@extends('client.layouts.app')
@section('content')
    <h1 class="text-center mt-5">Про нас</h1>
    <div class="d-flex justify-content-center">
        <img src="{{asset('client/img/about.jpeg')}}" class="" alt="">
    </div>
    <div class="mb-5">
        {!! $page->text !!}
    </div>
@endsection
