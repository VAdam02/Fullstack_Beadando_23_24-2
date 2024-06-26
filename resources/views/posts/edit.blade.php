<x-posts-layout title="Post editor" :authorsPostCount="$authorsPostCount" :categoriesPostCount="$categoriesPostCount">
    <div class="h-96" id="preview"></div>

    <form id="editform" action="{{ route('posts.update', $post) }}" method="POST" enctype="multipart/form-data">
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
            <script>
                content.addEventListener('input', function (e) {
                    content.style.height = (content.scrollHeight) + 'px';
                });
                addEventListener('load', function (e) {
                    content.style.height = (content.scrollHeight) + 'px';
                });
                addEventListener('resize', function (e) {
                    content.style.height = (content.scrollHeight) + 'px';
                });
            </script>
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
            <label for="image" class="block text-sm font-semibold mb-2">Image</label>
            <input type="file" name="image" id="image" class="w-full p-2 border border-gray-300 rounded">
            @error('image')
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
        <div class="flex gap-3">
            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Save</button>
        </div>

        <script>
            function updatePreview() {
                let title = document.getElementById('title').value;
                let content = document.getElementById('content').value;
                let date = document.getElementById('date').value;
                let public = document.getElementById('public').checked;
                let categories = Array.from(document.querySelectorAll('input[name="categories[]"]:checked')).map(category => category.value);
                let image = document.getElementById('image').files[0];

                fetch('/posts/preview', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        title: title,
                        content: content,
                        date: date,
                        public: public,
                        categories: categories
                    })
                })
                .then(function (response) {
                    return response.text();
                })
                .then(function (html) {
                    document.getElementById('preview').innerHTML = html;
                    document.querySelector('#preview #banner').style.backgroundImage = image == null ? 'url("{{ $post->imagename == null ? "https://via.placeholder.com/640x480.png/004466" : Storage::url('images/' . $post->imagename) }}")' : `url(${URL.createObjectURL(image)})`;
                });
            }
            document.querySelector('#editform').addEventListener('input', updatePreview);

            updatePreview();
        </script>
    </form>
    <a href="{{ url()->previous() }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Cancel</a>
    @can('delete', $post)
    <form action="{{ route('posts.destroy', $post) }}" method="POST" class="inline-block">
        @csrf
        @method('DELETE')
        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Delete</button>
    </form>
    @endcan
</x-posts-layout>
