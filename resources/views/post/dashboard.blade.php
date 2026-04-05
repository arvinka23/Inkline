<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="font-display text-2xl font-semibold text-stone-900 dark:text-stone-50">{{ __('My desk') }}</h1>
                <p class="mt-1 text-sm text-stone-600 dark:text-stone-400">{{ __('Your posts and quick actions') }}</p>
            </div>
            <a href="{{ route('posts.create') }}" class="inline-flex items-center justify-center rounded-lg bg-inkline-900 px-4 py-2 text-sm font-medium text-white hover:bg-inkline-700 dark:bg-amber-600 dark:hover:bg-amber-500">
                {{ __('New post') }}
            </a>
        </div>
    </x-slot>

    <div class="max-w-5xl mx-auto px-4 py-10 sm:px-6 lg:px-8">
        @if (session('status'))
            <p class="mb-6 text-sm text-green-700 dark:text-green-400">{{ session('status') }}</p>
        @endif

        @if ($posts->isEmpty())
            <p class="text-stone-600 dark:text-stone-400">{{ __('You have not written anything yet.') }}</p>
        @else
            <ul class="divide-y divide-amber-100 dark:divide-stone-700 rounded-xl border border-amber-100 bg-white dark:border-stone-700 dark:bg-stone-900">
                @foreach ($posts as $post)
                    <li class="flex flex-col gap-3 p-4 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <a href="{{ route('posts.read', $post) }}" class="font-medium text-stone-900 hover:text-inkline-700 dark:text-stone-100 dark:hover:text-amber-200">{{ $post->title }}</a>
                            <p class="mt-1 text-xs text-stone-500">{{ $post->category->name }} · {{ $post->published_at?->diffForHumans() ?? __('Draft') }}</p>
                        </div>
                        <div class="flex gap-3">
                            <a href="{{ route('posts.edit', $post) }}" class="text-sm text-inkline-700 dark:text-amber-200">{{ __('Edit') }}</a>
                            <form action="{{ route('posts.destroy', $post) }}" method="post" onsubmit="return confirm('{{ __('Delete this post?') }}');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-sm text-red-600 dark:text-red-400">{{ __('Delete') }}</button>
                            </form>
                        </div>
                    </li>
                @endforeach
            </ul>
            <div class="mt-8">{{ $posts->links() }}</div>
        @endif
    </div>
</x-app-layout>
