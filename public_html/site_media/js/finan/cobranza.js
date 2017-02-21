// JavaScript Document
$(document).ready(function() {
	$("#txt_fecha_nac_ini").datepicker();
    $("#txt_fecha_nac_fin").datepicker();
	$("#txt_fecha_nac_ini").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
	$("#txt_fecha_nac_fin").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
	
	$("#boton_busqueda").click(function(){
		$("#desplegable_busqueda").slideToggle(200);
	});
	$("#desplegable_busqueda").show();
	
	$('#modal_crm').on('hidden.bs.modal', function () {
		$("#cobr_table_acerca").DataTable().clear().destroy();
	});
	$('#modal_crm').on('shown.bs.modal', function () {
		$("#acerca_fecha_seguimiento").datepicker();
		$("#acerca_fecha_seguimiento").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
		$("#cobr_table_acerca").DataTable({
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
			bInfo : false,
			"columnDefs": [
				{className: "dt-body-center" , "targets": [0]},
				{className: "dt-body-center" , "targets": [1]},
				{className: "dt-body-center" , "targets": [2]},
				{className: "dt-body-center" , "targets": [3]},
				{className: "dt-body-center" , "targets": [4]},
				{className: "dt-body-center" , "targets": [5]}
			]
		});
	});
});
function js_cobranza_buscar( div, url )
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
	xhr.onreadystatechange=function()
	{   if ( xhr.readyState === 4 && xhr.status === 200 )
		{   document.getElementById(div).innerHTML=xhr.responseText;
			var table = $('#cobr_table').DataTable({
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
				bInfo : false,
				"columnDefs": [
					{className: "dt-body-center", "targets": [ 0 ]},
					{className: "dt-body-center" , "targets": [ 1 ]},
					{className: "dt-body-right" , "targets": [ 2 ]},
					{"title": "<span style='color:black'>Deuda pendt.</span>", className: "dt-body-right", "targets": [ 5 ]},
					{"title": "<span style='color:DarkRed'>F. vencimiento</span>", className: "dt-body-center" , "targets": [6]},
					{"title": "<span style='color:black'>F. seguimiento</span>", className: "dt-body-center" , "targets": [7]},
					{"title": "<span style='color:black'>Acercamiento</span>", className: "dt-body-center" , "targets": [8]}
				]
			});
			table.page.len(10).draw();
			$('#cobr_table thead tr th').css('background-color', 'bgGreen');
			// Add event listener for opening and closing details
			$('#cobr_table tbody').on('click', 'td.details-control', function ()
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
					var codigoCliente = [];
					codigoCliente = row.data();
					if( codigoCliente )
					{   var data = new FormData();
						data.append('event', 'carga_detalle_deudas');
						data.append('clie_codigo', codigoCliente[1]);	
						var xhr = new XMLHttpRequest();
						xhr.open('POST',document.getElementById('ruta_html_finan').value+'/cobranza/controller.php', true);
						xhr.onreadystatechange=function()
						{   if ( xhr.readyState === 4 && xhr.status === 200 )
							{   // Open this row
								row.child(xhr.responseText).show();
								tr.addClass('shown');
								var table_deuda = $('#deudas_'+codigoCliente[1]).DataTable({
									language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'},
									"lengthChange": false,
									searching: false,
									paging:false,
									info:false,
									"order":[[4, 'asc']],
									"columnDefs": [
										{className: "dt-body-center" , "targets": [0]},
										{className: "dt-body-center" , "targets": [1]},
										{className: "dt-body-right" , "targets": [2]},
										{className: "dt-body-right" , "targets": [3]},
										{className: "dt-body-right" , "targets": [4]}
									],
									"fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
										$('td', nRow).css('background-color', '#d6f9da');
									}
								});
								$('#deudas_'+codigoCliente[1]+' tbody').on('click', 'td.details-control', function () {		
								var tr_de = $(this).closest('tr');
								var row_de = table_deuda.row(tr_de);
								if ( row_de.child.isShown() )
								{   // This row is already open - close it
									row_de.child.hide();
									tr_de.removeClass('shown');
									$(this).find('i').toggleClass('fa fa-minus-circle fa fa-plus-circle');
									$(this).find('i').css("color", "green");
								}
								else
								{   $(this).find('i').toggleClass('fa fa-minus-circle fa fa-plus-circle');
									$(this).find('i').css("color", "red");
									var ref_interna = row_de.data();
									var data_de = new FormData();
									data_de.append('event', 'carga_detalle_deudas_info');
									data_de.append('deud_codigo', ref_interna[1]);
									var xhr_de = new XMLHttpRequest();
									xhr_de.open('POST',document.getElementById('ruta_html_finan').value+'/cobranza/controller.php', true);
									xhr_de.onreadystatechange=function()
									{   if ( xhr_de.readyState === 4 && xhr_de.status === 200 )
										{   // Open this row
											row_de.child(xhr_de.responseText).show();
											tr_de.addClass('shown');
											var table_deuda = $('#sub_deudas_'+ref_interna[1]).DataTable({
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
													$('td', nRow).css('background-color', '#dffafa');
													/*if ( aData[2] == "5" )
														$('td', nRow).css('background-color', 'Red');
													else if ( aData[2] == "4" )
														$('td', nRow).css('background-color', 'Orange');*/
												}
											});
										}
									};
									xhr_de.send(data_de);
								}
								});
							}
						};
						xhr.send(data);
					}
				}
			});
		} 
	};
	xhr.send(data);
}
function carga_detalle_resultado(crm_resu_codigo,div,url)
{   document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var data = new FormData();
	data.append('event', 'carga_detalles_resultados');
	data.append('crm_resu_codigo', crm_resu_codigo);	
	var xhr = new XMLHttpRequest();
	xhr.open('POST', url , true);
	xhr.onreadystatechange=function()
	{   if ( xhr.readyState === 4 && xhr.status === 200 )
		{   document.getElementById(div).innerHTML=xhr.responseText;
		} 
	};
	xhr.send(data);
}
function edit(codigo,div,url)
{   document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var data = new FormData();
	data.append('event', 'get');
	data.append('clie_codigo', codigo);	
	var xhr = new XMLHttpRequest();
	xhr.open('POST', url , true);
	xhr.onreadystatechange=function()
	{   if ( xhr.readyState === 4 && xhr.status === 200 )
		{   document.getElementById(div).innerHTML = xhr.responseText;
		}
	};
	xhr.send(data);
}
function js_cobranza_save_acerca( codigo, div, url )
{   document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var data = new FormData();
	data.append('event', 'acercamiento');
	
	//Alumno
	
	data.append('clie_codigo', 				document.getElementById('clie_codigo').value);
	data.append('tipo_persona', 			document.getElementById('tipo_persona').value);
	data.append('clie_telefono', 			document.getElementById('clie_telefono').value);
	data.append('clie_correoElectronico', 	document.getElementById('clie_correoElectronico').value);
	data.append('clie_direccion', 			document.getElementById('clie_direccion').value);
	data.append('combo_resultado', 			document.getElementById('combo_resultado').value);
	data.append('combo_detalle_resultado', 	document.getElementById('combo_detalle_resultado').value);
	data.append('observacion_resultado', 	document.getElementById('observacion_resultado').value);
	data.append('acerca_fecha_seguimiento', document.getElementById('acerca_fecha_seguimiento').value);
	data.append('deud_totalPendiente', 		document.getElementById('deud_totalPendiente').value);
	
	//Representante económico
	
	data.append('tipo_iden'	 , document.getElementById('tipo_iden').value);
	data.append('repr_cedula', document.getElementById('repr_cedula').value);
	data.append('repr_nomb'	 , document.getElementById('repr_nomb').value);
	data.append('repr_apel'	 , document.getElementById('repr_apel').value);
	data.append('repr_domi'	 , document.getElementById('repr_domi').value);
	data.append('repr_email' , document.getElementById('repr_email').value);
	data.append('repr_telf'	 , document.getElementById('repr_telf').value);

	//Representante legal
	data.append('tipo_iden_acad'  ,	document.getElementById('tipo_iden_acad').value);
	data.append('repr_cedula_acad', document.getElementById('repr_cedula_acad').value);
	data.append('repr_nomb_acad'  , document.getElementById('repr_nomb_acad').value);
	data.append('repr_apel_acad'  , document.getElementById('repr_apel_acad').value);
	data.append('repr_domi_acad'  , document.getElementById('repr_domi_acad').value);
	data.append('repr_email_acad' , document.getElementById('repr_email_acad').value);
	data.append('repr_telf_acad'  , document.getElementById('repr_telf_acad').value);	
	var xhr = new XMLHttpRequest();
	xhr.open('POST', url , true);
	xhr.onreadystatechange=function()
	{   if ( xhr.readyState === 4 && xhr.status === 200 )
		{   js_cobranza_buscar( div, url );
		} 
	};
	xhr.send(data);
}
function js_cobranza_check_fecha_nac()
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