<div class="alumnos_add_script">

<?php  
session_start();
include ('../framework/dbconf.php');
if(isset($_POST['alum_codi']))
{
	$alum_codi=$_POST['alum_codi'];
}else
{
	if(isset($_GET['alum_codi']))
	{
		$alum_codi=$_GET['alum_codi'];
	}
	else
	{
		$alum_codi=0;
	}
}


$params = array($alum_codi);
$sql="{call alum_info(?)}";
$stmt = sqlsrv_query($conn, $sql, $params);
if( $stmt === false ){
	echo "Error in executing statement .\n";die( print_r( sqlsrv_errors(), true));
} 
$alum_view= sqlsrv_fetch_array($stmt);
?>
<div id="div_noti">&nbsp;</div>
<div id="div_blacklist_warning" style=""></div>
<div class="alumnos_add_script">
<form id="frm_alum" name="frm_alum" action="" enctype="multipart/form-data" method="post">
<input id="alum_codi" name="alum_codi" type="hidden" value="<?=$alum_view['alum_codi'];?>">
<input id="hd_user_verified" name="hd_user_verified" type="hidden" value="0"><!--verifica si usuario web es válido-->
<div class="picture">

    <div class="selector">
        <?php
    	$file_exi=$_SESSION['ruta_foto_alumno'].$alum_view['alum_codi'].'.jpg';

    	if (file_exists($file_exi)) {
    		$pp=$file_exi;
    	} else {
    		$pp=$_SESSION['foto_default'];
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
                <button id="btn_inscribir" name="btn_inscribir" type="button" onClick="load_ajax_add_alum('div_noti','script_alum.php','opc=add&alum_nomb='+document.getElementById('alum_nomb').value+'&alum_apel='+document.getElementById('alum_apel').value+'&alum_fech_naci='+document.getElementById('alum_fech_naci').value+'&alum_cedu='+document.getElementById('alum_cedu').value+'&alum_tipo_iden='+document.getElementById('alum_tipo_iden').options[document.getElementById('alum_tipo_iden').selectedIndex].value+'&alum_mail='+document.getElementById('alum_mail').value+'&alum_celu='+document.getElementById('alum_celu').value+'&alum_domi='+document.getElementById('alum_domi').value+'&alum_telf='+document.getElementById('alum_telf').value+'&alum_ciud='+document.getElementById('alum_ciud').value+'&alum_pais='+document.getElementById('alum_pais').value+'&alum_telf_emerg='+document.getElementById('alum_telf_emerg').value+'&alum_ex_plantel='+document.getElementById('alum_ex_plantel').value+'&alum_usua='+document.getElementById('alum_usua').value+'&alum_parroq='+document.getElementById('alum_parroq').value+'&alum_vive_con='+document.getElementById('alum_vive_con').value+'&alum_movilizacion='+document.getElementById('alum_movilizacion').value+'&alum_motivo_cambio='+document.getElementById('alum_motivo_cambio').value+'&alum_discapacidad='+document.getElementById('alum_discapacidad').value+'&alum_condicionado='+document.getElementById('alum_condicionado').checked+'&alum_conducta='+document.getElementById('alum_conducta').value+'&alum_ultimo_anio='+document.getElementById('alum_ultimo_anio').value+'&alum_nacionalidad='+document.getElementById('alum_nacionalidad').value+'&alum_motivo_condicion='+document.getElementById('alum_motivo_condicion').value+'&alum_resp_form_pago='+document.getElementById('sl_form_pago').value+'&alum_resp_form_banc_tarj='+document.getElementById('sl_banco_tarjeta').value+'&alum_resp_form_banc_tarj_nume='+document.getElementById('alum_resp_form_banc_tarj_nume').value+'&alum_resp_form_banc_tipo='+(document.getElementById('cta_corriente').checked?'C':'A')+'&alum_resp_form_cedu='+document.getElementById('alum_resp_form_cedu').value+'&alum_resp_form_nomb='+document.getElementById('alum_resp_form_nomb').value+'&alum_grup_econ='+document.getElementById('sl_alum_grup_econ').value+'&alum_tiene_discapacidad='+document.getElementById('alum_tiene_discapacidad').checked+'&alum_genero='+document.getElementById('alum_hombre').checked+'&idreligion='+document.getElementById('alum_religion').value+'&idparentescovivecon='+document.getElementById('alum_parentesco_vive_con').value+'&idestadocivilpadres='+document.getElementById('alum_estado_civil_padres').value+'&alum_activ_deportiva='+document.getElementById('alum_activ_deportiva').value+'&alum_activ_artistica='+document.getElementById('alum_activ_artistica').value+'&alum_resp_form_fech_vcto='+document.getElementById('alum_resp_form_fech_vcto').value+'&alum_enfermedades='+document.getElementById('alum_enfermedades').value+'&alum_banc_emisor='+document.getElementById('sl_banco_emisor').value+'&alum_parentesco_emerg='+document.getElementById('alum_parentesco_emerg').value+'&alum_pers_emerg='+document.getElementById('alum_pers_emerg').value+'&alum_tipo_sangre='+document.getElementById('alum_tipo_sangre').value+'&alum_resp_form_tipo_iden='+document.getElementById('alum_resp_form_tipo_iden').options[document.getElementById('alum_resp_form_tipo_iden').selectedIndex].value,'alum_codi');">Inscribir</button>
            </li>
            <?php }else{?>
            <li>
                <button id="btn_guardar" name="btn_guardar" type="button" onClick="load_ajax_edit_alum('div_noti','script_alum.php','opc=edi&alum_codi='+document.getElementById('alum_codi').value+'&alum_nomb='+document.getElementById('alum_nomb').value+'&alum_apel='+document.getElementById('alum_apel').value+'&alum_fech_naci='+document.getElementById('alum_fech_naci').value+'&alum_cedu='+document.getElementById('alum_cedu').value+'&alum_tipo_iden='+document.getElementById('alum_tipo_iden').options[document.getElementById('alum_tipo_iden').selectedIndex].value+'&alum_mail='+document.getElementById('alum_mail').value+'&alum_celu='+document.getElementById('alum_celu').value+'&alum_domi='+document.getElementById('alum_domi').value+'&alum_telf='+document.getElementById('alum_telf').value+'&alum_ciud='+document.getElementById('alum_ciud').value+'&alum_pais='+document.getElementById('alum_pais').value+'&alum_telf_emerg='+document.getElementById('alum_telf_emerg').value+'&alum_ex_plantel='+document.getElementById('alum_ex_plantel').value+'&alum_usua='+document.getElementById('alum_usua').value+'&alum_parroq='+document.getElementById('alum_parroq').value+'&alum_vive_con='+document.getElementById('alum_vive_con').value+'&alum_movilizacion='+document.getElementById('alum_movilizacion').value+'&alum_motivo_cambio='+document.getElementById('alum_motivo_cambio').value+'&alum_discapacidad='+document.getElementById('alum_discapacidad').value+'&alum_condicionado='+document.getElementById('alum_condicionado').checked+'&alum_conducta='+document.getElementById('alum_conducta').value+'&alum_ultimo_anio='+document.getElementById('alum_ultimo_anio').value+'&alum_nacionalidad='+document.getElementById('alum_nacionalidad').value+'&alum_motivo_condicion='+document.getElementById('alum_motivo_condicion').value+'&alum_resp_form_pago='+document.getElementById('sl_form_pago').value+'&alum_resp_form_banc_tarj='+document.getElementById('sl_banco_tarjeta').value+'&alum_resp_form_banc_tarj_nume='+document.getElementById('alum_resp_form_banc_tarj_nume').value+'&alum_resp_form_banc_tipo='+(document.getElementById('cta_corriente').checked?'C':'A')+'&alum_resp_form_cedu='+document.getElementById('alum_resp_form_cedu').value+'&alum_resp_form_nomb='+document.getElementById('alum_resp_form_nomb').value+'&alum_grup_econ='+document.getElementById('sl_alum_grup_econ').value+'&alum_tiene_discapacidad='+document.getElementById('alum_tiene_discapacidad').checked+'&alum_genero='+document.getElementById('alum_hombre').checked+'&idreligion='+document.getElementById('alum_religion').value+'&idparentescovivecon='+document.getElementById('alum_parentesco_vive_con').value+'&idestadocivilpadres='+document.getElementById('alum_estado_civil_padres').value+'&alum_activ_deportiva='+document.getElementById('alum_activ_deportiva').value+'&alum_activ_artistica='+document.getElementById('alum_activ_artistica').value+'&alum_resp_form_fech_vcto='+document.getElementById('alum_resp_form_fech_vcto').value+'&alum_enfermedades='+document.getElementById('alum_enfermedades').value+'&alum_banc_emisor='+document.getElementById('sl_banco_emisor').value+'&alum_parentesco_emerg='+document.getElementById('alum_parentesco_emerg').value+'&alum_pers_emerg='+document.getElementById('alum_pers_emerg').value+'&alum_tipo_sangre='+document.getElementById('alum_tipo_sangre').value+'&alum_resp_form_tipo_iden='+document.getElementById('alum_resp_form_tipo_iden').options[document.getElementById('alum_resp_form_tipo_iden').selectedIndex].value);">Guardar</button>
            </li>   
            <?php }?>  
            <?php if (permiso_activo(21)){?>
            <li>
                <button id="btn_repre" name="btn_repre" type="button" onclick="window.location='representantes_add.php?alum_codi='+document.getElementById('alum_codi').value;"  <?php if ($alum_view['alum_codi']==""){?>style="display:none;"<? }?> >Familiares</button>
            </li>
            <?php }?>
            <li>
                <button id="btn_cancelar" name="btn_cancelar" type="reset">Cancelar</button>
            </li>
            <li>
                <button id="btn_regresar" name="btn_regresar" type="button" onclick="window.history.back();">Regresar</button>
            </li>
        </ul>
    </div>
    <div  id="alum_bloq_view">
    
    </div>
