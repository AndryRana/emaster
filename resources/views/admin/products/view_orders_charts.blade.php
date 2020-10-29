<?php
setlocale(LC_TIME,'fr_FR');
date_default_timezone_set('Europe/Paris');
$current_month = ucfirst(strftime('%b'));
$last_month = ucfirst(strftime('%b',strtotime("-1 month")));
$last_to_last_month = ucfirst(strftime('%b',strtotime("-2 month")));
?>
@extends('layouts.adminLayout.admin_design')

@section('content')
<script>
    window.onload = function () {
    
    var chart = new CanvasJS.Chart("chartContainer", {
        animationEnabled: true,
        theme: "light2", // "light1", "light2", "dark1", "dark2"
        title:{
            text: "Statistiques des commandes"
        },
        axisY: {
            title: "Nombre de Commandes"
        },
        data: [{        
            type: "column",  
            showInLegend: true, 
            legendMarkerColor: "grey",
            legendText: "3 derniers mois",
            dataPoints: [      
			    { y: <?php echo $last_to_last_month_orders; ?>,  label: "<?php echo $last_to_last_month; ?>" },
			    { y: <?php echo $last_month_orders; ?>,  label: "<?php echo $last_month; ?>" },
                { y: <?php echo $current_month_orders; ?>, label: "<?php echo $current_month; ?>" }
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
                Accueil</a> <a href="#">Statistiques des commandes</a> <a href="#" class="current">Voir les statistiques des commandes</a> </div>
        <h1>Commandes</h1>

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
                        <h5>Statistiques des commandes</h5>
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