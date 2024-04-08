@extends('client.layouts.app')
@section('content')
    <div class="single-blog-wrapper section-padding-0-100">

        <div class="single-blog-area blog-style-2 mb-50">
            <div class="single-blog-thumbnail">
                <img src="{{asset('client/img/b5.jpg')}}" alt="">
                <div class="post-tag-content">
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
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
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <!-- ##### Post Content Area ##### -->
                <div>
                    <!-- Single Blog Area  -->
                    <div class="single-blog-area blog-style-2 mb-50">
                        <!-- Blog Content -->
                        <div class="single-blog-content">
                            <div class="line"></div>
                            <span class="post-tag">{{$article->user()->first()->name}}</span>
                            <h4><a href="#" class="post-headline mb-0">{{$article->name}}</a></h4>
                            <div class="mb-5 mt-5">
                                {!! $article->text !!}
                            </div>
                        </div>
                    </div>

                    <!-- Comment Area Start -->
                    <div id="tab3">
                        @unless(empty(Auth::user()))
                            <form action="{{route('client.comments.store', ['article' => $article])}}"
                                  class="review-form mb-5 d-flex flex-column align-items-center"
                                  method="POST">
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
                        @else
                            <div class="text-center mb-5 mt-5 font-weight-bolder">Авторизуйтесь, щоб залишити коментар!</div>
                        @endunless


                        <div id="reviews" class="d-flex flex-column justify-content-between h-100">
                            @isset($comments)
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
                            @endisset
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ##### Single Blog Area End ##### -->
@endsection
