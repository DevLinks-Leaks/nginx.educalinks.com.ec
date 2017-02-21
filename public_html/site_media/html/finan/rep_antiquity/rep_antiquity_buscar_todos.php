<!-- Modal Msg-->
<div class="modal fade" id="modal_msg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Educalinks</h4>
			</div>
			<div class="modal-body" id='modal_msg_body'>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Ocultar</button>
			</div>
		</div>
	</div>
</div>
<!-- Modal Msg-->
<!-- Modal Editar-->
<div class="modal fade" id="modal_edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Reporte de emisiones</h4>
			</div>
			<div class="modal-body" id="modal_edit_body" >
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Ocultar</button>
			</div>
		</div>
	</div>
</div>
<!-- Modal Editar-->
<form id="file_form" action="{ruta_html_finan}/rep_antiquity/controller.php" enctype="multipart/form-data" method="post" target="_blank">
	<div class="box box-default">
		<div class="box-body">
			<div class="form-horizontal" role="form">
				<div class="form-group">
					<div class="col-md-4 col-sm-12">
						<!--<button 
							type="button"
							class="btn btn-primary"
							onclick="js_rep_emisiones_carga_reports_deudores('modal-deudoresbody','{ruta_html_finan}/rep_antiquity/controller.php','print_deudores_html')">
								<span class="fa fa-search"></span></button>-->
						<button 
							type="button"
							class="btn btn-default"
							onclick="js_rep_emisiones_carga_reports_deudores('modal-deudoresbody','{ruta_html_finan}/rep_antiquity/controller.php','print_deudores')">
								<span style="color:red;" class="fa fa-file-pdf-o"></span></button>
						<button 
							type="button"
							class="btn btn-default"
							onclick="js_rep_emisiones_carga_reports_deudores('modal-deudoresbody','{ruta_html_finan}/rep_antiquity/controller.php','print_deudores_xls')">
								<span style="color:green;" class="fa fa-file-excel-o"></span></button>
					</div>
					<div class="col-md-6 col-sm-10">
						<div class="input-group" id="div_fini" name="div_fini" data-placement="top"
							 title='Fecha de vencimiento, desde, hasta.'
							 onmouseover='$(this).tooltip("show")'>
							<span class="input-group-addon">
								<input type="checkbox" id='chk_fecha' name='chk_fecha' onclick='js_rep_emisiones_check_fecha();'>
							</span>
							<span class="input-group-addon">
								<span style="text-align:left;font-size:small;font-weight:bold;">Fecha de corte</span></span>
							<input type="text" class="form-control input-sm" name="txt_fecha_fin" id="txt_fecha_fin" 
										value="" placeholder="dd/mm/yyyy" disabled='disabled'>
						</div>
					</div>
				</div>
				<hr>
				<div class="form-group">
					<label class="col-md-2 col-sm-3 control-label" style='text-align: right;'>Per&iacute;odo:</label>
					<div class="col-md-4 col-sm-5">
						{combo_periodo}
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 col-sm-3 control-label" for="nivelEconomico" style='text-align: right;'>Nivel econ.:</label>
					<div class="col-md-4 col-sm-5">
						<div id="resultadoNivelEcon">
							{combo_nivel}
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 col-sm-3 control-label" for="cursos" style='text-align: right;'>Curso:</label>
					<div class="col-md-4 col-sm-5">
						<div id="resultadoCursos">
							{combo_cursos}
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>
<!--<div class="box box-default">
	<div class="box-header with-border">
	    <h3 class="box-title">Consulta</h3>
	</div>
	<div class="box-body">
		<div id="resultado">
			{tabla}
		</div>
	</div>
</div>-->