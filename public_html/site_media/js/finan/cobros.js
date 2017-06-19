 $(document).ready(function() { //jimmy
	$('#btn_folder_deudasPendientes').on('click', function () {
        var $el = $(this),
            textNode = this.lastChild;
        $el.find('span').toggleClass('glyphicon-folder-close glyphicon-folder-open');
    });
	$('a_folder_deudasPendientes').on('click', function () {
        var $el = $('#btn_folder_deudasPendientes'),
            textNode = this.lastChild;
        $el.find('span').toggleClass('glyphicon-folder-close glyphicon-folder-open');
    });
	$('#modal_msg').on('hidden.bs.modal', function () {
		document.getElementById('modal_msg_body').innerHTML='div align="center" style="height:100%;">Por favor, espere<br><br><i style="color:darkred;" class="fa fa-cog fa-spin"></i></div>';
		document.getElementById('modal_msg_footer').innerHTML='<button type="button" class="btn btn-default" data-dismiss="modal">Ocultar</button>';
	})
	$('#deudasPendiente_table').DataTable({
		"bPaginate": true,
		"bStateSave": false,
		"bAutoWidth": false,
		"bScrollAutoCss": true,
		"bProcessing": true,
		"bRetrieve": true,
		"sDom": '<"H"CTrf>t<"F"lip>',
		"sScrollXInner": "110%",
		"fnInitComplete": function() {
			this.css("visibility", "visible");
		},
		paging: false,
		lengthChange: false,
		searching: false,
		"info": false,
	    "retrieve" : true,
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
        "language": {"url":spanish}
  	});

  	$('#pagos_table').DataTable({
      	"info": false,
      	"ordering": false,
      	"searching":false,
      	"lengthChange":false,
      	"paging":false,
      	"retrieve" : true,
		"responsive":true,
        "language": {"url":spanish}
  	});   
	$('#form').validator().on('submit', function (e)
	{	//$('#form').validator('validate');
		if (e.isDefaultPrevented())
		{	// handle the invalid form...
			//alert('basara');
		}
		else
		{	// everything looks good!
			//e.preventDefault();
			//agregarPago('{ruta_html_finan}/cobros/controller.php');
		}
	})
});

// Carga el formulario para buscar a un cliente especifico
function validaAgregarPago(url)
{	var formaPago = document.getElementById('formaPago_asign').value;
	if (formaPago!=-1)
	{	document.getElementById('div_formas_de_pago').style.display = "block";
		agregarPago2(url);
	}else
	{	var mensaje = "¡Error! Faltaron completar algunos datos.";
		$.growl.error({ title: 'Educalinks informa', message: mensaje });
	}
	return false
}
function js_cobros_selecciona( div_buttons, div_body, tipo_persona )
{   var codigoCliente = $('#persona_table tr.selected').find('td:nth-child(1)').text();
	$('#hd_tipo_persona').val( tipo_persona );
	$('#codigoCliente').val( codigoCliente );
	$('#numeroIdentificacionCliente').val($('#persona_table tr.selected').find('td:nth-child(2)').text());
	$('#nombresCliente').val($('#persona_table tr.selected').find('td:nth-child(3)').text());
	
	$('#pagos_table tbody tr').each(function(){
		$(this).remove();	// Remuevo la información de formas de pago.
	});
	document.getElementById('Totalabonado').value='';
	// === Consulta de los datos del titular del cliente seleccionado
	var data = new FormData();
	data.append('event', 'get_cliente_info_adicional');
	data.append('codigoCliente', codigoCliente );
	data.append('tipo_persona', tipo_persona );
	var nivel='';
	var grupo='';
	var xhr = new XMLHttpRequest();
	xhr.open('POST', document.getElementById('ruta_html_common').value + '/persona/controller.php' , true);
	xhr.onreadystatechange=function(){
		if ( xhr.readyState === 4 && xhr.status === 200 )
		{   // Parse del JSON enviado desde PHP
			if( xhr.responseText.length > 0 )
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
				$('#numeroIdentificacionTitular').val(respuesta[0].cedulatitular);
				$('#nombreTitular').val(respuesta[0].nombretitular);
				$('#emailTitular').val(respuesta[0].emailtitular);
				$('#telefonoTitular').val(respuesta[0].telefonotitular);
				$('#direccionTitular').val(respuesta[0].direcciontitular);
				
				$('#tipoIdentificacionTitular').val('CI');	
				if( tipo_persona == 1 )
				{   carga_cliente_opciones(codigoCliente,'client_options');
					document.getElementById('div_datos_academicos_estudiante').style.display="inline";
				}
				else
				{   document.getElementById('client_options').innerHTML="";
					document.getElementById('div_datos_academicos_estudiante').style.display="none";
				}
				js_cobros_selecciona_get_deuda( codigoCliente, tipo_persona );
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
function js_cobros_selecciona_get_deuda( codigoCliente, tipo_persona )
{   var data = new FormData();
	data.append( 'event', 'get_deudas' );
	data.append( 'codigoCliente', codigoCliente );
	data.append( 'tipo_persona', tipo_persona );

	var xhr = new XMLHttpRequest();
	xhr.open('POST', document.getElementById('ruta_html_finan').value + '/cobros/controller.php' , true);
	xhr.onreadystatechange=function()
	{   if (xhr.readyState==4 && xhr.status==200)
		{   document.getElementById('formularioCobro').style.display='block';
			document.getElementById('EducaLinksHelperCliente2').style.display='none';
			document.getElementById('div_noticia_deudas_anteriores').style.display='none';
			document.getElementById('deudasPendiente_table').innerHTML=xhr.responseText;

			// ==================================================
			// Actualiza el total de las deudas pendientes
			var subtotal = 0;
			$('#deudasPendiente_table tbody tr').each(function(){
				subtotal += parseFloat($(this).find('td').eq(8).text());
			});
			$('#deudasPendiente_table tbody tr').each(function(){
				//subtotal += parseFloat($(this).find('td').eq(8).text());
				//$(this).find('td').eq(8).text('$' + String(parseFloat($(this).find('td').eq(8).text()))) ;
			});
			$('#totalDeudasPendientes').val(subtotal.toFixed(2));
			justificaMensajeNoData($('#deudasPendiente_table'),'resultado'); 
			// ==================================================
			// Limpia la tabla de las deudas seleccionadas
			$('#deudasSeleccionadas_table tbody tr').each(function(){
				if($(this).find('td').eq(0).hasClass('dataTables_empty')!=true){
					$(this).remove();	
				}
			});
			justificaMensajeNoData($('#deudasSeleccionadas_table'),'resultadoPendientesCobro'); // Agrego el div que coloca el datatable donde dice: "No data available in table"
			//justificaMensajeNoData($('#tabla_deudasPendientes'),'resultado');
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
			$('#collapse_deudasPendientes').collapse();
		}
	};
	xhr.send(data);
}
function carga_busquedaCliente(div,url){
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
                    "language": {"url":spanish_in}
                });
            } 
	}
	xhr.send(data);
}

//sumar abonado

