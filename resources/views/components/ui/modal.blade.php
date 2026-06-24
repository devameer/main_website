@props([
    'maxWidth' => 'max-w-lg',
])

{{-- Render the modal shell; visibility is gated by the parent with @if.
    Closing delegates to the Livewire component via $wire. --}}
<div
    x-data
    @keydown.escape.window="$wire.set('showModal', false)"
    class="relative z-[70]"
>
    <div
        x-cloak
        x-show="true"
        x-transition:enter="transition ease-out duration-150"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        class="fixed inset-0 z-[70] bg-slate-900/50 backdrop-blur-[2px]"
        @click="$wire.set('showModal', false)"
    ></div>

    <div
        x-cloak
        x-show="true"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        class="fixed left-1/2 top-1/2 z-[71] w-full -translate-x-1/2 -translate-y-1/2 px-4"
    >
        <div class="card mx-auto {{ $maxWidth }} shadow-xl">
            @isset($header)
                <div class="flex items-center justify-between border-b border-slate-200 px-5 py-4 dark:border-slate-800">
                    {{ $header }}
                    <button type="button" @click="$wire.set('showModal', false)" class="btn btn-ghost btn-icon -mr-2 text-slate-400">
                        <x-ui.icon name="x" size="18" />
                    </button>
                </div>
            @endisset

            <div class="p-5">
                {{ $slot }}
            </div>

            @isset($footer)
                <div class="flex items-center justify-end gap-2 border-t border-slate-200 px-5 py-3.5 dark:border-slate-800">
                    {{ $footer }}
                </div>
            @endisset
        </div>
    </div>
</div>
