@extends('client.layouts.app')
@section('content')
    {{ Breadcrumbs::render('client.catalog.category', $product->category()->first()) }}
    <div class="section">
        <div class="container">
            <div class="row">
                <div class="col-md-5 col-md-push-2">
                    <div id="product-main-img">
                        @if(!empty($product->images[0]))
                            @foreach($product->images as $image)
                                <div class="product-preview">
                                    <img src="{{asset('/storage/products/'.$image->name)}}" alt="">
                                </div>
                            @endforeach
                        @else
                            <div class="product-preview">
                                <img src="/client/img/product01.png" alt="">
                            </div>

                            <div class="product-preview">
                                <img src="/client/img/product03.png" alt="">
                            </div>

                            <div class="product-preview">
                                <img src="/client/img/product06.png" alt="">
                            </div>

                            <div class="product-preview">
                                <img src="/client/img/product08.png" alt="">
                            </div>
                        @endif

                    </div>
                </div>

                <div class="col-md-2  col-md-pull-5">
                    <div id="product-imgs">
                        @if(!empty($product->images[0]))
                            @foreach($product->images as $image)
                                <div class="product-preview">
                                    <img src="{{asset('/storage/products/'.$image->name)}}" alt="">
                                </div>
                            @endforeach
                        @else
                            <div class="product-preview">
                                <img src="/client/img/product01.png" alt="">
                            </div>

                            <div class="product-preview">
                                <img src="/client/img/product03.png" alt="">
                            </div>

                            <div class="product-preview">
                                <img src="/client/img/product06.png" alt="">
                            </div>

                            <div class="product-preview">
                                <img src="/client/img/product08.png" alt="">
                            </div>
                        @endif
                    </div>
                </div>

                <div class="col-md-5">
                    <div class="product-details">
                        <h2 class="product-name">{{$product->name}} ({{$product->article}})</h2>
                        <div>
                            {{ count($comments) }} Review(s)
                        </div>
                        <div>
                            <h3 class="product-price">UAH {{$product->price}} <del class="product-old-price">{{$product->old_price}}</del></h3>
                            <span class="product-available">
                                @if($product->count)
                                    {{$product->count}} In Stock
                                @else
                                    Not available
                                @endif
                            </span>
                        </div>

                        @if($product->count)
                            <div class="add-to-cart">
                                <div class="qty-label">
                                    Qty
                                    <div class="input-number">
                                        <input type="number" value="1" max="{{$product->count}}">
                                        <span class="qty-up">+</span>
                                        <span class="qty-down">-</span>
                                    </div>
                                </div>
                                <button class="add-to-cart-btn"><i class="fa fa-shopping-cart"></i> add to cart</button>
                            </div>
                        @endif

                        <ul class="product-links">
                            <li>Category:</li>
                            <li>
                                <a href="#">{{$product->category->name}}</a>
                            </li>

                        </ul>

                    </div>
                </div>

                <div class="col-md-12">
                    <div id="product-tab">
                        <ul class="tab-nav">
                            <li><a data-toggle="tab" href="#tab2">Details</a></li>
                            <li><a data-toggle="tab" href="#tab3">Reviews ({{ count($comments) }})</a></li>
                        </ul>

                        <div class="tab-content">
                            <div id="tab2" class="tab-pane fade in active">
                                <div class="row">
                                    <div class="col-md-12">

                                        <ul class="list-group">
                                            @foreach($product->properties as $property)
                                                <li class="list-group-item">
                                                    <div class="row">
                                                        <div class="col">
                                                            <strong>{{ $property->attribute()->first()->name }}: </strong>
                                                        </div>
                                                        <div class="col">
                                                            {{$property->value}}
                                                        </div>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>

                                    </div>
                                </div>
                            </div>

                            <div id="tab3" class="tab-pane fade in">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div id="reviews" class="d-flex flex-column justify-content-between h-100">
                                            @foreach($comments as $comment)
                                                <ul class="reviews">
                                                    <li>
                                                        <div class="review-heading">
                                                            <h5 class="name">{{$comment->name}}</h5>
                                                            <p class="date">{{$comment->created_at}}</p>
                                                        </div>
                                                        <div class="review-body">
                                                            <p>
                                                                {{$comment->text}}
                                                            </p>
                                                        </div>
                                                    </li>
                                                </ul>
                                            @endforeach

                                            <div class="store-filter clearfix">
                                                {!! Lte3::pagination($comments ?? null) !!}
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-md-6">
                                        <div id="review-form">
                                            <form action="{{route('client.reviews.store', ['product' => $product])}}" class="review-form" method="POST">
                                                @csrf
                                                <input name="name"
                                                       class="input"
                                                       type="text"
                                                       placeholder="Your Name"
                                                       value="{{Auth::user() ? Auth::user()->name : ''}}"
                                                >
                                                <input name="email"
                                                       class="input"
                                                       type="email"
                                                       placeholder="Your Email"
                                                       value="{{Auth::user() ? Auth::user()->email : ''}}"
                                                >
                                                <textarea name="text" class="input" placeholder="Your Review" maxlength="255"></textarea>
                                                <button class="primary-btn">Submit</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">

                <div class="col-md-12">
                    <div class="section-title text-center">
                        <h3 class="title">Similar Products</h3>
                    </div>
                </div>

                @foreach($product->category()->first()->products()->take(4)->get() as $item)
                    @unless(\App\Facades\Basket::exist($item))
                        <div class="col-md-3 col-xs-6">
                            <div class="product">
                                <div class="product-img">
                                    <img src="{{asset('client/img/product01.png')}}" alt="">
                                    <div class="product-label">
                                        <span class="sale">{{ round(((($item->price - $item->old_price) / $item->old_price) * 100)) }}%</span>
                                    </div>
                                </div>
                                <div class="product-body">
                                    <p class="product-category">{{$product->category()->first()->name}}</p>
                                    <h3 class="product-name product-name-edit">
                                        <a href="{{route('client.catalog.product', ['c_slug' => $item->category->slug, 'p_slug' => $item->slug])}}">
                                            {{$item->name}}
                                        </a>
                                    </h3>
                                    <h4 class="product-price">{{  $item->price }} <del class="product-old-price">{{  $item->old_price }}</del></h4>
                                    <div class="product-rating">
                                    </div>
                                    <div class="product-btns">
                                        @if(Auth::user()?->selected()->where('product_id', $item->id)->exists())
                                            <a href="{{route('client.wishlist.index')}}" class="btn btn-success">In wishlist</a>
                                        @else
                                            @if(Auth::user())
                                                <form action="{{route('client.wishlist.store', $item->id)}}" method="POST">
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
                                        @if(\App\Facades\Basket::exist($item))
                                            <a href="{{route('client.basket.index')}}" class="btn btn-success">In cart</a>
                                        @else
                                            <form action="{{route('client.basket.store', $item->id)}}" method="POST">
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
                    @endunless
                @endforeach

                <div class="clearfix visible-sm visible-xs"></div>


            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
@endsection
