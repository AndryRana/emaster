@extends('layouts.adminLayout.admin_design')

@section('content')

<div id="content">
    <div id="content-header">
        <div id="breadcrumb"> <a href="index.html" title="Aller à l'accueil" class="tip-bottom"><i
                    class="icon-home"></i>
                Accueil</a> <a href="#">Livraisons</a> <a href="#" class="current">Voir les Livraison</a> </div>
        <h1>Frais de port</h1>

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
                        <h5>Voir les catégories</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <table class="table table-bordered data-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Pays</th>
                                    <th>Frais de port</th>
                                    <th>Date de mise à jour</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($shipping_charges as $shipping)
                                <tr class="gradeX">
                                    <td>{{ $shipping->id }}</td>
                                    <td>{{ $shipping->country }}</td>
                                    <td>{{ $shipping->shipping_charges }}</td>
                                    <td>{{ $shipping->updated_at->format('d-m-Y H:i:s') }}</td>
                                    <td class="center">
                                        <a href="{{ url('admin/edit-shipping/'. $shipping->id) }}" class="btn btn-primary btn-mini">Modifier</a>

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