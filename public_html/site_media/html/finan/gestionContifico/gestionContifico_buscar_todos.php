
<!-- Modal actualizar-->
<div class="modal fade" id="modal_actualizar" tabindex="-1" role="dialog" data-backdrop="static"  data-keyboard="false" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<table width='100%'>
					<tr><td width='50%'><h4 class="modal-title" id="myModalLabel">Actualizacion Facturas</h4></td>
						<td style='text-align:right;'>
							<span id='span_boton_headeractualizar' name='span_boton_headeractualizar'></span>
							<button type="button" class="btn btn-success"
								onclick="js_contabilidad_actualizarfacturas('modal_actualizar_body','{ruta_html_finan}/contabilidad/controller.php')">
								<span class='glyphicon glyphicon-send'></span>&nbsp;Actualizar DNA's por lote</button>
						</td>
					</tr>
				</table>
			</div>
			<div id="migrarfacturasresult">
				<div class="modal-body" id="modal_actualizar_body" style='height:250px;overflow-y:scroll;'>
				...
				</div>
			</div>
			<div class="modal-footer" id="footer_actualizar">
				<button type="button" class="btn btn-default" data-dismiss="modal">Ocultar</button>
			</div>
		</div>
	</div>
</div>
<!-- Modal actualizar--> 
<!-- Modal Editar-->
<div class="modal fade" id="modal_edit" tabindex="-1" role="dialog" data-backdrop="static"  data-keyboard="false"  aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<table width='100%'>
					<tr><td width='50%'><h4 class="modal-title" id="myModalLabel">Migración de Pagos a Contífico</h4></td>
						<td style='text-align:right;'>
							<span id='span_boton_headerpagos' name='span_boton_headerpagos'></span>
							<button class="btn btn-success" type="button"
								onclick="js_contabilidad_migrarfacturas('resultado_pagos','{ruta_html_finan}/contabilidad/controller.php')">
								<span class='glyphicon glyphicon-send'></span>&nbsp;Migrar Pagos por lote</button>
						</td>
					</tr>
				</table>
			</div>
			<div class="modal-body" id="modal_pagos_body" style='height:250px;overflow-y:scroll;'>
			  ...
			</div>
			<div class="modal-footer" id="footerpagos">
				<button type="button" class="btn btn-default" data-dismiss="modal">Ocultar</button>
			</div>
		</div>
	</div>
</div>
<!-- Modal Editar-->
<!-- Modal Agregar-->
<div class="modal fade" id="modal_add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Agregar Item a periodo</h4>
			</div>
			<div class="modal-body" id="modal_add_body" style='height:250px;overflow-y:scroll;'>
			...
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>
<!-- Modal Agregar-->
<!-- Modal Deudas-->
<div class="modal fade" id="modal_deudas"   tabindex="-1" role="dialog" data-backdrop="static"  data-keyboard="false" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<table  width='100%'>
					<tr><td width='50%'><h4 class="modal-title" id="myModalLabel">Migración de deudas a Contífico</h4></td>
						<td style='text-align:right;'>
							<span id='span_boton_headerdeudas' name='span_boton_headerdeudas'></span>
							<button class="btn btn-success" type="button" aria-hidden='true' data-toggle='modal'  
								onclick="js_aniosPeriodo_migrarfacturas('resultado_deudas','{ruta_html_finan}/aniosPeriodo/controller.php')">
									<span class='glyphicon glyphicon-send'></span>&nbsp;Migrar deudas por lote</button>
						</td>
					</tr>
				</table>
			</div> 
			<div class="modal-body" id="modal_deudas_body" style='height:250px;overflow-y:scroll;'>
			...
			</div>
			<div class="modal-footer" id="footerdeudas">
				<button type="button" class="btn btn-default" data-dismiss="modal">Ocultar</button>
			</div>
		</div>
	</div>
</div>
<!-- Modal Deudas-->
<!-- Modal Migrar Pagos mensual por lote Confirmacion-->
<div class="modal fade" id="modal_pagosconfirmacion"   tabindex="-1" role="dialog" data-backdrop="static"  data-keyboard="false" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button-->
				<h4 class="modal-title" id="myModalLabel">Envío de pago individual</h4>
			</div>
			<div id="migrardeudasresult">
				<div class="modal-body" id="modal_pagosconfirmacion_body">
				</div> 
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
					<span id='span_sendpagoindividual_result_button' name='span_sendpagoindividual_result_button'>
						<button type="button" class="btn btn-primary" id='btn_sendpagoindividual' name='btn_sendpagoindividual' onclick="js_contabilidad_senddeudaindividual(document.getElementById('codigodeuda').value,'modal_pagos_body','{ruta_html_finan}/contabilidad/controller.php',document.getElementById('codigomes').value)">Migrar</button>
					</span>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Modal  Migrar Pagos mensual por lote Confirmacion-->
<!-- Modal Migrar Confirmacion-->
<div class="modal fade" id="modal_deudasconfirmacion" tabindex="-1" role="dialog" data-backdrop="static"  data-keyboard="false" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button-->
				<h4 class="modal-title" id="myModalLabel">Envío de deuda individual</h4>
			</div>	
			<div class="modal-body" id="modal_deudasconfirmacion_body">
			</div> 
			<div class="modal-footer" id="footerdeuda_individual">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				<span id='span_senddeudaindividual_result_button' name='span_senddeudaindividual_result_button'>
					<button type="button" class="btn btn-primary" id='btn_senddeudaindividual' name='btn_senddeudaindividual' onclick="js_aniosPeriodo_senddeudaindividual(document.getElementById('codigodeuda').value,'modal_deudasconfirmacion_body','modal_deudas_body','{ruta_html_finan}/aniosPeriodo/controller.php',document.getElementById('codigomes_deudas').value)">Migrar</button>
				</span>
			</div>
		</div>
	</div>
