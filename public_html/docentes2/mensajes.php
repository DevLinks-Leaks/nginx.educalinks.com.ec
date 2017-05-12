<!DOCTYPE html>
<html lang="es">
    <?php include("template/head.php");?>
    <body class="hold-transition skin-blue sidebar-mini">
		<div class="wrapper">
			<?php include ('template/header.php');?>
			<?php $Menu=700;include("template/menu.php");?>
			<div class="content-wrapper">
				<section class="content-header">
					<h1>Bandeja de mensajes 
						<small></small>
					</h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-envelope"></i></a></li>
						<li class="active">Bandeja de mensajes</li>
					</ol>
				</section>
				<section class="content" id="mainPanel">
					<div class="information">
						<div class="mensajes">
							<script type="text/javascript" src="../framework/funciones.js"> </script>
							<div id="mens_main_view" class="" >
								<?php include ('mensajes_view.php'); ?>
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
		<script src="../js/med_fichas.js"></script>
		<script type="text/javascript">  
			$(document).ready(function(){  
				
			});
		</script>
	</body>
</html>
<!-- Modal -->
<div class="modal fade bs-example-modal-lg" id="nuev_mens" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title" id="nuev_mens_modal">Nuevo Mensaje</h4>
			</div>
			<div class="modal-body">
				<div id="div_mens_nuev" >
					titulo
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" id="envio_mensaje" data-loading-text="Enviando..." onClick="envio_mensaje_nuevo();">
				Enviar
				</button>

				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<button type="button" class="btn btn-default" data-dismiss="modal">
				Cerrar
				</button>
			</div>
		</div>
	</div>
</div>
<!-- Modal Responder-->
<div class="modal fade bs-example-modal-lg" id="mens_responder" tabindex="-1" role="dialog" aria-labelledby="myModal" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div id="div_mens_resp" class="modal-content">
		  
		</div>
	</div>
</div>