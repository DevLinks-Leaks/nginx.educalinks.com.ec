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
		
		echo '<select class="form-control" id="sl_curso" name="sl_curso" onchange="CargarParalelos(this.value);VaciarAlumnos();" >';
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

		xmlhttp.open("GET", "select_paralelos.php?curso="+curso, true);
		xmlhttp.send();
	}
	
	function CargarAlumnos(curso_paralelo)
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
				document.getElementById('lbl_alumnos').innerHTML=xmlhttp.responseText;
			}
		}

		xmlhttp.open("GET", "select_alumnos.php?curso_paralelo="+curso_paralelo, true);
		xmlhttp.send();
	}
	
	function VaciarAlumnos()
	{
		document.getElementById("sl_alumnos").options.length = 0;
		opSeleccione=new Option("Seleccione","0");
		document.getElementById("sl_alumnos").options[0]=opSeleccione;
		document.getElementById("sl_alumnos").disabled=true;
	}
	
	 function getURLCertMatriculaPDF()
	 {
		 if (Validar())
		 {
			 var direccion;
			 direccion="reportes_generales/cert_matricula_pdf.php?curso_paralelo=";
			 direccion=direccion+document.getElementById('sl_paralelos').value+"&alumno="+document.getElementById('sl_alumnos').value;
			 //window.location.href=direccion;
			 window.open(direccion);
		 }

	}
	
	function getURLCertMatriculaHTML()
	 {
		 if (Validar())
		 {
			 var direccion;
			 direccion="reportes_generales/cert_matricula_html.php?curso_paralelo=";
			 direccion=direccion+document.getElementById('sl_paralelos').value+"&alumno="+document.getElementById('sl_alumnos').value;
			 //window.location.href=direccion;
			 window.open(direccion);
		 }

	}
	
	function getURLCertMatriculaExcel()
	 {
		 if (Validar())
		 {
			 var direccion;
			 direccion="reportes_generales/cert_matricula_excel.php?curso_paralelo=";
			 direccion=direccion+document.getElementById('sl_paralelos').value+"&alumno="+document.getElementById('sl_alumnos').value;
			 //window.location.href=direccion;
			 window.open(direccion);
		 }

	}
	
	function getURLCertComportamientoPDF()
	 {
		 if (Validar())
		 {
			 var direccion;
			 direccion="reportes_generales/cert_comportamiento_pdf.php?curso_paralelo=";
			 direccion=direccion+document.getElementById('sl_paralelos').value+"&alumno="+document.getElementById('sl_alumnos').value+"&peri_dist_codi="+document.getElementById('sl_periodo_dist').value;
			 //window.location.href=direccion;
			 window.open(direccion);
		 }

	}
	
	function getURLCertComportamientoHTML()
	 {
		 if (Validar())
		 {
			 var direccion;
			 direccion="reportes_generales/cert_comportamiento_html.php?curso_paralelo=";
			 direccion=direccion+document.getElementById('sl_paralelos').value+"&alumno="+document.getElementById('sl_alumnos').value+"&peri_dist_codi="+document.getElementById('sl_periodo_dist').value;
			 //window.location.href=direccion;
			 window.open(direccion);
		 }

	}
	
	function getURLCertComportamientoExcel()
	 {
		 if (Validar())
		 {
			 var direccion;
			 direccion="reportes_generales/cert_comportamiento_excel.php?curso_paralelo=";
			 direccion=direccion+document.getElementById('sl_paralelos').value+"&alumno="+document.getElementById('sl_alumnos').value+"&peri_dist_codi="+document.getElementById('sl_periodo_dist').value;
			 //window.location.href=direccion;
			 window.open(direccion);
		 }

	}
	
	function getURLCertAsistenciaPDF()
	 {
		 if (Validar())
		 {
			 var direccion;
			 direccion="reportes_generales/cert_asistencia_pdf.php?curso_paralelo=";
			 direccion=direccion+document.getElementById('sl_paralelos').value+"&alumno="+document.getElementById('sl_alumnos').value;
			 //window.location.href=direccion;
			 window.open(direccion);
		 }

	}
	
	function getURLCertAsistenciaHTML()
	 {
		 if (Validar())
		 {
			 var direccion;
			 direccion="reportes_generales/cert_asistencia_html.php?curso_paralelo=";
			 direccion=direccion+document.getElementById('sl_paralelos').value+"&alumno="+document.getElementById('sl_alumnos').value;
			 //window.location.href=direccion;
			 window.open(direccion);
		 }

	}
	
	function getURLCertAsistenciaExcel()
	 {
		 if (Validar())
		 {
			 var direccion;
			 direccion="reportes_generales/cert_asistencia_excel.php?curso_paralelo=";
			 direccion=direccion+document.getElementById('sl_paralelos').value+"&alumno="+document.getElementById('sl_alumnos').value;
			 //window.location.href=direccion;
			 window.open(direccion);
		 }

	}
	
	function getURLCertPromocionPDF()
	 {
		 if (Validar())
		 {
			 var direccion;
			 direccion="reportes_generales/cert_promocion_pdf.php?curso_paralelo=";
			 direccion=direccion+document.getElementById('sl_paralelos').value+"&alumno="+document.getElementById('sl_alumnos').value+"&peri_dist_codi="+document.getElementById('sl_periodo_dist').value;
			 //window.location.href=direccion;
			 window.open(direccion);
		 }

	}
	
	function getURLFichaEstudiantilPDF()
	 {
		 if (Validar())
		 {
			 var direccion;
			 direccion="reportes_generales/ficha_estudiantil_pdf.php?curso_paralelo=";
			 direccion=direccion+document.getElementById('sl_paralelos').value+"&alumno="+document.getElementById('sl_alumnos').value;
			 //window.location.href=direccion;
			 window.open(direccion);
		 }

	}
	
	function getURLFichaEstudiantilHTML()
	 {
		 if (Validar())
		 {
			 var direccion;
			 direccion="reportes_generales/ficha_estudiantil_html.php?curso_paralelo=";
			 direccion=direccion+document.getElementById('sl_paralelos').value+"&alumno="+document.getElementById('sl_alumnos').value;
			 //window.location.href=direccion;
			 window.open(direccion);
		 }

	}
	
	function getURLFichaEstudiantilExcel()
	 {
		 if (Validar())
		 {
			 var direccion;
			 direccion="reportes_generales/ficha_estudiantil_excel.php?curso_paralelo=";
			 direccion=direccion+document.getElementById('sl_paralelos').value+"&alumno="+document.getElementById('sl_alumnos').value;
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
		
		indice = document.getElementById("sl_alumnos").selectedIndex;
		if( indice == null || indice == 0 ) 
		{
			alert ("Seleccione un alumno");
			return false;
		}
		
		return true;
	}
	</script>