<!-- Modal Editar-->
<div class="modal fade" id="modal_edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Editar Punto de Emisión</h4>
			</div>
			<form id='frm_ptoEmisionAdd' name='frm_ptoEmisionAdd' 
					onsubmit="return save_edited(document.getElementById('pto_codigo').value, 'resultado','{ruta_html_finan}/puntos_emision/controller.php')" role="form" data-toggle="validator">
				<div class="modal-body" id="modal_edit_body">
					...
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
					<button type="submit" class="btn btn-success"><span class='glyphicon glyphicon-floppy-disk'></span>&nbsp;Guardar cambios</button>
				</div>
			</form>
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
				<h4 class="modal-title" id="myModalLabel">Registro de nuevo punto de emisión</h4>
			</div>
			<form id='frm_ptoEmisionAdd' name='frm_ptoEmisionAdd' 
					onsubmit="return add('resultado','{ruta_html_finan}/puntos_emision/controller.php')" role="form" data-toggle="validator">
				<div class="modal-body" id="modal_add_body">
					...
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
					<button type="submit" class="btn btn-success"><span class='glyphicon glyphicon-floppy-disk'></span>&nbsp;Guardar nuevo</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- Modal Agregar-->
<!-- Modal Asignar-->
<div class="modal fade" id="modal_asign" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Asignar usuario al punto de emisión</h4>
      </div>
      <div class="modal-body">
		  <div id="modal_asign_body">
		  ...
		  </div>
		  <div  id="modal_asign_footer">
		  ...
          </div>
      </div>
	  
      <div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button> 
      </div>
    </div>
  </div>
</div>
<!-- Modal Asignar-->
<!-- <div class="col-sm-3">
	<input type="text" class="form-control" id="busq" name="busq" placeholder="buscar..." onkeyup="busca(this.value,'resultado','{ruta_html_finan}/puntos_emision/controller.php')" />
</div>-->
<div class="box box-default">
	<div class="box-header with-border">
		<h3 class="box-title">
			<button class="btn btn-primary" type="button" aria-hidden='true' data-toggle='modal' data-target='#modal_add' 
					onclick="carga_add('modal_add_body','{ruta_html_finan}/puntos_emision/controller.php')" {disabled_agregar_sucursal}
					id='btn_sucursal_new' name='btn_sucursal_new'
					data-placement='right' onmouseover='$(this).tooltip("show")' title='Agregar nuevo punto de emisión'>
				<span class='glyphicon glyphicon-tent'></span>&nbsp;<span class='fa fa-plus'></span></button>
		</h3>
	</div>
	<div class="box-body">
		<div id="resultado">
			{tabla}
		</div>
	</div>
</div>