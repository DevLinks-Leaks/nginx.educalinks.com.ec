
function load_ajax_add_alum_bl(div,url,data){
		$('#btn_blacklist_add').button('loading');
		//document.getElementById(div).innerHTML='';
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
				var json = JSON.parse(xmlhttp.responseText);
				if (json.state=="success"){				
					$.growl.notice({ title: "Listo!",message: json.result });				
				}else{
					$.growl.error({ title: "Atención!",message: json.result });	
				}
				$('#btn_blacklist_add').button('reset');
				$('#ModalBlacklistAdd').modal('hide');
			}
		}
		xmlhttp.open("POST",url,true);
		xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		xmlhttp.send(data);	
	}

	function load_ajax_edit_alum_bl(div,url,data,flag){
		$('#btn_blacklist_save').button('loading');
		if(flag)
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
				var json = JSON.parse(xmlhttp.responseText);
				if (json.state=="success"){				
					$.growl.notice({ title: "Listo!",message: json.result });				
				}else{
					$.growl.error({ title: "Atención!",message: json.result });	
				}
				$('#btn_blacklist_save').button('reset');
            	
            	if(flag){
            		var text="";
            		$('#ModalBlacklistAdd').modal('hide'); 
            		load_ajax_lista('blacklist_main','alumnos_blacklist_main_lista.php','texto=','main_list','alum_table');
            	}else
            		$('#BlacklistEdit').modal('hide');
            }
        }
        xmlhttp.open("POST",url,true);
        xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
        xmlhttp.send(data);	
    }

    function load_ajax_del_alum_bl(div,url,data){
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
				var json = JSON.parse(xmlhttp.responseText);
				if (json.state=="success"){				
					$.growl.notice({ title: "Listo!",message: json.result });				
				}else{
					$.growl.error({ title: "Atención!",message: json.result });	
				}
				var text="";
				load_ajax_lista('blacklist_main','alumnos_blacklist_main_lista.php','texto=','main_list','alum_table');
			}
		}
		xmlhttp.open("POST",url,true);
		xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		xmlhttp.send(data);	
	}
}

function load_ajax_blacklist_aviso( div, url, alum_codi, opc )
{   document.getElementById(div).innerHTML='<div align="center" style="height:100%;"><img src="../imagenes/ajax-loader.gif"/></div>';
if (window.XMLHttpRequest)
	{	// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp_bl = new XMLHttpRequest();
	}
	else
	{	// code for IE6, IE5
		xmlhttp_bl = new ActiveXObject("Microsoft.XMLHTTP");
	}
	var data_bl = new FormData();
	data_bl.append('opc', opc);
	data_bl.append('alum_codi', alum_codi);
	xmlhttp_bl.onreadystatechange=function()
	{   if( xmlhttp_bl.readyState === 4 && xmlhttp_bl.status == 200 )
		{   if( xmlhttp_bl.responseText != "" )
		{   
			document.getElementById(div).innerHTML = '<br/>' + xmlhttp_bl.responseText;
			document.getElementById( 'div_curs' ).innerHTML="";
		}
		else
			{   document.getElementById(div).innerHTML="";
	}	
}
};
xmlhttp_bl.open("POST",url,true);
xmlhttp_bl.send(data_bl);	
}

function load_ajax_blacklist_warning( div, url, opc )
{   document.getElementById(div).innerHTML='<div align="center" style="height:100%;"><img src="../imagenes/ajax-loader.gif"/></div>';
if (window.XMLHttpRequest)
	{	// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp_bl = new XMLHttpRequest();
	}
	else
	{	// code for IE6, IE5
		xmlhttp_bl = new ActiveXObject("Microsoft.XMLHTTP");
	}
	var data_bl = new FormData();
	data_bl.append('opc', opc);
	data_bl.append('alum_nomb', document.getElementById('alum_nomb').value);
	data_bl.append('alum_apel', document.getElementById('alum_apel').value);
	xmlhttp_bl.onreadystatechange=function()
	{   if( xmlhttp_bl.readyState === 4 && xmlhttp_bl.status == 200 )
		{   if( xmlhttp_bl.responseText != "" )
		{   
			document.getElementById(div).innerHTML = xmlhttp_bl.responseText;
		}
		else
			{   document.getElementById(div).innerHTML="";
	}	
}
};
xmlhttp_bl.open("POST",url,true);
xmlhttp_bl.send(data_bl);	
}

function load_ajax_blacklist_warning_repr( div, url, opc )
{   document.getElementById(div).innerHTML='<div align="center" style="height:100%;"><img src="../imagenes/ajax-loader.gif"/></div>';
if (window.XMLHttpRequest)
	{	// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp_bl_repr = new XMLHttpRequest();
	}
	else
	{	// code for IE6, IE5
		xmlhttp_bl_repr = new ActiveXObject("Microsoft.XMLHTTP");
	}
	var data_bl_repr = new FormData();
	data_bl_repr.append('opc', opc);
	data_bl_repr.append('repr_cedu', document.getElementById('repr_cedula').value);
	xmlhttp_bl_repr.onreadystatechange=function()
	{   if( xmlhttp_bl_repr.readyState === 4 && xmlhttp_bl_repr.status == 200 )
		{   if( xmlhttp_bl_repr.responseText != "" )
		{   
			document.getElementById(div).innerHTML = xmlhttp_bl_repr.responseText;
		}
		else
			{   document.getElementById(div).innerHTML="";
	}	
}
};
xmlhttp_bl_repr.open("POST",url,true);
xmlhttp_bl_repr.send(data_bl_repr);	
}