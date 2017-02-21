// JavaScript Document
$(document).ready(function() {
	actualiza_badge_gest_fact();
	$('#pto_emision_table').DataTable({
		"bPaginate": true,
		"bStateSave": false,
		"bAutoWidth": false,
		"bScrollAutoCss": true,
		"bProcessing": true,
		"bRetrieve": true,
		"sDom": '<"H"CTrf>t<"F"lip>',
		"aLengthMenu": [[10,25, 50, 100, -1], [10,25, 50, 100, "Todos"]],
		"sScrollXInner": "110%",
		"fnInitComplete": function() {
			this.css("visibility", "visible");
		},
		paging: true,
		lengthChange: true,
		searching: true,
		language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'},
		"columnDefs": [
			{className: "dt-body-center" , "targets": [0]},
			{className: "dt-body-center" , "targets": [1]},
			{className: "dt-body-center" , "targets": [2]},
			{className: "dt-body-center" , "targets": [3]},
			{className: "dt-body-center" , "targets": [4]},
			{className: "dt-body-center" , "targets": [5]}
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
		if (xhr.readyState==4 && xhr.status==200){
			document.getElementById(div).innerHTML=xhr.responseText;
			$('#pto_emision_table').DataTable({
				"bPaginate": true,
				"bStateSave": false,
				"bAutoWidth": false,
				"bScrollAutoCss": true,
				"bProcessing": true,
				"bRetrieve": true,
				"sDom": '<"H"CTrf>t<"F"lip>',
				"aLengthMenu": [[10,25, 50, 100, -1], [10,25, 50, 100, "Todos"]],
				"sScrollXInner": "110%",
				"fnInitComplete": function() {
					this.css("visibility", "visible");
				},
				paging: true,
				lengthChange: true,
				searching: true,
				language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'},
				"columnDefs": [
					{className: "dt-body-center" , "targets": [0]},
					{className: "dt-body-center" , "targets": [1]},
					{className: "dt-body-center" , "targets": [2]},
					{className: "dt-body-center" , "targets": [3]},
					{className: "dt-body-center" , "targets": [4]},
					{className: "dt-body-center" , "targets": [5]}
				]
			});
		} 
	}
	xhr.send(data);
}
function del(codigo,div,url){
	if(confirm("¿Está seguro que desea eliminar el punto de emisión?")){
		document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
		var data = new FormData();
		data.append('event', 'delete');
		data.append('puntVent_codigo', codigo);	
		var xhr = new XMLHttpRequest();
		xhr.open('POST', url , true);
		xhr.onreadystatechange=function()
		{	if (xhr.readyState==4 && xhr.status==200)
			{	var n = xhr.responseText.length;
				if (n > 0)
				{	
					valida_tipo_growl(xhr.responseText);
				}
				else
				{
					$.growl.warning({ title: "Educalinks informa:",message: "Proceso realizado." });
				}
				busca("",div,url)
			} 
		}
		xhr.send(data);
	}
}
function edit(codigo,div,url){
	document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var data = new FormData();
	data.append('event', 'get');
	data.append('puntVent_codigo', codigo);	
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
	var xhr = new XMLHttpRequest();
	xhr.open('POST', url , true);
	xhr.onreadystatechange=function(){
		if (xhr.readyState==4 && xhr.status==200){
			document.getElementById(div).innerHTML=xhr.responseText;
			document.getElementById('puntVent_codigo').value=codigo;
			$('#pto_emision_table_users').DataTable({
				"bPaginate": true,
				"bStateSave": false,
				"bAutoWidth": false,
				"bScrollAutoCss": true,
				"bProcessing": true,
				"bRetrieve": true,
				"sDom": '<"H"CTrf>t<"F"lip>',
				"aLengthMenu": [[10,25, 50, 100, -1], [10,25, 50, 100, "Todos"]],
				"sScrollXInner": "110%",
				"fnInitComplete": function() {
					this.css("visibility", "visible");
				},
				paging: true,
				lengthChange: true,
				searching: true,
				language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'},
				"columnDefs": [
					{className: "dt-body-center" , "targets": [0]},
					{className: "dt-body-center" , "targets": [1]},
					{className: "dt-body-center" , "targets": [2]},
					{className: "dt-body-center" , "targets": [3]},
					{className: "dt-head-center" , "targets": [0]},
					{className: "dt-head-center" , "targets": [1]},
					{className: "dt-head-center" , "targets": [2]},
					{className: "dt-head-center" , "targets": [3]}
				]
			});
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
			$('#pto_emision_table_users').DataTable();
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
			$('#pto_emision_table_users_asigned').DataTable({
				"bPaginate": true,
				"bStateSave": false,
				"bAutoWidth": false,
				"bScrollAutoCss": true,
				"bProcessing": true,
				"bRetrieve": true,
				"sDom": '<"H"CTrf>t<"F"lip>',
				"aLengthMenu": [[10,25, 50, 100, -1], [10,25, 50, 100, "Todos"]],
				"sScrollXInner": "110%",
				"fnInitComplete": function() {
					this.css("visibility", "visible");
				},
				paging: true,
				lengthChange: true,
				searching: true,
				language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'},
				"columnDefs": [
					{className: "dt-body-center" , "targets": [0]},
					{className: "dt-body-center" , "targets": [1]},
					{className: "dt-body-center" , "targets": [2]},
					{className: "dt-body-center" , "targets": [3]},
					{className: "dt-body-center" , "targets": [4]}
				]
			});
		} 
	}
	xhr.send(data);
}
function add(div,url){
	document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var data = new FormData();
	data.append('event', 'set');
	data.append('puntVent_prefijo', document.getElementById('pto_prefijo_add').value);
	data.append('puntVent_codigoSucursal', document.getElementById('pto_sucursal_add').value);
	data.append('puntVent_secuencia', document.getElementById('pto_secuencia_add').value);
	data.append('puntVent_secuencianc', document.getElementById('pto_secuencianc_add').value);
	data.append('puntVent_estado', 'A');
	var xhr = new XMLHttpRequest();
	xhr.open('POST', url , true);
	xhr.onreadystatechange=function()
	{   if (xhr.readyState==4 && xhr.status==200)
		{   busca("",div,url);
		}
	};
	xhr.send(data);
}
function save_edited(rol_codigo,div,url){
	if(confirm("¿Está seguro que desea editar la información de la sucursal?")){
		document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
		var data = new FormData();
		data.append('event', 'edit');
		data.append('puntVent_codigo', document.getElementById('pto_codigo').value);
		data.append('puntVent_prefijo', document.getElementById('pto_prefijo').value);
		data.append('puntVent_codigoSucursal', document.getElementById('pto_sucursal').value);
		data.append('puntVent_secuencia', document.getElementById('pto_secuencia').value);
		data.append('puntVent_secuencianc', document.getElementById('pto_secuencia_nc').value);
		data.append('ckb_docPendientes', document.getElementById('ckb_docPendientes').checked);
		data.append('puntVent_estado', 'A');
		var xhr = new XMLHttpRequest();
		xhr.open('POST', url , true);
		xhr.onreadystatechange=function()
		{	if (xhr.readyState==4 && xhr.status==200)
			{	var n = xhr.responseText.length;
				if (n > 0)
				{	
					valida_tipo_growl(xhr.responseText);
				}
				else
				{
					$.growl.warning({ title: "Educalinks informa:",message: "Proceso realizado." });
				}
				busca("",div,url);
			}
		};
		xhr.send(data);
	}
}