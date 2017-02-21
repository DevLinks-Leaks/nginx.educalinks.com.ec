 $(document).ready(function() {
	 actualiza_badge_gest_fact();
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
			{className: "dt-body-center" , "targets": [7]},
			{className: "dt-body-center", "targets": [8]}
		]
	});

	$('#detalleFactura_table').DataTable({
	    "info": false,
		"language": {
				"url":spanish
			},
	    "ordering": false,
	    "searching":false,
	    "lengthChange":false,
	    "paging":false,
	    "retrieve" : true
	});  

	$('#detalleNotaCredito_table').DataTable({
	    "info": false,
		"language": {
				"url":spanish
			},
	    "ordering": false,
	    "searching":false,
	    "lengthChange":false,
	    "paging":false,
	    "retrieve" : true
	});        
});


function carga_busquedaCliente(div, url){
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
				"language": {
				"url":spanish
			},
	            "ordering": true,
	            "searching":false,
	            "lengthChange":false,
	            "paging":true
	          });
		} 
	}
	xhr.send(data);
}

function busca(div,url){
	var codcliente =document.getElementById('codigoCliente').value;
	document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var data = new FormData();
	data.append('event', 'get_all_data');
	data.append('codigoCliente', codcliente);	
	var xhr = new XMLHttpRequest();
	xhr.open('POST', url , true);
	xhr.onreadystatechange=function(){
		if (xhr.readyState==4 && xhr.status==200){
		document.getElementById(div).innerHTML=xhr.responseText;

		} 
	}
	xhr.send(data);
}

