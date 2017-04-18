function carga_permisos(div,url,rol_usuario,a){
	if (rol_usuario>0){
		var data = new FormData();
		data.append('rol_usuario', rol_usuario);
		data.append('opc', 'carga_permisos');
		data.append('a', a);
		var xhr = new XMLHttpRequest();
		xhr.open('POST', url , true);
		
		xhr.onreadystatechange=function(){
			if (xhr.readyState==4 && xhr.status==200){
			$.growl.notice({ title: "Educalinks informa ",message: "Lista de permisos cargada" });
			document.getElementById(div).innerHTML=xhr.responseText;
			$('#permi_ul').bonsai({  expandAll: true,  checkboxes: true, createCheckboxes: true});
			} 
		};
		xhr.send(data);
	}else{
		document.getElementById(div).innerHTML="<input type='hidden' id='a' name='a' value='"+a+"'/>";
	}
}
function graba_permi(check,url,tipo_permi,rol_usuario){
	var cbox;
	cbox=document.getElementById('checkbox-'+check);
	var data = new FormData();
	data.append('rol_usuario', rol_usuario);
	data.append('tipo_permi', tipo_permi);
	if (cbox.indeterminate==true || cbox.checked==true){
		data.append('opc', 'graba_permi');
		if(cbox.indeterminate==true){
			data.append('tipo_activo', 'IND');
		}else{
			data.append('tipo_activo', 'ACT');
		}
	}else{
		data.append('opc', 'borra_permi');
		data.append('tipo_activo', 'ACT');
	}
	var xhr = new XMLHttpRequest();
	xhr.open('POST', url , true);
	xhr.onreadystatechange=function(){
		if (xhr.readyState==4 && xhr.status==200){
			$.growl.notice({ title: "Educalinks informa ",message: "Proceso realizado" });
		
		} 
	};
	xhr.send(data);
}