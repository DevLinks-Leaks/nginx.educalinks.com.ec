$(document).ready(function() {
    $('#modal_resultadoPago').on('hidden.bs.modal', function (e) {
        limpiaPaginanoq('true');
    });
    
    $('#deudasPendiente_table').DataTable({
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
            {className: "dt-body-right" , "targets": [4]},
            {className: "dt-body-right" , "targets": [5]},
            {className: "dt-body-right" , "targets": [6]},
            {className: "dt-body-center", "targets": [7]},
            {className: "dt-body-center", "targets": [8]}
        ]
    });

    $('#deudasSeleccionadas_table').DataTable({
        "info": false,
        "ordering": false,
        "searching":false,
        "lengthChange":false,
        "paging":false,
        "retrieve" : true,
        "language": {
            "url":spanish
        }
    });

    $('#pagos_table').DataTable({
        "info": false,
        "ordering": false,
        "searching":false,
        "lengthChange":false,
        "paging":false,
        "retrieve" : true,
        "language": {
            "url":spanish
        }
    });
	
	$('#modal_select_sucursal').on('shown.bs.modal', function() {
        $('#pto_sucursal').focus();
		shortcut.add("Enter", function() {js_descuentofactura_select_sucursal_followed()},{'target':document.getElementById('pto_sucursal')});
    })
	$('#modal_select_ptoVenta').on('shown.bs.modal', function() {
		$('#cmb_ptoVenta').focus();
		shortcut.add("Enter", function() {js_descuentofactura_select_ptoVenta_followed()},{'target':document.getElementById('cmb_ptoVenta')});
	});
	$('#modal_select_numeroFactura').on('shown.bs.modal', function() {
		$('#cmb_numeroFactura').focus();
		shortcut.add("Enter", function() {js_descuentofactura_select_numeroFactura_followed()},{'target':document.getElementById('cmb_numeroFactura')});
	});
	$('#modal_select_sucursal').on('hidden.bs.modal', function() {
		$('#cmb_ptoVenta').focus();
	});
	$('#modal_select_ptoVenta').on('hidden.bs.modal', function() {
		$('#txt_num_factura').focus();
	});
});
var v_previsualizado = 0; //global
function js_descuentofactura_busca(div,url)
{   var codigoCliente = document.getElementById('codigoCliente').value;
    var tipo_persona = document.getElementById('hd_tipo_persona').value;
	v_previsualizado = 0;
	document.getElementById( 'span_button_return' ).innerHTML='<button class="btn btn-default" type="button" ' +
			' onclick="js_descuentofactura_busca(\'resultado\',\'' +
			document.getElementById( "ruta_html_finan" ).value + 
			'/descuentofacturas/controller.php\')"><i class="fa fa-refresh"></i>&nbsp;Refrescar deudas</button>';
    document.getElementById( 'span_button_save_deud_changes' ).innerHTML = '';
    document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    document.getElementById( 'div_total_deudas' ).innerHTML = '<span class="input-group-addon"><strong>T. Deudas: </strong>$</span>' + 
                            '<input type="text" disabled="true" class="form-control" name="totalDeudasPendientes" id="totalDeudasPendientes" placeholder="00.00" required="required">';
    var data = new FormData();
    data.append('event', 'get_deudas');
    data.append('codigoCliente', codigoCliente );
    data.append('tipo_persona', tipo_persona );
    var xhr = new XMLHttpRequest();
    xhr.open('POST', url , true);
    xhr.onreadystatechange=function()
    {   if (xhr.readyState==4 && xhr.status==200)
        {   document.getElementById(div).innerHTML=xhr.responseText;
            var table = $('#deudasPendiente_table').DataTable({
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
                    {className: "dt-body-left"  , "targets": [2]},
                    {className: "dt-body-right" , "targets": [3]},
                    {className: "dt-body-right" , "targets": [4]},
                    {className: "dt-body-right" , "targets": [5]},
                    {className: "dt-body-right" , "targets": [6]},
                    {className: "dt-body-right" , "targets": [7]},
                    {className: "dt-body-right" , "targets": [8]},
                    {className: "dt-body-center", "targets": [9]},
                    {className: "dt-body-center", "targets": [10]}
                ]
            });
            table.page.len(10).draw();
            $('#deudasPendiente_table thead tr th').css('background-color', 'bgGreen');
            // Add event listener for opening and closing details
            $('#deudasPendiente_table tbody').on('click', 'td.details-control', function ()
            {   var tr = $(this).closest('tr');
                var row = table.row(tr);
                if ( row.child.isShown() )
                {   // This row is already open - close it
                    row.child.hide();
                    tr.removeClass('shown');
                    $(this).find('i').toggleClass('fa fa-minus-circle fa fa-plus-circle');
                    $(this).find('i').css("color", "green");
                }
                else
                {   $(this).find('i').toggleClass('fa fa-minus-circle fa fa-plus-circle');
                    $(this).find('i').css("color", "red");
                    var ref_interna = [];
                    ref_interna = row.data();
                    if( ref_interna )
                    {   $('#modal_wait').modal("show");
                        var data = new FormData();
                        data.append('event', 'carga_detalle_deudas_info');
                        data.append('deud_codigo', ref_interna[1]);    
                        var xhr = new XMLHttpRequest();
                        xhr.open('POST', document.getElementById('ruta_html_finan').value + '/descuentofacturas/controller.php', true);
                        xhr.onreadystatechange=function()
                        {   if ( xhr.readyState === 4 && xhr.status === 200 )
                            {   // Open this row
                                row.child(xhr.responseText).show();
                                tr.addClass('shown');
                                var table_deuda = $('#detalle_deuda_'+ref_interna[1]).DataTable({
                                    language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'},
                                    "lengthChange": false,
                                    searching: false,
                                    paging:false,
                                    info:false,
                                    "order":[[4, 'asc']],
                                    "columnDefs": [
                                        {className: "dt-body-left"  , "targets": [0]},
                                        {className: "dt-body-right" , "targets": [1]},
                                        {className: "dt-body-right" , "targets": [2]},
                                        {className: "dt-body-right" , "targets": [3]},
                                        {className: "dt-body-right" , "targets": [4]},
                                        {className: "dt-body-right" , "targets": [5]},
                                        {className: "dt-body-right" , "targets": [6]}
                                    ],
                                    "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                                        $('td', nRow).css('background-color', '#d6f9da');
                                    }
                                });
                                $('#modal_wait').modal("hide");
                            }
                        };
                        xhr.send(data);
                    }
                }
            });
            // ==================================================
            // Actualiza el total de las deudas pendientes
            var subtotal = 0;
            $('#deudasPendiente_table tbody tr').each(function(){
                subtotal += parseFloat($(this).find('td').eq(8).text());
            });
            $('#totalDeudasPendientes').val(subtotal.toFixed(2));
            justificaMensajeNoData($('#deudasPendiente_table')); 
            // ==================================================
            // Limpia la tabla de las deudas seleccionadas
            $('#deudasSeleccionadas_table tbody tr').each(function(){
                if($(this).find('td').eq(0).hasClass('dataTables_empty') !== true)
                {   $(this).remove();    
                }
            });
            justificaMensajeNoData($('#deudasSeleccionadas_table')); // Agrego el div que coloca el datatable donde dice: "No data available in table"
            
        }
    };
    xhr.send(data);
}
// Carga el formulario para buscar a un cliente especifico
function js_descuentofactura_carga_busquedaCliente(div,url){
    var spanish_in="//cdn.datatables.net/plug-ins/f2c75b7247b/i18n/Spanish.json";
    document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var data = new FormData();
    data.append('event', 'buscar_clientes');    
    var xhr = new XMLHttpRequest();
    xhr.open('POST', url , true);
    xhr.onreadystatechange=function(){
        if (xhr.readyState==4 && xhr.status==200){
            document.getElementById(div).innerHTML=xhr.responseText;
            $('#clientes_table').DataTable({
                "info": false,
                "ordering": true,
                "searching":false,
                "lengthChange":false,
                "paging":true,
                "language": {
                    "url":spanish_in
                }
              });
        } 
    };
    xhr.send(data);
}
function js_descuentofactura_carga_asignacion( codigo, div, url )
{   document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    document.getElementById( 'div_total_deudas' ).innerHTML = '';
    var data = new FormData();
    data.append('event', 'asignarDescuento');    
    data.append('codigo', document.getElementById('codigoCliente').value);
    data.append('tipo_persona', document.getElementById('hd_tipo_persona').value);
    data.append('codigofactura', codigo);    
    var xhr = new XMLHttpRequest();
    xhr.open('POST', url , true);
    document.getElementById('coddeuda').value = codigo;
    xhr.onreadystatechange=function(){
        if (xhr.readyState==4 && xhr.status==200)
        {   document.getElementById(div).innerHTML=xhr.responseText;
            $("#porcentaje_descto").numeric({ decimal : ".",  negative : false, scale: 2 });
            $('[data-toggle="popover"]').popover({html:true});
            $("#diasvalidez").numeric({ decimal : false,  negative : false, precision: 3 });
            
            $("#descuento").numeric({ decimal : ".",  negative : false, scale: 2 });            
            $("#fechaInicio_add").datepicker();
            $("#fechaFin_add").datepicker();
            $("#txt_como_si_fuera").datepicker();
            $("#fechaInicio_add").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
            $("#fechaFin_add").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
            $("#txt_como_si_fuera").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
            $("#dias_prontopago").numeric({ decimal : ".",  negative : false, scale: 0, precision: 3 });
            $("#txt_num_factura").numeric({ decimal : ".",  negative : false, scale: 0 });
            
            document.getElementById( 'span_button_return' ).innerHTML='<button class="btn btn-warning" type="button" ' +
                ' data-placement="bottom"' +
                ' title=\'Volver a bandeja\'' +
                ' onmouseover=\'$(this).tooltip("show")\'' +
                ' onclick="js_descuentofactura_busca(\'resultado\',\'' +
                document.getElementById( "ruta_html_finan" ).value + 
                '/descuentofacturas/controller.php\')"><i class="fa fa-chevron-left"></i>&nbsp;Volver</button>';
            document.getElementById( 'span_button_save_deud_changes' ).innerHTML='<button class="btn btn-success" type="button" ' +
                ' onclick="js_descuentofactura_save( )"><li class="fa fa-save"></li>&nbsp;Guardar Cambios</button>';
            document.getElementById( 'txt_desc_deuda' ).value = codigo;
            
            /* Le pone mask a todos los controles de la tabla descuentos */
            
            var tini_dsctos = document.getElementById( 'hd_total_inicial_descuentos' ).value;
            var tnum_detalle= document.getElementById( 'hd_total_numero_detalle' ).value;
            
            var codigo_descto = 0;
            
            $('#tabla_descuentos_cliente tbody tr').each(function(){
                codigo_descto = $(this).find('td').eq(0).attr('data-codigo');
                $("#txt_desc_per_" + codigo_descto ).numeric({ decimal : ".",  negative : false, scale: 2, precision: 3 });
                $("#txt_desc_dias_" + codigo_descto ).numeric({ decimal : false,  negative : false, precision: 3 });
            });
            for (var i = 1; i <= tnum_detalle; i++ )
            {   $("#txt_per_IVA_" + i ).numeric({ decimal : ".",  negative : false, scale: 2 });
                $("#txt_per_ICE_" + i ).numeric({ decimal : ".",  negative : false, scale: 2 });
            }
			
			shortcut.add("Enter", function() {
				$('#txt_num_sucursal').trigger("click");
			},{'target':document.getElementById('txt_num_sucursal')});
			
			shortcut.add("Enter", function() {
				$('#txt_num_ptoVenta').trigger("click");
			},{'target':document.getElementById('txt_num_ptoVenta')});
			
			shortcut.add("Enter", function() {
				$('#txt_num_factura').trigger("click");
			},{'target':document.getElementById('txt_num_factura')});
        } 
    };
    xhr.send(data);
}
function js_descuentofactura_deshacer_del_descuento_asignado ( codigo )
{   var i = 1;
	v_previsualizado = 0;
	$('#tabla_descuentos_cliente tbody tr').each(function(){
        if ( $(this).find('td').eq(0).attr('data-codigo') == codigo )
        {   $(this).find('td').eq(0).css("text-decoration", "none");
            $(this).find('td').eq(0).attr('data-estado', 'active');
            document.getElementById( "txt_desc_per_" + i ).disabled = false;
            document.getElementById( "txt_desc_dias_" + i ).disabled = false;
            document.getElementById( "ckb_dapp_" + i ).disabled = false;
            //document.getElementById( "ckb_dap_" + i ).disabled = false;
            
            $(this).find('td').eq(4).html(    "<span onclick='js_descuentofactura_del_descuento_asignado(\"" + codigo + "\")' " +
                                            " class='btn_opc_lista_eliminar fa fa-times-circle-o cursorlink' " +
                                            " aria-hidden='true' onmouseover='$(this).tooltip(\"show\")' title='Eliminar' data-placement='left'></span>");
        }
		i++;
    });
}
function js_descuentofactura_del_descuento_asignado( codigo )
{   var i = 1;
	v_previsualizado = 0;
	$('#tabla_descuentos_cliente tbody tr').each(function(){
        if ( $(this).find('td').eq(0).attr('data-codigo') == codigo ) 
        {   $(this).find('td').eq(0).css("text-decoration", "line-through");
            $(this).find('td').eq(0).attr('data-estado', 'inactive');
            document.getElementById( "txt_desc_per_" + i ).disabled = true;
            document.getElementById( "txt_desc_dias_" + i ).disabled = true;
            document.getElementById( "ckb_dapp_" + i ).disabled = true;
            //document.getElementById( "ckb_dap_" + i ).disabled = true;
            
            $(this).find('td').eq(4).html(  "<span onclick='js_descuentofactura_deshacer_del_descuento_asignado(\"" + codigo + "\")' " +
                                            " class='btn_opc_lista_reenviar fa fa-rotate-left cursorlink' " +
                                            " aria-hidden='true' onmouseover='$(this).tooltip(\"show\")' title='Deshacer' data-placement='left'></span>");
        }
		i++;
    });
}
function js_descuentofactura_selecciona( div_buttons, div_body, tipo_persona )
{   var codigoCliente = $('#persona_table tr.selected').find('td:nth-child(1)').text();
    $('#hd_tipo_persona').val( tipo_persona );
    $('#codigoCliente').val( codigoCliente );
    $('#numeroIdentificacionCliente').val($('#persona_table tr.selected').find('td:nth-child(2)').text());
    $('#nombresCliente').val($('#persona_table tr.selected').find('td:nth-child(3)').text());

    // === Consulta de los datos del titular del cliente seleccionado
    var data = new FormData();
    data.append('event', 'get_cliente_info_adicional');
    data.append('codigoCliente', codigoCliente );
    data.append('tipo_persona', tipo_persona );
    var nivel='';
    var grupo='';
    var xhr = new XMLHttpRequest();
    xhr.open('POST', document.getElementById('ruta_html_common').value + '/persona/controller.php' , true);
    xhr.onreadystatechange=function()
    {   if ( xhr.readyState === 4 && xhr.status === 200 )
        {   if( xhr.responseText.length > 0 )
            {   var respuesta = JSON.parse(xhr.responseText);
                if(respuesta[0].codigoGrupoEconomico === null)
                {   grupo='-1';
                }
                else
                {   grupo=respuesta[0].codigoGrupoEconomico;
                }
                $('#txt_grupo_economico').attr("data-codigo",grupo);
                $('#txt_grupo_economico').val(respuesta[0].nombreGrupoEconomico);
                $('#txt_curso').attr("data-codigo",respuesta[0].codigoCurso);
                $('#txt_curso').val(respuesta[0].nombreCurso);
                
                if(respuesta[0].codigoNivelEconomico === null)
                {   nivel='-1';
                }
                else
                {   nivel=respuesta[0].codigoNivelEconomico;
                }
                $('#txt_nivel_economico').attr("data-codigo",nivel);
                
                $('#txt_nivel_economico').val(respuesta[0].nombreNivelEconomico);
                $('#numeroIdentificacionTitular').val(respuesta[0].cedulatitular);
                $('#nombreTitular').val(respuesta[0].nombretitular);
                $('#emailTitular').val(respuesta[0].emailtitular);
                $('#telefonoTitular').val(respuesta[0].telefonotitular);
                $('#direccionTitular').val(respuesta[0].direcciontitular);
                
                $('#tipoIdentificacionTitular').val('CI');    
                if( tipo_persona == 1 )
                {   carga_cliente_opciones( codigoCliente, 'client_options' ); //Llamado desde clientes.js
                    document.getElementById('div_datos_academicos_estudiante').style.display="inline";
                }
                else
                {   document.getElementById('client_options').innerHTML="";
                    document.getElementById('div_datos_academicos_estudiante').style.display="none";
                }
                js_descuentofactura_selecciona_get_deuda( codigoCliente, tipo_persona );
            }
            else
            {   $('#txt_grupo_economico').val('');
                $('#txt_grupo_economico').attr("data-codigo","");
                $('#txt_curso').val('');
                $('#txt_nivel_economico').val('');
                $('#txt_nivel_economico').attr("data-codigo","");
            }
        }
    };
    xhr.send(data);
}
function js_descuentofactura_selecciona_get_deuda( codigoCliente, tipo_persona )
{   var data = new FormData();
    data.append('event', 'get_deudas');
    data.append('codigoCliente', codigoCliente );
    data.append('tipo_persona', tipo_persona );
    
	document.getElementById( 'span_button_return' ).innerHTML='<button class="btn btn-default" type="button" ' +
                ' onclick="js_descuentofactura_busca(\'resultado\',\'' +
                document.getElementById( "ruta_html_finan" ).value + 
                '/descuentofacturas/controller.php\')"><i class="fa fa-refresh"></i>&nbsp;Refrescar deudas</button>';
    document.getElementById( 'span_button_save_deud_changes' ).innerHTML = '';
    
    var xhr = new XMLHttpRequest();
    xhr.open('POST', document.getElementById('ruta_html_finan').value + '/descuentofacturas/controller.php' , true);
    xhr.onreadystatechange=function()
    {   if (xhr.readyState==4 && xhr.status==200)
        {   document.getElementById( 'resultado' ).innerHTML=xhr.responseText;
            var table = $('#deudasPendiente_table').DataTable({
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
                    {className: "dt-body-left"  , "targets": [2]},
                    {className: "dt-body-right" , "targets": [3]},
                    {className: "dt-body-right" , "targets": [4]},
                    {className: "dt-body-right" , "targets": [5]},
                    {className: "dt-body-right" , "targets": [6]},
                    {className: "dt-body-right" , "targets": [7]},
                    {className: "dt-body-right" , "targets": [8]},
                    {className: "dt-body-center", "targets": [9]},
                    {className: "dt-body-center", "targets": [10]}
                ]
            });
            table.page.len(10).draw();
            $('#deudasPendiente_table thead tr th').css('background-color', 'bgGreen');
            // Add event listener for opening and closing details
            $('#deudasPendiente_table tbody').on('click', 'td.details-control', function ()
            {   var tr = $(this).closest('tr');
                var row = table.row(tr);
                if ( row.child.isShown() )
                {   // This row is already open - close it
                    row.child.hide();
                    tr.removeClass('shown');
                    $(this).find('i').toggleClass('fa fa-minus-circle fa fa-plus-circle');
                    $(this).find('i').css("color", "green");
                }
                else
                {   $(this).find('i').toggleClass('fa fa-minus-circle fa fa-plus-circle');
                    $(this).find('i').css("color", "red");
                    var ref_interna = [];
                    ref_interna = row.data();
                    if( ref_interna )
                    {   $('#modal_wait').modal("show");
                        var data = new FormData();
                        data.append('event', 'carga_detalle_deudas_info');
                        data.append('deud_codigo', ref_interna[1]);    
                        var xhr = new XMLHttpRequest();
                        xhr.open('POST', document.getElementById('ruta_html_finan').value + '/descuentofacturas/controller.php', true);
                        xhr.onreadystatechange=function()
                        {   if ( xhr.readyState === 4 && xhr.status === 200 )
                            {   // Open this row
                                row.child(xhr.responseText).show();
                                tr.addClass('shown');
                                var table_deuda = $('#detalle_deuda_'+ref_interna[1]).DataTable({
                                    language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'},
                                    "lengthChange": false,
                                    searching: false,
                                    paging:false,
                                    info:false,
                                    "order":[[4, 'asc']],
                                    "columnDefs": [
                                        {className: "dt-body-left"  , "targets": [0]},
                                        {className: "dt-body-right" , "targets": [1]},
                                        {className: "dt-body-right" , "targets": [2]},
                                        {className: "dt-body-right" , "targets": [3]},
                                        {className: "dt-body-right" , "targets": [4]},
                                        {className: "dt-body-right" , "targets": [5]},
                                        {className: "dt-body-right" , "targets": [6]}
                                    ],
                                    "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                                        $('td', nRow).css('background-color', '#d6f9da');
                                    }
                                });
                                $('#modal_wait').modal("hide");
                            }
                        };
                        xhr.send(data);
                    }
                }
            });
            // ==================================================
            // Actualiza el total de las deudas pendientes
            var subtotal = 0;
            $('#deudasPendiente_table tbody tr').each(function(){
                subtotal += parseFloat($(this).find('td').eq(8).text());
            });
            $('#totalDeudasPendientes').val(subtotal.toFixed(2));
            justificaMensajeNoData($('#deudasPendiente_table')); 
            // ==================================================
            // Limpia la tabla de las deudas seleccionadas
            $('#deudasSeleccionadas_table tbody tr').each(function(){
                if($(this).find('td').eq(0).hasClass('dataTables_empty') !== true){
                    $(this).remove();    
                }
            });
            justificaMensajeNoData($('#deudasSeleccionadas_table')); // Agrego el div que coloca el datatable donde dice: "No data available in table"
        }
    };
    xhr.send(data);
}
// Verifico si en la grilla de las deudas seleccionadas para cobro ya existe una que seleccioné arriba.
function js_descuentofactura_deudaAgregadaParaCobro(codigoDeuda){
    var existe = false;
    $('#deudasSeleccionadas_table tbody tr').each(function(){
        if( $(this).find('td').eq(0).data('codigo') == codigoDeuda  ){
            existe = true;
        }
    });

    return existe;
}

