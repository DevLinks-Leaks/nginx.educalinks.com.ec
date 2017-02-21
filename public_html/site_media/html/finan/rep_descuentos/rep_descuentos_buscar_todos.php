<!-- Modal Editar-->
<div class="modal fade" id="modal_edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Reporte de Descuentos Otorgados</h4>
      </div>
      <div class="modal-body" id="modal_edit_body">
      ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
       
      </div>
    </div>
  </div>
</div>
<!-- Modal Editar-->


 <div class="form-inline">
	<table width='50%'>
		<tr>
			<td>
				<table class="table table-striped table-hover" width='100%'>
					<tr>
						<td width='30%'><label class="codigoPeriodo_busq" for="cursos">Per&iacute;odo:</label></td>
						<td><div id="comboPeriodo">
							   {combo_periodo}
							</div>
						</td>
					</tr>
					<tr>
						<td><label class="codigoCurso_busq" for="cursos">Cursos:</label></td>
						<td><div id="comboCursos">
							   {combo_curso}
							</div>
						</td>
					</tr>
					<tr><td width='30%'><label class="codigoTipoDesc_busq" for="descuento">Tipo de descuento:</label></td>
						<td><div id="div_comboTipoDescuento">
								{combo_tipo_descuento}
							</div>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td>
				<div class="div_button" >
					<button type="button" 
							style="float:right" 
							class="btn btn-primary" aria-hidden="true" data-toggle="modal"  data-target="#modal_edit" 
							onclick=" carga_reports_descuentos('modal_edit_body','{ruta_html_finan}/rep_descuentos/controller.php','print_descuentos')">
							<span class="glyphicon glyphicon-print"></span>&nbsp;Imprimir</button>
				 </div>
			</td>
		</tr>
	</table>
                 
</div>

