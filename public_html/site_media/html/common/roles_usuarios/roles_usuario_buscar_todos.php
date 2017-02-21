<!-- Modal Editar-->
<div class="modal fade" id="modal_edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Editar Rol de Usuario</h4>
      </div>
      <div class="modal-body" id="modal_edit_body">
      ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="save_edited(document.getElementById('rol_codigo').value,'resultado','{ruta_html}/roles_usuarios/controller.php')">Guardar Cambios</button>
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
        <h4 class="modal-title" id="myModalLabel">Agregar Rol de Usuario</h4>
      </div>
      <div class="modal-body" id="modal_add_body">
      ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="add('resultado','{ruta_html}/roles_usuarios/controller.php')">Guardar Cambios</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal Agregar-->
<div class="form-medium">
    <div class="form-group">
    <input type="text" class="form-control" id="busq" name="busq" placeholder="buscar..." onkeyup="busca(this.value,'resultado','{ruta_html}/roles_usuarios/controller.php')" />
    </div>
    <div class="form-group">
    <button class="btn btn-success" type="button" aria-hidden='true' data-toggle='modal' data-target='#modal_add' onclick="carga_add('modal_add_body','{ruta_html}/roles_usuarios/controller.php')">Agregar Rol de Usuario</button>
    </div>
</div>
<div id="resultado">
	{tabla}
</div>