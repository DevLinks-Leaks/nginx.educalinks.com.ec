function load_ajax_veri_usua(div,url,data){
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
			if(xmlhttp.responseText=="<img src='../imagenes/butones/green_check.png' />"){
				document.getElementById('usua_veri_username').value="OK";	
			}else{
				document.getElementById('usua_veri_username').value="KO";
			}
		}
	}
	xmlhttp.open("POST",url,true);
	xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
	xmlhttp.send(data);	
}
function carga_info_usua_edit(usua_codi){
	document.getElementById('usua_nombre_edi').value=document.getElementById('usua_nombre_edi_'+usua_codi).value
	document.getElementById('usua_apellido_edi').value=document.getElementById('usua_apellido_edi_'+usua_codi).value
	document.getElementById('usua_email_edi').value=document.getElementById('usua_email_edi_'+usua_codi).value
	document.getElementById('usua_username_edi').value=document.getElementById('usua_username_edi_'+usua_codi).value
	load_ajax('div_rol_codi_edi','usuarios_rol_combo.php','rol_codi='+document.getElementById('rol_codi_edi_'+usua_codi).value+'&texto=');
}
function carga_info_rol_edit(rol_codi){
	document.getElementById('rol_deta_edi').value=document.getElementById('rol_deta_edi_'+rol_codi).value
	document.getElementById('rol_codi_edi').value=document.getElementById('rol_codi_edi_'+rol_codi).value
	document.getElementById('rol_finan_edi').checked=document.getElementById('rol_finan_edi_'+rol_codi).value
}
function load_ajax_add_usua(div,url,data){
	//document.getElementById(div).innerHTML='<div align="center" style="height:100%;"><img src="../imagenes/ajax-loader.gif"/></div>';
	if(document.getElementById('usua_veri_username').value=="OK"){		
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
					$.growl.notice({ title: "Listo!",message: "Se guardaron correctamente los datos del usuario." });				
				}else{
					$.growl.error({ title: "Atención!",message: "Ocurrió un error al grabar los datos del usuario." });	
				}
				var text="";
				load_ajax_lista('usua_main','usuarios_main_lista.php','texto=','main_list','usua_table');
				empty_form();
			}
		}
		xmlhttp.open("POST",url,true);
		xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		xmlhttp.send(data);	
	}else{
		alert("El Nombre de Usuario ya existe, por favor escoja uno nuevo.");
		document.getElementById('usua_username').focus();
	}
}
function load_ajax_edi_usua(div,url,data){
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
				if (xmlhttp.responseText>0){				
					$.growl.notice({ title: "Listo!",message: "Se guardaron correctamente los datos del usuario." });			
				}else{
					$.growl.error({ title: "Atención!",message: "Ocurrió un error al grabar los datos del usuario." });	
				}
				var text="";
				load_ajax_lista('usua_main','usuarios_main_lista.php','texto=','main_list','usua_table');
				empty_form(); 
			}
		}
		xmlhttp.open("POST",url,true);
		xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		xmlhttp.send(data);	
}

function load_ajax_del_usua(div,url,data){
	//document.getElementById(div).innerHTML='<div align="center" style="height:100%;"><img src="../imagenes/ajax-loader.gif"/></div>';
	if(confirm("¿Está seguro que desea eliminar la información del usuario?")){
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
					$.growl.notice({ title: "Listo!",message: "Se eliminaron correctamente los datos del usuario." });				
				}else{
					$.growl.error({ title: "Atención!",message: "Ocurrió un error al eliminaron los datos del usuario." });	
				}
				var text="";
				load_ajax_lista('usua_main','usuarios_main_lista.php','texto=','main_list','usua_table');
			}
		}
		xmlhttp.open("POST",url,true);
		xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		xmlhttp.send(data);	
	}
}
function load_ajax_add_rol(div,url,data){
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
			if (xmlhttp.responseText>0){				
				$.growl.notice({ title: "Listo!",message: "Se guardaron correctamente los datos del rol." });				
			}else{
				$.growl.error({ title: "Atención!",message: "Ocurrió un error al grabar los datos del rol." });	
			}
			var text="";
			load_ajax_lista('rol_main','roles_main_lista.php','texto=','main_list','rol_table');
			empty_form_rol();
		}
	}
	xmlhttp.open("POST",url,true);
	xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
	xmlhttp.send(data);	
}
function load_ajax_edi_rol(div,url,data){
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
				if (xmlhttp.responseText>0){				
					$.growl.notice({ title: "Listo!",message: "Se guardaron correctamente los datos del rol." });				
				}else{
					$.growl.error({ title: "Atención!",message: "Ocurrió un error al grabar los datos del rol." });	
				}
				var text="";
				load_ajax_lista('rol_main','roles_main_lista.php','texto=','main_list','rol_table');
				empty_form_rol();
			}
		}
		xmlhttp.open("POST",url,true);
		xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		xmlhttp.send(data);	
}

function load_ajax_del_rol(div,url,data){
	//document.getElementById(div).innerHTML='<div align="center" style="height:100%;"><img src="../imagenes/ajax-loader.gif"/></div>';
	if(confirm("¿Está seguro que desea eliminar la información del rol de usuario?")){
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
					$.growl.notice({ title: "Listo!",message: "Se eliminaron correctamente los datos del rol." });				
				}else{
					$.growl.error({ title: "Atención!",message: "Ocurrió un error al eliminaron los datos del rol." });	
				}
				var text="";
				load_ajax_lista('rol_main','roles_main_lista.php','texto=','main_list','rol_table');
			}
		}
		xmlhttp.open("POST",url,true);
		xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		xmlhttp.send(data);	
	}
}
function empty_form(){
	document.getElementById('usua_nombre').value="";
	document.getElementById('usua_apellido').value="";
	document.getElementById('usua_email').value="";
	document.getElementById('usua_username').value="";
	document.getElementById('div_veri_usua').innerHTML="";
}
function empty_form_rol(){
	document.getElementById('rol_deta').value="";
}