</div>


<div class="data"> 
	<ul class="nav nav-tabs">    
	  <li class="active"><a href="#tab1" data-toggle="tab" onClick=""><span class="icon-signup icon"></span> Datos personales</a></li>
	  <li><a href="#tab2" data-toggle="tab" onClick=""><span class="icon-books icon"></span> Datos académicos</a></li>
	 <li><a href="#tab3" data-toggle="tab" onClick=""><span class="icon-parent icon"></span> Débito Bancario</a></li>
	 <li><a href="#tab4" data-toggle="tab" onClick=""><span class="icon-phone icon"></span> Emergencia</a></li>
	</ul> 	
	<div class="tab-content">
		<div class="tab-pane active" id="tab1">
			<div class="form_element">
				<label for="alum_nomb">(*)Nombres:</label>
				<input id="alum_nomb" name="alum_nomb" type="text" placeholder="Ingrese los nombres del alumno..." value="<?=$alum_view['alum_nomb'];?>"  onkeyup="alum_bloq_view(); new_username ();" onchange="load_ajax_blacklist_warning('div_blacklist_warning','script_alumnos_blacklist.php','warning_blacklist' );">
			</div>
			<div class="form_element">
				<label for="alum_apel">(*)Apellidos:</label>
				<input id="alum_apel" class="input" name="alum_apel" type="text" placeholder="Ingrese los apellidos del alumno..." value="<?=$alum_view['alum_apel'];?>" onkeyup="alum_bloq_view(); new_username ();" onchange="load_ajax_blacklist_warning('div_blacklist_warning','script_alumnos_blacklist.php','warning_blacklist' );">
			</div>
			<div class="form_element">
				<label for="alum_usua">(*)Usuario Web:</label>
				<input id="alum_usua" name="alum_usua" type="text" <?php if ($alum_view['alum_codi']!=""){?>disabled="disabled"<? }?> placeholder="Ingrese el usuario web para el alumno..." value="<?=$alum_view['alum_usua'];?>" onkeyup="verif_usua(this.value);" onClick="verif_usua(this.value);" >
			</div>
			<div class="form_element">
				<label for="div_veri_alum">&nbsp;</label>
				<div id="div_veri_alum" style="float:none;">&nbsp;</div>
			</div>
			<div class="form_element">
				<label for="alum_fech_naci">(*)Fecha de Nacimiento:</label>
				<input id="alum_fech_naci" name="alum_fech_naci" type="text" placeholder="Ingrese la fecha de nacimiento del alumno..." value="<?=date_format($alum_view['alum_fech_naci'],"d/m/Y");?>">
			</div>
			<div class="form_element">
				<label for="lbl_tipo">(*)Género:<br/>
					<input id="alum_hombre" type="radio" name="genero" value="Hombre" <?= ($alum_view['alum_genero']==1?' checked':'') ?> />
						<span style="margin-right: 50px">Masculino</span>
					<input id="alum_mujer" type="radio" name="genero" value="Mujer" <?= ($alum_view['alum_genero']==0?' checked':'') ?> />
						<span style="margin-right: 50px">Femenino</span>
				</label>
			</div>
			<div class="form_element">
				<label for="alum_cedu">Número de Identificación:</label>
				<input id="alum_cedu" name="alum_cedu" type="text" placeholder="Ingrese la c&eacute;dula del alumno..." value="<?=$alum_view['alum_cedu'];?>" onkeyup="alum_bloq_view()">
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
		            echo "<select id='alum_tipo_iden' name='alum_tipo_iden' >";
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
				<label for="alum_mail">Email:</label>
				<input id="alum_mail" name="alum_mail" type="text" placeholder="Ingrese el email del alumno..." value="<?=$alum_view['alum_mail'];?>">
			</div>
			<div class="form_element">
				<label for="alum_celu">Celular:</label>
				<input id="alum_celu" name="alum_celu" type="text" placeholder="Ingrese el celular del alumno..." value="<?=$alum_view['alum_celu'];?>">
			</div>
			<div class="form_element">
				<label for="alum_domi">(*)Domicilio:</label>
				<input id="alum_domi" name="alum_domi" type="text" placeholder="Ingrese el domicilio del alumno..." value="<?=$alum_view['alum_domi'];?>">
			</div>
			<div class="form_element">
				<label for="alum_telf">(*)Tel&eacute;fono:</label>
				<input id="alum_telf" name="alum_telf" type="text" placeholder="Ingrese el tel&eacute;fono del alumno..." value="<?=$alum_view['alum_telf'];?>">
			</div>
			<div class="form_element">
				<label for="alum_ciud">(*)Ciudad:</label>
				<input id="alum_ciud" name="alum_ciud" type="text" placeholder="Ingrese la ciudad del alumno..." value="<?=$alum_view['alum_ciud'];?>">
			</div>
			<div class="form_element">
				<label for="alum_parroq">Parroquia:</label>
				<input id="alum_parroq" name="alum_parroq" type="text" placeholder="Ingrese la parroquia del alumno..." value="<?=$alum_view['alum_parroquia'];?>">
			</div>
			<div class="form_element">
				<label for="alum_pais">(*)Pa&iacute;s donde naci&oacute;:</label>
				<input id="alum_pais" name="alum_pais" type="text" placeholder="Ingrese el pa&iacute;s del alumno..." value="<?=$alum_view['alum_pais'];?>">
			</div>
			<div class="form_element">
				<label for="alum_nacionalidad">(*)Nacionalidad</label>
				<input id="alum_nacionalidad" name="alum_nacionalidad" type="text" placeholder="Ingrese la nacionalidad del alumno..." value="<?=$alum_view['alum_nacionalidad'];?>">
			</div>
			<div class="form_element">
				<label for="alum_reli">Religi&oacute;n:</label>
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
                    echo '<select id="alum_religion" name="alum_religion">';
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
			</div>
			<div class="form_element">
				<label for="alum_vive_con">Vive con:</label>
				<input id="alum_vive_con" name="alum_vive_con" type="text" placeholder="Ingrese con quien vive el alumno..." value="<?=$alum_view['alum_vive_con'];?>">
			</div>
			<div class="form_element">
				<label for="alum_vive_con">Parentesco:</label>
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
                    echo '<select id="alum_parentesco_vive_con" name="alum_vive_con">';
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
				<label for="alum_tiene_discapacidad">Inclusi&oacute;n:</label>
				<input id="alum_tiene_discapacidad" name="alum_tiene_discapacidad" type="checkbox"   <?= ($alum_view['alum_tiene_discapacidad']==1 ? 'checked':'');?>  onclick="ActivarDesactivarText('alum_tiene_discapacidad','alum_discapacidad')" />
			</div>
			<div class="form_element">
				<label for="alum_discapacidad">Discapacidad:</label>
				<input id="alum_discapacidad" name="alum_discapacidad" type="text" value="<?=$alum_view['alum_discapacidad'];?>" <?= ($alum_view['alum_tiene_discapacidad']==1?'':' disabled=true placeholder="No tiene"');?> >
			</div>
			<div class="form_element">
				<label for="alum_estado_civil_padres">(*)Estado civil de padres:</label>
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
                    echo '<select id="alum_estado_civil_padres" name="alum_estado_civil_padres">';
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
				<input id="alum_movilizacion" name="alum_movilizacion" type="text" placeholder="Ingrese como se moviliza el alumno..." value="<?=$alum_view['alum_movilizacion'];?>">
			</div>
			<div class="form_element">
				<label for="alum_activ_deportiva">Disciplinas o deportes que practica:</label>
				<textarea id="alum_activ_deportiva" name="alum_activ_deportiva"><?=$alum_view['alum_activ_deportiva'];?></textarea>
			</div>
			<div class="form_element">
				<label for="alum_activ_artistica">Actividades artísticas que practica:</label>
				<textarea id="alum_activ_artistica" name="alum_activ_artistica"><?=$alum_view['alum_activ_artistica'];?></textarea>
			</div>
			<div class="form_element">
				<label for="alum_activ_artistica">Enfermedades, alergias, medicinas, prohibiciones, inhabilidades o tratamiento médico especial:</label>
				<textarea id="alum_enfermedades" name="alum_enfermedades"><?=$alum_view['alum_enfermedades'];?></textarea>
			</div>
			<div class="form_element">
				<label for="alum_tipo_sangre">Tipo de sangre:</label>
				<select id="alum_tipo_sangre" name="alum_tipo_sangre">
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
		<div class="tab-pane" id="tab2">
			<div class="form_element">
				<label for="alum_ex_plantel">Plantel procedente:</label>
				<input id="alum_ex_plantel" name="alum_ex_plantel" type="text" placeholder="Ingrese el plantel procedente del alumno..." value="<?=$alum_view['alum_ex_plantel'];?>">
			</div>
			<div class="form_element">
				<label for="alum_motivo_cambio">Motivo cambio:</label>
				<input id="alum_motivo_cambio" name="alum_motivo_cambio" type="text" placeholder="Ingrese motivo de cambio del alumno..." value="<?=$alum_view['alum_motivo_cambio'];?>">
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
				<label for="alum_ultimo_anio">Último año/curso de estudio:</label>
				<input id="alum_ultimo_anio" name="alum_ultimo_anio" type="text" placeholder="Ingrese último año de estudio del alumno..." value="<?=$alum_view['alum_ultimo_anio'];?>">
			</div>
			<div class="form_element">
				<label for="alum_conducta">Comportamiento anterior:</label>
				<input type="text" name="alum_conducta" id="alum_conducta" placeholder="Ingrese el comportamiento anterior..." value="<?=$alum_view['alum_conducta'];?>">
			</div>
			<div class="form_element">
				<label for="div_veri_alum">&nbsp;</label>
				<div id="div_veri_alum" style="float:none;">&nbsp;</div>
			</div>
		</div>
		<div class="tab-pane" id="tab3">
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
                    echo '<select id="sl_banco_emisor" name="sl_banco_emisor">';
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
                <label for="alum_resp_form_banc_tarj_nume">Número Cuenta o Tarjeta</label>
                <input id="alum_resp_form_banc_tarj_nume" name="alum_resp_form_banc_tarj_nume" type="text" placeholder="Ingrese numero de Cuenta o Tarjeta..." value="<?=$alum_view['alum_resp_form_banc_tarj_nume'];?>">
            </div>
			<div class="form_element">
				<label for="alum_resp_form_fech_vcto">Fecha de Vencimiento de Tarjeta:</label>
				<input id="alum_resp_form_fech_vcto" name="alum_resp_form_fech_vcto" type="text" placeholder="Ingrese la fecha de vencimiento de la tarjeta..." value="<?=date_format($alum_view['alum_resp_form_fech_vcto'],"d/m/Y");?>">
			</div>
            <div class="form_element">
                <label for="lbl_tipo">Tipo de Cuenta:<br/>
                    <input id="cta_corriente" type="radio" name="tipo_cuenta" value="CORRIENTE" <?=($alum_view['alum_resp_form_banc_tipo']=="C"?"checked":"")?> />CUENTA CORRIENTE
                    <input id="cta_ahorro" type="radio" name="tipo_cuenta" value="AHORROS" <?=($alum_view['alum_resp_form_banc_tipo']=="A"?"checked":"")?> />CUENTA DE AHORROS
                </label>
            </div>
            <div class="form_element">
                <label for="alum_resp_form_cedu">Número de Idetificación del Propietario de la  Cuenta:</label>
                <input id="alum_resp_form_cedu" name="alum_resp_form_cedu" type="text" placeholder="Ingrese cédula..." value="<?=$alum_view['alum_resp_form_cedu'];?>">
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
		            echo "<select id='alum_resp_form_tipo_iden' name='alum_resp_form_tipo_iden' >";
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
                <input id="alum_resp_form_nomb" name="alum_resp_form_nomb" type="text" placeholder="Ingrese nombres y apellidos ..." value="<?=$alum_view['alum_resp_form_nomb'];?>">
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
					                
                    echo '<select id="alum_desc_tipo" name="alum_desc_tipo" onChange="carga_dscto(this.value,'."'".$_GET['alum_codi']."'".')">';
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
            </div>-->
            <div id="opcion101"  <?php if (permiso_activo(101)) echo 'style="display:block; padding-bottom: 0;"'; else  echo 'style="display:none;"';?>  >
            <div class="form_element">
                <label for="alum_grup_econ">(*)Grupo económico:</label>
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
			<div class="tab-pane" id="tab4">
				<div class="form_element">
					<label for="alum_telf_emerg">(*)Tel&eacute;fono de emergencia:</label>
					<input id="alum_telf_emerg" name="alum_telf_emerg" type="text" placeholder="Ingrese el tel&eacute;fono de emergencia del alumno..." value="<?=$alum_view['alum_telf_emerg'];?>">
				</div>
				<div class="form_element">
					<label for="alum_emer_parentesco">(*)Parentesco:</label>
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
						echo '<select id="alum_parentesco_emerg" name="alum_parentesco_emerg">';
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
					<label for="alum_pers_emerg">(*)Nombre de persona:</label>
					<input id="alum_pers_emerg" name="alum_pers_emerg" type="text" placeholder="Ingrese el nombre del contacto de emergencia..." value="<?=$alum_view['alum_pers_emerg'];?>">
				</div>
			</div>
			</div>
	</div>
</form>
</div>
</div>

<script>
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