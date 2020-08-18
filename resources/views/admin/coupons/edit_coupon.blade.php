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
                        <h5>Modifier le coupon</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <form  class="form-horizontal" method="post"
                            action="{{ url('/admin/edit-coupon/'. $couponDetails->id) }}" name="edit_coupon" id="edit_coupon">
                            @csrf
                            
                            <div class="control-group">
                                <label class="control-label">Code du coupon</label>
                                <div class="controls">
                                    <input type="text" name="coupon_code" id="coupon_code" minlength="5" maxlength="15" value="{{ $couponDetails->coupon_code }}" required>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Valeur du coupon en @if($couponDetails->amount_type=="Pourcentage")
                                    %  @else € @endif</label>
                                <div class="controls">
                                    <input type="number" name="amount" id="amount" min="1" value ="{{ $couponDetails->amount }}"  required>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Type de coupon</label>
                                <div class="controls">
                                    <select name="amount_type" id="amount_type" style="width: 220px;">
                                        <option @if ( $couponDetails->amount_type=="Pourcentage") selected
                                        @endif value="Pourcentage">Pourcentage</option>
                                        <option @if ( $couponDetails->amount_type=="Fixe") selected
                                        @endif value="Fixe">Fixe</option>
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Date de validation</label>
                                <div class="controls">
                                    <input value="{{ $couponDetails->expiry_date }}"  type="text" name="expiry_date" id="expiry_date" autocomplete="off" required >
                                    {{-- <input value="{{ \Carbon\Carbon::parse($couponDetails->expiry_date)->format('d-m-Y') }}" name="expiry_date" id="expiry_date" type="text" autocomplete="off" required > --}}
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Afficher</label>
                                <div class="controls">
                                    <input  type="checkbox" name="status" id="status" value="1" @if ($couponDetails->status=="1") checked
                                    @endif>
                                </div>
                            </div>
                            <div class="form-actions">
                                <input type="submit" value="Modifier le coupon" class="btn btn-success">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection