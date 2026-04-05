<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
            <div>
                <h1 class="font-display text-3xl font-bold text-stone-900 dark:text-stone-50">{{ $user->name }}</h1>
                <p class="mt-1 text-stone-600 dark:text-stone-400">{{ '@'.$user->username }}</p>
                @if ($user->bio)
                    <p class="mt-4 max-w-2xl text-stone-700 dark:text-stone-300">{{ $user->bio }}</p>
                @endif
                <p class="mt-3 text-sm text-stone-500">
                    {{ trans_choice(':count follower|:count followers', $user->followers_count, ['count' => $user->followers_count]) }}
                    ·
                    {{ __('following :count', ['count' => $user->following_count]) }}
                </p>
            </div>
            @auth
                @if (auth()->id() !== $user->id)
                    <form action="{{ route('follow', $user) }}" method="post">
                        @csrf
                        <button type="submit" class="rounded-lg border border-amber-300 bg-white px-4 py-2 text-sm font-medium text-inkline-900 hover:bg-inkline-50 dark:border-stone-600 dark:bg-stone-800 dark:text-amber-100 dark:hover:bg-stone-700">
                            {{ $isFollowing ? __('Unfollow') : __('Follow') }}
                        </button>
                    </form>
                @endif
            @else
                <a href="{{ route('login') }}" class="rounded-lg bg-inkline-900 px-4 py-2 text-sm font-medium text-white dark:bg-amber-600">{{ __('Follow') }}</a>
            @endauth
        </div>
    </x-slot>

    <div class="max-w-5xl mx-auto px-4 py-10 sm:px-6 lg:px-8">
        <h2 class="font-display text-lg font-semibold text-stone-900 dark:text-stone-50 mb-6">{{ __('Published') }}</h2>
        @if ($posts->isEmpty())
            <p class="text-stone-600 dark:text-stone-400">{{ __('No public posts yet.') }}</p>
        @else
            <div class="flex flex-col gap-10">
                @foreach ($posts as $post)
                    @include('partials.post-card', ['post' => $post])
                @endforeach
            </div>
            <div class="mt-10">{{ $posts->links() }}</div>
        @endif
    </div>
</x-app-layout>
