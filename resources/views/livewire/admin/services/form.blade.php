<div class="space-y-6">
    <div class="flex flex-wrap items-end justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold tracking-tight text-slate-900 dark:text-white">{{ ($service && $service->exists) ? 'Edit Service' : 'New Service' }}</h2>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Fill in both languages.</p>
        </div>
        <div class="flex items-center gap-2">
            <x-ui.button variant="secondary" icon="arrow-left" href="{{ route('admin.services.index') }}">Back</x-ui.button>
            <x-ui.button variant="primary" icon="save" wire:click="save" wire:target="save">Save Service</x-ui.button>
        </div>
    </div>

    <form wire:submit="save" class="space-y-6">
        <div class="card">
            <div class="card-header"><h3 class="card-title">Details</h3></div>
            <div class="card-body grid gap-4 sm:grid-cols-2">
                <div>
                    <label class="label">Icon (emoji)</label>
                    <input type="text" wire:model="icon" placeholder="🎨" class="field">
                </div>
                <div>
                    <label class="label">Slug</label>
                    <input type="text" wire:model="slug" placeholder="auto from English title" class="field">
                </div>
                <div class="sm:col-span-2">
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
                        <label class="label">Title *</label>
                        <input type="text" wire:model="title_en" class="field">
                        @error('title_en') <p class="field-hint text-danger-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="label">Short description</label>
                        <input type="text" wire:model="desc_en" class="field">
                    </div>
                    <div>
                        <label class="label">Items (comma separated)</label>
                        <input type="text" wire:model="items_en" placeholder="Figma Design, Wireframes, Prototype" class="field">
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header"><h3 class="card-title flex items-center gap-2">Arabic <span class="badge badge-gray uppercase">AR</span></h3></div>
                <div class="card-body space-y-4" dir="rtl">
                    <div>
                        <label class="label">العنوان *</label>
                        <input type="text" wire:model="title_ar" class="field">
                        @error('title_ar') <p class="field-hint text-danger-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="label">وصف مختصر</label>
                        <input type="text" wire:model="desc_ar" class="field">
                    </div>
                    <div>
                        <label class="label">العناصر (افصل بفاصلة)</label>
                        <input type="text" wire:model="items_ar" class="field">
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-end gap-2">
            <x-ui.button variant="secondary" href="{{ route('admin.services.index') }}">Cancel</x-ui.button>
            <x-ui.button variant="primary" icon="save" type="submit">Save Service</x-ui.button>
        </div>
    </form>
</div>
