////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function carga_info_alum_est_edit(alum_est_codi){
	document.getElementById('alum_est_det_edi').value=document.getElementById('alum_est_det_edi_'+alum_est_codi).value
	document.getElementById('alum_est_codi_edi').value=document.getElementById('alum_est_codi_edi_'+alum_est_codi).value //o alum_est_codi nomás.
	//Para cargar div de combobox, que en este caso no se usa.
	//load_ajax('div_rol_codi','usuarios_rol_combo.php','rol_codi='+document.getElementById('rol_codi_edi_'+usua_codi).value+'&texto=');
}
function alum_est_mensaje(opc, respuesta)
{
	if (opc=='add' && respuesta == true)
	{
		return 'Se guardó correctamente el estado.';
	}
	if (opc=='add' && respuesta == false)
	{
		return 'Ocurrió un error al guardar el estado.';
	}
	if (opc=='upd' && respuesta == true)
	{
		return 'Se actualizó el estado.';
	}
	if (opc=='upd' && respuesta == false)
	{
		return 'Ocurrió un error al actualzar el estado.';
	}
	if (opc=='del' && respuesta == true)
	{
		return 'Se eliminó.';
	}
	if (opc=='del' && respuesta == false)
	{
		return 'Ocurrió un error al eliminar el estado.';
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
function load_ajax_alum_est(div, url, opc, alum_est_det, peri_codi, alum_est_codi, alum_est_peri_codi, check)
{	
	var data = new FormData();
	data.append('opc', opc);
	data.append('alum_est_det', alum_est_det);
	data.append('peri_codi', peri_codi);
	data.append('alum_est_codi', alum_est_codi);
	data.append('alum_est_peri_codi', alum_est_peri_codi);
	data.append('check', check);
	var xhr = new XMLHttpRequest();
	xhr.open('POST', url , true);
	xhr.onreadystatechange=function(){
		if (xhr.readyState==4 && xhr.status==200){
		//alert(xhr.responseText);
		if (xhr.responseText>0){
				$.growl.notice({ title: "Listo!",message: alum_est_mensaje(opc, true) });				
			}else{
				$.growl.error({ title: "Atención!",message: alum_est_mensaje(opc, false) });	
			}
			var text="";
			load_ajax_lista(div,'alumno_estado_main_lista.php','texto=','main_list','alum_est_table');
			empty_form();
		} 
	}
	xhr.send(data);
}
function load_ajax_alum_est_del(div, url, opc, alum_est_det, peri_codi, alum_est_codi, alum_est_peri_codi, check)
{
	if(confirm("¿Está seguro que desea eliminar el estado?"))
	{
		load_ajax_alum_est(div, url, opc, alum_est_det, peri_codi, alum_est_codi, alum_est_peri_codi, check)
	}
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function empty_form(){
	document.getElementById('alum_est_det_nuev').value="";
}