@extends('layouts.frontLayout.front_design')

@section('content')
<section id="cart_items">
    <div class="container">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
                <li><a href="{{ asset('/') }}">Accueil</a></li>
                <li class="active">Merci</li>
            </ol>
        </div>
    </div>
</section>

<section id="do_action">
    <div class="container">
        <div class="heading" align="center">
            <h3>VOTRE COMMANDE A BIEN ÉTÉ TRAITÉE </h3>
            <p>Votre numéro de commande est le {{session()->get('order_id')}} et le montant total de la commande est de
                {{ number_format(session()->get('grand_total'), 2, ',', ' ') . ' €' }}</p>
            <p>Merci de cliquer sur le bouton Acheter afin d'effectuer le paiement </p>

            <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
                <input type="hidden" name="cmd" value="_xclick">
                <input type="hidden" name="business" value="absolam60@gmail.com">
                <input type="hidden" name="item_name" value="{{ Session::get('order_id') }}">
                <input type="hidden" name="currency_code" value="EUR">
                <input type="hidden" name="amount" value="{{ Session::get('grand_total') }}">
                <input type="hidden" name="first_name" value="{{ $nameArr[0] }}">
                <input type="hidden" name="
                " value="{{ $nameArr[1] }}">
                <input type="hidden" name="address1" value="{{ $orderDetails->address }}">
                <input type="hidden" name="address2" value="">
                <input type="hidden" name="city" value="{{ $orderDetails->city }}">
                <input type="hidden" name="state" value="{{ $orderDetails->state }}">
                <input type="hidden" name="zip" value="{{ $orderDetails->pincode }}">
                <input type="hidden" name="email" value="{{ $orderDetails->user_email }}">
                <input type="hidden" name="country" value="{{ $getCountryCode->country_code }}">
                <input type="hidden" name="return" value="{{ url('paypal/thanks') }}">
                <input type="hidden" name="cancel_return" value="{{ url('paypal/cancel') }}">
                <input type="image" src="https://www.paypalobjects.com/fr_FR/FR/i/btn/btn_buynow_LG.gif" border="0"
                    name="submit" alt="PayPal, le réflexe sécurité pour payer en ligne">
                <img alt="" border="0" src="https://www.paypalobjects.com/fr_FR/i/scr/pixel.gif" width="1" height="1">

            </form>
        </div>
    </div>
</section>
@endsection

<?php
session()->forget('grand_total');
session()->forget('order_id'); 
?>