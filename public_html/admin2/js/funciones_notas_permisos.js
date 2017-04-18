function radio_opcion(opcion){	
	 if(document.getElementById('radio_op2').checked) {
	  return 2
	}else if(document.getElementById('radio_op3').checked) {
	   return 3
	}else if(document.getElementById('radio_op4').checked) {
		return 4
	}

}
	

function nota_perm_del(nota_perm_codi,curs_para_mate_codi,curs_para_mate_prof_codi){		   
	if (confirm("Esta seguro que desea Eliminar")) {

		url='cursos_notas_permisos_main_deta_view.php?curs_para_mate_codi=' + curs_para_mate_codi + '&curs_para_mate_prof_codi=' + curs_para_mate_prof_codi + '&nota_perm_codi=' + nota_perm_codi + '&nota_perm_del=Y';
	 	div='curs_para_main_perm_deta';
		   	
		document.getElementById(div).innerHTML='<div align="center" style="height:100%;"><img src="../imagenes/ajax-loader.gif"/></div>';
		if (window.XMLHttpRequest)
		{// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		}
		else
		{// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=function()
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200){
				document.getElementById(div).innerHTML=xmlhttp.responseText;	
			}
		}
		xmlhttp.open("GET",url,true);	 
		xmlhttp.send();
	
	}		
			
}
	
function nota_perm_add(opcion){		   
	
		url='script_notas_permisos.php';
	 
		//individual de profesro y lamateria del curso
		if (opcion==1){ 
			vari_codi= (selectvalue(document.getElementById('pi_profesor_materia')));
			peri_dist_codi = document.getElementById('pi_peri_dist_codi').value;
			
			nota_peri_fec_ini = parseInt(document.getElementById('pi_nota_peri_fec_ini').value.replace(/-/g,''));
			nota_peri_fec_fin = parseInt(document.getElementById('pi_nota_peri_fec_fin').value.replace(/-/g,''));
		}else{
			peri_dist_codi = document.getElementById('pg_peri_dist_codi').value;
			nota_peri_fec_ini = parseInt(document.getElementById('pg_nota_peri_fec_ini').value.replace(/-/g,''));
			nota_peri_fec_fin = parseInt( document.getElementById('pg_nota_peri_fec_fin').value.replace(/-/g,''));
		
			// PEridodo Completo
			if (opcion==2) vari_codi= document.getElementById('peri_codi').value;
			
			// Materias de un Curso
			if (opcion==3) vari_codi= selectvalue(document.getElementById('pg_curs_para_codi'));
			
			// Materias de un Profesor en varios Curso
			if (opcion==4) vari_codi= selectvalue(document.getElementById('pg_prof_codi'));
		 
		}
		
		 
		usua_codi = document.getElementById('mens_de').value;
	
		 
		var data = new FormData();
		data.append('opcion', opcion);
		data.append('vari_codi', vari_codi);
		data.append('peri_dist_codi', peri_dist_codi);
		
		data.append('nota_peri_fec_ini', nota_peri_fec_ini);
		data.append('nota_peri_fec_fin', nota_peri_fec_fin);
		data.append('usua_codi', usua_codi);
		
		data.append('nota_perm_add', 'Y');
			
		
		
		var xhr = new XMLHttpRequest();
		xhr.open('POST', url , true);
		xhr.onload = function () {
		// do something to response
		console.log(this.responseText);
		};
		xhr.onreadystatechange=function(){
		if (xhr.readyState==4 && xhr.status==200){
			$.growl.notice({ title: "Informacion: ",message: "Permisos Asignados" });	
			document.getElementById(div).innerHTML=xhr.responseText;	
		} 
		
		}
		xhr.send(data);
					
			  
}

function curs_peri_mate_view(curs_para_codi,div,pgi){		   
	
		url='cursos_notas_permisos_main_view_diag.php';
	 
		   	
		var data = new FormData();
		data.append('curs_para_codi', curs_para_codi);	
		data.append('pgi', pgi);	
		
		var xhr = new XMLHttpRequest();
		xhr.open('POST', url , true);
		xhr.onload = function () {
		// do something to response
		console.log(this.responseText);
		};
		xhr.onreadystatechange=function(){
		if (xhr.readyState==4 && xhr.status==200){
			//$.growl.notice({ title: "Informacion: ",message: "Notas Grabadas" });	
			document.getElementById(div).innerHTML=xhr.responseText;	
		} 
		
		}
		xhr.send(data);
}