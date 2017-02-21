<div id="div_modal_enfermedades"	name="div_modal_enfermedades"></div>
<div id="div_modal_alergias" 		name="div_modal_alergias"></div>
<div id="div_modal_vacunas" 		name="div_modal_vacunas"></div>
<div id="div_modal_exs_lab_clinico"	name="div_modal_exs_lab_clinico"></div>
<div id="div_modal_cirugias" 		name="div_modal_cirugias"></div>
<div id="div_modal_radiografias" 	name="div_modal_radiografias"></div>
<input type="hidden" name="{per}_fmex_codi" 	id="{per}_fmex_codi"	value="{per_fmex_codi}" />
<input type="hidden" name="{per}_tipo" 	 		id="{per}_tipo"			value="{per_tipo}" />
<input type="hidden" name="{per}_per_codi" 	 	id="{per}_per_codi" 		value="{per_codi}" />
	<div class='panel panel-primary'>
		<div class='panel-heading' style='text-align:center;'>
			Ficha médica
		</div>
		<div class='panel-collapse collapse in'>
			<div class="grid">
				<div class="row">
					<div class="col-sm-12"  style='text-align:center;'>
						<input type="radio" id="{per}_rdb_tipo_ficha" name="{per}_rdb_tipo_ficha" value="PRE" {per_tipo_ficha_pre}> Pre-ocupacional
						<input type="radio" id="{per}_rdb_tipo_ficha" name="{per}_rdb_tipo_ficha" value="OCU" {per_tipo_ficha_ocu}> Ocupacional
						<input type="radio" id="{per}_rdb_tipo_ficha" name="{per}_rdb_tipo_ficha" value="POST" {per_tipo_ficha_post}> Post-ocupacional
						<input type="radio" id="{per}_rdb_tipo_ficha" name="{per}_rdb_tipo_ficha" value="OTRO" {per_tipo_ficha_otro}> General
					</div>
				</div>
			</div>
		</div>
	</div>
