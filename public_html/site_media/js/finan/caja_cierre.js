$(document).ready(function() {
    actualiza_badge_gest_fact();
	$('#cajas_table').DataTable({
		"bPaginate": false,
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
		paging: false,
		lengthChange: false,
		searching: false,
		bInfo: false,
		language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'},
		"columnDefs": [
			{className: "dt-body-center" , "targets": [0]},
			{className: "dt-body-center" , "targets": [1]},
			{className: "dt-body-center" , "targets": [2]},
			{className: "dt-body-center" , "targets": [3]},
			{className: "dt-body-center" , "targets": [4]},
			{className: "dt-body-center" , "targets": [5]},
			{className: "dt-body-right"  , "targets": [6]},
			{className: "dt-body-center" , "targets": [7]}
		]
	});
	var table_caja = $('#cajas_table').DataTable();
	table_caja.column( '3:visible' ).order( 'desc' );
});
// Consulta filtrada
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
			$('#cajas_table').addClass( 'nowrap' ).DataTable({lengthChange: false, responsive: true, searching: true,  orderClasses: true,
				language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'}});
		} 
	}
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

// Realiza la actualizacion de los datos en la BD
function edit(rol_codigo,div,url){
	if(confirm("¿Está seguro que desea editar la información de la categoria?")){
		document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
		var data = new FormData();
		data.append('event', 'edit');
		data.append('codigo', document.getElementById('codigo_mod').value);
		data.append('nombre', document.getElementById('nombre_mod').value);
		data.append('descripcion', document.getElementById('descripcion_mod').value);
		data.append('categoriaPadre', document.getElementById('categoriaPadre_mod').value);
		
		//alert(data);
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
	data.append('categoriaPadre', document.getElementById('categoriaPadre_add').value);
	//data.append('nombres', document.getElementById('nombres_add').value);
	
	var xhr = new XMLHttpRequest();
	xhr.open('POST', url , true);
	xhr.onreadystatechange=function(){
		if (xhr.readyState==4 && xhr.status==200){
			busca("",div,url)
		} 
	}
	xhr.send(data);
}
// Realiza las opciones de la tabla
function caja_close(codigo,div,url){
	if(confirm("¿Está seguro que desea cerrar la caja?")){
		document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
		var data = new FormData();
		data.append('event', 'close_caja');
		data.append('caja_codi', codigo);	
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
function caja_reopen(codigo,div,url){
	if(confirm("¿Está seguro que desea reabrir la caja?")){
		document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
		var data = new FormData();
		data.append('event', 'reopen_caja');
		data.append('caja_codi', codigo);	
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
function carga_reports_item(codigo,div,url,evento){
	carga_reports_fp(codigo,'modal_edit_body_fp',url,'print_fp');
	document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var data = new FormData();
	data.append('event', 'printvisor');
	data.append('codigo', codigo);	
	url2=url+'?event='+evento+'&codigo='+codigo;
	data.append('url',url2);
	var xhr = new XMLHttpRequest();
	xhr.open('POST', url , true);
	xhr.onreadystatechange=function(){
		if (xhr.readyState==4 && xhr.status==200){
			document.getElementById(div).innerHTML=xhr.responseText;
		} 
	}
	xhr.send(data);
}
function carga_reports_fp(codigo,div,url,evento){
	carga_reports_nc(codigo,'modal_edit_body_nc',url,'print_nc');
	document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var data = new FormData();
	data.append('event', 'printvisor');
	data.append('codigo', codigo);	
	url2=url+'?event='+evento+'&codigo='+codigo;
	data.append('url',url2);
	var xhr = new XMLHttpRequest();
	xhr.open('POST', url , true);
	xhr.onreadystatechange=function(){
		if (xhr.readyState==4 && xhr.status==200){
			document.getElementById(div).innerHTML=xhr.responseText;
		} 
	}
	xhr.send(data);
}
function carga_reports_nc(codigo,div,url,evento){
	document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var data = new FormData();
	data.append('event', 'printvisor');
	data.append('codigo', codigo);	
	url2=url+'?event='+evento+'&codigo='+codigo;
	data.append('url',url2);
	var xhr = new XMLHttpRequest();
	xhr.open('POST', url , true);
	xhr.onreadystatechange=function(){
		if (xhr.readyState==4 && xhr.status==200){
			document.getElementById(div).innerHTML=xhr.responseText;
		} 
	}
	xhr.send(data);
}