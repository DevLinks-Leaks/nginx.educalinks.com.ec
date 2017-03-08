<?php
if($_SESSION['peri_codi_dest']!=null){
	if(!(alum_tiene_deuda($_SESSION['alum_codi'],$_SESSION['curs_para_codi']) and para_sist(403)=='1')){
		$params = array($_SESSION['alum_codi'],$_SESSION['peri_codi_dest']);
		$sql="{call preins_curs_para(?,?)}";
		$preins_curs_para = sqlsrv_query($conn, $sql, $params);  
		$row_preins_curs_para = sqlsrv_fetch_array($preins_curs_para);

		if($row_preins_curs_para['alum_curs_para_codi_res']==null){
			// $_SESSION['ISBIEN_ALUM'] == 'INNOT';
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

			$sql_opc = "{call alum_curs_para_info(?)}";
			$params_opc= array($_SESSION['alum_curs_para_codi']);
			$alum_curs_para_codi = sqlsrv_query( $conn, $sql_opc,$params_opc);
			if( $stmt_opc === false ){echo "Error in executing statement .\n";die( print_r( sqlsrv_errors(), true));} 
			$row_alum_curs_para_codi=sqlsrv_fetch_array($alum_curs_para_codi);

			$sql_opc = "{call peri_info(?)}";
			$params_opc= array($_SESSION['peri_codi_dest']);
			$peri_info = sqlsrv_query( $conn, $sql_opc,$params_opc);
			if( $stmt_opc === false ){echo "Error in executing statement .\n";die( print_r( sqlsrv_errors(), true));} 
			$row_peri_info=sqlsrv_fetch_array($peri_info);
			/*descencriptar numero tarjeta*/
			if($alum_view['alum_resp_form_banc_tarj_nume']!=null){
				$alum_resp_form_banc_tarj_nume_dec=base64_decode($alum_view['alum_resp_form_banc_tarj_nume']);
				$iv = base64_decode($_SESSION['clie_iv']);
				$alum_resp_form_banc_tarj_nume = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $_SESSION['clie_key'], $alum_resp_form_banc_tarj_nume_dec, MCRYPT_MODE_CBC, $iv );
				// $alum_resp_form_banc_tarj_nume=rtrim($alum_resp_form_banc_tarj_nume,"\0");
				$alum_resp_form_banc_tarj_nume=preg_replace('/[^A-Za-z0-9\-]/', '',$alum_resp_form_banc_tarj_nume);
				$alum_resp_form_banc_tarj_nume =  creditCardMask($alum_resp_form_banc_tarj_nume,4,8);
			}
			/*FIN*/
?>
<div class="box box-default">
  	<!-- <div class="box-header"></div> -->
  	<div class="box-body">
			<div class="zones">
				<div class="nav-tabs-custom">  
					<ul class="nav nav-tabs">    
					  
					  <li class="active"><a href="#tab1" data-toggle="tab" onClick=""><span class=" fa-file-text-o fa"></span> 1. Datos del Alumno</a></li>
					  <li><a href="#tab2" data-toggle="tab" onClick=""><span class="fa-users fa"></span> 2. Datos de Representantes</a></li>
					  <li><a href="#tab3" data-toggle="tab" onClick=""><span class="fa-credit-card fa"></span> 3. Débito Bancario</a></li>
					  <li><a href="#tab4" data-toggle="tab" onClick=""><span class="fa-check fa"></span> 4. Confirmación</a></li>
					</ul>
				
					<div class="tab-content">
						<div class="tab-pane active" id="tab1">
								<div class="row">
									<div class="col-md-12"><h5 class="page-header">Datos Principales</h5></div>
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
													<input id="alum_hombre" class="alum_genero" type="radio" name="genero" value="Hombre" <?= ($alum_view['alum_genero']==1?' checked':'') ?> /> Masculino  </label>
												<label>					
													<input id="alum_mujer" class="alum_genero" type="radio" name="genero" value="Mujer" <?= ($alum_view['alum_genero']==0?' checked':'') ?> /> Femenino </label>
											
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label for="alum_cedu"><?=(para_sist(405)=='1'?'(*)':'')?>Cédula:</label>
											<input class="form-control <?=(para_sist(404)=='1'?'required':'')?>" id="alum_cedu" name="alum_cedu" type="text" placeholder="Ingrese la c&eacute;dula del alumno..." value="<?=$alum_view['alum_cedu'];?>" onkeyup="">
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
									<div class="col-md-6">
										<div class="form-group">
											<label for="alum_fech_naci">(*)Fecha de Nacimiento:</label>
											<input class="form-control" id="alum_fech_naci" name="alum_fech_naci" type="text" placeholder="Ingrese la fecha de nacimiento del alumno..." value="<?=date_format($alum_view['alum_fech_naci'],"d/m/Y");?>">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label for="alum_pais">País de nacimiento:</label>
											<select onchange="CargarProvincias('alum_prov_naci',this.value);" class="form-control" id="alum_pais" name="alum_pais">
											<?php 
											$params = array();
											$sql="{call cata_pais_cons()}";
											$stmt = sqlsrv_query($conn, $sql, $params);
											while($pais_view= sqlsrv_fetch_array($stmt))
											{
												$seleccionado="";
												if ($pais_view["descripcion"]==$alum_view["alum_pais"])
													$seleccionado="selected";
												echo '<option value="'.$pais_view["codigo"].'" '.$seleccionado.'>'.$pais_view["descripcion"].'</option>';
											}
											echo '</select>';
											?>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label for="alum_prov_naci">Provincia de nacimiento:</label>
											<select onchange="CargarCiudades('alum_ciud_naci',this.value);" class='form-control' id='alum_prov_naci' name='alum_prov_naci'>
											<?php 
											$params = array(null,$alum_view["alum_pais"]);
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
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label for="alum_ciud_naci">Ciudad de nacimiento:</label>
											<select onchange="CargarParroquias('alum_parr_naci',this.value);" class='form-control' id='alum_ciud_naci' name='alum_ciud_naci'>
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
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label for="alum_parr_naci">Parroquia de nacimiento:</label>
											<select class="form-control" id="alum_parr_naci" name="alum_parr_naci">
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
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label for="alum_sect_naci">Sector de nacimiento:</label>
											<select class="form-control" id="alum_sect_naci" name="alum_sect_naci">
											<?php 
											$params = array(337);
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
								</div>
								<div class="row">
									<div class="col-md-12"><h5 class="page-header">Datos Domicilio</h5></div>
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
									<div class="col-md-6">
										<div class="form-group">
											<label for="alum_ciud">(*)Ciudad:</label>
											<!-- <input class="form-control" id="alum_ciud" name="alum_ciud" type="text" placeholder="Ingrese la ciudad del alumno..." value="<?=$alum_view['alum_ciud'];?>"> -->
											<select onchange="CargarParroquias('alum_parroquia',this.value);" class='form-control' id='alum_ciud' name='alum_ciud'>
											<?php 
											$params = array(10,null);
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
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label for="alum_parroq">(*)Parroquia:</label>
											<!-- <input class="form-control" id="alum_parroq" name="alum_parroq" type="text" placeholder="Ingrese la parroquia del alumno..." value="<?=$alum_view['alum_parroquia'];?>"> -->
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
												$params = array(343);
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
							<div class="row">
								<table class="table table-responsive">
									<thead>
										<tr class="active">
											<th class="text-center">Representante</th>
											<th class="text-center">Parentesco</th>
											<th class="text-center">Representante Financiero</th>
											<th class="text-center">Datos</th>
										</tr>
									</thead>
									<tbody>
										<?php
											$params = array($_SESSION['alum_codi']);
											$sql="{call repr_alum_info(?)}";
											$repr_alum_info = sqlsrv_query($conn, $sql, $params);  
											while ($row_repr_alum_info = sqlsrv_fetch_array($repr_alum_info)){
										?>
										<tr>
											<td ><?= $row_repr_alum_info['repr_apel'];?> - <?= $row_repr_alum_info['repr_nomb'];?></td>
											<td class="text-center"><?= $row_repr_alum_info['repr_parentesco'];?></td>
											<td class="text-center"><input id="<?=$row_repr_alum_info['repr_codi'];?>" class="check_finan" type="checkbox" value="1" <?= ($row_repr_alum_info['repre_alum_fact']=='S'?' checked':'') ?> onclick="check_repr_finan(this);" /> </td>
											<td class="text-center">
												<button class="btn btn-primary" data-toggle="modal" data-target="#modal_preinscripcion"  onclick="load_modal_preinscripcion_view('modal_preinscripcion_content','preinscripcion_modal_view.php','repr_codi=<?= $row_repr_alum_info['repr_codi'];?>');" >Editar Datos</button>
											</td>
											
										</tr>
										<? } ?>
									</tbody>
								</table>
							</div>
						</div>
						<div class="tab-pane" id="tab3">
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
						                <label for="alum_resp_form_pago">Forma de Pago:</label>
						                <select class="form-control" id="alum_resp_form_pago" name="alum_resp_form_pago" onchange="CargarBancosTarjetas(this.value);" >
						                	<option value="0">SELECCIONE</option>
						                <?php	
						                    $params = array(21);
						                    $sql="{call cata_hijo_view(?)}";
						                    $stmt = sqlsrv_query($conn, $sql, $params);
						                    while($form_pago_view= sqlsrv_fetch_array($stmt))
						                    {	$seleccionado="";
						                		if ($form_pago_view["codigo"]==$alum_view["alum_resp_form_pago"])
						                			$seleccionado="selected";
						            	?>
					                        <option value="<?=$form_pago_view["codigo"];?>" <?=$seleccionado;?> ><?=$form_pago_view["descripcion"];?></option>
						                <?	}	?> 
						                </select>
						            </div>
					            </div>
					            <div class="col-md-6">
						            <div id="div_banco_tarjeta" class="form-group">
						                <label for="alum_resp_form_banc_tarj" id="lbl_banco_tarjeta">Banco/Tarjeta:</label>
										<?php 
					                    $params = array($alum_view['alum_resp_form_pago']);
					                    $sql="{call cata_hijo_view(?)}";
					                    $stmt = sqlsrv_query($conn, $sql, $params);
					            
					                    $seleccionado="";
					                    $deshabilitado="";
					                    if (!isset($alum_view['alum_resp_form_banc_tarj']))
					                        $deshabilitado="disabled";
					                   	?>
					                    <select class="form-control" id="alum_resp_form_banc_tarj" name="alum_resp_form_banc_tarj" <?=$deshabilitado?> >
					                    	<option value="0">SELECCIONE</option>
					                    <?php	while($banc_tarj_view= sqlsrv_fetch_array($stmt)){
					                        if($banc_tarj_view["codigo"]==$alum_view['alum_resp_form_banc_tarj'])
					                        {$seleccionado="selected";}else{$seleccionado="";}
					                    ?>
					                       	<option <?=$seleccionado;?> value="<?=$banc_tarj_view['codigo']?>" ><?=$banc_tarj_view["descripcion"];?></option>
					                    <?}?>
					                    </select>
						            </div>
					            </div>
					            <div class="col-md-6">
									<div class="form-group">
						                <label for="alum_resp_tarj_banco_emisor">Banco emisor: (en caso de tarj. de crédito)</label>
						                <select class="form-control" id="alum_resp_tarj_banco_emisor" name="alum_resp_tarj_banco_emisor" <?=($alum_view["alum_resp_form_pago"]==22) ? 'disabled' : '';?> >
											<option value="0">SELECCIONE</option>
						                	<?php 
						                    $params = array(22);
						                    $sql="{call cata_hijo_view(?)}";
						                    $stmt = sqlsrv_query($conn, $sql, $params);
						                    $seleccionado="";
						                    while($row= sqlsrv_fetch_array($stmt)){	
						                    	if($row["codigo"]==$alum_view['alum_resp_tarj_banco_emisor'])
						                        {$seleccionado="selected";}else{$seleccionado="";}
						                    ?>
						                     <option <?=$seleccionado?> value="<?=$row['codigo']?>"> <?=$row["descripcion"]?></option>
						                    <?}?>
						                    </select>
						            </div>
						        </div>
						        <div class="col-md-6"> 
									<div class="form-group">
						                <label for="alum_resp_form_banc_tarj_nume"><?=(para_sist(404)=='1'?'(*)':'')?>Número Cuenta o Tarjeta</label>
						                <input class="form-control <?=(para_sist(404)=='1'?'required':'')?>" id="alum_resp_form_banc_tarj_nume" name="alum_resp_form_banc_tarj_nume" type="text" placeholder="Ingrese numero de Cuenta o Tarjeta..." value="<?=$alum_resp_form_banc_tarj_nume;?>">
						            </div>
						        </div>
						        <div class="col-md-6"> 
									<div class="form-group">
										<label for="alum_resp_form_fech_vcto">Fecha de Vencimiento de Tarjeta:</label>
										<input class="form-control" id="alum_resp_form_fech_vcto" name="alum_resp_form_fech_vcto" type="text" placeholder="Ingrese la fecha de vencimiento de la tarjeta..." value="<?=date_format($alum_view['alum_resp_form_fech_vcto'],"d/m/Y");?>">
									</div>
								</div>
								<div class="col-md-6"> 
									<div class="form-group">
						            	
						                <label for="lbl_tipo">Tipo de Cuenta:<br/>
						                <br/>
						                    <input id="cta_corriente" type="radio" class="alum_resp_form_banc_tipo" name="tipo_cuenta" value="CORRIENTE" <?=($alum_view['alum_resp_form_banc_tipo']=="C"?"checked":"")?> />CUENTA CORRIENTE 
						                    <input id="cta_ahorro" type="radio" class="alum_resp_form_banc_tipo" name="tipo_cuenta" value="AHORROS" <?=($alum_view['alum_resp_form_banc_tipo']=="A"?"checked":"")?> />CUENTA DE AHORROS
						                </label>
						            </div>
					            </div>
					            <div class="col-md-6">
									<div class="form-group">
						                <label for="alum_resp_form_cedu">Número de Idetificación del Propietario de la  Cuenta:</label>
						                <input class="form-control" id="alum_resp_form_cedu" name="alum_resp_form_cedu" type="text" placeholder="Ingrese cédula..." value="<?=$alum_view['alum_resp_form_cedu'];?>">
						            </div>
						        </div>
						        <div class="col-md-6">
									<div class="form-group">
								        <label for="alum_resp_form_tipo_iden">Tipo de Identificación del Propietario de la Cuenta:</label>
								        <select class="form-control" id='alum_resp_form_tipo_iden' name='alum_resp_form_tipo_iden' >
								        <?php 
								            $sql="select tipo_iden_codi, tipo_iden_deta from Tipo_Identificacion where tipo_iden_estado='A' and tipo_iden_show_acad ='Y'";
								            $stmt = sqlsrv_query($conn, $sql);
								            while($tipo_iden_result= sqlsrv_fetch_array($stmt)){
								                $seleccionado="";
								                if ($tipo_iden_result["tipo_iden_codi"]==$alum_view['alum_resp_form_tipo_iden'])
								                            $seleccionado="selected";
								        ?>
											<option value="<?=$tipo_iden_result["tipo_iden_codi"]?>" <?=$seleccionado?> ><?=$tipo_iden_result["tipo_iden_deta"]?></option>
								        <? } ?>
							            </select>
								    </div>
							    </div>
							    <div class="col-md-6">
									<div class="form-group">
						                <label for="alum_resp_form_nomb">Nombres del Propietario de la  Cuenta:</label>
						                <input class="form-control" id="alum_resp_form_nomb" name="alum_resp_form_nomb" type="text" placeholder="Ingrese nombres y apellidos ..." value="<?=$alum_view['alum_resp_form_nomb'];?>">
						            </div>
					            </div>
							</div>
						</div>
						<div class="tab-pane" id="tab4">
							<div class="row">
								<div class="col-md-12">
									<div class="alert alert-success">
										<h3><i class="fa fa-ticket"></i> Información de Preinscripción</h3>
										<label class="lead">Se realizará una reserva de cupo para el curso "<b><?=$row_alum_curs_para_codi['curs_sig'];?> de <?=$row_alum_curs_para_codi['nive_sig'];?></b>" en el periodo Lectivo <b><?=$row_peri_info['peri_deta'];?></b></label>
									</div>
								</div>
								<div class="col-md-12">
									<div class="checkbox" style='font-size:large;'>
										<label><input id="aceptar_terminos" name="aceptar_terminos" type="checkbox" /></label>&nbsp;Confirmo que la información proporcionada es completa, correcta y que ha sido revisada con exactitud en: <br>
											<ul>
												<li>Datos de Alumno</li>
												<li>Datos de Representantes</li>
												<li>Débito Bancario</li>
											</ul>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-offset-4">
									<div class="alumnos_add_script admin_pass">
										<div class="form-group">
											<input id="btn_reservar" class="btn btn-primary" style="width:40%;" type="button" value="Registrar/Actualizar" onclick="preinscribir_alumno();" />
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		<!-- </form> -->
  	</div>
  	<div class="box-footer"></div>
</div>
<!-- <script type="text/javascript" charset="utf-8">
	
</script> -->
<? }else{ 
	// $_SESSION['ISBIEN_ALUM'] == 'YESIN';
	?>
<div class="box box-default">
  	<!-- <div class="box-header"></div> -->
  	<div class="box-body">
		<div class="row">
			<div class="col-md-12">
				<div class="alert alert-success">
					<h3><i class="fa fa-ticket"></i> Detalles de la Preinscripción</h3>
					<label class="lead">Se realizó una reserva de cupo para el alumno <b><?=$row_preins_curs_para['alum_apel'];?> <?=$row_preins_curs_para['alum_nomb'];?> </b> en el curso <b><?=$row_preins_curs_para['curs_deta'];?> de <?=$row_preins_curs_para['nive_deta'];?> "<?=$row_preins_curs_para['para_deta'];?>"</b> en el periodo Lectivo <b><?=$row_preins_curs_para['peri_deta'];?></b>.</label>
				</div>
			</div>
			<div class="col-md-10 col-md-offset-1">
				<table class="table table-responsive">
					<thead>
						<tr class="active">
							<th class="text-center">Documentos</th>
							<th class="text-center">Opciones</th>
						</tr>
					</thead>
					<tbody>
						<!-- <tr>
							<td >Contrato</td>
							<td class="text-center">
								<a class="btn btn-success" onclick="window.open('../admin/reportes_generales/contrato_<?= $_SESSION['directorio'] ?>_pdf.php?alum_curs_para_codi=<?= $row_preins_curs_para['alum_curs_para_codi_res'];?>','_blank')"><i class="fa fa-download"></i>	Descargar
								</a>
							</td>
						</tr> -->
						<tr>
							<td >Solicitud de Matricula</td>
							<td class="text-center">
								<a class="btn btn-success" onclick="window.open('../admin/reportes_generales/soli_matr_<?= $_SESSION['directorio'] ?>_pdf.php?alum_codi=<?=$_SESSION['alum_codi'];?>&peri_codi=<?=$_SESSION['peri_codi_dest'];?>','_blank')"><i class="fa fa-download"></i> Descargar</a>
							</td>
						</tr>
						<tr>
							<td>Ficha de Matrícula</td>
							<td class="text-center">
								<?php 
									if($_SESSION['directorio']=='liceopanamericano' or $_SESSION['directorio']=='liceopanamericanosur'){

								?>
								<a class="btn btn-success" onclick="window.open('../admin/reportes_generales/ficha_matricula_<?= $_SESSION['directorio'] ?>_pdf.php?alum_curs_para_codi=<?= $row_preins_curs_para['alum_curs_para_codi_res'];?>','_blank')"><i class="fa fa-download"></i> Descargar</a>
								<?php 
								}else{
								?>
								<a class="btn btn-success" onclick="window.open('../admin/reportes_generales/ficha_matricula_pdf.php?alum_curs_para_codi=<?= $row_preins_curs_para['alum_curs_para_codi_res'];?>','_blank')"><i class="fa fa-download"></i> Descargar</a>
								<?php
									}
								?>
							</td>
						</tr>
						<tr>
							<td >Autorización de débito</td>
							<td class="text-center">
								<a class="btn btn-success" onclick="window.open('../admin/reportes_generales/debito_pdf.php?alum_curs_para_codi=<?= $row_preins_curs_para['alum_curs_para_codi_res'];?>','_blank')"><i class="fa fa-download"></i>	Descargar
								</a>
							</td>
						</tr>
						<!-- <tr>
							<td>Pagaré </td>
							<td class="text-center">
								<a class="btn btn-success" onclick="window.open('../admin/reportes_generales/pagare_<?= $_SESSION['directorio'] ?>_pdf.php?alum_curs_para_codi=<?= $row_preins_curs_para['alum_curs_para_codi_res'];?>','_blank')"><i class="fa fa-download"></i> Descargar</a>
							</td>
						</tr> -->
						
					</tbody>
				</table>
			</div>
		</div>
  	</div>
  	<div class="box-footer"></div>
</div>

<? }  }
else { ?>
<div class="box box-default">
  	<!-- <div class="box-header"></div> -->
  	<div class="box-body">
		<div class="row">
			<div class="col-md-12">
				<div class="alert alert-danger">
					<h3><i class="fa fa-ticket"></i> Bloqueo de Preinscripción</h3>
					<label class="lead"> Favor acercarse a la institución para mayor información.</label>
				</div>
			</div>
		</div>
  	</div>
  	<div class="box-footer"></div>
</div>


<? }} ?>