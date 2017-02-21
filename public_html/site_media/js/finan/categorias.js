 $(document).ready(function() {
	actualiza_badge_gest_fact();
	$('#categoria_table').DataTable({
		lengthChange: true, 
		responsive: true, 
		searching: true,  
		orderClasses: true, 
		paging:true,
		bInfo:true,
		language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'},
		"columnDefs": [
			{className: "dt-body-center" , "targets": [0]},
			{className: "dt-body-left"   , "targets": [1]},
			{className: "dt-body-left"   , "targets": [2]},
			{className: "dt-body-left"   , "targets": [3]},
			{className: "dt-body-center" , "targets": [4]},
			{className: "dt-body-center" , "targets": [5]}
		]
	});
	var table = $('#categoria_table').DataTable();
	table.column( '0:visible' ).order( 'asc' );
});
// Consulta filtrada
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
			$('#categoria_table').addClass( 'nowrap' ).DataTable({
				lengthChange: false, 
				responsive: true, 
				searching: true,  
				orderClasses: true, 
				paging:false,
				bInfo:false,
				language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'},
				"columnDefs": [
					{className: "dt-body-center" , "targets": [0]},
					{className: "dt-body-left"   , "targets": [1]},
					{className: "dt-body-left"   , "targets": [2]},
					{className: "dt-body-left"   , "targets": [3]},
					{className: "dt-body-center" , "targets": [4]},
					{className: "dt-body-center" , "targets": [5]}
				]
			});
			var table = $('#categoria_table').DataTable();
			table.column( '0:visible' ).order( 'asc' );
		} 
	};
	xhr.send(data);
}
// Carga el formulario para ingresar un nuevo registro
function carga_add(div,url)
{   document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var data = new FormData();
	data.append('event', 'agregar');	
	var xhr = new XMLHttpRequest();
	xhr.open('POST', url , true);
	xhr.onreadystatechange=function()
	{   if (xhr.readyState==4 && xhr.status==200)
		{   document.getElementById(div).innerHTML=xhr.responseText;
		}
	};
	xhr.send(data);
}
// Carga el formulario para editar un registro
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
		}
	};
	xhr.send(data);
}
// Realiza la actualizacion de los datos en la BD
function edit(rol_codigo,div,url)
{   if(confirm("¿Está seguro que desea editar la información de la categoria?"))
	{   document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
		var data = new FormData();
		data.append( 'event', 'edit' );
		data.append( 'codigo', document.getElementById( 'codigo_mod' ).value );
		data.append( 'nombre', document.getElementById( 'nombre_mod' ).value );
		data.append( 'descripcion', document.getElementById( 'descripcion_mod' ).value );
		data.append( 'categoriaPadre', document.getElementById( 'categoriaPadre_mod' ).value );
		data.append( 'tipoMatricula', document.getElementById( 'ckb_tipoMatricula_mod' ).checked );
		//alert(data);
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
// Realiza el ingreso de un registro nuevo
function add(div,url)
{   document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var data = new FormData();
	data.append( 'event', 'set' );
	data.append( 'nombre', document.getElementById( 'nombre_add' ).value );
	data.append( 'descripcion', document.getElementById( 'descripcion_add' ).value );
	data.append( 'categoriaPadre', document.getElementById( 'categoriaPadre_add' ).value );
	data.append( 'tipoMatricula', document.getElementById( 'ckb_tipoMatricula_add' ).checked );
	//data.append('nombres', document.getElementById('nombres_add').value);
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
	}
	xhr.send(data);
}
// Realiza la eliminacion del cliente en la BD
function del(codigo,div,url)
{   if(confirm("¿Está seguro que desea eliminar la categoria?"))
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
				busca("",div,url);
			} 
		};
		xhr.send(data);
	}
}