<?php
include("../framework/dbconf.php");
include("../framework/funciones.php");
	// if(isset($_POST['repr_codi'])){
		$repr_codi=$_POST['repr_codi'];
		$sql_opc = "{call repr_info(?)}";
		$params_opc= array($repr_codi);
		$repr_info = sqlsrv_query( $conn, $sql_opc,$params_opc);

		$row_repr_info = sqlsrv_fetch_array($repr_info);

		if($repr_codi>0){
		$f="repre_exist_edit('alert_repr','script_repr.php');";
			$disabled='';
		}elseif($repr_codi==0){
			$disabled='';
		}else{
			$disabled='disabled';
		}
	// }

?>
<div class="row tab-pane active" id="tab1" name="tab1">
	<div class="col-md-6">
		<div class="form-group">
			<label for="repr_nomb">Nombres<span style="color:red;">*</span>:</label>
			<input class="form-control input-sm" id="repr_nomb" name="repr_nomb" type="text" placeholder="Ingresar nombres" value="<?=$row_repr_info['repr_nomb'];?>" <?=$disabled?> >
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label for="repr_apel">Apellidos<span style="color:red;">*</span>:</label>
			<input class="form-control input-sm" id="repr_apel" name="repr_apel" type="text" placeholder="Ingresar apellidos" value="<?=$row_repr_info['repr_apel'];?>" <?=$disabled?> >
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
			echo '<select class="form-control input-sm" id="idestadocivil" name="idestadocivil" '.$disabled.'>';
			while($esta_civil_padr_view= sqlsrv_fetch_array($stmt))
			{
				$seleccionado="";
				if ($esta_civil_padr_view["codigo"]==$row_repr_info["idestadocivil"])
					$seleccionado="selected";
				echo '<option value="'.$esta_civil_padr_view["codigo"].'" '.$seleccionado.'>'.$esta_civil_padr_view["descripcion"].'</option>';
			}
			echo '</select>';
			?> 
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label for="repr_fech_naci">Fecha de Nacimiento:</label>
			<input class="form-control input-sm" id="repr_fech_naci" name="repr_fech_naci" type="text" placeholder="Ingrese la fecha de nacimiento..." value="<?=date_format($row_repr_info['repr_fech_naci'],"d/m/Y");?>" <?=$disabled?> >
		</div>
	</div>
	<div class="form-group col-md-6">
		<label>País de Nacimiento:</label>
		<select class="form-control input-sm" onchange="CargarProvincias('repr_prov_naci',this.value);CargarCiudades('repr_ciud_naci',this.value);"  id="repr_pais_naci" name="repr_pais_naci" <?=$disabled?> >
		<?php 
		$params = array();
		$sql="{call cata_pais_cons()}";
		$stmt2 = sqlsrv_query($conn, $sql, $params);
		echo '<option value="">Seleccione</option>';
		while($pais_view= sqlsrv_fetch_array($stmt2))
		{
			$seleccionado="";
			if($row_repr_info['repr_pais_naci']==''){
				if ($pais_view["descripcion"]=='Ecuador')
					$seleccionado="selected";
			}else{
				if ($pais_view["descripcion"]==$row_repr_info["repr_pais_naci"])
					$seleccionado="selected";
			}
			echo '<option value="'.$pais_view["codigo"].'" '.$seleccionado.'>'.$pais_view["descripcion"].'</option>';
		}
		echo '</select>';
		?>
	</div>
	<div class="form-group col-md-6">
		<label>Provincia de Nacimiento:</label>
		<select class="form-control input-sm" onchange="CargarCiudades('repr_ciud_naci',this.value);" id='repr_prov_naci' name='repr_prov_naci' <?=$disabled?> >
		<?php 
		$params = array(null,($row_repr_info["repr_prov_naci"]==''?'Ecuador':$row_repr_info["repr_pais_naci"]));
		$sql="{call cata_provincia_cons(?,?)}";
		$stmt3 = sqlsrv_query($conn, $sql, $params);
		echo '<option value="">Seleccione</option>';
		while($ciudad_view= sqlsrv_fetch_array($stmt3))
		{
			$seleccionado="";
			if ($ciudad_view["descripcion"]==$row_repr_info["repr_prov_naci"])
				$seleccionado="selected";
			echo '<option value="'.$ciudad_view["codigo"].'" '.$seleccionado.'>'.$ciudad_view["descripcion"].'</option>';
		}
		echo '</select>';
		?>
	</div>
	<div class="form-group col-md-6">
		<label>Ciudad de Nacimiento:</label>
		<select class='form-control input-sm' id='repr_ciud_naci' name='repr_ciud_naci' <?=$disabled?> >
		<?php 
		$params = array(null,$row_repr_info["repr_prov_naci"]);
		$sql="{call cata_ciudad_cons(?,?)}";
		$stmt = sqlsrv_query($conn, $sql, $params);
		echo '<option value="">Seleccione</option>';
		while($ciudad_view= sqlsrv_fetch_array($stmt))
		{
			$seleccionado="";
			if ($ciudad_view["descripcion"]==$row_repr_info["repr_ciud_naci"])
				$seleccionado="selected";
			echo '<option value="'.$ciudad_view["codigo"].'" '.$seleccionado.'>'.$ciudad_view["descripcion"].'</option>';
		}
		echo '</select>';
		?>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label for="repr_nacionalidad">Nacionalidad:</label>
			<input class="form-control input-sm" id="repr_nacionalidad" name="repr_nacionalidad" type="text" placeholder="Ingresar nacionalidad" value="<?=$row_repr_info['repr_nacionalidad'];?>" <?=$disabled?> >
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
			echo '<select class="form-control input-sm" id="idreligion" name="idreligion" '.$disabled.'> ';
			while($religion_view= sqlsrv_fetch_array($stmt))
			{
				$seleccionado="";
				if ($religion_view["codigo"]==$row_repr_info["idreligion"])
					$seleccionado="selected";
				echo '<option value="'.$religion_view["codigo"].'" '.$seleccionado.'>'.$religion_view["descripcion"].'</option>';
			}
			echo '</select>';
			?>
		</div>
	</div>
