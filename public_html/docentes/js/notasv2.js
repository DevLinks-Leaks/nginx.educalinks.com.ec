function view_accordeon(div,curs_para_mate_prof_codi)
{	document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function()
	{   if ( xmlhttp.readyState === 4 && xmlhttp.status === 200 )
		{   document.getElementById( div ).innerHTML = xmlhttp.responseText;
			//$('#tbl_'+curs_para_mate_prof_codi ).DataTable();
		}
	}
	xmlhttp.open("POST",'notas_view_inaccordv2.php',true);
	xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
	xmlhttp.send('curs_para_mate_prof_codi=' + curs_para_mate_prof_codi);	
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

function form_notas_send (curs_para_mate_prof_codi,curs_para_mate_codi,peri_dist_codi,nota_perm_codi,accion){
	document.getElementById('curs_para_mate_prof_codi').value = curs_para_mate_prof_codi;
	document.getElementById('curs_para_mate_codi').value = curs_para_mate_codi;
	document.getElementById('peri_dist_codi').value = peri_dist_codi;
	document.getElementById('nota_perm_codi').value = nota_perm_codi;
	if (accion=='in')
		document.form_notas.action = 'notas_upload.php';
	if (accion=='out')
		document.form_notas.action = 'actas/notas_ingresadas_pdf.php';
	document.form_notas.submit();
}
function imprimirActa(curs_para_codi,curs_para_mate_codi,peri_dist_codi)
{
	var direccion;
	direccion="../admin/actas/acta_nota_parc_mate_excel_new.php?curs_para_codi=";
	direccion=direccion+curs_para_codi+"&curs_para_mate_codi="+curs_para_mate_codi+"&peri_dist_codi="+peri_dist_codi;
     //window.location.href=direccion;
     window.open(direccion);
 }
 function upload_excel ()
 {
 	if (document.getElementById('file_notas').value=="")
 		{	alert ('Seleccione un archivo por favor');
 	return false;
 }
}
function curs_para_nota_peri_dist_save(peri_dist_padr_view,curs_para_mate_codi,nota_perm_codi,curs_para_mate_prof_codi, nota_refe_cab_tipo, nota_refe_cab_codi){	  
	if (confirm("¿Está seguro de grabar estos valores?")) 
	{

		url='notas_deta_view_script.php';

		i=1;
		cc=document.getElementById('cc').value;
		cc_index=document.getElementById('CC_COLUM_index').value;

		var data = new FormData();
		data.append('col',cc);
		data.append('fil',cc_index);
		data.append('add_nota', 'Y');

		 //Lista de Alumnos		  
		 while (i<=cc)
		 {

				//Lista las columnnas de ingreso		
				alum_curs_para_mate_codi= document.getElementById('alum_curs_para_mate_codi_' + i).value ;
				deta_audi="Alumno curso paralelo materia: "+alum_curs_para_mate_codi;
				i2=0;
				
				while (i2<cc_index)
				{

					peri_dist_codi= document.getElementById('peri_dist_codi_' + (parseInt(i2) + 1)).value;
					nota= document.getElementById('nota_' + i + '_'  + i2).value ;
					
					data.append('alum_curs_para_mate_codi_'+i+'_'+i2, alum_curs_para_mate_codi);
					data.append('nota_'+i+'_'+i2, nota);
					data.append('peri_dist_codi_'+i+'_'+i2, peri_dist_codi);	
					deta_audi+=' Periodo distribución código: '+peri_dist_codi+' Nota: '+nota;

					i2+=1;
				}	 
				registrar_auditoria (19, deta_audi);
				i+=1;
				deta_audi= '';
			}	

			var xhr = new XMLHttpRequest();
			document.getElementById('notas_view').innerHTML='<div align="center" style="height:100%;"><img src="../../imagenes/ajax-loader.gif"/></div>';
			xhr.open('POST', url , false);
			/*xhr.onload = function () {
			  // do something to response
			  console.log(this.responseText);
			};
			xhr.onreadystatechange=function(){
			  if (xhr.readyState==4 && xhr.status==200){
				
			  } 
		   
			}*/
			xhr.send(data);

			$.growl.notice({ title: "Informacion: ",message: "Notas Grabadas" });	

			nota_perm_codi_in(nota_perm_codi);
			
			data='notas_deta_view.php?peri_dist_codi=' + peri_dist_padr_view + '&curs_para_mate_codi=' + curs_para_mate_codi + '&nota_perm_codi=' + nota_perm_codi + "&curs_para_mate_prof_codi="+curs_para_mate_prof_codi + "&nota_refe_cab_tipo="+nota_refe_cab_tipo + "&nota_refe_cab_codi="+nota_refe_cab_codi;
			load_ajax_get('notas_view',data);

		}			  
	}

	function nota_perm_codi_in(nota_perm_codi){
		url='notas_deta_view_script.php';
		var data = new FormData();
		data.append('nota_perm_codi', nota_perm_codi);			 
		data.append('perm_nota_in', 'Y');


		var xhr = new XMLHttpRequest();
		xhr.open('POST', url , true);
		xhr.onload = function () {		 
			console.log(this.responseText);
		};
		xhr.send(data);

	}



	function isNumber(event) {
		if (event) {
			var charCode = (event.which) ? event.which : event.keyCode;
			if (charCode != 190 && charCode > 31 && 
				(charCode < 48 || charCode > 57) && 
				(charCode < 96 || charCode > 105) && 
				(charCode < 37 || charCode > 40) && 
				charCode != 110 && charCode != 8 && charCode != 46 )
				return false;
		}
		return true;
	}

	function TEXTVALI(nota_nuev,nuev_actu,maximo)
	{
		if (nota_nuev.value == "") {
		//alert("El valor esta en blanco");
		nota_nuev.value=0;
	}
	else if (isNumber(nota_nuev.value)!= true ) {
		//alert("El valor no es numerico");
		nota_nuev.value=0;
	}
	else{
		if (nota_nuev.value > maximo) {
			//alert("El valor no puede ser mayor a " + maximo);
			nota_nuev.value=0;
		}
		if (nota_nuev.value < 0) {
			//alert("El valor debe ser mayor a cero");
			nota_nuev.value=0;

		}

	}
	//Actualiza el promedio
	//update_prom(nuev_actu)
}

function GuardarObs(peri_dist_codi, alum_codi, obse)
{
	if (confirm("¿Está seguro?"))
	{
		/*Creo los datos*/
		var datos = new FormData();
		datos.append("obse", obse);
		datos.append("alum_codi", alum_codi);
		datos.append("peri_dist_codi", peri_dist_codi);
		datos.append("opcion", "add");
		/*Creo objeto AJAX*/
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function ()
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				$.growl.notice({ title: "Mensaje: ",message: "¡Su observación fue grabada con éxito!" });
				location.reload();
			}
		}
		xmlhttp.open("POST","script_nota_obse.php");
		xmlhttp.send(datos);
	}
}////////////////////////////////////////
/////////////////////////////////////////
/////////////////////////////////////////
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

