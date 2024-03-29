<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@if (!empty($meta_title)) {{ $meta_title }} @else Accueil | E-Master @endif </title>
    @if (!empty($meta_description))
    <meta name="description" content="{{ $meta_description }}">
    @endif
    @if (!empty($meta_keywords))
    <meta name="meta_keywords" content="{{ $meta_keywords }}">
    @endif
    @yield('stripe-js')
   
    <link href="{{ asset('css/frontend_css/bootstrap.min.css') }}" rel="stylesheet">
    {{-- <link href="{{ asset('css/frontend_css/font-awesome.min.css') }}" rel="stylesheet"> --}}
    <link href="{{ asset('css/frontend_css/prettyPhoto.css') }}" rel="stylesheet">
    <link href="{{ asset('css/frontend_css/price-range.css') }}" rel="stylesheet">
    <link href="{{ asset('css/frontend_css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('css/frontend_css/easyzoom.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('css/frontend_css/responsive.css') }}" rel="stylesheet">
    <link href="{{ asset('css/frontend_css/passtrength.css') }}" rel="stylesheet">
    <link href="{{ asset('css/frontend_css/algolia.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/instantsearch.js@2.6.0/dist/instantsearch.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/instantsearch.js@2.6.0/dist/instantsearch-theme-algolia.min.css">
    <script src="{{ asset('js/frontend_js/jquery.js') }}"></script>
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
    <link rel="shortcut icon" href="{{ asset('images/frontend_images/ico/favicon.ico') }}">
    <link rel="apple-touch-icon-precomposed" sizes="144x144"
        href="{{ asset('images/frontend_images/apple-touch-icon-144-precomposed.png') }}">
    <link rel="apple-touch-icon-precomposed" sizes="114x114"
        href="{{ asset('images/frontend_images/apple-touch-icon-114-precomposed.png') }}">
    <link rel="apple-touch-icon-precomposed" sizes="72x72"
        href="{{ asset('images/frontend_images/apple-touch-icon-72-precomposed.png') }}">
    <link rel="apple-touch-icon-precomposed"
        href="{{ asset('images/frontend_images/apple-touch-icon-57-precomposed.png') }}">
    <script type='text/javascript' src='https://platform-api.sharethis.com/js/sharethis.js#property=5f8dd08afbf397001368c12c&product=inline-share-buttons' async='async'></script>
</head>
<!--/head-->

<body>
    <div id="app">
        @include('layouts.frontLayout.front_header')

        @yield('content')

        @include('layouts.frontLayout.front_footer')
    </div>

    <script src="{{ asset('js/frontend_js/jquery.js') }}"></script>
    <script src="{{ asset('js/frontend_js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/frontend_js/jquery.scrollUp.min.js') }}"></script>
    <script src="{{ asset('js/frontend_js/price-range.js') }}"></script>
    <script src="{{ asset('js/frontend_js/jquery.prettyPhoto.js') }}"></script>
    <script src="{{ asset('js/frontend_js/easyzoom.js') }}"></script>
    <script src="{{ asset('js/frontend_js/jquery.validate.js') }}"></script>
    <script src="{{ asset('js/frontend_js/passtrength.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    @yield('extra-js')
    <script src="https://cdn.jsdelivr.net/algoliasearch/3/algoliasearch.min.js"></script>
    <script src="https://cdn.jsdelivr.net/autocomplete.js/0/autocomplete.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/instantsearch.js@2.6.0"></script>
    <script src="{{ asset('js/frontend_js/algolia.js') }}"></script>
    <script src="{{ asset('js/frontend_js/algolia-instantsearch.js') }}"></script>

</body>

</html>