function validaHabilitacionMontosAbono(){
    var totalPagosAgregados =0;
    $('#pagos_table tbody tr').each(function(){
        if(!$(this).find('td').eq(0).attr('class')){
            totalPagosAgregados += 1;
        }
    });

    if(totalPagosAgregados > 0){
        $('.txtAbonoDeuda').prop('disabled', null);
    }else{
        $('.txtAbonoDeuda').prop('disabled', 'true');
    }
}

function actualizaTotalDeudasSeleccionadas(){
    var pendiente = 0, abonado = 0;
     $('#deudasSeleccionadas_table tbody tr').each(function(){
         if(!$(this).find('td').eq(0).attr('class')){ 
             pendiente += parseFloat($(this).find('td').eq(1).text());
             abonado += (!$(this).find('td').eq(2).find('input').val()? 0 : parseFloat($(this).find('td').eq(2).find('input').val()));
         }
     });
    var total = parseFloat(pendiente - abonado);
     $('#totalDeudasSeleccionadas').val( total.toFixed(2));    
}
// Valida que no se desborden los abonos asignados por el usuario deacuerdo a los pagos ingresados por el mismo
function validaDesbordamientoAbono (e, field, totalPagos, max_value)
{   var maximo=0;
    if(max_value>totalPagos)
    {   maximo=parseFloat(totalPagos);
    }
    else
    {   maximo=parseFloat(max_value);
    }
    //var valor = field.value;
    var valor_actual = field.value+String.fromCharCode(e.which);
    var valor_actual_real = parseFloat(valor_actual)*10;
    if( parseFloat(valor_actual_real) > parseFloat( maximo ) )
    {   $.growl.error({ title: "Educalinks informa", message: "Valor excedido, ingreso un monto menor o igual a la deuda" });
        field.value='';
        return false;
    }
}
// Quita una deuda de la grilla lista a cobrar 
function quitarDeuda(codigoDeuda)
{   $('#deudasSeleccionadas_table tbody tr').each(function(){
        if( $(this).find('td').eq(0).data('codigo') == codigoDeuda )
        {   $(this).remove();
        }
    });
    justificaMensajeNoData($('#deudasSeleccionadas_table')); // Agrego el div que coloca el datatable donde dice: "No data available in table"

    actualizaTotalDeudasSeleccionadas();

    setearMontosAsignados();
}

