<!DOCTYPE html>
<html lang="es">
    <?php include("template/head.php");?>
    <body class="hold-transition skin-blue sidebar-mini <?php echo $_SESSION['sidebar_status']; ?>">
		<div class="wrapper">
			<?php include ('template/header.php');?>
			<?php $Menu=201;include("template/menu.php");?>
			<div class="content-wrapper">
				<section class="content-header">
					<h1>Clases</h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-book"></i></a></li>
						<li class="active">Clases</li>
					</ol>
				</section>
				<section class="content" id="mainPanel">
					<div id="information">
						<div class="box box-default">
							<div class="box-header with-border">
								<h3 class="box-title">
									<a class="btn btn-warning" href="cursos_paralelo_main.php">
										<span class="fa fa-chevron-left"></span> Volver
									</a>
								</h3>
							</div>
							<div class="box-body">
								<div class="col-lg-12 col-sm-12 input-group input-group-sm">
									<span id="span_balance_reason" name="span_balance_reason" class="input-group-addon">Ver</span>
									<select id="cmb_mostrarMat" name="cmb_mostrarMat" class="form-control" onchange='js_cursos_paralelo_clase_select(this.value);' disabled='disabled'>
										<option value="">- Seleccione una materia -</option>
										<?php 
											$curs_para_codi=$_GET['curs_para_codi'];
											$params_mate = array($curs_para_codi);
											$sql_mate="{call curs_peri_mate_view_v2(?)}";
											$stmp_mate = sqlsrv_query($conn, $sql_mate, $params_mate);
											while($row_curs_mate_view=sqlsrv_fetch_array($stmp_mate))
											{
												$selected='';
												if($_GET['curs_para_mate_prof_codi']==$row_curs_mate_view['curs_para_mate_prof_codi']){
														$selected='selected';
												}
												echo '<option value="'.$row_curs_mate_view['curs_para_mate_prof_codi'].'" '.$selected.'>'.strtoupper($row_curs_mate_view["mate_deta"]).'</option>';
											}
										?>
									</select>
									<!--<span class="input-group-btn">
										<button type="button" class="btn btn-info btn-flat" onclick="js_cursos_paralelo_clase_load_subject();">Ver</button>
									</span>-->
								</div>
								<div id='div_ini_wait' align="center" style="height:100%;"><br><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i><br>Por favor, espere...</div>
								<div class="docentes_clases"> 
									<?php
									$curs_para_codi=$_GET['curs_para_codi'];
									$params_mate = array($curs_para_codi);
									$sql_mate="{call curs_peri_mate_view_v2(?)}";
									$stmp_mate = sqlsrv_query($conn, $sql_mate, $params_mate);
									$aux = 0;
									while($row_curs_mate_view=sqlsrv_fetch_array($stmp_mate))
									{
										if($_GET['curs_para_mate_prof_codi']==$row_curs_mate_view['curs_para_mate_prof_codi'])
											$display='';
										else
											$display='display:none;';
									?>
										<div style='<?=$display?>' id='mate_h_<?= $row_curs_mate_view['curs_para_mate_prof_codi'];?>' name='mate_h_<?php echo $aux; ?>' >
											<div class='form-group'>
												<div class='col-sm-6'>
													<div class="panel panel-default" id="prof_<?= $row_curs_mate_view['curs_para_mate_prof_codi'];?>" name="prof_<?= $row_curs_mate_view['curs_para_mate_prof_codi'];?>">
														<div class="panel-heading">
															<h3 class="panel-title"><span class="fa fa-briefcase"></span> Profesor</h3>
														</div>
														<div class="panel-body">
															<?php
															$ruta=$_SESSION['ruta_foto_docente'];
															$full_name=$ruta.$row_curs_mate_view['prof_codi'].".jpg";
															$file_exi=$full_name;
															if (file_exists($file_exi)){
																$pp=$file_exi;
															} else {
																$pp=$_SESSION['foto_default'];
															}?>
															<div class='form-group'>
																<div class='col-sm-2'>
																	<img src="<?php echo $pp;?>" title="<?= $row_curs_mate_view['prof_nomb']?>"  border="0" style="border-color:#F0F0F0;width:55px; height:55px;"/>
																</div>
																<div class='col-sm-10'>
																	<div class='row'>																					
																		<div class='col-sm-12'><?= $row_curs_mate_view["prof_nomb"]; ?></div>
																		<div class='col-sm-12'><?= $row_curs_mate_view["prof_mail"]; ?></div>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
												<div class='col-sm-6'>
													<div class="panel panel-default" id="resumen_<?= $row_curs_mate_view['curs_para_mate_prof_codi'];?>" name="resumen_<?= $row_curs_mate_view['curs_para_mate_prof_codi'];?>">
														<div class="panel-heading">
															<h3 class="panel-title"><span class="fa fa-stat"></span> Resumen</h3>
														</div>
														<div class="panel-body">
															<?
															$sql = "{call prof_summary (?)}";
															$params = array ($row_curs_mate_view["curs_para_mate_prof_codi"]);
															$stmt = sqlsrv_query($conn, $sql, $params);
															if ($stmp === false)
															{
																die(print_r (sqlsrv_errors(), true));
															}
															$row_summary = sqlsrv_fetch_array($stmt);
															?>
															<table style="width:100%;">
																<tr>
																	<td width="5%"><span class="fa fa-calendar"></span></td>
																	<td width="65%"><strong>Agendas activas</strong></td>
																	<td><?= $row_summary['num_agendas']?></td>
																</tr>
																<tr>
																	<td width="5%"><span class="fa fa-paperclip"></span></td>
																	<td width="65%"><strong>Materiales subidos</strong></td>
																	<td><?= $row_summary['num_materiales']?></td>
																</tr>
																<tr>
																	<td width="5%"><span class="fa fa-envelope"></span></td>
																	<td width="65%"><strong>Mensajes enviados (últimos 30 días)</strong></td>
																	<td><?= $row_summary['num_mensajes']?></td>
																</tr>
																<tr>
																	<td width="5%"><span class="fa fa-clock-o"></span></td>
																	<td width="65%"><strong>Última sesión</strong></td>
																	<td><?= $row_summary['ultima_sesion']?></td>
																</tr>
																<tr>
																	<td colspan="3">
																		<a
																			class="btn btn-primary center-block"
																			href="cursos_paralelo_clase_deta.php?curs_para_mate_prof_codi=<?php echo $row_curs_mate_view["curs_para_mate_prof_codi"];?>&curs_para_codi=<?php echo $curs_para_codi;?>">
																			Ver Detallado
																		</a>
																	</td>
																</tr>
															</table>
														</div>
													</div>
												</div>
											</div>
										</div>
										<?php $aux++; 
										} ?>
								</div>
							</div>
						</div>
		            </div>
				</section>
				<input type="hidden"  name="hd_num_materias" id="hd_num_materias" value='<?php echo $aux; ?>' />
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
			$( document ).ready(function() {
				document.getElementById( "div_ini_wait" ).innerHTML = '';
				document.getElementById( "cmb_mostrarMat" ).disabled = false;
				document.getElementById( "cmb_mostrarMat" ).focus();
			});
			function js_cursos_paralelo_clase_select( value )
			{	var num_materias = document.getElementById( "hd_num_materias" ).value;
				var i = 0;
				for (i = 0; i < num_materias; i++ )
				{   document.getElementsByName( "mate_h_" + i )[0].style.display ='none';
				}
				document.getElementById( "mate_h_" + value ).style.display ='inline';
				//$.growl({ title: "Educalinks informa", message: "Materia seleccionada" });
			}
		</script>
	</body>
</html>