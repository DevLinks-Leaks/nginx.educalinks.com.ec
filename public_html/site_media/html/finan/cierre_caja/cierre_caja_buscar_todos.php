<!-- Modal Editar-->
<div class="modal fade" id="modal_edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Visor de Cierre de Caja - Reportes de Cierre de Caja</h4>
      </div>
      <div class="modal-body">
        <div>
          <!-- Nav tabs -->
          <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#modal_edit_body" aria-controls="Reporte Items" role="tab" data-toggle="tab">Items</a></li>
            <li role="presentation"><a href="#modal_edit_body_fp" aria-controls="Reporte Forma de Pagos" role="tab" data-toggle="tab">Forma de Pago</a></li>
			<li role="presentation"><a href="#modal_edit_body_nc" aria-controls="Reporte Nota de Creditos" role="tab" data-toggle="tab">Notas de Cr&eacute;dito</a></li>
          </ul>
          <!-- Tab panes -->
          <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="modal_edit_body">...</div>
            <div role="tabpanel" class="tab-pane" id="modal_edit_body_fp">...</div>
			<div role="tabpanel" class="tab-pane" id="modal_edit_body_nc">...</div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button></div>
    </div>
  </div>
</div>
<!-- Modal Editar-->
<div class="box box-default">
	<div class="box-header">
	</div>
	<div class="box-body">
		<div id="resultado">
			{tabla}
		</div>
	</div>
</div>