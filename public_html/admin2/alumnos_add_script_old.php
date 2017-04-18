<div class="alumnos_add_script">
<link href="../theme/jquery1_11/jquery-ui.css" rel="stylesheet">
<link href="../theme/jquery1_11/external/jquery/jquery_growl/stylesheets/jquery.growl.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../framework/funciones.js"></script>
<script type="text/javascript" src="js/funciones_alum.js"></script>
<script type="text/javascript" src="js/funciones_repre.js"></script>
<?php  
session_start();
include ('../framework/dbconf.php');
if(isset($_POST['alum_codi'])){$alum_codi=$_POST['alum_codi'];}else{if(isset($_GET['alum_codi'])){$alum_codi=$_GET['alum_codi'];}else{$alum_codi=0;}}
$params = array($alum_codi);
$sql="{call alum_info(?)}";
$stmt = sqlsrv_query($conn, $sql, $params);
if( $stmt === false ){echo "Error in executing statement .\n";die( print_r( sqlsrv_errors(), true));} 
$alum_view= sqlsrv_fetch_array($stmt);?>
<div id="div_noti">&nbsp;</div>


<div class="alumnos_add_script">
<form id="frm_alum" name="frm_alum" action="" enctype="multipart/form-data" method="post">
<input id="alum_codi" name="alum_codi" type="hidden" value="<?=$alum_view['alum_codi'];?>">

