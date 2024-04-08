@extends('admin.products.inc.filter-wrap')

@section('body')
    {!! Lte3::hidden('type', 'projects') !!} {{-- example hidden field --}}
    <div class="row">
        <div class="col-md-3">
            {!! Lte3::text('name', null, [
                'label' => 'Name',
                'default' => request('name')
            ]) !!}
        </div>
        <div class="col-md-3">
            {!! Lte3::select2('category_id', request('category_id'), $categories, [
                'label' => 'Category',
                'id' => 'status2',
            ]) !!}
        </div>
        <div class="col-md-3">
            <label>
                Price
            </label>
            <div class="d-flex align-items-center">
                <input placeholder='min' type="number" class="form-control" name="min" value="{{request('min')}}">
                <input placeholder='max' type="number" class="form-control ml-2" name="max" value="{{request('max')}}">
            </div>
        </div>
    </div>
@stop
