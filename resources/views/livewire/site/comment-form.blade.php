<div>
    @if($submitted)
        <div class="rounded-xl border border-brand-200 bg-brand-50 p-6 text-center">
            <div class="text-3xl mb-3">💬</div>
            <h3 class="font-bold text-brand-800 mb-1">{{ __('comment_form.success_title') }}</h3>
            <p class="text-sm text-brand-600">{{ __('comment_form.success_msg') }}</p>
        </div>
    @else
        <form wire:submit="submit" class="space-y-4">
            <div class="grid gap-4 sm:grid-cols-2">
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">{{ __('comment_form.name') }}</label>
                    <input wire:model="authorName" type="text" class="w-full rounded-lg border border-slate-200 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-800 placeholder:text-slate-400 transition-all focus:border-brand-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500/20" placeholder="{{ __('comment_form.name_ph') }}">
                    @error('authorName') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">{{ __('comment_form.email') }} <span class="text-slate-400">{{ __('comment_form.email_note') }}</span></label>
                    <input wire:model="authorEmail" type="email" class="w-full rounded-lg border border-slate-200 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-800 placeholder:text-slate-400 transition-all focus:border-brand-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500/20" placeholder="{{ __('comment_form.email_ph') }}" dir="ltr">
                    @error('authorEmail') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>
            </div>
            <div>
                <label class="mb-1.5 block text-sm font-medium text-slate-700">{{ __('comment_form.body') }}</label>
                <textarea wire:model="body" rows="4" class="w-full rounded-lg border border-slate-200 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-800 placeholder:text-slate-400 transition-all focus:border-brand-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500/20 resize-none" placeholder="{{ __('comment_form.body_ph') }}"></textarea>
                @error('body') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
            </div>
            <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-brand-700 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition-all duration-150 hover:bg-brand-800 disabled:opacity-50" wire:loading.attr="disabled">
                <span wire:loading.remove>{{ __('comment_form.submit') }}</span>
                <span wire:loading>{{ __('comment_form.sending') }}</span>
            </button>
        </form>
    @endif
</div>
