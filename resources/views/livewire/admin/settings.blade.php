<div class="space-y-6" x-data="{ tab: @entangle('tab') }">
    <div class="flex flex-wrap items-end justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold tracking-tight text-slate-900 dark:text-white">Settings</h2>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Site identity, social links and the promo bar.</p>
        </div>
        <x-ui.button variant="primary" icon="save" wire:click="save" wire:target="save">Save changes</x-ui.button>
    </div>

    <form wire:submit="save" class="grid grid-cols-1 gap-4 lg:grid-cols-4">
        <nav class="flex gap-1 overflow-x-auto lg:col-span-1 lg:flex-col">
            <button type="button" @click="tab = 'general'" class="flex shrink-0 items-center gap-2.5 rounded-[8px] px-3 py-2.5 text-sm font-medium transition-colors"
                :class="tab === 'general' ? 'bg-primary-50 text-primary-700 dark:bg-primary-500/15 dark:text-primary-300' : 'text-slate-600 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-800'">
                <x-ui.icon name="globe" size="17" /> General
            </button>
            <button type="button" @click="tab = 'social'" class="flex shrink-0 items-center gap-2.5 rounded-[8px] px-3 py-2.5 text-sm font-medium transition-colors"
                :class="tab === 'social' ? 'bg-primary-50 text-primary-700 dark:bg-primary-500/15 dark:text-primary-300' : 'text-slate-600 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-800'">
                <x-ui.icon name="share-2" size="17" /> Social
            </button>
            <button type="button" @click="tab = 'promo'" class="flex shrink-0 items-center gap-2.5 rounded-[8px] px-3 py-2.5 text-sm font-medium transition-colors"
                :class="tab === 'promo' ? 'bg-primary-50 text-primary-700 dark:bg-primary-500/15 dark:text-primary-300' : 'text-slate-600 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-800'">
                <x-ui.icon name="megaphone" size="17" /> Promo bar
            </button>
            <button type="button" @click="tab = 'appearance'" class="flex shrink-0 items-center gap-2.5 rounded-[8px] px-3 py-2.5 text-sm font-medium transition-colors"
                :class="tab === 'appearance' ? 'bg-primary-50 text-primary-700 dark:bg-primary-500/15 dark:text-primary-300' : 'text-slate-600 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-800'">
                <x-ui.icon name="palette" size="17" /> Appearance
            </button>
        </nav>

        <div class="lg:col-span-3">
            {{-- General --}}
            <x-ui.card x-show="tab === 'general'" x-cloak title="Site identity" subtitle="Name, tagline and default meta used across the site">
                <div class="space-y-4">
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div><label class="label">Site name (EN)</label><input type="text" wire:model="site_name_en" class="field"></div>
                        <div><label class="label">Site name (AR)</label><input type="text" wire:model="site_name_ar" class="field" dir="rtl"></div>
                    </div>
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div><label class="label">Role / tagline (EN)</label><input type="text" wire:model="site_role_en" class="field"></div>
                        <div><label class="label">Role / tagline (AR)</label><input type="text" wire:model="site_role_ar" class="field" dir="rtl"></div>
                    </div>
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div><label class="label">Default meta description (EN)</label><textarea wire:model="meta_description_en" rows="3" class="field"></textarea></div>
                        <div><label class="label">Default meta description (AR)</label><textarea wire:model="meta_description_ar" rows="3" class="field" dir="rtl"></textarea></div>
                    </div>
                    <div><label class="label">Default OpenGraph image URL</label><input type="url" wire:model="og_image" placeholder="https://…" class="field"></div>
                </div>
            </x-ui.card>

            {{-- Social --}}
            <x-ui.card x-show="tab === 'social'" x-cloak title="Social links" subtitle="Used in the footer and the About page">
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div><label class="label">Twitter / X</label><input type="url" wire:model="social_twitter" class="field"></div>
                    <div><label class="label">LinkedIn</label><input type="url" wire:model="social_linkedin" class="field"></div>
                    <div><label class="label">GitHub</label><input type="url" wire:model="social_github" class="field"></div>
                    <div><label class="label">Instagram</label><input type="url" wire:model="social_instagram" class="field"></div>
                    <div class="sm:col-span-2"><label class="label">Email</label><input type="email" wire:model="social_email" class="field"></div>
                </div>
            </x-ui.card>

            {{-- Promo --}}
            <x-ui.card x-show="tab === 'promo'" x-cloak title="Promo bar" subtitle="The announcement strip at the top of the site">
                <div class="space-y-4">
                    <label class="flex items-center gap-2.5 cursor-pointer">
                        <input type="checkbox" wire:model="promo_enabled" class="h-4 w-4 rounded border-slate-300 text-primary-600 focus:ring-primary-500 dark:border-slate-600 dark:bg-slate-800">
                        <span class="text-sm font-medium text-slate-700 dark:text-slate-300">Show promo bar</span>
                    </label>
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div><label class="label">Text (EN)</label><input type="text" wire:model="promo_text_en" class="field"></div>
                        <div><label class="label">Text (AR)</label><input type="text" wire:model="promo_text_ar" class="field" dir="rtl"></div>
                    </div>
                    <div><label class="label">Link URL (leave empty for none)</label><input type="text" wire:model="promo_link" placeholder="/en/contact" class="field"></div>
                </div>
            </x-ui.card>

            {{-- Appearance --}}
            <x-ui.card x-show="tab === 'appearance'" x-cloak title="Appearance" subtitle="Dashboard theme (saved on this device)">
                <div>
                    <span class="label">Theme</span>
                    <div class="grid grid-cols-3 gap-3">
                        @foreach ([['light','sun','Light'],['dark','moon','Dark'],['system','monitor','System']] as [$t,$icon,$label])
                            <button type="button" onclick="localStorage.setItem('theme','{{ $t }}'); window.applyTheme('{{ $t }}')"
                                class="flex flex-col items-center gap-2 rounded-[8px] border border-slate-200 p-4 text-sm font-medium transition-colors hover:border-primary-400 hover:bg-primary-50/40 dark:border-slate-700 dark:hover:bg-primary-500/5">
                                <x-ui.icon :name="$icon" size="22" class="text-slate-500" /> {{ $label }}
                            </button>
                        @endforeach
                    </div>
                </div>
            </x-ui.card>

            <div class="flex justify-end border-t border-slate-200 pt-4 dark:border-slate-800">
                <x-ui.button variant="primary" icon="save" type="submit" wire:loading.attr="disabled">Save changes</x-ui.button>
            </div>
        </div>
    </form>
</div>
