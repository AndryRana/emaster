@extends('layouts.adminLayout.admin_design')

@section('content')

<div id="content">
    <div id="content-header">
        <div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i>
                Accueil</a> <a href="#">Catégories</a> <a href="#" class="current">Ajouter une catégorie</a> </div>
        <h1>Catégories</h1>
    </div>
    <div class="container-fluid">
        <hr>
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
                        <h5>Ajouter une catégorie</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <form class="form-horizontal" method="post" action="{{ url('/admin/add-category') }}" 
                        name="add_category" id="add_category" novalidate="novalidate">
                            @csrf
                            <div class="control-group">
                                <label class="control-label">Nom de la catégorie</label>
                                <div class="controls">
                                    <input type="text" name="category_name" id="category_name">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Description</label>
                                <div class="controls">
                                    <textarea type="text" name="description" id="description" rows="5" ></textarea>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">URL</label>
                                <div class="controls">
                                    <input type="text" name="url" id="url">
                                </div>
                            </div>
                            <div class="form-actions">
                                <input type="submit" value="Ajouter une catégorie" class="btn btn-success">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection