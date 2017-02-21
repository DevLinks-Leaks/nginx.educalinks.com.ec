<!-- Modal Editar-->
<div class="modal fade" id="modal_edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Editar Resultado</h4>
      </div>
      <div class="modal-body" id="modal_edit_body">
      ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success" data-dismiss="modal" onclick="save_edited(document.getElementById('codigo_mod').value,'resultado','{ruta_html_finan}/crm_resultados/controller.php')">
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
        <h4 class="modal-title" id="myModalLabel">Agregar Resultado</h4>
      </div>
      <div class="modal-body" id="modal_add_body">
      ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success" data-dismiss="modal" onclick="add('resultado','{ruta_html_finan}/crm_resultados/controller.php')">
			<span class='glyphicon glyphicon-floppy-disk'></span>&nbsp;Guardar Cambios</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal Agregar-->
<!-- Modal Asigna-->
<div class="modal fade" id="modal_asign" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
		<div id="modal_asign_body">
			...
		</div>
    </div>
  </div>
</div>
<!-- Modal Asigna-->
<!-- <div class="form-group">
<input type="text" class="form-control" id="busq" name="busq" placeholder="buscar..." onkeyup="busca(this.value,'resultado','{ruta_html_finan}/crm_resultados/controller.php')" />
</div>-->
<div class="box box-default">
	<div class="box-header with-border">
		<button class="btn btn-primary" type="button" aria-hidden='true' data-toggle='modal' data-target='#modal_add' 
			onclick="carga_add('modal_add_body','{ruta_html_finan}/crm_resultados/controller.php')" {disabled_agregar_resultado}><i class='fa fa-plus'></i>&nbsp;Agregar Resultado</button>
	</div>
	<div class="box-body">
		<div id="resultado">
			{tabla}
		</div>
	</div>
</div>