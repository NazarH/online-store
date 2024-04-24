<form action="{{route($route, $category->id ?? null)}}" method="POST">
    @csrf

    @if(!empty($put))
        @method('PUT')
    @endif

    <input type="hidden" name="parent_id" value="">

    {!! Lte3::text('name', $category->name ?? null, [
        'type' => 'text',
        'max' => '30',
        'label' => 'Enter Name',
        'placeholder' => 'Category Name',
    ]) !!}

    @if(!empty($category))
        @php($attributes = $category->attributes()->pluck('name', 'id')->toArray())

        {!! Lte3::select2('attributes', array_key_first($attributes), $attributes, [
            'label' => 'Attributes',
        ]) !!}
    @endif

    @include('components.metatag', ['item' => isset($category) ? $category : null])

    <button type="submit" class="btn btn-success">
        Submit
    </button>

    <script>
        var urlParams = new URLSearchParams(window.location.search);
        var parentId = urlParams.get('parent_id');
        var parentField = document.querySelector('input[name="parent_id"]');

        if(parentField) {
            parentField.value = parentId;
        }
    </script>

</form>
