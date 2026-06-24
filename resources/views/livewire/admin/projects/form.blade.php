<div class="space-y-6">
    {{-- Header --}}
    <div class="flex flex-wrap items-end justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold tracking-tight text-slate-900 dark:text-white">{{ ($project && $project->exists) ? 'Edit Project' : 'New Project' }}</h2>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Fill in both languages and the project details.</p>
        </div>
        <div class="flex items-center gap-2">
            <x-ui.button variant="secondary" icon="arrow-left" href="{{ route('admin.projects.index') }}">Back</x-ui.button>
            <x-ui.button variant="primary" icon="save" wire:click="save" wire:target="save">Save Project</x-ui.button>
        </div>
    </div>

    <form wire:submit="save" class="space-y-6">
        {{-- Shared details --}}
        <div class="card">
            <div class="card-header"><h3 class="card-title">Details</h3></div>
            <div class="card-body grid gap-4 sm:grid-cols-2">
                <div>
                    <label class="label">Icon (emoji)</label>
                    <input type="text" wire:model="icon" placeholder="✈️" class="field">
                    <p class="field-hint">An emoji that represents the project.</p>
                </div>
                <div>
                    <label class="label">Year</label>
                    <input type="text" wire:model="year" placeholder="2024" class="field">
                </div>
                <div>
                    <label class="label">Live URL</label>
                    <input type="url" wire:model="url" placeholder="https://…" class="field">
                    <p class="field-hint">Leave empty to hide the "Visit site" button.</p>
                </div>
                <div>
                    <label class="label">Slug</label>
                    <input type="text" wire:model="slug" placeholder="auto-generated from English name" class="field">
                </div>
                <div class="sm:col-span-2">
                    <label class="flex items-center gap-2.5 cursor-pointer">
                        <input type="checkbox" wire:model="is_published" class="h-4 w-4 rounded border-slate-300 text-primary-600 focus:ring-primary-500 dark:border-slate-600 dark:bg-slate-800">
                        <span class="text-sm font-medium text-slate-700 dark:text-slate-300">Published (visible on the public site)</span>
                    </label>
                </div>
            </div>
        </div>

        {{-- Bilingual content: two columns --}}
        <div class="grid gap-6 lg:grid-cols-2">
            {{-- English --}}
            <div class="card">
                <div class="card-header"><h3 class="card-title flex items-center gap-2">English <span class="badge badge-gray uppercase">EN</span></h3></div>
                <div class="card-body space-y-4">
                    <div>
                        <label class="label">Name *</label>
                        <input type="text" wire:model="name_en" class="field">
                        @error('name_en') <p class="field-hint text-danger-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="label">Role</label>
                        <input type="text" wire:model="role_en" placeholder="Design & Front-end Development" class="field">
                    </div>
                    <div>
                        <label class="label">Short description</label>
                        <input type="text" wire:model="desc_en" class="field">
                    </div>
                    <div>
                        <label class="label">Overview</label>
                        <textarea wire:model="overview_en" rows="4" class="field"></textarea>
                    </div>
                    <div>
                        <label class="label">Tags (comma separated)</label>
                        <input type="text" wire:model="tags_en" placeholder="Next.js, TypeScript, Tailwind" class="field">
                    </div>
                    <div>
                        <label class="label">Highlights (one per line)</label>
                        <textarea wire:model="highlights_en" rows="4" class="field" placeholder="Map-based discovery&#10;Fast search&#10;Mobile-first flow"></textarea>
                    </div>
                </div>
            </div>

            {{-- Arabic --}}
            <div class="card">
                <div class="card-header"><h3 class="card-title flex items-center gap-2">Arabic <span class="badge badge-gray uppercase">AR</span></h3></div>
                <div class="card-body space-y-4" dir="rtl">
                    <div>
                        <label class="label">الاسم *</label>
                        <input type="text" wire:model="name_ar" class="field">
                        @error('name_ar') <p class="field-hint text-danger-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="label">الدور</label>
                        <input type="text" wire:model="role_ar" class="field">
                    </div>
                    <div>
                        <label class="label">وصف مختصر</label>
                        <input type="text" wire:model="desc_ar" class="field">
                    </div>
                    <div>
                        <label class="label">نظرة عامة</label>
                        <textarea wire:model="overview_ar" rows="4" class="field"></textarea>
                    </div>
                    <div>
                        <label class="label">الوسوم (افصل بفاصلة)</label>
                        <input type="text" wire:model="tags_ar" class="field">
                    </div>
                    <div>
                        <label class="label">أبرز النقاط (سطر لكل نقطة)</label>
                        <textarea wire:model="highlights_ar" rows="4" class="field"></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-end gap-2">
            <x-ui.button variant="secondary" href="{{ route('admin.projects.index') }}">Cancel</x-ui.button>
            <x-ui.button variant="primary" icon="save" type="submit">Save Project</x-ui.button>
        </div>
    </form>
</div>
