// JavaScript Document
function carga_agenda(div,url,curs_para_mate_prof_codi){
	document.getElementById(div).innerHTML='<div align="center" style="height:100%;"><img src="../imagenes/ajax-loader.gif"/></div>';
	var data = new FormData();
	data.append('curs_para_mate_prof_codi', curs_para_mate_prof_codi);
	data.append('opc', 'agen_view');
		
	var xhr = new XMLHttpRequest();
	xhr.open('POST', url , true);
	xhr.onreadystatechange=function(){
		if (xhr.readyState==4 && xhr.status==200){
		document.getElementById(div).innerHTML=xhr.responseText;
		} 
	}
	xhr.send(data);
	
}