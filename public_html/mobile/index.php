<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Gustavo Decker">
    <link rel="icon" href="../imagenes/favicon.png">
    <title>Educalinks | Documentación</title>
    <!-- Latest compiled and minified CSS 
    <link href="bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css"/>-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <!-- Optional theme 
    <link href="bootstrap/css/bootstrap-theme.css" rel="stylesheet" type="text/css"/>-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
    <link href="css/theme.css" rel="stylesheet">
    <link href="bootstrap/css/bootstrap-datepicker3.css" rel="stylesheet" type="text/css"/>
    <link href="//cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/build/css/bootstrap-datetimepicker.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/r/bs/dt-1.10.8,af-2.0.0,b-1.0.1,b-colvis-1.0.1,b-print-1.0.1,cr-1.2.0,fc-3.1.0,fh-3.0.0,kt-2.0.0,r-1.0.7,rr-1.0.0,sc-1.3.0,se-1.0.0/datatables.min.css"/>   
</head>
<body>
<div class="container-fluid">
    <div class="page-header">
    	<h1>Documentación de Métodos: </h1>
        <h1><small>Métodos de Interconexión: </small></h1>
    </div>
    <div class="row">
    	<div class="col-md-5">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Consulta de Clientes</h3>
                </div>
                <div class="panel-body">
                	<div class="row">
                    	<div class="col-md-12">
                        	<h3>Envío</h3>
                            <h3><small>Método de envío de los parámetros: <strong>POST</strong></small></h3>
                            <h3><small>Url de acceso: <span class="text-primary">http://demo.educalinks.com.ec/mobile/main.php</span></small></h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <h3><small>Parametros a enviar</small></h3>
                            <div class="list-group">
                                <a class="list-group-item cursor_link" data-container="body" title="Detalle del Parámetro" data-toggle="popover" data-placement="right" data-content="<ul><li>Tipo de Dato: varchar() </li><li> Valor por Defecto: listar_clientes</li></ul>" data-html="true">opcion</a>
								<a class="list-group-item cursor_link" data-container="body" title="Detalle del Parámetro" data-toggle="popover" data-placement="right" data-content="<ul><li>Tipo de Dato: integer </li><li> Valor por Defecto: 310</li></ul>" data-html="true">opci_codi</a>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                    	<div class="col-md-12">
                        	<h3>Respuesta</h3>
                            <h3><small>Listado JSON de información de los colegios clientes de Educalinks.</small></h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <h3><small>Parametros a recibir:</small></h3>
                            <div class="list-group">
                                <a class="list-group-item cursor_link" data-container="body" title="Detalle del Parámetro" data-toggle="popover" data-placement="right" data-content="<ul><li>Tipo de Dato: int </li><li> Descripción: Código de cliente de Educalinks."  data-html="true" >id</a>
                                <a class="list-group-item cursor_link" data-container="body" title="Detalle del Parámetro" data-toggle="popover" data-placement="right" data-content="<ul><li>Tipo de Dato: varchar() </li><li> Descripción: Nombre del cliente de Educalinks.</li></ul>" data-html="true">texto</a>
                            </div>
                        </div>
                    </div>
                    <form method="post" enctype="multipart/form-data" id="frm_test_list_clie" name="frm_test_list_clie" action="main.php" target="_blank">
                    	<input type="hidden" id="opcion" name="opcion" value="listar_clientes"/>
						<input type="hidden" id="opci_codi" name="opci_codi" value="310"/>
                    	<button class="btn btn-success" type="submit"><span class="glyphicon glyphicon-eye-open"></span> Live Preview</button>
                    </form>
                </div>
            </div>
    	</div>
    </div>
    <div class="row">
    	<div class="col-md-5">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Login para Representantes</h3>
                </div>
                <div class="panel-body">
                	<div class="row">
                    	<div class="col-md-12">
                        	<h3>Envío</h3>
                            <h3><small>Método de envío de los parámetros: <strong>POST</strong></small></h3>
                            <h3><small>Url de acceso: <span class="text-primary">http://desarrollo.educalinks.com.ec/mobile/main.php</span></small></h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <h3><small>Parametros a enviar:</small></h3>
                            <div class="list-group">
                                <a class="list-group-item cursor_link" data-container="body" title="Detalle del Parámetro" data-toggle="popover" data-placement="right" data-content="<ul><li>Tipo de Dato: int </li><li> Descripción: Codigo de cliente de Educalinks</li></ul>"  data-html="true">colegio</a>
                                <a class="list-group-item cursor_link" data-container="body" title="Detalle del Parámetro" data-toggle="popover" data-placement="right" data-content="<ul><li>Tipo de Dato: varchar(50) </li><li> Descripción: nombre de usuario del representante</li></ul>"  data-html="true">username</a>
                                <a class="list-group-item cursor_link" data-container="body" title="Detalle del Parámetro" data-toggle="popover" data-placement="right" data-content="<ul><li>Tipo de Dato: varchar(100) </li><li> Descripción: Contraseña del representante</li></ul>"  data-html="true">password</a>
                                <a class="list-group-item cursor_link" data-container="body" title="Detalle del Parámetro" data-toggle="popover" data-placement="right" data-content="<ul><li>Tipo de Dato: int </li><li> Valor por Defecto: 2</li></ul>"  data-html="true">tipo_usua</a>
                                <a class="list-group-item cursor_link" data-container="body" title="Detalle del Parámetro" data-toggle="popover" data-placement="right" data-content="<ul><li>Tipo de Dato: varchar() </li><li> Valor por Defecto: login_representante</li></ul>" data-html="true">opcion</a>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                        	<h3>Respuesta</h3>
                            <h3><small>JSON de información sobre el resultado del login de los representantes.</small></h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <h3><small>Parametros a recibir:</small></h3>
                            <div class="list-group">
                                <a class="list-group-item cursor_link" data-container="body" title="Detalle del Parámetro" data-toggle="popover" data-placement="right" data-content="<ul><li>Tipo de Dato: varchar(2) </li><li> Descripción: los posibles valores a devolver son: <ul><li>OK</li><li>KO</li></ul></li></ul>"  data-html="true" >exito</a>
                                <a class="list-group-item cursor_link" data-container="body" title="Detalle del Parámetro" data-toggle="popover" data-placement="right" data-content="<ul><li>Tipo de Dato: varchar() </li><li> Descripción: mensaje de autenticación exitoso o fallido.</li></ul>" data-html="true">mensaje</a>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                    	<div class="col-md-6">
                        	<form method="post" enctype="multipart/form-data" id="frm_test_list_clie" name="frm_test_list_clie" action="main.php" target="_blank">
                            	<input type="text" class="form-control" id="username" name="username" value="0915861496"/>
                                <input type="text" class="form-control" id="password" name="password" value="0915861496"/>
                                <input type="hidden" id="tipo_usua" name="tipo_usua" value="2"/>
                                <input type="text" class="form-control" id="colegio" name="colegio" value="12"/>
                                <input type="hidden" id="opcion" name="opcion" value="login_representante"/>
                            	<button class="btn btn-success" type="submit"><span class="glyphicon glyphicon-eye-open"></span> Live Preview</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
    	</div>
    </div>
</div>
<!-- Bootstrap core JavaScript
================================================== -->
<!-- Latest compiled and minified JQuery 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>-->
<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script src="bootstrap/js/bootstrap-datepicker.min.js"></script>
<script src="bootstrap/js/bootstrap-datepicker.es.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>
<script src="//cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/src/js/bootstrap-datetimepicker.js"></script>
<script src="https://cdn.datatables.net/r/bs/dt-1.10.8,af-2.0.0,b-1.0.1,b-colvis-1.0.1,b-print-1.0.1,cr-1.2.0,fc-3.1.0,fh-3.0.0,kt-2.0.0,r-1.0.7,rr-1.0.0,sc-1.3.0,se-1.0.0/datatables.min.js" type="text/javascript" ></script>
<script src="../framework/js/bootstrap3-typeahead.js"></script>
<script>
$(function () {
  $('[data-toggle="popover"]').popover()
})
</script>
</body>
</html>