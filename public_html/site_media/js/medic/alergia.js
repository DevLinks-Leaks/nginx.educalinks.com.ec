// JavaScript Document
function js_alergia_cargaAlergiaTipo( div_resultado, combo_nombre, tipo_codi )
{   "use strict";
    document.getElementById( div_resultado ).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
	var data = new FormData();
	data.append( 'tipo_codi', tipo_codi );
    data.append( 'combo_nombre', combo_nombre );
    data.append( 'event', 'get_tipo' );
    var xhr = new XMLHttpRequest();
    xhr.open('POST', document.getElementById('ruta_html_medic').value + '/ficha_nuevo/controller.php' , true);
    xhr.onreadystatechange=function()
	{   if (xhr.readyState === 4 && xhr.status === 200)
		{   document.getElementById( div_resultado ).innerHTML=xhr.responseText;
        }
    };
    xhr.send(data);
}
function js_alergia_cargaAlergiaTipo_SelectFormat( div_resultado, combo_nombre, div_followed, combo_nombre_followed )
{   "use strict";
    document.getElementById( div_resultado ).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
	var data = new FormData();
    data.append( 'combo_nombre', combo_nombre );
    data.append( 'div_followed', div_followed );
	data.append( 'combo_nombre_followed', combo_nombre_followed );
    data.append( 'event', 'get_tipo_combo' );
    var xhr = new XMLHttpRequest();
    xhr.open('POST', document.getElementById('ruta_html_medic').value + '/ficha_nuevo/controller.php' , true);
    xhr.onreadystatechange=function()
	{   if (xhr.readyState === 4 && xhr.status === 200)
		{   document.getElementById( div_resultado ).innerHTML=xhr.responseText;
			js_cargo_cargaCargo_SelectFormat( div_followed, combo_nombre_followed, document.getElementById(combo_nombre).value );
        }
    };
    xhr.send(data);
}
function js_alergia_cargaAlergia( div_resultado, combo_nombre, tipo_codi, ele_protex_codi )
{   "use strict";
    document.getElementById( div_resultado ).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
	var data = new FormData();
    data.append( 'ele_protex_codi', ele_protex_codi );
    data.append( 'tipo_codi', tipo_codi );
    data.append( 'combo_nombre', combo_nombre );
    data.append( 'event', 'get_subtipo' );
    var xhr = new XMLHttpRequest();
    xhr.open('POST', document.getElementById('ruta_html_medic').value + '/alergia/controller.php' , true);
    xhr.onreadystatechange=function()
	{   if (xhr.readyState === 4 && xhr.status === 200)
		{   document.getElementById( div_resultado ).innerHTML=xhr.responseText;
        }
    };
    xhr.send(data);
}
function js_alergia_cargaAlergia_SelectFormat( div_resultado, combo_nombre, tipo_codi )
{   "use strict";
    document.getElementById( div_resultado ).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
	var data = new FormData();
    data.append( 'tipo_codi', tipo_codi );
    data.append( 'combo_nombre', combo_nombre );
    data.append( 'event', 'get_subtipo_combo' );
    var xhr = new XMLHttpRequest();
    xhr.open('POST', document.getElementById('ruta_html_medic').value + '/alergia/controller.php' , true);
    xhr.onreadystatechange=function()
	{   if (xhr.readyState === 4 && xhr.status === 200)
		{   document.getElementById( div_resultado ).innerHTML=xhr.responseText;
        }
    };
    xhr.send(data);
}