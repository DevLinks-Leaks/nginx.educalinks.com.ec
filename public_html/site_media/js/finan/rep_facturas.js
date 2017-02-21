$(document).ready(function(){
    $("#txt_fecha_ini").datepicker();
    $("#txt_fecha_fin").datepicker();
});
function js_rep_facturas_carga_reports_descuentos( div, url, evento )
{   document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var cajero = document.getElementById("caja").value;
    var fecha_ini= document.getElementById('txt_fecha_ini').value;
    var fecha_fin= document.getElementById('txt_fecha_fin').value;
    var data = new FormData();
    
    data.append('event', 'printvisor');
    data.append('codigo', cajero);
    data.append('fecha_ini', fecha_ini);
    data.append('fecha_fin', fecha_fin);
    url2=url+'?event='+evento+'&codigo='+cajero+'&fecha_ini='+fecha_ini+'&fecha_fin='+fecha_fin;
    data.append('url',url2);
    var xhr = new XMLHttpRequest();
    xhr.open('POST', url , true);
    xhr.onreadystatechange=function()
    {   if ( xhr.readyState === 4 && xhr.status === 200 )
        {   document.getElementById(div).innerHTML=xhr.responseText;
        }
    };
    xhr.send(data);
}
function js_rep_facturas_excel( evento, tipo_reporte )
{   document.getElementById( 'evento' ).value = evento;
    document.getElementById( 'tipo_reporte' ).value = tipo_reporte;
    document.getElementById( 'file_form' ).submit();
}