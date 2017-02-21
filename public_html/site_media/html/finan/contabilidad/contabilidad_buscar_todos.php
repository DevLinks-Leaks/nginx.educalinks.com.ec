<!-- Modal Editar-->
<div class="modal fade" id="modal_edit" tabindex="-1" role="dialog" data-backdrop="static"  data-keyboard="false" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content" style="width: 1100px;">
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel">Migración</h4>
			</div>
			<div id="migrardeudasresult">
				<div class="modal-body" id="modal_edit_body">
				...
				</div>
				<div class="modal-footer" id="footerdeudas">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Modal Editar-->
<!-- Modal actualizar-->
<div class="modal fade" id="modal_actualizar" tabindex="-1" role="dialog" data-backdrop="static"  data-keyboard="false" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content" style="width: 1100px;">
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel">Actualizacion Facturas</h4>
			</div>
			<div id="migrarfacturasresult">
				<div class="modal-body" id="modal_actualizar_body">
					...
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Modal actualizar-->
<!-- Modal matchcategorias-->
<div class="modal fade" id="modal_matchcategorias" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Match Categorias</h4>
			</div>
			<div class="modal-body" id="modal_matchcategorias_body">
				...
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary" onclick="guardarcontifico(document.getElementById('cate_codigo').value,'resultado','{ruta_html_finan}/contabilidad/controller.php')">Save changes</button>
			</div>
		</div>
	</div>
</div>
<!-- Modal matchcategorias---->
<!-- Modal matchproductos-->
<div class="modal fade" id="modal_matchproductos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Match Productos</h4>
			</div>
			<div class="modal-body" id="modal_matchproductos_body">
				...
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary" onclick="guardarcontificoproducto(document.getElementById('prod_codigo').value,'resultadoproductos','{ruta_html_finan}/contabilidad/controller.php')">Guardar</button>
			</div>
		</div>
	</div>
</div>
<!-- Modal matchproductos---->
<!-- Modal Migrar Confirmacion-->
<div class="modal fade" id="modal_deudasconfirmacion"   tabindex="-1" role="dialog" data-backdrop="static"  data-keyboard="false" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button-->
				<h4 class="modal-title" id="myModalLabel">Migrar deuda</h4>
			</div>
			<div id="migrardeudasresult">
				<div class="modal-body" id="modal_deudasconfirmacion_body">
				</div> 
				<div class="modal-footer" id="footerdeudas">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
					<button type="button" class="btn btn-primary" data-dismiss="modal"  onclick="senddeudaindividual(document.getElementById('codigodeuda').value,'modal_edit_body','{ruta_html_finan}/contabilidad/controller.php',document.getElementById('codigomes').value)">Agregar</button>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Modal  Migrar Confirmacion-->
<div class="box box-default">
	<div class="box-header">
	</div>
	<div class="box-body">
		<!-- Nav tabs -->
		<ul class="nav nav-tabs" role="tablist">
			<li role="presentation" class="active"><a href="#Categorias" aria-controls="Categorias" role="tab" data-toggle="tab">Categorias</a></li>
			<li role="presentation"><a href="#Productos" aria-controls="Productos" role="tab" data-toggle="tab">Productos</a></li>
		</ul>
		<div class="tab-content">
			<div role="tabpanel" class="tab-pane fade in active" id="Categorias">
				<div class="form-medium">
					<div class="col-sm-12">
						<br>
					</div>
				</div>
				<div class="form-medium">
					<div class="col-sm-12" id="resultado">
						{tabla_categoria}
					</div>
				</div>
			</div>
			<div role="tabpanel" class="tab-pane fade" id="Productos">
				<div class="form-medium">
					<div class="col-sm-12">
						<br>
					</div>
				</div>
				<div class="form-medium">
					<div class="col-sm-12" id="resultadoproductos">
						{tabla_productos}
					</div>
				</div>
			</div>
		</div>
	</div>
</div>