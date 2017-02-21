

 function C_Visitas(){
	  
	   
	  
	  
  		this.visi_add = function(usua_codi,usua_tipo_codi,visi_tipo_codi,visi_fech,visi_obse){
		  
		  //ruta 
		  url='clases/Ajax/Lib_Visitas.php'; 
		  
		  
		  execu=true;
		  if (usua_codi==''){ execu=false; alert('Debe ingresar Usuario');}
		  if (visi_fech==''){ execu=false; alert('Debe ingresar Fecha');} 
		   
		  if (execu==true){
			  var data = new FormData();
			  
			  data.append('usua_codi', usua_codi);			  
			  data.append('usua_tipo_codi', usua_tipo_codi);	
			  data.append('visi_tipo_codi', visi_tipo_codi);
			  			  
			  data.append('visi_fech', visi_fech);				  	
			  data.append('visi_obse', visi_obse);
		 	  
			  data.append('option', 'visi_add');
				  
			  
			  
			  var xhr = new XMLHttpRequest();
			  xhr.open('POST', url , true);
			  xhr.onload = function () {
				  // do something to response
				  console.log(this.responseText);
			  };
			  xhr.onreadystatechange=function(){
				  if (xhr.readyState==4 && xhr.status==200){
					  alert('Se agrego Visita')
					  window.location = "visitas.php";
					  //document.getElementById('resu').innerHTML=xhr.responseText;
				  } 			  
			  }
			  // Envio de Informacion
			  xhr.send(data);
		  }
		  
		  
	  };
	  
	  this.visi_busq = function(visi_fech_ini,visi_fech_fin,usua_codi,usua_tipo_codi){
		  
		  //ruta 
		  url='visitas_view.php'; 
		  
		 
		  var data = new FormData();
		  
		  data.append('visi_fech_ini', visi_fech_ini);	
		  data.append('visi_fech_fin', visi_fech_fin);
					  
		  data.append('usua_codi', usua_codi);			  
		  data.append('usua_tipo_codi', usua_tipo_codi);	
			   
		  
		  var xhr = new XMLHttpRequest();
		  xhr.open('POST', url , true);
		  xhr.onload = function () {
			  // do something to response
			  console.log(this.responseText);
		  };
		  xhr.onreadystatechange=function(){
			  if (xhr.readyState==4 && xhr.status==200){
				  //alert('Se agrego Visita')
				  //window.location = "visitas.php";
				  document.getElementById('div_visita').innerHTML=xhr.responseText;
			  } 			  
		  }
		  // Envio de Informacion
		  xhr.send(data);
		 
		  
		  
	  };
	  
	  

	  
	
        
      
	  
  };



 
