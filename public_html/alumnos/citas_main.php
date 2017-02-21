<?php
session_start();
include("../framework/dbconf.php");
include("../framework/funciones.php");
?>
<div class="panel-group" role="tablist" id="accordion" aria-multiselectable="true" >
	<?php
	if (para_sist(402))
	{
		$params_mate = array($_SESSION['alum_codi'],$_SESSION['curs_para_codi']);
		$sql_mate="{call alum_curs_peri_mate_view(?,?)}";
		$stmp_mate = sqlsrv_query($conn, $sql_mate, $params_mate); 
		while($row_curs_mate_view=sqlsrv_fetch_array($stmp_mate)){
			?>
			<div class="panel panel-default">
				<div class="panel-heading" role="tab" id="mate_h_<?= $row_curs_mate_view['alum_curs_para_mate_codi'];?>">
					<h4 class="panel-title">
						<a  role="button"
						data-toggle="collapse" 
						data-parent="#accordion" aria-expanded="false" aria-controls="mate_b_<?= $row_curs_mate_view['alum_curs_para_mate_codi'];?>" href="#mate_b_<?= $row_curs_mate_view['alum_curs_para_mate_codi'];?>" >
						<span class="glyphicon glyphicon-chevron-down"></span>
						<?= mb_strtoupper($row_curs_mate_view["mate_deta"]); ?> 
					</a>
				</h4>
			</div>
			<div id="mate_b_<?= $row_curs_mate_view['alum_curs_para_mate_codi'];?>" 
				class="panel-collapse collapse" role="tabpanel" 
				aria-labelledby="mate_h_<?= $row_curs_mate_view['alum_curs_para_mate_codi'];?>">
				<div class="panel-body">
					<div class="row">
						<div class="col-md-6">
							<!-- Profesor -->
							<div class="panel panel-default">
								<div class="panel-heading">
									<h3 class="panel-title"><span class="glyphicon glyphicon-user"></span> Profesor</h3>
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
									<div class="row">
										<div class="col-md-2"><img src="<?php echo $pp;?>" title="<?= $row_curs_mate_view['prof_nomb']?>"  border="0" style="border-color:#F0F0F0;" class="img-responsive"/></div>
										<div class="col-md-10">
											<div class="row">
												<div class="col-md-12"><h4><?= $row_curs_mate_view["prof_nomb"]; ?></h4></div>
												<div class="col-md-12"><h5><b><?= $row_curs_mate_view["prof_mail"]; ?><b></h5></div>
												<div class="col-md-12">
													Fecha a Reservar: <input data-provide="datepicker" name="fecha_cita_<?= $row_curs_mate_view['alum_curs_para_mate_codi'];?>" id="fecha_cita_<?= $row_curs_mate_view['alum_curs_para_mate_codi'];?>" value="<?= date("d/m/Y");?>" data-date-format="dd/mm/yyyy"/>
													<script type="text/javascript" charset="utf-8">
														$("#fecha_cita_<?= $row_curs_mate_view['alum_curs_para_mate_codi'];?>").datepicker()
																.on('changeDate',function(e) {
																	var d = e.format('dd/mm/yyyy');
																	citas_free_view('citas_alum_curs_para_mate_<?= $row_curs_mate_view['alum_curs_para_mate_codi'];?>','citas_main_lista.php','<?=$row_curs_mate_view['prof_codi']?>','','<?= $row_curs_mate_view['alum_curs_para_mate_codi'];?>',d);
																});
														
													</script>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-6" id="citas_alum_curs_para_mate_<?= $row_curs_mate_view['alum_curs_para_mate_codi'];?>">
							<?php include("citas_main_lista.php");?>
						</div>
					</div>          	
				</div>
			</div>
		</div>
		<?php }
	}
	else
	{
		?>
		<h3>Las citas están desactivadas.</h3>
		<?
	}
	?> 
</div>