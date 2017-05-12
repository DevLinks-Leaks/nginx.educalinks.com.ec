// JavaScript Document
function post_add(div,url)
{	
	var text;
	text=CKEDITOR.instances.text_post.getData();
	document.getElementById(div).innerHTML='<div align="center" style="height:100%;"><img src="../imagenes/ajax-loader.gif"/></div>';
	var data = new FormData();
	data.append('text_post_hd', text);
	if (document.getElementById('curs_para_mate_prof_codi_hd').value!=0)
	{
		data.append('opc', 'post_mate_add');
		data.append('curs_para_mate_prof_codi', document.getElementById('curs_para_mate_prof_codi_hd').value);
		data.append('curs_para_mate_codi', document.getElementById('curs_para_mate_codi_hd').value);
		data.append('curs_para_codi', document.getElementById('curs_para_codi_hd').value);
	}
	else
	{
		data.append('opc', 'post_add');
	}
		
	var xhr = new XMLHttpRequest();
	xhr.open('POST', url , true);
	xhr.onreadystatechange=function(){
		if (xhr.readyState==4 && xhr.status==200){
		$.growl.notice({ title: "Informacion: ",message: "Se posteó correctamente" });
		document.getElementById(div).innerHTML=xhr.responseText;
		} 
	}
	xhr.send(data);
	
}
function post_main_add(div,url){
	var text;
	text=CKEDITOR.instances.text_post.getData();
	document.getElementById(div).innerHTML='<div align="center" style="height:100%;"><img src="../imagenes/ajax-loader.gif"/></div>';
	var data = new FormData();
	data.append('text_post_hd', text);
	if (document.getElementById('curs_para_mate_codi_hd').value!=0){
		data.append('opc', 'post_mate_add');
		data.append('curs_para_mate_codi', document.getElementById('curs_para_mate_codi_hd').value);
		data.append('curs_para_codi', document.getElementById('curs_para_codi_hd').value);
	}else{
		data.append('opc', 'post_main_add');
	}
	
		
	var xhr = new XMLHttpRequest();
	xhr.open('POST', url , true);
	xhr.onreadystatechange=function(){
		if (xhr.readyState==4 && xhr.status==200){
		$.growl.notice({ title: "Informacion: ",message: "Se posteo correctamente" });
		document.getElementById(div).innerHTML=xhr.responseText;
		} 
	}
	xhr.send(data);
	
}