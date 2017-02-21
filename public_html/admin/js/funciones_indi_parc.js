function indi_parc_del(indi_parc_codi)
{
	if (confirm("Esta seguro que desea Eliminar" + indi_parc_codi )) 
	{					 
			load_ajax('indi_parc_main','evaluacion_comportamiento_main_lista.php','indi_parc_codi=' + indi_parc_codi + '&del_indi_parc=Y'); 					
	}
}

function indi_parc_add()
{
	load_ajax('indi_parc_main','evaluacion_comportamiento_main_lista.php','indi_codi=' 
			+ document.getElementById('sl_indicador').value  
			+ '&peri_dist_codi=' + document.getElementById('sl_peri_dist').value + '&add_indi_parc=Y');		
}


function indi_view(valo_codi,div)
{		   
	
		url='sl_indicadores.php';
	 
		   	
		var data = new FormData();
		data.append('valo_codi', valo_codi);		
		
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