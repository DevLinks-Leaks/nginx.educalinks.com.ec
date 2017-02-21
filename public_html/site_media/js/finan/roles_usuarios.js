// JavaScript Document

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
		$('#rol_table').datatable({pageSize: 4,sort: [true,true, true, false],filters: [true,true,true,false],filterText: 'Buscar... '}) ;
		} 
	}
	xhr.send(data);
}
function del(rol_codigo,div,url){
	if(confirm("¿Está seguro que desea eliminar el rol de usuario?")){
		document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
		var data = new FormData();
		data.append('event', 'delete');
		data.append('rol_codigo', rol_codigo);	
		var xhr = new XMLHttpRequest();
		xhr.open('POST', url , true);
		xhr.onreadystatechange=function(){
			if (xhr.readyState==4 && xhr.status==200){
			document.getElementById(div).innerHTML=xhr.responseText;
			$('#rol_table').datatable({pageSize: 4,sort: [true,true, true, false],filters: [true,true,true,false],filterText: 'Buscar... '}) ;
			} 
		}
		xhr.send(data);
	}
}
function edit(rol_codigo,div,url){
	document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var data = new FormData();
	data.append('event', 'get');
	data.append('rol_codigo', rol_codigo);	
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
	data.append('rol_nombre', document.getElementById('nombre_add').value);
	data.append('rol_descripcion', document.getElementById('descripcion_add').value);
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
	if(confirm("¿Está seguro que desea editar la información del rol del usuario?")){
		document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
		var data = new FormData();
		data.append('event', 'edit');
		data.append('rol_codigo', rol_codigo);
		data.append('rol_nombre', document.getElementById('nombre').value);	
		data.append('rol_descripcion', document.getElementById('descripcion').value);	
		data.append('rol_estado', document.getElementById('estado').value);	
		
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
