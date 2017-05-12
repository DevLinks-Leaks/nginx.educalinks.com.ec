<!DOCTYPE html>
<html lang="es">
    <?php include("template/head.php");?>
    <body class="hold-transition skin-blue sidebar-mini">
		<div class="wrapper">
			<?php include ('template/header.php');?>
			<?php $Menu=103;include("template/menu.php");?>
			<div class="content-wrapper">
				<section class="content-header">
					<?php
						$params = array($_SESSION['curs_para_codi']);
						$sql="{call curs_para_info(?)}";
						$curs_para_info = sqlsrv_query($conn, $sql, $params);  
						$row_curs_para_info = sqlsrv_fetch_array($curs_para_info);
				  	?>
					<h1>Representantes</h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-heart-o"></i></a></li>
						<li class="active">Representantes</li>
					</ol>
				</section>
				<section class="content" id="mainPanel">
					<div id="information">
						<div class='panel panel-info dismissible' id='panel_search' name='panel_search'>
							<div class="panel-heading">
								<h3 class="panel-title"><span class="fa fa-search"></span>&nbsp;Búsqueda
									<div class="pull-right">
										<a href="#/"  id="boton_busqueda" name="boton_busqueda" style='text-decoration:none;'><span class='fa fa-minus'></span></a>
										<!--<a href="#/" data-target="#panel_search" data-dismiss="alert" aria-hidden="true"><span class='fa fa-times'></span></a>-->
									</div>
								</h3>
							</div>
							<div class="panel-body" id="desplegable_busqueda" name="desplegable_busqueda">
								<div id="tbl_search" class="form-horizontal" role="form">
									<div class='col-md-11 col-sm-12'>
										<div class='form-group'>
											<label class="col-md-2 col-sm-4 control-label" style='text-align: right;' for='alum_codi_in'>No. id.:</label>
											<div class="col-md-4 col-sm-8">
												<input type="text" class="form-control input-sm" name="alum_codi_in" id="alum_codi_in" >
											</div>
											<label class="col-md-2 col-sm-4 control-label" style='text-align: right;' for='alum_apel_in'>Apellidos:</label>
											<div class="col-md-4 col-sm-8"
													data-placement="bottom"
													title='Apellidos del representante'
													onmouseover='$(this).tooltip("show")'>
												<input type="text" class="form-control input-sm" name="alum_apel_in" id="alum_apel_in" >
											</div>
										</div>
									</div>
									<div class='col-md-1 col-sm-12'>
										<button id='btn_buscar_representantes' name='btn_buscar_representantes' class="btn btn-primary"
												title="Presione [Enter] para buscar alumno(s)"
												onclick="js_alumnos_repr_main_search(document.getElementById('alum_codi_in').value,document.getElementById('alum_apel_in').value);">
													<span class="fa fa-search"></span></button></td>
									</div>
								</div>
							</div>
						</div>
						<div class="representantes_main_lista">
							<div class="box box-default">
								<div class="box-header with-border">
									<h3 class="box-title">Listado de representantes</h3>
								</div><!-- /.box-header -->
								<div class="box-body">
									<div id="repr_main">
									</div>
								</div>
							</div>
						</div>
		            </div>
				</section>
				<?php include("template/menu_sidebar.php");?>
			</div>
			<form id="frm_actu" name="frm_actu" method="post" action="" enctype="multipart/form-data">
				<?php include("template/rutas.php");?>
			</form>
			<?php include("template/footer.php");?>
		</div>
		<!-- =============================== -->
		<input name="mens_de"  		type="hidden" id="mens_de" 		value='<?php echo $_SESSION['USUA_DE'];  ?>'    />
		<input name="mens_de_tipo"  type="hidden" id="mens_de_tipo" value='<?php echo $_SESSION['USUA_TIPO']; ?>'    />
		<?php include("template/scripts.php");?>
		<script type="text/javascript" charset="utf-8">
			shortcut.add("Enter", function() {
				$('#btn_buscar_representantes').trigger("click");
			},{'target':document.getElementById('tbl_search')});
			
			$(document).ready(function() {
                $("#boton_busqueda").click(function(){
					$("#desplegable_busqueda").slideToggle(200);
				});
				$("#desplegable_busqueda").show();
			} );
		</script>
	</body>
</html>