@props(['categories' => null, 'category' => null])

@if($categories && $categories->isNotEmpty())
    <div class="mt-8 flex flex-wrap gap-2">
        <a href="{{ route('articles.index') }}" class="inline-flex items-center rounded-full border px-4 py-2 text-sm font-semibold transition-colors {{ ! $category ? 'border-brand-600 bg-brand-600 text-white shadow-sm shadow-brand-600/20' : 'border-slate-200 bg-white text-slate-600 hover:border-brand-300 hover:text-brand-700' }}">
            {{ __('common.all') }}
        </a>
        @foreach ($categories as $cat)
            <a href="{{ route('articles.index', ['category' => $cat->name]) }}" class="inline-flex items-center gap-1.5 rounded-full border px-4 py-2 text-sm font-semibold transition-colors {{ $category === $cat->name ? 'border-brand-600 bg-brand-600 text-white shadow-sm shadow-brand-600/20' : 'border-slate-200 bg-white text-slate-600 hover:border-brand-300 hover:text-brand-700' }}">
                {{ $cat->name }}
                <span class="text-xs opacity-70">({{ $cat->articles_count }})</span>
            </a>
        @endforeach
    </div>
@endif
