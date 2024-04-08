@include('admin.layouts.inc.begin')
<div class="wrapper">
    @includeWhen(config('lte3.view.preloader'), 'admin.layouts.inc.preloader')

    <x-navbar />

    @include('admin.layouts.inc.sidebar')
    <div class="content-wrapper">
        @yield('content')
    </div>
    @include('admin.layouts.inc.footer')
</div>
@include('admin.layouts.inc.end')


