 function peri_dist_peri_libt_view(peri_codi,peri_etap_codi_unid){	
 		 
		 
	 	peri_etap_codi=peri_etap_codi_unid.substr(0, 1);
	 	peri_etap_unid=peri_etap_codi_unid.substr(2, 3);
	 
		
		if (peri_etap_unid=='A'){			
			document.getElementById('n_peri_dist_codi').style.display="block";
			 
		}else{
			document.getElementById('n_peri_dist_codi').style.display="none";
		}
}
		
  function peri_acti_add(peri_codi){	
  
  		peri_etap_codi_unid =document.getElementById('n_peri_etap_codi').value
  		peri_etap_codi=peri_etap_codi_unid.substr(0, 1);
	 	peri_etap_unid=peri_etap_codi_unid.substr(2, 3);   
		
		if (peri_etap_unid=='A'){			
			 peri_dist_codi=document.getElementById('n_peri_dist_codi').value			 
		}else{
			 peri_dist_codi=-1
		}
	 	peri_fech_ini = parseInt(document.getElementById('n_peri_fech_ini').value.replace(/-/g,''));
		peri_fech_fin = parseInt(document.getElementById('n_peri_fech_fin').value.replace(/-/g,''));
		 
		usua_codi = document.getElementById('mens_de').value;
	
		 
		url='script_peri_acti.php';
		
		var data = new FormData();
		data.append('peri_codi', peri_codi);
		data.append('peri_fech_ini', peri_fech_ini);
		data.append('peri_fech_fin', peri_fech_fin);
		
		data.append('peri_etap_codi', peri_etap_codi);
		data.append('peri_dist_codi', peri_dist_codi);
		data.append('usua_codi', usua_codi);
		
		data.append('peri_acti_add', 'Y');
			
		
		
		var xhr = new XMLHttpRequest();
		xhr.open('POST', url , true);
		xhr.onload = function () {
		// do something to response
		console.log(this.responseText);
		};
		xhr.onreadystatechange=function(){
		if (xhr.readyState==4 && xhr.status==200){
			peri_etap_view();
			$.growl.notice({ title: "Informacion: ",message: "Activación de Permiso Realizada" });	
			document.getElementById(div).innerHTML=xhr.responseText;
			 	
		} 
		
		}
		xhr.send(data);
					
			  
}

 function peri_acti_del(peri_acti_codi){
	 		 			
		if (confirm("Esta seguro que desea Eliminar")) {
			
			usua_codi = document.getElementById('mens_de').value;		 
			url='script_peri_acti.php';
		
			var data = new FormData();
			data.append('peri_acti_codi', peri_acti_codi);	 
			data.append('peri_acti_del', 'Y');
		
			var xhr = new XMLHttpRequest();
			xhr.open('POST', url , true);
			xhr.onload = function () {
			// do something to response
			console.log(this.responseText);
			};
			xhr.onreadystatechange=function(){
			if (xhr.readyState==4 && xhr.status==200){
				peri_etap_view();
				$.growl.warning({ title: "Informacion: ",message: "Eliminacion realizada con exito" });	
				document.getElementById(div).innerHTML=xhr.responseText;
					
			} 
			
			}
			xhr.send(data);
		}			
			  
}

function peri_etap_view(){
	 
			url='admin_periodos_etapas_view.php' + '?peri_codi=' + document.getElementById('e_peri_codi').value; 
			div='peri_etap_view' ;
				
			load_ajax_get(div,url);
	
}


 function peri_dist_del_all(peri_dist_copy_all){
	 		 			
		if (confirm("Esta seguro que desea Eliminar, esto se perdera todo registro de notas realizado del periodo")) {
			
			 	 
			url='script_peri_acti.php';
		
			var data = new FormData();
			data.append('peri_codi', peri_codi);	 
			data.append('peri_dist_copy_all', 'Y');
		
			var xhr = new XMLHttpRequest();
			xhr.open('POST', url , true);
			xhr.onload = function () {
			// do something to response
			console.log(this.responseText);
			};
			xhr.onreadystatechange=function(){
			if (xhr.readyState==4 && xhr.status==200){
				peri_etap_view();
				$.growl.warning({ title: "Informacion: ",message: "Eliminacion realizada con exito" });	
				document.getElementById(div).innerHTML=xhr.responseText;
					
			} 
			
			}
			xhr.send(data);
		}			
			  
}


