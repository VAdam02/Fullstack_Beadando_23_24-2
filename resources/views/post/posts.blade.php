<x-general-layout>
    <div class="w-full" data-carousel="slide">
        <!-- Carousel wrapper -->
        <div class="m-3 relative h-56 overflow-hidden rounded-lg">
            @foreach ($highlightposts as $post)
            <div class="hidden duration-700 ease-in-out" data-carousel-item>
                <div class="rounded-lg p-5 bg-gray-700 shadow-md">
                    <a href="{{ route('posts.show', $post->id) }}" class="text-gray-300 hover:text-gray-500 transition duration-500 ease-in-out">
                        <h2 class="truncate font-semibold text-lg mb-2">{{ $post->title }}</h2>
                        <div class="h-24 text-justify overflow-hidden relative">
                            <div class="absolute text-justify bottom-0 left-0 w-full h-10 bg-gradient-to-t from-gray-700 to-transparent"></div>
                            {{ $post->content }}
                        </div>
                    </a>
                    <div class="text-sm text-gray-100 mt-2">Posted by <a href="{{ route('users.show', $post->author->id) }}" class="font-semibold text-gray-400 hover:text-gray-800 transition duration-200 ease-in-out">{{ $post->author->name }}</a> on {{ $post->date }}</div>
                    <div class="mt-2">
                        @foreach ($post->categories as $category)
                            <a href="{{ route('categories.show', $category->id) }}" class="inline-block px-2 py-1 rounded-full text-xs font-semibold text-gray-900 mt-1 mr-2 hover:text-gray-500 transition duration-200 ease-in-out" style="background-color: {{ $category->color }}">{{ $category->name }}</a>
                        @endforeach
                    </div>
                </div>
            </div>

            @endforeach
            <!-- Slider indicators -->
            <div class="absolute z-30 flex -translate-x-1/2 bottom-5 left-1/2 space-x-3 rtl:space-x-reverse">
                @foreach ($highlightposts as $post)
                    <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="{{ $post->title }}" data-carousel-slide-to="{{ $loop->index }}"></button>
                @endforeach
            </div>
            <!-- Slider controls -->
            <button type="button" class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-prev>
                <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                    <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4"/>
                    </svg>
                    <span class="sr-only">Previous</span>
                </span>
            </button>
            <button type="button" class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-next>
                <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                    <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    <span class="sr-only">Next</span>
                </span>
            </button>
        </div>
    </div>

    <div class="flex flex-wrap gap-10 p-5 my-3">
        <!-- Content -->
        <div class="grow lg:w-96 w-full" style="min-width:62%">
            <h1 class="font-semibold mt-5 mb-3 text-3xl">Latest posts</h1>
            <!-- List of Posts -->
            <div class="my-3 gap-10 flex flex-wrap">
                @foreach ($posts as $post)
                <div class="sm:w-96 w-full grow rounded-lg p-4 bg-gray-200 shadow-md hover:shadow-lg hover:scale-105 transform transition duration-300 ease-in-out">
                    <a href="{{ route('posts.show', $post->id) }}" class="hover:text-gray-500">
                        <h2 class="truncate font-semibold text-lg mb-2">{{ $post->title }}</h2>
                        <div class="h-48 text-justify overflow-hidden relative">
                            <div class="absolute bottom-0 left-0 w-full h-20 bg-gradient-to-t from-gray-200 to-transparent"></div>
                            {{ $post->content }}
                        </div>
                    </a>
                    <div class="text-sm text-gray-500 mt-2">Posted by <a href="{{ route('users.show', $post->author->id) }}" class="font-semibold text-gray-900 hover:text-gray-500">{{ $post->author->name }}</a> on {{ $post->date }}</div>
                    <div class="mt-2">
                        @foreach ($post->categories as $category)
                            <a href="{{ route('categories.show', $category->id) }}" class="inline-block px-2 py-1 rounded-full text-xs font-semibold text-gray-900 mt-1 mr-2 hover:text-gray-500" style="background-color: {{ $category->color }}">{{ $category->name }}</a>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination Links -->
            <div class="my-3">
                {{ $posts->links() }}
            </div>
        </div>

        <div class="flex flex-wrap gap-10 h-fit w-full xl:w-96">
            <div class="mx-auto xl:mx-0 xl:w-full">
                <h1 class="font-semibold mt-5 mb-3 text-3xl">Top authors</h1>
                <table class="bg-gray-900 rounded-lg overflow-hidden w-full">
                    <thead>
                        <tr>
                            <th class="text-left px-4 py-2 border-b border-gray-700 text-white">Name</th>
                            <th class="text-right px-4 py-2 border-b border-gray-700 text-white">Posts</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($authorsPostCount as $author)
                        <tr class="{{ $loop->iteration % 2 ? 'bg-gray-800' : 'bg-gray-700' }}">
                            <td class="text-left px-4 py-2 border-b border-gray-700 text-white">{{ $author->name }}</td>
                            <td class="text-right px-4 py-2 border-b border-gray-700 text-white">{{ $author->posts_count }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mx-auto xl:mx-0 xl:w-full">
                <h1 class="font-semibold mt-5 mb-3 text-3xl">Top categories</h1>
                <table class="bg-gray-900 rounded-lg overflow-hidden w-full">
                    <thead>
                        <tr>
                            <th class="text-left px-4 py-2 border-b border-gray-700 text-white">Name</th>
                            <th class="text-right px-4 py-2 border-b border-gray-700 text-white">Posts</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categoriesPostCount as $category)
                        <tr class="{{ $loop->iteration % 2 ? 'bg-gray-800' : 'bg-gray-700' }}">
                            <td class="text-left px-4 py-2 border-b border-gray-700 text-white">{{ $category->name }}</td>
                            <td class="text-right px-4 py-2 border-b border-gray-700 text-white">{{ $category->posts_count }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-general-layout>
