@php
    // Central navigation definition — single source of truth.
    $nav = [
        ['label' => 'Dashboard', 'route' => 'admin.dashboard', 'icon' => 'layout-dashboard'],
        ['section' => 'Content'],
        ['label' => 'Articles', 'route' => 'admin.articles.index', 'icon' => 'newspaper', 'badge' => (string) \App\Models\Article::count(), 'active' => ['admin.articles.*']],
        ['label' => 'Projects', 'route' => 'admin.projects.index', 'icon' => 'briefcase', 'active' => ['admin.projects.*']],
        ['label' => 'Services', 'route' => 'admin.services.index', 'icon' => 'sparkles', 'active' => ['admin.services.*']],
        ['label' => 'Categories', 'route' => 'admin.categories.index', 'icon' => 'folder'],
        ['label' => 'Testimonials', 'route' => 'admin.testimonials.index', 'icon' => 'quote', 'active' => ['admin.testimonials.*']],
        ['label' => 'Media', 'route' => 'admin.media.index', 'icon' => 'image'],
        ['section' => 'Communication'],
        ['label' => 'Messages', 'route' => 'admin.messages.index', 'icon' => 'mail', 'badge' => (string) \App\Models\Message::where('status','unread')->count(), 'badgeTone' => 'danger'],
        ['label' => 'Comments', 'route' => 'admin.comments.index', 'icon' => 'message-square', 'badge' => (string) \App\Models\Comment::where('status','pending')->count(), 'badgeTone' => 'warning'],
        ['section' => 'Account'],
        ['label' => 'Users', 'route' => 'admin.users.index', 'icon' => 'users'],
        ['label' => 'Settings', 'route' => 'admin.settings', 'icon' => 'settings'],
    ];
@endphp

{{-- Brand --}}
<div class="flex h-16 items-center gap-2.5 border-b border-slate-200 px-4 dark:border-slate-800">
    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-[8px] bg-primary-600 text-white shadow-sm">
        <x-ui.icon name="pen-tool" size="20" />
    </div>
    <div class="overflow-hidden whitespace-nowrap" :class="{ 'lg:opacity-0 lg:w-0': collapsed }">
        <p class="text-sm font-bold leading-tight text-slate-900 dark:text-white">Inker</p>
        <p class="text-[11px] leading-tight text-slate-400">Admin Panel</p>
    </div>
</div>

{{-- Nav list --}}
<nav class="flex-1 space-y-0.5 overflow-y-auto overflow-x-hidden px-3 py-4 scrollbar-none">
    @foreach ($nav as $item)
        @if (isset($item['section']))
            <p x-show="!collapsed" x-cloak class="px-3 pb-1.5 pt-4 text-[11px] font-semibold uppercase tracking-wider text-slate-400">
                {{ $item['section'] }}
            </p>
            <div x-show="collapsed" x-cloak class="my-3 border-t border-slate-200 dark:border-slate-800"></div>
            @continue
        @endif

        @php
            $patterns = $item['active'] ?? [$item['route']];
            $active = false;
            foreach ($patterns as $pattern) {
                if (request()->routeIs($pattern)) { $active = true; break; }
            }
            if (($item['route'] ?? '#') === '#') $active = false;
        @endphp

        <a
            href="{{ $item['route'] === '#' ? '#' : route($item['route']) }}"
            class="nav-link {{ $active ? 'nav-link-active' : '' }}"
            :title="collapsed ? '{{ $item['label'] }}' : null"
        >
            <x-ui.icon :name="$item['icon']" size="19" class="shrink-0" />
            <span class="flex-1 truncate" :class="{ 'lg:opacity-0 lg:w-0 lg:overflow-hidden': collapsed }">{{ $item['label'] }}</span>
            @isset($item['badge'])
                @php $tone = $item['badgeTone'] ?? 'gray'; @endphp
                <span x-show="!collapsed" class="ml-auto badge badge-{{ $tone }}">{{ $item['badge'] }}</span>
            @endisset
        </a>
    @endforeach
</nav>

{{-- Collapse toggle (desktop) --}}
<div class="border-t border-slate-200 p-3 dark:border-slate-800">
    <button type="button" @click="toggleCollapse()" class="nav-link hidden lg:flex">
        <x-ui.icon name="chevrons-left" size="19" class="shrink-0 transition-transform duration-300" x-bind:class="{ 'rotate-180': collapsed }" />
        <span :class="{ 'lg:opacity-0 lg:w-0 lg:overflow-hidden': collapsed }">Collapse</span>
    </button>
</div>
