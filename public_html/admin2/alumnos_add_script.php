<div class="alumnos_add_script">

<?php  
session_start();
include ('../framework/dbconf.php');
if(isset($_POST['alum_codi']))
{	$alum_curs_para_codi = $_POST['alum_curs_para_codi'];
	$alum_codi=$_POST['alum_codi'];
}else
{
	if(isset($_GET['alum_codi']))
	{	$alum_curs_para_codi = $_GET['alum_curs_para_codi'];
		$alum_codi = $_GET['alum_codi'];
	}
	else
	{	$alum_curs_para_codi = 0;
		$alum_codi=0;
	}
}
/*
	Cuando se inscribe, recién obtiene un alum_curs_para_codi, si es nuevo, no permitir sacar Documentos, o indicarle al usuario que debe matricularlo primero.
*/

$params = array($alum_codi);
$sql="{call alum_info(?)}";
$stmt = sqlsrv_query($conn, $sql, $params);
if( $stmt === false ){
	echo "Error in executing statement .\n";die( print_r( sqlsrv_errors(), true));
} 
$alum_view= sqlsrv_fetch_array($stmt);
/*descencriptar numero tarjeta*/
if($alum_view['alum_resp_form_banc_tarj_nume']!=null and !is_numeric($alum_view['alum_resp_form_banc_tarj_nume'])){
	$alum_resp_form_banc_tarj_nume_dec=base64_decode($alum_view['alum_resp_form_banc_tarj_nume']);
	$iv = base64_decode($_SESSION['clie_iv']);
	$alum_resp_form_banc_tarj_nume = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $_SESSION['clie_key'], $alum_resp_form_banc_tarj_nume_dec, MCRYPT_MODE_CBC, $iv );
	// $alum_resp_form_banc_tarj_nume=rtrim($alum_resp_form_banc_tarj_nume,"\0");
	$alum_resp_form_banc_tarj_nume=preg_replace('/[^A-Za-z0-9\-]/', '',$alum_resp_form_banc_tarj_nume);
	$alum_resp_form_banc_tarj_nume =  creditCardMask($alum_resp_form_banc_tarj_nume,4,8);
}else{
	$alum_resp_form_banc_tarj_nume=$alum_view['alum_resp_form_banc_tarj_nume'];
}
/*FIN*/
?>
	<style>
		a,
		a label {
			cursor: pointer;
			text-decoration: none !important;
		}
	</style>
	<div id="div_noti">&nbsp;</div>
	<div id="div_blacklist_warning" style=""></div>
	<div class="alumnos_add_script">
		<form id="frm_alum" name="frm_alum" action="" enctype="multipart/form-data" method="post">
			<input id="alum_codi" name="alum_codi" type="hidden" value="<?=$alum_view['alum_codi'];?>">
			<input id="hd_user_verified" name="hd_user_verified" type="hidden" value="0"><!--verifica si usuario web es válido-->
			<div class="row">
				<div class="col-md-3">
					<div class="box">
						<div class="box-header">
							<h3 class="box-title"></h3>
						</div>
						<!-- /.box-header -->
						<div class="box-body no-padding">
							<div class="selector" style='text-align:center;'>
								<?php
								$file_exi=$_SESSION['ruta_foto_alumno'].$alum_view['alum_codi'].'.jpg';

								if (file_exists($file_exi)) {
									$pp=$file_exi;
								} else {
									$pp=$_SESSION['foto_default'];
								}
								?>
								<div id="div_foto" >
									<img src="<?php echo $pp;?>" width="220" height="200" />
								</div>
								<input type="file" class='form-control input-sm' name="alum_foto" id="alum_foto" class="btn" onBlur='LimitAttach(this,1);' />
							</div>

							<div class="btn-group-vertical">
								
																	
							</div>
							<div  id="alum_bloq_view">
							
							</div>
						</div>
						<!-- /.box-body -->
					</div>
					
					<div class="box box-solid">
						<div class="box-header with-border">
							<h3 class="box-title">Opciones</h3>
							<div class="box-tools">
								<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
								</button>
							</div>
						</div>
						<div class="box-body no-padding">
							<ul class="nav nav-pills nav-stacked">
								<li><a  
										data-toggle='modal' 
										data-target='#ModalEstado' 
										onclick="load_ajax('modal_estado_content','modal_estado_view.php','alum_codi=<?=$alum_view['alum_codi'];?>');" >
										<span class='fa fa-clipboard' style='margin-right:3px;'></span>&nbsp;Matricuación/Estado</a></li>
								<li><a  
										data-toggle='modal' 
										data-target='#ModalDocumentos'
										onclick="document.getElementById('alum_curs_para_codi').value="<?=$alum_curs_para_codi;?>";document.getElementById('alum_codi').value="<?=$alum_view['alum_codi'];?>";">
											<span class='fa fa-print' style='margin-right:3px;'></span>&nbsp;Documentos
									</a></li>
								<?php if (permiso_activo(21)){?>
								<li><a 
										href="#" title='Presione [Shift+F] para ver los familiares del alumno'
										onclick="window.location='representantes_add.php?alum_codi='+document.getElementById('alum_codi').value;"><i style="color:red;" class="fa fa-heart-o"></i> <font style='text-decoration:underline'>F</font>amiliares</a></li>
								<?php }?>
								<li><a  
										data-target='#ModalAlumBloqAdd'
										data-toggle='modal'
										onclick="show_edit_bloqueo('div_bloqueos',<?=$alum_view['alum_codi'];?>,'alum_moti_bloq_opci_view');">
										<span style="color:red;" class='fa fa-ban' style='margin-right:3px;'></span>&nbsp;Bloquear</a></li>
								<?php 
								if (permiso_activo(528))
								{	echo "
									<li>
										<a 
											data-target='#ModalBlacklistAdd'
											data-toggle='modal'
											onclick=\"load_ajax('modal_main_blacklist','script_alumnos_blacklist.php','bl_alum_codi=".$row_alum_busq["alum_codi"]."&opc=edit_view_new');\">
											<span style='color:red;' class='fa fa-ban' style='margin-right:3px;'></span>&nbsp;Blacklist</a>
									</li>";
								}?>
							</ul>
						</div>
					</div>
			
				</div>
				<div class="col-md-9">
					<div class="box">
						<div class="box-header">
							<h3 class="box-title">
								<?php if ($alum_view['alum_codi']==""){?>
										<button id="btn_inscribir" name="btn_inscribir" type="button" class='btn btn-success' title='Presione [Shift+I] para guardar' 
											onClick="load_ajax_add_alum('div_noti','script_alum.php','alum_codi');"><span class='fa fa-save'></span>  <font style='text-decoration:underline'>I</font>nscribir</button>
									
									<?php }else{?>
										<button id="btn_guardar" name="btn_guardar" type="button" class='btn btn-success' title='Presione [Shift+G] para guardar' 
											onClick="load_ajax_edit_alum('div_noti','script_alum.php','<?=$alum_view['alum_codi'];?>');"><span class='fa fa-save'></span>  <font style='text-decoration:underline'>G</font>uardar</button>
									 
									<?php }?>  
										<button id="btn_cancelar" name="btn_cancelar" class='btn btn-warning' type="reset"><span class='fa fa-eraser'></span> Limpiar cambios</button>
										<button id="btn_regresar" name="btn_regresar" class='btn btn-info' type="button" onclick="window.history.back();"><span class='fa fa-arrow-left'></span> Regresar</button>
							</h3>
						</div>
						<!-- /.box-header -->
						<div class="box-body no-padding">
							<?php
								$ineditable_acad = $ineditable_finan = "";
								if( permiso_activo( 532 ) )
									echo "<input type='hidden' id='hd_edit_acad' name='hd_edit_acad' value='yes' />";
								else
								{	$ineditable_acad ="<div class='alert alert-danger'>
										<strong>¡Advertencia!</strong> No tiene permisos para editar informacion academica. Por favor, solicitar al adminisitrador de sistemas este permiso.
									</div>";
									echo "<input type='hidden' id='hd_edit_acad' name='hd_edit_acad' value='no' />";
								}
								if( permiso_activo( 533 ) )
									echo "<input type='hidden' id='hd_edit_finan' name='hd_edit_finan' value='yes' />";
								else
								{	$ineditable_finan ="<div class='alert alert-danger'>
										<strong>¡Advertencia!</strong> No tiene permisos para editar informacion financiera. Por favor, solicitar al adminisitrador de sistemas este permiso.
									</div>";
									echo "<input type='hidden' id='hd_edit_finan' name='hd_edit_finan' value='no' />";
								}
							?> 
							<div id="tabs" name="tabs" class="nav-tabs-custom"> 
								<?php echo $ineditable_acad;
								echo $ineditable_finan; ?>
								<ul class="nav nav-tabs">    
									<li class="active"><a href="#tab1" data-toggle="tab" onClick=""><span class="fa fa-clipboard"></span> Datos personales</a></li>
									<li><a href="#tab2" data-toggle="tab" onClick=""><span class="fa fa-graduation-cap"></span> Datos académicos</a></li>
									<li><a href="#tab3" data-toggle="tab" onClick=""><span class="fa fa-money"></span> Débito Bancario</a></li>
									<li><a href="#tab4" data-toggle="tab" onClick=""><span class="fa fa-phone"></span> Emergencia</a></li>
									<?php if ( para_sist( 408 ) == '1' )
									{	echo '<li><a href="#tab5" data-toggle="tab" onClick=""><span class="fa fa-star-o"></span> Militar</a></li>';
									}?>
								</ul> 	
								<div class="tab-content">
									<div class="tab-pane active" id="tab1" name="tab1">
										<?php 
											if ($alum_view['alum_codi']==""){?>
											<?php if (para_sist(406)=='1'){?>
												<div class="form_element">
													<label for="curs_prom">Curso para código promocion:</label>
													<select class='form-control input-sm' id='curs_prom' name='curs_prom'>
													<?php 
														$params = array();
														$sql="{call curs_view()}";
														$stmt = sqlsrv_query($conn, $sql, $params);
														while($curs_view= sqlsrv_fetch_array($stmt))
														{
															echo '<option value="'.$curs_view["curs_codi"].'" >'.$curs_view["curs_deta"].' '.$curs_view["nive_deta"].'</option>';
														}
													?>
													</select>
												</div>
												<div class="form_element">
													<label >&nbsp;</label>
													<div style="float:none;">&nbsp;</div>
												</div>
											<? } ?>
										<? } ?>
										<div class="form_element">
											<label for="alum_nomb"><span style="color:red;">(*)</span>Nombres:</label>
											<input id="alum_nomb" name="alum_nomb" type="text" class="form-control input-sm" placeholder="Ingrese los nombres del alumno..." value="<?=$alum_view['alum_nomb'];?>"  onkeyup="alum_bloq_view(); new_username ();" onchange="load_ajax_blacklist_warning('div_blacklist_warning','script_alumnos_blacklist.php','warning_blacklist' );">
										</div>
										<div class="form_element">
											<label for="alum_apel"><span style="color:red;">(*)</span>Apellidos:</label>
											<input id="alum_apel" name="alum_apel" type="text" class="form-control input-sm" placeholder="Ingrese los apellidos del alumno..." value="<?=$alum_view['alum_apel'];?>" onkeyup="alum_bloq_view(); new_username ();" onchange="load_ajax_blacklist_warning('div_blacklist_warning','script_alumnos_blacklist.php','warning_blacklist' );">
										</div>
										<div class="form_element">
											<label for="alum_usua"><span style="color:red;">(*)</span>Usuario Web:</label>
											<input id="alum_usua" name="alum_usua" type="text" class="form-control input-sm" <?php if ($alum_view['alum_codi']!=""){?>disabled="disabled"<? }?> placeholder="Ingrese el usuario web para el alumno..." value="<?=$alum_view['alum_usua'];?>" onkeyup="verif_usua(this.value);" onClick="verif_usua(this.value);" >
										</div>
										<div class="form_element">
											<label for="div_veri_alum">&nbsp;</label>
											<div id="div_veri_alum" style="float:none;">&nbsp;</div>
										</div>
										<div class="form_element">
											<label for="alum_cedu"><?=(para_sist(405)=='1'?'<span style="color:red;">(*)</span>':'')?>Número de Identificación:</label>
											<input id="alum_cedu" class="form-control input-sm <?=(para_sist(405)=='1'?'required':'')?>" name="alum_cedu" type="text" placeholder="Ingrese la c&eacute;dula del alumno..." value="<?=$alum_view['alum_cedu'];?>" onkeyup="alum_bloq_view()">
										</div>
										<div class="form_element">
											<label for="alum_tipo_iden">Tipo de Identificación:</label>
											<?php 
												include ('../framework/dbconf.php');        
												$sql="select tipo_iden_codi, tipo_iden_deta from Tipo_Identificacion where tipo_iden_estado='A' and tipo_iden_show_acad ='Y' and tipo_iden_codi!=2";
												$stmt = sqlsrv_query($conn, $sql);
										
												if( $stmt === false )
												{
													echo "Error in executing statement .\n";
													die( print_r( sqlsrv_errors(), true));
												}
												echo "<select class='form-control input-sm' id='alum_tipo_iden' name='alum_tipo_iden' >";
												while($tipo_iden_result= sqlsrv_fetch_array($stmt))
												{
													$seleccionado="";
													if ($tipo_iden_result["tipo_iden_codi"]==$alum_view['alum_tipo_iden'])
																$seleccionado="selected";
													echo '<option value="'.$tipo_iden_result["tipo_iden_codi"].'" '.$seleccionado.'>'.$tipo_iden_result["tipo_iden_deta"].'</option>';
												}
												echo '</select>';
											?> 
										</div>
										<div class="form_element">
											<label for="alum_fech_naci"><span style="color:red;">(*)</span>Fecha de Nacimiento:</label>
											<input id="alum_fech_naci" name="alum_fech_naci" type="text" class="form-control input-sm" placeholder="Ingrese la fecha de nacimiento del alumno..." value="<?=date_format($alum_view['alum_fech_naci'],"d/m/Y");?>">
										</div>
										<div class="form_element">
											<label for="lbl_tipo"><span style="color:red;">(*)</span>Género:<br/><br/>
												<input id="genero" type="radio" name="genero" value="Hombre" <?= ($alum_view['alum_genero']==1?' checked':'') ?> />
													<span style="margin-right: 50px">Masculino</span>
												<input id="genero" type="radio" name="genero" value="Mujer" <?= ($alum_view['alum_genero']==0?' checked':'') ?> />
													<span style="margin-right: 50px">Femenino</span>
											</label>
										</div>
										<div class="form_element">
											<label for="alum_pais">País de nacimiento:</label>
											<select class='form-control input-sm' onchange="CargarProvincias('alum_prov_naci',this.value);" id="alum_pais" name="alum_pais">
											<?php 
											$params = array();
											$sql="{call cata_pais_cons()}";
											$stmt = sqlsrv_query($conn, $sql, $params);
											while($pais_view= sqlsrv_fetch_array($stmt))
											{
												$seleccionado="";
												if($alum_view['alum_pais']==''){
													if ($pais_view["descripcion"]=='Ecuador')
														$seleccionado="selected";
												}else{
													if ($pais_view["descripcion"]==$alum_view["alum_pais"])
														$seleccionado="selected";
												}
												echo '<option value="'.$pais_view["codigo"].'" '.$seleccionado.'>'.$pais_view["descripcion"].'</option>';
											}
											echo '</select>';
											?>
										</div>
										<div class="form_element">
											<label for="alum_prov_naci">Provincia de nacimiento:</label>
											<select class='form-control input-sm' onchange="CargarCiudades('alum_ciud_naci',this.value);" id='alum_prov_naci' name='alum_prov_naci'>
											<?php 

											$params = array(null,($alum_view["alum_pais"]==''?'Ecuador':$alum_view["alum_pais"]));
											$sql="{call cata_provincia_cons(?,?)}";
											$stmt = sqlsrv_query($conn, $sql, $params);
									
											while($ciudad_view= sqlsrv_fetch_array($stmt))
											{
												$seleccionado="";
												if ($ciudad_view["descripcion"]==$alum_view["alum_prov_naci"])
													$seleccionado="selected";
												echo '<option value="'.$ciudad_view["codigo"].'" '.$seleccionado.'>'.$ciudad_view["descripcion"].'</option>';
											}
											echo '</select>';
											?>
										</div>
										<div class="form_element">
											<label for="alum_ciud_naci">Ciudad de nacimiento:</label>
											<select class='form-control input-sm' onchange="CargarParroquias('alum_parr_naci',this.value);" id='alum_ciud_naci' name='alum_ciud_naci'>
											<?php 
											$params = array(null,$alum_view["alum_prov_naci"]);
											$sql="{call cata_ciudad_cons(?,?)}";
											$stmt = sqlsrv_query($conn, $sql, $params);
											while($ciudad_view= sqlsrv_fetch_array($stmt))
											{
												$seleccionado="";
												if ($ciudad_view["descripcion"]==$alum_view["alum_ciud_naci"])
													$seleccionado="selected";
												echo '<option value="'.$ciudad_view["codigo"].'" '.$seleccionado.'>'.$ciudad_view["descripcion"].'</option>';
											}
											echo '</select>';
											?>
										</div>
										<div class="form_element">
											<label for="alum_parr_naci">Parroquia de nacimiento:</label>
											<select class='form-control input-sm' id="alum_parr_naci" name="alum_parr_naci">
											<?php 
											$params = array(null,$alum_view["alum_ciud_naci"]);
											$sql="{call cata_parroquia_cons(?,?)}";
											$stmt = sqlsrv_query($conn, $sql, $params);

											while($parroquia_view= sqlsrv_fetch_array($stmt))
											{
												$seleccionado="";
												if ($parroquia_view["descripcion"]==$alum_view["alum_parr_naci"])
													$seleccionado="selected";
												echo '<option value="'.$parroquia_view["codigo"].'" '.$seleccionado.'>'.$parroquia_view["descripcion"].'</option>';
											}
											echo '</select>';
											?>
										</div>
										<div class="form_element">
											<label for="alum_sect_naci">Sector de nacimiento:</label>
											<select class="form-control" id="alum_sect_naci" name="alum_sect_naci">
											<?php 
											$params = array(400);
											$sql="{call cata_hijo_view(?)}";
											$stmt = sqlsrv_query($conn, $sql, $params);
									
											while($sector_view= sqlsrv_fetch_array($stmt))
											{
												$seleccionado="";
												if ($sector_view["descripcion"]==$alum_view["alum_sect_naci"])
													$seleccionado="selected";
												echo '<option value="'.$sector_view["descripcion"].'" '.$seleccionado.'>'.$sector_view["descripcion"].'</option>';
											}
											echo '</select>';
											?>
										</div>
										<div class="form_element">
											<label for="alum_nacionalidad"><span style="color:red;">(*)</span>Nacionalidad</label>
											<input id="alum_nacionalidad" name="alum_nacionalidad" type="text" class="form-control input-sm" placeholder="Ingrese la nacionalidad del alumno..." value="<?=$alum_view['alum_nacionalidad'];?>">
										</div>
										<div class="form_element">
											<label for="alum_mail">Email:</label>
											<input id="alum_mail" name="alum_mail" type="text" class="form-control input-sm" placeholder="Ingrese el email del alumno..." value="<?=$alum_view['alum_mail'];?>">
										</div>
										<div class="form_element">
											<label for="alum_celu">Celular:</label>
											<input id="alum_celu" name="alum_celu" type="text" class="form-control input-sm" placeholder="Ingrese el celular del alumno..." value="<?=$alum_view['alum_celu'];?>">
										</div>
										<div class="form_element">
											<label for="alum_domi"><span style="color:red;">(*)</span>Domicilio:</label>
											<input id="alum_domi" name="alum_domi" type="text" class="form-control input-sm" placeholder="Ingrese el domicilio del alumno..." value="<?=$alum_view['alum_domi'];?>">
										</div>
										<div class="form_element">
											<label for="alum_telf"><span style="color:red;">(*)</span>Tel&eacute;fono:</label>
											<input id="alum_telf" name="alum_telf" type="text" class="form-control input-sm" placeholder="Ingrese el tel&eacute;fono del alumno..." value="<?=$alum_view['alum_telf'];?>">
										</div>
										<div class="form_element">
											<label for="alum_prov"><span style="color:red;">(*)</span>Provincia domicilio:</label>
											<select class='form-control input-sm' onchange="CargarCiudades('alum_ciud',this.value);" id='alum_prov' name='alum_prov'>
											<?php 

											$params = array('ECU',null);
											$sql="{call cata_provincia_cons(?,?)}";
											$stmt = sqlsrv_query($conn, $sql, $params);
									
											while($ciudad_view= sqlsrv_fetch_array($stmt))
											{
												$seleccionado="";
												if($alum_view['alum_prov']==null){
													if($ciudad_view["descripcion"]=='Guayas'){
														$seleccionado="selected";
													}
												}else{
													if ($ciudad_view["descripcion"]==$alum_view["alum_prov"])
														$seleccionado="selected";
												}
												
												echo '<option value="'.$ciudad_view["codigo"].'" '.$seleccionado.'>'.$ciudad_view["descripcion"].'</option>';
											}
											echo '</select>';
											?>
										</div>
										<div class="form_element">
											<label for="alum_ciud"><span style="color:red;">(*)</span>Ciudad Domicilio:</label>
											<select onchange="CargarParroquias('alum_parroquia',this.value);" class='form-control input-sm'  id='alum_ciud' name='alum_ciud'>
											<?php 
											$params = array(null,($alum_view["alum_prov"]==''?'Guayas':$alum_view["alum_prov"]));
											$sql="{call cata_ciudad_cons(?,?)}";
											$stmt = sqlsrv_query($conn, $sql, $params);
											while($ciudad_view= sqlsrv_fetch_array($stmt))
											{
												$seleccionado="";
												if ($ciudad_view["descripcion"]==$alum_view["alum_ciud"])
													$seleccionado="selected";
												echo '<option value="'.$ciudad_view["codigo"].'" '.$seleccionado.'>'.$ciudad_view["descripcion"].'</option>';
											}
											echo '</select>';
											?>
										</div>
										<div class="form_element">
											<label for="alum_parroq">Parroquia Domicilio:</label>
											<select class="form-control" id="alum_parroquia" name="alum_parroquia">
											<?php 
											$params = array(null,$alum_view["alum_ciud"]);
											$sql="{call cata_parroquia_cons(?,?)}";
											$stmt = sqlsrv_query($conn, $sql, $params);

											while($parroquia_view= sqlsrv_fetch_array($stmt))
											{
												$seleccionado="";
												if ($parroquia_view["descripcion"]==$alum_view["alum_parroquia"])
													$seleccionado="selected";
												echo '<option value="'.$parroquia_view["codigo"].'" '.$seleccionado.'>'.$parroquia_view["descripcion"].'</option>';
											}
											echo '</select>';
											?>
										</div>
										<div class="form_element">
											<label for="alum_religion">Religi&oacute;n:</label>
											<?php 
												include ('../framework/dbconf.php');		
												$params = array(328);
												$sql="{call cata_hijo_view(?)}";
												$stmt = sqlsrv_query($conn, $sql, $params);
										
												if( $stmt === false )
												{
													echo "Error in executing statement .\n";
													die( print_r( sqlsrv_errors(), true));
												}
												echo '<select class="form-control input-sm" id="alum_religion" name="alum_religion">';
												while($religion_view= sqlsrv_fetch_array($stmt))
												{
													$seleccionado="";
													if ($religion_view["codigo"]==$alum_view["idreligion"])
														$seleccionado="selected";
													echo '<option value="'.$religion_view["codigo"].'" '.$seleccionado.'>'.$religion_view["descripcion"].'</option>';
												}
												echo '</select>';
											?>
										</div>
										<div class="form_element">
											<label for="alum_etnia">Etnia:</label>
											<?php 
												include ('../framework/dbconf.php');		
												$params = array(409);
												$sql="{call cata_hijo_view(?)}";
												$stmt = sqlsrv_query($conn, $sql, $params);
										
												if( $stmt === false )
												{
													echo "Error in executing statement .\n";
													die( print_r( sqlsrv_errors(), true));
												}
												echo '<select class=form-control input-smform-control input-smform-control input-sm id="alum_etnia" name="alum_etnia">';
												while($religion_view= sqlsrv_fetch_array($stmt))
												{
													$seleccionado="";
													if ($religion_view["codigo"]==$alum_view["alum_etnia"])
														$seleccionado="selected";
													echo '<option value="'.$religion_view["codigo"].'" '.$seleccionado.'>'.$religion_view["descripcion"].'</option>';
												}
												echo '</select>';
											?>
										</div>
										<div class="form_element">
											<label for="alum_vive_con">Vive con (Nombre):</label>
											<input id="alum_vive_con" name="alum_vive_con" type="text" class="form-control input-sm" placeholder="Ingrese con quien vive el alumno..." value="<?=$alum_view['alum_vive_con'];?>">
										</div>
										<div class="form_element">
											<label for="alum_vive_con">Vive con (Parentesco):</label>
											<?php 
												include ('../framework/dbconf.php');		
												$params = array(2);
												$sql="{call cata_hijo_view(?)}";
												$stmt = sqlsrv_query($conn, $sql, $params);
										
												if( $stmt === false )
												{
													echo "Error in executing statement .\n";
													die( print_r( sqlsrv_errors(), true));
												}
												echo '<select class="form-control input-sm" id="alum_parentesco_vive_con" name="alum_vive_con">';
												while($alum_vive_con_view= sqlsrv_fetch_array($stmt))
												{
													$seleccionado="";
													if ($alum_vive_con_view["codigo"]==$alum_view["idparentescovivecon"])
														$seleccionado="selected";
													echo '<option value="'.$alum_vive_con_view["codigo"].'" '.$seleccionado.'>'.$alum_vive_con_view["descripcion"].'</option>';
												}
												echo '</select>';
											?> 
										</div>
										<div class="form_element">
											<label for="alum_estado_civil_padres"><span style="color:red;">(*)</span>Estado civil de padres:</label>
											<?php 
												include ('../framework/dbconf.php');		
												$params = array(1);
												$sql="{call cata_hijo_view(?)}";
												$stmt = sqlsrv_query($conn, $sql, $params);
										
												if( $stmt === false )
												{
													echo "Error in executing statement .\n";
													die( print_r( sqlsrv_errors(), true));
												}
												echo '<select class="form-control input-sm" id="alum_estado_civil_padres" name="alum_estado_civil_padres">';
												while($esta_civil_padr_view= sqlsrv_fetch_array($stmt))
												{
													$seleccionado="";
													if ($esta_civil_padr_view["codigo"]==$alum_view["idestadocivilpadres"])
														$seleccionado="selected";
													echo '<option value="'.$esta_civil_padr_view["codigo"].'" '.$seleccionado.'>'.$esta_civil_padr_view["descripcion"].'</option>';
												}
												echo '</select>';
											?>
										</div>
										<div class="form_element">
											<label for="alum_movilizacion">Movilización:</label>
											<?php 
												include ('../framework/dbconf.php');		
												$params = array(406);
												$sql="{call cata_hijo_view(?)}";
												$stmt = sqlsrv_query($conn, $sql, $params);
										
												if( $stmt === false )
												{
													echo "Error in executing statement .\n";
													die( print_r( sqlsrv_errors(), true));
												}
												echo '<select class="form-control" id="alum_movilizacion" name="alum_movilizacion">';
												while($esta_civil_padr_view= sqlsrv_fetch_array($stmt))
												{
													$seleccionado="";
													if ($esta_civil_padr_view["descripcion"]==$alum_view["alum_movilizacion"])
														$seleccionado="selected";
													echo '<option value="'.$esta_civil_padr_view["codigo"].'" '.$seleccionado.'>'.$esta_civil_padr_view["descripcion"].'</option>';
												}
												echo '</select>';
											?>
										</div>
										<div class="form_element">
											<label for="alum_tiene_discapacidad">Inclusi&oacute;n:</label>
											<input id="alum_tiene_discapacidad" name="alum_tiene_discapacidad" type="checkbox"   <?= ($alum_view['alum_tiene_discapacidad']==1 ? 'checked':'');?>  onclick="ActivarDesactivarText('alum_tiene_discapacidad','alum_discapacidad')" />
										</div>
										<div class="form_element">
											<label for="alum_discapacidad">Discapacidad:</label>
											<input id="alum_discapacidad" name="alum_discapacidad" type="text" class="form-control input-sm" value="<?=$alum_view['alum_discapacidad'];?>"
												<?= ($alum_view['alum_tiene_discapacidad']==1?'':' disabled=true placeholder="No tiene" style="background-color:#d1d1d1;" ');?> >
										</div>
										
										<div class="form_element">
											<label for="alum_activ_deportiva">Disciplinas o deportes que practica:</label>
											<textarea class='form-control input-sm' id="alum_activ_deportiva" name="alum_activ_deportiva"><?=$alum_view['alum_activ_deportiva'];?></textarea>
										</div>
										<div class="form_element">
											<label for="alum_activ_artistica">Actividades artísticas que practica:</label>
											<textarea class='form-control input-sm' id="alum_activ_artistica" name="alum_activ_artistica"><?=$alum_view['alum_activ_artistica'];?></textarea>
										</div>
										<div class="form_element">
											<label for="alum_activ_artistica">Enfermedades, alergias, medicinas, prohibiciones, inhabilidades o tratamiento médico especial:</label>
											<textarea class='form-control input-sm' id="alum_enfermedades" name="alum_enfermedades"><?=$alum_view['alum_enfermedades'];?></textarea>
										</div>
										<div class="form_element">
											<label for="alum_tipo_sangre"><span style="color:red;">(*)</span>Tipo de sangre:</label>
											<select class='form-control input-sm' id="alum_tipo_sangre" name="alum_tipo_sangre">
												<option value="" <?=($alum_view['alum_tipo_sangre']==""?"selected":"")?>>Elija</option>
												<option value="PENDIENTE" <?=($alum_view['alum_tipo_sangre']=="PENDIENTE"?"selected":"")?>>PENDIENTE</option>
												<option value="O NEGATIVO" <?=($alum_view['alum_tipo_sangre']=="O NEGATIVO"?"selected":"")?>>O NEGATIVO</option>
												<option value="O POSITIVO" <?=($alum_view['alum_tipo_sangre']=="O POSITIVO"?"selected":"")?>>O POSITIVO</option>
												<option value="A NEGATIVO" <?=($alum_view['alum_tipo_sangre']=="A NEGATIVO"?"selected":"")?>>A NEGATIVO</option>
												<option value="A POSITIVO" <?=($alum_view['alum_tipo_sangre']=="A POSITIVO"?"selected":"")?>>A POSITIVO</option>
												<option value="B NEGATIVO" <?=($alum_view['alum_tipo_sangre']=="B NEGATIVO"?"selected":"")?>>B NEGATIVO</option>
												<option value="B POSITIVO" <?=($alum_view['alum_tipo_sangre']=="B POSITIVO"?"selected":"")?>>B POSITIVO</option>
												<option value="AB NEGATIVO" <?=($alum_view['alum_tipo_sangre']=="AB NEGATIVO"?"selected":"")?>>AB NEGATIVO</option>
												<option value="AB POSITIVO" <?=($alum_view['alum_tipo_sangre']=="AB POSITIVO"?"selected":"")?>>AB POSITIVO</option>
											</select>
										</div>
										<div class="form_element">
											<label for="div_veri_alum">&nbsp;</label>
											<div>&nbsp;</div>
										</div>
										<script>
										function verif_usua(text){
											js_student_verify_user('div_veri_alum','script_alum.php','opc=veri_usua&alum_usua='+text);
										}
										</script>
									</div>
									<div class="tab-pane" id="tab2" name="tab2">
										<div class="form_element">
											<label for="alum_ex_plantel">Plantel procedente:</label>
											<input id="alum_ex_plantel" name="alum_ex_plantel" type="text" class="form-control input-sm" placeholder="Ingrese el plantel procedente del alumno..." value="<?=$alum_view['alum_ex_plantel'];?>">
										</div>
										<div class="form_element">
											<label for="alum_ex_plantel_dire">Dirección plantel procedencia:</label>
											<input class="form-control" id="alum_ex_plantel_dire" name="alum_ex_plantel_dire" type="text" class="form-control input-sm" placeholder="Ingrese la dirección del plantel de procedencia..." value="<?=$alum_view['alum_ex_plantel_dire'];?>">
										</div>
										<div class="form_element">
											<label for="alum_motivo_cambio">Motivo cambio:</label>
											<input id="alum_motivo_cambio" name="alum_motivo_cambio" type="text" class="form-control input-sm" placeholder="Ingrese motivo de cambio del alumno..." value="<?=$alum_view['alum_motivo_cambio'];?>">
										</div>
										<div class="form_element">
											<label for="alum_condicionado">Condicionado:</label>
											<input id="alum_condicionado" name="alum_condicionado" type="checkbox" <?= ($alum_view['alum_condicionado']==1 ? 'checked':'');?>  onclick="ActivarDesactivarText('alum_condicionado','alum_motivo_condicion')"/>
										</div>
										<div class="form_element">
											<label for="alum_motivo_condicion">Motivo condición:</label>
											<input id="alum_motivo_condicion" name="alum_motivo_condicion" type="text" class="form-control input-sm" value="<?=$alum_view['alum_motivo_condicion'];?>" <?= ($alum_view['alum_condicionado']==1?'':' disabled=true placeholder="No tiene"');?> >
										</div>
										<div class="form_element">
											<label for="alum_ultimo_anio">Último año/curso de estudio:</label>
											<input id="alum_ultimo_anio" name="alum_ultimo_anio" type="text" class="form-control input-sm" placeholder="Ingrese último año de estudio del alumno..." value="<?=$alum_view['alum_ultimo_anio'];?>">
										</div>
										<div class="form_element">
											<label for="alum_conducta">Comportamiento anterior:</label>
											<input type="text" class="form-control input-sm" name="alum_conducta" id="alum_conducta" placeholder="Ingrese el comportamiento anterior..." value="<?=$alum_view['alum_conducta'];?>">
										</div>
										<div class="form_element">
											<label for="div_veri_alum">&nbsp;</label>
											<div id="div_veri_alum" style="float:none;">&nbsp;</div>
										</div>
									</div>
									<div class="tab-pane" id="tab3" name="tab3">
										<div id="opcion82"  <?php if (permiso_activo(82)) echo 'style="display:block;"'; else  echo 'style="display:none;"';?>  >
										<div class="form_element">
											<label for="alum_form_pago">Forma de Pago:</label>
											<?php 
												include ('../framework/dbconf.php');		
												$params = array(21);
												$sql="{call cata_hijo_view(?)}";
												$stmt = sqlsrv_query($conn, $sql, $params);
										
												if( $stmt === false )
												{
													echo "Error in executing statement .\n";
													die( print_r( sqlsrv_errors(), true));
												}
												echo '<select class="form-control input-sm" id="sl_form_pago" name="sl_form_pago" onchange="CargarBancosTarjetas(this.value);" >';
												echo '<option value="">SELECCIONE</option>';
												
												while($form_pago_view= sqlsrv_fetch_array($stmt))
												{
													$seleccionado="";
													if ($form_pago_view["codigo"]==$alum_view["alum_resp_form_pago"])
														$seleccionado="selected";
													echo '<option value="'.$form_pago_view["codigo"].'" '.$seleccionado.'>'.$form_pago_view["descripcion"].'</option>';
												}
												echo '</select>';
											?> 
										</div>
										<div class="form_element">
											<label for="lbl_banco_tarjeta" id="lbl_banco_tarjeta">Banco/Tarjeta:
												<?php 
												include ('../framework/dbconf.php');        
												$params = array($alum_view['alum_resp_form_pago']);
												$sql="{call cata_hijo_view(?)}";
												$stmt = sqlsrv_query($conn, $sql, $params);
										
												if( $stmt === false )
												{
													echo "Error in executing statement .\n";
													die( print_r( sqlsrv_errors(), true));
												}
												$seleccionado="";
												$deshabilitado="";
												if (!isset($alum_view['alum_resp_form_banc_tarj']))
													$deshabilitado="disabled";
												echo '<select class="form-control input-sm" id="sl_banco_tarjeta" name="sl_banco_tarjeta" '.$deshabilitado.'>';
												echo '<option value="">SELECCIONE</option>';
												while($banc_tarj_view= sqlsrv_fetch_array($stmt))
												{
													if($banc_tarj_view["codigo"]==$alum_view['alum_resp_form_banc_tarj'])
													{
														$seleccionado="selected";
													}
													else
													{
														$seleccionado="";
													}
													echo '<option '.$seleccionado.' value="'.$banc_tarj_view['codigo'].'">'.$banc_tarj_view["descripcion"].'</option>';
												}
												echo '</select>';
											?> 
											</label>
										</div>
										<div class="form_element">
											<label for="alum_banc_emisor">Banco emisor: (en caso de tarj. de crédito)</label>
											<?php 
												include ('../framework/dbconf.php');        
												$params = array(22);
												$sql="{call cata_hijo_view(?)}";
												$stmt = sqlsrv_query($conn, $sql, $params);
												if( $stmt === false )
												{	echo "Error in executing statement .\n";
													die( print_r( sqlsrv_errors(), true));
												}
												$seleccionado="";
												echo '<select class="form-control input-sm" id="sl_banco_emisor" name="sl_banco_emisor">';
												echo '<option value="">SELECCIONE</option>';
												while($row= sqlsrv_fetch_array($stmt))
												{	if($row["codigo"]==$alum_view['alum_resp_tarj_banco_emisor'])
													{	$seleccionado="selected";
													}
													else
													{	$seleccionado="";
													}
													echo '<option '.$seleccionado.' value="'.$row['codigo'].'">'.$row["descripcion"].'</option>';
												}
												echo '</select>';
											?> 
										</div>
										<div class="form_element">
											<label for="alum_resp_form_fech_vcto">Fecha de Vencimiento de Tarjeta:</label>
											<input id="alum_resp_form_fech_vcto" name="alum_resp_form_fech_vcto" type="text" class="form-control input-sm" placeholder="Ingrese la fecha de vencimiento de la tarjeta..." value="<?=date_format($alum_view['alum_resp_form_fech_vcto'],"d/m/Y");?>">
										</div>
										<?php if( permiso_activo( 534 ) and $alum_codi!=''){?>
										<div class="form_element">
											<label for="check">Check para ver número de cuenta/tarjeta sin máscara</label><input name="check" type="checkbox" onclick="visualizar(this.checked,<?=$alum_codi?>);" />
										</div>
										<?}?>
										<div class="form_element">
											<label for="alum_resp_form_banc_tarj_nume"><?=(para_sist(404)=='1'?'<span style="color:red;">(*)</span>':'')?>Número Cuenta o Tarjeta</label>
											<input id="alum_resp_form_banc_tarj_nume" class="form-control input-sm <?=(para_sist(404)=='1'?'required':'')?>" name="alum_resp_form_banc_tarj_nume" type="text" placeholder="Ingrese numero de Cuenta o Tarjeta..." value="<?=$alum_resp_form_banc_tarj_nume;?>">
										</div>
										
										<div class="form_element">
											<label for="lbl_tipo">Tipo de Cuenta:<br/><br/>
												<input id="cta_corriente" type="radio" name="tipo_cuenta" value="CORRIENTE" <?=($alum_view['alum_resp_form_banc_tipo']=="C"?"checked":"")?> />CUENTA CORRIENTE
												<input id="cta_ahorro" type="radio" name="tipo_cuenta" value="AHORROS" <?=($alum_view['alum_resp_form_banc_tipo']=="A"?"checked":"")?> />CUENTA DE AHORROS
											</label>
										</div>
										<div class="form_element">
											<label for="alum_resp_form_cedu">Número de Idetificación del Propietario de la  Cuenta:</label>
											<input id="alum_resp_form_cedu" name="alum_resp_form_cedu" type="text" class="form-control input-sm" placeholder="Ingrese cédula..." value="<?=$alum_view['alum_resp_form_cedu'];?>">
										</div>
										<div class="form_element">
											<label for="alum_resp_form_tipo_iden">Tipo de Identificación del Propietario de la Cuenta:</label>
											<?php 
												include ('../framework/dbconf.php');        
												$sql="select tipo_iden_codi, tipo_iden_deta from Tipo_Identificacion where tipo_iden_estado='A' and tipo_iden_show_acad ='Y'";
												$stmt = sqlsrv_query($conn, $sql);
										
												if( $stmt === false )
												{
													echo "Error in executing statement .\n";
													die( print_r( sqlsrv_errors(), true));
												}
												echo "<select class='form-control input-sm' id='alum_resp_form_tipo_iden' name='alum_resp_form_tipo_iden' >";
												while($tipo_iden_result= sqlsrv_fetch_array($stmt))
												{
													$seleccionado="";
													if ($tipo_iden_result["tipo_iden_codi"]==$alum_view['alum_resp_form_tipo_iden'])
																$seleccionado="selected";
													echo '<option value="'.$tipo_iden_result["tipo_iden_codi"].'" '.$seleccionado.'>'.$tipo_iden_result["tipo_iden_deta"].'</option>';
												}
												echo '</select>';
											?> 
										</div>
										<div class="form_element">
											<label for="alum_resp_form_nomb">Nombres del Propietario de la  Cuenta:</label>
											<input id="alum_resp_form_nomb" name="alum_resp_form_nomb" type="text" class="form-control input-sm" placeholder="Ingrese nombres y apellidos ..." value="<?=$alum_view['alum_resp_form_nomb'];?>">
										</div>
										<br/>
										</div>
										<!--
										<div id="opcion100"  <?php if (permiso_activo(100)) echo 'style="display:block; padding-bottom: 0;"'; else  echo 'style="display:none;"';?>  >
										<div class="form_element">
											<label for="alum_desc_tipo">Tipo de Descuento:</label>
											<?php 
												include ('../framework/dbconf.php');		
												$para="";
												$paramsd = array($para);
												$sqld="{call str_consultaDescuento_busq(?)}";
												$stmtd = sqlsrv_query($conn, $sqld, $paramsd);
										
												if( $stmtd === false )
												{
													echo "Error in executing statement .\n";
													die( print_r( sqlsrv_errors(), true));
												} 
																
												echo '<select class="form-control input-sm" id="alum_desc_tipo" name="alum_desc_tipo" onChange="carga_dscto(this.value,'."'".$_GET['alum_codi']."'".')">';
												echo '<option value="0">SELECCIONE</option>';
												while($dsct_view= sqlsrv_fetch_array($stmtd))
												{
													if($dsct_view["desc_codigo"]==$alum_view['alum_desc_tipo']){
														$select='selected="selected"';
													}else{
														$select="";
													}
													echo '<option value="'.$dsct_view["desc_codigo"].'"'.$select.">".$dsct_view["desc_descripcion"].'</option>';
												}
												echo '</select>';
												//agregar tabla descuento y descuento_alumnos
												//agregar sps str_consultaDescuento_busq
												//modificar sp alum_info, alum_upd, alum_add
												//agregar en la tabla descuentos los descuentos
												//alumnos_add_script.php; script_alum.php; main_valid.php	
											?> 
										</div>
										
										<div class="form_element">
											<label for="alum_desc_porcentaje">Porcentaje de Descuento:</label>
											<input id="alum_desc_porcentaje" name="alum_desc_porcentaje" type="text" class="form-control input-sm" placeholder="0.00" value="<?php if($alum_view['alum_desc_porcentaje']==NULL){echo "0.00";}else{echo $alum_view['alum_desc_porcentaje'];}?>" onkeypress="return validaNumeros(event, this);">
										</div>
										<br/>
										</div>-->
										<div id="opcion101"  <?php if (permiso_activo(101)) echo 'style="display:block; padding-bottom: 0;"'; else  echo 'style="display:none;"';?>  >
										
										<div class="form_element">
										</div>
										<div class="form_element">
											<label for="alum_ingreso_familiar">Ingreso económico familiar:</label>
											<input class="form-control" id="alum_ingreso_familiar" name="alum_ingreso_familiar" type="text" class="form-control input-sm" placeholder="0.00"
												value="<?=( $alum_view['alum_ingreso_familiar'] == NULL ? '0.00' : (string)$alum_view['alum_ingreso_familiar'] );?>">
										</div>
										<div class="form_element">
											<label for="alum_grup_econ"><span style="color:red;">(*)</span>Grupo económico:</label>
											<?php 
												include ('../framework/dbconf.php');        
												$params = array();
												$sql="{call grup_econ_view()}";
												$stmt = sqlsrv_query($conn, $sql, $params);
										
												if( $stmt === false )
												{
													echo "Error in executing statement .\n";
													die( print_r( sqlsrv_errors(), true));
												} 
																
												echo '<select class="form-control input-sm" id="sl_alum_grup_econ" name="sl_alum_grup_econ" 
													'.(para_sist(511) == 'S' ? 'title="La selección de grupo económico está bloqueada porque han activado la opción de '.
														'\'Asignar el grupo económico automáticamente, dependiendo del ingreso familiar\'. Esta opción se asignará automáticamente después de guardar, dependiendo del ingreso familiar registrado en esta ventana, en la sección de Datos personales." disabled="disabled" style="background-color:#d1d1d1;"' : '').' >';
												while($grup_econ_view= sqlsrv_fetch_array($stmt))
												{
													if($grup_econ_view["codigo"]==$alum_view['grupEcon_codigo']){
														$select='selected="selected"';
													}else{
														$select="";
													}
													echo '<option value="'.$grup_econ_view["codigo"].'"'.$select.">".$grup_econ_view["descripcion"].'</option>';
												}
												echo '</select>';
											?> 
										</div>
										<div class="form_element">
											<label for="div_veri_alum">&nbsp;</label>
											<div id="div_veri_alum" style="float:none;">&nbsp;</div>
										</div>
										</div>
										</div>
										<div class="tab-pane" id="tab4" name="tab4">
											<div class="form_element">
												<label for="alum_pers_emerg"><span style="color:red;">(*)</span>Nombre de persona:</label>
												<input id="alum_pers_emerg" name="alum_pers_emerg" type="text" class="form-control input-sm" placeholder="Ingrese el nombre del contacto de emergencia..." value="<?=$alum_view['alum_pers_emerg'];?>">
											</div>
											<div class="form_element">
												<label for="alum_emer_parentesco"><span style="color:red;">(*)</span>Parentesco de contacto de emergencia:</label>
												<?php 
													include ('../framework/dbconf.php');		
													$params = array(2);
													$sql="{call cata_hijo_view(?)}";
													$stmt = sqlsrv_query($conn, $sql, $params);
											
													if( $stmt === false )
													{
														echo "Error in executing statement .\n";
														die( print_r( sqlsrv_errors(), true));
													}
													echo '<select class="form-control input-sm" id="alum_parentesco_emerg" name="alum_parentesco_emerg">';
													while($alum_vive_con_view= sqlsrv_fetch_array($stmt))
													{
														$seleccionado="";
														if ($alum_vive_con_view["codigo"]==$alum_view["alum_parentesco_emerg"])
															$seleccionado="selected";
														echo '<option value="'.$alum_vive_con_view["codigo"].'" '.$seleccionado.'>'.$alum_vive_con_view["descripcion"].'</option>';
													}
													echo '</select>';
												?> 
											</div>
											<div class="form_element">
												<label for="alum_telf_emerg"><span style="color:red;">(*)</span>Tel&eacute;fono de emergencia:</label>
												<input id="alum_telf_emerg" name="alum_telf_emerg" type="text" class="form-control input-sm" placeholder="Ingrese el tel&eacute;fono de emergencia del alumno..." value="<?=$alum_view['alum_telf_emerg'];?>">
											</div>
										</div>
										<?php if (para_sist(408)=='1')
										{?>
										
										<div class="tab-pane" id="tab5" name="tab5">
											<div class="form_element">
												<label for="alum_hijo_ex_cadete">Es hijo de ex-cadete:</label>
												<input id="alum_hijo_ex_cadete" name="alum_hijo_ex_cadete" type="checkbox"
													<?= ($alum_view['alum_hijo_ex_cadete']==1 ? 'checked':'');?> />
											</div>
											<div class="form_element">
												<label for="alum_hno_ex_cadete">Es hermano de ex-cadete:</label>
												<input id="alum_hno_ex_cadete" name="alum_hno_ex_cadete" type="checkbox"
													<?= ($alum_view['alum_hno_ex_cadete']==1 ? 'checked':'');?> />
											</div>
										</div>
										<?php
										}
										?>
								</div>
							</div>
						</div>
						<!-- /.box-body -->
					</div>
				</div>
			</div>
		</form>
	</div>
</div>

<script>
	$( document ).ready(function() {
		if(document.getElementById('hd_edit_finan').value == 'no' )
		{	
			$("#tab3 :input").attr("disabled", true);
		}
		if(document.getElementById('hd_edit_acad').value == 'no' )
		{
			$("#tab1 :input").attr("disabled", true);
			$("#tab2 :input").attr("disabled", true);
			$("#tab4 :input").attr("disabled", true);
			if( $("#tab5") )
				$("#tab5 :input").attr("disabled", true);
		}
	});
	function CargarBancosTarjetas (codigo)
	{	var xmlhttp;
		if (window.XMLHttpRequest)
		{	xmlhttp = new XMLHttpRequest ();
		}
		else
		{	xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');
		}
		xmlhttp.onreadystatechange = function ()
		{	if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{	document.getElementById('lbl_banco_tarjeta').innerHTML=xmlhttp.responseText;
			}
		}
		xmlhttp.open("GET", "select_banco_tarjeta.php?idpadre="+codigo, true);
		xmlhttp.send();
	}
</script>

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
				<div id="div_documentos">
					<div class="form_element" style='font-size:small;'>
						<table width="100%" cellspacing="0" cellpadding="0" border="0">
							<tr>
								<td style="padding-top: 15px">
									<a onclick="window.open('reportes_generales/contrato_<?= $_SESSION['directorio'] ?>_pdf.php?alum_curs_para_codi='+document.getElementById('alum_curs_para_codi').value,'_blank')">
										<span class='fa fa-download'></span> Descargar
									</a>
								</td>
								<td width="85%" style="padding-top: 15px">
									Convenio de matrícula <b>(El alumno debe estar registrado en un curso)</b>
									<input type="hidden" id="alum_curs_para_codi" value="" />
								</td>
							</tr>
							<tr>
								<td style="padding-top: 15px">
									<a onclick="window.open('reportes_generales/pagare_<?= $_SESSION['directorio'] ?>_pdf.php?alum_curs_para_codi='+document.getElementById('alum_curs_para_codi').value,'_blank')"><span class='fa fa-download'></span> Descargar</a>
								</td>
								<td width="85%" style="padding-top: 15px">
									Pagaré <b>(El alumno debe estar registrado en un curso)</b>
								</td>
							</tr>
							<tr>
								<td style="padding-top: 15px">
									<a onclick="window.open('reportes_generales/soli_matr_<?= $_SESSION['directorio'] ?>_pdf.php?alum_codi='+document.getElementById('alum_codi').value+'&peri_codi=<?=$_SESSION["peri_codi"]?>','_blank')"><span class='fa fa-download'></span> Descargar</a>
								</td>
								<td width="85%" style="padding-top: 15px">
									Solicitud de matrícula <b>(El alumno debe estar registrado en un curso)</b>
									<input type="hidden" id="alum_codi" value="" />
								</td>
							</tr>
							<tr>
								<td style="padding-top: 15px">
									<a onclick="window.open('reportes_generales/ficha_estudiantil_pdf.php?alum_codi='+document.getElementById('alum_codi').value,'_blank')"><span class='fa fa-download'></span> Descargar</a>
								</td>
								<td width="85%" style="padding-top: 15px">
									Ficha de datos <b>(El alumno debe estar registrado en un curso)</b>
								</td>
							</tr>
							<tr>
								<td style="padding-top: 15px">
									<?php 
										if($_SESSION['directorio']=='liceopanamericano' or $_SESSION['directorio']=='liceopanamericanosur'){

									?>
									<a onclick="window.open('reportes_generales/ficha_matricula_<?= $_SESSION['directorio'] ?>_pdf.php?alum_curs_para_codi='+document.getElementById('alum_curs_para_codi').value,'_blank')"><span class='fa fa-download'></span> Descargar</a>
									<?php 
									}else{
									?>
									<a onclick="window.open('reportes_generales/ficha_matricula_pdf.php?alum_curs_para_codi='+document.getElementById('alum_curs_para_codi').value,'_blank')"><span class='fa fa-download'></span> Descargar</a>
									<?php
										}
									?>
								</td>
								<td width="85%" style="padding-top: 15px">
									Ficha de matrícula <b>(El alumno debe estar registrado en un curso)</b>
								</td>
							</tr>
							<tr>
								<td style="padding-top: 15px">
									<a onclick="window.open('reportes_generales/carta_compromiso_pdf.php?alum_curs_para_codi='+document.getElementById('alum_curs_para_codi').value,'_blank')"><span class='fa fa-download'></span> Descargar</a>
								</td>
								<td width="85%" style="padding-top: 15px">
									Carta de compromiso <b>(El alumno debe estar registrado en un curso)</b>
								</td>
							</tr>
							<tr>
								<td style="padding-top: 15px">
									<a onclick="window.open('reportes_generales/autorizacion_fotos_pdf.php?alum_curs_para_codi='+document.getElementById('alum_curs_para_codi').value,'_blank')"><span class='fa fa-download'></span> Descargar</a>
								</td>
								<td width="85%" style="padding-top: 15px">
									Autorización de fotos <b>(El alumno debe estar registrado en un curso)</b>
								</td>
							</tr>
							<tr>
								<td style="padding-top: 15px">
									<a onclick="window.open('reportes_generales/debito_pdf.php?alum_curs_para_codi='+document.getElementById('alum_curs_para_codi').value,'_blank')"><span class='fa fa-download'></span> Descargar</a>
								</td>
								<td width="85%" style="padding-top: 15px">
									Autorización de débito <b>(El alumno debe estar registrado en un curso)</b>
								</td>
							</tr>
							<tr>
								<td style="padding-top: 15px">
									<a onclick="window.open('reportes_generales/compromiso_rendimiento_pdf.php?alum_curs_para_codi='+document.getElementById('alum_curs_para_codi').value,'_blank')">
										<span class='fa fa-download'></span> Descargar
									</a>
								</td>
								<td width="85%" style="padding-top: 15px">
									Compromiso de rendimiento académico <b>(El alumno debe estar registrado en un curso)</b>
									<input type="hidden" id="alum_curs_para_codi" value="" />
								</td>
							</tr>
							<tr>
								<td style="padding-top: 15px">
									<a onclick="window.open('reportes_generales/compromiso_comportamiento_pdf.php?alum_curs_para_codi='+document.getElementById('alum_curs_para_codi').value,'_blank')">
										<span class='fa fa-download'></span> Descargar
									</a>
								</td>
								<td width="85%" style="padding-top: 15px">
									Compromiso de comportamiento <b>(El alumno debe estar registrado en un curso)</b>
									<input type="hidden" id="alum_curs_para_codi" value="" />
								</td>
							</tr>
						</table>
					</div>
					<div class="form_element">&nbsp;</div>
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