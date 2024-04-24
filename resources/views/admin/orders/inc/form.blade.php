<form action="{{route($route, $order->id ?? null)}}" method="POST">
    @csrf

    @if(!empty($put))
        @method('PUT')
    @endif

    {!! Lte3::text('name', $order->name ?? null, [
        'type' => 'text',
        'max' => '30',
        'label' => 'Name',
        'placeholder' => 'User Name',
    ]) !!}

    {!! Lte3::text('email', $order->email ?? null, [
        'type' => 'email',
        'max' => '30',
        'label' => 'Email',
        'placeholder' => 'laravel@gmail.com',
    ]) !!}

    {!! Lte3::text('phone', $order->phone ?? null, [
        'type' => 'tel',
        'max' => '13',
        'label' => 'Phone Number',
        'placeholder' => '+380971234567',
    ]) !!}

    {!! Lte3::text('number', $order->number ?? null, [
        'type' => 'number',
        'max' => '30',
        'label' => 'Department',
        'placeholder' => 'Department №',
    ]) !!}

    {!! Lte3::text('location', $order->location ?? null, [
        'type' => 'text',
        'max' => '30',
        'label' => 'Location',
        'placeholder' => 'Location',
    ]) !!}

    {!! Lte3::select2('type', $order->type ?? null, [
        'basket' => 'Basket',
        'order' => 'Order',
    ], [
        'label' => 'Type',
    ]) !!}

    {!! Lte3::select2('status', $order->status ?? null, [
        'expected' => 'Expected',
        'paid' => 'Paid',
    ], [
        'label' => 'Status',
    ]) !!}

    {!! Lte3::select2('payment', $order->payment ?? null, [
        'receiving' => 'Receiving',
        'online' => 'Online',
    ], [
        'label' => 'Payment',
    ]) !!}

    <button type="submit" class="btn btn-success">
        Submit
    </button>
</form>
