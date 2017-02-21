 function curs_para_nota_comp_save(peri_dist_codi){	  
	if (confirm("¿Está seguro de grabar estos valores?")) {
	
		  url='cursos_paralelo_notas_comp_script.php';
		   		  
		  i=1;
		  cc=document.getElementById('indi_cont').value;
		  cc_index=document.getElementById('alum_cont').value;

		  var data = new FormData();
		  data.append('col',cc);
		  data.append('fil',cc_index);
		  data.append('add_nota', 'Y');
		  data.append('peri_dist_codi', peri_dist_codi);
		 
		 //Lista de Alumnos		  
		  while (i<=cc)
		  {  	  	
				//Lista las columnnas de ingreso		
				indi_parc_codi= document.getElementById('indi_' + i).value ;
			   	i2=0;
			   	while (i2<cc_index)
				{
					i2=i2+1;
					alum_curs_para_codi= document.getElementById('alum_' + i + '_' + i2).value;
				   	nota = document.getElementById('nota_' + i + '_'  + i2).value;
					alum_codi=document.getElementById('alum_' + i + '_' + i2).getAttribute("data-alum_codi");
					observacion=document.getElementById('observacion_' + i + '_'  + i2).value;
					
					data.append('alum_curs_para_codi_'+i+'_'+i2, alum_curs_para_codi);
					data.append('nota_'+i+'_'+i2, nota);
					data.append('indi_parc_codi_'+i+'_'+i2, indi_parc_codi);
					data.append('alum_codi_'+i+'_'+i2, alum_codi);
					data.append('observacion_'+i+'_'+i2, observacion);
					
					//alert (alum_curs_para_codi+'-'+nota+'-'+indi_parc_codi);
						
						//deta_audi+=' Periodo distribución código: '+peri_dist_codi+' Nota: '+nota;
		  		}	 
			  //registrar_auditoria (19, deta_audi);
			  i+=1;
			  //deta_audi= '';
		  }	
				   
				  
					  	var xhr = new XMLHttpRequest();
					  	xhr.open('POST', url , true);
					  	xhr.onload = function () {
						  // do something to response
						  console.log(this.responseText);
					  	};
					  	xhr.onreadystatechange=function(){
						  if (xhr.readyState==4 && xhr.status==200)
						  {
						  } 
					  	}
					 	xhr.send(data);
		  
		  $.growl.notice({ title: "Informacion: ",message: "Notas Grabadas" });	
		  //$.growl.notice({ title: "Informacion: ",message: xhr.responseText });	
		  //load_ajax('notas_view','cursos_paralelo_notas_mate_main_deta_view.php','peri_dist_codi=' + document.getElementById('peri_dist_codi').value + '&curs_para_mate_codi=' +  document.getElementById('curs_para_mate_codi').value);
		 
		   
	}			  
}