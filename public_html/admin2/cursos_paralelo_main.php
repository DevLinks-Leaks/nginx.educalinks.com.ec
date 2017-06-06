<!DOCTYPE html>
<?php
	
	if ( isset( $_GET['curs_para_codi'] ) )
		$search_by_curs_para_codi = $_GET['curs_para_codi'];
	else
		$search_by_curs_para_codi = -1; 
	 
?>
<html lang="es">
    <?php include("template/head.php");?>
    <body class="hold-transition skin-blue sidebar-mini <?php echo $_SESSION['sidebar_status']; ?>">
		<div class="wrapper">
			<?php include ('template/header.php');?>
			<?php $Menu=201;include("template/menu.php");?>
			<div class="content-wrapper">
				<section class="content-header">
					<h1>Cursos Paralelos</h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-university"></i></a></li>
						<li class="active">Cursos Paralelos</li>
					</ol>
				</section>
				<section class="content" id="mainPanel">
					<div id="information">
						<div class="box box-default">
							<div class="box-header with-border">
								<h3 class="box-title">
									<?php
										if ( $search_by_curs_para_codi == -1 )
										{   if (permiso_activo(36))
												echo '	<a class="btn btn-primary"  id="bt_curs_add" onclick="document.getElementById(\'curs_deta\').value=\'\';" data-toggle="modal" data-target="#curs_nuev" title="">
														<span class="fa fa-plus"></span> Nuevo Curso
													</a>';
									?>
									<div class='visible-phone'>
										<div class="btn-group">
											<button type="button" 
													onmouseover="$(this).tooltip('show');"
													class="btn btn-default dropdown-toggle" data-toggle="dropdown">
												<span style='color:green;' class='fa fa-file-excel-o'></span>&nbsp;Reportes&nbsp;<span class="caret"></span>
											</button>
											<ul class="dropdown-menu" role="menu">
												<li><a id="bt_curs_add"  href="cursos_paralelo_nomina_distrito_main_view_xls.php?peri_codi=<?= $_SESSION['peri_codi']; ?>" >
													<span style='color:#22ae73;' class="fa fa-file-excel-o"></span> Nómina Matr. General
												</a></li>
												<li><a id="bt_curs_add"  href="cursos_paralelo_nomina_totales_distrito_main_view_xls.php?peri_codi=<?= $_SESSION['peri_codi']; ?>" >
													<span style='color:#22ae73;' class="fa fa-file-excel-o"></span> Nómina Matr. Resumen
												</a></li>
												<li><a id="bt_curs_add"  href="listado_alumnos_all_xls.php" >
													<span style='color:#22ae73;' class="fa fa-file-excel-o"></span> Lista Matriculados
												</a></li>
												<li><a id="bt_curs_add"  href="listado_all_xls.php" title='Todos los alumnos con estado respectivo'>
													<span style='color:#22ae73;' class="fa fa-file-excel-o"></span> Lista General
												</a></li>
												<li><a  onclick=""
													data-toggle="modal"
													data-target="#ModalExcelencia"
													title=""><span style='color:#d5b62e;' class="fa fa-star"></span> Excelencia Acad.
												</a></li>
											</ul>
										</div>
									</div>
									<div class='visible-desktop'>
										<div class="btn-group">
											<button type="button" 
													onmouseover="$(this).tooltip('show');"
													class="btn btn-default dropdown-toggle" data-toggle="dropdown">
												<span style='color:green;' class='fa fa-file-excel-o'></span>&nbsp;Reportes&nbsp;<span class="caret"></span>
											</button>
											<ul class="dropdown-menu" role="menu">
												<li><a id="bt_curs_add"  href="cursos_paralelo_nomina_distrito_main_view_xls.php?peri_codi=<?= $_SESSION['peri_codi']; ?>" >
													<span style='color:#22ae73;' class="fa fa-file-excel-o"></span> Nómina Matr. General
												</a></li>
												<li><a id="bt_curs_add"  href="cursos_paralelo_nomina_totales_distrito_main_view_xls.php?peri_codi=<?= $_SESSION['peri_codi']; ?>" >
													<span style='color:#22ae73;' class="fa fa-file-excel-o"></span> Nómina Matr. Resumen
												</a></li>
												<li><a id="bt_curs_add"  href="listado_alumnos_all_xls.php" >
													<span style='color:#22ae73;' class="fa fa-file-excel-o"></span> Lista Matriculados
												</a></li>
												<li><a id="bt_curs_add"  href="listado_all_xls.php" title='Todos los alumnos con estado respectivo'>
													<span style='color:#22ae73;' class="fa fa-file-excel-o"></span> Lista General
												</a></li>
												<li><a  onclick=""
													data-toggle="modal"
													data-target="#ModalExcelencia"
													title=""><span style='color:#d5b62e;' class="fa fa-star"></span> Excelencia Acad.
												</a></li>
											</ul>
										</div>
									</div>
									<div style='display:none'>
										<a class="btn btn-default"  id="bt_curs_add"  href="cursos_paralelo_nomina_distrito_main_view_xls.php?peri_codi=<?= $_SESSION['peri_codi']; ?>" >
											<span style='color:#22ae73;' class="fa fa-file-excel-o"></span> Nómina Matr. General
										</a>
										<a class="btn btn-default"  id="bt_curs_add"  href="cursos_paralelo_nomina_totales_distrito_main_view_xls.php?peri_codi=<?= $_SESSION['peri_codi']; ?>" >
											<span style='color:#22ae73;' class="fa fa-file-excel-o"></span> Nómina Matr. Resumen
										</a>
										<a class="btn btn-default"  id="bt_curs_add"  href="listado_alumnos_all_xls.php" >
											<span style='color:#22ae73;' class="fa fa-file-excel-o"></span> Lista Matriculados
										</a>
										<a class="btn btn-default"  id="bt_curs_add"  href="listado_all_xls.php" title='Todos los alumnos con estado respectivo'>
											<span style='color:#22ae73;' class="fa fa-file-excel-o"></span> Lista General
										</a>
										<a  class="btn btn-default"
											onclick=""
											data-toggle="modal"
											data-target="#ModalExcelencia"
											title=""><span style='color:#d5b62e;' class="fa fa-star"></span> Excelencia Acad.
										</a>
									</div>
									<?php
										}
										else
										{	echo '<a href="cursos_paralelo_main.php" class="btn btn-info"  id="bt_curs_add" title="Ver el listado de todos los cursos del período lectivo '.$_SESSION['peri_deta'].'">
												<span class="fa fa-search"></span> Ver todos los cursos
											</a>';
										}
									?>
								</h3>
								 <?php include ('template/config_cursos.php');?>
							</div><!-- /.box-header -->
							<div class="box-body">
								<div id="curs_para_main">
									<?php  include ('cursos_paralelo_main_lista.php'); ?>
								</div>
								<script src="js/funciones_curs.js"></script>
								<script src="js/funciones_notas.js"></script>
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
		<script type="text/javascript" charset="utf-8">
			$(document).ready(function() {
				if (window.matchMedia('(max-width:960px)').matches)
					$('#table_cursos_paralelos').DataTable({
						language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'},
						"bSort": false ,
						"paging": false,
						"columnDefs": [
							{className: "dt-body-center", "targets": [0]},
							{className: "dt-body-center", "targets": [1], "visible": false},
							{className: "dt-body-right" , "targets": [2], "visible": false},
							{className: "dt-body-right" , "targets": [3], "visible": false}
						]
					});
				
				if (window.matchMedia('(min-width:961px)').matches)
					$('#table_cursos_paralelos').DataTable({
						language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'},
						"bSort": false
					});			
				$('[data-toggle="popover"]').popover({html:true});
			} );
		</script>
	</body>
