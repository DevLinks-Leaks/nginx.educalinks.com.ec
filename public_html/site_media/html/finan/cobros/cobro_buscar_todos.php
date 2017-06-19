<!-- Modal Cargando-->
<div class="modal modal-transparent fade" id="modal_msg" tabindex="-1"  data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Educalinks informa</h4>
			</div>
            <div class="modal-body" id="modal_msg_body" style='text-align:center;font-size:small;'>
                <div align="center" style="height:100%;">
					Por favor, espere
					<br>
					<br>
					<i style="color:darkred;" class="fa fa-cog fa-spin"></i>
				</div>
            </div>
			<div class="modal-footer" id="modal_msg_footer">
				<button type="button" class="btn btn-primary" data-dismiss="modal">Ocultar</button>
			</div>
        </div>
    </div>
</div>
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
<!-- Modal Mostrar detalles de los pagos de la deuda 
<div class="modal fade" id="modal_showPayments" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog-900">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Detalle de pagos</h4>
      </div>
      <div class="modal-body" id="modal_showPayments_body">
      ...
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="modal_showDetails" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog-900">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Detalle de deuda</h4>
      </div>
      <div class="modal-body" id="modal_showDetails_body">
      ...
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>
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
        <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="selecciona('{ruta_html_finan}/cobros/controller.php')">Seleccionar</button>
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
<!-- Modal Agregar pago -->
<div class="modal fade" id="modal_agregarPago" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Agregar pago</h4>
			</div>
			<form id='frm_agregarPago' name='frm_agregarPago' nonvalidate='false'
				onsubmit="return validaAgregarPago('{ruta_html_finan}/cobros/controller.php')" role="form" data-toggle="validator" nonvalidate='false'>
				<div class="modal-body">
					<div id="modal_agregarPago_body">...</div>
					<table><tr><td height='1px' >
						<div id='frm_PagoError' class='alert alert-error' style='display:none;'>&nbsp;</div>
							</td></tr></table>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
					<button type="submit" class="btn btn-success"><span class='glyphicon glyphicon-grain'></span>&nbsp;Agregar</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- Modal Agregar pago -->

<!-- Modal Editar pago -->
<div class="modal fade" id="modal_editarPago" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Editar pago</h4>
			</div>
			<form id='frm_editarPago' name='frm_editarPago'
				onsubmit="return validaEditarPago('{ruta_html_finan}/cobros/controller.php');" role="form" data-toggle="validator" nonvalidate='false'>
				<div class="modal-body">
					<div id="modal_editarPago_body">
						...
					</div>
				</div>
				<!-- <table width='100%'>
					<tr>
						<td width='50%' height='1px' style='text-align:left;'><div id='resultadoMetadataEditarPago' class='alert alert-error'></div></td>
						<td width='50%' height='1px' style='text-align:right;'></td>
					</tr>
					<tr>
						<td width='50%' height='1px' style='text-align:left;'><div id='frm_EditarPagoError' class='alert alert-error'></div></td>
						<td width='50%' height='1px' style='text-align:right;'></td>
					</tr>
				</table>-->

				<div class="modal-footer">
					<!-- <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="editarPago();">Editar</button> -->
					<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
					<button type="submit" class="btn btn-primary">Editar</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- Modal Editar pago -->

<!-- Modal para mostrar el resultado del pago -->
<div class="modal fade" id="modal_resultadoPago" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header" id='modal_resultadoPago_header'>
				<h4 class="modal-title" id="myModalLabel">Resultado de la operación</h4>
			</div>
			<div class="modal-body" id="modal_resultadoPago_body">
				...
			</div>
			<div class="modal-footer"  id='modal_resultadoPago_foot' style='text-align:center;'>
				<button type='button' onclick='window.location.replace("../../../finan/gestionFacturas/")'; id='btn_modal_resultadoPago_gestionFac' name='btn_modal_resultadoPago_gestionFac' 
					class="btn btn-block btn-sm btn-warning" data-dismiss="modal">
					<i class='fa fa-barcode'></i>&nbsp;Ir a gestión facturas</a>
				<button type='button' onclick='window.location.replace("../../../finan/pagos/");' id='btn_modal_resultadoPago_pagos' name='btn_modal_resultadoPago_pagos'
					class="btn btn-block btn-sm btn-primary" data-dismiss="modal">
					<i class='fa fa-list'></i>&nbsp;Ir a bandeja de pagos</a>
				<button type="button" id='btn_modal_resultadoPago_current_cl' name='btn_modal_resultadoPago_current_cl'
					class="btn btn-block btn-sm btn-danger" data-dismiss="modal"
					onclick="js_cobros_selecciona( 'span_button_save_person','', document.getElementById('hd_tipo_persona').value );">
					<i class='fa fa-user-circle-o'></i>&nbsp;Cobrar deuda al mismo cliente</button>
				<button type="button" id='btn_modal_resultadoPago_new_cl' name='btn_modal_resultadoPago_new_cl'
					class="btn btn-block btn-sm btn-success" data-dismiss="modal"
					onclick='js_cobros_limpiar_despues_de_pago_existoso();'>
					<i class='fa fa-users'></i>&nbsp;Cobrar deuda a otro cliente</button>
			</div>
		</div>
	</div>
