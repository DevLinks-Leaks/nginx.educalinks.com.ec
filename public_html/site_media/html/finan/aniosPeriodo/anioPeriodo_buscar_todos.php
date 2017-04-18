<!-- Modal Información-->
<div class="modal fade" id="modal_infoPa" tabindex="-1" role="dialog" aria-labelledby="modal_rep_ModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="modal_rep_ModalLabel"><span class='fa fa-question-circle'></span>&nbsp;Acerca de Períodos anuales</h4>
			</div>
			<div class="modal-body" id="modal_infoPa_body">
				<p>Períodos anuales es el nombre asignado a esta ventana y tiene dos funciones:</p>
				<ul>
					<li>Determinar, de los servicios/productos creados en el sistema, desde la <a href="../items/">pantalla de items</a>, cuáles el sistema los considerará como 'Pensiones'.</li>
					<li>Generar deudas masivas de los items marcados como pensiones dentro del sistema.</li>
				</ul>
				<br>
				<p>Si por algún motivo, usted ha registrado en el listado de items de ésta página un ítem que su escuela no considera como parte del plan de pago de 
				   las pensiones, o, si desea ingresar un item a la lista de esta página para hacer uso de la función de generar con facilidad deudas masivas, 
				   y no es un ítem que es parte del plan de pago de las pensiones, recuerde borrarlo al terminar la generación masiva de deudas.
				</p>
				<p>Los reportes del sistema que sólo toman en cuenta los items de esta lista son:</p>
				<ul>
					<li><a href="../general/">Reporte de deudores</a> (en la página de inicio)</li>
					<!--<li><a href="../rep_ctasporcobrar/">Reporte de cuentas por cobrar</a></li>
					<li><a href="../rep_mediacion/">Reporte de Mediación</a></li>
					<li><a href="../rep_antiquity/">Reporte de Antigüedad de saldos</a></li>-->
				</ul>
				<br>
				<b>Bloqueo de alumnos</b>
				<br>
				<br>
				<p>Éste bloqueo sirve para excluir a alumnos de ciertas funcionalidades del sistema.</p>
				<p>Para la generación de deudas por lote, en caso de querer
				excluir a un estudiante, debe agregarlo a la lista de alumnos bloqueados.</p>
				<p>Para agregar motivos de bloqueo, puede hacerlo desde el <b>módulo académico</b> en la <a href="../../admin/alumnos_main.php">bandeja de alumnos.</a></p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-success" data-dismiss="modal">Entendido</button>
			</div>
		</div>
	</div>
</div>
<!-- /. Modal Información-->
<!-- Modal Editar-->
<div class="modal fade" id="modal_edit_item" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Editar Item</h4>
			</div>
			<div class="modal-body" id="modal_edit_body">
				...
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
				<button type="button" class="btn btn-success" onclick="js_aniosPeriodo_saveEditItem('resultado','{ruta_html_finan}/aniosPeriodo/controller.php')">
				<span class='glyphicon glyphicon-floppy-disk'></span>&nbsp;Guardar Cambios</button>
			</div>
		</div>
	</div>
</div>
<!-- Modal Editar-->
<!-- Modal Agregar-->
<div class="modal fade" id="modal_add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Agregar Item a periodo</h4>
			</div>
			<div class="modal-body" id="modal_add_body">
				...
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				<button type="button" class="btn btn-success" onclick="js_aniosPeriodo_saveAddItem('resultado','{ruta_html_finan}/aniosPeriodo/controller.php')">
				<span class='glyphicon glyphicon-floppy-disk'></span>&nbsp;Guardar cambios</button>
			</div>
		</div>
	</div>
</div>
<div class="form-horizontal">
	<div class="form-group">
		<div class="col-lg-3 col-md-3 col-sm-4">
			<div class="box box-solid">
				<div class="box-header with-border">
					<h3 class="box-title">Períodos anuales</h3>
					<div class="box-tools">
						<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
						</button>
					</div>
				</div>
				<div class="box-body no-padding">
					<ul class="nav nav-pills nav-stacked">
						<li id="nav_aniosPeriodo_1" class="active"><a href="#" onclick="js_aniosPeriodo_buscaItemsPeriodo('resultado','{ruta_html_finan}/aniosPeriodo/controller.php')"><i class="fa fa-wrench"></i> Configuración inicial
						<li id="nav_aniosPeriodo_2"><a href="#" onclick="js_aniosPeriodo_carga_resultadoLote('resultado','{ruta_html_finan}/aniosPeriodo/controller.php')" {disabled_generar_deuda_lote}><i style="color:green;" class="fa fa-plus-square"></i> Generar deudas por lote</a></li>
						<li id="nav_aniosPeriodo_3"><a href="#" onclick="js_aniosPeriodo_carga_bloqueo_alumnos('resultado','{ruta_html_finan}/aniosPeriodo/controller.php')" {disabled_generar_deuda_lote}><i style="color:red;" class="fa fa-file-text-o"></i> Bloqueo de alumnos</a></li>
					</ul>
				</div>
			</div>
		</div>
		<div class="col-lg-9 col-md-9 col-sm-8">
			<input id="peri_codi" type="hidden" value="{periodo_codigo}" />
			<div id="box_window2_header" name="box_window2_header" class="box box-success">
				<div class="box-header with-border" id='div_main_box_header' main='div_main_box_header'>
					<button class="btn btn-primary" type="button" aria-hidden='true' data-toggle='modal' data-target='#modal_add' 
										onclick="js_aniosPeriodo_carga_add('modal_add_body','{ruta_html_finan}/aniosPeriodo/controller.php')" {disabled_agregar_item}>
							Item&nbsp;<li class='fa fa-plus'></li></button>
					<div class="pull-right">						
						<button type="button" class="btn btn-default"
							aria-hidden='true' data-toggle='modal' data-target='#modal_infoPa'>
							&nbsp;<span style='color:#3c8dbc;' class='fa fa-info-circle'></span>&nbsp;</button>
					</div>
				</div>
				<div class="box-body">
					<div class="grid">
						<div class="row">
							<div class="col-sm-12">
								<div id="resultado">
									{tabla}
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>