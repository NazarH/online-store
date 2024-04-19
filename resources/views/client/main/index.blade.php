@extends('client.layouts.app')
@section('content')

    <div class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="products-tabs">
                            <div id="tab1" class="tab-pane active">
                                <div class="products-slick" data-nav="#slick-nav-1">
                                    @foreach($products as $product)
                                        <div class="product">
                                            <div class="product-img">
                                                <img src="{{
                                                    !empty($product->images[0])
                                                        ? asset('/storage/products/'.$product->images[0]->name)
                                                        : asset('client/img/product01.png')
                                                  }}"
                                                     alt=""
                                                >
                                                <div class="product-label">
                                                    <span class="new">NEW</span>
                                                </div>
                                            </div>
                                            <div class="product-body">
                                                <p class="product-category">{{$product->category->name}}</p>
                                                <h3 class="product-name product-name-edit">
                                                    <a href="{{route('client.catalog.product', ['c_slug' => $product->category->slug, 'p_slug' => $product->slug])}}">
                                                        {{$product->name}}
                                                    </a>
                                                </h3>
                                                <h4 class="product-price"> {{$product->price}} <del class="product-old-price">{{$product->old_price}}</del></h4>
                                                <div class="product-btns">
                                                    @if(\App\Models\Favorite::search($product)->first() )
                                                        <a href="{{route('client.wishlist.index')}}" class="btn btn-success">In wishlist</a>
                                                    @else
                                                        @if(Auth::user())
                                                            <form action="{{route('client.wishlist.products.store', $product->id)}}" method="POST">
                                                                @csrf
                                                                <button class="add-to-wishlist btn btn-primary" type="submit">
                                                                    <i class="fa fa-heart-o"></i>
                                                                    <span class="tooltipp">add to wishlist</span>
                                                                </button>
                                                            </form>
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                                <div class="add-to-cart">
                                                    @if(\App\Facades\Basket::exist($product))
                                                        <a href="{{route('client.basket.index')}}" class="btn btn-success">In cart</a>
                                                    @else
                                                        <form action="{{route('client.basket.store', $product->id)}}" method="POST">
                                                            @csrf
                                                            <button class="add-to-cart-btn" type="submit">
                                                                <i class="fa fa-shopping-cart"></i>
                                                                add to cart
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <!-- /tab -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>

@endsection
