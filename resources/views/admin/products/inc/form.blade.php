@if(!empty($product->images[0]))
    <div class="d-flex mb-5">
        @foreach($product->media as $image)
            <form action="{{route('admin.products.image.delete', $image->id)}}" method="POST" class="d-flex flex-column">
                @csrf
                @method('delete')
                <img src="{{ asset('storage/products/'.$image->file_name) }}" alt="" class="mr-5 ml-5 mb-3" style="width: 150px; height: 150px;">
                <button type="submit" class="btn btn-danger align-self-center">Delete</button>
            </form>
        @endforeach
    </div>
@endif

<form action="{{route($route, $product->id ?? null)}}" method="POST" enctype="multipart/form-data">
    @csrf
    {!! Lte3::mediaFile('images', isset($product) ? $product : null, [
            'label' => 'Зображення',
            'multiple' => true,
            'is_image' => true,
        ]) !!}

    {!! Lte3::text('name', $product->name ?? null, [
        'type' => 'text',
        'max' => '30',
        'label' => 'Enter name',
    ]) !!}

    @if(!empty($category))
        {!! Lte3::select2("category_id", '', [
            $category->id => $category->name
        ], [
           'label' => 'Category name',
        ]) !!}
    @else
        @if(!empty($product->category))
            {!! Lte3::select2("category_id", '', [
                $product->category->id => $product->category->name
            ], [
               'label' => 'Category name',
            ]) !!}
        @endif
    @endif

    {!! Lte3::select2('brand_id', $product->brand_id ?? null, $brands, [
        'label' => 'Choose brand:',
    ]) !!}

    @if(!empty($attributes))
        @if(!empty($product))
            @foreach($product->properties as $property)
                @foreach($attributes as $attribute)
                    @if($property->attribute_id === $attribute->id)
                        @php($properties = $attribute->properties()->pluck('value', 'id')->toArray())

                        {!! Lte3::select2("properties[{$attribute->id}]", $property->id ?? null, $properties, [
                            'label' => $attribute->name,
                        ]) !!}
                    @endif
                @endforeach
            @endforeach
        @else
            @foreach($attributes as $attribute)
                @php($properties = $attribute->properties()->pluck('value', 'id')->toArray())

                {!! Lte3::select2("properties[{$attribute->id}]", '', $properties, [
                    'label' => $attribute->name,
                ]) !!}
            @endforeach
        @endif
    @endif

    <div class="form-inline justify-content-center">
        {!! Lte3::text('price', $product->price ?? null, [
            'type' => 'number',
            'placeholder' => 'Enter price',
            'label' => '',
            'class' => 'mr-3 mb-3',
        ]) !!}

        {!! Lte3::text('old_price', $product->old_price ?? null, [
                'type' => 'number',
                'placeholder' => 'Enter old price',
                'label' => '',
                'class' => 'mr-3 mb-3'
            ]) !!}

        {!! Lte3::text('count', $product->count ?? null, [
            'type' => 'number',
            'placeholder' => 'Enter count',
            'label' => '',
            'class' => 'mr-3 mb-3'
        ]) !!}
    </div>

    <HR>

    @include('components.metatag', ['item' => isset($product) ? $product : null])

    <div class="text-center">
        <button type="submit" class="btn btn-success d-block mx-auto">
            Submit
        </button>
    </div>

</form>


