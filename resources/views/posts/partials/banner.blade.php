@vite(['resources/css/app.css','resources/js/app.js'])

<div class="relative w-full h-full duration-700 ease-in-out rounded-lg p-5 shadow-md" style="background-image: url('{{ is_null($post->imagename) ? "https://via.placeholder.com/640x480.png/004466" : Storage::url('images/' . $post->imagename) }}'); background-size: cover; background-position: center;">
    <a href="{{ route('posts.show', $post->id) }}">
        <div class="absolute bottom-0 right-0 bg-gray-900 text-white w-96 max-w-full p-3 rounded-tl-lg rounded-br-lg">
            <h2 class="truncate font-semibold text-lg mb-2">{{ $post->title }}</h2>
            <div class="h-24 text-justify overflow-hidden relative">
                <div class="absolute bottom-0 left-0 w-full h-20 bg-gradient-to-t from-gray-900 to-transparent"></div>
                {{ $post->content }}
            </div>
            <div class="text-sm text-gray-100 mt-2">Posted by <a href="{{ route('users.show', $post->author->id) }}" class="font-semibold text-gray-400 hover:text-gray-800 transition duration-200 ease-in-out">{{ $post->author->name }}</a> on {{ $post->date }}</div>
            <div class="mt-2">
                @foreach ($post->categories as $category)
                    <a href="{{ route('categories.show', $category->id) }}" class="inline-block px-2 py-1 rounded-full text-xs font-semibold text-gray-900 mt-1 mr-2 hover:text-gray-500 transition duration-200 ease-in-out" style="background-color: {{ $category->color }}">{{ $category->name }}</a>
                @endforeach
            </div>
        </div>
    </a>
</div>