// Consulta filtrada de los alumnos
function busca_clientes(filtro, div, url){
	document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var data = new FormData();
	data.append('event', 'get_client');
	if(filtro == 'nombres'){
		data.append(filtro, document.getElementById('nombre_busq').value);	
	}else{
		data.append(filtro, document.getElementById('numeroIdentificacion_busq').value);		
	}
		
	var xhr = new XMLHttpRequest();
	xhr.open('POST', url , true);
	xhr.onreadystatechange=function(){
		if (xhr.readyState==4 && xhr.status==200){
			document.getElementById(div).innerHTML=xhr.responseText;
			 $('#clientes_table').DataTable({
	            "info": false,
				"language": {
				"url":spanish
			},
	            "ordering": true,
	            "searching":false,
	            "lengthChange":false,
	            "paging":true
	          });
			$('#clientes_table tbody').on('click','tr',function(){
				if($(this).hasClass('selected')){
					$(this).removeClass('selected');
				}else{
					$('#clientes_table tr.selected').removeClass('selected');
					$(this).addClass('selected');
				}
			});
		} 
	}
	xhr.send(data);
}
function js_notaCredito_selecciona( div_buttons, div_body, tipo_persona ){
	var codigoCliente = $('#persona_table tr.selected').find('td:nth-child(1)').text();
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
				if(respuesta[0].codigoGrupoEconomico==null)
				{   grupo='-1';
				}
				else
				{   grupo=respuesta[0].codigoGrupoEconomico;
				}
				$('#txt_grupo_economico').attr("data-codigo",grupo);
				$('#txt_grupo_economico').val(respuesta[0].nombreGrupoEconomico);
				$('#txt_curso').attr("data-codigo",respuesta[0].codigoCurso);
				$('#txt_curso').val(respuesta[0].nombreCurso);
			
				if(respuesta[0].codigoNivelEconomico==null)
				{   nivel='-1';
				}
				else
				{   nivel=respuesta[0].codigoNivelEconomico;
				}
				$('#txt_nivel_economico').attr("data-codigo",nivel);
				
				$('#txt_nivel_economico').val(respuesta[0].nombreNivelEconomico);
				$('#tipoIdentificacionTitular').val(respuesta[0].tipoIdentificacionComprador);
				$('#numeroIdentificacionTitular').val(respuesta[0].cedulatitular);
				$('#nombreTitular').val(respuesta[0].nombretitular);
				$('#emailTitular').val(respuesta[0].emailtitular);
				$('#telefonoTitular').val(respuesta[0].telefonotitular);
				$('#direccionTitular').val(respuesta[0].direcciontitular);
				
				
				if( tipo_persona == 1 )
				{   carga_cliente_opciones(codigoCliente,'client_options');
					document.getElementById('div_datos_academicos_estudiante').style.display="inline";
				}
				else
				{   document.getElementById('client_options').innerHTML="";
					document.getElementById('div_datos_academicos_estudiante').style.display="none";
				}
				js_notaCredito_selecciona_get_deuda( codigoCliente, tipo_persona );
			}
			else
			{   $('#txt_grupo_economico').val('');
				$('#txt_grupo_economico').attr("data-codigo","");
				$('#txt_curso').val('');
				$('#txt_nivel_economico').val('');
				$('#txt_nivel_economico').attr("data-codigo","");
			}
		}
	}
	xhr.send(data);
}
function js_notaCredito_selecciona_get_deuda( codigoCliente, tipo_persona )
{   var data = new FormData();
	data.append('event', 'get_deudas_pendientes');
	data.append('codigoCliente', codigoCliente );
	data.append('tipo_persona', tipo_persona );
	var xhr = new XMLHttpRequest();
	xhr.open('POST', document.getElementById('ruta_html_finan').value + '/notaCredito/controller.php'  , true);
	xhr.onreadystatechange=function()
	{   if (xhr.readyState==4 && xhr.status==200)
		{   document.getElementById('deudasPendiente_table').innerHTML=xhr.responseText;
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
					{className: "dt-body-center" , "targets": [7]},
					{className: "dt-body-center", "targets": [8]}
				]
			});
			
			justificaMensajeNoData($('#deudasPendiente_table')); 
			// ==================================================
			// Limpia la tabla del detalle de la factura
			$('#detalleFactura_table tbody tr').each(function(){
				if($(this).find('td').eq(0).hasClass('dataTables_empty')!=true){
					$(this).remove();	
				}
			});
			justificaMensajeNoData($('#detalleFactura_table')); // Agrego el div que coloca el datatable donde dice: "No data available in table"
			// Limpia la cabecera de la factura
			$('#prefijoSucursal').val("00");
			$('#prefijoPuntoVenta').val("00");
			$('#numeroFactura').val("0000");
			$('#totalNotaCreditoFactura').val("00.00");
			$('#totalNetoFactura').val("00.00");
			$('#numeroIdentificacionTitular').val("");
			$('#nombreTitular').val("");
			$('#emailTitular').val("");
			$('#telefonoTitular').val("");
			$('#direccionTitular').val("");
		}
	}
	xhr.send(data);
}

function justificaMensajeNoData(tabla){
	if( tabla.find('tbody').find('tr').length <= 0 ){
		tabla.find('tbody').append("<tr class='odd'><td class='datatTables_empty' valign='top' colspan='8' style='text-align: center;' >Ningún dato disponible en esta tabla</td></tr>");	
	}	
}

