<!-- Modal Información-->
<div class="modal fade" id="modal_infoSaf" tabindex="-1" role="dialog" aria-labelledby="modal_rep_ModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="modal_rep_ModalLabel"><span class='fa fa-question-circle'></span>&nbsp;Acerca de Saldos a favor</h4>
			</div>
			<div class="modal-body" id="modal_infoSaf_body">
				<p>Las acciones que incrementan o disminuyen un saldo a favor en una cartera en el sistema son:</p>
				
				<b>Aumento (+) :</b>
				<ul>
					<li>Por Notas de crédito.</li>
					<li>Por Pagos excedentes.</li>
					<li>Por Ingreso directo (en esta misma página).</li>
					<li>Por reversar un pago hecho con forma de pago 'Saldo a favor'.</li>
					<li>Por tratar de pagar una deuda ya cancelada desde Débito Bancario.</li>
				</ul>
				<br>
				<b>Disminución (-) :</b>
				<ul>
					<li>Cuando se aplica un Saldo a favor a una deuda como forma de pago.</li>
					<li>Cuando se disminuye el saldo a favor directamente desde esta página (Marcado como Devuelto).</li>
					<li>Cuando un pago excedente es revertido, la deuda vuelve a su estado Por Cobrar, y el saldo a favor generado por el mismo se revierte (Pago con excedente revertido).</li>
					<li>Cuando un cheque es marcado como protestado en el sistema, la deuda vuelve a su estado Por Cobrar, y el saldo a favor se disminuye (Cheque protestado).</li>
				</ul>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-success" data-dismiss="modal">Entendido</button>
			</div>
		</div>
	</div>
</div>
<!-- /. Modal Información-->
<!-- Modal Configuraciòn-->
<div class="modal fade" id="modal_configSaf" tabindex="-1" role="dialog" aria-labelledby="modal_rep_ModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="modal_rep_ModalLabel"><span class='fa fa-cog'></span>&nbsp;Configuración de saldos a favor<h4>
			</div>
			<div class="modal-body" id="modal_configSaf_body">
				<div class="checkbox">
					<label>
						<input type="checkbox" id="check_generar_Saf_NC" name="check_generar_Saf_NC"> Generar saldo a favor al generar Notas de crédito sobre deudas con valor cancelado.
					</label>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
				<button type="button" class="btn btn-primary" data-dismiss="modal" onClick='js_saldoaFavor_set_config( );'>
					<span class='fa fa-floppy-o'></span>&nbsp;Guardar Cambios</button>
			</div>
		</div>
	</div>
</div>
<!-- /. Modal Configuraciòn-->
<!-- Modal Reportes-->
<div class="modal fade" id="modal_rep" tabindex="-1" role="dialog" aria-labelledby="modal_rep_ModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="modal_rep_ModalLabel">Reporte histórico</h4>
			</div>
			<div class="modal-body" id="modal_rep_body">
			 ...
			 </div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Ocultar</button>
			</div>
		</div>
	</div>
</div>
<!-- /. Modal Reportes-->
<!-- Modal Cargando-->
<div class="modal modal-transparent fade" id="modal_wait" tabindex="-1"  data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-body" id="modal_wait_body" style='text-align:center;font-size:small;'>
                <div align="center" style="height:100%;">
					Por favor, espere
					<br>
					<br>
					<i style="color:darkred;" class="fa fa-cog fa-spin"></i>
				</div>
            </div>
        </div>
    </div>
