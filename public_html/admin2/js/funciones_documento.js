////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function carga_info_docu_edit(docu_codi){
	document.getElementById('docu_descr_edi').value=document.getElementById('docu_descr_edi_'+docu_codi).value
	document.getElementById('docu_codi_edi').value=document.getElementById('docu_codi_edi_'+docu_codi).value //o docu_codi nomás.
	//Para cargar div de combobox, que en este caso no se usa.
	//load_ajax('div_rol_codi','usuarios_rol_combo.php','rol_codi='+document.getElementById('rol_codi_edi_'+usua_codi).value+'&texto=');
}
function docu_mensaje(opc, respuesta)
{
	if (opc=='add' && respuesta == true)
	{
		return 'Se guardó correctamente los datos del documento.';
	}
	if (opc=='add' && respuesta == false)
	{
		return 'Ocurrió un error al guardar los datos de documento.';
	}
	if (opc=='upd' && respuesta == true)
	{
		return 'Se actualizó correctamente los datos del documento.';
	}
	if (opc=='upd' && respuesta == false)
	{
		return 'Ocurrió un error al actualzar los datos de documento.';
	}
	if (opc=='del' && respuesta == true)
	{
		return 'Se eliminaron correctamente los datos del documento.';
	}
	if (opc=='del' && respuesta == false)
	{
		return 'Ocurrió un error al eliminar los datos del documento.';
	}
	if (opc=='check' && respuesta == true)
	{
		return 'Check.';
	}
	if (opc=='check' && respuesta == false)
	{
		return 'Ocurrió un error al hacer check.';
	}
}
function load_ajax_docu(div, url, opc, docu_descr, peri_codi, docu_codi, docu_peri_codi, check)
{	
	var data = new FormData();
	data.append('opc', opc);
	data.append('docu_descr', docu_descr);
	data.append('peri_codi', peri_codi);
	data.append('docu_codi', docu_codi);
	data.append('docu_peri_codi', docu_peri_codi);
	data.append('check', check);
	var xhr = new XMLHttpRequest();
	xhr.open('POST', url , true);
	xhr.onreadystatechange=function(){
		if (xhr.readyState==4 && xhr.status==200){
		//alert(xhr.responseText);
		if (xhr.responseText>0){
				$.growl.notice({ title: "Listo!",message: docu_mensaje(opc, true) });				
			}else{
				$.growl.error({ title: "Atención!",message: docu_mensaje(opc, false) });	
			}
			var text="";
			load_ajax_lista(div,'documentos_main_lista.php','texto=','main_list','docu_table');
			empty_form();
		} 
	}
	xhr.send(data);
}
function load_ajax_docu_del(div, url, opc, docu_descr, peri_codi, docu_codi, docu_peri_codi, check)
{
	if(confirm("¿Está seguro que desea eliminar el Documento?"))
	{
		load_ajax_docu(div, url, opc, docu_descr, peri_codi, docu_codi, docu_peri_codi, check);
	}
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function empty_form(){
	document.getElementById('docu_descr_nuev').value="";
}