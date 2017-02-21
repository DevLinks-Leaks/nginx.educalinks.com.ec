<?php
session_start();
include ('../framework/dbconf.php');
include ('../framework/funciones.php');
if(isset($_POST['opc'])){$opc=$_POST['opc'];}else{$opc="";}
switch($opc){
	case 'agen_view':
		$tipo_usua="A";
		if($_POST['curs_para_mate_prof_codi']=='0'){
			$alum_codi=$_SESSION['alum_codi'];
			$peri_codi=$_SESSION['peri_codi'];
			$params_agen = array($alum_codi,$peri_codi);
			$sql_agen="{call agen_curs_para_mate_view_all(?,?)}";
			$stmp_agen = sqlsrv_query($conn, $sql_agen, $params_agen); 
		}else{
			$curs_para_mate_prof_codi=$_POST['curs_para_mate_prof_codi'];
			$params_agen = array($curs_para_mate_prof_codi,'T');
			$sql_agen="{call agen_curs_para_mate_view(?,?)}";
			$stmp_agen = sqlsrv_query($conn, $sql_agen, $params_agen); 
		}
		
		while($row_agen_curs_view= sqlsrv_fetch_array($stmp_agen)){?>
			<div class="panel panel-success">
				<div class="panel-heading"><?="(".$row_agen_curs_view['mate_deta'].") - ".$row_agen_curs_view['agen_titu']?></div>
				<div class="panel-body">
					<table class="table table-hover" width="90%">
						<tbody>
							<tr>
								<th width="60%"><strong>Detalle</strong></th>
								<th width="20%"><strong>Fecha Ingreso</strong></th>
								<th width="20%"><strong>Fecha de Entrega</strong></th>
							</tr>
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
				</div>
			</div>
		<?php } 
	break;
}
?>