</html>
 <!--Inicio modal agregar curso paralelo-->
<div 
	class="modal fade" 
	id="curs_nuev" 
	tabindex="-1" 
	role="dialog" 
	aria-labelledby="myModalLabel" 
	aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button 
					type="button" 
					class="close" 
					data-dismiss="modal">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">
					Nuevo curso paralelo
				</h4>
			</div>
			<div id="modal_main" class="modal-body">
				<div id="div_usua_edi"> 
					<form 
						id="frm_usua_edi" 
						name="frm_usua_edi" 
						method="post" 
						action="" 
						enctype="multipart/form-data">
						<div class="form_element">
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td width="25%" style="padding-top: 15px;">
										<label>Periodo Distribución: </label>
									</td>
									<td style="padding-top: 15px;">
									<? 	
										$peri_codi=$_SESSION['peri_codi'];
										$params = array($peri_codi);
										$sql="{call dist_peri_cab_view(?)}";
										$dist_peri_cab_view = sqlsrv_query($conn, $sql, $params);  
									?>
									<select class='form-control input-sm'
										id="sl_peri_dist_cabe_codi" 
										style="width: 75%; background-color:#CDF8F6;" 
										onchange="CargarModelos(this.value,document.getElementById('nota_refe_cab_codi').value);">
									<? 
									while($row_dist_peri_cab_view = sqlsrv_fetch_array($dist_peri_cab_view))
									{ 
									?>
									  <option 
										value="<?= $row_dist_peri_cab_view['peri_dist_cab_codi'];?>">
												<?= 
													$row_dist_peri_cab_view['peri_dist_cab_deta'];
												?>
									  </option>
									<?php
									}
									?>
									</select> 
									</td>
								</tr>
								<tr>
									<td width="25%">
										Curso: 
									</td>
									<td width="75%">
										<?php  
										$params = array();
										$sql="{call curs_view()}";
										$curs_view = sqlsrv_query($conn, $sql, $params);  
										?> 
										<select class='form-control input-sm'
											name="curs_codi" 
											id="curs_codi" 
											style="width: 75%; margin-top: 5px;">
										<?php  
										while ($row_curs_view = sqlsrv_fetch_array($curs_view)) 
										{
										$cc +=1; 
										?>     
											<option 
												value="<?= $row_curs_view['curs_codi']; ?>">
												<?= $row_curs_view['curs_deta']; ?>
											</option>
										<?php 
										}  
										?>	  
										</select>
									</td>
								</tr>
								<tr>
									<td>Paralelo: </td>
									<td>
										<?php  
										$params = array();
										$sql="{call para_view()}";
										$para_view = sqlsrv_query($conn, $sql, $params);  
										?> 
										<select class='form-control input-sm'
											name="para_codi"   
											id="para_codi" 
											style="width: 25%; margin-top: 5px;">
										<?php  
										while ($row_para_view = sqlsrv_fetch_array($para_view))
										{
											$cc +=1; 
										?>     
											<option 
												value="<?= $row_para_view['para_codi']; ?>">
												<?= $row_para_view['para_deta']; ?>
											</option>
										<?php 
										}  
										?>	  
										</select>
									</td>
								</tr>
								<tr>
									<td>Cupos: </td>
									<td>
										<input class='form-control input-sm'
											id="curs_para_cupo" 
											name="curs_para_cupo" 
											type="number" 
											value="<?php echo  para_sist(1); ?>" 
											min="0" style="width: 25%; margin-top: 5px;" 
											required>
									</td>
								</tr>
							</table>
						</div>
						<div class="form_element">&nbsp;</div>                
					</form>
				</div>
			</div>
			<div class="modal-footer">
				<button 
					type="button" 
					class="btn btn-success"  
					onClick="curs_para_save(<?= $_SESSION['peri_codi'];  ?>	,selectvalue(document.getElementById('sl_peri_dist_cabe_codi')),selectvalue(document.getElementById('curs_codi')),selectvalue(document.getElementById('para_codi')),document.getElementById('curs_para_cupo').value);" 
					data-dismiss="modal" ><span class='fa fa-floppy-o'></span> Guardar cambios
				</button>
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
<!--Inicio modal agregar curso paralelo-->
<!--Inicio modal eliminar notas curso paralelo-->
<div class="modal fade" id="ModalEliminarNotas" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="ModalCopiadeMaterias">Eliminar Notas</h4>
			</div>
			<div id="modal_main" class="modal-body">
				<div id="div_cupo_edi"> 
					<div class="form_element">
						<table border="0" cellpadding="0" cellspacing="0" width="100%;" class="table">
							<tr>
								<td width="25%" style="padding-top: 15px;">
									<label for="curs_para">Paralelo: </label>
								</td>
								<td style="padding-top: 15px;">
								<? 	
									$peri_codi=$_SESSION['peri_codi'];
									$params = array($peri_codi);
									$sql="{call peri_dist_peri_view_Lb(?)}";
									$peri_dist_peri_view = sqlsrv_query($conn, $sql, $params);  
								?>
								<select id="peri_dist_codi" style="width: 75%;">
								<? 
								while($row_peri_dist_peri_view = sqlsrv_fetch_array($peri_dist_peri_view))
								{ 
								?>
								  <option 
									value="<?= $row_peri_dist_peri_view['peri_dist_codi'];?>">
											<?= 
												(($row_peri_dist_peri_view['padre']=='')?
												$row_peri_dist_peri_view['padre']:
												$row_peri_dist_peri_view['padre'].' - ').
												$row_peri_dist_peri_view['peri_dist_deta'];
											?>
								  </option>
								<?php
								}
								?>
								</select> 
								</td>
							</tr>
							<tr>
								<td width="25%" style="padding-top: 15px;">
									Clave de seguridad:
								</td>
								<td style="padding-top: 15px;">
									<input type="password" id="txt_clave" placeholder="Ingrese su clave" style="width: 35%;"  />
								</td>
							</tr> 
						</table>  
					</div>
					<div class="form_element">&nbsp;</div>                
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" 
					onClick="notas_elim_peri_dist_all(document.getElementById('peri_dist_codi').value,
													  <? echo $_SESSION['codi']; ?>,
													  document.getElementById('txt_clave').value);" >
					<span class='fa fa-trash'></span> Eliminar
				</button>
				<button type="button" class="btn btn-default" data-dismiss="modal" >Cerrar</button>
			</div>
		</div>
	</div>
