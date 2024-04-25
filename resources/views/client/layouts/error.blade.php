<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        {!!
            \Seo::setGroup(app()->getLocale())
                ->setDefault([
                    'og_site_name' => config('app.name'),
                    'og_url' => URL::full(),
                    'og_locale' => app()->getLocale(),
                ])->renderHtml()
        !!}
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>Electro</title>
        <!-- Bootstrap -->
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
        <!-- Google font -->
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700" rel="stylesheet">
        <!-- Bootstrap -->
        <link type="text/css" rel="stylesheet" href="{{ asset('client/css/bootstrap.min.css') }}"/>
        <!-- Slick -->
        <link type="text/css" rel="stylesheet" href="{{ asset('client/css/slick.css') }}"/>
        <link type="text/css" rel="stylesheet" href="{{ asset('client/css/slick-theme.css') }}"/>
        <!-- nouislider -->
        <link type="text/css" rel="stylesheet" href="{{ asset('client/css/nouislider.min.css') }}"/>
        <!-- Font Awesome Icon -->
        <link rel="stylesheet" href="{{ asset('client/css/font-awesome.min.css') }}">
        <!-- Custom stlylesheets -->
        <link type="text/css" rel="stylesheet" href="{{ asset('client/css/style.css') }}"/>
        <link type="text/css" rel="stylesheet" href="{{ asset('client/css/custom.css') }}"/>
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <!-- Select2 -->
        <script src="{{ asset('client/js/jquery.min.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    </head>
    <body>
        <div class="wrapper">
            @include('client.layouts.inc.error-header')

            <main class="content-wrapper">
                @yield('content')
            </main>

            @include('client.layouts.inc.footer')

        </div>
        <div class="back-ground hidden" id="backForForm"></div>

        <script src="{{ asset('client/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('client/js/slick.min.js') }}"></script>
        <script src="{{ asset('client/js/nouislider.min.js') }}"></script>
        <script src="{{ asset('client/js/jquery.zoom.min.js') }}"></script>
        <script src="{{ asset('client/js/main.js') }}"></script>
    </body>
</html>