</div>
<!-- Modal Balancear-->
<div class="modal fade" id="modal_balance" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel"><span class='fa fa-balance-scale'></span>&nbsp;Balanceo de saldo a favor</h4>
			</div>
			<div class="modal-body" id="modal_balance_body">
				<input type="hidden" id="hd_per_codi" name="hd_per_codi" value='' >
				<div class='form-horizontal'>
					<div class='form-group'>
						<div class='col-sm-4'>
							Movimiento
						</div>
						<div class='col-sm-6'>
							<select id='cmb_balance_reason' name='cmb_balance_reason' class='form-control input-sm'
								onChange='js_saldoaFavor_change_reason();'>
								<option value='mas' selected='selected'>Ingreso directo (incremento de cartera)</option>
								<option value='menos' >Devolución (disminución de cartera)</option>
							</select>
						</div>
					</div>
					<div class='form-group'>
						<div class='col-sm-4'>
							Monto actual
						</div>
						<div class='col-sm-6'>
							<div class="input-group">
								<span class="input-group-addon" style='background-color:#f4f4f4;'>$</span>
								<input type="text" class="form-control input-sm" id="valor_actual" name="valor_actual"
									placeholder="0.00" disabled='disabled'>
							</div>
						</div>
					</div>
					<div class='form-group'>
						<div class='col-sm-4'>
							<span id='span_balance_mount_label' name='span_balance_mount_label'>Monto del movimiento</span>
						</div>
						<div class='col-sm-6'>
							<div class="input-group">
								<span id='span_balance_reason' name='span_balance_reason' class="input-group-addon">$</span>
								<input type="text" class="form-control input-sm" id="valor_balance" name="valor_balance"
									placeholder="0.00" onpaste="return false;"
									onkeypress="return js_saldoaFavor_validaDesbordamientoAbono( event, this,
										document.getElementById('valor_actual').value,
										document.getElementById('valor_actual').value);">
							</div>
						</div>
					</div>
					<div class='form-group'>
						<div class='col-sm-4'>
							Observaciones
						</div>
						<div class='col-sm-6'>
							<textarea id='txt_balance_obs' name='txt_balance_obs'  class='form-control input-sm'
								placeholder='Información adicional sobre el movimiento'></textarea>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
				<button type="button" class="btn btn-info" data-dismiss="modal" onclick="js_saldoaFavor_add2(  );">Procesar</button>
			</div>
		</div>
	</div>
</div>
<!-- Modal Balancear-->
<!-- Modal Agregar-->
<div class="modal fade" id="modal_busquedaCliente" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header" style='background-color:#D9EDF7;'>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 style='color:#3C8DC7;' class="modal-title" id="myModalLabel">Apertura de cartera con saldo a favor</h4>
			</div>
			<div class="modal-body" id="modal_busquedaCliente_body" style='background-color:#f4f4f4;'>
				...
			</div>
			<div class="modal-footer" style='background-color:#f4f4f4;'>
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
				<button type="button" class="btn btn-info" data-dismiss="modal" onclick="js_saldoaFavor_add(  )">
					<span class='fa fa-plus-square-o'></span>&nbsp;Crear cartera</button>
			</div>
		</div>
	</div>
</div>
<!-- Modal Agregar-->
<div class="box box-default">
	<div class="box-header with-border">
		<button type="button" class="btn btn-info"
				onclick="js_saldoaFavor_carga_busquedaCliente('{ruta_html_finan}/saldoaFavor/controller.php')"
				aria-hidden='true' data-toggle='modal' data-target='#modal_busquedaCliente' {disabled_agregar_banco}>
				<span class='fa fa-plus-square-o'></span>&nbsp;Apertura de cartera</button>
			<div id='EducaLinksHelperCliente' style='display:inline;font-size:small;text-align:left;vertical-align:middle;'>
				<a tabindex="0" data-toggle="popover" data-placement='right' title="Apertura de cartera a un cliente" data-content="<div style='font-size:x-small'>La cartera de un cliente es la cuenta en donde se guarda el saldo a favor. Si se generan notas de crédito o se registran pagos con valor excedente en el sistema, se aperturará una cartera al alumno automáticamente.</div>" data-placement='bottom'><span class='fa fa-info-circle'></span></a>
			</div>
		<div class="pull-right">
			<a class="btn btn-default" href='../../finan/rep_saldosafavor/'>
				<span style='color:red;' class="fa fa-bookmark-o"></span>&nbsp;Reporte general</a>
			<button type="button" class="btn btn-default"
				onclick="js_saldoaFavor_get_config( );"
				aria-hidden='true' data-toggle='modal' data-target='#modal_configSaf' {disabled_agregar_banco}>
				&nbsp;<span class='fa fa-cog'></span>&nbsp;</button>
			<button type="button" class="btn btn-default"
				aria-hidden='true' data-toggle='modal' data-target='#modal_infoSaf'>
				&nbsp;<span style='color:#3c8dbc;' class='fa fa-info-circle'></span>&nbsp;</button>
		</div>
	</div>
	<div class="box-body">
		<div class="col-lg-4 col-sm-6 input-group input-group-sm">
			<span id="span_balance_reason" name="span_balance_reason" class="input-group-addon">Ver</span>
			<select id='cmb_mostrarSaf' name='cmb_mostrarSaf' class='form-control'>
				<option value='all'>- Todos las carteras -</option>
				<option value='not_zero' selected='selected'>- Carteras con valores mayor a cero -</option>
			</select>
			<span class="input-group-btn">
				<button type="button" class="btn btn-info btn-flat" onClick='js_saldoaFavor_filter();'>Ir</button>
			</span>
		</div>
		<div id="resultado">
			{tabla}
		</div>
	</div>
</div>