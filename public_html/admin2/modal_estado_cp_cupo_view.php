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
		if($cupo_disponible==0)
			echo "<td>Cupo Disponible:</td><td ><span id='span_cupo' data-cupo='0'><div class='alert alert-danger' role='alert'>No existe cupo disponible.</div></span></td>";
		else
			echo "<td>Cupo Disponible:</td><td><span id='span_cupo' data-cupo='".$cupo_disponible."'>".$cupo_disponible."</span></td>";
	}
	else
	{
		echo "<td>Cupo Disponible:</td><td><span id='span_cupo' data-cupo='0'>--</span></td>";
	}
?>