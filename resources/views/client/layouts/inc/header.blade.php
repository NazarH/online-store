<header>
    <!-- TOP HEADER -->
    <div id="top-header">
        <div class="container">
            <ul class="header-links pull-left">
                <li><a href="#"><i class="fa fa-envelope-o"></i> hello@example.com </a></li>
                <a href="{{route('feedback.index')}}" class="btn btn-info">Feedback</a>
            </ul>
            <ul class="header-links pull-right">
                <li><a href="#"><i class="fa fa-dollar"></i> USD</a></li>
                @guest
                    @if (Route::has('login'))
                        <li class="nav-item">
                            <a id="showLoginModal" class="nav-link" href="#">{{ __('Login') }}</a>
                        </li>
                    @endif

                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a id="showRegisterModal" class="nav-link" href="#">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item">
                        <a id="navbarDropdown" class="nav-link" href="{{ route('client.personal.index') }}" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            <i class="fa fa-user-o"></i>
                            My Account
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <div aria-labelledby="navbarDropdown">

                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                                <i class="far fa-door-closed"></i>
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
                @can('view', auth()->user())
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.home') }}">Admin</a>
                    </li>
                @endcan
            </ul>
        </div>
    </div>
    <!-- /TOP HEADER -->

    <!-- MAIN HEADER -->
    <div id="header">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <!-- LOGO -->
                <div class="col-md-3">
                    <div class="header-logo">
                        <a href="/" class="logo">
                            <img src="{{asset('client/img/logo.png')}}" alt="">
                        </a>
                    </div>
                </div>
                <!-- /LOGO -->

                <!-- SEARCH BAR -->
                <div class="col-md-6">
                    <div class="header-search">
                        <form action="{{route('client.search')}}" method="GET">
                            @csrf
                            <input name="search" class="input input-select" placeholder="Search here">
                            <button class="search-btn" type="submit">
                                Search
                            </button>
                        </form>
                    </div>
                </div>
                <!-- /SEARCH BAR -->

                <!-- ACCOUNT -->
                <div class="col-md-3 clearfix">
                    <div class="header-ctn">
                        @guest
                        @else
                            <div>
                                <a href="{{route('client.wishlist.index')}}">
                                    <i class="fa fa-heart-o"></i>
                                    <span>Your Wishlist</span>
                                    <div class="qty">{{ \App\Models\Favorite::where('user_id', Auth::user()->id)->count() }}</div>
                                </a>
                            </div>
                        @endguest

                        <div>
                            <a href="{{route('client.basket.index')}}">
                                <i class="fa fa-shopping-cart"></i>
                                <span>Your Cart</span>
                                <div class="qty">{{ \App\Models\Order::where('key', '=', Cookie::get('key'))->first()?->products()->count() }}</div>
                            </a>
                        </div>

                        <!-- Menu Toogle -->
                        <div class="menu-toggle">
                            <a href="#">
                                <i class="fa fa-bars"></i>
                                <span>Menu</span>
                            </a>
                        </div>
                        <!-- /Menu Toogle -->
                    </div>
                </div>

                <!-- /ACCOUNT -->
            </div>
            <!-- row -->
        </div>
        <!-- container -->
    </div>
    <!-- /MAIN HEADER -->

    <!-- NAVIGATION -->
    <nav id="navigation">
        <!-- container -->
        <div class="container">
            <!-- responsive-nav -->
            <div id="responsive-nav">
                <!-- NAV -->
                <ul class="main-nav nav d-flex justify-content-center">
                    <li><a href="{{route('client.catalog.index')}}">Catalog</a></li>
                    <li><a href="{{route('client.articles.index')}}">Articles</a></li>
                </ul>
                <!-- /NAV -->
            </div>
            <!-- /responsive-nav -->
        </div>
        <!-- /container -->
    </nav>
    <!-- /NAVIGATION -->
</header>
