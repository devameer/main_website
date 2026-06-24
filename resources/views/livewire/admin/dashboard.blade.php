@php
    $stats = $this->stats;
    $visits = $this->visitsSeries;
    $langs = $this->languageBreakdown;
    $articles = $this->latestArticles;
    $messages = $this->recentMessages;
    $actions = $this->quickActions;

    $statusTone = [
        'published' => 'success', 'draft' => 'warning',
        'scheduled' => 'info', 'archived' => 'gray',
    ];
    $statusLabel = [
        'published' => 'Published', 'draft' => 'Draft',
        'scheduled' => 'Scheduled', 'archived' => 'Archived',
    ];
@endphp

<div class="space-y-6">
{{-- Page header --}}
<div class="flex flex-wrap items-end justify-between gap-4">
    <div>
        <h2 class="text-xl font-bold tracking-tight text-slate-900 dark:text-white">Welcome back, Ameer 👋</h2>
        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Here's what's happening with your content today.</p>
    </div>
    <div class="flex items-center gap-2">
        <x-ui.button variant="secondary" size="md" icon="download" href="#">Export</x-ui.button>
        <x-ui.button variant="primary" size="md" icon="plus" href="{{ route('admin.articles.create') }}">New Article</x-ui.button>
    </div>
</div>

{{-- Stat cards --}}
<div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
    <x-ui.stat-card label="Published Articles" :value="number_format($stats['published'])" icon="check-circle" tone="success" delta="+8.2%" :deltaUp="true" />
    <x-ui.stat-card label="Drafts" :value="number_format($stats['drafts'])" icon="draft" tone="warning" delta="-3.1%" :deltaUp="false" />
    <x-ui.stat-card label="Scheduled" :value="number_format($stats['scheduled'])" icon="calendar-clock" tone="info" delta="+2.0%" :deltaUp="true" />
    <x-ui.stat-card label="New Messages" :value="$messagesCount" icon="mail" tone="primary" delta="+12.5%" :deltaUp="true" />
</div>

