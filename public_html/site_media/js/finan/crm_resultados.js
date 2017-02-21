// JavaScript Document
$(document).ready(function() {
	actualiza_badge_gest_fact();
	$('#resul_table').addClass( 'nowrap' ).DataTable({
		lengthChange: true, 
		responsive: true, 
		searching: false,  
		orderClasses: true, 
		paging:false,
		"scrollX": '100%',
		language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'},
		"columnDefs": [
			{className: "dt-body-center" , "targets": [0]},
			{className: "dt-body-center" , "targets": [1]},
			{className: "dt-body-center" , "targets": [2]},
			{className: "dt-body-center" , "targets": [3]}
		]
	});
});
function busca(busq,div,url){
	document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var data = new FormData();
	data.append('event', 'get_all_data');
	data.append('busq', busq);	
	var xhr = new XMLHttpRequest();
	xhr.open('POST', url , true);
	xhr.onreadystatechange=function(){
		if (xhr.readyState==4 && xhr.status==200)
		{	document.getElementById(div).innerHTML=xhr.responseText;
			$('#resul_table').addClass( 'nowrap' ).DataTable({
				lengthChange: true, 
				responsive: true, 
				searching: false,  
				orderClasses: true, 
				paging:false,
				"scrollX": '100%',
				language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'},
				"columnDefs": [
					{className: "dt-body-center" , "targets": [0]},
					{className: "dt-body-center" , "targets": [1]},
					{className: "dt-body-center" , "targets": [2]},
					{className: "dt-body-center" , "targets": [3]}
				]
			});
		} 
	}
	xhr.send(data);
}
function busca_detalles(codigo,div,url){
	document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var data = new FormData();
	data.append('event', 'get_all_detalles');
	data.append('crm_resu_codigo', codigo);
	var xhr = new XMLHttpRequest();
	xhr.open('POST', url , true);
	xhr.onreadystatechange=function(){
		if (xhr.readyState==4 && xhr.status==200)
		{	document.getElementById(div).innerHTML=xhr.responseText;
			$('#resul_table_deta').addClass( 'nowrap' ).DataTable({
				lengthChange: true, 
				responsive: true, 
				searching: false,  
				orderClasses: true, 
				paging:false,
				language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'},
				bInfo : false,
				"scrollX": '100%',
				"columnDefs": [
					{className: "dt-body-center" , "targets": [0]},
					{className: "dt-body-left"   , "targets": [1]},
					{className: "dt-body-center" , "targets": [2]}
				]
			});
		} 
	}
	xhr.send(data);
}
function del(codigo,div,url){
	if(confirm("¿Está seguro que desea eliminar el resultado?")){
		document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
		var data = new FormData();
		data.append('event', 'delete');
		data.append('crm_resu_codigo', codigo);	
		var xhr = new XMLHttpRequest();
		xhr.open('POST', url , true);
		xhr.onreadystatechange=function(){
			if (xhr.readyState==4 && xhr.status==200){
				busca("",div,url)
				$.growl.notice({ title: "Educalinks informa", message: "'Detalle de llamada' eliminado correctamente." });
			}
		}
		xhr.send(data);
	}else
	{
		return false;
	}
}
function del_deta(codigo,div,url){
	if(confirm("¿Está seguro que desea eliminar el detalle del resultado?")){
		document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
		var data = new FormData();
		data.append('event', 'del_asign');
		data.append('deta_crm_resu_codigo', codigo);	
		var xhr = new XMLHttpRequest();
		xhr.open('POST', url , true);
		xhr.onreadystatechange=function(){
			if (xhr.readyState==4 && xhr.status==200){
				busca_detalles(document.getElementById('crm_resu_codigo').value,div,url)
				$.growl.notice({ title: "Educalinks informa", message: "Detalle eliminado correctamente." });
			} 
		}
		xhr.send(data);
	}
}
function edit(codigo,div,url){
	document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var data = new FormData();
	data.append('event', 'get');
	data.append('crm_resu_codigo', codigo);	
	var xhr = new XMLHttpRequest();
	xhr.open('POST', url , true);
	xhr.onreadystatechange=function(){
		if (xhr.readyState==4 && xhr.status==200){
			document.getElementById(div).innerHTML=xhr.responseText;
		} 
	}
	xhr.send(data);
}
function carga_add(div,url){
	document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var data = new FormData();
	data.append('event', 'agregar');	
	var xhr = new XMLHttpRequest();
	xhr.open('POST', url , true);
	xhr.onreadystatechange=function(){
		if (xhr.readyState==4 && xhr.status==200){
			document.getElementById(div).innerHTML=xhr.responseText;
		} 
	}
	xhr.send(data);
}
function asign(codigo,div,url){
	document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var data = new FormData();
	data.append('event', 'asignar');
	data.append('codigo', codigo);
	var xhr = new XMLHttpRequest();
	xhr.open('POST', url , true);
	xhr.onreadystatechange=function(){
		if (xhr.readyState==4 && xhr.status==200){
			document.getElementById(div).innerHTML=xhr.responseText;	
			document.getElementById('crm_resu_codigo').value=codigo;	
			document.getElementById('deta_descripcion_add').focus();
			busca_detalles(codigo,"resultado_detalles",url);
			
		} 
	}
	xhr.send(data);
}
function asign_deta(codigo,div,url){
	document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var data = new FormData();
	data.append('event', 'asign');	
	data.append('crm_resu_codigo',codigo);
	data.append('deta_crm_resu_descripcion',document.getElementById('deta_descripcion_add').value);
	var xhr = new XMLHttpRequest();
	xhr.open('POST', url , true);
	xhr.onreadystatechange=function(){
		if (xhr.readyState==4 && xhr.status==200){
			document.getElementById(div).innerHTML=xhr.responseText;		
			busca_detalles(codigo,"resultado_detalles",url);
			document.getElementById('deta_descripcion_add').value="";
			document.getElementById('deta_descripcion_add').focus();
			$.growl.notice({ title: "Educalinks informa", message: "Detalle asignado correctamente." });
		}
	}
	xhr.send(data);
}
function add(div,url){
	document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var data = new FormData();
	data.append('event', 'set');
	data.append('crm_resu_descripcion', document.getElementById('descripcion_add').value);
	data.append('crm_resu_estado', 'A');
	var xhr = new XMLHttpRequest();
	xhr.open('POST', url , true);
	xhr.onreadystatechange=function(){
		if (xhr.readyState==4 && xhr.status==200){
			busca("",div,url)
		} 
	}
	xhr.send(data);
}
function save_edited(codigo,div,url){
	if(confirm("¿Está seguro que desea editar la información del resultado?")){
		document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
		var data = new FormData();
		data.append('event', 'edit');
		data.append('crm_resu_codigo', document.getElementById('codigo_mod').value);
		data.append('crm_resu_descripcion', document.getElementById('descripcion_mod').value);
		data.append('crm_resu_estado', 'A');
		
		var xhr = new XMLHttpRequest();
		xhr.open('POST', url , true);
		xhr.onreadystatechange=function(){
			if (xhr.readyState==4 && xhr.status==200){
				busca("",div,url)
				$.growl.notice({ title: "Educalinks informa", message: "Cambios guardados correctamente." });
			} 
		}
		xhr.send(data);
	}
}
