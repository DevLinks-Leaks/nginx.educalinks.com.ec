// JavaScript Document
$(document).ready(function() {
    $('#modal_matchcategorias').on('shown.bs.modal', function (e) {});
    $('#tablapagos').addClass( 'nowrap' ).DataTable({
        lengthChange: false, 
        responsive: true, 
        searching: true,  
        orderClasses: true, 
        paging:true,
        bInfo:false,
        language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'},
        "columnDefs": [
            {className: "dt-body-center" , "targets": [0]},
            {className: "dt-body-left"   , "targets": [1]},
            {className: "dt-body-left"   , "targets": [2]},
            {className: "dt-body-center"   , "targets": [3]},
            {className: "dt-body-center" , "targets": [4]}
        ]
    });
    var table = $('#tablapagos').DataTable();
    table.column( '0:visible' ).order( 'asc' );
    
    $('#tabla_paidDNAs_main').addClass( 'nowrap' ).DataTable({
        lengthChange: false, 
        responsive: true, 
        searching: true,  
        orderClasses: true, 
        paging:true,
        bInfo:false,
        language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'},
        "columnDefs": [
            {className: "dt-body-center" , "targets": [0]},
            {className: "dt-body-left"   , "targets": [1]},
            {className: "dt-body-left"   , "targets": [2]},
            {className: "dt-body-center" , "targets": [3]},
            {className: "dt-body-center" , "targets": [4]}
        ]
    });
    var table = $('#tabla_paidDNAs_main').DataTable();
    table.column( '0:visible' ).order( 'asc' );
    
    $('#tablacategoria').addClass( 'nowrap' ).DataTable({
        lengthChange: false, 
        responsive: true, 
        searching: true,  
        orderClasses: true, 
        paging:true,
        bInfo:false,
        language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'},
        "columnDefs": [
            {className: "dt-body-center" , "targets": [0]},
            {className: "dt-body-left"   , "targets": [1]},
            {className: "dt-body-left"   , "targets": [2]},
            {className: "dt-body-center" , "targets": [3]},
            {className: "dt-body-center" , "targets": [4]},
            {className: "dt-body-center" , "targets": [5]}
        ]
    });    
    var table2 = $('#tablacategoria').DataTable();
    table2.column( '0:visible' ).order( 'asc' );
    $('#tablaproductos').addClass( 'nowrap' ).DataTable({
        lengthChange: false, 
        responsive: true, 
        searching: true,  
        orderClasses: true, 
        paging:true,
        bInfo:false,
        language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'},
        "columnDefs": [
            {className: "dt-body-center" , "targets": [0]},
            {className: "dt-body-left"   , "targets": [1]},
            {className: "dt-body-left"   , "targets": [2]},
            {className: "dt-body-center" , "targets": [3]},
            {className: "dt-body-center" , "targets": [4]},
            {className: "dt-body-center" , "targets": [5]}
        ]
    });
    var table3 = $('#tablaproductos').DataTable();
    table3.column( '0:visible' ).order( 'asc' );
});
var fact_enviadas=0;
var fact_procesadas=0;
var correctas=0;
var error=0;
var errorfactura=0;
var repetidas=0;
var proceso_corriendo = 0;
var json_codigoPagos_envioContifico = JSON.parse("[]");
var json_Pagos_envioContifico = JSON.parse("[]");
var json_codigoDeudasPagos_envioContifico = JSON.parse("[]");
var contabilidad_interval_carga_progress_bar_CONTIFICO = setInterval(function()
{   if ( 0 === 0 )
    {   clearInterval(contabilidad_interval_carga_progress_bar_CONTIFICO);
    }
}, Math.round( 100 ) );
function busca(busq,div,url)
{   document.getElementById(div).innerHTML='<br><div align="center"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i><br>Por favor, espere...</div><br>';
    var data = new FormData();
    data.append('event', 'get_all_data');
    data.append('busq', busq);    
    var xhr = new XMLHttpRequest();
    xhr.open('POST', url , true);
    xhr.onreadystatechange=function()
    {   if (xhr.readyState === 4 && xhr.status === 200)
        {   document.getElementById(div).innerHTML=xhr.responseText;
            $('#tablacategoria').addClass( 'nowrap' ).DataTable({
                lengthChange: false, 
                responsive: true, 
                searching: true,  
                orderClasses: true, 
                paging:true,
                bInfo:false,
                language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'},
                "columnDefs": [
                    {className: "dt-body-center" , "targets": [0]},
                    {className: "dt-body-left"   , "targets": [1]},
                    {className: "dt-body-left"   , "targets": [2]},
                    {className: "dt-body-center" , "targets": [3]},
                    {className: "dt-body-center" , "targets": [4]},
                    {className: "dt-body-center" , "targets": [5]}
                ]
            });
            var table = $('#tablacategoria').DataTable();
            table.column( '0:visible' ).order( 'asc' );
        }
    };
    xhr.send(data);
}
function buscaproducto(busq,div,url)
{   document.getElementById(div).innerHTML='<br><div align="center"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i><br>Por favor, espere...</div><br>';
    var data = new FormData();
    data.append('event', 'get_all_data_producto');
    data.append('busq', busq);    
    var xhr = new XMLHttpRequest();
    xhr.open('POST', url , true);
    xhr.onreadystatechange=function()
    {   if (xhr.readyState === 4 && xhr.status === 200)
        {   document.getElementById(div).innerHTML=xhr.responseText;
            $('#tablaproductos').addClass( 'nowrap' ).DataTable({
                lengthChange: false, 
                responsive: true, 
                searching: true,  
                orderClasses: true, 
                paging:true,
                bInfo:false,
                language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'},
                "columnDefs": [
                    {className: "dt-body-center" , "targets": [0]},
                    {className: "dt-body-left"   , "targets": [1]},
                    {className: "dt-body-left"   , "targets": [2]},
                    {className: "dt-body-center" , "targets": [3]},
                    {className: "dt-body-center" , "targets": [4]},
                    {className: "dt-body-center" , "targets": [5]}
                ]
            });
            var table = $('#tablaproductos').DataTable();
            table.column( '0:visible' ).order( 'asc' );
        }
    };
    xhr.send(data);
}
function del(codigo,div,url){
    if(confirm("¿Está seguro que desea eliminar el banco?"))
    {   document.getElementById(div).innerHTML='<br><div align="center"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i><br>Por favor, espere...</div><br>';
        var data = new FormData();
        data.append('event', 'delete');
        data.append('banc_codigo', codigo);    
        var xhr = new XMLHttpRequest();
        xhr.open('POST', url , true);
        xhr.onreadystatechange=function()
        {   if (xhr.readyState === 4 && xhr.status === 200)
            {   document.getElementById(div).innerHTML=xhr.responseText;
                $('#banc_table').datatable({pageSize: 30,sort: [true,true, true, false],filters: [true,true,true,false],filterText: 'Buscar... '}) ;
            } 
        };
        xhr.send(data);
    }
}
function edit(codigo,div,url)
{   document.getElementById(div).innerHTML='<br><div align="center"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i><br>Por favor, espere...</div><br>';
    var data = new FormData();
    data.append('event', 'get');
    data.append('banc_codigo', codigo);    
    var xhr = new XMLHttpRequest();
    xhr.open('POST', url , true);
    xhr.onreadystatechange=function()
    {   if (xhr.readyState === 4 && xhr.status === 200)
        {   document.getElementById(div).innerHTML = xhr.responseText;
        } 
    };
    xhr.send(data);
}
function guardarcontifico(codigo,div,url)
{   if(confirm("¿Está seguro que desea guardar la información?"))
    {    document.getElementById(div).innerHTML='<br><div align="center"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i><br>Por favor, espere...</div><br>';var e = document.getElementById("categorias");
        var strUser = e.options[e.selectedIndex].value;
        var data = new FormData();
        data.append('event', 'savecontifico');
        data.append('catecontifico_codigo', strUser);
        data.append('codigo_categoria', codigo);
        var xhr = new XMLHttpRequest();
        xhr.open('POST', url , true);
        xhr.onreadystatechange=function()
        {   if (xhr.readyState === 4 && xhr.status === 200)
            {   busca("",div,url);
            } 
        };
        xhr.send(data);
    }
}
function showRowInfo(elm)
{   return $(elm).closest("tr").find("td:eq(1)").text();
}
function js_contabilidad_migrarfacturasindividuales(codigo,div,url,elm)
{   var codigofactura=showRowInfo(elm);
    document.getElementById(div).innerHTML='<br><div align="center"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i><br>Por favor, espere...</div><br>';
    document.getElementById( 'span_sendpagoindividual_result_button' ).innerHTML = 
    '<button type="button" class="btn btn-primary" id="btn_sendpagoindividual" name="btn_sendpagoindividual"' +
    ' onclick="js_contabilidad_senddeudaindividual(document.getElementById(\'codigodeuda\').value,\'modal_pagosconfirmacion_body\','+
    '\'modal_pagos_body\',\''+document.getElementById('ruta_html_finan').value + '/contabilidad/controller.php\',document.getElementById(\'codigomes\').value)">Migrar</button>';
    
    var data = new FormData();
    data.append('event', 'migrarfacturasindividuales');
    data.append('codigodeuda', codigo);    
    data.append('codigofactura', codigofactura);    
    var xhr = new XMLHttpRequest();
    xhr.open('POST', url , true);
    xhr.onreadystatechange=function()
    {   if (xhr.readyState === 4 && xhr.status === 200)
        {   document.getElementById(div).innerHTML=xhr.responseText;
        } 
    };
    xhr.send(data);
}
function js_contabilidad_updfacturasindividuales( codigo, div, url, elm )
{   document.getElementById(div).innerHTML='<br><div align="center"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i><br>Por favor, espere...</div><br>';
    document.getElementById( 'span_upddeudaindividual_result_button' ).innerHTML = 
    '<button type="button" class="btn btn-primary" id="btn_upddeudaindividual" name="btn_upddeudaindividual"' +
    ' onclick="js_contabilidad_senddeudaindividualact(document.getElementById(\'codigodeuda\').value,\'modal_upd_dnas_confirmacion_body\','+
    '\'modal_actualizar_body\',\''+document.getElementById('ruta_html_finan').value + '/contabilidad/controller.php\',document.getElementById(\'codigomes_paid_dnas\').value)">Migrar</button>';
    
    var data = new FormData();
    data.append('event', 'migrarfacturasindividualesact');
    data.append('codigodeuda', codigo);
    var xhr = new XMLHttpRequest();
    xhr.open('POST', url , true);
    xhr.onreadystatechange=function()
    {   if (xhr.readyState === 4 && xhr.status === 200)
        {   document.getElementById(div).innerHTML=xhr.responseText;
        }
    };
    xhr.send(data);
}
function js_contabilidad_actualizarfacturas( div, url )
{   if ( document.getElementById('codigomes_paid_dnas') )
    {   var codigo = document.getElementById('codigomes_paid_dnas').value
        document.getElementById(div).innerHTML='<br><div align="center"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i><br>Por favor, espere...</div><br>';
        var data = new FormData();
        data.append('event', 'actualizarfacturas');
        data.append('mes', codigo);
        data.append('peri_codi', $("#cmb_periodo_anual_update option:selected").text() );
        var xhr = new XMLHttpRequest();
        xhr.open('POST', url , true);
        xhr.onreadystatechange=function()
        {   if (xhr.readyState === 4 && xhr.status === 200)
            {   if ( xhr.responseText.length > 0 )
                {   document.getElementById(div).innerHTML = xhr.responseText;
                    document.getElementById('footer_actualizar').innerHTML=
                    '<button type="button" class="btn btn-default" data-dismiss="modal">Ocultar</button></div>'+
                    '<button type="button" class="btn btn-primary" '+
                    'onclick="js_contabilidad_actualizarcontifico(\''+document.getElementById('ruta_html_finan').value+'/contabilidad/controller.php\',\'migrarfacturasresult\',0,0,0,0)">'+
                    'Migrar</button>';
                    document.getElementById('span_boton_headeractualizar').innerHTML=
                    '<button type="button" class="btn btn-warning" '+
                    'onclick=\'js_contabilidad_actualizar_DNAs("'+ codigo +'","modal_actualizar_body","' + document.getElementById('ruta_html_finan').value+'/contabilidad/controller.php")\'>'+
                    '<span class="fa fa-angle-left"></span>&nbsp;Volver</button>';
                }
                else
                {   document.getElementById(div).innerHTML = '<div class="modal-body" id="modal_actualizar_body">'+
                        '<div class="alert alert-danger" role="alert">'+
                        '<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>'+
                        '<span class="sr-only">Atencion:</span>&nbsp;Resultado desconocido</div></div>'+
                        ' <!--<div class="modal-footer" id="footeractualizar"><button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button></div>-->';
                }
            }
        };
        xhr.send(data);
    }
}
function js_contabilidad_actualizar_DNAs( codigo, div, url )
{   if ( proceso_corriendo === 0 )
    {   document.getElementById(div).innerHTML='<br><div align="center"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i><br>Por favor, espere...</div><br>';
        document.getElementById('span_boton_headerdeudas').innerHTML = '';
        document.getElementById('footer_actualizar').innerHTML =
                '<button type="button" class="btn btn-default" data-dismiss="modal">Ocultar</button></div>';
        var data = new FormData();
        data.append('event', 'update_dnas');
        data.append('mes', codigo);
        data.append('anio', $("#cmb_periodo_anual_update option:selected").text());
        var xhr = new XMLHttpRequest();
        xhr.open('POST', url, true);
        xhr.onreadystatechange = function()
        {   if ( xhr.readyState === 4 && xhr.status === 200 )
            {   document.getElementById(div).innerHTML=xhr.responseText;
                $('#tablapaiddnas').addClass( 'nowrap' ).DataTable({
                    lengthChange: false, 
                    responsive: true, 
                    searching: true,  
                    orderClasses: true, 
                    paging:true,
                    language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'}
                });
            }
        };
        xhr.send(data);
    }
    else
    {   $.growl({ title: "Educalinks informa",message: "Hay un envío de información a Contífico en proceso." });
    }
}
function js_contabilidad_migrarfacturas( div, url )
{   if ( document.getElementById('codigomes') )
    {   var codigo = document.getElementById('codigomes').value;
        document.getElementById(div).innerHTML='<br><div align="center"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i><br>Por favor, espere...</div><br>';var data = new FormData();
        data.append('event', 'migrarfacturas');
        data.append('mes', codigo);    
        data.append('anio', $("#cmb_periodo_anual_pagos option:selected").text());
        var xhr = new XMLHttpRequest();
        xhr.open('POST', url , true);
        xhr.onreadystatechange=function()
        {   if (xhr.readyState === 4 && xhr.status === 200)
            {   document.getElementById( div ).innerHTML=xhr.responseText;
                document.getElementById('footerpagos').innerHTML=
                '<button type="button" class="btn btn-default" data-dismiss="modal">Ocultar</button></div>'+
                '<button type="button" class="btn btn-primary" id="btn_migrarpagoscontifico" name="btn_migrarpagoscontifico" '+
                'onclick="js_contabilidad_migrarfacturascontificos(\'' + url + '\',\'modal_pagos_body\',0,0,0,0)">Migrar</button>';
                document.getElementById('span_boton_headerpagos').innerHTML=
                '<button type="button" class="btn btn-warning" '+
                'onclick="js_contabilidad_migrar(\''+codigo+'\',\'modal_pagos_body\',\''+document.getElementById('ruta_html_finan').value+'/contabilidad/controller.php\')">'+
                '<span class="fa fa-angle-left"></span>&nbsp;Volver</button>';
            }
        };
        xhr.send(data);
    }
}
function js_contabilidad_migrarfacturascontificos( url2, div, i, cc, ce,cd )
{   document.getElementById( 'btn_migrarpagoscontifico' ).disabled = true;
    var datosdeudas=document.getElementById('jsondeudas').innerHTML;
    var datosdeudasid=document.getElementById('jsondeudasid').innerHTML;
    var datosdeudasidpago=document.getElementById('jsondeudasidpago').innerHTML;
    var cantidad=document.getElementById('cantidad').value;
    document.getElementById(div).innerHTML='<br><div align="center"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i><br>Por favor, espere...</div><br>';
    var valores = JSON.parse(datosdeudas); //
    var valoresid = JSON.parse(datosdeudasid);
    var valoresidpago = JSON.parse(datosdeudasidpago); //$$
    json_codigoPagos_envioContifico = JSON.parse(datosdeudas); //
    json_codigoDeudasPagos_envioContifico = JSON.parse(datosdeudasid);
    json_Pagos_envioContifico = JSON.parse(datosdeudasidpago) //$$
    fact_enviadas = 0;
    correctas = 0;
    error = 0;
    errorfactura = 0;
    
    if( cantidad === '0' )
    {   document.getElementById(div).innerHTML = '<div class="alert alert-info" role="alert">'+
                '<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>'+
                '<span class="sr-only">Atencion:</span>&nbsp;No hay facturas por migrar.</div>';
    }
    else
    {   proceso_corriendo = 1;
        var start_time = new Date().getTime();
        var request_time = 0;
        var per_complete_first = 0;
        clearInterval(contabilidad_interval_carga_progress_bar_CONTIFICO);
        js_contabilidad_migrarfacturascontificos_followed( url2, div, 0, cantidad, cc, ce, cd, start_time, request_time, per_complete_first );
    }
}
function js_contabilidad_migrarfacturascontificos_followed( url2, div, indice, obj_len, cc, ce, cd, start_time, request_time, per_complete_first )
{   var per_complete = Math.round( ( ( ( indice + 1 ) * 100 ) / obj_len ) );
    if(contabilidad_interval_carga_progress_bar_CONTIFICO)
    {   clearInterval(contabilidad_interval_carga_progress_bar_CONTIFICO);
    }
    if( (fact_enviadas == obj_len) || ( proceso_corriendo === 0 ) )
    {   js_contabilidad_envio_pagos_lote_resultadofinal( url2, correctas, error, errorfactura, 'modal_pagos_body', indice, obj_len );
    }
    else
    {   if ( proceso_corriendo === 1 )
        {   if ( indice > 0 ) 
            {   var progressBar = $('#pb_envio_por_lote'), width = per_complete-per_complete_first-1;
                contabilidad_interval_carga_progress_bar_CONTIFICO = setInterval(function()
                {   width += 1;
                    progressBar.css('width', width + '%');
                    if (document.getElementById('div_text_per_complete'))
                        document.getElementById('div_text_per_complete').innerHTML = width;
                    if ( ( width >= ( per_complete - 1 )) && ((document.getElementById('pb_envio_por_lote'))) )
                    {   clearInterval(contabilidad_interval_carga_progress_bar_CONTIFICO);
                    }
                }, Math.round( request_time / (per_complete_first-1) ) );
            }
            var deuda = JSON.stringify( json_codigoPagos_envioContifico[ indice ] );
            var estado = '';
            var url = 'https://contifico.com/sistema/api/v1/documento/' + json_codigoDeudasPagos_envioContifico[ indice ].trim() + '/cobro/';
            var apikey = document.getElementById('apikey').value;
            var xhrr = new XMLHttpRequest();
            xhrr.open('POST', url , true);
            xhrr.setRequestHeader('Authorization', apikey);
            xhrr.setRequestHeader('Content-type','application/json; charset=utf-8');
            xhrr.onreadystatechange=function()
            {   if ( xhrr.readyState === 4 )
                {   if ( indice === 0 ) 
                    {   per_complete_first = per_complete;
                    }
                    request_time = new Date().getTime() - start_time;
                    if ( xhrr.status === 201 )
                    {   estado = 'MI';
                        correctas=correctas+1;
                    } 
                    else if ( xhrr.status === 401 )
                    {   estado = 'ER';
                        error=error+1;
                    }
                    else if ( xhrr.status === 409 )
                    {   repetidas=repetidas+1;
                    }
                    else if( xhrr.status === 500 )
                    {   estado = 'ER';
                        error=error+1;
                    }
                    else if( xhrr.status === 400 )
                    {   if( xhrr.responseText.length > 0 )
                        {   var mensaje = JSON.parse( xhrr.responseText );
                            if( mensaje.mensaje == 'El documento no tiene saldo pendiente' )
                            {   estado = 'MI';
                                correctas = correctas + 1;
                            }
                            else
                            {   estado = 'DE';
                                errorfactura = errorfactura + 1;
                            }
                        }
                    }
                    document.getElementById(div).innerHTML=
                    '<br>'+ 
                    '<div align="center" style="height:50%;">'+
                        '<i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i>'+
                        '<br>'+
                        '<span style="font-size:small;">Envío de Pagos a Contífico... <span id="div_text_per_complete" name="div_text_per_complete">' + (per_complete) + '</span>% completado</span>'+
                        '<br>'+
                        '<br>'+
                        '<a tabindex="0" class="btn btn-default btn-xs" onclick="js_contabilidad_detener_envio_CONTIFICO( );" data-toggle="tooltip" title="Detener" data-placement="top"><span class="fa fa-stop"></span></a>'+
                        '<a tabindex="0" class="btn btn-default btn-xs" onclick="js_contabilidad_pausar_envio_CONTIFICO( );" data-toggle="tooltip" title="Pausar" data-placement="right"><span class="fa fa-pause"></span></a>'+
                        '<div class="progress progress-striped">'+
                            '<div id="pb_envio_por_lote" name="pb_envio_por_lote" class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:' + (per_complete) + '%;position:relative;">'+
                            '</div>'+
                        '</div>'+
                    '</div>'+
                    '<span style="font-size:xx-small;" align="left">Enviando registro de pagos a Contífico.</span><br>'+
                    '<span style="font-size:xx-small;" align="left">' + ( indice + 1 ) + ' Pagos de ' + obj_len + '.</span>'+
                    '<br>'+
                    '<br>'+
                    '<span id="sms_estado_envio" name="sms_estado_envio" style="font-size:x-small;">Enviando...</span>';
                    var data = new FormData();
                    fact_procesadas = fact_procesadas + 1;
                    data.append('event', 'upddeuda');
                    data.append('codigo_documento', json_Pagos_envioContifico[ indice ] );
                    if( estado == 'MI' )
                        data.append('doccontifico_codigo', json_codigoDeudasPagos_envioContifico[ indice ] );
                    else    
                        data.append('doccontifico_codigo', 0 );
                    data.append('estado', estado);
                    var xhrII = new XMLHttpRequest();
                    xhrII.open('POST', url2 , true);
                    xhrII.onreadystatechange=function()
                    {   if (xhrII.readyState === 4 && xhrII.status === 200)
                        {   fact_enviadas = fact_enviadas + 1;
                            js_contabilidad_migrarfacturascontificos_followed( url2, div, indice + 1, obj_len, cc, ce, cd, new Date().getTime(), request_time, per_complete_first );
                        } 
                    };
                    xhrII.send(data);
                }
            };
            xhrr.send(deuda);
        }
        if( proceso_corriendo === 2 )
        {   document.getElementById(div).innerHTML=
                '<br>'+ 
                '<div align="center">'+
                    '<i style="font-size:large;color:darkred;" class="fa fa-cog"></i>'+
                    '<br>'+ 
                    '<span style="font-size:small;">Envío de Pagos a Contífico... <span id="div_text_per_complete" name="div_text_per_complete">' + (per_complete - per_complete_first - 1) + '</span>% completado</span>'+
                    '<br>'+ 
                    '<br>'+ 
                    '<a tabindex="0" class="btn btn-default btn-xs" onclick="js_contabilidad_detener_envio_CONTIFICO( );js_contabilidad_migrarfacturascontificos_followed   ( \''+url2+'\',\''+ div+'\','+ indice+','+ obj_len+','+ cc+','+ ce+','+ cd+','+ new Date().getTime()+','+ request_time+','+ per_complete_first+');" data-toggle="tooltip" title="Detener" data-placement="top"><span class="fa fa-stop"></span></a>'+
                    '<a tabindex="0" class="btn btn-default btn-xs" onclick="js_contabilidad_continuar_envio_CONTIFICO( );js_contabilidad_migrarfacturascontificos_followed ( \''+url2+'\',\''+ div+'\','+ indice+','+ obj_len+','+ cc+','+ ce+','+ cd+',0,'+ request_time+','+ per_complete_first+');" data-toggle="tooltip" title="Continuar" data-placement="right"><span class="fa fa-play"></span></a>'+
                    '<div class="progress progress-striped">'+
                        '<div id="pb_envio_por_lote" name="pb_envio_por_lote" class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:' + (per_complete - per_complete_first - 1) + '%;position:relative;">'+
                            '<!--<span id="span_envio_por_lote" name="span_envio_por_lote" style="position: absolute;display: block;width: 100%;color: white;">' + (per_complete - per_complete_first - 1) + '% Completado</span>-->'+
                        '</div>'+
                    '</div>'+
                '</div>'+
                '<span style="font-size:xx-small;" align="left">Enviando registro de Pagos a Contífico.</span><br>'+
                '<span style="font-size:xx-small;" align="left">' + ( indice ) + ' Deudas de ' + obj_len + '.</span>'+
                '<br>'+ 
                '<br>'+ 
                '<span id="sms_estado_envio" name="sms_estado_envio" style="font-size:x-small;">Pausado</span>';
        }
    }
} 
function js_contabilidad_envio_pagos_lote_resultadofinal( url, cc, ce, cd, div, indice, obj_len )
{   document.getElementById( div ).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div><br>Por favor, espere...<br>';
    var data = new FormData();
    data.append('event', 'resultado');
    data.append('contadorcorrectos', cc);    
    data.append('contadorerror', ce);    
    data.append('contadorerrfact', cd);
    var xhrII = new XMLHttpRequest();
    xhrII.open('POST', url , true);
    xhrII.onreadystatechange=function()
    {   if (xhrII.readyState === 4 && xhrII.status === 200)
        {   document.getElementById( div ).innerHTML = xhrII.responseText;
            if (!Notification)
            {   alert('Las notificaciones de escritorio no están disponibles en su explorador. Por favor utilzia Chrome.'); 
                return;
            }
            if (Notification.permission !== "granted")
                Notification.requestPermission();
            else
            {   if ( proceso_corriendo === 1 )
                {   var sms_notify = "";
                    if (obj_len > 1)
                        sms_notify = "¡Se han enviado " + ( indice ) + " registros de pagos a Contífico!"
                    else
                        sms_notify = "¡Envío de pagos completado!"
                    
                    var notification = new Notification('Educalinks', {
                        icon: document.getElementById('ruta_imagenes_common').value + "/favicon.png",
                        body: sms_notify,
                    });
                    var ruta_notify = document.getElementById('ruta_html_finan') + "/../../../finan/gestionContifico/";
                    notification.onclick = function ()
                    {   window.open( ruta_notify );
                    };
                }
            }
            proceso_corriendo = 0;
        } 
    };
    xhrII.send(data);
}
function js_contabilidad_actualizarcontifico( url2, div, i, cc, ce, cd )
{   var datosdeudas=document.getElementById('jsondeudas').innerHTML;
    var datosdeudasid=document.getElementById('jsondeudasid').innerHTML;
    var cantidad=document.getElementById('cantidad').value;
    var valores = JSON.parse(datosdeudas);
    json_codigoPagos_envioContifico = JSON.parse(datosdeudas);
    var valoresid = JSON.parse(datosdeudasid);
    json_Pagos_envioContifico = JSON.parse(datosdeudasid);
    var valoresidpago = 0;
    fact_enviadas=0;
    correctas=0;
    error=0;
    errorfactura=0;
    /*
    console.log(valores);
    console.log(valoresid);
    console.log(json_codigoPagos_envioContifico);
    console.log(json_Pagos_envioContifico);
    */
    if( cantidad === '0' )
    {   document.getElementById(div).innerHTML =  '<div class="modal-body" id="modal_actualizar_body">'+
        '<div class="alert alert-info" role="alert">'+
            '<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>'+
            '<span class="sr-only">Atencion:</span>&nbsp;No hay facturas por actualizar.</div></div>';
        /*'<div class="modal-footer" id="footeractualizar">'+
            '<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button></div>';*/
    }
    else
    {   proceso_corriendo = 1;
        var start_time = new Date().getTime();
        var request_time = 0;
        var per_complete_first = 0;
        clearInterval(contabilidad_interval_carga_progress_bar_CONTIFICO);
        js_contabilidad_senddeudaact( url2, div, 0, cantidad, cc, ce, cd, start_time, request_time, per_complete_first );
    }
}
function js_contabilidad_senddeudaact( url2, div, indice, obj_len, cc, ce, cd, start_time, request_time, per_complete_first )
{   var per_complete = Math.round( ( ( ( indice + 1 ) * 100 ) / obj_len ) );
    if(contabilidad_interval_carga_progress_bar_CONTIFICO)
    {   clearInterval(contabilidad_interval_carga_progress_bar_CONTIFICO);
    }
    if( (fact_enviadas == obj_len) || ( proceso_corriendo === 0 ) )
    {   js_contabilidad_resultadofinalact( url2, correctas, error, errorfactura, indice, obj_len );
    }
    else
    {   if ( proceso_corriendo === 1 )
        {   if ( indice > 0 ) 
            {   var progressBar = $('#pb_envio_por_lote'), width = per_complete-per_complete_first-1;
                contabilidad_interval_carga_progress_bar_CONTIFICO = setInterval(function()
                {   width += 1;
                    progressBar.css('width', width + '%');
                    if (document.getElementById('div_text_per_complete'))
                        document.getElementById('div_text_per_complete').innerHTML = width;
                    if ( ( width >= ( per_complete - 1 )) && ((document.getElementById('pb_envio_por_lote'))) )
                    {   clearInterval(contabilidad_interval_carga_progress_bar_CONTIFICO);
                    }
                }, Math.round( request_time / (per_complete_first-1) ) );
            }
            var url='https://www.contifico.com/sistema/api/v1/documento/';
            var deuda = JSON.stringify( json_codigoPagos_envioContifico[ indice ] );
            var apikey =document.getElementById('apikey').value;
            var xhrr = new XMLHttpRequest();
            xhrr.open('PUT', url , true);
            xhrr.setRequestHeader('Authorization', apikey);
            xhrr.setRequestHeader('Content-type','application/json; charset=utf-8');
            xhrr.onreadystatechange=function()
            {   if ( xhrr.readyState === 4 )
                {   fact_enviadas = fact_enviadas + 1;
                    if ( indice > 0 )
                    {   var progressBar = $('#pb_envio_por_lote'), width = per_complete-per_complete_first-1;
                        contabilidad_interval_carga_progress_bar_CONTIFICO = setInterval(function()
                        {   width += 1;
                            progressBar.css('width', width + '%');
                            if (document.getElementById('div_text_per_complete'))
                                document.getElementById('div_text_per_complete').innerHTML = width;
                            if ( ( width >= ( per_complete - 1 )) && ((document.getElementById('pb_envio_por_lote'))) )
                            {   clearInterval(contabilidad_interval_carga_progress_bar_CONTIFICO);
                            }
                        }, Math.round( request_time / (per_complete_first-1) ) );
                    }
                    document.getElementById(div).innerHTML=
                    '<div class="modal-body" id="modal_actualizar_body">'+
                        '<br>'+ 
                        '<div align="center" style="height:50%;">'+
                            '<i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i>'+
                            '<br>'+
                            '<span style="font-size:small;">Actualización de DNA\s a Factura... <span id="div_text_per_complete" name="div_text_per_complete">' + (per_complete) + '</span>% completado</span>'+
                            '<br>'+
                            '<br>'+
                            '<a tabindex="0" class="btn btn-default btn-xs" onclick="js_contabilidad_detener_envio_CONTIFICO( );" data-toggle="tooltip" title="Detener" data-placement="top"><span class="fa fa-stop"></span></a>'+
                            '<a tabindex="0" class="btn btn-default btn-xs" onclick="js_contabilidad_pausar_envio_CONTIFICO( );" data-toggle="tooltip" title="Pausar" data-placement="right"><span class="fa fa-pause"></span></a>'+
                            '<div class="progress progress-striped">'+
                                '<div id="pb_envio_por_lote" name="pb_envio_por_lote" class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:' + (per_complete) + '%;position:relative;">'+
                                '</div>'+
                            '</div>'+
                        '</div>'+
                        '<span style="font-size:xx-small;" align="left">Actualizando registros de facturas en Contífico.</span><br>'+
                        '<span style="font-size:xx-small;" align="left">' + ( indice + 1 ) + ' Deudas de ' + obj_len + '.</span>'+
                        '<br>'+
                        '<br>'+
                        '<span id="sms_estado_envio" name="sms_estado_envio" style="font-size:x-small;">Enviando...</span>'+
                    '</div>';
                    /*'<div class="modal-footer" id="footeractualizar">'+
                        '<button type="button" class="btn btn-default" data-dismiss="modal">Ocultar</button>'+
                    '</div>';*/
                    if ( xhrr.readyState === 4 && xhrr.status === 200 )
                    {   var mensaje = JSON.parse(xhrr.responseText);
                        if(mensaje.tipo_documento!='DNA')
                        {   var data = new FormData();
                            fact_procesadas=fact_procesadas+1;
                            var valores = JSON.parse(xhrr.responseText); 
                            data.append('event', 'updfacturas');
                            data.append('codigo_documento', valores[ 'descripcion' ] ); //valores.descripcion
                            var xhrII = new XMLHttpRequest();
                            xhrII.open('POST', url2 , true);
                            xhrII.onreadystatechange=function()
                            {   if (xhrII.readyState === 4 && xhrII.status === 200)
                                {   js_contabilidad_senddeudaact( url2, div, indice + 1, obj_len, cc, ce, cd, new Date().getTime(), request_time, per_complete_first );
                                }
                            };
                            xhrII.send(data);
                        }
                        correctas=correctas+1;
                    }
                    else 
                    {   if( xhrr.readyState === 4 && xhrr.status === 401)
                        {   error=error+1;
                        }
                        if ( xhrr.readyState === 4 && xhrr.status === 409)
                        {   repetidas=repetidas+1;
                        }
                        if( xhrr.readyState === 4 && xhrr.status === 500)
                        {   error=error+1;
                        }
                        if( xhrr.readyState === 4 && xhrr.status === 400)
                        {   errorfactura=errorfactura+1;
                        }
                        js_contabilidad_senddeudaact( url2, div, indice + 1, obj_len, cc, ce, cd, new Date().getTime(), request_time, per_complete_first );
                    }
                }
            };
            xhrr.send(deuda);
        }
        if( proceso_corriendo === 2 )
        {   document.getElementById(div).innerHTML=
                '<div class="modal-body" id="modal_actualizar_body">'+
                    '<br>'+ 
                    '<div align="center">'+
                        '<i style="font-size:large;color:darkred;" class="fa fa-cog"></i>'+
                        '<br>'+ 
                        '<span style="font-size:small;">Actualización de DNA\s a Factura... <span id="div_text_per_complete" name="div_text_per_complete">' + (per_complete - per_complete_first - 1) + '</span>% completado</span>'+
                        '<br>'+ 
                        '<br>'+ 
                        '<a tabindex="0" class="btn btn-default btn-xs" onclick="js_contabilidad_detener_envio_CONTIFICO( );js_contabilidad_senddeudaact   ( \''+url2+'\',\''+ div+'\','+ indice+','+ obj_len+','+ cc+','+ ce+','+ cd+','+ new Date().getTime()+','+ request_time+','+ per_complete_first+');" data-toggle="tooltip" title="Detener" data-placement="top"><span class="fa fa-stop"></span></a>'+
                        '<a tabindex="0" class="btn btn-default btn-xs" onclick="js_contabilidad_continuar_envio_CONTIFICO( );js_contabilidad_senddeudaact ( \''+url2+'\',\''+ div+'\','+ indice+','+ obj_len+','+ cc+','+ ce+','+ cd+',0,'+ request_time+','+ per_complete_first+');" data-toggle="tooltip" title="Continuar" data-placement="right"><span class="fa fa-play"></span></a>'+
                        '<div class="progress progress-striped">'+
                            '<div id="pb_envio_por_lote" name="pb_envio_por_lote" class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:' + (per_complete - per_complete_first - 1) + '%;position:relative;">'+
                                '<!--<span id="span_envio_por_lote" name="span_envio_por_lote" style="position: absolute;display: block;width: 100%;color: white;">' + (per_complete - per_complete_first - 1) + '% Completado</span>-->'+
                            '</div>'+
                        '</div>'+
                    '</div>'+
                    '<span style="font-size:xx-small;" align="left">Enviando registro de deudas a Contífico.</span><br>'+
                    '<span style="font-size:xx-small;" align="left">' + ( indice ) + ' Deudas de ' + obj_len + '.</span>'+
                    '<br>'+ 
                    '<br>'+ 
                    '<span id="sms_estado_envio" name="sms_estado_envio" style="font-size:x-small;">Pausado</span>'+
                '</div>';
                /*'<div class="modal-footer" id="footeractualizar">'+
                    '<button type="button" class="btn btn-default" data-dismiss="modal">Ocultar</button>'+
                '</div>';*/
        }
    }
}
function js_contabilidad_detener_envio_CONTIFICO( )
{   proceso_corriendo = 0;
    document.getElementById( 'sms_estado_envio' ).innerHTML = "<span>Deteniendo envío...</span> los registros que ya fueron procesadas ya tienen una respuesta del sistema del Contífico.";
}
function js_contabilidad_pausar_envio_CONTIFICO( )
{   proceso_corriendo = 2;
    document.getElementById( 'sms_estado_envio' ).innerHTML = "<span>Pausando envío...</span>";
}
function js_contabilidad_continuar_envio_CONTIFICO( )
{   proceso_corriendo = 1;
}
function js_contabilidad_resultadofinalact( url, cc, ce, cd, indice, obj_len )
{   document.getElementById('modal_actualizar_body').innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div><br>Por favor, espere...<br>';
    var data = new FormData();
    data.append('event', 'resultadoact');
    data.append('contadorcorrectos', cc);    
    data.append('contadorerror', ce);    
    data.append('contadorerrfact', cd);
    var xhrII = new XMLHttpRequest();
    xhrII.open('POST', url , true);
    xhrII.onreadystatechange=function()
    {   if (xhrII.readyState === 4 && xhrII.status === 200)
        {   document.getElementById('modal_actualizar_body').innerHTML = xhrII.responseText;
            if (!Notification)
            {   alert('Las notificaciones de escritorio no están disponibles en su explorador. Por favor utilzia Chrome.'); 
                return;
            }
            if (Notification.permission !== "granted")
                Notification.requestPermission();
            else
            {   if ( proceso_corriendo === 1 )
                {   var sms_notify = "";
                    if (obj_len > 1)
                        sms_notify = "¡Actualización de " + ( indice ) + " DNA's a Factura completado!"
                    else
                        sms_notify = "¡Actualización de DNA's a Factura completado!"
                    
                    var notification = new Notification('Educalinks', {
                        icon: document.getElementById('ruta_imagenes_common').value + "/favicon.png",
                        body: sms_notify,
                    });
                    var ruta_notify = document.getElementById('ruta_html_finan') + "/../../../finan/gestionContifico/";
                    notification.onclick = function ()
                    {   window.open( ruta_notify );
                    };
                }
            }
            proceso_corriendo = 0;
        } 
    };
    xhrII.send(data);
}
function js_contabilidad_senddeudaindividualact( id, div, div2, url2, mes )
{   var deuda=document.getElementById('jsondeudas').innerHTML;
	document.getElementById( 'span_upddeudaindividual_result_button' ).innerHTML = '';
    document.getElementById(div).innerHTML='<br><div align="center"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i><br>Por favor, espere...</div><br>';
    var url='https://www.contifico.com/sistema/api/v1/documento/';
    var apikey =document.getElementById('apikey').value;
    var xhrr = new XMLHttpRequest();
    xhrr.open('PUT', url , true);
    xhrr.setRequestHeader('Authorization', apikey);
    xhrr.setRequestHeader('Content-type','application/json; charset=utf-8');
    xhrr.onreadystatechange=function()
    {   if (xhrr.readyState === 4 && xhrr.status === 200 )
        {   //alert('El documento se creo correctamente');
			document.getElementById(div).innerHTML = 
                "<div class='callout callout-info'><h4><span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span>&nbsp;Contífico:</h4>" + 
                "El documento se creo correctamente</div>";
			var mensaje = JSON.parse( xhrr.responseText );
			if( mensaje.tipo_documento != 'DNA' )
			{   var data = new FormData();
				data.append( 'event', 'updfacturas' );
				data.append( 'codigo_documento', id ); //valores.descripcion
				var xhrII = new XMLHttpRequest();
				xhrII.open('POST', url2 , true);
				xhrII.onreadystatechange = function()
				{   if (xhrII.readyState === 4 && xhrII.status === 200)
					{   js_contabilidad_actualizar_DNAs( mes, div2, url2 );
					}
				};
				xhrII.send( data );
			}
        }
		else if (xhrr.readyState === 4 && xhrr.status === 401 )
        {   //alert('Error al validar credenciales');
			document.getElementById(div).innerHTML = 
                "<div class='callout callout-info'><h4><span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span>&nbsp;Contífico:</h4>" + 
                "Error al validar credenciales</div>";
            js_contabilidad_actualizar_DNAs( mes, div2, url2 );
        }else if (xhrr.readyState === 4 && xhrr.status === 409 )
        {   //alert('El documento ya existe');
			document.getElementById(div).innerHTML = 
                "<div class='callout callout-info'><h4><span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span>&nbsp;Contífico:</h4>" + 
                "El documento ya existe</div>";
            js_contabilidad_actualizar_DNAs( mes, div2, url2 );
        }
        else if( xhrr.readyState === 4 && xhrr.status === 500 )
        {   //alert('Error en el sistema');
			document.getElementById(div).innerHTML = 
                "<div class='callout callout-info'><h4><span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span>&nbsp;Contífico:</h4>" + 
                "Error en el sistema</div>";
			js_contabilidad_actualizar_DNAs( mes, div2, url2 );
        }
		else if( xhrr.readyState === 4 && xhrr.status === 400 )
        {   var mensaje = JSON.parse( xhrr.responseText );
			document.getElementById(div).innerHTML = 
                "<div class='callout callout-danger'><h4><span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span>&nbsp;Contífico:</h4>" + 
                "<b>Error en el documento</b>: "+mensaje.mensaje+"</div>";
			js_contabilidad_actualizar_DNAs( mes, div2, url2 );
        }
    };
    xhrr.send(deuda);
}
function js_contabilidad_senddeudaindividual( id, div, div2, url2, mes )
{   var mensaje = "";
    var responseJSON = JSON.parse("[]");
    var deuda = document.getElementById('jsondeudas').innerHTML;
    document.getElementById( 'span_sendpagoindividual_result_button' ).innerHTML = '';
    var deudaid = document.getElementById('idcontifico').innerHTML;
    document.getElementById(div).innerHTML='<br><div align="center"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i><br>Por favor, espere...</div><br>';
    //var data = new FormData();
    var url = 'https://contifico.com/sistema/api/v1/documento/'+deudaid.trim()+'/cobro/';
    var apikey = document.getElementById('apikey').value;
    var xhrr = new XMLHttpRequest();
    xhrr.open('POST', url , true);
    
    xhrr.setRequestHeader('Authorization', apikey);
    xhrr.setRequestHeader('Content-type','application/json; charset=utf-8');
    xhrr.onreadystatechange=function()
    {   if ( xhrr.readyState === 4 && xhrr.responseText.length > 0 )
        {   responseJSON = JSON.parse(xhrr.responseText);
            document.getElementById(div).innerHTML = 
                "<div class='callout callout-info'><h4><span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span>&nbsp;Contífico:</h4>" + 
                responseJSON.mensaje + "</div>";
        }
        if( xhrr.readyState === 4 && xhrr.status === 401)
        {   js_contabilidad_migrar(mes,div2,url2);
        }
        if( xhrr.readyState === 4 && xhrr.status === 201)
        {   document.getElementById(div).innerHTML = 
                "<div class='callout callout-info'><h4><span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span>&nbsp;Contífico:</h4>" + 
                    "El documento se creó correctamente.</div>";
            js_contabilidad_upddocumentoindividual(deudaid.trim(),url2,id,div2,'MI',0);
            js_contabilidad_migrar(mes,div2,url2);
        }
        else if ( xhrr.readyState === 4 && xhrr.status === 409)
        {   //alert('El documento ya existe');
            js_contabilidad_migrar(mes,div2,url2);
        }
        else if( xhrr.readyState === 4 && xhrr.status === 500)
        {   //alert('Error en el sistema');
            js_contabilidad_upddocumentoindividual(deudaid.trim(),url2,id,div2,'ER',0);
            js_contabilidad_migrar(mes,div2,url2);
        }
        else if( xhrr.readyState === 4 && xhrr.status === 400)
        {   if( xhrr.responseText.length > 0 )
            {   if(responseJSON.mensaje=='El documento no tiene saldo pendiente')
                {   js_contabilidad_upddocumentoindividual(deudaid.trim(),url2,id,div2,'MI',0);
                }        
                else
                {   js_contabilidad_upddocumentoindividual(deudaid.trim(),url2,id,div2,'DE',0);    
                }
            }
            //alert('Error en el documento');
            js_contabilidad_migrar(mes,div2,url2);
        }
    };
    xhrr.send(deuda);
}
function js_contabilidad_carga_deudas( codigo, div, url )
{   document.getElementById(div).innerHTML='<br><div align="center"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i><br>Por favor, espere...</div><br>';
    console.log( codigo );
    var data = new FormData();
    data.append('event', 'migrar');
    data.append('mes', codigo);
    var xhr = new XMLHttpRequest();
    xhr.open('POST', url , true);
    xhr.onreadystatechange=function()
    {   if (xhr.readyState === 4 && xhr.status === 200)
        {   document.getElementById(div).innerHTML=xhr.responseText;
            $('#tablapagomigrar').DataTable({
                //"iDisplayLength": -1,
                "bPaginate": true,
                "bStateSave": false,
                "bAutoWidth": false,
                //true
                "bScrollAutoCss": true,
                "bProcessing": true,
                "bRetrieve": true,
                //"bJQueryUI": true,
                //"sDom": 't',
                "sDom": '<"H"CTrf>t<"F"lip>',
                "aLengthMenu": [[10,25, 50, 100, -1], [10,25, 50, 100, "Todos"]],
                "sScrollXInner": "110%",
                "fnInitComplete": function() {
                    this.css("visibility", "visible");
                },
                paging: true,
                lengthChange: true,
                searching: true,
                language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'}
            });
        } 
    };
    xhr.send(data);
}
function js_contabilidad_upddocumentoindividual( codigo_contifico, url, codigo, div, estado, cantidad )
{   document.getElementById(div).innerHTML='<br><div align="center"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i><br>Por favor, espere...</div><br>';
    var data = new FormData();
    fact_procesadas=fact_procesadas+1;
    var contificoid=0;
    data.append('event', 'upddeuda');
    data.append('codigo_documento', codigo);
    if(estado=='MI')
    {   data.append('doccontifico_codigo', codigo_contifico);
    }
    else    
    {   data.append('doccontifico_codigo', contificoid);    
    }
    data.append('estado', estado);
    var xhr = new XMLHttpRequest();
    xhr.open('POST', url , true);
    xhr.onreadystatechange=function()
    {   if (xhr.readyState === 4 && xhr.status === 200)
        {   js_contabilidad_buscapagos('resultadomigracion_pagos',url);
        } 
    };
    xhr.send(data);
}
function guardarcontificoproducto(codigo,div,url)
{   if(confirm("¿Está seguro que desea guardar la información?"))
    {   document.getElementById(div).innerHTML='<br><div align="center"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i><br>Por favor, espere...</div><br>';
        var e = document.getElementById("productos");
        var strUser = e.options[e.selectedIndex].value;
        var data = new FormData();
        data.append('event', 'updproductos');
        data.append('prodcontifico_codigo', strUser);
        data.append('codigo_productos', codigo);
        var xhr = new XMLHttpRequest();
        xhr.open('POST', url , true);
        xhr.onreadystatechange=function()
        {   if (xhr.readyState === 4 && xhr.status === 200)
            {   buscaproducto("",div,url);
            } 
        };
        xhr.send(data);
    }
}
function js_contabilidad_buscapagos(div,url)
{   document.getElementById(div).innerHTML='<br><div align="center"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i><br>Por favor, espere...</div><br>';
   var data = new FormData();
    data.append('event', 'get_all_deuda');
    data.append('anio', $("#cmb_periodo_anual_pagos option:selected").text());    
    var xhr = new XMLHttpRequest();
    xhr.open('POST', url , true);
    xhr.onreadystatechange=function()
    {   if (xhr.readyState === 4 && xhr.status === 200)
        {   document.getElementById(div).innerHTML=xhr.responseText;
                $('#tablapagos').addClass( 'nowrap' ).DataTable({
                lengthChange: false, 
                responsive: true, 
                searching: true,  
                orderClasses: true, 
                paging:true,
                bInfo:false,
                language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'},
                "columnDefs": [
                    {className: "dt-body-center" , "targets": [0]},
                    {className: "dt-body-left"   , "targets": [1]},
                    {className: "dt-body-left"   , "targets": [2]},
                    {className: "dt-body-center"   , "targets": [3]},
                    {className: "dt-body-center" , "targets": [4]}
                ]
            });
            var table = $('#tablapagos').DataTable();
            table.column( '0:visible' ).order( 'asc' );
            $('#modal_deudas').modal('hide');
        } 
    };
    xhr.send(data);
}
function js_contabilidad_buscaDNAsPagados( div, url ) //'resultadomigracion_paidDNAs'
{   document.getElementById( div ).innerHTML='<br><div align="center"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i><br>Por favor, espere...</div><br>';
    var anio = $("#cmb_periodo_anual_update option:selected").text();
    var data = new FormData();
    data.append( 'event', 'get_all_paidDNAs' );
    data.append( 'anio', anio );
    var xhr = new XMLHttpRequest();
    xhr.open('POST', url, true);
    xhr.onreadystatechange = function()
    {   if ( xhr.readyState === 4 && xhr.status === 200 )
        {   document.getElementById(div).innerHTML=xhr.responseText;
            $('#tabla_paidDNAs_main').DataTable({
                "bPaginate": true,
                "bStateSave": false,
                "bAutoWidth": false,
                "bScrollAutoCss": true,
                "bProcessing": true,
                "bRetrieve": true,
                "sDom": '<"H"CTrf>t<"F"lip>',
                "aLengthMenu": [[10,25, 50, 100, -1], [10,25, 50, 100, "Todos"]],
                "sScrollXInner": "110%",
                "fnInitComplete": function() {
                    this.css("visibility", "visible");
                },
                paging: true,
                lengthChange: true,
                searching: true,
                language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'},
                "columnDefs": [
                    {className: "dt-body-center", "targets": [0]},
                    {className: "dt-body-center", "targets": [1]},
                    {className: "dt-body-right" , "targets": [2]},
                    {className: "dt-body-right" , "targets": [3]},
                    {className: "dt-body-center", "targets": [4]}
                ]
            });
        }
    };
    xhr.send(data);
}
function js_contabilidad_migrar(codigo,div,url)
{   if ( proceso_corriendo === 0 )
    {   document.getElementById('span_boton_headerpagos').innerHTML = '';
        document.getElementById('footerpagos').innerHTML =
                '<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button></div>';
        document.getElementById(div).innerHTML='<br><div align="center"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i><br>Por favor, espere...</div><br>';
        var data = new FormData();
        data.append('event', 'migrar');
        data.append('mes', codigo);    
        data.append('anio', $("#cmb_periodo_anual_pagos option:selected").text());        
        var xhr = new XMLHttpRequest();
        xhr.open('POST', url , true);
        xhr.onreadystatechange=function(){
            if (xhr.readyState === 4 && xhr.status === 200)
            {   document.getElementById(div).innerHTML=xhr.responseText;
                $('#tablapagomigrar').DataTable({
                    "bPaginate": true,
                    "bStateSave": false,
                    "bAutoWidth": false,
                    "bScrollAutoCss": true,
                    "bProcessing": true,
                    "bRetrieve": true,
                    "sDom": '<"H"CTrf>t<"F"lip>',
                    "aLengthMenu": [[10,25, 50, 100, -1], [10,25, 50, 100, "Todos"]],
                    "sScrollXInner": "110%",
                    "fnInitComplete": function() {
                        this.css("visibility", "visible");
                    },
                    paging: true,
                    lengthChange: true,
                    searching: true,
                    language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'}
                });
            } 
        };
        xhr.send(data);
    }
    else
    {   $.growl({ title: "Educalinks informa",message: "Hay un envío de información a Contífico en proceso." });
    }
}
function categorias(codigo,div,url)
{   document.getElementById(div).innerHTML='<br><div align="center"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i><br>Por favor, espere...</div><br>';
    var data = new FormData();
    data.append('event', 'categorias');
    data.append('categoriacodigo', codigo);    
    var xhr = new XMLHttpRequest();
    xhr.open('POST', url , true);
    xhr.onreadystatechange=function(){
        if (xhr.readyState === 4 && xhr.status === 200)
        {   getcategorias(div,url,codigo);
        } 
    };
    xhr.send(data);
}
function productos(codigo,div,url)
{   document.getElementById(div).innerHTML='<br><div align="center"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i><br>Por favor, espere...</div><br>';
    var data = new FormData();
    data.append('event', 'productos');
    data.append('productocodigo', codigo);    
    var xhr = new XMLHttpRequest();
    xhr.open('POST', url , true);
    xhr.onreadystatechange=function(){
        if (xhr.readyState === 4 && xhr.status === 200)
        {   getproducto(div,url,codigo);
        } 
    };
    xhr.send(data);
}
function getproducto(div,url2,codigo)
{   document.getElementById(div).innerHTML='<br><div align="center"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i><br>Por favor, espere...</div><br>';
    var url='https://www.contifico.com/sistema/api/v1/producto/';
    var data = new FormData();
    var apikey = document.getElementById('apikey').value;
    var xhr = new XMLHttpRequest();
    xhr.open('GET', url , true);
    xhr.setRequestHeader('Authorization', apikey);
    xhr.onreadystatechange=function()
    {   if (xhr.readyState === 4 && xhr.status === 200)
        {   comboproductos(div,xhr.responseText,url2,codigo);
        } 
    };
    xhr.send(data);
}
function getcategorias(div,url2,codigo)
{   document.getElementById(div).innerHTML='<br><div align="center"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i><br>Por favor, espere...</div><br>';
    var url='https://www.contifico.com/sistema/api/v1/categoria/';
    var data = new FormData();
    var apikey =document.getElementById('apikey').value;
    var xhr = new XMLHttpRequest();
    xhr.open('GET', url , true);
    xhr.setRequestHeader('Authorization', apikey);
    xhr.onreadystatechange=function()
    {   if (xhr.readyState === 4 && xhr.status === 200)
        {   combocategorias(div,xhr.responseText,url2,codigo);
        } 
    };
    xhr.send(data);
}
function combocategorias(div,categorias,url,codigo)
{   document.getElementById(div).innerHTML='<br><div align="center"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i><br>Por favor, espere...</div><br>';
    var data = new FormData();
    data.append('event', 'combocategorias');
    data.append('categorias', categorias);    
    data.append('codigocategoria', codigo);    
    var xhr = new XMLHttpRequest();
    xhr.open('POST', url , true);
    xhr.onreadystatechange=function()
    {   if (xhr.readyState === 4 && xhr.status === 200)
        {   document.getElementById(div).innerHTML=xhr.responseText;
        } 
    };
    xhr.send(data);
}
function comboproductos(div,productos,url,codigo)
{   document.getElementById(div).innerHTML='<br><div align="center"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i><br>Por favor, espere...</div><br>';
    var data = new FormData();
    data.append('event', 'comboproductos');
    data.append('productos', productos);    
    data.append('codigoproducto', codigo);    
    var xhr = new XMLHttpRequest();
    xhr.open('POST', url , true);
    xhr.onreadystatechange=function()
    {   if (xhr.readyState === 4 && xhr.status === 200)
        {   document.getElementById(div).innerHTML=xhr.responseText;
        }
    };
    xhr.send(data);
}
function  migrar_caja(div,url)
{   var datacaja=document.getElementById('jsoncaja').innerHTML;
    document.getElementById(div).innerHTML='<br><div align="center"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i><br>Por favor, espere...</div><br>';
    var data = new FormData();
    data.append('Caja', datacaja);    
    var xhr = new XMLHttpRequest();
    xhr.open('POST', url , true);
    xhr.onreadystatechange=function()
    {   if (xhr.readyState === 4 && xhr.status === 200)
        {   document.getElementById(div).innerHTML=xhr.responseText;
            alert(xhr.responseText);
        } 
    };
    xhr.send(data);
}
function addproductos(codigo,div,url)
{   document.getElementById(div).innerHTML='<br><div align="center"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i><br>Por favor, espere...</div><br>';
    var data = new FormData();
    data.append('event', 'add');
    data.append('prod_codigo', codigo);

    var xhr = new XMLHttpRequest();
    xhr.open('POST', url , true);
    xhr.onreadystatechange=function()
    {   if (xhr.readyState === 4 && xhr.status === 200)
        {   guardarproductos(xhr.responseText,codigo,url,div);
        }
    };
    xhr.send(data);
}
function guardarproductos(productos,codigo,url2,div)
{   if(confirm("¿Está seguro que desea guardar la información?"))
    {   var url='https://www.contifico.com/sistema/api/v1/producto/';
        var data = new FormData();
        var apikey =document.getElementById('apikey').value;
        data.append('Producto',productos);    
        var xhr = new XMLHttpRequest();
        xhr.open('POST', url , true);
        xhr.setRequestHeader('Authorization', apikey);
        xhr.setRequestHeader('Content-type','application/json; charset=utf-8');
        xhr.onreadystatechange=function()
        {   if ( xhr.readyState === 4 && xhr.status === 201)
            {   saveproductos(xhr.responseText,url2,codigo,div);
            } 
            else if ( xhr.readyState === 4 && xhr.status === 409)
            {   alert('El producto ya existe');
            }
        };
        xhr.send(productos);
    }
}
function saveproductos(codigo_contifico,url,codigo,div)
{   document.getElementById(div).innerHTML='<br><div align="center"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i><br>Por favor, espere...</div><br>';
    var data = new FormData();
    data.append('event', 'setproductos');
    data.append('codigo_productos', codigo);
    data.append('prodcontifico_codigo', codigo_contifico);
    var xhr = new XMLHttpRequest();
    xhr.open('POST', url , true);
    xhr.onreadystatechange=function()
    {   if (xhr.readyState === 4 && xhr.status === 200)
        {   buscaproducto("",'resultadoproductos',url);
        } 
    };
    xhr.send(data);
}
function save_edited(rol_codigo,div,url)
{   if(confirm("¿Está seguro que desea editar la información del banco?"))
    {   document.getElementById(div).innerHTML='<br><div align="center"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i><br>Por favor, espere...</div><br>';
        var data = new FormData();
        data.append('event', 'edit');
        data.append('banc_codigo', document.getElementById('banc_codigo').value);
        data.append('banc_nombre', document.getElementById('banc_nombre').value);
        
        var xhr = new XMLHttpRequest();
        xhr.open('POST', url , true);
        xhr.onreadystatechange=function()
        {   if (xhr.readyState === 4 && xhr.status === 200)
            {   busca("",div,url);
            } 
        };
        xhr.send(data);
    }
}
