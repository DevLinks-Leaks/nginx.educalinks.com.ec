function peri_dist_peri_libt_view(peri_codi,peri_etap_codi_unid){	
 		 
		 
	 	peri_etap_codi=peri_etap_codi_unid.substr(0, 1);
	 	peri_etap_unid=peri_etap_codi_unid.substr(2, 3);

		if (peri_etap_unid=='A'){
			$('.dynamic_1').show();
			$('.dynamic_2').hide();
			$('.dynamic_3').hide();
			//document.getElementById('n_peri_dist_codi').style.display="block";
			document.getElementById('pg_peri_dist_codi').disabled="";
			document.getElementById('sl_peri_dist_cab').disabled="";

		}else if(peri_etap_unid=='P'){
			$('.dynamic_2').show();
			$('.dynamic_3').hide();
			
			$('.dynamic_1').hide();
			document.getElementById('pg_peri_dist_codi').disabled="disabled";
			document.getElementById('sl_peri_dist_cab').disabled="disabled";
		}else if(peri_etap_unid=='E'){
			$('.dynamic_3').show();
			$('.dynamic_2').hide();
			$('.dynamic_1').hide();
			document.getElementById('pg_peri_dist_codi').disabled="disabled";
			document.getElementById('sl_peri_dist_cab').disabled="disabled";
		} else{
			$('.dynamic_1').hide();
			$('.dynamic_3').hide();
			$('.dynamic_2').hide();
			document.getElementById('pg_peri_dist_codi').disabled="disabled";
			document.getElementById('sl_peri_dist_cab').disabled="disabled";
			//document.getElementById('n_peri_dist_codi').style.display="none";
		}
}
		
function peri_acti_add(peri_codi)
{	var valid = 1;
	$('#btn_etapa_add').button('loading');
	peri_etap_codi_unid =document.getElementById('n_peri_etap_codi').value
	peri_etap_codi=peri_etap_codi_unid.substr(0, 1);
 	peri_etap_unid=peri_etap_codi_unid.substr(2, 3);   
	
	if (peri_etap_unid=='A'){			
		 peri_dist_codi=document.getElementById('pg_peri_dist_codi').value;
		 peri_codi_dest= '';
		 encu_deta=''; 
	}else  if(peri_etap_unid=='P'){
		  peri_codi_dest= $('#sl_peri_codi_dest').val();
		 peri_dist_codi=-1;
		 encu_deta='';
	}else if(peri_etap_unid=='E'){
		encu_deta= $('#txt_encuesta').val();
		peri_dist_codi=-1;
		peri_codi_dest= '';
	}else{
		peri_dist_codi=-1;
		peri_codi_dest= '';
		encu_deta='';
	}
 	peri_fech_ini = parseInt(document.getElementById('n_peri_fech_ini').value.replace(/-/g,''));
	peri_fech_fin = parseInt(document.getElementById('n_peri_fech_fin').value.replace(/-/g,''));
	usua_codi = document.getElementById('mens_de').value;
	
	if( document.getElementById('peri_deta') )
		document.getElementById('peri_deta').value='';
	
	if($('.dynamic_2').is(':visible'))
	{	console.log(document.getElementById('sl_peri_codi_dest').value);
		if( document.getElementById('sl_peri_codi_dest').value === '0' )
		{	valid = 0;
			$.growl.error({ title: "Educalinks informa",message: "Por favor, seleccione un período lectivo" });
		}
	}
	
	if($('.dynamic_1').is(':visible'))
	{	console.log(3);
		if( document.getElementById('sl_peri_dist_cab').value === '0' || document.getElementById('sl_peri_dist_cab').value.length === 0 )
		{	valid = 0;
			$.growl.error({ title: "Educalinks informa",message: "Por favor, seleccione un tipo de período" });
		}
	}
	
	if ( js_funciones_compare_dates_yyyymmdd ( document.getElementById('n_peri_fech_ini').value, document.getElementById('n_peri_fech_fin').value ) === 'NO' )
	{	valid = 0;
		$.growl.warning({ title: "Educalinks informa",message: "La fecha de inicio no puede ser mayor a la fecha de fin" });
	}
	
	if($('.dynamic_3').is(':visible'))
	{	console.log(1);
		if( document.getElementById('txt_encuesta').innerHTML.length < 4 )
		{	valid = 1;
			// $.growl.error({ title: "Educalinks informa",message: "Por favor, ingresar más de 4 caracteres." });
		}
	}
	if( valid === 1 )
	{   url='script_peri_acti.php';
		
		var data = new FormData();
		data.append('peri_codi', peri_codi);
		data.append('peri_fech_ini', peri_fech_ini);
		data.append('peri_fech_fin', peri_fech_fin);
		data.append('peri_etap_codi', peri_etap_codi);
		data.append('peri_dist_codi', peri_dist_codi);
		data.append('usua_codi', usua_codi);
		data.append('peri_codi_dest', peri_codi_dest);
		data.append('encu_deta', encu_deta);
		data.append('peri_acti_add', 'Y');
			
		if (window.XMLHttpRequest)
		{// code for IE7+, Firefox, Chrome, Opera, Safari
			xhr=new XMLHttpRequest();
		}
		else
		{// code for IE6, IE5
			xhr=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xhr.open('POST', url , true);
		xhr.onload = function () {
			// do something to response
			console.log(this.responseText);
		};
		xhr.onreadystatechange=function()
		{   if (xhr.readyState==4 && xhr.status==200)
			{   var json = JSON.parse(xhr.responseText);
				if (json.state=="success")
				{
					$.growl.notice({ title: "Educalinks informa",message: json.result });
					$('#btn_etapa_add').button('reset');
					$('#peri_nuev').modal('hide');
					peri_etap_view(peri_codi);
				}
				else
				{   $.growl.error({ title: "Educalinks informa",message: json.result });
					console.log(json.console);
					$('#btn_etapa_add').button('reset');
				}
			}
		};
		xhr.send(data);
	}
	else
		$('#btn_etapa_add').button('reset');
}

 function peri_acti_del(peri_acti_codi, peri_codi)
 {  if (confirm("¿Está seguro que desea eliminar esta etapa?"))
	{   usua_codi = document.getElementById('mens_de').value;		 
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
		xhr.onreadystatechange=function()
		{   if (xhr.readyState==4 && xhr.status==200)
			{   peri_etap_view(peri_codi);
				$.growl.warning({ title: "Informacion: ",message: "Eliminación realizada con éxito" });	
			}
		};
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