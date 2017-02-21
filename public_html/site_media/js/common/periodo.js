$(document).ready(function() {
	$("#tbl_periodos").DataTable({
		"paging": true,
		"lengthChange": false,
		"searching": false,
		"ordering": true,
		"info": true,
		"autoWidth": false,
		language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'},
		"columnDefs": [
			{className: "dt-body-center"  , "targets": [0]},
			{className: "dt-body-left"    , "targets": [1]},
			{className: "dt-body-center"  , "targets": [2]},
			{className: "dt-body-center"  , "targets": [3]},
			{className: "dt-body-center"  , "targets": [4]},
			{className: "dt-body-center"  , "targets": [5]},
			{className: "dt-body-center"  , "targets": [6]},
			{className: "dt-body-center"  , "targets": [7]},
			{className: "dt-body-center"  , "targets": [8]}
		]
	});
});
// Consulta filtrada
//function js_rol_busca(busq,div,url){
function busca(busq,div,url){
	document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
	var data = new FormData();
	data.append('event', 'get_all_data');
	data.append('busq', busq);	
	var xhr = new XMLHttpRequest();
	xhr.open('POST', url , true);
	xhr.onreadystatechange=function()
	{   if (xhr.readyState==4 && xhr.status==200)
		{   document.getElementById(div).innerHTML=xhr.responseText;
			$("#tbl_periodos").DataTable({
				"paging": true,
				"lengthChange": false,
				"searching": false,
				"ordering": true,
				"info": true,
				"autoWidth": false,
				language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'},
				"columnDefs": [
					{className: "dt-body-center"  , "targets": [0]},
					{className: "dt-body-left"    , "targets": [1]},
					{className: "dt-body-center"  , "targets": [2]},
					{className: "dt-body-center"  , "targets": [3]},
					{className: "dt-body-center"  , "targets": [4]},
					{className: "dt-body-center"  , "targets": [5]},
					{className: "dt-body-center"  , "targets": [6]},
					{className: "dt-body-center"  , "targets": [7]},
					{className: "dt-body-center"  , "targets": [8]}
				]
			});
			//var table = $('#tbl_roles').DataTable();
			//table.column( '0:visible' ).order( 'asc' );
		} 
	};
	xhr.send(data);
}
// Carga el formulario para ingresar un nuevo registro
//function js_rol_carga_add(busq,div,url){
function carga_add(div,url)
{   document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
	var data = new FormData();
	data.append('event', 'agregar');	
	var xhr = new XMLHttpRequest();
	xhr.open('POST', url , true);
	xhr.onreadystatechange=function()
	{   if (xhr.readyState==4 && xhr.status==200)
		{   document.getElementById(div).innerHTML=xhr.responseText;
			$("#fechainicio_add").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
			$("#fechafin_add").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
            $("#fechainicio_add").datepicker();
            $("#fechafin_add").datepicker();
			$("#txt_periodo_anio_add").numeric({ decimal : false,  negative : false, precision: 4 });
			$("#txt_nota_maxima_add").numeric({ decimal : false,  negative : false, precision: 3 });
		}
	};
	xhr.send(data);
}
// Carga el formulario para editar un registro
//function js_rol_carga_edit(codigo,div,url)
function carga_edit(codigo,div,url)
{   document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
	var data = new FormData();
	data.append('event', 'get');
	data.append('codigo', codigo);	
	var xhr = new XMLHttpRequest();
	xhr.open('POST', url , true);
	xhr.onreadystatechange=function(){
		if (xhr.readyState==4 && xhr.status==200)
		{   document.getElementById(div).innerHTML=xhr.responseText;
			$("#fechainicio_mod").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
			$("#fechafin_mod").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
            $("#fechainicio_mod").datepicker();
            $("#fechafin_mod").datepicker();
			$("#txt_periodo_anio_mod").numeric({ decimal : false,  negative : false, precision: 4 });
			$("#txt_nota_maxima_mod").numeric({ decimal : false,  negative : false, precision: 3 });
		}
	};
	xhr.send(data);
}
// Realiza la actualizacion de los datos en la BD
//function js_rol_edit(busq,div,url){
function edit(rol_codigo,div,url)
{   $('#btn_editar').removeAttr('data-dismiss');
	if (validate_upd())
	{	$('#btn_editar').attr('data-dismiss','modal');
		if(confirm("¿Está seguro que desea editar la información del periodo?"))
		{   document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
			var data = new FormData();
			data.append('event', 'edit');
			data.append('codigo', document.getElementById('codigo_mod').value);
			data.append('descripcion', document.getElementById('descripcion_mod').value);
			data.append('peri_ano', document.getElementById('txt_periodo_anio_mod').value);
			data.append('peri_nota_max', document.getElementById('txt_nota_maxima_mod').value);
			data.append('peri_tipo', document.getElementById('cmb_periodo_tipo_mod').value);
			data.append('fechainicio', document.getElementById('fechainicio_mod').value);
			data.append('fechafin', document.getElementById('fechafin_mod').value);
			var xhr = new XMLHttpRequest();
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
					busca("",div,url);
				}
			};
			xhr.send(data);
		}
	}
}
// Realiza el ingreso de un registro nuevo
//function js_rol_add(div,url)
function add(div,url)
{   $('#btn_guardar').removeAttr('data-dismiss');
	if (validate_in())
	{	$('#btn_guardar').attr('data-dismiss','modal');
		document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
		var data = new FormData();
		data.append('event', 'set');
		data.append('descripcion', document.getElementById('descripcion_add').value);
		data.append('peri_ano', document.getElementById('txt_periodo_anio_add').value);
		data.append('peri_nota_max', document.getElementById('txt_nota_maxima_add').value);
		data.append('peri_tipo', document.getElementById('cmb_periodo_tipo_add').value);
		data.append('fechainicio', document.getElementById('fechainicio_add').value);
		data.append('fechafin', document.getElementById('fechafin_add').value);
		var xhr = new XMLHttpRequest();
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
				busca("",div,url);
			} 
		};
		xhr.send(data);
	}
}
// Realiza la eliminacion del cliente en la BD
//function js_rol_del(codigo,div,url)
function del(codigo,div,url)
{   if(confirm("¿Está seguro que desea eliminar el periodo?"))
	{   document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
		var data = new FormData();
		data.append('event', 'delete');
		data.append('codigo', codigo);	
		var xhr = new XMLHttpRequest();
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
				busca("",div,url)
			} 
		};
		xhr.send(data);
	}
}
//Validación ingreso periodo
function validate_in()
{	if ($.trim($('#descripcion_add').val())=="")
	{	alert ('Ingrese una descripción para el periodo');
		return false;
	}
	if ($.trim($('#fechainicio_add').val())=="")
	{	alert ('Ingrese una fecha de inicio para el periodo');
		return false;
	}
	if ($.trim($('#fechafin_add').val())=="")
	{	alert ('Ingrese una fecha de fin para el periodo');
		return false;
	}
	return true;
}
//Validación actualización periodo
function validate_upd()
{	if ($.trim($('#descripcion_mod').val())=="")
	{	alert ('Ingrese una descripción para el periodo');
		return false;
	}
	if ($.trim($('#fechainicio_mod').val())=="")
	{	alert ('Ingrese una fecha de inicio para el periodo');
		return false;
	}
	if ($.trim($('#fechafin_mod').val())=="")
	{	alert ('Ingrese una fecha de fin para el periodo');
		return false;
	}
	return true;
}