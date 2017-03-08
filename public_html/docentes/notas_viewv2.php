<?php 

	session_start();	 
	include ('../framework/dbconf.php');
 
	$peri_codi=$_SESSION['peri_codi'];
	$params = array($_SESSION['prof_codi'],$_SESSION['peri_codi']);
	$sql="{call prof_curs_para_mate_view(?,?)}";
	$prof_curs_para_mate_view = sqlsrv_query($conn, $sql, $params);  
	$cc = 0; 
?>  
<?php  
	while ($row_prof_curs_para_mate_view = sqlsrv_fetch_array($prof_curs_para_mate_view)) 
	{ 
		$cc +=1; 
?>
<div class="zones">
    <div class="docentes_notas">  
        <div class="accordion" id="accordion<?= $cc;?>">
          <div class="accordion-group">
            <div class="accordion-heading" >
				<a 
                    class="accordion-toggle"  
                    data-toggle="collapse" 
                    data-parent="#accordion<?= $cc;?>" 
                    href="#collapse<?= $cc;?>" 
                    onclick="view_accordeon('accordion-subinner_<?= $cc;?>',<?= $row_prof_curs_para_mate_view["curs_para_mate_prof_codi"]; ?>)">
				<table width='100%'>
					<tr>
						<td width='40%'>
							<input type='hidden' id='i_<?php echo $cc; ?>' value='<?php echo $cc; ?>'>
							<input type='hidden' id='curso_<?php echo $cc; ?>' value='<?php echo $row_prof_curs_para_mate_view['curs_para_codi']; ?>'>
							<input type='hidden' id='materia_<?php echo $cc; ?>' value='<?php echo $row_prof_curs_para_mate_view['curs_para_mate_codi']; ?>'>
							<?= $row_prof_curs_para_mate_view["curs_deta"]; ?> 
							'<?= $row_prof_curs_para_mate_view["para_deta"]; ?>'
						</td>
						<td width='60%'>
							<?= $row_prof_curs_para_mate_view["mate_deta"]; ?>

						</td>
					</tr>
				</table>
                </a>
            </div>
            <div id="collapse<?= $cc;?>" class="accordion-body collapse in">
				<div  id="accordion-inner_<?= $cc;?>" class="accordion-inner">
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
							<table class=" table_striped " width='100%'>
								<tr>
									<td width='30%' height='40px' style='vertical-align:top;text-align;right;'><?  
										$params = array($row_prof_curs_para_mate_view['peri_dist_cabe_codi']);
										$sql="{call peri_dist_peri_libt_view(?)}";
										$peri_dist_peri_nive_view = sqlsrv_query($conn, $sql, $params);  
										?>
										<select id="peri_dist_<?= $cc?>"
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
										<br>
										<div class="accordion" id="opciones_reportes_<?= $cc;?>">
											<div class="accordion-group">
												<div class="accordion-heading" style='text-align:center;'>
													<a 
														class="accordion-toggle"  
														data-toggle="collapse" 
														data-parent="#opciones_reportes_<?= $cc;?>" 
														href="#collapse_opciones_reportes_<?= $cc;?>" >
														Opciones avanzadas para reportes
													</a>
												</div>
												<div id="collapse_opciones_reportes_<?= $cc;?>" class="accordion-body collapse in">
													<div  id="opciones_reportes_body-inner_<?= $cc;?>" class="accordion-inner">
														<table>
															<tr>
																<td style='text-align:right;vertical-align:middle;'>
																	<input type='checkbox' id='report_logo_<?php echo $cc; ?>' checked='checked' ></input>
																</td>
																<td style='text-align:left;vertical-align:middle;'>
																	Ver logo de la escuela
																</td>
															</tr>
															<tr>
																<td style='text-align:right;vertical-align:middle;'>
																	<input type='checkbox' id='report_logo_minis_<?php echo $cc; ?>'></input>
																</td>
																<td style='text-align:left;vertical-align:middle;'>
																	Ver logo de institucion ministerial
																</td>
															</tr>
															<tr>
																<td style='text-align:right;vertical-align:middle;'>
																	<input type='checkbox' id='print_user_<?php echo $cc; ?>' checked='checked'></input>
																</td>
																<td style='text-align:left;vertical-align:middle;'>
																	Mostrar usuario que imprime.
																</td>
															</tr>
															<tr>
																<td style='text-align:right;vertical-align:middle;'>
																	<input type='checkbox' id='print_fd_<?php echo $cc; ?>'></input>
																</td>
																<td style='text-align:left;vertical-align:middle;'>
																	Mostrar fecha completa.
																</td>
															</tr>
															<tr>
																<td style='text-align:right;vertical-align:middle;'>
																	<select id='font_size_<?php echo $cc; ?>'>
																	<?php 
																		for($c=8;$c<=20;$c++)
																		{
																			echo "<option value='".$c."' "; if($c==12) echo ' selected="selected" '; echo ">".$c."</option>";
																		}
																	?>
																	</select>
																</td>
																<td style='text-align:left;vertical-align:middle;'>
																	<label class='form-control' for='size_<?php echo $cc; ?>'>Tamaño fuente</label>
																</td>
															</tr>
															<tr>
																<td style='text-align:right;vertical-align:middle;'>
																	<select id='font_type_<?php echo $cc; ?>'>
																		<option value='Times New Roman'>Times New Roman</option>
																		<option value='Arial' selected='selected'>Arial</option>
																		<option value='Helvetica'>Helvetica</option>
																		<option value='Calibri'>Calibri</option>
																	</select>
																</td>
																<td style='text-align:left;vertical-align:middle;'>
																	<label class='form-control' for='size_<?php echo $cc; ?>'>Fuente</label>
																</td>
															</tr>
														</table>
													</div>
												</div>
											</div>
										</div>
									</td>
									<td style='vertical-align:top;text-align;left;'>
										<div id='div_button_<?php echo $cc; ?>' >
											 <div class="alumnos_main_lista_<?php echo $cc; ?>'" style="float:none; width:100%;">
												<table class="table_striped" id="alum_table_<?php echo $cc; ?>'">
													<thead>
														<tr>
															<th width="5%">&nbsp;</th>
															<th width="65%" class="sort"><span class="icon-sort icon"></span>Reporte</th>
															<th width="30%" class="sort"><span class="icon-cog icon"></span>Opciones</th>
														</tr>
													</thead>
													<tbody>
														<tr><td style='vertical-align:middle;'><div id='acta_001_qm_<?php echo $cc; ?>'></div></td><td style='vertical-align:middle;'><div id='acta_001_titulo_<?php echo $cc; ?>'></div></td><td style='vertical-align:middle;' align='center'><div id='acta_001_opc_<?php echo $cc; ?>'></div></td></tr>
														<tr><td style='vertical-align:middle;'><div id='acta_002_pm_<?php echo $cc; ?>'></div></td><td style='vertical-align:middle;'><div id='acta_002_titulo_<?php echo $cc; ?>'></div></td><td style='vertical-align:middle;' align='center'><div id='acta_002_opc_<?php echo $cc; ?>'></div></td></tr>
														<tr><td style='vertical-align:middle;'><div id='acta_003_cq_<?php echo $cc; ?>'></div></td><td style='vertical-align:middle;'><div id='acta_003_titulo_<?php echo $cc; ?>'></div></td><td style='vertical-align:middle;' align='center'><div id='acta_003_opc_<?php echo $cc; ?>'></div></td></tr>
														<tr><td style='vertical-align:middle;'><div id='acta_004_cf_<?php echo $cc; ?>'></div></td><td style='vertical-align:middle;'><div id='acta_004_titulo_<?php echo $cc; ?>'></div></td><td style='vertical-align:middle;' align='center'><div id='acta_004_opc_<?php echo $cc; ?>'></div></td></tr>
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
								<table class="table_striped">
									<tr>
										<th align="left">
											
											<?  
											$params = array($row_prof_curs_para_mate_view['peri_dist_cabe_codi']);
											$sql="{call peri_dist_peri_libt_view(?)}";
											$peri_dist_peri_nive_view = sqlsrv_query($conn, $sql, $params);  
											?>
											<label for="peri_dist_<?= $cc?>">Periodo Distribución: </label>
											<select id="peri_dis_<?= $cc?>" name="peri_dist_<?= $cc?>">
												
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
											<label for="sl_alumnos_<?= $cc?>">Alumno: </label>
											<?$params = array ($row_prof_curs_para_mate_view['curs_para_codi']);
										    $sql = "{call curs_para_alums_view (?)}";
										    $stmt = sqlsrv_query($conn, $sql, $params);

										    if (sqlsrv_has_rows($stmt))
										    {
										      echo "<select id='sl_alumnos_".$cc."'' name='sl_alumnos_".$cc."' >";
										      while ($row = sqlsrv_fetch_array($stmt))
										      {
										        echo "<option value='".$row["alum_codi"]."'>".$row['alum_apel']." ".$row['alum_nomb']."</option>";
										      }
										    }
										    else
										    {
										      echo "<select id='sl_alumnos_".$cc."' disabled='disabled'>";
										      echo "<option value='0'>Alumno</option>";
										    }
										    echo "</select>";?>
										</th>
										<th>
											
											<div class="options">
												<button class="icon-print btn btn-primary" onclick="window.open('../admin/libretas/<?=$_SESSION['directorio']?>/<?=$_SESSION['peri_codi']?>/lib<?=$prefijo_libreta;?>_one.php?peri_dist_codi=' + $('#peri_dis_<?= $cc?>').val() +'&alum_codi=' + $('#sl_alumnos_<?= $cc?>').val() +'&curs_para_codi=<?=$row_prof_curs_para_mate_view['curs_para_codi'];?>','_blank')" style="margin: 10px 0px;">
								                    Ver Libreta
								                </button>
								                <button class="icon-print btn btn-primary" onclick="window.open('../admin/libretas/<?=$_SESSION['directorio']?>/<?=$_SESSION['peri_codi']?>/lib<?=$prefijo_libreta;?>_all.php?peri_dist_codi=' + $('#peri_dis_<?= $cc?>').val() +'&curs_para_codi=<?=$row_prof_curs_para_mate_view['curs_para_codi'];?>','_blank')" style="margin: 10px 0px;">
								                    Ver Todos
							                	</button>
											</div>
										</th>
									</tr>
								</table>
								<br/>
								<br/>
								<br/>
							</div>
						</div>
					</div>
			  </div>
            </div>
          </div>
        </div>
    </div>
</div>
<?php  
}   
?>
