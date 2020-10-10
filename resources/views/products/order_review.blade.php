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

        <div class="row">
            <div class="col-sm-3 ">
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
           
            <div class="col-sm-3">
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
        


            <div class="col-sm-6 signup-form">
                <h2>Détails de votre commande</h2>
                <div class="table-responsive cart_info">
                    <table class="table table-condensed">
                      
                        <tbody>
                            <?php $total_amount = 0; ?>
                            @foreach ($userCart as $cart)
                            <tr>
                                <td >
                                    <a href=""><img class=" w-32"
                                            src="{{ asset('images/backend_images/product/small/'.$cart->image) }}" alt=""></a>
                                </td>
                                <td >
                                    <h4><a href="" class=" text-2xl font-medium">{{ $cart->product_name }}</a></h4>
                                    <p class="text-xl">{{ $cart->product_code }} | {{ $cart->size }}</p>
                                </td>
                                <td >
                                    <p class=" text-2xl">{{ number_format($cart->price, 2, ',', ' ') . ' €' }}</p>
                                </td>
                                <td >
                                 
                                    <p  class=" text-2xl">{{ $cart->quantity }}</p>
                                    
                                </td>
                                <td >
                                    <p class=" text-3xl font-medium text-orange-500">
                                        {{ number_format($cart->price * $cart->quantity , 2, ',', ' ') . ' €' }}</p>
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
                                        <tr>
                                            <td>TVA</td>
                                            <td>{{ number_format($total_amount*0.20 , 2, ',', ' ') . ' €' }}</td>
                                        </tr>
                                        <tr >
                                            <td>Livraison (+)</td>
                                            <td>{{ number_format(0 , 2, ',', ' ') . ' €'  }}</td>
                                        </tr>
                                        <tr >
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
                                            <td><span class=" text-3xl font-medium text-orange-500">{{ number_format($grand_total = $total_amount - session()->get('CouponAmount') , 2, ',', ' ') . ' €' }}</span>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        
        <div>
            <a href="{{ route('index') }}" class="btn btn-primary" ">Continuer vos achats</a>
        </div>
        <form name="paymentForm" id="paymentForm" action="{{ url('/place-order') }}" method="POST">
            @csrf
            <input type="hidden" name="grand_total" value="{{ $grand_total }}">
            <div class="payment-options flex flex-col justify-end items-center float-right">
                {{-- <span>
                    <label><strong>Selectionner le mode de Paiement:</strong> </label>
                </span>
                <span>
                    <label><input type="radio" name="payment_method" id="CB" value="CB"> <strong> Carte Bancaire</strong> </label>
                </span>
                <span>
                    <label><input type="radio" name="payment_method" id="Paypal" value="Paypal"> <strong> Paypal</strong> </label>
                </span> --}}
                <div>
                    <button type="submit" name="payment_method" value="CB" class="btn btn-primary" id="selectPaymentMethod">Procéder au paiement</button>
                </div>
                <div class="my-10">
                    <span> <img src="{{ asset('images/frontend_images/credit-card/site-paiement-securise.png') }}" alt="Paiement sécurisé" style="width: 250px;"></span>
                </div>
            </div>
        </form>
    </div>
</section>
<!--/#cart_items-->

@endsection
