<ul>
    @foreach($categories as $category)
        <li>{{ $category->name }}</li>

        @if($category->children)
            @include('client.catalog.categories.index', ['categories' => $category->children])
        @endif
    @endforeach
</ul>