// Carga el formulario para agregar un pago
function carga_formularioPago(div, url)
{   document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
	var data = new FormData();
	data.append('event', 'agregarPago');	
	var xhr = new XMLHttpRequest();
	xhr.open('POST', url , true);
	xhr.onreadystatechange=function()
	{   if (xhr.readyState==4 && xhr.status==200){
			if( xhr.responseText.length > 0 )
			{   document.getElementById(div).innerHTML=xhr.responseText;
			}
		}
	};
	xhr.send(data);
}
// Carga el formulario para agregar los metadatos de cada forma de pago
function carga_formularioMetadata(div, url)
{   document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
	var metadata= $('#formaPago_asign').find(':selected').text();
	var data = new FormData();
	data.append('event', 'get_metadata_form');
	data.append('formaPago', metadata);
	data.append('codigoCliente', document.getElementById('codigoCliente').value );
	data.append('tipo_persona', document.getElementById('hd_tipo_persona').value );
	var xhr = new XMLHttpRequest();
	xhr.open('POST', url , true);
	xhr.onreadystatechange=function()
	{   if (xhr.readyState==4 && xhr.status==200)
		{   document.getElementById(div).innerHTML=xhr.responseText;
			$('[data-toggle="popover"]').popover({html:true});
			$(function() {$('#monto').maskMoney({thousands:'', decimal:'.', allowZero:false});});
			$("#fechaDeposito").datepicker();
			$("#fechaDeposito").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
			$("#fechaTransaccion").datepicker();
			$("#fechaTransaccion").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
		}
	};
	xhr.send(data);
}
// Consulta filtrada de los clientes
function busca_clientes(filtro, div, url)
{   var spanish_in="//cdn.datatables.net/plug-ins/f2c75b7247b/i18n/Spanish.json";
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
	            "ordering": true,
	            "searching":false,
	            "lengthChange":false,
	            "paging":true,
                 "language": {
                     "url":spanish_in
                 }
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
// Manda los datos del cliente seleccionado a la pagina de la factura (deuda)
function selecciona(url){
	// Paso de los datos del cliente seleccionado
	//document.getElementById('client_options').innerHTML="";
	var spanish_in="//cdn.datatables.net/plug-ins/f2c75b7247b/i18n/Spanish.json";
	var codigoCliente = $('#clientes_table tr.selected').find('td:nth-child(1)').text();
	$('#codigoCliente').val(codigoCliente);
	$('#numeroIdentificacionCliente').val($('#clientes_table tr.selected').find('td:nth-child(2)').text());
	$('#nombresCliente').val($('#clientes_table tr.selected').find('td:nth-child(3)').text());

	// === Consulta de los datos del titular del cliente seleccionado
	var data = new FormData();
	data.append('event', 'get_deudas');
	data.append('codigoCliente', $('#clientes_table tr.selected').find('td:nth-child(1)').text());

	var xhr = new XMLHttpRequest();
	xhr.open('POST', url , true);
	xhr.onreadystatechange=function(){
		if (xhr.readyState==4 && xhr.status==200){
			document.getElementById('formularioCobro').style.display='block';
			document.getElementById('EducaLinksHelperCliente2').style.display='none';
			document.getElementById('div_noticia_deudas_anteriores').style.display='none';
			document.getElementById('deudasPendiente_table').innerHTML=xhr.responseText;

			// ==================================================
			// Actualiza el total de las deudas pendientes
			var subtotal = 0;
			$('#deudasPendiente_table tbody tr').each(function(){
				subtotal += parseFloat($(this).find('td').eq(8).text());
			});
			$('#deudasPendiente_table tbody tr').each(function(){
				//subtotal += parseFloat($(this).find('td').eq(8).text());
				//$(this).find('td').eq(8).text('$' + String(parseFloat($(this).find('td').eq(8).text()))) ;
			});
			$('#totalDeudasPendientes').val(subtotal.toFixed(2));
			justificaMensajeNoData($('#deudasPendiente_table'),'resultado'); 
			// ==================================================
			// Limpia la tabla de las deudas seleccionadas
			$('#deudasSeleccionadas_table tbody tr').each(function(){
				if($(this).find('td').eq(0).hasClass('dataTables_empty')!=true){
					$(this).remove();	
				}
			});
			justificaMensajeNoData($('#deudasSeleccionadas_table'),'resultadoPendientesCobro'); // Agrego el div que coloca el datatable donde dice: "No data available in table"
			//justificaMensajeNoData($('#tabla_deudasPendientes'),'resultado');
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
			carga_cliente_opciones(codigoCliente,'client_options');
			$('#collapse_deudasPendientes').collapse();
		}else{
			
		}
	};
	xhr.send(data);
}
// Verifico si en la grilla de las deudas seleccionadas para cobro ya existe una que seleccioné arriba.
function deudaAgregadaParaCobro(codigoDeuda){
	var existe = false;
	$('#deudasSeleccionadas_table tbody tr').each(function(){
		if( $(this).find('td').eq(0).data('codigo') == codigoDeuda  ){
			existe = true;
		}
	});

	return existe;
}
function validaFechaVencimiento(codigo,div,url)
{   var xhr = new XMLHttpRequest();
	xhr.onreadystatechange=function()
	{   if (xhr.readyState==4 && xhr.status==200)
		{   var arreglo = eval (xhr.responseText);
			var mensaje ="";
			var titulo="";
			if(arreglo.length >0){
				var ultimo_indice=arreglo.length-1;
				var plural=0;
				for (var i=0; i<(arreglo.length); i++){
					plural=plural+1;
				}
				if(plural>1)
				{	titulo="Deudas Pendientes";
					mensaje="Las siguientes deudas est&aacute;n pendientes de pago: <br><br>";
				}else{
					titulo="Deuda Pendiente";
					mensaje="La siguiente deuda est&aacute; pendiente de pago: <br><br>";
				}
				for (var i=0; i<(arreglo.length); i++){
					mensaje += arreglo[i]['descripcionDeuda']+'. Total: $'+arreglo[i]['deud_totalPendiente']+'<br>';
				}
				if(plural>1)
				{	mensaje+="<br>Por favor, cancelar las deudas pendientes primero.";
				}else{
					mensaje+="<br>Por favor, cancelar la deuda pendiente primero.";
				}
				if(deudaAgregadaParaCobro(arreglo[ultimo_indice]['deud_codigo'])){
					seleccionarDeuda(codigo,div,url);
				}else{
					$.growl.error({ title: 'Educalinks informa', message: 'Tiene deudas previas pendientes de pago. '+
						'<a style="color:white;text-decoration:underline;" href="#div_noticias_deudas_anteriores"><i class="fa fa-search"></i>&nbsp;Ver deudas</a>' });
					document.getElementById('div_noticia_deudas_anteriores').innerHTML="<div class='alert alert-info fade in'><a href='#' class='close' data-dismiss='alert'>&times;</a><strong>¡Informaci&oacute;n! </strong>"+mensaje+"</div>";
					document.getElementById('div_noticia_deudas_anteriores').style.display="block";
					return false;
				}
			}else{
				seleccionarDeuda(codigo,div,url);
			}
		} 
	};
	var data = new FormData();
	data.append('event', 'trae_deudas_vencidas_anteriores');
	data.append('cabFact_codigo', codigo);
	xhr.open('POST', url , true);
	xhr.send(data);
}
function js_cobros_pagado_cero ( codigo, url )
{   document.getElementById('modal_msg_body').innerHTML='div align="center" style="height:100%;">Por favor, espere<br><br><i style="color:darkred;" class="fa fa-cog fa-spin"></i></div>';
	var xhr = new XMLHttpRequest();
	var data = new FormData();
	data.append('event', 'marcar_pagado_cero');
	data.append('deud_codigo', codigo);
	xhr.open('POST', url , true);
	xhr.onreadystatechange=function()
	{   if (xhr.readyState==4 && xhr.status==200)
		{   var n = xhr.responseText.length;
			if (n > 0)
			{   valida_tipo_growl(xhr.responseText);
			}
			else
			{   $.growl.warning({ title: "Educalinks informa:",message: "Proceso realizado." });
			}
			$('#modal_msg').modal('hide');
			js_cobros_selecciona( 'span_button_save_person','', document.getElementById('hd_tipo_persona').value );//Para volver a cargar las deudas
		}
	};
	xhr.send(data);
}
// Agrega una deuda pendiente de cobro a la grilla de las deudas a cobrar
function seleccionarDeuda(codigo,div,url)
{   $('#deudasSeleccionadas_table tbody tr').each(function(){
		if($(this).attr('class')=='odd'){
			$(this).remove();	// Quito el div que coloca el datatable donde dice: "No data available in table"
		}
	});
	var idDeudaSeleccionada='deudaSeleccionada'+randomString(); // Identifico el input para validaciones posteriores
	$('#deudasPendiente_table tbody tr').each(function(){
		if($(this).find('td').eq(0).text()==codigo){
			if(!deudaAgregadaParaCobro(codigo)){
				var totalPendiente = $(this).find('td').eq(8).text();
				if ( totalPendiente === '0.00' )
				{	$('#modal_msg').modal('show');
					document.getElementById('modal_msg_body').innerHTML='La deuda seleccionada tiene un total pendiente de $0.00. El sistema la marcará como "PAGADA".';
					
					document.getElementById('modal_msg_footer').innerHTML='<button type="button" class="btn btn-default" data-dismiss="modal">Ahora no, por favor</button>' +
						'<button type="button" class="btn btn-primary" data-dismiss="modal"' +
						'onclick="js_cobros_pagado_cero('+$(this).find('td').eq(0).text()+',\'' + document.getElementById("ruta_html_finan").value +
						'/cobros/controller.php\')"><span class=\'glyphicon glyphicon-record\'></span>&nbsp;Marcar como pagado</button>';
				}
				else
				{   var nuevaLinea = "<tr>";	
					nuevaLinea += "<td data-codigo='"+$(this).find('td').eq(0).text()+"' style='text-align:center;vertical-align:baseline;'>"+$(this).find('td').eq(1).text()+"</td>";
					nuevaLinea += "<td data-prontopago='"+$(this).find('td').eq(3).text()+"' style='text-align:center;vertical-align:baseline;'>"+$(this).find('td').eq(8).text()+"</td>";
					nuevaLinea += "<td  style='text-align:center;vertical-align:baseline;'>"+
								  " <input id='"+idDeudaSeleccionada+"' class='txtAbonoDeuda form-control input-sm' " + 
								  " title='No exceder valores de deuda o de pago.' data-placement='right'" +
								  " onmouseover='$("+idDeudaSeleccionada+").tooltip(\"show\")' " + 
								  " onfocus='$("+idDeudaSeleccionada+").tooltip(\"show\")' "+ 
								  " onkeypress='return validaDesbordamientoAbono(event, this,document.getElementById("+'"'+"totalPagos"+'"'+").value,"+$(this).find('td').eq(8).text()+");' " +
								  " onkeyup='actualizaTotalDeudasSeleccionadas();' style='padding: 0;' type='text' value='' placeholder='0000.00' /></td>";
					nuevaLinea += " <td style='text-align:center;vertical-align:baseline;'><span onclick='quitarDeuda("+'"'+$(this).find('td').eq(0).text()+'"'+")' " + 
								  " onmouseover='$(this).tooltip(\"show\")' " +
								  " class='btn_opc_lista_eliminar glyphicon glyphicon-remove-circle cursorlink' aria-hidden='true' data-placement='bottom' title='Eliminar'></span></td>";
					nuevaLinea += "</tr>";
					$('#deudasSeleccionadas_table tbody').append(nuevaLinea);
					$(function() {$('#'+idDeudaSeleccionada).maskMoney({thousands:'', decimal:'.', allowZero:false});});
					$.growl.notice({ title: "Educalinks informa:", message: "Deuda seleccionada exitosamente" });
					document.getElementById('resultadoPendientesCobro').style.display='block';
				}
			}else{
				$.growl.error({ title: "Educalinks informa:", message: "Deuda ya seleccionada" });
			}
		}
	});
	validaHabilitacionMontosAbono();

	actualizaTotalDeudasSeleccionadas();
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
	var saldo=0;
	var pago=document.getElementById('totalPagos').value;
	var totalabonado=document.getElementById('Totalabonado').value;
	var deudaspendientes=0;
	deudaspendientes=document.getElementById('totalDeudasSeleccionadas').value;
 	$('#deudasSeleccionadas_table tbody tr').each(function(){
 		if(!$(this).find('td').eq(0).attr('class')){ 
 			pendiente += parseFloat($(this).find('td').eq(1).text());
 			abonado += (!$(this).find('td').eq(2).find('input').val()? 0 : parseFloat($(this).find('td').eq(2).find('input').val()));
 		}
 	});
	var total = parseFloat(pendiente - abonado);
	saldo = parseFloat(pago - abonado);
	
 	$('#totalDeudasSeleccionadas').val(total.toFixed(2));	
	$('#Totalabonado').val(abonado.toFixed(2));	
	if(pago!='' && saldo >0 && deudaspendientes >0){
	$('#saldofavor').val(saldo.toFixed(2))
	} 
	else if(saldo <0)
	{
	$('#saldofavor').val(0)	;
	}
	else
	{
	$('#saldofavor').val(0)	;
	}
}

// Valida que no se desborden los abonos asignados por el usuario deacuerdo a los pagos ingresados por el mismo
function validaDesbordamientoAbono (e, field, totalPagos, max_value)
{	var maximo=0;
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
	{	var mensajeError='Valor excedido. Por favor, ingrese un monto menor o igual a la deuda';
		$.growl.warning({ title: 'Educalinks informa', message: mensajeError });
		regexp = /.[0-9]{5}$/
		field.value=parseFloat(0).toFixed(2);
		if(document.getElementById('Totalabonado').value <= totalPagos)
		{
			return !(regexp.test(field.value));
		}
		
	}
}

// Quita una deuda de la grilla lista a cobrar 
function quitarDeuda(codigoDeuda){
	$('#deudasSeleccionadas_table tbody tr').each(function(){
		if( $(this).find('td').eq(0).data('codigo') == codigoDeuda  ){
			$(this).remove();
		}
	});
	justificaMensajeNoData($('#deudasSeleccionadas_table'),'resultadoPendientesCobro'); // Agrego el div que coloca el datatable donde dice: "No data available in table"

	actualizaTotalDeudasSeleccionadas();
	
	setearMontosAsignados();
	
	var saldopendiente=document.getElementById('Totalabonado').value;
	var totalabonado=document.getElementById('Totalabonado').value;
	if(totalabonado!=0){
	document.getElementById('totalDeudasSeleccionadas').value=saldopendiente;}
	document.getElementById('Totalabonado').value=0.00;
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

function agregarPago2(url)
{	$('#pagos_table tbody tr').each(function()
	{   if($(this).attr('class')=='odd')
		{
			$(this).remove();	// Quito el div que coloca el datatable donde dice: "No data available in table"
		}
	});

	// Creo el objeto JSON de los metadatos para retenerlos en cada fila de su pago correspondiente
	var metadato = {};
	switch($('#formaPago_asign').find(':selected').text()){
		case 'EFECTIVO':
			metadato['formaPago'] = 'EFECTIVO'; 
			metadato['codigoFormaPago'] = $('#formaPago_asign').find(':selected').val(); 
			metadato['monto'] = $('#monto').val(); 
			metadato['observacion'] = $('#observacion').val(); 
			break;
		case 'CHEQUE':
			metadato['formaPago'] = 'CHEQUE'; 
			metadato['codigoFormaPago'] = $('#formaPago_asign').find(':selected').val(); 
			metadato['banco'] = $('#banco').find(':selected').val();
			metadato['monto'] = $('#monto').val();
			metadato['numeroCheque'] = $('#numeroCheque').val();
			metadato['numeroCuenta'] = $('#numeroCuenta').val();
			metadato['girador'] = $('#nombreGirador').val();
			metadato['titular'] = $('#nombreTitular').val();
			metadato['fechaDeposito'] = $('#fechaDeposito').val();
			metadato['observacion'] = $('#observacion').val();
			break;
		case 'TARJETA DE CREDITO':
			metadato['formaPago'] = 'TARJETA CREDITO'; 
			metadato['codigoFormaPago'] = $('#formaPago_asign').find(':selected').val(); 
			metadato['tarjetaCredito'] = $('#tarjetaCredito').find(':selected').val();
			metadato['monto'] = $('#monto').val();
			metadato['numero'] = $('#numero').val();
			metadato['titular'] = $('#titular').val();
			metadato['lote'] = $('#lote').val();
			metadato['referencia'] = $('#referencia').val();
			//metadato['fechaCaducidad'] = $('#fechaCaducidad').val();
			metadato['red_de_pago'] = $('#red_de_pago').val();
			metadato['observacion'] = $('#observacion').val();
			break;
		case 'DEPOSITO':
			metadato['formaPago'] = 'DEPOSITO'; 
			metadato['codigoFormaPago'] = $('#formaPago_asign').find(':selected').val(); 
			metadato['banco'] = $('#banco').find(':selected').val();
			//metadato['numeroCuentaOrigen'] = $('#numeroCuentaOrigen').val();
			metadato['numeroCuentaDestino'] = $('#cuentaDestino').find(':selected').val();
			metadato['referencia'] = $('#referencia').val();
			metadato['fechaTransaccion'] = $('#fechaTransaccion').val();
			metadato['monto'] = $('#monto').val();
			metadato['observacion'] = $('#observacion').val();
			break;
		case 'TRANSFERENCIA':
			metadato['formaPago'] = 'TRANSFERENCIA'; 
			metadato['codigoFormaPago'] = $('#formaPago_asign').find(':selected').val(); 
			metadato['banco'] = $('#banco').find(':selected').val();
			metadato['numeroCuentaOrigen'] = $('#numeroCuentaOrigen').val();
			metadato['numeroCuentaDestino'] = $('#cuentaDestino').find(':selected').val();
			metadato['referencia'] = $('#referencia').val();
			metadato['fechaTransaccion'] = $('#fechaTransaccion').val();
			metadato['monto'] = $('#monto').val();
			metadato['observacion'] = $('#observacion').val();
			break; 
		case 'SALDOS A FAVOR':
			metadato['formaPago'] = 'SALDOS FAVOR'; 
			metadato['codigoFormaPago'] = $('#formaPago_asign').find(':selected').val(); 
			metadato['monto'] = $('#monto').val();
			break; 
		case 'DOCUMENTO INTERNO':
			metadato['formaPago'] = 'DOCUMENTO INTERNO'; 
			metadato['codigoFormaPago'] = $('#formaPago_asign').find(':selected').val(); 
			metadato['monto'] = $('#monto').val(); 
			metadato['detalle'] = $('#detalle').val(); 
			metadato['observacion'] = $('#observacion').val(); 
			break;
	}

	// Genero un identificador para cada fila del pago (Para identificacion en acciones posteriores)
	var idPago = randomString();
	var nuevoPago = '<tr>';
		nuevoPago += "<td style='text-align:center;' data-id='"+idPago+"'  data-meta='"+JSON.stringify(metadato)+"' >"+$('#formaPago_asign').find(':selected').text()+"</td>";
		nuevoPago += "<td style='text-align:center;'>"+$('#monto').val()+"</td>";
		
	if ( $('#formaPago_asign').find(':selected').text() != 'SALDOS A FAVOR' )
		nuevoPago += "<td style='text-align:center;'><span onclick='cargaFormularioEditarPago("+'"'+url+'"'+","+'"'+idPago+'"'+")' class='glyphicon glyphicon-pencil cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_editarPago' onmouseover='$(this).tooltip(\"show\")' title='Editar Pago'  data-placement='left'></span></td>";
	else
		nuevoPago += "<td style='text-align:center;font-size:x-small;'>N/A</td>";
		nuevoPago += "<td style='text-align:center;'><span onclick='quitarPago("+'"'+idPago+'"'+")' class='btn_opc_lista_eliminar glyphicon glyphicon-remove-circle cursorlink' aria-hidden='true' onmouseover='$(this).tooltip(\"show\")' title='Eliminar' data-placement='bottom'></span></td>";
		nuevoPago += '</tr>';
	$('#pagos_table tbody').append(nuevoPago);

	validaHabilitacionMontosAbono();

	actualizaTotalPagosAgregados();

	//$('#resultadoMetadata').empty(); // Esto es para que cuando se editen los pagos, no interfieran los valores del último formulario
	document.getElementById('formaPago_asign').value="";
	document.getElementById('resultadoMetadata').innerHTML= "<div id='frm_pagoNones' class='form-horizontal' ><div class='alert alert-success'><strong>¡&Eacute;xito!</strong>"
		+"<br> Forma de pago agregada. Puede seleccionar otra forma de pago o cerrar esta ventana haciendo clic en <a href='#' data-dismiss='modal'>Cerrar</a>.</div></div>";
	
}
function agregarPago( url )
{	if(validacionCamposNecesarios($('#formaPago_asign').find(':selected').text().trim()))
	{	$('#pagos_table tbody tr').each(function(){
			if($(this).attr('class')=='odd'){
				$(this).remove();	// Quito el div que coloca el datatable donde dice: "No data available in table"
			}
		});

		// Creo el objeto JSON de los metadatos para retenerlos en cada fila de su pago correspondiente
		var metadato = {};
		switch($('#formaPago_asign').find(':selected').text()){
			case 'EFECTIVO':
				metadato['formaPago'] = 'EFECTIVO'; 
				metadato['codigoFormaPago'] = $('#formaPago_asign').find(':selected').val(); 
				metadato['monto'] = $('#monto').val(); 
				metadato['observacion'] = $('#observacion').val(); 
				break;
			case 'CHEQUE':
				metadato['formaPago'] = 'CHEQUE'; 
				metadato['codigoFormaPago'] = $('#formaPago_asign').find(':selected').val(); 
				metadato['banco'] = $('#banco').find(':selected').val();
				metadato['monto'] = $('#monto').val();
				metadato['numeroCheque'] = $('#numeroCheque').val();
				metadato['numeroCuenta'] = $('#numeroCuenta').val();
				metadato['girador'] = $('#nombreGirador').val();
				metadato['titular'] = $('#nombreTitular').val();
				metadato['fechaDeposito'] = $('#fechaDeposito').val();
				metadato['observacion'] = $('#observacion').val();
				break;
			case 'TARJETA DE CREDITO':
				metadato['formaPago'] = 'TARJETA CREDITO'; 
				metadato['codigoFormaPago'] = $('#formaPago_asign').find(':selected').val(); 
				metadato['tarjetaCredito'] = $('#tarjetaCredito').find(':selected').val();
				metadato['monto'] = $('#monto').val();
				metadato['numero'] = $('#numero').val();
				metadato['titular'] = $('#titular').val();
				metadato['lote'] = $('#lote').val();
				metadato['referencia'] = $('#referencia').val();
				//metadato['fechaCaducidad'] = $('#fechaCaducidad').val();
				metadato['red_de_pago'] = $('#red_de_pago').val();
				metadato['observacion'] = $('#observacion').val();
				break;
			case 'DEPOSITO':
				metadato['formaPago'] = 'DEPOSITO'; 
				metadato['codigoFormaPago'] = $('#formaPago_asign').find(':selected').val(); 
				metadato['banco'] = $('#banco').find(':selected').val();
				//metadato['numeroCuentaOrigen'] = $('#numeroCuentaOrigen').val();
			    metadato['numeroCuentaDestino'] = $('#cuentaDestino').find(':selected').val();
				metadato['referencia'] = $('#referencia').val();
				metadato['fechaTransaccion'] = $('#fechaTransaccion').val();
				metadato['monto'] = $('#monto').val();
				metadato['observacion'] = $('#observacion').val();
				break;
			case 'TRANSFERENCIA':
				metadato['formaPago'] = 'TRANSFERENCIA'; 
				metadato['codigoFormaPago'] = $('#formaPago_asign').find(':selected').val(); 
				metadato['banco'] = $('#banco').find(':selected').val();
				metadato['numeroCuentaOrigen'] = $('#numeroCuentaOrigen').val();
				metadato['numeroCuentaDestino'] = $('#cuentaDestino').find(':selected').val();
				metadato['referencia'] = $('#referencia').val();
				metadato['fechaTransaccion'] = $('#fechaTransaccion').val();
				metadato['monto'] = $('#monto').val();
				metadato['observacion'] = $('#observacion').val();
				break; 
			case 'SALDOS A FAVOR':
				metadato['formaPago'] = 'SALDOS FAVOR'; 
				metadato['codigoFormaPago'] = $('#formaPago_asign').find(':selected').val(); 
				metadato['monto'] = $('#monto').val();
				break; 
			case 'DOCUMENTO INTERNO':
				metadato['formaPago'] = 'DOCUMENTO INTERNO'; 
				metadato['codigoFormaPago'] = $('#formaPago_asign').find(':selected').val(); 
				metadato['monto'] = $('#monto').val(); 
				metadato['detalle'] = $('#detalle').val(); 
				metadato['observacion'] = $('#observacion').val(); 
				break;
		}

		// Genero un identificador para cada fila del pago (Para identificacion en acciones posteriores)
		var idPago = randomString();
		var nuevoPago = '<tr>';
			nuevoPago += "<td data-id='"+idPago+"'  data-meta='"+JSON.stringify(metadato)+"' >"+$('#formaPago_asign').find(':selected').text()+"</td>";
			nuevoPago += '<td>'+$('#monto').val()+'</td>';
			nuevoPago += '<td>';
			nuevoPago += "<span onclick='quitarPago("+'"'+idPago+'"'+")' class='glyphicon glyphicon-remove cursorlink' aria-hidden='true' title='Eliminar Pago'>&nbsp;</span>";
			nuevoPago += "<span onclick='cargaFormularioEditarPago("+'"'+url+'"'+","+'"'+idPago+'"'+")' class='glyphicon glyphicon-pencil cursorlink' aria-hidden='true' data-toggle='modal' data-target='#modal_editarPago' title='Editar Pago'>&nbsp;</span>";
			nuevoPago += '</td>';
			nuevoPago += '</tr>';
		$('#pagos_table tbody').append(nuevoPago);

		validaHabilitacionMontosAbono();

		actualizaTotalPagosAgregados();

		//$('#resultadoMetadata').empty(); // Esto es para que cuando se editen los pagos, no interfieran los valores del último formulario
		document.getElementById('resultadoMetadata').innerHTML= "";
	
	} // Fin de la validación de los campos necesarios
}

function actualizaTotalPagosAgregados(){
	var abonado = 0;
	var saldoafavor=0;
	var deudas =document.getElementById('totalDeudasSeleccionadas').value;
 	$('#pagos_table tbody tr').each(function(){
 		if(!$(this).find('td').eq(0).attr('class')){ 
 			abonado += parseFloat($(this).find('td').eq(1).text());
 		}
 	});
	saldoafavor=abonado-deudas;
 	$('#totalPagos').val(abonado.toFixed(2));
	
}

function quitarPago(idPago){
	$('#pagos_table tbody tr').each(function(){
		if( $(this).find('td').eq(0).data('id') == idPago  ){
			$(this).remove();
		}
	});
	validaHabilitacionMontosAbono();

	justificaMensajeNoData($('#pagos_table'),'div_formas_de_pago');

	actualizaTotalPagosAgregados();
	
	setearMontosAsignados();
}

function setearMontosAsignados(){
	$('#deudasSeleccionadas_table tbody tr').each(function(){
		$(this).find('td').eq(2).find('input').val("");
	});
}

function justificaMensajeNoData(tabla, div){
	if( tabla.find('tbody').find('tr').length <= 0 )
	{	//tabla.clear();
		//tabla.draw();
		document.getElementById(div).style.display = "none";
		//tabla.find('tbody').append("<tr class='odd'><td class='datatTables_empty' valign='top' colspan='8' style='text-align: center;' >Ningún dato disponible en esta tabla</td></tr>");	
	}else
	{
		document.getElementById(div).style.display = "block";
	}
	//alert(tabla.find('tbody').find('tr').length);
}


function cargaFormularioEditarPago(url, idPago)
{	document.getElementById( 'modal_editarPago_body' ).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
	var data = new FormData();
	data.append('event', 'editarPago');
	data.append('idPago', idPago);
	$('#pagos_table tbody tr').each(function(){
		if($(this).find('td').eq(0).attr('data-id') == idPago){
			//var metadatos = $(this).find('td').eq(0).attr('data-meta');
			data.append('metadato', $(this).find('td').eq(0).attr('data-meta'));
		}
	});

	var xhr = new XMLHttpRequest();
	xhr.open('POST', url , true);
	xhr.onreadystatechange=function()
	{   if (xhr.readyState==4 && xhr.status==200)
		{	document.getElementById('modal_editarPago_body').innerHTML=xhr.responseText;
			$(function() {$('#monto').maskMoney({thousands:'', decimal:'.', allowZero:false});;})
			$("#fechaDeposito").datepicker();
			$("#fechaDeposito").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
			$("#fechaTransaccion").datepicker();
			$("#fechaTransaccion").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
		}
	};
	xhr.send(data);
}
function validaEditarPago(url)
{	var formaPago = document.getElementById('frm_editarPago').value;
	if (formaPago!=-1)
	{	editarPago2();
	}else
	{	alert("¡Error! Faltaron completar algunos datos.");
	}
	return false
}
function editarPago2() {
	var nombreFormaPago = $('#nombreFP').val();
	var metadato = {};
	var idPago = $('#pago').val();
	switch(nombreFormaPago){
		case 'EFECTIVO':
			metadato['formaPago'] = 'EFECTIVO'; 
			metadato['codigoFormaPago'] = $('#codigoFP').val(); 
			metadato['monto'] = $('#monto').val(); 
			metadato['observacion'] = $('#observacion').val(); 
			break;
		case 'CHEQUE':
			metadato['formaPago'] = 'CHEQUE'; 
			metadato['codigoFormaPago'] = $('#codigoFP').val(); 
			metadato['banco'] = $('#banco').find(':selected').val();
			metadato['monto'] = $('#monto').val();
			metadato['numeroCheque'] = $('#numeroCheque').val();
			metadato['numeroCuenta'] = $('#numeroCuenta').val();
			metadato['girador'] = $('#nombreGirador').val();
			metadato['titular'] = $('#nombreTitular').val();
			metadato['fechaDeposito'] = $('#fechaDeposito').val();
			metadato['observacion'] = $('#observacion').val();
			break;
		case 'TARJETA CREDITO':
			metadato['formaPago'] = 'TARJETA CREDITO'; 
			metadato['codigoFormaPago'] = $('#codigoFP').val(); 
			metadato['tarjetaCredito'] = $('#tarjetaCredito').find(':selected').val();
			metadato['monto'] = $('#monto').val();
			metadato['numero'] = $('#numero').val();
			metadato['titular'] = $('#titular').val();
			metadato['lote'] = $('#lote').val();
			metadato['referencia'] = $('#referencia').val();
			//metadato['fechaCaducidad'] = $('#fechaCaducidad').val();
			metadato['red_de_pago'] = $('#red_de_pago').val();
			metadato['observacion'] = $('#observacion').val();
			break;
		case 'DEPOSITO':
			metadato['formaPago'] = 'DEPOSITO'; 
			metadato['codigoFormaPago'] = $('#codigoFP').val(); 
			metadato['banco'] = $('#banco').find(':selected').val();
			//metadato['numeroCuentaOrigen'] = $('#numeroCuentaOrigen').val();
			metadato['numeroCuentaDestino'] = $('#cuentaDestino').find(':selected').val();
			metadato['referencia'] = $('#referencia').val();
			metadato['fechaTransaccion'] = $('#fechaTransaccion').val();
			metadato['monto'] = $('#monto').val();
			metadato['observacion'] = $('#observacion').val();
			break;
		case 'TRANSFERENCIA':
			metadato['formaPago'] = 'TRANSFERENCIA'; 
			metadato['codigoFormaPago'] = $('#codigoFP').val(); 
			metadato['banco'] = $('#banco').find(':selected').val();
			metadato['numeroCuentaOrigen'] = $('#numeroCuentaOrigen').val();
			metadato['numeroCuentaDestino'] = $('#cuentaDestino').find(':selected').val();
			metadato['referencia'] = $('#referencia').val();
			metadato['fechaTransaccion'] = $('#fechaTransaccion').val();
			metadato['monto'] = $('#monto').val();
			metadato['observacion'] = $('#observacion').val();
			break;
		case 'DOCUMENTO INTERNO':
			metadato['formaPago'] = 'DOCUMENTO INTERNO';
			metadato['codigoFormaPago'] = $('#codigoFP').val();
			metadato['monto'] = $('#monto').val();
			metadato['detalle'] = $('#detalle').val();
			metadato['observacion'] = $('#observacion').val();
			break;
	}

	
	$('#pagos_table tbody tr').each(function(){
		if($(this).find('td').eq(0).attr('data-id')==idPago){
			$(this).find('td').eq(1).text(metadato.monto);
			$(this).find('td').eq(0).attr('data-meta',JSON.stringify(metadato));
		}
	});
	
	actualizaTotalPagosAgregados();

	setearMontosAsignados();
	
	$.growl.notice({ title: 'Educalinks informa', message: 'Cambios almacenados' });
}
function editarPago() {
	var nombreFormaPago = $('#nombreFP').val();
	if(validacionCamposNecesarios(nombreFormaPago.trim())){
		
		var metadato = {};
		var idPago = $('#pago').val();
		switch(nombreFormaPago){
			case 'EFECTIVO':
				metadato['formaPago'] = 'EFECTIVO'; 
				metadato['codigoFormaPago'] = $('#codigoFP').val(); 
				metadato['monto'] = $('#monto').val(); 
				metadato['observacion'] = $('#observacion').val(); 
				break;
			case 'CHEQUE':
				metadato['formaPago'] = 'CHEQUE'; 
				metadato['codigoFormaPago'] = $('#codigoFP').val(); 
				metadato['banco'] = $('#banco').find(':selected').val();
				metadato['monto'] = $('#monto').val();
				metadato['numeroCheque'] = $('#numeroCheque').val();
				metadato['numeroCuenta'] = $('#numeroCuenta').val();
				metadato['girador'] = $('#nombreGirador').val();
				metadato['titular'] = $('#nombreTitular').val();
				metadato['fechaDeposito'] = $('#fechaDeposito').val();
				metadato['observacion'] = $('#observacion').val();
				break;
			case 'TARJETA CREDITO':
				metadato['formaPago'] = 'TARJETA CREDITO'; 
				metadato['codigoFormaPago'] = $('#codigoFP').val(); 
				metadato['tarjetaCredito'] = $('#tarjetaCredito').find(':selected').val();
				metadato['monto'] = $('#monto').val();
				metadato['numero'] = $('#numero').val();
				metadato['titular'] = $('#titular').val();
				metadato['lote'] = $('#lote').val();
				metadato['referencia'] = $('#referencia').val();
				//metadato['fechaCaducidad'] = $('#fechaCaducidad').val();
				metadato['red_de_pago'] = $('#red_de_pago').val();
				metadato['observacion'] = $('#observacion').val();
				break;
			case 'DEPOSITO':
				metadato['formaPago'] = 'DEPOSITO'; 
				metadato['codigoFormaPago'] = $('#codigoFP').val(); 
				metadato['banco'] = $('#banco').find(':selected').val();
				//metadato['numeroCuentaOrigen'] = $('#numeroCuentaOrigen').val();
				metadato['numeroCuentaDestino'] = $('#cuentaDestino').find(':selected').val();
				metadato['referencia'] = $('#referencia').val();
				metadato['fechaTransaccion'] = $('#fechaTransaccion').val();
				metadato['monto'] = $('#monto').val();
				metadato['observacion'] = $('#observacion').val();
				break;
			case 'TRANSFERENCIA':
				metadato['formaPago'] = 'TRANSFERENCIA'; 
				metadato['codigoFormaPago'] = $('#codigoFP').val(); 
				metadato['banco'] = $('#banco').find(':selected').val();
				metadato['numeroCuentaOrigen'] = $('#numeroCuentaOrigen').val();
				metadato['numeroCuentaDestino'] = $('#cuentaDestino').find(':selected').val();
				metadato['referencia'] = $('#referencia').val();
				metadato['fechaTransaccion'] = $('#fechaTransaccion').val();
				metadato['monto'] = $('#monto').val();
				metadato['observacion'] = $('#observacion').val();
				break;
			case 'DOCUMENTO INTERNO':
				metadato['formaPago'] = 'DOCUMENTO INTERNO';
				metadato['codigoFormaPago'] = $('#codigoFP').val();
				metadato['monto'] = $('#monto').val();
				metadato['detalle'] = $('#detalle').val();
				metadato['observacion'] = $('#observacion').val();
				break;
		}

		
		$('#pagos_table tbody tr').each(function(){
			if($(this).find('td').eq(0).attr('data-id')==idPago){
				$(this).find('td').eq(1).text(metadato.monto);
				$(this).find('td').eq(0).attr('data-meta',JSON.stringify(metadato));
			}
		});
		
		actualizaTotalPagosAgregados();

		setearMontosAsignados();

	} // Fin de la validación de los campos necesarios
}

function generaPago(div, url)
{   var bandera=0;
	var codigoCliente = $('#codigoCliente').val();
	var totalPagos = $('#totalPagos').val();
	if(validacionFinal())
	{   document.getElementById('btn_modal_resultadoPago_new_cl').disabled='disabled';
		document.getElementById('btn_modal_resultadoPago_current_cl').disabled='disabled';
		document.getElementById('btn_modal_resultadoPago_pagos').disabled='disabled';
		document.getElementById('btn_modal_resultadoPago_gestionFac').disabled='disabled';
		document.getElementById('btn_gen_pago').disabled=true;
		var pago = {};
		pago['cabecera'] = {};
		pago['cabecera']['codigoCliente'] = codigoCliente;
		pago['cabecera']['tipoPersona'] = document.getElementById( 'hd_tipo_persona' ).value;
		pago['cabecera']['total'] = totalPagos;
		pago['detalle'] = [];
		$('#pagos_table tbody tr').each(function()
		{   var metadatos = JSON.parse($(this).find('td').eq(0).attr('data-meta'));
			var detalle = {};
			detalle['codigoFormaPago'] = metadatos['codigoFormaPago'];
			detalle['formaPago'] = metadatos['formaPago'];
			detalle['monto'] = metadatos['monto'];
			detalle['metadato'] = {};
			switch(metadatos['formaPago']){
				case 'EFECTIVO':
					detalle['metadato']['observacion'] = metadatos['observacion'];
					break;
				case 'CHEQUE':
				 bandera=1;
					detalle['metadato']['banco'] = metadatos['banco'];
					detalle['metadato']['numeroCheque'] = metadatos['numeroCheque'];
					detalle['metadato']['numeroCuenta'] = metadatos['numeroCuenta'];
					detalle['metadato']['girador'] = metadatos['girador'];
					detalle['metadato']['titular'] = metadatos['titular'];
					detalle['metadato']['fechaDeposito'] = metadatos['fechaDeposito'];
					detalle['metadato']['observacion'] = metadatos['observacion'];
					break;
				case 'TARJETA CREDITO':
					detalle['metadato']['tarjetaCredito'] = metadatos['tarjetaCredito'];
					detalle['metadato']['numero'] = metadatos['numero'];
					detalle['metadato']['titular'] = metadatos['titular'];
					detalle['metadato']['lote'] = metadatos['lote'];
					detalle['metadato']['referencia'] = metadatos['referencia'];
					//detalle['metadato']['fechaCaducidad'] = metadatos['fechaCaducidad'];
					detalle['metadato']['red_de_pago'] = metadatos['red_de_pago'];
					detalle['metadato']['observacion'] = metadatos['observacion'];
					break;
				case 'DEPOSITO':
					detalle['metadato']['banco'] = metadatos['banco'];
					//detalle['metadato']['numeroCuentaOrigen'] = metadatos['numeroCuentaOrigen'];
					detalle['metadato']['numeroCuentaDestino'] = metadatos['numeroCuentaDestino'];
					detalle['metadato']['referencia'] = metadatos['referencia'];
					detalle['metadato']['fechaTransaccion'] = metadatos['fechaTransaccion'];
					detalle['metadato']['observacion'] = metadatos['observacion'];
					break;
				case 'TRANSFERENCIA':
					detalle['metadato']['banco'] = metadatos['banco'];
					detalle['metadato']['numeroCuentaOrigen'] = metadatos['numeroCuentaOrigen'];
					detalle['metadato']['numeroCuentaDestino'] = metadatos['numeroCuentaDestino'];
					detalle['metadato']['referencia'] = metadatos['referencia'];
					detalle['metadato']['fechaTransaccion'] = metadatos['fechaTransaccion'];
					detalle['metadato']['observacion'] = metadatos['observacion'];
					break;
				case 'DOCUMENTO INTERNO':
					detalle['metadato']['detalle'] = metadatos['detalle'];
					detalle['metadato']['observacion'] = metadatos['observacion'];
					break;
			}
			pago['detalle'].push(detalle);
		});

	 	pago['deudasAfectadas'] = [];
	 	$('#deudasSeleccionadas_table tbody tr').each(function()
		{   var deudas = {};
			var prontopago = $(this).find('td').eq(1).attr('data-prontopago');
			var deuda_pendiente = parseFloat($(this).find('td').eq(1).text());
			var abono = $(this).find('td').eq(2).find('input').val();
			
	 		deudas['codigoDeuda'] = $(this).find('td').eq(0).attr('data-codigo');
	 		deudas['abono'] = abono;
			
			if(abono==deuda_pendiente)
			{
				deudas['prontopago']=$(this).find('td').eq(1).attr('data-prontopago');
			}
			else
			{
				deudas['prontopago']= 0 ;
			}
	 		pago['deudasAfectadas'].push(deudas);
			//alert("va al xml:" + deudas['prontopago'] +" abono: "+ abono +" prontopago:"+ prontopago +" deuda_pendiente:"+ deuda_pendiente);
	 	});
		var codigoFC=0;
	 	
		var saldo=0;
		if(document.getElementById('saldofavor').value!='')
		{
			saldo=document.getElementById('saldofavor').value;
		}
		else
		{
			saldo=0
		}
		var data = new FormData();
		data.append('event', 'ingresaPago');
		data.append('datosPago', JSON.stringify(pago));
		data.append('valor',saldo);
		
		document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
        $( '#modal_resultadoPago' ).modal('show');
		
		var xhrpago = new XMLHttpRequest();
		xhrpago.open('POST', url , true);
		//js_cobros_limpiar_despues_de_pago_existoso();
		xhrpago.onreadystatechange=function()
		{   if (xhrpago.readyState==4 && xhrpago.status==200)
			{	var n = xhrpago.responseText.length;
				if (n > 0)
				{   document.getElementById('modal_resultadoPago_body').innerHTML = xhrpago.responseText;
					document.getElementById('btn_modal_resultadoPago_new_cl').disabled = '';
					document.getElementById('btn_modal_resultadoPago_current_cl').disabled = '';
					document.getElementById('btn_modal_resultadoPago_pagos').disabled = '';
					document.getElementById('btn_modal_resultadoPago_gestionFac').disabled = '';
					document.getElementById('btn_gen_pago').disabled=false;
					codigoFC = $("#fc_generada").val(); //PDTE. Si se va a manejar el crear más de una factura, enviar un arreglo de codigos.
					//js_cobros_limpiar_despues_de_pago_existoso();
					console.log('limpiar todo');
					if( ( $("#fc_generada").val().length > 0 ) && ( $("#fc_generada").val() != 'no tiene' ) )
						generaFcElect( codigoCliente, codigoFC, 'div_detalle_sri', url, bandera );
					else if( $("#fc_generada").val() != 'no tiene' )

					{   document.getElementById( 'div_detalle_sri' ).innerHTML = 
							"<div class='callout callout-info'><h4>Tiene más de una factura generada</h4>" + 
							"Sus facturas han sido enviadas a la bandeja de <a href='" + 
							"../gestionFacturas/'> gestión facturas</a>, " +
							"para su posterior envío al sistema de Comprobantes electrónicos del SRI </div>";
					}
					else
					{   document.getElementById( 'div_detalle_sri' ).innerHTML = "";
					}
				}
			}
			if (xhrpago.readyState==4 && xhrpago.status==500)
			{	var n = xhrpago.responseText.length;
				if (n > 0)
				{   document.getElementById('modal_resultadoPago_body').innerHTML = xhrpago.responseText;
					document.getElementById('btn_modal_resultadoPago_close').disabled=false;
					//js_cobros_limpiar_despues_de_pago_existoso();
					console.log('limpiar todo');
				}
			}
		};
		xhrpago.send(data);
	} // fin de condición que valida los campos necesarios
}
function generaFcElect( codigoCliente, codigoFC, div, url, bandera )
{   document.getElementById(div).innerHTML='Por favor, espere... <br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var data = new FormData();
	data.append('event', 'SendfacturaSRI');
	data.append('codigoFC', codigoFC);
	data.append('cheque', bandera);
	var xhrsnc = new XMLHttpRequest();
	xhrsnc.open('POST', url , true);
	xhrsnc.onreadystatechange=function()
	{   if (xhrsnc.readyState == 4 && xhrsnc.status == 200)
		{   if ( xhrsnc.responseText.length > 0 )
			{   document.getElementById(div).innerHTML=xhrsnc.responseText;
				document.getElementById('modal_resultadoPago_header').innerHTML="<strong>¡Pago realizado!</strong>";
			}
		}
	};
	xhrsnc.send(data);
}
function limpiaPagina(albedrio)
{   var confirmacion = true;
	if(albedrio){
		confirmacion = confirm("¿Está seguro de eliminar todo y empezar nuevamente?");
	}
	if( confirmacion ){
		$('#deudasSeleccionadas_table tbody tr').each(function(){
			$(this).remove();
		});
		justificaMensajeNoData($('#deudasSeleccionadas_table'),'resultadoPendientesCobro'); // Agrego el div que coloca el datatable donde dice: "No data available in table"
		actualizaTotalDeudasSeleccionadas();

		$('#pagos_table tbody tr').each(function(){
			$(this).remove();
		});
		justificaMensajeNoData($('#pagos_table'),'div_formas_de_pago');
		actualizaTotalPagosAgregados();

		justificaMensajeNoData($('#deudasPendiente_table'),'resultado');
	}
}
function limpiaPaginanoq(albedrio){
	$('#deudasSeleccionadas_table tbody tr').each(function(){
		$(this).remove();
	});
	justificaMensajeNoData($('#deudasSeleccionadas_table'),'resultadoPendientesCobro'); // Agrego el div que coloca el datatable donde dice: "No data available in table"
	actualizaTotalDeudasSeleccionadas();

	$('#pagos_table tbody tr').each(function(){
		$(this).remove();
	});
	justificaMensajeNoData($('#pagos_table'),'div_formas_de_pago');
	actualizaTotalPagosAgregados();

	justificaMensajeNoData($('#deudasPendiente_table'),'resultado');
	document.getElementById('modal_resultadoPago_header').innerHTML='<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button><h4 class="modal-title" id="myModalLabel">Resultado de la operación</h4>';
	document.getElementById('modal_resultadoPago_body').innerHTML='...';
}

function js_cobros_limpiar_despues_de_pago_existoso(){
	$('#deudasSeleccionadas_table tbody tr').each(function(){
		$(this).remove();
	});
	justificaMensajeNoData($('#deudasSeleccionadas_table'),'resultadoPendientesCobro'); // Agrego el div que coloca el datatable donde dice: "No data available in table"
	actualizaTotalDeudasSeleccionadas();

	$('#pagos_table tbody tr').each(function(){
		$(this).remove();
	});
	justificaMensajeNoData($('#pagos_table'),'div_formas_de_pago');
	actualizaTotalPagosAgregados();
	
	$('#deudasPendiente_table tbody tr').each(function(){
		$(this).remove();
	});
	justificaMensajeNoData($('#deudasPendiente_table'),'resultado');
	document.getElementById('codigoCliente').value='';
	document.getElementById('numeroIdentificacionCliente').value='';
	document.getElementById('nombresCliente').value='';
	document.getElementById('txt_grupo_economico').value='';
	document.getElementById('txt_curso').value='';
	document.getElementById('txt_nivel_economico').value='';
	document.getElementById('formularioCobro').style.display='none';
	document.getElementById('EducaLinksHelperCliente2').style.display='inline';
	document.getElementById('client_options').innerHTML='';
	document.getElementById('Totalabonado').value='';
}
function mostrarDetalleDeuda(codigoDeuda, div, url){
	document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
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
			    "ordering": true,
			    "searching":true,
			    "lengthChange":false,
			    "paging":false,
			    "responsive":true
			});
		}
	}
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
			    "info": true,
			    "ordering": true,
			    "searching":true,
			    "lengthChange":false,
			    "paging":false,
			    "responsive":true,
				"language": {"url":spanish},
				"columnDefs": [
					{"title": "<span style='color:black'>C&oacute;digo de Pago</span>", className: "dt-body-center", "targets": [ 0 ]},
					{"title": "<span style='color:black'>Fecha de pago</span>", className: "dt-body-center" , "targets": [1]},
					{"title": "<span style='color:DarkGreen'>Total pago</span>", className: "dt-body-right" , "targets": [2]}
				]
			});
		} 
	}
	xhr.send(data);
}

