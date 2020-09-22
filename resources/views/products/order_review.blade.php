@extends('layouts.frontLayout.front_design')

@section('content')

<section id="cart_items">
    <div class="container">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
                <li><a href="{{ asset('/') }}">Accueil</a></li>
                <li class="active">Votre commande</li>
            </ol>
        </div>
        <!--/breadcrums-->

        <div class="shopper-informations">
            <div class="row">
            </div>
        </div>

        <div class="row">
            <div class="col-sm-4 col-sm-offset-1">
                <div class="login-form ">
                    <h2>Détails de la facturation</h2>
                    <div class="form-group">
                        {{ $userDetails->name }}
                    </div>
                    <div class="form-group">
                        {{ $userDetails->address }}
                    </div>
                    <div class="form-group">
                        {{ $userDetails->city }}
                    </div>

                    <div class="form-group">
                        {{ $userDetails->state }}
                    </div>
                    <div class="form-group">
                        {{ $userDetails->country }}
                    </div>
                    <div class="form-group">
                        {{ $userDetails->pincode }}
                    </div>
                    <div class="form-group">
                        {{ $userDetails->mobile }}
                    </div>

                </div>
            </div>
            <div class="col-sm-1">
                <h2></h2>
            </div>
            <div class="col-sm-4">
                <div class="signup-form">
                    <h2>Détails de la livraison</h2>
                    <div class="form-group">
                        {{ $shippingDetails->name }}
                    </div>
                    <div class="form-group">
                        {{ $shippingDetails->address }}
                    </div>
                    <div class="form-group">
                        {{ $shippingDetails->city }}
                    </div>
                    <div class="form-group">
                        {{ $shippingDetails->state }}
                    </div>
                    <div class="form-group">
                        {{ $userDetails->country }}
                        </select>
                    </div>
                    <div class="form-group">
                        {{ $shippingDetails->pincode }}
                    </div>
                    <div class="form-group">
                        {{ $shippingDetails->mobile }}
                    </div>
                </div>
            </div>
        </div>


        <div class="review-payment">
            <h2>Détails & Paiement</h2>
        </div>

        <div class="table-responsive cart_info">
            <table class="table table-condensed">
                <thead>
                    <tr class="cart_menu">
                        <td class="image">Item</td>
                        <td class="description"></td>
                        <td class="price">Price</td>
                        <td class="quantity">Quantity</td>
                        <td class="total">Total</td>
                    </tr> 
                </thead>
                <tbody>
                    <?php $total_amount = 0; ?>
                    @foreach ($userCart as $cart)
                    <tr>
                        <td class="cart_product">
                            <a href=""><img style="width: 150px;" src="{{ asset('images/backend_images/product/small/'.$cart->image) }}" alt=""></a>
                        </td>
                        <td class="cart_description">
                            <h4><a href="">{{ $cart->product_name }}</a></h4>
                            <p>{{ $cart->product_code }} | {{ $cart->size }}</p>
                        </td>
                        <td class="cart_price">
                            <p>{{ number_format($cart->price, 2, ',', ' ') . ' €' }}</p>
                        </td>
                        <td class="cart_quantity">
                            <div class="cart_quantity_button">
                                <p>{{ $cart->quantity }}</p>
                            </div>
                        </td>
                        <td class="cart_total">
                            <p class="cart_total_price"> {{ number_format($cart->price * $cart->quantity , 2, ',', ' ') . ' €' }}</p>
                        </td>
                    </tr>
                    <?php $total_amount = $total_amount + ($cart->price * $cart->quantity); ?>
                    @endforeach

                    <tr>
                        <td colspan="4">&nbsp;</td>
                        <td colspan="2">
                            <table class="table table-condensed total-result">
                                <tr>
                                    <td>Sous-total</td>
                                    <td>{{ number_format($total_amount , 2, ',', ' ') . ' €' }}</td>
                                </tr>
                                <tr class="shipping-cost">
                                    <td>Livraison (+)</td>
                                    <td>{{ number_format(0 , 2, ',', ' ') . ' €'  }}</td>
                                </tr>
                                <tr class="shipping-cost">
                                    <td>Coupon de Réduction (-)</td>
                                    <td>
                                        @if (!empty(session()->get('CouponAmount')))
                                        {{ number_format(session()->get('CouponAmount') , 2, ',', ' ') . ' €'  }}
                                        @else
                                        {{ number_format(session()->get('CouponAmount') , 2, ',', ' ') . ' €'  }}
                                        @endif
                                    </td>

                                </tr>
                                <tr>
                                    <td>Total</td>
                                    <td><span>{{ number_format($total_amount - session()->get('CouponAmount') , 2, ',', ' ') . ' €' }}</span></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="payment-options">
            <span>
                <label><input type="checkbox"> Direct Bank Transfer</label>
            </span>
            <span>
                <label><input type="checkbox"> Check Payment</label>
            </span>
            <span>
                <label><input type="checkbox"> Paypal</label>
            </span>
        </div>
    </div>
</section>
<!--/#cart_items-->

@endsection