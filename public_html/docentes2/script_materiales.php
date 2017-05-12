<?php
session_start();
include ('../framework/dbconf.php');
include ('../framework/funciones.php');
if(isset($_POST['opc'])){$opc=$_POST['opc'];}else{$opc="";}

switch($opc){
	case 'mater_view':
		$params_mater = array($_POST['curs_para_mate_prof_codi']);
		$sql_mater="{call curs_para_mate_mater_view(?)}";
		$stmp_mater = sqlsrv_query($conn, $sql_mater, $params_mater);?>
		<table class="table_striped">
			<thead>
				<tr>
					<th>Detalle</th>
					<th>Fecha</th>
					<th>Opciones</th>
				</tr>
			</thead>
			<tbody>
			<?php while($row_mater_view = sqlsrv_fetch_array($stmp_mater)){?>
				<tr>
					<td><h4><?= $row_mater_view['mater_titu'];?></h4><br><?= $row_mater_view['mater_deta'];?></td>
					<td><?= date_format($row_mater_view['mater_fech_regi'],'d/m/Y');?></td>
					<td><div><a href="<?= $_SESSION['ruta_materiales_carga'].$row_mater_view['mater_file'];?>" >Descargar</a></div>
                    <div><a href="javascript:elimina_materiales('div_materiales','script_materiales.php','<?= $row_mater_view['mater_codi'];?>','<?=$_POST['curs_para_mate_prof_codi']?>')" >Eliminar</a></div></td>
				</tr>
			<?php }?>
			</tbody>
		</table>
		<?
	break;
	case 'mater_del':
		$params = array($_POST['mater_codi']);
		$sql="{call mater_del(?)}";
		$stmp = sqlsrv_query($conn, $sql, $params);	
		if( $conn === false){echo "Error in connection.\n";die( print_r( sqlsrv_errors(), true));}
	break;
	
}
?>