<x-posts-layout title="Post viewer" :authorsPostCount="$authorsPostCount" :categoriesPostCount="$categoriesPostCount">
    <img src="{{ is_null($post->imagename) ? "https://via.placeholder.com/640x480.png/004466" : Storage::url('images/' . $post->imagename) }}" alt="{{ $post->title }}" class="w-full h-96 object-cover object-center rounded-lg mb-5">

    <h1 class="font-semibold mt-5 text-3xl">{{ $post->title }}</h1>
    <p class="text-gray-500 mb-1 text-sm">By {{ $post->author->name }}</p>
    <div class="my-2">
        @foreach ($post->categories as $category)
            <a href="{{ route('categories.show', $category->id) }}" class="inline-block px-2 py-1 rounded-full text-xs font-semibold text-gray-900 mt-1 mr-2 hover:text-gray-500" style="background-color: {{ $category->color }}">{{ $category->name }}</a>
        @endforeach
    </div>
    <p class="mb-3 text-justify">{{ $post->content }}</p>
    <p class="text-gray-500">Created at {{ $post->created_at->diffForHumans() }}</p>
    <p class="text-gray-500">Updated at {{ $post->updated_at->diffForHumans() }}</p>
    <p class="text-gray-500">Published at {{ \Carbon\Carbon::parse($post->date)->diffForHumans() }}</p>
    <p class="text-gray-500 mb-3">Public: {{ $post->public ? 'Yes' : 'No' }}</p>
    <div class="flex gap-3">
        @can('update', $post)
        <a href="{{ route('posts.edit', $post) }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Edit</a>
        @endcan
        @can('delete', $post)
        <form action="{{ route('posts.destroy', $post) }}" method="POST" class="inline-block">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Delete</button>
        </form>
        @endcan
    </div>
    <div class="mt-5">
        @include('users.partials.card', ['user' => $post->author])
    </div>
</x-posts-layout>
