// JavaScript Document
$(document).ready(function()
{   $('[data-toggle="popover"]').popover({html:true});
	$('#modal_balance').on('shown', function() {
       
    });
	/*$(".detalle").tooltip({
		'html':         true,
		'selector':     '',
		'placement':     'bottom',
		'container':     'body',
		'tooltipClass': 'detalleTooltip'
	});*/
	var table = $('#banc_table').addClass( 'nowrap' ).DataTable({
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
			{className: "dt-body-center" , "targets": [4]},
			{className: "dt-body-center" , "targets": [5]},
			{className: "dt-body-center" , "targets": [6]},
			{className: "dt-body-center" , "targets": [7],"visible":false},
			{className: "dt-body-center" , "targets": [8]}
		]
	});
	table.page.len(10).draw();
	table.column( '5:visible' ).order( 'desc' );
	$('#banc_table tbody').on('click', 'td.details-control', function ()
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
			var saldoaFavorCliente = [];
			saldoaFavorCliente = row.data();
			cabeSaf_codigo = saldoaFavorCliente[1];
			cabeSaf_codigo = cabeSaf_codigo.replace('<div style="font-size:11px;">','');
			cabeSaf_codigo = cabeSaf_codigo.replace('</div>','');
			if( saldoaFavorCliente )
			{   $("#modal_wait").modal('show');
				var data2 = new FormData();
				data2.append('event', 'get_safHistorico');
				data2.append('cabeSaf_codigo', cabeSaf_codigo);
				var xhrII = new XMLHttpRequest();
				xhrII.open('POST', document.getElementById('ruta_html_finan').value+'/saldoaFavor/controller.php', true);
				xhrII.onreadystatechange=function()
				{   if ( xhrII.readyState === 4 && xhrII.status === 200 )
					{   // Open this row
						$("#modal_wait").modal('hide');
						row.child(xhrII.responseText).show();
						tr.addClass('shown');
						var table_deuda = $( '#safHistorico_table_' + cabeSaf_codigo ).DataTable({
							language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'},
							"lengthChange": false,
							searching: false,
							paging:false,
							info:false,
							"order":[[0, 'asc']],
							"columnDefs": [
								{className: "dt-body-center" , "targets": [0]},
								{className: "dt-body-center" , "targets": [1]},
								{className: "dt-body-center" , "targets": [2], "visible": false},
								{className: "dt-body-right"  , "targets": [3]},
								{className: "dt-body-right"  , "targets": [4]},
								{className: "dt-body-right"  , "targets": [5]},
								{className: "dt-body-center" , "targets": [6]},
								{className: "dt-body-center" , "targets": [7]},
								{className: "dt-body-center" , "targets": [8]},
								{className: "dt-body-center" , "targets": [9], "visible": false}
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
})	
function js_saldoaFavor_busca( busq, div, url )
{   document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var data = new FormData();
	data.append('event', 'get_all_data');
	data.append('cuales', document.getElementById( 'cmb_mostrarSaf' ).value );
	data.append('busq', busq);	
	var xhr = new XMLHttpRequest();
	xhr.open('POST', url , true);
	xhr.onreadystatechange=function()
	{   if (xhr.readyState==4 && xhr.status==200)
		{	document.getElementById(div).innerHTML=xhr.responseText;
			var table = $('#banc_table').addClass( 'nowrap' ).DataTable({
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
					{className: "dt-body-center" , "targets": [4]},
					{className: "dt-body-center" , "targets": [5]},
					{className: "dt-body-center" , "targets": [6]},
					{className: "dt-body-center" , "targets": [7],"visible":false},
					{className: "dt-body-center" , "targets": [8]}
				]
			});
			table.page.len(10).draw();
			table.column( '5:visible' ).order( 'desc' );
			$('#banc_table tbody').on('click', 'td.details-control', function ()
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
					var saldoaFavorCliente = [];
					saldoaFavorCliente = row.data();
					cabeSaf_codigo = saldoaFavorCliente[1];
					cabeSaf_codigo = cabeSaf_codigo.replace('<div style="font-size:11px;">','');
					cabeSaf_codigo = cabeSaf_codigo.replace('</div>','');
					if( saldoaFavorCliente )
					{   $("#modal_wait").modal('show');
						var data2 = new FormData();
						data2.append('event', 'get_safHistorico');
						data2.append('cabeSaf_codigo', cabeSaf_codigo);
						var xhrII = new XMLHttpRequest();
						xhrII.open('POST',document.getElementById('ruta_html_finan').value+'/saldoaFavor/controller.php', true);
						xhrII.onreadystatechange=function()
						{   if ( xhrII.readyState === 4 && xhrII.status === 200 )
							{   // Open this row
								$("#modal_wait").modal('hide');
								row.child(xhrII.responseText).show();
								tr.addClass('shown');
								var table_deuda = $( '#safHistorico_table_' + cabeSaf_codigo ).DataTable({
									language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'},
									"lengthChange": false,
									searching: false,
									paging:false,
									info:false,
									"order":[[0, 'asc']],
									"columnDefs": [
										{className: "dt-body-center" , "targets": [0]},
										{className: "dt-body-center" , "targets": [1]},
										{className: "dt-body-center" , "targets": [2], "visible": false},
										{className: "dt-body-right"  , "targets": [3]},
										{className: "dt-body-right"  , "targets": [4]},
										{className: "dt-body-right"  , "targets": [5]},
										{className: "dt-body-center" , "targets": [6]},
										{className: "dt-body-center" , "targets": [7]},
										{className: "dt-body-center" , "targets": [8]},
										{className: "dt-body-center" , "targets": [9], "visible": false}
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
function js_saldoaFavor_change_reason()
{	document.getElementById( 'valor_balance' ).value = '0';
	if( document.getElementById( 'cmb_balance_reason' ).value =='mas' )
	{   document.getElementById( 'span_balance_reason' ).innerHTML = '$';
		document.getElementById( 'span_balance_mount_label' ).innerHTML = 'Monto a incrementar';
	}
	else
	{   document.getElementById( 'span_balance_reason' ).innerHTML = '$ ( - )';
		document.getElementById( 'span_balance_mount_label' ).innerHTML = 'Monto a devolver';
	}
}
/*
function js_saldoafavor_eliminar(codigo,div,url)
{   if(confirm("¿Está seguro que desea eliminar el saldo a favor?"))
	{   document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
		var data = new FormData();
		data.append('event', 'delete');
		data.append('banc_codigo', codigo);	
		var xhr = new XMLHttpRequest();
		xhr.open('POST', url , true);
		xhr.onreadystatechange=function()
		{   if (xhr.readyState==4 && xhr.status==200)
			{	document.getElementById(div).innerHTML=xhr.responseText;
				$('#banc_table').addClass( 'nowrap' ).DataTable({"language": {"url":spanish}});
			} 
		};
		xhr.send(data);
	}
}
function js_saldoafavor_devolver(codigo,div,url)
{   if(confirm("¿Marcar saldo a favor como 'devuelto' ahora?"))
	{   document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
		var data = new FormData();
		data.append('event', 'devolver');
		data.append('banc_codigo', codigo);	
		var xhr = new XMLHttpRequest();
		xhr.open('POST', url , true);
		xhr.onreadystatechange=function()
		{   if (xhr.readyState==4 && xhr.status==200)
			{	document.getElementById(div).innerHTML = xhr.responseText;
				$('#banc_table').addClass( 'nowrap' ).DataTable({"language": {"url":spanish}});
			} 
		};
		xhr.send(data);
	}
}*/
function edit( codigo, div, url )
{   document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var data = new FormData();
	data.append('event', 'get');
	data.append('banc_codigo', codigo);	
	var xhr = new XMLHttpRequest();
	xhr.open('POST', url , true);
	xhr.onreadystatechange=function()
	{   if (xhr.readyState==4 && xhr.status==200)
		{   document.getElementById(div).innerHTML=xhr.responseText;
		}
	};
	xhr.send(data);
}
/*function carga_add(div,url)
{   document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var data = new FormData();
	data.append('event', 'agregar');	
	var xhr = new XMLHttpRequest();
	xhr.open('POST', url , true);
	xhr.onreadystatechange=function()
	{   if (xhr.readyState==4 && xhr.status==200)
		{   document.getElementById(div).innerHTML=xhr.responseText;
		}
	};
	xhr.send(data);
}*/
function js_saldoaFavor_busca_clientes( filtro, div, url )
{   var spanish_in="//cdn.datatables.net/plug-ins/f2c75b7247b/i18n/Spanish.json";
	document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var data = new FormData();
	data.append('event', 'get_client');
	data.append('tipo_persona', document.getElementById('cmb_per_consulta_tipo_persona').value );
	if(filtro == 'nombres')
	{   data.append(filtro, document.getElementById('nombre_busq').value);	
	}
	else
	{   data.append(filtro, document.getElementById('numeroIdentificacion_busq').value);		
	}
		
	var xhr = new XMLHttpRequest();
	xhr.open('POST', url , true);
	xhr.onreadystatechange=function()
	{   if (xhr.readyState==4 && xhr.status==200)
		{   document.getElementById(div).innerHTML=xhr.responseText;
			var table = $('#clientes_table').DataTable({
	            "info": false,
	            "ordering": true,
	            "searching":false,
	            "lengthChange":false,
	            "paging":true,
			    "language": {
                    "url":spanish_in
                }
	        });
			table.page.len(5).draw();
			$('#clientes_table tbody').on( 'click', 'tr', function ()
			{   if ( $(this).hasClass('selected') )
				{   $(this).removeClass('selected');
				}
				else
				{   table.$('tr.selected').removeClass('selected');
					$(this).addClass('selected');
					var celda0 = $(this).children().eq(0);
					document.getElementById('codalum').value=$(celda0).text();
				}
			});
		}
	};
	xhr.send(data);
}
// Carga el formulario para buscar a un cliente especifico
function js_saldoaFavor_carga_busquedaCliente(url)
{   var spanish_in="//cdn.datatables.net/plug-ins/f2c75b7247b/i18n/Spanish.json";
	document.getElementById('modal_busquedaCliente_body').innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var data = new FormData();
	data.append('event', 'buscar_clientes');	
	data.append('tabla', 'clientes_table');
	var xhr = new XMLHttpRequest();
	xhr.open('POST', url , true);
	xhr.onreadystatechange=function()
	{   if (xhr.readyState==4 && xhr.status==200)
		{   document.getElementById('modal_busquedaCliente_body').innerHTML=xhr.responseText;
			
			$("#valor").numeric({ decimal : ".",  negative : false, scale: 2, precision: 18 });
			$('[data-toggle="popover"]').popover({html:true});
			
			var table = $('#clientes_table').DataTable({
	            "info": false,
	            "ordering": true,
	            "searching":false,
	            "lengthChange":false,
	            "paging":true,
			    "language": {"url":spanish_in}
	        });
			table.page.len(8).draw();			  
			$('#clientes_table tbody').on( 'click', 'tr', function ()
			{   if ( $(this).hasClass('selected') )
				{   $(this).removeClass('selected');
				}
				else
				{   table.$('tr.selected').removeClass('selected');
					$(this).addClass('selected');
					var celda0 = $(this).children().eq(0);
					document.getElementById('codalum').value=$(celda0).text();
				}
			});
		}
	};
	xhr.send(data);
}
function js_saldoaFavor_add( )
{   document.getElementById( 'resultado' ).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var data = new FormData();
	data.append( 'event', 'set' );
	data.append( 'valor', document.getElementById( 'valor' ).value );
	data.append( 'alum_codi', document.getElementById( 'codalum' ).value );
	data.append( 'tipo_persona', document.getElementById( 'cmb_per_consulta_tipo_persona' ).value );

	var xhr = new XMLHttpRequest();
	xhr.open('POST', document.getElementById('ruta_html_finan').value+'/saldoaFavor/controller.php' , true);
	xhr.onreadystatechange=function()
	{   if (xhr.readyState==4 && xhr.status==200)
		{   js_saldoaFavor_busca("",'resultado', document.getElementById('ruta_html_finan').value+'/saldoaFavor/controller.php' );
		} 
	};
	xhr.send(data);
}
function js_saldoaFavor_add2(  )
{   document.getElementById( 'resultado' ).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    
	var data = new FormData();
	data.append( 'event', 'set' );
	
	if ( document.getElementById( 'cmb_balance_reason' ).value == 'mas' )
		data.append( 'valor', document.getElementById( 'valor_balance' ).value );
	if ( document.getElementById( 'cmb_balance_reason' ).value == 'menos' )
		data.append( 'valor', document.getElementById( 'valor_balance' ).value * -1 );
	
	var tipo_persona = 1;
	
	if ( $(this).find('td').eq(3).text( ) == 'ALUMNO' )
		tipo_persona = 1;
	if ( $(this).find('td').eq(3).text( ) == 'CLIENTE EXTERNO' )
		tipo_persona = 4;
	
	data.append( 'alum_codi', document.getElementById( 'hd_per_codi' ).value );
	data.append( 'tipo_persona', tipo_persona );
	data.append( 'observacion', document.getElementById( 'txt_balance_obs' ).value );

	var xhr = new XMLHttpRequest();
	xhr.open('POST', document.getElementById('ruta_html_finan').value+'/saldoaFavor/controller.php' , true);
	xhr.onreadystatechange=function()
	{   if ( xhr.readyState === 4 && xhr.status === 200 )
		{   js_saldoaFavor_busca( "", 'resultado', document.getElementById('ruta_html_finan').value+'/saldoaFavor/controller.php' );
		}
	};
	xhr.send(data);
}
function js_saldoaFavor_balancear( per_codi )
{   document.getElementById( 'span_balance_reason' ).innerHTML = '$';
	document.getElementById( 'span_balance_mount_label' ).innerHTML = 'Monto a incrementar';
	document.getElementById( 'cmb_balance_reason' ).value = 'mas';
	document.getElementById( 'hd_per_codi' ).value = per_codi;
    
	$('#banc_table tbody tr').each(function()
	{   if( $(this).find('td').eq(2).text( ) == per_codi  )
		{   var p_valor = $(this).find('td').eq(5).text( );
			p_valor = p_valor.replace('$','');
			document.getElementById( 'valor_actual' ).value = p_valor;
			document.getElementById( 'valor_balance' ).value = 0;
		}
	});
	
	$(function() {$('#valor_balance' ).maskMoney({thousands:'', decimal:'.', allowZero:false});});
}
function js_saldoaFavor_rep_hist( per_codi )
{   document.getElementById( 'modal_rep_body' ).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
	var cartera_codigo = 0;
	var cliente_codigo = '0';
	var tipo_persona = 0;
	$('#banc_table tbody tr').each(function()
	{   if( $(this).find('td').eq(2).text( ) == per_codi  )
		{   cartera_codigo = $(this).find('td').eq(1).text( );
			cliente_codigo = $(this).find('td').eq(2).text( );
			if ( $(this).find('td').eq(3).text( ) == 'ALUMNO' )
				tipo_persona = 1;
			if ( $(this).find('td').eq(3).text( ) == 'CLIENTE EXTERNO' )
				tipo_persona = 4;
		}
	});
	var evento = 'get_safHistorico_pdf';
	var data = new FormData();
	data.append('event', 'printvisor');
	url2 = document.getElementById('ruta_html_finan').value+'/saldoaFavor/controller.php' + 
		'?event=' + evento + '&tdrgcd=' + cartera_codigo+ '&cc=' + cliente_codigo+ '&tp=' + tipo_persona;
	data.append('url', url2 );
	var xhr = new XMLHttpRequest();
	xhr.open('POST', document.getElementById('ruta_html_finan').value+'/saldoaFavor/controller.php' , true);
	xhr.onreadystatechange=function()
	{   if ( xhr.readyState === 4 && xhr.status === 200 )
		{   document.getElementById( 'modal_rep_body' ).innerHTML = xhr.responseText;
		}
	};
	xhr.send(data);
}
/*function save_edited(rol_codigo,div,url)
{   if(confirm("¿Está seguro que desea editar la información del banco?"))
	{   document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
		var data = new FormData();
		data.append('event', 'edit');
		data.append('banc_codigo', document.getElementById('banc_codigo').value);
		data.append('banc_nombre', document.getElementById('banc_nombre').value);
		
		var xhr = new XMLHttpRequest();
		xhr.open('POST', url , true);
		xhr.onreadystatechange=function()
		{   if (xhr.readyState==4 && xhr.status==200)
			{   js_saldoaFavor_busca("",div,url);
			}
		};
		xhr.send(data);
	}
}*/
function js_saldoaFavor_validaDesbordamientoAbono (e, field, totalPagos, max_value)
{	if ( document.getElementById( 'cmb_balance_reason' ).value == 'menos' )
	{   var maximo=0;
		if(max_value>totalPagos)
		{	maximo=parseFloat(totalPagos);
		}else
		{	maximo=parseFloat(max_value);
		}
		var valor=field.value;
		var valor_actual=field.value+String.fromCharCode(e.which);
		valor_actual_real=parseFloat(valor_actual)*10;
		if (e.keyCode == 32)
		{	field.value=parseFloat(field.value*10).toFixed(2);
			valor_actual_real=parseFloat(valor_actual)*10;
		}
		if(parseFloat(parseFloat(valor_actual_real).toFixed(2))>parseFloat(parseFloat(maximo).toFixed(2)))
		{	var mensajeError='Valor excedido, ingreso un monto menor o igual a la deuda';
			regexp = /.[0-9]{5}$/
			field.value=parseFloat(0).toFixed(2);
			if(document.getElementById('valor_actual').value <= totalPagos)
			{
				return !(regexp.test(field.value));
			}
		}
	}
}
function js_saldoaFavor_get_config ()
{   var data = new FormData();
    data.append( 'event', 'get_saf_settings' );
    var xhr = new XMLHttpRequest();
    xhr.open('POST', document.getElementById('ruta_html_finan').value + '/saldoaFavor/controller.php' , true);
    xhr.onreadystatechange=function()
	{   if ( xhr.readyState === 4 && xhr.status === 200 )
		{   console.log( xhr.responseText );
			if ( xhr.responseText == 'S' )
				document.getElementById( 'check_generar_Saf_NC' ).checked = 'checked';
			else
				document.getElementById( 'check_generar_Saf_NC' ).checked = false;
        }
    };
    xhr.send(data);
}
function js_saldoaFavor_set_config ()
{   var data = new FormData();
    data.append( 'event', 'set_saf_settings' );
	data.append( 'check_generar_Saf_NC', document.getElementById( 'check_generar_Saf_NC' ).checked );
	var xhr = new XMLHttpRequest();
    xhr.open('POST', document.getElementById('ruta_html_finan').value + '/saldoaFavor/controller.php' , true);
    xhr.onreadystatechange=function()
	{   if (xhr.readyState === 4 && xhr.status === 200)
		{   $('#modal_configSaf').modal('hide');
			var n = xhr.responseText.length;
			if (n > 0)
			{   valida_tipo_growl(xhr.responseText);
			}
			else
			{   $.growl.warning({ title: "Educalinks informa:",message: "Proceso realizado." + xhr.responseText });
			}
        }
    };
    xhr.send(data);
}
function js_saldoaFavor_filter ()
{
	js_saldoaFavor_busca("",'resultado', document.getElementById('ruta_html_finan').value+'/saldoaFavor/controller.php' );
}