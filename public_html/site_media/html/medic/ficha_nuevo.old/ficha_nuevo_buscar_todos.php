<!-- Modal Editar-->
<div class="modal fade" id="modal_edit" tabindex="-1" role="dialog" aria-labelledby="modal_ficha_med_print_pdf" aria-hidden="true">
	<div class="modal-dialog-900">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id= id="modal_ficha_med_print_pdf">Reportes de Cierre de Caja</h4>
			</div>
			<div class="modal-body" >
				<div id="modal_ficha_med_print_pdf_result" name="modal_ficha_med_print_pdf_result">...</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
			</div>
		</div>
	</div>
</div>
<div id="div_modal_seleccionar_persona_lista" name="div_modal_seleccionar_persona_lista"></div>
<!-- Panel de informacion de la persona -->
<div class="panel panel-info">
	<div class="panel-heading">
		<table style='width:100%'>
			<tr>
				<td style='text-align:left;'>
					Paciente
				</td>
				<td style='text-align:right;'>
					<button class="btn btn-info btn-md" 
						onclick="js_persona_select_user_searchlist_2('span_button_save_person', 'div_modal_seleccionar_persona_lista', 'div_ficha_med_setear_formulario','js_ficha_med_select_user')">
						<span class="glyphicon glyphicon-search"></span>&nbsp;Buscar</button>
				</td>
			</tr>
		</table>
	</div>
	<div class="panel-body">
		<div class="row">
			<div class="col-md-2 col-xs-12 col-sm-6 bottom_10">
				<input type="text" class="form-control" id="alum_codi" name="alum_codi" placeholder="Código alumno" aria-describedby="alum_codi_addon" readonly>
			</div>
			<div class="col-md-4 col-xs-12 col-sm-6 bottom_10">
				<input type="text" class="form-control" id="alum_nombre" name="alum_nombre" placeholder="Nombres" aria-describedby="alum_nombre_addon" readonly>
				<input type="hidden" class="form-control" id="hd_per_genero" name="hd_per_genero">
			</div>
			<div class="col-md-4 col-xs-12 col-sm-6 bottom_10">
				<input style="display:inline;" type="text" class="form-control" id="alum_curso" name="alum_curso" placeholder="Curso" aria-describedby="alum_curso_addon" readonly>
				<input type="hidden" class="form-control" id="curs_para_codi" name="curs_para_codi">
			</div>
			<div class="col-md-2 col-xs-12 col-sm-6 bottom_10">
			</div>
		</div>
		<div class="row">
			<div class="col-md-4 col-xs-12 col-sm-6 bottom_10">
				<input placeholder="Dirección" id="alum_domi" name="alum_domi" class="form-control" aria-describedby="alum_domi_addon" readonly>
			</div>
			<div class="col-md-3 col-xs-12 col-sm-6 bottom_10">
				<input type="text" class="form-control" id="alum_telf" name="alum_telf" placeholder="Teléfono" aria-describedby="alum_telf_addon" readonly>
			</div>
		</div>
	</div>
</div>
<!-- /. Panel de informacion de la persona -->

<div class="box box-default">
	<div class="box-header with-border">
		<div class="form-horizontal">
			<div class="form-group">
				<div class="col-sm-6 col-xs-12" style="text-align:left;">
					<span id='span_button_save_person' name='span_button_save_person'></span>
				</div>
			</div>
		</div>
	</div>
	<div class="box-body" id="div_ficha_med_setear_formulario">
		<div style='text-align:center;'><span class='fa fa-user'></span></div>
	</div>
</div>