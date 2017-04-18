<?
session_start();	 
include ('../framework/dbconf.php');
include ('../framework/funciones.php');

	if (isset($_POST["alum_codi"]))
	{	$alum_codi = $_POST["alum_codi"];
	}
	else
	{	$alum_codi = "";
	}
	
	if (isset($_POST["alum_apel"]))
	{	$alum_apel = $_POST["alum_apel"];
	}
	else
	{	$alum_apel = "";
	}
	
	if (isset($_POST["curs_para_codi"]))
	{	$curs_para_codi = $_POST["curs_para_codi"];
	}
	else
	{	$curs_para_codi = "0";
	}
  
	$params = array($alum_codi,$alum_apel,$curs_para_codi,$_SESSION['peri_codi']);
	$sql="{call alumnos_main_lista2(?,?,?,?)}";
	$alum_busq = sqlsrv_query($conn, $sql, $params);  
	$cc = 0; 
?>
<div class="alumnos_main_lista">
<style>
	.rTable {
		display: table;
		width: 100%;
	}
	.rTableRow {
		display: table-row;
	}
	.rTableHeading {
		display: table-header-group;
		background-color: #ddd;
	}
	.rTableCell, .rTableHead {
		display: table-cell;
		padding: 3px 10px;
		width: 33%;
		/*border: 1px solid #999999;*/
	}
	.rTableCell, .rTableHead {
		display: table-cell;
		padding: 3px 10px;
		width: 33%;
		/*border: 1px solid #999999;*/
	}
	.rTableHeading {
		display: table-header-group;
		background-color: #ddd;
		font-weight: bold;
	}
	.rTableFoot {
		display: table-footer-group;
		font-weight: bold;
		background-color: #ddd;
	}
	.rTableBody {
		display: table-row-group;
	}
	a,
	a label {
		cursor: pointer;
		text-decoration: none !important;
	}
</style>

