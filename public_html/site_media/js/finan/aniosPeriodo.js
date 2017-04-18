// JavaScript Document
$(document).ready(function(){
    $('.disabled_a').click(function(e){
        e.preventDefault();
    });
    $('#anioPeriodo_table').addClass( 'nowrap' ).DataTable({
        lengthChange: true,
        responsive: true,
        searching: true,
        orderClasses: true,
        paging: true,
        language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'},
        "columnDefs": [
            {"title": "<span style='color:black;font-size:small;'>ref.</span>", className: "dt-body-center", "targets": [0]},
            {"title": "<span style='color:black;font-size:small;'>Producto</span>", className: "dt-body-center" , "targets": [1]},
            {"title": "<span style='color:black;font-size:small;'>Inicio cobro</span>", className: "dt-body-center" , "targets": [2]},
            {"title": "<span style='color:black;font-size:small;'>Fin cobro</span>", className: "dt-body-center" , "targets": [3]},
            {"title": "<span style='color:black;font-size:small;'>Prontopago</span>", className: "dt-body-center" , "targets": [4]},
            {"title": "<span style='color:black;font-size:small;'>Opciones</span>", className: "dt-body-center" , "targets": [5]},
            {className: "dt-head-center" , "targets": [0]},
            {className: "dt-head-left"   , "targets": [1]},
            {className: "dt-head-center" , "targets": [2]},
            {className: "dt-head-center" , "targets": [3]},
            {className: "dt-head-center" , "targets": [4]},
            {className: "dt-head-center" , "targets": [5]}
        ]
    });
    $('#tabladeuda').DataTable({
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
            {className: "dt-body-center" , "targets": [4]}
        ]
    });
    $('#modal_add').on('shown.bs.modal', function () {
       $("#fechaInicio_add").datepicker();
       $("#fechaFin_add").datepicker();
       //$("#diasProntopago_add").numeric({ decimal : ".",  negative : false, scale: 2 });
       $("#diasProntopago_add").numeric({ decimal : false,  negative : false, precision: 3 });
       //$('#diasProntopago_add').jStepper({minValue:0, maxValue:10, minLength:2, maxDecimals:2});
       $("#fechaInicio_add").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
       $("#fechaFin_add").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
    });
    $('#modal_edit_item').on('shown.bs.modal', function () {
        if( document.getElementById("diasProntopago_mod") )
        {   $("#diasProntopago_mod").numeric({ decimal : false,  negative : false, precision: 3 });
        }
        if( document.getElementById("fechaInicio_mod") )
        {   $("#fechaInicio_mod").datepicker();
            $("#fechaFin_mod").datepicker();
            $("#fechaInicio_mod").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
            $("#fechaFin_mod").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        }
    });
    $('#modal_deudas').on('hidden.bs.modal', function (e) {
        js_aniosPeriodo_buscadeudas('resultadomigracion_deudas', document.getElementById('ruta_html_finan').value + '/aniosPeriodo/controller.php' );
        js_contabilidad_buscapagos('resultadomigracion_pagos', document.getElementById('ruta_html_finan').value + '/contabilidad/controller.php' ); //función se encuentra en contabilidad.js
    });
    $('#modal_edit').on('hidden.bs.modal', function (e) {
        js_contabilidad_buscapagos('resultadomigracion_pagos', document.getElementById('ruta_html_finan').value + '/contabilidad/controller.php' ); //función se encuentra en contabilidad.js
        js_contabilidad_buscaDNAsPagados('resultadomigracion_paidDNAs', document.getElementById('ruta_html_finan').value + '/contabilidad/controller.php' ); //función se encuentra en contabilidad.js
    });
    $('#modal_actualizar').on('hidden.bs.modal', function (e) {
        js_contabilidad_buscaDNAsPagados('resultadomigracion_paidDNAs', document.getElementById('ruta_html_finan').value + '/contabilidad/controller.php' ); //función se encuentra en contabilidad.js
    });
});
var fact_enviadas = 0;
var fact_procesadas = 0;
var correctas = 0;
var error = 0;
var errorfactura = 0;
var repetidas = 0;
var json_codigoDeudas_envioContifico = JSON.parse("[]");
var proceso_corriendo = 0;
var aniosPeriodo_interval_carga_progress_bar_CONTIFICO = setInterval(function()
{   if ( 0 === 0 )
    {   clearInterval(aniosPeriodo_interval_carga_progress_bar_CONTIFICO);
    }
}, Math.round( 100 ) );
function aumenta_10(div)
{   var val_now= parseInt(document.getElementById(div).getAttribute('aria-valuenow'))+10;
    if(val_now <= 100)
    {   document.getElementById(div).setAttribute('aria-valuenow',val_now);
        document.getElementById(div).style.width = String(val_now) + '%';
        if(val_now<100)
        {   document.getElementById(div).innerHTML=String(val_now) + '%';
            document.getElementById('prog_bar_deudas').setAttribute('class','progress-bar progress-bar-striped active');
        }
        else
        {   document.getElementById(div).innerHTML='Completado';
            document.getElementById('prog_bar_deudas').setAttribute('class','progress-bar progress-bar-striped');
        }
    }
}
// Carga el combo de los productos
function cargaProductos(div, url){
    document.getElementById(div).innerHTML='<br><div align="center"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i><br>Por favor, espere...</div><br>';
    var comboCategoria = document.getElementById("codigoCategoria_add");
    var data = new FormData();
    data.append('categoria', comboCategoria.options[comboCategoria.selectedIndex].value);
    data.append('event', 'get_producto');
    var xhr = new XMLHttpRequest();
    xhr.open('POST', url, true);
    xhr.onreadystatechange = function(){
        if ( xhr.readyState === 4 && xhr.status === 200 ){
            document.getElementById(div).innerHTML=xhr.responseText;
        }
    };
    xhr.send(data);
}
// Carga el formulario para ingresar un nuevo registro
function js_aniosPeriodo_carga_add( div, url )
{   document.getElementById(div).innerHTML='<br><div align="center"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i><br>Por favor, espere...</div><br>';
    var data = new FormData();
    data.append('event', 'agregar');
    var xhr = new XMLHttpRequest();
    xhr.open('POST', url, true);
    xhr.onreadystatechange = function()
    {   if ( xhr.readyState === 4 && xhr.status === 200 )
        {   document.getElementById(div).innerHTML=xhr.responseText;
        }
    };
    xhr.send(data);
}
function js_aniosPeriodo_carga_deudas( codigo, div, url )
{   if ( proceso_corriendo === 0 )
    {   document.getElementById(div).innerHTML='<br><div align="center"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i><br>Por favor, espere...</div><br>';
        document.getElementById('span_boton_headerdeudas').innerHTML = '';
        document.getElementById('footerdeudas').innerHTML =
                '<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button></div>';
        var data = new FormData();
        data.append('event', 'deuda');
        data.append('mes', codigo);
        data.append('anio', $("#cmb_periodo_anual_deudas option:selected").text());
        var xhr = new XMLHttpRequest();
        xhr.open('POST', url, true);
        xhr.onreadystatechange = function()
        {   if ( xhr.readyState === 4 && xhr.status === 200 )
            {   document.getElementById(div).innerHTML=xhr.responseText;
                $('#tabladeudamigrar').addClass( 'nowrap' ).DataTable({
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
function js_aniosPeriodo_carga_deudasfechas(div, url){
    document.getElementById(div).innerHTML='<br><div align="center"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i><br>Por favor, espere...</div><br>';
    var data = new FormData();
    data.append('event', 'deuda');
    data.append('mes', codigo);//DE DONDE SACA "CODIGO"
    var xhr = new XMLHttpRequest();
    xhr.open('POST', url, true);
    xhr.onreadystatechange = function()
    {   if ( xhr.readyState === 4 && xhr.status === 200 )
        {   document.getElementById(div).innerHTML=xhr.responseText;
            $('#tabladeudamigrar').addClass('nowrap').DataTable({
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
                    {className: "dt-body-center" , "targets": [0]},
                    {className: "dt-body-left"     , "targets": [1]},
                    {className: "dt-body-center" , "targets": [2]},
                    {className: "dt-body-right"  , "targets": [3]},
                    {className: "dt-body-center" , "targets": [4]},
                    {className: "dt-body-center" , "targets": [5]}
                ]
            });
        }
    };
    xhr.send(data);
}
function js_aniosPeriodo_migrarfacturas( div, url )
{   if ( document.getElementById( 'codigomes_deudas' ) )
    {   var codigo = document.getElementById('codigomes_deudas').value;
        document.getElementById(div).innerHTML='<br><div align="center"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i><br>Por favor, espere...</div><br>';
        var data = new FormData();
        data.append('event', 'migrarfacturas');
        data.append('mes', codigo);
        data.append('anio', $("#cmb_periodo_anual_deudas option:selected").text());
        var xhr = new XMLHttpRequest();
        xhr.open('POST', url, true);
        xhr.onreadystatechange = function()
        {   if ( xhr.readyState === 4 && xhr.status === 200 )
            {   document.getElementById(div).innerHTML=xhr.responseText;
                document.getElementById('footerdeudas').innerHTML=
                '<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button></div>'+
                '<button type="button" class="btn btn-primary" id="btn_migrardeudascontifico" name="btn_migrardeudascontifico" '+
                'onclick="js_aniosPeriodo_migrarfacturascontificos(\'' + url + '\',\'modal_deudas_body\',0,0,0,0)">'+
                '<span class="glyphicon glyphicon glyphicon-send"></span>&nbsp;Migrar</button>';
                document.getElementById('span_boton_headerdeudas').innerHTML=
                '<button type="button" class="btn btn-warning" '+
                'onclick=\'js_aniosPeriodo_carga_deudas("'+ codigo +'","modal_deudas_body","' + document.getElementById('ruta_html_finan').value + '/aniosPeriodo/controller.php")\'>'+
                '<span class="fa fa-angle-left"></span>&nbsp;Volver</button>';
            }
        };
        xhr.send(data);
    }
}
function js_aniosPeriodo_migrarfacturasindividuales( codigo, div, url )
{   document.getElementById( div ).innerHTML='<br><div align="center"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i><br>Por favor, espere...</div><br>';
    document.getElementById( 'span_senddeudaindividual_result_button' ).innerHTML = 
                '<button type="button" class="btn btn-primary" id="btn_senddeudaindividual" name="btn_senddeudaindividual" ' +
                'onclick="js_aniosPeriodo_senddeudaindividual(document.getElementById(\'codigodeuda\').value,\'modal_deudasconfirmacion_body\',' +
                '\'modal_deudas_body\',\''+document.getElementById( 'ruta_html_finan' ).value+'/aniosPeriodo/controller.php\',document.getElementById(\'codigomes_deudas\').value)">Migrar</button>';
    var data = new FormData();
    data.append( 'event', 'migrarfacturasindividuales' );
    data.append( 'codigodeuda', codigo );
    var xhr = new XMLHttpRequest();
    xhr.open('POST', url, true);
    xhr.onreadystatechange = function()
    {   if ( xhr.readyState === 4 && xhr.status === 200 )
        {   document.getElementById(div).innerHTML=xhr.responseText;
        }
    };
    xhr.send(data);
}
function js_aniosPeriodo_migrarfacturascontificos( url2, div, i, cc, ce, cd )
{   document.getElementById( 'btn_migrardeudascontifico' ).disabled = true;
    var datosdeudas=document.getElementById('jsondeudas').innerHTML;
    var cantidad=document.getElementById('cantidad').value;
    document.getElementById(div).innerHTML='<br><div align="center"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i><br>Por favor, espere...</div><br>';
    var data = new FormData();
    var valores = JSON.parse(datosdeudas);
    json_codigoDeudas_envioContifico = JSON.parse(datosdeudas);
    fact_enviadas = 0;
    correctas = 0;
    error = 0;
    errorfactura = 0;
    if( cantidad === '0' )
    {    document.getElementById(div).innerHTML = 
        '<div class="alert alert-info" role="alert">'+
            '<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>'+
            '<span class="sr-only">Atencion:</span>&nbsp;No hay deudas por migrar.</div>';
    }
    else
    {   proceso_corriendo = 1;
        var start_time = new Date().getTime();
        var request_time = 0;
        var per_complete_first = 0;
        js_aniosPeriodo_migrarfacturascontificos_followed( url2, div, 0, cantidad, cc, ce, cd, start_time, request_time, per_complete_first );
    }
}
function js_aniosPeriodo_migrarfacturascontificos_followed( url2, div, indice, obj_len, cc, ce, cd, start_time, request_time, per_complete_first )
{   var per_complete = Math.round( ( ( ( indice + 1 ) * 100 ) / obj_len ) );
    if(aniosPeriodo_interval_carga_progress_bar_CONTIFICO)
    {   clearInterval(aniosPeriodo_interval_carga_progress_bar_CONTIFICO);
    }
    if( (fact_enviadas == obj_len) || ( proceso_corriendo === 0 ) )
    {   js_aniosPeriodo_envio_deudas_lote_resultadofinal( url2, correctas, error, errorfactura, 'modal_deudas_body', indice, obj_len );
    }
    else
    {    if ( proceso_corriendo === 1 )
        {    if ( indice > 0 ) 
            {   var progressBar = $('#pb_envio_por_lote'), width = per_complete-per_complete_first-1;
                aniosPeriodo_interval_carga_progress_bar_CONTIFICO = setInterval(function()
                {   width += 1;
                    progressBar.css('width', width + '%');
                    if (document.getElementById('div_text_per_complete'))
                        document.getElementById('div_text_per_complete').innerHTML = width;
                    if ( ( width >= ( per_complete - 1 )) && ((document.getElementById('pb_envio_por_lote'))) )
                    {   clearInterval(aniosPeriodo_interval_carga_progress_bar_CONTIFICO);
                    }
                }, Math.round( request_time / (per_complete_first-1) ) );
            }
            var deuda = JSON.stringify( json_codigoDeudas_envioContifico[ indice ] );
            var id = json_codigoDeudas_envioContifico[ indice ].documento;
            var estado = '';
            var url = 'https://www.contifico.com/sistema/api/v1/documento/';
            var apikey = document.getElementById('apikey').value;
            var xhrr = new XMLHttpRequest();
            xhrr.open('POST', url , true);
            xhrr.setRequestHeader('Authorization', apikey);
            xhrr.setRequestHeader('Content-type','application/json;charset=utf-8');
            xhrr.onreadystatechange = function()
            {   if ( xhrr.readyState === 4 )
                {   if ( indice === 0 ) 
                    {   per_complete_first = per_complete;
                    }
                    request_time = new Date().getTime() - start_time;
                    if ( xhrr.status === 201 )
                    {   estado = 'MI';
                        correctas = correctas + 1;
                    }
                    else if ( xhrr.status === 401 )
                    {   estado = 'ER';
                        error = error + 1;
                    }
                    else if ( xhrr.status === 409 )
                    {   estado = 'MI';
                        correctas = correctas + 1;
                    }
                    else if( xhrr.status === 500 )
                    {   estado = 'ER';
                        error = error + 1;
                    }
                    else if( xhrr.status === 400 )
                    {   estado = 'DE';
                        errorfactura = errorfactura + 1;
                    }
                    document.getElementById(div).innerHTML=
                    '<br>'+ 
                    '<div align="center" style="height:50%;">'+
                        '<i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i>'+
                        '<br>'+ 
                        '<span style="font-size:small;">Envío de deudas a Contífico... <span id="div_text_per_complete" name="div_text_per_complete">' + (per_complete) + '</span>% completado</span>'+
                        '<br>'+
                        '<br>'+
                        '<a tabindex="0" class="btn btn-default btn-xs" onclick="js_aniosPeriodo_detener_envio_CONTIFICO( );" data-toggle="tooltip" title="Detener" data-placement="top"><span class="fa fa-stop"></span></a>'+
                        '<a tabindex="0" class="btn btn-default btn-xs" onclick="js_aniosPeriodo_pausar_envio_CONTIFICO( );" data-toggle="tooltip" title="Pausar" data-placement="right"><span class="fa fa-pause"></span></a>'+
                        '<div class="progress progress-striped">'+
                            '<div id="pb_envio_por_lote" name="pb_envio_por_lote" class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:' + (per_complete) + '%;position:relative;">'+
                            '</div>'+
                        '</div>'+
                    '</div>'+
                    '<span style="font-size:xx-small;" align="left">Enviando registro de deudas a Contífico.</span><br>'+
                    '<span style="font-size:xx-small;" align="left">' + ( indice + 1 ) + ' Deudas de ' + obj_len + '.</span>'+
                    '<br>'+
                    '<br>'+
                    '<span id="sms_estado_envio" name="sms_estado_envio" style="font-size:x-small;">Enviando...</span>';
                    var data = new FormData();
                    fact_procesadas=fact_procesadas + 1;
                    data.append('event', 'upddeuda');
                    data.append('codigo_documento', id);
                    data.append('doccontifico_codigo', xhrr.responseText);
                    data.append('estado', estado);
                    var xhrII = new XMLHttpRequest();
                    xhrII.open('POST', url2, true);
                    xhrII.onreadystatechange = function()
                    {   if ( xhrII.readyState === 4 && xhrII.status === 200 )
                        {   fact_enviadas = fact_enviadas + 1;
                            js_aniosPeriodo_migrarfacturascontificos_followed( url2, div, indice + 1, obj_len, cc, ce, cd, new Date().getTime(), request_time, per_complete_first );
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
                    '<span style="font-size:small;">Envío de deudas a Contífico... <span id="div_text_per_complete" name="div_text_per_complete">' + (per_complete - per_complete_first - 1) + '</span>% completado</span>'+
                    '<br>'+ 
                    '<br>'+ 
                    '<a tabindex="0" class="btn btn-default btn-xs" onclick="js_aniosPeriodo_detener_envio_CONTIFICO( );js_aniosPeriodo_migrarfacturascontificos_followed   ( \''+url2+'\',\''+ div+'\','+ indice+','+ obj_len+','+ cc+','+ ce+','+ cd+','+ new Date().getTime()+','+ request_time+','+ per_complete_first+');" data-toggle="tooltip" title="Detener" data-placement="top"><span class="fa fa-stop"></span></a>'+
                    '<a tabindex="0" class="btn btn-default btn-xs" onclick="js_aniosPeriodo_continuar_envio_CONTIFICO( );js_aniosPeriodo_migrarfacturascontificos_followed ( \''+url2+'\',\''+ div+'\','+ indice+','+ obj_len+','+ cc+','+ ce+','+ cd+',0,'+ request_time+','+ per_complete_first+');" data-toggle="tooltip" title="Continuar" data-placement="right"><span class="fa fa-play"></span></a>'+
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
                '<span id="sms_estado_envio" name="sms_estado_envio" style="font-size:x-small;">Pausado</span>';
        }
    }
}
function js_aniosPeriodo_detener_envio_CONTIFICO( )
{   proceso_corriendo = 0;
    document.getElementById( 'sms_estado_envio' ).innerHTML = "<span>Deteniendo envío...</span> los registros que ya fueron procesadas ya tienen una respuesta del sistema del Contífico.";
}
function js_aniosPeriodo_pausar_envio_CONTIFICO( )
{   proceso_corriendo = 2;
    document.getElementById( 'sms_estado_envio' ).innerHTML = "<span>Pausando envío...</span>";
}
function js_aniosPeriodo_continuar_envio_CONTIFICO( )
{   proceso_corriendo = 1;
}
function js_aniosPeriodo_envio_deudas_lote_resultadofinal( url, cc, ce, cd, div, indice, obj_len )
{   if ( !div )
        div = 'migrardeudasresult';
    document.getElementById( div ).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var data = new FormData();
    data.append('event', 'resultado');
    data.append('contadorcorrectos', cc);
    data.append('contadorerror', ce);
    data.append('contadorerrfact', cd);
    var xhrII = new XMLHttpRequest();
    xhrII.open('POST', url, true);
    xhrII.onreadystatechange = function()
    {   if ( xhrII.readyState === 4 && xhrII.status === 200 )
        {   document.getElementById( div ).innerHTML = xhrII.responseText;
            if (!Notification)
            {   alert('Las notificaciones de escritorio no están disponibles en su explorador. Por favor utilzia Chrome.'); 
                return;
            }
            if (Notification.permission !== "granted")
                Notification.requestPermission();
            else
            {    if ( proceso_corriendo === 1 )
                {   var sms_notify = "";
                    if (obj_len > 1)
                        sms_notify = "¡Se han enviado " + ( indice ) + " registros de deudas a Contífico!";
                    else
                        sms_notify = "¡Envío de deudas completado!";
                    
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
function js_aniosPeriodo_senddeudaindividual( id, div, div2, url2, mes )
{   var deuda=document.getElementById('jsondeudas').innerHTML;
    document.getElementById( 'span_senddeudaindividual_result_button' ).innerHTML = '';
    document.getElementById(div).innerHTML='<br><div align="center"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i><br>Por favor, espere...</div><br>';
    var data = new FormData();
    var url='https://www.contifico.com/sistema/api/v1/documento/';
    var apikey = document.getElementById('apikey').value;
    var xhrr = new XMLHttpRequest();
    xhrr.open('POST', url , true);
    xhrr.setRequestHeader('Authorization', apikey);
    xhrr.setRequestHeader('Content-type','application/json;charset=utf-8');
    xhrr.onreadystatechange = function()
    {   if ( xhrr.readyState === 4 )
        {   var responseJSON = JSON.parse( xhrr.responseText );
            if( xhrr.status === 201 )
                document.getElementById(div).innerHTML = 
                "<div class='callout callout-info'><h4><span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span>&nbsp;Contífico:</h4>Deuda creada en Contífico correctamente.</div>";
            else
                document.getElementById(div).innerHTML = 
                    "<div class='callout callout-info'><h4><span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span>&nbsp;Contífico:</h4>" + 
                    responseJSON.mensaje + "</div>";
        }
        if ( xhrr.readyState === 4 && xhrr.status === 201 )
        {   js_aniosPeriodo_upddocumentoindividual(xhrr.responseText,url2,id,div2,'MI',0);
            js_aniosPeriodo_carga_deudas( mes, div2, url2 );
        }
        else if ( xhrr.readyState === 4 && xhrr.status === 401 )
        {   js_aniosPeriodo_upddocumentoindividual(xhrr.responseText,url2,id,div2,'ER',0);
            js_aniosPeriodo_carga_deudas( mes, div2, url2 );
        }
        else if ( xhrr.readyState === 4 && xhrr.status === 409 )
        {   js_aniosPeriodo_upddocumentoindividual(xhrr.responseText,url2,id,div2,'MI',0);
            js_aniosPeriodo_carga_deudas( mes, div2, url2 );
        }
        else if( xhrr.readyState === 4 && xhrr.status === 500 )
        {   js_aniosPeriodo_upddocumentoindividual(xhrr.responseText,url2,id,div2,'ER',0);
            js_aniosPeriodo_carga_deudas( mes, div2, url2 );
        }
        else if( xhrr.readyState === 4 && xhrr.status === 400 )
        {   js_aniosPeriodo_upddocumentoindividual(xhrr.responseText,url2,id,div2,'DE',0);
            js_aniosPeriodo_carga_deudas( mes, div2, url2 );   
        }
    };
    xhrr.send(deuda);
}
function js_aniosPeriodo_upddocumentoindividual(codigo_contifico,url,codigo, div,estado,cantidad)
{   document.getElementById(div).innerHTML='<br><div align="center"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i><br>Por favor, espere...</div><br>';
    var data = new FormData();
    fact_procesadas = fact_procesadas + 1;
    data.append('event', 'upddeuda');
    data.append('codigo_documento', codigo);
    data.append('doccontifico_codigo', codigo_contifico);
    data.append('estado', estado);
    var xhr = new XMLHttpRequest();
    xhr.open('POST', url, true);
    xhr.onreadystatechange = function(){
        if ( xhr.readyState === 4 && xhr.status === 200 )
        {   //return true;
        }
    };
    xhr.send(data);
}
function js_aniosPeriodo_buscadeudas(div, url)
{   document.getElementById(div).innerHTML='<br><div align="center"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i><br>Por favor, espere...</div><br>';
    var anio = $("#cmb_periodo_anual_deudas option:selected").text();
    var data = new FormData();
    data.append('event', 'get_all_deuda');
    data.append('anio', anio);
    var xhr = new XMLHttpRequest();
    xhr.open('POST', url, true);
    xhr.onreadystatechange = function()
    {   if ( xhr.readyState === 4 && xhr.status === 200 )
        {   document.getElementById(div).innerHTML = xhr.responseText;
            $('#tabladeuda').DataTable({
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
// Consulta filtrada
function js_aniosPeriodo_buscaItemsPeriodo(div, url)
{   document.getElementById(div).innerHTML='<br><div align="center"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i><br>Por favor, espere...</div><br>';
    var data = new FormData();
    data.append('event', 'get_all_data');
    data.append('anio', $("#codigoAnio option:selected").val());
    var xhr = new XMLHttpRequest();
    xhr.open('POST', url, true);
    xhr.onreadystatechange = function()
    {   if ( xhr.readyState === 4 && xhr.status === 200 )
        {   document.getElementById( 'div_main_box_header' ).innerHTML =
                        '<button class="btn btn-primary" type="button" aria-hidden="true" data-toggle="modal" data-target="#modal_add"'+
                                'onclick="js_aniosPeriodo_carga_add(\'modal_add_body\',\'' + document.getElementById("ruta_html_finan").value + '/aniosPeriodo/controller.php\')" {disabled_agregar_item}>'+
                                'Item&nbsp;<li class="fa fa-plus"></li></button>'+
                        '<div class="pull-right">'+
                        '<button type="button" class="btn btn-default"'+
                            'aria-hidden="true" data-toggle="modal" data-target="#modal_infoPa">'+
                            '&nbsp;<span style="color:#3c8dbc;" class="fa fa-info-circle"></span>&nbsp;</button>'+
                    '</div>';
            document.getElementById(div).innerHTML=xhr.responseText;
            $('#anioPeriodo_table').addClass( 'nowrap' ).DataTable({
                lengthChange: true,
                responsive: true,
                searching: true,
                orderClasses: true,
                paging: true,
                language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'},
                "columnDefs": [
                    {"title": "<span style='color:black;font-size:small;'>ref.</span>", className: "dt-body-center", "targets": [0]},
                    {"title": "<span style='color:black;font-size:small;'>Producto</span>", className: "dt-body-center" , "targets": [1]},
                    {"title": "<span style='color:black;font-size:small;'>Inicio cobro</span>", className: "dt-body-center" , "targets": [2]},
                    {"title": "<span style='color:black;font-size:small;'>Fin cobro</span>", className: "dt-body-center" , "targets": [3]},
                    {"title": "<span style='color:black;font-size:small;'>Prontopago</span>", className: "dt-body-center" , "targets": [4]},
                    {"title": "<span style='color:black;font-size:small;'>Opciones</span>", className: "dt-body-center" , "targets": [5]},
                    {className: "dt-head-center" , "targets": [0]},
                    {className: "dt-head-left"   , "targets": [1]},
                    {className: "dt-head-center" , "targets": [2]},
                    {className: "dt-head-center" , "targets": [3]},
                    {className: "dt-head-center" , "targets": [4]},
                    {className: "dt-head-center" , "targets": [5]}
                ]
            });
            $("#nav_aniosPeriodo_1").addClass("active");
            $("#nav_aniosPeriodo_2").removeClass("active");
            $("#nav_aniosPeriodo_3").removeClass("active");
        }
    };
    xhr.send(data);
}
function js_aniosPeriodo_carga_resultadoLote(div, url)
{   document.getElementById( 'div_main_box_header' ).innerHTML = 
                    '<div class="pull-right">'+
                        '<button type="button" class="btn btn-default"'+
                            'aria-hidden="true" data-toggle="modal" data-target="#modal_infoPa">'+
                            '&nbsp;<span style="color:#3c8dbc;" class="fa fa-info-circle"></span>&nbsp;</button>'+
                    '</div>';
    document.getElementById(div).innerHTML='<br><div align="center"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i><br>Por favor, espere...</div><br>';
    var data = new FormData();
    data.append('event', 'genera_deudas');
    var xhr = new XMLHttpRequest();
    xhr.open('POST', url, true);
    xhr.onreadystatechange = function(){
        if ( xhr.readyState === 4 && xhr.status === 200 )
        {   document.getElementById(div).innerHTML=xhr.responseText;
            $("#alumnos").select2();
            $("#nav_aniosPeriodo_1").removeClass("active");
            $("#nav_aniosPeriodo_2").addClass("active");
            $("#nav_aniosPeriodo_3").removeClass("active");
        }
    };
    xhr.send(data);
}
function js_aniosPeriodo_carga_bloqueo_alumnos(div, url)
{   document.getElementById( 'div_main_box_header' ).innerHTML = 
                    '<div class="pull-right">'+
                        '<button type="button" class="btn btn-default"'+
                            'aria-hidden="true" data-toggle="modal" data-target="#modal_infoPa">'+
                            '&nbsp;<span style="color:#3c8dbc;" class="fa fa-info-circle"></span>&nbsp;</button>'+
                    '</div>';
    document.getElementById(div).innerHTML='<br><div align="center"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i><br>Por favor, espere...</div><br>';
    var data = new FormData();
    data.append('event', 'bloqueo_alumnos');
    var xhr = new XMLHttpRequest();
    xhr.open('POST', url, true);
    xhr.onreadystatechange = function(){
        if ( xhr.readyState === 4 && xhr.status === 200 )
        {   document.getElementById(div).innerHTML=xhr.responseText;
            $("#alumnos").select2();
            $("#nav_aniosPeriodo_1").removeClass("active");
            $("#nav_aniosPeriodo_2").removeClass("active");
            $("#nav_aniosPeriodo_3").addClass("active");
        }
    };
    xhr.send(data);
}
// Realiza el ingreso de un registro nuevo
function js_aniosPeriodo_saveAddItem( div, url )
{   var comboProducto = document.getElementById("codigoProducto_add");
    if(comboProducto.options[comboProducto.selectedIndex].value > 0)
    {   if ( ( document.getElementById('fechaInicio_add').value.length === 0 ) || ( document.getElementById('fechaFin_add').value.length === 0 ) )
        {   $.growl.warning({ title: "Educalinks informa", message: "Marque las fechas de inicio y fin de cobro para continuar." });
        }
        else
        {   if (js_general_compare_dates( document.getElementById('fechaInicio_add').value, document.getElementById('fechaFin_add').value ) == 'OK' )
            {   document.getElementById(div).innerHTML='<br><div align="center"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i><br>Por favor, espere...</div><br>';
                var data = new FormData();
                data.append('event', 'set');
                data.append('anio',  document.getElementById('periodo_add').value);
                data.append('producto',  comboProducto.options[comboProducto.selectedIndex].value);
                data.append('fechaInicio', document.getElementById('fechaInicio_add').value);
                data.append('fechaFin', document.getElementById('fechaFin_add').value);
                data.append('diasProntopago', document.getElementById('diasProntopago_add').value);
                var xhr = new XMLHttpRequest();
                xhr.open('POST', url, true);
                xhr.onreadystatechange = function()
                {   if ( xhr.readyState === 4 && xhr.status === 200 )
                    {   $.growl.notice({ title: "¡Item modificado!", message: "Item " + comboProducto.options[comboProducto.selectedIndex].value + ": '" + comboProducto.options[comboProducto.selectedIndex].text + "' guardado correctamente." });
                        js_aniosPeriodo_buscaItemsPeriodo(div, url);
                    }
                };
                xhr.send(data);
            }
            else
            {   $.growl.warning({ title: "Educalinks informa", message: "Fecha de inicio no puede ser mayor que la fecha de fin." });
            }
        }
    }
    else
    {   $.growl.warning({ title: "Educalinks informa", message: "Seleccione un producto antes de continuar." });
    }
}
// Realiza el ingreso de un registro nuevo
function js_aniosPeriodo_generarDeudaLote( div2, url )
{   var frm = document.getElementById(div2);
    var porcentaje=100;
    var productos={};
    var bandera_prod = 0;
    for (i = 0;i<frm.elements.length;i++)
    {   if(frm.elements[i].type=="checkbox" && frm.elements[i].checked )
        {   productos[i] = frm.elements[i].value;
            bandera_prod++;
        }
    }
    if ( bandera_prod === 0 )
        $.growl.warning({ title: "Educalinks informa", message: "Seleccione al menos un producto para continuar." });
    else
    {   document.getElementById( 'div_deudas_resultado' ).innerHTML='<br><div align="center"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i><br>Por favor, espere...</div><br>';    aumenta_porc( 0 ); //Función llamada de general.js    document.getElementById('btn_genera_deuda').disabled = true;
        var alumnos={};
        $('#alumnos :selected').each(function(i, selected){ 
          alumnos[i] = $(selected).val(); 
        });
        var data = new FormData();
        data.append('event', 'set_deuda_ind');
        var bandera = 0;
        $('#alumnos :selected').each(function(i, selected){ 
            bandera++;
        });
        const selected = $('#alumnos :selected').map(function() {return $(this).text();}).get();
        if (!selected.includes(' - Todos -') && (bandera > 0) )
        {   data.append('casos','alumno');
        }
        if(( selected.includes(' - Todos -') && (bandera > 0) )&&(document.getElementById('curso').value >0))
        {   data.append('casos','curso');
        }
        if( document.getElementById('curso').value <= 0 )
        {   data.append('casos','todos');
        }
        if( ( document.getElementById('curso').value <= 0 ) && ( document.getElementById('periodos').value <= 0 ) )
        {   data.append('casos','todos');
        }
        data.append( 'producto',  JSON.stringify( productos ) );
        data.append( 'peri_codi', document.getElementById( "periodos" ).value );
        data.append( 'cod_curso', document.getElementById("curso").value );
        data.append( 'cod_alum',  JSON.stringify( alumnos ) );
        var xhr = new XMLHttpRequest();
        xhr.open('POST', url, true);
        xhr.onreadystatechange = function()
        {   if ( xhr.readyState === 4 && xhr.status === 200 )
            {   if ( xhr.responseText.length === 0 )
                {   document.getElementById('div_deudas_resultado').innerHTML =
                    '<span style="color:red;font-size:small;">Por favor, seleccione una opción en el listado de Alumnos.</span>';
                    aumenta_porc( 0 ); //Función llamada de general.js
                }
                else
                {   document.getElementById('div_deudas_resultado').innerHTML = xhr.responseText;
                    aumenta_porc(porcentaje); //Función llamada de general.js
                }    
                document.getElementById('btn_genera_deuda').disabled = false;
            }
        };
        xhr.send(data);
    }
}
function js_aniosPeriodo_validaTodos()
{   var bandera = 0;
    $('#alumnos :selected').each(function(i, selected){ 
        bandera++;
    });
    const selected = $('#alumnos :selected').map(function() {return $(this).text();}).get();
    if (selected.includes(' - Todos -') && (bandera > 1) )
    {   document.getElementById( 'span_tiene_todos' ).innerHTML = "Ha seleccionado - Todos - . Se generarán deudas para todos los estudiantes del curso seleccionado.";
        //$('option:contains(\' - Todos -\')').prop('selected', false)
    }
    else
        document.getElementById( 'span_tiene_todos' ).innerHTML = "";
}
// Carga el formulario para editar un registro
function js_aniosPeriodo_carga_edit(codigo, div, url)
{   document.getElementById(div).innerHTML='<br><div align="center"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i><br>Por favor, espere...</div><br>';
    var data = new FormData();
    data.append('event', 'get');
    data.append('producto', codigo);
    data.append('anio', $("#peri_codi").val());
    var xhr = new XMLHttpRequest();
    xhr.open('POST', url, true);
    xhr.onreadystatechange = function()
    {   if ( xhr.readyState === 4 && xhr.status === 200 )
        {   document.getElementById(div).innerHTML=xhr.responseText;
        }
    };
    xhr.send(data);
}
// Realiza la actualizacion de los datos en la BD
function js_aniosPeriodo_saveEditItem( div, url )
{   
    if ( ( document.getElementById('fechaInicio_mod').value.length === 0 ) || ( document.getElementById('fechaFin_mod').value.length === 0 ) )
    {   $.growl.warning({ title: "Educalinks informa", message: "Marque las fechas de inicio y fin de cobro para continuar." });
    }
    else
    {   if (js_general_compare_dates( document.getElementById('fechaInicio_mod').value, document.getElementById('fechaFin_mod').value ) == 'OK' )
        {   
            if(confirm("¿Está seguro que desea editar la informacion actual?"))
            {   
                document.getElementById(div).innerHTML='<br><div align="center"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i><br>Por favor, espere...</div><br>';
                var data = new FormData();
                data.append('event', 'edit');
                data.append('anio', document.getElementById('codigoPeriodo_mod').value);
                data.append('producto', document.getElementById('codigoProducto_mod').value);
                data.append('fechaInicio', document.getElementById('fechaInicio_mod').value);
                data.append('fechaFin', document.getElementById('fechaFin_mod').value);
                data.append('diasProntopago', document.getElementById('diasProntopago_mod').value);
                data.append('ckb_deudasPendientes', document.getElementById('ckb_deudasPendientes').checked);
                var cod_producto = document.getElementById('codigoProducto_mod').value;
                var nom_producto = document.getElementById('nombreProducto_mod').value;
                var xhr = new XMLHttpRequest();
                xhr.open('POST', url, true);
                xhr.onreadystatechange = function()
                {   if ( xhr.readyState === 4 && xhr.status === 200 )
                    {   $.growl.notice({ title: "Educalinks informa", message: "Item " + cod_producto + ": '" + nom_producto + "' modificado correctamente." });
                        $('#modal_edit_item').modal("hide");
                        js_aniosPeriodo_buscaItemsPeriodo(div, url);
                    }
                };
                xhr.send(data);
            }
        }
        else
        {   
            $.growl.warning({ title: "Educalinks informa", message: "Fecha de inicio no puede ser mayor que la fecha de fin." });
        }
    }
}
function js_aniosPeriodo_cargaCursos( div, url )
{   document.getElementById(div).innerHTML='<br><div align="center"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i><br>Por favor, espere...</div><br>';
    var comboPeriodos = document.getElementById("periodos");
    var data = new FormData();
    data.append('cod_peri', comboPeriodos.value);
    data.append('event', 'get_curso');
    var xhr = new XMLHttpRequest();
    xhr.open('POST', url, true);
    xhr.onreadystatechange = function()
    {   if ( xhr.readyState === 4 && xhr.status === 200 )
        {   document.getElementById(div).innerHTML=xhr.responseText;
            js_aniosPeriodo_cargaAlumnos( 'resultadoAlumnos' );
            document.getElementById( 'span_tiene_todos' ).innerHTML = "";
        }
    };
    xhr.send(data);
}
function js_aniosPeriodo_cargaAlumnos( div )
{   document.getElementById(div).innerHTML='<br><div align="center"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i><br>Por favor, espere...</div><br>';
    var comboCursos = document.getElementById("curso");
    var data = new FormData();
    data.append('cod_curso', comboCursos.value);
    data.append('event', 'get_alumnos');
    var xhr = new XMLHttpRequest();
    xhr.open('POST', document.getElementById('ruta_html_finan').value + '/aniosPeriodo/controller.php', true);
    xhr.onreadystatechange = function()
    {   if ( xhr.readyState === 4 && xhr.status === 200 )
        {   document.getElementById(div).innerHTML=xhr.responseText;
            if (comboCursos.value === -1 )
            {   $('#alumnos').attr('disabled','true');
            }
            else
            {   if ( $("#nav_aniosPeriodo_3").hasClass('active') )
                {   $("#alumnos option[value='-1']").remove();
                }
                $('#alumnos').removeAttr('disabled');
                $("#alumnos").select2();
            }
        }
    };
    xhr.send(data);
}
// Realiza la eliminacion del cliente en la BD
function js_aniosPeriodo_del( codigo, div, url )
{   if( confirm( "¿Está seguro que desea eliminar el item del periodo actual?" ) )
    {   document.getElementById(div).innerHTML='<br><div align="center"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i><br>Por favor, espere...</div><br>';
        var data = new FormData();
        data.append('event', 'delete');
        data.append('anio',  $("#peri_codi").val());
        data.append('producto', codigo);
        var xhr = new XMLHttpRequest();
        xhr.open('POST', url, true);
        xhr.onreadystatechange = function()
        {   if ( xhr.readyState === 4 && xhr.status === 200 )
            {   $.growl.notice({ title: "¡Item eliminado!", message: "Item " + codigo + " eliminado correctamente." });
                js_aniosPeriodo_buscaItemsPeriodo(div, url);
            }
        };
        xhr.send(data);
    }
}
function js_aniosPeriodo_bloquear ( div, url )
{
    var follow = 1;
    
    if( document.getElementById('curso').value <= 0 )
    {   follow = 0;
        $.growl.warning({ title: "Educalinks informa", message: "Seleccione un curso para continuar." });
    }
    var alumnos = {};
    var bandera = 0;
    $('#alumnos :selected').each(function(i, selected){ 
        alumnos[i] = $(selected).val(); 
        bandera ++;
    });
    if( bandera === 0 )
    {   follow = 0;
        $.growl.warning({ title: "Educalinks informa", message: "Seleccione al menos un alumno para continuar." });
    }
    if ( follow === 1 )
    {   document.getElementById('btn_bloqueo_alumnos').disabled=true;
        $("#nav_aniosPeriodo_1").addClass("disabled_a");
        $("#nav_aniosPeriodo_2").addClass("disabled_a");
        $("#nav_aniosPeriodo_3").addClass("disabled_a");
        
        
        var data = new FormData();
        data.append( 'event', 'set_bloqueo_alumno');
        data.append( 'peri_codi', document.getElementById( "periodos" ).value );
        data.append( 'motivo', document.getElementById("cmb_motivo").value );
        data.append( 'opcion', document.getElementById("cmb_opciones").value );
        data.append( 'cod_alum',  JSON.stringify( alumnos ) );
        var xhr = new XMLHttpRequest();
        xhr.open('POST', url, true);
        xhr.onreadystatechange = function()
        {   if ( xhr.readyState === 4 && xhr.status === 200 )
            {   if( xhr.responseText.length > 0 )
                {   resultado = JSON.parse(xhr.responseText);
                    document.getElementById('div_lista_bloqueados').innerHTML = resultado.tbl_listado_bloqueo_alumnos;
                    valida_tipo_growl(resultado.mensaje);
					js_aniosPeriodo_cargaAlumnos( 'resultadoAlumnos' );
                }
                else
                {   $.growl.error({ title: "Educalinks informa",message: "No se pudo hacer conexión con el servidor." });
                    document.getElementById('div_lista_bloqueados').innerHTML = xhr.responseText;
                }
                document.getElementById('btn_bloqueo_alumnos').disabled = false;
                $("#nav_aniosPeriodo_1").removeClass("disabled_a");
                $("#nav_aniosPeriodo_2").removeClass("disabled_a");
                $("#nav_aniosPeriodo_3").removeClass("disabled_a");
            }
        };
        xhr.send(data);
    }
}

// Realiza la eliminacion del cliente en la BD
function js_aniosPeriodo_del_bloqueo( codigo )
{   if( confirm( "¿Está seguro que desea eliminar el bloqueo de este alumno?" ) )
    {   document.getElementById( 'div_lista_bloqueados' ).innerHTML='<br><div align="center"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i><br>Por favor, espere...</div><br>';
        var data = new FormData();
        data.append('event', 'del_bloqueo_alumno');
        data.append('alum_moti_bloq_opci_codi',  codigo);
        var xhr = new XMLHttpRequest();
        xhr.open('POST', document.getElementById('ruta_html_finan').value + '/aniosPeriodo/controller.php', true);
        xhr.onreadystatechange = function()
        {   if ( xhr.readyState === 4 && xhr.status === 200 )
            {   console.log(xhr.responseText);
                if( xhr.responseText.length > 0 )
                {   resultado = JSON.parse(xhr.responseText);
                    document.getElementById('div_lista_bloqueados').innerHTML = resultado.tbl_listado_bloqueo_alumnos;
                    valida_tipo_growl(resultado.mensaje);
					js_aniosPeriodo_cargaAlumnos( 'resultadoAlumnos' );
                }
                else
                {   $.growl.error({ title: "Educalinks informa",message: "No se pudo hacer conexión con el servidor." });
                    document.getElementById('div_lista_bloqueados').innerHTML = xhr.responseText;
                }
                document.getElementById('btn_bloqueo_alumnos').disabled = false;
                $("#nav_aniosPeriodo_1").removeClass("disabled_a");
                $("#nav_aniosPeriodo_2").removeClass("disabled_a");
                $("#nav_aniosPeriodo_3").removeClass("disabled_a");
            }
        };
        xhr.send(data);
    }
}