<div class="nav-tabs-custom">
	<ul class="nav nav-tabs">
		<li class="active"><a href="#tab_1" data-toggle="tab"><i class="fa fa-clipboard"></i> Antecedentes personales</a></li>
		<li><a href="#tab_2" data-toggle="tab"><i class="fa fa-child"></i> Examen Físico</a></li>
		<li><a href="#tab_3" data-toggle="tab"><i class="fa fa-bed"></i> Examen Regional</a></li>
		<li><a href="#tab_4" data-toggle="tab"><i class="fa fa-assistive-listening-systems"></i> Órganos de los sentidos</a></li>
		<li><a href="#tab_5" data-toggle="tab"><i class="fa fa-hand-lizard-o"></i> Examen Neurológico</a></li>
		<li><a href="#tab_6" data-toggle="tab"><i class="fa fa-eye"></i> Estado mental</a></li>
		<li><a href="#tab_8" data-toggle="tab"><i class="fa fa-unlink"></i> Cirugías</a></li>
		<li><a href="#tab_9" data-toggle="tab"><i class="fa fa-sticky-note-o"></i> Radiografía/Ex. clínicos</a></li>
		<li><a href="#tab_7" data-toggle="tab"><i class="fa fa-comment-o"></i> Conclusión/Aptitudes</a></li>
	</ul>
	<div class="tab-content">
		<div class="tab-pane active" id="tab_1">
			<div class="grid">
				<div class="row">
					<div class="col-sm-1">
						<label>Tabaco</label>
					</div>
					<div class="col-sm-11">
						<input type="radio" id="{per}_rdb_tabaco" name="{per}_rdb_tabaco" value="S" {per_tabaco_si}> Si
						<input type="radio" id="{per}_rdb_tabaco" name="{per}_rdb_tabaco" value="N" {per_tabaco_no}> No
					</div>
				</div>
				<div class="row">
					<div class="col-sm-1">
						<label>Alcohol</label>
					</div>
					<div class="col-sm-11">
						<input type="radio" id="{per}_rdb_alcohol" name="{per}_rdb_alcohol" value="S" {per_alcohol_si}> Si
						<input type="radio" id="{per}_rdb_alcohol" name="{per}_rdb_alcohol" value="N" {per_alcohol_no}> No
					</div>
				</div>
				<div class="row">
					<div class="col-sm-1">
						<label>Drogas</label>
					</div>
					<div class="col-sm-11">
						<input type="radio" id="{per}_rdb_drogas" name="{per}_rdb_drogas" value="S" {per_drogas_si}> Si
						<input type="radio" id="{per}_rdb_drogas" name="{per}_rdb_drogas" value="N" {per_drogas_no}> No
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<br>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12 col-sm-12">
						<div class='panel panel-danger'>
							<div class='panel-heading'>
								<table style='width:100%'>
									<tr>
										<td style='text-align:left;'>
											Alergias
										</td>
										<td style='text-align:right;'>
											<button type="button" class="btn btn-danger" onclick="js_ficha_add_alergia('div_tbl_alergia', '{per}', '' );">
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
											<div id="div_tbl_alergia" name="div_tbl_alergia">{div_resultado_tbl_alergia}</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-12 col-sm-12">
						<div class='panel panel-warning'>
							<div class='panel-heading'>
								<table style='width:100%'>
									<tr>
										<td style='text-align:left;'>
											Vacunas
										</td>
										<td style='text-align:right;'>
											<button type="button" class="btn btn-warning" onclick="js_ficha_add_vacuna('div_tbl_vacuna', '{per}', '' );">
												<i class='fa fa-plus'></i>&nbsp;Agregar</button>
										</td>
									</tr>
								</table>
							</div>
							<div class='panel-collapse collapse in'>
								<div class="grid">
									<div class="row">
										<div class="col-sm-12">
											<div id="div_tbl_vacuna" name="div_tbl_vacuna">{div_resultado_tbl_vacuna}</div>
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
					<div class="col-md-12 col-sm-12">
						<div class='panel panel-info'>
							<div class='panel-heading'>
								<table style='width:100%'>
									<tr>
										<td style='text-align:left;'>
											Antecedentes patológicos familiares
										</td>
										<td style='text-align:right;'>
											<button type="button" class="btn btn-info" onclick="js_ficha_add_enfermedad('div_tbl_enfermedad_familia', '{per}', '', 'F' );">
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
											<div id="div_tbl_enfermedad_familia" name="div_tbl_enfermedad_familia">{div_resultado_tbl_enfermedad_familia}</div>
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
					<div class="col-md-12 col-sm-12">
						<div class='panel panel-info'>
							<div class='panel-heading'>
								<table style='width:100%'>
									<tr>
										<td style='text-align:left;'>
											Antecedentes patológicos personales
										</td>
										<td style='text-align:right;'>
											<button type="button" class="btn btn-info" onclick="js_ficha_add_enfermedad('div_tbl_enfermedad', '{per}', '', 'T' );">
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
											<div id="div_tbl_enfermedad" name="div_tbl_enfermedad">{div_resultado_tbl_enfermedad}</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div><!-- /.tab-pane -->
		<div class="tab-pane" id="tab_2">
			<div class="grid">
				<div class="row">
					<div class="col-sm-4">
						<label>Condición física</label>
						<input name="{per}_con_fisica" id="{per}_con_fisica"  type="text" class="form-control" value="{per_con_fisica}"
							pattern = "^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$" maxlength="60"/>
					</div>
					<div class="col-sm-4">
						<label>Actividad sicomotora</label>
						<input name="{per}_act_sicomotora" id="{per}_act_sicomotora"  type="text" class="form-control" value="{per_act_sicomotora}"
							pattern = "^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$" maxlength="60"/>
					</div>
					<div class="col-sm-4">
						<label>Deambulaci&oacute;n</label>
						<input name="{per}_deambulacion" id="{per}_deambulacion"  type="text" class="form-control" value="{per_deambulacion}" 
							pattern = "^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$" maxlength="60"/>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<br>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label>Expresión verbal</label>
						<input name="{per}_exp_verbal" id="{per}_exp_verbal"  type="text" class="form-control" value="{per_exp_verbal}"
							pattern = "^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$" maxlength="60"/>
					</div>
					<div class="col-sm-4">
						<label>Estado nutricional</label>
						<input name="{per}_estado_nutricional" id="{per}_estado_nutricional"  type="text" class="form-control" value="{per_estado_nutricional}"
							pattern = "^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$" maxlength="60"/>
					</div>
					<div class="col-sm-4">
						<label>Estatura</label>
						<div class="input-group" style="width: 100%;">
							<input name="{per}_estatura" id="{per}_estatura"  type="text" class="form-control" value="{per_estatura}" 
								pattern = "^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$" maxlength="60"/>
							<span style="width: 25%; font-size:small;" class="input-group-addon">
								Mts.</span>
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
						<label>Peso</label>
						<div class="input-group" style="width: 100%;">
							<input name="{per}_peso" id="{per}_peso"  type="text" class="form-control" value="{per_peso}"
								pattern = "^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$" maxlength="6"/>
							<span style="width: 25%; font-size:small;" class="input-group-addon">
								Lbs.</span>
						</div>
					</div>
					<div class="col-sm-4">
						<label>Temperatura Bucal</label>
						<div class="input-group" style="width: 100%;">
							<span style="width: 25%; font-size:small;" class="input-group-addon">
								<span class='fa fa-eyedropper'></span></span>
							<input name="{per}_temp_bucal" id="{per}_temp_bucal"  type="text" class="form-control" value="{per_temp_bucal}"
								pattern = "^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$" maxlength="6"/>
						</div>
					</div>
					<div class="col-sm-4">
						<label>Pulso</label>
						<div class="input-group" style="width: 100%;">
							<span style="width: 25%; font-size:small;" class="input-group-addon">
								<span class='fa fa-hand-rock-o'></span></span>
							<input name="{per}_pulso" id="{per}_pulso"  type="text" class="form-control" value="{per_pulso}" 
								pattern = "^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$" maxlength="6"/>
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
						<label>Presi&oacute;n Arterial</label>
						<div class="input-group" style="width: 100%;">
							<span style="width: 25%; font-size:small;" class="input-group-addon">
								<span class='fa fa-heartbeat'></span></span>
							<input name="{per}_presion_arterial" id="{per}_presion_arterial"  type="text" class="form-control" value="{per_presion_arterial}" 
							pattern = "^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$" maxlength="6"/>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<br>
					</div>
				</div>
			</div>
		</div><!-- /.tab-pane -->
		<div class="tab-pane" id="tab_3">
			<div class="grid">
				<div class='row'>
					<div class="col-sm-12">
						<div class='panel panel-info'>
							<div class='panel-heading'>
								GENERAL
							</div>
							<div class='panel-collapse collapse in'>
								<div class="form-horizontal">
									<div class="form-group">
										<div class="col-sm-6">
											<label>Piel</label>
											<input name="{per}_piel" id="{per}_piel"  type="text" class="form-control" value="{per_piel}"
												pattern = "^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$" maxlength="60"/>
										</div>
										<div class="col-sm-6">
											<label>Ganglios</label>
											<input name="{per}_ganglios" id="{per}_ganglios"  type="text" class="form-control" value="{per_ganglios}"
												pattern = "^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$" maxlength="60"/>
										</div>
									</div>
									<div class="form-group">
										<div class="col-sm-6">
											<label>Cabeza</label>
											<input name="{per}_cabeza" id="{per}_cabeza"  type="text" class="form-control" value="{per_cabeza}" 
												pattern = "^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$" maxlength="60"/>
										</div>
										<div class="col-sm-6">
											<label>Cuello</label>
											<input name="{per}_cuello" id="{per}_cuello"  type="text" class="form-control" value="{per_cuello}" 
												pattern = "^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$" maxlength="60"/>
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
				<div class='row'>
					<div class="col-sm-12">
						<div class='panel panel-info'>
							<div class='panel-heading'>
								CARA
							</div>
							<div class='panel-collapse collapse in'>
								<div class="form-horizontal">
									<div class="form-group">
										<div class="col-sm-4">
											<label>Ojos</label>
											<input name="{per}_ojos" id="{per}_ojos"  type="text" class="form-control" value="{per_ojos}"
												pattern = "^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$" maxlength="60"/>
										</div>
										<div class="col-sm-4">
											<label>Oidos</label>
											<input name="{per}_oidos" id="{per}_oidos"  type="text" class="form-control" value="{per_oidos}"
												pattern = "^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$" maxlength="60"/>
										</div>
										<div class="col-sm-4">
											<label>Boca</label>
											<input name="{per}_boca" id="{per}_boca"  type="text" class="form-control" value="{per_boca}" 
												pattern = "^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$" maxlength="60"/>
										</div>
									</div>
									<div class="form-group">
										<div class="col-sm-4">
											<label>Nariz</label>
											<input name="{per}_nariz" id="{per}_nariz"  type="text" class="form-control" value="{per_nariz}"
												pattern = "^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$" maxlength="60"/>
										</div>
										<div class="col-sm-4">
											<label>Dentadura</label>
											<input name="{per}_dentadura" id="{per}_dentadura"  type="text" class="form-control" value="{per_dentadura}"
												pattern = "^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$" maxlength="60"/>
										</div>
										<div class="col-sm-4">
											<label>Garganta</label>
											<input name="{per}_garganta" id="{per}_garganta"  type="text" class="form-control" value="{per_garganta}" 
												pattern = "^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$" maxlength="60"/>
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
				<div class='row'>
					<div class="col-sm-12">
						<div class='panel panel-info'>
							<div class='panel-heading'>
								TORAX
							</div>
							<div class='panel-collapse collapse in'>
								<div class="form-horizontal">
									<div class="form-group">
										<div class="col-sm-6">
											<label>Coraz&oacute;n</label>
											<input name="{per}_corazon" id="{per}_corazon"  type="text" class="form-control" value="{per_corazon}"
												pattern = "^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$" maxlength="60"/>
										</div>
										<div class="col-sm-6">
											<label>Torax</label>
											<input name="{per}_torax" id="{per}_torax"  type="text" class="form-control" value="{per_torax}"
												pattern = "^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$" maxlength="60"/>
										</div>
									</div>
									<div class="form-group">
										<div class="col-sm-6">
											<label>Pulmones</label>
											<input name="{per}_pulmones" id="{per}_pulmones"  type="text" class="form-control" value="{per_pulmones}" 
												pattern = "^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$" maxlength="60"/>
										</div>
										<div class="col-sm-6">
											<label>Mamas</label>
											<input name="{per}_mamas" id="{per}_mamas"  type="text" class="form-control" value="{per_mamas}" 
												pattern = "^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$" maxlength="60"/>
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
				<div class='row'>
					<div class="col-sm-12">
						<div class='panel panel-info'>
							<div class='panel-heading'>
								ABDOMEN
							</div>
							<div class='panel-collapse collapse in'>
								<div class="form-horizontal">
									<div class="form-group">
										<div class="col-sm-6">
											<label>H&iacute;gado</label>
											<input name="{per}_higado" id="{per}_higado"  type="text" class="form-control" value="{per_higado}"
												pattern = "^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$" maxlength="60"/>
										</div>
										<div class="col-sm-6">
											<label>Ves&iacute;cula Biliar</label>
											<input name="{per}_ves_biliar" id="{per}_ves_biliar"  type="text" class="form-control" value="{per_ves_biliar}"
												pattern = "^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$" maxlength="60"/>
										</div>
									</div>
									<div class="form-group">
										<div class="col-sm-6">
											<label>Bazo</label>
											<input name="{per}_bazo" id="{per}_bazo"  type="text" class="form-control" value="{per_bazo}" 
												pattern = "^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$" maxlength="60"/>
										</div>
										<div class="col-sm-6">
											<label>Est&oacute;mago</label>
											<input name="{per}_estomago" id="{per}_estomago"  type="text" class="form-control" value="{per_estomago}" 
												pattern = "^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$" maxlength="60"/>
										</div>
									</div>
									<div class="form-group">
										<div class="col-sm-6">
											<label>Intestinos</label>
											<input name="{per}_intestinos" id="{per}_intestinos"  type="text" class="form-control" value="{per_intestinos}" 
												pattern = "^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$" maxlength="60"/>
										</div>
										<div class="col-sm-6">
											<label>Ap&eacute;ndice</label>
											<input name="{per}_apendice" id="{per}_apendice"  type="text" class="form-control" value="{per_apendice}" 
												pattern = "^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$" maxlength="60"/>
										</div>
									</div>
									<div class="form-group">
										<div class="col-sm-6">
											<label>Ano</label>
											<input name="{per}_ano" id="{per}_ano"  type="text" class="form-control" value="{per_ano}" 
												pattern = "^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$" maxlength="60"/>
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
				<div class='row'>
					<div class="col-sm-12">
						<div class='panel panel-info'>
							<div class='panel-heading'>
								CONDUCTOS Y ANILLO
							</div>
							<div class='panel-collapse collapse in'>
								<div class="form-horizontal">
									<div class="form-group">
										<div class="col-sm-6">
											<label>Cordón Umbilical</label>
											<input name="{per}_umbilical" id="{per}_umbilical"  type="text" class="form-control" value="{per_umbilical}"
												pattern = "^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$" maxlength="60"/>
										</div>
										<div class="col-sm-6">
											<label>Crural</label>
											<input name="{per}_rurales" id="{per}_rurales"  type="text" class="form-control" value="{per_rurales}"
												pattern = "^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$" maxlength="60"/>
										</div>
									</div>
									<div class="form-group">
										<div class="col-sm-6">
											<label>Inguinal derecha</label>
											<input name="{per}_inguinal_derecha" id="{per}_inguinal_derecha"  type="text" class="form-control" value="{per_inguinal_derecha}" 
												pattern = "^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$" maxlength="60"/>
										</div>
										<div class="col-sm-6">
											<label>Inguinal izquierda</label>
											<input name="{per}_inguinal_izquierda" id="{per}_inguinal_izquierda"  type="text" class="form-control" value="{per_inguinal_izquierda}" 
												pattern = "^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$" maxlength="60"/>
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
				<div class='row'>
					<div class="col-sm-12">
						<div class='panel panel-info'>
							<div class='panel-heading'>
								COLUMNA VERTEBRAL
							</div>
							<div class='panel-collapse collapse in'>
								<div class="form-horizontal">
									<div class="form-group">
										<div class="col-sm-6">
											<label>Deformaciones</label>
											<input name="{per}_deformaciones" id="{per}_deformaciones"  type="text" class="form-control" value="{per_deformaciones}"
												pattern = "^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$" maxlength="60"/>
										</div>
										<div class="col-sm-6">
											<label>Masas musculares</label>
											<input name="{per}_masas_musculares" id="{per}_masas_musculares"  type="text" class="form-control" value="{per_masas_musculares}"
												pattern = "^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$" maxlength="60"/>
										</div>
									</div>
									<div class="form-group">
										<div class="col-sm-6">
											<label>Movibilidad</label>
											<input name="{per}_movibilidad" id="{per}_movibilidad"  type="text" class="form-control" value="{per_movibilidad}" 
												pattern = "^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$" maxlength="60"/>
										</div>
										<div class="col-sm-6">
											<label>Puntos dolorosos</label>
											<input name="{per}_puntos_dolorosos" id="{per}_puntos_dolorosos"  type="text" class="form-control" value="{per_puntos_dolorosos}" 
												pattern = "^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$" maxlength="60"/>
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
				<div class='row'>
					<div class="col-sm-12">
						<div class='panel panel-info'>
							<div class='panel-heading'>
								REGION URGO-GENITAL
							</div>
							<div class='panel-collapse collapse in'>
								<div class="form-horizontal">
									<div id='region_urgo_genital_masculina' name='region_urgo_genital_masculina' style="display:inline;">
										<div class="form-group">
											<div class="col-sm-6">
												<label>Tracto urinario</label>
												<input name="{per}_tracto_urinario" id="{per}_tracto_urinario"  type="text" class="form-control" value="{per_tracto_urinario}"
													pattern = "^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$" maxlength="60"/>
											</div>
											<div class="col-sm-6">
												<label>Tracto genital masculino</label>
												<input name="{per}_tracto_genital_masculino" id="{per}_tracto_genital_masculino"  type="text" class="form-control" value="{per_tracto_genital_masculino}"
													pattern = "^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$" maxlength="60"/>
											</div>
											<div class="col-sm-6">
												<label>Espermaquia</label>
												<input name="{per}_espermaquia" id="{per}_espermaquia"  type="text" class="form-control" value="{per_espermaquia}"
													pattern = "^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$" maxlength="60"/>
											</div>
										</div>
									</div>
									<div id='region_urgo_genital_femenina' name='region_urgo_genital_femenina' style="display:inline;">
										<div class="form-group">
											<div class="col-sm-6">
												<label>Tracto genital femenino</label>
												<input name="{per}_tracto_genital_femenino" id="{per}_tracto_genital_femenino"  type="text" class="form-control" value="{per_tracto_genital_femenino}" 
													pattern = "^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$" maxlength="60"/>
											</div>
											<div class="col-sm-6">
												<label>Menstruaci&oacute;n</label>
												<input name="{per}_menstruacion" id="{per}_menstruacion"  type="text" class="form-control" value="{per_menstruacion}" 
													pattern = "^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$" maxlength="60"/>
											</div>
										</div>
										<div class="form-group">
											<div class="col-sm-6">
												<label>Menarquia</label>
												<input name="{per}_menarquia" id="{per}_menarquia"  type="text" class="form-control" value="{per_menarquia}" 
													pattern = "^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$" maxlength="60"/>
											</div>
											<div class="col-sm-6">
												<label>Menapmia</label>
												<input name="{per}_menapmia" id="{per}_menapmia"  type="text" class="form-control" value="{per_menapmia}" 
													pattern = "^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$" maxlength="60"/>
											</div>
										</div>
										<div class="form-group">
											<div class="col-sm-6">
												<label>Gesta</label>
												<input name="{per}_gesta" id="{per}_gesta"  type="text" class="form-control" value="{per_gesta}" 
													pattern = "^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$" maxlength="60"/>
											</div>
											<div class="col-sm-6">
												<label>Partos</label>
												<input name="{per}_partos" id="{per}_partos"  type="text" class="form-control" value="{per_partos}" 
													pattern = "^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$" maxlength="60"/>
											</div>
										</div>
										<div class="form-group">
											<div class="col-sm-6">
												<label>Aborto</label>
												<input name="{per}_aborto" id="{per}_aborto"  type="text" class="form-control" value="{per_aborto}" 
													pattern = "^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$" maxlength="60"/>
											</div>
											<div class="col-sm-6">
												<label>Cesárea</label>
												<input name="{per}_cesarea" id="{per}_cesarea"  type="text" class="form-control" value="{per_cesarea}" 
													pattern = "^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$" maxlength="60"/>
											</div>
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
				<div class='row'>
					<div class="col-sm-12">
						<div class='panel panel-info'>
							<div class='panel-heading'>
								EXTREMIDADES
							</div>
							<div class='panel-collapse collapse in'>
								<div class="form-horizontal">
									<div class="form-group">
										<div class="col-sm-6">
											<label>Superior derecha</label>
											<input name="{per}_superior_derecha" id="{per}_superior_derecha"  type="text" class="form-control" value="{per_superior_derecha}"
												pattern = "^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$" maxlength="60"/>
										</div>
										<div class="col-sm-6">
											<label>Superior izquierda</label>
											<input name="{per}_superior_izquierda" id="{per}_superior_izquierda"  type="text" class="form-control" value="{per_superior_izquierda}"
												pattern = "^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$" maxlength="60"/>
										</div>
									</div>
									<div class="form-group">
										<div class="col-sm-6">
											<label>Inferior derecha</label>
											<input name="{per}_inferior_derecha" id="{per}_inferior_derecha"  type="text" class="form-control" value="{per_inferior_derecha}"
												pattern = "^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$" maxlength="60"/>
										</div>
										<div class="col-sm-6">
											<label>Inferior izquierda</label>
											<input name="{per}_inferior_izquierda" id="{per}_inferior_izquierda"  type="text" class="form-control" value="{per_inferior_izquierda}"
												pattern = "^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$" maxlength="60"/>
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
			<div class='grid'>
				<div class='row'>
					<div class="col-sm-12">
						<div class='panel panel-info'>
							<div class='panel-heading'>
								CAPACIDAD VISUAL
							</div>
							<div class='panel-collapse collapse in'>
								<div class="form-horizontal">
									<div class="form-group">
										<div class="col-sm-6">
											<label>Ojo derecho</label>
											<input name="{per}_ojo_derecho" id="{per}_ojo_derecho"  type="text" class="form-control" value="{per_ojo_derecho}"
												pattern = "^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$" maxlength="60"/>
										</div>
										<div class="col-sm-6">
											<label>Ojo izquierdo</label>
											<input name="{per}_ojo_izquierdo" id="{per}_ojo_izquierdo"  type="text" class="form-control" value="{per_ojo_izquierdo}"
												pattern = "^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$" maxlength="60"/>
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
						<div class='panel panel-info'>
							<div class='panel-heading'>
								CAPACIDAD AUDITIVA
							</div>
							<div class='panel-collapse collapse in'>
								<div class="form-horizontal">
									<div class="form-group">
										<div class="col-sm-6">
											<label>Oido derecho</label>
											<input name="{per}_oido_derecho" id="{per}_oido_derecho"  type="text" class="form-control" value="{per_oido_derecho}"
												pattern = "^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$" maxlength="60"/>
										</div>
										<div class="col-sm-6">
											<label>Oido izquierdo</label>
											<input name="{per}_oido_izquierdo" id="{per}_oido_izquierdo"  type="text" class="form-control" value="{per_oido_izquierdo}"
												pattern = "^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$" maxlength="60"/>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div><!-- /.tab-pane -->
		<div class="tab-pane" id="tab_5">
			<div class="form-horizontal">
				<div class="form-group">
					<div class="col-sm-6">
						<label><span class='fa fa-gavel'></span>&nbsp;Reflejos tendinosos</label>
						<input type="radio" id="{per}_rdb_reflex_tendinosos" name="{per}_rdb_reflex_tendinosos" value="A" {per_reflex_tendinoso_a}> Arreflexia
						<input type="radio" id="{per}_rdb_reflex_tendinosos" name="{per}_rdb_reflex_tendinosos" value="HIPO" {per_reflex_tendinoso_hipo}> Hiporreflexia
						<input type="radio" id="{per}_rdb_reflex_tendinosos" name="{per}_rdb_reflex_tendinosos" value="NORMAL" {per_reflex_tendinoso_normal}> Normal
						<input type="radio" id="{per}_rdb_reflex_tendinosos" name="{per}_rdb_reflex_tendinosos" value="HIPER" {per_reflex_tendinoso_hiper}> Hiperreflexia
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-6">
						<label><span class='fa fa-eye-slash'></span>&nbsp;Reflejos pupilares</label>
						<input type="radio" id="{per}_rdb_reflex_pupilares" name="{per}_rdb_reflex_pupilares" value="A" {per_reflex_pupilares_a}> Arreflexia
						<input type="radio" id="{per}_rdb_reflex_pupilares" name="{per}_rdb_reflex_pupilares" value="HIPO" {per_reflex_pupilares_hipo}> Hiporreflexia
						<input type="radio" id="{per}_rdb_reflex_pupilares" name="{per}_rdb_reflex_pupilares" value="NORMAL" {per_reflex_pupilares_normal}> Normal
						<input type="radio" id="{per}_rdb_reflex_pupilares" name="{per}_rdb_reflex_pupilares" value="HIPER" {per_reflex_pupilares_hiper}> Hiperreflexia
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-6">
						<label>Marcha</label>
						<input name="{per}_marcha" id="{per}_marcha"  type="text" class="form-control" value="{per_marcha}"
							pattern = "^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$" maxlength="60"/>
					</div>
					<div class="col-sm-6">
						<label>Sensibilidad superficial</label>
						<input name="{per}_sens_superficial" id="{per}_sens_superficial"  type="text" class="form-control" value="{per_sens_superficial}"
							pattern = "^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$" maxlength="60"/>
					</div>
					<div class="col-sm-6">
						<label>Profundidad Romberg</label>
						<input name="{per}_profunda_romberg" id="{per}_profunda_romberg"  type="text" class="form-control" value="{per_profunda_romberg}"
							pattern = "^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$" maxlength="60"/>
					</div>
				</div>
			</div>
		</div><!-- /.tab-pane -->
		<div class="tab-pane" id="tab_6">
			<div class="form-horizontal">
				<div class="form-group">
					<div class="col-sm-6">
						<label>Estado mental</label>
						<div class="input-group" style="width: 100%;">
							<span style="width: 25%; font-size:small;" class="input-group-addon">
								<span class='fa fa-commenting'></span></span>
							<input name="{per}_estado_mental" id="{per}_estado_mental"  type="text" class="form-control" value="{per_estado_mental}"
								pattern = "^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$" maxlength="60"/>
						</div>
					</div>
					<div class="col-sm-6">
						<label>Memoria</label>
						<div class="input-group" style="width: 100%;">
							<span style="width: 25%; font-size:small;" class="input-group-addon">
								<span class='fa fa-hourglass-o'></span></span>
							<input name="{per}_memoria" id="{per}_memoria"  type="text" class="form-control" value="{per_memoria}"
								pattern = "^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$" maxlength="60"/>
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-6">
						<label>Irritabilidad</label>
						<div class="input-group" style="width: 100%;">
							<span style="width: 25%; font-size:small;" class="input-group-addon">
								<span class='fa fa-coffee'></span></span>
							<input name="{per}_irritabilidad" id="{per}_irritabilidad"  type="text" class="form-control" value="{per_irritabilidad}"
								pattern = "^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$" maxlength="60"/>
						</div>
					</div>
					<div class="col-sm-6">
						<label>Depresi&oacute;n</label>
						<div class="input-group" style="width: 100%;">
							<span style="width: 25%; font-size:small;" class="input-group-addon">
								<span class='fa fa-frown-o'></span></span>
							<input name="{per}_depresion" id="{per}_depresion"  type="text" class="form-control" value="{per_depresion}"
								pattern = "^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$" maxlength="60"/>
						</div>
					</div>
				</div>
			</div>
		</div><!-- /.tab-pane -->
		<div class="tab-pane" id="tab_7">
			<div class="form-horizontal">
				<div class="form-group">
					<div class="col-sm-12">
						<div class='panel panel-info'>
							<div class='panel-heading'>
								CONCLUSIONES/OBSERVACIONES
							</div>
							<div class='panel-collapse collapse in'>
								<div class="form-horizontal">
									<div class="form-group">
										<div class="col-sm-12">
											<textarea name="{per}_aptitud_trabajo" id="{per}_aptitud_trabajo"  type="text" class="form-control" 
												placeholder="(500 caracteres máximo)"
												pattern = "^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$" maxlength="500"/>{per_aptitud_trabajo}</textarea>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div><!-- /.tab-pane -->
		<div class="tab-pane" id="tab_8">
			<div class="grid">
				<div class="row">
					<div class="col-md-12 col-sm-12">
						<div class='panel panel-default'>
							<div class='panel-heading'>
								<table style='width:100%'>
									<tr>
										<td style='text-align:left;'>
											Cirugías
										</td>
										<td style='text-align:right;'>
											<button type="button" class="btn bg-purple" onclick="js_ficha_add_cirugia('div_tbl_cirugia', '{per}', '' );">
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
											<div id="div_tbl_cirugia" name="div_tbl_cirugia">{div_resultado_tbl_cirugia}</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div><!-- /.tab-pane -->
		
		<div class="tab-pane" id="tab_9">
			<div class="grid">
				<div class="row">
					<div class="col-md-12 col-sm-12">
						<div class='panel panel-success'>
							<div class='panel-heading'>
								<table style='width:100%'>
									<tr>
										<td style='text-align:left;'>
											Exámenes de laboratorio
										</td>
										<td style='text-align:right;'>
											<button type="button" class="btn bg-olive" onclick="js_ficha_add_ex_lab_clinico('div_tbl_ex_lab_clinico', '{per}', '' );">
												<i class='fa fa-plus'></i>&nbsp;Agregar</button>
										</td>
									</tr>
								</table>
							</div>
							<div class='panel-collapse collapse in'>
								<div class="grid">
									<div class="row">
										<div class="col-sm-12">
											<div id="div_tbl_ex_lab_clinico" name="div_tbl_ex_lab_clinico">{div_resultado_tbl_ex_lab_clinico}</div>
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
					<div class="col-md-12 col-sm-12">
						<div class='panel panel-danger'>
							<div class='panel-heading'>
								<table style='width:100%'>
									<tr>
										<td style='text-align:left;'>
											Radiograf&iacute;as
										</td>
										<td style='text-align:right;'>
											<button type="button" class="btn bg-maroon" onclick="js_ficha_add_radiografia('div_tbl_radiografia', '{per}', '' );">
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
											<div id="div_tbl_radiografia" name="div_tbl_radiografia">{div_resultado_tbl_radiografia}</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div><!-- /.tab-pane -->
	</div>
</div>