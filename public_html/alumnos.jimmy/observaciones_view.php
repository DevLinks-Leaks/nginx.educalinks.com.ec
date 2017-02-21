<?php
	if ($_GET['tipo_observacion']!=0)
	{
		include ("../framework/dbconf.php");
		session_start(); 			
		$params_obs=array($_SESSION['peri_codi'],$_SESSION['alum_codi'], $_GET['tipo_observacion']);
		$sql_obs="{call observacion_alum_info_por_tipo(?,?,?)}";
		$stmp_obs = sqlsrv_query($conn, $sql_obs,$params_obs);
		if( $conn === false)
		{
			echo "Error in connection.\n";
			die( print_r( sqlsrv_errors(), true));
		}
?>
        <div>&nbsp;</div>
        <table class="table_striped">
            <thead>
                <tr>
                    <th colspan="5" class="center">
                        Observaciones
                    </th>
                </tr>
                <tr>
                    <th width="15%">Tipo de Observaci&oacute;n</th>
                    <th width="40%">Observaci&oacute;n</th>
                    <th width="15%">Profesor</th>
                    <th width="15%">Rol</th>
                    <th width="15%">Fecha de Ingreso</th>
                </tr>
            </thead>
            <tbody>
            <?php 
            while($row_obs_view=sqlsrv_fetch_array($stmp_obs)){?>
                <tr>
                    <td><?=$row_obs_view['obse_tipo_deta'];?></td>
                    <td><?=$row_obs_view['obse_deta'];?></td>
                    <td><?=$row_obs_view['usua_deta'];?></td>
                    <td><?=$row_obs_view['usua_tipo'];?></td>
                    <td><?=date_format($row_obs_view['obse_fech'],"d/m/Y");?></td>
                </tr>
            <?php }?>
            </tbody>
        </table>
 <?php 
 	} 
 ?>