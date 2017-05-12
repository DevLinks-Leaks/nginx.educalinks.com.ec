<?php
	include ('../framework/dbconf.php');
?>
	<ul class="nav nav-tabs">
	<li class="active"><a href="#tab2" data-toggle="tab">Materiales</a></li>
	<li><a href="#tab3" data-toggle="tab">Alumnos</a></li>
	<li><a href="#tab4" data-toggle="tab">Profesor</a></li>
</ul>
<div class="tab-content">
	<!--Seccion de Materiales-->
	<div class="tab-pane active" id="tab2">
		<div class="form-horizontal">
			<div class="form-group">
				<div class="col-sm-12">
					<h4>Subir material nuevo</h4>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-12">
					<form 
						action="javascript:void(0);" 
						enctype="multipart/form-data" 
						method="post">
						<div class="alumnos_add_script">
							<table class="table table-bordered">
								<tr>
									<td width='20%'>
										<label for="mater_titu"> 
											T&iacute;tulo del archivo: 
										</label> 
									</td>
									<td>
										<input class='form-control input-sm'
											type="text" 
											name="mater_titu" 
											id="mater_titu"/>
											
										<input  class='form-control input-sm'
											type="hidden" 
											name="curs_para_mate_prof_codi" 
											id="curs_para_mate_prof_codi"
											value="<?=$_POST['curs_para_mate_prof_codi']?>"/>
									</td>
								</tr>
								<tr>
									<td>
										<label for="mater_deta"> 
											Detalle material: 
										</label>
									</td>
									<td>
										<textarea class='form-control input-sm' id="mater_deta" name="mater_deta" rows="3"></textarea>
									</td>
								</tr>
								<tr>
									<td></td>
									<td>
										<input  class='form-control input-sm'type="file" name="archivo" id="archivo"/>
									</td>
								</tr>
							</table>
							<br>
							<div align="center" width='30%' style='atext-align:center'>
								<button type="submit" id="boton_subir" class="btn btn-success"><span class='fa fa-upload'></span> Subir material</button>
								<br>
								<br>
								<progress 
									id="barra_de_progreso" 
									value="0" 
									min="0" 
									max="100">
								</progress>
							</div>
						</div>
					</form>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-12">
					<div id="div_materiales">
					<hr>
					<h4>Materiales subidos</h4>
					<?php 
					$params_mater = array($_POST['curs_para_mate_prof_codi']);
					$sql_mater="{call curs_para_mate_mater_view(?)}";
					$stmp_mater = sqlsrv_query($conn, $sql_mater, $params_mater);
					?>
						<table class="table table-striped table-bordered">
							<thead style='background-color:rgba(1, 126, 186, 0.1) !important;'>
								<tr>
									<th>Detalle</th>
									<th style='text-align:center;'>Fecha</th>
									<th style='text-align:center;'>Opciones</th>
								</tr>
							</thead>
							<tbody>
							<?php 
							while($row_mater_view = sqlsrv_fetch_array($stmp_mater))
							{
							?>
								<tr>
									<td style='vertical-align:middle;'>
										<h4>
											<?= $row_mater_view['mater_titu'];?>
										</h4>
										<br>
										<?= $row_mater_view['mater_deta'];?>
									</td>
									<td style='text-align:center;vertical-align:middle;'>
										<?= date_format($row_mater_view['mater_fech_regi'],'d/m/Y');?>
									</td>
									<td style='text-align:center;vertical-align:middle;'>
										<a  class="btn btn-default" target='_blank'
											href="<?= $_SESSION['ruta_materiales_carga'].$row_mater_view['mater_file'];?>">
											<span class="fa fa-download"></span> Descargar
										</a>
										<a  class="btn btn-default" 
											href="javascript:elimina_materiales('div_materiales','script_materiales.php','<?= $row_mater_view['mater_codi'];?>','<?=$_POST['curs_para_mate_codi']?>')">
											<span class="fa fa-trash btn_opc_lista_eliminar"></span> Eliminar
										</a>
									</td>
								</tr>
							<?php }?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="tab-pane" id="tab3">
		<br>
		<div class='form-horizontal'>
			<div class='form-group'>
				<div class="col-md-5">
					<div class="panel panel-default">
						<div class="panel-heading">
							<span class="icons icon-users"></span>COMPAÑEROS DE CURSO:
						</div>
						<div class="panel-body">
							<?php 
							$params_compa = array($_POST['curs_para_mate_prof_codi']);
							$sql_compa="{call curs_para_prof_alums_view(?)}";
							$stmp_compa = sqlsrv_query($conn, $sql_compa, $params_compa); 
							$colum=6;
							$cont=0;
							while($row_compas_view = sqlsrv_fetch_array($stmp_compa))
							{	$cont++;
								$ruta=$_SESSION['ruta_foto_alumno'];
								$full_name=$ruta.$row_compas_view['alum_codi'].".jpg";
								$file_exi=$full_name;
								if (file_exists($file_exi)){
									$pp=$file_exi;
								} else {
									$pp=$_SESSION['foto_default'];
								}
								?>
								<div class="col-md-2 col-sm-2 col-xs-2 col-lg-2" id="div_foto_<?=$row_compas_view['alum_codi']?>" style="padding-left:5px;width:55px; height:55px;float:left">
									<img onClick="MostrarInfoAlumno(this.id);" 
										id="<?=$row_compas_view['alum_curs_para_codi']?>" src="<?php echo $pp;?>"
										title="<?= $row_compas_view['alum_apel']." ".$row_compas_view['alum_nomb'] ?>"
										onmouseover='$(this).tooltip("show");'
										border="0" class="img-thumbnail"
										style="border-color:#F0F0F0; cursor:pointer; width: 50px !important;height: 60px !important;"/>
								</div> 
								<?php if($cont==$colum){echo "<div style='float:none; width:100%; height:55px;'>&nbsp;</div>"; $cont=0;}?>
						<?php } ?>
						</div>
					</div>
				</div>
				<div class="col-md-7">
					<div id="alum_info_div">
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="tab-pane" id="tab4">
		<br>
		<?php
		$params_mate = array($_POST['curs_para_mate_prof_codi']);
		$sql_mate="{call curs_para_mate_prof_info(?)}";
		$stmp_mate = sqlsrv_query($conn, $sql_mate, $params_mate); 
		$row_curs_mate_view=sqlsrv_fetch_array($stmp_mate);
		$ruta=$_SESSION['ruta_foto_docente'];
		$full_name=$ruta.$row_curs_mate_view['prof_codi'].".jpg";
		$file_exi=$full_name;
		if (file_exists($file_exi)){
			$pp=$file_exi;
		} else {
			$pp=$_SESSION['foto_default'];
		}?>										
		<div class='form-horizontal'>
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
										<div class='col-sm-12'>Profesor: <?= $row_curs_mate_view["prof_nomb"]; ?></div>
										<div class='col-sm-12'>Email: <?= $row_curs_mate_view["prof_mail"]; ?></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>