function validacionCamposNecesarios( formaPago )
{   var mensajeError = '';
	switch(formaPago.trim()){
		case "EFECTIVO":
			if(!$('#monto').val() || $('#monto').val() == ""){
				mensajeError = 'No ha definido el monto.';
				break;
			}else if($('#monto').val() < 0){
				mensajeError = 'El valor del monto está mal definido.';
				break;
			}
			break;
		case "CHEQUE":
			if($('#banco').find('option:selected').val() < 0){
				mensajeError = 'No ha seleccionado el banco.';
				break;
			}else if(!$('#monto').val() || $('#monto').val() == ""){
				mensajeError = 'No ha definido el monto para el pago.';
				break;
			}else if($('#monto').val() < 0){
				mensajeError = 'El valor del monto está mal definido.';
				break;
			}else if(!$('#numeroCheque').val() || $('#numeroCheque').val() == ""){
				mensajeError = 'No ha definido el número del cheque.';
				break;
			}else if(!$('#numeroCuenta').val() || $('#numeroCuenta').val() == ""){
				mensajeError = 'No ha definido el número de la cuenta del cheque.';
				break;
			}else if(!$('#nombreGirador').val() || $('#nombreGirador').val() == ""){
				mensajeError = 'No ha definido al girador del cheque.';
				break;
			}else if(!$('#nombreTitular').val() || $('#nombreTitular').val() == ""){
				mensajeError = 'No ha definido el titular del cheque.';
				break;
			}else if(!$('#fechaDeposito').val() || $('#fechaDeposito').val() == ""){
				mensajeError = 'No ha definido la fecha de depósito del cheque.';
				break;
			}
			break;
		case "TARJETA DE CREDITO":
			if($('#tarjetaCredito').find('option:selected').val() < 0){
				mensajeError = 'No se ha seleccionado la tarjeta de crédito usada.';
				break;
			}else if(!$('#monto').val() || $('#monto').val() == ""){
				mensajeError = 'No ha definido el monto del pago.';
				break;
			}else if($('#monto').val() < 0){
				mensajeError = 'El valor del monto está mal definido.';
				break;
			}else if(!$('#numero').val() || $('#numero').val() == ""){
				mensajeError = 'No ha definido el número de la tarjeta de crédito.';
				break;
			}else if(!$('#titular').val() || $('#titular').val() == ""){
				mensajeError = 'No ha definido el titular de la tarjeta.';
				break;
			}else if(!$('#lote').val() || $('#lote').val() == ""){
				mensajeError = 'No ha definido el lote de la transacción.';
				break;
			}else if(!$('#referencia').val() || $('#referencia').val() == ""){
				mensajeError = 'No ha definido el número referencial de la transacción.';
				break;
			}
			break;
		case "TRANSFERENCIA":
			if($('#banco').find('option:selected').val() < 0){
				mensajeError = 'No ha seleccionado el banco.';
			}else if(!$('#monto').val() || $('#monto').val() == ""){
				mensajeError = 'No ha definido el monto.';
			}else if($('#monto').val() < 0){
				mensajeError = 'El valor del monto está mal definido.';
			}else if(!$('#numeroCuentaOrigen').val() || $('#numeroCuentaOrigen').val() == ""){
				mensajeError = 'No ha definido el número de la cuenta de origen.';
			}else if($('#cuentaDestino').find('option:selected').val() < 0){
				mensajeError = 'No ha seleccionado la cuenta de destino.';
			}else if(!$('#referencia').val() || $('#referencia').val() == ""){
				mensajeError = 'No ha definido el número referencial de la transacción.';
			}else if(!$('#fechaTransaccion').val() || $('#fechaTransaccion').val() == ""){
				mensajeError = 'No ha definido la fecha de la transacción.';
			}
			break;
		case "DEPOSITO":
			if($('#banco').find('option:selected').val() < 0){
				mensajeError = 'No ha seleccionado el banco.';
			}else if(!$('#monto').val() || $('#monto').val() == ""){
				mensajeError = 'No ha definido el monto.';
			}else if($('#monto').val() < 0){
				mensajeError = 'El valor del monto está mal definido.';
			}
			//else if(!$('#numeroCuentaOrigen').val() || $('#numeroCuentaOrigen').val() == ""){
				//mensajeError = 'No ha definido el número de la cuenta de origen.';
			//}
			else if($('#cuentaDestino').find('option:selected').val() < 0){
				mensajeError = 'No ha seleccionado la cuenta de destino.';
			}else if(!$('#referencia').val() || $('#referencia').val() == ""){
				mensajeError = 'No ha definido el número referencial de la transacción.';
			}else if(!$('#fechaTransaccion').val() || $('#fechaTransaccion').val() == ""){
				mensajeError = 'No ha definido la fecha de la transacción.';
			}
			break;
	}
	if( mensajeError != '' )
	{   
        $.growl.warning({ title: 'Educalinks informa', message: mensajeError });
		return false;
	}
	else
		return true;
}

