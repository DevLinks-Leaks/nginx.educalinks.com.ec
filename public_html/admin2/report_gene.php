<!DOCTYPE html>
<html lang="es">
    <?php include("template/head.php");?>
    <body class="hold-transition skin-blue sidebar-mini <?php echo $_SESSION['sidebar_status']; ?>">
		<div class="wrapper">
			<?php include ('template/header.php');?>
			<?php $Menu=606;include("template/menu.php");?>
			<div class="content-wrapper">
				<section class="content-header">
					<h1>Reportes Generales</h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-bookmark"></i></a></li>
						<li class="active">Reportes Generales</li>
					</ol>
				</section>
				<section class="content" id="mainPanel">
					<div id="information">
						<script type="text/javascript" src="js/select_reportes_generales.js?<?=$rand?>"></script>
						<div class="box box-default">
						    <div class="box-header with-border">
						        <h3 class="box-title">
						        <div class="row">
						        	<div class="form-group col-md-3">
							        	<select class="form-control" onchange="CargarPeriodosDistribucion(this.value);CargarCursosParalelos(this.value);CargarCursosParalelosAlumnos(0);"
											 style="width: 200px">
											 <?
											 $peri_codi=$_SESSION['peri_codi'];
											 $params = array($peri_codi);
											 $sql="{call peri_dist_cab_view(?)}";
											 $peri_dist_cab_view = sqlsrv_query($conn, $sql, $params);
											 ?>
											 <option value="0">Elija</option>
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
								   <div class="form-group col-md-3" id="div_sl_periodo_dist">
										<select class="form-control"
											 id="sl_periodo_dist"
											 disabled="disabled"
											 style="width: 200px">
											 <option value="0">Parcial/Quimestre</option>
										</select>
									</div>
									<div class="form-group col-md-3" id="div_sl_paralelos">
										  <select class="form-control"
										  disabled="disabled"
										  style="width: 200px"
										  id="sl_paralelos">
										  <option value="0">Curso/Paralelo</option>
									  </select>
									</div>
									<div class="form-group col-md-3" id="div_sl_alumno">
										<select class="form-control"
											id="sl_alumnos"
											name="sl_alumnos"
											disabled="disabled"
											>
											<option value="0">Alumno</option>
										</select>
									</div>
						        </h3>
						    </div><!-- /.box-header -->
	    					<div class="box-body">
	    						<div class="row alumnos_main_lista" >
	    						<div class="col-md-12">
									<table class="table table-striped" id="alum_table">
										<thead>
											<tr>
												<th width="80%" class="sort"><span class="icon-sort icon"></span>Reporte </th>
												<th width="20%" class="sort"><span class="icon-cog icon"></span>Opciones</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td><h4>Certificado de Matr&iacute;cula</h4></td>
												<td>
													<h2>
													   <a title="Descargar" onmouseover="$(this).tooltip('show');" href="JavaScript:getURLCertMatriculaPDF('<?=$_SESSION['directorio'];?>');" >
														   <span class="fa fa-file-pdf-o" style='font-color:red'></span>
													   </a>
												   </h2>
											   </td>
											</tr>
											<tr>
												<td><h4>Certificado de Conducta</h4></td>
												<td>
													<h2>
														<a title="Descargar" onmouseover="$(this).tooltip('show');"  href="JavaScript:getURLCertComportamientoPDF();"> 
														<span class="fa fa-file-pdf-o" style='font-color:red'></span>
														</a>
													</h2>
												</td>
											</tr>
											<tr>
												<td><h4>Certificado de Asistencia</h4></td>
												<td>
													<h2>
													   <a title="Descargar" onmouseover="$(this).tooltip('show');"  href="JavaScript:getURLCertAsistenciaPDF();" >
														   <span class="fa fa-file-pdf-o" style='font-color:red'></span>
													   </a>
													</h2>
												</td>
											</tr>
											<tr>
												<td><h4>Certificado de Promoci&oacute;n</h4></td>
												<td>
													<h2>
														<a title="Descargar" onmouseover="$(this).tooltip('show');"  href="JavaScript:getURLCertPromocionPDF('<?= $_SESSION['directorio']; ?>','<?= $_SESSION['peri_codi']; ?>');">
															<span class="fa fa-file-pdf-o" style='font-color:red'></span>
														</a>
												   <h2>
												</td>
											</tr>
											<tr>
												<td><h4>Listado de alumnos con notas pendientes de ingreso</h4></td>
												<td>
													<h2>
														<a title="Descargar" onmouseover="$(this).tooltip('show');"  href="JavaScript:getURLNotasPendientesIngresoPDF();">
															<span class="fa fa-file-pdf-o" style='font-color:red'></span>
														</a>
													<h2>
												</td>
											</tr>
										<?php 
										if($_SESSION['directorio']=='delfos' or $_SESSION['directorio']=='delfosvesp'){
										  ?>
											<tr>
												<td><h4>Informe Cualitativo Final de Educación Inicial</h4></td>
												<td>
													<h2>
														<a title="Descargar" onmouseover="$(this).tooltip('show');"  href="JavaScript:getURLInformeCualitativoFinal();">
														  <span class="fa fa-file-pdf-o" style='font-color:red'></span>
														</a>
													<h2>
												</td>
											</tr>
										<?php 
										} ?>
											<tr>
												<td><h4>Ficha de Matricula</h4></td>
												<td>
													<h2>
														<a title="Descargar" onmouseover="$(this).tooltip('show');"  href="JavaScript:getURLFichaMatricula('<?=$_SESSION['directorio'];?>');">
															<span class="fa fa-file-pdf-o" style='font-color:red'></span>
														</a>
													<h2>
												</td>
											</tr>
											<tr>
												<td><h4>Libro de Calificaciones</h4></td>
												<td>
													<h2>
														<a title="Descargar" onmouseover="$(this).tooltip('show');"  href="JavaScript:getURLLibroCalificacionesPDF();">
															<span class="fa fa-file-pdf-o" style='font-color:red'></span>
														</a>
													<h2>
												</td>
											</tr>
											<tr>
												<td><h4>Reporte de Asistencia</h4></td>
												<td>
													<h2>
														<a title="Descargar" onmouseover="$(this).tooltip('show');"  href="JavaScript:getURLReporteAsistenciaPDF();">
													   <span class="fa fa-file-pdf-o" style='font-color:red'></span>
														</a>
													<h2>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
								</div>
	    					</div>
						</div>
						<!-- InstanceBeginEditable name="information" -->
						
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
		</script>
	</body>
</html>

