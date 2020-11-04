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
                            {{-- <li><a href="#"><i class="fa fa-phone"></i> +2 95 01 88 821</a></li>
                            <li><a href="#"><i class="fa fa-envelope "></i> info@domain.com</a></li> --}}
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
                        <a href="{{ url('/') }}"><img src="images/frontend_images/home/logo.png" alt="" /></a>
                    </div>
                    {{-- <div class="btn-group pull-right">
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
                    </div>--}}
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
        <div class="container ">
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
                <div class="mr-6">
                        <div class="aa-input-container pull-right " id="aa-input-container">
                            <input type="search" id="aa-search-input" class="aa-input-search" placeholder="Recherche..." name="search"
                                autocomplete="off" />
                            <svg class="aa-input-icon" viewBox="654 -372 1664 1664">
                                <path d="M1806,332c0-123.3-43.8-228.8-131.5-316.5C1586.8-72.2,1481.3-116,1358-116s-228.8,43.8-316.5,131.5  
                                C953.8,103.2,910,208.7,910,332s43.8,228.8,131.5,316.5C1129.2,736.2,1234.7,780,1358,780s228.8-43.8,316.5-131.5  
                                C1762.2,560.8,1806,455.3,1806,332z M2318,1164c0,34.7-12.7,64.7-38,90s-55.3,38-90,38c-36,0-66-12.7-90-38l-343-342  
                                c-119.3,82.7-252.3,124-399,124c-95.3,0-186.5-18.5-273.5-55.5s-162-87-225-150s-113-138-150-225S654,427.3,654,332  
                                s18.5-186.5,55.5-273.5s87-162,150-225s138-113,225-150S1262.7-372,1358-372s186.5,18.5,273.5,55.5s162,87,225,150s113,138,150,225  
                                S2062,236.7,2062,332c0,146.7-41.3,279.7-124,399l343,343C2305.7,1098.7,2318,1128.7,2318,1164z" />
                            </svg>
                        </div>
                    {{-- <div class=" search_box pull-right">
                        <form action="{{ url('/search-product') }}" method="post" class="flex justify-end items-center">
                            @csrf
                            <input type="text" placeholder="Rechercher un produit" value="{{ request()->input('query') }}" name="product" id="product" />
                            <button type="submit" class=" p-3 bg-orange-400 hover:bg-orange-300 focus:outline-none "><i class="fa fa-search text-white"></i></button>
                        </form>
                    </div> --}}

                </div>
            </div>
        </div>
    </div>
    <!--/header-bottom-->
</header>
<!--/header-->