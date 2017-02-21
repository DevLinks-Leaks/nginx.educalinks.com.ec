function actualiza_hora_fin(hora,intervalo){
	var hora_ini;
	var min_ini;
	var min_fin; 
	var hora_fin;
	hora_ini=parseInt(hora.substring(0,2));
	min_ini=parseInt(hora.substring(3,5));
	
	if((parseInt(min_ini)+parseInt(intervalo))>=60){
		hora_fin=parseInt(hora_ini)+1;
		if((parseInt(min_ini)+parseInt(intervalo))==60){
			min_fin=parseInt(0);
		}else{
			min_fin=(parseInt(min_ini)+parseInt(intervalo))-60;
		}
	}else{
		hora_fin=parseInt(hora_ini);
		min_fin=parseInt(min_ini)+parseInt(intervalo);
	}
	if(parseInt(hora_fin)<10){hora_fin="0"+hora_fin;}
	if(parseInt(min_fin)<10){min_fin="0"+min_fin;}
	document.getElementById('horario_fin').value=hora_fin+":"+min_fin;
}
function hora_aten_add(div,url,prof_codi,peri_codi){
	document.getElementById(div).innerHTML='<div align="center" style="height:100%;"><img src="../imagenes/ajax-loader.gif"/></div>';
	var data = new FormData();
	data.append('prof_codi', prof_codi);
	data.append('peri_codi', peri_codi);
	data.append('dia_week', document.getElementById('dia_week').value);
	data.append('hora_ini', $('.horario_ini').val());
	data.append('hora_fin', $('.horario_fin').val());
	data.append('opc', 'hora_aten_add');
		
	var xhr = new XMLHttpRequest();
	xhr.open('POST', url , true);
	xhr.onreadystatechange=function(){
		if (xhr.readyState==4 && xhr.status==200){
			if(xhr.responseText>0){
				$.growl.notice({ title: "Listo!",message: "Se guardaron correctamente los datos del horario de atenci&oacute;n del profesor." });
				hora_aten_view(div,'profesores_horario_lista.php',prof_codi);
			}else if (xhr.responseText==-2){
				$.growl.error({ title: "Error!",message: "Error: El horario final debe ser mayor al horario inical. " });
				hora_aten_view(div,'profesores_horario_lista.php',prof_codi);
			}else if (xhr.responseText==-3){
				$.growl.error({ title: "Error!",message: "Error: Existe un cruce de horario. Favor ingresar el rango de horario nuevamente. " });
				hora_aten_view(div,'profesores_horario_lista.php',prof_codi);
			}else{
				$.growl.error({ title: "Atención!",message: "Ocurrió un error al grabar los datos del horario de atenci&oacute;n del profesor." });
				hora_aten_view(div,'profesores_horario_lista.php',prof_codi);
			}
		} 
	}
	xhr.send(data);
}
function hora_aten_del(div,url,hora_codi,prof_codi){
	document.getElementById(div).innerHTML='<div align="center" style="height:100%;"><img src="../imagenes/ajax-loader.gif"/></div>';
	var data = new FormData();
	data.append('hora_codi', hora_codi);
	data.append('opc', 'hora_aten_del');
		
	var xhr = new XMLHttpRequest();
	xhr.open('POST', url , true);
	xhr.onreadystatechange=function(){
		if (xhr.readyState==4 && xhr.status==200){
			if(xhr.responseText>0){
				$.growl.notice({ title: "Listo!",message: "Se eliminaron correctamente los datos del horario de atenci&oacute;n del profesor." ,duration: 6000 });
				hora_aten_view(div,'profesores_horario_lista.php',prof_codi)
			}else{
				$.growl.error({ title: "Atención!",message: "Ocurri&oacute; un error al eliminar los datos del horario de atenci&oacute;n del profesor." });
				hora_aten_view(div,'profesores_horario_lista.php',prof_codi)
			}
		} 
	}
	xhr.send(data);
}
function hora_aten_view(div,url,prof_codi){
	document.getElementById(div).innerHTML='<div align="center" style="height:100%;"><img src="../imagenes/ajax-loader.gif"/></div>';
	var data = new FormData();
	data.append('prof_codi', prof_codi);
		
	var xhr = new XMLHttpRequest();
	xhr.open('POST', url , true);
	xhr.onreadystatechange=function(){
		if (xhr.readyState==4 && xhr.status==200){
			document.getElementById(div).innerHTML=xhr.responseText;
		} 
	}
	xhr.send(data);
}