function getURLActaMateriaParcialExcel(id)
{
	if (Validar())
	{
		var direccion;
		direccion="actas/acta_nota_parc_mate_excel_new.php?curs_para_codi=";
		direccion=direccion+document.getElementById('curso_'+id).value+"&curs_para_mate_codi="+document.getElementById('materia_'+id).value+"&peri_dist_codi="+document.getElementById('peri_dist_'+id).value+"&font_type="+document.getElementById('font_type_'+id).value
		+"&font_size="+document.getElementById('font_size_'+id).value+"&report_logo="+document.getElementById('report_logo_'+id).checked+"&report_logo_minis="+document.getElementById('report_logo_minis_'+id).checked+"&pu="+document.getElementById('print_user_'+id).checked+"&pfd="+document.getElementById('print_fd_'+id).checked;
     //window.location.href=direccion;
     window.open(direccion);
 }
}
function getURLActaMateriaParcialHTML(id)
{
	if (Validar())
	{
		var direccion;
		direccion="actas/acta_nota_parc_mate_html.php?curs_para_codi=";
		direccion=direccion+document.getElementById('curso_'+id).value+"&curs_para_mate_codi="+document.getElementById('materia_'+id).value+"&peri_dist_codi="+document.getElementById('peri_dist_'+id).value+"&font_type="+document.getElementById('font_type_'+id).value
		+"&font_size="+document.getElementById('font_size_'+id).value+"&report_logo="+document.getElementById('report_logo_'+id).checked+"&report_logo_minis="+document.getElementById('report_logo_minis_'+id).checked+"&pu="+document.getElementById('print_user_'+id).checked+"&pfd="+document.getElementById('print_fd_'+id).checked;
     //window.location.href=direccion;
     window.open(direccion);
 }
}
function getURLActaMateriaQuimestreExcel(id)
{
	if (Validar())
	{
		var direccion;
		direccion="actas/acta_nota_parc_mate_excel_new.php?curs_para_codi=";
		direccion=direccion+document.getElementById('curso_'+id).value+"&curs_para_mate_codi="+document.getElementById('materia_'+id).value+"&peri_dist_codi="+document.getElementById('peri_dist_'+id).value+"&font_type="+document.getElementById('font_type_'+id).value
		+"&font_size="+document.getElementById('font_size_'+id).value+"&report_logo="+document.getElementById('report_logo_'+id).checked+"&report_logo_minis="+document.getElementById('report_logo_minis_'+id).checked+"&pu="+document.getElementById('print_user_'+id).checked+"&pfd="+document.getElementById('print_fd_'+id).checked;
     //window.location.href=direccion;
     window.open(direccion);
 }
}
function getURLActaMateriaQuimestreHTML(id)
{
	if (Validar())
	{
		var direccion;
		direccion="actas/acta_nota_parc_mate_html.php?curs_para_codi=";
		direccion=direccion+document.getElementById('curso_'+id).value+"&curs_para_mate_codi="+document.getElementById('materia_'+id).value+"&peri_dist_codi="+document.getElementById('peri_dist_'+id).value+"&font_type="+document.getElementById('font_type_'+id).value
		+"&font_size="+document.getElementById('font_size_'+id).value+"&report_logo="+document.getElementById('report_logo_'+id).checked+"&report_logo_minis="+document.getElementById('report_logo_minis_'+id).checked+"&pu="+document.getElementById('print_user_'+id).checked+"&pfd="+document.getElementById('print_fd_'+id).checked;
     //window.location.href=direccion;
     window.open(direccion);
 }
}
function getURLCuadroCalificacionesExcel(id)
{
	if (Validar())
	{
		var direccion;
		direccion="actas/cuadro_cali_excel_new.php?curs_para_codi=";
		direccion=direccion+document.getElementById('curso_'+id).value+"&curs_para_mate_codi="+document.getElementById('materia_'+id).value+"&peri_dist_codi="+document.getElementById('peri_dist_'+id).value+"&font_type="+document.getElementById('font_type_'+id).value
		+"&font_size="+document.getElementById('font_size_'+id).value+"&report_logo="+document.getElementById('report_logo_'+id).checked+"&report_logo_minis="+document.getElementById('report_logo_minis_'+id).checked+"&pu="+document.getElementById('print_user_'+id).checked+"&pfd="+document.getElementById('print_fd_'+id).checked;
     //window.location.href=direccion;
     window.open(direccion);
 }
}
function getURLCuadroCalificacionesHTML(id)
{
	if (Validar())
	{
		var direccion;
		direccion="actas/cuadro_cali_html.php?curs_para_codi=";
		direccion=direccion+document.getElementById('curso_'+id).value+"&curs_para_mate_codi="+document.getElementById('materia_'+id).value+"&peri_dist_codi="+document.getElementById('peri_dist_'+id).value+"&font_type="+document.getElementById('font_type_'+id).value
		+"&font_size="+document.getElementById('font_size_'+id).value+"&report_logo="+document.getElementById('report_logo_'+id).checked+"&report_logo_minis="+document.getElementById('report_logo_minis_'+id).checked+"&pu="+document.getElementById('print_user_'+id).checked+"&pfd="+document.getElementById('print_fd_'+id).checked;
     //window.location.href=direccion;
     window.open(direccion);
 }
}
function getURLCuadroCalificacionesFinalesExcel(id)
{
	if (Validar())
	{
		var direccion;
		direccion="actas/cuadro_cali_final_excel_new.php?curs_para_codi=";
		direccion=direccion+document.getElementById('curso_'+id).value+"&curs_para_mate_codi="+document.getElementById('materia_'+id).value+"&peri_dist_codi="+document.getElementById('peri_dist_'+id).value+"&font_type="+document.getElementById('font_type_'+id).value
		+"&font_size="+document.getElementById('font_size_'+id).value+"&report_logo="+document.getElementById('report_logo_'+id).checked+"&report_logo_minis="+document.getElementById('report_logo_minis_'+id).checked+"&pu="+document.getElementById('print_user_'+id).checked+"&pfd="+document.getElementById('print_fd_'+id).checked;
     //window.location.href=direccion;
     window.open(direccion);
 }
}
function getURLCuadroCalificacionesFinalesHTML(id)
{
	if (Validar())
	{
		var direccion;
		direccion="actas/cuadro_cali_final_html.php?curs_para_codi=";
		direccion=direccion+document.getElementById('curso_'+id).value+"&curs_para_mate_codi="+document.getElementById('materia_'+id).value+"&peri_dist_codi="+document.getElementById('peri_dist_'+id).value+"&font_type="+document.getElementById('font_type_'+id).value
		+"&font_size="+document.getElementById('font_size_'+id).value+"&report_logo="+document.getElementById('report_logo_'+id).checked+"&report_logo_minis="+document.getElementById('report_logo_minis_'+id).checked+"&pu="+document.getElementById('print_user_'+id).checked+"&pfd="+document.getElementById('print_fd_'+id).checked;
     //window.location.href=direccion;
     window.open(direccion);
 }
}
////////////////////////////////////////////////////////////////
function ValidarOpciones(parcialquim, id)
{	console.log(parcialquim);
	console.log(id);
	if (parcialquim.substring(0, 7)=='PERIODO')
	{
		divOpciones('acta_001', true,  false, "&nbsp;",id);
		divOpciones('acta_002', false, false, "&nbsp;",id);
		divOpciones('acta_003', true,  false, "&nbsp;",id);
		divOpciones('acta_004', true,  false, "&nbsp;",id);
	}
	else if (parcialquim.substring(0, 9)=='QUIMESTRE')
	{
		divOpciones('acta_001', true,  false, " quimestrales",id);
		divOpciones('acta_002', false, false, " quimestrales",id);
		divOpciones('acta_003', true,  false, " quimestrales",id);
		divOpciones('acta_004', true,  false, " quimestrales",id);
	}
	else if (parcialquim.substring(0, 6)=='EXAMEN')
	{
		divOpciones('acta_001', false, false, " examenes",id);
		divOpciones('acta_002', true,  false, " examenes",id);
		divOpciones('acta_003', true,  false, " examenes",id);
		divOpciones('acta_004', true,  false, " examenes",id);
	}
	else if (parcialquim.substring(0, 7)=='PARCIAL')
	{
		divOpciones('acta_001', false, false, " parciales",id);
		divOpciones('acta_002', true,  false, " parciales",id);
		divOpciones('acta_003', true,  false, " parciales",id);
		divOpciones('acta_004', true,  false, " parciales",id);
	}
}
function divOpciones(div, validar, html, acta, id)
{
	var div_1= "";
	var HTML_OPC="";
	var img_over="onmouseover=\"this.src='../imagenes/report_to_excel-over.png'\" " +
	" onmouseout=\"this.src='../imagenes/report_to_excel.png'\" ";
	if(div=='acta_001')
	{
		div_1= div+"_qm_"+id;
		var TITULO="Acta de calificaciones por quimestre y materia";
		var EXCEL="JavaScript:getURLActaMateriaQuimestreExcel("+id+");";
		var EXCEL_OPC="<a href='"+EXCEL+"' ><img src='../imagenes/report_to_excel.png' style='width:30px;' "+img_over+" border='0'></a>";
		var HTML="JavaScript:getURLActaMateriaQuimestreHTML("+id+");";
	}
	else if(div=='acta_002')
	{
		div_1= div+"_pm_"+id;
		var TITULO="Acta de calificaciones por parcial y materia";
		var EXCEL="JavaScript:getURLActaMateriaParcialExcel("+id+");";
		var EXCEL_OPC="<a href='"+EXCEL+"' ><img src='../imagenes/report_to_excel.png' style='width:30px;' "+img_over+"  border='0'></a>";
		var HTML="JavaScript:getURLActaMateriaParcialHTML("+id+");";
	}
	else if(div=='acta_003')
	{
		div_1= div+"_cq_"+id;
		var TITULO="Cuadro de calificaciones" + acta;
		var EXCEL="JavaScript:getURLCuadroCalificacionesExcel("+id+");";
		var EXCEL_OPC="<a href='"+EXCEL+"' ><img src='../imagenes/report_to_excel.png' style='width:30px;' "+img_over+"  border='0'></a>";
		var HTML="JavaScript:getURLCuadroCalificacionesHTML("+id+");";
	}
	else if(div=='acta_004')
	{
		div_1= div+"_cf_"+id;
		var TITULO="Cuadro de calificaciones" + acta + " finales";
		var EXCEL="JavaScript:getURLCuadroCalificacionesFinalesExcel("+id+");";
		var EXCEL_OPC="<a href='"+EXCEL+"' ><img src='../imagenes/report_to_excel.png' style='width:30px;' "+img_over+"  border='0'></a>";
		var HTML="JavaScript:getURLCuadroCalificacionesFinalesHTML("+id+");";
	}
	var div_2= div+"_titulo_" + id;
	var div_3= div+"_opc_" + id;
	console.log(div_1);
	console.log(div_2);
	console.log(div_3);
	if(html==true)
	{
		HTML_OPC="<a href='"+HTML+"' ><img src='../imagenes/report_to_html.png' style='width:30px;'></a>";
	}
	if(validar==true)
	{	document.getElementById(div_1).innerHTML="<img src='../imagenes/repo_icon.png' style='width:30px;'>";
		document.getElementById(div_2).innerHTML="<h4>" + TITULO + "</h4>";
		document.getElementById(div_3).innerHTML=EXCEL_OPC + " " + HTML_OPC;
	}
	else
	{
		document.getElementById(div_1).innerHTML="<img src='../imagenes/repo_icon.png' style='width:30px;'>";
		document.getElementById(div_2).innerHTML="<h4>" + TITULO + "</h4>";
		document.getElementById(div_3).innerHTML="N/A";
	}
}
function Validar()
{	/* Fución copiada de select_actas.js. retorna sólo true porque no existen combos de paralelo o asignatura en este caso.

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
	*/
	return true;
}