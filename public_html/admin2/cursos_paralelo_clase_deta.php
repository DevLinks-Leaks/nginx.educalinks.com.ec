<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
    <?php include("template/head.php");?>
    <body class="hold-transition skin-blue sidebar-mini <?php echo $_SESSION['sidebar_status']; ?>">
		<div class="wrapper">
			<?php include ('template/header.php');?>
			<?php $Menu=201;include("template/menu.php");?>
			<div class="content-wrapper">
				<section class="content-header">
					<h1>HISTORIAL DE ACTIVIDADES</h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-circle-o"></i></a></li>
						<li class="active">Cursos Paralelo</li>
					</ol>
				</section>
				<section class="content" id="mainPanel">
					<div id="information">
						<div class="box box-default">
							<div class="box-header with-border">
								<h3 class="box-title">
									<a class="btn btn-warning" 
										href="cursos_paralelo_clase_main.php?curs_para_codi=<?php echo $_GET['curs_para_codi'];?>&curs_para_mate_prof_codi=<?=$_GET['curs_para_mate_prof_codi'];?>"
										>
										<span class="fa fa-chevron-left"></span> Volver
									</a>
								</h3>
							</div><!-- /.box-header -->
							<div class="box-body">
								<div class="alumnos_curso zones">
									<div class="tabbable"> <!-- Only required for left/right tabs -->
										<ul class="nav nav-tabs">
											<li class="active">
												<a href="#tab1" data-toggle="tab">Agendas</a>
											</li>
											<li>
												<a href="#tab2" data-toggle="tab">Materiales</a>
											</li>
											<li>
												<a href="#tab3" data-toggle="tab">Mensajes</a>
											</li>
											<li>
												<a href="#tab4" data-toggle="tab">Sesiones</a>
											</li>
											<li>
												<a href="#tab5" data-toggle="tab">Gráficos</a>
											</li>
										</ul>
										<div class="tab-content">
											<div class="tab-pane active" id="tab1">
												<div id="div_agendas">
													<?php
													$params_agend = array($_GET['curs_para_mate_prof_codi']);
													$sql_agend="{call prof_agendas_cons(?)}";
													$stmp_agend = sqlsrv_query($conn, $sql_agend, $params_agend);?>
													<table class="table table-striped" id="agendas_table" data-page-length='10'>
														<thead style='background-color:rgba(1, 126, 186, 0.1) !important'>
														<tr>
															<th width="60%">Detalle</th>
															<th width="20%">Fecha</th>
															<th width="20%">Estado</th>
														</tr>
														</thead>
														<tbody>
														<?php
														while ($row_agend_view = sqlsrv_fetch_array($stmp_agend)) {
															?>
															<tr>
																<td><h4><?= $row_agend_view['agen_titu']; ?></h4>
																	<?= $row_agend_view['agen_deta']; ?>
																</td>
																<td><?= $row_agend_view['agen_fech_regi']; ?></td>
																<td>
																	<?= $row_agend_view['agen_esta']; ?>
																</td>
															</tr>
															<?
														}
														?>
														</tbody>
													</table>
												</div>
											</div>
											<!--Seccion de Materiales-->
											<div class="tab-pane" id="tab2">
												<div id="div_materiales">
													<?php
													$params_mater = array($_GET['curs_para_mate_prof_codi']);
													$sql_mater="{call curs_para_mate_mater_view(?)}";
													$stmp_mater = sqlsrv_query($conn, $sql_mater, $params_mater);?>
													<table class="table table-striped" id="material_table" data-page-length='10'>
														<thead style='background-color:rgba(1, 126, 186, 0.1) !important'>
															<tr>
																<th width="60%">Detalle</th>
																<th width="20%">Fecha</th>
																<th width="20%">Opciones</th>
															</tr>
														</thead>
														<tbody>
														<?php
															while ($row_mater_view = sqlsrv_fetch_array($stmp_mater))
															{
																?>
																<tr>
																	<td><h4><?= $row_mater_view['mater_titu']; ?></h4>
																		<?= $row_mater_view['mater_deta']; ?></td>
																	<td><?= date_format($row_mater_view['mater_fech_regi'], 'd/m/Y'); ?></td>
																	<td style='text-align:center'><a class="btn btn-default" target="_blank"
																		   href="<?= "../files/" .$_SESSION['directorio']."/".$_SESSION['peri_codi'] . "/" . $row_mater_view['mater_file']; ?>">
																		   <span class="fa fa-download btn_opc_lista_exportar"></span> Descargar</a>
																		<a class="btn btn-default"
																		   href="javascript:elimina_materiales('div_materiales','script_materiales.php','<?= $row_mater_view['mater_codi']; ?>','<?= $_GET['curs_para_mate_codi'] ?>')">
																		   <span class="fa fa-trash btn_opc_lista_eliminar"></span> Eliminar</a>
																	</td>
																</tr>
														<?php
															}
														?>
														</tbody>
														<tfoot>
															<tr class="pager_table" >
																<td colspan="3" class="right"><div class="paging"></div></td>
															</tr>
														</tfoot>
													</table>
												</div>
											</div>
											<!--Seccion de Alumnos del curso-->
											<div class="tab-pane" id="tab3">
												<div id="div_mensajes">
													<?php
													$params_mens = array($_GET['curs_para_mate_prof_codi']);
													$sql_mens="{call prof_mensajes_cons(?)}";
													$stmp_mens = sqlsrv_query($conn, $sql_mens, $params_mens);?>
													<table class="table table-striped" id="mensajes_table" data-page-length='10'>
														<thead style='background-color:rgba(1, 126, 186, 0.1) !important'>
														<tr>
															<th width="60%">Detalle</th>
															<th width="25%">Para</th>
															<th width="15%">Fecha</th>
														</tr>
														</thead>
														<tbody>
														<?php
														while ($row_mens_view = sqlsrv_fetch_array($stmp_mens))
														{
															?>
															<tr>
																<td>
																	<?= $row_mens_view['mens_deta']; ?>
																</td>
																<td>
																	<h4><?= $row_mens_view['mens_para_tipo'];; ?></h4>
																	<?= $row_mens_view['mens_para']; ?>
																</td>
																<td>
																	<?= $row_mens_view['mens_fech_envi']; ?>
																</td>
															</tr>
															<?php
														}
														?>
														</tbody>
														<tfoot>
														<tr class="pager_table">
															<td colspan="2" class="right">
																<div class="paging"></div>
															</td>
														</tr>
														</tfoot>
													</table>
												</div>
											</div>
											<!--Seccion de Profesor-->
											<div class="tab-pane" id="tab4">
												<div id="div_sesiones">
													<?php
													$params_sesi = array($_GET['curs_para_mate_prof_codi']);
													$sql_sesi="{call prof_sesiones_cons(?)}";
													$stmp_sesi = sqlsrv_query($conn, $sql_sesi, $params_sesi);?>
													<table class="table table-striped" id="sesiones_table" data-page-length='10'>
														<thead style='background-color:rgba(1, 126, 186, 0.1) !important'>
														<tr>
															<th width="85%">Detalle</th>
															<th width="15%">Fecha</th>
														</tr>
														</thead>
														<tbody>
														<?php
														while ($row_sesi_view = sqlsrv_fetch_array($stmp_sesi))
														{
															?>
															<tr>
																<td>
																	<?= $row_sesi_view['audi_deta']; ?>
																</td>
																<td>
																	<?= $row_sesi_view['audi_fech']; ?>
																</td>
															</tr>
															<?php
														}
														?>
														</tbody>
														<tfoot>
														<tr class="pager_table">
															<td colspan="2" class="right">
																<div class="paging" id="xxx_b"></div>
															</td>
														</tr>
														</tfoot>
													</table>
												</div>
											</div>
											  <!--Seccion de Profesor-->
											<div class="tab-pane" id="tab5">
												<div id="tab_contenidos">
													<div style="height: 250px; width: 500px">
														<canvas id="canvas" height="250" width="500"></canvas>
													</div>
													<!--Otra librería para gráficos-->
													<?
													$sql = "{call prof_summary_graph (?,?,?)}";
													$params = array ($_GET['curs_para_mate_prof_codi'],"20150505","20151007");
													$stmt = sqlsrv_query($conn,$sql,$params);
													$row = sqlsrv_fetch_array($stmt);
													?>
													<script>
														var randomScalingFactor = function(){ return Math.round(Math.random()*100)};
														var barChartData = {
															labels : ["Agendas","Materiales","Mensajes","Sesiones"],
															datasets : [
																{
																	fillColor : "rgba(220,220,220,0.5)",
																	strokeColor : "rgba(220,220,220,0.8)",
																	highlightFill: "rgba(220,220,220,0.75)",
																	highlightStroke: "rgba(220,220,220,1)",
																	data : [<? print $row["num_agendas"] ?>,<? print $row["num_materiales"] ?>,<? print $row["num_mensajes"] ?>,<? print $row["num_sesiones"] ?>]
																}
															]
														}
														window.onload = function(){
															var ctx = document.getElementById("canvas").getContext("2d");
															window.myBar = new Chart(ctx).Bar(barChartData, {
																responsive : false
															});
														}
													</script>
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
		<!--<script src="js/upload.js"></script>-->
        <script src="../framework/Chart.js-master/Chart.js"></script>
        <script type="text/javascript">		
		$(document).ready(function() {
			$('#agendas_table').DataTable({
                lengthChange: false,
                searching: true,
                order: [[ 1, "desc" ]],
                language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'}
            });
            $('#material_table').DataTable({
				lengthChange: false,
				searching: true,
				language: {
				url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'
				}
			});
			$('#sesiones_table').DataTable({
                lengthChange: false,
                searching: true,
                language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'}
            });
            $('#mensajes_table').DataTable({
				lengthChange: false,
				searching: true,
				language: {
					url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'
				}
			});
		});
		function activa_subida(){
			document.getElementById('boton_subir').disabled=false;
			document.getElementById('archivo').disabled=false;
		}
		function carga_archivos(div,url,curs_para_mate_codi){
			document.getElementById(div).innerHTML='<div align="center" style="height:100%;"><img src="../imagenes/ajax-loader.gif"/></div>';
			var data = new FormData();
			data.append('curs_para_mate_codi', curs_para_mate_codi);
			data.append('opc', 'mater_view');

			var xhr = new XMLHttpRequest();
			xhr.open('POST', url , true);
			xhr.onreadystatechange=function(){
				if (xhr.readyState==4 && xhr.status==200){
					document.getElementById(div).innerHTML=xhr.responseText;
				}
			}
			xhr.send(data);
		}
		function elimina_materiales(div,url,mater_codi,curs_para_mate_codi){
			document.getElementById(div).innerHTML='<div align="center" style="height:100%;"><img src="../imagenes/ajax-loader.gif"/></div>';
			var data = new FormData();
			data.append('mater_codi', mater_codi);
			data.append('opc', 'mater_del');

			var xhr = new XMLHttpRequest();
			xhr.open('POST', url , true);
			xhr.onreadystatechange=function(){
				if (xhr.readyState==4 && xhr.status==200){
					document.getElementById(div).innerHTML=xhr.responseText;
					carga_archivos('div_materiales','script_materiales.php',curs_para_mate_codi);
				}
			}
			xhr.send(data);
		}
		function bloquea_subida(){
			document.getElementById('boton_subir').disabled=true;
			document.getElementById('archivo').disabled=true;
		}
			function subirArchivos() {
				if(document.getElementById("archivo").value!=""){
					bloquea_subida();
					$("#archivo").upload('subir_archivo.php',
					{
						mater_titu: $("#mater_titu").val(),
						mater_deta: $("#mater_deta").val(),
						curs_para_mate_codi: $("#curs_para_mate_codi").val()
					},
					function(respuesta) {
						//Subida finalizada.
						$("#barra_de_progreso").val(0);
						if (respuesta === 1) {
							activa_subida();
							$.growl.notice({ title: "Informacion: ",message: "El archivo ha sido subido correctamente" });
							//mostrarRespuesta('El archivo ha sido subido correctamente.', true);
							$("#nombre_archivo, #archivo").val('');
							carga_archivos('div_materiales','script_materiales.php','<?=$_GET['curs_para_mate_codi'];?>');
						} else {
							activa_subida();
							$.growl.error({ title: "Informacion: ",message: "El archivo NO se ha podido subir" });
							//mostrarRespuesta('El archivo NO se ha podido subir.', false);
						}
						//mostrarArchivos();
					}, function(progreso, valor) {
						//Barra de progreso.
						$("#barra_de_progreso").val(valor);
					});
				}else{
					alert("Seleccione el archivo que desea subir primero.");
				}
			}
			$(document).ready(function() {
				$("#boton_subir").on('click', function() {
					subirArchivos();
				});
			});
		</script>
	</body>
</html>