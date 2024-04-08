<form action="{{route($route, $attribute->id ?? null)}}" method="POST">
    @csrf

    {!! Lte3::text('name', $attribute->name ?? null, [
        'type' => 'text',
        'max' => '30',
        'label' => 'Enter Name',
        'placeholder' => 'Attribute Name',
    ]) !!}

    @if(!empty($attribute))
        @php($properties = $attribute->properties()->pluck('value', 'id')->toArray())

        {!! Lte3::select2('category_ids', '', $properties,[
            'label' => 'All Properties',
        ]) !!}
    @else
        {!! Lte3::text('value', null, [
            'type' => 'text',
            'max' => '30',
            'label' => 'Enter Value',
            'placeholder' => 'Attribute Value',
        ]) !!}
    @endif

    {!! Lte3::select2('category_ids[]', empty($attribute) ? null : $attribute->belongsToCategories(), $categories ?? null, [
        'label' => 'Categories',
        'multiple' => true,
    ]) !!}

    <button type="submit" class="btn btn-success">
        Submit
    </button>
</form>
