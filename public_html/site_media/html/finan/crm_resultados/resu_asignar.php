<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="myModalLabel">Asignar detalle al resultado '{resultado_deta}'</h4>
</div>
<div class="modal-body">
    <div id="frm_ingresoItem" class="form-horizontal" >
		<div class="form-group"> 
			<input type="hidden" name="crm_resu_codigo" id="crm_resu_codigo" value="" />
			<div class="col-sm-1">
				<label for="deta_descripcion_add" class='control-label'>Nombre</label>
			</div>
			<div class="col-sm-6">
				<div class="input-group">
					<input type="text" class="form-control" name="deta_descripcion_add" id="deta_descripcion_add" placeholder="Detalle del Resultado" required="required">
					<span class="input-group-btn">
						<button class="btn btn-default btn-sm" type="button"  onclick="asign_deta(document.getElementById('crm_resu_codigo').value,'resultado_detalles','{ruta_html_finan}/crm_resultados/controller.php')">Agregar</button>
					</span>
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-12">
				<div id="resultado_detalles">
					{tabla_detalles}
				</div>
			</div>
		</div>    
	</div>
</div>
<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
</div>