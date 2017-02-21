<!-- Modal Visor Estado de cuenta-->
<div class="modal fade bs-example-modal-lg" id="modal_showDebtState" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header" style="background-color:#f4f4f4">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel" >Estado de cuenta</h4>
			</div>
			<div class="modal-body" id="modal_showDebtState_body" style="background-color:#f4f4f4;">
			...
			</div>
			<div class="modal-footer" style="background-color:#f4f4f4;">
				<button type="button" class="btn btn-success"
					onclick="print_cert_pdf('{ruta_html_finan}/clientes/controller.php')"><i class='fa fa-file-pdf-o'></i>&nbsp;Certificado financiero</button>
				<button type="button" class="btn btn-primary"
					onclick="print_pdf('{ruta_html_finan}/clientes/controller.php')"><i class='fa fa-file-pdf-o'></i>&nbsp;Estado de cuenta</button>
			</div>
		</div>
	</div>
</div>
<!-- /. Modal Visor Estado de cuenta-->
<!-- Modal Buscar cliente -->
<div class="modal fade" id="modal_busquedaCliente" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Busqueda de cliente</h4>
      </div>
      <div class="modal-body" id="modal_busquedaCliente_body">
      ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="selecciona('{ruta_html_finan}/facturas/controller.php')">Seleccionar</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal Buscar cliente -->
<!-- Modal Asignar-->
<div class="modal fade" id="modal_asign" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div id="modal_asign_body">
			...
			</div>
		</div>
	</div>
</div>
<!-- Modal Asignar-->
<!-- Modal Asignar Grupo Economico-->
<div class="modal fade" id="modal_showSetGrupoEconomico" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div id="modal_showSetGrupoEconomico_body">
			...
			</div>
		</div>
	</div>
</div>
<!-- Modal Asignar Grupo Economico-->
<!-- Modal Asignar representante-->
<div class="modal fade" id="modal_asign_repr" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Asignar representante</h4>
			</div>
			<div class="modal-body" id='div_asign_repr' name='div_asign_repr'>
			...
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>
<!-- Modal Asignar representante-->
<!-- Modal Buscar y Agregar producto -->
<div class="modal fade" id="modal_adicionProducto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style='background-color:#D9EDF7;'>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 style='color:#3C8DC7;' class="modal-title" id="myModalLabel">Busqueda de ítem (producto o servicio)</h4>
      </div>
      <div class="modal-body" id="modal_adicionProducto_body" style='background-color:#f4f4f4;'>
      ...
      </div>
      <div class="modal-footer" style='background-color:#f4f4f4;'>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-info" data-dismiss="modal" 
			id="btn_AddItemToDetail" name="btn_AddItemToDetail"
			onclick="AddItemToDetail('{ruta_html_finan}/facturas/controller.php')">Agregar</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal Buscar y Agregar producto -->

<!-- Modal para Editar un producto ya agregado -->
<div class="modal fade" id="modal_modificarLinea" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Actualizacion del detalle</h4>
      </div>
      <div class="modal-body" id="modal_modificacionLinea_body">
      ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="EditDetail('{ruta_html_finan}/facturas/controller.php')">Modificar</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal para Editar un producto ya agregado -->
<!-- Modal para mostrar el resultado de la factura e imprimirla -->
<!-- <form id='frm_deuda' name='frm_deuda' action='../../finan/cobros/controller.php' method='POST'> -->
<div class="modal fade" id="modal_mostrarFactura" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		
			<input type='hidden' id='hdnombresCliente' name='hdnombresCliente' value=''>
			<input type='hidden' id='hdcodigoCliente' name='hdcodigoCliente' value=''>
			<input type='hidden' id='hdnumeroIdentificacionCliente' name='hdnumeroIdentificacionCliente' value=''>
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Resultado de la operación</h4>
				</div>
				<div class="modal-body" id="modal_mostrarFactura_body">
				...
				</div>
				<div class="modal-footer" id='modalFooter_mostrarFactura'>
					<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				</div>
			</div>
		
	</div>
</div>
<!-- /. Modal para mostrar el resultado de la factura e imprimirla -->
<!-- Modal datos persona-->
<div class="modal fade" id="modal_add_per" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" onclick="$('#modal_add_per').modal('hide');" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel"><i class="fa fa-th"></i>&nbsp;Formulario de datos de cliente</h4>
			</div>
			<div class="modal-body" id="modal_add_per_body" name="modal_add_per_body">
				...
			</div>
			<div class="modal-footer" id="modal_add_per_footer" name="modal_add_per_footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				<span id='span_button_save_person' name='span_button_save_person'></span>
			</div>
		</div>
	</div>
