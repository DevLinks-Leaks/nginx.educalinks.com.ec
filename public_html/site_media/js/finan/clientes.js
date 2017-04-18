$(document).ready(function(){
	$(".detalle").tooltip({
        'selector': '',
        'placement': 'bottom',
        'container': 'body',
		'tooltipClass': 'detalleTooltip'
    });
	$("#txt_fecha_nac_ini").datepicker();
    $("#txt_fecha_nac_fin").datepicker();
	$("#txt_fecha_nac_ini").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
	$("#txt_fecha_nac_fin").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
	$("#boton_busqueda").click(function(){
		$("#desplegable_busqueda").slideToggle(200);
	});
	$("#desplegable_busqueda").show();
	$('#cliente_table').addClass( 'nowrap' ).DataTable({
		dom: 'Bfrtip',
        buttons: [ 
			{ extend: 'copy', text: 'Copiar <i class="fa fa-copy"></i>' },
			{ extend: 'csv', text: 'CSV <i style="color:green" class="fa fa-file-excel-o"></i>' },
			{ extend: 'excel', text: 'Excel <i style="color:green" class="fa fa-file-excel-o"></i>' },
			{ extend: 'pdf', text: 'PDF <i style="color:red" class="fa fa-file-pdf-o"></i>' },
			{ extend: 'print', text: 'Imprimir <i style="color:#428bca" class="fa fa-print"></i>' },
			],
		"bPaginate": true,
		"bStateSave": false,
		"bAutoWidth": false,
		"bScrollAutoCss": true,
		"bProcessing": true,
		"bRetrieve": true,
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
				{className: "dt-body-center" , "targets": [2]}
			]
	});
	$('#modal_showDebtState').on('shown.bs.modal', function () {
	}); 
});
// Consulta filtrada
function js_clientes_buscar( div, url )
{   document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var data = new FormData();
	data.append('event', 'get_all_data');
	data.append('id_titular', document.getElementById("txt_id_titular").value);
	data.append('cod_estudiante', document.getElementById("txt_cod_cliente").value);
	data.append('id_cliente', document.getElementById("txt_id_estudiante").value);
	data.append('nombre_estudiante', document.getElementById("txt_nom_cliente").value);
	data.append('nombre_titular', document.getElementById("txt_nom_titular").value);
	data.append('estado', document.getElementById("cmb_estado").value);
	var chk_fecha_nac = document.getElementById("chk_fecha_nac").checked;
	if( chk_fecha_nac )
	{   data.append('fechanac_ini', document.getElementById("txt_fecha_nac_ini").value);
		data.append('fechanac_fin', document.getElementById("txt_fecha_nac_fin").value);
	}
	data.append('periodo', document.getElementById("periodos").value);
	data.append('grupoEconomico', document.getElementById("cmb_grupoEconomico").value);
	data.append('nivelEconomico', document.getElementById("cmb_nivelesEconomicos").value);
	data.append('curso', document.getElementById("curso").value);
	var xhr = new XMLHttpRequest();
	xhr.open('POST', url , true);
	xhr.onreadystatechange=function(){
		if (xhr.readyState==4 && xhr.status==200){
			document.getElementById(div).innerHTML=xhr.responseText;
			$('#cliente_table').addClass( 'nowrap' ).DataTable({
				dom: 'Bfrtip',
				buttons: [ 
					{ extend: 'copy', text: 'Copiar <i class="fa fa-copy"></i>' },
					{ extend: 'csv', text: 'CSV <i style="color:green" class="fa fa-file-excel-o"></i>' },
					{ extend: 'excel', text: 'Excel <i style="color:green" class="fa fa-file-excel-o"></i>' },
					{ extend: 'pdf', text: 'PDF <i style="color:red" class="fa fa-file-pdf-o"></i>' },
					{ extend: 'print', text: 'Imprimir <i style="color:#428bca" class="fa fa-print"></i>' },
					],
				"bPaginate": true,
				"bStateSave": false,
				"bAutoWidth": false,
				"bScrollAutoCss": true,
				"bProcessing": true,
				"bRetrieve": true,
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
// Carga el formulario para ingresar un nuevo registro
function carga_add(div,url){
	document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var data = new FormData();
	data.append('event', 'agregar');	
	var xhr = new XMLHttpRequest();
	xhr.open('POST', url , true);
	xhr.onreadystatechange=function(){
		if (xhr.readyState==4 && xhr.status==200){
			document.getElementById(div).innerHTML=xhr.responseText;
		} 
	}
	xhr.send(data);
}
// Carga el formulario para asignar la residencia al usuario
function js_clientes_carga_asignacion( codigo, div, url )
{   document.getElementById( div ).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var data = new FormData();
	data.append('event', 'asignarDescuento');	
	data.append('codigo', codigo);	
	var xhr = new XMLHttpRequest();
	xhr.open('POST', url , true);
	xhr.onreadystatechange=function(){
		if (xhr.readyState==4 && xhr.status==200)
		{   document.getElementById(div).innerHTML = xhr.responseText;
			$(function() {$('#porcentaje_descto').maskMoney({thousands:'', decimal:'.', allowZero:false});;})
			$('[data-toggle="popover"]').popover({html:true});
			$("#diasvalidez").numeric({ decimal : false,  negative : false, precision: 3 });
		}
	};
	xhr.send(data);
}
function js_clientes_descuento_alumno_delete ( codigo, div, url, codigo_alumno )
{   if(confirm("¿Está seguro que desea eliminar el producto actual?"))
	{   var data = new FormData();
		data.append('event', 'delete');
		data.append('codigo', codigo );
		var xhr = new XMLHttpRequest();
		xhr.open('POST', url , true);
		xhr.onreadystatechange=function()
		{   if (xhr.readyState==4 && xhr.status==200)
			{   $.growl.notice({ title: "Educalinks informa",message: "Proceso realizado." });
				js_clientes_carga_asignacion( codigo_alumno, "modal_asign_body", document.getElementById('ruta_html_finan').value + '/clientes/controller.php' );
			} 
		};
		xhr.send(data);
	}
}
// Carga el combo de las manzanas
function carga_porcentaje(valor,div, url){
	document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var data = new FormData();
	data.append('desc_codigo', valor);	
	data.append('event', 'get_porcentaje');	
	var xhr = new XMLHttpRequest();
	xhr.open('POST', url , true);
	xhr.onreadystatechange=function(){
		if (xhr.readyState==4 && xhr.status==200){
			document.getElementById(div).innerHTML =xhr.responseText;
		} 
	}
	xhr.send(data);
}
// Carga el formulario para editar un registro
function edit(codigo,div,url){
	document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var data = new FormData();
	data.append('event', 'get');
	data.append('codigo', codigo);	
	var xhr = new XMLHttpRequest();
	xhr.open('POST', url , true);
	xhr.onreadystatechange=function(){
		if (xhr.readyState==4 && xhr.status==200){
		document.getElementById(div).innerHTML=xhr.responseText;
		} 
	}
	xhr.send(data);
}
// Realiza la actualizacion de los datos en la BD
function save_edited(rol_codigo,div,url)
{   if(confirm("¿Está seguro que desea editar la información del cliente?"))
	{   document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
		var data = new FormData();
		data.append('event', 'edit');
		data.append('codigo', document.getElementById('codigo').value);
		data.append('tipoPersona', document.getElementById('tipoPersona').value);
		data.append('tipoIdentificacion', document.getElementById('tipoIdentificacion').value);
		data.append('numeroIdentificacion', document.getElementById('num_identificacion').value);
		data.append('nombres', document.getElementById('nombres').value);
		data.append('apellidos', document.getElementById('apellidos').value);
		data.append('telefono', document.getElementById('telefono').value);
		data.append('direccion', document.getElementById('direccion').value);
		data.append('fechaNacimiento', document.getElementById('fecha_nacimiento').value);
		data.append('email', document.getElementById('email').value);
		data.append('estadoCivil', document.getElementById('estadoCivil').value);
		
		//alert(data);
		var xhr = new XMLHttpRequest();
		xhr.open('POST', url , true);
		xhr.onreadystatechange=function()
		{   if (xhr.readyState==4 && xhr.status==200)
			{   js_clientes_carga_asignacion( codigo_alumno, "modal_asign_body", document.getElementById('ruta_html_finan').value + '/clientes/controller.php' );
			} 
		};
		xhr.send(data);
	}
}
// Realiza la asignacion de la residencia al cliente en la BD
function js_clientes_save_asign( cod_cliente, div, url )
{   var codigo_descto = document.getElementById( 'codigo_descto' );
	codigo_descto = codigo_descto.options[codigo_descto.selectedIndex].value;
	var porcentaje_descuento = document.getElementById( 'porcentaje_descto' ).value;
	if(codigo_descto >= 1 && porcentaje_descuento >= 1)
	{   if(porcentaje_descuento <= 100)
		{   if(confirm("¿Está seguro que desea asignarle el descuento al alumno?"))
			{   var data = new FormData();
				data.append('event', 'asigna_descuento');
				data.append('codigo', cod_cliente );
				data.append('codigo_descto', codigo_descto);
				data.append('porcentaje_descuento', porcentaje_descuento);
				data.append('diasvalidez', document.getElementById('diasvalidez').value);
				
				var xhr = new XMLHttpRequest();
				xhr.open('POST', url , true);
				xhr.onreadystatechange=function()
				{   if (xhr.readyState==4 && xhr.status==200)
					{   $.growl.notice({ title: "Educalinks informa",message: "Proceso realizado." });
						js_clientes_carga_asignacion( cod_cliente, div, url );
					} 
				};
				xhr.send(data);
			}
		}
		else
		{   alert('El porcentaje no puede ser mas del 100%.');
		}
	}
	else
	{   alert('Seleccione las opciones que faltan para continuar.');
	}
}
// Realiza el ingreso de un registro nuevo
function add(div,url)
{   document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var data = new FormData();
	data.append('event', 'set');
	data.append('tipoPersona', document.getElementById('tipoPersona_add').value);
	data.append('tipoIdentificacion', document.getElementById('tipoIdentificacion_add').value);
	data.append('numeroIdentificacion', document.getElementById('num_identificacion_add').value);
	data.append('nombres', document.getElementById('nombres_add').value);
	data.append('apellidos', document.getElementById('apellidos_add').value);
	data.append('direccion', document.getElementById('direccion_add').value);
	data.append('telefono', document.getElementById('telefono_add').value);
	data.append('fechaNacimiento', document.getElementById('fecha_nacimiento_add').value);
	data.append('email', document.getElementById('email_add').value);
	data.append('estadoCivil', document.getElementById('estadoCivil_add').value);
	var xhr = new XMLHttpRequest();
	xhr.open('POST', url , true);
	xhr.onreadystatechange=function(){
		if (xhr.readyState==4 && xhr.status==200){
			js_clientes_buscar( div, url );
		} 
	}
	xhr.send(data);
}
// Realiza la eliminacion del cliente en la BD
function del(codigo,div,url){
	if(confirm("¿Está seguro que desea eliminar el cliente?")){
		document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
		var data = new FormData();
		data.append('event', 'delete');
		data.append('codigo', codigo);	
		var xhr = new XMLHttpRequest();
		xhr.open('POST', url , true);
		xhr.onreadystatechange=function(){
			if (xhr.readyState==4 && xhr.status==200){
				js_clientes_buscar( div, url );
			} 
		}
		xhr.send(data);
	}
}

/* carga el formulario de filtro para la generación del estado de cuenta */
function carga_visorEstadoCuenta(codigo,div,url){
	document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var data = new FormData();
	data.append('event', 'estadoCuenta');	
	data.append('codigoEstudiante', codigo);	
	var xhr = new XMLHttpRequest();
	xhr.open('POST', url , true);
	xhr.onreadystatechange=function()
	{   if (xhr.readyState === 4 && xhr.status === 200 )
		{   document.getElementById(div).innerHTML = xhr.responseText;
			$("#txt_fecha_ini").datepicker();
			$("#txt_fecha_fin").datepicker();
			var table = $("#tabla_estadoCuenta").DataTable({
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
					{className: "dt-body-right"  , "targets": [3]},
					{className: "dt-body-right"  , "targets": [4]},
					{className: "dt-body-right"  , "targets": [5]},
					{className: "dt-body-right"  , "targets": [6]},
					{className: "dt-body-center" , "targets": [7]},
					{className: "dt-body-center" , "targets": [8]},
					{className: "dt-body-center" , "targets": [9]}
				]
			});
			table.page.len(10).draw();
			$('#tabla_estadoCuenta tbody').on('click', 'td.details-control', function ()
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
					var deudaCliente = [];
					deudaCliente = row.data();
					deud_codigo  = deudaCliente[1];
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
		}
	};
	xhr.send(data);
}

/* Envía a generar el reporte y a presentarlo */
function print_pdf(ruta){

	var codigoAlumno = $("#codigoEstudiante").val();
	var codigoPeriodo = ( document.getElementById("chk_periodo").checked==true ? $("#combo_periodo option:selected").val() : "");
	var fechaInicio = ( document.getElementById("chk_fecha").checked==true ? $("#txt_fecha_ini").val() : "");
	var fechaFin = ( document.getElementById("chk_fecha").checked==true ? $("#txt_fecha_fin").val() : "");

	window.open(ruta+"?event=print_report&codigoAlumno="+codigoAlumno+"&codigoPeriodo="+codigoPeriodo+"&fechaInicio="+fechaInicio+"&fechaFin="+fechaFin);
}
function print_cert_pdf(ruta){
	var doit = 'yes';
    if ( ( document.getElementById('combo_periodo').value == -1 ) || ( document.getElementById('combo_periodo').value == 0 ) )
    {   $.growl.warning({ title: "Educalinks informa", message: "¡Debe seleccionar un período para poder descargar el Certificado financiero!" });
        doit = 'no';
    }
	console.log(doit);
    if( doit === 'yes' )
    {
		var codigoAlumno = $("#codigoEstudiante").val();
		var codigoPeriodo = ( document.getElementById("chk_periodo").checked==true ? $("#combo_periodo option:selected").val() : "");
		var fechaInicio = ( document.getElementById("chk_fecha").checked==true ? $("#txt_fecha_ini").val() : "");
		var fechaFin = ( document.getElementById("chk_fecha").checked==true ? $("#txt_fecha_fin").val() : "");

		window.open( ruta+"?event=print_cert_report&codigoAlumno="+codigoAlumno+"&codigoPeriodo="+codigoPeriodo );
	}
}
/* Valida el bloqueo o desbloque de un filtro de búsqueda del reporte estado de cuenta */
function validaFiltros(control, div, url){
	if(control.checked == true)
	{   /* Deshabilitar filtro */
		if(control.getAttribute("id") == "chk_periodo")
		{   document.getElementById("combo_periodo").removeAttribute("disabled");
		}else
		{   document.getElementById("txt_fecha_ini").removeAttribute("readonly");
			document.getElementById("txt_fecha_fin").removeAttribute("readonly");
		}
	}else{
		/* Habilitar filtro */
		if(control.getAttribute("id") == "chk_periodo")
		{   document.getElementById("combo_periodo").setAttribute("disabled","true");
		}else
		{   document.getElementById("txt_fecha_ini").setAttribute("readonly","readonly");
			document.getElementById("txt_fecha_fin").setAttribute("readonly","readonly");
		}
	}
	consultaDeudas(div, url);
}

/* carga el formulario para la asignación de un grupo económico */
function js_clientes_carga_asignacionGrupoEconomico( codigo, div,url )
{   document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var data = new FormData();
	data.append('event', 'asignarGrupoEconomico');	
	data.append('codigoEstudiante', codigo);	
	var xhr = new XMLHttpRequest();
	xhr.open('POST', url , true);
	xhr.onreadystatechange=function()
	{   if (xhr.readyState==4 && xhr.status==200)
		{   document.getElementById(div).innerHTML=xhr.responseText;
		}
	};
	xhr.send(data);
}

/* realiza la asignación del grupo económico al estudiante */
function asign_grupoEconomico(div,url) {
	var data = new FormData();
	data.append('event', 'asigna_grupo_economico');
	data.append('codigoEstudiante', $('#codigoEstudiante').val());
	data.append('codigoGrupoEconomico', $("#combo_grupoEconomico option:selected").val() );
	data.append('ingresoFamiliar', $('#txt_ge_ingresoFamiliar').val());
	var xhr = new XMLHttpRequest();
	xhr.open('POST', url , true);
	xhr.onreadystatechange=function(){
		if (xhr.readyState==4 && xhr.status==200)
		{	var n = xhr.responseText.length;
			if (n > 0)
			{	
				valida_tipo_growl(xhr.responseText);
			}
			else
			{
				$.growl.warning({ title: "Educalinks informa",message: "Proceso realizado." });
			}
		} 
	}
	xhr.send(data);
}

/* manda a realizar la eliminación de la deuda pendiente de cobro */
function eliminarDeuda(codigo, div, url) {
	var totalInicial = 0, totalPendiente = 0, totalAbonado = 0, estado = '';

	// Busco la deuda seleccionada en la tabla de las deudas
	$('#tabla_estadoCuenta tbody tr').each(function(){
		codigo_deuda = $(this).find('td').eq(1).text();
		codigo_deuda = codigo_deuda.replace('<div style="font-size:x-small;">','');
		codigo_deuda = codigo_deuda.replace('</div>','');
		if( codigo_deuda == codigo  )
		{   totalInicial 	= $(this).find('td').eq(4).text();
			totalAbonado 	= $(this).find('td').eq(6).text();
			totalPendiente 	= $(this).find('td').eq(7).text();
			estado 			= $(this).find('td').eq(8).text();
		}
	});
	if( totalAbonado <= 0.00){
		if(estado == "POR COBRAR"){
			if(confirm("¿Está seguro que desea eliminar la deuda seleccionada?")){
				document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
				var data = new FormData();
				data.append('event', 'delete_deuda');	
				data.append('codigoDeuda', codigo);	
				data.append('codigoEstudiante', $("#codigoEstudiante").val());
				var xhr = new XMLHttpRequest();
				xhr.open('POST', url , true);
				xhr.onreadystatechange=function(){
					if (xhr.readyState==4 && xhr.status==200){
						document.getElementById(div).innerHTML=xhr.responseText;
						$.growl.notice({ title: "Educalinks informa", message: "Deuda eliminada con éxito!" });
						var table = $("#tabla_estadoCuenta").DataTable({
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
								{className: "dt-body-right"  , "targets": [3]},
								{className: "dt-body-right"  , "targets": [4]},
								{className: "dt-body-right"  , "targets": [5]},
								{className: "dt-body-right"  , "targets": [6]},
								{className: "dt-body-center" , "targets": [7]},
								{className: "dt-body-center" , "targets": [8]},
								{className: "dt-body-center" , "targets": [9]}
							]
						});
						table.page.len(10).draw();
						$('#tabla_estadoCuenta tbody').on('click', 'td.details-control', function ()
						{   var tr = $(this).closest('tr');
							var row = table.row(tr);
							if ( row.child.isShown() )
							{   // This row is already open - close it
								row.child.hide();
								tr.removeClass('shown');
							}
							else
							{   var deudaCliente = [];
								deudaCliente = row.data();
								deud_codigo  = deudaCliente[1];
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
					}
				}
				xhr.send(data);
			}
		}else{
			$.growl.warning({ title: "Educalinks informa", message: "¡La deuda seleccionada no está pendiente de cobro o tiene una factura autorizada!" });	
		}
	}else{
		$.growl.warning({ title: "Educalinks informa", message: "¡La deuda seleccionada posee abonos realizados!" });
	}
	
}

function consultaDeudas( div, url )
{   var codigoAlumno = $("#codigoEstudiante").val();
	var codigoPeriodo = ( document.getElementById("chk_periodo").checked==true ? $("#combo_periodo option:selected").val() : "");
	var fechaInicio = ( document.getElementById("chk_fecha").checked==true ? $("#txt_fecha_ini").val() : "");
	var fechaFin = ( document.getElementById("chk_fecha").checked==true ? $("#txt_fecha_fin").val() : "");

	document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var data = new FormData();
	data.append('event', 'get_deudas');	
	data.append('codigoEstudiante', codigoAlumno);	
	data.append('codigoPeriodo', codigoPeriodo);
	data.append('fechaInicio', fechaInicio);
	data.append('fechaFin', fechaFin);
	var xhr = new XMLHttpRequest();
	xhr.open('POST', url , true);
	xhr.onreadystatechange=function()
	{   if (xhr.readyState==4 && xhr.status==200)
		{   document.getElementById(div).innerHTML=xhr.responseText;
			var table = $("#tabla_estadoCuenta").DataTable({
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
					{className: "dt-body-right"  , "targets": [3]},
					{className: "dt-body-right"  , "targets": [4]},
					{className: "dt-body-right"  , "targets": [5]},
					{className: "dt-body-right"  , "targets": [6]},
					{className: "dt-body-center" , "targets": [7]},
					{className: "dt-body-center" , "targets": [8]},
					{className: "dt-body-center" , "targets": [9]}
				]
			});
			table.page.len(10).draw();
			$('#tabla_estadoCuenta tbody').on('click', 'td.details-control', function ()
			{   var tr = $(this).closest('tr');
				var row = table.row(tr);
				if ( row.child.isShown() )
				{   // This row is already open - close it
					row.child.hide();
					tr.removeClass('shown');
				}
				else
				{   var deudaCliente = [];
					deudaCliente = row.data();
					deud_codigo  = deudaCliente[1];
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
		}
	};
	xhr.send(data);
}
function carga_cliente_opciones(codigoCliente,div)
{	document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var data = new FormData();
	data.append('event','get_cliente_opciones');
	data.append('codigoCliente',codigoCliente);
	var xhr = new XMLHttpRequest();
	xhr.open('POST', document.getElementById('ruta_html_finan').value+'/clientes/controller.php', true);
	xhr.onreadystatechange=function()
	{	if (xhr.readyState==4 && xhr.status==200)
		{	document.getElementById(div).innerHTML=xhr.responseText;
		}
	};
	xhr.send(data);
}
function js_clientes_check_fecha_nac()
{    var chk_tneto = document.getElementById("chk_fecha_nac").checked;
    if(chk_tneto)
    {   document.getElementById("txt_fecha_nac_ini").disabled = false;
        document.getElementById("txt_fecha_nac_fin").disabled = false;
    }
    else
    {   document.getElementById("txt_fecha_nac_ini").disabled = true;
        document.getElementById("txt_fecha_nac_fin").disabled = true;
		document.getElementById("txt_fecha_nac_ini").value = "";
        document.getElementById("txt_fecha_nac_fin").value = "";
    }
}