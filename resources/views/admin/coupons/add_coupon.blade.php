@extends('layouts.adminLayout.admin_design')

@section('content')

<div id="content">
    <div id="content-header">
        <div id="breadcrumb"> <a href="index.html" title="Aller à l'accueil" class="tip-bottom"><i
                    class="icon-home"></i>
                Accueil</a> <a href="#">Coupons</a> <a href="#" class="current">Ajouter un coupon</a> </div>
        <h1>Coupons</h1>
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
                        <h5>Ajouter un coupon</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <form enctype="multipart/form-data" class="form-horizontal" method="post"
                            action="{{ url('/admin/add-coupon') }}" name="add_coupon" id="add_coupon"
                            novalidate="novalidate">
                            @csrf
                            
                            <div class="control-group">
                                <label class="control-label">Code du coupon</label>
                                <div class="controls">
                                    <input type="text" name="coupon_code" id="coupon_code">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Montant</label>
                                <div class="controls">
                                    <input type="text" name="amount" id="amount">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Type de coupon</label>
                                <div class="controls">
                                    <select name="amount_type" id="amount_type" style="width: 220px;">
                                        <option value="Percentage">Percentage</option>
                                        <option value="Fixed">Fixe</option>
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Date de validation</label>
                                <div class="controls">
                                    <input type="text" name="expiry_date" id="expiry_date">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Afficher</label>
                                <div class="controls">
                                    <input type="checkbox" name="status" id="status" value="1">
                                </div>
                            </div>
                            <div class="form-actions">
                                <input type="submit" value="Ajouter un coupon" class="btn btn-success">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection