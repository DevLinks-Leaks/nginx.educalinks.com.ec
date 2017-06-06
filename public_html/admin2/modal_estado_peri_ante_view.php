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
			<div class='row'>
				<div class="col-sm-12">
					<b>Datos del Período anterior</b>
				</div>
			</div>
			<div class='row'>
				<div class="col-sm-12">
					<div style='font-size:1px'><hr style='height:1px; margin-top: 0.5em;' /></div>
				</div>
			</div>
			<div class='row'>
				<div class="col-sm-6">
					<b>Período: </b>
				</div>
				<div class="col-sm-6">
					<?php echo $prev_peri_deta; ?>
						<input type='hidden' id='prev_peri_codi' name='prev_peri_codi' value='<?php echo $prev_peri_codi; ?>'>
				</div>
			</div>
			<div class='row'>
				<div class="col-sm-6">
					<b>Estado final: </b>
				</div>
				<div class="col-sm-6">
					<?php echo $prev_estado; ?>
						<input type='hidden' id='prev_alum_est' name='prev_alum_est' value='<?php echo $prev_estado; ?>'>
				</div>
			</div>
			<div class='row'>
				<div class="col-sm-6">
					<b>Paralelo: </b>
				</div>
				<div class="col-sm-6">
					<?php echo $prev_curso_paralelo; ?>
						<input type='hidden' id='prev_curs_para_codi' name='prev_curs_para_codi' value='<?php echo $prev_curs_para_codi; ?>'>
				</div>
			</div>
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
		<div class='row' width='100%' align='center' height='40px' valign='bottom'>
			<div class="col-sm-6">
				<b>Datos del Período anterior</b>
			</div>
		</div>
		<div class='row' height='1px' >
			<div class="col-sm-6">
				<div style='font-size:1px'><hr style='height:1px; margin-top: 0.5em;' /></div>
			</div>
		</div>
		<div class='row' width='120px'>
			<div class="col-sm-6">
				<small><i>--Sin registros en el per&iacute;odo anterior--</i></small>
			</div>
		</div>
	<?php 
	}
	?>
		<input type="hidden" id="alum_curs_para_aprob" name="alum_curs_para_aprob" value="<?=$alum_curs_para_aprob;?>" />
		<div class="col-sm-12"><br/></div>
	</div>