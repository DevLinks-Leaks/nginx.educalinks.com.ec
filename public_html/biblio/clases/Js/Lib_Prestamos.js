

 function C_Prestamos(){
	  
		  //ruta 
		  //url='clases/Ajax/Lib_Prestamos.php'; 
	 
        this.lib_pres_add = function(usua_codi,usua_tipo_codi,libr_ejem_codi,pres_fech_inic,pres_obse_inic){
		  
		  //ruta 
		  url='clases/Ajax/Lib_Prestamos.php'; 
		  
		  
		  execu=true;
		  if (usua_codi==''){ execu=false; alert('Debe tener un Usuario');}
		  if (libr_ejem_codi==''){ execu=false; alert('Debe tener un Libro');}
		  if (pres_fech_inic==''){ execu=false; alert('Debe tener fecha');}
		   
		  if (execu==true){
			  var data = new FormData();
		 
			  data.append('usua_codi', usua_codi);			  
			  data.append('usua_tipo_codi', usua_tipo_codi);	
			  			  
			  data.append('libr_ejem_codi', libr_ejem_codi);	
			  data.append('pres_fech_inic', pres_fech_inic);	
			  data.append('pres_obse_inic', pres_obse_inic);	
			  
		 	  
			  data.append('option', 'lib_pres_add');
				  
			  
			  
			  var xhr = new XMLHttpRequest();
			  xhr.open('POST', url , true);
			  xhr.onload = function () {
				  // do something to response
				  console.log(this.responseText);
			  };
			  xhr.onreadystatechange=function(){
				  if (xhr.readyState==4 && xhr.status==200){
					alert('Se agrego Prestamo')
					window.location = "Prestamos.php";
					//document.getElementById('resu').innerHTML=xhr.responseText;
				  } 			  
			  }
			  // Envio de Informacion
			  xhr.send(data);
		  }
		  
		  
   		};
        
      
	  
  };



 
