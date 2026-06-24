<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * The root URL redirects to the default locale.
     */
    public function test_root_redirects_to_default_locale(): void
    {
        $this->get('/')->assertRedirect('/en');
    }

    /**
     * Each locale prefix returns a successful response.
     */
    public function test_locale_pages_return_200(): void
    {
        foreach (['en', 'ar'] as $locale) {
            $this->withSession(['locale' => $locale])
                ->get("/{$locale}")
                ->assertStatus(200);
        }
    }

    /**
     * The language switch attribute follows the locale.
     */
    public function test_locale_sets_html_dir_and_lang(): void
    {
        $en = $this->get('/en')->content();
        $this->assertStringContainsString('<html dir="ltr" lang="en"', $en);

        $ar = $this->get('/ar')->content();
        $this->assertStringContainsString('<html dir="rtl" lang="ar"', $ar);
    }
}
