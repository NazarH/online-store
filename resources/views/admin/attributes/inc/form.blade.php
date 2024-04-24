<form action="{{route($route, $attribute->id ?? null)}}" method="POST">
    @csrf

    @if(!empty($put))
        @method('PUT')
    @endif

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

    {!! Lte3::select2('category_ids[]', isset($attribute) ? $attribute->belongsToCategories() : null, $categories ?? null, [
        'label' => 'Categories',
        'multiple' => true,
    ]) !!}

    {!! Lte3::select2('value_ids[]', empty($attribute) ? null : $attribute->pluckValues(), null, [
        'label' => 'Values',
        'multiple' => true,
        'disabled' => true
    ]) !!}

    <button type="submit" class="btn btn-success">
        Submit
    </button>
</form>


