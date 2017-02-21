<!-- Modal Buscar cliente -->
<div class="modal fade" id="modal_busquedaCliente" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Búsqueda de cliente</h4>
      </div>
      <div class="modal-body" id="modal_busquedaCliente_body">
      ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="selecciona('{ruta_html_finan}/notaCredito/controller.php')">Seleccionar</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal Buscar cliente -->

<!-- Modal Agregar valor a reducir -->
<div class="modal fade" id="modal_addValorNC" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Valor a reducir</h4>
      </div>
      <div class="modal-body" id="modal_addValorNC_body">
      ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="addDetalleNC('{ruta_html_finan}/notaCredito/controller.php')">Agregar</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal Agregar valor a reducir -->

<!-- Modal para mostrar el resultado del pago -->
<div class="modal fade" id="modal_resultadoNC" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Resultado de la operación</h4>
      </div>
      <div class="modal-body" id="modal_resultadoNC_body">
      ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default"  data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="ImprimirFactura('{ruta_html_finan}/cobros/controller.php')">Imprimir factura</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal para mostrar el resultado del pago -->



<!-- DEUDAS CLIENTE -->
<div id="deudasPendientesAlumno">
	
	

	<!-- DEUDAS -->
    <div id="deudasnotacredito">
	<fieldset>
	    <legend class="form-inline">
	      <div class="row">
	        <span class="col-xs-4">Deudas pendientes</span>
	        <div class="input-group col-xs-2 col-xs-offset-6">
	          &nbsp;
	        </div>
	      </div>
	    </legend>
	    <div id="resultado" class="form-group"> 
	    	{tabla_deudasPendientes}
	    </div>
	</fieldset> 

	<div id="datosOperacion">
		<fieldset>
        	<legend class="form-inline">
        		<div class="row">
		        	<span class="col-xs-4">Nota de crédito</span>
		        	<div class="input-group col-xs-2 col-xs-offset-6">
		            	<span class="input-group-addon">Total</span>
		            	<input type="text" disabled="true" readonly class="form-control" name="totalValoresNotaCredito" id="totalValoresNotaCredito" placeholder="00.00" required="required">
		        	</div>
		      </div>
        	</legend>

			<div role="tabpanel" id="tbOperacion">
			  <!-- Menu Name tabs -->
			  <ul class="nav nav-tabs" id="tabOperacion" role="tablist">
			    <li role="presentation" class="active"><a href="#cabeceraNC" aria-controls="cabeceraNC" role="tab" data-toggle="tab">Información NC</a></li>
			    <li role="presentation"><a href="#detalleFactura" aria-controls="detalleFactura" role="tab" data-toggle="tab">Detalle Factura</a></li>
			    <li role="presentation"><a href="#detalleNC" aria-controls="detalleNC" role="tab" data-toggle="tab">Detalle NC</a></li>
			  </ul> 
			  <!-- Tab panes -->
			  <div class="tab-content">
			    <div role="tabpanel" class="tab-pane active" id="cabeceraNC">
			    	<!-- =====> CABECERA DE LA FACTURA Y/O NOTA DE CRÉDITO <===== -->
			    	<div class="form-group">
			          <div class="col-md-4">
						<input style="width:100%"  type="text" maxlength="15" class="form-control" id="tipoIdentificacionTitular" name="tipoIdentificacionTitular" placeholder="Tipo Id" readonly="readonly" />
			          </div>
			          <div class="col-md-8">
			            <input style="width:100%"  type="text" maxlength="15" onkeypress="return validaNumerosEnteros(event, this);" class="form-control" id="numeroIdentificacionTitular" name="numeroIdentificacionTitular" placeholder="Numero Id" readonly="readonly" />
			          </div>
			          <div class="col-md-12">
			            <input style="width:100%" type="text" maxlength="50" class="form-control" id="nombreTitular" name="nombreTitular" placeholder="Nombres" readonly="readonly" />
			          </div>
			          <div class="col-md-8">
			            <input style="width:100%" type="email" maxlength="50" class="form-control" id="emailTitular" name="emailTitular" placeholder="email" readonly="readonly" />  
			          </div>
			          <div class="col-md-4">
			            <input style="width:100%" type="text" maxlength="10" onkeypress="return validaNumerosEnteros(event, this);" class="form-control" id="telefonoTitular" name="telefonoTitular" placeholder="Tel." readonly="readonly" />  
			          </div>
			          <div class="col-md-12">
			            <input style="width:100%" type="text" maxlength="100" class="form-control" id="direccionTitular" name="direccionTitular" placeholder="Direccion" readonly="readonly" />
			          </div>
			        </div>
			    </div>
			    <div role="tabpanel" class="tab-pane" id="detalleFactura">
			    	<!-- =====> RESUMEN DE LA CABECERA DE LA FACTURA <===== -->
			    	<div id="" class="row form-group">
				      <div class="col-md-2">
				        <label for="numeroFactura"><h5>N° Factura</h5></label>
				        <div class="input-group">
				          <span class="input-group-addon" id="prefijoSucursal">{prefijoSucursal}</span>
				          <span class="input-group-addon" id="prefijoPuntoVenta">{prefijoPuntoVenta}</span>
				          <input type="text" readonly class="form-control input-sm" id="numeroFactura" name="numeroFactura" value="" placeholder="0000" />
				        </div>
				      </div>  

				      <div class="col-md-2 col-md-offset-0">
				        <label for="codigoFactura"><h5># Factura</h5></label>
				          <input type="text" readonly class="form-control input-sm" id="codigoFactura" name="codigoFactura" placeholder="0000" />
				      </div> 

				      <div class="col-md-2 col-md-offset-0">
				        <label for="totalNetoFactura"><h5>Total Factura</h5></label>
				        <div class="input-group">
				          <span class="input-group-addon">$</span>
				          <input type="text" readonly class="form-control input-sm" id="totalNetoFactura" name="totalNetoFactura" placeholder="00.00" />
                          
				        </div>
                         
				      </div> 
                      
                      <div class="col-md-2 col-md-offset-0">
				        <label for="totalSinImpFactura"><h5>Total Fact Sin Imp.</h5></label>
				        <div class="input-group">
				          <span class="input-group-addon">$</span>
				          <input type="text" readonly class="form-control input-sm" id="totalSinImpFactura" name="totalSinImpFactura" placeholder="00.00" />
                          
				        </div>
                         
				      </div>                      
                      

				       <div class="col-md-2 col-md-offset-0">
				        <label for="totalAbonoFactura"><h5>Total Abono</h5></label>
				        <div class="input-group">
				          <span class="input-group-addon">$</span>
				          <input type="text" readonly class="form-control input-lg" id="totalAbonoFactura" name="totalAbonoFactura" placeholder="00.00" />
				        </div>
				      </div>  

				      <div class="col-md-2 col-md-offset-0">
				        <label for="totalNotaCreditoFactura"><h5>Total N/C</h5></label>
				        <div class="input-group">
				          <span class="input-group-addon">$</span>
				          <input type="text" readonly class="form-control input-lg" id="totalNotaCreditoFactura" name="totalNotaCreditoFactura" placeholder="00.00" />
				        </div>
				      </div>  
				       
				    </div>
				    <!-- DETALLE DE LA FACTURA -->
				    <div id="resultadoDetalleFactura" class="form-group"> 
				    	{tabla_detalleFactura}
				    </div>
			    </div>
			    <div role="tabpanel" class="tab-pane" id="detalleNC">
			    	<!-- =====> DETALLE DE LA NOTA DE CREDITO <===== -->
			    	<div id="resultadoDetalleNotaCredito" class="form-group"> 
					     {tabla_detalleNotaCredito}
					</div>
			    </div>
			  </div>
			</div>
		</fieldset>

		<!-- OPCIONES generaNotaCredito('modal_resultadoNC_body','{ruta_html_finan}/notaCredito/controller.php')-->
		<div class="form-group">
			<button type="button" class="btn btn-default" onclick="limpiaPagina('true')" >Nueva</button>
			<button type="button" class="btn btn-success" aria-hidden="true" data-toggle="modal" data-target="#modal_resultadoNC" onclick="generaNotaCredito('modal_resultadoNC_body','{ruta_html_finan}/notaCredito/controller.php')" {disabled_confirmar_nota_credito}>Confirmar Nota de crédito</button>
		</div>

	</div>
</div>
</div>