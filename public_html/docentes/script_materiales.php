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
		<table class="table table-striped table-bordered">
			<thead style='background-color:rgba(1, 126, 186, 0.1) !important;'>
				<tr>
					<th>Detalle</th>
					<th style='text-align:center;'>Fecha</th>
					<th style='text-align:center;'>Opciones</th>
				</tr>
			</thead>
			<tbody>
			<?php while($row_mater_view = sqlsrv_fetch_array($stmp_mater)){?>
				<tr>
					<td><h4><?= $row_mater_view['mater_titu'];?></h4><br><?= $row_mater_view['mater_deta'];?></td>
					<td style='text-align:center;'><?= date_format($row_mater_view['mater_fech_regi'],'d/m/Y');?></td>
					<td style='text-align:center;'>
						<a class="btn btn-default " href="<?= $_SESSION['ruta_materiales_carga'].$row_mater_view['mater_file'];?>" ><span class="fa fa-download"></span> Descargar</a>
						<a class="btn btn-default" href="javascript:elimina_materiales('div_materiales','script_materiales.php','<?= $row_mater_view['mater_codi'];?>','<?=$_POST['curs_para_mate_prof_codi']?>')" ><span class="fa fa-trash btn_opc_lista_eliminar"></span>  Eliminar</a>
					</td>
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