<div class="picture">

    <div class="selector">
        <?php
    	$file_exi=$_SESSION['ruta_foto_alumno'].$alum_view['alum_codi'].'.jpg';

    	if (file_exists($file_exi)) {
    		$pp=$file_exi;
    	} else {
    		$pp=$_SESSION['ruta_foto_usuario'].'admin.jpg';
    	}
    	?>
        	<div id="div_foto" >
                <img src="<?php echo $pp;?>" width="150" height="200" />
            </div>
    		<input type="file" name="alum_foto" id="alum_foto" class="btn" onBlur='LimitAttach(this,1);' />
    </div>

    <div class="buttons">
        <ul>
            <?php if ($alum_view['alum_codi']==""){?>
            <li>
                <button id="btn_inscribir" name="btn_inscribir" type="button" onClick="load_ajax_add_alum('div_noti','script_alum.php','opc=add&alum_nomb='+document.getElementById('alum_nomb').value+'&alum_apel='+document.getElementById('alum_apel').value+'&alum_fech_naci='+document.getElementById('alum_fech_naci').value+'&alum_cedu='+document.getElementById('alum_cedu').value+'&alum_mail='+document.getElementById('alum_mail').value+'&alum_celu='+document.getElementById('alum_celu').value+'&alum_domi='+document.getElementById('alum_domi').value+'&alum_telf='+document.getElementById('alum_telf').value+'&alum_ciud='+document.getElementById('alum_ciud').value+'&alum_pais='+document.getElementById('alum_pais').value+'&alum_reli='+document.getElementById('alum_reli').value+'&alum_telf_emerg='+document.getElementById('alum_telf_emerg').value+'&alum_ex_plantel='+document.getElementById('alum_ex_plantel').value+'&alum_estado_civil_padres='+document.getElementById('alum_estado_civil_padres').value+'&alum_usua='+document.getElementById('alum_usua').value+'&alum_parroq='+document.getElementById('alum_parroq').value+'&alum_vive_con='+document.getElementById('alum_vive_con').value+'&alum_movilizacion='+document.getElementById('alum_movilizacion').value+'&alum_motivo_cambio='+document.getElementById('alum_motivo_cambio').value+'&alum_discapacidad='+document.getElementById('alum_discapacidad').value+'&alum_condicionado='+document.getElementById('alum_condicionado').checked+'&alum_conducta='+document.getElementById('alum_conducta').value+'&alum_ultimo_anio='+document.getElementById('alum_ultimo_anio').value+'&alum_nacionalidad='+document.getElementById('alum_nacionalidad').value+'&alum_motivo_condicion='+document.getElementById('alum_motivo_condicion').value+'&alum_resp_form_pago='+document.getElementById('sl_form_pago').value+'&alum_resp_form_banc_tarj='+document.getElementById('sl_banco_tarjeta').value+'&alum_resp_form_banc_tarj_nume='+document.getElementById('alum_resp_form_banc_tarj_nume').value+'&alum_resp_form_banc_tipo='+(document.getElementById('cta_corriente').checked?'C':'A')+'&alum_resp_form_cedu='+document.getElementById('alum_resp_form_cedu').value+'&alum_resp_form_nomb='+document.getElementById('alum_resp_form_nomb').value+'&alum_desc_porcentaje='+document.getElementById('alum_desc_porcentaje').value+'&alum_desc_tipo='+document.getElementById('alum_desc_tipo').value+'&alum_estado='+document.getElementById('sl_estado').value+'&alum_grup_econ='+document.getElementById('sl_alum_grup_econ').value+'&alum_tiene_discapacidad='+document.getElementById('alum_tiene_discapacidad').checked+'&alum_genero='+document.getElementById('alum_hombre').checked,'alum_codi');">Inscribir</button>
            </li>
            <?php }else{?>
            <li>
                <button id="btn_guardar" name="btn_guardar" type="button" onClick="load_ajax_edit_alum('div_noti','script_alum.php','opc=edi&alum_nomb='+document.getElementById('alum_nomb').value+'&alum_apel='+document.getElementById('alum_apel').value+'&alum_fech_naci='+document.getElementById('alum_fech_naci').value+'&alum_cedu='+document.getElementById('alum_cedu').value+'&alum_mail='+document.getElementById('alum_mail').value+'&alum_celu='+document.getElementById('alum_celu').value+'&alum_domi='+document.getElementById('alum_domi').value+'&alum_telf='+document.getElementById('alum_telf').value+'&alum_ciud='+document.getElementById('alum_ciud').value+'&alum_pais='+document.getElementById('alum_pais').value+'&alum_reli='+document.getElementById('alum_reli').value+'&alum_telf_emerg='+document.getElementById('alum_telf_emerg').value+'&alum_ex_plantel='+document.getElementById('alum_ex_plantel').value+'&alum_estado_civil_padres='+document.getElementById('alum_estado_civil_padres').value+'&alum_usua='+document.getElementById('alum_usua').value+'&alum_codi='+document.getElementById('alum_codi').value+'&alum_parroq='+document.getElementById('alum_parroq').value+'&alum_vive_con='+document.getElementById('alum_vive_con').value+'&alum_movilizacion='+document.getElementById('alum_movilizacion').value+'&alum_motivo_cambio='+document.getElementById('alum_motivo_cambio').value+'&alum_discapacidad='+document.getElementById('alum_discapacidad').value+'&alum_condicionado='+document.getElementById('alum_condicionado').checked+'&alum_conducta='+document.getElementById('alum_conducta').value+'&alum_ultimo_anio='+document.getElementById('alum_ultimo_anio').value+'&alum_nacionalidad='+document.getElementById('alum_nacionalidad').value+'&alum_motivo_condicion='+document.getElementById('alum_motivo_condicion').value+'&alum_resp_form_pago='+document.getElementById('sl_form_pago').value+'&alum_resp_form_banc_tarj='+document.getElementById('sl_banco_tarjeta').value+'&alum_resp_form_banc_tarj_nume='+document.getElementById('alum_resp_form_banc_tarj_nume').value+'&alum_resp_form_banc_tipo='+(document.getElementById('cta_corriente').checked?'C':'A')+'&alum_resp_form_cedu='+document.getElementById('alum_resp_form_cedu').value+'&alum_resp_form_nomb='+document.getElementById('alum_resp_form_nomb').value+'&alum_desc_porcentaje='+document.getElementById('alum_desc_porcentaje').value+'&alum_desc_tipo='+document.getElementById('alum_desc_tipo').value+'&alum_estado='+document.getElementById('sl_estado').value+'&alum_grup_econ='+document.getElementById('sl_alum_grup_econ').value+'&alum_tiene_discapacidad='+document.getElementById('alum_tiene_discapacidad').checked+'&alum_genero='+document.getElementById('alum_hombre').checked);">Guardar</button>
            </li>   
            <?php }?>  
            <?php if (permiso_activo(21)){?>
            <li>
                <button id="btn_repre" name="btn_repre" type="button" onclick="window.location='representantes_add.php?alum_codi='+document.getElementById('alum_codi').value;"  <?php if ($alum_view['alum_codi']==""){?>style="display:none;"<? }?> >Representantes</button>
            </li>
            <?php }?>
            <li>
                <button id="btn_cancelar" name="btn_cancelar" type="reset">Cancelar</button>
            </li>
        </ul>
    </div>
    <div  id="alum_bloq_view">
    
     
    </div>
</div>

