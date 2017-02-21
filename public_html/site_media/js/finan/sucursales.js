// JavaScript Document
$(document).ready(function() {
	actualiza_badge_gest_fact();
	$('#sucu_table').DataTable({
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
			{className: "dt-body-left" , "targets": [1]},
			{className: "dt-body-left" , "targets": [2]},
			{className: "dt-body-center"  , "targets": [3]},
			{className: "dt-body-center"  , "targets": [4]}
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
			$('#sucu_table').DataTable({
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
					{className: "dt-body-center"  , "targets": [0]},
					{className: "dt-body-left"    , "targets": [1]},
					{className: "dt-body-left"    , "targets": [2]},
					{className: "dt-body-center"  , "targets": [3]},
					{className: "dt-body-center"  , "targets": [4]}
				]
			});
		} 
	}
	xhr.send(data);
}
function del(codigo,div,url){
	if(confirm("¿Está seguro que desea eliminar la sucursal?")){
		document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
		var data = new FormData();
		data.append('event', 'delete');
		data.append('sucu_codigo', codigo);	
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
	data.append('sucu_codigo', codigo);	
	var xhr = new XMLHttpRequest();
	xhr.open('POST', url , true);
	xhr.onreadystatechange=function()
	{   if (xhr.readyState==4 && xhr.status==200)
		{   document.getElementById(div).innerHTML=xhr.responseText;
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
function validaAdd(div,url)
{	add(div,url);
	return false;
}
function add(div,url){
	document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var data = new FormData();
	data.append('event', 'set');
	data.append('sucu_descripcion', document.getElementById('sucu_descripcion_add').value);
	data.append('sucu_direccion', document.getElementById('sucu_direccion_add').value);
	data.append('sucu_prefijo', document.getElementById('sucu_prefijo_add').value);
	data.append('sucu_estado', 'A');
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
	};
	xhr.send(data);
}
function validaSave_edited(rol_codigo,div,url)
{	save_edited(rol_codigo,div,url);
	return false;
}
function save_edited(rol_codigo,div,url){
	if(confirm("¿Está seguro que desea editar la información de la sucursal?")){
		var data = new FormData();
		data.append('event', 'edit');
		data.append('sucu_codigo', document.getElementById('sucu_codigo').value);
		data.append('sucu_descripcion', document.getElementById('sucu_descripcion').value);
		data.append('sucu_direccion', document.getElementById('sucu_direccion').value);
		data.append('sucu_prefijo', document.getElementById('sucu_prefijo').value);
		data.append('ckb_docPendientes', document.getElementById('ckb_docPendientes').checked);
		data.append('sucu_estado', 'A');
		var xhr = new XMLHttpRequest();
		xhr.open('POST', url , true);
		xhr.onreadystatechange=function()
		{	if (xhr.readyState==4 && xhr.status==200)
			{	var n = xhr.responseText.length;
				if (n > 0)
				{   valida_tipo_growl(xhr.responseText);
				}
				else
				{   $.growl.warning({ title: "Educalinks informa:",message: "Proceso realizado." });
				}
				$('#modal_edit').modal('hide');
				busca("",div,url)
			} 
		};
		xhr.send(data);
	}
}
function enterpress_addpay(e){
	if (e.keyCode == 13) {
		$('#modal_add').modal('hide');
		return true;
    }
}