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
		$('#banc_table').datatable({pageSize: 30,sort: [true,true, true, false],filters: [true,true,true,false],filterText: 'Buscar... '}) ;
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
			$('#banc_table').datatable({pageSize: 30,sort: [true,true, true, false],filters: [true,true,true,false],filterText: 'Buscar... '}) ;
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
function carga_reports_descuentos(div,url,evento){
	document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    periodos= document.getElementById('periodos').value;
	tipo_descuentos= document.getElementById('cmb_tipo_descuentos').value;
	cursos= document.getElementById('curso').value;
	
	var data = new FormData();
	
	data.append('event', 'printvisor');
	data.append('periodos', periodos);
	data.append('curso', cursos);
	data.append('tipo_descuentos', tipo_descuentos);
	url2=url+'?event='+evento+'&periodos='+periodos+'&curso='+cursos+'&tipo_descuentos='+tipo_descuentos;
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