<?php 
	session_start();	 
	include ('../framework/dbconf.php');
	include ('../framework/funciones.php');?>  
<div class="main_lista">
<?php 
	if(isset($_POST['texto'])) $texto=$_POST['texto'];		
	else   $texto='%';
	$sql="{call str_commonParametros_info}";
	$para_sist_busq = sqlsrv_query($conn, $sql, $params);  
	$row_para_sist = sqlsrv_fetch_array($para_sist_busq);
	$cc = 0;
?>
<div class="modal fade" id="modal_save_prev" tabindex="-1" role="dialog" aria-labelledby="modal_save_prev" aria-hidden="false" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header" style='background-color:#1A286A'>
				<h4 class="modal-title" id="modal_save_prev" style='color:white;'>
					<i style="font-size:large;color:white;" class="fa fa-cog fa-spin"></i>&nbsp;<i style="font-size:large;color:white;" class="fa fa-save"></i>&nbsp;Educalinks informa</h4>
			</div>
			<div class="modal-body" id="modal_save_prev_body" style='background-color:#f4f4f4;'>
				Está a punto de cambiar la configuración del sistema. Es probable que el comportamiento de ciertas funcionalidades cambien a partir de ahora.<br>
				<br>
				<p align='center'>¿Está seguro que desea continuar?</p>
			</div>
			<div class="modal-footer" style='background-color:#f4f4f4;'>
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
				<button type="button" class="btn btn-primary" id='btn_save_param' name='btn_save_param'
					onclick="js_param_list_save()">
						<span class='fa fa-wrench'></span>&nbsp;Guardar configuración</button>
			</div>
		</div>
	</div>
