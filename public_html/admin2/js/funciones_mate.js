function mate_peri_upd(){
	
	if (confirm("Esta seguro que desea Actualizar")) {		
	
		div = 'curs_mate_main';
		url = 'script_cursos_materias.php';
		
		
		mate_prom='N';
		
		if (document.getElementById('ch_mate_prom').checked==true)
			mate_prom='A';
			
		
		//tipo de materia
		//mate_tipo=selectvalue(document.getElementById('m_mate_tipo'));
		 
			
		 
		
		var data = new FormData();
		data.append('peri_codi', document.getElementById('m_peri_codi').value);
		data.append('mate_codi', document.getElementById('m_mate_codi').value);
		data.append('mate_deta', document.getElementById('m_mate_deta').value);
		data.append('mate_abre', document.getElementById('m_mate_abre').value);
		data.append('area_codi', document.getElementById('a_area_sele').value);
		data.append('mate_prom', mate_prom);
		data.append('mate_padr', document.getElementById('m_mate_padr').value);
		data.append('mate_tipo', 'C');
  		data.append('upt_mate_codi', 'Y');
		var xhr = new XMLHttpRequest();
		xhr.open('POST', url , true);
		
		xhr.onreadystatechange=function(){
			if (xhr.readyState==4 && xhr.status==200){

				if(xhr.responseText=='OK'){
					$.growl.notice({ title: "Informacion: ",message: "Se actualizo Materia" });	
					$('#mate_edit').modal('hide');
					mate_view(div,'cursos_materias_main_lista.php');

					
					
				}else{
					$.growl.error({ title: "Error: ",message: xhr.responseText });	
					mate_view(div,'cursos_materias_main_lista.php');
				}
				
			 
				 
			} 
		}
		xhr.send(data);
		
		
	}
	
}
 
function mate_edit(mate_codi,mate_deta,mate_abre,mate_prom,mate_padr,mate_tipo,area_codi){	
	
	document.getElementById('m_top_matemodal').innerHTML= mate_deta + " (Codigo: " + mate_codi + ")";
	document.getElementById('m_mate_codi').value=mate_codi;
	document.getElementById('m_mate_deta').value=mate_deta;
	document.getElementById('a_area_sele').value=area_codi;
	document.getElementById('m_mate_abre').value=mate_abre;
	if (mate_prom=='A')
		document.getElementById('ch_mate_prom').checked=true;
	else
		document.getElementById('ch_mate_prom').checked=false;
	
	document.getElementById('m_mate_padr').value=mate_padr;
	
	// selectvalue_set(document.getElementById('m_mate_tipo'),mate_tipo)
	//document.getElementById('m_mate_tipo').values=mate_tipo;
	
/*	if (mate_tipo=='C'){
		document.getElementById('m_mate_tipoQ').checked=false;
		document.getElementById('m_mate_tipoC').checked=true;
		document.getElementById('m_mate_tipoP').checked=false;}
	else{
			if (mate_tipo=='Q'){
				document.getElementById('m_mate_tipoQ').checked=true;
				document.getElementById('m_mate_tipoC').checked=false;
				document.getElementById('m_mate_tipoP').checked=false;
			}
			else
			{
				document.getElementById('m_mate_tipoQ').checked=false;
				document.getElementById('m_mate_tipoC').checked=false;
				document.getElementById('m_mate_tipoP').checked=true;
			}
		}*/

}


function mate_upd(curs_para_mate_codi,curs_para_codi){	
 	if (confirm("Esta seguro que desea Eliminar, se perdera la informacion registrada en este Alumno en este Curso")) {		
		load_ajax('alum_view','cursos_paralelo_info_main_mate_view.php','curs_para_mate_codi=' + curs_para_mate_codi + '&curs_para_codi=' + curs_para_codi +  '&del_mate=' + 'Y') ;	
	}	
}

function mate_add(mate_deta){ 
	var data = new FormData();
	data.append('mate_deta', mate_deta);
	data.append('add_mate', 'Y');
	var xhr = new XMLHttpRequest();
	xhr.open('POST', 'script_cursos_materias.php' , true);
	
	xhr.onreadystatechange=function(){
		if (xhr.readyState==4 && xhr.status==200){

			$.growl.notice({ title: "Informacion: ",message: "Se agregó la Materia Exitosamente" });	
		
			mate_view('curs_mate_main','cursos_materias_main_lista.php');
			
		 	 
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
		
function mate_del(mate_codi){

	if (confirm("Esta seguro que desea Eliminar")) {
		var data = new FormData();
		data.append('mate_codi', mate_codi);
		data.append('del_mate', 'Y');
		var xhr = new XMLHttpRequest();
		xhr.open('POST', 'script_cursos_materias.php' , true);
		
		xhr.onreadystatechange=function(){
			if (xhr.readyState==4 && xhr.status==200){

				$.growl.notice({ title: "Informacion: ",message: "Se eliminó Materia" });	
			
				mate_view('curs_mate_main','cursos_materias_main_lista.php');
				
			 	 
			} 
		}
		xhr.send(data);				
	}	
}

function mate_view(div,url){
	document.getElementById(div).innerHTML='<div align="center" style="height:100%;"><img src="../imagenes/ajax-loader.gif"/></div>';
	var data = new FormData();
		
	var xhr = new XMLHttpRequest();
	xhr.open('POST', url , true);
	xhr.onreadystatechange=function(){
		if (xhr.readyState==4 && xhr.status==200){
			document.getElementById(div).innerHTML=xhr.responseText;
			$('#mate_table').DataTable({
				language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'},
				 	"bSort": false 
			});
		} 
	}
	xhr.send(data);
}