function validacionFinal()
{   $('#modal_resultadoPago_body').empty();
	// CLIENTE CONSULTADO
	if(!$('#codigoCliente').val()){
		var mensaje='Seleccione un alumno/cliente para continuar';
		$.growl.warning({ title: 'Educalinks informa', message: mensaje });
		return false;
	}

	// SELECCIÓN DE DEUDAS PENDIENTES
	
	var totalDeudasSeleccionadas = 0;
	var totalAbonado = 0;
	var totalPagosAgregados = 0;
	var totalPagos = 0;
	
	$('#deudasSeleccionadas_table tbody tr').each(function(){
		if(!$(this).find('td').eq(0).attr('class')){ 
			totalDeudasSeleccionadas += 1;
			totalAbonado += (!$(this).find('td').eq(2).find('input').val()? 0 : parseFloat($(this).find('td').eq(2).find('input').val()));
		}
	});
	if (totalDeudasSeleccionadas <= 0)
	{
		var mensajeError='Seleccione una deuda para continuar.';
		$.growl.warning({ title: 'Educalinks informa', message: mensajeError });
		return false;
 	}
	else
	{
		// INGRESO DE LOS PAGOS
	
		$('#pagos_table tbody tr').each(function(){
			if(!$(this).find('td').eq(0).attr('class')){ 
				totalPagosAgregados += 1;
				totalPagos += (!$(this).find('td').eq(1).text()? 0 : parseFloat( $(this).find('td').eq(1).text() ) );
			}
		});
		if (totalPagosAgregados <= 0){
			var mensaje='Agregue un pago para continuar.'
			$.growl.warning({ title: 'Educalinks informa', message: mensaje });
			return false;
		}
		else
		{
			// Asignado algún valor de los pagos a las deudas seleccionadas
			if(totalAbonado.toFixed(2) <= 0){
				var mensajeError ='Asignar valores en tabla "Deudas a cancelar" para continuar.';
				$.growl.warning({ title: 'Educalinks informa', message: mensajeError });
				return false;
			}
		} 		
 	}

 	// METADATOS DE LAS FORMAS DE PAGO AGREGADAS
 	var metadatos = '';
 	var mensajeError = '';
 	$('#pagos_table tbody tr').each(function(){
		if(!$(this).find('td').eq(0).attr('class')){ 
			metadatos = JSON.parse($(this).find('td').eq(0).attr('data-meta'));

			switch(metadatos.formaPago.trim()){
				case "EFECTIVO":
					if( metadatos.monto == "" ){
						mensajeError = 'No ha definido el monto de un pago en efectivo.';
						break;
					}else if( metadatos.monto < 0 ){
						mensajeError = 'El valor de un pago en efectivo está mal definido.';
						break;
					}
					break;
				case "CHEQUE":
					if(metadatos.banco == "" || metadatos.banco < 0){
						mensajeError = 'No se ha seleccionado el banco en un pago con cheque.';
						break;
					}else if(metadatos.monto == ""){
						mensajeError = 'No ha definido el monto para un pago con cheque.';
						break;
					}else if(metadatos.monto < 0){
						mensajeError = 'El monto de un pago con cheque está mal definido.';
						break;
					}else if(metadatos.numeroCheque == ""){
						mensajeError = 'No ha definido el número del cheque en un pago.';
						break;
					}else if(metadatos.numeroCuenta == ""){
						mensajeError = 'No ha definido el número de la cuenta en un pago con cheque.';
						break;
					}else if(metadatos.girador == ""){
						mensajeError = 'No ha definido al girador del cheque en un pago.';
						break;
					}else if(metadatos.titular == ""){
						mensajeError = 'No ha definido el titular del cheque en un pago.';
						break;
					}else if(metadatos.fechaDeposito == ""){
						mensajeError = 'No ha definido la fecha de depósito del cheque en un pago.';
						break;
					}
					break;
				case "TARJETA DE CREDITO":
					if(metadatos.tarjetaCredito == "" || metadatos.tarjetaCredito < 0){
						mensajeError = 'No se ha seleccionado la marca de tarjeta de crédito en un pago.';
						break;
					}else if(metadatos.monto == ""){
						mensajeError = 'No ha definido el monto para un pago con tarjeta de crédito.';
						break;
					}else if(metadatos.monto < 0){
						mensajeError = 'El monto de un pago con tarjeta de crédito está mal definido.';
						break;
					}else if(metadatos.numero == ""){
						mensajeError = 'No se ha definido el número de la tarjeta de crédito en un pago.';
						break;
					}else if(metadatos.titular == ""){
						mensajeError = 'No se ha definido el titular de la tarjeta de crédito en un pago.';
						break;
					}else if(metadatos.lote == ""){
						mensajeError = 'No se ha definido el lote de la transacción en un pago con tarjeta de crédito.';
						break;
					}else if(metadatos.referencia == ""){
						mensajeError = 'No se ha definido el número referencial de la transacción en un pago con tarjeta de crédito.';
						break;
					}
					break;
				case "TRANSFERENCIA":
					if(metadatos.banco == "" || metadatos.banco < 0){
						mensajeError = 'No se ha seleccionado el banco en un pago con depósito bancario.';
					}else if(metadatos.monto == ""){
						mensajeError = 'No ha definido el monto para un pago con transferencia bancaria.';
					}else if(metadatos.monto < 0){
						mensajeError = 'El monto de un pago con transferencia bancaria está mal definido.';
					}else if(metadatos.numeroCuentaOrigen == "" || metadatos.numeroCuentaOrigen < 0){
						mensajeError = 'No ha definido el número de la cuenta de origen para un pago con transferencia bancaria.';
					}else if(metadatos.numeroCuentaDestino < 0){
						mensajeError = 'No se ha seleccionado la cuenta de destino para un pago con transferencia bancaria.';
					}else if(metadatos.referencia == ""){
						mensajeError = 'No se ha definido el número referencial para un pago con transferencia bancaria.';
					}else if(metadatos.fechaTransaccion == ""){
						mensajeError = 'No se ha definido la fecha de la transacción para un pago con transferencia bancaria.';
					}
					break;
				case "DEPOSITO":
					if(metadatos.banco == "" || metadatos.banco < 0){
						mensajeError = 'No se ha seleccionado el banco en un pago con depósito bancario.';
					}else if(metadatos.monto == ""){
						mensajeError = 'No ha definido el monto para un pago con depósito bancario.';
					}else if(metadatos.monto < 0){
						mensajeError = 'El monto de un pago con depósito bancario está mal definido.';
					}
					//else if(metadatos.numeroCuentaOrigen == "" || metadatos.numeroCuentaOrigen < 0){
					//	mensajeError = 'No ha definido el número de la cuenta de origen para un pago con depósito bancario.';
					//}
					else if(metadatos.numeroCuentaDestino < 0){
						mensajeError = 'No se ha seleccionado la cuenta de destino para un pago con depósito bancario.';
					}else if(metadatos.referencia == ""){
						mensajeError = 'No se ha definido el número referencial para un pago con depósito bancario.';
					}else if(metadatos.fechaTransaccion == ""){
						mensajeError = 'No se ha definido la fecha de la transacción para un pago con depósito bancario.';
					}
					break;
			}
		}
	});
 	if(mensajeError != ''){
		$.growl.warning({ title: 'Educalinks informa', message: mensajeError });
 		return false;
 	}
	return true;
}

