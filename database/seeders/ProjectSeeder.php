<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        if (Project::exists()) {
            return;
        }

        $en = json_decode(file_get_contents(base_path('lang/en.json')), true)['projects'] ?? [];
        $ar = json_decode(file_get_contents(base_path('lang/ar.json')), true)['projects'] ?? [];

        foreach ($en as $i => $p) {
            $a = $ar[$i] ?? $p;

            Project::create([
                'slug'           => Str::slug($p['name']),
                'sort_order'     => $i + 1,
                'icon'           => $p['icon'] ?? null,
                'year'           => $p['year'] ?? null,
                'url'            => $p['url'] ?? null,
                'name_en'        => $p['name'],
                'name_ar'        => $a['name'] ?? $p['name'],
                'role_en'        => $p['role'] ?? null,
                'role_ar'        => $a['role'] ?? null,
                'desc_en'        => $p['desc'] ?? null,
                'desc_ar'        => $a['desc'] ?? null,
                'overview_en'    => $p['overview'] ?? null,
                'overview_ar'    => $a['overview'] ?? null,
                'tags_en'        => $p['tags'] ?? [],
                'tags_ar'        => $a['tags'] ?? [],
                'highlights_en'  => $p['highlights'] ?? [],
                'highlights_ar'  => $a['highlights'] ?? [],
                'is_published'   => true,
            ]);
        }
    }
}
