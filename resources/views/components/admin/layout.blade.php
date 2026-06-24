@props([
    'title' => 'Dashboard',
    'breadcrumbs' => [],
])

<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} — Inker Admin</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Anti-FOUC theme: apply before paint --}}
    <script>
        (function () {
            try {
                var t = localStorage.getItem('theme') || 'system';
                var dark = t === 'dark' || (t === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches);
                if (dark) document.documentElement.classList.add('dark');
                document.documentElement.style.colorScheme = dark ? 'dark' : 'light';
            } catch (e) {}
        })();
    </script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@400;500;600;700;800&family=IBM+Plex+Sans+Arabic:wght@400;500;600;700&display=swap" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@400;500;600;700;800&family=IBM+Plex+Sans+Arabic:wght@400;500;600;700&display=swap"></noscript>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireScriptConfig
</head>
<body class="min-h-full">
    <div
        x-data="adminShell()"
        class="min-h-screen transition-[padding] duration-300 ease-in-out"
        :class="collapsed ? 'lg:pl-[76px]' : 'lg:pl-[260px]'"
    >
        {{-- Mobile backdrop --}}
        <div
            x-show="mobileOpen"
            x-cloak
            x-transition.opacity.duration.200ms
            @click="mobileOpen = false"
            class="fixed inset-0 z-30 bg-slate-900/50 backdrop-blur-[2px] lg:hidden"
        ></div>

        {{-- Sidebar --}}
        <aside
            class="fixed inset-y-0 left-0 z-40 flex w-[260px] flex-col border-r border-slate-200 bg-white transition-all duration-300 ease-in-out dark:border-slate-800 dark:bg-slate-900 lg:translate-x-0"
            :class="{
                'translate-x-0': mobileOpen,
                '-translate-x-full': !mobileOpen,
                'lg:w-[260px]': !collapsed,
                'lg:w-[76px]': collapsed,
            }"
        >
            <x-admin.sidebar />
        </aside>

        {{-- Main column --}}
        <div class="flex min-h-screen flex-col transition-[padding] duration-300 ease-in-out">
            <x-admin.topbar :title="$title" :breadcrumbs="$breadcrumbs" />

            <main class="flex-1 px-4 py-6 sm:px-6 lg:px-8">
                <div class="mx-auto w-full max-w-[1400px]">
                    {{ $slot }}
                </div>
            </main>

            <footer class="border-t border-slate-200 px-6 py-4 text-xs text-slate-400 dark:border-slate-800 dark:text-slate-500">
                <div class="mx-auto flex w-full max-w-[1400px] items-center justify-between">
                    <span>© {{ date('Y') }} Inker Admin — Laravel + Livewire + Tailwind.</span>
                    <span class="hidden sm:inline">v1.0</span>
                </div>
            </footer>
        </div>
    </div>

    <x-ui.toasts />

    <script>
        function adminShell() {
            return {
                collapsed: JSON.parse(localStorage.getItem('sidebarCollapsed') || 'false'),
                mobileOpen: false,
                init() {
                    window.addEventListener('resize', () => {
                        if (window.innerWidth >= 1024) this.mobileOpen = false;
                    });
                },
                toggleCollapse() {
                    this.collapsed = !this.collapsed;
                    localStorage.setItem('sidebarCollapsed', JSON.stringify(this.collapsed));
                },
                toggleMobile() { this.mobileOpen = !this.mobileOpen; },
            };
        }
    </script>

    @stack('scripts')
</body>
</html>
