<div>
    @if($sent)
        <div class="rounded-xl border border-emerald-200 bg-emerald-50 p-6 text-center">
            <div class="text-3xl mb-3">✅</div>
            <h3 class="font-bold text-emerald-800 mb-1">{{ __('contact_form.success_title') }}</h3>
            <p class="text-sm text-emerald-600">{{ __('contact_form.success_msg') }}</p>
            <button wire:click="$set('sent', false)" class="mt-4 text-sm font-medium text-emerald-700 underline">
                {{ __('contact_form.again') }}
            </button>
        </div>
    @else
        <form wire:submit="send" class="space-y-4">
            <div class="grid gap-4 sm:grid-cols-2">
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">{{ __('contact_form.name') }}</label>
                    <input wire:model="name" type="text" class="w-full rounded-lg border border-slate-200 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-800 placeholder:text-slate-400 transition-all focus:border-brand-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500/20" placeholder="{{ __('contact_form.name_ph') }}">
                    @error('name') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">{{ __('contact_form.email') }}</label>
                    <input wire:model="email" type="email" class="w-full rounded-lg border border-slate-200 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-800 placeholder:text-slate-400 transition-all focus:border-brand-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500/20" placeholder="{{ __('contact_form.email_ph') }}" dir="ltr">
                    @error('email') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>
            </div>
            <div>
                <label class="mb-1.5 block text-sm font-medium text-slate-700">{{ __('contact_form.subject') }}</label>
                <input wire:model="subject" type="text" class="w-full rounded-lg border border-slate-200 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-800 placeholder:text-slate-400 transition-all focus:border-brand-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500/20" placeholder="{{ __('contact_form.subject_ph') }}">
                @error('subject') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="mb-1.5 block text-sm font-medium text-slate-700">{{ __('contact_form.body') }}</label>
                <textarea wire:model="body" rows="5" class="w-full rounded-lg border border-slate-200 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-800 placeholder:text-slate-400 transition-all focus:border-brand-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500/20 resize-none" placeholder="{{ __('contact_form.body_ph') }}"></textarea>
                @error('body') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
            </div>
            <button type="submit" class="w-full justify-center inline-flex items-center gap-2 rounded-lg bg-brand-700 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition-all duration-150 hover:bg-brand-800 disabled:opacity-50" wire:loading.attr="disabled">
                <span wire:loading.remove>{{ __('contact_form.submit') }}</span>
                <span wire:loading>{{ __('contact_form.sending') }}</span>
            </button>
        </form>
    @endif
</div>
