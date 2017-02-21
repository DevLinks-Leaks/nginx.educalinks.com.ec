<!-- Modal Editar-->
<div class="modal fade" id="modal_edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg"">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Reportes de facturas emitidas</h4>
      </div>
      <div class="modal-body" id="modal_edit_body" >
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
       
      </div>
    </div>
  </div>
</div>
<!-- Modal Editar-->
<form id="file_form" action="{ruta_html_finan}/rep_facturas/controller.php" enctype="multipart/form-data" method="POST" target="_blank">
	<input type='hidden' name="event" id="evento" value="print_excel"/>
	<input type='hidden' name="tipo_reporte" id="tipo_reporte" value="completo"/>
	<div class="grid">
		<div class="row">
			<div id="div_comboCajeros" class='col-sm-1'>
				<label class="control-label" for="comboUsuarios">Cajero</label>
			</div>
			<div id="div_comboCajeros" class='col-sm-3'>
				{combo_cajas}
			</div>
			<div class="col-sm-6" id="div_fini" name="div_fini" >
				<div class="input-group" id="div_fini" name="div_fini" data-placement="top"
					 title='Fecha de emisión, desde, hasta.'
					 onmouseover='$(this).tooltip("show")'>
					<span class="input-group-addon">
						<input type="checkbox" id='chk_fecha' name='chk_fecha' onclick='check_fecha();' checked>
					</span>
					<span class="input-group-addon">
						<span style="text-align:left;font-size:small;font-weight:bold;">F. emisi&oacute;n</span>
					</span>				
					<span class="input-group-addon">
						<small>Inicio</small></span>
					<input type="text" class="form-control" name="txt_fecha_ini" id="txt_fecha_ini" 
								value="{txt_fecha_ini}" placeholder="dd/mm/yyyy" required="required">
				
					<span class="input-group-addon">
						<small>Fin</small></span>
					<input type="text" class="form-control" name="txt_fecha_fin" id="txt_fecha_fin" 
								value="{txt_fecha_fin}" placeholder="dd/mm/yyyy" required="required">
				</div>
			</div>
			<div class='col-sm-2'>
				<div class="div_button" >
					<button type="button" class='btn btn-default' id='btn_selectFem_excel' name='btn_selectFem_excel' 
						onclick="js_rep_facturas_excel('print_excel','completo');"><span style='color:green;' class='fa fa-file-excel-o'></span>&nbsp;Excel
					</button>
					<button type="button" 
							class="btn btn-default" aria-hidden="true" data-toggle="modal"  data-target="#modal_edit" 
							onclick=" js_rep_facturas_carga_reports_descuentos('modal_edit_body','{ruta_html_finan}/rep_facturas/controller.php','print_cierres')">
							<span style='color:red;' class="fa fa-file-pdf-o"></span>&nbsp;PDF</button>
				</div>
			</div>
		</div>
	</div>
</form>