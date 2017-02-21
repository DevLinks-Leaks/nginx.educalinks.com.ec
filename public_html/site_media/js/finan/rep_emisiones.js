$(document).ready(function() {
	$("#txt_fecha_ini").datepicker();
	$("#txt_fecha_fin").datepicker();
	
	$("#boton_busqueda").click(function()
	{   $("#desplegable_busqueda").slideToggle(200);
	});
	
	$("#desplegable_busqueda").show();
	$("#cmb_producto").select2();
});

function js_rep_emisiones_carga_reports_deudores( div, url, evento ) //PDF DE LA TABLA PRINCIPAL CON TOTALES VERTICALES Y HORIZONTALES
{   "use strict";
    var doit = 'yes';
    /*if ( ( document.getElementById('curso').value == -1 ) || ( document.getElementById('curso').value == 0 ) )
    {   $('#modal_msg').modal('show');
        document.getElementById('modal_msg_body').innerHTML='¡Debe seleccionar un curso para poder descargar el archivo PDF!';
        doit = 'no';
    }*/
	console.log(doit);
    if( doit === 'yes' )
    {   var curso =0;
        var fecha_ini='';
        var fecha_fin='';
        var nivelEcon='';
        if(document.getElementById('txt_fecha_ini').value.length>0)
        {    fecha_ini= document.getElementById('txt_fecha_ini').value;
        }
        else
        {    fecha_ini='';
        }
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
        var periodos= document.getElementById('periodos').value;
        var quienes = 'T';
        var productos = $("#cmb_producto").val();
        var url2=url+'?event='+evento+'&curs_codi='+curso+'&nivelEcon_codi='+nivelEcon+'&peri_codi='+periodos+'&fechavenc_ini='+fecha_ini+'&fechavenc_fin='+fecha_fin+'&quienes='+quienes+'&productos='+productos;
        console.log(url2);
        window.open(url2);
    }
}
function js_rep_emisiones_check_fecha()
{   "use strict";
    var checked=document.getElementById('chk_fecha').checked;
    if(!checked)
    {   document.getElementById('txt_fecha_ini').disabled = true;
        document.getElementById('txt_fecha_ini').value = '';
		document.getElementById('txt_fecha_fin').disabled = true;
        document.getElementById('txt_fecha_fin').value = '';
    }else
    {   document.getElementById('txt_fecha_ini').disabled = false;
        document.getElementById('txt_fecha_ini').value = obtener_fecha('ayer');
		document.getElementById('txt_fecha_fin').disabled = false;
        document.getElementById('txt_fecha_fin').value = obtener_fecha('hoy');
    }
}