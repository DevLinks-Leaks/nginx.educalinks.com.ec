<?php
session_start();
include ('../framework/dbconf.php');
include ('../framework/funciones.php');
include ('../framework/lenguaje.php');
if(isset($_POST['opc'])){$opc=$_POST['opc'];}else{$opc="";}
switch($opc){
	case 'repr_add':
		$repr_fech_promoc=substr($_POST['repr_fech_promoc'],6,4)."".substr($_POST['repr_fech_promoc'],3,2)."".substr($_POST['repr_fech_promoc'],0,2);
		$repr_fech_naci = substr($_POST['repr_fech_naci'],6,4)."".substr($_POST['repr_fech_naci'],3,2)."".substr($_POST['repr_fech_naci'],0,2);
		$es_colaborador = ($_POST['repr_escolaborador']=='true' ? 1 : 0 );
		$repr_ex_alum = ($_POST['repr_ex_alum']=='true' ? 1 : 0 );
		$sql_opc = "{call repr_add(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
		$params_opc= array( $_POST['repr_nomb'],
							$_POST['repr_apel'],
							$_POST['repr_cedula'],
							$_POST['repr_tipo_iden'],
							$_POST['repr_email'],
							$_POST['repr_telf'],
							$_POST['repr_domi'],
							$_POST['repr_estado_civil'],
							$_POST['repr_celular'],
							$_POST['alum_codi'],
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
							$repr_ex_alum,
							$repr_fech_promoc,
							$_POST['repr_telf_trab'],
							$repr_fech_naci,
							$_POST['repr_pais_naci'],
							$_POST['repr_prov_naci'],
							$_POST['repr_ciud_naci'],
                            $_POST['identificacion_niv_1'],
                            $_POST['identificacion_niv_2'],
                            $_POST['identificacion_niv_3']);
		$stmt_opc = sqlsrv_query( $conn, $sql_opc,$params_opc);
		if( $stmt_opc === false ){echo "Error in executing statement .\n";die( print_r( sqlsrv_errors(), true));} 
		
		$repr_view_opc=0;
		$repr_view_opc=lastId($stmt_opc);
		echo $repr_view_opc>0?"OK":"KO";
		
		//Para auditoría
		if ($repr_view_opc>0)
		{
			$detalle= lng_form_label('code').": ".$repr_view_opc;
			$detalle.= lng_form_label('name').": ".$_POST['repr_nomb'].' '.$_POST['repr_apel'];
			$detalle.= lng_form_label('id card').": ".$_POST['repr_cedula'];
			$detalle.= lng_form_label('email').": ".$_POST['repr_email'];
			$detalle.= lng_form_label('phone').": ".$_POST['repr_telf'];
			$detalle.= lng_form_label('cellphone').": ".$_POST['repr_celular'];
			$detalle.= lng_form_label('address').": ".$_POST['repr_domi'];
			$detalle.= lng_form_label('marital status').": ".$_POST['repr_estado_civil'];
			$detalle.= lng_form_label('relation').": ".$_POST['repr_parentesco'];
			$detalle.= lng_form_label('student code').": ".$_POST['alum_codi'];
			registrar_auditoria (16, $detalle);
		}
	break;
	case 'repr_upd':
		$repr_fech_promoc=substr($_POST['repr_fech_promoc'],6,4)."".substr($_POST['repr_fech_promoc'],3,2)."".substr($_POST['repr_fech_promoc'],0,2);
		$repr_fech_naci = substr($_POST['repr_fech_naci'],6,4)."".substr($_POST['repr_fech_naci'],3,2)."".substr($_POST['repr_fech_naci'],0,2);
		$es_colaborador = ($_POST['repr_escolaborador']=='true' ? 1 : 0 );
		$repr_ex_alum = ($_POST['repr_ex_alum']=='true' ? 1 : 0 );
		$sql_opc = "{call repr_upd(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
		$params_opc= array( $_POST['repr_nomb'],
							$_POST['repr_apel'],
							$_POST['repr_cedula'],
							$_POST['repr_tipo_iden'],
							$_POST['repr_email'],
							$_POST['repr_telf'],
							$_POST['repr_domi'],
							$_POST['repr_estado_civil'],
							$_POST['repr_celular'],
							$_POST['repr_codi'],
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
							$repr_ex_alum,
							$repr_fech_promoc,
							$_POST['repr_telf_trab'],
							$repr_fech_naci,
							$_POST['repr_pais_naci'],
							$_POST['repr_prov_naci'],
							$_POST['repr_ciud_naci'],
                            $_POST['identificacion_niv_1'],
                            $_POST['identificacion_niv_2'],
                            $_POST['identificacion_niv_3']);
		$stmt_opc = sqlsrv_query( $conn, $sql_opc,$params_opc);
		if( $stmt_opc === false ){echo "Error in executing statement .\n";die( print_r( sqlsrv_errors(), true));} 
		$repr_view_opc=0;
		$repr_view_opc=lastId($stmt_opc);
		echo $repr_view_opc>0?"OK":"KO";
		
		//Para auditoría
		if ($repr_view_opc>0)
		{
			$detalle = lng_form_label('code').": ".$repr_view_opc;
			$detalle.= lng_form_label('last name').": ".$_POST['repr_apel'];
			$detalle.= lng_form_label('id card').": ".$_POST['repr_cedula'];
			$detalle.= lng_form_label('email').": ".$_POST['repr_email'];
			$detalle.= lng_form_label('phone').": ".$_POST['repr_telf'];
			$detalle.= lng_form_label('cellphone').": ".$_POST['repr_celular'];
			$detalle.= lng_form_label('address').": ".$_POST['repr_domi'];
			$detalle.= lng_form_label('marital status').": ".$_POST['repr_estado_civil'];
			$detalle.= lng_form_label('last relation').": ".$_POST['repr_parentesco'];
			registrar_auditoria (17, $detalle);
		}
		
	break;
	case 'repr_del':
		$sql_opc = "{call repr_del(?)}";
		$params_opc= array($_POST['repr_codi']);
		$stmt_opc = sqlsrv_query( $conn, $sql_opc,$params_opc);
		if( $stmt_opc === false ){echo "Error in executing statement .\n";die( print_r( sqlsrv_errors(), true));} 
		$repr_view_opc=$_POST['repr_codi'];
		echo $repr_view_opc;
		
		//Para auditoría
		$detalle="Código: ".$_POST['repr_codi'];
		registrar_auditoria (18, $detalle);
	break;
	case 'repr_list':
		/*Para los parentescos*/
		$row_parentescos = array();
		$sql="{call parentescos_cons()}";
		$stmt = sqlsrv_query($conn, $sql);
		if( $stmt === false )
		{
			echo "Error in executing statement .\n";
			die( print_r( sqlsrv_errors(), true));
		}
		else
			if (sqlsrv_has_rows($stmt))
				while($row_parentescos[]= sqlsrv_fetch_array($stmt));
			array_pop($row_parentescos);
		
		$sql_opc = "{call repr_alum_info(?)}";
		$params_opc= array($_POST['alum_codi']);
		$stmt_opc = sqlsrv_query( $conn, $sql_opc,$params_opc);
		if( $stmt_opc === false ){echo "Error in executing statement .\n";die( print_r( sqlsrv_errors(), true));} ?>
		<table class="table_full">
        <tr>       
			<td style='text-align:center'><?php echo show_this_phrase(20000020); ?></td>
			<td style='text-align:center'><?php echo PrimeraMayuscula(show_this(10000015)); ?></td>
			<td style='text-align:center'>Rel.</td>
			<td style='text-align:center'><?php echo PrimeraMayuscula(lng_options('main guardian')); ?></td>
			<td style='text-align:center'><?php echo PrimeraMayuscula(lng_options('financial guardian')); ?></td>
			<td style='text-align:center'>Opciones.</td>
        </tr>
        <?php while($row_repr_view=sqlsrv_fetch_array($stmt_opc)){?>
        <tr>
		<td style='text-align:center'><?=$row_repr_view['repr_cedula'];?></td>
        <td style='text-align:center'><?= $row_repr_view['repr_nomb']." ".$row_repr_view['repr_apel'];?></td>
		<td style='text-align:center'>
		<select id="<?= $row_repr_view['repr_codi'];?>" onchange="update_relative('div_repr_list','script_repr.php','<?=$_POST['alum_codi']?>','<?=$row_repr_view['repr_codi']?>',this.value);">
		 <option value="0">Elija</option>
		 <?
		 $selected="";
		 foreach ($row_parentescos as $row_par)
		 {
			 if ($row_par["codigo"]==$row_repr_view["idparentesco"])
				 $selected="selected";
			 else
				 $selected="";
		 	echo "<option value='".$row_par["codigo"]."' $selected>".$row_par["descripcion"]."</option>";
		 }
		?>
		</select>
		</td>
		<td style='text-align:center'><input type="radio" name="principal" onclick="javascript:repr_upd_princ('div_repr_list','script_repr.php','<?=$_POST['alum_codi']?>','<?=$row_repr_view['repr_codi']?>');"
			title='<?php echo PrimeraMayuscula(lng_options('make primary')); ?>'
			<?php if($row_repr_view['repre_alum_princ']=='P'){echo " checked='checked' ";}?> /></td>
        <td style='text-align:center'><input type="radio" name="financiero"  onclick="javascript:repr_upd_princ_finan('div_repr_list','script_repr.php','<?=$_POST['alum_codi']?>','<?=$row_repr_view['repr_codi']?>');"
			title='<?php echo PrimeraMayuscula(lng_options('make financial primary')); ?>'
			<?php if($row_repr_view['repre_alum_fact']=='S'){echo " checked='checked' ";}?> /></td>
		<td>
			<div class="menu_options">
			<ul>
				<li>
				<a class="option" href="representantes_add.php?repr_codi=<?=$row_repr_view['repr_codi']?>"><span class="icon-pencil2 icon"></span> Editar</a>
				</li>
				<li>
				<a class="option" href="javascript:quitar_representado('script_repr.php','<?=$_POST['alum_codi']?>','<?=$row_repr_view['repr_codi']?>');"><span class="icon-remove icon"></span> Eliminar</a>
				</li>
			</ul>
			</div>
		</td>
		</tr>
		<?php }?>
        </table>

	<?php break;
	case 'vali_repr':
		$sql_opc = "{call repr_info_cedu_vali(?,?)}";
		$params_opc= array($_POST['repr_cedu'],$_POST['tipo_iden']);
		$stmt_opc = sqlsrv_query( $conn, $sql_opc,$params_opc);
		if( $stmt_opc === false ){echo "Error in executing statement .\n";die( print_r( sqlsrv_errors(), true));} 
		$row_repr_view=sqlsrv_fetch_array($stmt_opc);
		if ($row_repr_view['repr_cant']>0){
			echo 'OK';
		}else{
			$result_CI_valid = validarNI($_POST['repr_cedu'],$_POST['tipo_iden']);
			echo $result_CI_valid;
		}
	break;
	case 'upd_repr_princ':
		$sql_opc = "{call repr_alum_upd(?,?)}";
		$params_opc= array($_POST['alum_codi'],$_POST['repr_cedu']);
		$stmt_opc = sqlsrv_query( $conn, $sql_opc,$params_opc);
		if( $stmt_opc === false ){echo "Error in executing statement .\n";die( print_r( sqlsrv_errors(), true));} else {echo "1";} 
	break;
		case 'upd_repr_princ_finan':
		$sql_opc = "{call repr_finan_alum_upd(?,?)}";
		$params_opc= array($_POST['alum_codi'],$_POST['repr_cedu']);
		$stmt_opc = sqlsrv_query( $conn, $sql_opc,$params_opc);
		if( $stmt_opc === false ){echo "Error in executing statement .\n";die( print_r( sqlsrv_errors(), true));}  else {echo "1";}
	break;
	case 'remove_alum':
		$sql_opc = "{call repr_alum_del(?,?)}";
		$params_opc= array($_POST['alum_codi'],$_POST['repr_codi']);
		$stmt_opc = sqlsrv_query( $conn, $sql_opc,$params_opc);
		if( $stmt_opc === false ){echo "Error in executing statement .\n";die( print_r( sqlsrv_errors(), true));} 
	break;
	case 'update_relative':
		$sql_opc = "{call repr_parentesco_upd(?,?,?)}";
		$params_opc= array($_POST['alum_codi'],$_POST['repr_codi'],$_POST['idparentesco']);
		$stmt_opc = sqlsrv_query( $conn, $sql_opc,$params_opc);
		if( $stmt_opc === false ){echo "Error in executing statement .\n";die( print_r( sqlsrv_errors(), true));} 
		echo "Todo OK";
	break;
    case 'cargar_idenficacion_nivel_2':
        $data = array(); $res = ""; $msj = "";
        $sql = "{call identificaciones_niv2_view(?)}";
        $params = array($_POST['id']);
        $stmt = sqlsrv_query( $conn, $sql,$params);
        if( $stmt === false ){
            $res = "error";
            $msj = "Error en la conexión";
        }
        else{
            $res = "success";
            $msj = "Todo Ok";
            while ($row = sqlsrv_fetch_array($stmt))
                array_push($data,array("id"=>$row["id"], "nombre"=>$row["nombre"]));
        }
        print json_encode(array("res"=>$res, "msj"=>$msj, "data"=>$data));
    break;
    case 'cargar_idenficacion_nivel_3':
        $data = array(); $res = ""; $msj = "";
        $sql = "{call identificaciones_niv3_view(?)}";
        $params = array($_POST['id']);
        $stmt = sqlsrv_query( $conn, $sql,$params);
        if( $stmt === false ){
            $res = "error";
            $msj = "Error en la conexión";
        }
        else{
            $res = "success";
            $msj = "Todo Ok";
            while ($row = sqlsrv_fetch_array($stmt))
                array_push($data,array("id"=>$row["id"], "nombre"=>$row["nombre"]));
        }
        print json_encode(array("res"=>$res, "msj"=>$msj, "data"=>$data));
    break;
    case 'carga_data_repre':
		$sql_opc = "{call repr_info_cedu_form(?,?)}";
		$params_opc= array($_POST['repr_cedu'],$_POST['tipo_iden']);
		$stmt_opc = sqlsrv_query( $conn, $sql_opc,$params_opc);
		if( $stmt_opc === false ){echo "Error in executing statement .\n";die( print_r( sqlsrv_errors(), true));} 
		$row_repr_view=sqlsrv_fetch_array($stmt_opc);?>
		<div class="form_element">
    	<label for="repr_nomb">(*)<?php echo lng_form_label('name'); ?>:</label>
    	<input id="repr_nomb" name="repr_nomb" type="text" placeholder="<?php echo lng_form_ph('name'); ?>" value="<?=$row_repr_view['repr_nomb'];?>">
    	</div>
        <div class="form_element">
    	<label for="repr_apel">(*)<?php echo lng_form_label('last name'); ?>:</label>
    	<input id="repr_apel" name="repr_apel" type="text" placeholder="<?php echo lng_form_ph('last name'); ?>" value="<?=$row_repr_view['repr_apel'];?>">
    	</div>
        <div class="form_element">
    	<label for="repr_email">(*)<?php echo lng_form_label('email'); ?>:</label>
    	<input id="repr_email" name="repr_email" type="text" placeholder="<?php echo lng_form_ph('email'); ?>" value="<?=$row_repr_view['repr_email'];?>">
    	</div>
        <div class="form_element">
    	<label for="repr_telf">Núm. Teléfono:</label>
    	<input id="repr_telf" name="repr_telf" type="text" placeholder="<?php echo lng_form_ph('phone'); ?>" value="<?=$row_repr_view['repr_telf'];?>">
    	</div>
        <div class="form_element">
    	<label for="repr_celular">Núm. Celular:</label>
    	<input id="repr_celular" name="repr_celular" type="text" placeholder="<?php echo lng_form_ph('cellphone'); ?>" value="<?=$row_repr_view['repr_celular'];?>">
    	</div>
        <div class="form_element">
    	<label for="repr_domi">Dirección:</label>
    	<input id="repr_domi" name="repr_domi" type="text" placeholder="<?php echo lng_form_ph('address'); ?>" value="<?=$row_repr_view['repr_domi'];?>">
    	</div>
    	<div class="form_element">
    	<label for="idestadocivil"><?php echo lng_form_label('marital status'); ?>:</label>
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
                    echo '<select id="idestadocivil" name="idestadocivil">';
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
		<div class="form_element">
			<label for="repr_fech_naci">Fecha de Nacimiento:</label>
			<input  id="repr_fech_naci" name="repr_fech_naci" type="text" placeholder="Ingrese la fecha de nacimiento..." value="<?=date_format($row_repr_view['repr_fech_naci'],"d/m/Y");?>">
		</div>
		<div class="form_element">
			<label>País de Nacimiento:</label>
			<select onchange="CargarProvincias('repr_prov_naci',this.value);"  id="repr_pais_naci" name="repr_pais_naci">
			<?php 
			$params = array();
			$sql="{call cata_pais_cons()}";
			$stmt2 = sqlsrv_query($conn, $sql, $params);
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
		<div class="form_element">
			<label>Provincia de Nacimiento:</label>
			<select  onchange="CargarCiudades('repr_ciud_naci',this.value);" id='repr_prov_naci' name='repr_prov_naci'>
			<?php 
			$params = array(null,($row_repr_view["repr_prov_naci"]==''?'Ecuador':$row_repr_view["repr_pais_naci"]));
			$sql="{call cata_provincia_cons(?,?)}";
			$stmt3 = sqlsrv_query($conn, $sql, $params);
	
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
		<div class="form_element">
			<label>Ciudad de Nacimiento:</label>
			<select class='form-control' id='repr_ciud_naci' name='repr_ciud_naci'>
			<?php 
			$params = array(null,$row_repr_view["repr_prov_naci"]);
			$sql="{call cata_ciudad_cons(?,?)}";
			$stmt = sqlsrv_query($conn, $sql, $params);
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
		<div class="form_element">
    	<label for="repr_nacionalidad"><?php echo lng_form_label('nationality'); ?>:</label>
    	<input id="repr_nacionalidad" name="repr_nacionalidad" type="text" placeholder="<?php echo lng_form_ph('nationality'); ?>" value="<?=$row_repr_view['repr_nacionalidad'];?>">
    	</div>
        <div class="form_element">
    	<label for="repr_profesion">Profesión o Título Académico:</label>
    	<input id="repr_profesion" name="repr_profesion" type="text" placeholder="<?php echo lng_form_ph('profession'); ?>" value="<?=$row_repr_view['repr_profesion'];?>">
    	</div>
         <div class="form_element">
    	<label for="repr_lugar_trabajo">Nombre de empresa o lugar de trabajo:</label>
    	<input id="repr_lugar_trabajo" name="repr_lugar_trabajo" type="text" placeholder="<?php echo lng_form_ph('workplace'); ?>" value="<?=$row_repr_view['repr_lugar_trabajo'];?>">
    	</div>
         <div class="form_element">
    	<label for="repr_direc_trabajo"><?php echo lng_form_label('workaddress'); ?>:</label>
    	<input id="repr_direc_trabajo" name="repr_direc_trabajo" type="text" placeholder="<?php echo lng_form_ph('workaddress'); ?>" value="<?=$row_repr_view['repr_direc_trabajo'];?>">
    	</div>
    	<div class="form_element">
    	<label for="repr_telf_trab">Teléfono de Trabajo:</label>
    	<input id="repr_telf_trab" name="repr_telf_trab" type="text" placeholder="Teléfono de Trabajo:" value="<?=$row_repr_view['repr_telf_trab'];?>">
    	</div>
         <div class="form_element">
    	<label for="repr_cargo">Cargo que desempeña:</label>
    	<input id="repr_cargo" name="repr_cargo" type="text" placeholder="<?php echo lng_form_ph('charge'); ?>" value="<?=$row_repr_view['repr_cargo'];?>">
    	</div>
        <div class="form_element">
    	<label for="idreligion"><?php echo lng_form_label('religion'); ?>:</label>
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
                    echo '<select id="idreligion" name="idreligion">';
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
         <div class="form_element">
    	<label for="repr_estudios">Nivel de estudios:</label>
    	<input id="repr_estudios" name="repr_estudios" type="text" placeholder="<?php echo lng_form_ph('studies'); ?>" value="<?=$row_repr_view['repr_estudios'];?>">
    	</div>
          <div class="form_element">
    	<label for="repr_institucion"><?php echo lng_form_label('institution'); ?>:</label>
    	<input id="repr_institucion" name="repr_institucion" type="text" placeholder="<?php echo lng_form_ph('institution'); ?>" value="<?=$row_repr_view['repr_institucion'];?>">
    	</div>
    	<div class="form_element">
    	<label for="repr_fech_promoc">Año de promoción exalumno:</label>
    	<input id="repr_fech_promoc" name="repr_fech_promoc" type="text" placeholder="Ingrese la fecha de promoción de exalumno" value="<?=date_format($row_repr_view['repr_fech_promoc'],"d/m/Y");?>"/>
    	</div>
		<div class="form_element">
    	<label for="repr_ex_alum">¿Es exalumno de la institución?</label>
    	<input id="repr_ex_alum" name="repr_ex_alum" type="checkbox" <?= ($row_repr_view['repr_ex_alum']==1 ? 'checked':'');?>/>
    	</div>
         <div class="form_element">
    	<label for="repr_motivo_representa">Razón por la cual representa (en caso de no ser padre o madre):</label>
    	<input id="repr_motivo_representa" name="repr_motivo_representa" type="text" placeholder="<?php echo lng_form_ph('reason'); ?>" value="<?=$row_repr_view['repr_motivo_representa'];?>">
    	</div>
        
		<div class="form_element">
    	<label for="repr_estado_civil">¿Es o fue colaborador de la institución?</label>
    	<input id="repr_escolaborador" name="repr_escolaborador" type="checkbox" <?= ($row_repr_view['repr_escolaborador']==1 ? 'checked':'');?>/>
    	</div>

        <div style="<?= (para_sist(408)==0?'display: none':'')?>">
            <div class="form_element">
            <label>Nivel 1:</label>
            <?php
            include ('../framework/dbconf.php');
            $params = array();
            $sql="{call identificaciones_niv1_view()}";
            $stmt = sqlsrv_query($conn, $sql, $params);
            if( $stmt === false )
            {   echo "Error in executing statement .\n";
                die( print_r( sqlsrv_errors(), true));
            }
            echo '<select id="identificacion_niv_1" name="identificacion_niv_1" onchange="CargarIdentNiv2(this.value)">';
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

            <div class="form_element">
                <label>Nivel 2: </label>
                <select id="identificacion_niv_2" name="identificacion_niv_2" onchange="CargarIdentNiv3(this.value)">
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

            <div class="form_element">
                <label>Nivel 3:</label>
                <select id="identificacion_niv_3" name="identificacion_niv_3">
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
    	<div class="form_element"></div>
	<?php break;
	
}
?>