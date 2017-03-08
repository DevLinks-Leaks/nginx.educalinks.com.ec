<?php
	include ('../framework/dbconf.php');

	$alum_codi = $_POST["alum_codi"];
	$params = array($alum_codi,$_SESSION['peri_codi']);
	$sql="{call alum_esta_info(?,?)}";
	$alum_esta_info = sqlsrv_query($conn, $sql, $params);  
	$alum_esta_info= sqlsrv_fetch_array($alum_esta_info);
	

?>
<table width='100%'>
	<tr>
		<td width='120px' height='40px' valign='bottom' colspan='2'><b>Estados de estudiante matriculado</b></td>
	</tr>
	<tr>
		<td width='90%' height='1px' >
			<div style='font-size:1px'><hr style='height:1px; margin-top: 0.5em;' />
			</div>
		</td>
	</tr>
	<tr>
		<td >
			<table width='100%'>
				<tr>
					<td width='50%'>
						<input id='check_column_1' name='check_column_1' type='checkbox' <?= ($alum_esta_info['acpe_matr_nueva']==1) ? 'checked' : ''; ?> onClick="load_ajax_alum_info_est('div_estado_detalle', 'script_alum.php', 'alum_info_alum_est_check', this.checked, '<?=$alum_esta_info['alum_curs_para_codi'];?>', '<?=$alum_codi;?>', 1)">
						<label for='check_column_1'>Matrícula Nueva</label>
					</td>
					<td width='50%'>
						<input id='check_column_2' name='check_column_2' type='checkbox' <?= ($alum_esta_info['acpe_matr_extr']==1) ? 'checked' : ''; ?> onClick="load_ajax_alum_info_est('div_estado_detalle', 'script_alum.php', 'alum_info_alum_est_check', this.checked, '<?=$alum_esta_info['alum_curs_para_codi'];?>', '<?=$alum_codi;?>', 2)">
						<label for='check_column_2'>Matrícula extranjero</label>
					</td>
				</tr>
				<tr>
					<td width='50%'>
						<input id='check_column_3' name='check_column_4' type='checkbox' <?= ($alum_esta_info['acpe_matr_con_pase']==1) ? 'checked' : ''; ?> onClick="load_ajax_alum_info_est('div_estado_detalle', 'script_alum.php', 'alum_info_alum_est_check', this.checked, '<?=$alum_esta_info['alum_curs_para_codi'];?>', '<?=$alum_codi;?>', 3)">
						<label for='check_column_3'>Matrícula con pase</label>
					</td>
					<td width='50%'>
						<input id='check_column_4' name='check_column_4' type='checkbox' <?= ($alum_esta_info['acpe_ret_con_pase']==1) ? 'checked' : ''; ?> onClick="load_ajax_alum_info_est('div_estado_detalle', 'script_alum.php', 'alum_info_alum_est_check', this.checked, '<?=$alum_esta_info['alum_curs_para_codi'];?>', '<?=$alum_codi;?>', 4)">
						<label for='check_column_4'>Retiro con pase</label>
					</td>
				</tr>
				<tr>
					<td width='50%'>
						<input id='check_column_5' name='check_column_5' type='checkbox' <?= ($alum_esta_info['acpe_ret_exp']==1) ? 'checked' : ''; ?> onClick="load_ajax_alum_info_est('div_estado_detalle', 'script_alum.php', 'alum_info_alum_est_check', 
				this.checked, '<?=$alum_esta_info['alum_curs_para_codi'];?>', '<?=$alum_codi;?>', 5)">
						<label for='check_column_5'>Retiro expulsado</label>
					</td>
					<td width='50%'>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>