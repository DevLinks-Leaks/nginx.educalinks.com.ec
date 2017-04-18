function indi_del(indi_codi){
		if (confirm("Esta seguro que desea Eliminar" + indi_codi )) {					 
				load_ajax('indi_main','indicadores_main_lista.php','indi_codi=' + indi_codi + '&del_indi=Y'); 					
		}
}

function indi_add_upd(){
 	if (document.getElementById('n_que').value=='N'){
		load_ajax('indi_main','indicadores_main_lista.php','indi_deta=' 
		  		+ document.getElementById('n_indi_deta').value  
				+ '&valo_codi=' + document.getElementById('n_valo_codi').value + '&add_indi=Y');		
	}else{
		url='indi_codi=' + document.getElementById('n_indi_codi').value
		url+= '&indi_deta=' + document.getElementById('n_indi_deta').value 
		url+= '&valo_codi=' + document.getElementById('n_valo_codi').value 
		url+= '&upd_indi=Y';
		load_ajax('indi_main','indicadores_main_lista.php',url);
	}
}


function indi_nuev_dial(){
	
	document.getElementById('n_valo_codi').value='';	
	document.getElementById('n_indi_deta').value='';
	document.getElementById('n_que').value='N';
}

function indi_upda_dial(indi_codi,indi_deta,valo_codi){
	document.getElementById('n_que').value='U';
	document.getElementById('n_indi_codi').value=indi_codi;	
	document.getElementById('n_indi_deta').value=indi_deta;
	document.getElementById('n_valo_codi').value=valo_codi;
	
}