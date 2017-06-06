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
<!-- Modal Módulos-->
<div class="modal fade" id="ModalEducalinksMoludos" tabindex="-1" role="dialog" aria-labelledby="modal_configBoton" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header" style='background-color:#E55A2F'>
				<h4 class="modal-title" id="ModalEducalinksMoludos_head" style='color:white;text-align:center;'>
					<i style="font-size:large;color:white;" class="fa fa-briefcase"></i>&nbsp;Módulos del sistema</h4>
			</div>
			<div class="modal-body" id="ModalEducalinksMoludos_body" style='background-color:#F5F5F5;'>
				<div class="row">
					<div class="col-xs-12">
						<?php if($_SESSION['certus_acad']){ ?>
							<a href="../../../admin/index.php" title="Ir al módulo académico" style='width:100%' class='btn btn-warning'>
								<i class='fa fa-graduation-cap'></i>&nbsp;Académico
							</a><br><br><?php }?>
						<?php if($_SESSION['certus_finan']){ if($_SESSION['rol_finan']==1){?>
							<a href="../../../main_finan.php" title="Ir al módulo financiero" style='width:100%' class='btn btn-success'>
								<i class='fa fa-dollar'></i>&nbsp;Financiero
							</a><br><br><?php }}?>
						<?php if($_SESSION['certus_biblio']){ if($_SESSION['rol_biblio']==1){?>
							<a href="../../../biblio/index.php" title="Ir al módulo biblioteca" style='width:100%' class='btn btn-primary'>
								<i class='fa fa-book'></i>&nbsp;Biblioteca
							</a><br><br><?php }}?>
						<?php if($_SESSION['certus_medic']){ if($_SESSION['rol_medico']==1){?>
							<a href="../../../main_medic.php" title="Ir al módulo médico" style='width:100%' class='btn btn-danger'>
							<i class='fa fa-medkit'></i>&nbsp;Médico
							</a><br><br><?php }}?>
					</div>
				</div>
			</div>
			<div class="modal-footer" style='background-color:#F5F5F5;text-align:center'>
				<button type="button" class="btn btn-default" data-dismiss="modal">Ocultar</button>
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