
<!-- Modal Configuraciòn-->
<div class="modal fade" id="modal_configGec" tabindex="-1" role="dialog" aria-labelledby="modal_rep_ModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="modal_rep_ModalLabel"><span class='fa fa-cog'></span>&nbsp;Configuración de grupos económicos<h4>
			</div>
			<div class="modal-body" id="modal_configGec_body">
				<div class="checkbox">
					<label>
						<input type="checkbox" id="check_usar_rango_aut_ingreso" name="check_usar_rango_aut_ingreso"> Asignar grupo económico automáticamente dependiendo del *ingreso mensual familiar.
					</label>
				</div>
				<br>
				<span style='font-size:small;'>*La información del ingreso mensual familiar de cada alumno se registra desde el <b>módulo académico</b>, en el formulario de datos del alumno.</span>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
				<button type="button" class="btn btn-primary" data-dismiss="modal" onClick='js_gruposEconomico_set_config( );'>
					<span class='fa fa-floppy-o'></span>&nbsp;Guardar Cambios</button>
			</div>
		</div>
	</div>
</div>
<!-- /. Modal Configuraciòn-->
<!-- Modal Editar-->
<div class="modal fade" id="modal_edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Editar Grupo</h4>
      </div>
      <div class="modal-body" id="modal_edit_body">
      ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success" 
		onclick="js_gruposEconomico_edit(document.getElementById('codigo_mod').value,'resultado','{ruta_html_finan}/gruposEconomico/controller.php')">
			<span class='glyphicon glyphicon-floppy-disk'></span>&nbsp;Guardar Cambios</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal Editar-->
<!-- Modal Agregar-->
<div class="modal fade" id="modal_add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Agregar Grupo</h4>
      </div>
      <div class="modal-body" id="modal_add_body">
      ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success" onclick="js_gruposEconomico_add('resultado','{ruta_html_finan}/gruposEconomico/controller.php')">
			<span class='glyphicon glyphicon-floppy-disk'></span>&nbsp;Guardar Cambios</button>
      </div>
    </div>
  </div>
</div>
<div id="box_window2_header" name="box_window2_header" class="box box-success">
	<div class="box-header with-border" id='div_main_box_header' main='div_main_box_header'>
		<button class="btn btn-primary" type="button" aria-hidden='true' data-toggle='modal' data-target='#modal_add' 
			onclick="js_gruposEconomico_carga_add('modal_add_body','{ruta_html_finan}/gruposEconomico/controller.php')" {disabled_agregar_grupo}>
			<i class='fa fa-group'></i></span>&nbsp;<i class='fa fa-plus'></i></button>
		<div class="pull-right">						
			<button type="button" class="btn btn-default"
				onclick="js_gruposEconomico_get_config( );"
				aria-hidden='true' data-toggle='modal' data-target='#modal_configGec' {disabled_agregar_banco}>
				&nbsp;<span class='fa fa-cog'></span>&nbsp;</button>
		</div>
	</div>
	<div class="box-body">
		<div class="grid">
			<div class="row">
				<div class="col-sm-12">
					<div id="resultado">
						{tabla}
					</div>
				</div>
			</div>
		</div>
	</div>
</div>