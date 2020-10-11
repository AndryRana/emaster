@extends('layouts.adminLayout.admin_design')

@section('content')
<!--main-container-part-->
<div id="content">
    <div id="content-header">
        <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a
                href="#" class="current">Commandes</a> </div>
        <h1>Commandes #{{ $orderDetails->id }}</h1>
        @if(Session::has('flash_message_success'))
            <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button> 
                    <strong>{!! session('flash_message_success') !!}</strong>
            </div>
        @endif
    </div>
    <div class="container-fluid">
        <hr>
        <div class="row-fluid">
            <div class="span6">
                <div class="widget-box">
                    <div class="widget-title">
                        <h5>Les détails de la commande</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <table class="table table-striped table-bordered">
                            <tbody>
                                <tr>
                                    <td class="taskDesc">Date de la commande</td>
                                    <td class="taskStatus">{{ $orderDetails->created_at->format('d-m-Y H:i:s') }}</td>
                                </tr>
                                <tr>
                                    <td class="taskDesc">Statut de la commande</td>
                                    <td class="taskStatus">{{ $orderDetails->order_status }}</td>
                                </tr>
                                <tr>
                                    <td class="taskDesc">Montant total</td>
                                    <td class="taskStatus">{{ number_format($orderDetails->grand_total, 2, ',', ' ') . ' €'  }}</td>
                                </tr>
                                <tr>
                                    <td class="taskDesc">Frais de transport</td>
                                    <td class="taskStatus">{{ number_format($orderDetails->shipping_charges, 2, ',', ' ') . ' €'  }}</td>
                                </tr>
                                <tr>
                                    <td class="taskDesc">Code coupon</td>
                                    <td class="taskStatus">{{ $orderDetails->coupon_code }}</td>
                                </tr>
                                <tr>
                                    <td class="taskDesc">Montant du coupon</td>
                                    <td class="taskStatus">{{ number_format($orderDetails->coupon_amount , 2, ',', ' ') . ' €'  }}</td>
                                </tr>
                                <tr>
                                    <td class="taskDesc">Mode de paiement</td>
                                    <td class="taskStatus">{{ $orderDetails->payment_method }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="accordion" id="collapse-group">
                    <div class="accordion-group widget-box">
                        <div class="accordion-heading">
                            <div class="widget-title">
                                <h5>Adresse de facturation</h5>
                            </div>
                        </div>
                        <div class="collapse in accordion-body" id="collapseGOne">
                            <div class="widget-content">
                                {{ $userDetails->name }} <br>
                                {{ $userDetails->address }} <br>
                                {{ $userDetails->city }} <br>
                                {{ $userDetails->state }} <br>
                                {{ $userDetails->country }} <br>
                                {{ $userDetails->pincode }} <br>
                                {{ $userDetails->mobile }} <br>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="span6">
                <div class="widget-box">
                    <div class="widget-title">
                        <h5>Information sur le client</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <table class="table table-striped table-bordered">
                            <tbody>
                                <tr>
                                    <td class="taskDesc">Nom</td>
                                    <td class="taskStatus">{{ $orderDetails->name }}</td>
                                </tr>
                                <tr>
                                    <td class="taskDesc">Email</td>
                                    <td class="taskStatus">{{ $orderDetails->user_email }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="accordion" id="collapse-group">
                    <div class="accordion-group widget-box">
                        <div class="accordion-heading">
                            <div class="widget-title">
                                <h5>Mettre à jour le statut de la commande</h5>
                            </div>
                        </div>
                        <div class="collapse in accordion-body" id="collapseGOne">
                            <div class="widget-content">
                                <form action="{{ url('admin/update-order-status') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="order_id" value="{{ $orderDetails->id }}">
                                    <table width="100%">
                                        <tr>
                                            <td>
                                                <select name="order_status" id="order_status" class="control-label"
                                                    required="">
                                                    <option value="New" @if($orderDetails->order_status == "New")
                                                        selected @endif>New</option>
                                                    <option value="Pending" @if($orderDetails->order_status ==
                                                        "Pending") selected @endif>Pending</option>
                                                    <option value="Cancelled" @if($orderDetails->order_status ==
                                                        "Cancelled") selected @endif>Cancelled</option>
                                                    <option value="In Process" @if($orderDetails->order_status == "In
                                                        Process") selected @endif>In Process</option>
                                                    <option value="Shipped" @if($orderDetails->order_status ==
                                                        "Shipped") selected @endif>Shipped</option>
                                                    <option value="Delivered" @if($orderDetails->order_status ==
                                                        "Delivered") selected @endif>Delivered</option>
                                                    <option value="Paid" @if($orderDetails->order_status == "Paid")
                                                        selected @endif>Paid</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="submit" class="bg-white hover:bg-gray-100 text-gray-600 font-semibold py-1 px-2 border border-gray-400 rounded shadow" value="Mise à jour Statut">
                                            </td>
                                        </tr>
                                    </table>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="accordion" id="collapse-group">
                    <div class="accordion-group widget-box">
                        <div class="accordion-heading">
                            <div class="widget-title">
                                <h5>Adresse de livraison</h5>
                            </div>
                        </div>
                        <div class="collapse in accordion-body" id="collapseGOne">
                            <div class="widget-content">
                                {{ $orderDetails->name }} <br>
                                {{ $orderDetails->address }} <br>
                                {{ $orderDetails->city }} <br>
                                {{ $orderDetails->state }} <br>
                                {{ $orderDetails->country }} <br>
                                {{ $orderDetails->pincode }} <br>
                                {{ $orderDetails->mobile }} <br></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row-fluid">
            <table id="example" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>Code du produit</th>
                        <th>Nom du produit</th>
                        <th>Taille du produit</th>
                        <th>Couleur du produit</th>
                        <th>Prix du produit</th>
                        <th>Quantité du produit</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orderDetails->orders as $pro)
                    <tr>
                        <td>{{ $pro->product_code }}</td>
                        <td>{{ $pro->product_name }}</td>
                        <td>{{ $pro->product_size }}</td>
                        <td>{{ $pro->product_color }}</td>
                        <td>{{ number_format($pro->product_price, 2, ',', ' ') . ' €'  }}</td>
                        <td>{{ $pro->product_qty }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<!--main-container-part-->
@endsection