function peri_dist_codi_view_in_acc(peri_dist_codi){
	if (peri_dist_codi >= 0 ){
		nota_refe_cab_codi=selectvalue(document.getElementById('cb_nota_refe_cab_codi'));
		if (peri_dist_codi == 0 ){
			peri_dist_codi=document.getElementById('peri_dist_codi_in').value;
		}
		
		load_ajax('acc_nota','admin_periodos_notas_view_script_acc.php','peri_dist_codi='  + peri_dist_codi + '&nota_refe_cab_codi=' + nota_refe_cab_codi);
		load_ajax2('in_notas','admin_periodos_notas_view_script_in.php','peri_dist_codi='  + peri_dist_codi + '&nota_refe_cab_codi=' + nota_refe_cab_codi);
	}
}

function peri_dist_in_add(){
	//EXTRA PARA CARGA 
	peri_dist_codi=document.getElementById('in_peri_dist_codi').value;
	
	
	// DATOS PARA PROCEDIMIENTIO
	peri_dist_cab_codi 	=	document.getElementById('in_peri_dist_cab_codi').value;
	peri_dist_deta		=	document.getElementById('in_peri_dist_deta').value;
	peri_dist_padr		=	document.getElementById('in_peri_dist_codi').value;
	
	peri_dist_nota_tipo =	'IN';	
	peri_dist_nive		=	3	
	peri_dist_abre		=	document.getElementById('in_peri_dist_abre').value;
	
	
	peri_dist_libt		=	'N';
	nota_refe_cab_codi  =	document.getElementById('in_nota_refe_cab_codi').value; 
	
	
	url='script_peri_dist.php';
		
	var data = new FormData();
	data.append('peri_dist_cab_codi', peri_dist_cab_codi);	 
	data.append('peri_dist_deta', peri_dist_deta);
	data.append('peri_dist_padr', peri_dist_padr);	 
	
	data.append('peri_dist_nota_tipo', peri_dist_nota_tipo);	 
	data.append('peri_dist_nive', peri_dist_nive);	 
	data.append('peri_dist_abre', peri_dist_abre);	 
	
	data.append('peri_dist_libt', peri_dist_libt);	 
	data.append('nota_refe_cab_codi', nota_refe_cab_codi);	 
	
	data.append('peri_dist_codi_ADD', 'Y');

	var xhr = new XMLHttpRequest();
	xhr.open('POST', url , true);
	xhr.onload = function () {
	// do something to response
	console.log(this.responseText);
	};
	xhr.onreadystatechange=function(){
	if (xhr.readyState==4 && xhr.status==200){		
		$.growl.warning({ title: "Informacion: ",message: "Agrego Correctamente" });	
		//alert(xhr.responseText);
		load_ajax('acc_nota','admin_periodos_notas_view_script_acc.php','peri_dist_codi='  + peri_dist_codi + '&nota_refe_cab_codi=' + nota_refe_cab_codi);
		load_ajax2('in_notas','admin_periodos_notas_view_script_in.php','peri_dist_codi='  + peri_dist_codi + '&nota_refe_cab_codi=' + nota_refe_cab_codi);
			
	} 
	
	}
	xhr.send(data);
			

}


