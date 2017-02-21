// JavaScript Document
$(document).ready(function() {
	actualiza_badge_gest_fact();
	$('#banc_table').addClass( 'nowrap' ).DataTable({
		lengthChange: false, 
		responsive: true, 
		searching: true,  
		orderClasses: true, 
		paging:true,
		bInfo:false,
		language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'},
		"columnDefs": [
			{className: "dt-body-center"  , "targets": [0]},
			{className: "dt-body-left"    , "targets": [1]},
			{className: "dt-body-center"  , "targets": [2]}
		]
	});
	var table = $('#banc_table').DataTable();
	table.column( '1:visible' ).order( 'desc' );
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
			$('#banc_table').addClass( 'nowrap' ).DataTable({
				lengthChange: false, 
				responsive: true, 
				searching: true,  
				orderClasses: true, 
				paging:true,
				bInfo:false,
				language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'},
				"columnDefs": [
					{className: "dt-body-center"  , "targets": [0]},
					{className: "dt-body-left"    , "targets": [1]},
					{className: "dt-body-center"  , "targets": [2]}
				]
			});
			var table = $('#banc_table').DataTable();
			table.column( '1:visible' ).order( 'desc' );
		} 
	}
	xhr.send(data);
}
function del(codigo,div,url){
	if(confirm("¿Está seguro que desea eliminar el banco?")){
		document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
		var data = new FormData();
		data.append('event', 'delete');
		data.append('banc_codigo', codigo);	
		var xhr = new XMLHttpRequest();
		xhr.open('POST', url , true);
		xhr.onreadystatechange=function(){
			if (xhr.readyState==4 && xhr.status==200){
				document.getElementById(div).innerHTML=xhr.responseText;
				$('#banc_table').addClass( 'nowrap' ).DataTable({
					lengthChange: false, 
					responsive: true, 
					searching: true,  
					orderClasses: true, 
					paging:false,
					bInfo:false,
					language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'},
					"columnDefs": [
						{className: "dt-body-center"  , "targets": [0]},
						{className: "dt-body-left"    , "targets": [1]},
						{className: "dt-body-center"  , "targets": [2]}
					]
				});
				var table = $('#banc_table').DataTable();
				table.column( '1:visible' ).order( 'desc' );
			} 
		}
		xhr.send(data);
	}
}
function edit(codigo,div,url){
	document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var data = new FormData();
	data.append('event', 'get');
	data.append('banc_codigo', codigo);	
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
function add(div,url){
	document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var data = new FormData();
	data.append('event', 'set');
	data.append('banc_nombre', document.getElementById('banc_nombre_add').value);

	var xhr = new XMLHttpRequest();
	xhr.open('POST', url , true);
	xhr.onreadystatechange=function(){
		if (xhr.readyState==4 && xhr.status==200){
			busca("",div,url)
		} 
	}
	xhr.send(data);
}
function save_edited(rol_codigo,div,url){
	if(confirm("¿Está seguro que desea editar la información del banco?")){
		document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
		var data = new FormData();
		data.append('event', 'edit');
		data.append('banc_codigo', document.getElementById('banc_codigo').value);
		data.append('banc_nombre', document.getElementById('banc_nombre').value);
		
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
