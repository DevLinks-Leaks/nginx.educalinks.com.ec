$(document).ready(function() {
	$('#tbl_ficha_med_consulta').DataTable({
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
			{className: "dt-body-center"  , "targets": [2]},
			{className: "dt-body-center"  , "targets": [3], "visible": false},
			{className: "dt-body-center"  , "targets": [4]},
			{className: "dt-body-center"  , "targets": [5]},
			{className: "dt-body-center"  , "targets": [6]},
			{className: "dt-body-center"  , "targets": [7], "visible": false},
			{className: "dt-body-center"  , "targets": [8]}
		]
	});
	var table = $('#tbl_ficha_med_consulta').DataTable();
	table.column( '2:visible' ).order( 'asc' );
});
function js_ficha_nuevo_navbar( object )
{   $( '.button_medic_menu' ).removeClass('btn btn-primary btn-block')
	$( '.button_medic_menu' ).addClass('btn btn-default btn-block');
	$( '.button_medic_menu' ).css('color', 'black');
	$( object ).addClass('btn btn-primary btn-block');
	$( object ).css('color', 'white');
}
function js_ficha_med_select_user( div_buttons, div_body, tipo_persona )
{   var per_codi = $('#persona_table tr.selected').find('td:nth-child(1)').text();
	var perX  = 'fmex';
	var data = new FormData();
	data.append( 'event', 'get_per_especifico_2' );
	data.append( 'tipo_persona' , tipo_persona );
	data.append( 'per_codi' , per_codi );
	data.append( 'perX' , perX );
	var xhr = new XMLHttpRequest(  );
	xhr.open( 'POST', document.getElementById('ruta_html_common').value + '/persona/controller.php' , true );
	xhr.onreadystatechange=function(  )
	{   if ( xhr.readyState === 4 && xhr.status === 200 )
		{   obj = JSON.parse(xhr.responseText);
            var n = obj['MENSAJE'].length;
            if ( n > 0 )
            {   valida_tipo_growl( obj['MENSAJE'] );
				document.getElementById( 'alum_codi' ).value 	= obj['per_codi'];
				//document.getElementById( 'alum_cedula' ).value 	= obj['cedula'];
				document.getElementById( 'alum_nombre' ).value 	= obj['nombre'];
				document.getElementById( 'alum_domi' ).value 	= obj['dir'];
				document.getElementById( 'alum_telf' ).value 	= obj['telf'];
				if( tipo_persona == 1 )
				{   document.getElementById( 'alum_curso' ).value 	= obj['curso'];
					document.getElementById( 'alum_curso' ).style.display = 'inline';
				}
				else
				{   document.getElementById( 'alum_curso' ).style.display = 'none';
				}
				document.getElementById( div_buttons ).innerHTML= "<button id='btn_ficha_med_button_save' name='btn_ficha_med_button_save' type='button' class='btn btn-success' " +
					" onclick='js_ficha_med_formulario_set(\"" + perX + "\");'> " +
					" <span class='glyphicon glyphicon-floppy-disk'></span>&nbsp;Guardar</button>";
					js_ficha_med_formulario_add( div_body, perX, tipo_persona, per_codi );
            }
            else
            {   $.growl.warning({ title: "Educalinks informa:",message: "Hubo un problema. Por favor intente en unos minutos." +
											" Si el problema persiste, comuníquese con soporte." });
            }
		}
	};
	xhr.send(data);
}
function js_ficha_med_formulario_onload( perX )
{   $("#" + perX + "_estatura").numeric({ decimal : ".",  negative : false, scale: 2, precision: 8 });
	$("#" + perX + "_peso").numeric({ decimal : ".",  negative : false, scale: 2, precision: 8 });
	$("#" + perX + "_temp_bucal").numeric({ decimal : ".",  negative : false, scale: 2, precision: 8 });
	$("#" + perX + "_pulso").numeric({ decimal : ".",  negative : false, scale: 2, precision: 8 });
	$('#' + perX + '_tbl_alergia').addClass( 'nowrap' ).DataTable({
		lengthChange: false, 
		responsive: true, 
		searching: false,  
		orderClasses: false, 
		paging:false,
		bInfo:false,
		language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'},
		"columnDefs": [
			{ "sWidth": "10%", "targets": [5] },
			{className: "dt-body-left"  , "targets": [0], "visible": false},
			{className: "dt-body-left"  , "targets": [1]},
			{className: "dt-body-left"  , "targets": [2]},
			{className: "dt-body-left"  , "targets": [3], "visible": false},
			{className: "dt-body-left"  , "targets": [4], "visible": false},
			{className: "dt-body-center", "targets": [5]}
		]
	});
	$('#' + perX + '_tbl_vacuna').addClass( 'nowrap' ).DataTable({
		lengthChange: false, 
		responsive: true, 
		searching: false,  
		orderClasses: false, 
		paging:false,
		bInfo:false,
		language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'},
		"columnDefs": [
			{ "sWidth": "10%", "targets": [5] },
			{className: "dt-body-left"  , "targets": [0], "visible": false},
			{className: "dt-body-left"  , "targets": [1]},
			{className: "dt-body-center", "targets": [2]},
			{className: "dt-body-left"  , "targets": [3]},
			{className: "dt-body-left"  , "targets": [4], "visible": false},
			{className: "dt-body-center", "targets": [5]}
		]
	});
	$('#' + perX + '_tbl_enfermedad').addClass( 'nowrap' ).DataTable({
		lengthChange: false, 
		responsive: true, 
		searching: false,  
		orderClasses: false, 
		paging:false,
		bInfo:false,
		language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'},
		"columnDefs": [
			{ "sWidth": "10%", "targets": [7] },
			{className: "dt-body-left"  , "targets": [0] , "visible": false},
			{className: "dt-body-left"  , "targets": [1]},
			{className: "dt-body-center", "targets": [2]},
			{className: "dt-body-center", "targets": [3]},
			{className: "dt-body-center", "targets": [4]},
			{className: "dt-body-left"	, "targets": [5]},
			{className: "dt-body-center", "targets": [6] , "visible": false},
			{className: "dt-body-center", "targets": [7]}
		]
	});
	$('#' + perX + "_tbl_enfermedad_familia" ).addClass( 'nowrap' ).DataTable({
		lengthChange: false, 
		responsive: true, 
		searching: false,  
		orderClasses: false, 
		paging:false,
		bInfo:false,
		language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'},
		"columnDefs": [
			{ "sWidth": "10%", "targets": [8] },
			{className: "dt-body-left"  , "targets": [0] , "visible": false},
			{className: "dt-body-left"  , "targets": [1]},
			{className: "dt-body-center", "targets": [2]},
			{className: "dt-body-center", "targets": [3]},
			{className: "dt-body-center", "targets": [4]},
			{className: "dt-body-center", "targets": [5]},
			{className: "dt-body-left"	, "targets": [6]},
			{className: "dt-body-center", "targets": [7] , "visible": false},
			{className: "dt-body-center", "targets": [8]}
		]
	});
	$('#' + perX + '_tbl_cirugia').addClass( 'nowrap' ).DataTable({
		lengthChange: false, 
		responsive: true, 
		searching: false,  
		orderClasses: false, 
		paging:false,
		bInfo:false,
		language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'},
		"columnDefs": [
			{ "sWidth": "10%", "targets": [6] },
			{className: "dt-body-left"  , "targets": [0] , "visible": false},
			{className: "dt-body-left"  , "targets": [1]},
			{className: "dt-body-center", "targets": [2]},
			{className: "dt-body-center", "targets": [3]},
			{className: "dt-body-center", "targets": [4]},
			{className: "dt-body-center", "targets": [5]},
			{className: "dt-body-left"	, "targets": [6]}
		]
	});
	$('#' + perX + '_tbl_ex_lab_clinico').addClass( 'nowrap' ).DataTable({
		lengthChange: false, 
		responsive: true, 
		searching: false,  
		orderClasses: false, 
		paging:false,
		bInfo:false,
		language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'},
		"columnDefs": [
			{ "sWidth": "10%", "targets": [4] },
			{className: "dt-body-left"  , "targets": [0] , "visible": false},
			{className: "dt-body-left"  , "targets": [1]},
			{className: "dt-body-center", "targets": [2]},
			{className: "dt-body-center", "targets": [3]},
			{className: "dt-body-center", "targets": [4]}
		]
	});
	$('#' + perX + '_tbl_radiografia').addClass( 'nowrap' ).DataTable({
		lengthChange: false, 
		responsive: true, 
		searching: false,  
		orderClasses: false, 
		paging:false,
		bInfo:false,
		language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'},
		"columnDefs": [
			{ "sWidth": "10%", "targets": [3] },
			{className: "dt-body-left"  , "targets": [0] , "visible": false},
			{className: "dt-body-left"  , "targets": [1]},
			{className: "dt-body-center", "targets": [2]},
			{className: "dt-body-left"  , "targets": [3]},
			{className: "dt-body-center", "targets": [4]}
		]
	});
}

