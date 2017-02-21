<!-- Modal Editar-->
<div class="modal fade" id="modal_edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Reporte de Notas de Cr&eacute;dito</h4>
			</div>
			<div class="modal-body" id="modal_edit_body">
			 ...
			 </div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
			</div>
		</div>
	</div>
</div>
<!-- Modal Editar-->
<div class="grid">
	<div class="row">
		<div id="div_comboCajeros" class='col-sm-1'>
			<label class="control-label" for="comboUsuarios">Cajero</label>
		</div>
		<div id="div_comboCajeros" class='col-sm-3'>
			{combo_cajero}
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
				<button type="button" 
						style="float:right " 
						class="btn btn-primary" aria-hidden="true" data-toggle="modal"  data-target="#modal_edit" 
						onclick=" carga_reports_notaCredito('modal_edit_body','{ruta_html_finan}/rep_notaCredito/controller.php','print_rep_notaCredito')" >
						<span class="glyphicon glyphicon-print"></span>&nbsp;Imprimir</button>
			</div>
		</div>
	</div>
</div>