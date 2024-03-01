@foreach ($posts as $post)
    <h2><a href={{ route('posts.show', ["post" => $post->id]) }}>{{ $post->title }}</a></h2>
    <p>{{ $post->content }}</p>
    <p><a href={{ route('posts.edit', ["post" => $post->id]) }}>Szerkesztés</a></p>
    <form action={{ route('posts.destroy', ["post" => $post->id]) }} method="post">
        @csrf
        @method('DELETE')
        <button type="submit">Törlés</button>
    </form>
    <hr>
@endforeach
