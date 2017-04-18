function CargarUnidadesGeneral(peri_dist_cab_codi, nivel, div)
{
	var data = new FormData();
	data.append('peri_dist_cab_codi', peri_dist_cab_codi);
	data.append('nivel', nivel);
	data.append('select', 'UnidadesGeneral')
	var xhr = new XMLHttpRequest();
	xhr.open('POST', 'select_permisos.php' , true);
	xhr.onreadystatechange=function()
	{
		if (xhr.readyState==4 && xhr.status==200)
		{
			document.getElementById(div).innerHTML=xhr.responseText;
		} 
	}
	xhr.send(data);
}

function CargarUnidadesIndividual(peri_dist_cab_codi, nivel, div)
{
	var data = new FormData();
	data.append('peri_dist_cab_codi', peri_dist_cab_codi);
	data.append('nivel', nivel);
	data.append('select', 'UnidadesIndividual')
	var xhr = new XMLHttpRequest();
	xhr.open('POST', 'select_permisos.php' , true);
	xhr.onreadystatechange=function()
	{
		if (xhr.readyState==4 && xhr.status==200)
		{
			document.getElementById(div).innerHTML=xhr.responseText;
		} 
	}
	xhr.send(data);
}

function CargarUnidadesReporte(peri_dist_cab_codi, nivel, div)
{
	var data = new FormData();
	data.append('peri_dist_cab_codi', peri_dist_cab_codi);
	data.append('nivel', nivel);
	data.append('select', 'UnidadesReporte')
	var xhr = new XMLHttpRequest();
	xhr.open('POST', 'select_permisos.php' , true);
	xhr.onreadystatechange=function()
	{
		if (xhr.readyState==4 && xhr.status==200)
		{
			document.getElementById(div).innerHTML=xhr.responseText;
		} 
	}
	xhr.send(data);
}

function CargarCursosGeneral(peri_dist_cab_codi, div)
{
	var data = new FormData();
	data.append('peri_dist_cab_codi', peri_dist_cab_codi);
	data.append('select', 'CursosGeneral');
	var xhr = new XMLHttpRequest();
	xhr.open('POST', 'select_permisos.php' , true);
	xhr.onreadystatechange=function()
	{
		if (xhr.readyState==4 && xhr.status==200)
		{
			document.getElementById(div).innerHTML=xhr.responseText;
		} 
	}
	xhr.send(data);
}

function CargarCursosIndividual(peri_dist_cab_codi, div)
{
	var data = new FormData();
	data.append('peri_dist_cab_codi', peri_dist_cab_codi);
	data.append('select', 'CursosIndividual');
	var xhr = new XMLHttpRequest();
	xhr.open('POST', 'select_permisos.php' , true);
	xhr.onreadystatechange=function()
	{
		if (xhr.readyState==4 && xhr.status==200)
		{
			document.getElementById(div).innerHTML=xhr.responseText;
		} 
	}
	xhr.send(data);
}

function CargarProfesoresGeneral(peri_dist_cab_codi, div)
{
	var data = new FormData();
	data.append('peri_dist_cab_codi', peri_dist_cab_codi);
	data.append('select', 'ProfesoresGeneral');
	
	var xhr = new XMLHttpRequest();
	xhr.open('POST', 'select_permisos.php' , true);
	xhr.onreadystatechange=function()
	{
		if (xhr.readyState==4 && xhr.status==200)
		{
			document.getElementById(div).innerHTML=xhr.responseText;
		} 
	}
	xhr.send(data);
}

function CargarProfesoresIndividual(curs_para_codi, div)
{
	var data = new FormData();
	data.append('curs_para_codi', curs_para_codi);
	data.append('select', 'ProfesoresIndividual');
	
	var xhr = new XMLHttpRequest();
	xhr.open('POST', 'select_permisos.php' , true);
	xhr.onreadystatechange=function()
	{
		if (xhr.readyState==4 && xhr.status==200)
		{
			document.getElementById(div).innerHTML=xhr.responseText;
		} 
	}
	xhr.send(data);
}