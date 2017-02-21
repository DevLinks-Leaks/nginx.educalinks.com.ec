$(document).ready(function() {
	actualiza_badge_gest_fact();
	$('#nivelEconomicoCursos_table').addClass( 'nowrap' ).DataTable({
		lengthChange: false, 
		responsive: true, 
		searching: true,  
		orderClasses: true,
		paging:true,
		bInfo:true,
		language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'},
		"columnDefs": [
			{className: "dt-body-center"  , "targets": [0]},
			{className: "dt-body-left"    , "targets": [1]},
			{className: "dt-body-center"  , "targets": [2]},
			{className: "dt-body-center"  , "targets": [3]}
		]
	});
	var table = $('#nivelEconomicoCursos_table').DataTable();
	table.column( '2:visible' ).order( 'asc' );
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
		if (xhr.readyState==4 && xhr.status==200){
			document.getElementById(div).innerHTML=xhr.responseText;
			$('#nivelEconomicoCursos_table').addClass( 'nowrap' ).DataTable({
				lengthChange: false, 
				responsive: true, 
				searching: true,  
				orderClasses: true,
				paging:true,
				bInfo:true,
				language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'},
				"columnDefs": [
						{className: "dt-body-center", "targets": [ 0 ]},
						{className: "dt-body-center" , "targets": [1]},
						{className: "dt-body-center" , "targets": [2]},
						{className: "dt-body-center" , "targets": [3]}
					]
			});
			var table = $('#nivelEconomicoCursos_table').DataTable();
			table.column( '2:visible' ).order( 'asc' );
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
function add(div,url)
{   document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var data = new FormData();
	data.append('event', 'set');
	var cmb_nivel_economico = document.getElementById('nivel_economico_add');
	var cmb_curso = document.getElementById('curso_add');
	data.append('niveEcon_codigo',cmb_nivel_economico.options[cmb_nivel_economico.selectedIndex].value);
	data.append('curs_codi', cmb_curso.options[cmb_curso.selectedIndex].value);
	
	var xhr = new XMLHttpRequest();
	xhr.open('POST', url , true);
	xhr.onreadystatechange=function(){
		if (xhr.readyState==4 && xhr.status==200){
			busca("",div,url);
		} 
	}
	xhr.send(data);
}
function edit(codigo,div,url){
	document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var data = new FormData();
	data.append('event', 'modificar');
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
function save_edited(codigo,div,url){
	if(confirm("¿Está seguro que desea editar la información?")){
		document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
		var data = new FormData();
		data.append('event', 'edit');
		data.append('codigo', document.getElementById('codigo_mod').value);
		var cmb_nivel_economico = document.getElementById('nivel_economico_mod');
		data.append('niveEcon_codigo',cmb_nivel_economico.options[cmb_nivel_economico.selectedIndex].value);
		//data.append('ckb_deudasPendientes', document.getElementById('ckb_deudasPendientes').checked);
		var xhr = new XMLHttpRequest();
		xhr.open('POST', url , true);
		xhr.onreadystatechange=function(){
			if (xhr.readyState==4 && xhr.status==200){
				//$.growl.notice({ title: "Educalinks informa:", message: "¡Cambios realizados correctamente!" });
				busca("",div,url);
			}else{
				//$.growl.error({ title: "Educalinks informa:", message: "Error al guardar los cambios." });
			}
		}
		xhr.send(data);
	}
}
function del(codigo,div,url){
	var cmb_grupo = document.getElementById('codigoGrupo_mod');
	if(confirm("¿Está seguro que desea eliminar la información de la cuenta contable?")){
		document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
		var data = new FormData();
		data.append('event', 'delete');
		data.append('codigo', codigo);
		
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