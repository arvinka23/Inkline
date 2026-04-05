<x-app-layout>
    <article class="mx-auto max-w-3xl px-4 pb-20 pt-8 sm:px-6 lg:px-8">
        <div class="inkline-article-surface">
            <p class="mb-8 border-b border-stone-200 pb-6 text-sm leading-relaxed text-stone-600 dark:border-stone-600 dark:text-stone-300">
                @if (filled($post->user->username))
                    <a href="{{ route('profile.show', ['author' => '@'.$post->user->username]) }}" class="font-semibold text-inkline-800 hover:underline dark:text-amber-200">{{ '@'.$post->user->username }}</a>
                @else
                    <span class="font-semibold text-stone-500 dark:text-stone-400">{{ $post->user->name }}</span>
                @endif
                <span class="mx-2 text-stone-400 dark:text-stone-500">·</span>
                <a href="{{ route('posts.category', $post->category) }}" class="text-stone-700 hover:text-inkline-700 hover:underline dark:text-stone-200 dark:hover:text-amber-200">{{ $post->category->name }}</a>
                @if ($post->published_at)
                    <span class="mx-2 text-stone-400 dark:text-stone-500">·</span>
                    <time class="text-stone-500 dark:text-stone-400" datetime="{{ $post->published_at->toIso8601String() }}">{{ $post->published_at->format('M j, Y') }}</time>
                @endif
            </p>

            <div class="mb-8 overflow-hidden rounded-xl border border-stone-200 dark:border-stone-600">
                <img
                    src="{{ $post->coverImageUrl(1200, 675) }}"
                    data-fallback-src="{{ asset('images/post-cover-placeholder.svg') }}"
                    alt="{{ $post->title }}"
                    class="aspect-[1200/675] max-h-[min(22rem,50vh)] w-full object-cover sm:max-h-[min(28rem,55vh)]"
                    width="1200"
                    height="675"
                    loading="eager"
                    fetchpriority="high"
                    onerror="this.onerror=null;this.src=this.dataset.fallbackSrc"
                />
            </div>

            <h1 class="font-display text-3xl font-bold leading-tight sm:text-4xl md:text-[2.5rem]">
                {{ $post->title }}
            </h1>

            <div class="mt-10 space-y-4 text-[1.0625rem] leading-[1.75] sm:text-lg">
                {!! nl2br(e($post->content)) !!}
            </div>

            <div class="mt-12 border-t border-stone-200 pt-8 dark:border-stone-600">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <p class="text-sm font-medium tabular-nums text-stone-600 dark:text-stone-300">
                        {{ trans_choice(':count clap|:count claps', $post->claps_count, ['count' => $post->claps_count]) }}
                    </p>

                    <div class="flex flex-wrap items-center gap-2">
                        @auth
                            @if (! $clapped)
                                <form action="{{ route('claps.store', $post) }}" method="post" class="inline">
                                    @csrf
                                    <button
                                        type="submit"
                                        class="inline-flex items-center justify-center rounded-lg bg-amber-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-400 focus:ring-offset-2 dark:focus:ring-offset-stone-800"
                                    >
                                        {{ __('Clap') }}
                                    </button>
                                </form>
                            @else
                                <span class="inline-flex items-center rounded-lg border border-stone-300 bg-stone-100 px-4 py-2.5 text-sm font-medium text-stone-700 dark:border-stone-500 dark:bg-stone-900/50 dark:text-stone-200">
                                    {{ __('You clapped this') }}
                                </span>
                            @endif
                        @else
                            <a
                                href="{{ route('login') }}"
                                class="inline-flex items-center justify-center rounded-lg border border-stone-300 bg-white px-4 py-2.5 text-sm font-semibold text-stone-800 hover:bg-stone-50 dark:border-stone-500 dark:bg-stone-900 dark:text-stone-100 dark:hover:bg-stone-950"
                            >
                                {{ __('Log in to clap') }}
                            </a>
                        @endauth

                        @can('update', $post)
                            <a
                                href="{{ route('posts.edit', $post) }}"
                                class="inline-flex items-center justify-center rounded-lg border border-stone-300 bg-white px-4 py-2.5 text-sm font-semibold text-stone-800 hover:bg-stone-50 dark:border-stone-500 dark:bg-stone-900 dark:text-stone-100 dark:hover:bg-stone-950"
                            >
                                {{ __('Edit') }}
                            </a>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </article>
</x-app-layout>
