
<?php 

	session_start();	 
	include ('../framework/dbconf.php');
	include ("../framwork/funciones.php");					 
	
	$params = array($_SESSION['prof_codi'],$_SESSION['peri_codi']);
	$sql="{call prof_curs_para_view(?,?)}";
	$prof_curs_para_mate_view = sqlsrv_query($conn, $sql, $params);  
	$cc = 0; 
?>
<div id='div_ini_wait' align="center" style="height:100%;"><br><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i><br>Por favor, espere...</div>

<div class="zones">
	<div class="docentes_observaciones">
		<?php
			$params_mate = array($_SESSION['prof_codi'],$_SESSION['peri_codi']);
			$sql_mate="{call prof_curs_para_mate_view(?,?)}";
			$stmp_mate = sqlsrv_query($conn, $sql_mate, $params_mate); 
			$aux = 0;
			while($row_curs_mate_view=sqlsrv_fetch_array($stmp_mate))
			{   if ($row_curs_mate_view['curs_para_mate_agen']==1) 
				{
				?>
				<div style='display:none;' id='mate_h_<?= $row_curs_mate_view['curs_para_mate_codi'];?>' name='mate_h_<?php echo $aux; ?>' >
					<div class='form-group'>
						<div class='col-sm-12'>
							<?php
								$params2 = array($row_curs_mate_view['curs_para_codi']);
								$sql2="{call alum_curs_para_view(?)}";
								$alum_curs_para_view = sqlsrv_query($conn, $sql2, $params2); 
							?>
							<table class="table table-striped">
								<thead>
									<tr>
										<th width="5%"></th>
										<th width="5%"></th>
										<th width="80%">Alumnos</th>
										<th width="10%">Opciones</th>
									</tr>
								</thead>
								<tbody>
										<?php 
										$cc=0; 
										while ($row_alum_curs_para_view = sqlsrv_fetch_array($alum_curs_para_view)) 
										{ 
											$cc +=1; 
										?> 
									<tr>
										<?php
										$file_exi=$_SESSION['ruta_foto_alumno'].$row_alum_curs_para_view["alum_codi"].'.jpg';
							
										if (file_exists($file_exi)) 
										{
											$pp=$file_exi;
										} 
										else 
										{
											$pp='../fotos/'.$_SESSION['directorio'].'/alumnos/0.jpg';
										}
										?>
									  <td class="center" width="5%">
										<?php echo $cc; ?>
									  </td>
									  <td class="center" width="5%">
										<img src="<?php echo $pp; ?>"  style="width:20px; height:20px;"/>
									  </td>
									  <td class="left" width="80%">
									   <?= $row_alum_curs_para_view["alum_codi"];?>
									   - <?= $row_alum_curs_para_view["alum_apel"].' '.$row_alum_curs_para_view["alum_nomb"];?>
									  </td>
									  <td width="10%">
											  <button
												  class="btn btn-default"
												  onClick="window.location='observaciones_main.php?alum_curs_para_codi=<?= $row_alum_curs_para_view["alum_curs_para_codi"]?>'">
												  <span style='color:#3c8dbc' class='fa fa-plus'></span> Agregar
											  </button>
									  </td>
									</tr>
							<?php }?>
							  </tbody>
							</table>
						</div>
					</div>
				</div>
				<?php 
					$aux++; 
				}
			}
		?>
	</div>
</div>
<input type="hidden"  name="hd_num_materias" id="hd_num_materias" value='<?php echo $aux; ?>' />