<!-- Modal Editar-->
<div class="modal fade" id="modal_ficha_med_print_pdf" tabindex="-1" role="dialog" aria-labelledby="modal_ficha_med_print_pdf_head" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="modal_ficha_med_print_pdf_head"><i class='fa fa-pdf-file-o'></i>Ficha médica</h4>
			</div>
			<div class="modal-body" >
				<div id="modal_ficha_med_print_pdf_result" name="modal_ficha_med_print_pdf_result">...</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Ocultar</button>
			</div>
		</div>
	</div>
</div>
<div class="box box-default">
	<div class="box-header">
		<div class="form-horizontal">
			<div class="form-group">
				<div class="col-sm-6 col-xs-12" style="text-align:left;">
					<span id='span_button_save_medical_record' name='span_button_save_medical_record'></span>
				</div>
			</div>
		</div>
	</div>
	<div class="box-body" id="div_ficha_med_bandeja_consulta">
		{resultado}
	</div>
</div>