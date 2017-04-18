<div class="cursos_paralelo_main_combo">
<?php 

	session_start();	 
	include ('../framework/dbconf.php');
	
	$peri_codi = 0;
	$alum_est_peri_codi = "";
	$prev_alum_est="";
	$prev_curs_para_codi=0;
	
	if(isset($_POST['peri_codi']))
		$peri_codi=$_POST['peri_codi'];
	else
		$peri_codi=$_SESSION['peri_codi'];
	
	if(isset($_POST['alum_est_peri_codi']))
		$alum_est_peri_codi=$_POST['alum_est_peri_codi'];
	else
		$alum_est_peri_codi="";
	
	if(isset($_POST['prev_alum_est']))
		$prev_alum_est=$_POST['prev_alum_est'];
	else
		$prev_alum_est="";
	
	if(isset($_POST['prev_curs_para_codi']))
		$prev_curs_para_codi=$_POST['prev_curs_para_codi'];
	else
		$prev_curs_para_codi=0;
	
	if(strtoupper($alum_est_peri_codi)=="MATRICULADO POR PAGAR")
	{
		if (($prev_alum_est=="") && ($prev_curs_para_codi==0))
		{
			$params = array($peri_codi);
			$sql="{call curs_peri_view(?)}";
			$curs_peri_view = sqlsrv_query($conn, $sql, $params); 
			?>
			<br>
			<br>
			<table>
				<tr>
					<td width='120px'>Curso:</td>
					<td><select id="curs_para_codi" 
							name="curs_para_codi" 
							class="select"
							onchange="load_ajax('div_cupo_disp','cursos_paralelo_main_cupo.php','curs_para_codi='+ this.value);activar_boton(this.value);"
							onkeyup="load_ajax('div_cupo_disp','cursos_paralelo_main_cupo.php','curs_para_codi='+ this.value);activar_boton(this.value);">
							<option value="0">Seleccione...</option>
							 <?php  while ($row_curs_peri_view = sqlsrv_fetch_array($curs_peri_view))
									{  ?>
										<option value="<?= $row_curs_peri_view["curs_para_codi"]; ?>">
											<?= $row_curs_peri_view["curs_deta"]." \"".$row_curs_peri_view["para_deta"]."\""; ?>
										</option>
							 <?php  }?>
						</select>
					</td>
				</tr>
			<?php
		}
		else
		{
			$params2 = array((int)$peri_codi, $prev_alum_est, (int)$prev_curs_para_codi);
			$sql2="{call curs_peri_view_por_estudiante(?,?,?)}";
			$options =  array( "Scrollable" => "buffered" );
			$stmt_opc = sqlsrv_query($conn, $sql2, $params2, $options);
			$row_count_tareas = sqlsrv_num_rows($stmt_opc);
			if( $stmt_opc === false )
			{
				echo "Error in executing statement .\n";
				die( print_r( sqlsrv_errors(), true));
			}
			?>
			<br>
			<br>
			<table>
				<tr>
					<td width='120px'>Curso:</td>
					<td><select id="curs_para_codi" 
							name="curs_para_codi" 
							class="select"
							onchange="load_ajax('div_cupo_disp','cursos_paralelo_main_cupo.php','curs_para_codi='+ this.value);activar_boton(this.value);"
							onkeyup="load_ajax('div_cupo_disp','cursos_paralelo_main_cupo.php','curs_para_codi='+ this.value);activar_boton(this.value);">
							<option value='0'>Seleccione...</option>
							 <?php  
							if($row_count_tareas>0)
							{	while( $row_cursos = sqlsrv_fetch_array( $stmt_opc, SQLSRV_FETCH_ASSOC) ) 
								{	
									echo "<option value='".$row_cursos["curs_para_codi"]."'>";
									echo $row_cursos["curs_deta"]." \"".$row_cursos["para_deta"]."\"";
									echo "</option>";
								}
							}
							?>
						</select>
					</td>
				</tr>
			<?php
		}
		?>
			<tr>
				<td width='120px' height='60px'>Cupos disponibles:</td>
				<td><div id="div_cupo_disp">--</div></td>
			</tr>
		</table>		
		<?php 
	}else
	{
		echo"
		<br>
		<br>
		<table>
			<tr>
				<td width='120px'></td>
				<td><span id='span_cupo'>--</span></td>
			</tr>
		</table>";
	}?>
</div>