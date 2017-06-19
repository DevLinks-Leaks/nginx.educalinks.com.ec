function ValidarDatos(direc)
{	
	if(document.getElementById('alum_foto')!=null){
		if (document.getElementById('alum_foto').value.trim()=='')
		{	$.growl.error({
					title: 'Educalinks informa',
					message: 'Por favor ingrese la foto de su representado.' });
			$('#alum_foto').closest('.form-group').addClass('has-error');
			document.getElementById('alum_foto').focus();
	        $('#tabs a[href="#tab2"]').tab('show');
			return false;
		}
		else
		{	$('#alum_foto').closest('.form-group').removeClass('has-error');
		}
	}

	return true;
}
function actualizar_datos()
{	
	if(ValidarDatos()){
		$('#btn_actualizar').button('loading');
		if (window.XMLHttpRequest)
		{// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		}
		else
		{// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		var archivo = document.getElementById('alum_foto');
		if (archivo!=null)
			var alum_foto = archivo.files[0];
		else
			var alum_foto='';

		var data = new FormData();
		data.append('opc', 'alum_upd');
		data.append('alum_foto', alum_foto);

		xmlhttp.onreadystatechange=function()
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				var json = JSON.parse(xmlhttp.responseText);
				if (json.state=="success"){				
					$.growl.notice({ title: "Educalinks informa:",message: json.result });
					$('#btn_actualizar').button('reset');
					// $('#modal_preinscripcion').modal('hide');
					// window.location.reload();
					window.open('index.php','_self')
				}else{
					$.growl.error({ title: "Educalinks informa:",message: json.result });
					console.log(json.console);
					$('#btn_actualizar').button('reset');
					
				}
			}
		}
		xmlhttp.open("POST","script_foto.php",true);
		// xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		xmlhttp.send(data);
	}
}