function seleccionarDeuda(codigo,div,url)
{	$('#detalleNotaCredito_table tbody tr').each(function(){
		$(this).remove();
	});
	document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var data = new FormData();
	data.append('event', 'get_factura'); 
	data.append('codigoFactura', codigo);
	data.append('tipo_persona', document.getElementById('hd_tipo_persona').value);
		
	var xhr = new XMLHttpRequest();
	xhr.open('POST', url , true);
	xhr.onreadystatechange=function(){
		if (xhr.readyState==4 && xhr.status==200){
			
			var respuesta = JSON.parse(xhr.responseText);

			$('#prefijoSucursal').html(respuesta.cabecera.prefijoSucursal); 
			$('#prefijoPuntoVenta').html(respuesta.cabecera.prefijoPuntoVenta); 
			$('#numeroFactura').val(respuesta.cabecera.secuencialComprobante); 

			$('#codigoFactura').val(respuesta.cabecera.codigoFactura); 

			$('#totalAbonoFactura').val(respuesta.cabecera.totalAbonado);
			$('#totalPendienteFactura').val(respuesta.cabecera.totalPendiente);  

			$('#totalNotaCreditoFactura').val(respuesta.cabecera.totalNotaCredito); 
			$('#totalNetoFactura').val(respuesta.cabecera.totalNeto); 
			$('#totalSinImpFactura').val(respuesta.cabecera.totalSinImpuestos); 

			$('#tipoIdentificacionTitular').val(respuesta.cabecera.tipoIdentificacionTitular); 
			$('#numeroIdentificacionTitular').val(respuesta.cabecera.identificacionTitular); 
			$('#nombreTitular').val(respuesta.cabecera.nombreTitular); 
			$('#emailTitular').val(respuesta.cabecera.emailTitular); 
			$('#telefonoTitular').val(respuesta.cabecera.telefonoTitular); 
			$('#direccionTitular').val(respuesta.cabecera.direccionTitular); 

			$('#resultadoDetalleFactura').html(respuesta.detalle);

			$('#detalleFactura_table').DataTable({
			    "info": false,
			    "ordering": false,
				"language": {
				"url":spanish
			},
			    "searching":false,
			    "lengthChange":false,
			    "paging":false,
			    "retrieve" : true
			});
		} 
	}
	xhr.send(data);
}
function validaDesbordamientoNC(e, field)
{	var desbordamiento = document.getElementById('txtValorNeto').value - document.getElementById('txtValorNC').value;
	var valor=field.value;
	var valor_actual=field.value+String.fromCharCode(e.which);
	valor_actual_real=parseFloat(valor_actual)*10;
	if (e.keyCode == 32)
	{	field.value=parseFloat(field.value*10).toFixed(2);
		valor_actual_real=parseFloat(valor_actual)*10;
	}
	if(parseFloat(parseFloat(valor_actual_real).toFixed(2))>parseFloat(parseFloat(desbordamiento).toFixed(2)))
	{	regexp = /.[0-9]{5}$/
		field.value=parseFloat(0).toFixed(2);
		if(desbordamiento <= field.value)
		{   return !(regexp.test(field.value));
		}
		
	}
}

function validaDesbordamientoNC222(e, field){
	var nuevoValor = parseFloat(field.value+String.fromCharCode(e.which));
	nuevoValor = parseFloat(nuevoValor); // Deduzco el nuevo valor a partir de lo que ingresa y lo que existe
	if(nuevoValor > 90){
		return false
	}
	var totalAgregado = parseFloat(0);
	$('#detalleNotaCredito_table tbody tr').each(function(){
		if(!$(this).find('td').eq(0).attr('class')){ // Que no este vacía la tabla
			totalAgregado = parseFloat(totalAgregado) + parseFloat((!$(this).find('td').eq(6).text()? 0 : parseFloat($(this).find('td').eq(6).text()))) ;
		}
	});
	totalAgregado = parseFloat(totalAgregado) + parseFloat(nuevoValor);
	var totalFacturado = parseFloat($("#totalSinImpFactura").val());
	if(parseFloat(parseFloat(totalAgregado).toFixed(2)) > parseFloat(totalFacturado) ){
		return false;
	}else{
		return true;
	}
}

