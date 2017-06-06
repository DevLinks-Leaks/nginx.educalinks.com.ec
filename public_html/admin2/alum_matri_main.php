
<!DOCTYPE html>
<html lang="es">
    <?php include("template/head.php");?>
    <body class="hold-transition skin-blue sidebar-mini <?php echo $_SESSION['sidebar_status']; ?>">
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
								<form id="file_form" action="" enctype="multipart/form-data" method="post" target="_blank">
									<div id="tbl_search" class="form-horizontal" role="form">
										<div class='form-group'>
											<div class='col-md-6 col-sm-12'>
												<div class='form-group'>
													<label class="col-md-4 col-sm-3 control-label" style='text-align: right;' for='alum_codi_in'>Cod. del alumno:</label>
													<div class='col-md-8 col-sm-8'>
														<input type="text" class="form-control input-sm" name="alum_codi_in" id="alum_codi_in" >
													</div>	
												</div>
												<div class='form-group'>
													<label class="col-md-4 col-sm-3 control-label" style='text-align: right;' for='alum_apel_in'>Apellido del alumno:</label>
													<div class="col-md-8 col-sm-8"
															data-placement="bottom"
															title='Apellidos del alumno'
															onmouseover='$(this).tooltip("show")'>
														<input type="text" class="form-control input-sm" name="alum_apel_in" id="alum_apel_in" >
													</div>
												</div>
											</div>
											<div class='col-md-6 col-sm-12' style='text-align:right;'>
												<div class='form-group'>
													<div class="checkbox checkbox-info col-md-4 col-sm-4  col-md-offset-0 col-sm-offset-4" style='text-align:right'>
														<label for='ckb_gestionFactura_opc_adv'>
															<input type="checkbox" id='ckb_opc_adv' name='ckb_opc_adv' onclick='check_opc_avanzadas();'>
																<span style="text-align:left;font-size:small;font-weight:bold;">B&uacute;squeda avanzada</span>
														</label>
													</div>
													<div class='col-md-6 col-sm-4' style='text-align:left'>
														<button type='button' id='btn_buscar_alumnos' name='btn_buscar_alumnos' class="btn btn-primary"
															title="Presione [Enter] para buscar alumno(s)"
															onclick="js_alum_matri_search_complete();">
																<span class="fa fa-search"></span></button></td>
														<div class="btn-group">
															<button type="button" 
																	title="Exportar búsqueda" onmouseover="$(this).tooltip('show');"
																	class="btn btn-default dropdown-toggle" data-toggle="dropdown">
																<span style='color:green;' class='fa fa-file-excel-o'>&nbsp;</span><span class="caret"></span>
															</button>
															<ul class="dropdown-menu" role="menu">
																<li><a href="#" onclick="js_alumnos_lista_general();">Rep. Lista General</a></li>
															</ul>
														</div>
														<div id='EducaLinksHelperCliente' style='display:inline;font-size:x-small;text-align:left;vertical-align:text-bottom;'>
															<a href='#' onmouseover='$(this).tooltip("show")' 
															title="Los filtros de búsqueda funcionan también para todos los reportes en Excel." data-placement='right'><span class='glyphicon glyphicon-info-sign'></span></a>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div id='div_opc_adv' name='div_opc_adv' class='collapse'>
											<div class='row'>
												<div class='col-md-6 col-sm-12'>
													<div class='form-group'>
														<label class="col-md-4 col-sm-3 control-label" style='text-align: right;' for='txt_alum_id'>No. id. alumno:</label>
														<div class="col-md-8 col-sm-8"
																data-placement="bottom"
																title='Número de identificación del alumno'
																onmouseover='$(this).tooltip("show")'>
															<input type="text" class="form-control input-sm" name="txt_alum_id" id="txt_alum_id" >
														</div>
													</div>
												</div>
												<div class='col-md-6 col-sm-12'>
													<div class='form-group'>
														<label class="col-md-4 col-sm-3 control-label" style='text-align: right;' for='txt_fecha_nac_ini'>F. nacimiento:</label>
														<div class="col-md-8 col-sm-8">
															<div class="input-group" id="div_fini" name="div_fini" data-placement="bottom"
																 title='Fecha de nacimiento, desde, hasta.'
																 onmouseover='$(this).tooltip("show")'>
																<span class="input-group-addon">
																	<input type="checkbox" id='chk_fecha_nac' name='chk_fecha_nac' onclick='js_alumnos_main_check_fechanac();'>
																</span>		
																<span class="input-group-addon">
																	<small>Inicio</small></span>
																<input type="text" class="form-control input-sm" name="txt_fecha_nac_ini" id="txt_fecha_nac_ini" 
																			value="" placeholder="yyyy-mm-dd" disabled='disabled'>
															
																<span class="input-group-addon">
																	<small>Fin</small></span>
																<input type="text" class="form-control input-sm" name="txt_fecha_nac_fin" id="txt_fecha_nac_fin" 
																			value="" placeholder="yyyy-mm-dd" disabled='disabled'>
															</div>
														</div>
													</div>
												</div>
											</div>
											<div class='row'>
												<div class='col-md-6 col-sm-12'>
													<div class='form-group'>
														<label class="col-md-4 col-sm-3 control-label" style='text-align: right;' for='cmb_grupo_economico'>Grupo Económico:</label>
														<div class="col-md-8 col-sm-8">
															<?php 	include ('../framework/dbconf.php');        
																	$params = array();
																	$sql="{call grup_econ_view()}";
																	$stmt = sqlsrv_query($conn, $sql, $params);
												
																	if( $stmt === false )
																	{   echo "Error in executing statement .\n";
																		die( print_r( sqlsrv_errors(), true));
																	}
																	
																	echo '<select class="form-control input-sm" id="cmb_grupo_economico" name="cmb_grupo_economico">
																				<option value="-1">- Todos -</option>';
																	while($grup_econ_view= sqlsrv_fetch_array($stmt))
																	{	if($grup_econ_view["codigo"]==$alum_view['grupEcon_codigo'])
																			$select='selected="selected"';
																		else
																			$select="";
																		echo '<option value="'.$grup_econ_view["codigo"].'"'.$select.">".$grup_econ_view["descripcion"].'</option>';
																	}
																	echo '</select>';
															?>
														</div>
													</div>
												</div>
												<div class='col-md-6 col-sm-12'>
													<div class='form-group'>
														<label class="col-md-4 col-sm-3 control-label" style='text-align: right;' for='txt_fecha_matri_ini'>F. matriculaci&oacute;n:</label>
														<div class="col-md-8 col-sm-8">
															<div class="input-group" id="div_fini" name="div_fini" data-placement="bottom"
																 title='Fecha de matriculación, desde, hasta.'
																 onmouseover='$(this).tooltip("show")'>
																<span class="input-group-addon">
																	<input type="checkbox" id='chk_fecha_matri' name='chk_fecha_matri' onclick='js_alumnos_main_check_fechamatr();'>
																</span>		
																<span class="input-group-addon">
																	<small>Inicio</small></span>
																<input type="text" class="form-control input-sm" name="txt_fecha_matri_ini" id="txt_fecha_matri_ini" 
																			value="" placeholder="yyyy-mm-dd" disabled='disabled'>
															
																<span class="input-group-addon">
																	<small>Fin</small></span>
																<input type="text" class="form-control input-sm" name="txt_fecha_matri_fin" id="txt_fecha_matri_fin" 
																			value="" placeholder="yyyy-mm-dd" disabled='disabled'>
															</div>
														</div>
													</div>
												</div>
											</div>
											<div class='row'>
												<div class='col-md-6 col-sm-12'>
													<div class='form-group'>
														<label class="col-md-4 col-sm-3 control-label" style='text-align: right;' for='cmb_nivel'>Nivel:</label>
														<div class="col-md-8 col-sm-8" >
															<? 	
																$params = array();
																$sql="{call nive_view()}";
																$nive_view = sqlsrv_query($conn, $sql, $params);  
															?>
															<select class="form-control input-sm" id="cmb_nivel" name="cmb_nivel"
																onchange=' alum_get_curso_by_nivel( this.value, "div_cmb_curso" ); '>
																<option value="-1">- Todos -</option>
																<? while($row_nive_view = sqlsrv_fetch_array($nive_view)){ ?>
																  <option value="<?= $row_nive_view['nive_codi'];?>" <? if ($row_nive_view['nive_codi']==$row_curs_view["nive_codi"] ) echo 'selected="selected"';?> >
																	<?= $row_nive_view['nive_deta'];?></option>
																<? } ?>
															</select>  
														</div>
													</div>
												</div>
												<div class='col-md-6 col-sm-12'>
													<div class='form-group'>
														<label class="col-md-4 col-sm-3 control-label" style='text-align: right;' for='cmb_alum_estado'>Estado:</label>
														<div class="col-md-8 col-sm-8">
															<select class="form-control input-sm" id="cmb_alum_estado" name="cmb_alum_estado" />
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
											</div>
											<div class='row'>
												<div class='col-md-6 col-sm-12'>
													<div class='form-group'>
														<label class="col-md-4 col-sm-3 control-label" style='text-align: right;' for='alum_apel_in'>Curso:</label>
														<div id='div_cmb_curso' class="col-md-8 col-sm-8" >
															<select class="form-control input-sm"  id="curs_para_codi_in" name="curs_para_codi_in">
																<option value="-1">- Todos -</option>
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
													</div>
												</div>
											</div>
										</div>
									</div>
								</form>
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
				$('[data-toggle="popover"]').popover({html:true});
				$("#txt_fecha_nac_ini").datepicker({ format: 'yyyy-mm-dd' });
				$("#txt_fecha_nac_fin").datepicker({ format: 'yyyy-mm-dd' });
				$("#txt_fecha_matri_ini").datepicker({ format: 'yyyy-mm-dd' });
				$("#txt_fecha_matri_fin").datepicker({ format: 'yyyy-mm-dd' });
				$("#txt_fecha_nac_ini").inputmask({
					mask: "y-1-2", 
					placeholder: "yyyy-mm-dd", 
					leapday: "-02-29", 
					separator: "-", 
					alias: "yyyy/mm/dd"
				});
				$("#txt_fecha_nac_fin").inputmask({
					mask: "y-1-2", 
					placeholder: "yyyy-mm-dd", 
					leapday: "-02-29", 
					separator: "-", 
					alias: "yyyy/mm/dd"
				});
				$("#txt_fecha_matri_ini").inputmask({
					mask: "y-1-2", 
					placeholder: "yyyy-mm-dd", 
					leapday: "-02-29", 
					separator: "-", 
					alias: "yyyy/mm/dd"
				});
				$("#txt_fecha_matri_fin").inputmask({
					mask: "y-1-2", 
					placeholder: "yyyy-mm-dd", 
					leapday: "-02-29", 
					separator: "-", 
					alias: "yyyy/mm/dd"
				});
			});
			shortcut.add("Enter", function() {
				$('#btn_buscar_alumnos').trigger("click");
			},{'target':document.getElementById('tbl_search')});
			function check_opc_avanzadas()
			{   var ckb_opc_adv = document.getElementById("ckb_opc_adv").checked;
				if(ckb_opc_adv)
				{   $("#div_opc_adv").collapse(200).collapse('show');
				}
				else
				{   $("#div_opc_adv").collapse(200).collapse('hide');
				}
			}
			function js_alumnos_main_check_fechanac()
			{    var chk_tneto = document.getElementById("chk_fecha_nac").checked;
				if(chk_tneto)
				{   document.getElementById("txt_fecha_nac_ini").disabled = false;
					document.getElementById("txt_fecha_nac_fin").disabled = false;
				}
				else
				{   document.getElementById("txt_fecha_nac_ini").disabled = true;
					document.getElementById("txt_fecha_nac_fin").disabled = true;
					document.getElementById("txt_fecha_nac_ini").value = "";
					document.getElementById("txt_fecha_nac_fin").value = "";
				}
			}
			function js_alumnos_main_check_fechamatr()
			{    var chk_tneto = document.getElementById("chk_fecha_matri").checked;
				if(chk_tneto)
				{   document.getElementById("txt_fecha_matri_ini").disabled = false;
					document.getElementById("txt_fecha_matri_fin").disabled = false;
				}
				else
				{   document.getElementById("txt_fecha_matri_ini").disabled = true;
					document.getElementById("txt_fecha_matri_fin").disabled = true;
					document.getElementById("txt_fecha_matri_ini").value = "";
					document.getElementById("txt_fecha_matri_fin").value = "";
				}
			}
			function js_alumnos_lista_general()
			{	document.getElementById( 'file_form' ).action = 'listado_all_xls.php';
				document.getElementById( 'file_form' ).submit();
			}
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