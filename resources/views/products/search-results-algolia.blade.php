@extends('layouts.frontLayout.front_design')

@section('content')

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

<div class="container">
    <h2 class="title text-center">Resultats de recherche</h2>
        <div id="search-box" class="flex justify-center">
            <!-- SearchBox widget will appear here -->
        </div>
        
        <div id="stats-container" class="flex justify-center">
            
        </div>
    <div class="search-results-container-algolia">
        <div>
            <div class="spacer"></div>
            {{-- <h2>Categories</h2> --}}
            <div id="refinement-list">
                <!-- RefinementList widget will appear here -->
            </div>
        </div>

        <div >
            <div id="hits" >
                <!-- Hits widget will appear here -->
            </div>

            <div id="pagination">
                <!-- Pagination widget will appear here -->
            </div>
        </div>
    </div> <!-- end search-results-container-algolia -->
</div> <!-- end container -->

@endsection