function mostrarReduccionDetalleDeuda(secuenciaDetalle, div, url){
	document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var codigoProducto = "", nombreProducto = "", valorBruto = "", descuento = "", iva = "", valorNeto = "", valorNC = "";
	$('#detalleFactura_table tbody tr').each(function(){
		if(!$(this).find('td').eq(0).attr('class')){ // Que no este vacía la tabla
			if($(this).find('td').eq(8).find('span').attr('data-iddetalle').trim() == secuenciaDetalle ){
				// Sumo los valores anteriores, a excepción del valor del elemento input actual. 
				codigoProducto = $(this).find('td').eq(0).text();
				nombreProducto = $(this).find('td').eq(1).text();
				valorBruto = parseFloat($(this).find('td').eq(2).text()).toFixed(2) * parseFloat($(this).find('td').eq(3).text()).toFixed(2);
				descuento = $(this).find('td').eq(4).text(); 
				iva = $(this).find('td').eq(5).text(); 
				valorNeto = $(this).find('td').eq(6).text(); 
				valorNC = $(this).find('td').eq(7).text(); 
			}
		}
	});

	var data = new FormData();
	data.append('event', 'agregarValorReduccion');	
	data.append('secuenciaDetalleFactura', secuenciaDetalle);	
	data.append('codigoProducto', codigoProducto);	
	data.append('nombreProducto', nombreProducto);	
	data.append('valorBruto', valorBruto);	
	data.append('descuento', descuento);	
	data.append('iva', iva);	
	data.append('valorNeto', valorNeto);	
	data.append('valorNC', valorNC);		

	var xhr = new XMLHttpRequest();
	xhr.open('POST', url , true);
	xhr.onreadystatechange=function(){
		if (xhr.readyState==4 && xhr.status==200){
			document.getElementById(div).innerHTML=xhr.responseText;
			$(function() {$('#txtValorNetoAReducir').maskMoney({thousands:'', decimal:'.', allowZero:false});;})
		} 
	};
	xhr.send(data);
}

