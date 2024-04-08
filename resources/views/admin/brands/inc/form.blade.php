<form action="{{route($route, $brand->id ?? null)}}" method="POST">
    @csrf

    {!! Lte3::text('name', $brand->name ?? null, [
        'type' => 'text',
        'max' => '30',
        'label' => 'Enter Name',
        'placeholder' => 'Brand Name',
    ]) !!}

    <button type="submit" class="btn btn-success">
        Submit
    </button>
</form>
