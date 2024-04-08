<form action="{{route($route, $lead->id ?? null)}}" method="POST">
    @csrf

    {!! Lte3::select2('type', $lead->type ?? null, [
            'feedback' => 'Feedback',
            'subscription' => 'Subscription',
            'callback' => 'Callback',
        ], [
            'label' => 'Type',
    ]) !!}

    {!! Lte3::text('user_id', $lead->user_id ?? null, [
        'type' => 'number',
        'label' => 'Enter User ID',
        'placeholder' => 'User ID',
    ]) !!}

    <button type="submit" class="btn btn-success">
        Submit
    </button>
</form>
