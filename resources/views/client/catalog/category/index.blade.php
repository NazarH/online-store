@extends('client.layouts.app')
@section('content')
    {{ Breadcrumbs::render('client.catalog.category', $category) }}
    <!-- SECTION -->
    <div class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <!-- ASIDE -->
                <div id="aside" class="col-md-3">
                    <form action="{{ route('client.catalog.category', $category->slug) }}" method="GET">
                        @csrf
                        <!-- aside Widget -->
                        <div class="aside">
                            <h3 class="aside-title">Categories</h3>
                            <div class="checkbox-filter">
                                @foreach(\App\Models\Category::all() as $index => $item)
                                    <div class="input-checkbox">
                                        <input type="checkbox" id="category-{{$index}}" name="category[]" value="{{$item->id}}"
                                            @if(Request::except(['_token']))
                                                @checked(!empty(Request::except(['_token'])['category']) && in_array($item->id, Request::except(['_token'])['category']))
                                            @endif
                                        >
                                        <label for="category-{{$index}}">
                                            <span></span>
                                            {{ $item->name }}
                                            <small>({{$item->products()->count()}})</small>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <!-- /aside Widget -->

                        <!-- aside Widget -->
                        <div class="aside">
                            <h3 class="aside-title">Brand</h3>
                            <div class="checkbox-filter">
                                @foreach(\App\Models\Brand::all() as $index => $brand)
                                    <div class="input-checkbox">
                                        <input type="checkbox" id="brand-{{$index}}" name="brand[]" value="{{$brand->id}}"
                                            @if(Request::except(['_token']))
                                                @checked(!empty(Request::except(['_token'])['brand']) && in_array($brand->id, Request::except(['_token'])['brand']))
                                            @endif
                                        >
                                        <label for="brand-{{$index}}">
                                            <span></span>
                                            {{ $brand->name }}
                                            <small>({{$brand->products()->count()}})</small>
                                        </label>
                                    </div>
                                @endforeach

                            </div>
                        </div>
                        <!-- /aside Widget -->

                        <!-- aside Widget -->
                        <div class="aside">
                            <h3 class="aside-title">Price</h3>
                            <div class="price-filter">
                                <div id="price-slider"></div>
                                <div class="input-number price-min">
                                    <input name="min_price" type="number"
                                           @if(Request::except(['_token']))
                                               value="{{ Request::except(['_token'])['min_price'] }}"
                                           @else
                                               value="{{ round(\App\Models\Product::min('price')) }}"
                                           @endif
                                    >
                                    <span class="qty-up">+</span>
                                    <span class="qty-down">-</span>
                                </div>
                                <span>-</span>
                                <div class="input-number price-max">
                                    <input name="max_price" type="number"
                                           @if(Request::except(['_token']))
                                               value="{{ Request::except(['_token'])['max_price'] }}"
                                           @else
                                               value="{{ round(\App\Models\Product::max('price')) }}"
                                           @endif
                                    >
                                    <span class="qty-up">+</span>
                                    <span class="qty-down">-</span>
                                </div>
                            </div>
                        </div>
                        <!-- /aside Widget -->

                        <div class="aside mt-5">
                            <button type="submit" class="btn btn-success">
                                Submit
                            </button>
                        </div>
                    </form>

                </div>
                <!-- /ASIDE -->

                <!-- STORE -->
                <div id="store" class="col-md-9">

                    <!-- store products -->
                    <div class="row">
                        <!-- product -->
                        @foreach($products as $product)
                            <div class="col-md-4">
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
                                        <p class="product-category">{{$product->category()->first()->name}}</p>
                                        <h3 class="product-name product-name-edit">
                                            <a href="{{route('client.catalog.product', ['c_slug' => $product->category->slug, 'p_slug' => $product->slug])}}">
                                                {{$product->name}}
                                            </a>
                                        </h3>
                                        <h4 class="product-price">{{$product->price}}<del class="product-old-price">
                                            {{$product->old_price}}</del></h4>
                                        <div class="product-btns">
                                            @if(Auth::user()?->selected()->where('product_id', $product->id)->exists())
                                                <a href="{{route('client.wishlist.index')}}" class="btn btn-success">In wishlist</a>
                                            @else
                                                @if(Auth::user())
                                                    <form action="{{route('client.wishlist.store', $product->id)}}" method="POST">
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
                            </div>

                        @endforeach
                        <!-- /product -->

                    </div>
                    <!-- /store products -->

                    <div class="store-filter clearfix">
                        {!! Lte3::pagination($products ?? null) !!}
                    </div>
                </div>
                <!-- /STORE -->
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /SECTION -->
@endsection
