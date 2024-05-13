<x-posts-layout title="Post editor" :authorsPostCount="$authorsPostCount" :categoriesPostCount="$categoriesPostCount">
    @vite(['resources/css/app.css','resources/js/app.js'])

    <div class="h-96" id="preview"></div>

    <form id="createform" action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="title" class="block text-sm font-semibold mb-2">Title</label>
            <input type="text" name="title" id="title" class="w-full p-2 border border-gray-300 rounded" value="{{ old('title') }}">
            @error('title')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-3">
            <label for="content" class="block text-sm font-semibold mb-2">Content</label>
            <textarea name="content" id="content" class="w-full p-2 border border-gray-300 rounded">{{ old('content') }}</textarea>
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
                        <input type="checkbox" name="categories[]" id="category{{ $category->id }}" value="{{ $category->id }}" {{ in_array($category->id, old('categories', [])) ? 'checked' : '' }}>
                        <label for="category{{ $category->id }}" >{{ $category->name }}</label>
                    </div>
                @endforeach
            </div>

            @error('categories')
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
            <input type="checkbox" name="public" id="public" value="1" {{ old('public') ? 'checked' : '' }}>
            <label for="public" class="block text-sm font-semibold mb-2">Public</label>
            @error('public')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-3">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Create post</button>
        </div>
        <script>
            function updatePreview() {
                let title = document.getElementById('title').value;
                let content = document.getElementById('content').value;
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
                        public: public,
                        categories: categories
                    })
                })
                .then(function (response) {
                    return response.text();
                })
                .then(function (html) {
                    document.getElementById('preview').innerHTML = html;
                    document.querySelector('#preview #banner').style.backgroundImage = image == null ? 'url("https://via.placeholder.com/640x480.png/004466")' : `url(${URL.createObjectURL(image)})`;
                });
            }
            document.querySelector('#createform').addEventListener('input', updatePreview);

            updatePreview();
        </script>
    </form>
</x-posts-layout>
