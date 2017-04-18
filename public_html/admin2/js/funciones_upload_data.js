function Subir(archivo, div_progreso, tabla)
{
	if (archivo.value != '')
	{	document.getElementById(div_progreso).innerHTML='<div align="center" style="height:100%;"><img src="../imagenes/ajax-loader.gif"/></div>';
		var data = new FormData();
		var my_file = archivo.files[0];
		data.append('file', my_file);
		data.append('tabla', tabla);
		var xmlhttp=new XMLHttpRequest();
		xmlhttp.onreadystatechange=function() 
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200) 
			{
				document.getElementById(div_progreso).innerHTML=xmlhttp.responseText;
			}
			else
			{
				document.getElementById(div_progreso).innerHTML=xmlhttp.responseText;
			}
		}
		xmlhttp.open("POST","script_upload_data.php",true);
		xmlhttp.send(data);
	}
	else
	{
		alert ("Por favor seleccione un archivo.");
	}
}