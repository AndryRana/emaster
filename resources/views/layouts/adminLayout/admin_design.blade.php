<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <title>Emaster Admin</title>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="{{ asset('css/backend_css/bootstrap.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/backend_css/bootstrap-responsive.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/backend_css/select2.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/backend_css/uniform.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/backend_css/fullcalendar.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/backend_css/matrix-style.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/backend_css/matrix-media.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/backend_css/sweetalert.css') }}" />
  <link href="{{ asset('css/backend_css/font-awesome.css') }}" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('css/backend_css/jquery.gritter.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/backend_css/jquery-ui.css') }}" />
  <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>
</head>

<body>

  @include('layouts.adminLayout.admin_header')

  @include('layouts.adminLayout.admin_sidebar')

  @yield('content')

  @include('layouts.adminLayout.admin_footer')

  

<script src="{{ asset('js/backend_js/jquery.min.js') }}"></script> 
{{-- <script src="{{ asset('js/backend_js/jquery.ui.custom.js') }}"></script>  --}}
<script src="{{ asset('js/backend_js/bootstrap.min.js') }}"></script> 
<script src="{{ asset('js/backend_js/jquery.uniform.js') }}"></script> 
<script src="{{ asset('js/backend_js/select2.min.js') }}"></script> 
<script src="{{ asset('js/backend_js/jquery.dataTables.min.js') }}"></script> 
<script src="{{ asset('js/backend_js/jquery.validate.js') }}"></script> 
<script src="{{ asset('js/backend_js/matrix.js') }}"></script> 
<script src="{{ asset('js/backend_js/matrix.form_validation.js') }}"></script>
<script src="{{ asset('js/backend_js/matrix.tables.js') }}"></script>
<script src="{{ asset('js/backend_js/matrix.popover.js') }}"></script>
<script src="{{ asset('vendor/sweetalert/sweetalert.all.js') }}"></script>
<script src="{{ asset('js/backend_js/jquery-ui.js') }}"></script>
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script> --}}
{{-- @include('sweetalert::alert') --}}
<script>
  $( function() {
    $( "#expiry_date" ).datepicker({
altField: "#datepicker",
closeText: 'Fermer',
prevText: 'Précédent',
nextText: 'Suivant',
currentText: 'Aujourd\'hui',
monthNames: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
monthNamesShort: ['Janv.', 'Févr.', 'Mars', 'Avril', 'Mai', 'Juin', 'Juil.', 'Août', 'Sept.', 'Oct.', 'Nov.', 'Déc.'],
dayNames: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
dayNamesShort: ['Dim.', 'Lun.', 'Mar.', 'Mer.', 'Jeu.', 'Ven.', 'Sam.'],
dayNamesMin: ['D', 'L', 'M', 'M', 'J', 'V', 'S'],
weekHeader: 'Sem.',
dateFormat: 'yy-mm-dd',
minDate: 0
});
});
  </script>
</body>

</html>