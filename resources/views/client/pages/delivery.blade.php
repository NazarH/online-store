@extends('client.layouts.app')
@section('content')
    <h1 class="text-center mt-5">Доставка</h1>
    <div class="d-flex justify-content-center mb-5">
        <img src="{{asset('client/img/delivery.jpeg')}}" alt="" class="w-75">
    </div>
    <div class="mb-5">
        {!! $page->text !!}
    </div>
@endsection
