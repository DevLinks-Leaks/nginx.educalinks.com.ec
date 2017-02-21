<!-- Modal enviar e-mail a cliente-->
<div class="modal fade" id="modal_resend" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Educalinks</h4>
            </div>
            <div class="modal-body" id="modal_resend_body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Aceptar</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal enviar e-mail a cliente-->
<form id="file_form" action="{ruta_html_finan}/VerDocumentosAutorizados/controller.php" enctype="multipart/form-data" method="post" target="_blank">
	<input type="hidden" id='tipoDocumentoAutorizado' name='tipoDocumentoAutorizado' value="FAC" />
	<!--<div class='panel panel-info'>
		<div class="panel-heading">
			<h3 class="panel-title">Búsqueda</h3>
		</div>
		<div class="panel-body">
			<div class="form-horizontal" role="form">
				<div class='form-group'>
					<div class='col-md-2 col-sm-3'>
						<button class='btn btn-primary glyphicon glyphicon-search btn-sm' id='btn_selectTipoDocAut' name='btn_selectTipoDocAut'  type="button" 
								onclick="return carga_tipoDocumentoAutorizado('tabla_consulta_tipoDocumentoAutorizado');">
						</button>
					</div>
					<div class='col-md-2 col-sm-6'>
						<select class='form-control input-sm' id='tipoDocumentoAutorizado' name='tipoDocumentoAutorizado' 
								onchange='return tipoDocumentoAutorizado_onChange(this);'>
							<option value='FAC' selected='selected'>Facturas</option>
							<option value='NC'>Nota de cr&eacute;dito</option>
							<option value='ND'>Nota de d&eacute;bito</option>
						</select>
					</div>
					<div class="col-md-6 col-sm-10" id="div_fini" name="div_fini" >
						<div class="input-group" id="div_fini" name="div_fini" data-placement="top"
							 title='Fecha de emisión, desde, hasta.'
							 onmouseover='$(this).tooltip("show")'>
							<span class="input-group-addon">
								<input type="checkbox" id='chk_fecha' name='chk_fecha' onclick='check_fecha();'>
							</span>
							<span class="input-group-addon">
								<span style="text-align:left;font-size:small;font-weight:bold;">F. emisi&oacute;n</span>
							</span>				
							<span class="input-group-addon">
								<small>Inicio</small></span>
							<input type="text" class="form-control input-sm" name="txt_fecha_ini" id="txt_fecha_ini" 
										value="" placeholder="dd/mm/yyyy" disabled='disabled'>
						
							<span class="input-group-addon">
								<small>Fin</small></span>
							<input type="text" class="form-control input-sm" name="txt_fecha_fin" id="txt_fecha_fin" 
										value="" placeholder="dd/mm/yyyy" disabled='disabled'>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>-->
</form>
<div class="box box-default">
	<div class="box-body">
		<div id='tabla_consulta_tipoDocumentoAutorizado'>
			<div  id="resultado" style='text-align:center'>
				{tabla}
			</div>
		</div>
	</div>
</div>