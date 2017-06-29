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

  	xmlhttp.open("POST", "select_actas.php", true);
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

  	xmlhttp.open("POST", "select_actas.php", true);
  	xmlhttp.send(data);
}

function CargarCursosParalelosMaterias (curs_para_codi)
{
  	var xmlhttp;

    /*Agrego la data*/
    var data = new FormData();
    data.append("curs_para_codi", curs_para_codi);
    data.append("select", "CursosParalelosMaterias")

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
  			document.getElementById('div_sl_asignatura').innerHTML=xmlhttp.responseText;
  		}
  	}

  	xmlhttp.open("POST", "select_actas.php", true);
  	xmlhttp.send(data);
}

function getURLActaMateriaParcialExcel()
{
   if (Validar())
   {
     var direccion;
     direccion="actas/acta_nota_parc_mate_excel_new.php?curs_para_codi=";
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
function getURLActaMateriaQuimestreExcel()
{
   if (Validar())
   {
     var direccion;
     direccion="actas/acta_nota_parc_mate_excel_new.php?curs_para_codi=";
     direccion=direccion+document.getElementById('sl_paralelos').value+"&curs_para_mate_codi="+document.getElementById('sl_asignatura').value+"&peri_dist_codi="+document.getElementById('sl_periodo_dist').value;
     //window.location.href=direccion;
     window.open(direccion);
   }
}
function getURLActaMateriaQuimestreHTML()
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

//////////////////////////////////////////////////////////////////
function getURLCuadroCalificacionesExcel()
{
   if (Validar())
   {
     var direccion;
     direccion="actas/cuadro_cali_excel_new.php?curs_para_codi=";
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
     direccion=direccion+document.getElementById('sl_paralelos').value+"&curs_para_mate_codi="+document.getElementById('sl_asignatura').value+"&peri_dist_codi="+document.getElementById('sl_periodo_dist').value;
     //window.location.href=direccion;
     window.open(direccion);
   }
}
// Cuadro de calificaciones parciales finales
function getURLCuadroCalificacionesParcialesFinalesExcel()
{
   if (Validar())
   {
     var direccion;
     direccion="actas/cuadro_cali_parc_final_excel.php?curs_para_codi=";
     direccion=direccion+document.getElementById('sl_paralelos').value+"&curs_para_mate_codi="+document.getElementById('sl_asignatura').value+"&peri_dist_codi="+document.getElementById('sl_periodo_dist').value;
     //window.location.href=direccion;
     window.open(direccion);
   }
}
// Cuadro de calificaciones Quimestrales y periodo final - Finales
function getURLCuadroCalificacionesFinalesExcel()
{
   if (Validar())
   {
     var direccion;
     direccion="actas/cuadro_cali_final_excel_new.php?curs_para_codi=";
     direccion=direccion+document.getElementById('sl_paralelos').value+"&curs_para_mate_codi="+document.getElementById('sl_asignatura').value+"&peri_dist_codi="+document.getElementById('sl_periodo_dist').value;
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
     direccion=direccion+document.getElementById('sl_paralelos').value+"&curs_para_mate_codi="+document.getElementById('sl_asignatura').value+"&peri_dist_codi="+document.getElementById('sl_periodo_dist').value;
     //window.location.href=direccion;
     window.open(direccion);
   }
}
////////////////////////////////////////////////////////////////
function ValidarOpciones(parcialquim)
{
	if (parcialquim.substring(0, 7)=='PERIODO' || parcialquim.substring(0, 8)=='PROMEDIO')
	{
		divOpciones('acta_001', true,  false, "&nbsp;");
		divOpciones('acta_002', false, false, "&nbsp;");
		divOpciones('acta_003', true,  false, "&nbsp;");
		divOpciones('acta_004', true,  false, "&nbsp;");
	}
	else if (parcialquim.substring(0, 9)=='QUIMESTRE')
	{
		divOpciones('acta_001', true,  false, " quimestrales");
		divOpciones('acta_002', false, false, " quimestrales");
		divOpciones('acta_003', true,  false, " quimestrales");
		divOpciones('acta_004', true,  false, " quimestrales");
	}
	else if (parcialquim.substring(0, 6)=='EXAMEN')
	{
		divOpciones('acta_001', false, false, " examenes");
		divOpciones('acta_002', true,  false, " examenes");
		divOpciones('acta_003', true,  false, " examenes");
		divOpciones('acta_004', true,  false, " examenes");
	}
	else if (parcialquim.substring(0, 7)=='PARCIAL')
	{
		divOpciones('acta_001', false, false, " parciales");
		divOpciones('acta_002', true,  false, " parciales");
		divOpciones('acta_003', true,  false, " parciales");
		divOpciones('acta_004', true,  false, " parciales");
	}
}
function divOpciones(div, validar, html, acta)
{
	var div_1= "";
	var HTML_OPC="";
	var img_over="onmouseover=\"this.src='../imagenes/report_to_excel-over.png'\" " +
					" onmouseout=\"this.src='../imagenes/report_to_excel.png'\" ";
	if(div=='acta_001')
	{
		div_1= div+"_qm";
		var TITULO="Acta de calificaciones por quimestre y materia";
		var EXCEL="JavaScript:getURLActaMateriaQuimestreExcel();";
		var EXCEL_OPC="<a href='"+EXCEL+"' ><img src='../imagenes/report_to_excel.png' style='width:45px;' "+img_over+" border='0'></a>";
		var HTML="JavaScript:getURLActaMateriaQuimestreHTML();";
	}
	else if(div=='acta_002')
	{
		div_1= div+"_pm";
		var TITULO="Acta de calificaciones por parcial y materia";
		var EXCEL="JavaScript:getURLActaMateriaParcialExcel();";
		var EXCEL_OPC="<a href='"+EXCEL+"' ><img src='../imagenes/report_to_excel.png' style='width:45px;' "+img_over+"  border='0'></a>";
		var HTML="JavaScript:getURLActaMateriaParcialHTML();";
	}
	else if(div=='acta_003')
	{
		div_1= div+"_cq";
		var TITULO="Cuadro de calificaciones" + acta;
		var EXCEL="JavaScript:getURLCuadroCalificacionesExcel();";
		var EXCEL_OPC="<a href='"+EXCEL+"' ><img src='../imagenes/report_to_excel.png' style='width:45px;' "+img_over+"  border='0'></a>";
		var HTML="JavaScript:getURLCuadroCalificacionesHTML();";
	}
	else if(div=='acta_004')
	{
    if(acta==' parciales'){
      div_1= div+"_cf";
      var TITULO="Cuadro de calificaciones" + acta + " finales";
      var EXCEL="JavaScript:getURLCuadroCalificacionesParcialesFinalesExcel();";
      var EXCEL_OPC="<a href='"+EXCEL+"' ><img src='../imagenes/report_to_excel.png' style='width:45px;' "+img_over+"  border='0'></a>";
      var HTML="JavaScript:getURLCuadroCalificacionesFinalesHTML();";
    }else{
      div_1= div+"_cf";
      var TITULO="Cuadro de calificaciones" + acta + " finales";
      var EXCEL="JavaScript:getURLCuadroCalificacionesFinalesExcel();";
      var EXCEL_OPC="<a href='"+EXCEL+"' ><img src='../imagenes/report_to_excel.png' style='width:45px;' "+img_over+"  border='0'></a>";
      var HTML="JavaScript:getURLCuadroCalificacionesFinalesHTML();";
    }
	}
	var div_2= div+"_titulo";
	var div_3= div+"_opc";
	if(html==true)
	{
		HTML_OPC="<a href='"+HTML+"' ><img src='../imagenes/report_to_html.png' style='width:45px;'></a>";
	}
	if(validar==true)
	{
		document.getElementById(div_1).innerHTML="<img src='../imagenes/repo_icon.png' style='width:60px;'>";
		document.getElementById(div_2).innerHTML="<h4>" + TITULO + "</h4>";
		document.getElementById(div_3).innerHTML=EXCEL_OPC + " " + HTML_OPC;
	}
	else
	{
		document.getElementById(div_1).innerHTML="<img src='../imagenes/repo_icon.png' style='width:60px;'>";
		document.getElementById(div_2).innerHTML="<h4>" + TITULO + "</h4>";
		document.getElementById(div_3).innerHTML="N/A";
	}
}
////////////////////////////////////////////////////////////////
function Validar()
{
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