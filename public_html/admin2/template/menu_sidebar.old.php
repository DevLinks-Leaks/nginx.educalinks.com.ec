<!-- Modal Configuración Colecturía-->
<div class="modal fade" id="modal_configColecturia" tabindex="-1" role="dialog" aria-labelledby="modal_configColecturia" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header" style='background-color:#1A286A'>
				<h4 class="modal-title" id="modal_configColecturia" style='color:white;'>
					<i style="font-size:large;color:white;" class="fa fa-cog fa-spin"></i>&nbsp;Parámetros del sistema</h4>
			</div>
			<div class="modal-body" id="modal_configColecturia_body" style='background-color:#f4f4f4;'>
			</div>
			<div class="modal-footer" style='background-color:#f4f4f4;'>
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				<button type="button" class="btn btn-primary"
					onclick="js_general_settings_change(
							document.getElementById('check_usa_pp_dv').checked,
							document.getElementById('desc_pronto').value,
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
<!-- Modal Configuración Botón-->
<div class="modal fade" id="modal_configBoton" tabindex="-1" role="dialog" aria-labelledby="modal_configBoton" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header" style='background-color:#1A286A'>
				<h4 class="modal-title" id="modal_configBoton" style='color:white;'>
					<i style="font-size:large;color:white;" class="fa fa-desktop"></i>&nbsp;Configuración de Botón de Pagos</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<!--<form id='frm_ptoEmisionAdd' name='frm_ptoEmisionAdd' 
					onsubmit="return js_general_config_bdp_change( )" role="form" data-toggle="validator">-->
				<div class="modal-body" id="modal_configBoton_body" style='background-color:#f4f4f4;'>
				</div>
				<div class="modal-footer" style='background-color:#f4f4f4;'>
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
					<button type="text" class="btn btn-primary" 
						onClick="return js_general_config_bdp_change( )" >
							<span class='fa fa-wrench'></span>&nbsp;Guardar configuración</button>
				</div>
			<!--</form>-->
		</div>
	</div>
</div>
<!-- Modal Configuración Botón-->
<aside class="control-sidebar control-sidebar-dark">
	<div class="tab-content">
        <!-- Home tab content -->
        <div class="tab-pane active" id="control-sidebar-home-tab">
            <h3 class="control-sidebar-heading">Módulos del sistema</h3>
            <ul class="control-sidebar-menu">
				<?php
			$acad = '	<li>
							<a href="../../../admin/index.php" title="Ir al módulo académico">
								<i class="menu-icon fa fa-graduation-cap bg-yellow"></i>
								<div class="menu-info">
									<h4 class="control-sidebar-subheading">Académico</h4>
									<p>Notas, tutoría, clase virtual</p>
								</div>
							</a>
						</li>';
			$admisiones = '	<li>
							<a href="../../../main_admisiones.php" title="Ir al módulo admisiones">
								<i class="menu-icon fa fa-child bg-orange"></i>
								<div class="menu-info">
									<h4 class="control-sidebar-subheading">Admisiones</h4>
									<p>Proceso de solicitudes, ingreso de documentos</p>
								</div>
							</a>
						</li>';
			$finan = '<li>
							<a href="../../../main_finan.php" title="Ir al módulo financiero">
								<i class="menu-icon fa fa-usd bg-green"></i>
								<div class="menu-info">
									<h4 class="control-sidebar-subheading">Financiero</h4>
									<p>Colecturía, cobranza y facturación electrónica</p>
								</div>
							</a>
						</li>';
			$biblio = '<li>
							<a href="../../../biblio/index.php" title="Ir al módulo biblioteca">
							  <i class="menu-icon fa fa-book bg-light-blue"></i>
							  <div class="menu-info">
								<h4 class="control-sidebar-subheading">Biblioteca</h4>
								<p>Mantenimiento de inventario de biblioteca</p>
							  </div>
							</a>
						</li>';
			$medico = '<li>
							<a href="../../../main_medic.php" title="Ir al módulo médico">
							  <i class="menu-icon fa fa-medkit bg-red"></i>
							  <div class="menu-info">
								<h4 class="control-sidebar-subheading">Médico</h4>
								<p>Inventario médico y ficha médica ocupacional</p>
							  </div>
							</a>
						</li>';
				
			echo $acad;
			//echo $admisiones;
			if($_SESSION['rol_finan']==1)
				echo $finan;
			if($_SESSION['rol_biblio']==1)
				echo $biblio;
			if($_SESSION['rol_medico']==1)
				echo $medico;
			?>
            </ul>
        </div><!-- /.tab-pane -->
    </div>
</aside><!-- /.control-sidebar -->
<!-- Add the sidebar's background. This div must be placed
    immediately after the control sidebar -->
<div class="control-sidebar-bg"></div>