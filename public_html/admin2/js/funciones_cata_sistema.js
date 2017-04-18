function carga_info_cata_sist_edit(cata_codi)
{
	document.getElementById('sl_cata_grup_edi').value=document.getElementById('cata_sist_codi_'+cata_codi).getAttribute('data-cata_padr_codi');
	document.getElementById('cata_desc_edi').value=document.getElementById('cata_sist_codi_'+cata_codi).getAttribute('data-cata_deta');
	document.getElementById('cata_codi_edi').value=cata_codi;
}

function load_ajax_add_cata_sist(div,url,data){
		//document.getElementById(div).innerHTML='';
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
					$.growl.notice({ title: "Listo!",message: "Se guardó correctamente el ítem." });			
				}else{
					$.growl.error({ title: "Atención!",message: "Ocurrió un error al guardar el ítem." });	
				}
				var text="";
				load_ajax_lista('cata_sist_main','cata_sistema_main_lista.php','texto=','main_list','cata_sist_table');
			}
		}
		xmlhttp.open("POST",url,true);
		xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		xmlhttp.send(data);	
}

function load_ajax_upd_para_sist(div,url,data){
		//document.getElementById(div).innerHTML='';
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
					$.growl.notice({ title: "Listo!",message: "Se actualizó el ítem correctamente." });			
				}else{
					$.growl.error({ title: "Atención!",message: "Ocurrió un error al actualizar el ítem." });	
				}
				var text="";
				load_ajax_lista('cata_sist_main','cata_sistema_main_lista.php','texto=','main_list','cata_sist_table');
			}
		}
		xmlhttp.open("POST",url,true);
		xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		xmlhttp.send(data);	
}