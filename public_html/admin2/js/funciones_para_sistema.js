function carga_info_para_sist_edit(para_codi){
	document.getElementById('para_codi_edi').value=document.getElementById('para_sist_codi_'+para_codi).getAttribute('data-para_sist_codi');
	document.getElementById('para_valo_edi').value=document.getElementById('para_sist_codi_'+para_codi).getAttribute('data-para_sist_valo');
	document.getElementById('para_deta_edi').value=document.getElementById('para_sist_codi_'+para_codi).getAttribute('data-para_sist_deta');
}

function load_ajax_edi_para_sist(div,url,data){
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
					$.growl.notice({ title: "Listo!",message: "Se actualizaron correctamente los parámetros." });			
				}else{
					$.growl.error({ title: "Atención!",message: "Ocurrió un error al actualizar los parámetros del sistema." });	
				}
				var text="";
				load_ajax_lista('para_sist_main','para_sistema_main_lista.php','texto=','main_list','para_sist_table');
			}
		}
		xmlhttp.open("POST",url,true);
		xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		xmlhttp.send(data);	
}