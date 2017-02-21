<div id="div_modal_datos_laborales" 			name="div_modal_datos_laborales"></div>
<div id="div_modal_rie_laborales" 				name="div_modal_rie_laborales"></div>
<div id="div_modal_acc_laborales" 				name="div_modal_acc_laborales"></div>
<div id="div_modal_actividades_extralaborales" 	name="div_modal_actividades_extralaborales"></div>
<div id="div_modal_proteccion_especial" 		name="div_modal_proteccion_especial"></div>
<div id="div_modal_debitos_bancarions" 			name="div_modal_debitos_bancarions"></div>
<div class="grid">
	<div class="row">
		<div class="col-sm-12" {bloqueo_mensaje_inicial_multiples_tipos_persona}>
			Si el tipo de persona no es especificado, puede ingresar datos tanto laborales como académicos, en caso de que sea un ex-alumno.
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<br>
		</div>
	</div>
</div>
<input type="hidden" name="{per}_tipo" 	 		id="{per}_tipo"			value="{per_tipo}" /> 
<input type="hidden" name="{per}_codi" 	 		id="{per}_codi" 		value="{per_codi}" /> 
<input type="hidden" name="{per}_empl_codi" 	id="{per}_empl_codi" 	value="{per_empl_codi}" />
<div class="nav-tabs-custom">
	<ul class="nav nav-tabs">
		<li class="active">
			<a href="#tab_1" data-toggle="tab"><i class="fa fa-clipboard"></i> Datos personales</a></li>
			<!--
			<li><a href="#tab_2" data-toggle="tab"><i class="fa fa-suitcase"></i> Datos laborales</a></li>
			<li><a href="#tab_3" data-toggle="tab"><i class="fa fa-wrench"></i> Datos del empleado</a></li>
			<li><a href="#tab_4" data-toggle="tab"><i class="fa fa-graduation-cap"></i> Datos académicos</a></li>
			<li><a href="#tab_5" data-toggle="tab"><i class="fa fa-credit-card"></i> Débitos bancarios</a></li>
			-->
			{display_datos_empleado}
			{display_datos_laborales}
			{display_datos_academicos}
			{display_datos_debitos_bancarios}
		<li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>
		
	</ul>
	<div class="tab-content">
		<div class="tab-pane active" id="tab_1">
			<div class="grid">
				<div class="row">
					<div class="col-sm-6">
						{cmb_per_tipo_identificacion}
					</div>
					<div class="col-sm-6">
						<input type="text" class="form-control" name="{per}_numero_identificacion" id="{per}_numero_identificacion"  required="required" value="{per_numero_identificacion}"
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
						<input name="{per}_nomb" id="{per}_nomb"  type="text" class="form-control" value="{per_nomb}" placeholder="Nombre" 
							pattern = "^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$" maxlength="60"/>
					</div>
					<div class="col-sm-6">
						<input name="{per}_nomb_seg" id="{per}_nomb_seg"  type="text" class="form-control" value="{per_nomb_seg}" placeholder="Segundo nombre" 
							pattern = "^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$" maxlength="60"/>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<br>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<input name="{per}_apel" id="{per}_apel"  type="text" class="form-control" value="{per_apel}" placeholder="Apellido paterno" 
							pattern = "^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$" maxlength="60"/>
					</div>
					<div class="col-sm-6">
						<input name="{per}_apel_mat" id="{per}_apel_mat"  type="text" class="form-control" value="{per_apel_mat}" placeholder="Apellido materno" 
							pattern = "^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$" maxlength="60"/>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<br>
					</div>
				</div>
				<div class='row'>
					<div class="col-sm-12">
						<input type="radio" id="{per}_rdb_genero" name="{per}_rdb_genero" value="M" {per_genero_m}> Masculino 
						<input type="radio" id="{per}_rdb_genero" name="{per}_rdb_genero" value="F" {per_genero_f}> Femenino
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
					<div class="col-sm-3">
						<label>Pa&iacute;s residencia</label>
						{cmb_pais_per_residencia}
					</div>
					<div class="col-sm-3">
						<label>Provincia/Estado residencia</label>
						<div id='div_provincia_{per}_residencia' name='div_provincia_{per}_residencia'>{cmb_provincia_per_residencia}</div>
					</div>
					<div class="col-sm-3">
						<label>Ciudad residencia</label>
						<div id='div_ciudad_{per}_residencia' name='div_ciudad_{per}_residencia'>{cmb_ciudad_per_residencia}</div>
					</div>
					<div class="col-sm-3">
						<label>Parroquia</label>
						<input name="{per}_parroquia" id="{per}_parroquia" type="text" class="form-control" value="{per_parroquia}" 
								placeholder="Parroquia" maxlength="60"/>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<br>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-8">
						<input name="{per}_dir" id="{per}_dir" type="text" class="form-control" value="{per_dir}" placeholder="Dirección" maxlength="150"/>
					</div>
					<div class="col-sm-4">
						<div class="input-group" style="width: 100%;">
							<span style="width: 25%; font-size:small;" class="input-group-addon">
								<span class='glyphicon glyphicon-phone-alt'></span>
							</span>
							<input name="{per}_telf" id="{per}_telf" type="text" class="form-control" value="{per_telf}" placeholder="Teléfono"
								pattern='[0-9]+' maxlength="25"/>
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
							<span style="width: 25%; font-size:small;" class="input-group-addon">
								<span class='glyphicon glyphicon-envelope'></span></span>
							<input name="{per}_email_personal" id="{per}_email_personal"  type="text" class="form-control" value="{per_email_personal}" 
								pattern = "^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$"
								maxlength="200"placeholder="e-mail personal"/>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<br>
					</div>
				</div>
				<div {bloqueo_datos_personales_explicitos}>
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
							<label>Pa&iacute;s</label>
							{cmb_pais_per_lugar_nac}
						</div>
						<div class="col-sm-3">
							<label>Provincia/Estado</label>
							<div id='div_provincia_{per}_lugar_nac' name='div_provincia_{per}_lugar_nac'>{cmb_provincia_per_lugar_nac}</div>
						</div>
						<div class="col-sm-3">
							<label>Ciudad</label>
							<div id='div_ciudad_{per}_lugar_nac' name='div_ciudad_{per}_lugar_nac'>{cmb_ciudad_per_lugar_nac}</div>
						</div>
						<div class="col-sm-3">
							<label>F. nacimiento </label>
							<div class="input-group">
								<div class="input-group-addon">
									<i class="fa fa-calendar"></i>
								</div>
								<input name="{per}_fecha_nac" id="{per}_fecha_nac"  type="text" class="form-control" value="{per_fecha_nac}"/>
							</div>
						</div>
					</div>
					<div class="row" {bloqueo_alumno}>
						<div class="col-sm-12">
							<br>
						</div>
					</div>
					<div class="row" {bloqueo_alumno}>
						<div class="col-sm-4"><label>Estado civil</label>{cmb_estado_civil_per}</div>
						<div class="col-sm-8"><label>Título</label>{cmb_profesion_per}</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<br>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-3"><label>Lateralidad</label>{cmb_lateralidad_per}</div>
						<div class="col-sm-4" {bloqueo_alumno} {bloqueo_ingreso_mensual}><label>Ingreso mensual</label>
							<div class="input-group">
								<span class="input-group-addon">$</span>
								<input name="{per}_empr_ingreso_mensual" id="{per}_empr_ingreso_mensual"  type="text" class="form-control" 
									value="{per_empr_ingreso_mensual}" placeholder="0.00"/>
							</div>
						</div>
						<div class="col-sm-4" {bloqueo_alumno} {bloqueo_num_hijos}><label>N&uacute;mero de hijos</label>
							<div class="input-group">
								<span class="input-group-addon"><span class="fa fa-child"></span></span>
								<input name="{per}_num_hijos" id="{per}_num_hijos"  type="text" class="form-control" 
									value="{per_num_hijos}" placeholder="0"/>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div><!-- /.tab-pane -->
		<div class="tab-pane" id="tab_2">
			<div class="grid">
				<div class="row">
					<div class="col-sm-12">
						<br>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						{mensaje_datos_laborales}
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<br>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<div class='panel panel-success'>
							<div class='panel-heading'>
								<table style='width:100%'>
									<tr>
										<td style='text-align:left;'>
											Datos laborales
										</td>
										<td style='text-align:right;'>
											<button type="button" class="btn btn-success" onclick="js_persona_add_datos_laborales('div_tbl_datos_laborales', '{per}', '');">
												<i class='fa fa-plus'></i>&nbsp;Agregar</button>
										</td>
									</tr>
								</table>
							</div>
							<div class='panel-collapse collapse in'>
								<div class="grid">
									<div class="row">
										<div class="col-sm-12">
											<div id="div_tbl_datos_laborales" name="div_tbl_datos_laborales">{div_resultado_tbl_datos_laborales}</div>
										</div>
									</div>
								</div>
							</div>
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
						<div class='panel panel-default'>
							<div class='panel-heading'>
								<table style='width:100%'>
									<tr>
										<td style='text-align:left;'>
											Antecedentes de riesgos laborales
										</td>
										<td style='text-align:right;'>
											<button type="button" class="btn bg-purple" onclick="js_persona_add_rie_laborales('div_tbl_rie_laborales', '{per}', '');">
												<i class='fa fa-plus'></i>&nbsp;Agregar</button>
										</td>
									</tr>
								</table>
							</div>
							<div class='panel-collapse collapse in'>
								<div class="grid">
									<div class="row">
										<div class="col-sm-12">
											<div id="div_tbl_rie_laborales" name="div_tbl_rie_laborales">{div_resultado_tbl_rie_laborales}</div>
										</div>
									</div>
								</div>
							</div>
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
						<div class='panel panel-danger'>
							<div class='panel-heading'>
								<table style='width:100%'>
									<tr>
										<td style='text-align:left;'>
											Antecedentes de accidentes laborales
										</td>
										<td style='text-align:right;'>
											<button type="button" class="btn btn-danger" onclick="js_persona_add_acc_laborales('div_tbl_acc_laborales', '{per}', '');">
												<i class='fa fa-plus'></i>&nbsp;Agregar</button>
										</td>
									</tr>
								</table>
							</div>
							<div class='panel-collapse collapse in'>
								<div class="grid">
									<div class="row">
										<div class="col-sm-12">
											<div id="div_tbl_acc_laborales" name="div_tbl_acc_laborales">{div_resultado_tbl_acc_laborales}</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div><!-- /.tab-pane -->
		<div class="tab-pane" id="tab_3">
			<div class="grid">
				<div class="row">
					<div class="col-sm-8"><input name="{per}_empr_nomb_empl" id="{per}_empr_nomb_empl"  type="text" class="form-control" value="{per_empr_nomb_empl}" 
						placeholder="Empresa donde Trabaja (Razón Social)" {bloqueo_empleado} /></div>
					<div class="col-sm-4"><input name="{per}_empr_ruc_empl" id="{per}_empr_ruc_empl"  type="text" pattern="[0-9]*" class="form-control" 
						value="{per_empr_ruc_empl}" maxlength='13' placeholder="RUC" {bloqueo_empleado} /></div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<br>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-9"><input name="{per}_empr_dir_empl" id="{per}_empr_dir_empl"  type="text" class="form-control" value="{per_empr_dir_empl}" 
						placeholder="Dirección de la Empresa" {bloqueo_empleado} /></div>
					<div class="col-sm-3">
						<input name="{per}_empr_telf_empl" id="{per}_empr_telf_empl"  type="text" class="form-control" value="{per_empr_telf_empl}" 
							placeholder="Teléfono" {bloqueo_empleado} />
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<br>
					</div>
				</div>
				<div class='row'>
					<div class="col-sm-12">
						<div class='panel panel-danger'>
							<div class='panel-heading'>
								Tipo empleado
							</div>
							<div class='panel-collapse collapse in'>
								<div class="grid">
									<div class="row">
										<div class="col-sm-12">
											<br>
										</div>
									</div>
									<div class="row">
										<div class="col-sm-12">
											<ul style="list-style-type:none">
												<li>
													<input type="radio" id="{per}_rdb_tipo_empl" name="{per}_rdb_tipo_empl" value="1" {empl_tipo_empleado_prof}> Docente 
													<input type="radio" id="{per}_rdb_tipo_empl" name="{per}_rdb_tipo_empl" value="2" {empl_tipo_empleado_mant}> Mantenimiento/soporte
													<input type="radio" id="{per}_rdb_tipo_empl" name="{per}_rdb_tipo_empl" value="3" {empl_tipo_empleado_admin}> Adminstrativo
												</li>
											</ul>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<br>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label>Área</label>
						{cmb_area_per}
					</div>
					<div class="col-sm-4">
						<label>Departamento</label>
						<div id="div_cmb_dept" name="div_cmb_dept">{cmb_dept_per}</div>
					</div>
					<div class="col-sm-4">
						<label>Cargo</label>
						<div id="div_cmb_cargo" name="div_cmb_cargo">{cmb_cargo_per}</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<br>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<div class="input-group" style="width: 100%;">
							<span style="width: 25%; font-size:small;" class="input-group-addon">
								<span class='fa fa-phone'></span>
							</span>
							<input name="{per}_empl_ext" id="{per}_empl_ext" type="text" class="form-control" value="{per_empl_ext}" placeholder="Ext."
								pattern='[0-9]+' maxlength="25"/>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="input-group" style="width: 100%;">
							<span style="width: 25%; font-size:small;" class="input-group-addon">
								<span class='glyphicon glyphicon-envelope'></span></span>
							<input name="{per}_empl_mail" id="{per}_empl_mail"  type="text" class="form-control" value="{per_empl_mail}" 
								pattern = "^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$"
								maxlength="200"placeholder="e-mail institucional"/>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<br>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<div class="bootstrap-timepicker">
							<label>Hora entrada</label>
							<div class="input-group">
								<input id="{per}_empr_turno_empl_de" name="{per}_empr_turno_empl_de" type="text" class="form-control" value="{per_empl_turno_ini}">
								<div class="input-group-addon">
									<i class="fa fa-clock-o"></i>
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="bootstrap-timepicker">
							<label>Hora salida</label>
							<div class="input-group">
								<input id="{per}_empr_turno_empl_a" name="{per}_empr_turno_empl_a" type="text" class="form-control" value="{per_empl_turno_fin}">
								<div class="input-group-addon">
									<i class="fa fa-clock-o"></i>
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-4">
						<label>Jornada</label>{cmb_jornada_per}
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<br>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label>Fecha inicio contrato </label>
						<div class="input-group">
							<div class="input-group-addon">
								<i class="fa fa-calendar"></i>
							</div>
							<input name="{per}_fecha_ini_c" id="{per}_fecha_ini_c" type="text" class="form-control" value="{per_fecha_ini_c}"/>
						</div>
					</div>
					<div class="col-sm-4">
						<label>Fecha fin contrato </label>
						<div class="input-group">
							<div class="input-group-addon">
								<i class="fa fa-calendar"></i>
							</div>
							<input name="{per}_fecha_fin_c" id="{per}_fecha_fin_c" type="text" class="form-control" value="{per_fecha_fin_c}"/>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<br>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6 col-sm-12">
						<div class='panel panel-info'>
							<div class='panel-heading'>
								<table style='width:100%'>
									<tr>
										<td style='text-align:left;'>
											Actividades extralaborales
										</td>
										<td style='text-align:right;'>
											<button type="button" class="btn btn-info" onclick="js_persona_add_act_ext('div_tbl_act_ext', '{per}', '' );">
												<i class='fa fa-plus'></i>&nbsp;Agregar
											</button>
										</td>
									</tr>
								</table>
							</div>
							<div class='panel-collapse collapse in'>
								<div class="grid">
									<div class="row">
										<div class="col-sm-12">
											<div id="div_tbl_act_ext" name="div_tbl_act_ext">{div_resultado_tbl_act_ext}</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-6 col-sm-12">
						<div class='panel panel-warning'>
							<div class='panel-heading'>
								<table style='width:100%'>
									<tr>
										<td style='text-align:left;'>
											Elementos de Protecci&oacute;n
										</td>
										<td style='text-align:right;'>
											<button type="button" class="btn btn-warning" onclick="js_persona_add_ele_protex('div_tbl_ele_protex', '{per}', '' );">
												<i class='fa fa-plus'></i>&nbsp;Agregar</button>
										</td>
									</tr>
								</table>
							</div>
							<div class='panel-collapse collapse in'>
								<div class="grid">
									<div class="row">
										<div class="col-sm-12">
											<div id="div_tbl_ele_protex" name="div_tbl_ele_protex">{div_resultado_tbl_ele_protex}</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div><!-- /.tab-pane -->
		<div class="tab-pane" id="tab_4">
			Lorem Ipsum is simply 
		</div><!-- /.tab-pane -->
		<div class="tab-pane" id="tab_5">
			Credit card 
		</div><!-- /.tab-pane -->
	</div>
</div>