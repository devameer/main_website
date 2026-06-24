<div class="space-y-6">
    <div class="flex flex-wrap items-end justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold tracking-tight text-slate-900 dark:text-white">{{ ($testimonial && $testimonial->exists) ? 'Edit Testimonial' : 'New Testimonial' }}</h2>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">A short quote from a collaborator.</p>
        </div>
        <div class="flex items-center gap-2">
            <x-ui.button variant="secondary" icon="arrow-left" href="{{ route('admin.testimonials.index') }}">Back</x-ui.button>
            <x-ui.button variant="primary" icon="save" wire:click="save" wire:target="save">Save</x-ui.button>
        </div>
    </div>

    <form wire:submit="save" class="space-y-6">
        <div class="card">
            <div class="card-header"><h3 class="card-title">Details</h3></div>
            <div class="card-body grid gap-4 sm:grid-cols-3">
                <div>
                    <label class="label">Initials *</label>
                    <input type="text" wire:model="initials" placeholder="J.A." class="field" maxlength="6">
                    @error('initials') <p class="field-hint text-danger-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="label">Role (EN)</label>
                    <input type="text" wire:model="role_en" placeholder="Product collaborator" class="field">
                </div>
                <div>
                    <label class="label">Role (AR)</label>
                    <input type="text" wire:model="role_ar" placeholder="متعاون" class="field">
                </div>
                <div class="sm:col-span-3">
                    <label class="flex items-center gap-2.5 cursor-pointer">
                        <input type="checkbox" wire:model="is_published" class="h-4 w-4 rounded border-slate-300 text-primary-600 focus:ring-primary-500 dark:border-slate-600 dark:bg-slate-800">
                        <span class="text-sm font-medium text-slate-700 dark:text-slate-300">Published</span>
                    </label>
                </div>
            </div>
        </div>

        <div class="grid gap-6 lg:grid-cols-2">
            <div class="card">
                <div class="card-header"><h3 class="card-title flex items-center gap-2">English <span class="badge badge-gray uppercase">EN</span></h3></div>
                <div class="card-body space-y-4">
                    <div>
                        <label class="label">Quote *</label>
                        <textarea wire:model="body_en" rows="4" class="field"></textarea>
                        @error('body_en') <p class="field-hint text-danger-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="label">Author name</label>
                        <input type="text" wire:model="author_en" placeholder="Jane Adams" class="field">
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header"><h3 class="card-title flex items-center gap-2">Arabic <span class="badge badge-gray uppercase">AR</span></h3></div>
                <div class="card-body space-y-4" dir="rtl">
                    <div>
                        <label class="label">الاقتباس</label>
                        <textarea wire:model="body_ar" rows="4" class="field"></textarea>
                    </div>
                    <div>
                        <label class="label">اسم الكاتب</label>
                        <input type="text" wire:model="author_ar" class="field">
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-end gap-2">
            <x-ui.button variant="secondary" href="{{ route('admin.testimonials.index') }}">Cancel</x-ui.button>
            <x-ui.button variant="primary" icon="save" type="submit">Save</x-ui.button>
        </div>
    </form>
</div>
