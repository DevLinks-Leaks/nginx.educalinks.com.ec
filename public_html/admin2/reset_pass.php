<!DOCTYPE html>
<html lang="es">
    <?php include("template/head.php");?>
    <body class="hold-transition skin-blue sidebar-mini <?php echo $_SESSION['sidebar_status']; ?>">
		<div class="wrapper">
			<?php include ('template/header.php');?>
			<?php $Menu=503;include("template/menu.php");?>
			<div class="content-wrapper">
				<section class="content-header">
					<?php
						$params = array($_SESSION['curs_para_codi']);
						$sql="{call curs_para_info(?)}";
						$curs_para_info = sqlsrv_query($conn, $sql, $params);  
						$row_curs_para_info = sqlsrv_fetch_array($curs_para_info);
				  	?>
					<h1>Reseteo de Clave</h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-ket"></i></a></li>
						<li class="active">Reseteo de Clave</li>
					</ol>
				</section>
				<section class="content" id="mainPanel">
					<div id="information">
						<div class="box box-default">
							<div class="box-header with-border">
								<h3 class="box-title"></h3>
							</div><!-- /.box-header -->
							<div class="box-body">
								<div id="usua_main" >
									 <?php include ('reset_pass_main.php'); ?>
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
		<script type="text/javascript" src="js/funciones_reset.js?<?=$rand;?>"></script> 
		<script type="text/javascript" charset="utf-8">
			$(document).ready(function() {
				$('#usua_table').DataTable({
					language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'},
				 	"bSort": false 
				}) ;
			} );
		</script>
	</body>
</html>
<div class="modal fade" id="ModalUsuaEdi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Resetear Clave Usuario</h4>
			</div>
			<div id="modal_main" class="modal-body">
				<div id="div_usua_edi"> 
				   <form id="frm_usua_edi" name="frm_usua_edi" method="post" action="" enctype="multipart/form-data">
						<div class="form_element"> 
						<table width="100%;" class="table">
						<tr>
							<td width="25%"><label for="usua_nombre_edi">Nombres: </label></td>
							<td width="75%"><input type="text" class="form-control input-sm"id="usua_nombre_edi" name="usua_nombre_edi" value="" placeholder="Ingrese los nombres..." disabled="disabled"></td>
						</tr>
						<tr>
							<td><label for="usua_apellido_edi">Apellidos: </label></td>
							<td><input type="text" class="form-control input-sm"id="usua_apellido_edi" name="usua_apellido_edi" value="" placeholder="Ingrese los apellidos..." disabled="disabled"></td>
						</tr>
						<tr>
							<td><label for="usua_email_edi">Email: </label></td>
							<td><input type="text" class="form-control input-sm"id="usua_email_edi" name="usua_email_edi" value="" placeholder="Ingrese el email..." disabled="disabled"></td>
						</tr>
						<tr>
							<td><label for="usua_username_edi">Username: </label></td>
							<td><input type="text" class="form-control input-sm"id="usua_username_edi" name="usua_username_edi" disabled="disabled" value="" placeholder="Ingrese el username...">
							<input type="hidden" id="usua_tipo_edi" name="usua_tipo_edi" value=""></td>
						</tr>
						<tr>
							<td><label for="usua_pass_edi">Clave: </label></td>
							<td><input type="text" class="form-control input-sm"id="usua_pass_edi" name="usua_pass_edi" value="" placeholder="Ingrese la nueva clave..."></td>
						</tr>
						</table>
						</div>
						<div class="form_element">&nbsp;</div>
					</form> 
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-success" onClick="load_ajax_edi_usua('usua_main','script_reset.php','opc=upd&usua_nombre='+document.getElementById('usua_nombre_edi').value+'&usua_apellido='+document.getElementById('usua_apellido_edi').value+'&usua_email='+document.getElementById('usua_email_edi').value+'&usua_username='+document.getElementById('usua_username_edi').value+'&usua_tipo='+document.getElementById('usua_tipo_edi').value+'&usua_pass='+document.getElementById('usua_pass_edi').value);" >Grabar</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>  