function randomString() {
    var chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz";
    var string_length = 8;
    var randomstring = '';
    for (var i=0; i<string_length; i++) {
        var rnum = Math.floor(Math.random() * chars.length);
        randomstring += chars.substring(rnum,rnum+1);
    }
    //document.randform.randomfield.value = randomstring;
    return randomstring;
}
function actualizaTotalPagosAgregados(){
    var abonado = 0;
     $('#pagos_table tbody tr').each(function(){
         if(!$(this).find('td').eq(0).attr('class')){ 
             abonado += parseFloat($(this).find('td').eq(1).text());
         }
     });
     $('#totalPagos').val(abonado.toFixed(2));    
}


function setearMontosAsignados(){
    $('#deudasSeleccionadas_table tbody tr').each(function(){
        $(this).find('td').eq(2).find('input').val("");
    });
}

function justificaMensajeNoData(tabla){
    if( tabla.find('tbody').find('tr').length <= 0 ){
        tabla.find('tbody').append("<tr class='odd'><td class='datatTables_empty' valign='top' colspan='8' style='text-align: center;' >Ningún dato disponible en esta tabla</td></tr>");    
    }    
}


function cargaFormularioEditarPago(url, idPago)
{   document.getElementById('modal_editarPago_body').innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var data = new FormData();
    data.append('event', 'editarPago');
    data.append('idPago', idPago);
    $('#pagos_table tbody tr').each(function()
    {   if($(this).find('td').eq(0).attr('data-id') == idPago)
        {   data.append('metadato', $(this).find('td').eq(0).attr('data-meta'));
        }
    });

    var xhr = new XMLHttpRequest();
    xhr.open('POST', url , true);
    xhr.onreadystatechange=function()
    {   if ( xhr.readyState === 4 && xhr.status === 200 )
        {   document.getElementById('modal_editarPago_body').innerHTML=xhr.responseText;
            $(function() {$('#monto').maskMoney({thousands:'', decimal:'.', allowZero:false});});
        }
    };
    xhr.send(data);
}
function limpiaPagina(albedrio)
{   var confirmacion = true;
    if(albedrio)
    {   confirmacion = confirm("¿Está seguro de eliminar todo y empezar nuevamente?");
    }
    if( confirmacion )
    {   $('#deudasSeleccionadas_table tbody tr').each(function(){
            $(this).remove();
        });
        justificaMensajeNoData($('#deudasSeleccionadas_table')); // Agrego el div que coloca el datatable donde dice: "No data available in table"
        actualizaTotalDeudasSeleccionadas();

        $('#pagos_table tbody tr').each(function(){
            $(this).remove();
        });
        justificaMensajeNoData($('#pagos_table'));
        actualizaTotalPagosAgregados();

        justificaMensajeNoData($('#deudasPendiente_table'));
    }
}
function limpiaPaginanoq(albedrio)
{   $('#deudasSeleccionadas_table tbody tr').each(function(){
        $(this).remove();
    });
    justificaMensajeNoData($('#deudasSeleccionadas_table')); // Agrego el div que coloca el datatable donde dice: "No data available in table"
    actualizaTotalDeudasSeleccionadas();

    $('#pagos_table tbody tr').each(function(){
        $(this).remove();
    });
    justificaMensajeNoData($('#pagos_table'));
    actualizaTotalPagosAgregados();

    justificaMensajeNoData($('#deudasPendiente_table'));
}

