$(document).ready(function() {
    actualiza_badge_gest_fact();
    $('#precio_table').addClass( 'nowrap' ).DataTable({lengthChange: false, responsive: true, searching: true,  orderClasses: true, paging:true,
        language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'},
        "columnDefs": [
            {className: "dt-body-center" , "targets": [0]},
            {className: "dt-body-center" , "targets": [1]},
            {className: "dt-body-center" , "targets": [2]},
            {"title": "<span style='color:DarkGreen'>P.V.P.</span>", className: "dt-body-right"  , "targets": [3]},
            {className: "dt-body-center" , "targets": [4]},
            {className: "dt-body-center" , "targets": [5]}
        ]
    });
});
function cargaProductos(div, url){
    document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var comboCategoria = document.getElementById("codigoCategoria_busq");
    var data = new FormData();
    data.append('codigoCategoria', comboCategoria.options[comboCategoria.selectedIndex].value);    
    data.append('event', 'get_producto');    
    var xhr = new XMLHttpRequest();
    xhr.open('POST', url , true);
    xhr.onreadystatechange=function(){
        if (xhr.readyState==4 && xhr.status==200){
            document.getElementById(div).innerHTML=xhr.responseText;
        } 
    }
    xhr.send(data);
}
// Consulta filtrada
function busca(div,url)
{   document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var data = new FormData();
    var comboProducto = document.getElementById('codigoProducto_busq');
    data.append('event', 'get_all_data');
    data.append('codigoProducto', comboProducto.options[comboProducto.selectedIndex].value);    
    var xhr = new XMLHttpRequest();
    xhr.open('POST', url , true);
    xhr.onreadystatechange=function()
	{   if (xhr.readyState==4 && xhr.status==200)
        {   document.getElementById(div).innerHTML=xhr.responseText;
            $('#precio_table').addClass( 'nowrap' ).DataTable({lengthChange: false, responsive: true, searching: true,  orderClasses: true, paging:true,
                language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'},
                "columnDefs": [
                    {className: "dt-body-center" , "targets": [0]},
                    {className: "dt-body-center" , "targets": [1]},
                    {className: "dt-body-center" , "targets": [2]},
                    {"title": "<span style='color:DarkGreen'>P.V.P.</span>", className: "dt-body-right"  , "targets": [3]},
                    {className: "dt-body-center" , "targets": [4]},
                    {className: "dt-body-center" , "targets": [5]}
                ]
            });
        }
    };
    xhr.send(data);
}
// Carga el formulario para ingresar un nuevo registro
function carga_add(div,url){
    document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var data = new FormData();
    var comboProducto = document.getElementById('codigoProducto_busq');
    data.append('event', 'agregar');
    data.append('nombreProducto', comboProducto.options[comboProducto.selectedIndex].innerHTML);    
    data.append('codigoProducto', comboProducto.options[comboProducto.selectedIndex].value);    
    var xhr = new XMLHttpRequest();
    xhr.open('POST', url , true);
    xhr.onreadystatechange=function(){
        if (xhr.readyState==4 && xhr.status==200){
            document.getElementById(div).innerHTML=xhr.responseText;
            $(function() {$('#precio_add').maskMoney({thousands:'', decimal:'.', allowZero:false});});
        } 
    };
    xhr.send(data);
}
// Realiza el ingreso de un registro nuevo
function validaAdd(div,url)
{   add(div,url);
    return false;
}
function add(div,url){
    var bypass = false;
    if (document.getElementById('codigoProducto_add').value <= 0){
        if(confirm("¿Está seguro de ingresar el precio actual a TODOS los productos de la CATEGORÍA seleccionada?")){
            bypass = true;
        }        
    }else{
        bypass = true;
    }

    if(bypass){
        var categorias = document.getElementById('codigoCategoria_busq');
        document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
		var data = new FormData();
        var comboGrupoEconomico = document.getElementById('grupoEconomico_add');
        var comboNivelEconomico = document.getElementById('nivel_economico_add');
        
        data.append('event', 'set');
        if (document.getElementById('codigoProducto_add').value <= 0){
            data.append('codigoCategoria', categorias.options[categorias.selectedIndex].value );
                if (document.getElementById('grupoEconomico_add').value <= 0)
                {
                data.append('casos','caso grupoeco');
                }
                 if(document.getElementById('nivel_economico_add').value <= 0)
                {
                data.append('casos','caso niveleco');    
                }
                if((document.getElementById('grupoEconomico_add').value <= 0) && (document.getElementById('nivel_economico_add').value <= 0))
                {
                data.append('casos','caso gruponivel');
                }
            
        }else{
            data.append('codigoProducto', document.getElementById('codigoProducto_add').value);
            data.append('casos','caso individual');
        }
        //data.append('codigoProducto', document.getElementById('codigoProducto_add').value);
        
        data.append('codigoGrupoEconomico', comboGrupoEconomico.options[comboGrupoEconomico.selectedIndex].value);
        data.append('codigoNivelEconomico', comboNivelEconomico.options[comboNivelEconomico.selectedIndex].value);
        data.append('precio', document.getElementById('precio_add').value);
        data.append('cuentacontable', document.getElementById('cuentacontable_add').value);
    
        var xhr = new XMLHttpRequest();
        xhr.open('POST', url , true);
        xhr.onreadystatechange=function()
        {   if (xhr.readyState==4 && xhr.status==200)
            {   var n = xhr.responseText.length;
                if (n > 0)
                {   valida_tipo_growl(xhr.responseText);
                }
                else
                {   $.growl.warning({ title: "Educalinks informa:",message: "Proceso realizado." });
                }
                busca(div,url);
            }
        };
        xhr.send(data);
    }
}
function js_precios_del(codigo,div,url)
{   if(confirm("¿Est&aacute; seguro que desea eliminar el precio?"))
	{   document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
		var data = new FormData();
		data.append('event', 'delete');
		data.append('codigo', codigo);	
		var xhr = new XMLHttpRequest();
		xhr.open('POST', url , true);
		xhr.onreadystatechange=function()
		{   if (xhr.readyState==4 && xhr.status==200)
			{	var n = xhr.responseText.length;
                if (n > 0)
                {   valida_tipo_growl(xhr.responseText);
                }
                else
                {   $.growl.warning({ title: "Educalinks informa:",message: "Proceso realizado." });
                }
                busca(div,url);
			} 
		};
		xhr.send(data);
	}
}