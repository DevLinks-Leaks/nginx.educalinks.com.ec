
// JavaScript Document


function agen_add(div,url,curs_para_mate_prof_codi,curs_para_mate_codi)
{
	document.getElementById(div).innerHTML='<div align="center" style="height:100%;"><img src="../imagenes/ajax-loader.gif"/></div>';
	var data = new FormData();
	var fecha_ini_dia,fecha_ini_mes,fecha_ini_ano,fecha_ini;
	fecha_ini_dia=document.getElementById('agen_fech_ini').value.substring(0,2);
	fecha_ini_mes=document.getElementById('agen_fech_ini').value.substring(3,5);
	fecha_ini_ano=document.getElementById('agen_fech_ini').value.substring(6,11);
	fecha_ini=fecha_ini_ano+""+fecha_ini_mes+""+fecha_ini_dia;
	var fecha_fin_dia,fecha_fin_mes,fecha_fin_ano,fecha_fin;
	fecha_fin_dia=document.getElementById('agen_fech_fin').value.substring(0,2);
	fecha_fin_mes=document.getElementById('agen_fech_fin').value.substring(3,5);
	fecha_fin_ano=document.getElementById('agen_fech_fin').value.substring(6,11);
	fecha_fin=fecha_fin_ano+""+fecha_fin_mes+""+fecha_fin_dia;
	
	data.append('curs_para_mate_prof_codi', curs_para_mate_prof_codi);
	data.append('agen_fech_ini', fecha_ini);
	data.append('agen_fech_fin', fecha_fin);
	data.append('agen_deta', document.getElementById('agen_deta').value);
	data.append('agen_titu', document.getElementById('agen_titu').value);
	data.append('opc', 'agen_add');
		
	var xhr = new XMLHttpRequest();
	xhr.open('POST', url , true);
	xhr.onreadystatechange=function(){
		if (xhr.readyState==4 && xhr.status==200){
			if(xhr.responseText=="OK"){
				$.growl.notice({ title: "Informacion: ",message: "¡Se agend&oacute; correctamente!" });
				agen_view(div,url,curs_para_mate_prof_codi,curs_para_mate_codi,'T');
			}else{
				$.growl.error({ title: "Informacion: ",message: "Ocurri&oacute; un error al agendar" });
				agen_view(div,url,curs_para_mate_prof_codi,curs_para_mate_codi,'T');
			}
		}
	}
	xhr.send(data);
}
function agen_view(div,url,curs_para_mate_prof_codi,curs_para_mate_codi,tipo)
{
		document.getElementById(div).innerHTML='<div align="center" style="height:100%;"><img src="../imagenes/ajax-loader.gif"/></div>';
		var data = new FormData();
		data.append('curs_para_mate_prof_codi', curs_para_mate_prof_codi);
		data.append('curs_para_mate_codi', curs_para_mate_codi);
		data.append('tipo', tipo);
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
 
function agen_del(agen_codi)
{
	if (confirm("Esta seguro que desea Eliminar")) {
		
		url='script_agen.php';
		var data = new FormData();
		data.append('agen_codi', agen_codi);	
		data.append('opc', 'agen_del');
			
		var xhr = new XMLHttpRequest();
		xhr.open('POST', url , true);
		xhr.onreadystatechange=function(){
			if (xhr.readyState==4 && xhr.status==200){
				$.growl.notice({ title: "Informacion: ",message: "¡Se Elimino registro correctamente!" });
			} 
		}
		xhr.send(data);
	}	
	 
}