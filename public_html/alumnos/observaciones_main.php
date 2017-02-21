<!DOCTYPE html>
<html lang="es">
    <?php include("template/head.php");?>
    <body class="hold-transition skin-blue sidebar-mini">
		<div class="wrapper">
			<?php include ('template/header.php');?>
			<?php $active="cons_estudiantes";include("template/menu.php");?>
			<div class="content-wrapper">
				<section class="content-header">
					<h1>Hoja de vida
						<small>Observaciones profesores</small>
					</h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-comments"></i></a></li>
						<li class="active">Hoja de vida</li>
					</ol>
					
				</section>
				<section class="content" id="mainPanel">
					<div id="information">
						<div class="panel panel-default">
							<div class="panel-heading">
								<h3 class="panel-title">
									<div class="form-horizontal">
										<div class="form-group">
											<div class="col-md-6">
												<h4>Seleccione el tipo de observación</h4>
												<?php
												$sql="{call tipo_observacion_view()}";
												$tipo_obs_view = sqlsrv_query($conn, $sql); 
												?>
											</div>
											<div class="col-md-6">
												<select class='form-control input-sm' id="tipo_obs" name="tipo_obs" onchange="MostrarObservaciones(this.value);">
													<?php while($row_tipo_obs_view = sqlsrv_fetch_array($tipo_obs_view)){?>
													<option value="<?=$row_tipo_obs_view['obse_tipo_codi']?>"><?=$row_tipo_obs_view['obse_tipo_deta']?></option>
													<?php }?>
													<option value="-1" selected>- Todas -</option>
												</select>
											</div>
										</div>
									</div><!-- Title Bar -->
								</h3>
							</div>
							<div class="panel-body"  id="desplegable_busqueda" name="desplegable_busqueda">
								<div class="form-horizontal" role="form">
									<div class="form-group">
										<div id="information">
											<!-- InstanceBeginEditable name="information" -->
											<script type="text/javascript">
												//Para que al cargar la página por primera vez se muestren todas las observaciones
												MostrarObservaciones (document.getElementById('tipo_obs').value);
												function MostrarObservaciones (tipo_observacion)
												{
													var xmlhttp;
											
													if (window.XMLHttpRequest)
													{
														xmlhttp = new XMLHttpRequest ();
													}
													else
													{
														xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');
													}
											
													xmlhttp.onreadystatechange = function ()
													{
														if (xmlhttp.readyState==4 && xmlhttp.status==200)
														{
															document.getElementById('div_observaciones').innerHTML=xmlhttp.responseText;
														}
													}
											
													xmlhttp.open("GET", "observaciones_view.php?tipo_observacion="+tipo_observacion, true);
													xmlhttp.send();
												}
											</script>
											<div id="div_observaciones">
											</div>
											<!-- InstanceEndEditable -->
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
		<script src="../js/med_fichas.js"></script>
		<script type="text/javascript">  
			$(document).ready(function(){  
				
			});
		</script>
	</body>
</html>	