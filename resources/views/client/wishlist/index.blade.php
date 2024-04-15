@extends('client.layouts.app')
@section('content')
    <div class="row">
        <!-- product -->
        @foreach($products as $product)
            <div class="col-md-4">
                <div class="product">
                    <div class="product-img">
                        <img src="{{asset('client/img/product01.png')}}" alt="">
                        <div class="product-label">
                            <span class="new">NEW</span>
                        </div>
                    </div>
                    <div class="product-body">
                        <p class="product-category">{{$product->category()->first()->name}}</p>
                        <h3 class="product-name product-name-edit">
                            <a href="{{route('client.catalog.product', ['c_slug' => $product->category->slug, 'p_slug' => $product->slug])}}">
                                {{$product->name}}
                            </a>
                        </h3>
                        <h4 class="product-price">{{$product->price}}<del class="product-old-price">
                                {{$product->old_price}}</del></h4>
                        <div class="product-btns">
                            <form action="{{route('client.wishlist.delete', $product->id)}}" method="POST">
                                @csrf
                                @method('delete')
                                <button class="add-to-cart-btn btn btn-danger" type="submit">Delete</button>
                            </form>
                        </div>
                    </div>
                    @unless(\App\Facades\Basket::exist($product))
                        <div class="add-to-cart">
                            <form action="{{route('client.basket.store', $product->id)}}" method="POST">
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
