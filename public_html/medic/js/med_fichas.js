/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
function carga_fichas(div,url){
    document.getElementById(div).innerHTML='<div align="center" style="height:100%;"><img src="images/ajax-loader.gif"/></div>';
    var data = new FormData();
    data.append('option','carga_fichas');
    var xhr_tick_ok = new XMLHttpRequest();
    xhr_tick_ok.open('POST', url , true);
    xhr_tick_ok.onreadystatechange=function(){
        if (xhr_tick_ok.readyState==4 && xhr_tick_ok.status==200){
            document.getElementById(div).innerHTML=xhr_tick_ok.responseText;
        }
    }
    xhr_tick_ok.send(data);
}
function carga_fichas_campos(div,url,fic_codigo){
    document.getElementById(div).innerHTML='<div align="center" style="height:100%;"><img src="images/ajax-loader.gif"/></div>';
    var data = new FormData();
    data.append('option','carga_campos');
	data.append('fic_codigo',fic_codigo);
    var xhr_tick_ok = new XMLHttpRequest();
    xhr_tick_ok.open('POST', url , true);
    xhr_tick_ok.onreadystatechange=function(){
        if (xhr_tick_ok.readyState==4 && xhr_tick_ok.status==200){
            document.getElementById(div).innerHTML=xhr_tick_ok.responseText;
			$('#table_preguntas').DataTable({select: false,lengthChange: false,searching: false,language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'}});
			if (fic_codigo!=''){$('#btn_pregunta_add').prop('disabled', false);}else{$('#btn_pregunta_add').prop('disabled', true);}
        }
    }
    xhr_tick_ok.send(data);
}
function agrega_ficha(div,url,fic_nombre){
    
	if(fic_nombre!=""){
		document.getElementById(div).innerHTML='<div align="center" style="height:100%;"><img src="images/ajax-loader.gif"/></div>';    
		var data = new FormData();
		data.append('option','agrega_ficha');
		data.append('fic_nombre',fic_nombre);
		var xhr_tick_ok = new XMLHttpRequest();
		xhr_tick_ok.open('POST', url , true);
		xhr_tick_ok.onreadystatechange=function(){
			if (xhr_tick_ok.readyState==4 && xhr_tick_ok.status==200){
				document.getElementById(div).innerHTML=xhr_tick_ok.responseText;
				carga_fichas_campos('campos_div',url,document.getElementById('fic_codigo').value);
				document.getElementById('nombre_ficha').value="";
			}
		}
		xhr_tick_ok.send(data);
	}else{
		alert("Por favor ingresar un nombre para la ficha.");
	}
}
function agrega_campo(div,url){
    document.getElementById(div).innerHTML='<div align="center" style="height:100%;"><img src="images/ajax-loader.gif"/></div>';    
    var data = new FormData();
    data.append('option','agrega_campo');
    data.append('fic_codigo',document.getElementById('fic_codigo').value);
	data.append('fic_cam_pregunta',document.getElementById('nombre_campo').value);
	data.append('fic_cam_tipo',document.getElementById('tipo_campo').value);
    var xhr_tick_ok = new XMLHttpRequest();
    xhr_tick_ok.open('POST', url , true);
    xhr_tick_ok.onreadystatechange=function(){
        if (xhr_tick_ok.readyState==4 && xhr_tick_ok.status==200){
            document.getElementById(div).innerHTML=xhr_tick_ok.responseText;
			$('#table_preguntas').DataTable({select: false,lengthChange: false,searching: false,language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'}});
        }
    }
    xhr_tick_ok.send(data);
}
function borra_campo(div,url,fic_cam_codigo){
    document.getElementById(div).innerHTML='<div align="center" style="height:100%;"><img src="images/ajax-loader.gif"/></div>';    
    var data = new FormData();
    data.append('option','borra_campo');
    data.append('fic_codigo',document.getElementById('fic_codigo').value);
	data.append('fic_cam_codigo',fic_cam_codigo);
    var xhr_tick_ok = new XMLHttpRequest();
    xhr_tick_ok.open('POST', url , true);
    xhr_tick_ok.onreadystatechange=function(){
        if (xhr_tick_ok.readyState==4 && xhr_tick_ok.status==200){
            document.getElementById(div).innerHTML=xhr_tick_ok.responseText;
			$('#table_preguntas').DataTable({select: false,lengthChange: false,searching: false,language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'}});
        }
    }
    xhr_tick_ok.send(data);
}
function carga_editar(fic_cam_codigo,fic_cam_pregunta,tipo_campo_edit){
	document.getElementById('fic_cam_codigo_edit').value=fic_cam_codigo;
	document.getElementById('nombre_campo_edit').value=fic_cam_pregunta;
	$("#tipo_campo_edit").val(tipo_campo_edit);
}
function edita_campo(div,url,fic_cam_codigo){
    document.getElementById(div).innerHTML='<div align="center" style="height:100%;"><img src="images/ajax-loader.gif"/></div>';    
    var data = new FormData();
    data.append('option','edita_campo');
    data.append('fic_codigo',document.getElementById('fic_codigo').value);
	data.append('fic_cam_pregunta',document.getElementById('nombre_campo_edit').value);
	data.append('fic_cam_tipo',document.getElementById('tipo_campo_edit').value);
	data.append('fic_cam_codigo',fic_cam_codigo);
    var xhr_tick_ok = new XMLHttpRequest();
    xhr_tick_ok.open('POST', url , true);
    xhr_tick_ok.onreadystatechange=function(){
        if (xhr_tick_ok.readyState==4 && xhr_tick_ok.status==200){
            document.getElementById(div).innerHTML=xhr_tick_ok.responseText;
			$('#table_preguntas').DataTable({select: false,lengthChange: false,searching: false,language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'}});
        }
    }
    xhr_tick_ok.send(data);
}
function carga_respuestas(div,url,fic_cam_codigo){
    document.getElementById(div).innerHTML='<div align="center" style="height:100%;"><img src="images/ajax-loader.gif"/></div>';    
    var data = new FormData();
    data.append('option','carga_respuestas');    
	data.append('fic_cam_codigo',fic_cam_codigo);
    var xhr_tick_ok = new XMLHttpRequest();
    xhr_tick_ok.open('POST', url , true);
    xhr_tick_ok.onreadystatechange=function(){
        if (xhr_tick_ok.readyState==4 && xhr_tick_ok.status==200){
            document.getElementById(div).innerHTML=xhr_tick_ok.responseText;
			$('#table_respuestas').DataTable({select: false,lengthChange: false,searching: false,language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'}});
        }
    }
    xhr_tick_ok.send(data);
}
function agrega_respuesta(div,url,fic_cam_codigo){
	if(document.getElementById('respuesta').value!=""){
		document.getElementById(div).innerHTML='<div align="center" style="height:100%;"><img src="images/ajax-loader.gif"/></div>';
		var data = new FormData();
		data.append('option','agrega_respuesta');    
		data.append('fic_cam_codigo',fic_cam_codigo);
		data.append('fic_cam_resp_respuesta',document.getElementById('respuesta').value);
		var xhr_tick_ok = new XMLHttpRequest();
		xhr_tick_ok.open('POST', url , true);
		xhr_tick_ok.onreadystatechange=function(){
			if (xhr_tick_ok.readyState==4 && xhr_tick_ok.status==200){
				document.getElementById(div).innerHTML=xhr_tick_ok.responseText;
				carga_respuestas(div,url,fic_cam_codigo);
			}
		}
		xhr_tick_ok.send(data);
	}else{
		alert("Por favor ingrese una respuesta.");
	}
}
function borra_respuesta(div,url,fic_cam_resp_codigo,fic_cam_codigo){
    document.getElementById(div).innerHTML='<div align="center" style="height:100%;"><img src="images/ajax-loader.gif"/></div>';    
    var data = new FormData();
    data.append('option','borra_respuesta');    
	data.append('fic_cam_codigo',fic_cam_codigo);
	data.append('fic_cam_resp_codigo',fic_cam_resp_codigo);
    var xhr_tick_ok = new XMLHttpRequest();
    xhr_tick_ok.open('POST', url , true);
    xhr_tick_ok.onreadystatechange=function(){
        if (xhr_tick_ok.readyState==4 && xhr_tick_ok.status==200){
            document.getElementById(div).innerHTML=xhr_tick_ok.responseText;
			carga_respuestas(div,url,fic_cam_codigo);
        }
    }
    xhr_tick_ok.send(data);
}
function carga_preguntas(div,url,fic_codigo){
    document.getElementById(div).innerHTML='<div align="center" style="height:100%;"><img src="images/ajax-loader.gif"/></div>';
    var data = new FormData();
    data.append('option','carga_preguntas');
	data.append('fic_codigo',fic_codigo);
    var xhr_tick_ok = new XMLHttpRequest();
    xhr_tick_ok.open('POST', url , true);
    xhr_tick_ok.onreadystatechange=function(){
        if (xhr_tick_ok.readyState==4 && xhr_tick_ok.status==200){
            document.getElementById(div).innerHTML=xhr_tick_ok.responseText;
        }
    }
    xhr_tick_ok.send(data);
}