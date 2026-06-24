<?php

namespace App\Livewire\Admin;

use App\Livewire\Component;
use App\Models\Setting;

class Settings extends Component
{
    // General
    public string $site_name_en = '';
    public string $site_name_ar = '';
    public string $site_role_en = '';
    public string $site_role_ar = '';
    public string $meta_description_en = '';
    public string $meta_description_ar = '';
    public string $og_image = '';

    // Social
    public string $social_twitter = '';
    public string $social_linkedin = '';
    public string $social_github = '';
    public string $social_instagram = '';
    public string $social_email = '';

    // Promo
    public bool $promo_enabled = true;
    public string $promo_text_en = '';
    public string $promo_text_ar = '';
    public string $promo_link = '';

    public string $tab = 'general';

    public function mount(): void
    {
        $s = fn ($k, $d = '') => Setting::get($k, $d);

        $this->site_name_en = $s('site_name_en');
        $this->site_name_ar = $s('site_name_ar');
        $this->site_role_en = $s('site_role_en');
        $this->site_role_ar = $s('site_role_ar');
        $this->meta_description_en = $s('meta_description_en');
        $this->meta_description_ar = $s('meta_description_ar');
        $this->og_image = $s('og_image');

        $this->social_twitter = $s('social_twitter');
        $this->social_linkedin = $s('social_linkedin');
        $this->social_github = $s('social_github');
        $this->social_instagram = $s('social_instagram');
        $this->social_email = $s('social_email');

        $this->promo_enabled = $s('promo_enabled', '1') === '1';
        $this->promo_text_en = $s('promo_text_en');
        $this->promo_text_ar = $s('promo_text_ar');
        $this->promo_link = $s('promo_link');
    }

    public function save(): void
    {
        $data = [
            'site_name_en' => $this->site_name_en,
            'site_name_ar' => $this->site_name_ar,
            'site_role_en' => $this->site_role_en,
            'site_role_ar' => $this->site_role_ar,
            'meta_description_en' => $this->meta_description_en,
            'meta_description_ar' => $this->meta_description_ar,
            'og_image' => $this->og_image,
            'social_twitter' => $this->social_twitter,
            'social_linkedin' => $this->social_linkedin,
            'social_github' => $this->social_github,
            'social_instagram' => $this->social_instagram,
            'social_email' => $this->social_email,
            'promo_enabled' => $this->promo_enabled ? '1' : '0',
            'promo_text_en' => $this->promo_text_en,
            'promo_text_ar' => $this->promo_text_ar,
            'promo_link' => $this->promo_link,
        ];

        foreach ($data as $key => $value) {
            Setting::set($key, $value);
        }

        $this->toastSuccess('Settings saved.', 'Saved');
    }

    public function render(): mixed
    {
        return $this->page('livewire.admin.settings', 'Settings', [
            ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
            ['label' => 'Settings'],
        ]);
    }
}