</div>
<div class="row tab-pane" id="tab2" name="tab2">
	<div class="col-md-6">
		<div class="form-group">
			<label for="repr_email">Correo<span style="color:red;">*</span>:</label>
			<input class="form-control input-sm" id="repr_email" name="repr_email" type="text" placeholder="Ingresar correo" value="<?=$row_repr_info['repr_email'];?>" <?=$disabled?>>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label for="repr_telf">Núm. Teléfono:</label>
			<input class="form-control input-sm" id="repr_telf" name="repr_telf" type="text" placeholder="Ingresar número convencional" value="<?=$row_repr_info['repr_telf'];?>" <?=$disabled?>>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label for="repr_celular">Núm. Celular:</label>
			<input class="form-control input-sm" id="repr_celular" name="repr_celular" type="text" placeholder="Ingresar número celular" value="<?=$row_repr_info['repr_celular'];?>" <?=$disabled?>>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label for="repr_domi">Dirección:</label>
			<input class="form-control input-sm" id="repr_domi" name="repr_domi" type="text" placeholder="Ingresar dirección" value="<?=$row_repr_info['repr_domi'];?>" <?=$disabled?>>
		</div>
	</div>
</div>
<div class="row tab-pane" id="tab3" name="tab3">
	<div class="col-md-6">
		<div class="form-group">
			<label for="repr_profesion">Profesión o Título Académico:</label>
			<input class="form-control input-sm" id="repr_profesion" name="repr_profesion" type="text" placeholder="Ingresar profesión" value="<?=$row_repr_info['repr_profesion'];?>" <?=$disabled?>>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label for="repr_lugar_trabajo">Nombre de empresa o lugar de trabajo:</label>
			<input class="form-control input-sm" id="repr_lugar_trabajo" name="repr_lugar_trabajo" type="text" placeholder="Ingresar lugar de trabajo" value="<?=$row_repr_info['repr_lugar_trabajo'];?>" <?=$disabled?>>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label for="repr_direc_trabajo">Dirección de trabajo:</label>
			<input class="form-control input-sm" id="repr_direc_trabajo" name="repr_direc_trabajo" type="text" placeholder="Ingresar dirección de trabajo" value="<?=$row_repr_info['repr_direc_trabajo'];?>" <?=$disabled?>>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
	    	<label for="repr_telf_trab">Teléfono de Trabajo:</label>
	    	<input id="repr_telf_trab" class="form-control input-sm" name="repr_telf_trab" type="text" placeholder="Teléfono de Trabajo:" value="<?=$row_repr_info['repr_telf_trab'];?>" <?=$disabled?>>
    	</div>
    </div>
	<div class="col-md-6">
		<div class="form-group">
			<label for="repr_cargo">Cargo que desempeña:</label>
			<input class="form-control input-sm" id="repr_cargo" name="repr_cargo" type="text" placeholder="Ingresar cargo" value="<?=$row_repr_info['repr_cargo'];?>" <?=$disabled?>>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label for="repr_estudios">Nivel de estudios:</label>
			<input class="form-control input-sm" id="repr_estudios" name="repr_estudios" type="text" placeholder="Ingresar nivel de estudios" value="<?=$row_repr_info['repr_estudios'];?>" <?=$disabled?>>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label for="repr_institucion">Institución:</label>
			<input class="form-control input-sm" id="repr_institucion" name="repr_institucion" type="text" placeholder="Ingresar institución" value="<?=$row_repr_info['repr_institucion'];?>" <?=$disabled?>>
		</div>
	</div>
