@foreach ($posts as $post)
    <a href="{{ route('posts.show', $post->id) }}">
        <h2>{{ $post->title }}</h2>
        <div>
            {{ $post->content }}
        </div>
    </a>
@endforeach
