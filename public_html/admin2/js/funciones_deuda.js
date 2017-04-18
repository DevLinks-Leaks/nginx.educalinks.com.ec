function activar_desactivar_deuda(check_box)
{
	var tiene_deuda;
	var lbl;
	if (check_box.checked)
	{
		tiene_deuda = true;
		lbl='Activada';
	}
	else
	{
		tiene_deuda = false;
		lbl='Desactivada';
	}
	var data = new FormData();
	data.append('alum_codi', check_box.getAttribute('data-alum_codi'));
	data.append('curs_para_codi', check_box.getAttribute('data-curs_para_codi'));
	data.append('tiene_deuda', tiene_deuda);
	data.append('opc', 'upd');
	
	var xmlhttp=new XMLHttpRequest();
	xmlhttp.onreadystatechange=function() 
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200) 
		{
			var json = JSON.parse(xmlhttp.responseText);
			if (json.state=="success"){				
				$.growl.notice({ title: "Educalinks informa:",message: json.result });
				
				$('#lbl_'+check_box.getAttribute('data-alum_codi')).text(lbl);
				
			}else{
				$.growl.error({ title: "Educalinks informa:",message: json.result });
				console.log(json.console);
				if(!tiene_deuda==true)
					lbl='Activada';
				else
					lbl='Desactivada';
				$('#lbl_'+check_box.getAttribute('data-alum_codi')).text(lbl);
				$(check_box).attr('checked', !tiende_deuda);
			}
		}
	}
	xmlhttp.open("POST","script_deuda.php",true);
	xmlhttp.send(data);
}