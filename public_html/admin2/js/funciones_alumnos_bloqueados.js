function carga_info_alum_edit(alum_codi){
	document.getElementById('alum_nomb_edi').value=document.getElementById('alum_nombre_edi_'+alum_codi).value;
	document.getElementById('alum_apel_edi').value=document.getElementById('alum_apellido_edi_'+alum_codi).value;
	document.getElementById('alum_cedu_edi').value=document.getElementById('alum_cedu_edi_'+alum_codi).value;
	document.getElementById('alum_obse_edi').value=document.getElementById('alum_obse_edi_'+alum_codi).value;
	document.getElementById('alum_codi_edi').value=alum_codi;
}

function load_ajax_add_alum(div,url,data){	
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
				if (xmlhttp.responseText>0){				
					$.growl.notice({ title: "Listo!",message: "Se guardaron correctamente los datos del alumno." });				
				}else{
					$.growl.error({ title: "Atención!",message: "Ocurrió un error al grabar los datos del alumno." });	
				}
				var text="";
				load_ajax_lista('alum_main','alumnos_bloqueados_main_lista.php','texto=','main_list','alum_table');
			}
		}
		xmlhttp.open("POST",url,true);
		xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		xmlhttp.send(data);	
}

function load_ajax_edi_alum(div,url,data){
		document.getElementById(div).innerHTML='';
		if (window.XMLHttpRequest)
		{// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		}
		else
		{// code for IEgmail6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=function()
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200){
				if (xmlhttp.responseText>0){				
					$.growl.notice({ title: "Listo!",message: "Se guardaron correctamente los datos del alumno." });			
				}else{
					$.growl.error({ title: "Atención!",message: "Ocurrió un error al grabar los datos del alumno." });	
				}
				var text="";
				load_ajax_lista('alum_main','alumnos_bloqueados_main_lista.php','texto=','main_list','alum_table');
			}
		}
		xmlhttp.open("POST",url,true);
		xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		xmlhttp.send(data);	
}

function load_ajax_del_alum(div,url,data){
	if(confirm("¿Está seguro que desea eliminar la información del alumno?")){
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
				if (xmlhttp.responseText!=""){				
					$.growl.notice({ title: "Listo!",message: "Se eliminaron correctamente los datos del alumno." });				
				}else{
					$.growl.error({ title: "Atención!",message: "Ocurrió un error al eliminaron los datos del alumno." });	
				}
				var text="";
				load_ajax_lista('alum_main','alumnos_bloqueados_main_lista.php','texto=','main_list','alum_table');
			}
		}
		xmlhttp.open("POST",url,true);
		xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		xmlhttp.send(data);	
	}
}
