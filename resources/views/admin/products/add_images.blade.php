@extends('layouts.adminLayout.admin_design')

@section('content')

<div id="content">
    <div id="content-header">
        <div id="breadcrumb"> <a href="index.html" title="Aller à l'accueil" class="tip-bottom"><i
                    class="icon-home"></i>
                Accueil</a> <a href="#">Products</a> <a href="#" class="current">Ajouter des images au produit</a>
        </div>
        <h1>Image(s) supplémentaire(s) du Produit</h1>
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
                        <h5>Ajouter des images au produit</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <form enctype="multipart/form-data" class="form-horizontal" method="post"
                            action="{{ url('/admin/add-images/'.$productDetails->id) }}" name="add_image"
                            id="add_image">
                            @csrf

                            <input type="hidden" name="product_id" value="{{ $productDetails->id }}">

                            <div class="control-group">
                                <label class="control-label">Nom du produit</label>
                                <label class=" control-label">{{ $productDetails->product_name }}</label>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Code du produit</label>
                                <label class=" control-label">{{ $productDetails->product_code }}</label>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Image(s) supplémentaire(s)</label>
                                <div class="controls">
                                    <input type="file" name="image[]" id="image" multiple="multiple">
                                </div>
                            </div>
                            <div class="form-actions">
                                <input type="submit" value="Ajouter des images" class="btn btn-success">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
                        <h5>Voir les images du produit</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <table class="table table-bordered data-table">
                            <thead>
                                <tr>
                                    <th>ID de l'image</th>
                                    <th>ID du produit</th>
                                    <th>Image</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($productsImages as $image)
                                <tr class="gradeX">
                                    <td>{{ $image->id }}</td>
                                    <td>{{ $image->product_id }}</td>
                                    <td> <img style="width: 100px;"
                                            src="{{ asset('images/backend_images/product/small/'.$image->image) }}">
                                    </td>
                                    <td class="center">
                                        <a rel="{{ $image->id }}" rel1="delete-alt-image" href="javascript:"
                                            class="btn btn-danger btn-mini deleteRecord" title="Supprimer l'image du produit">Supprimer</a>
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