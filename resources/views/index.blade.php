<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Armá Tu Evento</title>

        <!-- Full Calendar -->
        <link rel='stylesheet' href='/css/fullcalendar.min.css' />

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="/css/bootstrap.min.css">

	      <!-- <link rel="stylesheet" href="css/materialize.min.css"> -->
        <link rel="stylesheet" href="/css/starter-template.css">
        <link rel="stylesheet" href="/css/demo.css">
    </head>
    <body>
      <div ng-app="Client">
        <div ng-include="'/partials/navbar.html'"></div>
      </div>

  <script type="text/javascript" src="/js/jquery.min.js"></script>
  <script type="text/javascript" src='/js/moment.min.js'></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
  integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script type="text/javascript" src="/js/bootstrap.bundle.min.js"></script>

	<script type="text/javascript" src="/js/angular.min.js"></script>
	<script type="text/javascript" src="/js/angular-resource.min.js"></script>
  <script type="text/javascript" src="/js/angular-route.min.js"></script>
  <script type="text/javascript" src="/js/angular-ui-router.js"></script>
  <script type="text/javascript" src="/js/satellizer.js"></script>

  <!-- Main controller -->
  <script type="text/javascript" src="/js/router.js"></script>

	<!-- Full Calendar -->
  <script type="text/javascript" src='/js/fullcalendar.min.js'></script>
  <script type="text/javascript" src='/js/fullcalendar-es.js'></script>

  <!-- Image upload -->
  <script type="text/javascript" src='/js/imageupload.js'></script>

  <!-- Base64 file upload -->
  <script type="text/javascript" src='/js/angular-base64-upload.min.js'></script>

  <!-- Pusher -->
  <script type="text/javascript" src='/js/pusher.min.js'></script>

  <!-- pusher-angular -->
  <script src="//cdn.jsdelivr.net/npm/pusher-angular@latest/lib/pusher-angular.min.js"></script>

  <!-- pusher-angular (backup CDN)
  <script src="//cdnjs.cloudflare.com/ajax/libs/pusher-angular/1.0.0/pusher-angular.min.js"></script>
  -->

  <!-- Controllers -->
  <script type="text/javascript" src="/js/controllers/AdminCtrl.js"></script>
	<script type="text/javascript" src="/js/controllers/ClienteCtrl.js"></script>
  <script type="text/javascript" src="/js/controllers/ProveedorCtrl.js"></script>
  <script type="text/javascript" src="/js/controllers/PostCtrl.js"></script>
  <script type="text/javascript" src="/js/controllers/CertificadoCtrl.js"></script>
  <script type="text/javascript" src="/js/controllers/ResenaCtrl.js"></script>
  <script type="text/javascript" src="/js/controllers/HomepageCtrl.js"></script>
  <script type="text/javascript" src="/js/controllers/SearchCtrl.js"></script>
  <script type="text/javascript" src="/js/controllers/DemoCtrl.js"></script>
  <script type="text/javascript" src="/js/controllers/AuthLoginCtrl.js"></script>
  <script type="text/javascript" src="/js/controllers/PagoCtrl.js"></script>
  <script type="text/javascript" src="/js/controllers/DenunciaCtrl.js"></script>
  <script type="text/javascript" src="/js/controllers/TipoPagoCtrl.js"></script>
  <script type="text/javascript" src="/js/controllers/RubroCtrl.js"></script>
  <script type="text/javascript" src="/js/controllers/NotificationCtrl.js"></script>
  <script type="text/javascript" src="/js/controllers/SolicitudCtrl.js"></script>

  <!-- Resources -->
  <script type="text/javascript" src="/js/services/ClienteResource.js"></script>
  <script type="text/javascript" src="/js/services/CertificadoResource.js"></script>
	<script type="text/javascript" src="/js/services/ProveedorResource.js"></script>
	<script type="text/javascript" src="/js/services/PostResource.js"></script>
	<script type="text/javascript" src="/js/services/PostImageResource.js"></script>
  <script type="text/javascript" src="/js/services/ResenaResource.js"></script>
  <script type="text/javascript" src="/js/services/SearchResource.js"></script>
  <script type="text/javascript" src="/js/services/RubroResource.js"></script>
  <script type="text/javascript" src="/js/services/EventoResource.js"></script>
  <script type="text/javascript" src="/js/services/AuthService.js"></script>
  <script type="text/javascript" src="/js/services/DenunciaResource.js"></script>
  <script type="text/javascript" src="/js/services/ChatResource.js"></script>
  <script type="text/javascript" src="/js/services/TipoPagoResource.js"></script>
  <script type="text/javascript" src="/js/services/CertificadoProveedorResource.js"></script>
  <script type="text/javascript" src="/js/services/PagoResource.js"></script>
  <script type="text/javascript" src="/js/services/NotificacionResource.js"></script>
  <script type="text/javascript" src="/js/services/SolicitudResource.js"></script>


</body>
</html>
