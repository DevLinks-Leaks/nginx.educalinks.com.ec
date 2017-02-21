<!DOCTYPE html>
<html lang="es">
    <?php include("Templates/head.php");?>
	<?php session_activa(); ?>
	<body class="hold-transition skin-blue sidebar-mini">
		<div class="wrapper">
			<?php include("Templates/navbar.php");?>
			<?php include("Templates/menu.php");?>
			<div class="content-wrapper">
				<section class="content-header">
					<h1>Importación
						<small>Datos</small>
					</h1>
					<!-- <ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-plus"></i></a></li>
						<li class="active">Importación</li>
					</ol> -->
				</section>
				<section class="content" id="formulario_autor">
					<div id="Main_div" >
						<div id="importacion_main" > 
							<?php include("importacion_view.php"); ?>
						</div>
					</div>
				</section>
				<?php include("Templates/menu_sidebar.php");?>
			</div>
			<form id="frm_actu" name="frm_actu" method="post" action="" enctype="multipart/form-data">
				<?php include("Templates/rutas.php");?>
			</form>
			<?php include("Templates/footer.php");?>
		</div>
		<?php include("Templates/scripts.php");?>
		<!-- Modal importacion -->
		<div class="modal fade" id="modal_importacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	      	<div class="modal-dialog">
	        	<div class="modal-content">
	          		<div class="modal-header">
	            		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
	            		<h4 class="modal-title" id="myModalLabel">Subida archivo</h4>
	        		</div>
        			<div id="modal_main_autor" class="modal-body">
    					<form class="form-inline">
							<div class="form-group">
								<label for="file">Archivo a cargar:</label>
								<input id="file" class="form-control btn" name="file" type="file" accept="application/vnd.ms-excel"/>
								<input id="opc" type="hidden" value="" />
							</div>
						</form>
	            		
	       			</div>
	        		<div class="modal-footer">
	            		<button id="btn_subir" type="button" class="btn btn-success" data-loading-text="Subiendo..." onclick="upload_data();"><i class="fa fa-cloud-upload"></i> Subir Archivo</button>
	            		<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
	        		</div>
	    		</div>
			</div>
		</div>
		<!-- Modal autor Fin -->
		<script>
		    $(document).ready(function() {
		        
		    } );
		</script>
		<!-- InstanceBeginEditable name="Script Finales" -->        		   
		<!-- Button trigger modal -->

		<!-- InstanceEndEditable -->
	</body>
</html>