</div>
<div class="tab-pane" id="tab4" name="tab4">
	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
		    	<label for="repr_fech_promoc">Año de promoción exalumno:</label>
		    	<input id="repr_fech_promoc" class="form-control input-sm" name="repr_fech_promoc" type="text" placeholder="Ingrese la fecha de promoción de exalumno" value="<?=date_format($row_repr_info['repr_fech_promoc'],"d/m/Y");?>"<?=$disabled?> />
	    	</div>
		</div>
		<div class="col-md-6">
	    	<div class="form-group">
	    		</br>
		    	<label for="repr_ex_alum">¿Es exalumno de la institución?</label>
		    	</br>
		    	<input id="repr_ex_alum" name="repr_ex_alum" type="checkbox" <?= ($row_repr_info['repr_ex_alum']==1 ? 'checked':'');?> <?=$disabled?>/>
	    	</div>
	    </div>
		<div class="col-md-6">
			<div class="form-group">
				<label for="repr_motivo_representa">Razón por la cual representa (en caso de no ser padre o madre):</label>
				<input class="form-control input-sm" id="repr_motivo_representa" name="repr_motivo_representa" type="text" placeholder="Ingresar razón de representar" value="<?=$row_repr_info['repr_motivo_representa'];?>" <?=$disabled?>>
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
					
					<label for="repr_escolaborador">¿Es o fue colaborador de la institución?</label></br>
					<input id="repr_escolaborador" name="repr_escolaborador" type="checkbox" <?= ($row_repr_info['repr_escolaborador']==1 ? 'checked':'');?> <?=$disabled?>/>
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
            if ($row["id"] == $row_repr_info["ident_niv_1"])
                $seleccionado = "selected";
            echo '<option value="'.$row["id"].'" '.$seleccionado.'>'.$row["nombre"].'</option>';
        }
        echo '</select>';
        ?>
        </div>

        <div class="form-group col-md-6">
            <label>Nivel 2: </label>
            <select id="identificacion_niv_2" class="form-control input-sm" name="identificacion_niv_2" onchange="CargarIdentNiv3(this.value)" <?=$disabled?>>
                <?
                if ($row_repr_info['repr_nomb'] != ""){
                    $sql = "{call identificaciones_niv2_view(?)}";
                    $params = array($row_repr_info["ident_niv_1"]);
                    $stmt = sqlsrv_query( $conn, $sql,$params);
                    if( $stmt === false ){
                        echo "Error in executing statement .\n";
                        die( print_r( sqlsrv_errors(), true));
                    }
                    else{
                        echo '<option value="-1">Seleccione</option>';
                        while ($row = sqlsrv_fetch_array($stmt)){
                            $seleccionado = "";
                            if ($row["id"] == $row_repr_info["ident_niv_2"])
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
            <select id="identificacion_niv_3" class="form-control input-sm" name="identificacion_niv_3" <?=$disabled?>>
                <?
                if ($row_repr_info['repr_nomb'] != ""){
                    $sql = "{call identificaciones_niv3_view(?)}";
                    $params = array($row_repr_info["ident_niv_2"]);
                    $stmt = sqlsrv_query( $conn, $sql,$params);
                    if( $stmt === false ){
                        echo "Error in executing statement .\n";
                        die( print_r( sqlsrv_errors(), true));
                    }
                    else{
                        echo '<option value="-1">Seleccione</option>';
                        while ($row = sqlsrv_fetch_array($stmt)){
                            $seleccionado = "";
                            if ($row["id"] == $row_repr_info["ident_niv_3"])
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