@php $isEdit = isset($article) && $article?->exists; @endphp

<form wire:submit="save('draft')" x-data="{ tab: @entangle('tab'), showImport: false }">
    {{-- Header --}}
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.articles.index') }}" class="btn btn-secondary btn-icon">
                <x-ui.icon name="arrow-left" size="18" />
            </a>
            <div>
                <h2 class="text-xl font-bold tracking-tight text-slate-900 dark:text-white">
                    {{ $isEdit ? 'Edit Article' : 'New Article' }}
                </h2>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                    {{ $isEdit ? 'Update the content and settings below.' : 'Fill in the details to create a new article.' }}
                </p>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <x-ui.button variant="secondary" icon="file-text" type="button" @click="showImport = !showImport">Import Markdown</x-ui.button>
            <x-ui.button variant="ghost" icon="eye" type="button" wire:click="preview">Preview</x-ui.button>
            <x-ui.button variant="secondary" icon="save" type="submit">Save draft</x-ui.button>
        </div>
    </div>

    {{-- Import from Markdown panel --}}
    <div
        x-show="showImport"
        x-cloak
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0"
        class="card mb-6"
    >
        <div class="flex items-center justify-between gap-3 border-b border-slate-200 px-5 py-4 dark:border-slate-800">
            <div>
                <h3 class="card-title">Import from Markdown</h3>
                <p class="mt-0.5 text-xs text-slate-400">Fills the <span x-text="tab === 'ar' ? 'Arabic' : 'English'"></span> title &amp; body, plus slug and SEO fields. The active tab decides the language.</p>
            </div>
            <button type="button" @click="showImport = false" class="btn btn-ghost btn-icon text-slate-400"><x-ui.icon name="x" size="18" /></button>
        </div>

        <div class="grid grid-cols-1 gap-5 p-5 md:grid-cols-2">
            {{-- Upload --}}
            <div>
                <span class="label">Upload a .md file</span>
                <label class="flex cursor-pointer flex-col items-center justify-center gap-2 rounded-[8px] border border-dashed border-slate-300 px-4 py-6 text-center transition-colors hover:border-primary-400 hover:bg-primary-50/40 dark:border-slate-700 dark:hover:bg-primary-500/5">
                    <x-ui.icon name="upload" size="22" class="text-slate-400" />
                    <span class="text-sm font-medium text-slate-600 dark:text-slate-300">Click to choose a .md file</span>
                    <span class="text-xs text-slate-400">Parses fields &amp; saves a copy</span>
                    <input type="file" wire:model="markdownFile" accept=".md,.txt,text/markdown" class="hidden">
                </label>
                <div wire:loading wire:target="markdownFile" class="mt-2 flex items-center gap-2 text-sm text-primary-600">
                    <x-ui.icon name="loader" size="15" class="animate-spin" /> Reading file…
                </div>
                @error('markdownFile')<p class="field-hint text-danger-600 mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Stored markdown files --}}
            <div>
                <span class="label">Your stored markdown <span class="font-normal text-slate-400">({{ count($this->storedMarkdown) }})</span></span>
                @if (empty($this->storedMarkdown))
                    <p class="text-xs text-slate-400">Uploaded files are saved here automatically — you can re-import or download them anytime.</p>
                @else
                    <div class="max-h-56 space-y-1.5 overflow-y-auto pr-1">
                        @foreach ($this->storedMarkdown as $file)
                            <div class="flex items-center gap-2 rounded-[8px] border border-slate-200 px-3 py-2 dark:border-slate-700">
                                <x-ui.icon name="file-text" size="15" class="shrink-0 text-slate-400" />
                                <div class="min-w-0 flex-1">
                                    <p class="truncate text-sm font-medium text-slate-700 dark:text-slate-200">{{ $file['name'] }}</p>
                                    <p class="text-[11px] text-slate-400">{{ round($file['size'] / 1024, 1) }} KB · {{ \Carbon\Carbon::createFromTimestamp($file['modified'])->diffForHumans() }}</p>
                                </div>
                                <x-ui.tooltip text="Re-import">
                                    <button type="button" wire:click="loadStoredMarkdown('{{ $file['name'] }}')" class="btn btn-ghost btn-icon text-slate-500 hover:text-primary-600">
                                        <x-ui.icon name="refresh-cw" size="15" />
                                    </button>
                                </x-ui.tooltip>
                                <x-ui.tooltip text="Download">
                                    <a href="{{ route('admin.markdown.download', $file['name']) }}" class="btn btn-ghost btn-icon text-slate-500 hover:text-info-600">
                                        <x-ui.icon name="download" size="15" />
                                    </a>
                                </x-ui.tooltip>
                                <x-ui.tooltip text="Delete">
                                    <button type="button" wire:click="deleteStoredMarkdown('{{ $file['name'] }}')" wire:confirm="Delete this stored markdown file?" class="btn btn-ghost btn-icon text-slate-500 hover:text-danger-600">
                                        <x-ui.icon name="trash-2" size="15" />
                                    </button>
                                </x-ui.tooltip>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Grid: main + sidebar --}}
    <div class="grid grid-cols-1 gap-4 lg:grid-cols-3">
        {{-- MAIN --}}
        <div class="space-y-4 lg:col-span-2">
            <x-ui.card bodyClass="p-0">
                {{-- Language tabs --}}
                <div class="flex items-center gap-1 border-b border-slate-200 px-4 dark:border-slate-800">
                    <button type="button" @click="tab = 'en'" class="tab" :class="tab === 'en' ? 'tab-active' : 'tab-idle'">
                        <span class="inline-flex items-center gap-1.5">
                            <span class="text-base">🇬🇧</span> English
                        </span>
                    </button>
                    <button type="button" @click="tab = 'ar'" class="tab" :class="tab === 'ar' ? 'tab-active' : 'tab-idle'">
                        <span class="inline-flex items-center gap-1.5">
                            <span class="text-base">🇸🇦</span> Arabic
                        </span>
                    </button>
                </div>

                {{-- English fields --}}
                <div class="space-y-4 p-5" x-show="tab === 'en'" x-cloak x-transition.opacity.duration.150ms>
                    <div>
                        <label class="label">Title (English) <span class="text-danger-500">*</span></label>
                        <input type="text" wire:model="title_en" placeholder="Write a compelling title…" class="field">
                        @error('title_en')<p class="field-hint text-danger-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="label">Excerpt</label>
                        <input type="text" wire:model="excerpt" placeholder="Short summary shown in cards…" class="field">
                    </div>
                    <div>
                        <label class="label">Body (English) <span class="text-danger-500">*</span></label>
                        <x-ui.markdown-editor model="body_en" placeholder="Write your article in English…" :height="560" />
                        @error('body_en')<p class="field-hint text-danger-600">{{ $message }}</p>@enderror
                    </div>
                </div>

                {{-- Arabic fields --}}
                <div class="space-y-4 p-5" x-show="tab === 'ar'" x-cloak x-transition.opacity.duration.150ms dir="rtl">
                    <div>
                        <label class="label">العنوان (عربي) <span class="font-normal text-slate-400">اختياري</span></label>
                        <input type="text" wire:model="title" placeholder="اكتب عنوانًا جذابًا…" class="field text-right">
                        @error('title')<p class="field-hint text-danger-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="label">المحتوى (عربي) <span class="font-normal text-slate-400">اختياري</span></label>
                        <x-ui.markdown-editor model="body" placeholder="اكتب مقالك بالعربية…" :height="560" :rtl="true" />
                        @error('body')<p class="field-hint text-danger-600">{{ $message }}</p>@enderror
                    </div>
                </div>
            </x-ui.card>

            {{-- SEO card --}}
            <x-ui.card title="SEO Studio" subtitle="Optimize content for search engines" bodyClass="p-0">
                <div x-data="seoStudio()" class="divide-y divide-slate-100 dark:divide-slate-800">

                    {{-- Score + Google preview --}}
                    <div class="p-5">
                        <div class="flex items-center gap-4">
                            <div class="relative h-16 w-16 shrink-0">
                                <svg class="h-16 w-16 -rotate-90" viewBox="0 0 36 36">
                                    <circle cx="18" cy="18" r="15.9" fill="none" stroke-width="3" class="text-slate-200 dark:text-slate-700" stroke="currentColor" />
                                    <circle cx="18" cy="18" r="15.9" fill="none" stroke-width="3" stroke-linecap="round" :stroke="scoreStroke" :stroke-dasharray="score + ' 100'" />
                                </svg>
                                <span class="absolute inset-0 flex items-center justify-center text-sm font-bold" :class="scoreColor" x-text="score + '%'"></span>
                            </div>
                            <div class="min-w-0">
                                <p class="text-sm font-semibold text-slate-800 dark:text-slate-100">SEO Score</p>
                                <p class="text-xs" :class="scoreColor" x-text="scoreLabel"></p>
                            </div>
                        </div>

                        {{-- Live Google snippet preview --}}
                        <div class="mt-4 rounded-[8px] border border-slate-200 p-3 dark:border-slate-800">
                            <p class="text-[11px] text-slate-400">Google preview</p>
                            <p class="mt-1 truncate text-[15px] leading-tight text-[#1a0dab] dark:text-[#8ab4f8]" x-text="(titleVal || 'Your title appears here')"></p>
                            <p class="truncate text-xs text-[#006621] dark:text-[#9aa0a6]">example.com › articles › <span x-text="slugVal || 'your-slug'"></span></p>
                            <p class="mt-0.5 line-clamp-2 text-xs text-slate-600 dark:text-slate-400" x-text="metaVal || 'Your meta description appears here.'"></p>
                        </div>
                    </div>

                    {{-- Keyword + SEO fields --}}
                    <div class="space-y-4 p-5">
                        <div>
                            <label class="label">Primary keyword</label>
                            <input type="text" wire:model.live.debounce.400ms="primary_keyword" placeholder="e.g. react default props" class="field">
                            <p class="field-hint">The main keyword this article targets.</p>
                        </div>

                        <div>
                            <label class="label">Secondary keywords</label>
                            <input type="text" wire:model="secondary_keywords" placeholder="comma, separated, keywords" class="field">
                            <div x-show="keywordTags.length" class="mt-2 flex flex-wrap gap-1.5">
                                <template x-for="tag in keywordTags" :key="tag">
                                    <span class="badge badge-primary">#<span x-text="tag"></span></span>
                                </template>
                            </div>
                        </div>

                        <div>
                            <label class="label">Search intent</label>
                            <textarea wire:model="search_intent" rows="2" placeholder="What the reader is trying to achieve…" class="field resize-y"></textarea>
                        </div>

                        <div>
                            <label class="label">Target audience</label>
                            <textarea wire:model="target_audience" rows="2" placeholder="Who this article is for…" class="field resize-y"></textarea>
                        </div>

                        <div>
                            <label class="label">Reading time</label>
                            <input type="text" wire:model="reading_time" placeholder="e.g. 14–17 minutes" class="field">
                        </div>

                        <div class="border-t border-slate-100 pt-4 dark:border-slate-800">
                            <label class="label">URL slug</label>
                            <div class="flex items-center gap-2">
                                <span class="rounded-[8px] border border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-400 dark:border-slate-700 dark:bg-slate-800">/articles/</span>
                                <input type="text" wire:model.live.debounce.400ms="slug" placeholder="auto-generated-if-empty" class="field">
                            </div>
                        </div>

                        <div>
                            <label class="label">Meta title <span class="font-normal text-slate-400" x-text="'(' + titleVal.length + '/60)'"></span></label>
                            <input type="text" wire:model.live.debounce.400ms="meta_title" placeholder="Defaults to article title" class="field" :class="titleVal.length > 60 ? 'field-error' : ''">
                        </div>

                        <div>
                            <label class="label">Meta description <span class="font-normal text-slate-400" x-text="'(' + metaVal.length + '/160)'"></span></label>
                            <textarea wire:model.live.debounce.400ms="meta_description" rows="3" placeholder="Brief description for search engines…" class="field resize-y" :class="metaVal.length > 160 ? 'field-error' : ''"></textarea>
                        </div>
                    </div>

                    {{-- Live SEO analysis --}}
                    <div class="p-5">
                        <p class="label">Live analysis</p>
                        <ul class="space-y-1.5">
                            <template x-for="check in checks" :key="check.label">
                                <li class="flex items-start gap-2 text-sm" :class="check.ok ? 'text-slate-700 dark:text-slate-300' : 'text-slate-400'">
                                    <span x-show="check.ok" class="mt-0.5 text-success-600 dark:text-success-400">
                                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
                                    </span>
                                    <span x-show="!check.ok" class="mt-0.5 text-slate-300 dark:text-slate-600">
                                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/></svg>
                                    </span>
                                    <span x-text="check.label"></span>
                                </li>
                            </template>
                        </ul>
                    </div>
                </div>
            </x-ui.card>

            <script>
                function seoStudio() {
                    return {
                        get kw() { return (this.$wire.primary_keyword || '').toLowerCase().trim(); },
                        get titleVal() { return this.$wire.meta_title || this.$wire.title_en || this.$wire.title || ''; },
                        get metaVal() { return this.$wire.meta_description || this.$wire.excerpt || ''; },
                        get slugVal() { return this.$wire.slug || ''; },
                        get bodyVal() { return this.$wire.body_en || this.$wire.body || ''; },
                        get keywordTags() {
                            return (this.$wire.secondary_keywords || '')
                                .split(',').map(k => k.trim()).filter(k => k !== '');
                        },
                        get checks() {
                            const kw = this.kw;
                            const title = this.titleVal, meta = this.metaVal, slug = this.slugVal, body = this.bodyVal;
                            const list = [];
                            list.push({ ok: title.length >= 30 && title.length <= 60, label: 'Title length ' + title.length + ' (ideal 30–60)' });
                            list.push({ ok: meta.length >= 70 && meta.length <= 160, label: 'Meta length ' + meta.length + ' (ideal 70–160)' });
                            list.push({ ok: slug.length > 0, label: 'URL slug is set' });
                            if (kw) {
                                const safeKw = kw.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
                                list.push({ ok: title.toLowerCase().includes(kw), label: 'Primary keyword in title' });
                                list.push({ ok: meta.toLowerCase().includes(kw), label: 'Primary keyword in meta description' });
                                list.push({ ok: slug.toLowerCase().replace(/-/g,' ').includes(kw), label: 'Primary keyword in URL' });
                                const occ = (body.toLowerCase().match(new RegExp(safeKw, 'g')) || []).length;
                                list.push({ ok: occ >= 2 && occ <= 10, label: 'Keyword density ' + occ + '× (2–10 ideal)' });
                                const intro = body.toLowerCase().split(/\s+/).slice(0, 100).join(' ');
                                list.push({ ok: intro.includes(kw), label: 'Keyword in introduction' });
                            } else {
                                list.push({ ok: false, label: 'Set a primary keyword for deeper analysis' });
                            }
                            return list;
                        },
                        get score() {
                            if (!this.checks.length) return 0;
                            return Math.round(this.checks.filter(c => c.ok).length / this.checks.length * 100);
                        },
                        get scoreStroke() {
                            const s = this.score;
                            return s >= 80 ? '#10b981' : s >= 50 ? '#f59e0b' : '#ef4444';
                        },
                        get scoreColor() {
                            const s = this.score;
                            return s >= 80 ? 'text-success-600 dark:text-success-400' : s >= 50 ? 'text-warning-600 dark:text-warning-400' : 'text-danger-600 dark:text-danger-400';
                        },
                        get scoreLabel() {
                            const s = this.score;
                            return s >= 80 ? 'Excellent — well optimized' : s >= 50 ? 'Good — room to improve' : 'Needs work';
                        },
                    };
                }
            </script>
        </div>

        {{-- SIDEBAR --}}
        <div class="space-y-4">
            {{-- Publish box --}}
            <x-ui.card title="Publish">
                <div class="space-y-4">
                    @php
                        $statusIconTone = [
                            'draft' => 'text-warning-500',
                            'published' => 'text-success-500',
                            'scheduled' => 'text-info-500',
                            'archived' => 'text-slate-400',
                        ][$status] ?? 'text-slate-400';
                    @endphp
                    <div class="flex items-center justify-between rounded-[8px] bg-slate-50 px-3 py-2.5 dark:bg-slate-800/60">
                        <span class="flex items-center gap-2 text-sm">
                            <x-ui.icon name="circle-dot" size="16" class="{{ $statusIconTone }}" />
                            <span class="font-medium capitalize">{{ $status }}</span>
                        </span>
                        <span class="badge badge-gray">{{ $isEdit ? 'Modified' : 'New' }}</span>
                    </div>

                    <div>
                        <label class="label">Status</label>
                        <select wire:model.live="status" class="select">
                            @foreach ($this->statuses as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    @if ($status === 'scheduled')
                        <div>
                            <label class="label">Schedule for</label>
                            <input type="datetime-local" wire:model="published_at" class="field">
                        </div>
                    @endif

                    <div>
                        <label class="label">Published date</label>
                        <input type="datetime-local" wire:model="published_at" class="field">
                    </div>
                </div>
            </x-ui.card>

            {{-- Featured image --}}
            <x-ui.card title="Featured Image">
                <div class="space-y-3">
                    @if ($cover_image)
                        <div class="relative overflow-hidden rounded-[8px] ring-1 ring-slate-200 dark:ring-slate-700">
                            <img src="{{ $cover_image }}" alt="cover preview" class="h-40 w-full object-cover">
                            <button type="button" wire:click="$set('cover_image','')" class="absolute right-2 top-2 rounded-full bg-slate-900/70 p-1.5 text-white hover:bg-slate-900">
                                <x-ui.icon name="x" size="14" />
                            </button>
                        </div>
                    @endif

                    <div wire:loading wire:target="coverUpload" class="flex items-center gap-2 text-sm text-primary-600">
                        <x-ui.icon name="loader" size="16" class="animate-spin" /> Uploading…
                    </div>

                    <label class="flex cursor-pointer flex-col items-center justify-center gap-2 rounded-[8px] border border-dashed border-slate-300 px-4 py-6 text-center transition-colors hover:border-primary-400 hover:bg-primary-50/40 dark:border-slate-700 dark:hover:bg-primary-500/5">
                        <x-ui.icon name="upload" size="22" class="text-slate-400" />
                        <span class="text-sm font-medium text-slate-600 dark:text-slate-300">Click to upload</span>
                        <span class="text-xs text-slate-400">PNG, JPG up to 2MB</span>
                        <input type="file" wire:model="coverUpload" accept="image/*" class="hidden">
                    </label>
                    @error('coverUpload')<p class="field-hint text-danger-600">{{ $message }}</p>@enderror
                </div>
            </x-ui.card>

            {{-- Organization --}}
            <x-ui.card title="Organization">
                <div class="space-y-4">
                    <div>
                        <label class="label">Category</label>
                        <select wire:model="category" class="select">
                            @foreach ($this->categories as $cat)
                                <option value="{{ $cat }}">{{ $cat }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="label">Primary language</label>
                        <select wire:model="language" class="select">
                            <option value="en">English</option>
                            <option value="ar">Arabic</option>
                        </select>
                    </div>
                </div>
            </x-ui.card>
        </div>
    </div>

    {{-- Sticky action bar --}}
    <div class="sticky bottom-0 z-20 mt-4 -mx-4 border-t border-slate-200 bg-white/90 px-4 py-3 backdrop-blur-md sm:mx-0 sm:rounded-t-[8px] dark:border-slate-800 dark:bg-slate-900/90 sm:px-0">
        <div class="flex flex-col items-center justify-between gap-3 sm:flex-row">
            <a href="{{ route('admin.articles.index') }}" class="link-muted text-sm">← Back to articles</a>
            <div class="flex w-full items-center gap-2 sm:w-auto">
                <x-ui.button variant="ghost" class="flex-1 sm:flex-none" icon="eye" type="button" wire:click="preview">Preview</x-ui.button>
                <x-ui.button variant="secondary" class="flex-1 sm:flex-none" icon="save" type="submit">Save draft</x-ui.button>
                @if ($status === 'scheduled')
                    <x-ui.button variant="warning" class="flex-1 sm:flex-none" icon="calendar-clock" type="button" wire:click="save('schedule')" wire:target="save" wire:loading.attr="disabled">Schedule</x-ui.button>
                @else
                    <x-ui.button variant="primary" class="flex-1 sm:flex-none" icon="check" type="button" wire:click="save('publish')" wire:target="save" wire:loading.attr="disabled">Publish</x-ui.button>
                @endif
            </div>
        </div>
    </div>
</form>
