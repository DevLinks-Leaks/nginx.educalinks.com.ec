
<?php 

	session_start();	 
	include ('../framework/dbconf.php');
	if(isset($_POST['tipo']))
		$tipo=$_POST['tipo']; 
	else 
		$tipo='A';
		
	if (isset($_POST['curs_para_mate_codi']))
	{
		$curs_para_mate_codi=$_POST['curs_para_mate_codi'];
	}
	else
	{
		if(isset($_GET['curs_para_mate_codi']))  
		{
			$curs_para_mate_codi=$_GET['curs_para_mate_codi'];
		}
		else
		{
			$curs_para_mate_codi=0;
		}
	}
	
	if (isset($_POST['curs_para_mate_prof_codi']))
	{
		$curs_para_mate_prof_codi=$_POST['curs_para_mate_prof_codi'];
	}
	else
	{
		if(isset($_GET['curs_para_mate_prof_codi']))  
		{
			$curs_para_mate_prof_codi=$_GET['curs_para_mate_prof_codi'];
		}
		else
		{
			$curs_para_mate_prof_codi=0;
		}
	}		 
	
	 
	$params = array($curs_para_mate_codi);
	$sql="{call curs_peri_mate_info(?)}";
	$curs_peri_mate_info = sqlsrv_query($conn, $sql, $params);  
	$row_curs_peri_mate_info = sqlsrv_fetch_array($curs_peri_mate_info);
	 
?>
<div class="docentes_agendas">
	<table class="table_striped">
		<tr>
			<td>		
				<div class="" > 
					<h3><strong>Materia</strong>:
		<?= $row_curs_peri_mate_info["mate_deta"]; ?></h3> <h5>Curso: <?= $row_curs_peri_mate_info["curs_deta"]; ?> ( Paralelo: <?= $row_curs_peri_mate_info["para_deta"]; ?>)</h5>	
				</div>
				<div>  
				<select class="form-control input-sm" name="tipo" id="tipo" onchange="agen_view('para_main','script_agen.php','<?= $curs_para_mate_prof_codi;?>','<?= $curs_para_mate_codi;?>',this.value);">
						<option value="A" <? if ($tipo=='A') echo 'selected';?>>Activos</option>
						<option value="P" <? if ($tipo=='P') echo 'selected';?>>Pendientes</option>
						<option value="I" <? if ($tipo=='I') echo 'selected';?>>Inactivos</option>
						<option value="T" <? if ($tipo=='T') echo 'selected';?>>Todos</option>
					</select>
				</div>
			</td>
		</tr>
	</table>
<br>
<div id="agen_view">
	   <?php include ('agenda_main_view_lista.php'); ?>
</div>
</div>