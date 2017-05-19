<?php
include ('../framework/dbconf.php');

if (isset($_POST["curs_para_codi"])){$curs_para_codi = $_POST["curs_para_codi"];}else{	$curs_para_codi = "";}
if (isset($_POST["alum_codi"])){$alum_codi = $_POST["alum_codi"];}else{	$alum_codi = "";}

	$params = array($alum_codi);
	$sql="{call alum_info(?)}";
	$alum_info = sqlsrv_query($conn, $sql, $params);  
	$row_alum_info= sqlsrv_fetch_array($alum_info);
	
?>
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
	<h4 class="modal-title" id="myModalLabel">Cambio de paralelo: <?= $row_alum_info['alum_apel'].' '.$row_alum_info['alum_nomb']?></h4>
</div>
<div id="modal_main" class="modal-body">
	<div id="div_cupo_edi"> 
		<div class="form_element">
			<table border="0" cellpadding="0" cellspacing="0" width="100%;" class="table">
				<tr>
					<td width="25%" style="padding-top: 15px;">
						<label for="curs_para">Paralelo: </label>
					</td>
					<td style="padding-top: 15px;">
						<input type="hidden" id="alum_curs_para_codi" value="" />
						<input type="hidden" id="alum_codi" value="" />
						<select id="sl_curs_para_codi_1" 
						style="width: 50%;" 
						onchange="load_ajax('div_matching','cambio_paralelo_matching.php','curs_para_codi_orig=<?= $curs_para_codi;?>&alum_curs_para_codi='+document.getElementById('alum_curs_para_codi').value+'&curs_para_codi_dest='+document.getElementById('sl_curs_para_codi_1').value+'&alum_codi='+document.getElementById('alum_codi').value);">
						<option value="-1">Elija</option>
						<?
						$params=array($curs_para_codi);
						$sql="{call curs_para_paralelos (?)}";
						$stmt=sqlsrv_query($conn, $sql, $params);
						while ($row = sqlsrv_fetch_array($stmt))
						{
							?>
							<option value="<?= $row["curs_para_codi"]?>">
								<?= $row["curs_deta"]." - Paralelo: ".$row["para_deta"];?>
							</option>
							<?
						}
						?>
					</select>
				</td>
			</tr>
			<tr>
				<td colspan="2" style="padding-top: 15px;">
					<div id="div_cupo_disp"></div>
				</td>
			</tr>
			<tr>
				<td colspan="2" style="padding-top: 15px;">
					<div id="div_matching"></div>
				</td>
			</tr> 
		</table>  
	</div>
	<div class="form_element">&nbsp;</div>                
</div>
</div>
<div class="modal-footer">
	<button 
	type="button" 
	class="btn btn-success" 
	onClick="CambiarParalelo()" >
	Aceptar
</button>
<button 
type="button" 
class="btn btn-default" 
data-dismiss="modal" >
Cerrar
</button>
</div>