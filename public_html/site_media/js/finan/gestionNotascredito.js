/**
 * Created by Redlinks 10/06/2015.
 */
$(document).ready(function(){
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
	var table_NC = $('#facturasPendiente_table').DataTable();
	table_NC.column( '5:visible' ).order( 'desc' );
});
function reenvio_factura(codigo, div,url){
    document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var data = new FormData();
    data.append('event', 'resend_to_sri');
    data.append('codigoDocumento', codigo);
    var xhr = new XMLHttpRequest();
    xhr.open('POST', url , true);
    xhr.onreadystatechange=function(){
        if (xhr.readyState==4 && xhr.status==200){
            document.getElementById(div).innerHTML=xhr.responseText;

            // Vuelve a cargar el grid con las facturas pendientes
            carga_facturasPendientes('resultadoProceso', url);
        }
    }
    xhr.send(data);
}

function envio_factura(codigo, div, url, envio){
    document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var data = new FormData();
    data.append('event', 'send_to_sri');
    data.append('codigoDocumento', codigo);
	data.append('enviar', envio);
    var xhr = new XMLHttpRequest();
    xhr.open('POST', url , true);
    xhr.onreadystatechange=function(){
        if (xhr.readyState==4 && xhr.status==200){
            document.getElementById(div).innerHTML=xhr.responseText;

            // Vuelve a cargar el grid con las facturas pendientes
            carga_facturasPendientes('resultadoProceso', url);
        }
    }
    xhr.send(data);
}

function carga_facturasPendientes(div, url){
    document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var data = new FormData();
    data.append('event', 'get_pending_bills');
    var xhr = new XMLHttpRequest();
    xhr.open('POST', url , true);
    xhr.onreadystatechange=function(){
        if (xhr.readyState==4 && xhr.status==200){
            document.getElementById(div).innerHTML=xhr.responseText;
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
			var table_NC = $('#facturasPendiente_table').DataTable();
			table_NC.column( '5:visible' ).order( 'desc' );
		}
    }
    xhr.send(data);
}

function envio_facturasPorLote(div, url){

}
function editar(codigo,alum_codi,tipo_persona,div,url,url2,follow_next)
{   document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
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
			{
				carga_tabla_asign_repr(alum_codi,'div_asign_repr',url2);
			}
        }
    };
    xhr.send(data);
}
function validaSave_edited(url)
{	save_edited(url);
	return false;
}
function save_edited(url)
{   if(confirm("¿Está seguro que desea editar la información de la factura?"))
    {   var tipoced =0;
		if(document.getElementById('tipo_iden').selectedIndex===0)
		{   tipoced='CI';
		}
		else if(document.getElementById('tipo_iden').selectedIndex===1)
		{   tipoced='RUC';
		}
		else if (document.getElementById('tipo_iden').selectedIndex===2)
		{   tipoced='PLC';
		}
		
		var data = new FormData();
		
		data.append('event', 'edit');
		data.append('codigo', document.getElementById('factura_codigo').value);
		data.append('tipoid', tipoced);
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
				{	
					valida_tipo_growl(xhr.responseText);
				}
				else
				{
					$.growl.warning({ title: "Educalinks informa:",message: "Proceso realizado." });
				}
				carga_facturasPendientes('resultadoProceso',url)
			} 
		};
		xhr.send(data);
	}
}

function js_gestionNotascredito_to_excel_busquedaFacturas( evento, tipo_reporte )
{   document.getElementById( 'evento' ).value = evento;
    document.getElementById( 'tipo_reporte' ).value = tipo_reporte;
	document.getElementById( 'file_form' ).submit();
}
function carga_busquedaFacturas(div, url)
{   document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var tipoDocumentoAutorizado = 'NC';
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
    xhr.open('POST', url , true);
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