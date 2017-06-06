<!DOCTYPE html>
<html lang="es">
    <?php include("template/head.php");?>
    <body class="hold-transition skin-blue sidebar-mini <?php echo $_SESSION['sidebar_status']; ?>">
		<div class="wrapper">
			<?php include ('template/header.php');?>
			<?php $Menu=106;include("template/menu.php");?>
			<div class="content-wrapper">
				<section class="content-header">
					<?php
						$params = array($_SESSION['curs_para_codi']);
						$sql="{call curs_para_info(?)}";
						$curs_para_info = sqlsrv_query($conn, $sql, $params);  
						$row_curs_para_info = sqlsrv_fetch_array($curs_para_info);
				  	?>
					<h1>Blacklist</h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-ban"></i></a></li>
						<li class="active">Blacklist</li>
					</ol>
				</section>
				<section class="content" id="mainPanel">
					<div id="information">
						<div id="blacklist_main">
							<?php include ('alumnos_blacklist_main_lista.php');  ?>
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
				$('#blacklist_table').DataTable({
					language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'},
				 	"bSort": false 
				}) ;
			} );
		</script>
	</body>
</html>
<div class="modal fade" id="BlacklistEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Editar Motivo Blacklist</h4>
			</div>
			<div id="modal_main_blacklist" class="modal-body">
				
			</div>
			<div class="modal-footer">
				<button id="btn_blacklist_save" type="button" class="btn btn-success" data-loading-text="Grabando..." onClick="load_ajax_edit_alum_bl('blacklist_main','script_alumnos_blacklist.php','opc=upd&bl_codi='+document.getElementById('bl_codi').value+'&bl_moti_bloq_deta='+document.getElementById('cmb_motivos').options[document.getElementById('cmb_motivos').selectedIndex].value,true);" >Grabar</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div> 