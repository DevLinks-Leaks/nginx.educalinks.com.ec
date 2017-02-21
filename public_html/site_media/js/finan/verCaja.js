$(document).ready(function() {
    actualiza_badge_gest_fact();
	$('#cajas_table').DataTable({
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
			{className: "dt-body-right"  , "targets": [6]},
			{className: "dt-body-center" , "targets": [7]}
		]
	});
	var table_caja = $('#cajas_table').DataTable();
	table_caja.column( '3:visible' ).order( 'desc' );
});
function countDown(div) {
	var counter = 5;
	//document.timer.field.value = counter-- + ' seconds left';
	if (counter != -1)
		setTimeout('countDown()',1000);
	else
		document.getElementById(div).innerHTML='<div align="center" style="height:100%;"><br>'
			+	'<small><i>Parece que est&aacute; tardando demasiado en cargar.<br>' 
			+ 	'Por favor, intente cerrando esta ventana y abri&eacute;ndola nuevamente.</i></small></div>';
}
//CONSULTA FILTRADA. NO USADA ACTUALMENTE.
function busca(busq,div,url){
	document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var data = new FormData();
	data.append('event', 'get_all_data');
	data.append('busq', busq);	
	var xhr = new XMLHttpRequest();
	xhr.open('POST', url , true);
	xhr.onreadystatechange=function(){
		if (xhr.readyState==4 && xhr.status==200)
		{	document.getElementById(div).innerHTML=xhr.responseText;
			$('#cajas_table').addClass( 'nowrap' ).DataTable({lengthChange: false, responsive: true, searching: true,  orderClasses: true,
				language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'}});
		} 
	}
	xhr.send(data);
}

// JS LLAMADO A REPORTES
function carga_reports_item(codigo,div,url,evento){
	document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var data = new FormData();
	data.append('event', 'printvisor');
	data.append('codigo', codigo);	
	url2=url+'?event='+evento+'&codigo='+codigo;
	data.append('url',url2);
	var xhr = new XMLHttpRequest();
	xhr.open('POST', url , true);
	xhr.onreadystatechange=function(){
		if (xhr.readyState==4 && xhr.status==200){
			document.getElementById(div).innerHTML=xhr.responseText;
			carga_reports_fp(codigo,'modal_edit_body_fp',url,'print_fp');
		} 
	}
	countDown(div);
	xhr.send(data);
}
function carga_reports_fp(codigo,div,url,evento){
	document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var data = new FormData();
	data.append('event', 'printvisor');
	data.append('codigo', codigo);	
	url2=url+'?event='+evento+'&codigo='+codigo;
	data.append('url',url2);
	var xhr = new XMLHttpRequest();
	xhr.open('POST', url , true);
	xhr.onreadystatechange=function(){
		if (xhr.readyState==4 && xhr.status==200){
			document.getElementById(div).innerHTML=xhr.responseText;
			carga_reports_nc(codigo,'modal_edit_body_nc',url,'print_nc');
		} 
	}
	countDown(div);
	xhr.send(data);
}
function carga_reports_nc(codigo,div,url,evento){
	document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var data = new FormData();
	data.append('event', 'printvisor');
	data.append('codigo', codigo);	
	url2=url+'?event='+evento+'&codigo='+codigo;
	data.append('url',url2);
	var xhr = new XMLHttpRequest();
	xhr.open('POST', url , true);
	xhr.onreadystatechange=function(){
		if (xhr.readyState==4 && xhr.status==200){
			document.getElementById(div).innerHTML=xhr.responseText;
		} 
	}
	countDown(div);
	xhr.send(data);
}