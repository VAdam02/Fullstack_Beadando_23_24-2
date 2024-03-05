<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

<!-- List of Posts -->
<div class="mt-5 mx-5 gap-4 flex flex-wrap">
    @foreach ($posts as $post)
    <div class="flex-auto w-96 rounded-lg p-4 bg-gray-100 shadow-md">
        <a href="{{ route('posts.show', $post->id) }}">
            <h2 class="truncate font-semibold text-lg mb-2">{{ $post->title }}</h2>
            <div class="h-24 overflow-hidden relative">
                <div class="absolute bottom-0 left-0 w-full h-20 bg-gradient-to-t from-gray-100 to-transparent"></div>
                {{ $post->content }}
            </div>
        </a>
        <div class="text-sm text-gray-500 mt-2">Posted by <a href="{{ route('users.show', $post->author->id) }}" class="font-semibold text-gray-900">{{ $post->author->name }}</a> on {{ $post->date }}</div>
        <div class="mt-2">
            @foreach ($post->categories as $category)
                <a href="{{ route('categories.show', $category->id) }}" class="inline-block px-2 py-1 rounded-full text-xs font-semibold text-gray-900 mt-1 mr-2" style="background-color: {{ $category->color }}">{{ $category->name }}</a>
            @endforeach
        </div>
    </div>
    @endforeach
</div>

<!-- Pagination Links -->
<div class="mt-5">
    {{ $posts->links() }}
</div>