<table class="table_striped" id="alum_table">
 <thead>
  <tr>
    <th width="5%" class="sort"><span class="icon-sort icon"></span>&nbsp;Código </th>
    <th width="25%" class="sort"><span class="icon-sort icon"></span>&nbsp;Nombre</th>
    <th width="20%" class="sort"><span class="icon-sort icon"></span>&nbsp;Curso</th>
    <th width="15%" class="sort"><span class="icon-sort icon"></span>&nbsp;Estado</th>
    <th width="35%" class="center"><span class="icon-cog icon"></span>&nbsp;Opciones</th>
  </tr>
 </thead>
 
	<?php 
		
		$perm_22='N';
		$perm_81='N';
		$perm_23='N';
		$perm_24='N';
		if (permiso_activo(22)){  
			$perm_22='A';	
	  	}
		if (permiso_activo(81)){ 
			$perm_81='A';
   	 	}	 
		if (permiso_activo(23)){ 
			$perm_23='A';
   	 	}
		if (permiso_activo(24)){
			$perm_24='A';	
		}	
		if (permiso_activo(91)){
			$perm_91='A';	
		}	
		if (permiso_activo(515)){
			$perm_515='A';
		}
	 ?>
 <tbody>
 <?php  
	while ($row_alum_busq = sqlsrv_fetch_array($alum_busq)) 
	{
		// $params_estado = array($row_alum_busq["alum_curs_para_codi"]);
		// $sql_estado="{call alum_info_alum_est_info(?)}";
		// $stmt_estado = sqlsrv_query($conn, $sql_estado, $params_estado);
		// if( $stmt_estado === false )
		// {
		// 	echo "Error in executing statement .\n";die( print_r( sqlsrv_errors(), true));
		// }
		// $alum_est_view= sqlsrv_fetch_array($stmt_estado);
		$nombre_completo = validarTildeHTML($row_alum_busq["alum_apel"])." ".validarTildeHTML($row_alum_busq["alum_nomb"]);
		$cc +=1; ?>
		<tr>
			<td><?php echo $row_alum_busq["alum_codi"]; ?></td>
			<td><?php echo $nombre_completo; ?></td>
			<td><?php echo $row_alum_busq["curs_deta"]." - ".$row_alum_busq["para_deta"]; ?></td>
			<td><?php echo $row_alum_busq["esta_deta"]; ?></td>
			<td >
				<?php 
				unset($opciones);
				$tabla = "";
				$opciones = array();
				if ($perm_22=='A')
				{   $opciones[]="<div class='rTableCell'>
						<!-- <a 
							class='option'
							data-toggle='modal'
							data-target='#ModalMatri'
							onclick=\"
							document.getElementById('ModalMatri_title').innerHTML='".PrimeraMayuscula($nombre_completo)."';
							document.getElementById('div_cambiar_estado').innerHTML='';
							document.getElementById('div_blacklist_view').innerHTML='';
							document.getElementById('alum_codi').value='".$row_alum_busq['alum_codi']."';
							document.getElementById('adm_est_alum_est_codi').value='".$alum_est_view['alum_est_peri_codi']."';
							document.getElementById('adm_est_alum_est_det').value='".PrimeraMayuscula($alum_est_view['alum_est_det'])."';
							document.getElementById('div_adm_est_alum_curs_para_codi').innerHTML='".PrimeraMayuscula($alum_est_view['alum_est_det'])."';
							document.getElementById('adm_est_curs_para_codi').value='".$row_alum_busq['curs_para_codi']."';
							document.getElementById('adm_est_alum_curs_para_codi').value='".$row_alum_busq['alum_curs_para_codi']."';
							document.getElementById('peri_0').onchange();document.getElementById('div_bloqueos_view').innerHTML=''\" >
							<span class='icon-signup icon' style='margin-right:3px;'></span>&nbsp;Estado</a> -->
							<a 
							class='option' 
							data-toggle='modal' 
							data-target='#ModalEstado' 
							onclick=\"load_ajax('modal_estado_content','modal_estado_view.php','alum_codi=". $row_alum_busq['alum_codi']."');\" >
							<span class='icon-signup icon' style='margin-right:3px;'></span>&nbsp;Estado</a>
					</div>";
				}
				if ($perm_81=='A')
				{
					$opciones[]="
					<div class='rTableCell'>
						<a 
							class='option'
							data-toggle='modal' 
							data-target='#ModalDocumentos'
							onclick=\"document.getElementById('alum_curs_para_codi').value=".$row_alum_busq['alum_curs_para_codi'].";document.getElementById('alum_codi').value=".$row_alum_busq['alum_codi'].";\">
								<span class='icon-print icon' style='margin-right:3px;'></span>&nbsp;Documentos
						</a>
					 </div>";
				}
				if ($perm_23=='A')
				{	$opciones[]="
					<div class='rTableCell'>
						<a 
							class='option'
							onclick=\"window.location='alumnos_add.php?alum_codi='+".$row_alum_busq["alum_codi"] .";\" >
							<span class='icon-pencil2 icon' style='margin-right:3px;'></span>&nbsp;Editar
						</a>
					</div>";
				}
				if ($perm_24=='A')
				{	$opciones[]="
					<div class='rTableCell'>
						<a 
							class='option' 
							onclick=\"load_ajax_del_alum('opc=alum_delete&alum_codi=". $row_alum_busq['alum_codi'] ."')\" >
							<span class='icon-remove icon' style='margin-right:3px;'></span>&nbsp;Eliminar</a>
					</div>";
				}
				if ($perm_515=='A')
				{	$opciones[]="
					<div class='rTableCell'>
						<a 
							class='option'
							data-target='#ModalAlumBloqAdd'
							data-toggle='modal'
							onclick=\"show_edit_bloqueo('div_bloqueos',". $row_alum_busq["alum_codi"] .",'alum_moti_bloq_opci_view');\">
							<span class='icon-lock icon' style='margin-right:3px;'></span>&nbsp;Bloquear</a>
					</div>";
				}
				if (permiso_activo(22)){
					if ($row_alum_busq["alum_curs_para_codi"]!="")
					{	$opciones[]="
						<div class='rTableCell'>
						<a 
							class='option'
							data-target='#ModalCambiarCurso'
							data-toggle='modal'
							onclick=\"alum_curs_para_info(". $row_alum_busq["alum_curs_para_codi"] .");document.getElementById('alum_curs_para_codi').value=". $row_alum_busq["alum_curs_para_codi"].";\">
							<span class='icon-cog icon' style='margin-right:3px;'></span><span style='font-size:x-small'> &nbsp;Cambiar Curso</span></a>
						</div>";
					}
				}
				if (permiso_activo(528))
				{	$opciones[]="
					<div class='rTableCell'>
						<a 
							class='option'
							data-target='#ModalBlacklistAdd'
							data-toggle='modal'
							onclick=\"load_ajax('modal_main_blacklist','script_alumnos_blacklist.php','bl_alum_codi=".$row_alum_busq["alum_codi"]."&opc=edit_view_new');\">
							<span class='icon-lock icon' style='margin-right:3px;'></span>&nbsp;Blacklist</a>
					</div>";
				}
				$opciones[]="
				<div class='rTableCell'>
					<a class='option'
						onclick=\"window.location='representantes_add.php?alum_codi='+".$row_alum_busq["alum_codi"] .";\">
						<span class='icon-users icon' style='margin-right:3px;'></span>&nbsp;Familiares</a>
				</div>";
				$tabla=alumnos_main_genera_tabla_por_columnas($opciones, 3, 0,'100%','left');// función está en funciones.php
				echo $tabla;
				
			?>
			</td>
		</tr>
	<?php  
	
	}
	?>
	</tbody>
	<tfoot>
		<tr class="pager_table" >
			<td colspan="2"><span class="icon-users icon"></span> Total de Alumnos ( <?php echo $cc; ?> )</td>
			<td colspan="2" class="right"><div class="paging"></div></td>
		</tr>
	</tfoot>
</table>
</div>
<?php
function alumnos_main_genera_tabla_por_columnas($array_con_td, $num_columnas=2, $border=0, $width='100%', $align='center')
{	$aux = 0;
	$c = count($array_con_td);
	$body = "";
	$body.='<div class="rTableRow">';
	$tr = 1;
	while ($aux < $c)
	{	$body.=  $array_con_td[$aux];
		$aux+=1;
		if (fmod($aux, $num_columnas)==0) 
		{	$body.='</div><div class="rTableRow">';
			$tr++;
		}
	}
	$tr = $tr * $num_columnas;
	$td_faltantes = $tr - $c;
	
	for ( $aux2=0; $aux2<$td_faltantes; $aux2++ )
	   $body.='<div class="rTableCell"></div>';
	$body.='</div>';
	
	$table= "<div class='rTable' style='text-align:".$align."; width:".$width."' >";
	$table.= $body;
	$table.= "</div>";
	
	return $table;
}
?>