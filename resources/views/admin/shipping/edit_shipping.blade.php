@extends('layouts.adminLayout.admin_design')

@section('content')

<div id="content">
    <div id="content-header">
        <div id="breadcrumb"> <a href="index.html" title="Aller à l'accueil" class="tip-bottom"><i
                    class="icon-home"></i>
                Accueil</a> <a href="#">Frais de port</a> <a href="#" class="current">Modifier le Frais de Port</a> </div>
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
                    <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
                        <h5>Modifier le Frais de port</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <form enctype="multipart/form-data" class="form-horizontal" method="post"
                            action="{{ url('/admin/edit-shipping/'.$shippingDetails->id) }}" name="add-shipping"
                            id="add-shipping" novalidate="novalidate">
                            @csrf
                            <input type="hidden" name="id" value="{{ $shippingDetails->id }}">
                            <div class="control-group">
                                <label class="control-label">Pays</label>
                                <div class="controls">
                                    <input readonly class=" w-28" type="text" value="{{ $shippingDetails->country }}">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Frais de port</label>
                                <div class="controls">
                                    <input type="text" name="shipping_charges" id="shipping_charges" value="{{ $shippingDetails->shipping_charges }}"">
                                </div>
                            </div>
                            
                            <div class="form-actions">
                                <input type="submit" value="Modifier Frais de port" class="btn btn-success">
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection