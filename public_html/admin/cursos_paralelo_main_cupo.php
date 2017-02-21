<?php 
session_start();	 
include ('../framework/dbconf.php');

if(isset($_POST['curs_para_codi']))
	$curs_para_codi=$_POST['curs_para_codi'];
else
	$curs_para_codi=0;

if ($curs_para_codi!=0)
{
	$params = array($curs_para_codi);
	$sql="{call curs_peri_info(?)}";
	$curs_cupo_view = sqlsrv_query($conn, $sql, $params);  
	$cupo_disponible=0;
	while ($row_curs_cupo_view = sqlsrv_fetch_array($curs_cupo_view))
	{ 
		$cupo_disponible=$row_curs_cupo_view["cupo_disp"];
	}
	echo "<span id='span_cupo'>".$cupo_disponible."</span>";
}
else
{
	echo "--";
}
?>