function peri_dist_in_del(peri_dist_codi){	
	
	
	if (confirm("Esta seguro que desea Eliminar?")) {
		url='script_peri_dist.php';
			
		var data = new FormData();
		data.append('peri_dist_codi', peri_dist_codi);	
		data.append('peri_dist_codi_DEL', 'Y');
	
		var xhr = new XMLHttpRequest();
		xhr.open('POST', url , true);
		xhr.onload = function () {
		// do something to response
		console.log(this.responseText);
		};
		xhr.onreadystatechange=function(){
		if (xhr.readyState==4 && xhr.status==200){		
			$.growl.warning({ title: "Informacion: ",message: "Elimino Correctamente" });	
			//EXTRA PARA CARGA 
			peri_dist_codi		=	document.getElementById('in_peri_dist_codi').value;
			nota_refe_cab_codi  =	document.getElementById('in_nota_refe_cab_codi').value; 	
			load_ajax('acc_nota','admin_periodos_notas_view_script_acc.php','peri_dist_codi='  + peri_dist_codi + '&nota_refe_cab_codi=' + nota_refe_cab_codi);
			load_ajax2('in_notas','admin_periodos_notas_view_script_in.php','peri_dist_codi='  + peri_dist_codi + '&nota_refe_cab_codi=' + nota_refe_cab_codi);
				
		} 
		
		}
		xhr.send(data);
	}
	
}


function nota_refe_pos(nota_refe_opcion,nota_refe_cod){
	
	
	//EXTRA PARA CARGA 
	peri_dist_codi=document.getElementById('in_peri_dist_codi').value;
	nota_refe_cab_codi  =	document.getElementById('in_nota_refe_cab_codi').value; 
	url='script_peri_dist.php';
			
	var data = new FormData();
	data.append('nota_refe_cod', nota_refe_cod);	
	data.append('nota_refe_opcion', nota_refe_opcion);	
	data.append('nota_refe_pos', 'Y');
	
		var xhr_nota_refe_pos = new XMLHttpRequest();
		xhr_nota_refe_pos.open('POST', url , true);
		xhr_nota_refe_pos.onload = function () {
		// do something to response
		console.log(this.responseText);
		};
		xhr_nota_refe_pos.onreadystatechange=function(){
		if (xhr_nota_refe_pos.readyState==4 && xhr_nota_refe_pos.status==200){		
			//$.growl.warning({ title: "Informacion: ",message: "Elimino Correctamente" });	
						 
			//EXTRA PARA CARGA 
			peri_dist_codi		=	document.getElementById('in_peri_dist_codi').value;
			nota_refe_cab_codi  =	document.getElementById('in_nota_refe_cab_codi').value; 	
			load_ajax('acc_nota','admin_periodos_notas_view_script_acc.php','peri_dist_codi='  + peri_dist_codi + '&nota_refe_cab_codi=' + nota_refe_cab_codi);
				
		} 
		
		}
		xhr_nota_refe_pos.send(data);

}

function nota_refe_add(){

	//EXTRA PARA CARGA 
	peri_dist_codi=document.getElementById('in_peri_dist_codi').value;
	nota_refe_cab_codi  =	document.getElementById('in_nota_refe_cab_codi').value; 
	url='script_peri_dist.php';
			
	var data = new FormData();
	data.append('peri_dist_codi', peri_dist_codi);	
	data.append('nota_refe_cab_codi', nota_refe_cab_codi);	
	data.append('nota_refe_add', 'Y');
	
		var xhr = new XMLHttpRequest();
		xhr.open('POST', url , true);
		xhr.onload = function () {
		// do something to response
		console.log(this.responseText);
		};
		xhr.onreadystatechange=function(){
		if (xhr.readyState==4 && xhr.status==200){		
			//$.growl.warning({ title: "Informacion: ",message: "Elimino Correctamente" });	
						 
			//EXTRA PARA CARGA 
			peri_dist_codi		=	document.getElementById('in_peri_dist_codi').value;
			nota_refe_cab_codi  =	document.getElementById('in_nota_refe_cab_codi').value; 	
			load_ajax('acc_nota','admin_periodos_notas_view_script_acc.php','peri_dist_codi='  + peri_dist_codi + '&nota_refe_cab_codi=' + nota_refe_cab_codi);
				
		} 
		
		}
		xhr.send(data);
	
}

