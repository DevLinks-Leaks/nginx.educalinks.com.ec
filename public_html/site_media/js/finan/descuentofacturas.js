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
			{className: "dt-body-center", "targets": [8]},
			{className: "dt-body-center", "targets": [9]}
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
});
function js_descuentofactura_busca(div,url)
{   var codigoCliente = document.getElementById('codigo').value;
	var tipo_persona = document.getElementById('hd_tipo_persona').value;
	document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var data = new FormData();
	data.append('event', 'get_deudas');
	data.append('codigoCliente', codigoCliente );
	data.append('tipo_persona', tipo_persona );
	var xhr = new XMLHttpRequest();
	xhr.open('POST', url , true);
	xhr.onreadystatechange=function()
	{   if (xhr.readyState==4 && xhr.status==200)
		{   document.getElementById(div).innerHTML=xhr.responseText;
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
					{className: "dt-body-center", "targets": [8]},
					{className: "dt-body-center", "targets": [9]}
				]
			});

			// ==================================================
			// Actualiza el total de las deudas pendientes
			var subtotal = 0;
			$('#deudasPendiente_table tbody tr').each(function(){
				subtotal += parseFloat($(this).find('td').eq(7).text());
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
			$("#descuento").numeric({ decimal : ".",  negative : false, scale: 2 });
		} 
	};
	xhr.send(data);
}
//guardar descuento
function js_descuentofactura_habilitar()
{   if(document.getElementById('checkporcentaje').checked){
		document.getElementById('porcentaje_descto').removeAttribute("readonly");
		document.getElementById('descuento').setAttribute("readonly","readonly");
		document.getElementById('checkvalor').setAttribute("disabled","disabled");
		//document.getElementById('checkvalor').checked=false;
	}
	else
	{   document.getElementById('porcentaje_descto').setAttribute("readonly","readonly");
		document.getElementById('checkvalor').removeAttribute("disabled");
	}
	
	if(document.getElementById('checkvalor').checked)
	{   document.getElementById('porcentaje_descto').setAttribute("readonly","readonly");
		document.getElementById('descuento').removeAttribute("readonly");
		document.getElementById('checkporcentaje').setAttribute("disabled","disabled");
		//document.getElementById('checkporcentaje').checked=false;
	}
	else
	{   document.getElementById('descuento').setAttribute("readonly","readonly");	
		document.getElementById('checkporcentaje').removeAttribute("disabled");
	}
}

function js_descuentofactura_save_asign(div,url)
{   var codigodeuda = document.getElementById('coddeuda').value;
	var valor_descto = document.getElementById('descuento').value;
	var porcentaje_descto = document.getElementById('porcentaje_descto').value;
	var codcliente=document.getElementById('codigo').value;
	var porcentajetotal=0;
	var valor1=0;
	$('#deudasPendiente_table  tbody tr').each(function(){
		var celda = $(this).children().eq(0);
		var valor =  $(celda).text();
		
		if(codigodeuda==valor)
		{   var celda1 = $(this).children().eq(2);
			 valor1 =  $(celda1).text();
		}	
	});
	if(porcentaje_descto <= 100)
	{   if(confirm("¿Está seguro que desea asignarle el descuento al alumno?"))
		{   var data = new FormData();
			data.append('event', 'asigna_descuento');
			data.append('codigodeuda', codigodeuda);
			data.append('codigoCliente', codcliente);
			if(document.getElementById('checkvalor').checked)
			{   data.append('valor_descuento', valor_descto);
				porcentajetotal=(100*valor_descto)/valor1;
				data.append('porcentaje_descuento', porcentajetotal);			
			}
			else
			{   porcentajetotal=(valor1*porcentaje_descto)/100;	
				data.append('valor_descuento', porcentajetotal);	
				data.append('porcentaje_descuento', porcentaje_descto);
			}
			var xhr = new XMLHttpRequest();
			xhr.open('POST', url , true);
			
			xhr.onreadystatechange=function()
			{   if (xhr.readyState==4 && xhr.status==200)
				{   js_descuentofactura_busca('resultado',url);
				} 
			};
			xhr.send(data);
		}
	}else
	{   alert('El porcentaje no puede ser mas del 100%.');
	}
}
function js_descuentofactura_del(codigo,div,div2,url){
	if(confirm("¿Está seguro que desea eliminar el descuento actual?")){
		var coddeuda =document.getElementById('coddeuda').value;
		document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
		var data = new FormData();
		data.append('event', 'delete');
		data.append('codigo', codigo);	
		
		var xhr = new XMLHttpRequest();
		xhr.open('POST', url , true);
		xhr.onreadystatechange=function(){
			if (xhr.readyState==4 && xhr.status==200){
				js_descuentofactura_busca('resultado',url);
				js_descuentofactura_carga_asignacion(coddeuda,div2,url);
			} 
		};
		xhr.send(data);
	}
}
function js_descuentofactura_selecciona( div_buttons, div_body, tipo_persona ){
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

	var xhr = new XMLHttpRequest();
	xhr.open('POST', document.getElementById('ruta_html_finan').value + '/descuentofacturas/controller.php' , true);
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
					{className: "dt-body-center", "targets": [7]},
					{className: "dt-body-center", "targets": [8]},
					{className: "dt-body-center", "targets": [9]}
				]
			});

			// ==================================================
			// Actualiza el total de las deudas pendientes
			var subtotal = 0;
			$('#deudasPendiente_table tbody tr').each(function(){
				subtotal += parseFloat($(this).find('td').eq(7).text());
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
	{   alert('Valor excedido, ingreso un monto menor o igual a la deuda');
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
function mostrarPagosDeuda(codigoDeuda, div, url){
	document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
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