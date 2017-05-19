
<!DOCTYPE html>
<html lang="es">
    <?php include("template/head.php");?>
    <body class="hold-transition skin-blue sidebar-mini">
		<div class="wrapper">
			<?php include ('template/header.php');?>
			<?php $Menu=605;include("template/menu.php");?>
			<div class="content-wrapper">
				<section class="content-header">
					<?php
						$params = array($_SESSION['curs_para_codi']);
						$sql="{call curs_para_info(?)}";
						$curs_para_info = sqlsrv_query($conn, $sql, $params);  
						$row_curs_para_info = sqlsrv_fetch_array($curs_para_info);
				  	?>
					<h1>Listado de Alumnos</h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-bookmark"></i></a></li>
						<li class="active">Alumnos</li>
					</ol>
				</section>
				<section class="content" id="mainPanel">
					<div id="information">
						<div class='panel panel-info dismissible' id='panel_search' name='panel_search'>
							<div class="panel-heading">
								<h3 class="panel-title"><span class="fa fa-search"></span>&nbsp;Búsqueda
									<div class="pull-right">
										<a href="#/"  id="boton_busqueda" name="boton_busqueda" style='text-decoration:none;'><span class='fa fa-minus'></span></a>
										<!--<a href="#/" data-target="#panel_search" data-dismiss="alert" aria-hidden="true"><span class='fa fa-times'></span></a>-->
									</div>
								</h3>
							</div>
							<div class="panel-body" id="desplegable_busqueda" name="desplegable_busqueda">
								<div id="tbl_search" class="form-horizontal" role="form">
									<div class='col-md-11 col-sm-12'>
										<div class='form-group'>
											<label class="col-md-2 col-sm-4 control-label" style='text-align: right;' for='alum_codi_in'>Cod. del alumno:</label>
											<div class="col-md-4 col-sm-8">
												<input type="text" class="form-control input-sm" name="alum_codi_in" id="alum_codi_in" >
											</div>
											<label class="col-md-2 col-sm-4 control-label" style='text-align: right;' for='alum_apel_in'>Apellido del alumno:</label>
											<div class="col-md-4 col-sm-8"
													data-placement="bottom"
													title='Apellidos del alumno'
													onmouseover='$(this).tooltip("show")'>
												<input type="text" class="form-control input-sm" name="alum_apel_in" id="alum_apel_in" >
											</div>
										</div>
										<div class='form-group'>
											<label class="col-md-2 col-sm-4 control-label" style='text-align: right;' for='alum_apel_in'>Curso:</label>
											<div class="col-md-4 col-sm-8" >
												<select class="form-control"  id="curs_para_codi_in" />
													<option value="0">- Todos -</option>
													<?
													$sql	= "{call curs_para_view (?)}";
													$params	= array($_SESSION["peri_codi"]);
													$stmt	= sqlsrv_query($conn,$sql,$params);
													while ($row = sqlsrv_fetch_array($stmt))
													{
														?>
														<option value="<?= $row["curs_para_codi"]?>"><?= $row["curs_deta"]." (".$row["para_deta"].")"?></option>
														<?
													}
													?>
												</select>
											</div>
											<label class="col-md-2 col-sm-4 control-label" style='text-align: right;' for='alum_apel_in'>Estado:</label>
											<div class="col-md-4 col-sm-8">
												<select class="form-control" id="cmb_alum_estado" name="cmb_alum_estado" />
													<option value="-1">- Todos -</option>
													<option value="1">RESERVADO</option>
													<option value="2">MATRICULADO POR PAGAR</option>
													<option value="3">MATRICULADO</option>
													<option value="4">OYENTE</option>
													<option value="5">RETIRADO</option>
													<option value="6">ADMITIDO</option>
													<option value="7">GRADUADO</option>
												</select>
											</div>
										</div>
									</div>
									<div class='col-md-1 col-sm-12'>
										<button id='btn_buscar_alumnos' name='btn_buscar_alumnos' class="btn btn-primary"
												title="Presione [Enter] para buscar alumno(s)"
												onclick="js_alum_matri_search(document.getElementById('alum_codi_in').value,document.getElementById('alum_apel_in').value,document.getElementById('curs_para_codi_in').value);">
													<span class="fa fa-search"></span></button></td>
									</div>
								</div>
							</div>
						</div>
						<div class="box box-default">
							<div class="box-header with-border">
								<h3 class="box-title"></h3>
							</div>
							<div class="box-body">
								<div id="alum_main">
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
		<script>
			$(document).ready(function(){
				$("#boton_busqueda").click(function(){
					$("#desplegable_busqueda").slideToggle(200);
				});
				$("#desplegable_busqueda").show();
				$('#alum_codi_in').focus();
			});
			shortcut.add("Enter", function() {
				$('#btn_buscar_alumnos').trigger("click");
			},{'target':document.getElementById('tbl_search')});
		</script>
	</body>
</html>
<!-- Modal Revertir deuda y borrar pago-->
<div class="modal fade" id="modal_alum_main_ask" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Educalinks</h4>
			</div>
			<div class="modal-body" id="modal_alum_main_ask_body">
			</div>
			<div class="modal-footer" id="modal_alum_main_ask_footer">
			</div>
		</div>
	</div>
