@extends('admin.products.inc.filter-wrap')

@section('body')
    {!! Lte3::hidden('type', 'projects') !!} {{-- example hidden field --}}
    <div class="row">
        <div class="col-md-3">
            {!! Lte3::text('name', request('name'), [
                'type' => 'text',
                'label' => 'Name'
            ]) !!}
        </div>
        <div class="col-md-3">
            {!! Lte3::text('email', request('email'), [
                'type' => 'email',
                'label' => 'Email'
            ]) !!}
        </div>
        <div class="col-md-3">
            {!! Lte3::select2('role', request('role'), [
                'client' => 'client',
                'admin' => 'admin',
            ], [
                'label' => 'Role',
                'multiple' => true
            ]) !!}
        </div>
        <div class="col-md-3">
            {!! Lte3::datepicker('created_at', null, [
                'label' => 'Registered At',
                'format' => 'Y-m-d',
                'value' => null,
                'default' => '',
            ]) !!}
        </div>
    </div>
@stop
