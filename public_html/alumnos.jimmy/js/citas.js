// JavaScript Document
function citas_add(div,url,hora_codi,alum_curs_para_mate_codi,prof_codi,hora_dia,fecha_cita){
	document.getElementById(div).innerHTML='<div align="center" style="height:100%;"><img src="../imagenes/ajax-loader.gif"/></div>';
	var data = new FormData();
	
	data.append('opc', 'cita_add');
	data.append('hora_codi', hora_codi);
	data.append('alum_curs_para_mate_codi', alum_curs_para_mate_codi);
	data.append('prof_codi', prof_codi);
	data.append('hora_dia', hora_dia);
	data.append('fecha_cita', fecha_cita);
	
	var xhr = new XMLHttpRequest();
	xhr.open('POST', url , true);
	xhr.onreadystatechange=function(){
		if (xhr.readyState==4 && xhr.status==200){
		$.growl.notice({ title: "Informacion: ",message: "Se realiz&oacute; correctamente la cita." });
		//document.getElementById(div).innerHTML=xhr.responseText;
		citas_free_view('citas_alum_curs_para_mate_'+alum_curs_para_mate_codi,'citas_main_lista.php',prof_codi,'',alum_curs_para_mate_codi,fecha_cita)
		} 
	}
	xhr.send(data);
}
function citas_free_view(div,url,prof_codi,conn,alum_curs_para_mate_codi,fecha){
	document.getElementById(div).innerHTML='<div align="center" style="height:100%;"><img src="../imagenes/ajax-loader.gif"/></div>';
	var data = new FormData();
	
	data.append('fecha_cita', fecha);
	data.append('prof_codi', prof_codi);
	data.append('alum_curs_para_mate_codi',alum_curs_para_mate_codi);
	data.append('conn', conn);
	
	var xhr = new XMLHttpRequest();
	xhr.open('POST', url , true);
	xhr.onreadystatechange=function(){
		if (xhr.readyState==4 && xhr.status==200){
		//$.growl.notice({ title: "Informacion: ",message: "Se posteo correctamente" });
		document.getElementById(div).innerHTML=xhr.responseText;
		} 
	}
	xhr.send(data);
}