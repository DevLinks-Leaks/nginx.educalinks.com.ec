$(document).ready(function()
{   $('#grupoEconomico_table').addClass( 'nowrap' ).DataTable({
        lengthChange: false, 
        responsive: true, 
        searching: true,  
        orderClasses: true, 
        paging:true,
        bInfo:false,
        language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'},
        "columnDefs": [
            {className: "dt-body-center"  , "targets": [0]},
            {className: "dt-body-left"  , "targets": [1]},
            {className: "dt-body-left"   , "targets": [2]},
            {className: "dt-body-center"  , "targets": [3]}
        ]
    });
    var table = $('#tarjetaCredito').DataTable();
    table.column( '1:visible' ).order( 'desc' );
});
// Consulta filtrada
function js_gruposEconomico_busca( busq, div, url )
{   document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var data = new FormData();
    data.append('event', 'get_all_data');
    data.append('busq', busq);    
    var xhr = new XMLHttpRequest();
    xhr.open('POST', url , true);
    xhr.onreadystatechange=function()
    {   if ( xhr.readyState === 4 && xhr.status === 200 )
        {   document.getElementById(div).innerHTML=xhr.responseText;
            $('#grupoEconomico_table').addClass( 'nowrap' ).DataTable({
                lengthChange: false, 
                responsive: true, 
                searching: true,  
                orderClasses: true, 
                paging:true,
                bInfo:false,
                language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'},
                "columnDefs": [
                    {className: "dt-body-center"  , "targets": [0]},
                    {className: "dt-body-left"  , "targets": [1]},
                    {className: "dt-body-left"   , "targets": [2]},
                    {className: "dt-body-center"  , "targets": [3]}
                ]
            });
        }
        var table = $('#tarjetaCredito').DataTable();
        table.column( '1:visible' ).order( 'desc' );
    };
    xhr.send(data);
}
// Carga el formulario para ingresar un nuevo registro
function js_gruposEconomico_carga_add( div, url )
{   document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';var data = new FormData();
    data.append('event', 'agregar');    
    var xhr = new XMLHttpRequest();
    xhr.open('POST', url , true);
    xhr.onreadystatechange=function()
    {   if ( xhr.readyState === 4 && xhr.status === 200 )
        {   document.getElementById(div).innerHTML=xhr.responseText;
            $("#txt_rango_ini_add").numeric({ decimal : ".",  negative : false, scale: 2, precision: 8 });
            $("#txt_rango_fin_add").numeric({ decimal : ".",  negative : false, scale: 2, precision: 8 });
        }
    };
    xhr.send(data);
}
// Carga el formulario para editar un registro
function js_gruposEconomico_carga_edit( codigo, div,url )
{   document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var data = new FormData();
    data.append('event', 'get');
    data.append('codigo', codigo);    
    var xhr = new XMLHttpRequest();
    xhr.open('POST', url , true);
    xhr.onreadystatechange=function(){
        if ( xhr.readyState === 4 && xhr.status === 200 )
        {   document.getElementById(div).innerHTML=xhr.responseText;            
            $("#txt_rango_ini_mod").numeric({ decimal : ".",  negative : false, scale: 2, precision: 8 });
            $("#txt_rango_fin_mod").numeric({ decimal : ".",  negative : false, scale: 2, precision: 8 });
        } 
    };
    xhr.send(data);
}
// Realiza el ingreso de un registro nuevo
function js_gruposEconomico_add( div, url )
{   if ( document.getElementById('txt_rango_ini_add').value > document.getElementById('txt_rango_fin_add').value )
        $.growl.warning({ title: "Educalinks informa",message: "Rango inicial no puede ser mayor." });
    else
    {   document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
        var data = new FormData();
        data.append('event', 'set');
        data.append('nombre', document.getElementById('nombre_add').value);
        data.append('descripcion', document.getElementById('descripcion_add').value);
        data.append('rango_desde', document.getElementById('txt_rango_ini_add').value);
        data.append('rango_hasta', document.getElementById('txt_rango_fin_add').value);
        var xhr = new XMLHttpRequest();
        xhr.open('POST', url , true);
        xhr.onreadystatechange=function()
        {   if ( xhr.readyState === 4 && xhr.status === 200 )
            {   $('#modal_add').modal('hide');
                var n = xhr.responseText.length;
                if (n > 0)
                {   valida_tipo_growl(xhr.responseText);
                }
                else
                {   $.growl.warning({ title: "Educalinks informa",message: "Proceso realizado." + xhr.responseText });
                }
                js_gruposEconomico_busca( "", div, url );
            } 
        };
        xhr.send(data);
    }
}
// Realiza la actualizacion de los datos en la BD
function js_gruposEconomico_edit( rol_codigo, div, url )
{   if ( document.getElementById('txt_rango_ini_mod').value > document.getElementById('txt_rango_fin_mod').value )
        $.growl.warning({ title: "Educalinks informa",message: "Rango inicial no puede ser mayor." });
    else
    {   if(confirm("¿Está seguro que desea editar la información del grupo economico?"))
        {   document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
            var data = new FormData();
            data.append('event', 'edit');
            data.append('codigo', document.getElementById('codigo_mod').value);
            data.append('nombre', document.getElementById('nombre_mod').value);
            data.append('descripcion', document.getElementById('descripcion_mod').value);
            data.append('rango_desde', document.getElementById('txt_rango_ini_mod').value);
            data.append('rango_hasta', document.getElementById('txt_rango_fin_mod').value);
            
            var xhr = new XMLHttpRequest();
            xhr.open('POST', url , true);
            xhr.onreadystatechange=function()
            {   if ( xhr.readyState === 4 && xhr.status === 200 )
                {   $('#modal_edit').modal('hide');
                    var n = xhr.responseText.length;
                    if (n > 0)
                    {   valida_tipo_growl(xhr.responseText);
                    }
                    else
                    {   $.growl.warning({ title: "Educalinks informa",message: "Proceso realizado." + xhr.responseText });
                    }
                    js_gruposEconomico_busca("",div,url);
                } 
            };
            xhr.send(data);
        }
    }
}
function js_gruposEconomico_del( codigo, div, url )
{   if(confirm("¿Está seguro que desea eliminar el grupo economico actual?"))
    {   document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
        var data = new FormData();
        data.append('event', 'delete');
        data.append('codigo', codigo);    
        var xhr = new XMLHttpRequest();
        xhr.open('POST', url , true);
        xhr.onreadystatechange=function()
        {   if ( xhr.readyState === 4 && xhr.status === 200 )
            {   var n = xhr.responseText.length;
                if (n > 0)
                {   valida_tipo_growl(xhr.responseText);
                }
                else
                {   $.growl.warning({ title: "Educalinks informa",message: "Proceso realizado." + xhr.responseText });
                }
                js_gruposEconomico_busca("",div,url);
            } 
        };
        xhr.send(data);
    }
}
function js_gruposEconomico_get_config ()
{   var data = new FormData();
    data.append( 'event', 'get_gec_settings' );
    var xhr = new XMLHttpRequest();
    xhr.open('POST', document.getElementById('ruta_html_finan').value + '/gruposEconomico/controller.php' , true);
    xhr.onreadystatechange=function()
    {   if ( xhr.readyState === 4 && xhr.status === 200 )
        {   if ( xhr.responseText == 'S' )
                document.getElementById( 'check_usar_rango_aut_ingreso' ).checked = 'checked';
            else
                document.getElementById( 'check_usar_rango_aut_ingreso' ).checked = false;
        }
    };
    xhr.send(data);
}
function js_gruposEconomico_set_config ()
{   var data = new FormData();
    data.append( 'event', 'set_gec_settings' );
    data.append( 'check_usar_rango_aut_ingreso', document.getElementById( 'check_usar_rango_aut_ingreso' ).checked );
    var xhr = new XMLHttpRequest();
    xhr.open('POST', document.getElementById('ruta_html_finan').value + '/gruposEconomico/controller.php' , true);
    xhr.onreadystatechange=function()
    {   if ( xhr.readyState === 4 && xhr.status === 200 )
        {   $('#modal_configGec').modal('hide');
            var n = xhr.responseText.length;
            if (n > 0)
            {   valida_tipo_growl(xhr.responseText);
            }
            else
            {   $.growl.warning({ title: "Educalinks informa",message: "Proceso realizado." + xhr.responseText });
            }
        }
    };
    xhr.send(data);
}