function generaXML(url){
	var data = new FormData();
	data.append('event', 'get_xml_sri');	
	var xhr = new XMLHttpRequest();
	xhr.open('POST', url , true);
	xhr.onreadystatechange=function(){
		if (xhr.readyState==4 && xhr.status==200){
			//alert(xhr.responseText);
			document.getElementById('modal_resultadoPago_body').innerHTML=xhr.responseText;
		} 
	}
	xhr.send(data);
}
function enterpress_editpay(e){
	if (e.keyCode == 13) {
		editarPago();
		$('#modal_editarPago').modal('hide');
		return true;
    }
}
function pagoPDf(codigoPago)
{	var data = new FormData();
	data.append('event', 'print_pdf_pago');
	data.append('codigoPago', codigoPago);
	var xhr = new XMLHttpRequest();
	xhr.open('POST', '../PDF/controller.php' , true);
	xhr.onreadystatechange=function()
	{	if (xhr.readyState==4 && xhr.status==200)
		{	document.getElementById('modal_resultadoPago_body').innerHTML=xhr.responseText;
			//document.getElementById(div).innerHTML=xhr.responseText;
		} 
	}
	xhr.send(data);
}
function folder_deudasPendientes(){
	$('#collapse_deudasPendientes').collapse('toggle');
}