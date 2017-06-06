
function carga_info_usua_edit(usua_codi){
	document.getElementById('usua_nombre_edi').value=document.getElementById('usua_nombre_edi_'+usua_codi).value
	document.getElementById('usua_apellido_edi').value=document.getElementById('usua_apellido_edi_'+usua_codi).value
	document.getElementById('usua_email_edi').value=document.getElementById('usua_email_edi_'+usua_codi).value
	document.getElementById('usua_username_edi').value=document.getElementById('usua_username_edi_'+usua_codi).value
	document.getElementById('usua_tipo_edi').value=document.getElementById('usua_tipo_edi_'+usua_codi).value
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
					$('#ModalUsuaEdi').modal('hide');
				}else{
					$.growl.error({ title: "Atención!",message: "Ocurrió un error al grabar los datos del usuario." });	
				}
				var text="";
				empty_form();
				load_ajax_lista_reset('usua_main','reset_pass_main.php','texto=','main_list','usua_table');
				
			}
		}
		xmlhttp.open("POST",url,true);
		xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		xmlhttp.send(data);	
}
function load_ajax_lista_reset(div,url,data,div_cont,tabla){
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
			$('#'+tabla).DataTable({
				language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'},
				 	"bSort": false 
			});
		}
	}
	xmlhttp.open("POST",url,true);
	xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
	xmlhttp.send(data);	
}
function empty_form(){
	document.getElementById('usua_nombre_edi').value="";
	document.getElementById('usua_apellido_edi').value="";
	document.getElementById('usua_email_edi').value="";
	document.getElementById('usua_username_edi').value="";
	document.getElementById('usua_tipo_edi').value="";
	document.getElementById('usua_pass_edi').value="";
}