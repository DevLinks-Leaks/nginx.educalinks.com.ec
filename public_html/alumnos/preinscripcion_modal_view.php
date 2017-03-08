<?php
	include("../framework/dbconf.php");

	$sql_opc = "{call repr_info(?)}";
	$params_opc= array($_POST['repr_codi']);
	$repr_info = sqlsrv_query( $conn, $sql_opc,$params_opc);

	$row_repr_info = sqlsrv_fetch_array($repr_info);
?>
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
	<h4 class="modal-title" id="title_repr">Representante: <?=$alum_esta_info['row_repr_info'].' '.$alum_esta_info['row_repr_info']?></h4>
</div>
<div id="modal_repr" class="modal-body" >
	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<label for="repr_nomb">(*)Nombres:</label>
				<input class="form-control" id="repr_nomb" name="repr_nomb" type="text" placeholder="Ingresar nombres" value="<?=$row_repr_info['repr_nomb'];?>">
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label for="repr_apel">(*)Apellidos:</label>
				<input class="form-control" id="repr_apel" name="repr_apel" type="text" placeholder="Ingresar apellidos" value="<?=$row_repr_info['repr_apel'];?>">
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label for="repr_email">(*)Correo:</label>
				<input class="form-control" id="repr_email" name="repr_email" type="text" placeholder="Ingresar correo" value="<?=$row_repr_info['repr_email'];?>">
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label for="repr_telf">(*)Núm. Teléfono:</label>
				<input class="form-control" id="repr_telf" name="repr_telf" type="text" placeholder="Ingresar número convencional" value="<?=$row_repr_info['repr_telf'];?>">
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label for="repr_celular">(*)Núm. Celular:</label>
				<input class="form-control" id="repr_celular" name="repr_celular" type="text" placeholder="Ingresar número celular" value="<?=$row_repr_info['repr_celular'];?>">
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label for="repr_domi">Dirección:</label>
				<input class="form-control" id="repr_domi" name="repr_domi" type="text" placeholder="Ingresar dirección" value="<?=$row_repr_info['repr_domi'];?>">
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
				<input class="form-control" id="repr_fech_naci" name="repr_fech_naci" type="text" placeholder="Ingrese la fecha de nacimiento..." value="<?=date_format($row_repr_info['repr_fech_naci'],"d/m/Y");?>">
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label>País de Nacimiento:</label>
				<select onchange="CargarProvincias('repr_prov_naci',this.value);" class="form-control" id="repr_pais_naci" name="repr_pais_naci">
				<?php 
				$params = array();
				$sql="{call cata_pais_cons()}";
				$stmt = sqlsrv_query($conn, $sql, $params);
				while($pais_view= sqlsrv_fetch_array($stmt))
				{
					$seleccionado="";
					if ($pais_view["descripcion"]==$row_repr_info["repr_pais_naci"])
						$seleccionado="selected";
					echo '<option value="'.$pais_view["codigo"].'" '.$seleccionado.'>'.$pais_view["descripcion"].'</option>';
				}
				echo '</select>';
				?>
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label>Provincia de Nacimiento:</label>
				<select onchange="CargarCiudades('repr_ciud_naci',this.value);" class='form-control' id='repr_prov_naci' name='repr_prov_naci'>
				<?php 
				$params = array(null,$row_repr_info["repr_pais_naci"]);
				$sql="{call cata_provincia_cons(?,?)}";
				$stmt = sqlsrv_query($conn, $sql, $params);
		
				while($ciudad_view= sqlsrv_fetch_array($stmt))
				{
					$seleccionado="";
					if ($ciudad_view["descripcion"]==$row_repr_info["repr_prov_naci"])
						$seleccionado="selected";
					echo '<option value="'.$ciudad_view["codigo"].'" '.$seleccionado.'>'.$ciudad_view["descripcion"].'</option>';
				}
				echo '</select>';
				?>
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label>Ciudad de Nacimiento:</label>
				<select class='form-control' id='repr_ciud_naci' name='repr_ciud_naci'>
				<?php 
				$params = array(null,$row_repr_info["repr_prov_naci"]);
				$sql="{call cata_ciudad_cons(?,?)}";
				$stmt = sqlsrv_query($conn, $sql, $params);
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
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label for="repr_nacionalidad">Nacionalidad:</label>
				<input class="form-control" id="repr_nacionalidad" name="repr_nacionalidad" type="text" placeholder="Ingresar nacionalidad" value="<?=$row_repr_info['repr_nacionalidad'];?>">
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label for="repr_profesion">Profesión o Título Académico:</label>
				<input class="form-control" id="repr_profesion" name="repr_profesion" type="text" placeholder="Ingresar profesión" value="<?=$row_repr_info['repr_profesion'];?>">
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label for="repr_lugar_trabajo">Nombre de empresa o lugar de trabajo:</label>
				<input class="form-control" id="repr_lugar_trabajo" name="repr_lugar_trabajo" type="text" placeholder="Ingresar lugar de trabajo" value="<?=$row_repr_info['repr_lugar_trabajo'];?>">
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label for="repr_direc_trabajo">Dirección de trabajo:</label>
				<input class="form-control" id="repr_direc_trabajo" name="repr_direc_trabajo" type="text" placeholder="Ingresar dirección de trabajo" value="<?=$row_repr_info['repr_direc_trabajo'];?>">
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
		    	<label for="repr_telf_trab">Teléfono de Trabajo:</label>
		    	<input id="repr_telf_trab" class="form-control" name="repr_telf_trab" type="text" placeholder="Teléfono de Trabajo:" value="<?=$row_repr_info['repr_telf_trab'];?>">
	    	</div>
	    </div>
		<div class="col-md-6">
			<div class="form-group">
				<label for="repr_cargo">Cargo que desempeña:</label>
				<input class="form-control" id="repr_cargo" name="repr_cargo" type="text" placeholder="Ingresar cargo" value="<?=$row_repr_info['repr_cargo'];?>">
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
					if ($religion_view["codigo"]==$row_repr_info["idreligion"])
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
				<input class="form-control" id="repr_estudios" name="repr_estudios" type="text" placeholder="Ingresar nivel de estudios" value="<?=$row_repr_info['repr_estudios'];?>">
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label for="repr_institucion">Institución:</label>
				<input class="form-control" id="repr_institucion" name="repr_institucion" type="text" placeholder="Ingresar institución" value="<?=$row_repr_info['repr_institucion'];?>">
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
		    	<label for="repr_fech_promoc">Año de promoción exalumno:</label>
		    	<input id="repr_fech_promoc" class="form-control" name="repr_fech_promoc" type="text" placeholder="Ingrese la fecha de promoción de exalumno" value="<?=date_format($row_repr_info['repr_fech_promoc'],"d/m/Y");?>"/>
	    	</div>
    	</div>
    	<div class="col-md-6">
	    	<div class="form-group">
	    		</br>
		    	<label for="repr_ex_alum">¿Es exalumno de la institución?</label>
		    	</br>
		    	<input id="repr_ex_alum" name="repr_ex_alum" type="checkbox" <?= ($row_repr_info['repr_ex_alum']==1 ? 'checked':'');?>/>
	    	</div>
	    </div>
		<div class="col-md-6">
			<div class="form-group">
				<label for="repr_motivo_representa">Razón por la cual representa (en caso de no ser padre o madre):</label>
				<input class="form-control" id="repr_motivo_representa" name="repr_motivo_representa" type="text" placeholder="Ingresar razón de representar" value="<?=$row_repr_info['repr_motivo_representa'];?>">
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
					
					<label for="repr_escolaborador">¿Es o fue colaborador de la institución?</label></br>
					<input id="repr_escolaborador" name="repr_escolaborador" type="checkbox" <?= ($row_repr_info['repr_escolaborador']==1 ? 'checked':'');?>/>
			</div>
		</div>
		
	</div>
	<div class="row">&nbsp;
	</div>
</div>
<div id='repr_footer' class="modal-footer">
	<button id="btn_guardar_repr" type='button' class='btn btn-success' data-dismiss='modal' onclick="actualizar_representante(<?= $_POST['repr_codi'];?>);">Guardar</button>
	<button type='button' class='btn btn-default' data-dismiss='modal' >Cerrar</button>
</div>