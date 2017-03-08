<?php
	session_start();	 
	include ('../framework/dbconf.php');
	include ('../framework/funciones.php');

	if (isset($_POST["alum_codi"])){$alum_codi = $_POST["alum_codi"];}else{	$alum_codi = "";}

	$params = array($alum_codi,$_SESSION['peri_codi']);
	$sql="{call alum_esta_info(?,?)}";
	$alum_esta_info = sqlsrv_query($conn, $sql, $params);  
	$alum_esta_info= sqlsrv_fetch_array($alum_esta_info);

	$alum_curs_para_codi = ($alum_esta_info['alum_curs_para_codi']==null) ? 0 : $alum_esta_info['alum_curs_para_codi'];


	$params = array();
	$sql="{call esta_view()}";
	$esta_view = sqlsrv_query($conn, $sql, $params);

?>

<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
	<h4 class="modal-title" id="ModalMatri_title">Estado de: <?=$alum_esta_info['alum_apel'].' '.$alum_esta_info['alum_nomb']?></h4>
</div>
<div id="modal_main" class="modal-body" >
	<div class="row">
		<table width="100%" >
			<tr>
				<td colspan='2'>
					<? include('modal_estado_peri_ante_view.php'); ?>
				</td>
			</tr>
			<tr>
				<td width="50%" valign='top'>
					<table width="90%">
						<tr>
							<td>
								<table width="100%">
									<tr>
										<td height='40px' valign='bottom' colspan='2'><b>Datos del Periodo Activo</b></td>
									</tr>
									<tr>
										<td height='1px' colspan='2'>
											<div style='font-size:1px'><hr style='height:1px; margin-top: 0.5em;' />
											</div>
										</td>
									</tr>
									<tr>
										<td width="30%">Año Lectivo:</td><td><b><?=$alum_esta_info['peri_deta'];?></b></td>
										
									</tr>
									<tr height='35px'>
										<td >Estado Actual:</td><td><b><?=$alum_esta_info['esta_deta'];?></b></td>
									</tr>
									<?php if(!($alum_esta_info['esta_abre']=='MAT' or $alum_esta_info['esta_abre']=='OYE')){ ?>
									<tr height='35px'>
										<td>Estado:</td>
										<td>
											<select id="esta_codi" onchange="<?php if($alum_curs_para_codi==0){ ?> load_ajax('div_cp_combo','modal_estado_cp_combo_view.php',''); <? }else{ ?> activar_boton(this.value); <? } ?>">
												<option data-abre="" value="0">Seleccione...</option>
											<?php while ($row_esta_view = sqlsrv_fetch_array($esta_view)){  
												if($row_esta_view['esta_codi']!=$alum_esta_info['esta_codi']){
													if($row_esta_view['esta_abre']=='MPP'){
														if( $_SESSION['certus_finan']==1){ ?>
															<option data-abre="<?= $row_esta_view['esta_abre'];?>" value="<?= $row_esta_view['esta_codi'];?>" ><?= $row_esta_view['esta_deta'];?></option>
											<?			}
										 			}else{ ?>
														<option data-abre="<?= $row_esta_view['esta_abre'];?>" value="<?= $row_esta_view['esta_codi'];?>" ><?= $row_esta_view['esta_deta'];?></option>
											<?		}
												}
											} ?>

											</select>
										</td>
									</tr>
									<tr id="div_cp_combo" height='35px'>
										<!-- <? 	include('modal_estado_cp_combo_view.php'); ?> -->
									</tr>
									<tr id="div_cupo" height='35px'>
										<!-- <? 	include('modal_estado_cp_cupo_view.php'); ?> -->
									</tr>
									<? } ?>
								</table>
							</td>
						</tr>
						<?php if($alum_curs_para_codi!=0){ ?>
						<tr>
							<td>
								<div id="div_estado_retiro" class="alert-danger">
									<? include('modal_estado_retiro_view.php'); ?>
								</div>
							</td>
						</tr>
						<? } ?>
					</table>
				</td>
				<td width="50%" valign='top'>
					<table width="90%">
						<tr>
							<td>
								<div id="div_estado_detalle">
									<?php if($alum_esta_info['esta_codi']!=null){ ?>
									<? 	include('modal_estado_detalle_view.php');
									} ?>
									<!-- <? 	include('modal_estado_detalle_view.php'); ?> -->
								</div>
							</td>
						</tr>
						<tr>
							<td>
								<div id="div_estado_documento">
									<!-- <?php if($alum_esta_info['esta_codi']!=null){ ?>
									<? 	include('modal_estado_documento_view.php');
									} ?> -->
									<? 	include('modal_estado_documento_view.php'); ?>
								</div>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<?php if(!($alum_esta_info['esta_abre']=='MAT' or $alum_esta_info['esta_abre']=='OYE')){ ?>
			<tr>
				<td colspan="2">&nbsp;</td>
			</tr>
			<tr>
				<td colspan="2">
					<ul class="list-group">
						<?php if( $_SESSION['certus_finan']==1){?>
						
							<? 	include('modal_estado_deud_matr_view.php'); ?>
						
						<? } ?>
							<? 	include('modal_estado_blacklist_view.php'); ?>
							<? 	include('modal_estado_bloq_dece_view.php'); ?>
					</ul>
				</td>
			</tr>
			<? } ?>
		</table>
	</div>
	<div class="row">&nbsp;
	</div>
</div>
<div id='ModalMatri_footer' class="modal-footer">
	<button id="btn_aplicar" type='button' class='btn btn-success' data-dismiss='modal' onclick="aplicar_estado('modal_estado_content','<?= $alum_curs_para_codi;?>','<?= $alum_esta_info['alum_codi'];?>');" disabled>Aplicar Estado</button>
	<button type='button' class='btn btn-default' data-dismiss='modal' >Cerrar</button>
</div>