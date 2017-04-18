/**
 * Creado por Redlinks, Marcos Alvear, el 24/02/2017.
 */
document.addEventListener('DOMContentLoaded', function ()
{   if (Notification.permission !== "granted")
		Notification.requestPermission();
});
$(document).ready(function() {
	$("#boton_busqueda").click(function(){
		$("#desplegable_busqueda").slideToggle(200);
	});
	$("#txt_fecha_ini").datepicker();
    $("#txt_fecha_fin").datepicker();
	$("#txt_fecha_deuda_ini").datepicker();
    $("#txt_fecha_deuda_fin").datepicker();
	$("#txt_fecha_aut_ini").datepicker({ format: 'yyyy-mm-dd' });
	$("#txt_fecha_aut_fin").datepicker({ format: 'yyyy-mm-dd' });
	$("#txt_fecha_aut_ini").inputmask({
		mask: "y-1-2", 
		placeholder: "yyyy-mm-dd", 
		leapday: "-02-29", 
		separator: "-", 
		alias: "yyyy/mm/dd"
	});
	$("#txt_fecha_aut_fin").inputmask({
		mask: "y-1-2", 
		placeholder: "yyyy-mm-dd", 
		leapday: "-02-29", 
		separator: "-", 
		alias: "yyyy/mm/dd"
	});
	$("#cmb_producto").select2();
	$("#txt_tneto_ini").numeric({ decimal : ".",  negative : false, scale: 2, precision: 8 });
	$("#txt_tneto_fin").numeric({ decimal : ".",  negative : false, scale: 2, precision: 8 });
	
	$(".detalle").tooltip({
		'html': 		true,
        'selector': 	'',
        'placement': 	'bottom',
        'container': 	'body',
		'tooltipClass': 'detalleTooltip'
    });
    $('#facturasPendiente_table').DataTable({
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
			{className: "dt-body-center"  , "targets": [0]},
			{className: "dt-body-center"  , "targets": [1]},
			{className: "dt-body-right"   , "targets": [2]},
			{className: "dt-body-center"  , "targets": [3]},
			{className: "dt-body-center"  , "targets": [4]},
			{className: "dt-body-center"  , "targets": [5]},
			{className: "dt-body-center"  , "targets": [6]},
			{className: "dt-body-center"  , "targets": [7]}
		]
	});
	var table = $('#facturasPendiente_table').DataTable();
	table.column( '5:visible' ).order( 'desc' );
});
function js_gestionFactura_envio_factura(codigo, div, url, envio, estadoFac )
{   if( proceso_individual_corriendo === 0 )
	{   proceso_individual_corriendo = 1;
		document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i><br><span style="font-size:small;">Enviando comprobante electrónico. Por favor, espere...</span></div>';
		var data = new FormData();
		data.append('event', 'send_to_sri');
		data.append('codigoDocumento', codigo);
		data.append('enviar', envio);
		data.append('estadoFac', estadoFac);
		var xhr = new XMLHttpRequest();
		xhr.open('POST', url , true);
		xhr.onreadystatechange=function()
		{   if (xhr.readyState==4 && xhr.status==200)
			{   document.getElementById(div).innerHTML=xhr.responseText;
				proceso_individual_corriendo = 0;
				js_gestionFactura_carga_busquedaFacturas('resultadoProceso');
			}
		};
		xhr.send(data);	
	}
	else
	{   $.growl({ title: "Educalinks informa",message: "Ya hay un comprobante electrónico siendo enviado. Por favor, espere." });
	}
}
function js_gestionFactura_reenvio_factura(codigo, div, url, estadoFac ){
    if( proceso_individual_corriendo === 0 )
	{   proceso_individual_corriendo = 1;
		document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i><br><span style="font-size:small;">Enviando comprobante electrónico. Por favor, espere...</span></div>';
		var data = new FormData();
		data.append('event', 'resend_to_sri');
		data.append('codigoDocumento', codigo);
		data.append('estadoFac', estadoFac);
		var xhr = new XMLHttpRequest();
		xhr.open('POST', url , true);
		xhr.onreadystatechange=function(){
			if (xhr.readyState==4 && xhr.status==200){
				document.getElementById(div).innerHTML=xhr.responseText;
				proceso_individual_corriendo = 0;
				js_gestionFactura_carga_busquedaFacturas('resultadoProceso');
			}
		};
		xhr.send(data);
	}
	else
	{   $.growl({ title: "Educalinks informa",message: "Ya hay un comprobante electrónico siendo enviado. Por favor, espere." });
	}
}
function js_gestionFactura_editar(codigo,alum_codi,tipo_persona,div,url,url2,follow_next){
    document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var data = new FormData();	
    data.append('event', 'editar_factura');
    data.append('codigofactura', codigo);
    data.append('tipo_persona', tipo_persona);
    var xhr = new XMLHttpRequest();
    xhr.open('POST', url , true);
    xhr.onreadystatechange=function(){
        if (xhr.readyState==4 && xhr.status==200){
            document.getElementById(div).innerHTML=xhr.responseText;
			if(follow_next)
			{   carga_tabla_asign_repr(alum_codi,'div_asign_repr',url2); //funcion llamada de representantes.js
			}
        }
    };
    xhr.send(data);
}
function js_gestionFactura_validaSave_edited(url)
{	js_gestionFactura_save_edited(url);
	return false;
}
function js_gestionFactura_save_edited(url){
	if(confirm("¿Está seguro que desea editar la información de la factura?")){
		var data = new FormData();
		
		data.append('event', 'edit');
		data.append('codigo', document.getElementById('factura_codigo').value);
		data.append('tipoid', document.getElementById('tipo_iden').value);
		data.append('numeroid', document.getElementById('num_cedula').value);
		data.append('repr_nomb', document.getElementById('repr_nomb').value);
		data.append('repr_apel', document.getElementById('repr_apel').value);
		data.append('repr_domi', document.getElementById('repr_domi').value);
		data.append('repr_email', document.getElementById('repr_email').value);
		data.append('repr_telf', document.getElementById('repr_telf').value);
		data.append('codigoAlumno', document.getElementById('codigoAlumno').value);
		data.append('ckb_docPendientes', document.getElementById('ckb_docPendientes').checked);
		data.append('ckb_datosPersonales', document.getElementById('ckb_datosPersonales').checked);
		
		var xhr = new XMLHttpRequest();
		xhr.open('POST', url , true);
		xhr.onreadystatechange=function()
		{	if (xhr.readyState==4 && xhr.status==200)
			{	var n = xhr.responseText.length;
				if (n > 0)
				{	valida_tipo_growl(xhr.responseText);
				}
				else
				{   $.growl.warning({ title: "Educalinks informa:",message: "Proceso realizado." });
				}
				carga_facturasPendientes('resultadoProceso',url);
			} 
		};
		xhr.send(data);
	}
}
function js_gestionFactura_get_fac_pdtes_codi_json( div, url, evento )
{   checkboxes = document.getElementsByName('ckb_codigoDocumento[]');
    var factura=[];
	var bandera = 0;
	for(var i = 0, n = checkboxes.length; i < n; i++ )
    {   if ( checkboxes[i].checked )
		{   factura.push(checkboxes[i].value);
			bandera++;
		}
    }
	console.log(factura);
	if ( bandera > 0 )
	{   var chartgrama = new Array();
		chartgrama['NO AUTORIZADO'] = 0;
		chartgrama['PROCESANDOSE'] = 0;
		chartgrama['AUTORIZADO'] = 0;
		chartgrama['DEVUELTA'] = 0;
		chartgrama['ERROR'] = 0;
		chartgrama['NOCAJA'] = 0;
		proceso_corriendo = 1;
		var start_time = new Date().getTime();
		var request_time = 0;
		var per_complete_first = 0;
		js_gestionFactura_get_fac_pdtes_codi_json_followed ( div, url, evento, factura, 0, factura.length, chartgrama, start_time, request_time, per_complete_first );	
	}
	else
	{   document.getElementById(div).innerHTML=
		"<div id='facturasGeneradas' class='form-group'>"+
			"<div class='callout' role='alert'>"+
				"<h4><i class='icon fa fa-info-circle'></i> No hay facturas pendiente de envío</h4>"+
				"<p>En este momento no hay facturas pendiente de envío. Por favor, redefina su búsqueda o intente más tarde.</p>"+
			"</div>"+
		"</div>";
	}
}
var proceso_individual_corriendo = 0;
var proceso_corriendo = 0;
var array_chartgrama_envioSRI = [];
var json_stringified_codigoFactura_envioSRI = "";
var json_codigoFactura_envioSRI = JSON.parse("[]");
var gestionFactura_interval_carga_progress_bar_SRI = setInterval(function()
{   if ( 0 === 0 )
	{   clearInterval(gestionFactura_interval_carga_progress_bar_SRI);
	}
}, Math.round( 100 ) );
function js_gestionFactura_get_fac_pdtes_codi_json_followed ( div, url, evento, objeto, indice, obj_len, chartgrama, start_time, request_time, per_complete_first )
{   /*	Esta es una función recursiva. Digamos, por dar una explicación, que estamos ante un caso en el que se va llamara si misma 10 veces.
		Por cada vez que se llame, se calcula un porcentaje de lo 'que representará lo completado una vez que esta recursividad haya sido terminado'.
		Es decir, si estoy en la primera recursividad, per_complete será igual a 10. Ese diez es el porcentaje de lo completado, una vez que termine
		de ejecutarse el ajax en esta recursividad.
		
		-"div" es la ubicación en donde se mostrará visualmente el proceso.
		
		-"url" es la ubicación del controller.php, o del script asíncrono en *.php.
		
		-"evento" es usado en este caso como una variable ya que hay dos eventos diferentes que utilizan esta función muy bien.
		
		-"objeto" es el arreglo con los códigos de las facturas que fueron consultados desde la función la función js_gestionFactura_get_fac_pdtes_codi_json( div, url, evento );
		
		-"indice" es utilizado para guiarse dentro del arreglo 'objeto'. En esta función se la utiliza de la siguiente manera: Por cada llamado recursivo, se aumenta 1 al índice
		 y se trabaja con el código de esa factura para hacer el envío al SRI. Una vez que responde el servicio del SRI, el resultado es guardado en 'chartgrama'.
		
		-"chartgrama" es la pizarra de resultados que se muestra una vez que se terminen las llamadas recursivas. Chartgrama es declarado 
		 en la función js_gestionFactura_get_fac_pdtes_codi_json( div, url, evento );
		
		-"obj_len", tamaño del arreglo 'objeto'.
		
		-"start_time", tiempo tomado antes de ejecutar el AJAX.
		
		-"request_time", es el tiempo promedio que se demora en ejecutar el AJAX, guardado de la recursividad anterior. La primera vez siempre va a ser = 0.
		
		-"per_complete_first" es el porcentaje que representa cada operación.
		
		-"per_complete" es lo que se supone que "será" el porcentaje completado una vez que se ejecute el ajax correctamente.
		
		-"gestionFactura_interval_carga_progress_bar_SRI" es el intervalo empezado en la recursividad anterior. Sirve para dar de baja dicho intervalo, ya que si
		 el ajax 'termina de ejecutarse' antes del tiempo estimado, el intervalo sigue ejecutandose, y el siguiente intervalo se ejecuta a la vez,
		 provocando un 'bug' visual, pues hace que el % mostrado en pantalla salte, por dar un ejemplo, de 50% a 43% y luego a 56%. Esto se pone peor
		 mientras más intervalos hayan ejecutándose a la vez.
		
		
	*/
	if ( !objeto )
	{   objeto = json_codigoFactura_envioSRI; /* variable global */
		//obj_len = objeto.length;
	}
	if( !chartgrama )
	{   chartgrama = array_chartgrama_envioSRI; /* variable global */	
	}
	/*
	console.log(json_codigoFactura_envioSRI);
	console.log(array_chartgrama_envioSRI);
	console.log(objeto);
	console.log(chartgrama);
	console.log('proceso: ' + proceso_corriendo);
	console.log('indice: ' + indice);
	console.log('obj len: ' + obj_len);
	*/
	if ( chartgrama['NOCAJA'] > 0 )
	{   document.getElementById(div).innerHTML='<div class="callout callout-info">'+
						'<h4><strong><li class="fa fa-exclamation"></li> Envío de factura sin pago</strong></h4>'+
						' Usuario debe estar a <b>asignado a una caja</b> y/o'+
						' estar trabajando con una <b>caja abierta</b> para poder realizar esta operación.'+
					'</div>';		
		proceso_corriendo = 0;
		js_gestionFactura_carga_busquedaFacturas( 'resultadoProceso');
	}
	else
	{   var per_complete = Math.round( ( ( ( indice + 1 ) * 100 ) / obj_len ) );
		if(gestionFactura_interval_carga_progress_bar_SRI)
		{   clearInterval(gestionFactura_interval_carga_progress_bar_SRI);
		}
		if( ( indice < obj_len ) && ( proceso_corriendo != 0 ) )
		{   if( proceso_corriendo === 1 )
			{   if ( indice > 0 ) 
				{   var progressBar = $('#pb_envio_por_lote'), width = per_complete-per_complete_first-1;
					gestionFactura_interval_carga_progress_bar_SRI = setInterval(function()
					{   width += 1;
						progressBar.css('width', width + '%');
						if (document.getElementById('div_text_per_complete'))
							document.getElementById('div_text_per_complete').innerHTML = width;
						if ( ( width >= ( per_complete - 1 )) && ((document.getElementById('pb_envio_por_lote'))) )
						{   clearInterval(gestionFactura_interval_carga_progress_bar_SRI);
						}
					}, Math.round( request_time / (per_complete_first-1) ) );
				}
				/*
					console.log( 'per complete first: ' + per_complete_first );
					console.log( 'request time: ' + request_time );
					console.log( 'per complete: ' + per_complete );
					console.log( Math.round( request_time / (per_complete_first-1) ) );
				*/
				var data2 = new FormData();
				data2.append('event', evento );
				data2.append('codigoFactura', objeto[indice] );
				data2.append( 'estado', document.getElementById("cmb_estado").value );
				var xhrII = new XMLHttpRequest();
				xhrII.open('POST', url , true);
				xhrII.onreadystatechange=function()
				{   if ( xhrII.readyState === 4 && xhrII.status === 200 )
					{   if ( indice === 0 ) 
						{   per_complete_first = per_complete;
						}
						request_time = new Date().getTime() - start_time;
						if( xhrII.responseText.length > 0 )
						{   var estado_respuesta = JSON.parse(xhrII.responseText);
							if ( estado_respuesta.estado =='NOCAJA' )
								chartgrama['NOCAJA'] = chartgrama [ 'NOCAJA' ] + 1;
							else
							{   chartgrama[ estado_respuesta.estado ] = chartgrama [ estado_respuesta.estado ] + 1;
								var container = document.createElement("div");
								container.innerHTML = estado_respuesta.detalle.datos;
								
								if (estado_respuesta.estado == 'AUTORIZADO' )
									document.getElementById("div_log_lote_autorizadas").appendChild(container);
								if (estado_respuesta.estado == 'NO AUTORIZADO' )
									document.getElementById("div_log_lote_no_autorizadas").appendChild(container);
								if (estado_respuesta.estado == 'PROCESANDOSE' )
									document.getElementById("div_log_lote_procesadas").appendChild(container);
								if (estado_respuesta.estado == 'DEVUELTA' )
									document.getElementById("div_log_lote_devueltas").appendChild(container);
								if (estado_respuesta.estado == 'ERROR' )
									document.getElementById("div_log_lote_errores").appendChild(container);	
							}						
						}
						else
						{   chartgrama['ERROR'] = chartgrama [ 'ERROR' ] + 1;
						}
						indice = indice + 1;
						document.getElementById(div).innerHTML=
						'<br>'+ 
						'<div align="center" style="height:100%;">'+
							'<i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i>'+
							'<br>'+ 
							'<span style="font-size:small;">Envío de comprobantes electrónicos... <span id="div_text_per_complete" name="div_text_per_complete">' + (per_complete) + '</span>% completado</span>'+
							'<br>'+ 
							'<br>'+ 
							'<a tabindex="0" class="btn btn-default btn-xs" onclick="js_gestionFactura_detener_envio_SRI(\'pb_envio_por_lote\');" data-toggle="tooltip" title="Detener" data-placement="top"><span class="fa fa-stop"></span></a>'+
							'<a tabindex="0" class="btn btn-default btn-xs" onclick="js_gestionFactura_pausar_envio_SRI(\'pb_envio_por_lote\');" data-toggle="tooltip" title="Pausar" data-placement="right"><span class="fa fa-pause"></span></a>'+
							'<div class="progress progress-striped">'+
								'<div id="pb_envio_por_lote" name="pb_envio_por_lote" class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:' + (per_complete) + '%;position:relative;">'+
									'<!--<span id="span_envio_por_lote" name="span_envio_por_lote" style="position: absolute;display: block;width: 100%;color: white;">' + (per_complete) + '% Completado</span>-->'+
								'</div>'+
							'</div>'+
						'</div>'+
						'<span style="font-size:xx-small;" align="left">Enviando factura ref. ' + objeto[indice] + ' al SRI.</span><br>'+
						'<span style="font-size:xx-small;" align="left">' + ( indice + 1 ) + ' comprobantes electrónicos enviados de ' + obj_len + '.</span>'+
						'<br>'+ 
						'<br>'+ 
						'<span id="sms_estado_envio" name="sms_estado_envio" style="font-size:x-small;">Enviando...</span>';
						js_gestionFactura_get_fac_pdtes_codi_json_followed ( div, url, evento, objeto, indice, obj_len, chartgrama, new Date().getTime(), request_time, per_complete_first );
					}
				};
				xhrII.send(data2);
			}
			if( proceso_corriendo === 2 )
			{   array_chartgrama_envioSRI = chartgrama; /* variable global */
				json_codigoFactura_envioSRI = objeto; /* variable global */
				document.getElementById(div).innerHTML=
					'<br>'+ 
					'<div align="center" style="height:100%;">'+
						'<i style="font-size:large;color:darkred;" class="fa fa-cog"></i>'+
						'<br>'+ 
						'<span style="font-size:small;">Envío de comprobantes electrónicos... <span id="div_text_per_complete" name="div_text_per_complete">' + (per_complete - per_complete_first - 1) + '</span>% completado</span>'+
						'<br>'+ 
						'<br>'+ 
						'<a tabindex="0" class="btn btn-default btn-xs" onclick="js_gestionFactura_detener_envio_SRI(\'pb_envio_por_lote\');js_gestionFactura_get_fac_pdtes_codi_json_followed   ( \''+div+'\',\''+ url+'\',\''+ evento+'\',null,'+ indice+','+ obj_len+',null,'+ new Date().getTime()+','+ request_time+','+ per_complete_first+');" data-toggle="tooltip" title="Detener" data-placement="top"><span class="fa fa-stop"></span></a>'+
						'<a tabindex="0" class="btn btn-default btn-xs" onclick="js_gestionFactura_continuar_envio_SRI(\'pb_envio_por_lote\');js_gestionFactura_get_fac_pdtes_codi_json_followed ( \''+div+'\',\''+ url+'\',\''+ evento+'\',null,'+ indice+','+ obj_len+',null,0,'+ request_time+','+ per_complete_first+');" data-toggle="tooltip" title="Continuar" data-placement="right"><span class="fa fa-play"></span></a>'+
						'<div class="progress progress-striped">'+
							'<div id="pb_envio_por_lote" name="pb_envio_por_lote" class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:' + (per_complete - per_complete_first - 1) + '%;position:relative;">'+
								'<!--<span id="span_envio_por_lote" name="span_envio_por_lote" style="position: absolute;display: block;width: 100%;color: white;">' + (per_complete - per_complete_first - 1) + '% Completado</span>-->'+
							'</div>'+
						'</div>'+
					'</div>'+
					'<span style="font-size:xx-small;" align="left">Enviando factura ref. ' + objeto[indice] + ' al SRI.</span><br>'+
					'<span style="font-size:xx-small;" align="left">' + ( indice ) + ' comprobantes electrónicos enviados de ' + obj_len + '.</span>'+
					'<br>'+ 
					'<br>'+ 
					'<span id="sms_estado_envio" name="sms_estado_envio" style="font-size:x-small;">Pausado</span>';
			}
		}
		else
		{   document.getElementById(div).innerHTML=
				"<div id='facturasGeneradas' class='form-group'>"+
					"<div class='callout callout-success' role='alert'>"+
						"<h4><i class='icon fa fa-check'></i> Envío de comprobantes electrónicos completado</h4>"+
						"<ul>"+
							"<li><strong>" + chartgrama['AUTORIZADO'] + "</strong> facturas fueron autorizadas</li>"+
							"<li><strong>" + chartgrama['NO AUTORIZADO'] + "</strong> facturas fueron no autorizadas</li>"+
							"<li><strong>" + chartgrama['DEVUELTA'] + "</strong> facturas fueron devueltas</li>"+
							"<li><strong>" + chartgrama['PROCESANDOSE'] + "</strong> facturas fueron procesadas</li>"+
							"<li><strong>" + chartgrama['ERROR'] + "</strong> facturas tuvieron errores </li>"+
						"</ul>"+
					"</div>"+
				"</div>";
			if (chartgrama['AUTORIZADO'] > 0 )
				document.getElementById( 'span_log_lote_autorizadas' ).innerHTML="<span class='label label-danger'> " + chartgrama['AUTORIZADO'] + "</span>";
			if (chartgrama['NO AUTORIZADO'] > 0 )
				document.getElementById( 'span_log_lote_no_autorizadas' ).innerHTML="<span class='label label-danger'> " + chartgrama['NO AUTORIZADO'] + "</span>";
			if (chartgrama['DEVUELTA'] > 0 )
				document.getElementById( 'span_log_lote_devueltas' ).innerHTML="<span class='label label-danger'> " + chartgrama['DEVUELTA'] + "</span>";
			if (chartgrama['PROCESANDOSE'] > 0 )
				document.getElementById( 'span_log_lote_procesadas' ).innerHTML="<span class='label label-danger'> " + chartgrama['PROCESANDOSE'] + "</span>";
			if (chartgrama['ERROR'] > 0 )
				document.getElementById( 'span_log_lote_errores' ).innerHTML="<span class='label label-danger'> " + chartgrama['ERROR'] + "</span>";
			
			/*$.growl.notice({ title: "Educalinks informa",message: "Envío de facturas completado correctamente." });*/
			if (!Notification)
			{   alert('Las notificaciones de escritorio no están disponibles en su explorador. Por favor utilzia Chrome.'); 
				return;
			}
			if (Notification.permission !== "granted")
				Notification.requestPermission();
			else
			{	if ( proceso_corriendo === 1 )
				{   var sms_notify = "";
					if (obj_len > 1)
						sms_notify = "¡Se han enviado " + ( indice ) + " comprobantes electrónicos al SRI!"
					else
						sms_notify = "¡Envío de factura completado!"
					
					var notification = new Notification('Educalinks', {
						icon: document.getElementById('ruta_imagenes_common').value + "/favicon.png",
						body: sms_notify,
					});
					var ruta_notify = document.getElementById('ruta_html_finan') + "/../../../finan/verDocumentosAutorizados/";
					notification.onclick = function () {
						window.open( ruta_notify );
					};
				}
			}
			proceso_corriendo = 0;
			js_gestionFactura_carga_busquedaFacturas( 'resultadoProceso');
		}
	}
}
function js_gestionFactura_envio_facturasPorLote( div, url )
{   if ( proceso_corriendo != 0 )
		$.growl({ title: "Educalinks informa",message: "Ya hay un lote de comprobantes electrónicos en proceso de envío. Por favor, espere." });
	else
	{   document.getElementById(div).innerHTML=
		'<br>'+
		'<div align="center" style="height:100%;">'+
			'<i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i><br>'+
			'<span style="font-size:small;">Enviando los comprobantes electrónicos al SRI. Por favor, espere...</span>'+
		'</div>';
		js_gestionFactura_limpiar_log_envio_lote(  );
		var obj = js_gestionFactura_get_fac_pdtes_codi_json ( div, url, 'send_to_sri_all' );
	}	
}
function js_gestionFactura_autorizar_facturasPorLote( div, url )
{   if ( proceso_corriendo != 0 )
		$.growl({ title: "Educalinks informa",message: "Ya hay un lote de comprobantes electrónicos en proceso de envío. Por favor, espere." });
	else
	{   document.getElementById(div).innerHTML=
		'<br>'+
		'<div align="center" style="height:100%;">'+
			'<i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i><br>'+
			'<span style="font-size:small;">Enviando los comprobantes electrónicos al SRI. Por favor, espere...</span>'+
		'</div>';
		js_gestionFactura_limpiar_log_envio_lote(  );
		var obj = js_gestionFactura_get_fac_pdtes_codi_json ( div, url, 'autorizar_to_sri_all' );
	}
}
function js_gestionFactura_limpiar_log_envio_lote(  )
{	$('.nav-tabs a[href="#modal_lote_body"]').tab('show');
	document.getElementById( 'div_log_lote_autorizadas' ).innerHTML="";
	document.getElementById( 'div_log_lote_no_autorizadas' ).innerHTML="";
	document.getElementById( 'div_log_lote_devueltas' ).innerHTML="";
	document.getElementById( 'div_log_lote_procesadas' ).innerHTML="";
	document.getElementById( 'div_log_lote_errores' ).innerHTML="";
	document.getElementById( 'span_log_lote_autorizadas' ).innerHTML="";
	document.getElementById( 'span_log_lote_no_autorizadas' ).innerHTML="";
	document.getElementById( 'span_log_lote_devueltas' ).innerHTML="";
	document.getElementById( 'span_log_lote_procesadas' ).innerHTML="";
	document.getElementById( 'span_log_lote_errores' ).innerHTML="";
}
function js_gestionFactura_detener_envio_SRI(progress_bar)
{   proceso_corriendo = 0;
	document.getElementById( 'sms_estado_envio' ).innerHTML = "<span>Deteniendo envío...</span> las facturas que ya fueron procesadas ya tienen una respuesta del sistema del SRI.";
}
function js_gestionFactura_pausar_envio_SRI(progress_bar)
{   proceso_corriendo = 2;
	document.getElementById( 'sms_estado_envio' ).innerHTML = "<span>Pausando envío...</span>";
}
function js_gestionFactura_continuar_envio_SRI(progress_bar)
{   proceso_corriendo = 1;
}
function js_gestionFactura_to_excel_busquedaFacturas( evento, tipo_reporte )
{   document.getElementById( 'evento' ).value = evento;
    document.getElementById( 'tipo_reporte' ).value = tipo_reporte;
	document.getElementById( 'file_form' ).submit();
}
function js_gestionFactura_carga_busquedaFacturas(div)
{   document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    $('#span_codigoDocumento_head1').removeClass('fa-check-square-o').addClass('fa-square-o');	
	$('#span_codigoDocumento_head2').html("Marcar todos");
	var tipoDocumentoAutorizado = 'FAC';
    var fechavenc_ini = document.getElementById("txt_fecha_ini").value;
    var fechavenc_fin = document.getElementById("txt_fecha_fin").value;
    var data = new FormData();
    data.append('event', 'get_all_data');
    data.append('tipoDocumentoAutorizado', tipoDocumentoAutorizado);
    data.append('fechavenc_ini', fechavenc_ini);
    data.append('fechavenc_fin', fechavenc_fin);
    var ckb_opc_adv = document.getElementById("ckb_gestionFactura_opc_adv").checked;
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
		var chk_fechaAut = document.getElementById("chk_fecha_aut").checked;
		if(chk_fechaAut)
		{   data.append('fechaAut_ini', document.getElementById("txt_fecha_aut_ini").value);
			data.append('fechaAut_fin', document.getElementById("txt_fecha_aut_fin").value);
		}
        data.append('periodo', document.getElementById("periodos").value);
        data.append('grupoEconomico', document.getElementById("cmb_grupoEconomico").value);
        data.append('nivelEconomico', document.getElementById("cmb_nivelesEconomicos").value);
        data.append('curso', document.getElementById("curso").value);
    }
    var xhr = new XMLHttpRequest();
    xhr.open('POST', document.getElementById('ruta_html_finan').value + '/gestionFacturas/controller.php' , true);
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
            $('#facturasPendiente_table').DataTable({
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
                    {className: "dt-body-center" , "targets": [7]}
                ]
            });
            var table_fac = $('#facturasPendiente_table').DataTable();
            table_fac.column( '5:visible' ).order( 'desc' );
			document.getElementById("div_por_cobrar").innerHTML = '';
			if ( document.getElementById("cmb_estado").value == 'PC' )
			{   document.getElementById("div_por_cobrar").innerHTML = 'El total neto mostrado puede variar del total neto real, dependiendo de ' +
					'los días de validez en los descuentos y en el prontopago.';
			}
        }
    };
    xhr.send(data);
}
function js_gestionFactura_check_opc_avanzadas()
{   var ckb_opc_adv = document.getElementById("ckb_gestionFactura_opc_adv").checked;
    if(ckb_opc_adv)
    {   $("#div_gestionFactura_opc_adv").collapse(200).collapse('show');
    }
    else
    {   $("#div_gestionFactura_opc_adv").collapse(200).collapse('hide');
    }
}
function js_gestionFactura_check_tneto()
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
function js_gestionFactura_check_fechaAut()
{    var chk_tneto = document.getElementById("chk_fecha_aut").checked;
    if(chk_tneto)
    {   document.getElementById("txt_fecha_aut_ini").disabled = false;
        document.getElementById("txt_fecha_aut_fin").disabled = false;
    }
    else
    {   document.getElementById("txt_fecha_aut_ini").disabled = true;
        document.getElementById("txt_fecha_aut_fin").disabled = true;
		document.getElementById("txt_fecha_aut_ini").value = "";
        document.getElementById("txt_fecha_aut_fin").value = "";
    }
}
function js_gestionFactura_select_all2 (  )
{   if ( $('#span_codigoDocumento_head1').hasClass('fa-square-o') )
	{   $('#span_codigoDocumento_head1').removeClass('fa-square-o').addClass('fa-check-square-o');
		$('#span_codigoDocumento_head2').html("Desmarcar todos");
		checked = true;
	}
	else
	{   $('#span_codigoDocumento_head1').removeClass('fa-check-square-o').addClass('fa-square-o');	
		$('#span_codigoDocumento_head2').html("Marcar todos");
		checked = false;
	}
	checkboxes = document.getElementsByName('ckb_codigoDocumento[]');
    for(var i = 0, n = checkboxes.length; i < n; i++ )
    {   checkboxes[i].checked = checked;
		
		if ( checked )
		{   if ( document.getElementById( 'tr_row_' + checkboxes[i].value ) )
				document.getElementById( 'tr_row_' + checkboxes[i].value ).style.backgroundColor = '#ffc';
		}
		else
		{   if ( document.getElementById( 'tr_row_' + checkboxes[i].value ) )
				document.getElementById( 'tr_row_' + checkboxes[i].value ).style.backgroundColor = 'white';
		}
    }
	if ( checked )
	{   //document.getElementById('tr_row_head').style.backgroundColor = '#ffc';
		//document.getElementById('btn_send').disabled = false;
		//document.getElementById('btn_resend').disabled = false;
		document.getElementById('ckb_codigoDocumento_head').checked = true;
	}
	else
	{   //document.getElementById('tr_row_head').style.backgroundColor = 'white';
		//document.getElementById('btn_send').disabled = true;
		//document.getElementById('btn_resend').disabled = true;
		document.getElementById('ckb_codigoDocumento_head').checked = false;
	}		
}
function js_gestionFactura_select_all ( source )
{   checkboxes = document.getElementsByName('ckb_codigoDocumento[]');
    for(var i = 0, n = checkboxes.length; i < n; i++ )
    {   checkboxes[i].checked = source.checked;
		if ( source.checked )
		{   if ( document.getElementById( 'tr_row_' + checkboxes[i].value ) )
				document.getElementById( 'tr_row_' + checkboxes[i].value ).style.backgroundColor = '#ffc';
		}
		else
		{   if ( document.getElementById( 'tr_row_' + checkboxes[i].value ) )
				document.getElementById( 'tr_row_' + checkboxes[i].value ).style.backgroundColor = 'white';
		}
    }
	if ( source.checked )
	{  // document.getElementById('tr_row_head').style.backgroundColor = '#ffc';
		//document.getElementById('btn_send').disabled = false;
		//document.getElementById('btn_resend').disabled = false;
		$('#span_codigoDocumento_head1').removeClass('fa-square-o').addClass('fa-check-square-o');
		$('#span_codigoDocumento_head2').html("Desmarcar todos");
	}
	else
	{   //document.getElementById('tr_row_head').style.backgroundColor = 'white';
		//document.getElementById('btn_send').disabled = true;
		//document.getElementById('btn_resend').disabled = true;
		$('#span_codigoDocumento_head1').removeClass('fa-check-square-o').addClass('fa-square-o');	
		$('#span_codigoDocumento_head2').html("Marcar todos");
	}	
}
function js_gestionFactura_select_check_ind ( source, num_linea )
{   var marcar = 'si';
	checkboxes = document.getElementsByName('ckb_codigoDocumento[]');
	var total_sinchecar = 0;
    for(var i = 0, n = checkboxes.length; i < n; i++ )
    {   if ( !checkboxes[i].checked )
		{	marcar = 'no';
			total_sinchecar++;
		}
    }
	if ( source.checked )
	{   if ( document.getElementById( 'tr_row_' + source.value ) )
			document.getElementById( 'tr_row_' + source.value ).style.backgroundColor = '#ffc';
	}
	else
	{   if ( document.getElementById( 'tr_row_' + source.value ) )
			document.getElementById( 'tr_row_' + source.value ).style.backgroundColor = 'white';
	}
	if ( marcar === 'si' )
	{	document.getElementById('ckb_codigoDocumento_head').checked = 'checked';
		$('#span_codigoDocumento_head1').removeClass('fa-square-o').addClass('fa-check-square-o');
		$('#span_codigoDocumento_head2').html("Desmarcar todos");
		//document.getElementById('tr_row_head').style.backgroundColor = '#ffc';
		//document.getElementById('btn_send').disabled = false;
		//document.getElementById('btn_resend').disabled = false;
	}
	else
	{	document.getElementById('ckb_codigoDocumento_head').checked = false;
		$('#span_codigoDocumento_head1').removeClass('fa-check-square-o').addClass('fa-square-o');
		$('#span_codigoDocumento_head2').html("Marcar todos");
		//document.getElementById('tr_row_head').style.backgroundColor = 'white';
	}
	if ( total_sinchecar == n )
	{	//document.getElementById('btn_send').disabled = true;
		//document.getElementById('btn_resend').disabled = true;
	}
	else
	{	//document.getElementById('btn_send').disabled = false;
		//document.getElementById('btn_resend').disabled = false;
	}
}