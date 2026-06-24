<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        if (Service::exists()) {
            return;
        }

        $en = json_decode(file_get_contents(base_path('lang/en.json')), true)['services.items'] ?? [];
        $ar = json_decode(file_get_contents(base_path('lang/ar.json')), true)['services.items'] ?? [];

        foreach ($en as $i => $s) {
            $a = $ar[$i] ?? $s;

            Service::create([
                'slug'       => Str::slug($s['title']),
                'sort_order' => $i + 1,
                'icon'       => $s['icon'] ?? null,
                'title_en'   => $s['title'],
                'title_ar'   => $a['title'] ?? $s['title'],
                'desc_en'    => $s['desc'] ?? null,
                'desc_ar'    => $a['desc'] ?? null,
                'items_en'   => $s['items'] ?? [],
                'items_ar'   => $a['items'] ?? [],
                'is_published' => true,
            ]);
        }
    }
}
