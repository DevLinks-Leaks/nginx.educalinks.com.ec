function CargarPeriodosDistribucion (peri_dist_cab_codi)
{
  	var xmlhttp;

    /*Agrego la data*/
    var data = new FormData();
    data.append("peri_dist_cab_codi", peri_dist_cab_codi);
    data.append("select", "PeriodosDistribucion")

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
  			document.getElementById('div_sl_periodo_dist').innerHTML=xmlhttp.responseText;
  		}
  	}

  	xmlhttp.open("POST", "select_reportes_generales.php", true);
  	xmlhttp.send(data);
}

function CargarCursosParalelos (peri_dist_cab_codi)
{
  	var xmlhttp;

    /*Agrego la data*/
    var data = new FormData();
    data.append("peri_dist_cab_codi", peri_dist_cab_codi);
    data.append("select", "CursosParalelos")

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
  			document.getElementById('div_sl_paralelos').innerHTML=xmlhttp.responseText;
  		}
  	}

  	xmlhttp.open("POST", "select_reportes_generales.php", true);
  	xmlhttp.send(data);
}
function CargarCursosParalelosExc (peri_dist_cab_codi)
{	var xmlhttp;
    /*Agrego la data*/
    var data = new FormData();
    data.append("peri_dist_cab_codi", peri_dist_cab_codi);
    data.append("select", "CursosParalelosExc")
  	if (window.XMLHttpRequest)
  	{	xmlhttp = new XMLHttpRequest ();
  	}
  	else
  	{	xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');
  	}
  	xmlhttp.onreadystatechange = function ()
  	{	if (xmlhttp.readyState==4 && xmlhttp.status==200)
  		{	document.getElementById('div_sl_paralelos').innerHTML=xmlhttp.responseText;
  		}
  	}
  	xmlhttp.open("POST", "select_reportes_generales.php", true);
  	xmlhttp.send(data);
}
function CargarCursosParalelosAlumnos (curs_para_codi)
{
  	var xmlhttp;

    /*Agrego la data*/
    var data = new FormData();
    data.append("curs_para_codi", curs_para_codi);
    data.append("select", "CursosParalelosAlumnos")

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
  			document.getElementById('div_sl_alumno').innerHTML=xmlhttp.responseText;
  		}
  	}

  	xmlhttp.open("POST", "select_reportes_generales.php", true);
  	xmlhttp.send(data);
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
	 function getURLCertPromocionPDF(dir_colegio,peri_codi)
   {
     if (Validar())
     {
       var direccion;
       direccion="promociones/"+dir_colegio+"/"+peri_codi+"/cert_promocion_pdf.php?curso_paralelo=";
       //direccion="reportes_generales/cert_promocion_pdf27072016.php?curso_paralelo=";
			 direccion=direccion+document.getElementById('sl_paralelos').value+"&alumno="+document.getElementById('sl_alumnos').value+"&peri_dist_codi="+document.getElementById('sl_periodo_dist').value;
			 //window.location.href=direccion;
			 window.open(direccion);
		 }

	}
	
    function getURLFichaEstudiantilPDF()
    {   if (Validar())
        {   var direccion;
            direccion="reportes_generales/ficha_estudiantil_pdf.php?curso_paralelo=";
            direccion=direccion+document.getElementById('sl_paralelos').value+"&alumno="+document.getElementById('sl_alumnos').value;
            //window.location.href=direccion;
            window.open(direccion);
        }
    }
    function getURLNotasPendientesIngresoPDF()
    {   var direccion;
		direccion="reportes_generales/notas_pendientes_pdf.php?peri_dist_codi=";
		direccion=direccion+document.getElementById('sl_periodo_dist').value;
		//window.location.href=direccion;
		window.open(direccion);
    }
	function getURLExcelenciaAcadExcel()
	 {	if (Validar())
		{	var direccion;
			direccion="alum_excelencia.php?curs_para_codi=";
			direccion=direccion+document.getElementById('sl_paralelos').value;
			direccion=direccion+'&peri_dist_cab_codi='+document.getElementById('sl_peri_dist_cab').value;
			window.open(direccion);
		}
	}
  function getURLInformeCualitativoFinal()
   {  if (Validar())
    { var direccion;
      direccion="reportes_generales/inf_cualitativo_pdf.php?curso_paralelo=";
      direccion=direccion+document.getElementById('sl_paralelos').value+"&alumno="+document.getElementById('sl_alumnos').value+"&peri_dist_codi="+document.getElementById('sl_periodo_dist').value;
      window.open(direccion);
    }
  }
  function getURLFichaMatricula(dom)
   {
     if (Validar())
     {
       var direccion;
       if(dom=='liceopanamericano' || dom=='liceopanamericanosur')
        direccion="reportes_generales/ficha_matricula_"+dom+"_pdf.php?curso_paralelo=";
       else
        direccion="reportes_generales/ficha_matricula_pdf.php?curso_paralelo=";
       direccion=direccion+document.getElementById('sl_paralelos').value+"&alum_curs_para_codi="+document.getElementById('sl_alumnos').value;
       //window.location.href=direccion;
       window.open(direccion);
     }

  }
	function Validar()
	{
		
		indice = document.getElementById("sl_paralelos").selectedIndex;
		if( indice == null || indice == 0 ) 
		{
			alert ("Seleccione un paralelo");
			return false;
		}
		
		return true;
	}