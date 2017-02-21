<!-- Modal Editar-->
<div class="modal fade" id="modal_edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Observación de Cheque Protestado</h4>
			</div>
			<div class="modal-body" id="modal_edit_body">
				...
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
				<button type="button" class="btn btn-primary" data-dismiss="modal" onclick="js_validacheques_protestar(document.getElementById('cheq_codigo').value,'resultado','{ruta_html_finan}/valida_cheques/controller.php')">Guardar Cambios</button>
			</div>
		</div>
	</div>
</div>
<!-- Modal Editar-->
<!-- Modal Aprobar-->
<div class="modal fade" id="modal_approve" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Aprobar cheque</h4>
			</div>
			<div class="modal-body" id="modal_approve_body">
				¿Está seguro que desea aprobar el cheque?
				<input type='hidden' id='hd_aprove_cheq_codigo' name='hd_aprove_cheq_codigo' value='' >
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Ahora no, por favor</button>
				<button type="button" class="btn btn-primary" data-dismiss="modal" onclick="js_validacheques_aprobar_followed(document.getElementById('hd_aprove_cheq_codigo').value,'resultado','{ruta_html_finan}/valida_cheques/controller.php')">Aprobar</button>
			</div>
		</div>
	</div>
</div>
<!-- Modal Aprobar-->
<div class="box-body">
	<div class="col-lg-4 col-sm-6 input-group input-group-sm">
		<span id="span_cheq_filtro" name="span_cheq_filtro" class="input-group-addon">Ver</span>
		<select id='cmb_mostrarCheq' name='cmb_mostrarCheq' class='form-control'>
			<option selected='selected' value='PV'>- Cheques por validar -</option>
			<option value='PF'>- Cheques posfechados -</option>
			<option value='PR'>- Cheques protestados -</option>
			<option value='AP'>- Cheques aprobados -</option>
		</select>
		<span class="input-group-btn">
			<button type="button" class="btn btn-info btn-flat" onClick='js_validacheques_filter();'>Ir</button>
		</span>
	</div>
	<br>
	<div id="resultado">
		{tabla}
	</div>
</div>