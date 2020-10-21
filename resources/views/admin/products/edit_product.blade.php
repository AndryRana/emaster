@extends('layouts.adminLayout.admin_design')

@section('content')

<div id="content">
    <div id="content-header">
        <div id="breadcrumb"> <a href="index.html" title="Aller à l'accueil" class="tip-bottom"><i
                    class="icon-home"></i>
                Accueil</a> <a href="#">Produits</a> <a href="#" class="current">Modifier le produit</a> </div>
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
                        <h5>Modifier le produit</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <form enctype="multipart/form-data" class="form-horizontal" method="post"
                            action="{{ url('/admin/edit-product/' . $productDetails->id) }}" name="edit_product"
                            id="edit_product" novalidate="novalidate">
                            @csrf
                            <div class="control-group">
                                <label class="control-label">Choisir une catégorie</label>
                                <div class="controls">
                                    <select name="category_id" id="category_id" style="width: 220px;">
                                        <?php echo $categories_drop_down; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                    <label class="control-label">Nom du produit</label>
                                    <div class="controls">
                                        <input type="text" name="product_name" id="product_name"
                                            value="{{ $productDetails->product_name }}">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Code du produit</label>
                                    <div class="controls">
                                        <input type="text" name="product_code" id="product_code"
                                            value="{{ $productDetails->product_code }}">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Couleur du produit</label>
                                    <div class="controls">
                                        <input type="text" name="product_color" id="product_color"
                                            value="{{ $productDetails->product_color }}">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Description</label>
                                    <div class="controls">
                                        <textarea type="text" name="description" id="description"
                                            rows="5"> {{ $productDetails->description }}</textarea>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Manches</label>
                                    <div class="controls">
                                        <select name="sleeve" style="width: 220px;">
                                            <option value="none" selected disabled >Selectionner la manche</option>
                                            @foreach ($sleeveArray as $sleeve)
                                                <option value="{{ $sleeve }}" @if (!empty($productDetails->sleeve) && $productDetails->sleeve==$sleeve) selected @endif>{{ $sleeve }}</option>
                                            @endforeach 
                                        </select>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Modèle</label>
                                    <div class="controls">
                                        <select name="pattern" style="width: 220px;">
                                            <option value="none" selected disabled >Selectionner le modèle</option>
                                            @foreach ($patternArray as $pattern)
                                            <option value="{{ $pattern }}" @if (!empty($productDetails->pattern) && $productDetails->pattern==$pattern) selected @endif>{{ $pattern }}</option>
                                            @endforeach 
                                        </select>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Prix</label>
                                    <div class="controls">
                                        <input type="text" name="price" id="price" value="{{ $productDetails->price }}">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Image</label>
                                    <div class="controls flex flex-row items-center">
                                        <input type="file" name="image" id="image">
                                        @if (!empty($productDetails->image))
                                        <input type="hidden" name="current_image" value="{{ $productDetails->image }}">
                                        <img style="width: 50px;"
                                            src="{{ asset('/images/backend_images/product/small/'. $productDetails->image) }}">
                                        
                                        <a
                                            href="{{ url('/admin/delete-product-image/' . $productDetails->id) }}" class="text-white bg-red-500 px-3 py-1 hover:text-black">Supprimer</a>
                                        @endif
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Video</label>
                                    <div class="controls ">
                                        <input type="file" name="video" id="video">
                                        @if (!empty($productDetails->video))
                                            <input type="hidden" name="current_video" value="{{ $productDetails->video }}">
                                            <a target="_blank" href="{{ url('videos/'.$productDetails->video) }}" class="text-white bg-blue-500 px-3 py-1  hover:text-black">Voir la vidéo</a>
                                            <a href="{{ url('/admin/delete-product-video/' . $productDetails->id) }}" class="text-white bg-red-500 px-3 py-1 hover:text-black">Supprimer</a>
                                        @endif
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Caratctéristique</label>
                                    <div class="controls">
                                        <input type="checkbox" name="feature_item" id="feature_item"
                                            @if($productDetails->feature_item=="1") checked
                                        @endif value="1" >
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Afficher</label>
                                    <div class="controls">
                                        <input type="checkbox" name="status" id="status"
                                            @if($productDetails->status=="1") checked
                                        @endif value="1" >
                                    </div>
                                </div>
                                <div class="form-actions">
                                    <input type="submit" value="Modifier le produit" class="btn btn-success">
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection