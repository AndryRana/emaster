@extends('layouts.adminLayout.admin_design')

@section('content')

<div id="content">
    <div id="content-header">
        <div id="breadcrumb"> <a href="index.html" title="Aller à l'accueil" class="tip-bottom"><i
                    class="icon-home"></i>
                Accueil</a> <a href="#">Commandes</a> <a href="#" class="current">Voir les commandes</a> </div>
        <h1>Commandes</h1>

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

    </div>
    <div class="container-fluid">
        <hr>
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
                        <h5>Voir les commandes</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <table class="table table-bordered data-table">
                            <thead>
                                <tr>
                                    <th>ID de la commande</th>
                                    <th>Date de la commande</th>
                                    <th>Nom du Client</th>
                                    <th>Email du client</th>
                                    <th>Nom des produits</th>
                                    <th>Montant de la commande</th>
                                    <th>Statut</th>
                                    <th>Mode de Paiement</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                <tr class="gradeX">
                                    <td class="center">{{ $order->id }}</td>
                                    <td class="center">{{ $order->created_at->format('d-m-Y H:i:s') }}</td>
                                    <td class="center">{{ $order->name }}</td>
                                    <td class="center">{{ $order->user_email }}</td>
                                    <td> @foreach ($order->orders as $pro)
                                        {{ $pro->product_name }}
                                        ({{ $pro->product_qty }})
                                        <br>
                                   @endforeach</td>
                                    <td class="center">{{ number_format($order->grand_total, 2, ',', ' ') . ' €'  }}</td>
                                    <td class="center">{{ $order->order_status }}</td>
                                    <td class="center">{{ $order->payment_method}}</td>
                                    <td class="center">
                                        <a href="{{ url('/admin/view-orders/' .$order->id) }}"  class="btn btn-success btn-mini" title="Voir les produits">Voir les détails</a>
                                    </td>
                                </tr>

                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection