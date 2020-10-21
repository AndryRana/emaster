@extends('layouts.frontLayout.front_design')

@section('content')

<section>
    <div class="container">
        <div class="row">
            @if (Session::has('flash_message_error'))
            <div class="alert alert-danger alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{!! session('flash_message_error') !!}</strong>
            </div>
            @endif
            <div class="col-sm-3">
                @include('layouts.frontLayout._front_sidebar')
            </div>

            <div class="col-sm-9 padding-right">
                <div class="product-details">
                    <!--product-details-->
                    <div class="col-sm-5">
                        <div class="view-product">
                            <div class="easyzoom easyzoom--overlay easyzoom--with-thumbnails">
                                <a href="{{ asset('images/backend_images/product/large/'. $productDetails->image) }}">
                                    <img style="width:300px;" class="mainImage"
                                        src="{{ asset('images/backend_images/product/medium/'. $productDetails->image) }}"
                                        alt="image" />
                                </a>
                            </div>
                        </div>
                        <div id="similar-product" class="carousel slide" data-ride="carousel">

                            <!-- Wrapper for slides -->
                            <div class="carousel-inner">
                                <div class="item active thumbnails">
                                    <a href="{{ asset('images/backend_images/product/large/'. $productDetails->image) }}"
                                        data-standard="{{ asset('images/backend_images/product/small/'. $productDetails->image) }}">
                                        <img class="changeImage" style="width:80px;"
                                            src="{{ asset('images/backend_images/product/small/'. $productDetails->image) }}"
                                            alt="image" />
                                    </a>
                                    @foreach ($productAltImages as $altimage)
                                    <a href="{{ asset('images/backend_images/product/large/'. $altimage->image) }}"
                                        data-standard="{{ asset('images/backend_images/product/small/'. $altimage->image) }}">
                                        <img class="changeImage" style="width: 80px; cursor:pointer;"
                                            src="{{ asset('images/backend_images/product/small/'. $altimage->image) }}"
                                            alt="">
                                    </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-sm-7 ">
                        <form name="addtocartForm" id="addtocartForm" action="{{ url('/add-cart') }}" method="post">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $productDetails->id }}" />
                            <input type="hidden" name="product_name" value="{{ $productDetails->product_name }}" />
                            <input type="hidden" name="product_code" value="{{ $productDetails->product_code }}" />
                            <input type="hidden" name="product_color" value="{{ $productDetails->product_color }}" />
                            <input type="hidden" name="price" id="price" value="{{ $productDetails->price}}" />

                            <div class="product-information">
                                <!--/product-information-->
                                <img src="images/product-details/new.jpg" class="newarrival" alt="" />
                                <h2>{{ $productDetails->product_name }}</h2>
                                <p>Code: {{ $productDetails->product_code }}</p>
                                <p>Couleur: {{ $productDetails->product_color }}</p>
                                @if (!empty($productDetails->sleeve))
                                <p>Manche: {{ $productDetails->sleeve }}</p>
                                @endif
                                @if (!empty($productDetails->pattern))
                                <p>Modèle: {{ $productDetails->pattern }}</p>
                                @endif
                                <p>
                                    <select id="selSize" name="size" class="attributesize h-16" required>
                                        <option value="">Selectionner la taille</option>
                                        @foreach ($productDetails->attributes as $sizes)
                                        <option value="{{ $productDetails->id }}-{{ $sizes->size }}">{{ $sizes->size }}
                                        </option>
                                        @endforeach
                                    </select>
                                </p>
                                <img src="images/product-details/rating.png" alt="" />
                                <span>
                                    <span id="getPrice">{{ $productDetails->getprice() }}</span>
                                    <label>Quantité:</label>
                                    <input type="text" name="quantity" value="1" />
                                    @if ($total_stock>0)
                                    <button type="submit" class="btn btn-default cart " id="cartButton">
                                        <i class="fa fa-shopping-cart"></i>
                                        Ajouter au panier
                                    </button>
                                    @endif
                                </span>
                                <p><b>Disponibilité:</b> <span id="Availability"> @if ($total_stock>0) En Stock @else
                                        Produit indisponible @endif </p></span>
                                <p><b>Condition:</b> Neuf</p>
                                <div class="login-form flex ">
                                    <p class="mt-4"><b>Livraison:</b></p>
                                    <input type="text" name="pincode" id="chkPincode"
                                        placeholder="Saisir votre code postal" class="mx-10">
                                    <button type="button"
                                        class=" mb-10 h-15 bg-orange-400 p-4 text-white focus:outline-none hover:bg-gray-300 hover:text-black"
                                        id="checkPincode">
                                        Vérifier
                                    </button>
                                </div>
                                <span id="pincodeResponse"></span>
                               
                                <!-- ShareThis BEGIN -->
                                <div class="sharethis-inline-share-buttons"></div>
                                <!-- ShareThis END -->
            
                            </div>
                            <!--/product-information-->
                        </form>
                    </div>
                </div>
                <!--/product-details-->

                <div class="category-tab shop-details-tab">
                    <!--category-tab-->
                    <div class="col-sm-12">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#description" data-toggle="tab">Description</a></li>
                            <li><a href="#care" data-toggle="tab">Matériel et Entretien</a></li>
                            <li><a href="#delivery" data-toggle="tab">Option de livraison</a></li>
                            @if (!empty($productDetails->video))
                                <li><a href="#video" data-toggle="tab">Vidéo du produit</a></li>
                            @endif
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane fade active in" id="description">
                            <div class="col-sm-12">
                                <p>
                                    {{ $productDetails->description }}
                                </p>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="care">
                            <div class="col-sm-12">
                                <p>
                                    {{ $productDetails->care }}
                                </p>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="delivery">
                            <div class="col-sm-12">
                                <p>
                                    Livraison gratuite
                                </p>
                            </div>
                        </div>
                        @if (!empty($productDetails->video))
                            <div class="tab-pane fade" id="video">
                                <div class="col-sm-12">
                                    <video class=" object-contain " controls>
                                        <source src="{{ url('videos/'. $productDetails->video) }}" type="video/mp4">

                                    </video>
                                </div>
                            </div>
                        @endif    
                        {{-- <div class="tab-pane fade active in" id="reviews" >
                            <div class="col-sm-12">
                                <ul>
                                    <li><a href=""><i class="fa fa-user"></i>EUGEN</a></li>
                                    <li><a href=""><i class="fa fa-clock-o"></i>12:41 PM</a></li>
                                    <li><a href=""><i class="fa fa-calendar-o"></i>31 DEC 2014</a></li>
                                </ul>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
                                <p><b>Write Your Review</b></p>
                                
                                <form action="#">
                                    <span>
                                        <input type="text" placeholder="Your Name"/>
                                        <input type="email" placeholder="Email Address"/>
                                    </span>
                                    <textarea name="" ></textarea>
                                    <b>Rating: </b> <img src= "images/product-details/rating.png" alt="" />
                                    <button type="button" class="btn btn-default pull-right">
                                        Submit
                                    </button>
                                </form>
                            </div>
                        </div> --}}

                    </div>
                </div>
                <!--/category-tab-->

                <div class="recommended_items">
                    <!--recommended_items-->
                    <h2 class="title text-center">Les clients ayant consulté cet article ont également regardé</h2>

                    <div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                            <?php $count=1; ?>
                            @foreach($relatedProducts->chunk(3) as $chunk)
                            <div <?php if($count==1){ ?> class="item active" <?php } else { ?> class="item" <?php } ?>>
                                @foreach($chunk as $item)
                                <div class="col-sm-4">
                                    <div class="product-image-wrapper">
                                        <div class="single-products">
                                            <div class="productinfo text-center">
                                                <img style=" width:200px; "
                                                    src="{{ asset('images/backend_images/product/small/'.$item->image) }}"
                                                    alt="" />
                                                <h2>{{ $item->getprice() }}</h2>
                                                <p>{{ $item->product_name }}</p>
                                                <a href="{{ url('/product/'.$item->id) }}"><button type="button"
                                                        class="btn btn-default add-to-cart"><i
                                                            class="fa fa-shopping-cart"></i>Ajouter au
                                                        panier</button></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <?php $count++; ?>
                            @endforeach
                        </div>
                        <a class="left recommended-item-control" href="#recommended-item-carousel" data-slide="prev">
                            <i class="fa fa-angle-left"></i>
                        </a>
                        <a class="right recommended-item-control" href="#recommended-item-carousel" data-slide="next">
                            <i class="fa fa-angle-right"></i>
                        </a>
                    </div>
                </div>
                <!--/recommended_items-->

            </div>
        </div>
    </div>
</section>

@endsection