<!-- Modal Editar-->
<div class="modal fade" id="modal_edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Reporte de Saldos a favor</h4>
			</div>
			<div class="modal-body" id="modal_edit_body">
			 ...
			 </div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Ocultar</button>
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
						<td><label class="codigoNivel_busq" for="cursos">Niveles Econ&oacute;micos:</label></td>
						<td><div id="comboNIvelesEconomicos">
							   {combo_nivel}
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
				</table>
				</td>
			</tr>
			<tr><td>
					<div class="div_button" >
						<button type="button" 
								style="float:right" 
								class="btn btn-default" aria-hidden="true" data-toggle="modal"  data-target="#modal_edit" 
								onclick="js_rep_saldoafavor_reporte('modal_edit_body','{ruta_html_finan}/rep_saldosafavor/controller.php','print_saldosafavor')">
								<span style='color:red;' class="fa fa-file-pdf-o"></span>&nbsp;PDF</button>
					 </div>
			</td>
		</tr>
	</table>
</div>