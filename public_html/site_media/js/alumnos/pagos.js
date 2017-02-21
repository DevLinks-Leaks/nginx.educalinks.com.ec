$(document).ready(function(){
	var table = $("#tabla_estadoCuenta_paid").DataTable({
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
			{className: "dt-body-center" , "targets": [2]},
			{className: "dt-body-center" , "targets": [3]},
			{className: "dt-body-center" , "targets": [4]}
		]
	});
	table.page.len(10).draw();
	$('#tabla_estadoCuenta_paid tbody').on('click', 'td.details-control', function ()
	{   var tr = $(this).closest('tr');
		var row = table.row(tr);
		if ( row.child.isShown() )
		{   // This row is already open - close it
			row.child.hide();
			tr.removeClass('shown');
			//$(this).find('i').toggleClass('fa fa-minus-circle fa fa-plus-circle');
			//$(this).find('i').css("color", "green");
		}
		else
		{   //$(this).find('i').toggleClass('fa fa-minus-circle fa fa-plus-circle');
			//$(this).find('i').css("color", "red");
			var deudaCliente = [];
			deudaCliente = row.data();
			deud_codigo  = deudaCliente[0];
			deud_codigo  = deud_codigo.replace('<div style="font-size:x-small;">','');
			deud_codigo  = deud_codigo.replace('</div>','');
			if( deudaCliente )
			{   var data2 = new FormData();
				data2.append('event', 'get_payments');
				data2.append('deuda', deud_codigo);	
				var xhrII = new XMLHttpRequest();
				xhrII.open('POST',document.getElementById('ruta_html_finan').value+'/pagos/controller.php', true);
				xhrII.onreadystatechange=function()
				{   if ( xhrII.readyState === 4 && xhrII.status === 200 )
					{   // Open this row
						row.child(xhrII.responseText).show();
						tr.addClass('shown');
						var table_deuda = $( '#pagosRealizados_table_' + deud_codigo ).DataTable({
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
								{className: "dt-body-center" , "targets": [3]},
								{className: "dt-body-center" , "targets": [4], "visible": false},
								{className: "dt-body-center" , "targets": [5], "visible": false},
								{className: "dt-body-center" , "targets": [6], "visible": false},
								{className: "dt-body-center" , "targets": [7], "visible": false},
								{className: "dt-body-center" , "targets": [8], "visible": false},
								{className: "dt-body-center" , "targets": [9], "visible": false},
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
	$('#modal_CarouselPago').modal('show');
});
function js_menu_pagos()
{   var url = '../../alumnos/pagos/';
    var f = document.createElement('form');
    f.action = url;
    f.method = 'POST';
    var i = document.createElement( 'input' );
    i.type = 'hidden';
    i.name = 'event';
    i.id = 'evento';
    i.value = 'MAIN';
    f.appendChild(i);
    document.body.appendChild(f);
    f.submit();
}
function js_pagos_pagar( deud_codigo, url )
{   var url =  '../../alumnos/pagos/';
    js_pagos_submit( deud_codigo, url );
}
function js_pagos_select_all ( source )
{   checkboxes = document.getElementsByName('ckb_deud_codigo[]');
    for(var i = 0, n = checkboxes.length; i < n; i++ )
    {   checkboxes[i].checked = source.checked;
		if ( source.checked )
			document.getElementById( 'tr_row_' + i ).style.backgroundColor = '#ffc';
		else
			document.getElementById( 'tr_row_' + i ).style.backgroundColor = 'white';
    }
	if ( source.checked )
		document.getElementById('tr_row_head').style.backgroundColor = '#ffc';
	else
		document.getElementById('tr_row_head').style.backgroundColor = 'white';
	if ( source.checked )
		document.getElementById('btn_pagar_deudas').disabled = false;
	else
		document.getElementById('btn_pagar_deudas').disabled = true;
}
function js_pagos_val_btn ( btn_disable_override )
{   checkboxes = document.getElementsByName('ckb_deud_codigo[]');
	bandera = 0;
    for( var i = 0, n = checkboxes.length; i < n; i++ )
    {   if (checkboxes[i].checked )
			bandera++ ;
    }
	if ( bandera > 0 )
	{   document.getElementById('btn_pagar_deudas').disabled = false;
	}
	else
	{   document.getElementById('btn_pagar_deudas').disabled = true;
	}
	if ( btn_disable_override )
		document.getElementById('btn_pagar_deudas').disabled = true;
}
function js_pagos_select_check_ind ( source, num_linea )
{   document.getElementById('modal_resultadoPago_body').innerHTML = '<div align="center" style="height:100%;">Por favor, espere<br><br><i style="color:darkred;" class="fa fa-cog fa-spin"></i></div>';
	document.getElementById('modal_resultadoPago_header').innerHTML = '<strong>Botón de pagos</strong>';
	$('#modal_resultadoPago').modal('show');
	var marcar = 'si';
	checkboxes = document.getElementsByName('ckb_deud_codigo[]');
    for(var i = 0, n = checkboxes.length; i < n; i++ )
    {   if ( !checkboxes[i].checked )
		{	marcar = 'no';
		}
    }
	if ( source.checked )
		document.getElementById( 'tr_row_' + num_linea ).style.backgroundColor = '#ffc';
	else
		document.getElementById( 'tr_row_' + num_linea ).style.backgroundColor = 'white';
	
	if ( marcar === 'si' )
	{	document.getElementById('ckb_deud_codigo_head').checked = 'checked';
		document.getElementById('tr_row_head').style.backgroundColor = '#ffc';
	}
	else
	{	document.getElementById('ckb_deud_codigo_head').checked = false;
		document.getElementById('tr_row_head').style.backgroundColor = 'white';
	}
	var codigoDeuda = 0;
	codigoDeuda = js_pagos_siguiente_checked_get_codigoDeuda ( num_linea + 1 );
	if ( codigoDeuda !== 0 )
	{   js_pagos_validaFechaVencimiento( source, codigoDeuda, num_linea + 1, 1 );
	}	
	else
	{   codigoDeuda = js_pagos_obtiene_deudCodigo( num_linea );
		js_pagos_validaFechaVencimiento( source, codigoDeuda, num_linea, 0 );
	}
}
function js_pagos_validaFechaVencimiento( source, codigoDeuda, num_linea, siguiente )
{   var xhr = new XMLHttpRequest();
	xhr.onreadystatechange=function()
	{   if (xhr.readyState==4 && xhr.status==200)
		{   var arreglo = eval (xhr.responseText);
			var mensaje = "";
			var is_not_selected = false;
			var btn_disable_override = 0;
			if( arreglo.length > 0 )
			{   var ultimo_indice = arreglo.length-1;
				var plural = 0;
				for ( var i = 0; i < ( arreglo.length ); i++ )
				{   plural = plural + 1;
					
					//si alguno no está checkeado, marca como cierto que hay deudas vencidas que no están seleccionadas.
					if( !js_pagos_deudaAgregadaParaCobro( arreglo[i]['deud_codigo'] ) )
						is_not_selected = true;
				}
				if( plural > 1 )
				{	mensaje="Las siguientes deudas est&aacute;n pendientes de pago: <br><br>";
				}
				else
				{   mensaje="La siguiente deuda est&aacute; pendiente de pago: <br><br>";
				}
				for ( var i=0; i < ( arreglo.length ); i++ )
				{   mensaje += arreglo[i]['descripcionDeuda']+'. Total: $'+arreglo[i]['deud_totalPendiente']+'<br>';
				}
				if( plural > 1 )
				{	mensaje+="<br>Por favor, cancelar las deudas pendientes primero.";
				}
				else
				{   mensaje+="<br>Por favor, cancelar la deuda pendiente primero.";
				}
				if( is_not_selected  )
				{   document.getElementById('modal_resultadoPago_header').innerHTML="<strong>¡Deuda pendiente!</strong>";
					document.getElementById('modal_resultadoPago_body').innerHTML="<div class='alert alert-info'><strong>¡Informaci&oacute;n! </strong>"+mensaje+"</div>";
					$('#modal_resultadoPago').modal('show');
					
					/* //Descomentar para no dejar checar una deuda seleccionada que no es válida seleccionar.
					source.checked = false;
					if ( siguiente === 0 )
						document.getElementById( 'tr_row_' + num_linea ).style.backgroundColor = 'white';
					else
						document.getElementById( 'tr_row_' + String( num_linea - 1) ).style.backgroundColor = 'white';
					*/
					btn_disable_override = 1;
				}
				else
					$('#modal_resultadoPago').modal('hide');
			}
			else
			{   //seleccionarDeuda(codigo,div,url); // no hacer nada.
				$('#modal_resultadoPago').modal('hide');
			}
			js_pagos_val_btn ( btn_disable_override );
		}
	};
	var data = new FormData();
	data.append('event', 'trae_deudas_vencidas_anteriores');
	data.append('cabFact_codigo', codigoDeuda );
	xhr.open('POST', document.getElementById('ruta_html_alumnos').value + '/pagos/controller.php' , true);
	xhr.send(data);
}
function js_pagos_deudaAgregadaParaCobro( codigoDeuda )
{   var existe = false;
	$('#tabla_estadoCuenta tbody tr').each(function()
	{   //console.log('codigo: ' + $(this).find('td').eq(5).find('input:checkbox:first').attr( 'value' ));
		//console.log('checked: ' + $(this).find('td').eq(5).find('input:checkbox:first').is(':checked') );
		if( $(this).find('td').eq(5).find('input:checkbox:first').attr( 'value' ) == codigoDeuda  )
		{   if( $(this).find('td').eq(5).find('input:checkbox:first').is(':checked') )
			{   existe = true;
				//console.log( 'entra y cambia' + existe );
			}
		}
	});
	return existe;
	/* Busca fila por fila el checkbox con valor = codigoDeuda, 
	   y si está checkeado, lo marca como que existe.
	*/
}
function js_pagos_siguiente_checked_get_codigoDeuda( num_linea )
{   var codigoDeuda = 0;
	var aux = 0 ;
	$('#tabla_estadoCuenta tbody tr').each(function()
	{   if ( aux >= num_linea )
		{   if( $(this).find('td').eq(5).find('input:checkbox:first').is(':checked') )
			{	if ( codigoDeuda == 0 )
					codigoDeuda = $(this).find('td').eq(5).find('input:checkbox:first').attr( 'value' );
			}
		}
		aux = aux + 1; 
	});
	return codigoDeuda;
}
function js_pagos_obtiene_deudCodigo( num_linea )
{   var codigoDeuda = 0;
	var aux = 0 ;
	$('#tabla_estadoCuenta tbody tr').each(function()
	{   if ( aux === num_linea )
		{   if( $(this).find('td').eq(5).find('input:checkbox:first').is(':checked') )
				codigoDeuda = $(this).find('td').eq(5).find('input:checkbox:first').attr( 'value' );
		}
		aux = aux + 1;
	});
	return codigoDeuda;
}