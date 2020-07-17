@extends('layouts.adminLayout.admin_design')

@section('content')
    
<div id="content">
    <div id="content-header">
        <div id="breadcrumb"> <a href="index.html" title="Aller à l'accueil" class="tip-bottom"><i class="icon-home"></i>
                Accueil</a> <a href="#">Catégories</a> <a href="#" class="current">Modifier une catégorie</a> </div>
        <h1>Catégories</h1>
    </div>
    <div class="container-fluid">
        <hr>
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
                        <h5>Modifier une catégorie</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <form class="form-horizontal" method="post" action="{{ url('/admin/edit-category/' . $categoryDetails->id) }}" 
                        name="add_category" id="add_category" novalidate="novalidate">
                            @csrf
                            <div class="control-group">
                                <label class="control-label">Nom de la catégorie</label>
                                <div class="controls">
                                    <input type="text" name="category_name" id="category_name" value="{{ $categoryDetails->name }}">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Niveau de la catégorie</label>
                                <div class="controls">
                                    <select name="parent_id" style="width: 220px" >
                                        <option value="0">Catégorie principale</option>
                                        @foreach ($levels as $val)
                                            <option value="{{ $val->id }}" @if($val->id == $categoryDetails->parent_id) selected @endif>{{ $val->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Description</label>
                                <div class="controls">
                                    <textarea type="text" name="description" id="description" rows="5">{{ $categoryDetails->description }}</textarea>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">URL</label>
                                <div class="controls">
                                    <input type="text" name="url" id="url" value="{{ $categoryDetails->url }}">
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