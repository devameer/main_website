@props([
    'title' => '',
    'breadcrumbs' => [],
])

<header class="sticky top-0 z-20 border-b border-slate-200 bg-white/80 backdrop-blur-md dark:border-slate-800 dark:bg-slate-900/80">
    <div class="flex h-16 items-center gap-3 px-4 sm:px-6 lg:px-8">
        {{-- Mobile menu + collapse --}}
        <button type="button" @click="toggleMobile()" class="btn btn-ghost btn-icon lg:hidden">
            <x-ui.icon name="menu" size="20" />
        </button>
        <button type="button" @click="toggleCollapse()" class="btn btn-ghost btn-icon hidden lg:inline-flex">
            <x-ui.icon name="panel-left" size="20" />
        </button>

        {{-- Breadcrumbs / title --}}
        <div class="min-w-0">
            <nav class="flex items-center gap-1.5 text-xs text-slate-400">
                @foreach ($breadcrumbs as $crumb)
                    @if (!$loop->first)<x-ui.icon name="chevron-right" size="12" />@endif
                    @if (!empty($crumb['url']))
                        <a href="{{ $crumb['url'] }}" class="transition-colors hover:text-primary-600">{{ $crumb['label'] }}</a>
                    @else
                        <span class="text-slate-500 dark:text-slate-300">{{ $crumb['label'] }}</span>
                    @endif
                @endforeach
            </nav>
            <h1 class="truncate text-base font-semibold text-slate-900 dark:text-white">{{ $title }}</h1>
        </div>

        {{-- Search --}}
        <div class="ml-auto hidden md:block">
            <label class="search w-64 lg:w-72">
                <x-ui.icon name="search" size="16" class="text-slate-400" />
                <input type="search" placeholder="Search articles, people…" class="text-sm" />
                <kbd class="ml-1 hidden rounded border border-slate-200 px-1.5 text-[10px] font-medium text-slate-400 lg:inline dark:border-slate-700">⌘K</kbd>
            </label>
        </div>

        {{-- Actions --}}
        <div class="flex items-center gap-1" :class="{ 'md:ml-2': true }">
            {{-- Theme toggle --}}
            <div x-data="themeToggle()" class="relative">
                <x-ui.dropdown align="right" width="w-40">
                    <x-slot:trigger>
                        <span class="btn btn-ghost btn-icon">
                            <x-ui.icon name="sun" size="19" class="dark:hidden" />
                            <x-ui.icon name="moon" size="19" class="hidden dark:block" />
                        </span>
                    </x-slot:trigger>
                    <button type="button" class="menu-item" @click="setTheme('light')">
                        <x-ui.icon name="sun" size="16" /> Light
                    </button>
                    <button type="button" class="menu-item" @click="setTheme('dark')">
                        <x-ui.icon name="moon" size="16" /> Dark
                    </button>
                    <button type="button" class="menu-item" @click="setTheme('system')">
                        <x-ui.icon name="monitor" size="16" /> System
                    </button>
                </x-ui.dropdown>
            </div>

            {{-- Notifications --}}
            <x-ui.dropdown align="right" width="w-80" panelClass="p-0">
                <x-slot:trigger>
                    <span class="relative btn btn-ghost btn-icon">
                        <x-ui.icon name="bell" size="19" />
                        <span class="absolute right-1.5 top-1.5 h-2 w-2 rounded-full bg-danger-500 ring-2 ring-white dark:ring-slate-900"></span>
                    </span>
                </x-slot:trigger>
                <div class="flex items-center justify-between px-3 py-2.5">
                    <span class="text-sm font-semibold text-slate-800 dark:text-slate-100">Notifications</span>
                    <span class="badge badge-primary">3 new</span>
                </div>
                <div class="max-h-80 divide-y divide-slate-100 overflow-y-auto dark:divide-slate-800">
                    @php
                        $notifTones = [
                            'info'    => 'bg-info-50 text-info-600 dark:bg-info-500/15 dark:text-info-400',
                            'success' => 'bg-success-50 text-success-600 dark:bg-success-500/15 dark:text-success-400',
                            'warning' => 'bg-warning-50 text-warning-600 dark:bg-warning-500/15 dark:text-warning-400',
                            'danger'  => 'bg-danger-50 text-danger-600 dark:bg-danger-500/15 dark:text-danger-400',
                        ];
                    @endphp
                    @foreach ([
                        ['comment','New comment on "Laravel Tips"','2m ago','info'],
                        ['user','Sarah joined as editor','1h ago','success'],
                        ['alert-triangle','Storage almost full','3h ago','warning'],
                    ] as $n)
                        <a href="#" class="flex gap-3 px-3 py-3 transition-colors hover:bg-slate-50 dark:hover:bg-slate-800/50">
                            <span class="mt-0.5 flex h-8 w-8 shrink-0 items-center justify-center rounded-full {{ $notifTones[$n[3]] }}">
                                <x-ui.icon :name="$n[0]" size="15" />
                            </span>
                            <span class="min-w-0 flex-1">
                                <span class="block text-sm text-slate-700 dark:text-slate-200">{{ $n[1] }}</span>
                                <span class="block text-xs text-slate-400">{{ $n[2] }}</span>
                            </span>
                        </a>
                    @endforeach
                </div>
                <a href="#" class="block px-3 py-2.5 text-center text-xs font-semibold text-primary-600 hover:bg-slate-50 dark:hover:bg-slate-800">View all notifications</a>
            </x-ui.dropdown>

            {{-- User menu --}}
            <x-ui.dropdown align="right" width="w-60" panelClass="p-0">
                <x-slot:trigger>
                    <span class="flex items-center gap-2 rounded-[8px] p-1 pr-2 transition-colors hover:bg-slate-100 dark:hover:bg-slate-800">
                        <img src="https://i.pravatar.cc/64?img=12" alt="avatar" class="h-8 w-8 rounded-full object-cover" />
                        <span class="hidden text-left lg:block">
                            <span class="block text-xs font-semibold leading-tight text-slate-800 dark:text-slate-100">Ameer Ahmad</span>
                            <span class="block text-[11px] leading-tight text-slate-400">Administrator</span>
                        </span>
                        <x-ui.icon name="chevron-down" size="15" class="hidden text-slate-400 lg:block" />
                    </span>
                </x-slot:trigger>
                <div class="flex items-center gap-3 px-3 py-3">
                    <img src="https://i.pravatar.cc/64?img=12" alt="avatar" class="h-10 w-10 rounded-full object-cover" />
                    <div class="min-w-0">
                        <p class="truncate text-sm font-semibold text-slate-800 dark:text-slate-100">Ameer Ahmad</p>
                        <p class="truncate text-xs text-slate-400">ameer@example.com</p>
                    </div>
                </div>
                <div class="my-1 border-t border-slate-100 dark:border-slate-800"></div>
                <a href="#" class="menu-item"><x-ui.icon name="user" size="16" /> Profile</a>
                <a href="#" class="menu-item"><x-ui.icon name="settings" size="16" /> Account settings</a>
                <a href="#" class="menu-item"><x-ui.icon name="circle-help" size="16" /> Help center</a>
                <div class="my-1 border-t border-slate-100 dark:border-slate-800"></div>
                <a href="#" class="menu-item menu-item-danger"><x-ui.icon name="log-out" size="16" /> Sign out</a>
            </x-ui.dropdown>
        </div>
    </div>
</header>

<script>
    function themeToggle() {
        return {
            setTheme(t) {
                localStorage.setItem('theme', t);
                window.applyTheme(t);
            },
        };
    }
</script>