function js_ficha_med_formulario_add( div_body, perX, tipo_persona, per_codi )
{	document.getElementById( div_body ).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
	var data = new FormData();
	data.append( 'event', 'formulario_med' );
	data.append( 'tipo_persona' , tipo_persona );
	data.append( 'per_codi' , per_codi );
	data.append( 'perX' , perX );
	var xhr = new XMLHttpRequest(  );
	xhr.open( 'POST', document.getElementById('ruta_html_medic').value + '/ficha_nuevo/controller.php' , true );
	xhr.onreadystatechange=function(  )
	{   if ( xhr.readyState === 4 && xhr.status === 200 )
		{   document.getElementById( div_body ).innerHTML = xhr.responseText;
			js_ficha_med_formulario_onload( perX );
		}
	};
	xhr.send(data);
}
function js_ficha_med_formulario_set( perX )
{   var data = new FormData( );
	document.getElementById( 'btn_ficha_med_button_save' ).disabled = true;
	var tipo_persona = document.getElementById( perX + '_tipo').value;
	data.append( 'event' , 'set_ficha_med_especifico' );
	data.append( 'perX' , perX );
	data.append( perX + '_fmex_codi' , document.getElementById( perX + '_fmex_codi' ).value );
	data.append( perX + '_per_codi' , document.getElementById( perX + '_per_codi' ).value );
	data.append( perX + '_tipo' , tipo_persona );
	
	if ( document.querySelector('input[id="' + perX + '_rdb_tipo_ficha"]:checked') )
		data.append( perX + '_rdb_tipo_ficha' , document.querySelector('input[id="' + perX + '_rdb_tipo_ficha"]:checked').value );
	
	data.append( perX + '_rdb_tabaco' , document.querySelector('input[id="' + perX + '_rdb_tabaco"]:checked').value );
	data.append( perX + '_rdb_alcohol' , document.querySelector('input[id="' + perX + '_rdb_alcohol"]:checked').value );
	data.append( perX + '_rdb_drogas' , document.querySelector('input[id="' + perX + '_rdb_drogas"]:checked').value );
	
	data.append( perX + '_con_fisica' , document.getElementById( perX + '_con_fisica' ).value );
	data.append( perX + '_act_sicomotora' , document.getElementById( perX + '_act_sicomotora' ).value );
	data.append( perX + '_deambulacion' , document.getElementById( perX + '_deambulacion' ).value );
	data.append( perX + '_exp_verbal' , document.getElementById( perX + '_exp_verbal' ).value );
	data.append( perX + '_estado_nutricional' , document.getElementById( perX + '_estado_nutricional' ).value );
	data.append( perX + '_estatura' , document.getElementById( perX + '_estatura' ).value );
	data.append( perX + '_peso' , document.getElementById( perX + '_peso' ).value );
	data.append( perX + '_temp_bucal' , document.getElementById( perX + '_temp_bucal' ).value );
	data.append( perX + '_pulso' , document.getElementById( perX + '_pulso' ).value );
	data.append( perX + '_presion_arterial' , document.getElementById( perX + '_presion_arterial' ).value );
	data.append( perX + '_piel' , document.getElementById( perX + '_piel' ).value );
	data.append( perX + '_ganglios' , document.getElementById( perX + '_ganglios' ).value );
	data.append( perX + '_cabeza' , document.getElementById( perX + '_cabeza' ).value );
	data.append( perX + '_cuello' , document.getElementById( perX + '_cuello' ).value );
	data.append( perX + '_ojos' , document.getElementById( perX + '_ojos' ).value );
	data.append( perX + '_oidos' , document.getElementById( perX + '_oidos' ).value );
	data.append( perX + '_boca' , document.getElementById( perX + '_boca' ).value );
	data.append( perX + '_nariz' , document.getElementById( perX + '_nariz' ).value );
	data.append( perX + '_dentadura' , document.getElementById( perX + '_dentadura' ).value );
	data.append( perX + '_garganta' , document.getElementById( perX + '_garganta' ).value );
	data.append( perX + '_corazon' , document.getElementById( perX + '_corazon' ).value );
	data.append( perX + '_torax' , document.getElementById( perX + '_torax' ).value );
	data.append( perX + '_pulmones' , document.getElementById( perX + '_pulmones' ).value );
	data.append( perX + '_mamas' , document.getElementById( perX + '_mamas' ).value );
	data.append( perX + '_higado' , document.getElementById( perX + '_higado' ).value );
	data.append( perX + '_ves_biliar' , document.getElementById( perX + '_ves_biliar' ).value );
	data.append( perX + '_bazo' , document.getElementById( perX + '_bazo' ).value );
	data.append( perX + '_estomago' , document.getElementById( perX + '_estomago' ).value );
	data.append( perX + '_intestinos' , document.getElementById( perX + '_intestinos' ).value );
	data.append( perX + '_apendice' , document.getElementById( perX + '_apendice' ).value );
	data.append( perX + '_ano' , document.getElementById( perX + '_ano' ).value );
	data.append( perX + '_umbilical' , document.getElementById( perX + '_umbilical' ).value );
	data.append( perX + '_rurales' , document.getElementById( perX + '_rurales' ).value );
	data.append( perX + '_inguinal_derecha' , document.getElementById( perX + '_inguinal_derecha' ).value );
	data.append( perX + '_inguinal_izquierda' , document.getElementById( perX + '_inguinal_izquierda' ).value );
	data.append( perX + '_deformaciones' , document.getElementById( perX + '_deformaciones' ).value );
	data.append( perX + '_masas_musculares' , document.getElementById( perX + '_masas_musculares' ).value );
	data.append( perX + '_movibilidad' , document.getElementById( perX + '_movibilidad' ).value );
	data.append( perX + '_puntos_dolorosos' , document.getElementById( perX + '_puntos_dolorosos' ).value );
	data.append( perX + '_tracto_urinario' , document.getElementById( perX + '_tracto_urinario' ).value );
	data.append( perX + '_espermaquia' , document.getElementById( perX + '_espermaquia' ).value );
	data.append( perX + '_tracto_genital_masculino' , document.getElementById( perX + '_tracto_genital_masculino' ).value );
	data.append( perX + '_tracto_genital_femenino' , document.getElementById( perX + '_tracto_genital_femenino' ).value );
	data.append( perX + '_menstruacion' , document.getElementById( perX + '_menstruacion' ).value );
	data.append( perX + '_menarquia' , document.getElementById( perX + '_menarquia' ).value );
	data.append( perX + '_menapmia' , document.getElementById( perX + '_menapmia' ).value );
	data.append( perX + '_gesta' , document.getElementById( perX + '_gesta' ).value );
	data.append( perX + '_partos' , document.getElementById( perX + '_partos' ).value );
	data.append( perX + '_aborto' , document.getElementById( perX + '_aborto' ).value );
	data.append( perX + '_cesarea' , document.getElementById( perX + '_cesarea' ).value );
	data.append( perX + '_superior_derecha' , document.getElementById( perX + '_superior_derecha' ).value );
	data.append( perX + '_superior_izquierda' , document.getElementById( perX + '_superior_izquierda' ).value );
	data.append( perX + '_inferior_derecha' , document.getElementById( perX + '_inferior_derecha' ).value );
	data.append( perX + '_inferior_izquierda' , document.getElementById( perX + '_inferior_izquierda' ).value );
	data.append( perX + '_ojo_derecho' , document.getElementById( perX + '_ojo_derecho' ).value );
	data.append( perX + '_ojo_izquierdo' , document.getElementById( perX + '_ojo_izquierdo' ).value );
	data.append( perX + '_oido_derecho' , document.getElementById( perX + '_oido_derecho' ).value );
	data.append( perX + '_oido_izquierdo' , document.getElementById( perX + '_oido_izquierdo' ).value );
	
	data.append( perX + '_rdb_reflex_tendinosos', document.querySelector('input[id="' + perX + '_rdb_reflex_tendinosos"]:checked').value );
	data.append( perX + '_rdb_reflex_pupilares' , document.querySelector('input[id="' + perX + '_rdb_reflex_pupilares"]:checked').value );
	
	data.append( perX + '_marcha' , document.getElementById( perX + '_marcha' ).value );
	data.append( perX + '_sens_superficial' , document.getElementById( perX + '_sens_superficial' ).value );
	data.append( perX + '_profunda_romberg' , document.getElementById( perX + '_profunda_romberg' ).value );
	data.append( perX + '_estado_mental' , document.getElementById( perX + '_estado_mental' ).value );
	data.append( perX + '_memoria' , document.getElementById( perX + '_memoria' ).value );
	data.append( perX + '_irritabilidad' , document.getElementById( perX + '_irritabilidad' ).value );
	data.append( perX + '_depresion' , document.getElementById( perX + '_depresion' ).value );
	data.append( perX + '_aptitud_trabajo' , document.getElementById( perX + '_aptitud_trabajo' ).value );
	
	var xhr = new XMLHttpRequest();
    xhr.open('POST' , document.getElementById('ruta_html_medic').value + '/ficha_nuevo/controller.php' , true);
    xhr.onreadystatechange=function()
    {   if (xhr.readyState==4 && xhr.status==200)
        {   obj = JSON.parse( xhr.responseText );
            var n = obj['MENSAJE'].length;
            if ( n > 0 )
            {   valida_tipo_growl(obj['MENSAJE']);
				document.getElementById( perX + '_fmex_codi' ).value = obj['fmex_codi'];
				document.getElementById( 'btn_ficha_med_button_save' ).disabled = false;
            }
            else
            {   $.growl.warning({ title: "Educalinks informa:",message: "Hubo un problema al obtener respuesta del sistema. Por favor, intente en unos minutos." });
				document.getElementById( 'btn_ficha_med_button_save' ).disabled = false;
            }
        }
    };
    xhr.send(data);
}
function js_ficha_med_formulario_edit( div_buttons, div_body, perX, fmex_codi )
{   document.getElementById( div_body ).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
	var perX  = 'perMain'; 
	var data = new FormData();
	data.append( 'event', 'get_ficha_med_especifico' );
	data.append( 'fmex_codi' , fmex_codi );
	data.append( 'perX' , perX );
	var xhr = new XMLHttpRequest(  );
	xhr.open( 'POST', document.getElementById('ruta_html_medic').value + '/ficha_nuevo/controller.php' , true );
	xhr.onreadystatechange=function(  )
	{   if ( xhr.readyState === 4 && xhr.status === 200 )
		{   if ( xhr.responseText.length > 0 )
            {   $.growl.notice({ title: "Educalinks informa:",message: "Datos cargados." });
				document.getElementById( div_body ).innerHTML = xhr.responseText;
				document.getElementById( div_buttons ).innerHTML= "<button type='button' class='btn btn-warning' " +
					" onclick='js_ficha_med_bandeja_consulta(\"" + div_body + "\", \"" + div_buttons + "\");'> " +
					" <&nbsp;Volver a bandeja</button>" +
					" <button id='btn_ficha_med_button_save' name='btn_ficha_med_button_save' type='button' class='btn btn-success' " +
					" onclick='js_ficha_med_formulario_set(\"" + perX + "\");'> " +
					" <span class='glyphicon glyphicon-floppy-disk'></span>&nbsp;Guardar</button>";
					js_ficha_med_formulario_onload( perX );
            }
            else
            {   $.growl.warning({ title: "Educalinks informa:",message: "Hubo un problema. Por favor intente en unos minutos." +
											" Si el problema persiste, comuníquese con soporte." });
            }
		}
	};
	xhr.send(data);
}
function js_ficha_med_bandeja_consulta( div_body, div_buttons )
{   document.getElementById( div_body ).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
	var perX  = 'perMain'; 
	var data = new FormData();
	data.append( 'event', 'get_ficha_med_listado' );
	data.append( 'is_back' , 1 );
	var xhr = new XMLHttpRequest(  );
	xhr.open( 'POST', document.getElementById('ruta_html_medic').value + '/ficha_nuevo/controller.php' , true );
	xhr.onreadystatechange=function(  )
	{   if ( xhr.readyState === 4 && xhr.status === 200 )
		{   if ( xhr.responseText.length > 0 )
            {   document.getElementById( div_body ).innerHTML = xhr.responseText;
				document.getElementById( div_buttons ).innerHTML= "";
				$('#tbl_ficha_med_consulta').DataTable({
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
						{className: "dt-body-center"  , "targets": [2]},
						{className: "dt-body-center"  , "targets": [3], "visible": false},
						{className: "dt-body-center"  , "targets": [4]},
						{className: "dt-body-center"  , "targets": [5]},
						{className: "dt-body-center"  , "targets": [6], "visible": false},
						{className: "dt-body-center"  , "targets": [7]}
					]
				});
				var table = $('#tbl_ficha_med_consulta').DataTable();
				table.column( '2:visible' ).order( 'asc' );
            }
            else
            {   $.growl.warning({ title: "Educalinks informa:",message: "Hubo un problema. Por favor intente en unos minutos." +
											" Si el problema persiste, comuníquese con soporte." });
            }
		}
	};
	xhr.send(data);
}
/*	--------------------------------------------
	ALERGIA
	--------------------------------------------
*/
function js_ficha_add_alergia( div_show_result, perX, fmex_ale_codi )
{  	if( document.getElementById( perX + '_fmex_codi').value != '' )
	{	var data = new FormData();
		/*var nombre_completo = document.getElementById( perX + '_apel').value + ' ' + document.getElementById( perX + '_apel_mat').value + ' ' 
			+ document.getElementById( perX + '_nomb').value + ' ' + document.getElementById( perX + '_nomb_seg').value;
		*/
		data.append( 'event', 'agregar_alergia' );
		data.append( 'perX' , perX );
		//data.append( 'per_nombre_completo' , nombre_completo );
		data.append( 'div_show_result' , div_show_result ); 
		data.append( 'fmex_codi' , document.getElementById( perX + '_fmex_codi').value );
		data.append( 'fmex_ale_codi' , fmex_ale_codi );
		var xhr = new XMLHttpRequest();
		xhr.open('POST' , document.getElementById('ruta_html_medic').value + '/ficha_nuevo/controller.php', true);
		xhr.onreadystatechange=function()
		{   if ( xhr.readyState === 4 && xhr.status === 200 )
			{	document.getElementById( 'div_modal_alergias' ).innerHTML = xhr.responseText;
				$('#modal_alergia').modal('show');
			}
		};
		xhr.send( data );
	}
	else
	{   alert("Debe guardar los datos generales primero para poder realizar esta acción.");	
	}
}
function js_ficha_set_alergia( div_show_result, fmex_codi, ale_codi, ale_reaccion, perX )
{  	if( ale_codi.value > 0 )
	{	ale_codi.style.border = "1px solid #D2D6DE";
		document.getElementById( perX + '_lbl_ale_nombre' ).style.color = "black";
		if( ale_reaccion.value.length > 0 )
		{	var data = new FormData();
			data.append( 'event' , 'setear_alergia' );
			data.append( 'fmex_codi' , fmex_codi );
			data.append( 'ale_codi' , ale_codi.value );
			data.append( 'ale_reaccion' , ale_reaccion.value );
			data.append( 'perX' , perX ); //perMain
			var xhr = new XMLHttpRequest();
			xhr.open('POST' , document.getElementById('ruta_html_medic').value + '/ficha_nuevo/controller.php', true);
			xhr.onreadystatechange=function()
			{   if ( xhr.readyState === 4 && xhr.status === 200 )
				{	obj = JSON.parse( xhr.responseText );
					var n = obj['MENSAJE'].length;
					if ( n > 0 )
					{   valida_tipo_growl(obj['MENSAJE']);
					}
					else
					{   $.growl.warning({ title: "Educalinks informa:",message: "No se realizó el proceso. Intente en unos minutos." });
					}
					$('#modal_alergia').modal('hide');
					js_ficha_consulta_alergia( div_show_result, fmex_codi, perX );
				}
			};
			xhr.send( data );
		}
		else
		{   $.growl.error({title: 'Educalinks Informa', message: "Por favor, escriba una descripción o una reacción."});
			ale_reaccion.style.border = "1px solid red";
			document.getElementById( perX + '_lbl_ale_reaccion' ).style.color = "red";
		}
	}
	else
	{   $.growl.error({title: 'Educalinks Informa', message: "No ha seleccionado ninguna alergia."});
		ale_codi.style.border = "1px solid red";
		document.getElementById( perX + '_lbl_ale_nombre' ).style.color = "red";
	}
}
function js_ficha_consulta_alergia( div_show_result, fmex_codi, perX )
{  	var data = new FormData();
	data.append( 'event' , 'consultar_alergia' );
	data.append( 'perX' , perX );
	data.append( 'fmex_codi' , fmex_codi );
	data.append( 'div_show_result' , div_show_result );
	var xhr = new XMLHttpRequest();
	xhr.open('POST' , document.getElementById('ruta_html_medic').value + '/ficha_nuevo/controller.php', true);
	xhr.onreadystatechange=function()
	{   if ( xhr.readyState === 4 && xhr.status === 200 )
		{	document.getElementById( div_show_result ).innerHTML = xhr.responseText;
			$('#' + perX + '_tbl_alergia').addClass( 'nowrap' ).DataTable({
				lengthChange: false, 
				responsive: true, 
				searching: false,  
				orderClasses: false, 
				paging:false,
				bInfo:false,
				language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'},
				"columnDefs": [
					{ "sWidth": "10%", "targets": [3] },
					{className: "dt-body-left"  , "targets": [0], "visible": false},
					{className: "dt-body-left"  , "targets": [1]},
					{className: "dt-body-left"  , "targets": [2]},
					{className: "dt-body-left"  , "targets": [3], "visible": false},
					{className: "dt-body-left"  , "targets": [4], "visible": false},
					{className: "dt-body-center", "targets": [5]}
				]
				
			});
		}
	};
	xhr.send( data );
}
function js_ficha_del_alergia( div_show_result, fmex_codi, perX, fmex_ale_codi )
{  	var data = new FormData();
	data.append( 'event' , 'borrar_alergia' );
	data.append( 'fmex_codi' , fmex_codi );
	data.append( 'fmex_ale_codi' , fmex_ale_codi );
	data.append( 'perX' , perX ); //perMain
	var xhr = new XMLHttpRequest();
	xhr.open('POST' , document.getElementById('ruta_html_medic').value + '/ficha_nuevo/controller.php', true);
	xhr.onreadystatechange=function()
	{   if ( xhr.readyState === 4 && xhr.status === 200 )
		{	obj = JSON.parse( xhr.responseText );
			var n = obj['MENSAJE'].length;
			if ( n > 0 )
			{   valida_tipo_growl( obj['MENSAJE'] );
			}
			else
			{   $.growl.warning({ title: "Educalinks informa:",message: "No se realizó el proceso. Intente en unos minutos." });
			}
			js_ficha_consulta_alergia( div_show_result, fmex_codi, perX );
		}
	};
	xhr.send( data );
}
/*	--------------------------------------------
	VACUNA
	--------------------------------------------
*/
function js_ficha_add_vacuna( div_show_result, perX, fmex_vac_codi )
{  	if( document.getElementById( perX + '_fmex_codi').value != '' )
	{	var data = new FormData();
		/*var nombre_completo = document.getElementById( perX + '_apel').value + ' ' + document.getElementById( perX + '_apel_mat').value + ' ' 
			+ document.getElementById( perX + '_nomb').value + ' ' + document.getElementById( perX + '_nomb_seg').value;
		*/
		data.append( 'event', 'agregar_vacuna' );
		data.append( 'perX' , perX );
		//data.append( 'per_nombre_completo' , nombre_completo );
		data.append( 'div_show_result' , div_show_result ); 
		data.append( 'fmex_codi' , document.getElementById( perX + '_fmex_codi').value );
		data.append( 'fmex_vac_codi' , fmex_vac_codi );
		var xhr = new XMLHttpRequest();
		xhr.open('POST' , document.getElementById('ruta_html_medic').value + '/ficha_nuevo/controller.php', true);
		xhr.onreadystatechange=function()
		{   if ( xhr.readyState === 4 && xhr.status === 200 )
			{	document.getElementById( 'div_modal_vacunas' ).innerHTML = xhr.responseText;
				$('#modal_vacuna').modal('show');
				$("#" + perX + "_vac_fecha").datepicker();
				$("#" + perX + "_vac_fecha").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
			}
		};
		xhr.send( data );
	}
	else
	{   alert("Debe guardar los datos generales primero para poder realizar esta acción.");	
	}
}
function js_ficha_set_vacuna( div_show_result, fmex_codi, vac_codi, vac_fecha, vac_desc, perX )
{  	if( vac_codi.value > 0 )
	{	vac_codi.style.border = "1px solid #D2D6DE";
		document.getElementById( perX + '_lbl_vac_nombre' ).style.color = "black";
		var data = new FormData();
		data.append( 'event' , 'setear_vacuna' );
		data.append( 'fmex_codi' , fmex_codi );
		data.append( 'vac_codi' , vac_codi.value );
		data.append( 'vac_fecha' , vac_fecha.value );
		data.append( 'vac_desc' , vac_desc.value );
		data.append( 'perX' , perX ); //perMain
		var xhr = new XMLHttpRequest();
		xhr.open('POST' , document.getElementById('ruta_html_medic').value + '/ficha_nuevo/controller.php', true);
		xhr.onreadystatechange=function()
		{   if ( xhr.readyState === 4 && xhr.status === 200 )
			{	obj = JSON.parse( xhr.responseText );
				var n = obj['MENSAJE'].length;
				if ( n > 0 )
				{   valida_tipo_growl(obj['MENSAJE']);
				}
				else
				{   $.growl.warning({ title: "Educalinks informa:",message: "No se realizó el proceso. Intente en unos minutos." });
				}
				$('#modal_vacuna').modal('hide');
				js_ficha_consulta_vacuna( div_show_result, fmex_codi, perX );
			}
		};
		xhr.send( data );
	}
	else
	{   $.growl.error({title: 'Educalinks Informa', message: "No ha seleccionado ninguna vacuna."});
		vac_codi.style.border = "1px solid red";
		document.getElementById( perX + '_lbl_vac_nombre' ).style.color = "red";
	}
}
function js_ficha_consulta_vacuna( div_show_result, fmex_codi, perX )
{  	var data = new FormData();
	data.append( 'event' , 'consultar_vacuna' );
	data.append( 'perX' , perX );
	data.append( 'fmex_codi' , fmex_codi );
	data.append( 'div_show_result' , div_show_result );
	var xhr = new XMLHttpRequest();
	xhr.open('POST' , document.getElementById('ruta_html_medic').value + '/ficha_nuevo/controller.php', true);
	xhr.onreadystatechange=function()
	{   if ( xhr.readyState === 4 && xhr.status === 200 )
		{	document.getElementById( div_show_result ).innerHTML = xhr.responseText;
			$('#' + perX + '_tbl_vacuna').addClass( 'nowrap' ).DataTable({
				lengthChange: false, 
				responsive: true, 
				searching: false,  
				orderClasses: false, 
				paging:false,
				bInfo:false,
				language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'},
				"columnDefs": [
					{ "sWidth": "10%", "targets": [5] },
					{className: "dt-body-left"  , "targets": [0], "visible": false},
					{className: "dt-body-left"  , "targets": [1]},
					{className: "dt-body-center", "targets": [2]},
					{className: "dt-body-left"  , "targets": [3]},
					{className: "dt-body-left"  , "targets": [4], "visible": false},
					{className: "dt-body-center", "targets": [5]}
				]
				
			});
		}
	};
	xhr.send( data );
}
function js_ficha_del_vacuna( div_show_result, fmex_codi, perX, fmex_vac_codi )
{  	var data = new FormData();
	data.append( 'event' , 'borrar_vacuna' );
	data.append( 'fmex_codi' , fmex_codi );
	data.append( 'fmex_vac_codi' , fmex_vac_codi );
	data.append( 'perX' , perX ); //perMain
	var xhr = new XMLHttpRequest();
	xhr.open('POST' , document.getElementById('ruta_html_medic').value + '/ficha_nuevo/controller.php', true);
	xhr.onreadystatechange=function()
	{   if ( xhr.readyState === 4 && xhr.status === 200 )
		{	obj = JSON.parse( xhr.responseText );
			var n = obj['MENSAJE'].length;
			if ( n > 0 )
			{   valida_tipo_growl( obj['MENSAJE'] );
			}
			else
			{   $.growl.warning({ title: "Educalinks informa:",message: "No se realizó el proceso. Intente en unos minutos." });
			}
			js_ficha_consulta_vacuna( div_show_result, fmex_codi, perX );
		}
	};
	xhr.send( data );
}
/*	--------------------------------------------
	ENFERMEDAD
	--------------------------------------------
*/
function js_ficha_add_enfermedad( div_show_result, perX, fmex_enf_codi, titular )
{  	if( document.getElementById( perX + '_fmex_codi').value != '' )
	{	var data = new FormData();
		/*var nombre_completo = document.getElementById( perX + '_apel').value + ' ' + document.getElementById( perX + '_apel_mat').value + ' ' 
			+ document.getElementById( perX + '_nomb').value + ' ' + document.getElementById( perX + '_nomb_seg').value;
		*/
		data.append( 'event', 'agregar_enfermedad' );
		data.append( 'perX' , perX );
		//data.append( 'per_nombre_completo' , nombre_completo );
		data.append( 'div_show_result' , div_show_result ); 
		data.append( 'fmex_codi' , document.getElementById( perX + '_fmex_codi').value );
		data.append( 'fmex_enf_codi' , fmex_enf_codi );
		data.append( 'titular' , titular );
		var xhr = new XMLHttpRequest();
		xhr.open('POST' , document.getElementById('ruta_html_medic').value + '/ficha_nuevo/controller.php', true);
		xhr.onreadystatechange=function()
		{   if ( xhr.readyState === 4 && xhr.status === 200 )
			{	document.getElementById( 'div_modal_enfermedades' ).innerHTML = xhr.responseText;
				$( '#modal_enfermedad' ).modal('show');
				//$( '#cmb_enf_' + perX ).select2();
				//console.log( document.getElementById( 'cmb_enf_' + perX) );
				//console.log( perX );
			}
		};
		xhr.send( data );
	}
	else
	{   alert("Debe guardar los datos generales primero para poder realizar esta acción.");	
	}
}
function js_ficha_set_enfermedad( div_show_result, fmex_codi, enf_codi, enf_tiene, enf_tuvo, enf_parentesco, enf_tratamiento, enf_desc_tratamiento, titular, perX )
{  	if( enf_codi.value > 0 )
	{	enf_codi.style.border = "1px solid #D2D6DE";
		document.getElementById( perX + '_lbl_enf_nombre' ).style.color = "black";
		var data = new FormData();
		data.append( 'event' , 'setear_enfermedad' );
		data.append( 'fmex_codi' , fmex_codi );
		data.append( 'enf_codi' , enf_codi.value );
		data.append( 'enf_parentesco' , enf_parentesco.value );
		data.append( 'enf_titular' , titular );
		if ( enf_tiene.checked ) 
			data.append( 'enf_tiene' , 'S' );
		else
			data.append( 'enf_tiene' , 'N' );
		
		if ( enf_tuvo.checked ) 
			data.append( 'enf_tuvo' , 'S' );
		else
			data.append( 'enf_tuvo' , 'N' );
		
		if ( enf_tratamiento.checked ) 
			data.append( 'enf_tratamiento' , 'S' );
		else
			data.append( 'enf_tratamiento' , 'N' );
		
		data.append( 'enf_desc_tratamiento' , enf_desc_tratamiento.value );
		data.append( 'perX' , perX );
		var xhr = new XMLHttpRequest();
		xhr.open('POST' , document.getElementById('ruta_html_medic').value + '/ficha_nuevo/controller.php', true);
		xhr.onreadystatechange=function()
		{   if ( xhr.readyState === 4 && xhr.status === 200 )
			{	obj = JSON.parse( xhr.responseText );
				var n = obj['MENSAJE'].length;
				if ( n > 0 )
				{   valida_tipo_growl(obj['MENSAJE']);
				}
				else
				{   $.growl.warning({ title: "Educalinks informa:",message: "No se realizó el proceso. Intente en unos minutos." });
				}
				$('#modal_enfermedad').modal('hide');
				js_ficha_consulta_enfermedad( div_show_result, fmex_codi, titular, perX );
			}
		};
		xhr.send( data );
	}
	else
	{   $.growl.error({title: 'Educalinks Informa', message: "No ha seleccionado ninguna enfermedad."});
		enf_codi.style.border = "1px solid red";
		document.getElementById( perX + '_lbl_enf_nombre' ).style.color = "red";
	}
}
function js_ficha_consulta_enfermedad( div_show_result, fmex_codi, titular, perX )
{   var data = new FormData();
	data.append( 'event' , 'consultar_enfermedad' );
	data.append( 'perX' , perX );
	data.append( 'fmex_codi' , fmex_codi );
	data.append( 'div_show_result' , div_show_result );
	data.append( 'titular' , titular );
	var xhr = new XMLHttpRequest();
	xhr.open('POST' , document.getElementById('ruta_html_medic').value + '/ficha_nuevo/controller.php', true);
	xhr.onreadystatechange=function()
	{   if ( xhr.readyState === 4 && xhr.status === 200 )
		{	document.getElementById( div_show_result ).innerHTML = xhr.responseText;
			if ( titular == 'T' )
			{	$('#' + perX + "_tbl_enfermedad" ).addClass( 'nowrap' ).DataTable({
					lengthChange: false, 
					responsive: true, 
					searching: false,  
					orderClasses: false, 
					paging:false,
					bInfo:false,
					language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'},
					"columnDefs": [
						{ "sWidth": "10%", "targets": [7] },
						{className: "dt-body-left"  , "targets": [0] , "visible": false},
						{className: "dt-body-left"  , "targets": [1]},
						{className: "dt-body-center", "targets": [2]},
						{className: "dt-body-center", "targets": [3]},
						{className: "dt-body-center", "targets": [4]},
						{className: "dt-body-left"	, "targets": [5]},
						{className: "dt-body-center", "targets": [6] , "visible": false},
						{className: "dt-body-center", "targets": [7]}
					]
				});
			}	
			else
			{	$('#' + perX + "_tbl_enfermedad_familia" ).addClass( 'nowrap' ).DataTable({
					lengthChange: false, 
					responsive: true, 
					searching: false,  
					orderClasses: false, 
					paging:false,
					bInfo:false,
					language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'},
					"columnDefs": [
						{ "sWidth": "10%", "targets": [8] },
						{className: "dt-body-left"  , "targets": [0] , "visible": false},
						{className: "dt-body-left"  , "targets": [1]},
						{className: "dt-body-center", "targets": [2]},
						{className: "dt-body-center", "targets": [3]},
						{className: "dt-body-center", "targets": [4]},
						{className: "dt-body-center", "targets": [5]},
						{className: "dt-body-left"	, "targets": [6]},
						{className: "dt-body-center", "targets": [7] , "visible": false},
						{className: "dt-body-center", "targets": [8]}
					]
				});
			}
			
		}
	};
	xhr.send( data );
}
function js_ficha_del_enfermedad( div_show_result, fmex_codi, perX, fmex_enf_codi, titular )
{  	var data = new FormData();
	data.append( 'event' , 'borrar_enfermedad' );
	data.append( 'fmex_codi' , fmex_codi );
	data.append( 'fmex_enf_codi' , fmex_enf_codi );
	data.append( 'perX' , perX );
	var xhr = new XMLHttpRequest();
	xhr.open('POST' , document.getElementById('ruta_html_medic').value + '/ficha_nuevo/controller.php', true);
	xhr.onreadystatechange=function()
	{   if ( xhr.readyState === 4 && xhr.status === 200 )
		{	obj = JSON.parse( xhr.responseText );
			var n = obj['MENSAJE'].length;
			if ( n > 0 )
			{   valida_tipo_growl( obj['MENSAJE'] );
			}
			else
			{   $.growl.warning({ title: "Educalinks informa:",message: "No se realizó el proceso. Intente en unos minutos." });
			}
			js_ficha_consulta_enfermedad( div_show_result, fmex_codi, titular, perX );
		}
	};
	xhr.send( data );
}
/*	--------------------------------------------
	CIRUGIA
	--------------------------------------------
*/
function js_ficha_add_cirugia( div_show_result, perX, fmex_cir_codi )
{  	if( document.getElementById( perX + '_fmex_codi').value != '' )
	{	var data = new FormData();
		/*var nombre_completo = document.getElementById( perX + '_apel').value + ' ' + document.getElementById( perX + '_apel_mat').value + ' ' 
			+ document.getElementById( perX + '_nomb').value + ' ' + document.getElementById( perX + '_nomb_seg').value;
		*/
		data.append( 'event', 'agregar_cirugia' );
		data.append( 'perX' , perX );
		//data.append( 'per_nombre_completo' , nombre_completo );
		data.append( 'div_show_result' , div_show_result ); 
		data.append( 'fmex_codi' , document.getElementById( perX + '_fmex_codi').value );
		data.append( 'fmex_cir_codi' , fmex_cir_codi );
		var xhr = new XMLHttpRequest();
		xhr.open('POST' , document.getElementById('ruta_html_medic').value + '/ficha_nuevo/controller.php', true);
		xhr.onreadystatechange=function()
		{   if ( xhr.readyState === 4 && xhr.status === 200 )
			{	document.getElementById( 'div_modal_cirugias' ).innerHTML = xhr.responseText;
				$('#modal_cirugia').modal('show');
				$("#" + perX + "_cir_fecha").datepicker();
				$("#" + perX + "_cir_fecha").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
			}
		};
		xhr.send( data );
	}
	else
	{   alert("Debe guardar los datos generales primero para poder realizar esta acción.");	
	}
}
function js_ficha_set_cirugia( div_show_result, fmex_codi, cir_fecha, cir_nombre_desc, cir_localizacion, cir_extension, cir_proposito, perX )
{  	var valido = 1;
	
	if ( !document.querySelector('input[id="' + cir_localizacion.id + '"]:checked') )
		valido = 0;
	if ( !document.querySelector('input[id="' + cir_extension.id + '"]:checked') )
		valido = 0;
	if ( !document.querySelector('input[id="' + cir_proposito.id + '"]:checked') )
		valido = 0;
	if( valido === 1 )
	{   if( cir_nombre_desc.value.length > 0 )
		{	cir_nombre_desc.style.border = "1px solid #D2D6DE";
			document.getElementById( perX + '_lbl_cir_nombre_desc' ).style.color = "black";
			var data = new FormData();
			data.append( 'event' , 'setear_cirugia' );
			data.append( 'fmex_codi' , fmex_codi );
			data.append( 'cir_fecha' , cir_fecha.value );
			data.append( 'cir_nombre_desc' , cir_nombre_desc.value );
			data.append( 'cir_localizacion' , document.querySelector('input[id="' + cir_localizacion.id + '"]:checked').value );
			data.append( 'cir_extension' , document.querySelector('input[id="' + cir_extension.id + '"]:checked').value );
			data.append( 'cir_proposito' , document.querySelector('input[id="' + cir_proposito.id + '"]:checked').value );
			data.append( 'perX' , perX );
			var xhr = new XMLHttpRequest();
			xhr.open('POST' , document.getElementById('ruta_html_medic').value + '/ficha_nuevo/controller.php', true);
			xhr.onreadystatechange=function()
			{   if ( xhr.readyState === 4 && xhr.status === 200 )
				{	obj = JSON.parse( xhr.responseText );
					var n = obj['MENSAJE'].length;
					if ( n > 0 )
					{   valida_tipo_growl(obj['MENSAJE']);
					}
					else
					{   $.growl.warning({ title: "Educalinks informa:",message: "No se realizó el proceso. Intente en unos minutos." });
					}
					$('#modal_cirugia').modal('hide');
					js_ficha_consulta_cirugia( div_show_result, fmex_codi, perX );
				}
			};
			xhr.send( data );
		}
		else
		{   $.growl.error({title: 'Educalinks Informa', message: "No ha seleccionado ninguna cirugía."});
			cir_nombre_desc.style.border = "1px solid red";
			document.getElementById( perX + '_lbl_cir_nombre_desc' ).style.color = "red";
		}
	}
	else
	{   $.growl.error({ title: "Educalinks informa:",message: "Por favor, ingrese todos los datos." });
	}
}
function js_ficha_consulta_cirugia( div_show_result, fmex_codi, perX )
{  	var data = new FormData();
	data.append( 'event' , 'consultar_cirugia' );
	data.append( 'perX' , perX );
	data.append( 'fmex_codi' , fmex_codi );
	data.append( 'div_show_result' , div_show_result );
	var xhr = new XMLHttpRequest();
	xhr.open('POST' , document.getElementById('ruta_html_medic').value + '/ficha_nuevo/controller.php', true);
	xhr.onreadystatechange=function()
	{   if ( xhr.readyState === 4 && xhr.status === 200 )
		{	document.getElementById( div_show_result ).innerHTML = xhr.responseText;
			$('#' + perX + '_tbl_cirugia').addClass( 'nowrap' ).DataTable({
				lengthChange: false, 
				responsive: true, 
				searching: false,  
				orderClasses: false, 
				paging:false,
				bInfo:false,
				language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'},
				"columnDefs": [
					{ "sWidth": "10%", "targets": [6] },
					{className: "dt-body-left"  , "targets": [0] , "visible": false},
					{className: "dt-body-left"  , "targets": [1]},
					{className: "dt-body-center", "targets": [2]},
					{className: "dt-body-center", "targets": [3]},
					{className: "dt-body-center", "targets": [4]},
					{className: "dt-body-center", "targets": [5]},
					{className: "dt-body-left"	, "targets": [6]}
				]
				
			});
		}
	};
	xhr.send( data );
}
function js_ficha_del_cirugia( div_show_result, fmex_codi, perX, fmex_cir_codi )
{  	var data = new FormData();
	data.append( 'event' , 'borrar_cirugia' );
	data.append( 'fmex_codi' , fmex_codi );
	data.append( 'fmex_cir_codi' , fmex_cir_codi );
	data.append( 'perX' , perX );
	var xhr = new XMLHttpRequest();
	xhr.open('POST' , document.getElementById('ruta_html_medic').value + '/ficha_nuevo/controller.php', true);
	xhr.onreadystatechange=function()
	{   if ( xhr.readyState === 4 && xhr.status === 200 )
		{	obj = JSON.parse( xhr.responseText );
			var n = obj['MENSAJE'].length;
			if ( n > 0 )
			{   valida_tipo_growl( obj['MENSAJE'] );
			}
			else
			{   $.growl.warning({ title: "Educalinks informa:",message: "No se realizó el proceso. Intente en unos minutos." });
			}
			js_ficha_consulta_cirugia( div_show_result, fmex_codi, perX );
		}
	};
	xhr.send( data );
}
/*	--------------------------------------------
	EXAMEN DE LABORATORIO CLINICO
	--------------------------------------------
*/
function js_ficha_add_ex_lab_clinico( div_show_result, perX, fmex_lab_codi )
{  	if( document.getElementById( perX + '_fmex_codi').value != '' )
	{	var data = new FormData();
		/*var nombre_completo = document.getElementById( perX + '_apel').value + ' ' + document.getElementById( perX + '_apel_mat').value + ' ' 
			+ document.getElementById( perX + '_nomb').value + ' ' + document.getElementById( perX + '_nomb_seg').value;
		*/
		data.append( 'event', 'agregar_ex_lab_clinico' );
		data.append( 'perX' , perX );
		//data.append( 'per_nombre_completo' , nombre_completo );
		data.append( 'div_show_result' , div_show_result ); 
		data.append( 'fmex_codi' , document.getElementById( perX + '_fmex_codi').value );
		data.append( 'fmex_lab_codi' , fmex_lab_codi );
		var xhr = new XMLHttpRequest();
		xhr.open('POST' , document.getElementById('ruta_html_medic').value + '/ficha_nuevo/controller.php', true);
		xhr.onreadystatechange=function()
		{   if ( xhr.readyState === 4 && xhr.status === 200 )
			{	document.getElementById( 'div_modal_exs_lab_clinico' ).innerHTML = xhr.responseText;
				$('#modal_ex_lab_clinico').modal('show');
				$("#" + perX + "_lab_fecha").datepicker();
				$("#" + perX + "_lab_fecha").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
			}
		};
		xhr.send( data );
	}
	else
	{   alert("Debe guardar los datos generales primero para poder realizar esta acción.");	
	}
}
function js_ficha_set_ex_lab_clinico( div_show_result, fmex_codi, lab_codi, lab_resultado, lab_fecha, perX )
{  	if( lab_codi.value > 0 )
	{	lab_codi.style.border = "1px solid #D2D6DE";
		document.getElementById( perX + '_lbl_lab_nombre' ).style.color = "black";
		if( lab_resultado.value.length > 0 )
		{	lab_resultado.style.border = "1px solid #D2D6DE";
			document.getElementById( perX + '_lbl_lab_nombre' ).style.color = "black";
			var data = new FormData();
			data.append( 'event' , 'setear_ex_lab_clinico' );
			data.append( 'fmex_codi' , fmex_codi );
			data.append( 'lab_fecha' , lab_fecha.value );
			data.append( 'lab_codi' , lab_codi.value );
			data.append( 'lab_resultado' , lab_resultado.value );
			data.append( 'perX' , perX );
			var xhr = new XMLHttpRequest();
			xhr.open('POST' , document.getElementById('ruta_html_medic').value + '/ficha_nuevo/controller.php', true);
			xhr.onreadystatechange=function()
			{   if ( xhr.readyState === 4 && xhr.status === 200 )
				{	obj = JSON.parse( xhr.responseText );
					var n = obj['MENSAJE'].length;
					if ( n > 0 )
					{   valida_tipo_growl(obj['MENSAJE']);
					}
					else
					{   $.growl.warning({ title: "Educalinks informa:",message: "No se realizó el proceso. Intente en unos minutos." });
					}
					$('#modal_ex_lab_clinico').modal('hide');
					js_ficha_consulta_ex_lab_clinico( div_show_result, fmex_codi, perX );
				}
			};
			xhr.send( data );
		}
		else
		{   $.growl.error({title: 'Educalinks Informa', message: "No ha escrito el resultado del examen especificado."});
			lab_resultado.style.border = "1px solid red";
			document.getElementById( perX + '_lbl_lab_resultado' ).style.color = "red";
		}
	}
	else
	{   $.growl.error({title: 'Educalinks Informa', message: "No ha seleccionado el examen cl&iacute;nico."});
		lab_codi.style.border = "1px solid red";
		document.getElementById( perX + '_lbl_lab_nombre' ).style.color = "red";
	}
}
function js_ficha_consulta_ex_lab_clinico( div_show_result, fmex_codi, perX )
{  	var data = new FormData();
	data.append( 'event' , 'consultar_ex_lab_clinico' );
	data.append( 'perX' , perX );
	data.append( 'fmex_codi' , fmex_codi );
	data.append( 'div_show_result' , div_show_result );
	var xhr = new XMLHttpRequest();
	xhr.open('POST' , document.getElementById('ruta_html_medic').value + '/ficha_nuevo/controller.php', true);
	xhr.onreadystatechange=function()
	{   if ( xhr.readyState === 4 && xhr.status === 200 )
		{	document.getElementById( div_show_result ).innerHTML = xhr.responseText;
			$('#' + perX + '_tbl_ex_lab_clinico').addClass( 'nowrap' ).DataTable({
				lengthChange: false, 
				responsive: true, 
				searching: false,  
				orderClasses: false, 
				paging:false,
				bInfo:false,
				language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'},
				"columnDefs": [
					{ "sWidth": "10%", "targets": [4] },
					{className: "dt-body-left"  , "targets": [0] , "visible": false},
					{className: "dt-body-left"  , "targets": [1]},
					{className: "dt-body-center", "targets": [2]},
					{className: "dt-body-center", "targets": [3]},
					{className: "dt-body-center", "targets": [4]}
				]
				
			});
		}
	};
	xhr.send( data );
}
function js_ficha_del_ex_lab_clinico( div_show_result, fmex_codi, perX, fmex_lab_codi )
{  	var data = new FormData();
	data.append( 'event' , 'borrar_ex_lab_clinico' );
	data.append( 'fmex_codi' , fmex_codi );
	data.append( 'fmex_lab_codi' , fmex_lab_codi );
	data.append( 'perX' , perX );
	var xhr = new XMLHttpRequest();
	xhr.open('POST' , document.getElementById('ruta_html_medic').value + '/ficha_nuevo/controller.php', true);
	xhr.onreadystatechange=function()
	{   if ( xhr.readyState === 4 && xhr.status === 200 )
		{	obj = JSON.parse( xhr.responseText );
			var n = obj['MENSAJE'].length;
			if ( n > 0 )
			{   valida_tipo_growl( obj['MENSAJE'] );
			}
			else
			{   $.growl.warning({ title: "Educalinks informa:",message: "No se realizó el proceso. Intente en unos minutos." });
			}
			js_ficha_consulta_ex_lab_clinico( div_show_result, fmex_codi, perX );
		}
	};
	xhr.send( data );
}
/*	--------------------------------------------
	RADIOGRAFIA
	--------------------------------------------
*/
function js_ficha_add_radiografia( div_show_result, perX, fmex_rad_codi )
{  	if( document.getElementById( perX + '_fmex_codi').value != '' )
	{	var data = new FormData();
		/*var nombre_completo = document.getElementById( perX + '_apel').value + ' ' + document.getElementById( perX + '_apel_mat').value + ' ' 
			+ document.getElementById( perX + '_nomb').value + ' ' + document.getElementById( perX + '_nomb_seg').value;
		*/
		data.append( 'event', 'agregar_radiografia' );
		data.append( 'perX' , perX );
		//data.append( 'per_nombre_completo' , nombre_completo );
		data.append( 'div_show_result' , div_show_result ); 
		data.append( 'fmex_codi' , document.getElementById( perX + '_fmex_codi').value );
		data.append( 'fmex_rad_codi' , fmex_rad_codi );
		var xhr = new XMLHttpRequest();
		xhr.open('POST' , document.getElementById('ruta_html_medic').value + '/ficha_nuevo/controller.php', true);
		xhr.onreadystatechange=function()
		{   if ( xhr.readyState === 4 && xhr.status === 200 )
			{	document.getElementById( 'div_modal_radiografias' ).innerHTML = xhr.responseText;
				$('#modal_radiografia').modal('show');
				$("#" + perX + "_rad_fecha").datepicker();
				$("#" + perX + "_rad_fecha").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
			}
		};
		xhr.send( data );
	}
	else
	{   alert("Debe guardar los datos generales primero para poder realizar esta acción.");	
	}
}
function js_ficha_set_radiografia( div_show_result, fmex_codi, rad_nombre_desc, rad_fecha, rad_localizacion, perX )
{  	if( rad_nombre_desc.value.length > 0 )
	{	rad_nombre_desc.style.border = "1px solid #D2D6DE";
		document.getElementById( perX + '_lbl_rad_nombre_desc' ).style.color = "black";
		if( rad_localizacion.value.length > 0 )
		{	rad_localizacion.style.border = "1px solid #D2D6DE";
			document.getElementById( perX + '_lbl_rad_localizacion' ).style.color = "black";
			
			var data = new FormData();
			data.append( 'event' , 'setear_radiografia' );
			data.append( 'fmex_codi' , fmex_codi );
			data.append( 'rad_nombre_desc' , rad_nombre_desc.value );
			data.append( 'rad_fecha' , rad_fecha.value );
			data.append( 'rad_localizacion' , rad_localizacion.value );
			data.append( 'perX' , perX );
			var xhr = new XMLHttpRequest();
			xhr.open('POST' , document.getElementById('ruta_html_medic').value + '/ficha_nuevo/controller.php', true);
			xhr.onreadystatechange=function()
			{   if ( xhr.readyState === 4 && xhr.status === 200 )
				{	obj = JSON.parse( xhr.responseText );
					var n = obj['MENSAJE'].length;
					if ( n > 0 )
					{   valida_tipo_growl(obj['MENSAJE']);
					}
					else
					{   $.growl.warning({ title: "Educalinks informa:",message: "No se realizó el proceso. Intente en unos minutos." });
					}
					$('#modal_radiografia').modal('hide');
					js_ficha_consulta_radiografia( div_show_result, fmex_codi, perX );
				}
			};
			xhr.send( data );
			}
		else
		{   $.growl.error({title: 'Educalinks Informa', message: "Debe describir sobre qu&eacute; lugar se hizo la radiograf&iacute;."});
			rad_localizacion.style.border = "1px solid red";
			document.getElementById( perX + '_lbl_rad_localizacion' ).style.color = "red";
		}
	}
	else
	{   $.growl.error({title: 'Educalinks Informa', message: "Debe escribir el nombre y/o una descripci&oacute;n."});
		rad_nombre_desc.style.border = "1px solid red";
		document.getElementById( perX + '_lbl_rad_nombre_desc' ).style.color = "red";
	}
}
function js_ficha_consulta_radiografia( div_show_result, fmex_codi, perX )
{  	var data = new FormData();
	data.append( 'event' , 'consultar_radiografia' );
	data.append( 'perX' , perX );
	data.append( 'fmex_codi' , fmex_codi );
	data.append( 'div_show_result' , div_show_result );
	var xhr = new XMLHttpRequest();
	xhr.open('POST' , document.getElementById('ruta_html_medic').value + '/ficha_nuevo/controller.php', true);
	xhr.onreadystatechange=function()
	{   if ( xhr.readyState === 4 && xhr.status === 200 )
		{	document.getElementById( div_show_result ).innerHTML = xhr.responseText;
			$('#' + perX + '_tbl_radiografia').addClass( 'nowrap' ).DataTable({
				lengthChange: false, 
				responsive: true, 
				searching: false,  
				orderClasses: false, 
				paging:false,
				bInfo:false,
				language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'},
				"columnDefs": [
					{ "sWidth": "10%", "targets": [3] },
					{className: "dt-body-left"  , "targets": [0] , "visible": false},
					{className: "dt-body-left"  , "targets": [1]},
					{className: "dt-body-center", "targets": [2]},
					{className: "dt-body-left"  , "targets": [3]},
					{className: "dt-body-center", "targets": [4]}
				]
				
			});
		}
	};
	xhr.send( data );
}
function js_ficha_del_radiografia( div_show_result, fmex_codi, perX, fmex_rad_codi )
{  	var data = new FormData();
	data.append( 'event' , 'borrar_radiografia' );
	data.append( 'fmex_codi' , fmex_codi );
	data.append( 'fmex_rad_codi' , fmex_rad_codi );
	data.append( 'perX' , perX );
	var xhr = new XMLHttpRequest();
	xhr.open('POST' , document.getElementById('ruta_html_medic').value + '/ficha_nuevo/controller.php', true);
	xhr.onreadystatechange=function()
	{   if ( xhr.readyState === 4 && xhr.status === 200 )
		{	obj = JSON.parse( xhr.responseText );
			var n = obj['MENSAJE'].length;
			if ( n > 0 )
			{   valida_tipo_growl( obj['MENSAJE'] );
			}
			else
			{   $.growl.warning({ title: "Educalinks informa:",message: "No se realizó el proceso. Intente en unos minutos." });
			}
			js_ficha_consulta_radiografia( div_show_result, fmex_codi, perX );
		}
	};
	xhr.send( data );
}
function js_ficha_med_formulario_pdf( div, fmex_codi, url )
{   document.getElementById( div ).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
	var data = new FormData();
	//data.append('event', 'printvisor');
	var url2 = url + '?event=print_ficha_med_pdf&fmex_codi=' + fmex_codi;
	//data.append('url',url2);
	window.open(url2);
	/*var xhr = new XMLHttpRequest();
	xhr.open('POST', url , true);
	xhr.onreadystatechange=function()
	{   if ( xhr.readyState === 4 && xhr.status === 200 )
		{   document.getElementById( div ).innerHTML = xhr.responseText;
		} 
	};
	xhr.send(data);*/
}