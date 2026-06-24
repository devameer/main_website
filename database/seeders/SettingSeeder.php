<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $defaults = [
            'site_name_en' => 'Ameer Alafash',
            'site_name_ar' => 'عامر علافش',
            'site_role_en' => 'Front-end Developer & Web Designer',
            'site_role_ar' => 'مطوّر Front-end ومصمم ويب',
            'meta_description_en' => 'Front-end developer and web designer building fast, clear, accessible interfaces.',
            'meta_description_ar' => 'مطوّر ومصمم ويب يبني واجهات سريعة وواضحة ومتاحة.',
            'og_image' => '',

            'social_twitter' => 'https://twitter.com/ameer_alafash',
            'social_linkedin' => 'https://linkedin.com/in/ameer-alafash',
            'social_github' => 'https://github.com/ameer-alafash',
            'social_instagram' => 'https://instagram.com/ameer_alafash',
            'social_email' => 'hey@devameer.com',

            'promo_enabled' => '1',
            'promo_text_en' => 'Available for new projects',
            'promo_text_ar' => 'متاح لمشاريع جديدة',
            'promo_link' => '',
        ];

        foreach ($defaults as $key => $value) {
            Setting::firstOrCreate(['key' => $key], ['value' => $value]);
        }
    }
}