</div>
<!-- Modal para mostrar el resultado del pago -->
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
					<button type="button" class="btn btn-primary" data-dismiss="modal"  onclick="senddeudaindividual(document.getElementById('fc_generada').value,'fc_generada','{ruta_html_finan}/cobros/controller.php',document.getElementById('codigopago').value)">Agregar</button>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Modal  Migrar Confirmacion-->
<div id="div_modal_seleccionar_persona_lista" name="div_modal_seleccionar_persona_lista"></div>
<!-- CLIENTE -->
<div class='panel panel-info'>
	<div class="panel-heading">
		<table style='width:100%'>
			<tr>
				<td style='text-align:left;'>
					Cliente
					<div id='EducaLinksHelperCliente' style='display:inline;font-size:small;text-align:left;vertical-align:middle;'>
						<a href='#' onmouseover='$(this).tooltip("show")' title="Para cobrar una deuda, haga click a 'Buscar' para empezar por buscando un cliente." data-placement='right'><span class='glyphicon glyphicon-question-sign'></span></a>
					</div>
					<div id='EducaLinksHelperCliente2' class='EducalinksHelper' style='display:none;font-size:small;text-align:left;vertical-align:middle;'>
						¿No est&aacute; seguro de haber cobrado una deuda correctamente? <a href='#' onmouseover='$(this).tooltip("show")' title="Si no est&aacute; seguro(a) de haber realizado un pago correctamente, puede verificar seleccionando desde el men&uacute; la opci&oacute;n de Ver/Pagos." data-placement='right'><span class='glyphicon glyphicon-info-sign'></span></a>
					</div>
				</td>
				<td style='text-align:right;'>
					<!--<button id="btnBuscarCliente" type="button" 
							class="btn btn-info btn-md" aria-hidden="true" data-toggle="modal" data-target="#modal_busquedaCliente" 
							onclick="carga_busquedaCliente('modal_busquedaCliente_body','{ruta_html_finan}/cobros/controller.php')" {disabled_caja} >
						<span class='glyphicon glyphicon-search'></span>&nbsp;Buscar</button>-->
					<button class="btn btn-info btn-md" 
								onclick="js_persona_select_user_searchlist_2('span_button_save_person', 'div_modal_seleccionar_persona_lista', '','js_cobros_selecciona')">
								<span class="glyphicon glyphicon-search"></span>&nbsp;Buscar</button>
				</td>
			</tr>
		</table>
	</div>
	<div class="panel-footer">
		<div id="datosCliente" name="datosCliente" class="grid">
			<div class="row">
				<div class="col-sm-2">
					<input type="hidden" readonly class="form-control" id="hd_tipo_persona" name="hd_tipo_persona" />
					<input type="text" readonly class="form-control" id="codigoCliente" name="codigoCliente" placeholder="Codigo" />
				</div>
				<div class="col-sm-2">
					<input type="text" readonly class="form-control" id="numeroIdentificacionCliente" name="numeroIdentificacionCliente" placeholder="CI / RUC" />
				</div>
				<div class="col-sm-4">
					<input type="text" readonly class="form-control" id="nombresCliente" name="nombresCliente" placeholder="Nombres" />
					<input type="hidden" class="form-control" id="hd_prontopago" name="hd_prontopago" value='{hd_prontopago}' />
				</div>
				<div class="col-sm-4" style='text-align:right;margin-top:2px;'>
					<div style='vertical-align:top;' id='client_options'>{opciones_cliente}</div>
				</div>
			</div>
			<div class="row">
				<div  id='div_datos_academicos_estudiante' name='div_datos_academicos_estudiante' style='display:inline;'>
					<div class="col-sm-4">
						<input id="txt_curso" type="text" class="form-control" placeholder="Grado/Curso" disabled style="width:100%" />
					</div>
					<div class="col-sm-4">
						<input id="txt_grupo_economico" type="text" class="form-control" placeholder="Grupo económico" disabled style="width:100%" />
					</div>
					<div class="col-sm-4">
						<input id="txt_nivel_economico" type="text" class="form-control" placeholder="Nivel económico" disabled style="width:100%" />
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
			
