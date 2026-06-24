@props([
    'icon' => 'inbox',
    'title' => 'Nothing here yet',
    'description' => null,
])

<div class="flex flex-col items-center justify-center px-6 py-14 text-center">
    <div class="flex h-14 w-14 items-center justify-center rounded-full bg-slate-100 text-slate-400 dark:bg-slate-800 dark:text-slate-500">
        <x-ui.icon :name="$icon" size="26" />
    </div>
    <h4 class="mt-4 text-sm font-semibold text-slate-700 dark:text-slate-200">{{ $title }}</h4>
    @if ($description)
        <p class="mt-1 max-w-sm text-sm text-slate-500 dark:text-slate-400">{{ $description }}</p>
    @endif
    @isset($actions)
        <div class="mt-5 flex items-center gap-2">{{ $actions }}</div>
    @endisset
</div>
