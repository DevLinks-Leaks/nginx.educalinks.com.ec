<!DOCTYPE html>
<html lang="es">
<?php include("template/head.php");?>
<body role="document">
<?php $active="ficha_ocupa";
include("template/navbar.php");
/*clases*/
/*scritps*/
include("scripts/constructor_combo_tipo_id.php");
include("scripts/constructor_combo_catalogo.php");
/*variables*/
$per_numero_identificacion = $per_nomb = $per_nomb_seg = $per_apel = $per_apel_mat = $per_dir = $per_telf = $per_fecha_nac = $per_email_personal = "";
?>
<div class="container-fluid theme-showcase" role="main">
<!-- =============================== -->
	<div class="row bottom_10" style='text-align:center;'>
		<h5>DEPARTAMENTO MÉDICO</h5>
		<h3><span class="glyphicon glyphicon-file"></span> FICHA MÉDICA OCUPACIONAL</h3>
		<hr>
	</div>
	<input type="hidden" name="per_codi" 	 id="per_codi" 	   value="{per_codi}" /> 
	<input type="hidden" name="per_empr_codi" id="per_empr_codi" value="{per_empr_codi}" /> 
	<input type="hidden" name="per_per_empr_codi" id="per_per_empr_codi" value="{per_per_empr_codi}" /> 
	<div class="grid">
		<div class="row">
			<div class="col-sm-6">
				<div class="input-group" style="width: 100%;">
					<span style="width: 25%; font-size:small;" class="input-group-addon" id="ficha_hosp_addon">Ficha Hosp.</span>
					<input type="text" class="form-control" id="ficha_hosp" name="ficha_hosp">
				</div>
			</div>
			<div class="col-sm-6">
				<div class="input-group" style="width: 100%;">
					<span style="width: 25%; font-size:small;" class="input-group-addon" id="fic_ocu_num_afil_iess_addon">No. Afili. IESS</span>
					<input type="text" class="form-control" id="fic_ocu_num_afil_iess" name="fic_ocu_num_afil_iess">
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<br>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-6">
				<label>DATOS DEL EMPLEADO/PACIENTE </label>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<br>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-6">
				<?php echo constructor_combo_tipo_id('cmb_per_tipo_identificacion', 1); //si trae datos, mandar tercer parámetro con el valor ?>
			</div>
			<div class="col-sm-6">
				<input type="text" class="form-control" name="per_numero_identificacion" id="per_numero_identificacion"  required="required" 
					value="<?php echo $per_numero_identificacion; ?>"
					placeholder="No. de identificaci&oacute;n" pattern="[a-zA-Z0-9]+"
					maxlength="20" />
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<br>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-6">
				<div class="input-group" style="width: 100%;">
					<span style="width: 25%; font-size:small;" class="input-group-addon" id="ficha_hosp_addon">Nombre</span>
					<input name="per_nomb" id="per_nomb"  type="text" class="form-control" value="<?php echo $per_nomb; ?>" placeholder="Nombre"
						pattern = "^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$" maxlength="60"/>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="input-group" style="width: 100%;">
					<span style="width: 25%; font-size:small;" class="input-group-addon" id="ficha_hosp_addon">Segundo Nombre</span>
					<input name="per_nomb_seg" id="per_nomb_seg"  type="text" class="form-control" value="<?php echo $per_nomb_seg; ?>"
						placeholder="Segundo nombre"
						pattern = "^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$" maxlength="60"/>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<br>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-6">
				<div class="input-group" style="width: 100%;">
					<span style="width: 25%; font-size:small;" class="input-group-addon" id="ficha_hosp_addon">Apellido paterno</span>
					<input name="per_apel" id="per_apel"  type="text" class="form-control" value="<?php echo $per_apel; ?>" 
						placeholder="Apellido paterno" 
						pattern = "^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$" maxlength="60"/>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="input-group" style="width: 100%;">
					<span style="width: 25%; font-size:small;" class="input-group-addon" id="ficha_hosp_addon">Apellido materno</span>
					<input name="per_apel_mat" id="per_apel_mat"  type="text" class="form-control" value="<?php echo $per_apel_mat; ?>" 
						placeholder="Apellido materno" 
						pattern = "^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$" maxlength="60"/>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<br>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<label>DIRECCIÓN Y TELÉFONO DE DOMICILIO </label>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<br>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-8">
				<div class="input-group" style="width: 100%;">
					<span style="width: 25%; font-size:small;" class="input-group-addon" id="ficha_hosp_addon">Dirección</span>
					<input name="per_dir" id="per_dir" type="text" class="form-control" 
						value="<?php echo $per_dir; ?>" placeholder="Dirección" maxlength="150"/>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="input-group" style="width: 100%;">
					<span style="width: 25%; font-size:small;" class="input-group-addon" id="ficha_hosp_addon">
						<span class='glyphicon glyphicon-phone-alt'></span>
					</span>
					<input name="per_telf" id="per_telf" type="text" class="form-control" value="<?php echo $per_telf; ?>" 
						placeholder="Teléfono" pattern='[0-9]+' maxlength="25"/>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<br>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-8"></div>
			<div class="col-sm-4">
				<div class="input-group" style="width: 100%;">
					<span style="width: 25%; font-size:small;" class="input-group-addon" id="ficha_hosp_addon">
						<span class='glyphicon glyphicon-envelope'></span></span>
					<input name="per_email_personal" id="per_email_personal"  type="text" class="form-control"
						value="<?php echo $per_email_personal; ?>"
						pattern = "^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$"
						maxlength="200"placeholder="Correo electrónico personal"/>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<br>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<label>FECHA Y LUGAR DE NACIMIENTO</label>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<br>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-3">
				<label>Fecha de nacimiento </label>
				<input name="per_fecha_nac" id="per_fecha_nac"  type="date" class="form-control" value="<?php echo $per_fecha_nac; ?>" placeholder="Fec. Nacimiento"/>
			</div>
			<div class="col-sm-3">
				<label>Pais</label>
				{cmb_pais_per_lugar_nac}
			</div>
			<div class="col-sm-3">
				<label>Provincia/Estado</label>
				<div id='div_provincia_per_lugar_nac' name='div_provincia_per_lugar_nac'>{cmb_provincia_per_lugar_nac}</div>
			</div>
			<div class="col-sm-3">
				<label>Ciudad</label>
				<div id='div_ciudad_per_lugar_nac' name='div_ciudad_per_lugar_nac'>{cmb_ciudad_per_lugar_nac}</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<br>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-4"><label>Estado civil</label>{cmb_estado_civil_repr}</div>
			<div class="col-sm-8"><label>Título</label>{cmb_profesion_repr}</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<br>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<label>DATOS LABORALES</label>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<br>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-8"><input name="per_empr_nomb" id="per_empr_nomb"  type="text" class="form-control" value="{per_empr_nomb}" placeholder="Empresa donde Trabaja (Razón Social)"/></div>
			<div class="col-sm-4"><input name="per_empr_ruc" id="per_empr_ruc"  type="text" pattern="[0-9]*" class="form-control" 
				value="{per_empr_ruc}" maxlength='13' placeholder="RUC"/></div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<br>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12"><input name="per_empr_dir" id="per_empr_dir"  type="text" class="form-control" value="{per_empr_dir}" placeholder="Dirección de la Empresa"/></div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<br>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12"><input name="per_empr_cargo" id="per_empr_cargo"  type="text" class="form-control" value="{per_empr_cargo}" placeholder="Cargo que desempeña"/></div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<br>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-4">
				<div class="input-group">
					<span class="input-group-addon">$</span>
					<input name="per_empr_ingreso_mensual" id="per_empr_ingreso_mensual"  type="number" min="0" class="form-control" 
						value="{per_empr_ingreso_mensual}" placeholder="Ingreso mensual"/>
				</div>
			</div>
			<div class="col-sm-4">
				<input name="per_empr_telf" id="per_empr_telf"  type="text" class="form-control" value="{per_empr_telf}" 
					placeholder="Teléfono"/>
			</div>
			<div class="col-sm-4">
				<input name="per_empr_mail" id="per_empr_mail"  type="text" class="form-control" value="{per_empr_mail}" 
					pattern = "^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$"
					maxlength="200"placeholder="Correo electrónico empresa"/>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<br>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-6">
				<div class="checkbox" style='display:inline;'>
					<label>
						<input type="checkbox" id="ckb_per_es_exalumno" name="ckb_per_es_exalumno"
							onchange="js_enviarSolicitud_es_exalumno(this);" {per_es_exalumno_check}>
							¿Es ex-Alumno?
					</label>
				</div>
			</div>
			<div class="col-sm-6">
				{per_cmb_es_exalumno}
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<br>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<div class="input-group" id="div_per_es_extrabajador" name="div_per_es_extrabajador" >
					<span class="input-group-addon">
						<input type="checkbox" id='ckb_per_es_extrabajador' name='ckb_per_es_extrabajador' 
							onclick='js_enviarSolicitud_es_extrabajador(this);' {per_es_exworker_check}/>
					</span>
					<span class="input-group-addon">
						<span style="text-align:left;font-size:small;font-weight:bold;">¿Ha trabajado antes en la institución?</span>
					</span>				
					<span class="input-group-addon">
						<small>Inicio</small></span>
					<input type="date" class="form-control" name="per_es_extrabajador_fecha_ini" id="per_es_extrabajador_fecha_ini" 
						value="{per_es_extrabajador_fecha_ini}" placeholder="dd/mm/yyyy" required="required" {per_exworker_fini_disabled}>
				
					<span class="input-group-addon">
						<small>Fin</small></span>
					<input type="date" class="form-control" name="per_es_extrabajador_fecha_fin" id="per_es_extrabajador_fecha_fin" 
						value="{per_es_extrabajador_fecha_fin}" placeholder="dd/mm/yyyy" required="required" {per_exworker_ffin_disabled}>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<br>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<button type="button" class="btn btn-default" onclick="$('#modal_add_repr').modal('hide');">Cancelar</button><!--Debe ser llamado de un modal llamado tal cual.-->
				<button type="button" class="btn btn-success" 
					onclick="js_enviarSolicitud_guarda_formulario_repr('{ruta_html}/enviarSolicitud/controller.php');$('#modal_add_repr').modal('hide');">
					<span class='glyphicon glyphicon-floppy-disk'></span>&nbsp;Guardar Cambios</button>
			</div>
		</div>
	</div>
		
	
	<div class="row bottom_10">
		<div class="col-md-4">
			<div class="input-group">
				<span class="input-group-addon" id="fic_ocu_apel_paterno_addon">Apellido Paterno:</span>
				<input type="text" class="form-control" id="fic_ocu_apel_paterno" name="fic_ocu_apel_paterno">
			</div>
		</div>
		<div class="col-md-4">
			<div class="input-group">
				<span class="input-group-addon" id="fic_ocu_apel_materno_addon">Apellido Materno:</span>
				<input type="text" class="form-control" id="fic_ocu_apel_materno" name="fic_ocu_apel_materno">
			</div>
		</div>
		<div class="col-md-4">
			<div class="input-group">
				<span class="input-group-addon" id="fic_ocu_nombres_addon">Nombres:</span>
				<input type="text" class="form-control" id="fic_ocu_nombres" name="fic_ocu_nombres">
			</div>
		</div>
	</div>
	
	<div class="row bottom_10">
		<div class="col-md-2">
			<div class="input-group">
				<span class="input-group-addon" id="fic_ocu_edad_addon">Edad:</span>
				<input type="text" class="form-control" id="fic_ocu_edad" name="fic_ocu_edad">
			</div>
		</div>
		<div class="col-md-3">
			<div class="input-group">
				<span class="input-group-addon" id="fic_ocu_fec_nacimiento_addon">Fech. Nacimiento:</span>
				<input type="text" class="form-control" id="fic_ocu_fec_nacimiento" name="fic_ocu_fec_nacimiento">
			</div>
		</div>
		<div class="col-md-2">
			<div class="input-group">
				<span class="input-group-addon" id="fic_ocu_sexo_addon">Sexo:</span>
                <select name="fic_ocu_sexo" id="fic_ocu_sexo" class="form-control">
                <option value="M">MASCULINO</option>
                <option value="F">FEMENINO</option>
                </select>
			</div>
		</div>
		<div class="col-md-3">
			<div class="input-group">
				<span class="input-group-addon" id="fic_ocu_est_civil_addon">Estado Civil:</span>
                <select name="fic_ocu_est_civil" id="fic_ocu_est_civil" class="form-control">
                <?php $catalogos = new Catalogos();
				$catalogos->set_idpadre(1);
				$catalogos->get_all_estados_civiles();
				foreach($catalogos->rows as $estado_civil){?>
                <option value="<?=$estado_civil['codigo']?>"><?=$estado_civil['descripcion']?></option>
                <?php }?>
                </select>
			</div>
		</div>
		<div class="col-md-2">
			<div class="input-group">
				<span class="input-group-addon" id="fic_ocu_hijos_addon">Hijos:</span>
				<input type="text" class="form-control" id="fic_ocu_hijos" name="fic_ocu_hijos">
			</div>
		</div>
	</div>
	
	<div class="row bottom_10">
		<div class="col-md-8">
			<div class="input-group">
				<span class="input-group-addon" id="fic_ocu_domicilio_addon">Domicilio:</span>
				<input type="text" class="form-control" id="fic_ocu_domicilio" name="fic_ocu_domicilio">
			</div>
		</div>
		<div class="col-md-4">
			<div class="input-group">
				<span class="input-group-addon" id="fic_ocu_telefono_addon">Tel&eacute;fono:</span>
				<input type="text" class="form-control" id="fic_ocu_telefono" name="fic_ocu_telefono">
			</div>
		</div>
	</div>
	
	<div class="row bottom_10">
		<div class="col-md-3">
			<div class="input-group">
				<span class="input-group-addon" id="fic_ocu_profesion_addon">Profesi&oacute;n:</span>
				<input type="text" class="form-control" id="fic_ocu_profesion" name="fic_ocu_profesion">
			</div>
		</div>
		<div class="col-md-3">
			<div class="input-group">
				<span class="input-group-addon" id="fic_ocu_instruccion_addon">Instrucci&oacute;n:</span>
				<input type="text" class="form-control" id="fic_ocu_instruccion" name="fic_ocu_instruccion">
			</div>
		</div>
		<div class="col-md-3">
			<div class="input-group">
				<span class="input-group-addon" id="fic_ocu_cargo_addon">Cargo:</span>
				<input type="text" class="form-control" id="fic_ocu_cargo" name="fic_ocu_cargo">
			</div>
		</div>
		<div class="col-md-3">
			<div class="input-group">
				<span class="input-group-addon" id="fic_ocu_turno_addon">Turno:</span>
				<input type="text" class="form-control" id="fic_ocu_turno" name="fic_ocu_turno">
			</div>
		</div>
	</div>
	
	<div class="row bottom_10">
		<div class="col-md-6">
			<div class="input-group">
				<span class="input-group-addon" id="fic_ocu_tarea_addon">Tarea:</span>
				<input type="text" class="form-control" id="fic_ocu_tarea" name="fic_ocu_tarea">
			</div>
		</div>
		<div class="col-md-6">
			<div class="input-group">
				<span class="input-group-addon" id="fic_ocu_tiempo_addon">Tiempo:</span>
				<input type="text" class="form-control" id="fic_ocu_tiempo" name="fic_ocu_tiempo">
			</div>
		</div>
	</div>
	
	<div class="row bottom_10">
		<div class="col-md-6">
			<div class="input-group">
				<span class="input-group-addon" id="fic_ocu_act_extralaboral_addon">Activ. Extralaboral:</span>
				<input type="text" class="form-control" id="fic_ocu_act_extralaboral" name="fic_ocu_act_extralaboral">
			</div>
		</div>
		<div class="col-md-6">
			<div class="input-group">
				<span class="input-group-addon" id="fic_ocu_lateralidad_addon">Lateralidad:</span>
				<input type="text" class="form-control" id="fic_ocu_lateralidad" name="fic_ocu_lateralidad">
			</div>
		</div>
	</div>
	
</div><!-- /container -->
<?php include("template/scripts.php");?>
<script src="js/med_fichas.js"></script>
<script type="text/javascript">  
	$(document).ready(function(){  
		$('#fic_ocu_fec_nacimiento').datetimepicker({
			format: 'DD/MM/YYYY',
			locale: 'es',
			showTodayButton: true,
			tooltips: {
				today: 'Ir al día actual',
				clear: 'Borrar selección',
				close: 'Cerrar el Seleccionador',
				selectMonth: 'Seleccione el Mes',
				prevMonth: 'Mes Anterior',
				nextMonth: 'Mes Siguiente',
				selectYear: 'Seleccione el Año',
				prevYear: 'Año Anterior',
				nextYear: 'Año Siguiente',
				selectDecade: 'Seleccione la Década',
				prevDecade: 'Década Anterior',
				nextDecade: 'Década Siguiente',
				prevCentury: 'Siglo Anterior',
				nextCentury: 'Siglo Siguiente'
			}
		});
	});
</script>
</body>
</html>