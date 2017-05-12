function js_rep_debito_carga_reports_deudores( div, url, evento ) //PDF DE LA TABLA PRINCIPAL CON TOTALES VERTICALES Y HORIZONTALES
{   "use strict";
    var doit = 'yes';

    if( doit === 'yes' )
    {   var curso =0;
        var nivelEcon='';
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
		var quienes = document.querySelector('input[id="rdb_quienes"]:checked').value;
        var url2=url+'?event='+evento+'&curs_codi='+curso+'&nivelEcon_codi='+nivelEcon+'&peri_codi='+periodos+'&quienes='+quienes;
        console.log(url2);
        window.open(url2);
    }
}