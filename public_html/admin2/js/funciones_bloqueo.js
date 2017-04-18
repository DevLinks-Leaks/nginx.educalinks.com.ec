function bloq_mensaje(opc, respuesta)
{
	if (opc=='add' && respuesta == true)
	{
		return 'Se agregó correctamente el bloqueo.';
	}
	if (opc=='add' && respuesta == false)
	{
		return 'Ocurrió un error al agregar el bloqueo.';
	}
	if (opc=='del' && respuesta == true)
	{
		return 'Se quitó correctamente el bloqueo.';
	}
	if (opc=='del' && respuesta == false)
	{
		return 'Ocurrió un error al quitar el bloqueo.';
	}
}
function load_ajax_bloq(div, url, opc, bloq_opci_codi)
{	var data = new FormData()
	data.append('opc', opc);
	data.append('opci_codi', document.getElementById('cmb_opciones').value);
	data.append('bloq_moti_codi', document.getElementById('cmb_motivos').value);
	data.append('bloq_opci_codi', bloq_opci_codi);
	var xhr = new XMLHttpRequest();
	xhr.open('POST', url , true);
	xhr.onreadystatechange=function(){
		if (xhr.readyState==4 && xhr.status==200){
		if (xhr.responseText>0){
				$.growl.notice({ title: "Listo!",message: bloq_mensaje(opc, true) });				
			}else{
				$.growl.error({ title: "Atención!",message: bloq_mensaje(opc, false) });	
			}
			var text="";
			load_ajax_lista_bloq(div,'bloqueo_opcion_main_lista.php','texto=','main_list','bloq_table');
			empty_form();
		} 
	}
	xhr.send(data);
}
function load_ajax_lista_bloq(div,url,data,div_cont,tabla){
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
			$('#'+tabla).datatable({pageSize: 10,sort: [true, true, false],filters: ['select', 'select', false],filterText: 'Escriba para buscar... '});
		}
	}
	xmlhttp.open("POST",url,true);
	xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
	xmlhttp.send(data);	
}