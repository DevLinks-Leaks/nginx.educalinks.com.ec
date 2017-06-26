function curs_para_nota_peri_dist_save(){	  
	if (confirm("¿Está seguro de grabar estos valores?")) {
	
		  url='cursos_paralelo_notas_mate_main_deta_view_script.php';
		   		  
		  i=1;
		  cc=document.getElementById('cc').value;
		  cc_index=document.getElementById('CC_COLUM_index').value;

		  var data = new FormData();
		  data.append('col',cc);
		  data.append('fil',cc_index);
		  data.append('add_nota', 'Y');
		 
		 //Lista de Alumnos		  
		  while (i<=cc){
			  	  	
				//Lista las columnnas de ingreso		
				alum_curs_para_mate_codi= document.getElementById('alum_curs_para_mate_codi_' + i).value ;
			   	i2=0;
				deta_audi="Alumno curso paralelo materia: "+alum_curs_para_mate_codi;
			   	while (i2<cc_index){
					 
					peri_dist_codi= document.getElementById('peri_dist_codi_' + (parseInt(i2) + 1)).value;
				   	nota= document.getElementById('nota_' + i + '_'  + i2).value ;
					
					  	data.append('alum_curs_para_mate_codi_'+i+'_'+i2, alum_curs_para_mate_codi);
					  	data.append('nota_'+i+'_'+i2, nota);
					  	data.append('peri_dist_codi_'+i+'_'+i2, peri_dist_codi);	
						
						deta_audi+=' Periodo distribución código: '+peri_dist_codi+' Nota: '+nota;
				    i2+=1;
		  		}	 
			  registrar_auditoria (19, deta_audi);
			  i+=1;
			  deta_audi= '';
		  }	
				   
				  
					  	var xhr = new XMLHttpRequest();
					  	xhr.open('POST', url , true);
					  	xhr.onload = function () {
						  // do something to response
						  console.log(this.responseText);
					  	};
					  	xhr.onreadystatechange=function(){
						  if (xhr.readyState==4 && xhr.status==200){
						  
						  } 
					   
					  	}
					 	 xhr.send(data);
		  
		  $.growl.notice({ title: "Informacion: ",message: "Notas Grabadas" });	
		  //$.growl.notice({ title: "Informacion: ",message: xhr.responseText });	
		  	 load_ajax('notas_view','cursos_paralelo_notas_mate_main_deta_view.php','peri_dist_codi=' + document.getElementById('peri_dist_codi').value + '&curs_para_mate_codi=' +  document.getElementById('curs_para_mate_codi').value);
		 
		   
	}			  
}

function validaDesbordamientoAbono (e, field, max_value)
{	var maximo=0;
	maximo=parseFloat(max_value);
	var valor=field.value;
	var valor_actual=field.value+String.fromCharCode(e.which);
	valor_actual_real=parseFloat(valor_actual)*10;
	if (e.keyCode == 32)
	{	field.value=parseFloat(field.value*10).toFixed(2);
		valor_actual_real=parseFloat(valor_actual)*10;
	}
	if(parseFloat(parseFloat(valor_actual_real).toFixed(2))>parseFloat(parseFloat(maximo).toFixed(2)))
	{	//var mensajeError='Valor excedido, ingreso un monto menor o igual a la deuda';
		//document.getElementById('modal_resultadoPago_header').innerHTML="<strong>¡Valor excedido!</strong>";
		//document.getElementById('modal_resultadoPago_body').innerHTML="<div class='alert alert-warning'><strong>¡Advertencia! </strong>"+mensajeError+"</div>";
		//$('#modal_resultadoPago').modal('show');
		field.value=parseFloat(0).toFixed(2);
		return !(regexp.test(field.value));
	}
}

function TEXTVALI(nota_nuev,nuev_actu,maximo)
{
	if (nota_nuev.value == "") {
		//alert("El valor esta en blanco");			
		nota_nuev.value=0;
	}
	else if (isNumber(nota_nuev.value)!= true ) {
			//alert("El valor no es numerico");			
			nota_nuev.value=0;
	}
	else{
		if (nota_nuev.value > maximo) {
			//alert("El valor no puede ser mayor a " + maximo);		
			nota_nuev.value=0;	
		}
		if (nota_nuev.value < 0) {
			//alert("El valor debe ser mayor a cero");			
			nota_nuev.value=0;
			
		}		 
	 		
  	}
	//Actualiza el promedio
 	//update_prom(nuev_actu)	
}

function isNumber(n) {
  return !isNaN(parseFloat(n)) && isFinite(n);
}

