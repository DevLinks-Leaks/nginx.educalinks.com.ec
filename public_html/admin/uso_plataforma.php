<?php 

	session_start();	 
	include ('../framework/dbconf.php');
	include ('../framework/funciones.php');
	
	$peri_codi=$_SESSION['peri_codi'];	
	
	
	
	$params = array($peri_codi);
	$sql="{call uso_plataforma_repr(?)}";
	$uso_plataforma_repr = sqlsrv_query($conn, $sql, $params);  
	$row_uso_plataforma_repr= sqlsrv_fetch_array($uso_plataforma_repr);

	$params = array($peri_codi);
	$sql="{call uso_plataforma_alum(?)}";
	$uso_plataforma_alum = sqlsrv_query($conn, $sql, $params);  
	$row_uso_plataforma_alum= sqlsrv_fetch_array($uso_plataforma_alum);

	$params = array($peri_codi);
	$sql="{call uso_plataforma_prof(?)}";
	$uso_plataforma_prof = sqlsrv_query($conn, $sql, $params);  
	$row_uso_plataforma_prof= sqlsrv_fetch_array($uso_plataforma_prof);

	$params = array($peri_codi);
	$sql="{call uso_plataforma_prof(?)}";
	$uso_plataforma_prof = sqlsrv_query($conn, $sql, $params);  
	$row_uso_plataforma_prof= sqlsrv_fetch_array($uso_plataforma_prof);

  	$peri_dist_nive=1;
	$params = array($_SESSION['peri_codi'],$peri_dist_nive);
	$sql="{call peri_dist_view_by_nive(?,?)}"; 
	$peri_dist_view_by_nive = sqlsrv_query($conn, $sql, $params); 
?>
<b>Representantes</b>
<br/>
Total: <?= $row_uso_plataforma_repr['total']; ?>
<br/>
Total Uso: <?= $row_uso_plataforma_repr['total_uso']; ?>
<br/>
App Uso: <?= $row_uso_plataforma_repr['app_uso']; ?>
<br/>
<br/>
<b>Alumnos</b>
<br/>
Total: <?= $row_uso_plataforma_alum['total']; ?>
<br/>
Total Uso: <?= $row_uso_plataforma_alum['total_us']; ?>
<br/>
App Uso: <?= $row_uso_plataforma_alum['app_uso']; ?>
<br/>
<br/>
<b>DATOS PARA ALUMNOS DE EDUCACION GENERAL PARA ARRIBA</b>
<br/>
<b>Alumnos Aprobados</b>
<br/>
Total Aprobados: <?= $row_uso_plataforma_alum['total_aprobados']; ?>
<br/>
<br/>
<b>Alumnos Reprobados</b>
<br/>
<label for="fecha_fin">Periodo Distribucion:</label>
<select id="sl_peri_dist_codi"  onchange="buscar_total_reprobados(this.value);">
	<option value="0">Elija</option>
	<? while($row_peri_dist_view_by_nive = sqlsrv_fetch_array($peri_dist_view_by_nive))
	{ ?>
	<option value="<?= $row_peri_dist_view_by_nive['peri_dist_codi'];?>">
	<?= $row_peri_dist_view_by_nive['peri_dist_deta'];?>
	</option>
	<?php 	 
	} 
	?>
</select> 
<br/>
<label id="total_reprobado">Total reprobados en periodo distribucion: </label> 
<br/>
<br/>
<b>Docentes</b>
<br/>
Total: <?= $row_uso_plataforma_prof['total']; ?>
<br/>
Total Uso: <?= $row_uso_plataforma_prof['total_uso']; ?>
<br/>
<br/>
<b>Docentes Ingreso Notas</b>
<br/>
<label for="fecha_ini">Fecha Inicio</label>
<input type="date" id="fecha_ini" name="fecha_ini">

<label for="fecha_fin">Fecha Fin</label>
<input type="date" id="fecha_fin" name="fecha_fin">
<br/>
<button id="buscar_nota_ingr" onclick="buscar_nota_ingr();">Buscar</button>
<br/>
<label id="total_nota">Total que ingresan notas: </label> 
<br/>
<iframe src="https://docs.google.com/a/redlinks.com.ec/forms/d/e/1FAIpQLScW94CCIJHG6MUqR8jYsPTLLSqLsuUx8gfGGPhb5uaZvvw2vA/viewform?embedded=true" width="760" height="500" frameborder="0" marginheight="0" marginwidth="0">Cargando...</iframe>
<script>
	function buscar_nota_ingr(){
		var fecha_ini= document.getElementById('fecha_ini').value;
		var fecha_fin= document.getElementById('fecha_fin').value;
		document.getElementById('total_nota').innerHTML='';
		if (window.XMLHttpRequest)
		{// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		}
		else
		{// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		var data = new FormData();
		data.append('opc', 'ingr_nota');
		data.append('fecha_ini', fecha_ini);
		data.append('fecha_fin', fecha_fin);
		xmlhttp.onreadystatechange=function()
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				document.getElementById('total_nota').innerHTML='Total que ingresan notas: '+xmlhttp.responseText;
				
			}
		}
		xmlhttp.open("POST","uso_plataforma_script.php",true);
		//xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		xmlhttp.send(data);
		
	}
	function buscar_total_reprobados(value){
		document.getElementById('total_reprobado').innerHTML='';
		if (window.XMLHttpRequest)
		{// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		}
		else
		{// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		var data = new FormData();
		data.append('opc', 'total_reprobado');
		data.append('peri_dist_codi', value);
		xmlhttp.onreadystatechange=function()
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				document.getElementById('total_reprobado').innerHTML='Total reprobados en periodo distribucion: '+xmlhttp.responseText;
				
			}
		}
		xmlhttp.open("POST","uso_plataforma_script.php",true);
		//xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		xmlhttp.send(data);
		
	}
</script>