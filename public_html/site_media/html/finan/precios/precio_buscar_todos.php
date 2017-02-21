<!-- Modal Agregar-->
<div class="modal fade" id="modal_add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Agregar Precio</h4>
			</div>
			<form id='frm_pago' name='frm_pago' 
					onsubmit="return validaAdd('resultado','{ruta_html_finan}/precios/controller.php')" role="form" data-toggle="validator">
				<div class="modal-body">
					<div id="modal_add_body">
						...
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
					<!--<button type="button" class="btn btn-primary" onclick="add('resultado','{ruta_html_finan}/precios/controller.php')">Guardar Cambios</button>-->
					<button type="submit" class="btn btn-primary">Guardar Cambios</button>
				</div>
			</form>
		</div>
    </div>
</div>
<!-- Modal Agregar-->
<div class="form-medium">
    <div class="form-group">
		<label for="codigoCategoria_busq">Categoria</label>
		{combo_categoria}      
    </div>
    <div class="form-group">
		<label for="codigoProducto_busq">Producto</label>
		<div id="resultadoProducto">
			{combo_producto}      
		</div>
    </div>
</div>

<div class="box box-default">
	<div class="box-header with-border">
		<h3 class="box-title">
			<button class="btn btn-primary" type="button" aria-hidden='true' data-toggle='modal' data-target='#modal_add' onclick="carga_add('modal_add_body','{ruta_html_finan}/precios/controller.php')" title='Agregar precio'>
				<i class='fa fa-usd'></i>&nbsp;<i class='fa fa-plus'></i></button>
		</h3>
	</div>
	<div class="box-body">
		<div id="resultado">
			{tabla}
		</div>
	</div>
</div>