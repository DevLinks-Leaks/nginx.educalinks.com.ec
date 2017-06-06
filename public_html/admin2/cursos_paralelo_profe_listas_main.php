<!DOCTYPE html>
<html lang="es">
    <?php include("template/head.php");?>
    <body class="hold-transition skin-blue sidebar-mini <?php echo $_SESSION['sidebar_status']; ?>">
		<div class="wrapper">
			<?php include ('template/header.php');?>
			<?php $Menu=602;include("template/menu.php");?>
			<div class="content-wrapper">
				<section class="content-header">
					<h1>Reportes de profesores</h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-users"></i></a></li>
						<li class="active">Reportes de profesores</li>
						
					</ol>
				</section>
				<section class="content" id="mainPanel">
					<div id="information">
						<script type="text/javascript" src="js/select_reportes_generales.js?<?=$rand?>"></script>
						<div class="box box-default">
						    <div class="box-header with-border">
						        <h3 class="box-title">
						        </h3>
						    </div>
						    <div class="box-body">
						    	<div class="col-md-6 col-md-offset-3 list-group">
						    		<a class="list-group-item" style="cursor: pointer" data-toggle="modal" data-toggle="modal" data-target="#ModalProfesorAgenda" onclick="resetC();">
						    			<span class="badge">
						    				<span class="fa fa-file-o"></span>
						    			</span>
						    			<h4>Reporte de Agendas y Materiales</h4>
						    		</a>
						    		<a class="list-group-item" style="cursor: pointer" data-toggle="modal" data-toggle="modal" data-target="#ModalProfesorNotas" onclick="resetNP()">
						    			<span class="badge">
						    				<span class="fa fa-file-pdf-o"></span>
						    			</span>
						    			<h4>Reporte de Alumnos con notas pendientes de ingreso</h4>
						    		</a>
						    	</div>
						    	<!-- <table class="table table-striped" id="alum_table">
									<thead>
										<tr>
											<th width="40%" class="text-center">Reporte </th>
											<th width="40%" class="text-center">Filtro </th>
											<th width="20%" class="text-center">Opciones</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td ><h4>Reporte de Agendas y Materiales</h4></td>
											<td class="text-center">
												
											</td>
											<td class="text-center">
												   <a title="Descargar" onmouseover="$(this).tooltip('show');"  style="cursor: pointer" data-toggle="modal" data-target="#ModalProfesorAgenda">
													   <span class="fa fa-file-o fa-2x" style='font-color:red'></span>
												   </a>
										   </td>
										</tr>
										<tr>
											<td ><h4>Reporte Notas Pendientes</h4></td>
											<td class="text-center">
												
									   	
											</td>
											<td class="text-center">
												   <a title="Descargar" onmouseover="$(this).tooltip('show');" data-toggle="modal" data-target="#ModalProfesorNotas" style="cursor: pointer">
													   <span class="fa fa-file-pdf-o fa-2x" style='font-color:red'></span>
												   </a>
										   </td>
										</tr>
									</tbody>
								</table> -->
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
		<script>
			function getURL()
			{   var direccion;
				direccion="cursos_paralelo_profe_listas_main_view.php?curs_para_codi=";
				direccion=direccion+document.getElementById('curso').value;
				window.open(direccion);
			}
			function validarNP(){
				if ($('#sl_periodo_dist').val()==0){
					$('#sl_periodo_dist').closest('.form-group').addClass('has-error');
					return false;
				}
				else
					$('#sl_periodo_dist').closest('.form-group').removeClass('has-error');
				if ($('#sl_prof').val()==0){
					$('#sl_prof').closest('.form-group').addClass('has-error');
					return false;
				}
				else
					$('#sl_prof').closest('.form-group').removeClass('has-error');
				return true;
			}
			function getReporteNP(){
				if(validarNP()){
					window.open('reportes_generales/notas_pendientes_pdf.php?peri_dist_codi='+$('#sl_periodo_dist').val()+'&prof_codi='+$('#sl_prof').val());
				}
			}
			function resetNP(){
				$('#sl_prof').val(0);
				$('#sl_peri_dist_cab').val(0).change();
			}
			function resetC(){
				$('#curso').val(0);
			}
			function MostrarListado (curso)
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
						document.getElementById('div_curso_lista').innerHTML=xmlhttp.responseText;
					}
				}

				xmlhttp.open("GET", "cursos_paralelo_profe_listas_main_view.php?curs_para_codi="+curso, true);
				xmlhttp.send();
			}
		</script>
		<!-- Modal Reporte Agendas Profesor -->
		<div class="modal fade" id="ModalProfesorAgenda" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div id="" class="modal-content">
					<div class="modal-header">
						<button 
							type="button" 
							class="close" 
							data-dismiss="modal">
							<span aria-hidden="true">&times;</span>
						</button>
						<h4 class="modal-title" id="myModalLabel">Criterio</h4>
					</div>
					<form class="form-horizontal">
						<div id="" class="modal-body">

							<div class="form-group">
								<label class="col-md-2 control-label">Curso: </label>
								<div class="col-md-10">
									<?php 
									$params = array ($_SESSION['peri_codi']);
									$sql="{call curs_para_view(?)}";
									$stmt = sqlsrv_query($conn, $sql, $params);
									$a=0;?>
									<select id="curso" name="curso" class="form-control" onchange="" >
										<option value="0">- Seleccione un curso -</option>
										<?php while($curso_view= sqlsrv_fetch_array($stmt)){?>
										<option value="<?= $curso_view['curs_para_codi'];?>">
											<?= $curso_view['curs_deta'].' / Paralelo '.$curso_view['para_deta'];?>
										</option>
										<?php }?>
									</select>
								</div>
							</div>
						</div>
					</form>
					<div class="modal-footer">
						<button class="btn btn-success" data-dismiss="modal" onclick="javascript:getURL()"><span class="fa fa-download"></span> Descargar</button>
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
		<!-- FIN MODAL -->
		<!-- Modal Reporte Profesor Notas Faltante -->
		<div class="modal fade" id="ModalProfesorNotas" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div id="" class="modal-content">
					<div class="modal-header">
						<button 
							type="button" 
							class="close" 
							data-dismiss="modal">
							<span aria-hidden="true">&times;</span>
						</button>
						<h4 class="modal-title" id="myModalLabel">Criterio</h4>
					</div>
					<form class="form-horizontal">
						<div id="" class="modal-body">
							<div class="form-group">
								<label class="col-md-3 control-label">Profesor: </label>
								<div class="col-md-9">
									<?php 
									$params = array ();
									$sql="{call prof_view()}";
									$prof_view = sqlsrv_query($conn, $sql, $params);
									$a=0;?>
									<select id="sl_prof" name="sl_prof" class="form-control" onchange="MostrarListado(this.value);" >
										<option value="0">- Seleccione un profesor -</option>
										<?php while($row_prof_view= sqlsrv_fetch_array($prof_view)){?>
										<option value="<?= $row_prof_view['prof_codi'];?>">
											<?= $row_prof_view['prof_apel'].' '.$row_prof_view['prof_nomb'];?>
										</option>
										<?php }?>
									</select>
									
								   	
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">Periodo Distribución: </label>
								<div class="col-md-9">
									<select id="sl_peri_dist_cab" class="form-control" class="form-control" onchange="CargarPeriodosDistribucion(this.value);"
									 >
									 <?
									 $peri_codi=$_SESSION['peri_codi'];
									 $params = array($peri_codi);
									 $sql="{call peri_dist_cab_view(?)}";
									 $peri_dist_cab_view = sqlsrv_query($conn, $sql, $params);
									 ?>
									 <option value="0">-Seleccione un periodo distribución-</option>
									 <?php
									 while ($row_peri_dist_cab_view = sqlsrv_fetch_array($peri_dist_cab_view))
									 {
										?>
										<option value="<?= $row_peri_dist_cab_view['peri_dist_cab_codi']; ?>">
										   <?= $row_peri_dist_cab_view['peri_dist_cab_deta']; ?>
									   </option>
									   <?
								   }
								   ?>
								   </select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">Parcial/Quimestre: </label>
								<div id="div_sl_periodo_dist" class="col-md-9">
									<select class="form-control"
										 id="sl_periodo_dist"
										 disabled="disabled"
										 >
										 <option value="0">Parcial/Quimestre</option>
									</select>
								</div>
							</div>
						</div>
					</form>
					<div class="modal-footer">
						<button class="btn btn-success" onclick="getReporteNP()" ><span class="fa fa-download"></span> Descargar</button>
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
		<!-- FIN MODAL -->
	</body>
</html>