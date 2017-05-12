<?php 

	session_start();	 
	include ('../framework/dbconf.php');
 
	$peri_codi=$_SESSION['peri_codi'];
	$params = array($_SESSION['prof_codi'],$_SESSION['peri_codi']);
	$sql="{call prof_curs_para_mate_view(?,?)}";
	$prof_curs_para_mate_view = sqlsrv_query($conn, $sql, $params);  
	$cc = 0;
	$aux=0;
?>  
<div id='div_ini_wait' align="center" style="height:100%;"><br><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i><br>Por favor, espere...</div>
<?php  
	while ($row_prof_curs_para_mate_view = sqlsrv_fetch_array($prof_curs_para_mate_view)) 
	{ 
		$cc +=1; 
?>
	<div style='display:none;' id='mate_h_<?= $row_prof_curs_para_mate_view['curs_para_mate_codi'];?>' name='mate_h_<?php echo $aux; ?>' >
		<input type='hidden' id='i_<?php echo $cc; ?>' value='<?php echo $cc; ?>'>
		<input type='hidden' id='curso_<?php echo $cc; ?>' value='<?php echo $row_prof_curs_para_mate_view['curs_para_codi']; ?>'>
		<input type='hidden' id='materia_<?php echo $cc; ?>' value='<?php echo $row_prof_curs_para_mate_view['curs_para_mate_codi']; ?>'>
		<div class='form-group'>
			<div class='col-sm-12'>
					<ul class="nav nav-tabs" role="tablist">
						<li role="presentation" class="active"><a href="#home_<?= $cc;?>" aria-controls="Ingresar notas" role="tab" data-toggle="tab">Ingresar notas</a></li>
						<li role="presentation"><a href="#consultar_<?= $cc;?>" aria-controls="Ver/Imprmir notas" role="tab" data-toggle="tab">Ver/Imprimir notas</a></li>
						<li role="presentation"><a href="#lib_<?= $cc;?>" aria-controls="Libretas" role="tab" data-toggle="tab">Libretas</a></li>
					</ul>
					<!-- Tab panes -->
					<div class="tab-content">
						<div role="tabpanel" class="tab-pane active" id="home_<?= $cc;?>">
							<div  id="accordion-subinner_<?= $cc;?>" class="accordion-inner">
								<?= $prof_curs_para_mate_view["curs_para_mate_codi"]; ?>
							</div>
						</div>
						<div role="tabpanel" class="tab-pane" id="consultar_<?= $cc;?>">
							<table class="table table-striped" width='100%'>
								<tr>
									<td width='30%' height='40px' style='vertical-align:top;text-align;right;'><?  
										$params = array($row_prof_curs_para_mate_view['peri_dist_cabe_codi']);
										$sql="{call peri_dist_peri_libt_view(?)}";
										$peri_dist_peri_nive_view = sqlsrv_query($conn, $sql, $params);  
										?>
										<select class='form-control input-sm' id="peri_dist_<?= $cc?>"
											onchange="var sl_periodo_dist = document.getElementById('peri_dist_<?= $cc?>'); 
													  var sl_periodo_distText = sl_periodo_dist.options[sl_periodo_dist.selectedIndex].innerHTML;
													  ValidarOpciones(sl_periodo_distText , document.getElementById('i_<?php echo $cc; ?>').value);">
											
										<? 
											echo "<option value='0'>Elija</option>";
											while($row_peri_dist_peri_nive_view = sqlsrv_fetch_array($peri_dist_peri_nive_view))
											{ 	echo '<option value="'.$row_peri_dist_peri_nive_view['peri_dist_codi'].'">';
												echo $row_peri_dist_peri_nive_view['peri_dist_deta'];
												echo '</option>';
											} 
										?>
										</select>
										<br>
										<div class="panel box box-warning" id='opciones_reportes_<?= $cc;?>'>
											<div class="box-header with-border">
												<h4 class="box-title">
													<a data-toggle="collapse" data-parent="#opciones_reportes_<?= $cc;?>" href="#collapse_opciones_reportes_<?= $cc;?>">
													Opciones avanzadas para actas
													</a>
												</h4>
											</div>
											<div id="collapse_opciones_reportes_<?= $cc;?>" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
												<div class="box-body">
													<table class='table table-striped table-bordered'>
														<tr>
															<td style='text-align:left;vertical-align:middle;'>
																Ver logo de la escuela
															</td>
															<td style='text-align:left;vertical-align:middle;'>
																<input type='checkbox' id='report_logo_<?php echo $cc; ?>' checked='checked' ></input>
															</td>
														</tr>
														<tr>
															<td style='text-align:left;vertical-align:middle;'>
																Ver logo de institucion ministerial
															</td>
															<td style='text-align:left;vertical-align:middle;'>
																<input type='checkbox' id='report_logo_minis_<?php echo $cc; ?>'></input>
															</td>
														</tr>
														<tr>
															<td style='text-align:left;vertical-align:middle;'>
																Mostrar usuario que imprime.
															</td>
															<td style='text-align:left;vertical-align:middle;'>
																<input type='checkbox' id='print_user_<?php echo $cc; ?>' checked='checked'></input>
															</td>
														</tr>
														<tr>
															<td style='text-align:left;vertical-align:middle;'>
																Mostrar fecha completa.
															</td>
															<td style='text-align:left;vertical-align:middle;'>
																<input type='checkbox' id='print_fd_<?php echo $cc; ?>'></input>
															</td>
														</tr>
														<tr>
															<td style='text-align:left;vertical-align:middle;'>
																<label class='control-label' for='size_<?php echo $cc; ?>'>Tamaño fuente</label>
															</td>
															<td style='text-align:left;vertical-align:middle;'>
																<select class='form-control input-sm' id='font_size_<?php echo $cc; ?>'>
																<?php 
																	for($c=8;$c<=20;$c++)
																	{
																		echo "<option value='".$c."' "; if($c==12) echo ' selected="selected" '; echo ">".$c."</option>";
																	}
																?>
																</select>
															</td>
														</tr>
														<tr>
															<td style='text-align:left;vertical-align:middle;'>
																<label class='control-label' for='size_<?php echo $cc; ?>'>Fuente</label>
															</td>
															<td style='text-align:left;vertical-align:middle;'>
																<select class='form-control input-sm' id='font_type_<?php echo $cc; ?>'>
																	<option value='Times New Roman'>Times New Roman</option>
																	<option value='Arial' selected='selected'>Arial</option>
																	<option value='Helvetica'>Helvetica</option>
																	<option value='Calibri'>Calibri</option>
																</select>
															</td>
														</tr>
													</table>
												</div>
											</div>
										</div>
									</td>
									<td style='vertical-align:top;text-align;left;'>
										<div id='div_button_<?php echo $cc; ?>' >
											 <div class="alumnos_main_lista_<?php echo $cc; ?>'" style="float:none; width:100%;">
												<table class="table table-striped" id="alum_table_<?php echo $cc; ?>'">
													<thead style='background-color:rgba(1, 126, 186, 0.1) !important;'>
														<tr>
															<th width="5%">&nbsp;</th>
															<th width="65%" class="sort">Reporte</th>
															<th width="30%" class="sort">Opciones</th>
														</tr>
													</thead>
													<tbody>
														<tr><td style='vertical-align:middle;'><div id='acta_001_qm_<?php echo $cc; ?>'>&nbsp;</div></td><td style='vertical-align:middle;'><div id='acta_001_titulo_<?php echo $cc; ?>'></div></td><td style='vertical-align:middle;' align='center'><div id='acta_001_opc_<?php echo $cc; ?>'></div></td></tr>
														<tr><td style='vertical-align:middle;'><div id='acta_002_pm_<?php echo $cc; ?>'>&nbsp;</div></td><td style='vertical-align:middle;'><div id='acta_002_titulo_<?php echo $cc; ?>'></div></td><td style='vertical-align:middle;' align='center'><div id='acta_002_opc_<?php echo $cc; ?>'></div></td></tr>
														<tr><td style='vertical-align:middle;'><div id='acta_003_cq_<?php echo $cc; ?>'>&nbsp;</div></td><td style='vertical-align:middle;'><div id='acta_003_titulo_<?php echo $cc; ?>'></div></td><td style='vertical-align:middle;' align='center'><div id='acta_003_opc_<?php echo $cc; ?>'></div></td></tr>
														<tr><td style='vertical-align:middle;'><div id='acta_004_cf_<?php echo $cc; ?>'>&nbsp;</div></td><td style='vertical-align:middle;'><div id='acta_004_titulo_<?php echo $cc; ?>'></div></td><td style='vertical-align:middle;' align='center'><div id='acta_004_opc_<?php echo $cc; ?>'></div></td></tr>
													</tbody>
												</table>
											</div>
										</div>
									</td>
								</tr>
							</table>
						</div>
						<div role="tabpanel" class="tab-pane" id="lib_<?= $cc;?>">
							<div  id="accordion-subinner_<?= $cc;?>" class="accordion-inner">
								<? $prefijo_libreta = ($row_prof_curs_para_mate_view['peri_dist_cab_tipo']=='I'?'_ini':''); ?>
								<table width='100%;' class="table table-striped table-bordered">
									<tr>
										<th align="left">
											
											<?  
											$params = array($row_prof_curs_para_mate_view['peri_dist_cabe_codi']);
											$sql="{call peri_dist_peri_libt_view(?)}";
											$peri_dist_peri_nive_view = sqlsrv_query($conn, $sql, $params);  
											?>
											<label for="peri_dist_<?= $cc?>">Periodo Distribución: </label>
										</th>
										<th align="left">
											<label for="sl_alumnos_<?= $cc?>">Alumno: </label>
										</th>
									</tr>
									<tr>
										<th align="left">
											<select class='form-control input-sm' id="peri_dis_<?= $cc?>" name="peri_dist_<?= $cc?>">
												
											<? 
												// echo "<option value='0'>Elija</option>";
												while($row_peri_dist_peri_nive_view = sqlsrv_fetch_array($peri_dist_peri_nive_view))
												{ 	echo '<option value="'.$row_peri_dist_peri_nive_view['peri_dist_codi'].'">';
													echo $row_peri_dist_peri_nive_view['peri_dist_deta'];
													echo '</option>';
												} 
											?>
											</select>
										</th>
										<th align="left">
											<?$params = array ($row_prof_curs_para_mate_view['curs_para_codi']);
										    $sql = "{call curs_para_alums_view (?)}";
										    $stmt = sqlsrv_query($conn, $sql, $params);

										    if (sqlsrv_has_rows($stmt))
										    {
										      echo "<select class='form-control input-sm' id='sl_alumnos_".$cc."'' name='sl_alumnos_".$cc."' >";
										      while ($row = sqlsrv_fetch_array($stmt))
										      {
										        echo "<option value='".$row["alum_codi"]."'>".$row['alum_apel']." ".$row['alum_nomb']."</option>";
										      }
										    }
										    else
										    {
										      echo "<select class='form-control input-sm' id='sl_alumnos_".$cc."' disabled='disabled'>";
										      echo "<option value='0'>Alumno</option>";
										    }
										    echo "</select>";?>
										</th>
									</tr>
								</table>
								<button class="btn btn-default" onclick="window.open('../admin/libretas/<?=$_SESSION['directorio']?>/<?=$_SESSION['peri_codi']?>/lib<?=$prefijo_libreta;?>_one.php?peri_dist_codi=' + $('#peri_dis_<?= $cc?>').val() +'&alum_codi=' + $('#sl_alumnos_<?= $cc?>').val() +'&curs_para_codi=<?=$row_prof_curs_para_mate_view['curs_para_codi'];?>','_blank')" style="margin: 10px 0px;">
									<span class='fa fa-print'></span> Ver Libreta
								</button>
								<button class="btn btn-default" onclick="window.open('../admin/libretas/<?=$_SESSION['directorio']?>/<?=$_SESSION['peri_codi']?>/lib<?=$prefijo_libreta;?>_all.php?peri_dist_codi=' + $('#peri_dis_<?= $cc?>').val() +'&curs_para_codi=<?=$row_prof_curs_para_mate_view['curs_para_codi'];?>','_blank')" style="margin: 10px 0px;">
									<span class='fa fa-print'></span> Ver Todos
								</button>
							</div>
						</div>
					</div>
			</div>
        </div>
    </div>
<?php  
	$aux++;
}   
?>
<input type="hidden"  name="hd_num_materias" id="hd_num_materias" value='<?php echo $aux; ?>' />
