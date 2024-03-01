<table>
    <tr>
        <th>Név</th>
        <th>Szín</th>
    </tr>
    @foreach ($categories as $category)
    <tr>
        <td><a href={{ route('categories.show', ["category" => $category->id]) }}>{{ $category->name }}</td>
        <td>{{ $category->color }}</td>
    </tr>
    @endforeach
</table>
