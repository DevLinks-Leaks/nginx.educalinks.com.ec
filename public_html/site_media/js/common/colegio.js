// JavaScript Document
function js_colegio_cargaColegio( div_colegio, combo_nombre_ciudad, combo_nombre_colegio, url )
{   "use strict";
    if( document.getElementById( combo_nombre_ciudad ) )
		var ciudadID = document.getElementById( combo_nombre_ciudad ).value;
	else
		var ciudadID = "-1";
    document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
	var data = new FormData();
    data.append( 'ciudadID', ciudadID );
    data.append( 'combo_nombre_colegio', combo_nombre_colegio );
    data.append( 'event', 'get_colegio' );
    var xhr = new XMLHttpRequest();
    xhr.open('POST', url , true);
    xhr.onreadystatechange=function(){
        if (xhr.readyState === 4 && xhr.status === 200){
            document.getElementById( div_colegio ).innerHTML=xhr.responseText;
        }console.log(xhr.responseText);
    };
    xhr.send(data);
}