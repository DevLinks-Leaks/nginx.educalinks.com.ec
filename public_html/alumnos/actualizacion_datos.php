<!DOCTYPE html>
<html lang="es">
    <?php include("template/head.php");?>
    <body class="hold-transition skin-blue sidebar-mini">
		<div class="wrapper">
			<?php include ('template/header.php');?>
			<?php $active="cons_estudiantes";include("template/menu.php");?>
			<div class="content-wrapper">
				<section class="content-header">
					<h1>Actualización de Datos
						<small>Datos del estudiante</small>
					</h1>
					<ol class="breadcrumb">
						 <li><button class="btn btn-xs btn-primary" data-target="#myModal" data-toggle="modal"><i class='fa fa-list'></i> Instrucciones</button></li>
					</ol>
				</section>
				<section class="content" id="mainPanel">
					<div id="information">
						<?php
                            include ('../framework/funciones.php');
							// session_activa(3);
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
						    	<script src="js/actualizacion_datos.js?<?=$rand;?>"> </script>
						    	<script src="js/preinscripcion.js?<?=$rand;?>"> </script>
									<input type="hidden" id="opc" name="opc" value="ActualizarDatos" />
									<input type="hidden" id="hd_alum_codi" name="hd_alum_codi" value="<?= $_SESSION['alum_codi']; ?>" />
									<div class="zones">
										<div class="nav-tabs-custom">  
											<ul id="tabs" class="nav nav-tabs">
                                                <?if( $_SESSION['certus_medic'] == '1' ){?><li class="active"><a href="#tab4" data-toggle="tab" onClick=""><span class="fa fa-medkit"></span> Ficha médica</a></li><?}?>
												 <li class="<?=( $_SESSION['certus_medic'] == '1' ? '' : 'active'  )?>"><a href="#tab1" data-toggle="tab" onClick=""><span class=" fa-file-text-o fa"></span> Datos del Alumno</a></li>
												 <li><a href="#tab2" data-toggle="tab" onClick=""><span class="fa-users fa"></span> Datos del representante</a></li>
												 <li><a href="#tab3" data-toggle="tab" onClick=""><span class="fa-save fa"></span> Confirmación</a></li>
											</ul>
											<?php
												 if($_SESSION['certus_medic']=='1')
												 	$ha_actualizado_medic = $alum_view['alum_upd_ficha_medica'];
												 else
													$ha_actualizado_medic = 1;
											?>
											<input type="hidden" name="hd_ha_actualizado_medic" id="hd_ha_actualizado_medic" value="<?php echo $ha_actualizado_medic;?>"/>
										
											<div class="tab-content">
												<div class="tab-pane <?=( $_SESSION['certus_medic'] == '1' ? 'active' : ''  )?>" id="tab4">
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
												<div class="tab-pane  <?=( $_SESSION['certus_medic'] == '1' ? '' : 'active'  )?>" id="tab1">
													<div class="row">
														<div class="col-md-12"><h5 class="page-header">Datos Principales</h5></div>
														<div class="col-md-6">
															<div class="form-group">
																<label for="alum_nomb">Nombres<span style="color:red;">*</span>:</label>
																<input class="form-control" id="alum_nomb" name="alum_nomb" type="text" placeholder="Ingrese los nombres del alumno..." value="<?=$alum_view['alum_nomb'];?>"  onkeyup="new_username ();" readonly>
															</div>
														</div>
														<div class="col-md-6">
															<div class="form-group">
																<label for="alum_apel">Apellidos<span style="color:red;">*</span>:</label>
																<input class="form-control" id="alum_apel" class="form-control" name="alum_apel" type="text" placeholder="Ingrese los apellidos del alumno..." value="<?=$alum_view['alum_apel'];?>" onkeyup="new_username ();" readonly>
															</div>
														</div>
														<div class="col-md-6">
															<div class="form-group">
																<label for="alum_usua">Usuario Web:</label>
																<input class="form-control" id="alum_usua" name="alum_usua" type="text" <?php if ($alum_view['alum_codi']!=""){?>disabled="disabled"<? }?> placeholder="Ingrese el usuario web para el alumno..." value="<?=$alum_view['alum_usua'];?>" onkeyup="verif_usua(this.value);" onClick="verif_usua(this.value);" >
															</div>
														</div>
														<div class="col-md-6">
															<div class="form-group">
																<label for="lbl_tipo">Género:</label><br/><br/>
																	<label>
																		<input disabled id="alum_hombre" class="alum_genero" type="radio" name="genero" value="Hombre" <?= ($alum_view['alum_genero']==1?' checked':'') ?> /> Masculino  </label>
																	<label>					
																		<input disabled id="alum_mujer" class="alum_genero" type="radio" name="genero" value="Mujer" <?= ($alum_view['alum_genero']==0?' checked':'') ?> /> Femenino </label>
																
															</div>
														</div>
														<div class="col-md-6">
															<div class="form-group">
																<label for="alum_cedu">Número de Identificación<?=(para_sist(405)=='1'?'<span style="color:red;">*</span>':'')?>:</label>
																<input class="form-control <?=(para_sist(404)=='1'?'required':'')?>" id="alum_cedu" name="alum_cedu" type="text" placeholder="Ingrese la c&eacute;dula del alumno..." value="<?=$alum_view['alum_cedu'];?>" onkeyup="" disabled>
															</div>
														</div>
														<div class="col-md-6">
															<div class="form-group">
																<label>Tipo de Identificación<span style="color:red;">*</span>:</label>
														        <?php 
														            include ('../framework/dbconf.php');        
														            $sql="select tipo_iden_codi, tipo_iden_deta from Tipo_Identificacion where tipo_iden_estado='A' and tipo_iden_show_acad ='Y' and tipo_iden_codi!=2";
														            $stmt = sqlsrv_query($conn, $sql);
														    
														            if( $stmt === false )
														            {
														                echo "Error in executing statement .\n";
														                die( print_r( sqlsrv_errors(), true));
														            }
														            echo "<select class='form-control' id='alum_tipo_iden' name='alum_tipo_iden' disabled>";
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
														<div class="col-md-6">
															<div class="form-group">
																<label for="alum_fech_naci">Fecha de Nacimiento<span style="color:red;">*</span>:</label>
																<input class="form-control" id="alum_fech_naci" name="alum_fech_naci" type="text" placeholder="Ingrese la fecha de nacimiento del alumno..." value="<?=date_format($alum_view['alum_fech_naci'],"d/m/Y");?>" disabled>
															</div>
														</div>
                                                        <div class="form-group col-md-6">
                                                            <label for="alum_pais">País de nacimiento:</label>
                                                            <select class='form-control' onchange="CargarProvincias('alum_prov_naci',this.value);CargarCiudades('alum_ciud_naci',this.value);CargarParroquias('alum_parr_naci',this.value);" id="alum_pais" name="alum_pais">
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
                                                        <div class="form-group col-md-6">
                                                            <label for="alum_prov_naci">Provincia de nacimiento:</label>
                                                            <select class='form-control' onchange="CargarCiudades('alum_ciud_naci',this.value);CargarParroquias('alum_parr_naci',this.value);" id='alum_prov_naci' name='alum_prov_naci'>
                                                                <?php

                                                                $params = array(null,($alum_view["alum_pais"]==''?'Ecuador':$alum_view["alum_pais"]));
                                                                $sql="{call cata_provincia_cons(?,?)}";
                                                                $stmt = sqlsrv_query($conn, $sql, $params);
                                                                echo '<option value="">Seleccione</option>';
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
                                                        <div class="form-group col-md-6">
                                                            <label for="alum_ciud_naci">Ciudad de nacimiento:</label>
                                                            <select class='form-control' onchange="CargarParroquias('alum_parr_naci',this.value);" id='alum_ciud_naci' name='alum_ciud_naci'>
                                                                <?php
                                                                $params = array(null,$alum_view["alum_prov_naci"]);
                                                                $sql="{call cata_ciudad_cons(?,?)}";
                                                                $stmt = sqlsrv_query($conn, $sql, $params);
                                                                echo '<option value="">Seleccione</option>';
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
                                                        <div class="form-group col-md-6">
                                                            <label for="alum_parr_naci">Parroquia de nacimiento:</label>
                                                            <select class='form-control' id="alum_parr_naci" name="alum_parr_naci">
                                                                <?php
                                                                $params = array(null,$alum_view["alum_ciud_naci"]);
                                                                $sql="{call cata_parroquia_cons(?,?)}";
                                                                $stmt = sqlsrv_query($conn, $sql, $params);
                                                                echo '<option value="">Seleccione</option>';
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
														<div class="col-md-6">
															<div class="form-group">
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
														</div>
														<div class="col-md-6">
															<div class="form-group">
																<label for="alum_nacionalidad">Nacionalidad</label>
																<input class="form-control" id="alum_nacionalidad" name="alum_nacionalidad" type="text" placeholder="Ingrese la nacionalidad del alumno..." value="<?=$alum_view['alum_nacionalidad'];?>">
															</div>
														</div>
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
														<div class="form-group col-md-6">
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
																echo '<select class="form-control" id="alum_etnia" name="alum_etnia">';
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
													</div>
													<div class="row">
														<div class="col-md-12"><h5 class="page-header">Datos Domicilio</h5></div>
														<div class="col-md-6">
															<div class="form-group">
																<label for="alum_domi">Domicilio<span style="color:red;">*</span>:</label>
																<input class="form-control" id="alum_domi" name="alum_domi" type="text" placeholder="Ingrese el domicilio del alumno..." value="<?=$alum_view['alum_domi'];?>">
															</div>
														</div>
														<div class="col-md-6">
															<div class="form-group">
																<label for="alum_telf">Tel&eacute;fono:</label>
																<input class="form-control" id="alum_telf" name="alum_telf" type="text" placeholder="Ingrese el tel&eacute;fono del alumno..." value="<?=$alum_view['alum_telf'];?>">
															</div>
														</div>
														<div class="col-md-6">
															<div class="form-group">
																<label for="alum_prov">Provincia<span style="color:red;">*</span>:</label>
																<select onchange="CargarCiudades('alum_ciud',this.value);CargarParroquias('alum_parroquia',this.value);" class='form-control' id='alum_prov' name='alum_prov'>
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
														</div>
														<div class="col-md-6">
															<div class="form-group">
																<label for="alum_ciud">Ciudad<span style="color:red;">*</span>:</label>
																<!-- <input class="form-control" id="alum_ciud" name="alum_ciud" type="text" placeholder="Ingrese la ciudad del alumno..." value="<?=$alum_view['alum_ciud'];?>"> -->
																<select onchange="CargarParroquias('alum_parroquia',this.value);" class='form-control' id='alum_ciud' name='alum_ciud'>
																<?php 
																$params = array(null,($alum_view["alum_prov"]==''?'Guayas':$alum_view["alum_prov"]));
																$sql="{call cata_ciudad_cons(?,?)}";
																$stmt = sqlsrv_query($conn, $sql, $params);
																echo '<option value="">Seleccione</option>';
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
														</div>
														<div class="col-md-6">
															<div class="form-group">
																<label for="alum_parroq">Parroquia<span style="color:red;">*</span>:</label>
																<select class="form-control" id="alum_parroquia" name="alum_parroquia">
																<?php 
																$params = array(null,($alum_view["alum_ciud"]==''?'Balzar':$alum_view["alum_ciud"]));
																$sql="{call cata_parroquia_cons(?,?)}";
																$stmt = sqlsrv_query($conn, $sql, $params);
																echo '<option value="">Seleccione</option>';
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
														</div>
														
														
													</div>
													<div class="row">
														<div class="col-md-12"><h5 class="page-header">Datos Adicionales</h5></div>
														<div class="col-md-6">
															<div class="form-group">
																<label for="alum_vive_con">Vive con (Nombre):</label>
																<input class="form-control" id="alum_vive_con" name="alum_vive_con" type="text" placeholder="Ingrese con quien vive el alumno..." value="<?=$alum_view['alum_vive_con'];?>">
															</div>
														</div>
														<div class="col-md-6">
															<div class="form-group">
																<label>Vive con (Parentesco):</label>
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
														</div>
														<div class="col-md-6">
															<div class="form-group">
																<label for="alum_ex_plantel">Plantel de procedencia:</label>
																<input class="form-control" id="alum_ex_plantel" name="alum_ex_plantel" type="text" placeholder="Ingrese el plantel de procedencia del alumno..." value="<?=$alum_view['alum_ex_plantel'];?>">
															</div>
														</div>
														<div class="col-md-6">
															<div class="form-group">
																<label for="alum_ex_plantel_dire">Dirección plantel procedencia:</label>
																<input class="form-control" id="alum_ex_plantel_dire" name="alum_ex_plantel_dire" type="text" placeholder="Ingrese la dirección del plantel de procedencia..." value="<?=$alum_view['alum_ex_plantel_dire'];?>">
															</div>
														</div>
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
														<div class="col-md-6">
															<div class="form-group">
																<label>Enfermedades, alergias, medicinas, prohibiciones, inhabilidades o tratamiento médico especial:</label>
																<textarea class="form-control" rows="3" id="alum_enfermedades" name="alum_enfermedades"><?=$alum_view['alum_enfermedades'];?></textarea>
															</div>
														</div>
														<div class="col-md-6">
															<div class="form-group">
																<label>Tipo de sangre:</label>
																<select class="form-control" id="alum_tipo_sangre" name="alum_tipo_sangre">
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
														</div>
														<div class="form-group col-md-6">
															<label for="alum_tiene_seguro">&nbsp;<br/>
																<input id="alum_tiene_seguro" class="" name="alum_tiene_seguro" type="checkbox"   <?= ($alum_view['alum_tiene_seguro']==1 ? 'checked':'');?>   />
																<label for="alum_tiene_seguro">¿Tiene seguro médico?</label>
																<br/><br/>
															</label>
														</div>
													</div>
													<div class="row">
														<div class="col-md-12"><h5 class="page-header">Datos Contacto de Emergencia</h5></div>
														<div class="col-md-6">
															<div class="form-group">
																<label for="alum_pers_emerg">Nombre de persona de contacto de emergencia:</label>
																<input class="form-control" id="alum_pers_emerg" name="alum_pers_emerg" type="text" placeholder="Ingrese el nombre del contacto de emergencia..." value="<?=$alum_view['alum_pers_emerg'];?>">
															</div>
														</div>
														<div class="col-md-6">
															<div class="form-group">
																<label>Parentesco de contacto de emergencia:</label>
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
																<label for="alum_telf_emerg">Tel&eacute;fono de emergencia:</label>
																<input class="form-control" id="alum_telf_emerg" name="alum_telf_emerg" type="text" placeholder="Ingrese el tel&eacute;fono de emergencia del alumno..." value="<?=$alum_view['alum_telf_emerg'];?>">
															</div>
														</div>
													</div>

												</div>
												<div class="tab-pane" id="tab2">
													<div class="alumnos_add_script admin_pass">
														<div class="row">
															<div class="col-md-6">
																<div class="form-group">
																	<label for="repr_nomb">Nombres<span style="color:red;">*</span>:</label>
																	<input disabled class="form-control" id="repr_nomb" name="repr_nomb" type="text" placeholder="Ingresar nombres" value="<?=$row_repr_view['repr_nomb'];?>">
																</div>
															</div>
															<div class="col-md-6">
																<div class="form-group">
																	<label for="repr_apel">Apellidos<span style="color:red;">*</span>:</label>
																	<input disabled class="form-control" id="repr_apel" name="repr_apel" type="text" placeholder="Ingresar apellidos" value="<?=$row_repr_view['repr_apel'];?>">
																</div>
															</div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="repr_fech_naci">Fecha de Nacimiento:</label>
                                                                    <input disabled class="form-control" id="repr_fech_naci" name="repr_fech_naci" type="text" placeholder="Ingrese la fecha de nacimiento..." value="<?=date_format($row_repr_view['repr_fech_naci'],"d/m/Y");?>"  >
                                                                </div>
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label>País de Nacimiento:</label>
                                                                <select class="form-control" onchange="CargarProvincias('repr_prov_naci',this.value);CargarCiudades('repr_ciud_naci',this.value);"  id="repr_pais_naci" name="repr_pais_naci"  >
                                                                    <?php
                                                                    $params = array();
                                                                    $sql="{call cata_pais_cons()}";
                                                                    $stmt2 = sqlsrv_query($conn, $sql, $params);
                                                                    echo '<option value="">Seleccione</option>';
                                                                    while($pais_view= sqlsrv_fetch_array($stmt2))
                                                                    {
                                                                        $seleccionado="";
                                                                        if($row_repr_view['repr_pais_naci']==''){
                                                                            if ($pais_view["descripcion"]=='Ecuador')
                                                                                $seleccionado="selected";
                                                                        }else{
                                                                            if ($pais_view["descripcion"]==$row_repr_view["repr_pais_naci"])
                                                                                $seleccionado="selected";
                                                                        }
                                                                        echo '<option value="'.$pais_view["codigo"].'" '.$seleccionado.'>'.$pais_view["descripcion"].'</option>';
                                                                    }
                                                                    echo '</select>';
                                                                    ?>
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label>Provincia de Nacimiento:</label>
                                                                <select class="form-control input-sm" onchange="CargarCiudades('repr_ciud_naci',this.value);" id='repr_prov_naci' name='repr_prov_naci'  >
                                                                    <?php
                                                                    $params = array(null,($row_repr_view["repr_prov_naci"]==''?'Ecuador':$row_repr_view["repr_pais_naci"]));
                                                                    $sql="{call cata_provincia_cons(?,?)}";
                                                                    $stmt3 = sqlsrv_query($conn, $sql, $params);
                                                                    echo '<option value="">Seleccione</option>';
                                                                    while($ciudad_view= sqlsrv_fetch_array($stmt3))
                                                                    {
                                                                        $seleccionado="";
                                                                        if ($ciudad_view["descripcion"]==$row_repr_view["repr_prov_naci"])
                                                                            $seleccionado="selected";
                                                                        echo '<option value="'.$ciudad_view["codigo"].'" '.$seleccionado.'>'.$ciudad_view["descripcion"].'</option>';
                                                                    }
                                                                    echo '</select>';
                                                                    ?>
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label>Ciudad de Nacimiento:</label>
                                                                <select class='form-control input-sm' id='repr_ciud_naci' name='repr_ciud_naci'  >
                                                                    <?php
                                                                    $params = array(null,$row_repr_view["repr_prov_naci"]);
                                                                    $sql="{call cata_ciudad_cons(?,?)}";
                                                                    $stmt = sqlsrv_query($conn, $sql, $params);
                                                                    echo '<option value="">Seleccione</option>';
                                                                    while($ciudad_view= sqlsrv_fetch_array($stmt))
                                                                    {
                                                                        $seleccionado="";
                                                                        if ($ciudad_view["descripcion"]==$row_repr_view["repr_ciud_naci"])
                                                                            $seleccionado="selected";
                                                                        echo '<option value="'.$ciudad_view["codigo"].'" '.$seleccionado.'>'.$ciudad_view["descripcion"].'</option>';
                                                                    }
                                                                    echo '</select>';
                                                                    ?>
                                                            </div>
															<div class="col-md-6">
																<div class="form-group">
																	<label for="repr_email">Correo<span style="color:red;">*</span>:</label>
																	<input class="form-control" id="repr_email" name="repr_email" type="text" placeholder="Ingresar correo" value="<?=$row_repr_view['repr_email'];?>">
																</div>
															</div>
															<div class="col-md-6">
																<div class="form-group">
																	<label for="repr_telf">Núm. Teléfono<span style="color:red;">*</span>:</label>
																	<input class="form-control" id="repr_telf" name="repr_telf" type="text" placeholder="Ingresar número convencional" value="<?=$row_repr_view['repr_telf'];?>">
																</div>
															</div>
															<div class="col-md-6">
																<div class="form-group">
																	<label for="repr_celular">Núm. Celular<span style="color:red;">*</span>:</label>
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
																	<label for="repr_profesion">Profesión o Título Académico:</label>
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
																	<label for="repr_lugar_trabajo">Nombre de empresa o lugar de trabajo:</label>
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
																	<label for="repr_cargo">Cargo que desempeña:</label>
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
                                                        <div class="row" style="<?= (para_sist(408)==0?'display: none':'')?>">
                                                            <div class="form-group col-md-6">
                                                                <label>Nivel 1: </label>
                                                                <?php
                                                                include ('../framework/dbconf.php');
                                                                $params = array();
                                                                $sql="{call identificaciones_niv1_view()}";
                                                                $stmt = sqlsrv_query($conn, $sql, $params);
                                                                if( $stmt === false )
                                                                {   echo "Error in executing statement .\n";
                                                                    die( print_r( sqlsrv_errors(), true));
                                                                }
                                                                echo '<select id="identificacion_niv_1" class="form-control input-sm" name="identificacion_niv_1" onchange="CargarIdentNiv2(this.value)"'.$disabled.' >';
                                                                echo '<option value="-1">Seleccione</option>';
                                                                while($row = sqlsrv_fetch_array($stmt))
                                                                {   $seleccionado="";
                                                                    if ($row["id"] == $row_repr_view["ident_niv_1"])
                                                                        $seleccionado = "selected";
                                                                    echo '<option value="'.$row["id"].'" '.$seleccionado.'>'.$row["nombre"].'</option>';
                                                                }
                                                                echo '</select>';
                                                                ?>
                                                            </div>

                                                            <div class="form-group col-md-6">
                                                                <label>Nivel 2: </label>
                                                                <select id="identificacion_niv_2" class="form-control input-sm" name="identificacion_niv_2" onchange="CargarIdentNiv3(this.value)" >
                                                                    <?
                                                                    if ($row_repr_view['repr_nomb'] != ""){
                                                                        $sql = "{call identificaciones_niv2_view(?)}";
                                                                        $params = array($row_repr_view["ident_niv_1"]);
                                                                        $stmt = sqlsrv_query( $conn, $sql,$params);
                                                                        if( $stmt === false ){
                                                                            echo "Error in executing statement .\n";
                                                                            die( print_r( sqlsrv_errors(), true));
                                                                        }
                                                                        else{
                                                                            echo '<option value="-1">Seleccione</option>';
                                                                            while ($row = sqlsrv_fetch_array($stmt)){
                                                                                $seleccionado = "";
                                                                                if ($row["id"] == $row_repr_view["ident_niv_2"])
                                                                                    $seleccionado="selected";
                                                                                echo "<option value='".$row['id']."' ".$seleccionado.">".$row["nombre"]."</option>";
                                                                            }
                                                                        }
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>

                                                            <div class="form-group col-md-6">
                                                                <label>Nivel 3:</label>
                                                                <select id="identificacion_niv_3" class="form-control input-sm" name="identificacion_niv_3" >
                                                                    <?
                                                                    if ($row_repr_view['repr_nomb'] != ""){
                                                                        $sql = "{call identificaciones_niv3_view(?)}";
                                                                        $params = array($row_repr_view["ident_niv_2"]);
                                                                        $stmt = sqlsrv_query( $conn, $sql,$params);
                                                                        if( $stmt === false ){
                                                                            echo "Error in executing statement .\n";
                                                                            die( print_r( sqlsrv_errors(), true));
                                                                        }
                                                                        else{
                                                                            echo '<option value="-1">Seleccione</option>';
                                                                            while ($row = sqlsrv_fetch_array($stmt)){
                                                                                $seleccionado = "";
                                                                                if ($row["id"] == $row_repr_view["ident_niv_3"])
                                                                                    $seleccionado="selected";
                                                                                echo "<option value='".$row['id']."' ".$seleccionado.">".$row["nombre"]."</option>";
                                                                            }
                                                                        }
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
													</div>
												</div>
												<div class="tab-pane" id="tab3">
													<div class="row">
														<div class="col-md-12">
															<div class="checkbox" style='font-size:large;'>
																<label><input id="aceptar_terminos" name="aceptar_terminos" type="checkbox" />&nbsp;Confirmo que la información proporcionada es completa, correcta y que ha sido revisada con exactitud en:</label><br>
																	<ul>
                                                                        <?if( $_SESSION['certus_medic'] == '1' ){?><li>Ficha Médica</li><?}?>
																		<li>Datos del Alumno</li>
																		<li>Datos del Representante</li>
																	</ul>
															</div>
														</div>
													</div>
													<div class="row">
														<div class="col-md-offset-4">
															<div class="alumnos_add_script admin_pass">
																<div class="form-group">
																	<button id="btn_actualizar" class="btn btn-primary" style="width:40%;" data-loading="Actualizando.." onclick="actualizar_datos();">Actualizar</button>
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
		<script type="text/javascript">  
			$(document).ready(function(){  
				$("#alum_fech_naci").datepicker();
                $("#repr_fech_promoc").datepicker();
				// $('#myModal').modal('show');
			});
			function preview(tField,iType) { 
				file=tField.value; 
				if (iType==1) { 
					extArray = new Array(".jpg",'.png','.jpeg'); 
				} 
				allowSubmit = false; 
				if (!file) return; 
				while (file.indexOf("\\") != -1) file = file.slice(file.indexOf("\\") + 1); 
				ext = file.slice(file.indexOf(".")).toLowerCase(); 
				for (var i = 0; i < extArray.length; i++) { 
					if (extArray[i] == ext) { 
						allowSubmit = true; 
						break; 
					} 
				} 
				if (allowSubmit) {
					var oFReader = new FileReader();
			        oFReader.readAsDataURL(document.getElementById("alum_foto").files[0]);

			        oFReader.onload = function (oFREvent) {
			            document.getElementById("alum_preview").src = oFREvent.target.result;
			        };
				} else { 
					tField.value=""; 
					alert("Usted sólo puede subir archivos con extensiones " + (extArray.join(" ")) + "\nPor favor seleccione un nuevo archivo"); 
				} 
			}
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