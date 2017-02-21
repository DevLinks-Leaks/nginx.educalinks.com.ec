// JavaScript Document
 $(document).ready(function() {
	actualiza_badge_gest_fact();
    $('#user_table').addClass( 'nowrap' ).DataTable({
		lengthChange: true, 
		responsive: true, 
		searching: true,  
		orderClasses: true,
		paging:true,
		bInfo:true,
		language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'},
		"columnDefs": [
			{className: "dt-body-center", "targets": [0]},
			{className: "dt-body-left"  , "targets": [1]},
			{className: "dt-body-left"  , "targets": [2]},
			{className: "dt-body-left"  , "targets": [3]},
			{className: "dt-body-left"  , "targets": [4]},
			{className: "dt-body-left"  , "targets": [5]},
			{className: "dt-body-center", "targets": [6]}
		]
	});
	var table = $('#user_table').DataTable();
	table.column( '0:visible' ).order( 'asc' );
	$('#modal_add').on('shown.bs.modal', function () {
		 $("#fecha_nacimiento_add").datepicker();
	});
	$('#modal_edit').on('shown.bs.modal', function () {
		 $("#fecha_nacimiento").datepicker();
	});
});
function busca(busq,div,url)
{   document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var data = new FormData();
	data.append('event', 'get_all_data');
	data.append('busq', busq);	
	var xhr = new XMLHttpRequest();
	xhr.open('POST', url , true);
	xhr.onreadystatechange=function()
	{   if (xhr.readyState==4 && xhr.status==200)
		{   document.getElementById(div).innerHTML=xhr.responseText;
			$('#user_table').addClass( 'nowrap' ).DataTable({
			lengthChange: true, 
			responsive: true, 
			searching: true,  
			orderClasses: true,
			paging:true,
			bInfo:true,
			language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'},
			"columnDefs": [
				{className: "dt-body-center", "targets": [0]},
				{className: "dt-body-left"  , "targets": [1]},
				{className: "dt-body-left"  , "targets": [2]},
				{className: "dt-body-left"  , "targets": [3]},
				{className: "dt-body-left"  , "targets": [4]},
				{className: "dt-body-left"  , "targets": [5]},
				{className: "dt-body-center", "targets": [6]}
			]
		});
		var table = $('#user_table').DataTable();
		table.column( '0:visible' ).order( 'asc' );
		$('#modal_add').on('shown.bs.modal', function () {
			 $("#fecha_nacimiento_add").datepicker();
		});
		$('#modal_edit').on('shown.bs.modal', function () {
			 $("#fecha_nacimiento").datepicker();
		});
		} 
	};
	xhr.send(data);
}
function del(codigo,div,url)
{   if(confirm("¿Está seguro que desea eliminar el usuario?"))
	{   document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
		var data = new FormData();
		data.append('event', 'delete');
		data.append('usua_codigo', codigo);	
		var xhr = new XMLHttpRequest();
		xhr.open('POST', url , true);
		xhr.onreadystatechange=function()
		{   if (xhr.readyState==4 && xhr.status==200)
			{   document.getElementById(div).innerHTML=xhr.responseText;
				$('#user_table').addClass( 'nowrap' ).DataTable({
					lengthChange: true, 
					responsive: true, 
					searching: true,  
					orderClasses: true,
					paging:true,
					bInfo:true,
					language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'},
					"columnDefs": [
						{className: "dt-body-center", "targets": [0]},
						{className: "dt-body-left"  , "targets": [1]},
						{className: "dt-body-left"  , "targets": [2]},
						{className: "dt-body-left"  , "targets": [3]},
						{className: "dt-body-left"  , "targets": [4]},
						{className: "dt-body-left"  , "targets": [5]},
						{className: "dt-body-center", "targets": [6]}
					]
				});
				var table = $('#user_table').DataTable();
				table.column( '0:visible' ).order( 'asc' );
				$('#modal_add').on('shown.bs.modal', function () {
					 $("#fecha_nacimiento_add").datepicker();
				});
				$('#modal_edit').on('shown.bs.modal', function () {
					 $("#fecha_nacimiento").datepicker();
				});
			} 
		};
		xhr.send(data);
	}
}
function edit(codigo,div,url)
{	document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var data = new FormData();
	data.append('event', 'get');
	data.append('usua_codigo', codigo);	
	var xhr = new XMLHttpRequest();
	xhr.open('POST', url , true);
	xhr.onreadystatechange=function(){
		if (xhr.readyState==4 && xhr.status==200){
			document.getElementById(div).innerHTML=xhr.responseText;
		} 
	}
	xhr.send(data);
}
function carga_add(div,url)
{	document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var data = new FormData();
	data.append('event', 'agregar');	
	var xhr = new XMLHttpRequest();
	xhr.open('POST', url , true);
	xhr.onreadystatechange=function()
	{	if (xhr.readyState==4 && xhr.status==200)
		{	document.getElementById(div).innerHTML=xhr.responseText;
		}
	};
	xhr.send(data);
}
function add(div,url)
{	document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var data = new FormData();
	data.append('event', 'set');
	data.append('usua_codigo', document.getElementById('usua_codigo_add').value);
	data.append('usua_nombres', document.getElementById('nombres_add').value);
	data.append('usua_apellidos', document.getElementById('apellidos_add').value);
	data.append('usua_correoElectronico', document.getElementById('email_add').value);
	data.append('usua_clave', document.getElementById('clave_add').value);
	data.append('usua_fechaNacimiento', document.getElementById('fecha_nacimiento_add').value);
	data.append('usua_codigoRol', document.getElementById('rol_add').value);
	var xhr = new XMLHttpRequest();
	xhr.open('POST', url , true);
	xhr.onreadystatechange=function()
	{	if (xhr.readyState==4 && xhr.status==200)
		{	busca("",div,url);
		}
	};
	xhr.send(data);
}
function save_edited(rol_codigo,div,url)
{	if(confirm("¿Está seguro que desea editar la información del usuario?"))
	{	document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
		var data = new FormData();
		data.append('event', 'edit');
		data.append('usua_codigo', document.getElementById('usua_codigo').value);
		data.append('usua_nombres', document.getElementById('nombres').value);
		data.append('usua_apellidos', document.getElementById('apellidos').value);
		data.append('usua_correoElectronico', document.getElementById('email').value);
		data.append('usua_clave', document.getElementById('clave').value);
		data.append('usua_fechaNacimiento', document.getElementById('fecha_nacimiento').value);
		data.append('usua_codigoRol', document.getElementById('rol').value);
		data.append('usua_estado', 'A');
		
		var xhr = new XMLHttpRequest();
		xhr.open('POST', url , true);
		xhr.onreadystatechange=function()
		{	if (xhr.readyState==4 && xhr.status==200)
			{	busca("",div,url);
			}
		};
		xhr.send(data);
	}
}
