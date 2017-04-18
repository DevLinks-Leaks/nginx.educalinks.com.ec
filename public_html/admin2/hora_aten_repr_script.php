<?php 
	session_start();	 
	include ('../framework/dbconf.php');?>  
<div class="main_lista">
	<div id="div_curso">
        <label>Fecha a consultar:</label>
    	<input id="hora_aten_repr_fecha" name="hora_aten_repr_fecha" type="text"  value="<? echo date("d/m/Y"); ?>">
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