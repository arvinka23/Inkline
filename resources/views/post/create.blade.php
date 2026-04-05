<x-app-layout>
    <x-slot name="header">
        <h1 class="font-display text-2xl font-semibold text-stone-900 dark:text-stone-50">{{ __('Write') }}</h1>
    </x-slot>

    <div class="max-w-3xl mx-auto px-4 py-10 sm:px-6 lg:px-8">
        <form method="post" action="{{ route('posts.store') }}" enctype="multipart/form-data" class="space-y-6">
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
                <x-input-label for="cover_image" :value="__('Cover image (optional)')" />
                <input
                    id="cover_image"
                    name="cover_image"
                    type="file"
                    accept="image/jpeg,image/png,image/gif,image/webp"
                    class="mt-1 block w-full text-sm text-stone-600 file:mr-4 file:rounded-md file:border-0 file:bg-amber-600 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white hover:file:bg-amber-700 dark:text-stone-300 dark:file:bg-amber-500 dark:hover:file:bg-amber-600"
                />
                <p class="mt-1 text-xs text-stone-500 dark:text-stone-400">{{ __('JPEG, PNG, GIF or WebP, max 5 MB.') }}</p>
                <x-input-error :messages="$errors->get('cover_image')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="image" :value="__('Or paste image URL (optional)')" />
                <x-text-input id="image" name="image" type="text" class="mt-1 block w-full" :value="old('image')" placeholder="https://..." />
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
