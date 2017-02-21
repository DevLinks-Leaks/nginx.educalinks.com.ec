function activar_boton(value){
		if (value==0)
			$('#btn_matricular').prop('disabled', true);
		else
			$('#btn_matricular').prop('disabled', false);
}

function alum_est_mensaje(opc, respuesta)
{	if (opc=='alum_info_alum_est_check' && respuesta == true)
	{
		return 'Cambio guardado.';
	}
	if (opc=='alum_info_alum_est_check' && respuesta == false)
	{
		return 'Error al hacer visto.';
	}
	if (opc=='alum_info_docu_check' && respuesta == true)
	{
		return 'Cambio guardado.';
	}
	if (opc=='alum_info_docu_check' && respuesta == false)
	{
		return 'Error al hacer visto.';
	}
	if (opc=='add_alum_est_reg' && respuesta == true)
	{
		return 'Cambio de estado guardado.';
	}
	if (opc=='add_alum_est_reg' && respuesta == false)
	{
		return 'Error al guardar cambios.';
	}
}
function load_ajax_alum_curso_combo(div,url,data){
	document.getElementById(div).innerHTML='<div align="center" style="height:100%;"><img src="../imagenes/ajax-loader.gif"/></div>';
	document.getElementById('div_curs').innerHTML ='';

	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			
			document.getElementById(div).innerHTML=xmlhttp.responseText;
			load_ajax_alum_curso_cupo('div_cupo_disp','cursos_paralelo_main_cupo.php','curs_para_codi='+ document.getElementById('curs_para_codi').value);	
		}
	}
	xmlhttp.open("POST",url,true);
	xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
	xmlhttp.send(data);	
}
function load_ajax_alum_curso_cupo(div,url,data){
	//document.getElementById(div).innerHTML='<div align="center" style="height:100%;"><img src="../imagenes/ajax-loader.gif"/></div>';
	document.getElementById(div).innerHTML='';
	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById(div).innerHTML=xmlhttp.responseText;			
		}
	}
	xmlhttp.open("POST",url,true);
	xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
	xmlhttp.send(data);	
}
function load_ajax_cambio_estado(div,url, div2, url2, data){
	document.getElementById(div).innerHTML='<div align="center" style="height:100%;"><img src="../imagenes/ajax-loader.gif"/></div>';
	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function()
	{   if (xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById(div).innerHTML=xmlhttp.responseText;
			load_ajax_alum_est_matr_checks(div2,url2,data)
		}
	};
	console.log(url);
	xmlhttp.open("POST",url,true);
	xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
	xmlhttp.send(data);	
}
function load_ajax_alum_est_matr_checks(div,url,data){
	document.getElementById(div).innerHTML='<div align="center" style="height:100%;"><img src="../imagenes/ajax-loader.gif"/></div>';
	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById(div).innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("POST",url,true);
	xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
	xmlhttp.send(data);	
}
function load_ajax_alumno_estado_combo(div,url,data){
	document.getElementById(div).innerHTML='<div align="center" style="height:100%;"><img src="../imagenes/ajax-loader.gif"/></div>';
	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById(div).innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("POST",url,true);
	xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
	xmlhttp.send(data);	
}
function load_ajax_documentos(div,url,data){
	document.getElementById(div).innerHTML='<div align="center" style="height:100%;"><img src="../imagenes/ajax-loader.gif"/></div>';
	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById(div).innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("POST",url,true);
	xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
	xmlhttp.send(data);	
}
function load_ajax_add_alum_est_reg(div,url,data){
	document.getElementById(div).innerHTML='<div align="center" style="height:100%;"><img src="../imagenes/ajax-loader.gif"/></div>';
	document.getElementById('ModalMatri_footer').innerHTML='<small><i>Por favor espere...</i></small>';
	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			
			if (xmlhttp.responseText>0){
				$.growl.notice({ title: "Educalinks informa:",message: alum_est_mensaje('add_alum_est_reg', true) });
			}else{
				$.growl.error({ title: "Educalinks informa:",message: alum_est_mensaje('add_alum_est_reg', false) });
			}
			var text="";
			$('#ModalMatri').modal('hide');
			load_ajax('alum_main','alumnos_main_lista.php','');
		}
	}
	xmlhttp.open("POST",url,true);
	xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
	xmlhttp.send(data);	
}
function load_ajax_previo_periodo(valor1, valor2, div, url, div2, url2, data){
	document.getElementById('div_periodo_previo').innerHTML='<div align="center" style="height:100%;"><img src="../imagenes/ajax-loader.gif"/></div>';
	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function()
	{   if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{   document.getElementById('div_periodo_previo').innerHTML=xmlhttp.responseText;
			if( valor1 == valor2 )
			{   load_ajax_alum_est_matr_checks(div, url, data);
				load_ajax_ModalMatri('ModalMatri_footer', 'OPCION_CERO', document.getElementById('adm_est_alum_est_det').value);
			}
			else if( valor1 == 'Matriculado' )
			{   load_ajax_alum_est_matr_checks(div, url, data);
				load_ajax_ModalMatri('ModalMatri_footer', 'OPCION_CERO', document.getElementById('adm_est_alum_est_det').value);
			}
			else
			{
				/*
				document.getElementById('div_checks').innerHTML ='';
				load_ajax(div2, url2, data);
				
				En caso de querer cambiar las cosas, y querer que el 'Detalle del estado' se muestre sólo cuando valor1=valor 2,
				comentar la linea de abajo y descomentar las líneas de arriba. En el caso de desear el resultado contrario, realizar
				la acción contraria.
				*/
				load_ajax_cambio_estado(div, url, div2, url2, data);
				load_ajax_ModalMatri('ModalMatri_footer', 'Seleccione...', document.getElementById('adm_est_alum_est_det').value);
			}
		}
	};
	xmlhttp.open("POST",'alumnos_main_previo_periodo.php',true);
	xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
	xmlhttp.send(data);	
}
/////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////
function load_ajax_add_alum(div,url,data,elem){	
	//document.getElementById(div).innerHTML='<div align="center" style="height:100%;"><img src="../imagenes/ajax-loader.gif"/></div>';
	if(ValidarAlumno() && ValidarUsuario())
	{   document.getElementById(div).innerHTML='';
		if (window.XMLHttpRequest)
		{// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		}
		else
		{// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=function()
		{   if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{   if ( xmlhttp.responseText > 0 )
				{   document.getElementById(elem).value=xmlhttp.responseText;
					$.growl.notice({ title: "Educalinks informa",message: "Se guardaron correctamente los datos del alumno." });
					$('#btn_inscribir').hide();
					$('#btn_cancelar').hide();
					document.getElementById('btn_repre').style.display='Block';
					load_ajax_file('div_foto','script_alum_foto.php?alum_codi='+document.getElementById('alum_codi').value,'alum_foto');
				}else
				{   $.growl.error({ title: "Educalinks informa",message: "Ocurrió un error al grabar los datos del alumno." });	
					document.getElementById('alum_usua').focus();
				}
			}
		};
		xmlhttp.open("POST",url,true);
		xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		xmlhttp.send(data);	
	}
}
function load_ajax_edit_alum(div,url,data){
	if(ValidarAlumno())
	{	document.getElementById(div).innerHTML='<div align="center" style="height:100%;"><img src="../imagenes/ajax-loader.gif"/></div>';
		document.getElementById(div).innerHTML='';
		if (window.XMLHttpRequest)
		{// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		}
		else
		{// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=function()
		{   if ( xmlhttp.readyState == 4 && xmlhttp.status == 200 )
			{  	if ( xmlhttp.responseText != '-1' )
				{   $.growl.notice({ title: "Educalinks informa",message: "¡Exito! Datos guardados correctamente." });
					load_ajax_file('div_foto','script_alum_foto.php?alum_codi='+document.getElementById('alum_codi').value,'alum_foto');
				}else
				{   $.growl.error({ title: "Educalinks informa",message: "Error! Datos no se guardaron." });
					load_ajax_file('div_foto','script_alum_foto.php?alum_codi='+document.getElementById('alum_codi').value,'alum_foto');
				}
			}
		};
		xmlhttp.open("POST",url,true);
		xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		xmlhttp.send(data);	
	}
}
function vali_matri(cupo_actual,curs_para_codi,alum_codi)
{	
	$('#btn_matricular').button('loading');
	if (cupo_actual>0)
	{
		if (window.XMLHttpRequest)
		{// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		}
		else
		{// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=function()
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				if (xmlhttp.responseText!="KO"){
					alert("Se realizó correctamente la matriculación");
					location.reload();
					/* Descomentar en caso de querer que la ventana matriculado se mantenga abierta despues de darle click a Matricular.
					
					document.getElementById('div_adm_est_alum_curs_para_codi').innerHTML='Matriculado Por Pagar';
					document.getElementById('div_curs').innerHTML ='';
					document.getElementById('div_alumno_estado_periodo').innerHTML ='';
					document.getElementById('adm_est_curs_para_codi').value=curs_para_codi;
					document.getElementById('adm_est_alum_est_det').value='Matriculado Por Pagar';
					load_ajax_si_valor_es_igual('Matriculado Por Pagar', 'Matriculado Por Pagar', 'div_checks','alumno_estado_detalle.php','div_alumno_estado_periodo', 'alumnos_main_estado_combo.php','peri_codi=' + document.getElementById('peri_0').value + '&alum_est_codi=' + document.getElementById('adm_est_alum_est_codi').value + '&alum_est_det=Matriculado Por Pagar&alum_codi=' + document.getElementById('alum_codi').value + '&peri_tipo=R');
					*/
					$('#btn_matricular').button('reset');
					$('#ModalMatri').modal('hide');
					load_ajax('alum_main','alumnos_main_lista.php','');
				}else{
					alert("Ocurrió un problema al procesar la matriculación.");
					$('#btn_matricular').button('reset');
					$('#ModalMatri').modal('hide');
					load_ajax('alum_main','alumnos_main_lista.php','');
				}
			}
		}
		xmlhttp.open("POST","script_alum.php",true);
		xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		var data="opc=add_curs_para&alum_codi="+alum_codi+"&curs_para_codi="+curs_para_codi;
		xmlhttp.send(data);
	}else{
		alert("El curso se encuentra sin cupo disponible. Por favor elija otro")
	}
}
function vali_desmatri(curs_para_codi,alum_codi)
{
	if (confirm ("¿Está seguro de querer desmatricular al estudiante?"))
	{
		if (window.XMLHttpRequest)
		{// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		}
		else
		{// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=function()
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				if (xmlhttp.responseText!="KO")
				{
					switch (xmlhttp.responseText)
					{
						case "1":
							alert("Error: El estudiante tiene notas registradas.");
						break;
						case "2":
							alert("Error: El estudiante tiene faltas registradas.");
						break;
						default:
							alert("Se realizó correctamente la desmatriculación");
							//$('#ModalMatri').modal('hide');
							load_ajax_add_alum_est_reg('div_alumno_estado_periodo', 'script_alum.php', 'opc=alum_add_alum_est_peri_reg&alum_codi=' + document.getElementById('alum_codi').value + '&peri_codi=' + document.getElementById('peri_0').value + '&alum_est_peri_codi=' + document.getElementById('sl_estado').value );
					}
				}
				else
				{
					alert("Ocurrió un problema al procesar la desmatriculación.");
					load_ajax('alum_main','alumnos_main_lista.php','');
				}
			}
		}
		xmlhttp.open("POST","script_alum.php",true);
		xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		var data="opc=del_curs_para&alum_codi="+alum_codi+"&curs_para_codi="+curs_para_codi;
		xmlhttp.send(data);	
	}
}
function load_ajax_del_alum(div,url,data){	
	//document.getElementById(div).innerHTML='<div align="center" style="height:100%;"><img src="../imagenes/ajax-loader.gif"/></div>';
	if (confirm ("¿Está seguro de querer eliminar al estudiante, se perderán las notas, registros de faltas y todos los datos relacionados con el estudiante?"))
	{
		if (window.XMLHttpRequest)
		{// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		}
		else
		{// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=function()
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200){
				if(xmlhttp.responseText>0){
					$.growl.notice({ title: "Educalinks informa:",message: "Se eliminó correctamente los datos del alumno." });	
					/*var data_new="opc=repr_list_gen";
					var text="";
					load_ajax_lista_twofilters(div,'alumnos_main_lista.php','texto=','alumnos_main_lista','alum_table');*/
					location.reload();
				}else{
					$.growl.error({ title: "Educalinks informa:",message: "Ocurrió un error al eliminar los datos del alumno." });	
				}
			}
		}
		
		xmlhttp.open("POST",url,true);
		xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		xmlhttp.send(data);
	}
}
function load_ajax_retiro_alum(div,url,data)
{
	if (confirm ("¿Está seguro de querer retirar al estudiante?"))
	{
		if (window.XMLHttpRequest)
		{// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		}
		else
		{// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=function()
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				if(xmlhttp.responseText>0)
				{
					$.growl.notice({ title: "Educalinks informa:",message: "Retiro exitoso del estudiante." });	
					location.reload();
				}
				else
				{
					$.growl.error({ title: "Educalinks informa:",message: "No se pudo procesar el retiro del estudiante." });	
				}
			}
		}
		
		xmlhttp.open("POST",url,true);
		xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		xmlhttp.send(data);
	}
}
function alum_bloq_view()
{	
	/*div='alum_bloq_view';
	document.getElementById(div).innerHTML='<div align="center" style="height:100%;"><img src="../imagenes/ajax-loader.gif"/></div>';
	
	url='alumnos_bloq_view.php?';
	url += data = 	'alum_bloq_nomb='   + document.getElementById('alum_nomb').value + 
			'&alum_bloq_apel='  + document.getElementById('alum_apel').value + 
			'&alum_bloq_cedu='  + document.getElementById('alum_cedu').value;
			
	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			
			document.getElementById(div).innerHTML=xmlhttp.responseText;
			
		}
	}
	xmlhttp.open("GET",url + data,true);
	xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
	xmlhttp.send(data);	*/
}

function alumno_bloqueado(alum_cedu,alum_apel,alum_nomb){		 
	 	
		url = 'script_alum.php?';
	
	
		url='cursos_paralelo_falt_alum_main_view.php';
		div='divview';
		
		opc =		document.getElementById('veri_bloq').value ;					 
	 	alum_cedu= 		document.getElementById('alum_cedu').value;
	  	alum_apel= 		document.getElementById('alum_apel').value ;
	  	alum_nomb= 		document.getElementById('alum_nomb').value ;
		 
	  	
		
		var data = new FormData();		
		data.append('opc', opc);		
		
		data.append('alum_cedu', alum_cedu);	
		data.append('alum_apel', alum_apel);
		data.append('alum_nomb', alum_nomb);	
 
		
		
		var xhr = new XMLHttpRequest();
		xhr.open('POST', url , true);
		xhr.onload = function () {
		// do something to response
		console.log(this.responseText);
		};
		xhr.onreadystatechange=function(){
		if (xhr.readyState==4 && xhr.status==200){		   
		  	document.getElementById(div).innerHTML=xhr.responseText;	
		} 
		
		}
		xhr.send(data);
}

function curs_para_cambiar_load (alum_curs_para_codi, alum_codi)
{
	document.getElementById("alum_curs_para_codi").value=alum_curs_para_codi;
	document.getElementById("alum_codi").value=alum_codi;
	document.getElementById("sl_curs_para_codi_1").value=-1;
	document.getElementById("div_matching").innerHTML="";
}

function curs_para_cambiar(alum_curs_para_codi, curs_para_codi)
{
	if (confirm ("¿Está seguro de querer cambiar al estudiante de paralelo, se perderán todas sus notas y deberá volver a ingresarlas?"))
	{
		if (window.XMLHttpRequest)
		{// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		}
		else
		{// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=function()
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200){
				if (xmlhttp.responseText!="KO")
				{
					alert("Cambio de paralelo existoso.");
					location.reload();
				}
				else
				{
					alert("Ocurrió un problema al cambiar de paralelo.");
				}
			}
		}
		xmlhttp.open("POST","script_alum.php",true);
		xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		var data="opc=camb_curs_para&alum_curs_para_codi="+alum_curs_para_codi+"&curs_para_codi="+curs_para_codi;
		xmlhttp.send(data);	
	}
}
function ActivarDesactivarText(ckeck_box,text_box)
{
	if (document.getElementById(ckeck_box).checked)
	{
		document.getElementById(text_box).disabled=false;
		document.getElementById(text_box).setAttribute('placeholder','Ingrese aquí');
		document.getElementById(text_box).focus();
	}
	else
	{
		document.getElementById(text_box).disabled=true;
		document.getElementById(text_box).value='';
		document.getElementById(text_box).setAttribute('placeholder','No tiene');
	}
}
function load_ajax_alum_info_est(div, url, opc, check, alum_codi, peri_codi, columna)
{	
	var data = new FormData();
	data.append('opc', opc);
	data.append('check', check);
	data.append('alum_codi', alum_codi);
	data.append('peri_codi', peri_codi);
	data.append('columna', columna);
	var xhr = new XMLHttpRequest();
	xhr.open('POST', url , true);
	xhr.onreadystatechange=function(){
		if (xhr.readyState==4 && xhr.status==200){
		//alert(xhr.responseText);
		if (xhr.responseText>0){
				$.growl.notice({ title: "Educalinks informa:",message: alum_est_mensaje(opc, true) });
			}else{
				$.growl.error({ title: "Educalinks informa:",message: alum_est_mensaje(opc, false) });
			}
			var text="";
			load_ajax_alum_est_matr_checks(div,'alumno_estado_detalle.php','peri_codi='+peri_codi+'&alum_codi='+alum_codi);
		}
	}
	xhr.send(data);
}
function js_student_verify_user(div,url,data)
{   document.getElementById(div).innerHTML='<div align="center" style="height:100%;"><img src="../imagenes/ajax-loader.gif"/></div>';
	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function()
	{   if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{   obj = JSON.parse( xmlhttp.responseText );
			var n = obj[ 'MENSAJE' ].length;
			if ( n > 0 )
			{   document.getElementById(div).innerHTML = obj[ 'MENSAJE' ];
				document.getElementById('hd_user_verified').value = obj[ 'VERIFIED' ];
			}
			else
			{   document.getElementById(div).innerHTML = obj[ 'MENSAJE' ];
				document.getElementById('hd_user_verified').value = obj[ 'VERIFIED' ];
			}
		}
	}
	xmlhttp.open("POST",url,true);
	xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
	xmlhttp.send(data);	
}
function load_ajax_alum_docu(div, url, opc, check, alum_codi, peri_codi, docu_peri_codi)
{	var data = new FormData();
	data.append('opc', opc);
	data.append('check', check);
	data.append('alum_codi', alum_codi);
	data.append('peri_codi', peri_codi);
	data.append('docu_peri_codi', docu_peri_codi);
	var xhr = new XMLHttpRequest();
	xhr.open('POST', url , true);
	xhr.onreadystatechange=function(){
		if (xhr.readyState==4 && xhr.status==200){
		//alert(xhr.responseText);
		if (xhr.responseText>0){
				$.growl.notice({ title: "Educalinks informa:",message: alum_est_mensaje(opc, true) });
			}else{
				$.growl.error({ title: "Educalinks informa:",message: alum_est_mensaje(opc, false) });
			}
			var text="";
			load_ajax_documentos(div,'alumno_estado_detalle.php','peri_codi='+peri_codi+'&alum_codi='+alum_codi);
		}
	}
	xhr.send(data);
}
function load_ajax_ModalMatri(div, estado, actual)
{	var subtexto0='';
	var subtexto1='';
	var mostrarTabla=1;
	document.getElementById('div_blacklist_view').innerHTML='';
	var BOTON_CAMBIAR_ESTADO = "<button type='button' class='btn btn-info' onClick=\"load_ajax_cambiar_estado_del_estudiante('div_alumno_estado_periodo', 'alumnos_main_estado_combo.php', 'peri_codi=' + document.getElementById('peri_0').value + '&alum_est_codi=' + document.getElementById('adm_est_alum_est_codi').value + '&alum_est_det=' + document.getElementById('adm_est_alum_est_det').value);\">Cambiar Estado actual</button>";
	var BOTON_CAMBIAR_ESTADO_HREF = "<a onClick=\"load_ajax_cambiar_estado_del_estudiante('div_alumno_estado_periodo', 'alumnos_main_estado_combo.php', 'peri_codi=' + document.getElementById('peri_0').value + '&alum_est_codi=' + document.getElementById('adm_est_alum_est_codi').value + '&alum_est_det=' + document.getElementById('adm_est_alum_est_det').value);\">Cambiar Estado actual</a>";
	if (estado==actual)
	{   subtexto0=" <font color='red'><small><i>No puede seleccionar el mismo estado</i></small></font> ";
		subtexto1=" disabled = 'disabled' ";
		mostrarTabla = 0;
	}
	if ( ( actual=='Matriculado' ) && ( estado =='Matriculado Por Pagar' ) )
	{   subtexto0=" <font color='red'><small><i>No puede seleccionar el mismo estado</i></small></font> ";
		subtexto1=" disabled = 'disabled' ";
		mostrarTabla = 0;
	}
	if (estado=='Seleccione...')
	{
		document.getElementById(div).innerHTML = "<table width='100%'><tr><td width='200px' align='left'></td><td align='right'><button type='button' class='btn btn-default' data-dismiss='modal'>Cerrar</button></td></tr></table>";
	}
	else if ( estado=='Matriculado Por Pagar' )
	{
		document.getElementById(div).innerHTML = "<table width='100%'><tr><td width='200px' align='left'>"+subtexto0+"</td><td align='right'><button "+subtexto1+" type='button' id='btn_matricular' class='btn btn-success' data-loading-text='Matriculando...' onClick=\"vali_matri(document.getElementById('span_cupo').innerHTML,document.getElementById('curs_para_codi').value,document.getElementById('alum_codi').value);\" disabled >Matricular</button><button type='button' class='btn btn-default' data-dismiss='modal'>Cerrar</button></td></tr></table>";
		document.getElementById('div_blacklist_view').innerHTML='';
		load_ajax_blacklist_aviso('div_blacklist_view','script_alumnos_blacklist.php',document.getElementById('alum_codi').value,'alert_blacklist' );
		document.getElementById('div_bloqueos_view').innerHTML='';
		if( mostrarTabla )
		{   load_ajax_lista_alum_bloq_matriz('div_bloqueos_view','script_alum.php',document.getElementById('alum_codi').value,'alum_moti_bloq_opci_only_view', actual );
		}
	}
	else if (estado=='Retirado')
	{
		if ((actual !='Matriculado Por Pagar') && (actual !='Matriculado') && (actual!='Retirado'))
		{
			subtexto0=" <font color='red'><small><i>Estudiante debe estar matriculado primero, para poder ser retirado.</i></small></font> ";
			subtexto1=" disabled = 'disabled' ";
		}
		document.getElementById(div).innerHTML = "<table width='100%'><tr><td width='200px' align='left'>"+subtexto0+"</td><td align='right'><button "+subtexto1+" type='button' class='btn btn-success' onClick=\"load_ajax_retiro_alum('div_matri', 'script_alum.php', 'opc=alum_ret&alum_curs_para_codi=' + document.getElementById('adm_est_alum_curs_para_codi').value);\">Retirar estudiante del periodo actual</button><button type='button' class='btn btn-default' data-dismiss='modal'>Cerrar</button></td></tr></table>";
	}
	else if (estado=='OPCION_CERO')
	{
		document.getElementById(div).innerHTML = "<table width='100%'><tr><td valign='top' width='200px' align='left'>" + BOTON_CAMBIAR_ESTADO + "<br/><br/><small><i>Estado actual: "+ actual +".</i></small></td><td valign='top' align='right'><button type='button' class='btn btn-default' data-dismiss='modal'>Cerrar</button></td></tr></table>";
		document.getElementById('div_cambiar_estado').innerHTML = "<font color='red'><small><i>"+BOTON_CAMBIAR_ESTADO_HREF+"</i></small></font>" ;
	}
	else
	{
		var ONCLICK_AJAX = "";
		//if((actual=='Matriculado Por Pagar') && ((estado=='Admitido') || (estado=='Inscrito') || (estado=='No Admitido')))
		if (actual=='Matriculado Por Pagar')
		{
			ONCLICK_AJAX = "vali_desmatri(document.getElementById('adm_est_curs_para_codi').value, document.getElementById('alum_codi').value);";
		}
		else
		{
			ONCLICK_AJAX = "load_ajax_add_alum_est_reg('div_alumno_estado_periodo', 'script_alum.php', 'opc=alum_add_alum_est_peri_reg&alum_codi=' + document.getElementById('alum_codi').value + '&peri_codi=' + document.getElementById('peri_0').value + '&alum_est_peri_codi=' + document.getElementById('sl_estado').value );";
		}
		document.getElementById(div).innerHTML = "<table width='100%'><tr><td width='200px' align='left'>"+subtexto0+"</td><td align='right'><button "+subtexto1+" type='button' class='btn btn-success' onClick=\""+ ONCLICK_AJAX +"\">Cambiar Estado</button><button type='button' class='btn btn-default' data-dismiss='modal'>Cerrar</button></td></tr></table>";
	}
}
function load_ajax_si_valor_es_igual(valor1, valor2, div, url, div2, url2, data)
{
	load_ajax_previo_periodo(valor1, valor2, div, url, div2, url2, data);
}
function load_ajax_cambiar_estado_del_estudiante(div, url, data)
{   var BOTON_VER_DETALLE_AJAX = "document.getElementById('div_curs').innerHTML =''; document.getElementById('div_alumno_estado_periodo').innerHTML ='';load_ajax_si_valor_es_igual(document.getElementById('adm_est_alum_est_det').value, 'Matriculado Por Pagar', 'div_checks','alumno_estado_detalle.php','div_alumno_estado_periodo', 'alumnos_main_estado_combo.php','peri_codi=' + document.getElementById('peri_0').value + '&alum_est_codi=' + document.getElementById('adm_est_alum_est_codi').value + '&alum_est_det=' + document.getElementById('adm_est_alum_est_det').value + '&alum_codi=' + document.getElementById('alum_codi').value + '&peri_tipo=R');";
	var BOTON_VER_DETALLE="";
	document.getElementById('div_checks').innerHTML ='';
	document.getElementById('div_cambiar_estado').innerHTML ="<font color='red'><small><i><a onClick=\" " + BOTON_VER_DETALLE_AJAX + " \">Ver detalle...</a></i></small></font>";
	load_ajax(div, url, data);
	load_ajax_ModalMatri('ModalMatri_footer', 'Seleccione...', document.getElementById('adm_est_alum_est_det').value);
}
function show_edit_bloqueo (div,alum_codi,opc)
{	document.getElementById('alum_bloq_codi').value=alum_codi;
	load_ajax_lista_alum_bloq(div,'script_alum.php',alum_codi,opc);
}
function load_ajax_lista_alum_bloq(div,url,alum_codi,opc){
	document.getElementById(div).innerHTML='<div align="center" style="height:100%;"><img src="../imagenes/ajax-loader.gif"/></div>';
	if (window.XMLHttpRequest)
	{	// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else
	{	// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	var data = new FormData();
	data.append('opc', opc);
	data.append('alum_codi', alum_codi);
	xmlhttp.onreadystatechange=function()
	{   if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{   if( xmlhttp.responseText.length > 0 )
			{   document.getElementById(div).innerHTML=xmlhttp.responseText;
				$('#tbl_alum_bloq').datatable({pageSize: 5,sort: [true, true, false],filters: [false, false, false]});
			}
		}
	};
	xmlhttp.open("POST",url,true);
	xmlhttp.send(data);	
}
function alum_bloq_moti_opci_add(div,alum_codi,opc)
{   if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	var data = new FormData();
	data.append('opc', 'alum_moti_bloq_opci_add');
	data.append('alum_codi', alum_codi);
	data.append('moti_bloq_codi', document.getElementById('cmb_motivos').value);
	data.append('opci_codi', document.getElementById('cmb_opciones').value);
	xmlhttp.onreadystatechange=function()
	{   if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{   load_ajax_lista_alum_bloq(div,'script_alum.php',alum_codi,opc);
		}
	};
	xmlhttp.open("POST","script_alum.php",true);
	xmlhttp.send(data);	
}
function alum_bloq_moti_opci_del(div,alum_codi,alum_moti_bloq_opci_codi,opc){
	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	var data = new FormData();
	data.append('opc', 'alum_moti_bloq_opci_del');
	data.append('alum_codi', alum_codi);
	data.append('alum_moti_bloq_opci_codi', alum_moti_bloq_opci_codi);
	xmlhttp.onreadystatechange=function()
	{   if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{   load_ajax_lista_alum_bloq(div,'script_alum.php',alum_codi,opc);
		}
	};
	xmlhttp.open("POST","script_alum.php",true);
	xmlhttp.send(data);	
}
function load_ajax_lista_alum_bloq_matriz( div, url, alum_codi, opc, actual )
{   document.getElementById(div).innerHTML='<div align="center" style="height:100%;"><img src="../imagenes/ajax-loader.gif"/></div>';
	if (window.XMLHttpRequest)
	{	// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp = new XMLHttpRequest();
	}
	else
	{	// code for IE6, IE5
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	var bandera_mora = 0;
	var data = new FormData();
	var sl_estado = document.getElementById('sl_estado');
	data.append('opc', opc);
	data.append('alum_codi', alum_codi);
	xmlhttp.onreadystatechange=function()
	{   if( xmlhttp.readyState === 4 && xmlhttp.status == 200 )
		{   if( xmlhttp.responseText != "No Mora" )
			{   bandera_mora = bandera_mora + 1 ;
				document.getElementById(div).innerHTML = "<br>" + xmlhttp.responseText;
				document.getElementById( 'div_curs' ).innerHTML="";
				$('#tbl_alum_bloq').datatable({pageSize: 5,sort: [true, true, false],filters: [false, false, false]});
			}
			else
			{   document.getElementById(div).innerHTML="";
			}
			if (window.XMLHttpRequest)
			{	// code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttpII = new XMLHttpRequest();
			}
			else
			{	// code for IE6, IE5
				xmlhttpII = new ActiveXObject("Microsoft.XMLHTTP");
			}
			var data2 = new FormData();
			data2.append( 'opc', 'alum_deudaMatricula' );
			data2.append( 'alum_codi', alum_codi );
			xmlhttpII.onreadystatechange=function()
			{   if( xmlhttpII.readyState === 4 && xmlhttpII.status == 200 )
				{   if( xmlhttpII.responseText != "<center>Alumno no tiene deudas financieras pendientes.</center>" )
					{   bandera_mora = bandera_mora + 1 ;
						document.getElementById( 'div_curs' ).innerHTML = "<br>" + xmlhttpII.responseText;
					}
					else
					{   document.getElementById( 'div_curs' ).innerHTML="";
					}
					if( bandera_mora === 0 )
					{   if( actual != sl_estado.options[sl_estado.selectedIndex].innerHTML )
						{	load_ajax('div_curs','cursos_paralelo_main_combo.php','peri_codi=' + document.getElementById('peri_0').value
										+ '&alum_est_peri_codi=' + sl_estado.options[sl_estado.selectedIndex].innerHTML
										+ '&prev_curs_para_codi='  + document.getElementById('prev_curs_para_codi').value
										+ '&prev_alum_est=' + document.getElementById('prev_alum_est').value);
						}
					}
				}
			};
			xmlhttpII.open("POST",url,true);
			xmlhttpII.send(data2);	
		}
	};
	xmlhttp.open("POST",url,true);
	xmlhttp.send(data);	
}
function ValidarAlumno ()
{	if (document.getElementById('alum_nomb').value=='')
	{	$.growl.error({ title: "Educalinks informa",message: "Por favor ingrese los nombres del estudiante." });
		document.getElementById('alum_nomb').style.border='solid 1px red';
		return false;
	}
	else
	{	document.getElementById('alum_nomb').style.border='';
	}
	if (document.getElementById('alum_apel').value=='')
	{	$.growl.error({ title: "Educalinks informa",message: "Por favor ingrese los apellidos del estudiante." });
		document.getElementById('alum_apel').style.border='solid 1px red';
		return false;
	}
	else
	{	document.getElementById('alum_apel').style.border='';
	}
	if (document.getElementById('alum_usua').value=='')
	{	$.growl.error({ title: "Educalinks informa",message: "Por favor ingrese el usuario del estudiante." });
		document.getElementById('alum_usua').style.border='solid 1px red';
		return false;
	}
	else
	{	document.getElementById('alum_usua').style.border='';
	}
	if (document.getElementById('alum_fech_naci').value=='')
	{	$.growl.error({ title: "Educalinks informa",message: "Por favor ingrese la fecha de nacimiento del estudiante." });
		document.getElementById('alum_fech_naci').style.border='solid 1px red';
		return false;
	}
	else
	{	document.getElementById('alum_fech_naci').style.border='';
	}
	if (!document.getElementById('alum_mujer').checked && !document.getElementById('alum_hombre').checked)
	{	$.growl.error({ title: "Educalinks informa",message: "Por favor escoja el género del estudiante del estudiante." });
		return false;
	}
	if (document.getElementById('alum_cedu').value==''){	
	}else{
		var response = validarNI(document.getElementById('alum_cedu').value,document.getElementById('alum_tipo_iden').options[document.getElementById('alum_tipo_iden').selectedIndex].value);
		if(response=="Cédula Correcta" || response=="RUC Correcto" || response=="Pasaporte" ){
			document.getElementById('alum_cedu').style.border='';
		}else{
			$.growl.error({ title: "Educalinks informa",message: response+". Por favor ingrese el número de identificación de acuerdo al tipo correctamente." });
			document.getElementById('alum_cedu').style.border='solid 1px red';
			return false;
		}
	}
	if (document.getElementById('alum_domi').value=='')
	{	$.growl.error({ title: "Educalinks informa",message: "Por favor ingrese el domicilio del estudiante." });
		document.getElementById('alum_domi').style.border='solid 1px red';
		return false;
	}
	else
	{	document.getElementById('alum_domi').style.border='';
	}
	if (document.getElementById('alum_telf').value=='')
	{	$.growl.error({ title: "Educalinks informa",message: "Por favor ingrese el teléfono del estudiante." });
		document.getElementById('alum_telf').style.border='solid 1px red';
		return false;
	}
	else
	{	document.getElementById('alum_telf').style.border='';
	}
	if (document.getElementById('alum_ciud').value=='')
	{	$.growl.error({ title: "Educalinks informa",message: "Por favor ingrese la ciudad de residencia del estudiante." });
		document.getElementById('alum_ciud').style.border='solid 1px red';
		return false;
	}
	else
	{	document.getElementById('alum_ciud').style.border='';
	}
	/*if (document.getElementById('alum_parroq').value=='')
	{	$.growl.error({ title: "Educalinks informa",message: "Por favor ingrese la parroquia de residencia del estudiante." });
		document.getElementById('alum_parroq').style.border='solid 1px red';
		return false;
	}
	else
	{	document.getElementById('alum_parroq').style.border='';
	}*/
	if (document.getElementById('alum_pais').value=='')
	{	$.growl.error({ title: "Educalinks informa",message: "Por favor ingrese la nacionalidad del estudiante." });
		document.getElementById('alum_pais').style.border='solid 1px red';
		return false;
	}
	else
	{	document.getElementById('alum_pais').style.border='';
	}
	if (document.getElementById('alum_nacionalidad').value=='')
	{	$.growl.error({ title: "Educalinks informa",message: "Por favor ingrese la nacionalidad del estudiante." });
		document.getElementById('alum_nacionalidad').style.border='solid 1px red';
		return false;
	}
	else
	{	document.getElementById('alum_nacionalidad').style.border='';
	}
	if (document.getElementById('alum_tipo_sangre').value=='')
	{	$.growl.error({ title: "Educalinks informa",message: "Por favor ingrese el tipo de sangre del estudiante." });
		document.getElementById('alum_tipo_sangre').style.border='solid 1px red';
		return false;
	}
	else
	{	document.getElementById('alum_tipo_sangre').style.border='';
	}
	if (document.getElementById('alum_telf_emerg').value=='')
	{	$.growl.error({ title: "Educalinks informa",message: "Por favor ingrese el teléfono de emergencia del estudiante." });
		document.getElementById('alum_telf_emerg').style.border='solid 1px red';
		return false;
	}
	else
	{	document.getElementById('alum_telf_emerg').style.border='';
	}
	if (document.getElementById('alum_pers_emerg').value=='')
	{	$.growl.error({ title: "Educalinks informa",message: "Por favor ingrese el nombre de contacto de emergencia del estudiante." });
		document.getElementById('alum_pers_emerg').style.border='solid 1px red';
		return false;
	}
	else
	{	document.getElementById('alum_pers_emerg').style.border='';
	}
	if (document.getElementById('alum_resp_form_cedu').value==''){	
	}else{
		var response = validarNI(document.getElementById('alum_resp_form_cedu').value,document.getElementById('alum_resp_form_tipo_iden').options[document.getElementById('alum_resp_form_tipo_iden').selectedIndex].value);
		if(response=="Cédula Correcta" || response=="RUC Correcto" || response=="Pasaporte" ){
			document.getElementById('alum_resp_form_cedu').style.border='';
		}else{
			$.growl.error({ title: "Educalinks informa",message: response+". Por favor ingrese el número de identificación del propietario de la cuenta de acuerdo al tipo correctamente." });
			document.getElementById('alum_resp_form_cedu').style.border='solid 1px red';
			return false;
		}
	}
	return true;
}
function ValidarUsuario()
{	if (document.getElementById('hd_user_verified').value!="1")
	{	$.growl.error({ title: "Educalinks informa",message: "Usuario no válido. Debe ingresar un usuario válido." });	
		document.getElementById('alum_usua').style.border='solid 1px red';
		return false;
	}
	else
	{	document.getElementById('alum_usua').style.border='';
	}
	return true;
}
function carga_dscto(tipo_dscto,alum_codi){
	//document.getElementById('alum_desc_porcentaje').value='<div align="center" style="height:100%;"><img src="../imagenes/ajax-loader.gif"/></div>';
	var data = new FormData();	
	data.append('opc', 'carga_dscto');
	data.append('alum_codi', alum_codi);
	data.append('tipo_dscto', tipo_dscto);
	var xhr = new XMLHttpRequest();
	xhr.open('POST', 'script_alum.php' , true);
	xhr.send(data);
	xhr.onreadystatechange=function(){
		if (xhr.readyState==4 && xhr.status==200){
			document.getElementById('alum_desc_porcentaje').value= xhr.responseText;
		} 
	}
}
function alum_curs_para_info (alum_curs_para_codi)
{	var data = new FormData();	
	data.append('opc', 'alum_curs_para_info');
	data.append('alum_curs_para_codi', alum_curs_para_codi);
	var xhr = new XMLHttpRequest();
	xhr.open('POST', 'script_alum.php' , true);
	xhr.send(data);
	xhr.onreadystatechange=function(){
		if (xhr.readyState==4 && xhr.status==200)
		{	obj = JSON.parse(xhr.responseText);
			if (obj.error == "no")
			{	document.getElementById("estudiante_info").innerHTML = obj.alum_codi+" / "+obj.alum_nomb+" "+obj.alum_apel;
				document.getElementById("curso_actual").innerHTML = obj.curs_deta+" / "+obj.para_deta;
			}
			else
			{	document.getElementById("estudiante_info").innerHTML = obj.mensaje;
			}
		} 
	}
}
function alum_change_course (curs_para_codi,alum_curs_para_codi)
{	var data = new FormData();	
	data.append('opc', 'alum_change_course');
	data.append('alum_curs_para_codi', alum_curs_para_codi);
	data.append('curs_para_codi', curs_para_codi);
	var xhr = new XMLHttpRequest();
	xhr.open('POST', 'script_alum.php' , true);
	xhr.send(data);
	xhr.onreadystatechange=function(){
		if (xhr.readyState==4 && xhr.status==200)
		{	obj = JSON.parse(xhr.responseText);
			if (obj.error == "no")
			{	$.growl.notice({ title: "Educalinks informa:",message: obj.mensaje });
			}
			else
			{	$.growl.error({ title: "Educalinks informa:",message: obj.mensaje });
			}
		} 
	}
}
function BuscarAlumnos(alum_codi,alum_apel,curs_para_codi)
{	 document.getElementById('alum_main').innerHTML='<div align="center" style="height:100%;"><img src="../imagenes/ajax-loader.gif"/> Buscando registros...</div>';
	var data = new FormData();	
	data.append('alum_codi', alum_codi);
	data.append('alum_apel', alum_apel);
	data.append('curs_para_codi', curs_para_codi);
	var xhr = new XMLHttpRequest();
	xhr.open('POST', 'alumnos_main_lista.php' , true);
	xhr.send(data);
	xhr.onreadystatechange=function(){
		if (xhr.readyState==4 && xhr.status==200)
		{	document.getElementById('alum_main').innerHTML=xhr.responseText;
			$(document).ready(function() {
			$('#alum_table').datatable({
				pageSize: 30,
				sort: [true,true, true, false],
				filters: [false,false, false, false],
				filterText: 'Buscar... '
			}) ;
			} ); 
		} 
	}
}
function validarNI(strCedula,tipo_iden)
{	
	if (tipo_iden==3){
			return 'Pasaporte';
	}else if(isNumeric(strCedula))
	{	
		var total_caracteres=strCedula.length;// se suma el total de caracteres
		if(tipo_iden==1)
		{
			if(total_caracteres==10)
			{	//compruebo que tenga 10 digitos la cedula
				var nro_region=strCedula.substring( 0,2);//extraigo los dos primeros caracteres de izq a der
				if(nro_region>=1 && nro_region<=24)
				{	// compruebo a que region pertenece esta cedula//
					var ult_digito=strCedula.substring( total_caracteres-1,total_caracteres);//extraigo el ultimo digito de la cedula
					//extraigo los valores pares//
					var valor2=parseInt(strCedula.charAt(1));
					var valor4=parseInt(strCedula.charAt(3));
					var valor6=parseInt(strCedula.charAt(5));
					var valor8=parseInt(strCedula.charAt(7));
					var suma_pares=(valor2 + valor4 + valor6 + valor8);
					//extraigo los valores impares//
					var valor1=parseInt(strCedula.charAt(0));
					valor1=(valor1 * 2);
					if(valor1>9){ valor1=(valor1 - 9); }else{ }
					var valor3=parseInt(strCedula.charAt(2));
					valor3=(valor3 * 2);
					if(valor3>9){ valor3=(valor3 - 9); }else{ }
					var valor5=parseInt(strCedula.charAt(4));
					valor5=(valor5 * 2);
					if(valor5>9){ valor5=(valor5 - 9); }else{ }
					var valor7=parseInt(strCedula.charAt(6));
					valor7=(valor7 * 2);
					if(valor7>9){ valor7=(valor7 - 9); }else{ }
					var valor9=parseInt(strCedula.charAt(8));
					valor9=(valor9 * 2);
					if(valor9>9){ valor9=(valor9 - 9); }else{ }

					var suma_impares=(valor1 + valor3 + valor5 + valor7 + valor9);
					var suma=(suma_pares + suma_impares);
					var temp=''+suma;
					var dis=parseInt(temp.charAt(0));//extraigo el primer numero de la suma
					var dis=((dis + 1)* 10);//luego ese numero lo multiplico x 10, consiguiendo asi la decena inmediata superior
					var digito=(dis - suma);
					if(digito==10){ digito='0'; }else{ }//si la suma nos resulta 10, el decimo digito es cero
					if (digito==parseInt(ult_digito))
					{	//comparo los digitos final y ultimo
						return "Cédula Correcta";
					}
					else
					{	return "Cédula Incorrecta";
					}
				}else
				{	//echo "Este Nro de Cedula no corresponde a ninguna provincia del ecuador";
					return "Cédula Incorrecta";
				}
				//echo "Es un Numero y tiene el numero correcto de caracteres que es de ".total_caracteres."";

			}else //numero 10
			{	//echo "Es un Numero y tiene solo".total_caracteres;
				return "Cédula Incorrecta";
			}
		} else if (tipo_iden==2)
		{
			if(total_caracteres==13)
			{	//compruebo que tenga 10 digitos la cedula
				var nro_region=strCedula.substring( 0,2);//extraigo los dos primeros caracteres de izq a der
				if(nro_region>=1 && nro_region<=24)
				{	
					var primeros_digitos;
					var array_coeficientes;
					var digito_verificador;
					var valor3 = strCedula.charAt(2);
					if(valor3>=0 && valor3<=5){ //Persona natural
						primeros_digitos = strCedula.substring( 0, 9);
						array_coeficientes = [2, 1, 2, 1, 2, 1, 2, 1, 2];
						digito_verificador = parseInt(strCedula.charAt(9));
						primeros_digitos = primeros_digitos.split("");

						var total = 0;

						primeros_digitos.forEach(function(item,index,arr){
					       var valor_Posicion = ( parseInt(item) * array_coeficientes[index] );
				            if (valor_Posicion >= 10) {
				            	var valor_char = valor_Posicion.toString();
				                valor_char = valor_char.split("");
				                var temp=0;
				                valor_char.forEach(function(item){
				                	temp = temp + parseInt(item);
				                });
				                valor_Posicion = temp;
				            }
				            total = total + valor_Posicion;
						});

				        var residuo =  total % 10;
				        var resultado;
				        if (residuo == 0) {
				            resultado = 0;        
				        } else {
				            resultado = 10 - residuo;
				        }
				        if (resultado != digito_verificador) {
				        	return 'RUC Incorrecto';
				        }else{
				        	return 'RUC Correcto';
				        }
					}else if (valor3==6){ // Entidad Publica
						primeros_digitos = strCedula.substring( 0, 8);
						array_coeficientes = [3, 2, 7, 6, 5, 4, 3, 2];
						digito_verificador = parseInt(strCedula.charAt(8));
						primeros_digitos = primeros_digitos.split("");


						var total = 0;
						primeros_digitos.forEach(function(item,index,arr){
					       var valor_Posicion = ( parseInt(item) * array_coeficientes[index] );
				            total = total + valor_Posicion;
						});

				        var residuo =  total % 11;
				        var resultado;
				        if (residuo == 0) {
				            resultado = 0;        
				        } else {
				            resultado = 11 - residuo;
				        }
				        if (resultado != digito_verificador) {
				        	return 'RUC Incorrecto';
				        }else{
				        	return 'RUC Correcto';
				        }
					}else if (valor3==9){ // Sociedad Privada
						primeros_digitos = strCedula.substring( 0, 9);
						array_coeficientes = [4, 3, 2, 7, 6, 5, 4, 3, 2];
						digito_verificador = parseInt(strCedula.charAt(9));
						primeros_digitos = primeros_digitos.split("");

						var total = 0;
						primeros_digitos.forEach(function(item,index,arr){
					       var valor_Posicion = ( parseInt(item) * array_coeficientes[index] );
				            total = total + valor_Posicion;
						});
				        var residuo =  total % 11;
				        var resultado;
				        if (residuo == 0) {
				            resultado = 0;        
				        } else {
				            resultado = 11 - residuo;
				        }
				        if (resultado != digito_verificador) {
				        	return 'RUC Incorrecto';
				        }else{
				        	return 'RUC Correcto';
				        }
					}else {
						return 'RUC Incorrecto';
					}	
				}else
				{	//echo "Este Nro de RUC no corresponde a ninguna provincia del ecuador";
					return 'RUC Incorrecto';
				}
				//echo "Es un Numero y tiene el numero correcto de caracteres que es de ".$total_caracteres."";

			}else //numero 10
			{	//return "Es un Numero y tiene solo".$total_caracteres;
				return 'RUC Incorrecto';
			}
		}
	}else
	{	return "Esta Cédula o RUC no corresponde a un Nro de Identidad de Ecuador";
		//return "Incorrecto"
	}
	
}
function isNumeric(n) {
  return !isNaN(parseFloat(n)) && isFinite(n);
}