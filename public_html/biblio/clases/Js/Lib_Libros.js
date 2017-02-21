

 function C_Libros(){
	  
	  	this.libr_tipo_view = function(libr_tipo_codi,div_revista,div_video){
			
			
			if (libr_tipo_codi==3){
				document.getElementById('div_revista').style.display='block';
				document.getElementById('div_video').style.display='none';				
			}
			else if (libr_tipo_codi==5){
				document.getElementById('div_revista').style.display='none';
				document.getElementById('div_video').style.display='block';
				
			}
			else{
				document.getElementById('div_revista').style.display='none';
				document.getElementById('div_video').style.display='none';
			}
			
			
		}
	  
	  
  		this.libr_add = function(libr_codi_impr,libr_titu,libr_auto_codi,libr_edit_codi,libr_cole_codi,libr_tipo_codi,libr_isbn,libr_issn,libr_revi_nume,libr_fech_publ,libr_fech_ingr,libr_obse,libr_vide_dire,libr_vide_acto,libr_vide_inte,libr_vide_orig,libr_vide_dura,libr_vide_gene,libr_vide_resu,libr_cara){
		  
		  //ruta 
		  url='clases/Ajax/Lib_Libros.php'; 
		  
		  
		  execu=true;
		  if (libr_codi_impr==''){ execu=false; alert('Debe ingresar algo en el detalle');}
		   
		  if (execu==true){
			  var data = new FormData();
			  
			  data.append('libr_codi_impr', libr_codi_impr);			  
			  data.append('libr_titu', libr_titu);	
			  			  
			  data.append('libr_auto_codi', libr_auto_codi);	
			  data.append('libr_cole_codi', libr_cole_codi);	
			  data.append('libr_edit_codi', libr_edit_codi);
			  data.append('libr_tipo_codi', libr_tipo_codi);
			  	
			  data.append('libr_isbn', libr_isbn);	
			  data.append('libr_issn', libr_issn);	
			  data.append('libr_revi_nume', libr_revi_nume);	
			  
			  data.append('libr_fech_publ', libr_fech_publ);
			  data.append('libr_fech_ingr', libr_fech_ingr);
			  			  
			  data.append('libr_obse', libr_obse);		
			  
			  data.append('libr_vide_dire', libr_vide_dire);	
			  data.append('libr_vide_acto', libr_vide_acto);	
			  data.append('libr_vide_inte', libr_vide_inte);	
			  data.append('libr_vide_orig', libr_vide_orig);	
			  data.append('libr_vide_dura', libr_vide_dura);	
			  data.append('libr_vide_gene', libr_vide_gene);	
			  data.append('libr_vide_resu', libr_vide_resu);
			  
			   data.append('option', 'libr_add');
			   
			   data.append('libr_cara', libr_cara.files[0],libr_cara.value);	
			  
		 	  	var file      = libr_cara.files[0];
				var fileName  = libr_cara.files[0].name;
				var fileSize  = libr_cara.files[0].size;
				var fileType  = libr_cara.files[0].type;
			 
				  
			  
			  
			  var xhr = new XMLHttpRequest();
			  xhr.open('POST', url , true);
			  //xhr.setRequestHeader('Content-Type', 'multipart/form-data');
			  xhr.onload = function () {
				  // do something to response
				  console.log(this.responseText);
			  };
			  xhr.onreadystatechange=function(){
				  if (xhr.readyState==4 && xhr.status==200){
					  	alert('Se agrego Libro')
					 	document.getElementById('resu_view').innerHTML=xhr.responseText;
					  	//window.location = "index.php";
				  } 			  
			  }
			  // Envio de Informacion
			  xhr.send(data);
		  }
		  
		  
	  };
	  
	  this.libr_upd = function(libr_codi,libr_codi_impr,libr_titu,libr_auto_codi,libr_edit_codi,libr_cole_codi,libr_tipo_codi,libr_isbn,libr_issn,libr_revi_nume,libr_fech_publ,libr_fech_ingr,libr_obse,libr_vide_dire,libr_vide_acto,libr_vide_inte,libr_vide_orig,libr_vide_dura,libr_vide_gene,libr_vide_resu,libr_cara){
		  
		  //ruta 
		  url='clases/Ajax/Lib_Libros.php'; 
		  
		  
		  execu=true;
		  if (libr_codi_impr==''){ execu=false; alert('Debe ingresar algo en el detalle');}
		   
		  if (execu==true){
			  var data = new FormData();
			  
			  data.append('libr_codi', libr_codi);
			  data.append('libr_codi_impr', libr_codi_impr);			  
			  data.append('libr_titu', libr_titu);	
			  			  
			  data.append('libr_auto_codi', libr_auto_codi);	
			  data.append('libr_cole_codi', libr_cole_codi);	
			  data.append('libr_edit_codi', libr_edit_codi);
			  data.append('libr_tipo_codi', libr_tipo_codi);
			  	
			  data.append('libr_isbn', libr_isbn);	
			  data.append('libr_issn', libr_issn);	
			  data.append('libr_revi_nume', libr_revi_nume);	
			  
			  data.append('libr_fech_publ', libr_fech_publ);
			  data.append('libr_fech_ingr', libr_fech_ingr);
			  			  
			  data.append('libr_obse', libr_obse);		
			  
			  data.append('libr_vide_dire', libr_vide_dire);	
			  data.append('libr_vide_acto', libr_vide_acto);	
			  data.append('libr_vide_inte', libr_vide_inte);	
			  data.append('libr_vide_orig', libr_vide_orig);	
			  data.append('libr_vide_dura', libr_vide_dura);	
			  data.append('libr_vide_gene', libr_vide_gene);	
			  data.append('libr_vide_resu', libr_vide_resu);	
			  
		 	  
			  data.append('option', 'libr_upd');
			  
			   data.append('libr_cara', libr_cara.files[0],libr_cara.value);	
			  
		 	  	var file      = libr_cara.files[0];
				var fileName  = libr_cara.files[0].name;
				var fileSize  = libr_cara.files[0].size;
				var fileType  = libr_cara.files[0].type;
				  
			  
			  
			  var xhr = new XMLHttpRequest();
			  xhr.open('POST', url , true);
			  xhr.onload = function () {
				  // do something to response
				  console.log(this.responseText);
			  };
			  xhr.onreadystatechange=function(){
				  if (xhr.readyState==4 && xhr.status==200){
					  //alert('Se Actualizo Libro')
					  //location.reload();
					  	document.getElementById('resu_view').innerHTML=xhr.responseText;
				  } 			  
			  }
			  // Envio de Informacion
			  xhr.send(data);
		  }
		  
		  
	  };
	  
	  this.libr_cara_add = function file_add(div,url){
		if(document.getElementById('tick_archivo').value!=""){
			
			  var fileSelect=document.getElementById('tick_archivo');
			  var files = fileSelect.files;
			  var file = files[0];
  
			  document.getElementById(div).innerHTML='<div align="center" style="height:100%;"><img src="../imagenes/ajax-loader.gif"/></div>';
			  var data = new FormData();
			  data.append('tick_codigo', document.getElementById('tick_codigo').value);        
			  data.append('tick_file_descripcion', document.getElementById('tick_file_descripcion').value);
			  data.append('tick_file_nombre_archivo', file, file.name);
			  data.append('option','files_add');
			  var xhr_tare_ok = new XMLHttpRequest();
			  xhr_tare_ok.open('POST', url , true);
			  xhr_tare_ok.onreadystatechange=function(){
				  if (xhr_tare_ok.readyState==4 && xhr_tare_ok.status==200){
					  document.getElementById(div).innerHTML=xhr_tare_ok.responseText;
					  document.getElementById('tick_archivo').value="";
					  $('#table_archivos').DataTable({lengthChange: false,searching: false,language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'}});
  
				  } 
			  }
			  xhr_tare_ok.send(data); 
			
			
		}else{
			alert("Seleccione un archivo para cargar.");
		}
	}
        
        this.lib_pres_add = function(usua_codi,usua_tipo_codi,libr_ejem_codi,pres_fech_inic,pres_obse_inic){
		  
		  //ruta 
		  url='clases/Ajax/Lib_Libros.php'; 
		  
		  
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
					//alert('Se agrego Prestamo')
					window.location = "Prestamos.php";
					document.getElementById('resu').innerHTML=xhr.responseText;
				  } 			  
			  }
			  // Envio de Informacion
			  xhr.send(data);
		  }
		  
		  
	  };
        
      
	  
  };



 
