<!-- Modal Editar-->
<div class="modal fade" id="modal_edit_item" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Editar Item</h4>
			</div>
			<div class="modal-body" id="modal_edit_body">
				...
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
				<button type="button" class="btn btn-success" onclick="saveEditItem('resultado','{ruta_html_finan}/aniosPeriodo/controller.php')">
				<span class='glyphicon glyphicon-floppy-disk'></span>&nbsp;Guardar Cambios</button>
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
				<h4 class="modal-title" id="myModalLabel">Agregar Item a periodo</h4>
			</div>
			<div class="modal-body" id="modal_add_body">
				...
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				<button type="button" class="btn btn-success" onclick="saveAddItem('resultado','{ruta_html_finan}/aniosPeriodo/controller.php')">
				<span class='glyphicon glyphicon-floppy-disk'></span>&nbsp;Guardar cambios</button>
			</div>
		</div>
	</div>
</div>
<!-- Modal Agregar-->
<!-- Modal Deudas-->
<div class="modal fade" id="modal_deudas"   tabindex="-1" role="dialog" data-backdrop="static"  data-keyboard="false" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" style="width:1200px;">
		<div class="modal-content">
			<div class="modal-header">
				<!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button-->
				<h4 class="modal-title" id="myModalLabel">Migrar deudas</h4>
			</div>
			<div id="migrardeudasresult">
				<div class="modal-body" id="modal_deudas_body">
					...
				</div>
				<div class="modal-footer" id="footerdeudas">
					<button type="button" class="btn btn-default" data-dismiss="modal" onclick="js_aniosPeriodo_buscadeudas('resultadomigracion_deudas','{ruta_html_finan}/aniosPeriodo/controller.php')">Cerrar</button>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Modal Deudas-->
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
					<button type="button" class="btn btn-primary" data-dismiss="modal"  onclick="js_aniosPeriodo_senddeudaindividual(document.getElementById('codigodeuda').value,'modal_deudas_body','{ruta_html_finan}/aniosPeriodo/controller.php',document.getElementById('codigomes').value)">Agregar</button>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Modal  Migrar Confirmacion-->
<!-- Modal Generar Deudas-->
<div class="modal fade" id="modal_resultadoLote"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-lg" >
		<div class="modal-content">
			<div class="modal-header">
				<!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
				<h4 class="modal-title" id="myModalLabel">Generar deudas por lote</h4>
			</div>
			<div class="modal-body" id="modal_resultadoLote_body">
				...
			</div>
			<div class="modal-footer">
				<button id="btn_cancela_deuda" type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
				<button id="btn_genera_deuda" type="button" class="btn btn-primary" onclick="generarDeudaLote('modal_resultadoLote_body','frm_generaDeudasLotefrm','{ruta_html_finan}/aniosPeriodo/controller.php')">
				<span class='glyphicon glyphicon-floppy-disk'></span>&nbsp;Generar y guardar</button>
			</div>
		</div>
	</div>
</div>
<!-- Modal Generar Deudas-->
<div class="box box-default">
	<div class="box-header with-border">
		<div class="btn-group">
			<button class="btn btn-primary" type="button" aria-hidden='true' data-toggle='modal' data-target='#modal_add' 
					onclick="carga_add('modal_add_body','{ruta_html_finan}/aniosPeriodo/controller.php')" {disabled_agregar_item}>
					Item&nbsp;<li class='fa fa-plus'></li></button>
			<button class="btn btn-success" type="button" aria-hidden='true' data-toggle='modal' data-target='#modal_resultadoLote' 
					onclick="carga_resultadoLote('modal_resultadoLote_body','{ruta_html_finan}/aniosPeriodo/controller.php')" {disabled_generar_deuda_lote}>
					Generar deudas Lote&nbsp;<li class='fa fa-plus-square'></li></button>
		</div>
		<div class="pull-right">
			Período activo: {periodo_activo}
			<input id="peri_codi" type="hidden" value="{periodo_codigo}" />
		</div>
	</div>
	<div class="box-body">
		<div class="grid">
			<div class="row">
				<div class="col-sm-12">
					<div id="resultado">
						{tabla}
					</div>
				</div>
			</div>
		</div>
	</div>
</div>