<div>
    @if($subscribed)
        <div class="rounded-xl border border-emerald-200 bg-emerald-50 p-5 text-center">
            <p class="text-base font-medium text-emerald-700">{{ __('newsletter.success') }}</p>
        </div>
    @else
        <form wire:submit="subscribe" class="flex gap-3">
            <input
                wire:model="email"
                type="email"
                class="w-full rounded-lg border border-slate-200 bg-slate-50 px-4 py-3.5 text-base text-slate-800 placeholder:text-slate-400 transition-all focus:border-brand-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500/20 min-w-0 flex-1"
                placeholder="{{ __('newsletter.placeholder') }}"
                dir="ltr"
            >
            <button type="submit" class="shrink-0 inline-flex items-center gap-2 rounded-lg bg-brand-700 px-6 py-3.5 text-base font-semibold text-white shadow-sm transition-all duration-150 hover:bg-brand-800 disabled:opacity-50" wire:loading.attr="disabled">
                <span wire:loading.remove>{{ __('newsletter.btn') }}</span>
                <span wire:loading>{{ __('newsletter.sending') }}</span>
            </button>
        </form>
        @error('email') <p class="mt-2 text-sm text-red-500">{{ $message }}</p> @enderror
    @endif
</div>
