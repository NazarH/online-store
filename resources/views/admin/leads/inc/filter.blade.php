@extends('admin.products.inc.filter-wrap')

@section('body')
    {!! Lte3::hidden('type', 'projects') !!}
    <div class="row">
        <div class="col-md-3">
            {!! Lte3::text('user_id', null, [
                'label' => 'Search email',
                'default' => request('name')
            ]) !!}
        </div>

        <div class="col-md-3">
            {!! Lte3::select2('type_of_lead', 'subscription', [
                'subscription' => 'Subscription',
                'callback' => 'Callback',
                'feedback' => 'Feedback'
            ], [
                'label' => 'Type',
                'id' => 'type'
            ]) !!}
        </div>
    </div>
@stop
