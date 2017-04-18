<!DOCTYPE html>
<html lang="es">
    <?php include("template/head.php");?>
    <body class="hold-transition skin-blue sidebar-mini">
		<div class="wrapper">
			<?php include ('template/header.php');?>
			<?php $Menu=401;include("template/menu.php");?>
			<div class="content-wrapper">
				<section class="content-header">
					<?php
						$params = array($_SESSION['curs_para_codi']);
						$sql="{call curs_para_info(?)}";
						$curs_para_info = sqlsrv_query($conn, $sql, $params);  
						$row_curs_para_info = sqlsrv_fetch_array($curs_para_info);
				  	?>
					<h1>Roles</h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-circle-o"></i></a></li>
						<li class="active">Roles</li>
					</ol>
				</section>
				<section class="content" id="mainPanel">
					<div id="information">
						<div class="box box-default">
							<div class="box-header with-border">
								<h3 class="box-title">
									<?php if (permiso_activo(46)){?>
									<a class="btn btn-primary" onclick="document.getElementById('rol_deta').focus();" data-toggle="modal" data-target="#ModalRolAdd" title="">
										<span class="fa fa-plus"></span> Agregar Rol
									</a><?php }?>
								</h3>
							</div><!-- /.box-header -->
							<div class="box-body">
								<script type="text/javascript" src="js/funciones_usua.js"></script> 
								<div id="rol_main">
									<?php include ('roles_main_lista.php'); ?>
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
				$('#rol_table').DataTable() ;
			} );
		</script>
	</body>
</html>
<div class="modal fade" id="ModalRolAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Nuevo Rol</h4>
			</div>
			<div id="modal_main" class="modal-body">
				<div id="div_rol_nuev"> 
						<form 
							id="frm_rol_add" 
								name="frm_rol_add" 
								method="post" 
								action="" 
								enctype="multipart/form-data">
							<table style="width: 100%">
									<tr>
										<td width="25%">
											<label class='control-label' for="rol_deta">Descripci&oacute;n:</label>
										</td>
										<td>
											<input type="text" class='form-control input-sm'
												id="rol_deta" 
												name="rol_deta" 
												value="" 
												placeholder="Ingrese la descripci&oacute;n"
												style="width: 100%; margin-top: 5px;">
											 <input 
														type="hidden" 
															id="rol_estado" 
															name="rol_estado" 
															value="A">
										</td>
									</tr>
									<tr>
										<td>
											<label>
												Acceso a financiero:
											</label>
										</td>
										<td>
											<input
												id="rol_finan"
												type="checkbox"
												style="margin-top: 10px;">
										</td>
									</tr>
								</table>
						</form>
				</div>
				<div class="form_element">&nbsp;</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-success" onClick="load_ajax_add_rol('rol_main','script_usua.php','opc=add_rol&rol_deta='+document.getElementById('rol_deta').value+'&rol_estado='+document.getElementById('rol_estado').value+'&rol_finan='+document.getElementById('rol_finan').checked);" >Agregar</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="ModalRolEdi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Editar Rol</h4>
			</div>
			<div id="modal_main" class="modal-body">
				<div id="div_rol_edi"> 
						<form id="frm_rol_edi" name="frm_rol_edi" method="post" action="" enctype="multipart/form-data">
							<table style="width: 100%">
									<tr>
										<td width="25%">
											<label for="rol_deta_edi">
												Descripci&oacute;n: 
											</label>
										</td>
										<td>
											<input 
												type="text" 
												id="rol_deta_edi" 
												name="rol_deta_edi" 
												value="" 
												placeholder="Ingrese la descripci&oacute;n..."
												style="width: 100%; margin-top: 5px;">

											 <input 
												type="hidden" 
												id="rol_codi_edi" 
												name="rol_codi_edi" 
												value="">
										</td>
									</tr>
									<tr>
										<td>
											<label>
												Acceso a financiero:
											</label>
										</td>
										<td>
											<input
												id="rol_finan_edi"
												type="checkbox"
												style="margin-top: 10px;">
										</td>
									</tr>
								</table>
						</form>
				</div>
				<div class="form_element">&nbsp;</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-success" onClick="load_ajax_edi_rol('rol_main','script_usua.php','opc=upd_rol&rol_deta='+document.getElementById('rol_deta_edi').value+'&rol_codi='+document.getElementById('rol_codi_edi').value+'&rol_finan='+document.getElementById('rol_finan_edi').checked);" >Grabar</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>