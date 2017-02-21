// JavaScript Document
function js_rep_saldoafavor_reporte( div, url, evento )
{   document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    periodos= document.getElementById('periodos').value;
	niveles= document.getElementById('cmb_nivelesEconomicos').value;
	cursos= document.getElementById('curso').value;
	var data = new FormData();
	
	data.append('event', 'printvisor');
	data.append('periodofinal', periodos);
	data.append('nivelEconomico', niveles);
	data.append('curso', cursos);
	url2=url+'?event='+evento+'&periodofinal='+periodos+'&nivelEcon='+niveles+'&curso='+cursos;
	data.append('url',url2);
	var xhr = new XMLHttpRequest();
	xhr.open('POST', url , true);
	xhr.onreadystatechange=function()
	{   if ( xhr.readyState === 4 && xhr.status === 200 )
		{   document.getElementById(div).innerHTML = xhr.responseText;
		}
	};
	xhr.send(data);
}