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