</div>
<!--Fin modal eliminar notas a curso paralelo-->
<script type="text/javascript" src="js/select_reportes_generales.js"></script>
<!--Inicio modal excelencia académica-->
<div class="modal fade" id="ModalExcelencia" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="ModalCopiadeMaterias">Informe de Excelencia Académica</h4>
			</div>
			<div id="modal_main" class="modal-body">
				<div id="div_cupo_edi"> 
					<div class="form_element">
						<table border="0" cellpadding="0" cellspacing="0" width="100%;" class="table">
							<tr>
								<td width="25%" style="padding-top: 15px;">
									<label>Tipo de Periodo: </label>
								</td>
								<td style="padding-top: 15px;">
								<? 	
									$peri_codi=$_SESSION['peri_codi'];
									$params = array($peri_codi);
									$sql="{call peri_dist_cab_view(?)}";
									$stmt = sqlsrv_query($conn, $sql, $params);  
								?>
								<select id="sl_peri_dist_cab" onchange="CargarCursosParalelosExc(this.value);" style="width: 200px">
									<option>Elija</option>
								<? 
								while($row = sqlsrv_fetch_array($stmt))
								{ 
								?>
								  <option 
									value="<?= $row['peri_dist_cab_codi'];?>">
											<?= 
												$row["peri_dist_cab_deta"];
											?>
								  </option>
								<?php
								}
								?>
								</select> 
								</td>
							</tr>
							<tr>
								<td width="25%" style="padding-top: 15px;">
									<label>Curso/Paralelo: </label>
								</td>
								<td style="padding-top: 15px;">
									<div id="div_sl_paralelos">
										<select
											disabled="disabled"
											style="width: 200px"
											id="sl_paralelos">
											<option value="0">Curso/Paralelo</option>
										</select>
									</div>
								</td>
							</tr>
						</table>
					</div>
					<div class="form_element">&nbsp;</div>                
				</div>
			</div>
			<div class="modal-footer">
				<button 
					type="button" 
					class="btn btn-success"
					onclick="getURLExcelenciaAcadExcel();">
					<span class='fa fa-download'></span> Descargar
				</button>
				<button 
					type="button" 
					class="btn btn-default" 
					data-dismiss="modal" >
					Cerrar
				</button>
			</div>
		</div>
	</div>
</div>