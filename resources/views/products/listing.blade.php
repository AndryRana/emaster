@extends('layouts.frontLayout.front_design')

@section('content')
<section id="slider">
    <!--slider-->
    <div class="container">

        <div class="row">
            <div class="col-sm-12">
                <div id="slider-carousel" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#slider-carousel" data-slide-to="0" class="active"></li>
                        <li data-target="#slider-carousel" data-slide-to="1"></li>
                        <li data-target="#slider-carousel" data-slide-to="2"></li>
                    </ol>

                    <div class="carousel-inner">
                        <div class="item active">
                            <div class="col-sm-6">
                                <h1><span>E</span>-SHOPPER ANDRY</h1>
                                <h2>E-Commerce</h2>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                    incididunt ut labore et dolore magna aliqua. </p>
                                <button type="button" class="btn btn-default get">Get it now</button>
                            </div>
                            <div class="col-sm-6">
                                <img src="{{ asset('images/frontend_images/home/girl1.jpg') }}"
                                    class="girl img-responsive" alt="" />
                                <img src="{{ asset('images/frontend_images/home/pricing') }}" class="pricing" alt="" />
                            </div>
                        </div>
                        <div class="item">
                            <div class="col-sm-6">
                                <h1><span>E</span>-SHOPPER</h1>
                                <h2>Design by ANDRY</h2>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                    incididunt ut labore et dolore magna aliqua. </p>
                                <button type="button" class="btn btn-default get">Get it now</button>
                            </div>
                            <div class="col-sm-6">
                                <img src="{{ asset('images/frontend_images/home/girl2.jpg') }}"
                                    class="girl img-responsive" alt="" />
                                <img src="{{ asset('images/frontend_images/home/pricing.png') }}" class="pricing"
                                    alt="" />
                            </div>
                        </div>

                        <div class="item">
                            <div class="col-sm-6">
                                <h1><span>E</span>-SHOPPER</h1>
                                <h2>Free Ecommerce Template</h2>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                    incididunt ut labore et dolore magna aliqua. </p>
                                <button type="button" class="btn btn-default get">Get it now</button>
                            </div>
                            <div class="col-sm-6">
                                <img src="{{ asset('images/frontend_images/home/girl3.jpg') }}"
                                    class="girl img-responsive" alt="" />
                                <img src="{{ asset('images/frontend_images/home/pricing.png') }}" class="pricing"
                                    alt="" />
                            </div>
                        </div>

                    </div>

                    <a href="#slider-carousel" class="left control-carousel hidden-xs" data-slide="prev">
                        <i class="fa fa-angle-left"></i>
                    </a>
                    <a href="#slider-carousel" class="right control-carousel hidden-xs" data-slide="next">
                        <i class="fa fa-angle-right"></i>
                    </a>
                </div>

            </div>
        </div>
    </div>
</section>
<!--/slider-->

<section>
    <div class="container">
        <div class="row">
            <div class="col-sm-3">
                @include('layouts.frontLayout.front_sidebar')
            </div>

            <div class="col-sm-9 padding-right">
                <div class="features_items">
                    <!--features_items-->
                    <h2 class="title text-center">
                        @if (!empty($search_product))
                        {{ $productsAll->count() }} résultat(s) sur {{ $search_product }}
                        @else
                        {{ $categoryDetails->name }}
                        @endif
                    </h2>
                    @foreach ($productsAll as $product)

                    <div class="col-sm-4">
                        <div class="product-image-wrapper">
                            <div class="single-products">
                                <div class="productinfo text-center">
                                    <img src="{{ asset('images/backend_images/product/small/'. $product->image) }}"
                                        alt="" />
                                    <h2>{{ $product->getPrice() }}</h2>
                                    <p>{{ $product->product_name }}</p>
                                    <a href="{{ url('product/'.$product->id) }}" class="btn btn-default add-to-cart"><i
                                            class="fa fa-shopping-cart"></i>Ajouter au panier</a>
                                </div>
                                {{-- <div class="product-overlay">
                                                <div class="overlay-content">
                                                    <h2>{{ $product->getPrice() }}</h2>
                                <p>{{ $product->product_name }}</p>
                                <a href="#" class="btn btn-default add-to-cart"><i
                                        class="fa fa-shopping-cart"></i>Ajouter au panier</a>
                            </div>
                        </div> --}}
                    </div>
                    <div class="choose">
                        <ul class="nav nav-pills nav-justified">
                            <li><a href="#"><i class="fa fa-plus-square"></i>Ajouter à votre liste</a></li>
                            <li><a href="#"><i class="fa fa-plus-square"></i>Comparer</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            @endforeach

        </div>
        <!--features_items-->
    </div>
    </div>
    <div align="center" class="bottom-0">{{ $productsAll->links() }}</div>
    </div>
</section>

@endsection