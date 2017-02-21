<div id="visorEstadoCuenta_cliente" class="form-horizontal" >
	<ul class="nav nav-tabs" role="tablist">
		<li role="presentation" class="active"><a href="#tab_estadoCuenta_deuda" aria-controls="Deudas" role="tab" data-toggle="tab">Deudas</a></li>
		<li role="presentation"><a href="#tab_estadoCuenta_pagos" aria-controls="Pagos" role="tab" data-toggle="tab">Pagos</a></li>
		<!--<li role="presentation"><a href="#tab3" aria-controls="Notas de crédito" role="tab" data-toggle="tab">Notas de crédito</a></li>-->
	</ul>
	<!-- Tab panes -->
	<div class="tab-content">
		<div role="tabpanel" class="tab-pane active" id="tab_estadoCuenta_deuda">
			<br>
			<div class='panel panel-primary'>
				<div class="panel-heading">
					Filtros
				</div>
				<div class="panel-collapse collapse in">
					<div class='grid'>
						<input type="hidden" class="form-control" name="codigoEstudiante" id="codigoEstudiante" value="{alumno_codigo}" required="required">
						<div class="row">
							<div class="col-sm-12" id="div_fini" name="div_fini" >
								<div class="input-group" id="div_fini" name="div_fini" data-placement="top"
									 title='Fecha de emisión, desde, hasta.'
									 onmouseover='$(this).tooltip("show")'>
									<span class="input-group-addon">
										<input type="checkbox" id='chk_periodo' name='chk_periodo'
											onchange="validaFiltros(this,'resultadoDeudas','{ruta_html_finan}/clientes_externos/controller.php')">
									</span>
									<span class="input-group-addon">
										<span style="text-align:left;font-size:small;font-weight:bold;">Per&iacute;odo</span>
									</span>				
									{combo_periodos}
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-12" id="div_fini" name="div_fini" >
								<div class="input-group" id="div_fini" name="div_fini" data-placement="top"
									 title='Fecha de emisión, desde, hasta.'
									 onmouseover='$(this).tooltip("show")'>
									<span class="input-group-addon">
										<input type="checkbox" id='chk_fecha' name='chk_fecha' onclick='check_fecha();'
											onchange="consultaDeudas('resultadoDeudas','{ruta_html_finan}/clientes_externos/controller.php')">
									</span>
									<span class="input-group-addon">
										<span style="text-align:left;font-size:small;font-weight:bold;">F. emisi&oacute;n</span>
									</span>				
									<span class="input-group-addon">
										<small>Inicio</small></span>
									<input type="text" class="form-control" name="txt_fecha_ini" id="txt_fecha_ini" 
											value="" placeholder="dd/mm/yyyy" disabled='disabled' 
											onchange="consultaDeudas('resultadoDeudas','{ruta_html_finan}/clientes_externos/controller.php')">
								
									<span class="input-group-addon">
										<small>Fin</small></span>
									<input type="text" class="form-control" name="txt_fecha_fin" id="txt_fecha_fin" 
											value="" placeholder="dd/mm/yyyy" disabled='disabled' 
											onchange="consultaDeudas('resultadoDeudas','{ruta_html_finan}/clientes_externos/controller.php')">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="grid">
				<div class="row" >
					<div class="col-sm-12" id="resultadoDeudas" name="resultadoDeudas" style='background-color:#f4f4f4;height:300px;overflow-y:scroll;'>
						{tablaDeudas}
					</div>
				</div>
			</div>
		</div>
		<div role="tabpanel" class="tab-pane" id="tab_estadoCuenta_pagos">
			<div class="row">
				<div class="col-sm-12" id="resultadoPagos" name="resultadoPagos" style='background-color:#f4f4f4;height:300px;overflow-y:scroll;'>
					{tablaPagos}
				</div>
			</div>
		</div>
	</div>
</div>