{{-- Charts row --}}
<div class="mb-6 grid grid-cols-1 gap-4 lg:grid-cols-3">
    {{-- Visits line chart --}}
    <x-ui.card class="lg:col-span-2" title="Article Visits" subtitle="Last 30 days">
        <x-slot:header>
            <div class="flex items-center gap-3 text-xs">
                <span class="inline-flex items-center gap-1.5 font-medium text-slate-500"><span class="h-2 w-2 rounded-full bg-primary-500"></span> Visits</span>
                <span class="inline-flex items-center gap-1.5 font-medium text-slate-500"><span class="h-2 w-2 rounded-full bg-success-500"></span> Unique</span>
            </div>
        </x-slot:header>

        <div class="relative h-72">
            <canvas id="visitsChart"></canvas>
        </div>
    </x-ui.card>

    {{-- Language donut --}}
    <x-ui.card title="Articles by Language" subtitle="Distribution">
        <div class="flex flex-col items-center justify-center gap-4">
            <div class="relative h-44 w-44">
                <canvas id="langChart"></canvas>
                <div class="absolute inset-0 flex flex-col items-center justify-center">
                    <span class="text-2xl font-bold text-slate-900 dark:text-white">{{ array_sum(array_column($langs, 'value')) }}</span>
                    <span class="text-xs text-slate-400">Total</span>
                </div>
            </div>
            <div class="w-full space-y-2">
                @foreach ($langs as $l)
                    <div class="flex items-center justify-between text-sm">
                        <span class="inline-flex items-center gap-2 text-slate-600 dark:text-slate-300">
                            <span class="h-2.5 w-2.5 rounded-full" style="background: {{ $l['color'] }}"></span>{{ $l['label'] }}
                        </span>
                        <span class="font-semibold text-slate-800 dark:text-slate-100">{{ $l['value'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </x-ui.card>
</div>

{{-- Bottom row: latest articles + side column --}}
<div class="grid grid-cols-1 gap-4 lg:grid-cols-3">
    {{-- Latest articles --}}
    <x-ui.card class="lg:col-span-2" bodyClass="p-0">
        <div class="flex items-center justify-between px-5 py-4">
            <div>
                <h3 class="card-title">Latest Articles</h3>
                <p class="mt-0.5 text-xs text-slate-400">Most recently created</p>
            </div>
            <a href="{{ route('admin.articles.index') }}" class="text-xs font-semibold text-primary-600 hover:underline">View all</a>
        </div>
        <div class="table-wrap">
            <table class="t-base">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Status</th>
                        <th class="hidden md:table-cell">Views</th>
                        <th class="hidden lg:table-cell">Date</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($articles as $article)
                        <tr>
                            <td>
                                <div class="flex items-center gap-3">
                                    <img src="{{ $article->cover_image }}" alt="" class="h-9 w-12 rounded-md object-cover" loading="lazy">
                                    <div class="min-w-0 max-w-[220px]">
                                        <p class="truncate font-medium text-slate-800 dark:text-slate-100">{{ $article->display_title }}</p>
                                        <p class="text-xs text-slate-400">{{ $article->category }}</p>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <x-ui.badge :tone="$statusTone[$article->status]" dot>{{ $statusLabel[$article->status] }}</x-ui.badge>
                            </td>
                            <td class="hidden md:table-cell text-slate-500">{{ number_format($article->views) }}</td>
                            <td class="hidden lg:table-cell text-slate-500">{{ $article->created_at->format('M j, Y') }}</td>
                            <td class="text-right">
                                <x-ui.tooltip text="Edit">
                                    <a href="{{ route('admin.articles.edit', $article) }}" class="btn btn-ghost btn-icon text-slate-500 hover:text-primary-600">
                                        <x-ui.icon name="pencil" size="16" />
                                    </a>
                                </x-ui.tooltip>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </x-ui.card>

    {{-- Side column --}}
    <div class="space-y-4">
        {{-- Quick actions --}}
        <x-ui.card title="Quick Actions">
            <div class="grid grid-cols-2 gap-2">
                @php
                    $actionTones = [
                        'primary' => 'bg-primary-50 text-primary-600 hover:bg-primary-100 dark:bg-primary-500/15 dark:text-primary-400',
                        'success' => 'bg-success-50 text-success-600 hover:bg-success-100 dark:bg-success-500/15 dark:text-success-400',
                        'warning' => 'bg-warning-50 text-warning-600 hover:bg-warning-100 dark:bg-warning-500/15 dark:text-warning-400',
                        'info'    => 'bg-info-50 text-info-600 hover:bg-info-100 dark:bg-info-500/15 dark:text-info-400',
                    ];
                @endphp
                @foreach ($actions as $action)
                    <a href="{{ $action['route'] }}" class="flex flex-col items-center gap-2 rounded-[8px] p-3 text-center transition-colors {{ $actionTones[$action['tone']] }}">
                        <x-ui.icon :name="$action['icon']" size="20" />
                        <span class="text-xs font-semibold">{{ $action['label'] }}</span>
                    </a>
                @endforeach
            </div>
        </x-ui.card>

        {{-- Recent messages --}}
        <x-ui.card title="Recent Messages" bodyClass="p-0">
            <div class="divide-y divide-slate-100 dark:divide-slate-800">
                @foreach ($messages as $m)
                    <a href="#" class="flex items-start gap-3 px-5 py-3 transition-colors hover:bg-slate-50 dark:hover:bg-slate-800/50">
                        <img src="{{ $m['avatar'] }}" alt="" class="h-9 w-9 rounded-full object-cover">
                        <div class="min-w-0 flex-1">
                            <div class="flex items-center justify-between gap-2">
                                <p class="truncate text-sm font-medium text-slate-800 dark:text-slate-100">{{ $m['name'] }}</p>
                                <span class="shrink-0 text-[11px] text-slate-400">{{ $m['time'] }}</span>
                            </div>
                            <p class="truncate text-xs {{ $m['unread'] ? 'text-slate-600 dark:text-slate-300 font-medium' : 'text-slate-500' }}">{{ $m['preview'] }}</p>
                        </div>
                        @if ($m['unread'])
                            <span class="mt-1.5 h-2 w-2 shrink-0 rounded-full bg-primary-500"></span>
                        @endif
                    </a>
                @endforeach
            </div>
        </x-ui.card>
    </div>
</div>
</div>

@push('scripts')
    <script>
        (function () {
            const visits = @js($visits);
            const langs = @js($langs);

            const ticksColor = () => getComputedStyle(document.body).color;

            function buildVisits() {
                const el = document.getElementById('visitsChart');
                if (!el || el._chart) return;
                const ctx = el.getContext('2d');
                const grad = ctx.createLinearGradient(0, 0, 0, 280);
                grad.addColorStop(0, 'rgba(99,102,241,0.25)');
                grad.addColorStop(1, 'rgba(99,102,241,0)');

                el._chart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: visits.labels,
                        datasets: [
                            {
                                label: 'Visits',
                                data: visits.visits,
                                borderColor: '#6366f1',
                                backgroundColor: grad,
                                borderWidth: 2,
                                fill: true,
                                tension: 0.4,
                                pointRadius: 0,
                                pointHoverRadius: 5,
                                pointHoverBackgroundColor: '#6366f1',
                            },
                            {
                                label: 'Unique',
                                data: visits.unique,
                                borderColor: '#10b981',
                                borderWidth: 2,
                                borderDash: [4, 4],
                                fill: false,
                                tension: 0.4,
                                pointRadius: 0,
                                pointHoverRadius: 5,
                            },
                        ],
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: { mode: 'index', intersect: false },
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: '#0f172a',
                                padding: 10,
                                cornerRadius: 6,
                                titleFont: { size: 12 },
                                bodyFont: { size: 12 },
                            },
                        },
                        scales: {
                            x: { grid: { display: false }, ticks: { color: '#94a3b8', font: { size: 11 }, maxRotation: 0, autoSkipPadding: 20 } },
                            y: { grid: { color: 'rgba(148,163,184,0.15)' }, ticks: { color: '#94a3b8', font: { size: 11 } }, beginAtZero: true },
                        },
                    },
                });
            }

            function buildLang() {
                const el = document.getElementById('langChart');
                if (!el || el._chart) return;
                el._chart = new Chart(el.getContext('2d'), {
                    type: 'doughnut',
                    data: {
                        labels: langs.map((l) => l.label),
                        datasets: [{
                            data: langs.map((l) => l.value),
                            backgroundColor: langs.map((l) => l.color),
                            borderWidth: 0,
                            hoverOffset: 6,
                        }],
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '72%',
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: '#0f172a',
                                padding: 10,
                                cornerRadius: 6,
                            },
                        },
                    },
                });
            }

            function buildAll() { buildVisits(); buildLang(); }

            if (document.readyState !== 'loading') buildAll();
            else document.addEventListener('DOMContentLoaded', buildAll);

            document.addEventListener('livewire:navigated', buildAll);
        })();
    </script>
@endpush