</div>
<form method="POST" id="frm_parametros_sistema" name="frm_parametros_sistema" action='para_sistema_main.php'>
	<div class='panel panel-primary'>
		<div class='panel-heading' style='text-align:center;'>
			<?php echo $_SESSION['menu_institucion']; ?>
			<br>
			MÓDULOS ACTIVOS
		</div>
		<div class='panel-collapse collapse in'>
			<div class="grid">
				<div class="row">
					<div class="col-sm-12"  style='text-align:center;'>
						<br>
						<input type="checkbox" id="ckb_acad" name="ckb_acad"     value="" checked  data-toggle="toggle" data-on="Académico" data-off="Académico" disabled> 
						<input type="checkbox" id="ckb_finan" name="ckb_finan"   value="" <?php echo ($_SESSION['certus_finan'] == 1 ? 'checked':'0'); ?>  data-toggle="toggle" data-on="Financiero" data-off="Financiero" disabled> 
						<input type="checkbox" id="ckb_biblio" name="ckb_biblio" value="" <?php echo ($_SESSION['certus_biblio'] == 1 ? 'checked':'0'); ?>  data-toggle="toggle" data-on="Biblioteca" data-off="Biblioteca" disabled> 
						<input type="checkbox" id="ckb_medic" name="ckb_medic"   value="" <?php echo ($_SESSION['certus_medic'] == 1 ? 'checked':'0'); ?> data-toggle="toggle" data-on="Médico" data-off="Médico" disabled>
						<br>
						<br>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-sm-2"  style='text-align:left;'>
		<div class='panel-collapse collapse in'>
			<div class="grid">
				<div class="row visible-desktop">
					<div class="col-sm-12"  style='text-align:left;'>
						<a class='button_param_menu btn btn-primary btn-block' onclick='js_param_list_navbar(this);' href="#tab_1" data-toggle="tab"><span style="font-size:xx-small;"><i class="fa fa-wrench"></i> Config. general</span></a>
						<a class='button_param_menu btn btn-default btn-block' onclick='js_param_list_navbar(this);' href="#tab_2" data-toggle="tab"><span style="font-size:xx-small;"><i class="fa fa-university"></i> Config. de cursos</span></a>
						<a class='button_param_menu btn btn-default btn-block' onclick='js_param_list_navbar(this);' href="#tab_3" data-toggle="tab"><span style="font-size:xx-small;"><i class="fa fa-graduation-cap"></i> Alumnos</span></a>
						<a class='button_param_menu btn btn-default btn-block' onclick='js_param_list_navbar(this);' href="#tab_4" data-toggle="tab"><span style="font-size:xx-small;"><i class="fa fa-list-alt"></i> Notas y libretas</span></a>
						<a class='button_param_menu btn btn-default btn-block' onclick='js_param_list_navbar(this);' href="#tab_5" data-toggle="tab"><span style="font-size:xx-small;"><i class="fa fa-envelope"></i> Mensajería</span></a>
						<a class='button_param_menu btn btn-default btn-block' onclick='js_param_list_navbar(this);' href="#tab_6" data-toggle="tab"><span style="font-size:xx-small;"><i class="fa fa-child"></i> Módulo alumnos</span></a>
						<a class='button_param_menu btn btn-default btn-block' onclick='js_param_list_navbar(this);' href="#tab_8" data-toggle="tab"><span style="font-size:xx-small;"><i class="fa fa-users"></i> Módulo docentes</span></a>
						<a class='button_param_menu btn btn-default btn-block' onclick='js_param_list_navbar(this);' href="#tab_9" data-toggle="tab"><span style="font-size:xx-small;"><i class="fa fa-heart-o"></i> Módulo representantes</span></a>
						<a class='button_param_menu btn btn-default btn-block' onclick='js_param_list_navbar(this);' href="#tab_10" data-toggle="tab"><span style="font-size:xx-small;"><i class="fa fa-dollar"></i> Módulo financiero</span></a>
						<a class='btn btn-success btn-block' href="#" data-toggle="modal" data-target="#modal_save_prev"><span style="font-size:xx-small;"><i class="fa fa-save"></i> Guardar cambios</span></a>
					</div>
				</div>
				<div class="row visible-phone">
					<div class="col-sm-12"  style='text-align:center;'>
						<div class="btn-group">
							<a class='button_param_menu btn btn-primary' onclick='js_param_list_navbar_sm(this);' href="#tab_1" data-toggle="tab"><span style="font-size:xx-small;" title='Config. general'><i class="fa fa-wrench"></i></span></a>
							<a class='button_param_menu btn btn-default' onclick='js_param_list_navbar_sm(this);' href="#tab_2" data-toggle="tab"><span style="font-size:xx-small;" title='Config. de cursos'><i class="fa fa-university"></i></span></a>
							<a class='button_param_menu btn btn-default' onclick='js_param_list_navbar_sm(this);' href="#tab_3" data-toggle="tab"><span style="font-size:xx-small;" title='Alumnos'><i class="fa fa-graduation-cap"></i></span></a>
							<a class='button_param_menu btn btn-default' onclick='js_param_list_navbar_sm(this);' href="#tab_4" data-toggle="tab"><span style="font-size:xx-small;" title='Notas y libretas'><i class="fa fa-list-alt"></i></span></a>
							<a class='button_param_menu btn btn-default' onclick='js_param_list_navbar_sm(this);' href="#tab_5" data-toggle="tab"><span style="font-size:xx-small;" title='Mensajería'><i class="fa fa-envelope"></i></span></a>
							<a class='button_param_menu btn btn-default' onclick='js_param_list_navbar_sm(this);' href="#tab_6" data-toggle="tab"><span style="font-size:xx-small;" title=' Módulo alumnos'><i class="fa fa-child"></i></span></a>
							<a class='button_param_menu btn btn-default' onclick='js_param_list_navbar_sm(this);' href="#tab_8" data-toggle="tab"><span style="font-size:xx-small;" title='Módulo docentes'><i class="fa fa-users"></i></span></a>
							<a class='button_param_menu btn btn-default' onclick='js_param_list_navbar_sm(this);' href="#tab_9" data-toggle="tab"><span style="font-size:xx-small;"><i class="fa fa-heart-o"></i> Módulo representantes</span></a>
							<a class='button_param_menu btn btn-default' onclick='js_param_list_navbar_sm(this);' href="#tab_10" data-toggle="tab"><span style="font-size:xx-small;"><i class="fa fa-dollar"></i> Módulo financiero</span></a>
							<a class='btn btn-success' href="#" data-toggle="modal" data-target="#modal_save_prev"><span style="font-size:xx-small;" title='Guardar cambios'><i class="fa fa-save"></i></span></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-sm-10"  style='text-align:center;'>
		<div class="nav-tabs-custom">
			<div class="tab-content">
				<div class="tab-pane active" id="tab_1">
					<div class='panel panel-primary'>
						<div class='panel-heading' style='text-align:center;'>
							<i class="fa fa-wrench"></i>  Configuración general
						</div>
					</div>
					<div class="grid">
						<div class='row'>
							<div class="col-sm-12">
								<ul class="nav nav-tabs" role="tablist">
									<li role="presentation" class="active"><a href="#conf_g_tab_1" aria-controls="conf_g_tab_1" role="tab" data-toggle="tab">Información institucional</a></li>
									<li role="presentation"><a href="#conf_g_tab_2" aria-controls="conf_g_tab_2" role="tab" data-toggle="tab">Datos del rector(a) y secretario(a)</a></li>
									<li role="presentation"><a href="#conf_g_tab_3" aria-controls="conf_g_tab_3" role="tab" data-toggle="tab">Datos adicionales</a></li>
								</ul>
								<div class="tab-content">
									<div role="tabpanel" class="tab-pane active" id="conf_g_tab_1">
										<br>
										<input name="es_militar" id="es_militar" type="hidden" class="form-control"
											value="<?php echo $row_para_sist['es_militar'];?>"/>
										<div class="form-horizontal">
											<div class="form-group">
												<div class="col-sm-6">
													<label style='font-size:small;'>Siglas de la institución</label>
													<input name="inst_siglas" id="inst_siglas"  type="text" class="form-control"
														value="<?php echo $row_para_sist['inst_siglas'];?>"
														pattern = "^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$" maxlength="60"/>
												</div>
												<div class="col-sm-6">
													<label style='font-size:small;'>Nombre de la institución</label>
													<input name="inst_nomb" id="inst_nomb"  type="text" class="form-control"
														value="<?php echo $row_para_sist['inst_nomb'];?>"
														pattern = "^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$" maxlength="60"/>
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-6">
													<label style='font-size:small;'>¿Qué poner antes del nombre de la institución?</label>
													<input name="inst_antes_de_su_nombre" id="inst_antes_de_su_nombre"  type="text" class="form-control"
														value="<?php echo $row_para_sist['inst_antes_de_su_nombre'];?>"
														pattern = "^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$" maxlength="60"/>
												</div>
												<div class="col-sm-6">
													<label style='font-size:small;'>Jornada</label>
													<input name="jornada" id="jornada"  type="text" class="form-control"
														value="<?php echo $row_para_sist['jornada'];?>"
														pattern = "^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$" maxlength="60"/>
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-6">
													<label style='font-size:small;'>País del colegio</label>
													<input name="pais" id="pais"  type="text" class="form-control"
														value="<?php echo $row_para_sist['pais'];?>"
														pattern = "^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$" maxlength="60"/>
												</div>
												<div class="col-sm-6">
													<label style='font-size:small;'>Ciudad del colegio</label>
													<input name="ciudad" id="ciudad"  type="text" class="form-control"
														value="<?php echo $row_para_sist['ciudad'];?>" 
														pattern = "^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$" maxlength="60"/>
												</div>
											</div>
										</div>
									</div>
									<div role="tabpanel" class="tab-pane" id="conf_g_tab_2">
										<div class='form-horizontal' style='text-align:left;'>
											<br>
											<div class="form-group">
												<div class="col-sm-12">
													<label style='font-size:small;'>Información del Rector</label>
													<div style='font-size:1px'><hr style='height:1px; margin-top: 0.5em;' /></div>
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-8">
													<label style='font-size:small;'>Etiqueta del rector(a)</label>
												</div>
												<div class="col-sm-4">
													<input name="rector_etiqueta" id="rector_etiqueta"  type="text" class="form-control"
														value="<?php echo $row_para_sist['rector_etiqueta'];?>"
														pattern = "^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$" maxlength="60"/>
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-8">
													<label style='font-size:small;'>Nombre del rector(a)</label>
												</div>
												<div class="col-sm-4">
													<input name="rector_nomb" id="rector_nomb"  type="text" class="form-control"
														value="<?php echo $row_para_sist['rector_nomb'];?>"
														pattern = "^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$" maxlength="60"/>
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-8">
													<label style='font-size:small;'>Sexo del rector(a)</label>
												</div>
												<div class="col-sm-4">
													<input type="checkbox" id="rector_sexo" name="rector_sexo" value="" data-toggle="toggle" data-on="M" data-off="F"
														<?php echo ($row_para_sist['rector_sexo'] == 'M' ? 'checked':'0'); ?>>
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-12">
													<label style='font-size:small;'>Información del Rector</label>
													<div style='font-size:1px'><hr style='height:1px; margin-top: 0.5em;' /></div>
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-8">
													<label style='font-size:small;'>Etiqueta del secretario(a)</label>
												</div>
												<div class="col-sm-4">
													<input name="secr_etiqueta" id="secr_etiqueta"  type="text" class="form-control"
														value="<?php echo $row_para_sist['secr_etiqueta'];?>" 
														pattern = "^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$" maxlength="60"/>
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-8">
													<label style='font-size:small;'>Nombre del secretario(a)</label>
												</div>
												<div class="col-sm-4">
													<input name="secr_nomb" id="secr_nomb"  type="text" class="form-control"
														value="<?php echo $row_para_sist['secr_nomb'];?>"
														pattern = "^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$" maxlength="60"/>
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-8">
													<label style='font-size:small;'>Sexo del secretario(a)</label>
												</div>
												<div class="col-sm-4">
													<input type="checkbox" id="secr_sexo" name="secr_sexo" value="" data-toggle="toggle" data-on="M" data-off="F"
														<?php echo ($row_para_sist['secr_sexo'] == 'M' ? 'checked':'0'); ?>>
												</div>
											</div>
										</div>
									</div>
									<div role="tabpanel" class="tab-pane" id="conf_g_tab_3">
										<br>
										<div class="form-horizontal">
											<div class="form-group">
												<div class="col-sm-6">
													<label style='font-size:small;'>Antes del nombre del distrito educativo</label>
													<input name="distr_antes_de_su_nombre" id="distr_antes_de_su_nombre"  type="text" class="form-control"
														value="<?php echo $row_para_sist['distr_antes_de_su_nombre'];?>"
														pattern = "^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$" maxlength="60"/>
												</div>
												<div class="col-sm-6">
													<label style='font-size:small;'>Nombre del distrito educativo</label>
													<input name="distr_educativo_nomb" id="distr_educativo_nomb"  type="text" class="form-control"
														value="<?php echo $row_para_sist['distr_educativo_nomb'];?>"
														pattern = "^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$" maxlength="60"/>
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-6">
													<label style='font-size:small;'>Nombre del repr. financiero</label>
													<input name="financiero_nombre" id="financiero_nombre"  type="text" class="form-control"
														value="<?php echo $row_para_sist['financiero_nombre'];?>"
														pattern = "^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$" maxlength="60"/>
												</div>
												<div class="col-sm-6">
													<label style='font-size:small;'>Nombre legal de la institución</label>
													<input name="inst_nombre_legal" id="inst_nombre_legal"  type="text" class="form-control"
														value="<?php echo $row_para_sist['inst_nombre_legal'];?>" 
														pattern = "^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$" maxlength="60"/>
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-6">
													<label style='font-size:small;'>Dirección del colegio</label>
													<input name="inst_dir" id="inst_dir"  type="text" class="form-control"
														value="<?php echo $row_para_sist['inst_dir'];?>"
														pattern = "^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$" maxlength="60"/>
												</div>
												<div class="col-sm-6">
													<label style='font-size:small;'>Enlace Página Oficial</label>
													<input name="url_oficial" id="url_oficial"  type="text" class="form-control"
														value="<?php echo $row_para_sist['url_oficial'];?>"
														pattern = "^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$" maxlength="60"/>
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-6">
													<label style='font-size:small;'>Nombre Coordinación Zonal</label>
													<input name="coordinacion_zonal_nomb" id="coordinacion_zonal_nomb"  type="text" class="form-control"
														value="<?php echo $row_para_sist['coordinacion_zonal_nomb'];?>"
														pattern = "^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$" maxlength="60"/>
												</div>
												<div class="col-sm-6">
													<label style='font-size:small;'>Enlace Página Acádemico</label>
													<input name="url_pagina_academico" id="url_pagina_academico"  type="text" class="form-control"
														value="<?php echo $row_para_sist['url_pagina_academico'];?>"
														pattern = "^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$" maxlength="60"/>
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-6">
													<label style='font-size:small;'>Código AMIE</label>
													<input name="codigo_AMIE" id="codigo_AMIE"  type="text" class="form-control"
														value="<?php echo $row_para_sist['codigo_AMIE'];?>"
														pattern = "^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$" maxlength="60"/>
												</div>
												<div class="col-sm-6">
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="tab-pane" id="tab_2">
					<div class='panel panel-primary'>
						<div class='panel-heading' style='text-align:center;'>
							<i class="fa fa-university"></i>  Configuración de cursos
						</div>
					</div>
					<div class="grid">
						<div class="row">
							<div class="col-sm-4">
								<label style='font-size:small;'>Valor inicial de cupos</label>
								<input name="curso_cupos" id="curso_cupos"  type="number" class="form-control" value="<?php echo $row_para_sist["curso_cupos"]; ?>"
									pattern = "^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$" min="0"/>
							</div>
						</div>
					</div>
				</div><!-- /.tab-pane -->
				<div class="tab-pane" id="tab_3">
					<div class='panel panel-primary'>
						<div class='panel-heading' style='text-align:center;'>
							<i class="fa fa-graduation-cap"></i> Alumnos
						</div>
					</div>
					<ul class="nav nav-tabs" role="tablist">
						<li role="presentation" class="active"><a href="#c_alum_tab_1" aria-controls="c_alum_tab_1" role="tab" data-toggle="tab">Conf. general</a></li>
						<li role="presentation"><a href="#c_alum_tab_2" aria-controls="c_alum_tab_2" role="tab" data-toggle="tab">Conf. Matriculación</a></li>
						<li role="presentation"><a href="#c_alum_tab_3" aria-controls="c_alum_tab_3" role="tab" data-toggle="tab">Conf. de uso de formulario de alumno</a></li>
					</ul>
					<div class="tab-content">
						<div role="tabpanel" class="tab-pane active" id="c_alum_tab_1">
							<br>
							<div class='form-horizontal' style='text-align:left;'>
								<div class="form-group">
									<div class="col-sm-8">
										<label style='font-size:small;'>Incluir alumnos retirados en Nómina Matr.</label>
									</div>
									<div class="col-sm-4">
										<input type="checkbox" id="incluir_alum_ret" name="incluir_alum_ret" value="" data-toggle="toggle" data-on="SI" data-off="NO"
											<?php echo ($row_para_sist['incluir_alum_ret'] == '1' ? 'checked':'0'); ?>>
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-8">
										<label style='font-size:small;'>Modo de Generación de códigos de alumnos</label>
									</div>
									<div class="col-sm-4">
										<input type="checkbox" id="modo_genera_alum_codi" name="modo_genera_alum_codi" value="" data-toggle="toggle" data-on="P" data-off="D"
											<?php echo ($row_para_sist['modo_genera_alum_codi'] == '1' ? 'checked':'0'); ?>>
											<button style='font-size:x-small' class="btn btn-success btn-sm" onclick="toggle_modo_genera_alum_codi(1)">POR PROMOCIÓN</button>
											<button style='font-size:x-small' class="btn btn-danger btn-sm"  onclick="toggle_modo_genera_alum_codi(2)">DEFAULT</button>
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-8">
										<label style='font-size:small;'>Incluir bloqueo de preinscripción en pantalla Bloqueo Libreta</label>
									</div>
									<div class="col-sm-4">
										<input type="checkbox" id="bloqueo_preinscr_pantalla_bloqueo" name="bloqueo_preinscr_pantalla_bloqueo" value="" data-toggle="toggle" data-on="SI" data-off="NO"
											<?php echo ($row_para_sist['bloqueo_preinscr_pantalla_bloqueo'] == '1' ? 'checked':'0'); ?>>
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-8">
										<label style='font-size:small;'>Número de dígitos para la generación del código de alumno</label>
									</div>
									<div class="col-sm-4">
										<input type="textbox" class='form-control input-sm' id="alum_codi_digitos" name="alum_codi_digitos"
											value="<?php echo $row_para_sist['alum_codi_digitos'];?>">
									</div>
								</div>
							</div>
						</div>
						<div role="tabpanel" class="tab-pane" id="c_alum_tab_2">
							<br>
							<div class='form-horizontal' style='text-align:left;'>
								<div class="form-group">
									<div class="col-sm-8">
										<label style='font-size:small;'>Mostrar observación en matriculación</label>
									</div>
									<div class="col-sm-4">
										<input type="checkbox" id="show_obs_matri" name="show_obs_matri" value="" data-toggle="toggle" data-on="SI" data-off="NO"
											<?php echo ($row_para_sist['show_obs_matri'] == '1' ? 'checked':'0'); ?>>
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-8">
										<label style='font-size:small;'>Bloquear matrículación a un alumno por no aprobar una o más materias</label>
									</div>
									<div class="col-sm-4">
										<input type="checkbox" id="bloq_matr_por_aprobacion" name="bloq_matr_por_aprobacion" value="" data-toggle="toggle" data-on="SI" data-off="NO"
											<?php echo ($row_para_sist['bloq_matr_por_aprobacion'] == '1' ? 'checked':'0'); ?>>
									</div>
								</div>
							</div>
						</div>
						<div role="tabpanel" class="tab-pane" id="c_alum_tab_3">
							<br>
							<div class='form-horizontal' style='text-align:left;'>
								<div class="form-group">
									<div class="col-sm-8">
										<label style='font-size:small;'>Campo Número de Cuenta en Débito Bancario obligatorio</label>
									</div>
									<div class="col-sm-4">
										<input type="checkbox" id="frm_alum_debito_mandatorio" name="frm_alum_debito_mandatorio" value="" data-toggle="toggle" data-on="SI" data-off="NO"
											<?php echo ($row_para_sist['frm_alum_debito_mandatorio'] == '1' ? 'checked':'0'); ?>>
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-8">
										<label style='font-size:small;'>Campo Número de Cédula Estudiante obligatorio</label>
									</div>
									<div class="col-sm-4">
										<input type="checkbox" id="frm_alum_cedula_mandatorio" name="frm_alum_cedula_mandatorio" value="" data-toggle="toggle" data-on="SI" data-off="NO"
											<?php echo ($row_para_sist['frm_alum_cedula_mandatorio'] == '1' ? 'checked':'0'); ?>>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div><!-- /.tab-pane -->
				<div class="tab-pane" id="tab_4">
					<div class='panel panel-primary'>
						<div class='panel-heading' style='text-align:center;'>
							<i class="fa fa-list-alt"></i> Notas y libretas
						</div>
					</div>
					<div class='form-horizontal' style='text-align:left;'>
						<div class="form-group">
							<div class="col-sm-8">
								<label style='font-size:small;'><span class='fa fa-key'></span> Mostrar usuario y clave en libretas</label>
							</div>
							<div class="col-sm-4">
								<input type="checkbox" id="libretas_show_user_pass" name="libretas_show_user_pass" value="" data-toggle="toggle" data-on="SI" data-off="NO"
									<?php echo ($row_para_sist['libretas_show_user_pass'] == '1' ? 'checked':'0'); ?>>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-8">
								<label style='font-size:small;'>Manejo de decimales en libretas</label>
							</div>
							<div class="col-sm-4">
								<input type="checkbox" id="notas_decimales" name="notas_decimales" value="" data-toggle="toggle" data-on="T" data-off="R"
									<?php echo ($row_para_sist['notas_decimales'] == '1' ? 'checked':'0'); ?>>
									<button class="btn btn-success" onclick="toggle_notas_decimales(1)">TRUNCAR</button>
									<button class="btn btn-danger"  onclick="toggle_notas_decimales(2)">REDONDEAR</button>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-8">
								<label style='font-size:small;'>Cantidad de decimales en notas</label>
							</div>
							<div class="col-sm-4">
								<input type="textbox" class='form-control input-sm' id="cantidad_decimales" name="cantidad_decimales"
									value="<?php echo $row_para_sist['cantidad_decimales'];?>">
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-8">
								<label style='font-size:small;'>Mínima nota aceptable para aprobar el supletorio</label>
							</div>
							<div class="col-sm-4">
								<input type="textbox" class='form-control input-sm' id="min_aceptable_supl" name="min_aceptable_supl"
									value="<?php echo $row_para_sist['min_aceptable_supl'];?>">
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-8">
								<label style='font-size:small;'>Número máximo de deudas vencidas permitidas hasta bloquear la visualización de libretas en la impresión por lotes y en el módulo de representantes</label>
							</div>
							<div class="col-sm-4">
								<input type="textbox" class='form-control input-sm' id="vista_libr_repr" name="vista_libr_repr"
									value="<?php echo $row_para_sist['vista_libr_repr'];?>">
							</div>
						</div>
					</div>
				</div><!-- /.tab-pane -->
				<div class="tab-pane" id="tab_5">
					<div class='panel panel-primary'>
						<div class='panel-heading' style='text-align:center;'>
							<i class="fa fa-envelope"></i> Mensajería
						</div>
					</div>
					<div class="form-horizontal" style='text-align:left;'>
						<div class="form-group">
							<div class="col-sm-12">
								<label style='font-size:small;'><span class='fa fa-child'></span>&nbsp;ALUMNOS</label>
								<div style='font-size:1px'><hr style='height:1px; margin-top: 0.5em;' /></div>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-8">
								<label style='font-size:small;'>Permitir que alumnos puedan enviar menajes a Administradores</label>
							</div>
							<div class="col-sm-4">
								<input type="checkbox" id="sms_alum_to_admin" name="sms_alum_to_admin" value="S" data-toggle="toggle" data-on="SI" data-off="NO"
									<?php echo ($row_para_sist['sms_alum_admin'] == 'A' ? 'checked':'0'); ?>>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-8">
								<label style='font-size:small;'>Permitir que alumnos puedan enviar mensajes a Docentes</label>
							</div>
							<div class="col-sm-4">
								<input type="checkbox" id="sms_alum_to_teacher" name="sms_alum_to_teacher" value="S" data-toggle="toggle" data-on="SI" data-off="NO"
									<?php echo ($row_para_sist['sms_alum_doc'] == 'A' ? 'checked':'0'); ?>>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-8">
								<label style='font-size:small;'>Permitir que alumnos puedan enviar mensajes a Alumnos</label>
							</div>
							<div class="col-sm-4">
								<input type="checkbox" id="sms_alum_to_alum" name="sms_alum_to_alum" value="S" data-toggle="toggle" data-on="SI" data-off="NO"
									<?php echo ($row_para_sist['sms_alum_alum'] == 'A' ? 'checked':'0'); ?>>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-8">
								<label style='font-size:small;'>Permitir que alumnos puedan enviar mensajes a Representantes</label>
							</div>
							<div class="col-sm-4">
								<input type="checkbox" id="sms_alum_to_repr" name="sms_alum_to_repr" value="S" data-toggle="toggle" data-on="SI" data-off="NO"
									<?php echo ($row_para_sist['sms_alum_repr'] == 'A' ? 'checked':'0'); ?>>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-12">
								<label style='font-size:small;'><span class='fa fa-heart-o'></span>&nbsp;REPRESENTANTES</label>
								<div style='font-size:1px'><hr style='height:1px; margin-top: 0.5em;' /></div>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-8">
								<label style='font-size:small;'>Permitir que representantes puedan enviar menajes a Administradores</label>
							</div>
							<div class="col-sm-4">
								<input type="checkbox" id="sms_repr_to_admin" name="sms_repr_to_admin" value="S" data-toggle="toggle" data-on="SI" data-off="NO"
									<?php echo ($row_para_sist['sms_repr_admin'] == 'A' ? 'checked':'0'); ?>>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-8">
								<label style='font-size:small;'>Permitir que representantes puedan enviar mensajes a Docentes</label>
							</div>
							<div class="col-sm-4">
								<input type="checkbox" id="sms_repr_to_teacher" name="sms_repr_to_teacher" value="S" data-toggle="toggle" data-on="SI" data-off="NO"
									<?php echo ($row_para_sist['sms_repr_doc'] == 'A' ? 'checked':'0'); ?>>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-8">
								<label style='font-size:small;'>Permitir que representantes puedan enviar mensajes a Alumnos</label>
							</div>
							<div class="col-sm-4">
								<input type="checkbox" id="sms_repr_to_alum" name="sms_repr_to_alum" value="S" data-toggle="toggle" data-on="SI" data-off="NO"
									<?php echo ($row_para_sist['sms_repr_alum'] == 'A' ? 'checked':'0'); ?>>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-8">
								<label style='font-size:small;'>Permitir que representantes puedan enviar mensajes a Representantes</label>
							</div>
							<div class="col-sm-4">
								<input type="checkbox" id="sms_repr_to_repr" name="sms_repr_to_repr" value="S" data-toggle="toggle" data-on="SI" data-off="NO"
									<?php echo ($row_para_sist['sms_repr_repr'] == 'A' ? 'checked':'0'); ?>>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-12">
								<label style='font-size:small;'><span class='fa fa-users'></span>&nbsp;DOCENTES</label>
								<div style='font-size:1px'><hr style='height:1px; margin-top: 0.5em;' /></div>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-8">
								<label style='font-size:small;'>Permitir que docentes puedan enviar menajes a Administradores</label>
							</div>
							<div class="col-sm-4">
								<input type="checkbox" id="sms_repr_to_admin" name="sms_repr_to_admin" value="S" data-toggle="toggle" data-on="SI" data-off="NO"
									<?php echo ($row_para_sist['sms_doc_admin'] == 'A' ? 'checked':'0'); ?>>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-8">
								<label style='font-size:small;'>Permitir que docentes puedan enviar mensajes a Docentes</label>
							</div>
							<div class="col-sm-4">
								<input type="checkbox" id="sms_teacher_to_teacher" name="sms_teacher_to_teacher" value="S" data-toggle="toggle" data-on="SI" data-off="NO"
									<?php echo ($row_para_sist['sms_doc_doc'] == 'A' ? 'checked':'0'); ?>>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-8">
								<label style='font-size:small;'>Permitir que docentes puedan enviar mensajes a alumnos</label>
							</div>
							<div class="col-sm-4">
								<input type="checkbox" id="sms_teacher_to_alum" name="sms_teacher_to_alum" value="S" data-toggle="toggle" data-on="SI" data-off="NO"
									<?php echo ($row_para_sist['sms_doc_alum'] == 'A' ? 'checked':'0'); ?>>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-8">
								<label style='font-size:small;'>Permitir que docentes puedan enviar mensajes a Representantes</label>
							</div>
							<div class="col-sm-4">
								<input type="checkbox" id="sms_teacher_to_repr" name="sms_teacher_to_repr" value="S" data-toggle="toggle" data-on="SI" data-off="NO"
									<?php echo ($row_para_sist['sms_doc_repr'] == 'A' ? 'checked':'0'); ?>>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-12">
								<label style='font-size:small;'><span class='fa fa-star'></span>&nbsp;ADMINISTRADORES</label>
								<div style='font-size:1px'><hr style='height:1px; margin-top: 0.5em;' /></div>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-8">
								<label style='font-size:small;'>Los administradores pueden enviar mensajes a todos los alumnos, representantes y docentes</label>
							</div>
						</div>
					</div>
				</div><!-- /.tab-pane -->
				<div class="tab-pane" id="tab_6">
					<div class='panel panel-primary'>
						<div class='panel-heading' style='text-align:center;'>
							<i class="fa fa-child"></i> Módulo alumnos
						</div>
					</div>
					<div class="form-horizontal" style='text-align:left;'>
						<div class="form-group">
							<div class="col-sm-8">
								<label style='font-size:small;'><span class='fa fa-photo'></span> Hacer que alumnos cambien foto</label>
							</div>
							<div class="col-sm-4">
								<input type="checkbox" id="sms_alum_to_admin" name="sms_alum_to_admin" value="S" data-toggle="toggle" data-on="SI" data-off="NO"
									<?php echo ($row_para_sist['mod_alum_cambiar_foto'] == '1' ? 'checked':'0'); ?>>
							</div>
						</div>
					</div>
				</div><!-- /.tab-pane -->
				<div class="tab-pane" id="tab_7">
					<div class='panel panel-primary'>
						<div class='panel-heading' style='text-align:center;'>
							<i class="fa fa-comment-o"></i> Conclusión/Aptitudes
						</div>
					</div>
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
													<textarea name="aptitud_trabajo" id="aptitud_trabajo"  type="text" class="form-control" 
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
					<div class='panel panel-primary'>
						<div class='panel-heading' style='text-align:center;'>
							<i class="fa fa-users"></i> Módulo docentes
						</div>
					</div>
					<div class="form-horizontal" style='text-align:left;'>
						<div class="form-group">
							<div class="col-sm-8">
								<label style='font-size:small;'><span class='fa fa-calendar'></span> Manejo de Citas (Para que aparezca las citas en el menu de docente)</label>
							</div>
							<div class="col-sm-4">
								<input type="checkbox" id="sms_alum_to_admin" name="sms_alum_to_admin" value="S" data-toggle="toggle" data-on="SI" data-off="NO"
									<?php echo ($row_para_sist['mod_doc_citas'] == '1' ? 'checked':'0'); ?>>
							</div>
						</div>
					</div>
				</div>
				<div class="tab-pane" id="tab_9">
					<div class='panel panel-primary'>
						<div class='panel-heading' style='text-align:center;'>
							<i class="fa fa-heart-o"></i>  Módulo de representantes
						</div>
					</div>
					<div class="form-horizontal" style='text-align:left;'>
						<div class="form-group">
							<div class="col-sm-12">
								<label style='font-size:small;'>Botón de pagos (configuración de caja web)</label>
								<div style='font-size:1px'><hr style='height:1px; margin-top: 0.5em;' /></div>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-12">
								<button onclick='js_general_config_bdp();' type='button' class='btn btn-app'><i class='fa fa-edit'></i>&nbsp;Configurar</button>
							</div>
						</div>
					</div>
				</div><!-- /.tab-pane -->
				<div class="tab-pane" id="tab_10">
					<div class='panel panel-primary'>
						<div class='panel-heading' style='text-align:center;'>
							<i class="fa fa-dollar"></i> Módulo financiero
						</div>
					</div>
					<div class="grid">
						<div id="alta_usuario" class="form-medium" >
							<!-- Nav tabs -->
							<ul class="nav nav-tabs" role="tablist">
								<li role="presentation" class="active"><a href="#valores_general" aria-controls="valores_general" role="tab" data-toggle="tab">General</a></li>
								<li <?php echo ( permiso_activo(226) ? '' : 'style="display:none;"');?> role="presentation"><a href="#interaccion_contifico" aria-controls="interaccion_contifico" role="tab" data-toggle="tab">Contífico</a></li>
								<li role="presentation"><a href="#interaccion_sistema" aria-controls="interaccion_sistema" role="tab" data-toggle="tab">Interacción entre módulos del sistema</a></li>
							</ul>
							<!-- Tab panes -->
							<div class="tab-content">
								<div role="tabpanel" class="tab-pane active" id="valores_general">
									<div class="form-horizontal" style='text-align:left;'>
										<br>
										<div class="form-group">
											<div class="col-sm-8">
												<label style='font-size:small;'>Porcentaje del I.V.A.</label>
											</div>
											<div class="col-sm-4">
												<div class='input-group'>
													<input type="text" class="form-control" name="desc_prepago" id="desc_prepago" placeholder="Ingrese el porcentaje de descuento"
														value='<?php echo $row_para_sist['iva']; ?>' required="required"><span class="input-group-addon" >%</span>
												</div>
											</div>
										</div>
										<div class="form-group">
											<div class="col-sm-8">
												<label style='font-size:small;'>Aplicar cambio del IVA a todas las deudas por cobrar con abono 0.</label>
											</div>
											<div class="col-sm-4">
												<input type="checkbox" id="usa_pp_dv" name="usa_pp_dv" value="S" data-toggle="toggle" data-on="SI" data-off="NO"
													<?php echo ($row_para_sist['usa_pp_dv'] == '1' ? 'checked':'0'); ?>>
											</div>
										</div>
										<div class="form-group">
											<div class="col-sm-8">
												<label style='font-size:small;'>Envío de facturas al SRI</label>
											</div>
											<div class="col-sm-4">
												<input type="checkbox" id="check_enviar_fac_sri_en_cobro" name="check_enviar_fac_sri_en_cobro" 
													value="S" data-toggle="toggle" data-on="SI" data-off="NO"
													<?php echo ($row_para_sist['enviar_fac_sri_en_cobro'] == 'S' ? 'checked':'0'); ?>> Intentar enviar factura(s) al SRI al cobrar una o más deudas en la ventana de "Cobrar deuda".
											</div>
										</div>
										<div class="form-group">
											<div class="col-sm-8">
												<label style='font-size:small;'>Envío de cheques a bandeja de validación</label>
											</div>
											<div class="col-sm-4">
												<input type="checkbox" id="check_enviar_cheque_a_bandeja" name="check_enviar_cheque_a_bandeja"
													value="S" data-toggle="toggle" data-on="SI" data-off="NO"
													<?php echo ($row_para_sist['enviar_cheque_a_bandeja'] == 'S' ? 'checked':'0'); ?>> Mandar los cheques a la bandeja de validar cheques para esperar a su aprobación.
											</div>
										</div>
										<div class="form-group">
											<div class="col-sm-8">
												<label style='font-size:small;'>Porcentaje de descuento en deudas que apliquen al prontopago</label>
											</div>
											<div class="col-sm-4">
												<div class="input-group">
													<input type="text" class="form-control" name="desc_pronto" id="desc_pronto" placeholder="Ingrese el porcentaje de descuento"  value='<?php echo $row_para_sist['prontopago']; ?>'
													required="required"><span class="input-group-addon">%</span>
												</div>
											</div>
										</div>
										<div class="form-group">
											<div class="col-sm-8">
												<label style='font-size:small;'>Método de aplicación de descuentos a las deudas.</label>
											</div>
											<div class="col-sm-4">
												<div class="checkbox">
													<label>
														<input type="radio" id="rdb_metodo_descuento" name="rdb_metodo_descuento" value="desc_sobre" 
															<?php echo ($row_para_sist['metodo_descuento_alumno'] == 'desc_sobre' ? 'checked':'0'); ?>> Aplicar descuento sobre descuento<br>
														<input type="radio" id="rdb_metodo_descuento" name="rdb_metodo_descuento" value="desc_sumado"
															<?php echo ($row_para_sist['metodo_descuento_alumno'] == 'desc_sumado' ? 'checked':'0'); ?>> Sumar todos los descuento asignados y restar el total de la suma de los porcentajes.
													</label>
												</div>
											</div>
										</div>
										<div class="form-group">
											<div class="col-sm-8">
												<label style='font-size:small;'>Característica del descuento con fecha límite y abonos parciales
													<div id='EducaLinksHelperCliente' style='display:inline;font-size:small;text-align:left;vertical-align:middle;'>
														<a  tabindex="0" data-toggle="popover" data-placement='left'
															title="<a href='../../finan/tipo_descuento/' target='_blank'>Descuento con fecha límite</a>" data-content="<div style='font-size:x-small'>Son descuentos que tienen un tiempo de validez que se determina cuando se asigna a un alumno.</div>"><span class='fa fa-info-circle'></span></a>
														<a  tabindex="0" data-toggle="popover" data-placement='top'
															title="<a href='../tipo_descuento/' target='_blank'>Opción de no eliminar el descuento cuando se hace abono</a>" data-content="<div style='font-size:x-small'>Esta opción permite determinar si el descuento no se elimina si es que se ha recibido un abono parcial a una deuda que tenga asignado un descuento con fecha límite de validez.</div>"><span class='fa fa-info-circle'></span></a>
													</div>
												</label>
											</div>
											<div class="col-sm-4">
												<div class="checkbox">
													<label>
														<input type="checkbox" id="check_quitar_limite_dias_validez" name="check_quitar_limite_dias_validez"
															value="S" data-toggle="toggle" data-on="SI" data-off="NO"
															<?php echo ($row_para_sist['quitar_limite_dias_validez'] == 'S' ? 'checked':'0'); ?>> Hacer que el descuento no se elimine nunca si se recibe un abono parcial dentro de los días en los que el descuento es considerado válido.
														
													</label>
												</div>
											</div>
										</div>
										<div class="form-group">
											<div class="col-sm-8">
												<label style='font-size:small;'></label>
											</div>
											<div class="col-sm-4">
												
											</div>
										</div>
									</div>
								</div>
								<div role="tabpanel" class="tab-pane" id="interaccion_contifico">
									<br>
									<div class="form-horizontal" style='text-align:left;'>
										<div class="form-group">
											<div class="col-sm-12">
												<p style='font-size:small;'>Las <b>API KEY</b> y <b>API KEY TOKEN</b> son claves entregadas por Contífico para poder enviar las deudas a sus sistema contable, siempre que haya activado una cuenta con ellos.</p>
												<div style='font-size:1px'><hr style='height:1px; margin-top: 0.5em;' /></div>
											</div>
										</div>
										<div class="form-group">
											<div class="col-sm-8">
												<label style='font-size:small;'>APY KEY</label>
											</div>
											<div class="col-sm-4">
												<div class="input-group">
													<input type="text" class="form-control" name="txt_config_apikey" id="txt_config_apikey" placeholder="API KEY"
														value='<?php echo $row_para_sist['apikeycontifico']; ?>' disabled='disabled'
														required="required"><span class="input-group-addon" ><i class='fa fa-key'></i></span>
													</div>
											</div>
										</div>
										<div class="form-group">
											<div class="col-sm-8">
												<label style='font-size:small;'>APY KEY TOKEN</label>
											</div>
											<div class="col-sm-4">
												<div class="input-group">
													<input type="text" class="form-control" name="txt_config_apikey_token" id="txt_config_apikey_token" placeholder="API KEY TOKEN" 
														value='<?php echo $row_para_sist['apikeytoken']; ?>' disabled='disabled'
														required="required"><span class="input-group-addon" ><i class='fa fa-key'></i></span>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div role="tabpanel" class="tab-pane" id="interaccion_sistema">
									<br>
									<div class="form-horizontal" style='text-align:left;'>										
										<div class="form-group">
											<div class="col-sm-12">
												<label style='font-size:small;'>Interacción entre el módulo académico - financiero</label>
												<div style='font-size:1px'><hr style='height:1px; margin-top: 0.5em;' /></div>
											</div>
										</div>
										<div class="form-group">
											<div class="col-sm-8">
												<label style='font-size:small;'>Bloqueo al acceso de libretas a los deudores.</label>
											</div>
											<div class="col-sm-4">
												<input type="checkbox" id="check_bloqueo" name="check_bloqueo"
													value="S" data-toggle="toggle" data-on="SI" data-off="NO"
													<?php echo ($row_para_sist['bloqueo'] == 'true' ? 'checked':'0'); ?>>
											</div>
										</div>
										<div class="form-group">
											<div class="col-sm-8">
												<label style='font-size:small;'>Generar deuda de ítems 'matrícula' al matricular a un estudiante.</label>
											</div>
											<div class="col-sm-4">
												<input type="checkbox" id="check_genera_deuda_matr" name="check_genera_deuda_matr"
													value="S" data-toggle="toggle" data-on="SI" data-off="NO"
													<?php echo ($row_para_sist['generar_deuda_matricula'] == 'S' ? 'checked':'0'); ?>>
											</div>
										</div>
										<div class="form-group">
											<div class="col-sm-8">
												<label style='font-size:small;'>Bloquear matriculación si el estudiante tiene deudas pendientes.</label>
											</div>
											<div class="col-sm-4">
												<input type="checkbox" id="check_bloqueo_matr_por_deuda" name="check_bloqueo_matr_por_deuda"
													value="S" data-toggle="toggle" data-on="SI" data-off="NO"
													<?php echo ($row_para_sist['bloquear_matricula_deuda'] == 'S' ? 'checked':'0'); ?>>
											</div>
										</div>
										<div class="form-group">
											<div class="col-sm-12">
												<label style='font-size:small;'>Botón de pagos (módulo representantes)</label>
												<div style='font-size:1px'><hr style='height:1px; margin-top: 0.5em;' /></div>
											</div>
										</div>
										<div class="form-group">
											<div class="col-sm-12">
												<button onclick='js_general_config_bdp();' type='button' class='btn btn-app'><i class='fa fa-edit'></i>&nbsp;Configurar</button>
											</div>
										</div>
										<div class="form-group">
											<div class="col-sm-12">
												<label style='font-size:small;'>Interacción entre el módulo biblioteca - financiero</label>
												<div style='font-size:1px'><hr style='height:1px; margin-top: 0.5em;' /></div>
											</div>
										</div>
										<div class="form-group">
											<div class="col-sm-8">
												<label style='font-size:small;'>Generar deuda de multa por atraso de entrega de libros.</label>
											</div>
											<div class="col-sm-4">
												<input type="checkbox" id="check_biblio_genera_multa_por_mora" name="check_biblio_genera_multa_por_mora"
													value="S" data-toggle="toggle" data-on="SI" data-off="NO"
													<?php echo ($row_para_sist['biblio_genera_multa_por_mora'] == 'S' ? 'checked':'0'); ?>>
											</div>
										</div>
										<div class="form-group">
											<div class="col-sm-8">
												<label style='font-size:small;'>Bloquear préstamo de libro si el estudiante tiene deudas pendientes.</label>
											</div>
											<div class="col-sm-4">
												<input type="checkbox" id="check_biblio_bloquea_prestamo_por_deuda" name="check_biblio_bloquea_prestamo_por_deuda"
													value="S" data-toggle="toggle" data-on="SI" data-off="NO"
													<?php echo ($row_para_sist['biblio_bloquea_prestamo_por_deuda'] == 'S' ? 'checked':'0'); ?>>
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
	</div>
</form>