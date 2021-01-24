@extends('layouts.frontLayout.front_design')

@section('content')
<section id="slider">
    <!--slider-->
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div id="slider-carousel" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        @foreach ($banners as $key => $banner)
                        <li data-target="#slider-carousel" data-slide-to="0" @if($key==0) class="active" @endif></li>
                        @endforeach

                    </ol>

                    <div class="carousel-inner">
                        @foreach ($banners as $key => $banner)
                        <div class="item @if($key==0) active @endif">
                            <a href="{{ $banner->link }}" title="Bannière"><img class=" w-full "
                                    src="images/frontend_images/banners/{{ $banner->image }}"></a>
                        </div>

                        @endforeach

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
    <div class="container ">
        <div class="row">
            <div class="col-sm-3">
                @include('layouts.frontLayout._front_sidebar')
            </div>

            <div class="col-sm-9 padding-right ">
                <div class="features_items ">
                    <!--features_items-->
                    <h2 class="title text-center">TOUS LES PRODUITS</h2>
                    @foreach ($productsAll as $product)

                    <div class="col-sm-4  ">
                        <div class="product-image-wrapper ">
                            <div class="single-products">
                                <div class="productinfo text-center">
                                    <a href="{{ url('product/'.$product->id) }}">         
                                        <img src="{{ asset('images/backend_images/product/small/'. $product->image) }}"
                                        alt="" />
                                    </a>
                                    <h2>{{ $product->getPrice() }}</h2>
                                    <p>{{ $product->product_name }}</p>
                                    <a href="{{ url('product/'.$product->id) }}" class="btn btn-default add-to-cart"><i
                                            class="fa fa-shopping-cart"></i>Voir le produit</a>
                                </div>
                            </div>
                            {{-- <div class="choose ">
                                <ul class="nav nav-pills nav-justified">
                                    <li><a href="#"><i class="fa fa-plus-square"></i>Ajouter à votre liste</a></li>
                                    <li><a href="#"><i class="fa fa-plus-square"></i>Comparer</a></li>
                                </ul>
                            </div> --}}
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