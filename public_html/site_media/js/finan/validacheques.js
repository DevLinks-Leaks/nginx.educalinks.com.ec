/// JavaScript Document
$(document).ready(function() {
    $('#validacheque_table').DataTable({
        dom: 'Bfrtip',
        buttons: [ 
			{ extend: 'copy', text: 'Copiar <i class="fa fa-copy"></i>' },
			{ extend: 'csv', text: 'CSV <i style="color:green" class="fa fa-file-excel-o"></i>' },
			{ extend: 'excel', text: 'Excel <i style="color:green" class="fa fa-file-excel-o"></i>' },
			{ extend: 'pdf', text: 'PDF <i style="color:red" class="fa fa-file-pdf-o"></i>' },
			{ extend: 'print', text: 'Imprimir <i style="color:#428bca" class="fa fa-print"></i>' },
			],
		"paging": true,
		"lengthChange": true,
		"searching": true,
		"ordering": true,
		"info": true,
		"autoWidth": false,
		language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'},
        "columnDefs": [
            {className: "dt-body-center" , "targets": [0]},
            {className: "dt-body-center" , "targets": [1]},
            {className: "dt-body-center" , "targets": [2]},
            {className: "dt-body-center" , "targets": [3]},
            {className: "dt-body-center" , "targets": [4]},
            {className: "dt-body-right"  , "targets": [5]},
            {className: "dt-body-center" , "targets": [6]}
        ]
    });
    var table = $('#validacheque_table').DataTable();
    table.column( '4:visible' ).order( 'desc' );
	$('.buttons-excel').ready(function() {
		$(this).addClass('btn-success');
	})
});
function js_validacheques_busca( div, url )
{   document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var data = new FormData();
    data.append('event', 'get_all');
    data.append('filtro', document.getElementById( 'cmb_mostrarCheq' ).value );
    var xhr = new XMLHttpRequest();
    xhr.open('POST', url , true);
    xhr.onreadystatechange=function()
    {   if ( xhr.readyState === 4 && xhr.status === 200 )
        {   document.getElementById(div).innerHTML=xhr.responseText;
            $.growl.warning({ title: "Educalinks informa:",message: "Proceso realizado." });
            $('#validacheque_table').DataTable({
                dom: 'Bfrtip',
				buttons: [ 
					{ extend: 'copy', text: 'Copiar <i class="fa fa-copy"></i>' },
					{ extend: 'csv', text: 'CSV <i style="color:green" class="fa fa-file-excel-o"></i>' },
					{ extend: 'excel', text: 'Excel <i style="color:green" class="fa fa-file-excel-o"></i>' },
					{ extend: 'pdf', text: 'PDF <i style="color:red" class="fa fa-file-pdf-o"></i>' },
					{ extend: 'print', text: 'Imprimir <i style="color:#428bca" class="fa fa-print"></i>' },
					],
				"paging": true,
				"lengthChange": true,
				"searching": true,
				"ordering": true,
				"info": true,
				"autoWidth": false,
				language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'},
                "columnDefs": [
                    {className: "dt-body-center" , "targets": [0]},
                    {className: "dt-body-center" , "targets": [1]},
                    {className: "dt-body-center" , "targets": [2]},
                    {className: "dt-body-center" , "targets": [3]},
                    {className: "dt-body-center" , "targets": [4]},
                    {className: "dt-body-right"  , "targets": [5]},
                    {className: "dt-body-center" , "targets": [6]}
                ]
            });
            var table = $('#validacheque_table').DataTable();
            table.column( '4:visible' ).order( 'desc' );
			$('.buttons-excel').ready(function() {
				$(this).addClass('btn-success');
			})
        } 
    };
    xhr.send(data);
}
function js_validacheques_aprobar( codigo, div, url )
{   document.getElementById( 'hd_aprove_cheq_codigo' ).value = codigo;
}
function js_validacheques_aprobar_followed( codigo, div, url )
{   document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var data = new FormData();
    data.append('event', 'aprobar');
    data.append('cheq_codigo', codigo);    
    var xhr = new XMLHttpRequest();
    xhr.open('POST', url , true);
    xhr.onreadystatechange=function()
    {   if ( xhr.readyState === 4 && xhr.status === 200 )
        {   document.getElementById(div).innerHTML=xhr.responseText;
            $.growl.warning({ title: "Educalinks informa:",message: "Proceso realizado." });
            $('#validacheque_table').DataTable({
                dom: 'Bfrtip',
				buttons: [ 
					{ extend: 'copy', text: 'Copiar <i class="fa fa-copy"></i>' },
					{ extend: 'csv', text: 'CSV <i style="color:green" class="fa fa-file-excel-o"></i>' },
					{ extend: 'excel', text: 'Excel <i style="color:green" class="fa fa-file-excel-o"></i>' },
					{ extend: 'pdf', text: 'PDF <i style="color:red" class="fa fa-file-pdf-o"></i>' },
					{ extend: 'print', text: 'Imprimir <i style="color:#428bca" class="fa fa-print"></i>' },
					],
				"paging": true,
				"lengthChange": true,
				"searching": true,
				"ordering": true,
				"info": true,
				"autoWidth": false,
				language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'},
                "columnDefs": [
                    {className: "dt-body-center" , "targets": [0]},
                    {className: "dt-body-center" , "targets": [1]},
                    {className: "dt-body-center" , "targets": [2]},
                    {className: "dt-body-center" , "targets": [3]},
                    {className: "dt-body-center" , "targets": [4]},
                    {className: "dt-body-right"  , "targets": [5]},
                    {className: "dt-body-center" , "targets": [6]}
                ]
            });
            var table = $('#validacheque_table').DataTable();
            table.column( '4:visible' ).order( 'desc' );
			$('.buttons-excel').ready(function() {
				$(this).addClass('btn-success');
			})
        } 
    };
    xhr.send(data);
}
function js_validacheques_protestar( codigo, div, url )
{   document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var data = new FormData();
    data.append('event', 'protestar');
    data.append('cheq_codigo', codigo);    
    data.append('cheq_observacion', document.getElementById('observaciondeposito_add').value);
    data.append('alerta', document.getElementById('alerta').checked);
    var xhr = new XMLHttpRequest();
    xhr.open('POST', url , true);
    xhr.onreadystatechange=function()
    {   if (xhr.readyState==4 && xhr.status==200)
        {   document.getElementById(div).innerHTML=xhr.responseText;
            $.growl.warning({ title: "Educalinks informa",message: "Proceso realizado." });
            $('#validacheque_table').addClass( 'nowrap' ).DataTable({
                dom: 'Bfrtip',
				buttons: [ 
					{ extend: 'copy', text: 'Copiar <i class="fa fa-copy"></i>' },
					{ extend: 'csv', text: 'CSV <i style="color:green" class="fa fa-file-excel-o"></i>' },
					{ extend: 'excel', text: 'Excel <i style="color:green" class="fa fa-file-excel-o"></i>' },
					{ extend: 'pdf', text: 'PDF <i style="color:red" class="fa fa-file-pdf-o"></i>' },
					{ extend: 'print', text: 'Imprimir <i style="color:#428bca" class="fa fa-print"></i>' },
					],
				"paging": true,
				"lengthChange": true,
				"searching": true,
				"ordering": true,
				"info": true,
				"autoWidth": false,
				language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'},
                "columnDefs": [
                    {className: "dt-body-center" , "targets": [0]},
                    {className: "dt-body-center" , "targets": [1]},
                    {className: "dt-body-center" , "targets": [2]},
                    {className: "dt-body-center" , "targets": [3]},
                    {className: "dt-body-center" , "targets": [4]},
                    {className: "dt-body-right"  , "targets": [5]},
                    {className: "dt-body-center" , "targets": [6]}
                ]
            });
            var table = $('#validacheque_table').DataTable();
            table.column( '4:visible' ).order( 'desc' );
			$('.buttons-excel').ready(function() {
				$(this).addClass('btn-success');
			})
		}
    };
    xhr.send(data);
}
function js_validacheques_protestar_add( codigo, div, url )
{   document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var data = new FormData();
    data.append('event', 'agregar');    
    var xhr = new XMLHttpRequest();
    xhr.open('POST', url , true);
    xhr.onreadystatechange=function(){
        if ( xhr.readyState === 4 && xhr.status === 200 )
        {   document.getElementById(div).innerHTML=xhr.responseText;
        } 
    };
    document.getElementById('cheq_codigo').value = codigo;
    xhr.send(data);
}
function js_validacheques_filter(  )
{   js_validacheques_busca('resultado', document.getElementById('ruta_html_finan').value+'/valida_cheques/controller.php' );
}