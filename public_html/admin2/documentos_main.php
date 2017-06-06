<!DOCTYPE html>
<html lang="es">
    <?php include("template/head.php");?>
    <body class="hold-transition skin-blue sidebar-mini <?php echo $_SESSION['sidebar_status']; ?>">
		<div class="wrapper">
			<?php include ('template/header.php');?>
			<?php $Menu=127;include("template/menu.php");?>
			<div class="content-wrapper">
				<section class="content-header">
					<?php
						$params = array($_SESSION['curs_para_codi']);
						$sql="{call curs_para_info(?)}";
						$curs_para_info = sqlsrv_query($conn, $sql, $params);  
						$row_curs_para_info = sqlsrv_fetch_array($curs_para_info);
				  	?>
					<h1>Documentos solicitados para matrícula</h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-briefcase"></i></a></li>
						<li class="active">Documentos</li>
					</ol>
				</section>
				<section class="content" id="mainPanel">
					<div id="information">
						<div class="box box-default">
							<div class="box-header with-border">
								<h3 class="box-title">
									<a class="btn btn-primary"  data-toggle="modal" data-target="#ModalDocuAdd" title="">
										<span class="fa fa-plus"></span> Agregar documento
									</a>
									<a class="btn btn-info" href="alumnos_main.php" title=""><span class="fa fa-graduation-cap"></span> Ir a bandeja de alumnos</a>
								</h3>
							</div><!-- /.box-header -->
							<div class="box-body">
							<script type="text/javascript" src="js/funciones_documento.js"></script> 
								<div id="rol_main">
									<?php include ('documentos_main_lista.php'); ?>
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
				$('#docu_table').DataTable({
					language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'},
				 	"bSort": false 
				}) ;
			} );
		</script>
	</body>
</html>
<div	class="modal fade" 
		id="ModalDocuAdd" 
		tabindex="-1" 
		role="dialog" 
		aria-labelledby="myModalLabel" 
		aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button 
					type="button" 
					class="close" 
					data-dismiss="modal">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">Nuevo Documento</h4>
			</div>
			<div id="modal_main" class="modal-body">
				<div id="div_docu_nuev"> 
					<form 
						id="frm_docu_add" 
						name="frm_docu_add" 
						method="post" 
						action="" 
						enctype="multipart/form-data">
						<table width="100%">
							<tr>
								<td>
									<label>
										Per&iacute;odo activo:
									</label>
								</td>
								<td>
									<label>
										<?php echo $_SESSION['peri_deta']; ?>
									</label>
									<input 
										type="hidden" 
										id="docu_peri_codi_nuev" 
										name="docu_peri_codi_nuev" 
										value="<?php echo $_SESSION['peri_codi']; ?>">
								</td>
							</tr>
							<tr>
								<td valign='top'>
									<label for="docu_descr_nuev">
										Descripci&oacute;n:
									</label>
								</td>
								<td>
									<textarea 
										id="docu_descr_nuev" 
										name="docu_descr_nuev" 
										maxlength='250'
										rows="4"
										placeholder="Ingrese descripci&oacute;n del documento..."
										style="width: 100%; margin-top: 5px;"></textarea>
								</td>
							</tr>
						</table>
						<div class="form_element">&nbsp;</div>   
					</form>
				</div>
			</div>
			<div class="modal-footer">
				<button 
					type="button" 
					class="btn btn-success" 
					onClick="load_ajax_docu('docu_main','script_docu.php', 'add', 
							document.getElementById('docu_descr_nuev').value,
							document.getElementById('docu_peri_codi_nuev').value,
							0,0,0);" 
						><span class='fa fa-save'></span> Guardar cambios</button>
				<button 
					type="button" 
					class="btn btn-default" 
					data-dismiss="modal">
						Cerrar
				</button>
			</div>
		</div>
	</div>
</div>
<div 	class="modal fade" 
		id="ModalDocuEdi" 
		tabindex="-1" 
		role="dialog" 
		aria-labelledby="myModalLabel" 
		aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button 
					type="button" 
					class="close" 
					data-dismiss="modal">
						<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">Editar Documento</h4>
			</div>
			<div id="modal_main" class="modal-body">
				<div id="div_docu_edi"> 
					<form 
						id="frm_docu_edi" 
						name="frm_docu_edi" 
						method="post" 
						action="" 
						enctype="multipart/form-data">
						<table width="100%">
							<tr>
								<td>
									<label>
										Per&iacute;odo activo:
									</label>
								</td>
								<td>
									<label>
										<?php echo $_SESSION['peri_deta']; ?>
									</label>
									<input 
										type="hidden" 
										id="docu_codi_edi" 
										name="docu_codi_edi" 
										value="">
								</td>
							</tr>
							<tr>
								<td valign='top'>
									<label for="docu_descr_edi">
										Descripci&oacute;n:
									</label>
								</td>
								<td>
									<textarea 
										id="docu_descr_edi" 
										name="docu_descr_edi" 
										maxlength='250'
										rows="4"
										placeholder="Ingrese descripci&oacute;n del documento..."
										style="width: 100%; margin-top: 5px;"></textarea>
								</td>
							</tr>
							</table>
						</form>
				</div>
				<div class="form_element">&nbsp;</div> 
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-success" 
						onClick="load_ajax_docu('docu_main','script_docu.php', 'upd', 
							document.getElementById('docu_descr_edi').value,
							0,
							document.getElementById('docu_codi_edi').value,
							0,0);" ><span class='fa fa-save'></span> Guardar cambios</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>  