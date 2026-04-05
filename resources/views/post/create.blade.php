<x-app-layout>
    <x-slot name="header">
        <h1 class="font-display text-2xl font-semibold text-stone-900 dark:text-stone-50">{{ __('Write') }}</h1>
    </x-slot>

    <div class="max-w-3xl mx-auto px-4 py-10 sm:px-6 lg:px-8">
        <form method="post" action="{{ route('posts.store') }}" class="space-y-6">
            @csrf
            <div>
                <x-input-label for="title" :value="__('Title')" />
                <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title')" required />
                <x-input-error :messages="$errors->get('title')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="category_id" :value="__('Topic')" />
                <select id="category_id" name="category_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100" required>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->id }}" @selected(old('category_id') == $cat->id)>{{ $cat->name }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="image" :value="__('Image URL (optional)')" />
                <x-text-input id="image" name="image" type="url" class="mt-1 block w-full" :value="old('image')" placeholder="https://..." />
                <x-input-error :messages="$errors->get('image')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="content" :value="__('Body')" />
                <textarea id="content" name="content" rows="14" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100" required>{{ old('content') }}</textarea>
                <x-input-error :messages="$errors->get('content')" class="mt-2" />
            </div>
            <x-primary-button>{{ __('Publish') }}</x-primary-button>
        </form>
    </div>
</x-app-layout>
