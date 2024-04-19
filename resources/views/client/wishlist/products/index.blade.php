@extends('client.layouts.app')
@section('content')
    <div class="row">
        <!-- product -->
        @foreach($favorites as $item)
            <div class="col-md-4">
                <div class="product">
                    <div class="product-img">
                        <img src="{{asset('client/img/product01.png')}}" alt="">
                        <div class="product-label">
                            <span class="new">NEW</span>
                        </div>
                    </div>
                    <div class="product-body">
                        <p class="product-category">{{$item->product->category()->first()->name}}</p>
                        <h3 class="product-name product-name-edit">
                            <a href="{{route('client.catalog.product', ['c_slug' => $item->product->category->slug, 'p_slug' => $item->product->slug])}}">
                                {{$item->product->name}}
                            </a>
                        </h3>
                        <h4 class="product-price">{{$item->product->price}}<del class="product-old-price">
                                {{$item->product->old_price}}</del></h4>
                        <div class="product-btns">
                            <form action="{{route('client.wishlist.products.store', $item->product->id)}}" method="POST">
                                @csrf
                                @method('delete')
                                <button class="add-to-cart-btn btn btn-danger" type="submit">Delete</button>
                            </form>
                        </div>
                    </div>
                    @unless(\App\Facades\Basket::exist($item->product))
                        <div class="add-to-cart">
                            <form action="{{route('client.basket.store', $item->product->id)}}" method="POST">
                                @csrf
                                <button class="add-to-cart-btn" type="submit">
                                    <i class="fa fa-shopping-cart"></i>
                                    add to cart
                                </button>
                            </form>
                        </div>
                    @endunless
                </div>
            </div>
        @endforeach
        <!-- /product -->

    </div>

    <div class="store-filter clearfix">
        {!! Lte3::pagination($products ?? null) !!}
    </div>
@endsection