</div>
<!-- /. Modal datos persona-->
<div id="div_modal_seleccionar_persona_lista" name="div_modal_seleccionar_persona_lista"></div>
<div class="box box-default">
	<div class="box-header with-border">
		<button type="button" class="btn btn-primary" onclick="limpiaPaginaPreguntar('true')" >
			<span class='glyphicon glyphicon-file'></span>&nbsp;</button>
	</div>
	<div class="box-body">
		<div class='grid'>
			<div id="datosCliente">
				<div class='panel panel-info'>
					<div class="panel-heading">
						<table style='width:100%'>
								<tr>
									<td style='text-align:left;'>
										Cliente
									</td>
									<td style='text-align:right;'>
										<!--<button id="btnBuscarCliente" type="button" 
											class="btn btn-info btn-md" aria-hidden="true" data-toggle="modal" data-target="#modal_busquedaCliente" 
											onclick="carga_busquedaCliente('modal_busquedaCliente_body','{ruta_html_finan}/cobros/controller.php')" {disabled_caja} >
										<span class='glyphicon glyphicon-search'></span>&nbsp;Buscar</button>-->
										<button type="button" class="btn btn-success btn-sm"
												onclick="js_persona_add('span_button_save_person', 'modal_add_per_body', 4, 'genera_deuda'); $('#modal_add_per').modal('show');" >
											<i class='fa fa-plus'></i>&nbsp;Cliente externo</button>
										<button type="button" class="btn btn-info btn-sm" 
											onclick="js_persona_select_user_searchlist_2('span_button_save_person', 'div_modal_seleccionar_persona_lista', '','js_factura_selecciona');">
											<i class="fa fa-search"></i>&nbsp;Buscar</button>
									</td>
								</tr>
							</table>
					</div>
					<div class="panel-footer">
						<div id="datosCliente" name="datosCliente" class="grid">
							<div class="row">
								<div class="col-sm-2">
									<input type="hidden" readonly class="form-control" id="hd_tipo_persona" name="hd_tipo_persona" />
									<input type="text" readonly class="form-control input-sm" id="codigoCliente" name="codigoCliente" placeholder="Código" title="Código del cliente" />
								</div>
								<div class="col-sm-2">
									<input type="text" readonly class="form-control input-sm" id="numeroIdentificacionCliente" name="numeroIdentificacionCliente" placeholder="CI / RUC" />
								</div>
								<div class="col-sm-4">
									<input type="text" readonly class="form-control input-sm" id="nombresCliente" name="nombresCliente" placeholder="Nombres" />
								</div>
								<div class="col-sm-4" style='text-align:right;'>
									<div style='vertical-align:middle;' id='client_options'>{opciones_cliente}</div>
								</div>
							</div>
							<div class="row">
								<div  id='div_datos_academicos_estudiante' name='div_datos_academicos_estudiante' style='display:inline;'>
									<div class="col-sm-4">
										<input  id="txt_curso" type="text" class="form-control input-sm" placeholder="Grado/Curso" disabled style="width:100%" />
									</div>
									<div class="col-sm-4">
										<input id="txt_grupo_economico" type="text" class="form-control input-sm" placeholder="Grupo económico" disabled style="width:100%" />
									</div>
									<div class="col-sm-4">
										<input id="txt_nivel_economico" type="text" class="form-control input-sm" placeholder="Nivel económico" disabled style="width:100%" />
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div id="datosFactura" class='panel panel-info'>
					<div class="panel-heading">
						<table style='width:100%'>
							<tr>
								<td style='text-align:left;'>
									Datos del titular
								</td>
								<td style='text-align:right;'>
								</td>
							</tr>
						</table>
					</div>
					<div class="panel-body">
						<div class="grid">
							<div class="row">
								<div class="col-md-4">
									<input style="width:100%"  type="text" maxlength="15" class="form-control" id="tipoIdentificacionTitular" name="tipoIdentificacionTitular" disabled placeholder="Tipo Id" />
								</div>
								<div class="col-md-8">
									<input style="width:100%"  type="text" maxlength="15" onkeypress="return validaNumerosEnteros(event, this);" class="form-control" id="numeroIdentificacionTitular" name="numeroIdentificacionTitular" disabled placeholder="Numero Id" />
								</div>
								<div class="col-md-12">
									<input style="width:100%" type="text" maxlength="50" class="form-control" disabled id="nombreTitular" name="nombreTitular" placeholder="Nombres" />
								</div>
								<div class="col-md-8">
									<input style="width:100%" type="email" maxlength="50" class="form-control" disabled id="emailTitular" name="emailTitular" placeholder="email" />  
								</div>
								<div class="col-md-4">
									<input style="width:100%" type="text" maxlength="10" onkeypress="return validaNumerosEnteros(event, this);" class="form-control" id="telefonoTitular" name="telefonoTitular" disabled placeholder="Tel." />  
								</div>
								<div class="col-md-12">
									<input style="width:100%" type="text" maxlength="100" class="form-control" disabled id="direccionTitular" name="direccionTitular" placeholder="Direccion" />
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- DETALLE DE LA FACTURA -->
			<div class='panel panel-info'>
				<div class="panel-heading">
					<table style='width:100%'>
						<tr>
							<td style='text-align:left;'>
								Detalle Factura
								<div id='EducaLinksHelperDeudaSeleccionada' class='EducalinksHelper' style='display:inline;font-size:x-small;text-align:left;vertical-align:middle;'>
									<a href='#' onmouseover='$(this).tooltip("show")' 
									   title="Haga click en 'Agregar producto' para continuar." data-placement='right'><span class='glyphicon glyphicon-question-sign'></span></a>
								</div>
							</td>
							<td style='text-align:right;'>
								<button type="button" class="btn btn-info" aria-hidden="true"
									onclick="carga_adicionarProducto('modal_adicionProducto_body','{ruta_html_finan}/facturas/controller.php')" {disabled_agregar_producto}><i class='fa fa-plus'></i>&nbsp;<i class='fa fa-shopping-cart'></i>&nbsp;Agregar ítem</button>
							</td>
						</tr>
					</table>
				</div>
				<div class="panel-collapse collapse in">
					<div class='grid' style="display:block;" >
						<div class="row">
							<div id="resultado"class="col-sm-12">
								{tabla}
							</div>
						</div>
					</div>
				</div>
				<div class="panel-footer">
					<div class="grid">
						<div class="row">
							<div class="col-md-8 col-sm-12">
								<div class="form-group"> 
									<div class="input-group">
										<div class="input-group-addon">
											Fecha inicio cobro
										</div>
										<div class="input-group-addon">
											<i class="fa fa-calendar"></i>
										</div>
										<input type="text" name="fechaInicio_add" id="fechaInicio_add" value='{txt_fecha_ini}'
											class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask required="required">
									</div>
								</div>
								<div class="form-group">
									<div class="input-group">
										<div class="input-group-addon">
											Fecha vencimiento
										</div>
										<div class="input-group-addon">
											<i class="fa fa-calendar"></i>
										</div>
										<input type="text" name="fechaFin_add" id="fechaFin_add" value='{txt_fecha_fin}'
											class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask required="required">
									</div>
								</div>
								<div class="form-group">
									<div class="checkbox">
										<label>
											<input type="checkbox" id="check_generar_FAC" name="check_generar_FAC" checked
												onclick='js_facturas_check_generar_FAC();' > Generar factura
										</label>
									</div>
								</div>
							</div>
							<div class="col-md-4 col-sm-12">
							<!--<div class="col-sm-4 col-md-offset-8">-->
								<div class="input-group">
									<span class="input-group-addon"><strong>Total:</strong> $</span>
									<input type="text" readonly class="form-control input-lg" id="totalNetoFactura" name="totalNetoFactura" placeholder="00.00" />
								</div>
							</div> 
						</div>
					</div>
				</div>
			</div>
		</div>
	</div><!-- /.box-body -->
	<div class="box-footer">
		Generación de deudas.
		<button type="button" id='btn_generar_deuda' name='btn_generar_deuda'
			class="btn btn-primary pull-right" aria-hidden="true" data-toggle="modal" data-target="#modal_mostrarFactura" 
			onclick="generaFactura('modal_mostrarFactura_body','{ruta_html_finan}/facturas/controller.php')" {disabled_generar_deuda}>
				<span class="glyphicon glyphicon-floppy-disk"></span>&nbsp;Generar deuda y factura</button>
	</div>
</div>