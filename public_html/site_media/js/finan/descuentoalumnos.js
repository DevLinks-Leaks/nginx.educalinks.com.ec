$(document).ready(function() {
	$('#descfacturas_table').addClass( 'nowrap' ).DataTable({
		dom: 'Bfrtip',
        buttons: [ 
			{ extend: 'copy', text: 'Copiar <i class="fa fa-copy"></i>' },
			{ extend: 'csv', text: 'CSV <i style="color:green" class="fa fa-file-excel-o"></i>' },
			{ extend: 'excel', text: 'Excel <i style="color:green" class="fa fa-file-excel-o"></i>' },
			{ extend: 'pdf', text: 'PDF <i style="color:red" class="fa fa-file-pdf-o"></i>' },
			{ extend: 'print', text: 'Imprimir <i style="color:#428bca" class="fa fa-print"></i>' },
			],
		lengthChange: false, 
		responsive: true, 
		searching: true,  
		orderClasses: true, 
		paging:true,
		"bFilter": false, 
		"sScrollX": "100%", 
		"bScrollCollapse": true,
		language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'},
		"columnDefs": [
			{className: "dt-body-center" , "targets": [0]},
			{className: "dt-body-left"   , "targets": [1]},
			{className: "dt-body-center" , "targets": [2]},
			{className: "dt-body-center" , "targets": [3]},
			{className: "dt-body-center" , "targets": [4]},
			{className: "dt-body-center" , "targets": [5]},
			{className: "dt-body-center" , "targets": [6]},
			{className: "dt-body-center" , "targets": [7]}
		]
	});
	$('.buttons-excel').ready(function() {
		$(this).addClass('btn-success');
	})
});
// Consulta filtrada
function busca( busq, div, url )
{   document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var data = new FormData();
	data.append('event', 'get_all_data');
	data.append('busq', busq);	
	var xhr = new XMLHttpRequest();
	xhr.open('POST', url , true);
	xhr.onreadystatechange=function(){
		if (xhr.readyState==4 && xhr.status==200){
			document.getElementById(div).innerHTML=xhr.responseText;
			$('#descfacturas_table').addClass( 'nowrap' ).DataTable({
				dom: 'Bfrtip',
				buttons: [ 
					{ extend: 'copy', text: 'Copiar <i class="fa fa-copy"></i>' },
					{ extend: 'csv', text: 'CSV <i style="color:green" class="fa fa-file-excel-o"></i>' },
					{ extend: 'excel', text: 'Excel <i style="color:green" class="fa fa-file-excel-o"></i>' },
					{ extend: 'pdf', text: 'PDF <i style="color:red" class="fa fa-file-pdf-o"></i>' },
					{ extend: 'print', text: 'Imprimir <i style="color:#428bca" class="fa fa-print"></i>' },
					],
				lengthChange: false, 
				responsive: true, 
				searching: true,  
				orderClasses: true, 
				paging:true,
				"bFilter": false, 
				"sScrollX": "100%", 
				"bScrollCollapse": true,
				language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'},
				"columnDefs": [
					{className: "dt-body-center" , "targets": [0]},
					{className: "dt-body-left"   , "targets": [1]},
					{className: "dt-body-center" , "targets": [2]},
					{className: "dt-body-center" , "targets": [3]},
					{className: "dt-body-center" , "targets": [4]},
					{className: "dt-body-center" , "targets": [5]},
					{className: "dt-body-center" , "targets": [6]},
					{className: "dt-body-center" , "targets": [7]}
				]
			});
		}
	};
	xhr.send(data);
}
// Carga el formulario para ingresar un nuevo registro
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
// Carga el formulario para editar un registro
function carga_edit(codigo,div,url){
	document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var data = new FormData();
	data.append('event', 'get');
	data.append('codigo', codigo);	
	var xhr = new XMLHttpRequest();
	xhr.open('POST', url , true);
	xhr.onreadystatechange=function(){
		if (xhr.readyState==4 && xhr.status==200){
		document.getElementById(div).innerHTML=xhr.responseText;
		} 
	}
	xhr.send(data);
}
// Realiza la actualizacion de los datos en la BD
function edit(rol_codigo,div,url){
	if(confirm("¿Está seguro que desea editar la información del producto?\n Recuerde que al modificar el campo 'PRECIO GENERAL' de un producto con precio, deberá asignarle nuevamente un precio.")){
		document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
		var data = new FormData();
		data.append('event', 'edit');
		data.append('codigo', document.getElementById('codigo_mod').value);
		data.append('nombre', document.getElementById('nombre_mod').value);
		data.append('descripcion', document.getElementById('descripcion_mod').value);
		data.append('categoria', document.getElementById('codigoCategoria_mod').value);
		data.append('cuentaContable', document.getElementById('cuentaContable_mod').value);
		data.append('aplicaIVA', document.getElementById('aplicaIVA_mod').checked);
		data.append('aplicaICE', document.getElementById('aplicaICE_mod').checked);
		data.append('precioGeneral', document.getElementById('precioGeneral_mod').checked);
		data.append('descuento', document.getElementById('descuento_mod').checked);
		data.append('liquidez', document.getElementById('liquidez_mod').checked);
		data.append('prontopago', document.getElementById('prontopago_mod').checked);
		var xhr = new XMLHttpRequest();
		xhr.open('POST', url , true);
		xhr.onreadystatechange=function(){
			if (xhr.readyState==4 && xhr.status==200){
				busca("",div,url)
			} 
		}
		xhr.send(data);
	}
}
// Realiza el ingreso de un registro nuevo
function add(div,url){
	document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var data = new FormData();
	data.append('event', 'set');
	data.append('nombre', document.getElementById('nombre_add').value);
	data.append('descripcion', document.getElementById('descripcion_add').value);
	data.append('categoria', document.getElementById('codigoCategoria_add').value);
	data.append('cuentaContable', document.getElementById('cuentaContable_add').value);
	data.append('aplicaIVA', document.getElementById('aplicaIVA_add').checked);
	data.append('aplicaICE', document.getElementById('aplicaICE_add').checked);
	data.append('precioGeneral', document.getElementById('precioGeneral_add').checked);
	data.append('descuento', document.getElementById('descuento_add').checked);
	data.append('liquidez', document.getElementById('liquidez_add').checked);
	data.append('prontopago', document.getElementById('prontopago_add').checked);
	var xhr = new XMLHttpRequest();
	xhr.open('POST', url , true);
	xhr.onreadystatechange=function()
	{   if (xhr.readyState==4 && xhr.status==200)
		{   busca("",div,url);
		}
	};
	xhr.send(data);
}
// Realiza la eliminacion del cliente en la BD
function js_descuento_alumno_delete ( codigo, div, url )
{   if(confirm("¿Está seguro que desea eliminar el producto actual?"))
	{   document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
		var data = new FormData();
		data.append('event', 'delete');
		data.append('codigo', codigo);	
		var xhr = new XMLHttpRequest();
		xhr.open('POST', url , true);
		xhr.onreadystatechange=function()
		{   if (xhr.readyState==4 && xhr.status==200)
			{   busca("",div,url);
			} 
		};
		xhr.send(data);
	}
}