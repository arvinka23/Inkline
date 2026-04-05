<nav x-data="{ open: false }" class="relative z-50 border-b border-gray-200 bg-white">
    <div class="relative z-50 mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-14 items-center justify-between sm:h-16">
            <div class="flex items-center gap-6">
                <a href="{{ route('home') }}" class="flex items-center gap-2 text-gray-900 dark:text-stone-100">
                    <span class="flex -space-x-2" aria-hidden="true">
                        <span class="h-5 w-5 rounded-full bg-gray-900 dark:bg-stone-100"></span>
                        <span class="h-5 w-5 rounded-full bg-gray-400 ring-2 ring-white dark:bg-stone-500 dark:ring-stone-900"></span>
                    </span>
                    <span class="text-xl font-bold tracking-tight">Inkline</span>
                </a>
            </div>

            <div class="hidden items-center gap-4 sm:flex">
                @auth
                    <a
                        href="{{ route('posts.create') }}"
                        class="rounded-md bg-[#1a202c] px-4 py-2 text-xs font-semibold uppercase tracking-wide text-white hover:bg-gray-800 dark:bg-stone-100 dark:text-gray-900 dark:hover:bg-stone-200"
                    >
                        {{ __('Create post') }}
                    </a>
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                type="button"
                                class="inline-flex items-center gap-1 rounded-md border border-gray-200 bg-white px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-stone-600 dark:bg-stone-800 dark:text-stone-200 dark:hover:bg-stone-700"
                            >
                                {{ Auth::user()->name }}
                                <svg class="h-4 w-4 text-gray-500" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            @if (filled(Auth::user()->username))
                                <x-dropdown-link :href="route('profile.show', ['author' => '@'.Auth::user()->username])">{{ __('Profile') }}</x-dropdown-link>
                            @else
                                <x-dropdown-link :href="route('profile.edit')">{{ __('Set username') }}</x-dropdown-link>
                            @endif
                            <x-dropdown-link :href="route('dashboard')">{{ __('My desk') }}</x-dropdown-link>
                            <x-dropdown-link :href="route('profile.edit')">{{ __('Settings') }}</x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">{{ __('Log out') }}</x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900 dark:text-stone-400 dark:hover:text-stone-200">{{ __('Log in') }}</a>
                    <a
                        href="{{ route('register') }}"
                        class="rounded-md bg-[#1a202c] px-4 py-2 text-xs font-semibold uppercase tracking-wide text-white hover:bg-gray-800 dark:bg-blue-600 dark:hover:bg-blue-500"
                    >
                        {{ __('Join') }}
                    </a>
                @endauth
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button type="button" @click="open = ! open" class="rounded-md p-2 text-gray-500 hover:bg-gray-100 dark:hover:bg-stone-800" aria-expanded="false" :aria-expanded="open">
                    <span class="sr-only">{{ __('Menu') }}</span>
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden border-t border-gray-200 dark:border-stone-700 sm:hidden">
        <div class="space-y-1 px-4 py-3">
            @auth
                <a href="{{ route('posts.create') }}" class="block rounded-md py-2 text-sm font-semibold uppercase tracking-wide text-gray-900 dark:text-stone-100">{{ __('Create post') }}</a>
                <a href="{{ route('dashboard') }}" class="block py-2 text-sm text-gray-700 dark:text-stone-300">{{ __('My desk') }}</a>
                <a href="{{ route('profile.edit') }}" class="block py-2 text-sm text-gray-700 dark:text-stone-300">{{ __('Settings') }}</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full py-2 text-left text-sm text-gray-700 dark:text-stone-300">{{ __('Log out') }}</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="block py-2 text-sm text-gray-700 dark:text-stone-300">{{ __('Log in') }}</a>
                <a href="{{ route('register') }}" class="block py-2 text-sm font-medium text-gray-900 dark:text-stone-100">{{ __('Join') }}</a>
            @endauth
        </div>
    </div>
</nav>