</div>
<div class="modal fade" 
	 id="ModalCambiarCurso" 
	 tabindex="-1" 
	 role="dialog" 
	 aria-labelledby="myModalLabel" 
	 aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Cambiar de Curso</h4>
			</div>
			<div class="modal-body">
				<div id="div_documentos">
					<div class="form_element">
						<table width="100%" cellspacing="0" cellpadding="0" border="0">
							<tr>
								<td width="25%" style="padding-top: 15px">
									<b>Estudiante:</b>
								</td>
								<td style="padding-top: 15px">
									<div id="estudiante_info"></div>
								</td>
							</tr>
							<tr>
								<td width="25%" style="padding-top: 15px">
									<b>Curso Actual:</b>
								</td>
								<td style="padding-top: 15px">
									<div id="curso_actual"></div>
								</td>
							</tr>
							<tr>
								<td width="25%" style="padding-top: 15px">
									<b>Cambiar a:</b>
								</td>
								<td style="padding-top: 15px">
									<?
									$sql	= "{call curs_para_view (?)}";
									$params	= array($_SESSION["peri_codi"]);
									$stmt	= sqlsrv_query($conn,$sql,$params);
									?>
									<select class='form-control input-sm' style="width:80%" id="cmb_curs_para">
									<?
									while ($row	= sqlsrv_fetch_array($stmt))
									{	
									?>
										<option value="<?= $row["curs_para_codi"]?>"><?= $row["curs_deta"]." / ".$row["para_deta"]?></option>
									<?
									}
									?>
									</select>
								</td>
							</tr>
						</table>
					</div>
					<div class="form_element">&nbsp;</div>
				</div>
			</div>
			<div class="modal-footer">
				<button id='btn_curs_para_change' type='button' class='btn btn-success' onclick="alum_change_course(document.getElementById('cmb_curs_para').value,document.getElementById('alum_curs_para_codi').value)">Cambiar</button>
				<button type='button' class='btn btn-default' data-dismiss='modal'>Cerrar</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" 
	 id="ModalDocumentos" 
	 tabindex="-1" 
	 role="dialog" 
	 aria-labelledby="myModalLabel" 
	 aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Documentos</h4>
			</div>
			<div class="modal-body">
				<div id="div_document" class="row">
					
				</div>
			</div>
			<div class="modal-footer">
				<button type='button' class='btn btn-default' data-dismiss='modal'>Cerrar</button>
			</div>
		</div>
	</div>
</div>
<!-- Modal Estados Matriculación Nuevo -->
<div class="modal fade" id="ModalEstado" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div id="modal_estado_content" class="modal-content">
			
		</div>
	</div>
</div>
<!-- FIN MODAL -->
<div	class="modal fade" 
		id="ModalAlumBloqAdd" 
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
				<h4 class="modal-title" id="myModalLabel">Bloqueo</h4>
			</div>
			<div id="modal_main" class="modal-body">
				<div id="div_docu_nuev"> 
					<table width="100%" style="margin-bottom:20px">
						<tr>
							<td width="30%">
								Motivo
							</td>
							<td style="margin-top:5px">
								<select class='form-control input-sm' id="cmb_motivos" style="width: 75%">
								<?
								$sql	= "{call moti_bloq_all()}";
								$params	= array();
								$stmt	= sqlsrv_query($conn,$sql,$params);
								if ($stmt === false)
								{	die(print_r(sqlsrv_errors(),true));
								}
								while ($row = sqlsrv_fetch_array($stmt))
								{	echo "<option value='".$row["moti_bloq_codi"]."'>".$row["moti_bloq_deta"]."</option>";
								}
								?>
								</select>
							</td>
						</tr>
						<tr>
							<td width="30%">
								Opción a bloquear
							</td>
							<td style="padding-top:5px">
								<select class='form-control input-sm'  id="cmb_opciones" style="width: 75%">
								<?
								$sql	= "{call opci_all()}";
								$params	= array();
								$stmt	= sqlsrv_query($conn,$sql,$params);
								if ($stmt === false)
								{	die(print_r(sqlsrv_errors(),true));
								}
								while ($row = sqlsrv_fetch_array($stmt))
								{	echo "<option value='".$row["opci_codi"]."'>".$row["opci_deta"]."</option>";
								}
								?>
								</select>
								<input id="alum_bloq_codi" type="hidden" value="" />
							</td>
						</tr>
						<tr>
							<td width="30%">
							</td>
							<td style="padding-top:5px">
							<? if (permiso_activo(519)){?>
								<button class="btn btn-danger" onclick="alum_bloq_moti_opci_add('div_bloqueos',document.getElementById('alum_bloq_codi').value,'alum_moti_bloq_opci_view')"><span class="fa fa-plus"></span> Agregar bloqueo</button>
							<?}?>
							</td>
						</tr>
					</table>
					<div id="div_bloqueos">
					</div>
					<div class="form_element">&nbsp;</div>   
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
<div	class="modal fade" 
		id="ModalBlacklistAdd" 
		tabindex="-1" 
		role="dialog" 
		aria-labelledby="myModalLabel" 
		aria-hidden="true">
	<div class="modal-dialog">
		<div id="modal_main_blacklist" class="modal-content">
			
		</div>
	</div>
</div>