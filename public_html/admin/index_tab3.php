 <script src="../framework/Chart.js-master/Chart.js"></script>
<?php 

	 	 
	include ('../framework/dbconf.php');


	$params = array($_SESSION['peri_codi']);
	$sql="{call curs_peri_cc_matriculados(?)}";
	$curs_peri_cc_matriculados333 = sqlsrv_query($conn, $sql, $params);  
	$cc = 0; 
  
	while ($row_curs_peri_cc_matriculados333 = sqlsrv_fetch_array($curs_peri_cc_matriculados333)) { 
		$cc +=1; 
		
		$label_tab3 = $label_tab3 . '"' . $row_curs_peri_cc_matriculados333["curs_deta"] . '-' .  $row_curs_peri_cc_matriculados333["para_deta"]  .  '",';
 
		//INgresos al sistema Representantes
		$data_tab3 = $data_tab3 . '"' . $row_curs_peri_cc_matriculados333["cc_matriculados"] . '",';
		$total_matri += $row_curs_peri_cc_matriculados333["cc_matriculados"];
		 
	}
	$label_tab3 = substr($label_tab3,0,-1);
	$data_tab3 = substr($data_tab3,0,-1);
	 
	echo $label_tab3;
	echo $data_tab3;
	 
?> 
 Agenda: <?= $_SESSION['peri_deta']; ?>
<div style="width: 70%;float:left;">
  <canvas id="canvas_tab3" height="450" width="800"></canvas>
</div>


<script>
	var randomScalingFactor = function(){ return Math.round(Math.random()*100)};

	var barChartData_tab3 = {
		labels : [<? print $label_tab3; ?>],
		datasets : [
			{
				label: [<? print $label_tab3; ?>],
				fillColor : "rgba(220,220,220,0.5)",
				strokeColor : "rgba(220,220,220,0.8)",
				highlightFill: "rgba(220,220,220,0.75)",
				highlightStroke: "rgba(220,220,220,1)",
				data : [<? print $data_tab3; ?>]
			} 
			
		]

	}
	window.onload = function(){
		var ctx2 = document.getElementById("canvas_tab3").getContext("2d");
		window.myBar2 = new Chart(ctx2).Bar(barChartData_tab3, {
			responsive : true,
			scaleShowValues: true
		});
		var ctx = document.getElementById("canvas_matri_incri").getContext("2d");
		window.myBar = new Chart(ctx).Bar(barChartData, {
			responsive : true,
			scaleShowValues: true
		});
		
	}
		 
	</script> 
