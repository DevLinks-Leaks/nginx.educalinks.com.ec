<?php
session_start();
include ('../framework/dbconf.php');
include ('../framework/funciones.php');
if(isset($_POST['opc'])){$opc=$_POST['opc'];}else{$opc="";}
switch($opc){
	case 'set_alum':
		if(isset($_POST['alum_codi'])){$alum_codi=$_POST['alum_codi'];}else{$alum_codi="";}
		if(isset($_POST['repr_codi'])){$repr_codi=$_POST['repr_codi'];}else{$repr_codi="";}
		
		$params2 = array($alum_codi,$_SESSION['peri_codi']);
		$sql2="{call alum_info_repr(?,?)}";
		$resu_alum_info = sqlsrv_query($conn, $sql2, $params2);  
		$row_resu_alum_info = sqlsrv_fetch_array($resu_alum_info);
		
		
		$_SESSION['alum_codi']=$row_resu_alum_info['alum_codi'];
		$_SESSION['alum_nomb']=$row_resu_alum_info['alum_nomb'];
		$_SESSION['alum_apel']=$row_resu_alum_info['alum_apel'];
		$_SESSION['alum_mail']=$row_resu_alum_info['alum_mail'];
		$_SESSION['alum_usua']=$row_resu_alum_info['alum_usua'];
		$_SESSION['alum_celu']=$row_resu_alum_info['alum_celu'];
		$_SESSION['alum_fech_naci']=date_format($row_resu_alum_info['alum_fech_naci'],'d/m/Y');
		$_SESSION['alum_domi']=$row_resu_alum_info['alum_domi'];
		$_SESSION['alum_telf']=$row_resu_alum_info['alum_telf'];
		$_SESSION['alum_cedu']=$row_resu_alum_info['alum_cedu'];
		$_SESSION['alum_ciud']=$row_resu_alum_info['alum_ciud'];
		$_SESSION['alum_reli']=$row_resu_alum_info['alum_reli'];
		$_SESSION['alum_pais']=$row_resu_alum_info['alum_pais'];
		$_SESSION['alum_estado_civil_padres']=$row_resu_alum_info['alum_estado_civil_padres'];
		$_SESSION['alum_telf_emerg']=$row_resu_alum_info['alum_telf_emerg'];
		$_SESSION['alum_ex_plantel']=$row_resu_alum_info['alum_ex_plantel'];
		$_SESSION['curs_para_codi']=$row_resu_alum_info['curs_para_codi'];
		$_SESSION['curs_codi']=$row_resu_alum_info['curs_codi'];
		$_SESSION['para_codi']=$row_resu_alum_info['para_codi'];
		$_SESSION['peri_dist_cab_tipo']=$row_resu_alum_info['peri_dist_cab_tipo'];
		$_SESSION['alum_upd']=$row_resu_alum_info['alum_upd'];
		if ($_SESSION['alum_upd']==0)
			$_SESSION['ISBIEN_ALUM'] = 'INNOT';
		else
			$_SESSION['ISBIEN_ALUM'] = 'YESIN';
	break;
}
?>