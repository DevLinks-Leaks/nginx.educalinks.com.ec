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
<!-- Modal Eliminar-->
<div class="modal fade" id="modal_delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header" style='background-color:#d9534f; color:white;'>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Eliminar Precio</h4>
				<input type="hidden" id='hd_price_code' name='hd_price_code' value='' />
			</div>
			<div class="modal-body" id="modal_delete_body" style='text-align:center;'>
				¿Está seguro que desea eliminar el precio?
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger"  data-dismiss="modal" onclick='js_precios_del_followed( );'>
				<i class='fa fa-trash'></i> Eliminar</button>
				<button type="button" class="btn btn-default" data-dismiss="modal"><i class='fa fa-ban' style='color:red;'></i> Cancelar</button>

			</div>
		</div>
    </div>
</div>
<div class='panel panel-info dismissible' id='panel_search' name='panel_search'>
	<div class="panel-heading">
		<h3 class="panel-title">
			<a href="#/" class="boton_busqueda" style='text-decoration:none;'><span class="fa fa-search"></span>&nbsp;Búsqueda</a>
			<div class="pull-right">
				<a href="#/" class="boton_busqueda" style='text-decoration:none;'><span class='fa fa-minus'></span></a>
			</div>
		</h3>
	</div>
	<div class="panel-body" id="desplegable_busqueda" name="desplegable_busqueda">
		<div class="form-horizontal" role="form">
			<div class='col-md-6 col-sm-12'>
				<div class='row'>
					<div class='col-md-12 col-sm-12'>
						<div class='form-group'>
							<label class="col-md-4 col-sm-3 control-label" style='text-align: right;' for='txt_cod_cliente'>Categoria:</label>
							<div class="col-md-8 col-sm-8">
								{combo_categoria}
							</div>
						</div>
					</div>
					<div class='col-md-12 col-sm-12'>
						<div class='form-group'>
							<label class="col-md-4 col-sm-3 control-label" style='text-align: right;' for='txt_nom_cliente'>Producto:</label>
							<div class="col-md-8 col-sm-8"
									data-placement="bottom"
									title='Nombre del cliente representado'
									onmouseover='$(this).tooltip("show")'>
								<div id="resultadoProducto">
									{combo_producto}
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class='col-md-6 col-sm-12' style='text-align:center;'>
				<!--<button class="btn btn-danger" type="button"
					id='btn_search' name='btn_search'
					data-placement="bottom"
					title='Descargar historial de precios del item seleccionado'
					onmouseover='$(this).tooltip("show")'
					onclick="js_precios_historico();"><i class='fa fa-clock-o'></i> <i class='fa fa-file-excel-o'></i></button>-->
			</div>
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