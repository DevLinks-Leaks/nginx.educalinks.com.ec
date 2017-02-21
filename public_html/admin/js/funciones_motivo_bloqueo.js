function moti_mensaje(opc, respuesta)
{	if (opc=='add' && respuesta == true)
	{
		return 'Se agregó correctamente el motivo.';
	}
	if (opc=='add' && respuesta == false)
	{
		return 'Ocurrió un error al agregar el motivo.';
	}
	if (opc=='upd' && respuesta == true)
	{
		return 'Se modificó correctamente el motivo.';
	}
	if (opc=='upd' && respuesta == false)
	{
		return 'Ocurrió un error al modificar el motivo.';
	}
	if (opc=='del' && respuesta == true)
	{
		return 'Se quitó correctamente el motivo.';
	}
	if (opc=='del' && respuesta == false)
	{
		return 'Ocurrió un error al quitar el motivo.';
	}
}
function load_ajax_moti(div, url, opc, moti_bloq_codi)
{	var data = new FormData()
	data.append('opc', opc);
	if (opc=='add')
	{	data.append('moti_bloq_deta', document.getElementById('txt_motivo').value);
		data.append('moti_bloq_obli', document.getElementById('check_obligatorio').checked);
	}
	if (opc=='upd')
	{	data.append('moti_bloq_deta', document.getElementById('txt_moti_bloq_deta').value);
		data.append('moti_bloq_obli', document.getElementById('check_moti_bloq_obli').checked);
	}
	data.append('moti_bloq_codi', moti_bloq_codi);
	var xhr = new XMLHttpRequest();
	xhr.open('POST', url , true);
	xhr.onreadystatechange=function(){
		if (xhr.readyState==4 && xhr.status==200){
		if (xhr.responseText>0){
				$.growl.notice({ title: "Listo!",message: moti_mensaje(opc, true) });				
			}else{
				$.growl.error({ title: "Atención!",message: moti_mensaje(opc, false) });	
			}
			var text="";
			load_ajax_lista_moti(div,'motivo_bloqueo_main_lista.php','texto=','main_list','moti_table');
			empty_form();
		} 
	}
	xhr.send(data);
}
function load_ajax_lista_moti(div,url,data,div_cont,tabla){
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
			$('#'+tabla).datatable({pageSize: 10,sort: [true, true, false],filters: [true, false, false],filterText: 'Escriba para buscar... '});
		}
	}
	xmlhttp.open("POST",url,true);
	xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
	xmlhttp.send(data);	
}
function show_edit (moti_bloq_codi)
{	document.getElementById('txt_moti_bloq_deta').value = document.getElementById('moti_bloq_deta_'+moti_bloq_codi).value;
	document.getElementById('check_moti_bloq_obli').checked = (document.getElementById('moti_bloq_obli_'+moti_bloq_codi).value=='true'?true:false);
	document.getElementById('txt_moti_bloq_codi').value = moti_bloq_codi;
}