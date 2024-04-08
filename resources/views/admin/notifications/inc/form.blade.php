<form action="{{route($route, $notification->id ?? null)}}" method="POST">
    @csrf

    {!! Lte3::select2('type', null, [
            'subscription' => 'Subscription',
        ], [
            'label' => 'Type',
    ]) !!}

    {!! Lte3::text('topic', $notification->topic ?? null, [
        'type' => 'text',
        'max' => '30',
        'label' => 'Enter Name',
        'placeholder' => 'Brand Name',
    ]) !!}

    {!! Lte3::textarea('text', $notification->text ?? null, [
        'label' => 'Text of article',
        'class' => 'f-cke-full',
    ]) !!}

    {!! Lte3::datetimepicker('notification_date', $notification->notification_date ?? now(), [
        'label' => 'Datetime (If needed)',
        'format' => 'Y-m-d H:i:s',
    ]) !!}

    <button type="submit" class="btn btn-success">
        Submit
    </button>
</form>
