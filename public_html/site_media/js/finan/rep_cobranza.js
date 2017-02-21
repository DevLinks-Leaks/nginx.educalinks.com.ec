// JavaScript Document
$(document).ready(function() {
	$("#txt_fecha_ini").datepicker();
	$("#txt_fecha_fin").datepicker();
	var table = $('#cobr_table').DataTable({
		"language": {
			"url":spanish
		},
		"lengthChange": false,
		searching: false,
		columnDefs: [ { "orderable": false, "targets": 0 },{ "orderable": false, "targets": 5 } ],
		"order": [[5, 'asc'],[4, 'asc'],[3, 'desc'],[2, 'asc']]
	});
	table.page.len(10).draw();
	// Add event listener for opening and closing details
	$('#cobr_table tbody').on('click', 'td.details-control', function () {		
		var tr = $(this).closest('tr');
		var row = table.row(tr);
		if ( row.child.isShown() ) {
			// This row is already open - close it
			row.child.hide();
			tr.removeClass('shown');
		}
		else {
			var codigoCliente = row.data();
			var data = new FormData();
			data.append('event', 'carga_detalle_deudas');
			data.append('clie_codigo', codigoCliente[1]);	
			var xhr = new XMLHttpRequest();
			xhr.open('POST',document.getElementById('ruta_html_finan').value+'/rep_cobranza/controller.php', true);
			xhr.onreadystatechange=function(){
				if (xhr.readyState==4 && xhr.status==200){
					// Open this row
					row.child(xhr.responseText).show();
					tr.addClass('shown');
					var table_deuda = $('#deudas_'+codigoCliente[1]).DataTable({
						"language": {
							"url":spanish
						},
						"lengthChange": false,
						searching: false,
						paging:false,
						info:false,
						columnDefs:[{"orderable": false, "targets": 0 }],
						"order":[[4, 'asc']]
					});
					$('#deudas_'+codigoCliente[1]+' tbody').on('click', 'td.details-control', function () {		
					var tr_de = $(this).closest('tr');
					var row_de = table_deuda.row(tr_de);
					if ( row_de.child.isShown() ) {
						// This row is already open - close it
						row_de.child.hide();
						tr_de.removeClass('shown');
					}else{
						var ref_interna = row_de.data();
						var data_de = new FormData();
						data_de.append('event', 'carga_detalle_deudas_info');
						data_de.append('deud_codigo', ref_interna[1]);											
						var xhr_de = new XMLHttpRequest();
						xhr_de.open('POST',document.getElementById('ruta_html_finan').value+'/rep_cobranza/controller.php', true);
						xhr_de.onreadystatechange=function(){
							if (xhr_de.readyState==4 && xhr_de.status==200){
								// Open this row
								row_de.child(xhr_de.responseText).show();
								tr_de.addClass('shown');
							}
						}
						xhr_de.send(data_de);
					}
					});
				}
			}
			xhr.send(data);
		}
	});
});
function carga_reports_cobranza_crm(div,url,evento){
	document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    usuaFinan= document.getElementById('cmb_usuaFinan').value;
	fecha_ini= document.getElementById('txt_fecha_ini').value;
	fecha_fin= document.getElementById('txt_fecha_fin').value;
	var data = new FormData();
	
	data.append('event', 'printvisor');
	data.append('usrfn', usuaFinan);
	data.append('fi', fecha_ini);
	data.append('ff', fecha_fin);
	url2=url+'?event='+evento+'&usrfn='+usuaFinan+'&fi='+fecha_ini+'&ff='+fecha_fin;
	data.append('url',url2);
	var xhr = new XMLHttpRequest();
	xhr.open('POST', url , true);
	xhr.onreadystatechange=function(){
		if (xhr.readyState==4 && xhr.status==200){
			document.getElementById(div).innerHTML=xhr.responseText;
		} 
	}
	xhr.send(data);
}

function check_fecha(){
	var checked=document.getElementById('chk_fecha').checked;
	if(checked==false)
	{
		document.getElementById('txt_fecha_ini').disabled = true;
		document.getElementById('txt_fecha_ini').value = '';
		document.getElementById('txt_fecha_fin').disabled = true;
		document.getElementById('txt_fecha_fin').value = '';
	}else
	{
		document.getElementById('txt_fecha_ini').disabled = false;
		document.getElementById('txt_fecha_fin').disabled = false;
		document.getElementById('txt_fecha_ini').value = obtener_fecha('hoy');
		document.getElementById('txt_fecha_fin').value = obtener_fecha('mañana');
	}
}