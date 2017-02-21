$(document).ready(function() 
{   $('#tarjetaCredito').addClass( 'nowrap' ).DataTable({
		lengthChange: false, 
		responsive: true, 
		searching: true,  
		orderClasses: true, 
		paging:true,
		bInfo:false,
		language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'},
		"columnDefs": [
			{className: "dt-body-center"  , "targets": [0]},
			{className: "dt-body-left"  , "targets": [1]},
			{className: "dt-body-left"   , "targets": [2]},
			{className: "dt-body-center"  , "targets": [3]}
		]
	});
	var table = $('#tarjetaCredito').DataTable();
	table.column( '1:visible' ).order( 'desc' );
});
function js_tarjetaCredito_busca( busq, div, url )
{   document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var data = new FormData();
	data.append('event', 'get_all_data');
	data.append('busq', busq);	
	var xhr = new XMLHttpRequest();
	xhr.open('POST', url , true);
	xhr.onreadystatechange=function()
	{   if (xhr.readyState==4 && xhr.status==200)
		{   document.getElementById(div).innerHTML = xhr.responseText;
			$('#tarjetaCredito').addClass( 'nowrap' ).DataTable({
				lengthChange: false, 
				responsive: true, 
				searching: true,  
				orderClasses: true,
				paging:true,
				language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'}
			});
		}
	};
	xhr.send(data);
}
function js_tarjetaCredito_del(codigo, div, url )
{   if(confirm("¿Está seguro que desea eliminar la tarjeta de crédito?"))
	{   document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
		var data = new FormData();
		data.append('event', 'delete');
		data.append('tarjeta_codigo', codigo);	
		var xhr = new XMLHttpRequest();
		xhr.open('POST', url , true);
		xhr.onreadystatechange=function(){
			if (xhr.readyState==4 && xhr.status==200)
			{	document.getElementById(div).innerHTML = xhr.responseText;
				$('#tarjetaCredito').addClass( 'nowrap' ).DataTable({
					lengthChange: false,
					responsive: true,
					searching: true,
					orderClasses: true,
					paging:true,
					language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'}
				});
			}
		};
		xhr.send(data);
	}
}
function js_tarjetaCredito_edit( codigo, div, url )
{   document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var data = new FormData();
	data.append('event', 'get');
	data.append('tarjeta_codigo', codigo);	
	var xhr = new XMLHttpRequest();
	xhr.open('POST', url , true);
	xhr.onreadystatechange=function()
	{   if (xhr.readyState==4 && xhr.status==200)
		{  document.getElementById(div).innerHTML=xhr.responseText;
			$('[data-toggle="popover"]').popover({html:true});
		} 
	};
	xhr.send(data);
}
function js_tarjetaCredito_carga_add( div, url )
{   document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var data = new FormData();
	data.append('event', 'agregar');	
	var xhr = new XMLHttpRequest();
	xhr.open('POST', url , true);
	xhr.onreadystatechange=function()
	{   if (xhr.readyState==4 && xhr.status==200)
		{   document.getElementById(div).innerHTML=xhr.responseText;
			$('[data-toggle="popover"]').popover({html:true});
		}
	};
	xhr.send(data);
}
function asign(codigo,div,url){
	document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var data = new FormData();
	data.append('event', 'asignar');	
	var xhr = new XMLHttpRequest();
	xhr.open('POST', url , true);
	xhr.onreadystatechange=function(){
		if (xhr.readyState==4 && xhr.status==200){
			document.getElementById(div).innerHTML=xhr.responseText;
			document.getElementById('puntVent_codigo').value=codigo;
			$('#pto_emision_table_users').datatable({
				pageSize: 4,
				sort: [true,true, true, false],
				filters: [false,true,false,false],
				filterText: 'Buscar... '
			}) ;
			show_asigned(codigo,'modal_asign_footer',url);
		} 
	}
	xhr.send(data);
}
function asign_user(codigo,div,url){
	document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var data = new FormData();
	data.append('event', 'asign');
	data.append('usua_codigo', codigo);
	data.append('puntVent_codigo', document.getElementById('puntVent_codigo').value);	
	var xhr = new XMLHttpRequest();
	xhr.open('POST', url , true);
	xhr.onreadystatechange=function(){
		if (xhr.readyState==4 && xhr.status==200){
			document.getElementById(div).innerHTML=xhr.responseText;
			$('#pto_emision_table_users').datatable({
				pageSize: 4,
				sort: [true,true, true, false],
				filters: [false,true,false,false],
				filterText: 'Buscar... '
			}) ;
			show_asigned(document.getElementById('puntVent_codigo').value,'modal_asign_footer',url);
		} 
	}
	xhr.send(data);
}
function del_user_asigned(codigo,div,url){
	if(confirm("¿Está seguro de eliminar el usuario al punto de emisión?")){
		document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
		var data = new FormData();
		data.append('event', 'del_asign');
		data.append('usuaPvta_codigo', codigo);
		var xhr = new XMLHttpRequest();
		xhr.open('POST', url , true);
		xhr.onreadystatechange=function(){
			if (xhr.readyState==4 && xhr.status==200){
				show_asigned(document.getElementById('puntVent_codigo').value,'modal_asign_footer',url);
			}
		}
		xhr.send(data);
	}
}
function show_asigned(codigo,div,url){
	document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var data = new FormData();
	data.append('event', 'asignados');
	data.append('puntVent_codigo', codigo);	
	var xhr = new XMLHttpRequest();
	xhr.open('POST', url , true);
	xhr.onreadystatechange=function(){
		if (xhr.readyState==4 && xhr.status==200){
			document.getElementById(div).innerHTML=xhr.responseText;
			$('#pto_emision_table_users_asigned').datatable({
				pageSize: 4,
				sort: [false,true, true, false],
				filters: [false,false,true,false],
				filterText: 'Buscar... '
			}) ;
		} 
	}
	xhr.send(data);
}
function js_tarjetaCredito_add( div, url )
{   document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var data = new FormData();
	data.append('event', 'set');
	data.append('tarjCred_nombre', document.getElementById('tarjetaCredito_add').value);
	data.append('tarjCred_bancod', document.getElementById('bancos_add').value);
	data.append('es_internacional', document.getElementById('cmb_esInternacional_add').value);
	var xhr = new XMLHttpRequest();
	xhr.open('POST', url , true);
	xhr.onreadystatechange=function()
	{   if (xhr.readyState==4 && xhr.status==200)
		{   js_tarjetaCredito_busca( "",div, url );
		} 
	};
	xhr.send(data);
}
function js_tarjetaCredito_save_edited( rol_codigo, div, url )
{   if(confirm("¿Está seguro que desea editar la información de la Tarjeta de Crédito?"))
	{   document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
		var data = new FormData();
		data.append('event', 'edit');
		data.append('tarjCred_codigo', document.getElementById('tarjeta_codigo').value);
		data.append('tarjCred_nombre', document.getElementById('tarjeta_nombre').value);
		data.append('tarjCred_bancod', document.getElementById('bancos').value);
		data.append('es_internacional', document.getElementById('cmb_esInternacional').value);
		var xhr = new XMLHttpRequest();
		xhr.open('POST', url , true);
		xhr.onreadystatechange=function()
		{   if (xhr.readyState==4 && xhr.status==200)
			{   js_tarjetaCredito_busca( "", div, url );
			}
		};
		xhr.send(data);
	}
}