@extends('client.layouts.app')
@section('content')
    <div id="breadcrumb" class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <div class="col-md-11">
                    <h3 class="breadcrumb-header">BASKET</h3>
                    <ul class="breadcrumb-tree">
                        <li><a href="/">Home</a></li>
                        <li class="active">Basket</li>
                    </ul>
                </div>
                @unless(empty(Cookie::get('key')))
                    <div class="col-md-1">
                        <a href="{{route('client.order.index', Cookie::get('key'))}}" class="btn btn-success">
                            <i class="fa fa-shopping-cart"></i>
                            To order
                        </a>
                    </div>
                @endunless
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    @unless(empty(Cookie::get('key')))
        <div class="row">
            <!-- product -->
            @foreach($products as $product)
                @php($count = \App\Facades\Basket::count($order->id, $product->id))
                <div class="col-md-4">
                    <div class="product">
                        <div class="product-img">
                            <img src="{{asset('client/img/product01.png')}}" alt="">
                        </div>
                        <div class="product-body">
                            <p class="product-category">{{$product->category()->first()->name}}</p>
                            <h3 class="product-name product-name-edit">
                                <a href="{{route('client.catalog.product', ['c_slug' => $product->category->slug, 'p_slug' => $product->slug])}}">
                                    {{$product->name}}
                                </a>
                            </h3>
                            <h4 class="product-price">UAH {{$product->price * $count}}</h4>
                            <div class="product-btns">
                                <form action="{{route('client.basket.update', $product->id)}}"
                                      class="d-flex align-items-center justify-content-center product-form"
                                      method="POST"
                                >
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{$product->id}}">
                                    <button class="subtract btn btn-danger" type="submit">
                                        -
                                    </button>
                                    <input type="number"
                                           name="count"
                                           class="input-text qty text count"
                                           value="{{$count}}"
                                           id="count_{{$product->id}}"
                                           min="1"
                                    >
                                    <button class="add btn btn-success" type="submit">
                                        +
                                    </button>
                                </form>
                                <form action="{{route('client.basket.delete', $product->id)}}" method="POST">
                                    @csrf
                                    @method('delete')
                                    <button class="add-to-cart-btn btn btn-danger" type="submit">Видалити</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script>
                $(document).ready(function(){
                    $('.add').click(function(){
                        var $form = $(this).closest('.product-form');
                        var productId = $form.find('input[name="product_id"]').val();
                        var $countInput = $form.find('input[id="count_' + productId + '"]');
                        var value = parseInt($countInput.val()) || 0;
                        $countInput.val(value + 1);
                    });

                    $('.subtract').click(function(){
                        var $form = $(this).closest('.product-form');
                        var productId = $form.find('input[name="product_id"]').val();
                        var $countInput = $form.find('input[id="count_' + productId + '"]');
                        var value = parseInt($countInput.val()) || 0;
                        if (value > 1) {
                            $countInput.val(value - 1);
                        }
                    });
                });
            </script>


            <!-- /product -->

        </div>
    @endunless


    <div class="store-filter clearfix">
        {!! Lte3::pagination($products ?? null) !!}
    </div>
@endsection
