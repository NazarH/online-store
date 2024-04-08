@extends('client.layouts.app')
@section('content')
    <h1 class="text-center mt-5">Політика конфіденційності</h1>
    <div class="d-flex justify-content-center mb-5">
        <img src="{{asset('client/img/policy.jpeg')}}" class="w-50" alt="">
    </div>
    <div class="mb-5">
        {!! $page->text !!}
    </div>

@endsection
