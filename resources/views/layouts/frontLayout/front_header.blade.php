<?php
use App\Http\Controllers\Controller;
use App\Product;
$mainCategories = Controller::mainCategories();
$cartCount = Product::cartCount();
?>

<header id="header">
    <!--header-->
    <div class="header_top">
        <!--header_top-->
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="contactinfo">
                        <ul class="nav nav-pills">
                            <li><a href="#"><i class="fa fa-phone"></i> +2 95 01 88 821</a></li>
                            <li><a href="#"><i class="fa fa-envelope "></i> info@domain.com</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="social-icons pull-right">
                        <ul class="nav navbar-nav">
                            <li><a href="#"><i class="fab fa-facebook"></i></a></li>
                            <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                            <li><a href="#"><i class="fab fa-linkedin"></i></a></li>
                            <li><a href="#"><i class="fab fa-dribbble"></i></a></li>
                            <li><a href="#"><i class="fab fa-google-plus"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/header_top-->

    <div class="header-middle">
        <!--header-middle-->
        <div class="container">
            <div class="row">
                <div class="col-sm-4">
                    <div class="logo pull-left">
                        <a href="index.html"><img src="images/home/logo.png" alt="" /></a>
                    </div>
                    <div class="btn-group pull-right">
                        <div class="btn-group">
                            <button type="button" class="btn btn-default dropdown-toggle usa" data-toggle="dropdown">
                                USA
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a href="#">Canada</a></li>
                                <li><a href="#">UK</a></li>
                            </ul>
                        </div>

                        <div class="btn-group">
                            <button type="button" class="btn btn-default dropdown-toggle usa" data-toggle="dropdown">
                                DOLLAR
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a href="#">Canadian Dollar</a></li>
                                <li><a href="#">Pound</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="shop-menu pull-right">
                        <ul class="nav navbar-nav">
                            <li><a href="{{ url('/wish-list') }}"><i class="fa fa-star"></i>Liste d'envies</a></li>
                            <li><a href="{{ url('/orders') }}"><i class="fa fa-crosshairs"></i> Vos commandes</a></li>
                            <li><a href="{{ asset(url('/cart')) }}"><i class="fa fa-shopping-cart"></i> Panier
                                    @if ($cartCount >0)
                                    <span class=" badge badge-pill badge-secondary">
                                       {{ $cartCount }}

                                    </span>
                                    @endif
                                </a>
                            </li>
                            @if (empty(Auth::check()))
                            <li><a href="{{ url('/login-register') }}"><i class="fa fa-lock"></i> S'identifier</a></li>
                            @else
                            <li ><a href="{{ url('/account') }}"><i class="fa fa-user"></i ><span>Compte de <br/> {{ Auth::user()->name }} </span></a></li>
                            <li><a href="{{ url('/user-logout') }}"><i class="fa fa-sign-out-alt"></i>Se déconnecter</a>
                            </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/header-middle-->

    <div class="header-bottom">
        <!--header-bottom-->
        <div class="container">
            <div class="row">
                <div class="col-sm-9">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse"
                            data-target=".navbar-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>
                    <div class="mainmenu pull-left">
                        <ul class="nav navbar-nav collapse navbar-collapse">
                            <li><a href="{{ asset('/') }}" class="active">Accueil</a></li>
                            <li class="dropdown"><a href="#">Tous nos rayons<i class="fa fa-angle-down"></i></a>
                                <ul role="menu" class="sub-menu">
                                    @foreach ($mainCategories as $cat)
                                        @if($cat->status=="1")
                                        <li><a href="{{ asset('/products/'.$cat->url) }}">{{ $cat->name }}</a></li>
                                        @endif
                                    @endforeach
                                </ul>
                            </li>
                            <li class="dropdown"><a href="#">Blog<i class="fa fa-angle-down"></i></a>
                                <ul role="menu" class="sub-menu">
                                    <li><a href="blog.html">Blog List</a></li>
                                    <li><a href="blog-single.html">Blog Single</a></li>
                                </ul>
                            </li>
                            <li><a href="404.html">404</a></li>
                            <li><a href="{{ url('/page/contact') }}">Contact</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-3">

                    <div class=" search_box pull-right">
                        <form action="{{ url('/search-product') }}" method="post" class="flex justify-end items-center">
                            @csrf
                            <input type="text" placeholder="Rechercher un produit" value="{{ request()->input('query') }}" name="product" id="product" />
                            <button type="submit" class=" p-3 bg-orange-400 hover:bg-orange-300 focus:outline-none "><i class="fa fa-search text-white"></i></button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!--/header-bottom-->
</header>
<!--/header-->