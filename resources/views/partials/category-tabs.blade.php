@php
    $tabCategories = \App\Models\category::query()->orderBy('name')->get();
@endphp
<div class="mb-8 rounded-xl border border-gray-200 bg-white px-2 py-3 shadow-sm sm:px-4 sm:py-4">
    {{-- Größere Tabs + horizontales Scrollen, damit mehr Topics sichtbar bleiben --}}
    <div class="-mx-1 flex flex-nowrap items-stretch gap-2 overflow-x-auto pb-1 sm:mx-0 sm:flex-wrap sm:overflow-visible sm:gap-3 sm:pb-0">
        <a
            href="{{ route('home') }}"
            class="shrink-0 rounded-lg px-4 py-3 text-base font-semibold transition-colors sm:py-2.5 {{ request()->routeIs('home') ? 'bg-blue-600 text-white shadow-sm' : 'text-gray-700 hover:bg-gray-100' }}"
        >
            {{ __('All') }}
        </a>
        @foreach ($tabCategories as $cat)
            <a
                href="{{ route('posts.category', $cat) }}"
                class="shrink-0 rounded-lg px-4 py-3 text-base font-semibold transition-colors sm:py-2.5 {{ $activeCategory && $activeCategory->is($cat) ? 'bg-blue-600 text-white shadow-sm' : 'text-gray-700 hover:bg-gray-100' }}"
            >
                {{ $cat->name }}
            </a>
        @endforeach
    </div>
</div>
