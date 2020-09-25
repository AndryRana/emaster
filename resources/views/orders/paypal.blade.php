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
            <h3>VOTRE COMMAeDE A BIEN ÉTÉ TRAITÉE </h3>
            <p>Votre numéro de commande est le {{session()->get('order_id')}} et le montant total payé est de
                {{ number_format(session()->get('grand_total'), 2, ',', ' ') . ' €' }}</p>
            <p>Merci de cliquer sur le bouton PAYPAL afin d'effectuer le paiement </p>
            <form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
                <input type="hidden" name="cmd" value="_s-xclick">
                <input type="hidden" name="business" value="sb-oopfd3298778@business.example.com">
                <input type="hidden" name="item_name" value="{{session()->get('order_id')}} ">
                <input type="hidden" name="item_number" value="{{session()->get('order_id')}} ">
                <input type="hidden" name="amount" value="{{session()->get('grand_total')}}">
                <input type="image" 
                src="https://www.paypalobjects.com/webstatic/en_US/i/btn/png/btn_paynow_107x26.png" alt="Acheter">
                <img alt="" src="https://paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
            </form>
        </div>
    </div>
</section>
@endsection

<?php
session()->forget('grand_total');
session()->forget('order_id'); 
?>