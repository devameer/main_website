@props(['approvedComments', 'article'])

<section class="border-t border-slate-100 py-14 md:py-20">
    <div class="mx-auto w-full max-w-3xl px-4 sm:px-6">
        @if($approvedComments->isNotEmpty())
            <div class="mb-10">
                <h2 class="mb-6 text-xl font-bold text-slate-900">{{ __('articles.comments_count', ['n' => $approvedComments->count()]) }}</h2>
                <div class="space-y-5">
                    @foreach ($approvedComments as $comment)
                        <div class="flex gap-4 rounded-xl border border-slate-200 bg-white p-4">
                            @if($comment->author_avatar)
                                <img src="{{ $comment->author_avatar }}" alt="{{ $comment->author_name }}" class="h-10 w-10 shrink-0 rounded-full object-cover" loading="lazy" decoding="async" width="40" height="40">
                            @else
                                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-brand-100 font-bold text-brand-700">{{ mb_substr($comment->author_name, 0, 1) }}</span>
                            @endif
                            <div class="min-w-0 flex-1">
                                <div class="flex items-center gap-2">
                                    <span class="font-semibold text-slate-900">{{ $comment->author_name }}</span>
                                    <time class="text-xs text-slate-400">{{ $comment->created_at->diffForHumans() }}</time>
                                </div>
                                <p class="mt-1 text-sm leading-relaxed text-slate-600">{{ $comment->body }}</p>
                                @if($comment->likes > 0)
                                    <span class="mt-1 text-xs text-slate-400">👍 {{ $comment->likes }}</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <div>
            <h2 class="mb-6 text-xl font-bold text-slate-900">{{ __('articles.leave_comment') }}</h2>
            <livewire:site.comment-form :articleId="$article->id" />
        </div>
    </div>
</section>
