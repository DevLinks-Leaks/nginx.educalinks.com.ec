<!--<div id='save_ans' name='save_ans'
	style="text-align:right; padding: 20px 30px; background: rgb(66, 133, 244); z-index: 999999; font-size: 16px; font-weight: 100;">
	<p" style="color: rgba(255, 255, 255, 0.9); display: inline-block; margin-right: 10px; text-decoration: none;"><span class='fa fa-graduation-cap'><span></p>
	<a class="btn btn-default btn-sm" href="#" onclick="dismiss_process_ans();"
		style="margin-top: -5px; border: 0px; box-shadow: none; color: rgb(243, 156, 18); font-weight: 600; background: rgb(255, 255, 255);">Ocultar</a></div>-->
<?php
	$params = array(
		$_POST['curso_cupos'],$_POST['inst_siglas'],$_POST['inst_nomb'],$_POST['inst_nombre_legal'],$_POST['rector_nomb'],
		$_POST['rector_etiqueta'],$_POST['rector_sexo'],$_POST['secr_nomb'],$_POST['secr_etiqueta'],$_POST['secr_sexo'],
		$_POST['es_militar'],$_POST['ciudad'],$_POST['pais'],$_POST['jornada'],$_POST['inst_antes_de_su_nombre'],
		$_POST['financiero_nombre'],$_POST['distr_antes_de_su_nombre'],$_POST['distr_educativo_nomb'],$_POST['inst_dir'],$_POST['url_oficial'],
		$_POST['url_pagina_academico'],$_POST['coordinacion_zonal_nomb'],$_POST['codigo_AMIE'],$_POST['alum_codi_digitos'],$_POST['incluir_alum_ret'],
		$_POST['modo_genera_alum_codi'],$_POST['bloqueo_preinscr_pantalla_bloqueo'],$_POST['show_obs_matri'],$_POST['bloq_matr_por_aprobacion'],$_POST['frm_alum_debito_mandatorio'],
		$_POST['frm_alum_cedula_mandatorio'],$_POST['libretas_show_user_pass'],$_POST['notas_decimales'],$_POST['cantidad_decimales'],$_POST['min_aceptable_supl'],
		$_POST['mostrar_pase_en_libreta'],
		$_POST['vista_libr_repr'],$_POST['sms_alum_admin'],$_POST['sms_alum_doc'],$_POST['sms_alum_alum'],$_POST['sms_alum_repr'],
		$_POST['sms_repr_admin'],$_POST['sms_repr_doc'],$_POST['sms_repr_alum'],$_POST['sms_repr_repr'],$_POST['sms_doc_admin'],
		$_POST['sms_doc_doc'],$_POST['sms_doc_alum'],$_POST['sms_doc_repr'],$_POST['ms_host'],$_POST['ms_user'],
		$_POST['ms_pass'],$_POST['ms_port'],$_POST['ms_sll'],$_POST['mod_doc_citas'],$_POST['mod_alum_cambiar_foto'],
		$_POST['iva_upd_deudas_cero'],$_POST['prontopago'],$_POST['iva'],$_POST['enviar_fac_sri_en_cobro'],$_POST['enviar_cheque_a_bandeja'],
		$_POST['quitar_limite_dias_validez'],$_POST['forma_aplica_descuento'],$_POST['bloqueo'],$_POST['apikey'],$_POST['apikeytoken'],
		$_POST['genera_deuda_matr'],$_POST['bloquea_matr_por_deuda'],$_POST['biblio_genera_multa_por_mora'],$_POST['biblio_bloquea_prestamo_por_deuda'],$_POST['usua_codigo'],
	);
	$sql="{call str_commonParametros_upd(".
		"?,?,?,?,?,?,?,?,?,?,".
		"?,?,?,?,?,?,?,?,?,?,".
		"?,?,?,?,?,?,?,?,?,?,".
		"?,?,?,?,?,?,?,?,?,?,".
		"?,?,?,?,?,?,?,?,?,?,".
		"?,?,?,?,?,?,?,?,?,?,".
		"?,?,?,?,?,?,?,?,?,?,".
		"?)}";
	//$para_sist_busq = sqlsrv_query($conn, $sql, $params);  
	//$row_para_sist = sqlsrv_fetch_array($para_sist_busq);
?>
<div id='save_ans' name='save_ans'
	style="padding: 20px 30px; background: rgb(243, 156, 18); z-index: 999999; font-size: 16px; font-weight: 600;">
	<p" style="color: rgba(255, 255, 255, 0.9); display: inline-block; margin-right: 10px; text-decoration: none;">Los cambios han sido realizados!</p>
	<a class="btn btn-default btn-sm" href="#" onclick="dismiss_process_ans();"
		style="margin-top: -5px; border: 0px; box-shadow: none; color: rgb(243, 156, 18); font-weight: 600; background: rgb(255, 255, 255);">¡Entendido!</a></div>
		