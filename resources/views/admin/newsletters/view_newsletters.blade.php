@extends('layouts.adminLayout.admin_design')

@section('content')

<div id="content">
    <div id="content-header">
        <div id="breadcrumb"> <a href="index.html" title="Aller à l'accueil" class="tip-bottom"><i
                    class="icon-home"></i>
                Accueil</a> <a href="#">Newsletters</a> <a href="#" class="current">Voir les Abonnés Newsletter</a> </div>
        <h1>Newsletters</h1>

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
                        <h5>Voir les Abonnés Newsletter</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <table class="table table-bordered data-table">
                            <thead>
                                <tr>
                                    <th>ID Abonné</th>
                                    <th>Email</th>
                                    <th>statut</th>
                                    <th>Enregistré le</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($newsletters as $newsletter)
                                <tr class="gradeX">
                                    <td class="center">{{ $newsletter->id }}</td>
                                    <td class="center">{{ $newsletter->email }}</td>
                                    <td class="center">
                                        @if($newsletter->status==1)
                                          <span class="text-success">Active</span>
                                        @else
                                          <span class="text-error">Inactive</span>
                                        @endif
                                    </td>
                                    <td class="center">{{ $newsletter->created_at->format('d-m-Y H:i:s') }}</td>
                                    
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