function js_cargo_cargaCargo( div_resultado, combo_nombre, dept_codi, cargo_codi )
{   "use strict";
    document.getElementById( div_resultado ).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
	var data = new FormData();
    data.append( 'cargo_codi', cargo_codi );
    data.append( 'dept_codi', dept_codi );
    data.append( 'combo_nombre', combo_nombre );
    data.append( 'event', 'get' );
    var xhr = new XMLHttpRequest();
    xhr.open('POST', document.getElementById('ruta_html_common').value + '/cargo/controller.php' , true);
    xhr.onreadystatechange=function()
	{   if (xhr.readyState === 4 && xhr.status === 200)
		{   document.getElementById( div_resultado ).innerHTML=xhr.responseText;
        }
    };
    xhr.send(data);
}
function js_cargo_cargaCargo_SelectFormat( div_resultado, combo_nombre, dept_codi )
{   "use strict";
    document.getElementById( div_resultado ).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
	var data = new FormData();
    data.append( 'dept_codi', dept_codi );
    data.append( 'combo_nombre', combo_nombre );
    data.append( 'event', 'get_combo' );
    var xhr = new XMLHttpRequest();
    xhr.open('POST', document.getElementById('ruta_html_common').value + '/cargo/controller.php' , true);
    xhr.onreadystatechange=function()
	{   if (xhr.readyState === 4 && xhr.status === 200)
		{   document.getElementById( div_resultado ).innerHTML=xhr.responseText;
        }
    };
    xhr.send(data);
}