function nota_refe_upt_cc(id,nota_refe_cod){

	//EXTRA PARA CARGA 
	peri_dist_codi=document.getElementById('in_peri_dist_codi').value;
	nota_refe_cab_codi  =	document.getElementById('in_nota_refe_cab_codi').value; 
	
	
	 
	nota_refe_cc  =	document.getElementById('nota_refe_cc_' + id).value; 	
	nota_refe_1  =	document.getElementById('nota_refe_1_' + id).value; 
	nota_refe_2  =	document.getElementById('nota_refe_2_' + id).value; 
	nota_refe_num_dec  =	document.getElementById('nota_refe_num_dec_' + id).value; 
	nota_refe_func_dec  =	document.getElementById('nota_refe_func_dec_' + id).value; 
	
	url='script_peri_dist.php';
			
	var data = new FormData();
	data.append('nota_refe_cod', nota_refe_cod);	
	data.append('nota_refe_cc', nota_refe_cc);	
	data.append('nota_refe_1', nota_refe_1);	
	data.append('nota_refe_2', nota_refe_2);	
	data.append('nota_refe_num_dec', nota_refe_num_dec);	
	data.append('nota_refe_func_dec', nota_refe_func_dec);	
	
	data.append('nota_refe_upt_cc', 'Y');
	
		var xhr_nota_refe_upt_cc = new XMLHttpRequest();
		xhr_nota_refe_upt_cc.open('POST', url , true);
		xhr_nota_refe_upt_cc.onload = function () {
		// do something to response
		console.log(this.responseText);
		};
		xhr_nota_refe_upt_cc.onreadystatechange=function(){
		if (xhr_nota_refe_upt_cc.readyState==4 && xhr_nota_refe_upt_cc.status==200){		
			//$.growl.warning({ title: "Informacion: ",message: "Elimino Correctamente" });	
						 
			//EXTRA PARA CARGA 
			peri_dist_codi		=	document.getElementById('in_peri_dist_codi').value;
			nota_refe_cab_codi  =	document.getElementById('in_nota_refe_cab_codi').value; 	
			load_ajax('acc_nota','admin_periodos_notas_view_script_acc.php','peri_dist_codi='  + peri_dist_codi + '&nota_refe_cab_codi=' + nota_refe_cab_codi);
				
		} 
		
		}
		xhr_nota_refe_upt_cc.send(data);
	
}

function nota_refe_del(nota_refe_cod){

	//EXTRA PARA CARGA 
	peri_dist_codi=document.getElementById('in_peri_dist_codi').value;
	nota_refe_cab_codi  =	document.getElementById('in_nota_refe_cab_codi').value; 

	
	url='script_peri_dist.php';
			
	var data = new FormData();
	data.append('nota_refe_cod', nota_refe_cod);	 
	
	data.append('nota_refe_del', 'Y');
	
		var xhr_nota_refe_delc = new XMLHttpRequest();
		xhr_nota_refe_delc.open('POST', url , true);
		xhr_nota_refe_delc.onload = function () {
		// do something to response
		console.log(this.responseText);
		};
		xhr_nota_refe_delc.onreadystatechange=function(){
		if (xhr_nota_refe_delc.readyState==4 && xhr_nota_refe_delc.status==200){		
			//$.growl.warning({ title: "Informacion: ",message: "Elimino Correctamente" });	
						 
			//EXTRA PARA CARGA 
			peri_dist_codi		=	document.getElementById('in_peri_dist_codi').value;
			nota_refe_cab_codi  =	document.getElementById('in_nota_refe_cab_codi').value; 	
			load_ajax('acc_nota','admin_periodos_notas_view_script_acc.php','peri_dist_codi='  + peri_dist_codi + '&nota_refe_cab_codi=' + nota_refe_cab_codi);
				
		} 
		
		}
		xhr_nota_refe_delc.send(data);
	
}





 
