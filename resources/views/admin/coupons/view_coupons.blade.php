@extends('layouts.adminLayout.admin_design')

@section('content')

<div id="content">
    <div id="content-header">
        <div id="breadcrumb"> <a href="index.html" title="Aller à l'accueil" class="tip-bottom"><i
                    class="icon-home"></i>
                Accueil</a> <a href="#">Coupons</a> <a href="#" class="current">Voir les coupons</a> </div>
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
                    <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
                        <h5>Voir les coupons</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <table class="table table-bordered data-table">
                            <thead>
                                <tr>
                                    <th>ID du coupon</th>
                                    <th>Code du coupon</th>
                                    <th>Montant</th>
                                    <th>Type de coupon</th>
                                    <th>Date de validité</th>
                                    <th>Date de création</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($coupons as $coupon)
                                <tr class="gradeX">
                                    <td>{{ $coupon->id }}</td>
                                    <td>{{ $coupon->coupon_code }}</td>
                                    <td>
                                       
                                        @if($coupon->amount_type=="Percentage")
                                        {{ $coupon->amount }} % @else {{ number_format($coupon->amount, 2, ',', ' ') . ' €'  }} @endif
                                    </td>
                                    <td>{{ $coupon->amount_type }}</td>
                                    <td>{{ \Carbon\Carbon::parse($coupon->expiry_date)->format('d-m-Y') }}</td>
                                    <td>{{ $coupon->created_at->format('d-m-Y') }}</td>
                                    <td>
                                        @if ($coupon->status==1) Activé @else Désactivé @endif
                                    </td>
                                    <td class="center">
                                        <a href="#myModal{{ $coupon->id }}" data-toggle="modal"
                                            class="btn btn-success btn-mini" title="Voir les coupons">Voir les détails</a>

                                        <a href="{{ url('/admin/edit-coupon/' .$coupon->id) }}"
                                            class="btn btn-primary btn-mini" title="Modifier le coupons">Modifier</a>

                                        <a id="delCoupon" rel="{{ $coupon->id }}" rel1="delete-coupon"
                                            <?php /*href="/admin/delete-coupon/{{ $coupon->id }}"*/ ?>
                                            href="javascript:"
                                            class="btn btn-danger btn-mini deleteRecord" title="Supprimer le coupon" >Supprimer</a>
                                    </td>
                                </tr>

                                {{-- <div id="myModal{{ $coupon->id }}" class="modal hide">
                                    <div class="modal-header">
                                        <button data-dismiss="modal" class="close" type="button">×</button>
                                        <h3>Les détails du {{ $coupon->coupon_name }} </h3>
                                    </div>
                                    <div class="modal-body">
                                        <p>ID du coupon: {{ $coupon->id }}</p>
                                        <p>ID de la Catégorie: {{ $coupon->category_id }}</p>
                                        <p>Nom de la Catégorie: {{ $coupon->category_name }} </p>
                                        <p>Code du coupon: {{ $coupon->coupon_code }}</p>
                                        <p>Couleur du coupon: {{ $coupon->coupon_color }}</p>
                                        <p>Fabrication:</p>
                                        <p>Materiel:</p>
                                        <p>Description: {{ $coupon->description }}</p>
                                    </div>
                                </div> --}}

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