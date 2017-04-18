function BuscarAlumnos(alum_codi,alum_apel,curs_para_codi)
{	 document.getElementById('alum_main').innerHTML='<div align="center" style="height:100%;"><img src="../imagenes/ajax-loader.gif"/> Buscando registros...</div>';
	var data = new FormData();	
	data.append('alum_codi', alum_codi);
	data.append('alum_apel', alum_apel);
	data.append('curs_para_codi', curs_para_codi);
	var xhr = new XMLHttpRequest();
	xhr.open('POST', 'alumnos_main_lista.php' , true);
	xhr.send(data);
	xhr.onreadystatechange=function(){
		if (xhr.readyState==4 && xhr.status==200)
		{	document.getElementById('alum_main').innerHTML=xhr.responseText;
			$(document).ready(function() {
			$('#alum_table').datatable({
				pageSize: 30,
				sort: [true,true, true, false],
				filters: [false,false, false, false],
				filterText: 'Buscar... '
			}) ;
			} ); 
		} 
	}
}