<x-app-layout>
    <div class="mx-auto max-w-6xl px-4 py-8 sm:px-6 lg:px-8">
        @include('partials.category-tabs', ['activeCategory' => $category])

        @if ($posts->isEmpty())
            <p class="text-gray-600 dark:text-stone-400">{{ __('Nothing here yet.') }}</p>
        @else
            <div class="flex flex-col gap-8">
                @foreach ($posts as $post)
                    @include('partials.post-card', ['post' => $post])
                @endforeach
            </div>
            <div class="mt-10">{{ $posts->links() }}</div>
        @endif
    </div>
</x-app-layout>
