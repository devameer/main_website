{{-- Toast container — driven by Alpine.store('toasts'). --}}
<div
    x-data
    x-cloak
    class="pointer-events-none fixed bottom-4 right-4 z-[90] flex w-full max-w-sm flex-col gap-2"
>
    <template x-for="t in $store.toasts.items" :key="t.id">
        <div
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 translate-x-4"
            x-transition:enter-end="opacity-100 translate-x-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0 translate-x-4"
            class="card pointer-events-auto flex items-start gap-3 p-3.5 shadow-lg"
        >
            <template x-if="t.type === 'success'"><span class="mt-0.5 text-success-600 dark:text-success-400"><x-ui.icon name="circle-check" size="18" /></span></template>
            <template x-if="t.type === 'error'"><span class="mt-0.5 text-danger-600 dark:text-danger-400"><x-ui.icon name="x-circle" size="18" /></span></template>
            <template x-if="t.type === 'warning'"><span class="mt-0.5 text-warning-500"><x-ui.icon name="alert-triangle" size="18" /></span></template>
            <template x-if="t.type === 'info'"><span class="mt-0.5 text-info-500"><x-ui.icon name="info" size="18" /></span></template>

            <div class="min-w-0 flex-1">
                <p x-show="t.title" x-text="t.title" class="text-sm font-semibold text-slate-800 dark:text-slate-100"></p>
                <p x-text="t.message" class="text-sm text-slate-600 dark:text-slate-300"></p>
            </div>

            <button type="button" @click="$store.toasts.dismiss(t.id)" class="text-slate-400 transition-colors hover:text-slate-600 dark:hover:text-slate-200">
                <x-ui.icon name="x" size="16" />
            </button>
        </div>
    </template>
</div>
