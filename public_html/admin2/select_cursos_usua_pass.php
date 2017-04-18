<?php 
		session_start();
		include ('../framework/dbconf.php');		
		$sql="{call curs_view()}";
		$stmt = sqlsrv_query($conn, $sql);

		if( $stmt === false )
		{
			echo "Error in executing statement .\n";
			die( print_r( sqlsrv_errors(), true));
		}
		
		echo '<select class="form-control input-sm" id="sl_curso" name="sl_curso" onchange="CargarParalelos(this.value);VaciarAsignaturas();" >';
		echo '<option value="0">Seleccione</option>';
		while($curso_view= sqlsrv_fetch_array($stmt))
		{
			echo '<option value="'.$curso_view["curs_codi"].'">'.$curso_view["curs_deta"].'</option>';
		}
		echo '</select>';
?> 


	<script type="text/javascript">	
	function CargarParalelos (curso)
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
				document.getElementById('lbl_paralelo').innerHTML=xmlhttp.responseText;
			}
		}

		xmlhttp.open("GET", "select_paralelos_usua_pass.php?curso="+curso, true);
		xmlhttp.send();
	}
	
	function getURLAlumnos()
	 {
		 if (Validar())
		 {
			 var direccion;
			 direccion="reportes_generales/usuarios_claves_alumnos.php?curs_para_codi=";
			 direccion=direccion+document.getElementById('sl_paralelos').value;
			 window.open(direccion);
		 }

	}
	
	function Validar()
	{
		indice = document.getElementById("sl_curso").selectedIndex;
		if( indice == null || indice == 0 ) 
		{
			alert ("Seleccione un curso");
			return false;
		}
		
		indice = document.getElementById("sl_paralelos").selectedIndex;
		if( indice == null || indice == 0 ) 
		{
			alert ("Seleccione un paralelo");
			return false;
		}
		
		return true;
	}
	</script>