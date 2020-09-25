@extends('layouts.frontLayout.front_design')

@section('content')
<section id="cart_items">
    <div class="container">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
                <li><a href="{{ asset('/') }}">Accueil</a></li>
                {{-- <i class="fa fa-home"></i> --}}
                <li class="active">Votre panier</li>
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
                    <tr class="cart_menu">
                        <td class="image">Article</td>
                        <td class="description"></td>
                        <td class="price">Prix</td>
                        <td class="quantity">Quantité</td>
                        <td class="total">Total</td>
                        <td></td>
                    </tr>
                </thead>
                <tbody>
                    <?php $total_amount = 0; ?>
                    @foreach ($userCart as $cart)
                    <tr>
                        <td class="cart_product">
                            <a href=""><img class="cart_img"
                                    src="{{ asset('images/backend_images/product/small/'.$cart->image) }}" alt=""></a>
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
                                @if ($cart->quantity>1)
                                <a class="cart_quantity_down"
                                    href="{{ url('/cart/update-quantity/'. $cart->id.'/-1') }}"> - </a>
                                @endif
                                <input class="cart_quantity_input" type="text" name="quantity"
                                    value="{{ $cart->quantity }}" autocomplete="off" size="2">
                                <a class="cart_quantity_up" href="{{ url('/cart/update-quantity/'. $cart->id.'/1') }}">
                                    + </a>
                            </div>
                        </td>
                        <td class="cart_total">
                            <p class="cart_total_price">
                                {{ number_format($cart->price * $cart->quantity , 2, ',', ' ') . ' €' }}</p>
                        </td>
                        <td class="cart_delete">
                            <a class="cart_quantity_delete" href="{{ url('/cart/delete-product/' . $cart->id) }}"><i
                                    class="fa fa-times"></i></a>
                        </td>
                    </tr>
                    <?php $total_amount = $total_amount + ($cart->price * $cart->quantity); ?>
                    @endforeach


                </tbody>
            </table>
        </div>
    </div>
</section>
<!--/#cart_items-->

<section id="do_action">
    <div class="container">
        <div class="heading">
            <h3>Que devriez-vous faire ensuite?</h3>
            <p>Choisissez un code de réduction si vous en avez.</p>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="chose_area">
                    <ul class="user_option">
                        <li>
                            <form action="{{ url('cart/apply-coupon') }}" method="post">
                                @csrf
                                <label>Code du coupon</label>
                                <input type="text" name="coupon_code">
                                <input type="submit" value="Appliquer" class="btn btn-default">
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="total_area">
                    <ul>
                        @if (!empty(session()->get('CouponAmount')))
                            <li>Sous-total <span> {{ number_format($total_amount , 2, ',', ' ') . ' €' }}</span></li>
                            <li>TVA <span> {{ number_format($total_amount*0.20 , 2, ',', ' ') . ' €' }}</span></li>
                            <li>Coupon de réduction <span> {{ number_format(session()->get('CouponAmount') , 2, ',', ' ') . ' €'  }}</span></li>
                            <li>Total <span> {{ number_format($total_amount - session()->get('CouponAmount') , 2, ',', ' ') . ' €' }}</span></li>
                            @else
                            <li>TVA <span> {{ number_format($total_amount*0.20 , 2, ',', ' ') . ' €' }}</span></li>
                            <li>Total <span> {{ number_format($total_amount , 2, ',', ' ') . ' €' }}</span></li>
                        @endif
                    </ul>
                    <a class="btn btn-default update" href="">Update</a>
                    <a class="btn btn-default check_out" href="{{ url('/checkout') }}">Passer la commande</a>
                </div>
            </div>
        </div>
    </div>
</section>
<!--/#do_action-->
@endsection