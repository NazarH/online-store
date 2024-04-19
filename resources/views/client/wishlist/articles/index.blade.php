@extends('client.layouts.app')
@section('content')
    <div class="row">
        <!-- articles -->
        @foreach($favorites as $item)
            <div class="single-blog-area blog-style-2wow fadeInUp mt-5 mb-5">
                <div class="row align-items-center">
                    <div class="col-12 col-md-6">
                        <div class="single-blog-thumbnail">
                            <img src="{{asset('client/img/3.jpg')}}" alt="">
                            <div class="post-date">
                                <a href="#">
                                    {{date('d', strtotime($item->article->created_at))}}
                                    <span>
                                {{date('F', strtotime($item->article->created_at))}}
                            </span>
                                </a>

                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <!-- Blog Content -->
                        <div class="single-blog-content">
                            <form action="{{route('client.wishlist.articles.store',  $item->article->id)}}" method="POST">
                                @csrf
                                @method('delete')
                                <button class="add-to-cart-btn btn btn-danger mb-5" type="submit">Delete</button>
                            </form>
                            <div class="line"></div>
                            <h4><a href="{{route('client.articles.single', $item->article->slug)}}" class="post-headline">{{$item->article->name}}</a></h4>
                            <p>
                                {{ substr($item->article->text, 0, 196)}}...
                            </p>
                            <div class="post-meta">
                                <p>By <a href="#">{{$item->article->user()->first()->name }}</a></p>
                            </div>
                        </div>
                    </div>
            </div>
        @endforeach
        <!-- /product -->


    </div>

    <div class="store-filter clearfix">
        {!! Lte3::pagination($products ?? null) !!}
    </div>
@endsection
