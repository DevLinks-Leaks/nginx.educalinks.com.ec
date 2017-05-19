<!DOCTYPE html>
<html lang="es">
    <?php include("template/head.php");?>
    <body class="hold-transition skin-blue sidebar-mini">
		<div class="wrapper">
			<?php include ('template/header.php');?>
			<?php $Menu=602;include("template/menu.php");?>
			<div class="content-wrapper">
				<section class="content-header">
					<h1>Lista de profesores</h1>
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
						    	<table class="table table-striped" id="alum_table">
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
												<?php 
												$params = array ($_SESSION['peri_codi']);
												$sql="{call curs_para_view(?)}";
												$stmt = sqlsrv_query($conn, $sql, $params);
												$a=0;?>
												<select id="curso" name="curso" class="form-control input-sm" onchange="MostrarListado(this.value);" >
													<option value="0">- Seleccione un curso -</option>
													<?php while($curso_view= sqlsrv_fetch_array($stmt)){?>
													<option value="<?= $curso_view['curs_para_codi'];?>">
														<?= $curso_view['curs_deta'].' / Paralelo '.$curso_view['para_deta'];?>
													</option>
													<?php }?>
												</select>
											</td>
											<td class="text-center">
												   <a title="Descargar" onmouseover="$(this).tooltip('show');" onclick="javascript:getURL()" style="cursor: pointer">
													   <span class="fa fa-file-o fa-2x" style='font-color:red'></span>
												   </a>
										   </td>
										</tr>
										<tr>
											<td ><h4>Reporte Notas Pendientes</h4></td>
											<td class="text-center">
												<?php 
												$params = array ();
												$sql="{call prof_view()}";
												$prof_view = sqlsrv_query($conn, $sql, $params);
												$a=0;?>
												<select id="curso" name="curso" class="form-control input-sm" onchange="MostrarListado(this.value);" >
													<option value="0">- Seleccione un profesor -</option>
													<?php while($row_prof_view= sqlsrv_fetch_array($prof_view)){?>
													<option value="<?= $row_prof_view['prof_codi'];?>">
														<?= $row_prof_view['prof_apel'].' '.$row_prof_view['prof_nomb'];?>
													</option>
													<?php }?>
												</select>
												<select class="form-control" class="form-control input-sm" onchange="CargarPeriodosDistribucion(this.value);"
												 style="width: 200px">
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
											   	<div id="div_sl_periodo_dist">
													<select class="form-control input-sm"
														 id="sl_periodo_dist"
														 disabled="disabled"
														 style="width: 200px">
														 <option value="0">Parcial/Quimestre</option>
													</select>
												</div>
									   	
											</td>
											<td class="text-center">
												   <a title="Descargar" onmouseover="$(this).tooltip('show');" href="window.open('reportes_generales/notas_pendientes_pdf.php?peri_codi')" style="cursor: pointer">
													   <span class="fa fa-file-pdf-o fa-2x" style='font-color:red'></span>
												   </a>
										   </td>
										</tr>
									</tbody>
								</table>
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
		<!-- Modal Estados Matriculación Nuevo -->
		<div class="modal fade" id="ModalProfesor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div id="modal_estado_content" class="modal-content">
					<div class="modal-header">
						<button 
							type="button" 
							class="close" 
							data-dismiss="modal">
							<span aria-hidden="true">&times;</span>
						</button>
						<h4 class="modal-title" id="myModalLabel"></h4>
					</div>
					<div id="modal_main" class="modal-body">
						<div class="row">
							<div class="col-md-12">

							</div>
							<div class="col-md-12">

							</div>
						</div>
					</div>
					<div class="modal-footer">
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
	</body>
</html>