<!DOCTYPE html>
<html lang="es">
    <?php include("template/head.php");?>
    <body class="hold-transition skin-blue sidebar-mini">
		<div class="wrapper">
			<?php include ('template/header.php');?>
			<?php $Menu=606;include("template/menu.php");?>
			<div class="content-wrapper">
				<section class="content-header">
					<?php
						$params = array($_SESSION['curs_para_codi']);
						$sql="{call curs_para_info(?)}";
						$curs_para_info = sqlsrv_query($conn, $sql, $params);  
						$row_curs_para_info = sqlsrv_fetch_array($curs_para_info);
				  	?>
					<h1>Reportes Generales</h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-bookmark"></i></a></li>
						<li class="active">Reportes Generales</li>
					</ol>
				</section>
				<section class="content" id="mainPanel">
					<div id="information">
						<script type="text/javascript" src="js/select_reportes_generales.js?<?=$rand?>"></script>
						<div style="width:100%; float:left;">
							<div class="options" style="width:75%; float:none;"> 
								<ul>
									<li>
										<a class="button_text">
										 <select onchange="CargarPeriodosDistribucion(this.value);CargarCursosParalelos(this.value);CargarCursosParalelosAlumnos(0);"
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
									   </a>
									</li>
									<li>
										<a class="button_text">
											<div id="div_sl_periodo_dist">
												<select
													 id="sl_periodo_dist"
													 disabled="disabled"
													 style="width: 200px">
													 <option value="0">Parcial/Quimestre</option>
												</select>
											</div>
										</a>
									</li>
									<li>
										<a class="button_text">
											<div id="div_sl_paralelos">
												  <select
												  disabled="disabled"
												  style="width: 200px"
												  id="sl_paralelos">
												  <option value="0">Curso/Paralelo</option>
											  </select>
											</div>
										</a>
									</li>
									<li>
										<a class="button_text">
											<div id="div_sl_alumno">
												<select
													id="sl_alumnos"
													name="sl_alumnos"
													disabled="disabled"
													style="width: 200px">
													<option value="0">Alumno</option>
												</select>
											</div>
										</a>
									</li>
								</ul>
							</div>
						</div>
						<!-- InstanceBeginEditable name="information" -->
						<div class="alumnos_main_lista" style="float:none; width:100%;">
							<table class="table_striped" id="alum_table">
								<thead>
									<tr>
										<th width="90%" class="sort"><span class="icon-sort icon"></span>Reporte </th>
										<th width="10%" class="sort"><span class="icon-cog icon"></span>Opciones</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td><h3>Certificado de Matr&iacute;cula</h3></td>
										<td>
											<h1>
											   <a href="JavaScript:getURLCertMatriculaPDF();" >
												   <span class="icon-file-pdf icon"></span>
											   </a>
										   </h1>
									   </td>
									</tr>
									<tr>
										<td><h3>Certificado de Conducta</h3></td>
										<td>
											<h1>
												<a href="JavaScript:getURLCertComportamientoPDF();"> 
												<span class="icon-file-pdf icon"></span>
												</a>
											</h1>
										</td>
									</tr>
									<tr>
										<td><h3>Certificado de Asistencia</h3></td>
										<td>
											<h1>
											   <a href="JavaScript:getURLCertAsistenciaPDF();" >
												   <span class="icon-file-pdf icon"></span>
											   </a>
											</h1>
										</td>
									</tr>
									<tr>
										<td><h3>Certificado de Promoci&oacute;n</h3></td>
										<td>
											<h1>
												<a href="JavaScript:getURLCertPromocionPDF('<?= $_SESSION['directorio']; ?>','<?= $_SESSION['peri_codi']; ?>');">
													<span class="icon-file-pdf icon"></span>
												</a>
										   <h1>
										</td>
									</tr>
									<tr>
										<td><h3>Listado de alumnos con notas pendientes de ingreso</h3></td>
										<td>
											<h1>
												<a href="JavaScript:getURLNotasPendientesIngresoPDF();">
													<span class="icon-file-pdf icon"></span>
												</a>
											<h1>
										</td>
									</tr>
								<?php 
								if($_SESSION['directorio']=='delfos' or $_SESSION['directorio']=='delfosvesp'){
								  ?>
									<tr>
										<td><h3>Informe Cualitativo Final de Educación Inicial</h3></td>
										<td>
											<h1>
												<a href="JavaScript:getURLInformeCualitativoFinal();">
												  <span class="icon-file-pdf icon"></span>
												</a>
											<h1>
										</td>
									</tr>
								<?php 
								} ?>
									<tr>
										<td><h3>Ficha de Matricula</h3></td>
										<td>
											<h1>
												<a href="JavaScript:getURLFichaMatricula('<?=$_SESSION['directorio'];?>');">
													<span class="icon-file-pdf icon"></span>
												</a>
											<h1>
										</td>
									</tr>
									<tr>
										<td><h3>Libro de Calificaciones</h3></td>
										<td>
											<h1>
												<a href="JavaScript:getURLLibroCalificacionesPDF();">
													<span class="icon-file-pdf icon"></span>
												</a>
											<h1>
										</td>
									</tr>
									<tr>
										<td><h3>Reporte de Asistencia</h3></td>
										<td>
											<h1>
												<a href="JavaScript:getURLReporteAsistenciaPDF();">
											   <span class="icon-file-pdf icon"></span>
												</a>
											<h1>
										</td>
									</tr>
								</tbody>
							</table>
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
		</script>
	</body>
</html>

