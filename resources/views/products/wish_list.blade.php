
@extends('layouts.frontLayout.front_design')

@section('content')
<?php use App\Product; ?>
<section id="cart_items">
    <div class="container">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
                <li><a href="{{ asset('/') }}">Accueil</a></li>
                {{-- <i class="fa fa-home"></i> --}}
                <li class="active">Votre liste d'envie</li>
            </ol>
        </div>
        <div class="table-responsive cart_info">
            @if (Session::has('flash_message_error'))
            <div class="alert alert-danger alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{!! session('flash_message_error') !!}</strong>
            </div>
            @endif
            @if (Session::has('flash_message_success'))
            <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{!! session('flash_message_success') !!}</strong>
            </div>
            @endif
            <table class="table table-condensed">
                <thead>
                    <tr class="cart_menu grid grid-cols-1 sm:grid-cols-2 md:grid-cols-6 lg:grid-cols-7 items-center">
                        <td class="image">Article</td>
                        <td class="description"></td>
                        <td class="price ">Prix</td>
                        <td class="quantity">Quantité</td>
                        <td class="total">Total</td>
                        <td></td>
                        <td></td>
                    </tr>
                </thead>
                <tbody>
                    <?php $total_amount = 0; ?>
                    @foreach ($userWishList as $wishlist)

                    <tr class="flex flex-row justify-between items-center grid grid-cols-1 sm:grid-cols-2 md:grid-cols-6 lg:grid-cols-7 items-center">
                        <td class="cart_product">
                            <a href=""><img class="cart_img"
                                    src="{{ asset('images/backend_images/product/small/'.$wishlist->image) }}" alt=""></a>
                        </td>
                        <td class="cart_description text-sm">
                            <h4><a href="">{{ $wishlist->product_name }}</a></h4>
                            <p>{{ $wishlist->product_code }} | {{ $wishlist->size }}</p>

                        </td>
                        <td class="cart_price">
                            <?php $product_price = Product::getProductPrice($wishlist->product_id,$wishlist->size) ?>
                            <p>{{ number_format($product_price, 2, ',', ' ') . ' €' }}</p>
                        </td>
                        <td class="cart_quantity">
                            <p>{{ $wishlist->quantity }}</p>
                        </td>
                        <td class="cart_total">
                            <p class="cart_total_price"> {{ number_format($product_price * $wishlist->quantity , 2, ',', ' ') . ' €' }}</p>
                        </td>
                        <form name="addtocartForm" id="addtocartForm" action="{{ url('/add-cart') }}" method="post">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $wishlist->product_id }}" />
                            <input type="hidden" name="product_name" value="{{ $wishlist->product_name }}" />
                            <input type="hidden" name="product_code" value="{{ $wishlist->product_code }}" />
                            <input type="hidden" name="product_color" value="{{ $wishlist->product_color }}" />
                            <input type="hidden" name="size" value="{{ $wishlist->id }}-{{ $wishlist->size }}">
                            <input type="hidden" name="price" id="price" value="{{ $wishlist->price}}" />

                            <td>
                                <button type="submit" class="btn btn-default cart mt-4" id="cartButton" name="cartButton" value="Add to Cart">
                                    <i class="fa fa-shopping-cart"></i>
                                    Ajouter au panier
                                </button>
                            </td>
                        </form>
                        <td class="cart_delete"><a class="cart_quantity_delete" href="{{ url('/wish-list/delete-product/'.$wishlist->id) }}"><i class="fa fa-times"></i></a></td>
                    </tr>

                    <?php $total_amount = $total_amount + ($product_price * $wishlist->quantity); ?>
                    @endforeach


                </tbody>
            </table>
        </div>
    </div>
</section>
<!--/#cart_items-->


@endsection