<div role="main">
<!-- =============================== -->
	<?php	
		$yesterday=new DateTime('yesterday');
		$today=new DateTime('today');
	?>
	<form id="file_form" action="{ruta_html_finan}/pagos/controller.php" enctype="multipart/form-data" method="POST" target="_blank">
		<input type='hidden' name="event" id="evento" value="print_excel_all_data"/>
		<input type='hidden' name="tipo_reporte" id="tipo_reporte" value="completo"/>
		<div class='panel panel-info dismissible' id='panel_search' name='panel_search'>
			<div class="panel-heading">
				<h3 class="panel-title"><a href="#/" id="boton_busqueda" name="boton_busqueda" style='text-decoration:none;'><span class="fa fa-search"></span>&nbsp;Búsqueda</a>
				<a href="#/" class="pull-right" data-target="#panel_search" data-dismiss="alert" aria-hidden="true"><span class='fa fa-times'></span></a></h3>
			</div>
			<div class="panel-body" id="desplegable_busqueda" name="desplegable_busqueda">
				<div class="form-horizontal" role="form">
					<div class='form-group'>
						<div class='col-md-4 col-sm-12'> 
							<button type="button" class='btn btn-primary fa fa-search' id='btn_selectPago_search' name='btn_selectPago_search' 
									onclick="return carga_atenciones();">
							</button>
							<!--<button type="button" id='btn_selectPago_xls2' name='btn_selectPago_xls2'
									onclick="js_Pago_to_excel_PagosRealizados('print_excel_all_data','completo');"
									class="btn btn-default dropdown-toggle" data-toggle="dropdown">
								<span style='color:green;' class='fa fa-file-excel-o'>&nbsp;</span><span class="caret"></span>
							</button>-->
						</div>
						<div class="col-md-6 col-sm-10" id="div_fini" name="div_fini" >
							<div class="input-group" id="div_fini" name="div_fini" data-placement="top"
								 title='Buscar consultas médicas desde, hasta.'
								 onmouseover='$(this).tooltip("show")'>
								<span class="input-group-addon">
									<input type="checkbox" id='chk_fecha' name='chk_fecha' onclick='check_fecha();' checked>
								</span>
								<span class="input-group-addon">
									<span style="text-align:left;font-size:small;font-weight:bold;">F. consulta</span>
								</span>				
								<span class="input-group-addon">
									<small>Inicio</small></span>
								<input type="text" class="form-control input-sm" name="txt_fecha_ini" id="txt_fecha_ini" 
											value="<?php echo $yesterday->format('d/m/Y'); ?>" placeholder="dd/mm/yyyy" required="required">
							
								<span class="input-group-addon">
									<small>Fin</small></span>
								<input type="text" class="form-control input-sm" name="txt_fecha_fin" id="txt_fecha_fin" 
											value="<?php echo $today->format('d/m/Y'); ?>" placeholder="dd/mm/yyyy" required="required">
							</div>
						</div>
						<!--<div class="checkbox checkbox-info col-sm-2">
							<label for='ckb_opc_adv'>
								<input type="checkbox" id='ckb_opc_adv' name='ckb_opc_adv' onclick='js_Pago_check_opc_avanzadas();'>
									<span style="text-align:left;font-size:small;font-weight:bold;">B&uacute;squeda avanzada</span>
							</label>
						</div>-->
					</div>
					<div id='div_opc_adv' name='div_opc_adv' class='collapse'>
						<div class='form-group'>
							<label class="col-md-2 col-sm-3 control-label" style='text-align: right;' for='txt_id_titular'>Id. titular:</label>
							<div class="col-md-4 col-sm-8"
									data-placement="bottom"
									title='N&uacute;mero de identificaci&oacute;n del titular del documento autorizado'
									onmouseover='$(this).tooltip("show")'>
								<input type="text" class="form-control" name="txt_id_titular" id="txt_id_titular" >
							</div>
							<label class="col-md-2 col-sm-3 control-label" style='text-align: right;' for='txt_id_titular'>Nombre titular:</label>
							<div class="col-md-4 col-sm-8"
									data-placement="bottom"
									title='Nombre del titular del documento autorizado'
									onmouseover='$(this).tooltip("show")'>
								<input type="text" class="form-control" name="txt_nom_titular" id="txt_nom_titular" >
							</div>
						</div>
						<div class='form-group'>
							<label class="col-md-2 col-sm-3 control-label" style='text-align: right;' for='txt_id_titular'>Cod. estudiante:</label>
							<div class="col-md-4 col-sm-8"
									data-placement="bottom"
									title='C&oacute;digo del representado'
									onmouseover='$(this).tooltip("show")'>
								<input type="text" class="form-control" name="txt_cod_cliente" id="txt_cod_cliente" >
							</div>
							<label class="col-md-2 col-sm-3 control-label" style='text-align: right;' for='txt_id_titular'>Nombre estudiante:</label>
							<div class="col-md-4 col-sm-8"
									data-placement="bottom"
									title='Nombre del cliente representado'
									onmouseover='$(this).tooltip("show")'>
								<input type="text" class="form-control" name="txt_nom_cliente" id="txt_nom_cliente" >
							</div>
						</div>
						<div class='form-group'>
							<label class="col-md-2 col-sm-3 control-label" style='text-align: right;' for='txt_ref_factura'>Período:</label>
							<div class="col-md-4 col-sm-8"
									data-placement="bottom"
									title='Período en el que se generó la deuda'
									onmouseover='$(this).tooltip("show")'>
								{cmb_periodo}
							</div>
							<label class="col-md-2 col-sm-3 control-label" style='text-align: right;' for='cmb_producto'>Grupo Económico:</label>
							<div class="col-md-4 col-sm-8"
									data-placement="bottom"
									title='grupo Económico'
									onmouseover='$(this).tooltip("show")'>
								{cmb_grupoEconomico}
							</div>
						</div>
						<div class='form-group'>
							<label class="col-md-2 col-sm-3 control-label" style='text-align: right;' for='txt_ref_factura'>Nivel Económico:</label>
							<div class="col-md-4 col-sm-8"
									data-placement="bottom"
									title='Nivel económico'
									onmouseover='$(this).tooltip("show")'>
								<div id='resultadoNivelEcon' name='resultadoNivelEcon'>{cmb_nivelEconomico}</div>
							</div>
							<label class="col-md-2 col-sm-3 control-label" style='text-align: right;' for='cmb_producto'>Curso Paralelo:</label>
							<div class="col-md-4 col-sm-8"
									data-placement="bottom"
									title='Curso del alumno'
									onmouseover='$(this).tooltip("show")'>
								<div id='resultadoCursos' name='resultadoCursos'>{cmb_curso}</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
	<div class="box box-default">
		<div class="box-header">
		  <h3 class="box-title"></h3>
		</div><!-- /.box-header -->
		<div class="box-body">
			<div id="resultado">
			<!--<img src="<?php /*echo $diccionario['rutas_head']['ruta_html_medic']."/".$_SESSION['print_dir_logo_cliente']; */?>"  style="max-width:75px;max-height:100px;">-->
				<?php //include ("../tabla_atenciones.php");?>
			</div>
		</div>
	</div>
</div><!-- /container -->