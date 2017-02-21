function area_upd(){
	
	if (confirm("Esta seguro que desea Actualizar")) {		
	
		div = 'areas_main';
		url = 'script_areas.php';
		
		
		var data = new FormData();
		data.append('area_codi', document.getElementById('a_area_codi').value);
		data.append('area_deta', document.getElementById('a_area_deta').value);
  		data.append('upt_area', 'Y');
		var xhr = new XMLHttpRequest();
		xhr.open('POST', url , true);
		
		xhr.onreadystatechange=function(){
			if (xhr.readyState==4 && xhr.status==200){

				if(xhr.responseText=='OK'){
					$.growl.notice({ title: "Informacion: ",message: "Se eliminó Área exitosamente" });	
			
					area_view('areas_main','areas_main_lista.php');
				}else{
					$.growl.error({ title: "Error: ", message: "Se produjo un error al actualizar el Área. "+ xhr.responseText });	
			
					area_view('areas_main','areas_main_lista.php');
				}
				
			 
				 
			} 
		}
		xhr.send(data);
		
		
	}
	
}
 
function area_edit(area_codi,area_deta){	
	document.getElementById('m_top_matemodal').innerHTML= area_deta;
	document.getElementById('a_area_codi').value=area_codi;
	document.getElementById('a_area_deta').value=area_deta;
}


function mate_upd(curs_para_mate_codi,curs_para_codi){	
 	if (confirm("Esta seguro que desea Eliminar, se perdera la informacion registrada en este Alumno en este Curso")) {		
		load_ajax('alum_view','cursos_paralelo_info_main_mate_view.php','curs_para_mate_codi=' + curs_para_mate_codi + '&curs_para_codi=' + curs_para_codi +  '&del_mate=' + 'Y') ;	
	}	
}

function area_add(area_deta){ 
	var data = new FormData();
	data.append('area_deta', area_deta);
	data.append('add_area', 'Y');
	var xhr = new XMLHttpRequest();
	xhr.open('POST', 'script_areas.php' , true);
	
	xhr.onreadystatechange=function(){
		if (xhr.readyState==4 && xhr.status==200){

			if(xhr.responseText=='OK'){
				$.growl.notice({ title: "Informacion: ",message: "Se agregó el Área exitosamente" });	
				area_view('areas_main','areas_main_lista.php');
			}else{
				$.growl.error({ title: "Error: ",message: "Se produjo un error al agregar el Área. "+xhr.responseText });	
				area_view('areas_main','areas_main_lista.php');
			}
			
			
		} 
	}
	xhr.send(data);		

}

/*function mate_del(curs_para_mate_codi,curs_para_codi){	
 	if (confirm("Esta seguro que desea Eliminar, se perdera la informacion registrada en este Alumno en este Curso")) {
		load_ajax('alum_view','cursos_paralelo_info_main_mate_view.php','curs_para_mate_codi=' + curs_para_mate_codi + '&curs_para_codi=' + curs_para_codi +  '&del_mate=' + 'Y') ;	
	}	
}*/




function mate_upd(mate_codi){		 
	if (confirm("Esta seguro que desea Eliminar")) {		 
		load_ajax('mate_'+ mate_codi,'script_mate.php','mate_codi=' + mate_codi + '&mate_deta=' + document.getElementById('mate_deta_' + mate_codi).value + '&upd_mate=Y'); 
		document.getElementById('bt_mate_edit_' + mate_codi).innerHTML = 'Editar';
		document.getElementById('bt_mate_dele_' + mate_codi).innerHTML = 'Eliminar';
	
	}
}
		
function area_del(area_codi){

	if (confirm("Esta seguro que desea Eliminar")) {
		var data = new FormData();
		data.append('area_codi', area_codi);
		data.append('del_area', 'Y');
		var xhr = new XMLHttpRequest();
		xhr.open('POST', 'script_areas.php' , true);
		
		xhr.onreadystatechange=function(){
			if (xhr.readyState==4 && xhr.status==200){

				if(xhr.responseText=='OK'){
					$.growl.notice({ title: "Informacion: ",message: "Se eliminó Área exitosamente" });	
			
					area_view('areas_main','areas_main_lista.php');
				}else{
					$.growl.error({ title: "Error: ", message: "Se produjo un error al eliminar el Área. "+ xhr.responseText });	
			
					area_view('areas_main','areas_main_lista.php');
				}
				
				
			 	 
			} 
		}
		xhr.send(data);				
	}	
}

function area_view(div,url){
	document.getElementById(div).innerHTML='<div align="center" style="height:100%;"><img src="../imagenes/ajax-loader.gif"/></div>';
	var data = new FormData();
		
	var xhr = new XMLHttpRequest();
	xhr.open('POST', url , true);
	xhr.onreadystatechange=function(){
		if (xhr.readyState==4 && xhr.status==200){
			document.getElementById(div).innerHTML=xhr.responseText;
			/*$('#mate_table').datatable({
				pageSize: 20,
				sort: [false, false,false, false,false],
				filters: [true,'select','select','select',false],
				filterText: 'Escriba para buscar... '
			}) ;*/
		} 
	}
	xhr.send(data);
}