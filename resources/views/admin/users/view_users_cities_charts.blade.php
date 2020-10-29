@extends('layouts.adminLayout.admin_design')

@section('content')
<script>
	window.onload = function() {
	
	var chart = new CanvasJS.Chart("chartContainer", {
		animationEnabled: true,
		title: {
			text: "Utilisateurs par Ville"
		},
		data: [{
			type: "pie",
			startAngle: 240,
			yValueFormatString: "##0.00\"%\"",
			indexLabel: "{label} {y}",
			dataPoints: [
				{y: <?php echo $getUserCities[0]['count']; ?>, label: "<?php echo $getUserCities[0]['city']; ?>"},
				{y: <?php echo $getUserCities[1]['count']; ?>, label: "<?php echo $getUserCities[1]['city']; ?>"},
				{y: <?php echo $getUserCities[2]['count']; ?>, label: "<?php echo $getUserCities[2]['city']; ?>"},
			]
		}]
	});
	chart.render();
	
	}
	</script>

<div id="content">
    <div id="content-header">
        <div id="breadcrumb"> <a href="index.html" title="Aller à l'accueil" class="tip-bottom"><i
                    class="icon-home"></i>
                Accueil</a> <a href="#">Graphique Utilisateurs par ville</a> <a href="#" class="current">Graphique Utilisateurs par ville</a> </div>
        <h1>Utilisateurs par Ville</h1>

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
                        <h5>Graphique Utilisateurs par ville</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <div id="chartContainer" style="height: 370px; width: 100%;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
@endsection