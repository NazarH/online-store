@extends('client.layouts.app')
@section('content')
    <div class="row mt-5">
        <div class="col">
            <a href="{{ route('client.wishlist.products') }}" class="btn btn-primary btn-lg btn-block">Products</a>
        </div>
        <div class="col">
            <a href="{{ route('client.wishlist.articles') }}" class="btn btn-primary btn-lg btn-block">Articles</a>
        </div>
    </div>


    <div class="store-filter clearfix">
        {!! Lte3::pagination($products ?? null) !!}
    </div>
@endsection
