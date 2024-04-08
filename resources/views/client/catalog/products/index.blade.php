@extends('client.layouts.app')
@section('content')
    <div id="breadcrumb" class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <div class="col-md-12">
                    <ul class="breadcrumb-tree">
                        <li><a href="/">Home</a></li>
                        <li><a href="#">All Categories</a></li>
                    </ul>
                </div>
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <div class="section">
        <div class="container">
            <div class="row">
                <div class="col-md-5 col-md-push-2">
                    <div id="product-main-img">
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
                    </div>
                </div>

                <div class="col-md-2  col-md-pull-5">
                    <div id="product-imgs">
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
                    </div>
                </div>

                <div class="col-md-5">
                    <div class="product-details">
                        <h2 class="product-name">{{$product->name}} ({{$product->article}})</h2>
                        <div>
                            {{ count($comments) }} Review(s)
                        </div>
                        <div>
                            <h3 class="product-price">$980.00 <del class="product-old-price">$990.00</del></h3>
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
@endsection
