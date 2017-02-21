$(document).ready(function() {
    actualiza_badge_gest_fact();
    $("#txt_fecha_ini").datepicker();
    $("#txt_fecha_fin").datepicker();
	$("#txt_fecha_deuda_ini").datepicker();
    $("#txt_fecha_deuda_fin").datepicker();
	$("#cmb_producto").select2();
	$("#txt_tneto_ini").numeric({ decimal : ".",  negative : false, scale: 2, precision: 8 });
	$("#txt_tneto_fin").numeric({ decimal : ".",  negative : false, scale: 2, precision: 8 });
	$("#boton_busqueda").click(function(){
		$("#desplegable_busqueda").slideToggle(200);
	});
});
function tipoDocumentoAutorizado_onChange(obj)
{   var v_select = obj.value;
	if (v_select == 'ND')
	{   document.getElementById("cmb_producto").disabled = true;
		document.getElementById("cmb_producto").value = '-1';
	}
	else
	{   document.getElementById("cmb_producto").disabled = false;
	}
	if (v_select == 'FAC')
	{   document.getElementById("cmb_estado").innerHTML = "<select class='form-control' id='cmb_estado' name='cmb_estado'>"+
							"<option value=''>Seleccione...</option>"+
							"<option value='P' selected='selected'>Pagado</option>"+
							"<option value='PC'>Por cobrar</option>"+
							"<option value='PV'>Por validar</option>"+
							"<option value='A'>Anulado</option>"+
						"</select>";
		document.getElementById("span_fecha_filtro_main").innerHTML = 'F. Pago';
	}
	else
	{   document.getElementById("span_fecha_filtro_main").innerHTML = 'F. emisión';
		document.getElementById("cmb_estado").innerHTML = "<select class='form-control' id='cmb_estado' name='cmb_estado'>"+
							"<option value=''>Seleccione...</option>"+
							"<option value='A' selected='selected'>Activo</option>"+
							"<option value='I'>Inactivo</option>";
						"</select>";
	}
}
function js_verDocumentoAutorizado_to_excel_tipoDocumentoAutorizado( evento, tipo_reporte )
{   document.getElementById( 'evento' ).value = evento;
    document.getElementById( 'tipo_reporte' ).value = tipo_reporte;
	document.getElementById( 'file_form' ).submit();
}
function carga_tipoDocumentoAutorizado(div)
{   document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var tipoDocumentoAutorizado = document.getElementById('tipoDocumentoAutorizado').value;
    var fechavenc_ini = document.getElementById("txt_fecha_ini").value;
    var fechavenc_fin = document.getElementById("txt_fecha_fin").value;
    var data = new FormData();
    data.append('event', 'get_all_data');
    data.append('tipoDocumentoAutorizado', tipoDocumentoAutorizado);
    data.append('fechavenc_ini', fechavenc_ini);
    data.append('fechavenc_fin', fechavenc_fin);
    var ckb_opc_adv = document.getElementById("ckb_opc_adv").checked;
	data.append('ckb_opc_adv', ckb_opc_adv);
    if(ckb_opc_adv)
    {   data.append('estadoElectronico', document.getElementById("cmb_estadoElectronico").value);
		data.append('id_titular', document.getElementById("txt_id_titular").value);
        data.append('cod_estudiante', document.getElementById("txt_cod_cliente").value);
        data.append('nombre_estudiante', document.getElementById("txt_nom_cliente").value);
        data.append('nombre_titular', document.getElementById("txt_nom_titular").value);
        data.append('ptvo_venta', document.getElementById("txt_ptoVenta").value);
        data.append('sucursal', document.getElementById("txt_sucursal").value);
        data.append('ref_factura', document.getElementById("txt_ref_factura").value);
        var productos = []; 
		$('#cmb_producto :selected').each(function(i, selected){ 
		  productos[i] = $(selected).val(); 
		});
        data.append('prod_codigo', JSON.stringify( productos ) );
		console.log(JSON.stringify( productos ));
        data.append('estado', document.getElementById("cmb_estado").value);
		var chk_tneto = document.getElementById("chk_tneto").checked;
		if(chk_tneto)
		{   data.append('tneto_ini', document.getElementById("txt_tneto_ini").value);
			data.append('tneto_fin', document.getElementById("txt_tneto_fin").value);
		}
		var chk_fechadeuda = document.getElementById("chk_fecha_deuda").checked;
		if(chk_fechadeuda)
		{   data.append('fechadeuda_ini', document.getElementById("txt_fecha_deuda_ini").value);
			data.append('fechadeuda_fin', document.getElementById("txt_fecha_deuda_fin").value);
		}
        data.append('periodo', document.getElementById("periodos").value);
        data.append('grupoEconomico', document.getElementById("cmb_grupoEconomico").value);
        data.append('nivelEconomico', document.getElementById("cmb_nivelesEconomicos").value);
        data.append('curso', document.getElementById("curso").value);
    }
    var xhr = new XMLHttpRequest();
    xhr.open('POST', document.getElementById('ruta_html_finan').value + '/verDocumentosAutorizados/controller.php' , true);
    xhr.onreadystatechange=function()
    {   if (xhr.readyState==4 && xhr.status==200)
        {   document.getElementById(div).innerHTML=xhr.responseText;
            $(".detalle").tooltip({
                'html':         true,
                'selector':     '',
                'placement':     'bottom',
                'container':     'body',
                'tooltipClass': 'detalleTooltip'
            });
            var table = $('#facturasPendiente_table').DataTable({
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
                    {className: "dt-body-center" , "targets": [1]},
                    {className: "dt-body-right"  , "targets": [2]},
                    {className: "dt-body-center" , "targets": [3]},
                    {className: "dt-body-center" , "targets": [4]},
                    {className: "dt-body-center" , "targets": [5]},
                    {className: "dt-body-center" , "targets": [6]},
                    {className: "dt-body-center" , "targets": [7]},
                    {className: "dt-body-center" , "targets": [8]},
                    {className: "dt-body-center" , "targets": [9]}
                ]
            });
			table.page.len(10).draw();
            table.column( '5:visible' ).order( 'desc' );
			$('#facturasPendiente_table tbody').on('click', 'td.details-control', function ()
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
					var facturaCliente = [];
					facturaCliente = row.data();
					cabefact_codigo  = facturaCliente[1];
					cabefact_codigo  = cabefact_codigo.replace('<div style="font-size:11px;">','');
					cabefact_codigo  = cabefact_codigo.replace('</div>','');
					if( facturaCliente )
					{   $("#modal_wait").modal('show');
						var data2 = new FormData();
						data2.append('event', 'get_payments');
						data2.append('num_factura', cabefact_codigo);
						data2.append('bandeja_factura', 'SI');
						var xhrII = new XMLHttpRequest();
						xhrII.open('POST',document.getElementById('ruta_html_finan').value+'/pagos/controller.php', true);
						xhrII.onreadystatechange=function()
						{   if ( xhrII.readyState === 4 && xhrII.status === 200 )
							{   // Open this row
								$("#modal_wait").modal('hide');
								row.child(xhrII.responseText).show();
								tr.addClass('shown');
								var table_deuda = $( '#pagosRealizados_table_' + cabefact_codigo ).DataTable({
									language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'},
									"lengthChange": false,
									searching: false,
									paging:false,
									info:false,
									"order":[[4, 'asc']],
									"columnDefs": [
										{className: "dt-body-center" , "targets": [0]},
										{className: "dt-body-center" , "targets": [1], "visible": false},
										{className: "dt-body-right"  , "targets": [2]},
										{className: "dt-body-right"  , "targets": [3]},
										{className: "dt-body-center" , "targets": [4], "visible": false},
										{className: "dt-body-center" , "targets": [5], "visible": false},
										{className: "dt-body-center" , "targets": [6], "visible": false},
										{className: "dt-body-center" , "targets": [7], "visible": false},
										{className: "dt-body-center" , "targets": [8]},
										{className: "dt-body-center" , "targets": [9]},
										{className: "dt-body-center" , "targets":[12], "visible": false}
									],
									"fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
										$('td', nRow).css('background-color', '#d6f9da');
									}
								});	
							}
						};
						xhrII.send(data2);
					}
				}
			});
        }
    };
    xhr.send(data);
}
function reenvio_factura( codigo, div, url )
{   document.getElementById('modal_resend_body').innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var tipoDocumentoAutorizado = document.getElementById('tipoDocumentoAutorizado').value;
    var data = new FormData();
    data.append('event', 'resend_to_sri');
    data.append('codigoDocumento', codigo);
	data.append('tipoDocumentoAutorizado', tipoDocumentoAutorizado);
    var xhr = new XMLHttpRequest();
    xhr.open('POST', url , true);
    xhr.onreadystatechange=function()
    {   if (xhr.readyState==4 && xhr.status==200)
        {   document.getElementById('modal_resend_body').innerHTML=xhr.responseText;
        }
    };
    xhr.send(data);
}
function check_opc_avanzadas()
{   var ckb_opc_adv = document.getElementById("ckb_opc_adv").checked;
    if(ckb_opc_adv)
    {   $("#div_opc_adv").collapse(200).collapse('show');
    }
    else
    {   $("#div_opc_adv").collapse(200).collapse('hide');
    }
}
function check_tneto()
{    var chk_tneto = document.getElementById("chk_tneto").checked;
    if(chk_tneto)
    {   document.getElementById("txt_tneto_ini").disabled = false;
        document.getElementById("txt_tneto_fin").disabled = false;
    }
    else
    {   document.getElementById("txt_tneto_ini").disabled = true;
        document.getElementById("txt_tneto_fin").disabled = true;
		document.getElementById("txt_tneto_ini").value = "";
        document.getElementById("txt_tneto_fin").value = "";
    }
}
function js_gestionFactura_check_fechadeuda()
{    var chk_tneto = document.getElementById("chk_fecha_deuda").checked;
    if(chk_tneto)
    {   document.getElementById("txt_fecha_deuda_ini").disabled = false;
        document.getElementById("txt_fecha_deuda_fin").disabled = false;
    }
    else
    {   document.getElementById("txt_fecha_deuda_ini").disabled = true;
        document.getElementById("txt_fecha_deuda_fin").disabled = true;
		document.getElementById("txt_fecha_deuda_ini").value = "";
        document.getElementById("txt_fecha_deuda_fin").value = "";
    }
}