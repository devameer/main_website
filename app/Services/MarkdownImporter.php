<?php

namespace App\Services;

/**
 * Parses a markdown article (with optional SEO sections A-G) into article fields.
 *
 * Recognized structured format (sections used):
 *   ## B. Final Recommended Title   -> title
 *   ## C. SEO Plan                   -> slug, meta_title, meta_description
 *   ## D. Full SEO Article           -> body (everything until section E)
 *
 * Sections A, E, F, G are intentionally dropped.
 *
 * Falls back gracefully for plain markdown: first "# heading" = title, rest = body.
 */
class MarkdownImporter
{
    /** @return array{title:string,slug:string,meta_title:string,meta_description:string,excerpt:string,body:string,primary_keyword:string,secondary_keywords:array<int,string>,search_intent:string,target_audience:string,reading_time:string} */
    public function parse(string $content): array
    {
        $content = trim($content);

        $title = '';
        $slug = '';
        $metaTitle = '';
        $metaDescription = '';
        $body = '';
        $primaryKeyword = '';
        $secondaryKeywords = [];
        $searchIntent = '';
        $targetAudience = '';
        $readingTime = '';

        // --- Title: section B ---
        if (preg_match('/^##\s*B\.[^\n]*\n+(?:-+\n+)?\*\*(.+?)\*\*/m', $content, $m)) {
            $title = trim($m[1]);
        }

        // --- SEO Plan: section C, until section D ---
        if (preg_match('/^##\s*C\.[^\n]*\n(.*?)(?=^##\s*D\.|\z)/sm', $content, $m)) {
            $plan = $m[1];
            $slug = $this->lineAfter($plan, 'Suggested URL Slug');
            $metaTitle = $this->labelValue($plan, 'Meta Title');
            $metaDescription = $this->labelValue($plan, 'Meta Description');
            $primaryKeyword = $this->labelValue($plan, 'Primary Keyword');
            $readingTime = $this->labelValue($plan, 'Suggested Reading Time');
            if ($readingTime === '') {
                $readingTime = $this->labelValue($plan, 'Reading Time');
            }
            $searchIntent = $this->multilineValue($plan, 'Search Intent');
            $targetAudience = $this->multilineValue($plan, 'Target Audience');

            $secondaryRaw = $this->multilineValue($plan, 'Secondary Keywords');
            if ($secondaryRaw !== '') {
                $secondaryKeywords = array_values(array_filter(
                    array_map('trim', preg_split('/[,\x{060C}\n]/u', $secondaryRaw)),
                    fn ($v) => $v !== '',
                ));
            }
        }

        // --- Body: section D, until section E (or end) ---
        if (preg_match('/^##\s*D\.[^\n]*\n(.*?)(?=^##\s*[E-G]\.|\z)/sm', $content, $m)) {
            $body = trim($m[1]);
        }

        // --- Fallbacks for plain markdown (no structured sections) ---
        if ($title === '' && preg_match('/^#\s+(.+)$/m', $content, $m)) {
            $title = trim($m[1]);
        }
        if ($body === '') {
            $body = trim(preg_replace('/^#\s+.+\n*/m', '', $content, 1));
        }

        $excerpt = $metaDescription !== '' ? $metaDescription : $this->firstParagraph($body);

        if ($slug === '' && $title !== '') {
            $slug = $this->slugify($title);
        }

        return [
            'title' => $title,
            'slug' => $slug,
            'meta_title' => $metaTitle !== '' ? $metaTitle : $title,
            'meta_description' => $metaDescription,
            'excerpt' => $excerpt,
            'body' => $body,
            'primary_keyword' => $primaryKeyword,
            'secondary_keywords' => $secondaryKeywords,
            'search_intent' => $searchIntent,
            'target_audience' => $targetAudience,
            'reading_time' => $readingTime,
        ];
    }

    /** List of sample files shipped in resources/markdown. */
    public function sampleFiles(): array
    {
        $dir = resource_path('markdown');
        $files = [];

        if (is_dir($dir)) {
            foreach (glob($dir . '/*.md') as $path) {
                $name = basename($path);
                $lang = str_ends_with($name, '-ar.md') ? 'ar' : (str_ends_with($name, '-en.md') ? 'en' : '');
                $files[] = [
                    'name' => $name,
                    'language' => $lang,
                    'label' => ucfirst(pathinfo($name, PATHINFO_FILENAME)),
                    'size' => filesize($path),
                ];
            }
        }

        return $files;
    }

    public function readSample(string $name): ?string
    {
        $path = resource_path('markdown/' . $name);
        $real = realpath($path);

        // Prevent path traversal outside the markdown directory.
        if (! $real || ! str_starts_with($real, realpath(resource_path('markdown')))) {
            return null;
        }
        if (! is_file($real) || ! str_ends_with($real, '.md')) {
            return null;
        }

        return file_get_contents($real);
    }

    private function labelValue(string $haystack, string $label): string
    {
        // Matches: **Label:** value  (value until newline or end)
        if (preg_match('/\*\*' . preg_quote($label, '/') . ':?\*\*\s*(.+)/', $haystack, $m)) {
            return trim($m[1]);
        }

        return '';
    }

    private function multilineValue(string $haystack, string $label): string
    {
        // Matches: **Label:** then everything (across lines) until the next line starting with ** (another bold label) or end.
        if (preg_match('/\*\*' . preg_quote($label, '/') . ':?\*\*\s*(.*?)(?=\n\s*\*\*|\Z)/s', $haystack, $m)) {
            return trim($m[1]);
        }

        return '';
    }

    private function lineAfter(string $haystack, string $label): string
    {
        // Matches: **Label:** `value`
        if (preg_match('/\*\*' . preg_quote($label, '/') . ':?\*\*\s*`([^`]+)`/', $haystack, $m)) {
            return trim($m[1]);
        }

        return '';
    }

    private function firstParagraph(string $body): string
    {
        foreach (preg_split('/\n{2,}/', $body) as $block) {
            $block = trim($block);
            if ($block === '' || str_starts_with($block, '#') || str_starts_with($block, '```') || str_starts_with($block, '{{IMAGE')) {
                continue;
            }

            return trim($block);
        }

        return '';
    }

    private function slugify(string $text): string
    {
        $text = trim($text);
        $text = preg_replace('/[^\p{L}\p{N}\s-]/u', '', $text);
        $text = preg_replace('/[\s_-]+/', '-', $text);
        $text = preg_replace('/-+/', '-', $text);

        return strtolower(trim($text, '-'));
    }
}
