<?php 
session_start();
include("../core/rutas.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="es">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>{proyecto} | {subtitulo}</title>

	<link href="{ruta_imagenes_common}/bootstrap/css/bootstrap.css" rel="stylesheet">
	<link href="{ruta_imagenes_common}/bootstrap/css/theme.css" rel="stylesheet">
	<link href="{ruta_imagenes_common}/bootstrap/css/bootstrap-theme.css" rel="stylesheet">
	<link href="{ruta_imagenes_common}/jquery/jquery-ui/jquery-ui.css" rel="stylesheet">
	<link rel="shortcut icon" href="{ruta_imagenes_common}/favicon.png" />
	<link rel="stylesheet" type="text/css" media="screen" href="{ruta_imagenes_common}/bootstrap/css/datatable-bootstrap.css">
	<script src="{ruta_imagenes_common}/jquery/jquery-2.1.1.js"></script>
	<script src="{ruta_imagenes_common}/bootstrap/js/bootstrap.js"></script>
	<script src="{ruta_imagenes_common}/jquery/jquery-ui/jquery-ui.js"></script>
	<script src="{ruta_js_finan}/roles_usuarios.js"></script>
	<script src="{ruta_js_finan}/general.js"></script>
	<script src="{ruta_js_common}/mensajeria.js"></script>

	<script type="text/javascript" src="{ruta_imagenes_common}/bootstrap/js/datatable.js"></script>
</head>
<body>
	{navbar}
    <div class="container-fluid">
      <!-- MENU-->
      {menu}
      <!-- MENU-->
      <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main main_content">
        <h1 class="page-header">{subtitulo}</h1>
        <div id="mensaje">
            <h3>{mensaje}</h3>
        </div>
        <div id="formulario">
            {formulario}
        </div>
        <form id="frm_rutas" name="frm_rutas" enctype="multipart/form-data" method="post">
			{rutas_all}
        </form>
      </div>
    </div>
    <script type="text/javascript" charset="utf-8">
	$(document).ready(function() {
		actualiza_badge_gest_fact();
		$('#rol_table').datatable({
			pageSize: 4,
			sort: [true,true, true, false],
			filters: [true,true,true,false],
			filterText: 'Buscar... '
			}) ;
		} );
	</script>
</body>
</html>
