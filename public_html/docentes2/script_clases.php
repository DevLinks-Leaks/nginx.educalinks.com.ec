<?php
session_start();
include ('../framework/dbconf.php');
include ('../framework/funciones.php');
if(isset($_POST['opc'])){$opc=$_POST['opc'];}else{$opc="";}
switch($opc){
	case 'agen_view':
		$tipo_usua="A";
		$params_agen = array($_POST['curs_para_mate_codi'],$tipo_usua);
		$sql_agen="{call agen_curs_para_mate_view(?,?)}";
		$stmp_agen = sqlsrv_query($conn, $sql_agen, $params_agen); 
		while($row_agen_curs_view= sqlsrv_fetch_array($stmp_agen)){?>
			<table class="table">
                <thead>
                    <tr>
                        <th colspan="3"><?="(".$row_agen_curs_view['mate_deta'].") - ".$row_agen_curs_view['agen_titu']?></th>
                    </tr>
                    <tr>
                        <th width="50%">Detalle</th>
                        <th>Fecha Ingeso</th>
                        <th>Fecha de Entrega</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?=$row_agen_curs_view['agen_deta']?>
                        </td>
                        <td><?=date_format($row_agen_curs_view['agen_fech_ini'], 'd/m/Y')?>
                        </td>
                        <td><?=date_format($row_agen_curs_view['agen_fech_fin'], 'd/m/Y')?>
                        </td>
                    </tr>
                </tbody>
            </table>
		<?php } 
	break;
}
?>