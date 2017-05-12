<?php 

	session_start();	 
	include ('../framework/dbconf.php');
	include ("../framwork/funciones.php");					 
	
	$params = array($_SESSION['prof_codi'],$_SESSION['peri_codi']);
	$sql="{call prof_curs_para_view(?,?)}";
	$prof_curs_para_mate_view = sqlsrv_query($conn, $sql, $params);  
	$cc = 0; 
?> 
	<?php
        $params_mate = array($_SESSION['prof_codi'],$_SESSION['peri_codi']);
        $sql_mate="{call prof_curs_para_mate_view(?,?)}";
        $stmp_mate = sqlsrv_query($conn, $sql_mate, $params_mate); 
		$aux = 0;
        while($row_curs_mate_view=sqlsrv_fetch_array($stmp_mate)){
			if ($row_curs_mate_view["curs_para_mate_agen"] == 1)
			{?>
			<div style="<?=($aux==0 ? '' : 'display:none;');?>" id='mate_h_<?= $row_curs_mate_view['curs_para_mate_codi'];?>' name='mate_h_<?php echo $aux; ?>' >
				<div class='form-horizontal'>
					<div class='form-group'>
						<div class='col-sm-12'>
								<span class="fa fa-books"></span>Agendas: 
									<?php 
									$tipo_usua="A";
									$params_agen = array($row_curs_mate_view['curs_para_mate_prof_codi'],$tipo_usua);
									$sql_agen="{call agen_curs_para_mate_view_cont(?,?)}";
									$stmp_agen = sqlsrv_query($conn, $sql_agen, $params_agen); 
									while($row_agen_curs_view= sqlsrv_fetch_array($stmp_agen)){?>
										<?=$row_agen_curs_view['cont_agen']?>
									<?php } ?>
							<div class='pull-right'>
								<a  class="btn btn-default" target="_blank"
									href="cursos_paralelos_materias_profesor_lista.php?curs_para_mate_prof_codi=<?= $row_curs_mate_view['curs_para_mate_prof_codi']?>">
									<span class="fa fa-list"></span>
									Listado
								</a>
							</div>
						</div>
					</div>
					<div class='form-group'>
						<div class='col-sm-6'>
							<div class='form-group'>
								<div class='col-sm-12'>
									<table class="table table-striped table-bordered">
										<thead style='background-color:rgba(1, 126, 186, 0.1) !important;'>
											<tr>
												<th>
													<span class="icons icon-list"></span>Agenda
												</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td  class="no-padding">
													 <div class="agenda_list">
													<?php 
													$tipo_usua="A";
													$params_agen = array($row_curs_mate_view['curs_para_mate_prof_codi'],$tipo_usua);
													$sql_agen="{call agen_curs_para_mate_view(?,?)}";
													$stmp_agen = sqlsrv_query($conn, $sql_agen, $params_agen); 
													while($row_agen_curs_view= sqlsrv_fetch_array($stmp_agen)){?>
														<div class="agenda">
														<div style="width:70%;float:left;"><?=$row_agen_curs_view['agen_titu']?></div>
														<div style="width:30%;float:right;"><?=date_format($row_agen_curs_view['agen_fech_fin'], 'd/m/Y')?></div>
														</div>
													<?php } ?>
													</div>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
								<div class='col-sm-12'>
									<table class="table table-striped table-bordered">
										<thead style='background-color:rgba(1, 126, 186, 0.1) !important;'>
											<tr>
												<th>
													<span class="icons icon-list"></span>Permisos de Notas 
												</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td  class="no-padding">
													<div class="agenda_list">
														<?php 
															$curs_para_mate_codi=$row_curs_mate_view['curs_para_mate_codi']; 
															$params = array($curs_para_mate_codi);
															$sql="{call nota_perm_view_acti_pend(?)}";
															$nota_perm_view_acti_pend = sqlsrv_query($conn, $sql, $params);  
															$cc = 0;
														while($row_nota_perm_view_acti_pend= sqlsrv_fetch_array($nota_perm_view_acti_pend))
														{	if ($row_nota_perm_view_acti_pend['nota_peri_esta_resu']=='A') $ColorDeEstado='#DFD'; 
															if ($row_nota_perm_view_acti_pend['nota_peri_esta_resu']=='P') $ColorDeEstado='#D7EBFF';
														?>
												  
														<div class="agenda" style="background:<?=$ColorDeEstado;?>;">
														<div style="width:50%;float:left;"><?=$row_nota_perm_view_acti_pend['peri_dist_deta']?></div>
														
														<div style="width:50%;float:right;">Inicio del Permiso:<?=date_format($row_nota_perm_view_acti_pend['nota_peri_fec_ini'], 'd/m/Y')?></div>
														<div style="width:50%;float:left;">Estado: <?=$row_nota_perm_view_acti_pend['resu']?></div>
														<div style="width:50%;float:right;">Fin del Permiso:<?=date_format($row_nota_perm_view_acti_pend['nota_peri_fec_fin'], 'd/m/Y')?></div>
														</div>
													<?php 
														} ?>
													</div>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
						<div class='col-sm-6'>							
							<?php 
							$params_compa = array($row_curs_mate_view['curs_para_mate_prof_codi']);
							$sql_compa="{call curs_para_prof_alums_view(?)}";
							$stmp_compa = sqlsrv_query($conn, $sql_compa, $params_compa); 
							$colum=6;
							?>
							<div class="panel panel-default">
								<div class="panel-heading">
									<span class="icons icon-users"></span>COMPAÑEROS DE CURSO:
								</div>
								<div class="panel-body">
								<?php $cont=0; 
								while($row_compas_view = sqlsrv_fetch_array($stmp_compa))
								{   $cont++;
									$ruta=$_SESSION['ruta_foto_alumno'];
									$full_name=$ruta.$row_compas_view['alum_codi'].".jpg";
									$file_exi=$full_name;
									if (file_exists($file_exi))
									{   $pp=$file_exi;
									} 
									else
									{   $pp=$_SESSION['foto_default'];
									}
									?>
									<div id="div_foto_<?=$row_compas_view['alum_codi']?>" style="padding-left:5px;width:55px; height:55px;float:left">
										<img src="<?php echo $pp;?>" title="<?= $row_compas_view['alum_apel']." ".$row_compas_view['alum_nomb']?>"
											onmouseover='$(this).tooltip("show");'
											border="0" class="img-thumbnail" style="border-color:#F0F0F0; width: 50px !important;height: 60px !important;"/>
									</div> 
									<?php 
									if($cont==$colum)
									{	echo "<div style='float:none; width:100%; height:55px;'>&nbsp;</div>"; $cont=0;
									}
								} ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
	<?php $aux++;
		}
	}
    ?>