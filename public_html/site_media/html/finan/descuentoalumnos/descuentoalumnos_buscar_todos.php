<!-- Modal Editar-->
<div class="modal fade" id="modal_edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Editar &Iacute;m</h4>
      </div>
      <div class="modal-body" id="modal_edit_body">
      ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="edit(document.getElementById('codigo_mod').value,'resultado','{ruta_html_finan}/items/controller.php')">Guardar Cambios</button>
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
        <h4 class="modal-title" id="myModalLabel">Agregar &Iacute;tem</h4>
      </div>
      <div class="modal-body" id="modal_add_body">
      ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="add('resultado','{ruta_html_finan}/items/controller.php')">Guardar Cambios</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal Agregar-->
<!-- <div class="form-medium">
    <div class="form-group">
    <input type="text" class="form-control" id="busq" name="busq" placeholder="buscar..." onkeyup="busca(this.value,'resultado','{ruta_html_finan}/descuentoalumnos/controller.php')" />
    </div>
   
</div>-->
<div class="box box-default">
	<div class="box-header">
		<h3 class="box-title"></h3>
	</div><!-- /.box-header -->
	<div class="box-body">
		<div id="resultado">
			{tabla}
		</div>
	</div>
</div>