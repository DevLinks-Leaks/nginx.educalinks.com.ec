 function curs_para_nota_cual_save(peri_dist_codi){	  
	if (confirm("¿Está seguro de grabar estos valores?")) {
	
		  url='cursos_paralelo_notas_cual_script.php';
		   		  
		  i=1;
		  cc=document.getElementById('alum_cont').value;

		  var data = new FormData();
		  data.append('fil',cc);
		  data.append('add_nota', 'Y');
		  data.append('peri_dist_codi', peri_dist_codi);
		 
		 //Lista de Alumnos		  
		  while (i<=cc)
		  {  	  	
				//Lista las columnnas de ingreso		
				nota_peri_cual_codi= document.getElementById('nota_' + i).value ;
				alum_curs_para_mate_codi=document.getElementById('alum_' + i).value;

				data.append('alum_curs_para_mate_codi_'+i, alum_curs_para_mate_codi);
				data.append('nota_peri_cual_codi_'+i, nota_peri_cual_codi);
					
				i+=1;
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
	}			  
}