<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

<div class="container mx-auto mt-5 grid grid-cols-3 gap-4">
@foreach ($posts as $post)
<div class="rounded-lg p-4 bg-gray-100 shadow-md">
    <a href="{{ route('posts.show', $post->id) }}">
        <h2 class="truncate font-semibold text-lg mb-2">{{ $post->title }}</h2>
        <div class="h-24 overflow-hidden relative">
            <div class="absolute bottom-0 left-0 w-full h-20 bg-gradient-to-t from-gray-100 to-transparent"></div>
            {{ $post->content }}
        </div>
    </a>
</div>
@endforeach
</div>