function deducirValores(field){
	if(field.value != ""){
		var proporcionAReducir = 0;
		proporcionAReducir = (field.value * 100)/ parseFloat($("#txtValorNeto").val()).toFixed(2)

		$("#txtValorBrutoDeducido").val( parseFloat( $("#txtValorBruto").val()  * proporcionAReducir / 100 ).toFixed(2) )
		$("#txtDescuentoDeducido").val( parseFloat( $("#txtDescuento").val()  * proporcionAReducir / 100 ).toFixed(2) )
		$("#txtIVADeducido").val( parseFloat( $("#txtIVA").val()  * proporcionAReducir / 100 ).toFixed(2) )

	}else{
		$("#txtValorBrutoDeducido").val("");
		$("#txtDescuentoDeducido").val("");
		$("#txtIVADeducido").val("");
	}
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

function addDetalleNC(url){
	$('#detalleNotaCredito_table tbody tr').each(function(){
		if($(this).attr('class')=='odd'){
			$(this).remove();	// Quito el div que coloca el datatable donde dice: "No data available in table"
		}
	});

	var idLinea = randomString();
	var nuevaLinea = "<tr>";	
	nuevaLinea += "<td data-idfila='"+idLinea+"' data-iddetalle='"+$("#txtSecuenciaDetalleFactura").val()+"'>"+$("#txtCodigoProducto").val()+"</td>";
	nuevaLinea += "<td>"+$("#txtNombreProducto").val()+"</td>";
	nuevaLinea += "<td>"+$("#txtDescripcion").val()+"</td>";
	nuevaLinea += "<td>"+$("#txtValorBrutoDeducido").val()+"</td>";
	nuevaLinea += "<td>"+$("#txtDescuentoDeducido").val()+"</td>";
	nuevaLinea += "<td>"+$("#txtIVADeducido").val()+"</td>";
	nuevaLinea += "<td>"+$("#txtValorNetoAReducir").val()+"</td>";
	nuevaLinea += "<td>"+"<span onclick='quitarValorNC("+'"'+idLinea+'"'+")' class='glyphicon glyphicon-remove cursorlink' aria-hidden='true' title='Eliminar valor'>&nbsp;</span>"+"</td>";
	nuevaLinea += "</tr>";
	$('#detalleNotaCredito_table tbody').append(nuevaLinea);

 	actualizaTotalNC();
}

function actualizaTotalNC(){
	var reducido = 0;
 	$('#detalleNotaCredito_table tbody tr').each(function(){
 		if(!$(this).find('td').eq(0).attr('class')){ 
 			reducido += parseFloat($(this).find('td').eq(6).text());
 		}else{
 			reducido = 0;
 		}
 	});
 	$('#totalValoresNotaCredito').val(reducido.toFixed(2));
	$('#totalNotaCreditoFactura').val(reducido.toFixed(2));	
}

function actualizaTotalDeudasPendientes(){
	var pendiente = 0;
 	$('#deudasPendiente_table tbody tr').each(function(){
 		if(!$(this).find('td').eq(0).attr('class')){ 
 			pendiente += parseFloat($(this).find('td').eq(5).text());
 		}else{
 			pendiente = 0;
 		}
 	});
 	$('#totalDeudasPendientes').val(pendiente.toFixed(2));	
}
function quitarValorNC(fila){
	if(confirm("¿Está seguro de eliminar el detalle actual de la nota de crédito?"))
	{   $('#detalleNotaCredito_table tbody tr').each(function(){
	 		if(!$(this).find('td').eq(0).attr('class'))
			{   if($(this).find('td').eq(0).attr('data-idfila') == fila)
				{   $(this).remove();
	 			}
	 		}
	 	});
	 	justificaMensajeNoData($('#detalleNotaCredito_table'));
	 	actualizaTotalNC();
	}
}

function limpiaPagina( albedrio )
{   var blanquear = 0;
	if(albedrio)
	{   if( confirm("¿Está segurox de eliminar todo y empezar nuevamente?") ) 
			blanquear = 1;
	}
	else
	{   blanquear = 1;
	}
	if( blanquear === 1 )
	{   // => Blanquear las deudas pendientes
		$('#deudasPendiente_table tbody tr').each(function(){
			$(this).remove();
		});
		justificaMensajeNoData($('#deudasPendiente_table')); // Agrego el div que coloca el datatable donde dice: "No data available in table"
		actualizaTotalDeudasPendientes();
		// => Blanquear los detalles de la factura
		$('#detalleFactura_table tbody tr').each(function(){
			$(this).remove();
		});
		justificaMensajeNoData($('#detalleFactura_table'));
		// => Blanquear los detalles de la nota de crédito
		$('#detalleNotaCredito_table tbody tr').each(function(){
			$(this).remove();
		});
		justificaMensajeNoData($('#detalleNotaCredito_table'));
		actualizaTotalNC();
		// Campos totales de la factura
		$("#totalSinImpFactura").val("");
		
		$("#prefijoSucursal").text("00");
		$("#prefijoPuntoVenta").text("00");
		$("#numeroFactura").val("");
		$("#codigoFactura").val("");
		$("#totalNetoFactura").val("");
		$("#totalAbonoFactura").val("");
		$("#totalNotaCreditoFactura").val("");
		$("#totalPendienteFactura").val("");
		// Campos de la cabecera de la factura
		$("#numeroIdentificacionTitular").val("");
		$("#nombreTitular").val("");
		$("#emailTitular").val("");
		$("#telefonoTitular").val("");
		$("#direccionTitular").val("");
	}
}
function cancelar(){
	var confirmacion = true;
	// => Blanquear las deudas pendientes
	$('#deudasPendiente_table tbody tr').each(function(){
		$(this).remove();
	});
	justificaMensajeNoData($('#deudasPendiente_table')); // Agrego el div que coloca el datatable donde dice: "No data available in table"
	actualizaTotalDeudasPendientes();
	// => Blanquear los detalles de la factura
	$('#detalleFactura_table tbody tr').each(function(){
		$(this).remove();
	});
	justificaMensajeNoData($('#detalleFactura_table'));
	// => Blanquear los detalles de la nota de crédito
	$('#detalleNotaCredito_table tbody tr').each(function(){
		$(this).remove();
	});
	justificaMensajeNoData($('#detalleNotaCredito_table'));
	actualizaTotalNC();
	// Campos totales de la factura
	$("#totalSinImpFactura").val("");
	
	$("#prefijoSucursal").text("00");
	$("#prefijoPuntoVenta").text("00");
	$("#numeroFactura").val("");
	$("#codigoFactura").val("");
	$("#totalNetoFactura").val("");
	$("#totalAbonoFactura").val("");
	$("#totalNotaCreditoFactura").val("");
	$("#totalPendienteFactura").val("");
	// Campos de la cabecera de la factura
	$("#numeroIdentificacionTitular").val("");
	$("#nombreTitular").val("");
	$("#emailTitular").val("");
	$("#telefonoTitular").val("");
	$("#direccionTitular").val("");
}
function validacionFinal(){
	// Elimino el contenido del modal de resultado para que no se presente por error de validación
	$('#modal_resultadoNC_body').empty();
	$('#modal_busquedaCliente_body').empty();

	// CLIENTE CONSULTADO
	if(!$('#codigoCliente').val()){
		alert('Consulte el cliente para continuar.');
		return false;
	}
 	// FACTURAS CONSULTADAS
	var totalFacturasConsultadas = 0;
	$('#deudasPendiente_table tbody tr').each(function(){
		if(!$(this).find('td').eq(0).attr('class')){ 
			totalFacturasConsultadas += 1;
		}
	});
	if (totalFacturasConsultadas <= 0){
		alert('No existe ninguna factura consultada.');
		return false;
 	}
	// DETALLE DE FACTURA Y VALORES A REDUCIR
	var totalLineasDetalle = 0;
	var totalValorReducido = 0;
	var totalNCDetalle = 0, totalNetoDetalle = 0;
	$('#detalleFactura_table tbody tr').each(function(){
		if(!$(this).find('td').eq(0).attr('class')){ 
			totalLineasDetalle += 1;
			totalValorReducido += (!$(this).find('td').eq(8).find('input').val()? 0 : parseFloat($(this).find('td').eq(8).find('input').val()));
			totalNCDetalle += (!$(this).find('td').eq(7).text()? 0 : parseFloat($(this).find('td').eq(7).text()));
			totalNetoDetalle += (!$(this).find('td').eq(6).text()? 0 : parseFloat($(this).find('td').eq(6).text()));
		}
	});
	if (totalLineasDetalle <= 0)
	{   alert('No existe ningún detalle (lo cual es rarísimo).');
		return false;
 	}else
	{   // Asignado algún valor de los pagos a las deudas seleccionadas
 		if(totalValorReducido.toFixed(2) <= 0){
 			alert('No se puede generar una nota de crédito con cero valor.');
			return false;	
 		}else if(totalValorReducido.toFixed(2) > parseFloat($("#totalPendienteFactura").val()).toFixed(2) ){ // Que el total asignado sea igual al total de pagos
 			alert('El valor a reducir de la factura, sobrepasa el valor pendiente de la misma.');
			return false;	
 		}else if(totalValorReducido.toFixed(2) > parseFloat( totalNetoDetalle - totalNCDetalle ).toFixed(2)){
 			alert('El valor a reducir de la factura, sobrepasa el valor neto de la misma.');
			return false;	
 		}
 	}
 	// METADATOS DEL DOCUMENTO PROPIAMENTE DICHO
 	if(!$("#numeroIdentificacionTitular").val() || $("#numeroIdentificacionTitular").val() == "" ){
 		alert('Defina el número de identificación del titular de la nota de crédito.');
		return false;	
 	}else if(!$("#nombreTitular").val() || $("#nombreTitular").val() == "" ){
 		alert('Defina el nombre del titular de la nota de crédito.');
		return false;	
 	}else if(!$("#nombreTitular").val() || $("#nombreTitular").val() == "" ){
 		alert('Defina el nombre del titular de la nota de crédito.');
		return false;	
 	}else if(!$("#emailTitular").val() || $("#emailTitular").val() == "" ){
 		alert('Defina el correo electrónico del titular de la nota de crédito.');
		return false;	
 	}else if(!$("#telefonoTitular").val() || $("#telefonoTitular").val() == "" ){
 		alert('Defina el número de teléfono del titular de la nota de crédito.');
		return false;	
 	}else if(!$("#direccionTitular").val() || $("#direccionTitular").val() == "" ){
 		alert('Defina la dirección del titular de la nota de crédito.');
		return false;	
 	}

	return true;
}
function generaNotaCredito(div, url)
{   //if(validacionFinal()){
		var notaCredito = {};
	
		notaCredito['cabecera'] = {};
		notaCredito['cabecera']['codigoFactura'] = $('#codigoFactura').val();
		notaCredito['cabecera']['codigoAlumno'] = $('#codigoCliente').val();
		notaCredito['cabecera']['tipoIdentificacionTitular'] = $('#tipoIdentificacionTitular').val();
		notaCredito['cabecera']['numeroIdentificacionTitular'] = $('#numeroIdentificacionTitular').val();
		notaCredito['cabecera']['nombreTitular'] = $('#nombreTitular').val();
		notaCredito['cabecera']['emailTitular'] = $('#emailTitular').val();
		notaCredito['cabecera']['direccionTitular'] = $('#direccionTitular').val();
		notaCredito['cabecera']['telefonoTitular'] = $('#telefonoTitular').val();
		notaCredito['cabecera']['total'] = $('#totalValoresNotaCredito').val();
		notaCredito['detalle'] = [];		

		$('#detalleNotaCredito_table tbody tr').each(function(){
			var detalle = {};
			detalle["secuenciaDetalle"] = $(this).find('td').eq(0).attr('data-iddetalle');
			detalle["codigoProducto"] = $(this).find('td').eq(0).text();
			detalle["descripcion"] = $(this).find('td').eq(1).text();;
			detalle["valorBruto"] = parseFloat($(this).find('td').eq(3).text())-parseFloat($(this).find('td').eq(4).text());
			detalle["valorDescuento"] = $(this).find('td').eq(4).text();
			detalle["valorIVA"] = $(this).find('td').eq(5).text();
			detalle["valorNeto"] = $(this).find('td').eq(6).text();

			notaCredito['detalle'].push(detalle);
		});

		document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
		var data = new FormData();
		data.append('event', 'ingresaNotaCredito');
		data.append('datosNotaCredito', JSON.stringify(notaCredito));

		var xhrnc = new XMLHttpRequest();
		xhrnc.open('POST', url , true);
		xhrnc.onreadystatechange=function()
		{   if (xhrnc.readyState==4 && xhrnc.status==200)
			{   document.getElementById(div).innerHTML=xhrnc.responseText;
				var codigoNC=$("#nc_generada").val()
				generaNcElect(codigoNC,'div_detalle_sri',url);
			}
		};
		xhrnc.send(data);
}
function generaNcElect(codigoNC,div,url)
{   document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var data = new FormData();
	data.append('event', 'SendNotaCreditoSRI');
	data.append('codigoNC', codigoNC);

	var xhrsnc = new XMLHttpRequest();
	xhrsnc.open('POST', url , true);
	xhrsnc.onreadystatechange=function()
	{   if ( xhrsnc.readyState === 4 && xhrsnc.status === 200 )
		{   document.getElementById(div).innerHTML=xhrsnc.responseText;
			limpiaPagina(false);
			var dataClient = new FormData();
			dataClient.append('event', 'get_deudas_pendientes');
			dataClient.append('codigoCliente', $('#codigoCliente').val());

			var xhr_II = new XMLHttpRequest();
			xhr_II.open('POST', url , true);
			xhr_II.onreadystatechange=function()
			{   if (xhr_II.readyState==4 && xhr_II.status==200)
				{   document.getElementById('deudasPendiente_table').innerHTML=xhr_II.responseText;

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
							{className: "dt-body-center" , "targets": [7]},
							{className: "dt-body-center", "targets": [8]}
						]
					});

					// ==================================================
					// Actualiza el total de las deudas pendientes
					var subtotal = 0;
					$('#deudasPendiente_table tbody tr').each( function()
					{   subtotal += parseFloat($(this).find('td').eq(5).text());
					});
					$('#totalDeudasPendientes').val(subtotal);					
					$('#detalleNotaCredito_table tbody tr').each( function()
					{   $(this).remove();	
					});
				}
			};
		}
	};
	xhrsnc.send(data);
}