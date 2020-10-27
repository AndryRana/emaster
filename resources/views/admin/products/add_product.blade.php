@extends('layouts.adminLayout.admin_design')

@section('content')

<div id="content">
    <div id="content-header">
        <div id="breadcrumb"> <a href="index.html" title="Aller à l'accueil" class="tip-bottom"><i
                    class="icon-home"></i>
                Accueil</a> <a href="#">Produits</a> <a href="#" class="current">Ajouter un produit</a> </div>
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
                        <h5>Ajouter un produit</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <form enctype="multipart/form-data" class="form-horizontal" method="post"
                            action="{{ url('/admin/add-product') }}" name="add_product" id="add_product"
                            novalidate="novalidate">
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
                                    <input type="text" name="product_name" id="product_name" >
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Code du produit</label>
                                <div class="controls">
                                    <input type="text" name="product_code" id="product_code">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Couleur du produit</label>
                                <div class="controls">
                                    <input type="text" name="product_color" id="product_color">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Description</label>
                                <div class="controls">
                                    <textarea type="text" name="description" id="description" rows="5" class="textarea_editor span12"></textarea>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Matériel et entretien</label>
                                <div class="controls">
                                    <textarea type="text" name="care" id="care" rows="5" class="textarea_care span12"></textarea>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Manches</label>
                                <div class="controls">
                                    <select name="sleeve" style="width: 220px;">
                                        <option value="none" selected disabled >Selectionner la manche</option>
                                        @foreach ($sleeveArray as $sleeve)
                                        <option value="{{ $sleeve }}">{{ $sleeve }}</option>
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
                                        <option value="{{ $pattern }}">{{ $pattern }}</option>
                                        @endforeach 
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Prix</label>
                                <div class="controls">
                                    <input type="text" name="price" id="price">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Poids (g)</label>
                                <div class="controls">
                                    <input type="text" name="weight" id="weight">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Image</label>
                                <div class="controls">
                                    <input type="file" name="image" id="image">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Video</label>
                                <div class="controls">
                                    <input type="file" name="video" id="video">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Caractéristique</label>
                                <div class="controls">
                                    <input type="checkbox" name="feature_item" id="feature_item" value="1">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Afficher</label>
                                <div class="controls">
                                    <input type="checkbox" name="status" id="status" value="1">
                                </div>
                            </div>
                            <div class="form-actions">
                                <input type="submit" value="Ajouter un produit" class="btn btn-success">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection