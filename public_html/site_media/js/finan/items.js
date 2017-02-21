	$(document).ready(function() {
	actualiza_badge_gest_fact();
	$('#item_table').DataTable({
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
			{className: "dt-body-left"    , "targets": [3]},
			{className: "dt-body-right"   , "targets": [4]},
			{className: "dt-body-center"  , "targets": [5]},
			{className: "dt-body-center"  , "targets": [6]},
			{className: "dt-body-center"  , "targets": [7]},
			{className: "dt-body-center"  , "targets": [8]},
			{className: "dt-body-center"  , "targets": [9]},
			{className: "dt-body-center"  , "targets": [10]},
			{className: "dt-body-center"  , "targets": [11]}
		]
	});
	var table = $('#item_table').DataTable();
	table.column( '0:visible' ).order( 'asc' );
});
// Consulta filtrada
function js_item_busca( busq, div, url )
{   document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var data = new FormData();
	data.append('event', 'get_all_data');
	data.append('busq', busq);	
	var xhr = new XMLHttpRequest();
	xhr.open('POST', url , true);
	xhr.onreadystatechange=function()
	{	if (xhr.readyState==4 && xhr.status==200)
		{	document.getElementById(div).innerHTML=xhr.responseText;
			$('#item_table').DataTable({
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
					{className: "dt-body-left"    , "targets": [3]},
					{className: "dt-body-right"   , "targets": [4]},
					{className: "dt-body-center"  , "targets": [5]},
					{className: "dt-body-center"  , "targets": [6]},
					{className: "dt-body-center"  , "targets": [7]},
					{className: "dt-body-center"  , "targets": [8]},
					{className: "dt-body-center"  , "targets": [9]},
					{className: "dt-body-center"  , "targets": [10]},
					{className: "dt-body-center"  , "targets": [11]}
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
		if (xhr.readyState==4 && xhr.status==200)
		{	document.getElementById(div).innerHTML=xhr.responseText;
		} 
	};
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
		if (xhr.readyState==4 && xhr.status==200)
		{	document.getElementById(div).innerHTML=xhr.responseText;
		} 
	};
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
		xhr.onreadystatechange=function()
		{	if (xhr.readyState==4 && xhr.status==200)
			{	var n = xhr.responseText.length;
				if (n > 0)
				{   valida_tipo_growl(xhr.responseText);
				}
				else
				{   $.growl.warning({ title: "Educalinks informa:",message: "Proceso realizado." });
				}
				js_item_busca( "", div, url );
			} 
		};
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
		{	var n = xhr.responseText.length;
			if (n > 0)
			{   valida_tipo_growl(xhr.responseText);
			}
			else
			{   $.growl.warning({ title: "Educalinks informa:",message: "Proceso realizado." });
			}
			js_item_busca( "", div, url );
		} 
	};
	xhr.send(data);
}
// Realiza la eliminacion del cliente en la BD
function del(codigo,div,url)
{   if(confirm("¿Está seguro que desea eliminar el producto actual?"))
	{   document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
		var data = new FormData();
		data.append('event', 'delete');
		data.append('codigo', codigo);	
		var xhr = new XMLHttpRequest();
		xhr.open('POST', url , true);
		xhr.onreadystatechange=function()
		{   if (xhr.readyState==4 && xhr.status==200)
			{   var n = xhr.responseText.length;
                if (n > 0)
                {   valida_tipo_growl(xhr.responseText);
                }
                else
                {   $.growl.warning({ title: "Educalinks informa:",message: "Proceso realizado." });
                }
				js_item_busca( "", div, url );
			}
		};
		xhr.send(data);
	}
}
function js_item_cargaItem( div_resultado, combo_nombre, categoria_codi )
{   "use strict";
    document.getElementById( div_resultado ).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
	var data = new FormData();
    data.append( 'categoria', categoria_codi );
    data.append( 'combo_nombre', combo_nombre );
    data.append( 'event', 'get_subtipo' );
    var xhr = new XMLHttpRequest();
    xhr.open('POST', document.getElementById('ruta_html_finan').value + '/items/controller.php' , true);
    xhr.onreadystatechange=function()
	{   if ( xhr.readyState === 4 && xhr.status === 200 )
		{   document.getElementById( div_resultado ).innerHTML=xhr.responseText;
        }
    };
    xhr.send(data);
}