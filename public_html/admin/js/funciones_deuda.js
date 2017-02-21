function activar_desactivar_deuda(check_box)
{
	var tiene_deuda;
	if (check_box.checked)
	{
		tiene_deuda = true;
	}
	else
	{
		tiene_deuda = false;
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
			
		}
		else
		{
			document.getElementById(div_progreso).innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("POST","script_deuda.php",true);
	xmlhttp.send(data);
}