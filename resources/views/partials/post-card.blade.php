{{--
    Medium-style card: ~65% copy / ~35% image, white surface, navy CTA, Inter (sans).
--}}
<article
    class="grid w-full grid-cols-1 items-stretch overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm transition-shadow hover:shadow-md dark:border-gray-700 dark:bg-gray-900 md:grid-cols-[minmax(0,1fr)_minmax(200px,32%)]"
>
    <div
        class="order-2 flex flex-col justify-center px-6 py-7 text-left md:order-none md:row-start-1 md:px-8 md:py-8 lg:px-10 lg:py-9"
    >
        <a href="{{ route('posts.read', $post) }}" class="group block">
            <h2
                class="mb-3 text-xl font-bold leading-snug text-gray-900 group-hover:text-gray-700 md:mb-4 md:text-2xl dark:text-stone-100 dark:group-hover:text-stone-200"
            >
                {{ $post->title }}
            </h2>
        </a>
        <p class="mb-6 text-sm leading-relaxed text-gray-600 md:mb-7 md:text-base dark:text-stone-400">
            {{ \Illuminate\Support\Str::limit(strip_tags($post->content), 220) }}
        </p>
        <a
            href="{{ route('posts.read', $post) }}"
            class="inline-flex w-fit items-center rounded-md bg-[#1a202c] px-4 py-2.5 text-[11px] font-semibold uppercase tracking-wider text-white shadow-sm hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2 dark:bg-stone-100 dark:text-gray-900 dark:hover:bg-stone-200 dark:focus:ring-offset-gray-900"
        >
            {{ __('Read more') }}
            <svg
                class="ms-1.5 h-4 w-4 rtl:rotate-180"
                aria-hidden="true"
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="2"
                stroke="currentColor"
            >
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 12H5m14 0-4 4m4-4-4-4" />
            </svg>
        </a>
    </div>

    <div
        class="order-1 flex min-h-[180px] bg-gray-100 md:order-none md:row-start-1 md:min-h-[260px] dark:bg-stone-950"
    >
        <a
            href="{{ route('posts.read', $post) }}"
            class="flex min-h-[180px] w-full md:min-h-full focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-inset"
        >
            <img
                class="h-48 w-full rounded-t-lg object-cover md:h-full md:min-h-[260px] md:rounded-none md:rounded-tr-lg md:rounded-br-lg"
                src="{{ $post->coverImageUrl(800, 600) }}"
                data-fallback-src="{{ asset('images/post-cover-placeholder.svg') }}"
                alt="{{ $post->title }}"
                width="800"
                height="600"
                loading="lazy"
                onerror="this.onerror=null;this.src=this.dataset.fallbackSrc"
            />
        </a>
    </div>
</article>
