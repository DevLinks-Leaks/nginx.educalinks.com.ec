<?
	$alum_curs_para_aprob='AP';
	$param_prev_peri=array($alum_codi, $_SESSION['peri_codi'], 'R');
	$sql_prev_peri="{call alum_info_peri_anterior(?,?,?)}";
	$options_tareas =  array( "Scrollable" => "buffered" );
	$prev_peri_busq = sqlsrv_query($conn, $sql_prev_peri, $param_prev_peri, $options_tareas);
	$row_count_prev_peri_busq = sqlsrv_num_rows($prev_peri_busq);
	if( $prev_peri_busq === false )
	{
		echo "Error in executing statement .\n";
		die( print_r( sqlsrv_errors(), true));
	}
	
	if($row_count_prev_peri_busq>0)
	{
		while($row_prev_peri_busq= sqlsrv_fetch_array($prev_peri_busq, SQLSRV_FETCH_ASSOC))
		{
			$prev_curso_paralelo = $row_prev_peri_busq['curso_paralelo'];
			$prev_curs_para_codi = $row_prev_peri_busq['curs_para_codi'];
			$prev_estado = PrimeraMayuscula(strtolower($row_prev_peri_busq['estado']));
			$prev_peri_deta = $row_prev_peri_busq['peri_deta'];
			$prev_peri_codi = $row_prev_peri_busq['peri_codi'];
			if(para_sist(512)=='1')
				$alum_curs_para_aprob = $row_prev_peri_busq['alum_curs_para_aprob'];
			else
				$alum_curs_para_aprob = 'AP';
		}
?>
	<div class="row">
		<div class="col-md-6">
			<table width='100%' align='center'>
				<tr>
					<td colspan='2' height='40px' valign='bottom'><b>Datos del Período anterior</b></td>
				</tr>
				<tr>
					<td width='120px' height='1px' colspan='2'><div style='font-size:1px'><hr style='height:1px; margin-top: 0.5em;' /></div></td>
				</tr>
				<tr>	
					<td width='120px' align='left'><b>Período: </b>
					</td>
					<td align='left'> <?php echo $prev_peri_deta; ?>
						<input type='hidden' id='prev_peri_codi' name='prev_peri_codi' value='<?php echo $prev_peri_codi; ?>'>
					</td>
				</tr>
				<tr>	
					<td width='120px' align='left'><b>Estado final: </b>
					</td>
					<td align='left'> <?php echo $prev_estado; ?>
						<input type='hidden' id='prev_alum_est' name='prev_alum_est' value='<?php echo $prev_estado; ?>'>
					</td>
				</tr>
				<tr>	
					<td width='120px' align='left'><b>Paralelo: </b>
					</td>
					<td align='left'> <?php echo $prev_curso_paralelo; ?>
						<input type='hidden' id='prev_curs_para_codi' name='prev_curs_para_codi' value='<?php echo $prev_curs_para_codi; ?>'>
					</td>
				</tr>
			</table>
		</div>
		<? if ($alum_curs_para_aprob=='RP'){?>
			<div class="col-md-6"><br/><br/><br/></div>
			<div class="col-md-5">
				<div class="alert alert-danger">
	                <h4><i class="icon fa fa-ban"></i> Alerta de Bloqueo!</h4>
	                Alumno reprobó el año anterior
	          	</div>
			</div>
		<?}?>
	<?php 
	}
	else
	{?>
		<table width='100%' align='center'>
			<tr>
				<td height='40px' valign='bottom' colspan='2'><b>Datos del Período anterior</b></td>
			</tr>
			<tr>
				<td height='1px' colspan='2'>
					<div style='font-size:1px'><hr style='height:1px; margin-top: 0.5em;' />
					</div>
				</td>
			</tr>
			<tr>
				<td colspan='2' width='120px'><small><i>--Sin registros en el per&iacute;odo anterior--</i></small></td>
			</tr>
		</table>
	<?php 
	}
	?>
	<input type="hidden" id="alum_curs_para_aprob" name="alum_curs_para_aprob" value="<?=$alum_curs_para_aprob;?>" />