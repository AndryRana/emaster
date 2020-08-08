@extends('layouts.adminLayout.admin_design')

@section('content')

<div id="content">
    <div id="content-header">
        <div id="breadcrumb"> <a href="index.html" title="Aller à l'accueil" class="tip-bottom"><i
                    class="icon-home"></i>
                Accueil</a> <a href="#">Attributs</a> <a href="#" class="current">Ajouter les attributs du produit</a>
        </div>
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
                    <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
                        <h5>Ajouter les Attributs du produit</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <form enctype="multipart/form-data" class="form-horizontal" method="post"
                            action="{{ url('/admin/add-attributes/'.$productDetails->id) }}" name="add-attribute"
                            id="add-attribute">
                            @csrf

                            <input type="hidden" name="product_id" value="{{ $productDetails->id }}">

                            <div class="control-group">
                                <label class="control-label">Nom de la catégorie</label>
                                <label class="control-label">
                                    {{-- {{ $category_name }} --}}
                                </label>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Nom du produit</label>
                                <label class=" control-label">{{ $productDetails->product_name }}</label>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Code du produit</label>
                                <label class=" control-label">{{ $productDetails->product_code }}</label>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Couleur du produit</label>
                                <label class=" control-label">{{ $productDetails->product_color }}</label>
                            </div>
                            <div class="control-group">
                                <label class="control-label"></label>
                                <div class="controls field_wrapper">
                                    <input required type="text" name="sku[]" id="sku" placeholder="SKU"
                                        style="width:120px;" />
                                    <input required type="text" name="size[]" id="size" placeholder="Size"
                                        style="width:120px;" />
                                    <input required type="text" name="price[]" id="price" placeholder="Price"
                                        style="width:120px;" />
                                    <input required type="text" name="stock[]" id="stock" placeholder="Stock"
                                        style="width:120px;" />
                                    <a href="javascript:void(0);" class="add_button" title="Add field">
                                        Ajouter
                                    </a>
                                </div>

                            </div>
                            <div class="form-actions">
                                <input type="submit" value="Ajouter les attributs" class="btn btn-success">
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
                        <h5>Voir les attributs du produit</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <form action="{{ url('/admin/edit-attributes/'.$productDetails->id) }}" method="POST">
                            @csrf
                            <table class="table table-bordered data-table">
                                <thead>
                                    <tr>
                                        <th>ID de l'attribut</th>
                                        <th>SKU</th>
                                        <th>Taille</th>
                                        <th>Prix</th>
                                        <th>Stock</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($productDetails['attributes'] as $attribute)
                                    <tr class="gradeX">
                                        <td><input type="hidden" name="idAttr[]" value="{{ $attribute->id }}" >{{ $attribute->id }}</td>
                                        <td>{{ $attribute->sku }}</td>
                                        <td>{{ $attribute->size }}</td>
                                        <td><input type="text" name="price[]" value="{{ $attribute->price }}"></td>
                                        <td><input type="text" name="stock[]" value="{{ $attribute->stock }}"></td>
                                        <td class="center">
                                            <input type="submit" value="Update" class="btn btn-primary btn-mini">
                                            <a rel="{{ $attribute->id }}" rel1="delete-attribute" href="javascript:"
                                                class="btn btn-danger btn-mini deleteRecord">Supprimer</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection