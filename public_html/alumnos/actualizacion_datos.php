<!DOCTYPE html>
<html lang="es">
	<?php  $ActualizacionDatos=1;    ?>
    <?php include("template/head.php");?>
    <body class="hold-transition skin-blue sidebar-mini">
		<div class="wrapper">
			<?php include ('template/header.php');?>
			<?php $active="cons_estudiantes";include("template/menu.php");?>
			<div class="content-wrapper">
				<section class="content-header">
					<h1>Actualización de datos
						<small>Datos personales y ficha médica</small>
					</h1>
					<ol class="breadcrumb">
						<li><button class="btn btn-xs btn-primary" data-target="#myModal" data-toggle="modal"><i class='fa fa-list'></i> Instrucciones</button></li>
					</ol>
				</section>
				<section class="content" id="mainPanel">
					<div id="information">
						<?php 
							/*Actualización de datos*/
							if (isset($_POST['opc']))
							{	$alum_fech_naci = substr($_POST['alum_fech_naci'],6,4)."".substr($_POST['alum_fech_naci'],3,2)."".substr($_POST['alum_fech_naci'],0,2);
								$alum_genero = ($_POST['genero']=='Hombre'?1:0);
								$sql	= "{call actualiza_estudiante(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
								$params	= array($_SESSION['alum_codi'],
												$_POST['alum_nomb'],
												$_POST['alum_apel'],
												$alum_fech_naci,
												$genero,
												$_POST['alum_cedu'],
												$_POST['alum_tipo_iden'],
												$_POST['alum_mail'],
												$_POST['alum_celu'],
												$_POST['alum_domi'],
												$_POST['alum_telf'],
												$_POST['alum_ciud'],
												$_POST['alum_parroq'],
												$_POST['alum_pais'],
												$_POST['alum_nacionalidad'],
												$_POST['alum_religion'],
												$_POST['alum_vive_con'],
												$_POST['alum_parentesco_vive_con'],
												$_POST['alum_estado_civil_padres'],
												$_POST['alum_movilizacion'],
												$_POST['alum_activ_deportiva'],
												$_POST['alum_activ_artistica'],
												$_POST['alum_enfermedades'],
												$_POST['alum_telf_emerg'],
												$_POST['alum_parentesco_emerg'],
												$_POST['alum_pers_emerg'],
												$_POST['alum_tipo_sangre']);
								$stmt_al	= sqlsrv_query($conn,$sql,$params);
								if ($stmt_al===false)
								{	echo "<script>";
									echo "$.growl.error({title: 'Educalinks informa',message: 'No se pueden actualizar los datos.' });";
									echo "</script>";
								}
								else
								{	echo "<script>";
									echo "$.growl.notice({title: 'Educalinks informa',message: '¡Los datos del alumno fueron actualizados!' });";
									echo "</script>";
								}
								$es_colaborador = ($_POST['repr_escolaborador']=='on' ? 1 : 0 );
								$repr_ex_alum = ($_POST['repr_ex_alum']=='on' ? 1 : 0 );
								$sql	= "{call actualiza_representante(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
								$params	= array( $_POST['repr_nomb'],
												$_POST['repr_apel'],
												$_SESSION['repr_cedula'],
												$_POST['repr_email'],
												$_POST['repr_telf'],
												$_POST['repr_domi'],
												$_POST['repr_estado_civil'],
												$_POST['repr_celular'],
												$_SESSION['repr_codi'],
												$_POST['repr_profesion'],
												$_POST['repr_nacionalidad'],
												$_POST['repr_lugar_trabajo'],
												$_POST['repr_direc_trabajo'],
												$_POST['repr_cargo'],
												$_POST['repr_religion'],
												$_POST['repr_estudios'],
												$_POST['repr_institucion'],
												$_POST['repr_motivo_representa'],
												$es_colaborador,
												$_POST['repr_telf_trab'],
												$_POST['repr_fech_promoc'],
												$repr_ex_alum);
								$stmt_rep	= sqlsrv_query($conn,$sql,$params);
								if ($stmt_rep===false)
								{	echo "<script>";
									echo "$.growl.error({title: 'Educalinks informa',message: 'No se pueden actualizar los datos.' });";
									echo "</script>";
									die( print_r( sqlsrv_errors(), true));
								}
								else
								{	echo "<script>";
									echo "$.growl.notice({title: 'Educalinks informa',message: '¡Los datos del representante fueron actualizados!' });";
									echo "</script>";
								}
								if ($stmt_al===false or $stmt_rep===false)
									$_SESSION['ISBIEN_ALUM'] = 'INNOT';
								else
									$_SESSION['ISBIEN_ALUM'] = 'YESIN';
							}
							session_activa(3);
							/*Fin de actualización de datos*/
							$params = array($_SESSION['curs_para_codi']);
							$sql="{call curs_para_info(?)}";
							$curs_para_info = sqlsrv_query($conn, $sql, $params);  
							$row_curs_para_info = sqlsrv_fetch_array($curs_para_info);
							
							$params = array($_SESSION['alum_codi']);
							$sql="{call alum_info(?)}";
							$stmt = sqlsrv_query($conn, $sql, $params);
							if( $stmt === false ){
								echo "Error in executing statement .\n";die( print_r( sqlsrv_errors(), true));
							} 
							$alum_view= sqlsrv_fetch_array($stmt);
							
							$sql_opc = "{call repr_info_cedu(?)}";
							$params_opc= array($_SESSION['repr_cedula']);
							$stmt_opc = sqlsrv_query( $conn, $sql_opc,$params_opc);
							if( $stmt_opc === false ){echo "Error in executing statement .\n";die( print_r( sqlsrv_errors(), true));} 
							$row_repr_view=sqlsrv_fetch_array($stmt_opc);
						?>
						
						
						<div class="panel panel-default">
						  	<div class="panel-heading"></div>
						  	<div class="panel-body">
						    	<script src="js/actualizacion_datos.js"> </script>
								<form method="POST" onsubmit="return ValidarDatos('<?= $_SESSION['directorio']; ?>');">
									<input type="hidden" id="opc" name="opc" value="ActualizarDatos" />
									<input type="hidden" id="hd_alum_codi" name="hd_alum_codi" value="<?= $_SESSION['alum_codi']; ?>" />
									<div class="zones">
										<div class="nav-tabs-custom">  
											<ul class="nav nav-tabs">    
											  <li class="active"><a href="#tab4" data-toggle="tab" onClick=""><span class="fa fa-pencil"></span> 1. Ficha médica</a></li>
											  <li><a href="#tab1" data-toggle="tab" onClick=""><span class=" fa-file-text-o fa"></span> 2. Datos del Alumno</a></li>
											  <li><a href="#tab2" data-toggle="tab" onClick=""><span class="fa-users fa"></span> 3. Datos del representante</a></li>
											  <li><a href="#tab3" data-toggle="tab" onClick=""><span class="fa-pencil fa"></span> 4. Opciones</a></li>
											</ul> 	
											<?php
												$ha_actualizado_medic = $alum_view['alum_upd_ficha_medica'];
											?>
											<input type="hidden" name="hd_ha_actualizado_medic" id="hd_ha_actualizado_medic" value="<?php echo $ha_actualizado_medic;?>"/>
										
											<div class="tab-content">
												<div class="tab-pane active" id="tab4">
													<div class="alumnos_add_script admin_pass">
															<?php 
																include ('../framework/dbconf.php');		
																$params = array( -1, $_SESSION['alum_codi'], 'UPD' );
																$sql="{call str_medic_ficha_medica_list_cons(?,?,?)}";
																$stmt = sqlsrv_query($conn, $sql, $params );
																
																$html_medic = "";
																
																if( $stmt === false )
																{
																	echo "Error in executing statement .\n";
																	die( print_r( sqlsrv_errors(), true));
																}
																$html_medic.= '
																<table class="table">';
																$exists_upd = 0; $ha_actualizado_medic_detail = "(Pendiente completar)";
																if ($ha_actualizado_medic == 1 )
																	$ha_actualizado_medic_detail = "(Completado) <span style='color:green;font-size:small;' class='icon-checkbox-checked'></span>";
																while($fichas_medicas_creadas = sqlsrv_fetch_array($stmt))
																{   $html_medic.=  '
																		<tr>
																			<td><button class="btn btn-block btn-success" type="button" 
																				onclick="js_actualizacion_datos_openfichamedica_editar('.$fichas_medicas_creadas["fmex_codi"].');">Editar ficha médica</button>
																			</td>
																			<td>Fecha de modificación: '.$fichas_medicas_creadas["fmex_fecha_ingr"].'. '.$ha_actualizado_medic_detail.'
																			</td>
																		</tr>';
																	$exists_upd++;
																}
																$html_medic.=  '</table>';
																if ( $exists_upd > 0 )
																{
																	echo $html_medic;
																}
																else
																	echo '
																		<div class="row">
																			<div class="col-md-4 col-md-offset-4">
																				<button type="button" class="btn btn-block btn-primary" onclick="js_actualizacion_datos_openfichamedica();" >Ingresar nueva ficha</button>
																			</div>
																		</div>';
															?>
													</div>
												</div>
												<div class="tab-pane" id="tab1">
													<div class="alumnos_add_script admin_pass">
														<div class="row">
															<div class="col-md-6">
																<div class="form-group">
																	<label for="alum_nomb">(*)Nombres:</label>
																	<input class="form-control" id="alum_nomb" name="alum_nomb" type="text" placeholder="Ingrese los nombres del alumno..." value="<?=$alum_view['alum_nomb'];?>"  onkeyup="new_username ();" readonly>
																</div>
															</div>
															<div class="col-md-6">
																<div class="form-group">
																	<label for="alum_apel">(*)Apellidos:</label>
																	<input class="form-control" id="alum_apel" class="form-control" name="alum_apel" type="text" placeholder="Ingrese los apellidos del alumno..." value="<?=$alum_view['alum_apel'];?>" onkeyup="new_username ();" readonly>
																</div>
															</div>
														</div>
														<div class="row">
															<div class="col-md-6">
																<div class="form-group">
																	<label for="alum_usua">Usuario Web:</label>
																	<input class="form-control" id="alum_usua" name="alum_usua" type="text" <?php if ($alum_view['alum_codi']!=""){?>disabled="disabled"<? }?> placeholder="Ingrese el usuario web para el alumno..." value="<?=$alum_view['alum_usua'];?>" onkeyup="verif_usua(this.value);" onClick="verif_usua(this.value);" >
																</div>
															</div>
															<div class="col-md-6">
																<div class="form-group">
																	<label for="alum_fech_naci">(*)Fecha de Nacimiento:</label>
																	<input class="form-control" id="alum_fech_naci" name="alum_fech_naci" type="text" placeholder="Ingrese la fecha de nacimiento del alumno..." value="<?=date_format($alum_view['alum_fech_naci'],"d/m/Y");?>">
																</div>
															</div>
														</div>
														<script type="text/javascript" charset="utf-8">
														$("#alum_fech_naci").datepicker();
														</script>
														<div class="row">
															<div class="col-md-12">
																<div class="form-group">
																	<label for="lbl_tipo">Género:<br/>
																		<label class="radio-inline">
																			<input id="alum_hombre" type="radio" name="genero" value="Hombre" <?= ($alum_view['alum_genero']==1?' checked':'') ?> />
																				<span style="margin-right: 50px">Masculino</span>
																			
																		</label>
																		<label class="radio-inline">
																			<input id="alum_mujer" type="radio" name="genero" value="Mujer" <?= ($alum_view['alum_genero']==0?' checked':'') ?> />
																				<span style="margin-right: 50px">Femenino</span>
																		</label>
																	</label>
																</div>
															</div>
														</div>
														<div class="row">
															<div class="col-md-6">
																<div class="form-group">
																	<label for="alum_cedu">(*)Cédula:</label>
																	<input class="form-control" id="alum_cedu" name="alum_cedu" type="text" placeholder="Ingrese la c&eacute;dula del alumno..." value="<?=$alum_view['alum_cedu'];?>" onkeyup="">
																</div>
															</div>
															<div class="col-md-6">
																<div class="form-group">
																	<label>(*)Tipo de Identificación:</label>
															        <?php 
															            include ('../framework/dbconf.php');        
															            $sql="select tipo_iden_codi, tipo_iden_deta from Tipo_Identificacion where tipo_iden_estado='A' and tipo_iden_show_acad ='Y' and tipo_iden_codi!=2";
															            $stmt = sqlsrv_query($conn, $sql);
															    
															            if( $stmt === false )
															            {
															                echo "Error in executing statement .\n";
															                die( print_r( sqlsrv_errors(), true));
															            }
															            echo "<select class='form-control' id='alum_tipo_iden' name='alum_tipo_iden' >";
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
															</div>
														</div>
														<div class="row">
															<div class="col-md-6">
																<div class="form-group">
																	<label for="alum_mail">Email:</label>
																	<input class="form-control" id="alum_mail" name="alum_mail" type="text" placeholder="Ingrese el email del alumno..." value="<?=$alum_view['alum_mail'];?>">
																</div>
															</div>
															<div class="col-md-6">
																<div class="form-group">
																	<label for="alum_celu">Celular:</label>
																	<input class="form-control" id="alum_celu" name="alum_celu" type="text" placeholder="Ingrese el celular del alumno..." value="<?=$alum_view['alum_celu'];?>">
																</div>
															</div>
														</div>
														<div class="row">
															<div class="col-md-6">
																<div class="form-group">
																	<label for="alum_domi">(*)Domicilio:</label>
																	<input class="form-control" id="alum_domi" name="alum_domi" type="text" placeholder="Ingrese el domicilio del alumno..." value="<?=$alum_view['alum_domi'];?>">
																</div>
															</div>
															<div class="col-md-6">
																<div class="form-group">
																	<label for="alum_telf">Tel&eacute;fono:</label>
																	<input class="form-control" id="alum_telf" name="alum_telf" type="text" placeholder="Ingrese el tel&eacute;fono del alumno..." value="<?=$alum_view['alum_telf'];?>">
																</div>
															</div>
														</div>
														<div class="row">
															<div class="col-md-6">
																<div class="form-group">
																	<label for="alum_ciud">(*)Ciudad:</label>
																	<input class="form-control" id="alum_ciud" name="alum_ciud" type="text" placeholder="Ingrese la ciudad del alumno..." value="<?=$alum_view['alum_ciud'];?>">
																</div>
															</div>
															<div class="col-md-6">
																<div class="form-group">
																	<label for="alum_parroq">(*)Parroquia:</label>
																	<input class="form-control" id="alum_parroq" name="alum_parroq" type="text" placeholder="Ingrese la parroquia del alumno..." value="<?=$alum_view['alum_parroquia'];?>">
																</div>
															</div>
														</div>
														<div class="row">
															<div class="col-md-6">
																<div class="form-group">
																	<label for="alum_pais">Pa&iacute;s donde naci&oacute;:</label>
																	<input class="form-control" id="alum_pais" name="alum_pais" type="text" placeholder="Ingrese el pa&iacute;s del alumno..." value="<?=$alum_view['alum_pais'];?>">
																</div>
															</div>
															<div class="col-md-6">
																<div class="form-group">
																	<label for="alum_nacionalidad">Nacionalidad</label>
																	<input class="form-control" id="alum_nacionalidad" name="alum_nacionalidad" type="text" placeholder="Ingrese la nacionalidad del alumno..." value="<?=$alum_view['alum_nacionalidad'];?>">
																</div>
															</div>
														</div>
														<div class="row">
															<div class="col-md-6">
																<div class="form-group">
																	<label>Religi&oacute;n:</label>
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
																		echo '<select class="form-control" id="alum_religion" name="alum_religion">';
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
															</div>
														</div>
														<div class="row">
															<div class="col-md-6">
																<div class="form-group">
																	<label for="alum_vive_con">Vive con:</label>
																	<input class="form-control" id="alum_vive_con" name="alum_vive_con" type="text" placeholder="Ingrese con quien vive el alumno..." value="<?=$alum_view['alum_vive_con'];?>">
																</div>
															</div>
															<div class="col-md-6">
																<div class="form-group">
																	<label>Parentesco:</label>
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
																		echo '<select class="form-control" id="alum_parentesco_vive_con" name="alum_parentesco_vive_con">';
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
															</div>
														</div>
														<div class="row">
															<div class="col-md-6">
																<div class="form-group">
																	<label>Estado civil de padres:</label>
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
																		echo '<select class="form-control" id="alum_estado_civil_padres" name="alum_estado_civil_padres">';
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
															</div>
															<div class="col-md-6">
																<div class="form-group">
																	<label for="alum_movilizacion">Movilización:</label>
																	<input class="form-control" id="alum_movilizacion" name="alum_movilizacion" type="text" placeholder="Ingrese como se moviliza el alumno..." value="<?=$alum_view['alum_movilizacion'];?>">
																</div>
															</div>
														</div>
														<div class="row">
															<div class="col-md-6">
																<div class="form-group">
																	<label>Disciplinas o deportes que practica:</label>
																	<textarea class="form-control" rows="3" id="alum_activ_deportiva" name="alum_activ_deportiva"><?=$alum_view['alum_activ_deportiva'];?></textarea>
																</div>
															</div>
															<div class="col-md-6">
																<div class="form-group">
																	<label>Actividades artísticas que practica:</label>
																	<textarea class="form-control" rows="3" id="alum_activ_artistica" name="alum_activ_artistica"><?=$alum_view['alum_activ_artistica'];?></textarea>
																</div>
															</div>
														</div>
														<div class="row">
															<div class="col-md-6">
																<div class="form-group">
																	<label>Enfermedades, alergias, medicinas, prohibiciones, inhabilidades o tratamiento médico especial:</label>
																	<textarea class="form-control" rows="3" id="alum_enfermedades" name="alum_enfermedades"><?=$alum_view['alum_enfermedades'];?></textarea>
																</div>
															</div>
															<div class="col-md-6">
																<div class="form-group">
																	<label>(*)Tipo de sangre:</label>
																	<select class="form-control" id="alum_tipo_sangre" name="alum_tipo_sangre">
																		<option value="" <?=($alum_view['alum_tipo_sangre']==""?"selected":"")?>>Elija</option>
																		<option value="PENDIENTE" <?=($alum_view['alum_tipo_sangre']=="PENDINTE"?"selected":"")?>>PENDIENTE</option>
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
															</div>
														</div>
														<div class="row">
															<div class="col-md-6">
																<div class="form-group">
																	<label for="alum_telf_emerg">Tel&eacute;fono de emergencia:</label>
																	<input class="form-control" id="alum_telf_emerg" name="alum_telf_emerg" type="text" placeholder="Ingrese el tel&eacute;fono de emergencia del alumno..." value="<?=$alum_view['alum_telf_emerg'];?>">
																</div>
															</div>
															<div class="col-md-6">
																<div class="form-group">
																	<label>Parentesco:</label>
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
																		echo '<select class="form-control" id="alum_parentesco_emerg" name="alum_parentesco_emerg">';
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
															</div>
														</div>
														<div class="row">
															<div class="col-md-6">
																<div class="form-group">
																	<label for="alum_pers_emerg">Nombre de persona:</label>
																	<input class="form-control" id="alum_pers_emerg" name="alum_pers_emerg" type="text" placeholder="Ingrese el nombre del contacto de emergencia..." value="<?=$alum_view['alum_pers_emerg'];?>">
																</div>
															</div>
														</div>
													</div>
												</div>
												<div class="tab-pane" id="tab2">
													<div class="alumnos_add_script admin_pass">
														<div class="row">
															<div class="col-md-6">
																<div class="form-group">
																	<label for="repr_nomb">(*)Nombres:</label>
																	<input class="form-control" id="repr_nomb" name="repr_nomb" type="text" placeholder="Ingresar nombres" value="<?=$row_repr_view['repr_nomb'];?>">
																</div>
															</div>
															<div class="col-md-6">
																<div class="form-group">
																	<label for="repr_apel">(*)Apellidos:</label>
																	<input class="form-control" id="repr_apel" name="repr_apel" type="text" placeholder="Ingresar apellidos" value="<?=$row_repr_view['repr_apel'];?>">
																</div>
															</div>
															<div class="col-md-6">
																<div class="form-group">
																	<label for="repr_email">(*)Correo:</label>
																	<input class="form-control" id="repr_email" name="repr_email" type="text" placeholder="Ingresar correo" value="<?=$row_repr_view['repr_email'];?>">
																</div>
															</div>
															<div class="col-md-6">
																<div class="form-group">
																	<label for="repr_telf">(*)Núm. Teléfono:</label>
																	<input class="form-control" id="repr_telf" name="repr_telf" type="text" placeholder="Ingresar número convencional" value="<?=$row_repr_view['repr_telf'];?>">
																</div>
															</div>
															<div class="col-md-6">
																<div class="form-group">
																	<label for="repr_celular">(*)Núm. Celular:</label>
																	<input class="form-control" id="repr_celular" name="repr_celular" type="text" placeholder="Ingresar número celular" value="<?=$row_repr_view['repr_celular'];?>">
																</div>
															</div>
															<div class="col-md-6">
																<div class="form-group">
																	<label for="repr_domi">Dirección:</label>
																	<input class="form-control" id="repr_domi" name="repr_domi" type="text" placeholder="Ingresar dirección" value="<?=$row_repr_view['repr_domi'];?>">
																</div>
															</div>
															<div class="col-md-6">
																<div class="form-group">
																	<label for="repr_profesion">Profesión:</label>
																	<input class="form-control" id="repr_profesion" name="repr_profesion" type="text" placeholder="Ingresar profesión" value="<?=$row_repr_view['repr_profesion'];?>">
																</div>
															</div>
															<div class="col-md-6">
																<div class="form-group">
																	<label for="repr_nacionalidad">Nacionalidad:</label>
																	<input class="form-control" id="repr_nacionalidad" name="repr_nacionalidad" type="text" placeholder="Ingresar nacionalidad" value="<?=$row_repr_view['repr_nacionalidad'];?>">
																</div>
															</div>
															<div class="col-md-6">
																<div class="form-group">
																	<label for="repr_lugar_trabajo">Lugar de trabajo:</label>
																	<input class="form-control" id="repr_lugar_trabajo" name="repr_lugar_trabajo" type="text" placeholder="Ingresar lugar de trabajo" value="<?=$row_repr_view['repr_lugar_trabajo'];?>">
																</div>
															</div>
															<div class="col-md-6">
																<div class="form-group">
																	<label for="repr_direc_trabajo">Dirección de trabajo:</label>
																	<input class="form-control" id="repr_direc_trabajo" name="repr_direc_trabajo" type="text" placeholder="Ingresar dirección de trabajo" value="<?=$row_repr_view['repr_direc_trabajo'];?>">
																</div>
															</div>
															<div class="col-md-6">
																<div class="form-group">
															    	<label for="repr_telf_trab">Teléfono de Trabajo:</label>
															    	<input id="repr_telf_trab" class="form-control" name="repr_telf_trab" type="text" placeholder="Teléfono de Trabajo:" value="<?=$row_repr_view['repr_telf_trab'];?>">
														    	</div>
														    </div>
															<div class="col-md-6">
																<div class="form-group">
																	<label for="repr_cargo">Cargo:</label>
																	<input class="form-control" id="repr_cargo" name="repr_cargo" type="text" placeholder="Ingresar cargo" value="<?=$row_repr_view['repr_cargo'];?>">
																</div>
															</div>
															<div class="col-md-6">
																<div class="form-group">
																	<label>Religión:</label>
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
																	echo '<select class="form-control" id="repr_religion" name="repr_religion">';
																	while($religion_view= sqlsrv_fetch_array($stmt))
																	{
																		$seleccionado="";
																		if ($religion_view["codigo"]==$row_repr_view["idreligion"])
																			$seleccionado="selected";
																		echo '<option value="'.$religion_view["codigo"].'" '.$seleccionado.'>'.$religion_view["descripcion"].'</option>';
																	}
																	echo '</select>';
																	?>
																</div>
															</div>
															<div class="col-md-6">
																<div class="form-group">
																	<label for="repr_estudios">Nivel de estudios:</label>
																	<input class="form-control" id="repr_estudios" name="repr_estudios" type="text" placeholder="Ingresar nivel de estudios" value="<?=$row_repr_view['repr_estudios'];?>">
																</div>
															</div>
															<div class="col-md-6">
																<div class="form-group">
																	<label for="repr_institucion">Institución:</label>
																	<input class="form-control" id="repr_institucion" name="repr_institucion" type="text" placeholder="Ingresar institución" value="<?=$row_repr_view['repr_institucion'];?>">
																</div>
															</div>
															<div class="col-md-6">
																<div class="form-group">
																	<label for="repr_motivo_representa">Razón por la cual representa (en caso de no ser padre o madre):</label>
																	<input class="form-control" id="repr_motivo_representa" name="repr_motivo_representa" type="text" placeholder="Ingresar razón de representar" value="<?=$row_repr_view['repr_motivo_representa'];?>">
																</div>
															</div>
															<div class="col-md-6">
																<div class="form-group">
																	<label>Estado civil:</label>
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
																	echo '<select class="form-control" id="repr_estado_civil" name="repr_estado_civil">';
																	while($esta_civil_padr_view= sqlsrv_fetch_array($stmt))
																	{
																		$seleccionado="";
																		if ($esta_civil_padr_view["codigo"]==$row_repr_view["idestadocivil"])
																			$seleccionado="selected";
																		echo '<option value="'.$esta_civil_padr_view["codigo"].'" '.$seleccionado.'>'.$esta_civil_padr_view["descripcion"].'</option>';
																	}
																	echo '</select>';
																	?> 
																</div>
															</div>
															<div class="col-md-6">
																<div class="form-group">
																		</br>
																		<label for="repr_escolaborador">¿Es o fue colaborador de la institución?</label></br>
    																	<input id="repr_escolaborador" name="repr_escolaborador" type="checkbox" <?= ($row_repr_view['repr_escolaborador']==1 ? 'checked':'');?>/>
																</div>
															</div>
															<div class="col-md-6">
																<div class="form-group">
															    	<label for="repr_fech_promoc">Año de promoción exalumno:</label>
															    	<input id="repr_fech_promoc" class="form-control" name="repr_fech_promoc" type="text" placeholder="Ingrese la fecha de promoción de exalumno" value="<?=date_format($row_repr_view['repr_fech_promoc'],"d/m/Y");?>"/>
														    	</div>
													    	</div>
													    	<div class="col-md-6">
														    	<div class="form-group">
														    		</br>
															    	<label for="repr_ex_alum">¿Es exalumno de la institución?</label>
															    	</br>
															    	<input id="repr_ex_alum" name="repr_ex_alum" type="checkbox" <?= ($row_repr_view['repr_ex_alum']==1 ? 'checked':'');?>/>
															    	
														    	</div>
														    </div>
														</div>
													</div>
												</div>
												<div class="tab-pane" id="tab3">
													<div class="row">
														<div class="col-md-12">
															<div class="checkbox" style='font-size:large;'>
																<label><input id="aceptar_terminos" name="aceptar_terminos" type="checkbox" /></label>&nbsp;Confirmo que la información proporcionada es completa, correcta y que ha sido revisada con exactitud en:<br>
																	<ul>
																		<li>Datos de Alumno</li>
																		<li>Datos de Representante</li>
																		<li>Ficha Medica</li>
																	</ul>
															</div>
														</div>
													</div>
													<div class="row">
														<div class="col-md-offset-4">
															<div class="alumnos_add_script admin_pass">
																<div class="form-group">
																	<input class="btn btn-primary" style="width:40%;" type="submit" value="Actualizar Datos" />
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</form>
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
		<script src="../js/med_fichas.js"></script>
		<script type="text/javascript">  
			$(document).ready(function(){  
				$("#repr_fech_promoc").datepicker();
			});
		</script>
	</body>
</html>
<!-- Modal para instrucciones-->
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Instrucciones</h4>
			</div>
			<div class="modal-body">
				<img width='100%' src="../imagenes/instrucciones_act_datos.jpg" />
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Ocultar</button>
			</div>
		</div>
	</div>
</div>		
<script type="text/javascript">
$(window).load(function(){
$('#myModal').modal('show');
});
</script>