</div>
<!-- Modal  Migrar Confirmacion-->
<!-- Modal Actualizar DNA Confirmacion-->
<div class="modal fade" id="modal_upd_dnas_confirmacion" tabindex="-1" role="dialog" data-backdrop="static"  data-keyboard="false" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button-->
				<h4 class="modal-title" id="myModalLabel">Actualización DNA's individual</h4>
			</div>	
			<div class="modal-body" id="modal_upd_dnas_confirmacion_body">
			</div> 
			<div class="modal-footer" id="footer_upd_dnas_confirmacion">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				<span id='span_upddeudaindividual_result_button' name='span_upddeudaindividual_result_button'>
					<button type="button" class="btn btn-primary" id='btn_upddeudaindividual' name='btn_upddeudaindividual' onclick="js_contabilidad_senddeudaindividualact(document.getElementById('codigodeuda').value,'modal_upd_dnas_confirmacion_body','modal_actualizar_body','{ruta_html_finan}/contabilidad/controller.php',document.getElementById('codigomes_paid_dnas').value)">Migrar</button>
				</span>
			</div>
		</div>
	</div>
</div>
<!-- Modal Actualizar DNA Confirmacion-->
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
	<div class="box-header">
		<p ><b>La migración a contífico consiste de tres pasos sencillos.</b></p>
	</div>
	<div class="box-body">
		<div>
			<ul class="nav nav-tabs" role="tablist">
				<li role="presentation" class="active"><a href="#MigracionDeudas" aria-controls="MigracionDeudas" role="tab" data-toggle="tab"><span id="badge_gest_deudas_in"></span>Enviar deudas&nbsp;</a></li>
				<li role="presentation" ><a href="#MigracionPagos" aria-controls="MigracionPagos" role="tab" data-toggle="tab"><span id="badge_gest_pagos_in"></span>Enviar pagos&nbsp;</a></li>
				<li role="presentation" ><a href="#ActulizacionPagos" aria-controls="ActulizacionPagos" role="tab" data-toggle="tab">Actualizar DNA's a Facturas</a></li>
			</ul>
			<div class="tab-content">
				<div role="tabpanel" class="tab-pane fade in active" id="MigracionDeudas">
					<div class="grid">
						<div class="row">
							<div class="col-sm-12">
								<br>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-12">
								<p style='font-size:small;'><b>1. Envío de deudas</b><br> Para migrar la información a contífico, debe empezar por enviar primero el registro de una deuda.
									Una vez que se envíen las deudas, en contífico se registrarán como Documentos No Autorizados (DNA o DNA's si lo mencionamos en plurar).</p>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-12">
								<br>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-1" style='text-align:left;font-size:small;'>
								<label class='control-label'>Año</label>
							</div>
							<div class="col-sm-3">
								{combo_anual_deudas}
							</div>
						</div>
						<div class="row">
							<div class="col-sm-12">
								<hr>
							</div>
						</div>
						<div class="row">
							<div id="resultadomigracion_deudas" class="col-sm-12">
								{tabla_deuda}
							</div>
						</div>
					</div>
				</div>
				<div role="tabpanel" class="tab-pane fade" id="MigracionPagos">
					<div class="row">
						<div class="col-sm-12">
							<br>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<p style='font-size:small;'><b>2. Envío de pagos</b><br> Una vez enviada las deudas desde Educalinks, y generado los DNA's en Contífico, se procede a enviar
								los pagos que se hicieron sobre esas deudas.</p>
						</div>
					</div>
					<div class="grid">
						<div class="row">
							<div class="col-sm-12">
								<br>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-1" style='text-align:left;font-size:small;'>
								<label class='control-label'>Año</label>
							</div>
							<div class="col-sm-3">
								{combo_anual_pagos}
							</div>
						</div>
						<div class="row">
							<div class="col-sm-12">
								<hr>
							</div>
						</div>
						<div class="row">
							<div id="resultadomigracion_pagos" class="col-sm-12">
								{tabla_pagos}
							</div>
						</div>
					</div>
				</div>
				<div role="tabpanel" class="tab-pane fade" id="ActulizacionPagos">
					<div class="grid">
						<div class="row">
							<div class="col-sm-12">
								<br>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-12">
								<p style='font-size:small;'><b>3. Actualización de DNA's a Facturas</b><br> Ahora que los DNA's tienen registrado sus respectivos pagos, los procedemos a convertir en FACTURAS.</p>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-12">
								<br>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-1" style='text-align:left;font-size:small;'>
								<label class='control-label'>Año</label>
							</div>
							<div class="col-sm-3">
								{combo_anual_pagos_update}
							</div>
						</div>
						<div class="row">
							<div class="col-sm-12">
								<hr>
							</div>
						</div>
						<div class="row">
							<div id="resultadomigracion_paidDNAs" class="col-sm-12">
								{tabla_paidDNAs}
							</div>
						</div>
					</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>