function notas_elim_peri_dist (curs_para_codi, peri_dist_codi, clie_codi, clave)
{
	if (clave.trim()!="")
	{
		if (confirm("¿Desea eliminar las notas de forma permanente? Una vez eliminadas no se podrán recuperar."))
		{
			var data = new FormData();
			data.append('curs_para_codi', curs_para_codi);
			data.append('peri_dist_codi', peri_dist_codi);
			data.append('clie_codi', clie_codi);
			data.append('clave', clave);
			data.append('del_notas_all', 'Y');
			
			var xmlhttp=new XMLHttpRequest();
			xmlhttp.onreadystatechange=function() 
			{
				if (xmlhttp.readyState==4 && xmlhttp.status==200) 
				{
					
				}
				else
				{
					if (xmlhttp.responseText=="1")
					{
						alert ('Notas eliminadas.');
					}
					if (xmlhttp.responseText=="2")
					{
						alert ('No tiene una clave asignada.');
					}
					if (xmlhttp.responseText=="3")
					{
						alert ('La contraseña no es correcta.');
					}
					if (xmlhttp.responseText=="4")
					{
						alert ('Error: No se pudieron eliminar las notas');
					}
				}
			}
			xmlhttp.open("POST","script_notas_del.php",true);
			xmlhttp.send(data);
		}
	}
	else
	{
		alert ("Ingrese la clave de seguridad.");
	}
}

function notas_elim_peri_dist_all (peri_dist_codi, clie_codi, clave)
{
	if (clave.trim()!="")
	{
		if (confirm("¿Desea eliminar las notas de forma permanente de TODOS LOS CURSOS? Una vez eliminadas no se podrán recuperar."))
		{
			var data = new FormData();
			data.append('peri_dist_codi', peri_dist_codi);
			data.append('clie_codi', clie_codi);
			data.append('clave', clave);
			data.append('del_notas_all', 'Y');
			
			var xmlhttp=new XMLHttpRequest();
			xmlhttp.onreadystatechange=function() 
			{
				if (xmlhttp.readyState==4 && xmlhttp.status==200) 
				{
					
				}
				else
				{
					if (xmlhttp.responseText=="1")
					{
						alert ('Notas eliminadas.');
					}
					if (xmlhttp.responseText=="2")
					{
						alert ('No tiene una clave asignada.');
					}
					if (xmlhttp.responseText=="3")
					{
						alert ('La contraseña no es correcta.');
					}
					if (xmlhttp.responseText=="4")
					{
						alert ('Error: No se pudieron eliminar las notas');
					}
				}
			}
			xmlhttp.open("POST","script_notas_del.php",true);
			xmlhttp.send(data);
		}
	}
	else
	{
		alert ("Ingrese la clave de seguridad.");
	}
}

function GuardarObs(peri_dist_codi, alum_codi, obse)
{
	if (confirm("¿Está seguro?"))
	{
		/*Creo los datos*/
		var datos = new FormData();
		datos.append("obse", obse);
		datos.append("alum_codi", alum_codi);
		datos.append("peri_dist_codi", peri_dist_codi);
		datos.append("opcion", "add");
		/*Creo objeto AJAX*/
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function ()
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				$.growl.notice({ title: "Mensaje: ",message: "¡Su observación fue grabada con éxito!" });
				location.reload();
			}
		}
		xmlhttp.open("POST","script_observaciones.php");
		xmlhttp.send(datos);
	}
}

///////////////////////////////////////////////////
///////////////////////////////////////////////////
//23 de noviembre, Marcos Alvear.

function handleChange(input, min, max)
{	if (input.value < min) input.value = min;
	if (input.value > max) input.value = max;
}
function calc(row, count_columnas)
{	var c = 0;
	var subtotal = 0;
	var total = 0;
	var arreglo=new Array();
	while(c < count_columnas)
	{
		arreglo[c] = parseFloat(document.getElementById('nota_'+row+'_'+c).value);
		c=c+1;
	}
	var aux = 0;
	while(aux < count_columnas)
	{
		var subtotal = subtotal + arreglo[aux];
		aux=aux+1;
	}
	var subtotal=parseFloat(document.getElementById('nota_'+row).value);
	var total=(subtotal)/count_columnas;
	document.getElementById('promedio_'+row).value=total.toFixed(2);
	//sum();
}
function sum()
{	var	s = document.getElementsByClassName("subTotal");
	var g = 0;
	for(var i = 0; i < s.length; i++){
		var a = s[i].value, b = 1*a+1*g;
		g = b;
	}
	document.getElementById("promedioSum").value = (parseFloat(g.toFixed(2))/s.length).toFixed(2);
}
function esNumerico(evt)
{	var charCode = (evt.which) ? evt.which : evt.keyCode;
	if (charCode != 46 && charCode > 31 
		&& (charCode < 48 || charCode > 57))
		return false;
	return true;
}
function equiv(row)
{	var val1=parseInt(document.getElementById('promedio'+row).value);
	if((val1>=0)&&(val1<=4)){ document.getElementById('equivalente'+row).value='NAAR';}
	if((val1>4)&&(val1<7)){ document.getElementById('equivalente'+row).value='PAAR';}
	if((val1>=7)&&(val1<9)){ document.getElementById('equivalente'+row).value='AAR';}
	if((val1>=9)&&(val1<=10)){document.getElementById('equivalente'+row).value='DAR';}
}