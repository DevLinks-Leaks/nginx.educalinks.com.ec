<?php 
	include ('../framework/dbconf.php');
	
	if (isset($_POST["alum_codi"])){$alum_codi = $_POST["alum_codi"];}

	$params = array($alum_codi,$_SESSION['peri_codi']);
	$sql="{call alum_esta_info(?,?)}";
	$alum_esta_info_ret = sqlsrv_query($conn, $sql, $params);  
	$alum_esta_info_ret= sqlsrv_fetch_array($alum_esta_info_ret);
	
	$alum_curs_para_fech_retiro = ($alum_esta_info_ret['alum_curs_para_fech_retiro']==null) ? '' : date_format($alum_esta_info_ret['alum_curs_para_fech_retiro'], 'd/m/Y' );
?>
<table width="100%">
	<tr>
		<td height='40px' valign='bottom' colspan='2'><b>Retiro de Estudiante</b></td>
	</tr>
	<tr>
		<td height='1px' colspan='2'>
			<div style='font-size:1px'><hr style='height:1px; margin-top: 0.5em;' />
			</div>
		</td>
	</tr>
	<tr>
		<td height='30px' width="30%">
			<label for='retirado'>Retirado: </label>
		</td>
		<td height='30px'>
			<input id='retirado' name='retirado' type='checkbox' <?= ($alum_curs_para_fech_retiro!='') ? 'checked' : ''; ?> onClick="load_ajax_retiro('div_estado_retiro', 'script_alum.php', this.checked, '<?=$alum_codi;?>','<?=$alum_esta_info_ret['alum_curs_para_codi'];?>');">
		</td>
	</tr>
	<?php if($alum_curs_para_fech_retiro!=''){ ?>
	<tr>
		<td>
			<label for='fech_retirado'>Fecha Retiro: </label>
		</td>
		<td><?= $alum_curs_para_fech_retiro;?></td>
	</tr>
	<? } ?>
</table>