function mostrarDetalleDeuda(codigoDeuda, div, url)
{   document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var data = new FormData();
    data.append('event', 'detalleDeuda');    
    data.append('codigoDeuda', codigoDeuda);    
    var xhr = new XMLHttpRequest();
    xhr.open('POST', url , true);
    xhr.onreadystatechange=function(){
        if (xhr.readyState==4 && xhr.status==200){
            document.getElementById(div).innerHTML=xhr.responseText;
            $('#deudasTable').DataTable({
                "info": false,
                "ordering": false,
                "searching":false,
                "lengthChange":false,
                "paging":false,
                "responsive":true
            });
        } 
    };
    xhr.send(data);
}
function mostrarPagosDeuda(codigoDeuda, div, url)
{   document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var data = new FormData();
    data.append('event', 'detallePagosDeuda');    
    data.append('codigoDeuda', codigoDeuda);    
    var xhr = new XMLHttpRequest();
    xhr.open('POST', url , true);
    xhr.onreadystatechange=function(){
        if (xhr.readyState==4 && xhr.status==200){
            document.getElementById(div).innerHTML=xhr.responseText;
            $('#pagosDetalleTable').DataTable({
                "info": false,
                "ordering": false,
                "searching":false,
                "lengthChange":false,
                "paging":false,
                "responsive":true
            });
        } 
    };
    xhr.send(data);
}
// Carga el combo de las manzanas
function js_descuentofactura_carga_porcentaje( valor, div, url )
{   var data = new FormData();
    var v_readonly = 0;
    if ( document.getElementById("porcentaje_descto").getAttribute("readonly") == "readonly" )
        v_readonly = 0;
    else
        v_readonly = 1;
    
    document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    
    data.append('desc_codigo', valor );
    data.append('readonly', v_readonly );
    data.append('event', 'get_porcentaje');
    var xhr = new XMLHttpRequest();
    xhr.open('POST', url , true);
    xhr.onreadystatechange=function(){
        if (xhr.readyState==4 && xhr.status==200){
            document.getElementById(div).innerHTML =xhr.responseText;
            $("#porcentaje_descto").numeric({ decimal : ".",  negative : false, scale: 2 });
            $('[data-toggle="popover"]').popover({html:true});
            $("#diasvalidez").numeric({ decimal : false,  negative : false, precision: 3 });
        } 
    };
    xhr.send(data);
}
function js_descuentofacturas_agregar_descuento()
{   v_previsualizado = 0;
	var codigo_descto     = document.getElementById("codigo_descto").value;
    var porcentaje_descto = document.getElementById("porcentaje_descto").value;
    var diasvalidez       = document.getElementById("diasvalidez").value;
    var ckb_prontopago    = document.getElementById("ckb_prontopago").checked;
    var descripcion       = $('#codigo_descto').find('option:selected').text();
    var style             = "style='text-align:center;'";
    var existe            = 0;
    var nuevaLinea        = "<tr>";
	var i = 1;
	
	$('#tabla_descuentos_cliente tbody tr').each(function(){
		i++;
	});
	
    if ( codigo_descto != -1 )
    {   if(porcentaje_descto <= 100 && porcentaje_descto > 0)
        {   $('#tabla_descuentos_cliente tbody tr').each(function(){
                if( $(this).find('td').eq(0).attr('data-codigo') == codigo_descto )
                {   existe = 1;
                }
            });
            if ( existe === 0 ) 
            {   nuevaLinea +="<td " + style + " data-codigo='" + codigo_descto + "' data-estado='active'>" + descripcion + "</td>";
                
                nuevaLinea +="<td " + style + "><input class='form-control input-sm' type='text' id='txt_desc_per_"+ i + "' name='txt_desc_per_"+ i + "' ";
                nuevaLinea +=" value='" + porcentaje_descto + "'></td>";
                
                nuevaLinea +="<td " + style + "><input class='form-control input-sm' type='text' id='txt_desc_dias_"+ i + "' name='txt_desc_dias_"+ i + "' ";
                nuevaLinea +=" value='" + diasvalidez + "'></td>";
                
                nuevaLinea +="<td " + style + "><input type='checkbox' id='ckb_dapp_" + i + "' name='ckb_dapp_" + i + "' ";
                nuevaLinea += ( ( ckb_prontopago === false ) ? '' : 'checked' ) + "></td>";
                
                nuevaLinea +="<td " + style + ">";
                nuevaLinea +="<span onclick='js_descuentofactura_del_descuento_asignado(\""+ codigo_descto + "\")'";
                nuevaLinea +=" class='btn_opc_lista_eliminar fa fa-times-circle-o cursorlink' ";
                nuevaLinea +=" aria-hidden='true' onmouseover='$(this).tooltip(\"show\")' title='Eliminar' data-placement='left'></span></td>";
                nuevaLinea += "</tr>";

                $('#tabla_descuentos_cliente tbody').append(nuevaLinea);
                $("#txt_desc_per_" + i ).numeric({ decimal : ".",  negative : false, scale: 2 });
                $("#txt_desc_dias_" + i ).numeric({ decimal : false,  negative : false, precision: 3 });
                
                $("#modal_addDiscount").modal("hide");
            }
            else
            {   $.growl.warning({ title: "Educalinks informa", message: "Descuento ya se encuentra en la tabla." });
            }
        }
        else
        {   $.growl.warning({ title: "Educalinks informa", message: "Porcentaje debe estar entre 1% y 100%." });
        }
    }
    else
    {   $.growl.warning({ title: "Educalinks informa", message: "Seleccione un descuento para continuar." });
    }
}
function js_descuentofacturas_get_deudaXML_format (  )
{   var factura = {
        cabecera : {
            codigoDeuda      : '',
            md               : '',
            codigoCliente    : '',
            tipoPersona      : '',
            fechaInicio_cobro: '',
            fechaVencimiento : '',
            dias_prontopago  : '',
            generaFactura    : '',
			sucursal		 : '',
			puntoVenta		 : '',
			numeroFactura	 : ''
			
        },
        detalle:   [],
        descuento: []
    };
    
    // ======================================================
    // => DETALLE FACTURA
    // ======================================================
    var v_detaFac_sec = 0;
    
    $('#tabla_detalleFactura_config tbody tr').each(function(){
        
        v_detaFac_sec = $(this).find('td').eq(0).text();

        factura.detalle.push({
            detaFact_sec   : v_detaFac_sec,
            codigoProducto : $(this).find('td').eq(1).attr('data-codigo'),
            aplica_pp      : ( ( document.getElementById("ckb_pp_"  + v_detaFac_sec ).checked) ? 1 : 0 ),
            aplica_dscto   : ( ( document.getElementById("ckb_des_" + v_detaFac_sec ).checked) ? 1 : 0 ),
            rep_liquidez   : ( ( document.getElementById("ckb_liq_" + v_detaFac_sec ).checked) ? 1 : 0 ),
            aplica_IVA     : ( ( document.getElementById("ckb_aIVA_"+ v_detaFac_sec ).checked) ? 1 : 0 ),
            aplica_ICE     : ( ( document.getElementById("ckb_aICE_"+ v_detaFac_sec ).checked) ? 1 : 0 ),
            per_IVA        : document.getElementById("txt_per_IVA_" + v_detaFac_sec ).value,
            per_ICE        : document.getElementById("txt_per_ICE_" + v_detaFac_sec ).value
        });
    });
    
    // ======================================================
    // => DESCUENTOS ASIGNADOS
    // ======================================================
    var v_codigo_descto = 0;
    var total_per = 0;
	var i = 1;
    $('#tabla_descuentos_cliente tbody tr').each(function(){
        v_codigo_descto = $(this).find('td').eq(0).attr('data-codigo');
        if( $(this).find('td').eq(0).attr('data-estado') == 'active' )
        {   factura.descuento.push({
                codigo_descto : v_codigo_descto,
                percent       : document.getElementById("txt_desc_per_" + i ).value,
                diasvalidez   : document.getElementById("txt_desc_dias_"+ i ).value,
				aplica_pp     : ( ( document.getElementById("ckb_dapp_" + i ).checked) ? 1 : 0 )
            });
            total_per = total_per + parseInt(document.getElementById("txt_desc_per_" + i ).value);
        }
		i++;
    });
    
    factura.cabecera.codigoDeuda         = $('#txt_desc_deuda').val();
    factura.cabecera.md                  = document.getElementById( 'cmb_tipo_descuento' ).value;
    factura.cabecera.codigoCliente       = $('#codigoCliente').val();
    factura.cabecera.tipoPersona         = $('#hd_tipo_persona').val();
    factura.cabecera.fechaInicio_cobro   = $('#fechaInicio_add').val();
    factura.cabecera.fechaVencimiento    = $('#fechaFin_add').val();
    factura.cabecera.dias_prontopago     = $('#dias_prontopago').val();
    
    if ( document.getElementById('check_generar_FAC').checked )
    {   factura.cabecera.generaFactura = '1';
        factura.cabecera.sucursal = $('#txt_num_sucursal').val();
		factura.cabecera.ptoVenta = $('#txt_num_ptoVenta').val();
		factura.cabecera.puntVent_codigo = $('#txt_num_ptoVenta').data('puntvent_codigo');
		factura.cabecera.numeroFactura = $('#txt_num_factura').val();
    }
    else
    {   factura.cabecera.generaFactura = '0';
		factura.cabecera.sucursal = '0';
		factura.cabecera.ptoVenta = '0';
		factura.cabecera.puntVent_codigo = '0';
        factura.cabecera.numeroFactura = '0';
    }
    if ( total_per > 100 )
        return false
    else
        return factura;
}
function js_descuentofacturas_previsualizar (  )
{   var deuda_xml = js_descuentofacturas_get_deudaXML_format();
	if ( deuda_xml === false )
             $.growl.warning({ title: "Educalinks informa", message: "Porcentajes de descuento superan el 100%." });
	else
    {   var fecha = document.getElementById( "txt_como_si_fuera" ).value;
		if ( !fecha )
		{   $.growl.warning({ title: "Educalinks informa", message: "Debe seleccionar una fecha para visualizar los valores." });
		}
        else
        {   document.getElementById( "div_previsualizacion" ).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i><br>Por favor, espere...</div>';
            var data = new FormData();
            data.append('event', 'get_previsualizacion');
            data.append('deuda_xml', JSON.stringify( deuda_xml ) );
            data.append('como_si_fuera', $('#txt_como_si_fuera').val() );
            var xhr = new XMLHttpRequest();
            xhr.open('POST', document.getElementById('ruta_html_finan').value + '/descuentofacturas/controller.php', true);
            xhr.onreadystatechange=function()
            {   if (xhr.readyState === 4 && xhr.status === 200 )
                {   if ( xhr.responseText.length > 0 )
                    {   json_response = JSON.parse(xhr.responseText);
                        valida_tipo_growl( json_response['mensaje'] );
                        document.getElementById( 'div_previsualizacion' ).innerHTML = json_response['tbl_previsualizacion'];
						v_previsualizado = 1;
                    }
                    else
                        $.growl.error({ title: "Educalinks informa", message: "No se pudo hacer conexión con el servidor" });
                }
            };
            xhr.send(data);
        }
    }
}
function js_descuentofactura_save(  )
{   $( '#modal_save_changes' ).modal('show');
	var nota = "";
	var subtotal = 0;
	
	if ( v_previsualizado === 1 )
	{   $('#tbl_previsualizacion tbody tr').each(function(){
			subtotal += parseFloat($(this).find('td').eq(8).text()); //siempre debería ser una fila.
		});
		
		if ( subtotal === 0 )
		{   nota = 
			'<div class="row">'+
				'<div class="col-md-12">'+
					'<div class="alert alert-warning">'+
						'<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'+
						'<h4><i class="icon fa fa-warning"></i> Nota!</h4>'+
						'Si la deuda, tiene un valor total pendiente de cero ($0), pasará a estado PAGADO automáticamente, sin forma de pago y sin factura autorizada.'+
					'</div>'
				'</div>'+
			'</div>'+
			'<br>';
		}	
		
		document.getElementById( 'modal_save_changes_body' ).innerHTML = 
		'<div class="row">'+
			'<div class="col-md-12">¿Está seguro de realizar cambios de configuración sobre esta deuda? Puede seguir modificando la configuración mientras que la deuda permanezca en estado "Por Cobrar".</div>'+
		'</div>'+
		'<br>'+
		nota +
		'<div class="row">'+
			'<div class="col-md-6" style="text-align:center">'+
				'<button class="btn btn-info" id="btn_modal_save_changes_followed" name="btn_modal_save_changes_followed" onclick="js_descuentofactura_save_followed(  );" >'+
					'<li class="fa fa-save"></li>&nbsp;Guardar cambios</button>'+
			'</div>'+
			'<div class="col-md-6" style="text-align:center">'+
				'<button class="btn btn-default" id="btn_modal_save_changes_dismiss" name="btn_modal_save_changes_dismiss" data-dismiss="modal">'+
					'<li style="color:red;" class="fa fa-ban"></li>&nbsp;Cancelar</button>'+
			'</div>'+
		'</div>';
	}
    else
	{   document.getElementById( 'modal_save_changes_body' ).innerHTML = 
		'<div class="row">'+
			'<div class="col-md-12">Por favor, previsualizar los cambios antes de guardar.</div>'+
		'</div>'+
		'<br>'+
		'<div class="row">'+
			'<div class="col-md-6" style="text-align:center">'+
				'<button class="btn btn-info" id="btn_modal_save_changes_followed" name="btn_modal_save_changes_followed" disabled="disabled" >'+
					'<li class="fa fa-save"></li>&nbsp;Guardar cambios</button>'+
			'</div>'+
			'<div class="col-md-6" style="text-align:center">'+
				'<button class="btn btn-default" id="btn_modal_save_changes_dismiss" name="btn_modal_save_changes_dismiss" data-dismiss="modal">'+
					'<li style="color:red;" class="fa fa-ban"></li>&nbsp;Cancelar</button>'+
			'</div>'+
		'</div>';
	}
}
function js_descuentofactura_save_followed(  )
{   var deuda_xml = js_descuentofacturas_get_deudaXML_format();
    if ( deuda_xml === false )
        $.growl.warning({ title: "Educalinks informa", message: "Porcentajes de descuento superan el 100%." });
    else
    {   if (js_general_compare_dates( document.getElementById('fechaInicio_add').value, document.getElementById('fechaFin_add').value ) == 'OK' )
		{   document.getElementById( 'modal_save_changes_body' ).innerHTML = '<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i><br>Por favor, espere<br><br><br></div>';
			var data = new FormData();
			data.append('event', 'set_changes');
			data.append('deuda_xml', JSON.stringify( deuda_xml ) );
			var xhr = new XMLHttpRequest();
			xhr.open('POST', document.getElementById('ruta_html_finan').value + '/descuentofacturas/controller.php', true);
			xhr.onreadystatechange=function()
			{   if (xhr.readyState === 4 && xhr.status === 200 )
				{   var resultado = js_general_resultado_sql(xhr.responseText);
					var class_callout = "";
					if( resultado === 'exito' ) class_callout = 'success';
					else if( resultado === 'error' ) class_callout = 'danger';
					else if( resultado === 'advertencia' ) class_callout = 'warning';
					else class_callout = 'info';
					
					var subtotal = 0;
					var btn_continuar = "";
					$('#tbl_previsualizacion tbody tr').each(function(){
						subtotal += parseFloat($(this).find('td').eq(8).text()); //siempre debería ser una fila.
					});
					
					if ( subtotal === 0 )
					{   btn_continuar = ' disabled = "disabled" ';
					}	
						
					var mensaje = '<div class="callout callout-' + class_callout + '">'
								+    '<h4><strong><li class="fa fa-exclamation"></li>Educalinks informa sobre cambio de configuración de deuda(s)</strong></h4>'
								+    xhr.responseText 
								+ '</div>'
								+ '<div class="row">'+
									'<div class="col-md-6" style="text-align:center">'+
										'<button class="btn btn-info"  data-dismiss="modal" onclick="'+
											'js_descuentofactura_busca(\'resultado\',\'' + document.getElementById( "ruta_html_finan" ).value + 
											'/descuentofacturas/controller.php\');"><i class="fa fa-list-alt"></i>&nbsp;Volver a bandeja de deudas</button>'+
									'</div>'+
									'<div class="col-md-6" style="text-align:center">'+
										'<button class="btn btn-success" ' + btn_continuar + ' data-dismiss="modal">Continuar modificando</button>'+
									'</div>'+
								'</div>';
					document.getElementById( 'modal_save_changes_body' ).innerHTML = mensaje;
				}
			};
			xhr.send(data);
		}
		else
		{   $.growl.warning({ title: "Educalinks informa", message: "Fecha de inicio no puede ser mayor que la fecha de fin." });
		}
    }
}
function js_facturas_check_generar_FAC ()
{   if(document.getElementById('check_generar_FAC').checked)
    {   document.getElementById('txt_num_sucursal').disabled = false;
		document.getElementById('txt_num_ptoVenta').disabled = false;
		document.getElementById('txt_num_factura').disabled = false;
		
		$('#txt_num_sucursal').css('background-color', 'white').css('cursor', 'pointer');
		$('#txt_num_ptoVenta').css('background-color', 'white').css('cursor', 'pointer');
		$('#txt_num_factura').css('background-color', 'white').css('cursor', 'pointer');
    }
    else
    {   document.getElementById('txt_num_sucursal').disabled = true;
		document.getElementById('txt_num_ptoVenta').disabled = true;
		document.getElementById('txt_num_factura').disabled = true;
		
		$('#txt_num_sucursal').css('background-color', '#eee').css('cursor', 'default');
		$('#txt_num_ptoVenta').css('background-color', '#eee').css('cursor', 'default');
		$('#txt_num_factura').css('background-color', '#eee').css('cursor', 'default');
    }
}
function js_descuentofactura_check_pvfalse ()
{	v_previsualizado = 0;
}
function js_descuentofactura_select_sucursal()
{   $('#modal_select_sucursal').modal("show");
}
function js_descuentofactura_select_ptoVenta()
{   if( $('#txt_num_sucursal').val() != '' )
	{	var data = new FormData();
		data.append('event', 'get_ptoventas');
		data.append('sucursal', $('#txt_num_sucursal').data("sucu_codigo") );
		var xhr = new XMLHttpRequest();
		xhr.open('POST', document.getElementById('ruta_html_finan').value + '/descuentofacturas/controller.php', true);
		xhr.onreadystatechange=function()
		{   if (xhr.readyState === 4 && xhr.status === 200 )
			{   var boton = '<span class="input-group-btn">'+
								'<button type="button" class="btn btn-info btn-flat" onclick="js_descuentofactura_select_ptoVenta_followed();">Seleccionar</button>'+
							'</span>';
				document.getElementById("div_cmb_ptoVenta").innerHTML = xhr.responseText + boton;
				$('#modal_select_ptoVenta').modal("show");
			}
		};
		xhr.send(data);
	}
	else
		$.growl.error({ title: "Educalinks informa", message: "Seleccione primero ununa sucursal" });
}
function js_descuentofactura_select_numeroFactura()
{   if( $('#txt_num_ptoVenta').val() != '' )
	{	var data = new FormData();
		data.append('event', 'get_numerosfacturas');
		data.append('puntoVenta', $('#txt_num_ptoVenta').data("puntvent_codigo") );
		var xhr = new XMLHttpRequest();
		xhr.open('POST', document.getElementById('ruta_html_finan').value + '/descuentofacturas/controller.php', true);
		xhr.onreadystatechange=function()
		{   if (xhr.readyState === 4 && xhr.status === 200 )
			{   var boton = '<span class="input-group-btn">'+
								'<button type="button" class="btn btn-info btn-flat" onclick="js_descuentofactura_select_numeroFactura_followed();">Seleccionar</button>'+
							'</span>';
				document.getElementById("div_cmb_numeroFactura").innerHTML = xhr.responseText + boton;
				$('#modal_select_numeroFactura').modal("show");
			}
		};
		xhr.send(data);
	}
	else
		$.growl.error({ title: "Educalinks informa", message: "Seleccione primero un punto de venta" });
}
function js_descuentofactura_select_sucursal_followed()
{   $('#modal_select_sucursal').modal("hide");
	document.getElementById('txt_num_sucursal').value = document.getElementById('pto_sucursal').value;
	$('#txt_num_sucursal').data("sucu_codigo", $('#pto_sucursal').find(':selected').data("sucu_codigo") );
}
function js_descuentofactura_select_ptoVenta_followed()
{   $('#modal_select_ptoVenta').modal("hide");
	document.getElementById('txt_num_ptoVenta').value = document.getElementById('cmb_ptoVenta').value;
	$('#txt_num_ptoVenta').data("puntvent_codigo", $('#cmb_ptoVenta').find(':selected').data("puntvent_codigo") );
}
function js_descuentofactura_select_numeroFactura_followed()
{   $('#modal_select_numeroFactura').modal("hide");
	document.getElementById('txt_num_factura').value = document.getElementById('cmb_numeroFactura').value;
}