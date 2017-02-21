<!-- Modal Editar-->
<div class="modal fade" id="modal_edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Editar Punto de Emisión</h4>
      </div>
      <div class="modal-body" id="modal_edit_body">
      ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="save_edited(document.getElementById('pto_codigo').value,'resultado','{ruta_html}/puntos_emision/controller.php')">Guardar Cambios</button>
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
        <h4 class="modal-title" id="myModalLabel">Agregar Punto de Emisión</h4>
      </div>
      <div class="modal-body" id="modal_add_body">
      ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="add('resultado','{ruta_html}/puntos_emision/controller.php')">Guardar Cambios</button>
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
        <h4 class="modal-title" id="myModalLabel">Asignar Usuario al Punto de Emisión</h4>
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
<div class="form-medium">
    <div class="form-group">
    <input type="text" class="form-control" id="busq" name="busq" placeholder="buscar..." onkeyup="busca(this.value,'resultado','{ruta_html}/puntos_emision/controller.php')" />
    </div>
    <div class="form-group">
    <button class="btn btn-success" type="button" aria-hidden='true' data-toggle='modal' data-target='#modal_add' onclick="carga_add('modal_add_body','{ruta_html}/puntos_emision/controller.php')">Agregar Punto de Emisión</button>
    </div>
</div>
<div id="resultado">
  {tabla}
</div>