<div class="box box-default">
	<div class="box-header with-border">
		<h3 class="box-title">Cobro</h3>
		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
			<!--<button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button> NO REMOVER-->
		</div>
	</div><!-- /.box-header -->
	<div class="box-body">
		<div id="deudasPendientesCliente">
			<!-- DEUDAS PENDIENTES-->
			<br>
			<div id='formularioCobro' style="display:none;">
				<div class='panel panel-info'>
					<div class="panel-heading">
						<table style='width:100%'>
							<tr>
								<td style='text-align:left;'>
									<button id='a_folder_deudasPendientes' name='a_folder_deudasPendientes' class="btn btn-link" type="button"
											onclick="return folder_deudasPendientes();"><span class="glyphicon glyphicon-option-vertical"></span>  Deudas pendientes
									</button>
										<div id='EducaLinksHelperDeudasPendientes' class='EducalinksHelper' style='display:inline;font-size:x-small;text-align:left;vertical-align:middle;'>
											<a href='#' onmouseover='$(this).tooltip("show")' title="Esta es la tabla de deudas pendientes. Una vez que selecciona a un cliente para cobrarle una deuda, en esta tabla se mostrar&aacute;n las deudas pendientes de pago (o con abono parcial)." data-placement='bottom'><span class='glyphicon glyphicon-question-sign'></span></a>
										</div>
										<div id='EducaLinksHelperDeudasPendientes2' class='EducalinksHelper' style='display:inline;font-size:x-small;text-align:left;vertical-align:middle;'>
											<a href='#' onmouseover='$(this).tooltip("show")' title="Seleccione una deuda pendiente desde el cuadro opciones, haciendo clic en 'Seleccionar' (el ícono de flechita abajo)." data-placement='right'><span class='glyphicon glyphicon-question-sign'></span></a>
										</div>
								</td>
								<td style='text-align:right;'>
									<button id='btn_folder_deudasPendientes' name='btn_folder_deudasPendientes' class="btn btn-link" type="button"
											onclick="return folder_deudasPendientes();"
											data-placement="left"
											title='Ver deudas pendientes'
											onfocus='$(this).tooltip("show")'
											onmouseover='$(this).tooltip("show")'>
										<span class='glyphicon glyphicon-folder-close'></span>
									</button>
								</td>
							</tr>
						</table>
					</div>
					<div  id="collapse_deudasPendientes" class="panel-collapse collapse">
						<div id="resultado" style="display:none;" class="grid">
							<div class="row">
								<a name='div_noticias_deudas_anteriores'></a>
								<div class="col-sm-12" id="div_noticia_deudas_anteriores" style='align:center;display:none;' >
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12">
									{tabla_deudasPendientes}
								</div>
							</div>
						</div>
					</div>
					<div class="panel-footer">
						<div class="grid">
							<div class="row">
								<div class="col-sm-4 col-sm-offset-8">
									<div class="input-group" >
										<span class="input-group-addon"><strong>T. Deudas: </strong>$</span>
										<input type="text" disabled="true" class="form-control" name="totalDeudasPendientes" id="totalDeudasPendientes" placeholder="00.00" required="required">
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- DEUDAS A CANCELAR-->
				<br>
				<div class='panel panel-info'>
					<div class="panel-heading">
						<table style='width:100%'>
							<tr>
								<td style='text-align:left;'>
									Deudas a cancelar 
									<div id='EducaLinksHelperDeudaSeleccionada' class='EducalinksHelper' style='display:inline;font-size:x-small;text-align:left;vertical-align:middle;'>
										<a href='#' onmouseover='$(this).tooltip("show")' 
										   title="Si ya seleccion&oacute; un cliente, debe tambi&eacute;n seleccionar una deuda de la tabla 'Deudas pendientes' para poder continuar. Todas las deudas pendientes seleccionadas se mostrar&aacute;n en esta tabla." data-placement='top'><span class='glyphicon glyphicon-question-sign'></span></a>
									</div>
									<div id='EducaLinksHelperDeudaSeleccionada2' class='EducalinksHelper' style='display:inline;font-size:x-small;text-align:left;vertical-align:middle;'>
										<a href='#' onmouseover='$(this).tooltip("show")' 
										   title="Si desea deseleccionar una deuda, haga click sobre la 'x', en la opci&oacute;n de 'Sacar'." data-placement='right'><span class='glyphicon glyphicon-question-sign'></span></a>
									</div>
								</td>
								<td style='text-align:right;'>
								</td>
							</tr>
						</table>
					</div>
					<div class="panel-collapse collapse in">
						<div id="resultadoPendientesCobro" style="display:none;" class='grid'>
							<div class="row">
								<div class="col-sm-12">
									{tabla_deudasSeleccionadas}
								</div>
							</div>
						</div>
					</div>
					<div class="panel-footer">
						<div class="grid">
							<div class="row">
								<div class="col-sm-4 col-sm-offset-4">
									<div class="input-group" >
										<span class="input-group-addon"><strong>T. Abonado: </strong>$</span>
										<input type="text" disabled="true" readonly class="form-control" name="Totalabonado" id="Totalabonado" placeholder="00.00" required="required">
									</div>
								</div>
								<div class="col-sm-4">
									<div class="input-group" >
										<span class="input-group-addon"><strong>Saldo pdte.: </strong>$</span>
										<input type="text" disabled="true" readonly class="form-control" name="totalDeudasSeleccionadas" id="totalDeudasSeleccionadas" placeholder="00.00" required="required">
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- FORMAS DE PAGO -->
				<br>
				<div class='panel panel-success'>
					<div class="panel-heading">
						<table style='width:100%'>
							<tr>
								<td style='text-align:left;'>
									Forma de Pago
									<div id='EducaLinksHelperFormaDePago' class='EducalinksHelper' style='display:inline;font-size:x-small;text-align:left;vertical-align:middle;'>
										<a href='#' onmouseover='$(this).tooltip("show")' 
											title="Seleccione la forma de pago con la que el cliente desea pagar su deuda. Debe escoger al menos una forma de pago." data-placement='top'><span class='glyphicon glyphicon-question-sign'></span></a>
									</div>
									<div id='EducaLinksHelperFormaDePago2' class='EducalinksHelper' style='display:inline;font-size:x-small;text-align:left;vertical-align:middle;'>
										<a href='#' onmouseover='$(this).tooltip("show")' 
											title="Recuerde que debe haber seleccionado al menos una deuda pendiente de cobro de la tabla 'Deudas pendientes'." data-placement='right'><span class='glyphicon glyphicon-question-sign'></span></a>
									</div>
								</td>
								<td style='text-align:right;'>
									<button id="btnAgregarFormaPago" type='button' class='btn btn-success btn-md' 
											aria-hidden='true' data-toggle='modal' data-target='#modal_agregarPago'
											onclick='carga_formularioPago("modal_agregarPago_body","{ruta_html_finan}/cobros/controller.php")' {disabled_caja}>
									<span class='glyphicon glyphicon-grain'></span>&nbsp;Agregar</button>
								</td>
							</tr>
						</table>
					</div>
					<div class="panel-collapse collapse in">
						<div id="opcionesFormasDePago" class="grid">
							<div id='div_formas_de_pago' style="display:none;">
								<div class="row" >
									<div class="col-sm-12">
										{tabla_pagos}
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="panel-footer">
						<div class="grid">
							<div class="row">
								<div class="col-sm-4 col-sm-offset-4">
									<div class="input-group" >
										<span class="input-group-addon"><strong>Total Pagos: </strong>$</span>
										<input type="text" disabled="true" readonly class="form-control" name="totalPagos" id="totalPagos" placeholder="00.00" required="required">
									</div>
								</div>
								<div class="col-sm-4">
									<div class="input-group" >
										<span class="input-group-addon"><strong>Saldo a Favor: </strong>$</span>
										<input type="text" disabled="true" readonly class="form-control" name="saldofavor" id="saldofavor" placeholder="00.00" required="required">
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div><!-- /.box-body -->
	<div class="box-footer">
		<div id="cobro_opciones" class="btn-group pull-right">
			<button type="button" class="btn btn-default btn-md" onclick="limpiaPagina('true')" {disabled_caja}><span class='glyphicon glyphicon-erase'></span> Limpiar selecciones</button>
			<button type="button" id='btn_gen_pago' name='btn_gen_pago' class="btn btn-primary btn-md" aria-hidden="true" 
					onclick="generaPago('modal_resultadoPago_body','{ruta_html_finan}/cobros/controller.php')" {disabled_caja}>
				<span class='glyphicon glyphicon-record'></span> Confirmar pagos</button>
		</div>
	</div>
</div>
<!-- DEUDAS CLIENTE -->