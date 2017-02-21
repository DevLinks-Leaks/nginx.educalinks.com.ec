<!-- Modal Editar-->
<div class="modal fade" id="modal_edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Editar Tarjeta de Crédito</h4>
      </div>
      <div class="modal-body" id="modal_edit_body">
      ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success" data-dismiss="modal" 
			onclick="js_tarjetaCredito_save_edited(document.getElementById('tarjeta_codigo').value,'resultado','{ruta_html_finan}/tarjetasCredito/controller.php')">
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
        <h4 class="modal-title" id="myModalLabel">Agregar Tarjeta de Crédito</h4>
      </div>
      <div class="modal-body" id="modal_add_body">
      ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success" data-dismiss="modal" onclick="js_tarjetaCredito_add('resultado','{ruta_html_finan}/tarjetasCredito/controller.php')">
			<span class='glyphicon glyphicon-floppy-disk'></span>&nbsp;Guardar Cambios</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal Agregar-->
<!-- Modal Asignar-->
<div class="modal fade" id="modal_asign" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog-800">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Asignar Banco a la Tarjeta de Crédito</h4>
      </div>
      <div class="modal-body" id="modal_asign_body">
      ...
      </div>
      <div class="modal-footer-left" id="modal_asign_footer">
      ...  
      </div>
    </div>
  </div>
</div>
<!-- Modal Asignar-->
<div class="box box-default">
	<div class="box-header with-border">
		<h3 class="box-title">
			<button class="btn btn-primary" type="button" aria-hidden='true' data-toggle='modal' data-target='#modal_add' 
				onclick="js_tarjetaCredito_carga_add('modal_add_body','{ruta_html_finan}/tarjetasCredito/controller.php')">
					<span class='glyphicon glyphicon-credit-card'></span>&nbsp;<span class='glyphicon glyphicon-plus'></span></button>
		</h3>
	</div>
	<div class="box-body">
		<div id="resultado">
			{tabla}
		</div>
	</div>
</div>