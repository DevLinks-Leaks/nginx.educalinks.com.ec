 <script src="../framework/Chart.js-master/Chart.js"></script>
<?php 
	include ('../framework/dbconf.php');
	$params = array($_SESSION['peri_codi']);
	$sql="{call curs_peri_cc_matriculados(?)}";
	$curs_peri_cc_matriculadosc = sqlsrv_query($conn, $sql, $params);  
	$cc = 0; 
  
	while ($row_curs_peri_cc_matriculadosc = sqlsrv_fetch_array($curs_peri_cc_matriculadosc))
	{   $cc +=1; 
		
		$label = $label . '"' . substr($row_curs_peri_cc_matriculadosc["curs_deta"],0,15) . '-' .  $row_curs_peri_cc_matriculadosc["para_deta"]  .  '",';
 
		//INgresos al sistema Representantes
		$data_1 = $data_1 . '"' . $row_curs_peri_cc_matriculadosc["cc_matriculados"] . '",';
		$total_matri += $row_curs_peri_cc_matriculadosc["cc_matriculados"];
	}
	$label = substr($label,0,-1);
	$data_1 = substr($data_1,0,-1);
?>
<div class="row">
	<div class="col-md-4">
		<div class="box">
			<div class="box-header">
				<h3 class="box-title">Periodo Activo: <?= $_SESSION['peri_deta']; ?></h3>
			</div>
			<!-- /.box-header -->
			<div class="box-body no-padding">
				<table class="table table-striped">
					<tr>
						<th>Día</th>    
						<th>Matriculados</th>
					</tr>
					<?php 
					  $params = array($_SESSION['peri_codi']);
						$sql="{call curs_peri_cc_matriculados_fecha(?)}";
						$curs_peri_cc_matriculados_fecha = sqlsrv_query($conn, $sql, $params);  
						 
					?>
					<?php while ($row_curs_peri_cc_matriculados_fecha = sqlsrv_fetch_array($curs_peri_cc_matriculados_fecha)) {  ?>
					 
					<tr>
						<td align="left" valign="middle">
							<?= 
							(date_format($row_curs_peri_cc_matriculados_fecha["dia"], 'd M Y')==""?
							$row_curs_peri_cc_matriculados_fecha["dia"]:
							date_format($row_curs_peri_cc_matriculados_fecha["dia"], 'd M Y'));  ?>
						</td>
						<td align="center" valign="middle"><?= $row_curs_peri_cc_matriculados_fecha['cc'];  ?></td>
					</tr>
					<?php } ?>
				</table>
			</div>
			<!-- /.box-body -->
		</div>
	</div>
	<div class="col-md-8">
		<div class="box">
			<div class="box-header">
				<h3 class="box-title"></h3>
			</div>
			<!-- /.box-header -->
			<div class="box-body no-padding">
				<canvas id="canvas_matri_incri" height="450" width="800"></canvas>
			</div>
			<!-- /.box-body -->
		</div>
	</div>
</div>
<script>
	var randomScalingFactor = function(){ return Math.round(Math.random()*100)};

	var barChartData = {
		labels : [<? print $label; ?>],
		datasets : [
			{
				label: [<? print $label; ?>],
				fillColor : "rgba(220,220,220,0.5)",
				strokeColor : "rgba(220,220,220,0.8)",
				highlightFill: "rgba(220,220,220,0.75)",
				highlightStroke: "rgba(220,220,220,1)",
				data : [<? print $data_1; ?>]
			} 
			
		]

	}
	window.onload = function(){
		var ctx = document.getElementById("canvas_matri_incri").getContext("2d");
		window.myBar = new Chart(ctx).Bar(barChartData, {
			responsive : true,
			scaleShowValues: true
		});
	}

</script> 
