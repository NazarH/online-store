<!-- Navbar -->
<nav class="main-header navbar navbar-expand {{config('lte3.view.dark_mode') ? 'dark-mode' : 'navbar-white navbar-light'}}">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>

        <li class="nav-item dropdown">
            <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
               class="nav-link dropdown-toggle"><i class="far fa-clock"></i></a>
            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow"
                style="left: 0px; right: inherit;">
                <li><a href="#" class="dropdown-item">UTC: {{ now()->timezone(config('app.timezone')) }} </a></li>
                @if(config('app.timezone_client'))
                    <li><a href="#" class="dropdown-item">{{ config('app.timezone_client') }}: {{ now()->timezone(config('app.timezone_client')) }}</a>
                    </li>
                @endif
            </ul>
        </li>
    </ul>

    <ul class="navbar-nav">
        @foreach($currencies as $item)
            <div class="mr-3">
                <b>{{$item['currency']}}</b> : {{$item['saleRate']}}
            </div>
        @endforeach
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Navbar Search -->
        <li class="nav-item">
            <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                <i class="fas fa-search"></i>
            </a>
            <div class="navbar-search-block">
                <form class="form-inline">
                    <div class="input-group input-group-sm">
                        <input class="form-control form-control-navbar" type="search" placeholder="Search"
                               aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-navbar" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                            <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </li>


        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-bell"></i>
                <span class="badge badge-warning navbar-badge">0</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <span class="dropdown-item dropdown-header">0 Notifications</span>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-envelope mr-2"></i>
                    <span class="float-right text-muted text-sm"></span>
                </a>

            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-widget="control-sidebar" data-controlsidebar-slide="true" href="#" role="button">
                <i class="fas fa-th-large"></i>
            </a>
        </li>

        @auth
        <li class="nav-item dropdown user-menu">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                <img src="/vendor/adminlte/dist/img/user2-160x160.jpg" class="user-image img-circle elevation-2"
                     alt="User Image">
                <span class="d-none d-md-inline">{{ Lte3::user('name') }}</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <!-- User image -->
                <li class="user-header bg-primary">
                    <img src="/vendor/adminlte/dist/img/user2-160x160.jpg" class="img-circle elevation-2"
                         alt="User Image">

                    <p>
                        {{ Lte3::user('name') }}
                        <small>Created {{ Lte3::user('created_at') }}</small>
                    </p>
                </li>
                <!-- Menu Footer-->
                <li class="user-footer">
                    <a href="{{route('client.personal.index')}}" class="btn btn-default btn-flat" target="_blank">Profile</a>
                    <a href="/" class="btn btn-default btn-flat">Home</a>
                    <a href="/logout" class="btn btn-default btn-flat float-right js-click-submit"
                       data-confirm="Logout?">Sign out</a>
                </li>
            </ul>
        </li>
        @else
        <li class="nav-item">
            <a href="/logout" class="nav-link js-click-submit" data-confirm="Logout?" role="button">
                <i class="fa fa-sign-out-alt"></i>
            </a>
        </li>
        @endauth
    </ul>
</nav>
<!-- /.navbar -->
