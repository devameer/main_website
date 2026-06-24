<section class="space-y-8">
    <div>
        <h2 class="mb-4 font-bold text-slate-900">{{ __('contact.methods_title') }}</h2>
        <div class="space-y-3">
            <button onclick="copyEmail('hey@devameer.com')" class="group flex w-full items-center gap-3 rounded-xl border border-slate-200 bg-white p-4 text-right transition-shadow hover:shadow-sm">
                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-brand-50 text-brand-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                </span>
                <div class="min-w-0">
                    <p class="text-xs text-slate-400">{{ __('contact.email_label') }}</p>
                    <p class="font-medium text-slate-800">hey@devameer.com</p>
                </div>
            </button>
            <span id="email-copied" class="block text-xs text-brand-500 opacity-0 transition-opacity text-center">{{ __('contact.email_copied') }}</span>
        </div>
    </div>

    <div>
        <h2 class="mb-4 font-bold text-slate-900">{{ __('contact.faqs_title') }}</h2>
        <div class="space-y-4">
            @foreach (__('contact.faqs') as $faq)
                <div class="rounded-xl border border-slate-200 bg-white p-4">
                    <p class="font-semibold text-slate-800">{{ $faq['q'] }}</p>
                    <p class="mt-1 text-sm text-slate-500">{{ $faq['a'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>
