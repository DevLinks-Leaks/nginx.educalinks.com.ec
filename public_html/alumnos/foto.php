<!DOCTYPE html>
<html lang="es">
    <?php include("template/head.php");?>
    <body class="hold-transition skin-blue sidebar-mini">
		<div class="wrapper">
			<?php include ('template/header.php');?>
			<?php $active="cons_estudiantes";include("template/menu.php");?>
			<div class="content-wrapper">
				<section class="content-header">
					<h1>Carnet
						<small>Foto de Carnet</small>
					</h1>
					<ol class="breadcrumb">
						<!-- <li><button class="btn btn-xs btn-primary" data-target="#myModal" data-toggle="modal"><i class='fa fa-list'></i> Instrucciones</button></li> -->
					</ol>
				</section>
				<section class="content" id="mainPanel">
					<div id="information">
						<div class="panel panel-default">
						  	<div class="panel-heading"></div>
						  	<div class="panel-body">
						    	<script src="js/foto.js?<?=$rand;?>"> </script>
						    	<script src="js/preinscripcion.js?<?=$rand;?>"> </script>
									<input type="hidden" id="opc" name="opc" value="ActualizarDatos" />
									<input type="hidden" id="hd_alum_codi" name="hd_alum_codi" value="<?= $_SESSION['alum_codi']; ?>" />
									<div class="zones">
										<div class="nav-tabs-custom">  
											<ul id="tabs" class="nav nav-tabs">
												<li class="active"><a href="#tab2" data-toggle="tab" onClick=""><span class=" fa-image fa"></span> Foto del Alumno</a></li>
											</ul>

											<div class="tab-content">
												<div class="tab-pane active" id="tab2">
													<div class="row">
														<div class="col-md-3">
															<div class="selector" style='text-align:center;'>
																<?php
																$file_exi=$_SESSION['ruta_foto_alumno'].$alum_view['alum_codi'].'.jpg';

																if (file_exists($file_exi)) {
																	$pp=$file_exi;
																} else {
																	$pp=$_SESSION['foto_carnet'];
																}
																?>
																<div id="div_foto" >
																	<img id="alum_preview" src="<?php echo $pp;?>?<?=$rand?>" width="220" height="200" />
																</div>
																<input type="file" class='form-control input-sm' name="alum_foto" id="alum_foto" class="btn" onblur="preview(this,1);" onchange="preview(this,1);"/>
																
															</div>
														</div>
														
														<div class="col-md-6">
															<div class="alert alert-warning">
												                <h4><i class="icon fa fa-warning"></i> Importante!</h4>
												                <p>Esta foto será usada para la emisión del carnet estudiantil.</p>
												                <p>La foto debe cumplir los siguientes requisitos para proceder a la impresión:</p>
												                <ul>
												                	<li>Vestir el uniforme de diario.</li>
												                	<li>Foto con fondo blanco.</li>
												                	<li>Seguir formato de imagen sugerida.</li>
												                	<li>En caso de mujeres: accesorios blancos.</li>
												                </ul>
												                <p><b>*En caso de no cumplir todos los requisitos la credencial no será emitida y deberá ser reemplazada.</b></p>
											              	</div>
														</div>
														<div class="col-md-3">
															<div class="nav-tabs-custom">  
																<ul id="tabs" class="nav nav-tabs">
																	<li class="active"><a href="#tab_1" data-toggle="tab" onClick=""><span class=" fa-male fa"></span> Hombre</a></li>
																	<li class=""><a href="#tab_2" data-toggle="tab" onClick=""><span class=" fa-female fa"></span> Mujer </a></li>
																</ul>
																<div class="tab-content">
																	<div class="tab-pane active" id="tab_1">
																		<img class="img-responsive"  src="<?=$_SESSION['foto_carnet_hombre'];?>" />
																	</div>
																	<div class="tab-pane" id="tab_2">
																		<img class="img-responsive" src="<?=$_SESSION['foto_carnet_mujer'];?>" />
																	</div>
																</div>
															</div>
														</div>
													</div>
													<div class="row">
														<div class="col-md-4 col-md-offset-5 form-group">
															<button id="btn_actualizar" class="btn btn-success" style="width:40%;" data-loading="Actualizando.." onclick="actualizar_datos();">Subir Foto</button>
														</div>
													</div>
												</div>
											</div>
										</div>
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
		<script type="text/javascript">

			function preview(tField,iType) { 
				file=tField.value; 
				if (iType==1) { 
					extArray = new Array(".jpg",'.png','.jpeg'); 
				} 
				allowSubmit = false; 
				if (!file) return; 
				while (file.indexOf("\\") != -1) file = file.slice(file.indexOf("\\") + 1); 
				ext = file.slice(file.indexOf(".")).toLowerCase(); 
				for (var i = 0; i < extArray.length; i++) { 
					if (extArray[i] == ext) { 
						allowSubmit = true; 
						break; 
					} 
				} 
				if (allowSubmit) {
					var oFReader = new FileReader();
			        oFReader.readAsDataURL(document.getElementById("alum_foto").files[0]);

			        oFReader.onload = function (oFREvent) {
			            document.getElementById("alum_preview").src = oFREvent.target.result;
			        };
				} else { 
					tField.value=""; 
					alert("Usted sólo puede subir archivos con extensiones " + (extArray.join(" ")) + "\nPor favor seleccione un nuevo archivo"); 
				} 
			}
		</script>
	</body>
</html>
<!-- Modal para instrucciones-->
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Instrucciones</h4>
			</div>
			<div class="modal-body">
				<img width='100%' src="../imagenes/instrucciones_act_datos.jpg" />
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Ocultar</button>
			</div>
		</div>
	</div>
</div>		