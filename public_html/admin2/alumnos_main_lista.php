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
	{	$curs_para_codi = "-1";
	}
	
	if (isset($_POST["grupo_economico"]))
	{	$grupo_economico = $_POST["grupo_economico"];
	}
	else
	{	$grupo_economico = "-1";
	}
	if (isset($_POST["nivel"]))
	{	$nivel = $_POST["nivel"];
	}
	else
	{	$nivel = "-1";
	}
	if (isset($_POST["alum_id"]))
	{	$alum_id = $_POST["alum_id"];
	}
	else
	{	$alum_id = "";
	}
	if (isset($_POST["fechanac_ini"]))
	{	$fechanac_ini = $_POST["fechanac_ini"];
	}
	else
	{	$fechanac_ini = "";
	}
	if (isset($_POST["fechanac_fin"]))
	{	$fechanac_fin = $_POST["fechanac_fin"];
	}
	else
	{	$fechanac_fin = "";
	}
	if (isset($_POST["fechamatri_ini"]))
	{	$fechamatri_ini = $_POST["fechamatri_ini"];
	}
	else
	{	$fechamatri_ini = "";
	}
	if (isset($_POST["fechamatri_fin"]))
	{	$fechamatri_fin = $_POST["fechamatri_fin"];
	}
	else
	{	$fechamatri_fin = "";
	}
	if (isset($_POST["alum_estado"]))
	{	$alum_estado = $_POST["alum_estado"];
	}
	else
	{	$alum_estado = "-1";
	}
  
	$params = array(
		$alum_codi,			$alum_apel,			$_SESSION['peri_codi'],
		$alum_id,			$grupo_economico,	$nivel,
		$fechanac_ini,		$fechanac_fin,		$fechamatri_ini,
		$fechamatri_fin,	$curs_para_codi,	$alum_estado);
	$sql="{call alumnos_main_lista2(?,?,?,?,?,?,?,?,?,?,?,?)}";
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
	a {
		/*color: #424242;*/
	}
	a,
	a label {
		cursor: pointer;
		text-decoration: none !important;
	}
	a:hover {
		color: #4285F4;
	}
