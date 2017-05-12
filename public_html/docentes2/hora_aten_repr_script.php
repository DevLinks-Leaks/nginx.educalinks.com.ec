<?php 
	session_start();	 
	include ('../framework/dbconf.php');?>  
<div class="main_lista">
	<div id="div_curso">
		<div class="form-horizontal">
		<div class="form-group">
			<div class="col-sm-2">
				<label>Fecha a consultar:</label>
			</div>
			<div class="col-sm-3">
				<input class='form-control input-sm' id="hora_aten_repr_fecha" name="hora_aten_repr_fecha" type="text"  value="<? echo date("d/m/Y"); ?>">
			</div>
		</div>
	</div>
    <script type="text/javascript">
	function MostrarCitas (fecha)
	{
		var xmlhttp;

		if (window.XMLHttpRequest)
		{
			xmlhttp = new XMLHttpRequest ();
		}
		else
		{
			xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');
		}

		xmlhttp.onreadystatechange = function ()
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				document.getElementById('div_citas').innerHTML=xmlhttp.responseText;
			}
		}

		xmlhttp.open("GET", "hora_aten_repr_listas_main_view.php?fecha="+fecha, true);
		xmlhttp.send();
	}
	</script>
    
    <div id="div_citas">
    	<? include ('hora_aten_repr_listas_main_view.php'); ?>
    </div>
</div>