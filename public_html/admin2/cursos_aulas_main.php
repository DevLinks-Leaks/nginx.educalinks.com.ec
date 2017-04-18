<!DOCTYPE html>
<html lang="es">
    <?php include("template/head.php");?>
    <body class="hold-transition skin-blue sidebar-mini">
		<div class="wrapper">
			<?php include ('template/header.php');?>
			<?php $Menu=204;include("template/menu.php");?>
			<div class="content-wrapper">
				<section class="content-header">
					<h1>Aulas</h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-circle-o"></i></a></li>
						<li class="active">Aulas</li>
					</ol>
				</section>
				<section class="content" id="mainPanel">
					<div id="information">
						<div class="box box-default">
							<div class="box-header with-border">
								<h3 class="box-title">
									<?php if (permiso_activo(40)){?>
									<a class="btn btn-primary" id='bt_aula_add' onclick="document.getElementById('aula_deta').value='';" data-toggle="modal" data-target="#Aula_nuev" >
										<span class="fa fa-plus"></span> Agregar Aulas
									</a><?php }?>
								</h3>
							</div><!-- /.box-header -->
							<div class="box-body">
								<script type="text/javascript" src="../framework/funciones.js"> </script>
								<div id="curs_aula_main" >
									<?php include ('cursos_aulas_main_lista.php'); ?>
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
			$(document).ready(function() {
			} );
		</script>
	</body>
</html>
<div class="modal fade" id="Aula_nuev" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title" id="myModalLabel">Nueva Aula</h4>
			</div>
			<div class="modal-body">
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td>Nombre: </td>
						<td><input class='form-control input-sm' id="aula_deta" name="aula_deta" type="text" value=""></td>
					</tr>
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-success"  data-dismiss="modal" 
					onClick="load_ajax('curs_aula_main','cursos_aulas_main_lista.php','aula_deta=' + document.getElementById('aula_deta').value  + '&add_aula=Y'); ">
						<span class="fa fa-floppy-o"></span> Guardar Cambios</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>
             