</style>
<table class="table table-striped table-hover" id="alum_table">
 <thead style='background-color:rgba(1, 126, 186, 0.1) !important;'>
  <tr>
    <th style="text-align:left">&nbsp;Alumnos </th>
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
		<tr><td>
			<div class='form-horizontal'>
				<div class='row'>
					<div class='col-lg-6 col-md-6 col-sm-12 col-sm-12' style="text-align:left">
						<b style='color:#2d3c4a;'><?php echo $nombre_completo; ?></b><br>
						<small><b style='color:#2d3c4a;'>Código:</b>&nbsp;<?php echo $row_alum_busq["alum_codi"]; ?></small><br>
						<small><b style='color:#2d3c4a;'>Estado:</b>&nbsp;
							<?php 
								if ( $row_alum_busq["esta_deta"] == 'MATRICULADO') echo '<span style="color:#17ca34">'.$row_alum_busq["esta_deta"].'</span>'; 
								else if ( $row_alum_busq["esta_deta"] == 'RETIRADO') echo '<span style="color:#e24b4b">'.$row_alum_busq["esta_deta"].'</span>'; 
								else echo $row_alum_busq["esta_deta"]; ?></small> |&nbsp;
						<small><b style='color:#2d3c4a;'>Curso:</b>&nbsp;
						<?php
						if(permiso_activo(10))
							echo "<a href='cursos_paralelo_main.php?curs_para_codi=".$row_alum_busq['curs_para_codi']."'
									title='Ver información del curso ".$row_alum_busq["curs_deta"]." - ".$row_alum_busq["para_deta"]."'>".$row_alum_busq["curs_deta"]." - ".$row_alum_busq["para_deta"]."</a>";
						else
							echo $row_alum_busq["curs_deta"]." - ".$row_alum_busq["para_deta"];
						?></small>
					</div>
					<div class='col-lg-6 col-md-6 col-sm-12 col-sm-12' style="text-align:center">
						<?php 
						unset($opciones);
						$tabla = "";
						$opciones = array();
						if ($perm_22=='A' and $row_alum_busq["alum_estado"]=='A')
						{   $opciones[]="<div class='rTableCell'>
									<a 
									class='option' 
									data-toggle='modal' 
									data-target='#ModalEstado' 
									onclick=\"load_ajax('modal_estado_content','modal_estado_view.php','alum_codi=". $row_alum_busq['alum_codi']."');\" >
									<span class='fa fa-clipboard' style='margin-right:3px;'></span>Estado</a>
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
									onclick=\"load_ajax('div_document','modal_documentos_view.php','alum_codi=". $row_alum_busq['alum_codi']."&alum_curs_para_codi=". $row_alum_busq['alum_curs_para_codi']."');\">
										<span class='fa fa-print' style='margin-right:3px;'></span><span>&nbsp;Documentos</span>
								</a>
							 </div>";
						}
						if ($perm_23=='A')
						{	$opciones[]="
							<div class='rTableCell'>
								<a 
									class='option btn_opc_lista_editar'
									onclick=\"window.location='alumnos_add.php?alum_codi=".$row_alum_busq["alum_codi"]."';\" >
									<span class='fa fa-pencil' style='margin-right:3px;'></span>&nbsp;Editar
								</a>
							</div>";
						}
						if ($perm_24=='A')
						{	$opciones[]="
							<div class='rTableCell'>
								<a 
									class='option' 
									onclick=\"load_ajax_del_alum('opc=alum_delete&alum_codi=". $row_alum_busq['alum_codi'] ."')\" >
									<span class='fa fa-trash' style='margin-right:3px;'></span>&nbsp;Eliminar</a>
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
									<span class='fa fa-ban' style='margin-right:3px;'></span>&nbsp;Bloquear</a>
							</div>";
						}
						if (permiso_activo(535)){
							if ($row_alum_busq["alum_curs_para_codi"]!="")
							{	$opciones[]="
								<div class='rTableCell'>
								<a 
									class='option'
									data-target='#ModalCambiarCurso'
									data-toggle='modal'
									onclick=\"alum_curs_para_info(". $row_alum_busq["alum_curs_para_codi"] .");document.getElementById('cb_alum_curs_para_codi').value=". $row_alum_busq["alum_curs_para_codi"].";\">
									<span class='fa fa-cog' style='margin-right:3px;'></span><span>&nbsp;Cambiar Curso</span></a>
								</div>";
							}
						}
						if (permiso_activo(222)){
							if ($row_alum_busq["alum_curs_para_codi"]!="")
							{	$opciones[]="
								<div class='rTableCell'>
								<a 
									class='option'
									data-target='#ModalCambioParalelo'
									data-toggle='modal'
									onclick=\"curs_para_cambiar_load('cambiar_paralelo_content','modal_cambio_paralelo_view.php','curs_para_codi=". $row_alum_busq["curs_para_codi"] ."&alum_codi=". $row_alum_busq["alum_codi"] ."',". $row_alum_busq["alum_curs_para_codi"] .", ". $row_alum_busq["alum_codi"] .")\";>
									<span class='fa fa-circle' style='margin-right:3px;'></span><span>&nbsp;Cambiar Paralelo</span></a>
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
									<span class='fa fa-ban' style='margin-right:3px;'></span>&nbsp;Blacklist</a>
							</div>";
						}
						$opciones[]="
						<div class='rTableCell'>
							<a class='option'
								onclick=\"window.location='representantes_add.php?alum_codi='+".$row_alum_busq["alum_codi"] .";\">
								<span class='fa fa-heart-o' style='margin-right:3px;'></span>&nbsp;Familiares</a>
						</div>";
						$tabla=alumnos_main_genera_tabla_por_columnas($opciones, 3, 0,'100%','left');// función está en funciones.php
						echo $tabla;
						
					?>
						</div>
					</div>
				</div>
			</td>
		</tr>
	<?php  
	
	}
	?>
	</tbody>
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