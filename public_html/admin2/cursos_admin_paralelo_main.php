<!DOCTYPE html>
<html lang="es">
    <?php include("template/head.php");?>
    <body class="hold-transition skin-blue sidebar-mini <?php echo $_SESSION['sidebar_status']; ?>">
		<div class="wrapper">
			<?php include ('template/header.php');?>
			<?php $Menu=215;include("template/menu.php");?>
			<div class="content-wrapper">
				<section class="content-header">
					<h1>Paralelos</h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-list-alt"></i></a></li>
						<li class="active">Paralelos</li>
					</ol>
				</section>
				<section class="content" id="mainPanel">
					<div id="information">
						<div class="box box-default">
							<div class="box-header with-border">
								<h3 class="box-title">
									<?php if (permiso_activo(43)){?>
									<a id='bt_para_add' class="btn btn-primary" onclick="document.getElementById('para_deta').value='';" data-toggle="modal" data-target="#para_nuev">
										<span class="fa fa-plus"></span> Agregar Nuevo Paralelo
									</a><?php }?>
								</h3>
							</div><!-- /.box-header -->
							<div class="box-body">
								<script type="text/javascript" src="../framework/funciones.js"> </script>
								<div id="curs_para_main" >
									<?php include ('cursos_admin_paralelo_main_lista.php'); ?>
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
<div class="modal fade" id="para_nuev" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title" id="myModalLabel">Nuevo Paralelo</h4>
			</div>
			<div class="modal-body">
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td>Nombre: </td>
						<td><input class='form-control input-sm' id="para_deta" name="para_deta" type="text" value=""></td>
					</tr>
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-success"  data-dismiss="modal" 
					onClick="load_ajax('curs_para_main','cursos_admin_paralelo_main_lista.php','para_deta=' + document.getElementById('para_deta').value  + '&add_para=Y'); ">
					<span class="fa fa-floppy-o"></span> Guardar Cambios</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>