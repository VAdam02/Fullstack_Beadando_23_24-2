<x-posts-layout title="Post editor" :authorsPostCount="$authorsPostCount" :categoriesPostCount="$categoriesPostCount">
    @vite(['resources/css/app.css','resources/js/app.js'])

    <form action="{{ route('posts.update', $post) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="title" class="block text-sm font-semibold mb-2">Title</label>
            <input type="text" name="title" id="title" class="w-full p-2 border border-gray-300 rounded" value="{{ old('title', $post->title) }}">
            @error('title')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-3">
            <label for="content" class="block text-sm font-semibold mb-2">Content</label>
            <textarea name="content" id="content" class="w-full p-2 border border-gray-300 rounded">{{ old('content', $post->content) }}</textarea>
            @error('content')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-3">
            <label for="categories" class="block text-sm font-semibold mb-2">Categories</label>
            <div class="mt-2">
                @foreach ($categories as $category)
                    <div class="inline-block px-2 py-1 rounded-full text-xs font-semibold text-gray-900 mt-1 mr-2 hover:text-gray-500" style="background-color: {{ $category->color }}">
                        <input type="checkbox" name="categories[]" id="category{{ $category->id }}" value="{{ $category->id }}" {{ in_array($category->id, old('categories', $post->categories->pluck('id')->toArray())) ? 'checked' : '' }}>
                        <label for="category{{ $category->id }}" >{{ $category->name }}</label>
                    </div>
                @endforeach
            </div>

            @error('categories')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-3">
            <label for="date" class="block text-sm font-semibold mb-2">Date</label>
            <input type="datetime-local" name="date" id="date" class="w-full p-2 border border-gray-300 rounded" value="{{ old('date', $post->date) }}">

            @error('date')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-3">
            <input type="checkbox" name="public" id="public" value="1" {{ old('public', $post->public) ? 'checked' : '' }}>
            <label for="public" class="block text-sm font-semibold mb-2">Public</label>
            @error('public')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-3">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Update post</button>
        </div>
    </form>
</x-posts-layout>