<div class="data">  
    <div class="form_element">
    	<label for="alum_nomb">Nombres:</label>
    	<input id="alum_nomb" name="alum_nomb" type="text" placeholder="Ingrese los nombres del alumno..." value="<?=$alum_view['alum_nomb'];?>"  onkeyup="alum_bloq_view(); new_username ();">
    </div>
    <div class="form_element">
    	<label for="alum_apel">Apellidos:</label>
    	<input id="alum_apel" class="input" name="alum_apel" type="text" placeholder="Ingrese los apellidos del alumno..." value="<?=$alum_view['alum_apel'];?>" onkeyup="alum_bloq_view(); new_username ();">
    </div>
    <div class="form_element">
    	<label for="alum_fech_naci">Fecha de Nacimiento:</label>
    	<input id="alum_fech_naci" name="alum_fech_naci" type="text" placeholder="Ingrese la fecha de nacimiento del alumno..." value="<?=date_format($alum_view['alum_fech_naci'],"d/m/Y");?>">
    </div>
    <div class="form_element">
                <label for="lbl_tipo">Género:<br/>
                    <input id="alum_hombre" type="radio" name="genero" value="Hombre" <?= ($alum_view['alum_genero']==1?' checked':'') ?> /><span style="margin-right: 50px">HOMBRE</span>
                    <input id="alum_mujer" type="radio" name="genero" value="Mujer" <?= ($alum_view['alum_genero']==0?' checked':'') ?> />MUJER
				</label>
            </div>
    <div class="form_element">
    	<label for="alum_cedu">Cédula:</label>
    	<input id="alum_cedu" name="alum_cedu" type="text" placeholder="Ingrese la c&eacute;dula del alumno..." value="<?=$alum_view['alum_cedu'];?>" onkeyup="alum_bloq_view()">
    </div>
    <div class="form_element">
    	<label for="alum_mail">Email:</label>
    	<input id="alum_mail" name="alum_mail" type="text" placeholder="Ingrese el email del alumno..." value="<?=$alum_view['alum_mail'];?>">
    </div>
    <div class="form_element">
    	<label for="alum_celu">Celular:</label>
    	<input id="alum_celu" name="alum_celu" type="text" placeholder="Ingrese el celular del alumno..." value="<?=$alum_view['alum_celu'];?>">
    </div>
    <div class="form_element">
    	<label for="alum_domi">Domicilio:</label>
    	<input id="alum_domi" name="alum_domi" type="text" placeholder="Ingrese el domicilio del alumno..." value="<?=$alum_view['alum_domi'];?>">
    </div>
    <div class="form_element">
    	<label for="alum_telf">Tel&eacute;fono:</label>
    	<input id="alum_telf" name="alum_telf" type="text" placeholder="Ingrese el tel&eacute;fono del alumno..." value="<?=$alum_view['alum_telf'];?>">
    </div>
    <div class="form_element">
    	<label for="alum_ciud">Ciudad:</label>
    	<input id="alum_ciud" name="alum_ciud" type="text" placeholder="Ingrese la ciudad del alumno..." value="<?=$alum_view['alum_ciud'];?>">
    </div>
    <div class="form_element">
    	<label for="alum_parroq">Parroquia:</label>
    	<input id="alum_parroq" name="alum_parroq" type="text" placeholder="Ingrese la parroquia del alumno..." value="<?=$alum_view['alum_parroquia'];?>">
    </div>
    <div class="form_element">
    	<label for="alum_pais">Pa&iacute;s donde naci&oacute;:</label>
    	<input id="alum_pais" name="alum_pais" type="text" placeholder="Ingrese el pa&iacute;s del alumno..." value="<?=$alum_view['alum_pais'];?>">
    </div>
    <div class="form_element">
    	<label for="alum_nacionalidad">Nacionalidad</label>
    	<input id="alum_nacionalidad" name="alum_nacionalidad" type="text" placeholder="Ingrese la nacionalidad del alumno..." value="<?=$alum_view['alum_nacionalidad'];?>">
    </div>
    <div class="form_element">
    	<label for="alum_reli">Religi&oacute;n:</label>
    	<input id="alum_reli" name="alum_reli" type="text" placeholder="Ingrese la religi&oacute;n del alumno..." value="<?=$alum_view['alum_reli'];?>">
    </div>
    <div class="form_element">
    	<label for="alum_telf_emerg">Tel&eacute;fono de emergencia:</label>
    	<input id="alum_telf_emerg" name="alum_telf_emerg" type="text" placeholder="Ingrese el tel&eacute;fono de emergencia del alumno..." value="<?=$alum_view['alum_telf_emerg'];?>">
    </div>
    <div class="form_element">
    	<label for="alum_ex_plantel">Plantel procedente:</label>
    	<input id="alum_ex_plantel" name="alum_ex_plantel" type="text" placeholder="Ingrese el plantel procedente del alumno..." value="<?=$alum_view['alum_ex_plantel'];?>">
    </div>
    <div class="form_element">
    	<label for="alum_vive_con">Vive con:</label>
    	<input id="alum_vive_con" name="alum_vive_con" type="text" placeholder="Ingrese con quien vive el alumno..." value="<?=$alum_view['alum_vive_con'];?>">
    </div>
    <div class="form_element">
    	<label for="alum_motivo_cambio">Motivo cambio:</label>
    	<input id="alum_motivo_cambio" name="alum_motivo_cambio" type="text" placeholder="Ingrese motivo de cambio del alumno..." value="<?=$alum_view['alum_motivo_cambio'];?>">
    </div>
    <div class="form_element">
    	<label for="alum_tiene_discapacidad">Tiene discapacidad:</label>
    	<input id="alum_tiene_discapacidad" name="alum_tiene_discapacidad" type="checkbox"   <?= ($alum_view['alum_tiene_discapacidad']==1 ? 'checked':'');?>  onclick="ActivarDesactivarText('alum_tiene_discapacidad','alum_discapacidad')" />
    </div>
    <div class="form_element">
    	<label for="alum_discapacidad">Discapacidad:</label>
    	<input id="alum_discapacidad" name="alum_discapacidad" type="text" value="<?=$alum_view['alum_discapacidad'];?>" <?= ($alum_view['alum_tiene_discapacidad']==1?'':' disabled=true placeholder="No tiene"');?> >
    </div>
    <div class="form_element">
    	<label for="alum_condicionado">Condicionado:</label>
    	<input id="alum_condicionado" name="alum_condicionado" type="checkbox" <?= ($alum_view['alum_condicionado']==1 ? 'checked':'');?>  onclick="ActivarDesactivarText('alum_condicionado','alum_motivo_condicion')"/>
    </div>
    <div class="form_element">
    	<label for="alum_motivo_condicion">Motivo condición:</label>
    	<input id="alum_motivo_condicion" name="alum_motivo_condicion" type="text" value="<?=$alum_view['alum_motivo_condicion'];?>" <?= ($alum_view['alum_condicionado']==1?'':' disabled=true placeholder="No tiene"');?> >
    </div>
     <div class="form_element">
    	<label for="alum_conducta">Conducta anterior:</label>
        <? if ($alum_view['alum_conducta']=='') $alum_conducta=0; else $alum_conducta=$alum_view['alum_conducta']; ?> 
    	<input type="number" name="alum_conducta" id="alum_conducta" maxlength="2" min="1" max="10" step="1" value="<?=$alum_conducta;?>"
         onkeypress='numero_validacion(event,0,10)' onmouseout="if (this.value=='') this.value=0; "
        >
        
    </div>
    
    <div class="form_element">
    	<label for="alum_estado_civil_padres">Estado civil de padres:</label>
    	<input id="alum_estado_civil_padres" name="alum_estado_civil_padres" type="text" placeholder="Ingrese el estado civil de los padres..." value="<?=$alum_view['alum_estado_civil_padres'];?>">
    </div>
    <div class="form_element">
    	<label for="alum_ultimo_anio">Último año de estudio:</label>
    	<input id="alum_ultimo_anio" name="alum_ultimo_anio" type="text" placeholder="Ingrese último año de estudio del alumno..." value="<?=$alum_view['alum_ultimo_anio'];?>">
    </div>
    <div class="form_element">
    	<label for="alum_movilizacion">Movilización:</label>
    	<input id="alum_movilizacion" name="alum_movilizacion" type="text" placeholder="Ingrese como se moviliza el alumno..." value="<?=$alum_view['alum_movilizacion'];?>">
    </div>
	<script>
	function verif_usua(text){
		load_ajax('div_veri_alum','script_alum.php','opc=veri_usua&alum_usua='+text);
	}
	</script>
    <div class="form_element">
    	<label for="alum_usua">Usuario Web:</label>
    	<input id="alum_usua" name="alum_usua" type="text" <?php if ($alum_view['alum_codi']!=""){?>disabled="disabled"<? }?> placeholder="Ingrese el usuario web para el alumno..." value="<?=$alum_view['alum_usua'];?>" onkeyup="verif_usua(this.value);" onClick="verif_usua(this.value);" >
        <div id="div_veri_alum" style="float:none;">&nbsp;</div>
    </div>  
    <div class="form_element">
                <label for="alum_estado">Estado:</label>
                <?php 
                    include ('../framework/dbconf.php');        
                    $params = array();
                    $sql="{call alum_esta_view()}";
                    $stmt = sqlsrv_query($conn, $sql, $params);
            
                    if( $stmt === false )
                    {
                        echo "Error in executing statement .\n";
                        die( print_r( sqlsrv_errors(), true));
                    }
                    $seleccionado="";
                    echo '<select id="sl_estado" name="sl_estado">';
                    echo '<option value="">SELECCIONE</option>';
                    while($estado_view= sqlsrv_fetch_array($stmt))
                    {
                        if($estado_view["codigo"]==$alum_view['alum_estado'])
                        {
                            $seleccionado="selected";
                        }else{
                            $seleccionado="";
                        }
                        echo '<option '.$seleccionado.' value="'.$estado_view['codigo'].'">'.$estado_view["descripcion"].'</option>';
                    }
                    echo '</select>';
                ?> 
    </div>
    <div id="opcion82"  <?php if (permiso_activo(82)) echo 'style="display:block;"'; else  echo 'style="display:none;"';?>  >
            <div class="form_element" style="width:100%;">
                Información de Responsabilidad Económica 
            </div> 
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
                    
                    echo '<select id="sl_form_pago" name="sl_form_pago" onchange="CargarBancosTarjetas(this.value);" >';
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
                    echo '<select id="sl_banco_tarjeta" name="sl_banco_tarjeta" '.$deshabilitado.'>';
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
                <label for="alum_resp_form_banc_tarj_nume">Numero Cuenta o Tarjeta</label>
                <input id="alum_resp_form_banc_tarj_nume" name="alum_resp_form_banc_tarj_nume" type="text" placeholder="Ingrese numero de Cuenta o Tarjeta..." value="<?=$alum_view['alum_resp_form_banc_tarj_nume'];?>">
            </div>
            <div class="form_element">
                <label for="lbl_tipo">Tipo de Cuenta:<br/>
                    <input id="cta_corriente" type="radio" name="tipo_cuenta" value="CORRIENTE" checked />CUENTA CORRIENTE
                    <input id="cta_ahorro" type="radio" name="tipo_cuenta" value="AHORROS" />CUENTA DE AHORROS
                </label>
            </div>
            <div class="form_element">
                <label for="alum_resp_form_cedu">Cedula del Propietario de la  Cuenta:</label>
                <input id="alum_resp_form_cedu" name="alum_resp_form_cedu" type="text" placeholder="Ingrese cédula..." value="<?=$alum_view['alum_resp_form_cedu'];?>">
            </div>
            <div class="form_element">
                <label for="alum_resp_form_nomb">Nombres del Propietario de la  Cuenta:</label>
                <input id="alum_resp_form_nomb" name="alum_resp_form_nomb" type="text" placeholder="Ingrese nombres y apellidos ..." value="<?=$alum_view['alum_resp_form_nomb'];?>">
            </div>
            <br/>
            </div>
            
            <div id="opcion100"  <?php if (permiso_activo(100)) echo 'style="display:block; padding-bottom: 0;"'; else  echo 'style="display:none;"';?>  >
    		<div class="form_element" style="width:100%;">
                Descuentos
            </div>
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
					                
                    echo '<select id="alum_desc_tipo" name="alum_desc_tipo">';
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
                <input id="alum_desc_porcentaje" name="alum_desc_porcentaje" type="text" placeholder="0.00" value="<?php if($alum_view['alum_desc_porcentaje']==NULL){echo "0.00";}else{echo $alum_view['alum_desc_porcentaje'];}?>" onkeypress="return validaNumeros(event, this);">
            </div>
            <br/>
            </div>




            <div id="opcion101"  <?php if (permiso_activo(101)) echo 'style="display:block; padding-bottom: 0;"'; else  echo 'style="display:none;"';?>  >
            <div class="form_element" style="width:100%;">
                Grupo económico
            </div>
            <div class="form_element">
                <label for="alum_grup_econ">Grupo económico:</label>
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
                                    
                    echo '<select id="sl_alum_grup_econ" name="sl_alum_grup_econ">';
                    echo '<option value="0">SELECCIONE</option>';
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
            <br/>
            </div>
	</div>
</form>
</div>
</div>

<script>
	function CargarBancosTarjetas (codigo)
	{
		var xmlhttp;

		if (window.XMLHttpRequest)
		{
			xmlhttp = new XMLHttpRequest ();
		}
		else
		{
			xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');
		}

		xmlhttp.onreadystatechange = function ()
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				document.getElementById('lbl_banco_tarjeta').innerHTML=xmlhttp.responseText;
			}
		}

		xmlhttp.open("GET", "select_banco_tarjeta.php?idpadre="+codigo, true);
		xmlhttp.send();
	}
</script>