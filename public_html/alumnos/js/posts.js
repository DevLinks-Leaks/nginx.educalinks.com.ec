// JavaScript Document
function post_add(div,url){
	var text;
	text=CKEDITOR.instances.text_post.getData();
	document.getElementById(div).innerHTML='<br><div align="center"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i><br>Por favor, espere...</div><br>';
	var data = new FormData();
	data.append('text_post_hd', text);
	if (document.getElementById('curs_para_mate_codi_hd').value!=0){
		data.append('opc', 'post_mate_add');
		data.append('curs_para_mate_codi', document.getElementById('curs_para_mate_codi_hd').value);
	}else{
		data.append('opc', 'post_add');
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
function post_main_add(div,url){
	var text;
	text=CKEDITOR.instances.text_post.getData();
	document.getElementById(div).innerHTML='<br><div align="center"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i><br>Por favor, espere...</div><br>';
	var data = new FormData();
	data.append('text_post_hd', text);
	if (document.getElementById('curs_para_mate_codi_hd').value!=0){
		data.append('opc', 'post_mate_add');
		data.append('curs_para_mate_codi', document.getElementById('curs_para_mate_codi_hd').value);
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