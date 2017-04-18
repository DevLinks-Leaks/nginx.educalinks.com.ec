
function peri_nue(){
	 
	 document.getElementById('n_do').value='N';
	 document.getElementById('peri_deta').value='';
	 document.getElementById('peri_deta').value='';
	 document.getElementById('modaltitu').innerHTML = 'Nuevo Periodo'
					 
} 
 
		 
function peri_edi(peri_codi,peri_deta,peri_ano){
	 
	 document.getElementById('n_do').value='E';
	  document.getElementById('n_modaltitu').innerHTML = 'Editar Periodo Codigo:' + peri_codi;
	  document.getElementById('n_peri_codi').value=peri_codi;
	  document.getElementById('n_peri_deta').value=peri_deta;
	  document.getElementById('n_peri_ano').value=peri_ano
		 
} 


function peri_aceptar(){
	 
	 if (document.getElementById('n_do').value=='N'){
		load_ajax('curs_peri_main','admin_periodos_lista.php','peri_deta=' + document.getElementById('n_peri_deta').value   + '&peri_ano=' + document.getElementById('n_peri_ano').value   +'&add_peri=Y');  
	}else{
	 if (confirm("Esta seguro que desea Actualizar"  )) {				
			 
		load_ajax('curs_peri_main','admin_periodos_lista.php','peri_codi=' +  document.getElementById('n_peri_codi').value + '&peri_deta=' +  document.getElementById('n_peri_deta').value  + '&peri_ano=' + document.getElementById('n_peri_ano').value   + '&upd_peri=Y'); 
				  
				 
		}
		
	}
 
		 
}



function peri_del(peri_codi){
	  if (confirm("Esta seguro que desea Eliminar" + peri_codi )) {					 
		  load_ajax('curs_peri_main','admin_periodos_lista.php','peri_codi=' + peri_codi + '&del_peri=Y'); 					
	  }				
}
 