<!DOCTYPE html>
<html lang="es">
    <?php include("template/head.php");?>
    <body class="hold-transition skin-blue sidebar-mini">
		<div class="wrapper">
			<?php include ('template/header.php');?>
			<?php $Menu=410;include("template/menu.php");?>
			<div class="content-wrapper">
				<section class="content-header">
					<?php
						$params = array($_SESSION['curs_para_codi']);
						$sql="{call curs_para_info(?)}";
						$curs_para_info = sqlsrv_query($conn, $sql, $params);  
						$row_curs_para_info = sqlsrv_fetch_array($curs_para_info);
				  	?>
					<h1>Parámetros del sistema</h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-circle-o"></i></a></li>
						<li class="active">Parámetros del sistema</li>
					</ol>
				</section>
				<section class="content" id="mainPanel">
					<div id="information">
						<div class="box box-default">
							<div class="box-header with-border">
								<h3 class="box-title"></h3>
							</div><!-- /.box-header -->
							<div class="box-body">
								<script type="text/javascript" src="js/funciones_para_sistema.js"></script> 
								<div id="para_sist_main" >
									 <?php include ('para_sistema_main_lista.php'); ?>
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
				$('#para_sist_table').DataTable() ;
			} );
		</script>
	</body>
</html>
<div class="modal fade" id="ModalUsuaEdi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Editar Parámetro</h4>
			</div>
			<div id="modal_main" class="modal-body">
				<div id="div_usua_edi"> 
					<form id="frm_usua_edi" name="frm_usua_edi" method="post" action="" enctype="multipart/form-data">
						<div class="form_element">
						<table border="0" cellpadding="0" cellspacing="0" width="100%;" class="table">
						<tr>
						<td width="25%"><label for="para_deta_edi">Parámetro: </label></td>
						<td width="75%">
						<input type="text" class="form-control input-sm"id="para_deta_edi" style="width: 100%; margin-top: 5px;"  name="para_deta_edi" value="" disabled>
						<input type="hidden" id="para_codi_edi" name="para_codi_edi" value="">
						</td>
						</tr>
						<tr>
						<td><label for="para_valo_edi">Valor: </label></td>
						<td><textarea id="para_valo_edi" style="width: 100%; margin-top: 5px;" name="para_valo_edi" value=""></textarea></td>
						</tr>
						</table>  
						</div>
						<div class="form_element">&nbsp;</div>                
					</form>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-success" 
					onClick="load_ajax_edi_para_sist('para_sist_main','script_para_sistema.php',
					'opc=upd&sist_codi='+document.getElementById('para_codi_edi').value+'&sist_valo='+document.getElementById('para_valo_edi').value);" >
					<span class='fa fa-floppy-o'></span> Guardar Cambios</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>  