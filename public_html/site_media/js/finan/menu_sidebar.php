<!-- Modal Configuración Colecturía--> 
<div class="modal fade" id="modal_configColecturia" tabindex="-1" role="dialog" aria-labelledby="modal_configColecturia" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header" style='background-color:#1A286A'>
				<h4 class="modal-title" id="modal_configColecturia" style='color:white;'>
					<i style="font-size:large;color:white;" class="fa fa-cog fa-spin"></i>&nbsp;Parámetros del sistema</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body" id="modal_configColecturia_body" style='background-color:#f4f4f4;'>
			</div>
			<div class="modal-footer" style='background-color:#f4f4f4;'>
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				<button type="button" class="btn btn-primary" data-dismiss="modal" 
					onclick="js_general_settings_change(document.getElementById('desc_pronto').value,
							document.getElementById('desc_prepago').value,
							document.getElementById('check_enviar_fac_sri_en_cobro').checked,
							document.getElementById('check_enviar_cheque_a_bandeja').checked,
							document.getElementById('check_bloqueo').checked,
							document.getElementById('txt_config_apikey').value,
							document.getElementById('txt_config_apikey_token').value,
							document.getElementById('check_genera_deuda_matr').checked,
							document.getElementById('check_bloqueo_matr_por_deuda').checked,
							document.getElementById('check_biblio_genera_multa_por_mora').checked,
							document.getElementById('check_biblio_bloquea_prestamo_por_deuda').checked,
							'{ruta_html_finan}/general/controller.php')">
						<span class='fa fa-wrench'></span>&nbsp;Guardar configuración</button>
			</div>
		</div>
	</div>
</div>
<!-- Modal Configuración Colecturía-->

<aside class="control-sidebar control-sidebar-dark">
	<!-- Create the tabs -->
	<ul class="nav nav-tabs nav-justified control-sidebar-tabs">
	  <li class='active'><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
	  <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-wrench"></i></a></li>
	</ul>
	<!-- Tab panes -->
	<div class="tab-content">
        <!-- Home tab content -->
        <div class="tab-pane active" id="control-sidebar-home-tab">
            <h3 class="control-sidebar-heading">Módulos del sistema</h3>
            <ul class="control-sidebar-menu">
				{sidebar_modulo_acad}
				{sidebar_modulo_admisiones}
				{sidebar_modulo_finan}
				{sidebar_modulo_biblio}
				{sidebar_modulo_medico}
            </ul>
        </div><!-- /.tab-pane -->
        <!-- Stats tab content -->
        <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div><!-- /.tab-pane -->
		<!-- Settings tab content -->
		<div class="tab-pane" id="control-sidebar-settings-tab">
			<form method="post">
				<h3 class="control-sidebar-heading">Configuración general</h3>
				<div class="form-group">
					<label class="control-sidebar-subheading">
						Per&iacute;odo activo
						<button type="button" class="pull-right btn btn-warning btn-xs glyphicon glyphicon-refresh"
							onclick="js_general_change_periodo(document.getElementById('ruta_html_common').value + '/general/controller.php' )"></button>
					</label>
					{cmb_sidebar_periodo}
				</div><!-- /.form-group -->
				<div class="form-group">
					<label class="control-sidebar-subheading">
						Configuración colectur&iacute;a
						<button type="button" class="pull-right btn btn-success btn-xs glyphicon glyphicon-arrow-right" onclick="js_general_settings_get();"
						data-toggle="modal" data-target="#modal_configColecturia"></button>
					</label>
					<p>
						Configuración de parámetros generales del módulo de colecturía.
					</p>
				</div><!-- /.form-group
				<div class="form-group">
					<label class="control-sidebar-subheading">
						Mostrar nombre de usuario y fecha en reportes
						<input type="checkbox" class="pull-right" checked>
					</label>
					<p>
						Permite que los reportes se impriman con los datos del usuario.
					</p>
				</div> --><!-- /.form-group -->
            </form>
        </div><!-- /.tab-pane -->
    </div>
</aside><!-- /.control-sidebar -->
<!-- Add the sidebar's background. This div must be placed
    immediately after the control sidebar -->
<div class="control-sidebar-bg"></div>