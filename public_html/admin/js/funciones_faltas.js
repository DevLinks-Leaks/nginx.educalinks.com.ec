 function alum_curs_para_falt_add(){	
		   
	 	url='cursos_paralelo_falt_alum_main_view.php';
		div='curs_para_view_falt';
		
		curs_para_codi =		document.getElementById('curs_para_codi').value ;	
					 
	 	falt_tipo_codi= 		document.getElementById('f_falt_tipo_codi').value;
	  	alum_curs_para_codi= 	document.getElementById('f_alum_curs_para_codi').value ;
	  	falt_fech= 				document.getElementById('f_falt_fech').value ;
		peri_dist_codi =		document.getElementById('f_peri_dist_codi').value ;
	  	
		
		var data = new FormData();		
		data.append('curs_para_codi', curs_para_codi);		
		
		data.append('falt_tipo_codi', falt_tipo_codi);	
		data.append('alum_curs_para_codi', alum_curs_para_codi);
		data.append('falt_fech', falt_fech);		
		data.append('peri_dist_codi', peri_dist_codi);		
		data.append('add_falt', 'Y');
		
		
		var xhr = new XMLHttpRequest();
		xhr.open('POST', url , true);
		xhr.onload = function () {
		// do something to response
		console.log(this.responseText);
		};
		xhr.onreadystatechange=function(){
		if (xhr.readyState==4 && xhr.status==200){
		  $.growl.notice({ title: "Informacion: ",message: "Falta Agregada" });	
		  document.getElementById(div).innerHTML=xhr.responseText;	
		} 
		
		}
		xhr.send(data);
		
	 
		  	  
	 		  
}
	function falt_set(alum_codi,alum_nomb,alum_curs_para_codi){
			document.getElementById('lb_nombre').innerHTML= alum_nomb;
			document.getElementById('f_codi_alum').value=alum_codi;
		 	document.getElementById('f_alum_curs_para_codi').value=alum_curs_para_codi;
		
		}
		
 function alum_curs_para_falt_del(falt_codi){	
	if (confirm("Esta seguro que desea Eliminar")) {

	 	url='cursos_paralelo_falt_alum_main_deta_view.php';
		div='curs_para_view_falt';
		
		alum_curs_para_codi =	document.getElementById('alum_curs_para_codi').value ;	
	   	
		
		var data = new FormData();		
	 
		data.append('falt_codi', falt_codi);	
		data.append('alum_curs_para_codi', alum_curs_para_codi); 
		data.append('del_falt', 'Y');
		
		
		var xhr = new XMLHttpRequest();
		xhr.open('POST', url , true);
		xhr.onload = function () {
		// do something to response
		console.log(this.responseText);
		};
		xhr.onreadystatechange=function(){
		if (xhr.readyState==4 && xhr.status==200){
		  $.growl.notice({ title: "Informacion: ",message: "Falta Eliminada" });	
		  document.getElementById(div).innerHTML=xhr.responseText;	
		} 
		
		}
		xhr.send(data);
		
	 }
		  	  
	 		  
}