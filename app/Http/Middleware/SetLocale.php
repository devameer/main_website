<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    protected array $supported = ['en', 'ar'];

    public function handle(Request $request, Closure $next): Response
    {
        // Prefer the {locale} route segment, then the remembered session value.
        $locale = $request->route('locale') ?? $request->session()->get('locale') ?? config('app.fallback_locale', 'en');

        if (! in_array($locale, $this->supported, true)) {
            $locale = 'en';
        }

        app()->setLocale($locale);
        $request->session()->put('locale', $locale);

        // So every route() helper automatically includes the current locale.
        URL::defaults(['locale' => $locale]);

        return $next($request);
    }
}
