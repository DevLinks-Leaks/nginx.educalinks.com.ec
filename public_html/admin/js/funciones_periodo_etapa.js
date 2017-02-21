function peri_dist_peri_libt_view(peri_codi,peri_etap_codi_unid){	
 		 
		 
	 	peri_etap_codi=peri_etap_codi_unid.substr(0, 1);
	 	peri_etap_unid=peri_etap_codi_unid.substr(2, 3);

		if (peri_etap_unid=='A'){			
			//document.getElementById('n_peri_dist_codi').style.display="block";
			document.getElementById('pg_peri_dist_codi').disabled="";
			document.getElementById('sl_peri_dist_cab').disabled="";

		}else{
			document.getElementById('pg_peri_dist_codi').disabled="disabled";
			document.getElementById('sl_peri_dist_cab').disabled="disabled";
			//document.getElementById('n_peri_dist_codi').style.display="none";
		}
}
		
function peri_acti_add(peri_codi){	
  
  		peri_etap_codi_unid =document.getElementById('n_peri_etap_codi').value
  		peri_etap_codi=peri_etap_codi_unid.substr(0, 1);
	 	peri_etap_unid=peri_etap_codi_unid.substr(2, 3);   
		
		if (peri_etap_unid=='A'){			
			 peri_dist_codi=document.getElementById('pg_peri_dist_codi').value			 
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
			$.growl.notice({ title: "Informacion: ",message: "Activación de Permiso Realizada" });	
			//document.getElementById(div).innerHTML=xhr.responseText;
			peri_etap_view(peri_codi);
			 	
		} 
		
		}
		xhr.send(data);
					
			  
}

 function peri_acti_del(peri_acti_codi, peri_codi){
	 		 			
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
				peri_etap_view(peri_codi);
				$.growl.warning({ title: "Informacion: ",message: "Eliminación realizada con éxito" });	
				document.getElementById(div).innerHTML=xhr.responseText;
					
			}
			}
			xhr.send(data);
		}						  
}

function peri_etap_view(peri_codi)
{
	load_ajax('peri_etap_view','admin_periodos_etapas_view.php','peri_codi=' + peri_codi);	
}

function CargarUnidades(peri_dist_cab_codi, nivel)
{
	var data = new FormData();
	data.append('peri_dist_cab_codi', peri_dist_cab_codi);
	data.append('nivel', nivel);
	var xhr = new XMLHttpRequest();
	xhr.open('POST', 'select_unidades_etapas.php' , true);
	xhr.onreadystatechange=function()
	{
		if (xhr.readyState==4 && xhr.status==200)
		{
			document.getElementById('div_unidad').innerHTML=xhr.responseText;
		} 
	}
	xhr.send(data);
}