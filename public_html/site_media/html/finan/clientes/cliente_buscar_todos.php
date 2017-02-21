<!-- Modal Cargando-->
<div class="modal modal-transparent fade" id="modal_msg" tabindex="-1"  data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-body" id="modal_msg_body" style='text-align:center;font-size:small;'>
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
<form id="file_form" action="{ruta_html_finan}/clientes/controller.php" enctype="multipart/form-data" method="post" target="_blank">
	<input type='hidden' name="event" id="evento" value="print_excel_all_data"/>
	<input type='hidden' name="tipo_reporte" id="tipo_reporte" value="mini"/>
	<div class='panel panel-info dismissible' id='panel_search' name='panel_search'>
		<div class="panel-heading">
			<h3 class="panel-title"><a href="#/" id="boton_busqueda" name="boton_busqueda" style='text-decoration:none;'><span class="fa fa-search"></span>&nbsp;Búsqueda</a>
				<a href="#/" class="pull-right" data-target="#panel_search" data-dismiss="alert" aria-hidden="true"><span class='fa fa-times'></span></a>
			</h3>
		</div>
		<div class="panel-body" id="desplegable_busqueda" name="desplegable_busqueda">
			<div class="form-horizontal" role="form">
				<div class='form-group'>
					<div class='col-md-1 col-sm-12'>
					<button class="btn btn-primary fa fa-search" type="button" 
							data-placement="bottom"
							title='Buscar facturas'
							onmouseover='$(this).tooltip("show")'
							onclick="js_clientes_buscar('resultado','{ruta_html_finan}/clientes/controller.php')"></button>
					</div>
					<label class="col-md-2 col-sm-3 control-label" style='text-align: right;' for='txt_cod_cliente'>Cod. estudiante:</label>
					<div class="col-md-3 col-sm-8"
							data-placement="bottom"
							title='C&oacute;digo del representado'
							onmouseover='$(this).tooltip("show")'>
						<input type="text" class="form-control input-sm" name="txt_cod_cliente" id="txt_cod_cliente" >
					</div>
					<label class="col-md-2 col-sm-3 control-label" style='text-align: right;' for='txt_nom_cliente'>Nombre estudiante:</label>
					<div class="col-md-4 col-sm-8"
							data-placement="bottom"
							title='Nombre del cliente representado'
							onmouseover='$(this).tooltip("show")'>
						<input type="text" class="form-control input-sm" name="txt_nom_cliente" id="txt_nom_cliente" >
					</div>
				</div>
				<div class='form-group'>
					<div class="col-md-6 col-sm-10 col-md-offset-0 col-sm-offset-1">
						<div class="input-group" id="div_total_neto" name="div_total_neto" data-placement="top"
							 title='valor total neto, desde, hasta.'
							 onmouseover='$(this).tooltip("show")'>
							<span class="input-group-addon">
								<input type="checkbox" id='chk_fecha_nac' name='chk_fecha_nac' onclick='js_clientes_check_fecha_nac();'>
							</span>
							<span class="input-group-addon">
								<span style="text-align:left;font-size:small;font-weight:bold;">F. nacimiento</span>
							</span>				
							<span class="input-group-addon" style="text-align:left;font-size:small;font-weight:bold;">de</span>
							<input type="text" class="form-control input-sm" name="txt_fecha_nac_ini" id="txt_fecha_nac_ini" placeholder='dd/mm/yyyy' disabled='disabled'>
							<span class="input-group-addon" style="text-align:left;font-size:small;font-weight:bold;">a</span>
							<input type="text" class="form-control input-sm" name="txt_fecha_nac_fin" id="txt_fecha_nac_fin" placeholder='dd/mm/yyyy' disabled='disabled'>
						</div>
					</div>
					<label class="col-md-2 col-sm-3 control-label" style='text-align: right;' for='txt_id_estudiante'>Id. estudiante:</label>
					<div class="col-md-4 col-sm-8"
							data-placement="bottom"
							title='N&uacute;mero de identificaci&oacute;n del titular del documento autorizado'
							onmouseover='$(this).tooltip("show")'>
						<input type="text" class="form-control input-sm" name="txt_id_estudiante" id="txt_id_estudiante" >
					</div>
				</div>
				<div class='form-group'>
					<label class="col-md-2 col-sm-3 control-label" style='text-align: right;' for='txt_id_titular'>Id. titular:</label>
					<div class="col-md-4 col-sm-8"
							data-placement="bottom"
							title='N&uacute;mero de identificaci&oacute;n del titular del documento autorizado'
							onmouseover='$(this).tooltip("show")'>
						<input type="text" class="form-control input-sm" name="txt_id_titular" id="txt_id_titular" >
					</div>
					<label class="col-md-2 col-sm-3 control-label" style='text-align: right;' for='txt_nom_titular'>Nombre titular:</label>
					<div class="col-md-4 col-sm-8"
							data-placement="bottom"
							title='Nombre del titular del documento autorizado'
							onmouseover='$(this).tooltip("show")'>
						<input type="text" class="form-control input-sm" name="txt_nom_titular" id="txt_nom_titular" >
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
				<div class='form-group'>
					<label class="col-md-2 col-sm-3 control-label" style='text-align: right;' for='cmb_estado'>Estado:</label>
					<div class="col-md-4 col-sm-8"
							data-placement="bottom"
							title='Estado de la factura'
							onmouseover='$(this).tooltip("show")'>
						<select class='form-control input-sm' id='cmb_estado' name='cmb_estado'>
							<option value='A' selected='selected'>Activo</option>
							<option value='I'>Inactivo</option>
						</select>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>
<div class="box box-default">
	<div class="box-header with-border">
	    <h3 class="box-title">Estudiantes</h3>
	</div><!-- /.box-header -->
	<div class="box-body">
		<div id="resultado">
			{tabla}
		</div>
	</div>
</div>