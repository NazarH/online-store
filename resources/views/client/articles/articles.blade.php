@extends('client.layouts.app')
@section('content')
    @foreach($articles as $article)
        @if($article->published_at <= now())
            <div class="single-blog-area blog-style-2wow fadeInUp mt-5 mb-5">
                <div class="row align-items-center">
                    <div class="col-12 col-md-6">
                        <div class="single-blog-thumbnail">

                            <img src="{{$article->mainImage() ? $article->mainImage() : asset('client/img/3.jpg')}}" alt="">
                            <div class="post-date">
                                <a href="#">
                                    {{date('d', strtotime($article->created_at))}}
                                    <span>
                                        {{date('F', strtotime($article->created_at))}}
                                    </span>
                                </a>

                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <!-- Blog Content -->
                        <div class="single-blog-content">
                            @if(\App\Models\Favorite::search($article)->first() )
                                <a href="{{route('client.wishlist.index')}}" class="btn btn-success mb-5">In wishlist</a>
                            @else
                                @if(Auth::user())
                                    <form action="{{route('client.wishlist.articles.store', $article->id)}}" method="POST">
                                        @csrf
                                        <button class="add-to-wishlist btn btn-primary  mb-5" type="submit">
                                            <i class="fa fa-heart-o"></i>
                                            <span class="tooltipp">add to wishlist</span>
                                        </button>
                                    </form>
                                @endif
                            @endif
                            <div class="line"></div>
                            <h4><a href="{{route('client.articles.single', $article->slug)}}" class="post-headline">{{$article->name}}</a></h4>
                            <p>
                                {{ substr($article->text, 0, 196)}}...
                            </p>
                            <div class="post-meta">
                                <p>By <a href="#">{{$article->user()->first()->name }}</a></p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        @endif
    @endforeach
    <div class="store-filter clearfix">
        {!! Lte3::pagination($articles ?? null) !!}
    </div>
@endsection
