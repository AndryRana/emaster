@extends('layouts.adminLayout.admin_design')

@section('content')

<div id="content">
    <div id="content-header">
        <div id="breadcrumb"> <a href="index.html" title="Aller à l'accueil" class="tip-bottom"><i
                    class="icon-home"></i>
                Accueil</a> <a href="#">Produits</a> <a href="#" class="current">Voir les produits</a> </div>
        <h1>Produits</h1>

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
                        <h5>Voir les produits</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <table class="table table-bordered data-table">
                            <thead>
                                <tr>
                                    <th>ID du produit</th>
                                    <th>ID de la Catégorie</th>
                                    <th>Nom de la Catégorie</th>
                                    <th>Nom du produit</th>
                                    <th>Code du produit</th>
                                    <th>Couleur du produit</th>
                                    <th>Prix</th>
                                    <th>Image</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                <tr class="gradeX">
                                    <td>{{ $product->id }}</td>
                                    <td>{{ $product->category_id }}</td>
                                    <td>{{ $product->category_name }}</td>
                                    <td>{{ $product->product_name }}</td>
                                    <td>{{ $product->product_code }}</td>
                                    <td>{{ $product->product_color }}</td>
                                    <td>{{ $product->getprice() }}</td>
                                    <td>
                                        @if (!empty($product->image))
                                        <img src="{{ asset('/images/backend_images/product/small/'.$product->image) }}"
                                            style="width: 60px;">
                                        @endif
                                    </td>
                                    <td class="center">
                                        <a href="#myModal{{ $product->id }}" data-toggle="modal"
                                            class="btn btn-success btn-mini">Voir les détails</a>

                                        <a href="{{ url('/admin/edit-product/' .$product->id) }}"
                                            class="btn btn-primary btn-mini">Modifier</a>

                                        <a href="{{ url('/admin/add-attributes/' .$product->id) }}"
                                            class="btn btn-success btn-mini">Ajouter des attributs</a>

                                        <a id="delProduct" rel="{{ $product->id }}" rel1="delete-product"
                                            <?php /*href="/admin/delete-product/{{ $product->id }}"*/ ?>
                                            href="javascript:"
                                            class="btn btn-danger btn-mini deleteRecord">Supprimer</a>
                                    </td>
                                </tr>

                                <div id="myModal{{ $product->id }}" class="modal hide">
                                    <div class="modal-header">
                                        <button data-dismiss="modal" class="close" type="button">×</button>
                                        <h3>Les détails du {{ $product->product_name }} </h3>
                                    </div>
                                    <div class="modal-body">
                                        <p>ID du produit: {{ $product->id }}</p>
                                        <p>ID de la Catégorie: {{ $product->category_id }}</p>
                                        <p>Nom de la Catégorie: {{ $product->category_name }} </p>
                                        <p>Code du produit: {{ $product->product_code }}</p>
                                        <p>Couleur du produit: {{ $product->product_color }}</p>
                                        <p>Prix: {{ $product->getprice() }}</p>
                                        <p>Fabrication:</p>
                                        <p>Materiel:</p>
                                        <p>Description: {{ $product->description }}</p>
                                    </div>
                                </div>

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