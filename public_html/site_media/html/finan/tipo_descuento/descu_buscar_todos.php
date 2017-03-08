<!-- Modal Editar-->
<div class="modal fade" id="modal_edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Editar Tipo de Descuento</h4>
      </div>
      <div class="modal-body" id="modal_edit_body">
      ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success" data-dismiss="modal" 
			onclick="save_edited(document.getElementById('codigo_mod').value,'resultado','{ruta_html_finan}/tipo_descuento/controller.php')">
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
        <h4 class="modal-title" id="myModalLabel">Nuevo Tipo de Descuento</h4>
      </div>
      <div class="modal-body" id="modal_add_body">
      ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success" data-dismiss="modal" onclick="add('resultado','{ruta_html_finan}/tipo_descuento/controller.php')">
			<span class='glyphicon glyphicon-floppy-disk'></span>&nbsp;Guardar Cambios</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal Agregar-->
<div class="box box-default">
	<div class="box-header with-border">
		<h3 class="box-title">
			<button class="btn btn-primary" type="button" aria-hidden='true' data-toggle='modal' data-target='#modal_add' 
				onclick="carga_add('modal_add_body','{ruta_html_finan}/tipo_descuento/controller.php')" {disabled_agregar_descuento}>
					<i class='fa fa-percent'></i></span>&nbsp;<i class='fa fa-plus'></i></button>
		</h3>
	</div>
	<div class="box-body">
		<!--<div class="col-lg-4 col-sm-6 input-group input-group-sm">
			<span id="span_balance_reason" name="span_balance_reason" class="input-group-addon">Ver</span>
			<select id='cmb_mostrarDes' name='cmb_mostrarDes' class='form-control'>
				<option value='zzz'>- Todos los descuentos -</option>
				<option value='0' selected='selected'>- Descuentos del sistema -</option>
				<option value='1' >- Descuento para convenio de pago -</option>
			</select>
			<span class="input-group-btn">
				<button type="button" class="btn btn-info btn-flat" onClick='js_saldoaFavor_filter();'>Ir</button>
			</span>
		</div>-->
		<div id="resultado">
			{tabla}
		</div>
	</div>
</div>