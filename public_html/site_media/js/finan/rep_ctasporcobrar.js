$(document).ready(function() {
	$("#txt_fecha_ini").datepicker();
	$("#txt_fecha_fin").datepicker();
	
	$("#boton_busqueda").click(function()
	{   $("#desplegable_busqueda").slideToggle(200);
	});
	
	$("#desplegable_busqueda").show();
	$("#cmb_producto").select2();
});
function js_rep_ctasporcobrar_carga_rpte( div, url,evento )
{   "use strict";
	var doit = 'yes';
    if( evento == 'print_cierres' )
	{   if ( ( document.getElementById('curso').value == -1 ) || ( document.getElementById('curso').value == 0 ) )
		{   $('#modal_msg').modal('show');
			document.getElementById('modal_msg_body').innerHTML='Esta opción sólo permite descargar un curso a la vez. ¡Debe seleccionar un curso para poder imprimir el PDF!';
			doit = 'no';
		}
	}
	if( doit === 'yes' )
	{   var curso =0;
		var fecha_fin='';
		var nivelEcon='';
		if(document.getElementById('txt_fecha_fin').value.length>0)
		{    fecha_fin= document.getElementById('txt_fecha_fin').value;
		}
		else
		{    fecha_fin='';
		}
		if(document.getElementById('curso').value!=-1)
		{    curso= document.getElementById('curso').value;
		}
		else
		{    curso='';
		}
		if(document.getElementById('cmb_nivelesEconomicos').value!=-1)
		{    nivelEcon= document.getElementById('cmb_nivelesEconomicos').value;
		}
		else
		{    nivelEcon='';
		}
		var periodos = document.getElementById('periodos').value;
		var productos = $("#cmb_producto").val();
		
		document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
		
		var data = new FormData();
		data.append('event', 'printvisor');
		var url2=url+'?event=print_cierres_pdf&eventox='+evento+'&curs_codi='+curso+'&nivelEcon_codi='+nivelEcon+'&peri_codi='+periodos+'&fechacorte_fin='+fecha_fin+'&productos='+productos;
		window.open(url2);
		/* Para abrirlo en un modal.
		data.append('url',url2);
		var xhr = new XMLHttpRequest();
		xhr.open('POST', url , true);
		xhr.onreadystatechange=function()
		{   if (xhr.readyState === 4 && xhr.status === 200 )
			{   document.getElementById(div).innerHTML=xhr.responseText;
			} 
		};
		xhr.send(data);*/
	}
}
function js_rep_ctasporcobrar_carga_rpte_xls( div, url,evento )
{   "use strict";
	var doit = 'yes';
    if( evento == 'print_cierres' )
	{   if ( ( document.getElementById('curso').value == -1 ) || ( document.getElementById('curso').value == 0 ) )
		{   $('#modal_msg').modal('show');
			document.getElementById('modal_msg_body').innerHTML='Esta opción sólo permite descargar un curso a la vez. ¡Debe seleccionar un curso para poder imprimir el PDF!';
			doit = 'no';
		}
	}
	if( doit === 'yes' )
	{   var curso =0;
		var fecha_fin='';
		var nivelEcon='';
		if(document.getElementById('txt_fecha_fin').value.length>0)
		{    fecha_fin= document.getElementById('txt_fecha_fin').value;
		}
		else
		{    fecha_fin='';
		}
		if(document.getElementById('curso').value!=-1)
		{    curso= document.getElementById('curso').value;
		}
		else
		{    curso='';
		}
		if(document.getElementById('cmb_nivelesEconomicos').value!=-1)
		{    nivelEcon= document.getElementById('cmb_nivelesEconomicos').value;
		}
		else
		{    nivelEcon='';
		}
		var periodos = document.getElementById('periodos').value;
		var productos = $("#cmb_producto").val();
		
		//document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
		
		var data = new FormData();
		data.append('event', 'printvisor');
		var url2=url+'?event=print_cierres_xls&eventox='+evento+'&curs_codi='+curso+'&nivelEcon_codi='+nivelEcon+'&peri_codi='+periodos+'&fechacorte_fin='+fecha_fin+'&productos='+productos;
		window.open(url2);
		/* Para abrirlo en un modal.
		data.append('url',url2);
		var xhr = new XMLHttpRequest();
		xhr.open('POST', url , true);
		xhr.onreadystatechange=function()
		{   if (xhr.readyState === 4 && xhr.status === 200 )
			{   document.getElementById(div).innerHTML=xhr.responseText;
			} 
		};
		xhr.send(data);*/
	}
}
function rep_ctasporcobrar_check_fecha()
{   "use strict";
    var checked=document.getElementById('chk_fecha').checked;
    if(!checked)
    {   document.getElementById('txt_fecha_fin').disabled = true;
        document.getElementById('txt_fecha_fin').value = '';
    }else
    {   document.getElementById('txt_fecha_fin').disabled = false;
        document.getElementById('txt_fecha_fin').value = obtener_fecha('hoy');
    }
}