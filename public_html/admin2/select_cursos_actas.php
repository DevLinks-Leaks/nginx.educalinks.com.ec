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
		
		echo '<select  class="form-control" id="sl_curso" name="sl_curso" onchange="CargarParalelos(this.value);VaciarAsignaturas();" >';
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

		xmlhttp.open("GET", "select_paralelos_actas.php?curso="+curso, true);
		xmlhttp.send();
	}
	
	function CargarAsignaturas(curso_paralelo)
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
				document.getElementById('lbl_asignatura').innerHTML=xmlhttp.responseText;
			}
		}

		xmlhttp.open("GET", "select_asignaturas_actas.php?curso_paralelo="+curso_paralelo, true);
		xmlhttp.send();
	}
	
	function VaciarAsignaturas()
	{
		document.getElementById("sl_asignatura").options.length = 0;
		opSeleccione=new Option("Seleccione","0");
		document.getElementById("sl_asignatura").options[0]=opSeleccione;
		document.getElementById("sl_asignatura").disabled=true;
	}	
	
	function getURLActaMateriaQuimestreHTML()
	 {
		 if (Validar())
		 {
			 var direccion;
			 direccion="actas/acta_nota_quim_mate_html.php?curs_para_codi=";
			 direccion=direccion+document.getElementById('sl_paralelos').value+"&curs_para_mate_codi="+document.getElementById('sl_asignatura').value+"&peri_dist_codi="+document.getElementById('sl_periodo_dist').value;
			 //window.location.href=direccion;
			 window.open(direccion);
		 }

	}
	
	function getURLActaMateriaQuimestreExcel()
	 {
		 if (Validar())
		 {
			 var direccion;
			 direccion="actas/acta_nota_quim_mate_excel.php?curs_para_codi=";
			 direccion=direccion+document.getElementById('sl_paralelos').value+"&curs_para_mate_codi="+document.getElementById('sl_asignatura').value+"&peri_dist_codi="+document.getElementById('sl_periodo_dist').value;
			 //window.location.href=direccion;
			 window.open(direccion);
		 }

	}
	
	function getURLActaMateriaParcialHTML()
	 {
		 if (Validar())
		 {
			 var direccion;
			 direccion="actas/acta_nota_parc_mate_html.php?curs_para_codi=";
			 direccion=direccion+document.getElementById('sl_paralelos').value+"&curs_para_mate_codi="+document.getElementById('sl_asignatura').value+"&peri_dist_codi="+document.getElementById('sl_periodo_dist').value;
			 //window.location.href=direccion;
			 window.open(direccion);
		 }

	}
	
	function getURLActaMateriaParcialExcel()
	 {
		 if (Validar())
		 {
			 var direccion;
			 direccion="actas/acta_nota_parc_mate_excel.php?curs_para_codi=";
			 direccion=direccion+document.getElementById('sl_paralelos').value+"&curs_para_mate_codi="+document.getElementById('sl_asignatura').value+"&peri_dist_codi="+document.getElementById('sl_periodo_dist').value;
			 //window.location.href=direccion;
			 window.open(direccion);
		 }

	}
	
	function getURLCuadroCalificacionesHTML()
	 {
		 if (Validar())
		 {
			 var direccion;
			 direccion="actas/cuadro_cali_html.php?curs_para_codi=";
			 direccion=direccion+document.getElementById('sl_paralelos').value+"&peri_dist_codi="+document.getElementById('sl_periodo_dist').value;
			 //window.location.href=direccion;
			 window.open(direccion);
		 }

	}
	
	function getURLCuadroCalificacionesExcel()
	 {
		 if (Validar())
		 {
			 var direccion;
			 direccion="actas/cuadro_cali_excel.php?curs_para_codi=";
			 direccion=direccion+document.getElementById('sl_paralelos').value+"&peri_dist_codi="+document.getElementById('sl_periodo_dist').value;
			 //window.location.href=direccion;
			 window.open(direccion);
		 }

	}
	
	function getURLCuadroCalificacionesFinalesHTML()
	 {
		 if (Validar())
		 {
			 var direccion;
			 direccion="actas/cuadro_cali_final_html.php?curs_para_codi=";
			 direccion=direccion+document.getElementById('sl_paralelos').value+"&peri_dist_codi="+document.getElementById('sl_periodo_dist').value;
			 //window.location.href=direccion;
			 window.open(direccion);
		 }

	}
	
	function getURLCuadroCalificacionesFinalesExcel()
	 {
		 if (Validar())
		 {
			 var direccion;
			 direccion="actas/cuadro_cali_final_excel.php?curs_para_codi=";
			 direccion=direccion+document.getElementById('sl_paralelos').value+"&peri_dist_codi="+document.getElementById('sl_periodo_dist').value;
			 //window.location.href=direccion;
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
		
		indice = document.getElementById("sl_asignatura").selectedIndex;
		if( indice == null || indice == 0 ) 
		{
			alert ("Seleccione una asignatura");
			return false;
		}
		
		return true;
	}
	</script>