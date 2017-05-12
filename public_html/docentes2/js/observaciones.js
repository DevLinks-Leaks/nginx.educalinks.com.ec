// JavaScript Document
function obs_add(div,url,alum_curs_para_codi){
	document.getElementById(div).innerHTML='<div align="center" style="height:100%;"><img src="../imagenes/ajax-loader.gif"/></div>';
	$('#btn_obs_add').button('loading');
	var data = new FormData();
	data.append('alum_curs_para_codi', alum_curs_para_codi);
	data.append('tipo_obs', document.getElementById('tipo_obs').value);
	data.append('obs_deta', document.getElementById('obs_deta').value);
	data.append('opc', 'obs_add');
		
	var xhr = new XMLHttpRequest();
	xhr.open('POST', url , true);
	xhr.onreadystatechange=function(){
		if (xhr.readyState==4 && xhr.status==200){
			var json = JSON.parse(xhr.responseText);
			if (json.state=="success"){				
				$.growl.notice({ title: "Listo!",message: json.result });
				$('#btn_obs_add').button('reset');
				$('#modal_new_obse').modal('hide');
				obs_view('div_obs_list',url,alum_curs_para_codi);			
			}else if(json.state=="warning"){
				$.growl.notice({ title: "Atención!",message: 'Observación agregada con éxito. '+json.result ,duration: 6400});
				$('#btn_obs_add').button('reset');
				$('#modal_new_obse').modal('hide');
				obs_view('div_obs_list',url,alum_curs_para_codi);
			}else{
				$.growl.error({ title: "Atención!",message: json.result });
				$('#btn_obs_add').button('reset');
				console.log(json.console);	
			}
		} 
	}
	xhr.send(data);
}
function obs_view(div,url,alum_curs_para_codi){
	document.getElementById(div).innerHTML='<div align="center" style="height:100%;"><img src="../imagenes/ajax-loader.gif"/></div>';
	var data = new FormData();
	data.append('alum_curs_para_codi', alum_curs_para_codi);
	data.append('opc', 'obs_view');
		
	var xhr = new XMLHttpRequest();
	xhr.open('POST', url , true);
	xhr.onreadystatechange=function(){
		if (xhr.readyState==4 && xhr.status==200){
			if(xhr.responseText=="OK"){
				document.getElementById(div).innerHTML=xhr.responseText;
			}else{
				document.getElementById(div).innerHTML=xhr.responseText;
			}
		} 
	}
	xhr.send(data);
}