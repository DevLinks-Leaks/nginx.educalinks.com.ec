<!DOCTYPE html>
<html lang="es">
	<?php $ActualizacionDatos=1;?>
    <?php include("template/head.php");?>
    <body class="hold-transition skin-blue sidebar-mini">
		<div class="wrapper">
			<?php include ('template/header.php');?>
			<?php $active="cons_estudiantes";include("template/menu.php");?>
			<div class="content-wrapper">
				<section class="content-header">
					<h1>Preinscripción
						<small>Reserva Cupo</small>
					</h1>
					<ol class="breadcrumb">
						<li><button class="btn btn-xs btn-primary" data-target="#myModalPre" data-toggle="modal"><i class='fa fa-list'></i> Instrucciones</button></li>
					</ol>
				</section>
				<section class="content" id="mainPanel">
					<div id="information">
						<?php include("preinscripcion_view.php");?>
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
		<script src="js/preinscripcion.js?<?= $rand?>"></script>
		<script type="text/javascript">  
			$(document).ready(function(){  
				$("#alum_resp_form_fech_vcto").datepicker();
				$("#alum_fech_naci").datepicker();
			});
		</script>
	</body>
</html>
<!-- Modal Estados Preinscipcion Nuevo -->
<div class="modal fade" id="modal_preinscripcion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div id="modal_preinscripcion_content" class="modal-content">
			
		</div>
	</div>
</div>
<!-- FIN MODAL -->
<!-- Modal para instrucciones-->
<!-- Modal -->
<div class="modal fade" id="myModalPre" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Instrucciones Preinscripción</h4>
			</div>
			<div class="modal-body">
				<img width='100%' src="../imagenes/instrucciones_preinscripcion.png" />
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Ocultar</button>
			</div>
		</div>
	</div>
</div>		
<script type="text/javascript" charset="utf-8">
$("#alum_fech_naci").datepicker();
$(window).load(function(){
	$('#myModalPre').modal('show');
});
</script>