function registrar_encuesta(codi)
{	
	$('#btn_encuesta').button('loading');
	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	var data = new FormData();
	data.append('opc', 'visi_usua_add');
	data.append('codi', codi);
	data.append('tipo', 'ENC');

	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			var json = JSON.parse(xmlhttp.responseText);
			if (json.state=="success"){				
				$.growl.notice({ title: "Educalinks informa:",message: 'La encuesta ha sido registrada exitosamente' });
				$('#btn_encuesta').button('reset');
				$('#modal_encu').modal('hide');
				
			}else{
				$.growl.error({ title: "Educalinks informa:",message: 'Ha ocurrido un error al completar la encuesta' });
				console.log(json.console);
				$('#btn_encuesta').button('reset');
				
			}
		}
	}
	xmlhttp.open("POST","script_general.php",true);
	// xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
	xmlhttp.send(data);

}