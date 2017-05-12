<?php 
	include ('../framework/dbconf.php');
	
	if (isset($_POST["alum_codi"])){$alum_codi = $_POST["alum_codi"];}

	$params = array($alum_codi,$_SESSION['peri_codi']);
	$sql="{call alum_esta_info(?,?)}";
	$alum_esta_info_obse = sqlsrv_query($conn, $sql, $params);  
	$alum_esta_info_obse= sqlsrv_fetch_array($alum_esta_info_obse);
?>
<label style="padding-right: 90%;" for="txt_obs"><b>Observación</b>: </label><br/>
<textarea style="padding-right: 40%;width:100%;" id="txt_obse" name="txt_obs" rows="3" title="Presione enter para ingresar la Observación" cols="3" ><?=$alum_esta_info_obse['alum_curs_para_obse'];?></textarea>
<button id="btn_add_obse" type='button' class='btn btn-success' onclick="add_obse('div_obse',<?=$alum_esta_info_obse['alum_curs_para_codi'];?>,<?=$alum_codi?>);">Guardar Observación</button>