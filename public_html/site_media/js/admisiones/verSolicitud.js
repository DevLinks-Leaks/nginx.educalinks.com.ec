//Variables globales
//var num_campos_fecha_asign = 0;
//var num_total_campos_fecha_asign = 0;
//
$(document).ready(function(){
	$(".detalle").tooltip({
		'html': 		true,
        'selector': 	'',
        'placement': 	'bottom',
        'container': 	'body',
		'tooltipClass': 'detalleTooltip'
    });
	$('#tbl_solicitud').DataTable({
		"bPaginate": true,
		"bStateSave": false,
		"xScroll": "100%",
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
		language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'}
	});
	$('#modal_asign_fecha').on('hidden.bs.modal', function () {
		var num = document.getElementById('hd_fecha_next').value;
		for ( num = document.getElementById('hd_fecha_next').value; num > 1; num = num - 1 )
		{   $("#div_temp_fecha_asign_" + num).remove();
		}
		document.getElementById( 'hd_fecha_next' ).value = "2";
	});
	$("#txt_s_fecha_ini").datepicker();
	$("#txt_s_fecha_fin").datepicker();
	$("#txt_s_fecha_ini").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
	$("#txt_s_fecha_fin").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
});
function js_verSolicitud_check_fecha(){
    "use strict";
    var checked=document.getElementById('chk_fecha').checked;
    if(!checked)
    {
        document.getElementById('txt_s_fecha_ini').disabled = true;
        document.getElementById('txt_s_fecha_ini').value = '';
        document.getElementById('txt_s_fecha_fin').disabled = true;
        document.getElementById('txt_s_fecha_fin').value = '';
    }else
    {
        document.getElementById('txt_s_fecha_ini').disabled = false;
        document.getElementById('txt_s_fecha_fin').disabled = false;
        document.getElementById('txt_s_fecha_ini').value = obtener_fecha('ayer'); //función en general.js
        document.getElementById('txt_s_fecha_fin').value = obtener_fecha('hoy'); //función en general.js
    }
}
function js_verSolicitud_check_opc_avanzadas()
{   var ckb_opc_adv = document.getElementById("ckb_verSolicitud_opc_adv").checked;
    if(ckb_opc_adv)
    {   $("#div_verSolicitud_opc_adv").collapse(200).collapse('show');
    }
    else
    {   $("#div_verSolicitud_opc_adv").collapse(200).collapse('hide');
    }
}
function js_verSolicitud_fecha_quitar_una( obj )
{   var obj_name = obj.attributes["name"].value;
    var wordsToFind = ["quitar_", "*quitar_*"];
    if (obj_name.toLowerCase().indexOf(wordsToFind[0]) === 0 || obj_name.toLowerCase().indexOf(wordsToFind[1]) === 0)
    {   var nombre = obj_name.replace("quitar_", "");
        $("#div_temp_fecha_asign_" + nombre).remove();
		document.getElementById( 'hd_fecha_next' ).value = Number(document.getElementById( 'hd_fecha_next' ).value) - 1;
    }
}
function js_verSolicitud_procesar_mensaje( soli_codi, per_codi, soli_estado, div, url )
{   document.getElementById( 'hd_procesar_pase_soli_codi' ).value = soli_codi;
    document.getElementById( 'hd_procesar_pase_per_codi' ).value = per_codi;
	document.getElementById( 'hd_procesar_pase_soli_estado' ).value = soli_estado;
	document.getElementById( 'hd_procesar_pase_div' ).value = div;
	document.getElementById( 'hd_procesar_pase_ruta_html' ).value = url;
	$('#modal_procesar_pase').modal('show');
}
function js_verSolicitud_eliminar_solicitud( soli_codi, div, url )
{   if ( confirm( "¿Está seguro de querer eliminar la solicitud? Una vez eliminada no podrá recuperarla" ) )
	{   var data = new FormData( );
		data.append( 'event' , 'del_soli' );
		data.append( 'soli_codi' , soli_codi );
		var xhr = new XMLHttpRequest( );
		xhr.open( 'POST' , url , true );
		xhr.onreadystatechange = function( )
		{   if ( xhr.readyState === 4 && xhr.status === 200 )
			{	var n = xhr.responseText.length;
				if ( n > 0 )
				{   valida_tipo_growl( xhr.responseText );
				}
				else
				{   $.growl.warning( { title: "Educalinks informa:", message: "Proceso realizado." } );
				}
				js_verSolicitud_buscar_todos ( "get_all", div, url, document.getElementById( 'hd_main_soli_estado' ).value, "","","","","","","","","" );
			}
		};
		xhr.send(data);	
	}
}
function js_verSolicitud_cambiar_estado( soli_codi, soli_estado, div, url )
{   document.getElementById( 'span_mce_soli_codi' ).innerHTML = soli_codi;
	document.getElementById( 'hd_mce_soli_codi' ).value = soli_codi;
	document.getElementById( 'txt_mce_estado_anterior' ).value = soli_estado;
}
function js_verSolicitud_cambiar_estado_followed( soli_codi, soli_estado, div, url )
{   if ( confirm( "¿Cambiar el estado ahora?" ) )
	{   var data = new FormData( );
		data.append( 'event' , 'set_estado_maint' );
		data.append( 'soli_codi' , soli_codi );
		data.append( 'soli_estado' , soli_estado );
		var xhr = new XMLHttpRequest( );
		xhr.open( 'POST' , url , true );
		xhr.onreadystatechange = function( )
		{   if ( xhr.readyState === 4 && xhr.status === 200 )
			{	$('#modal_cambiar_estado').modal('hide');
				var n = xhr.responseText.length;
				if ( n > 0 )
				{   valida_tipo_growl( xhr.responseText );
				}
				else
				{   $.growl.warning( { title: "Educalinks informa:", message: "Proceso realizado." } );
				}
				js_verSolicitud_buscar_todos ( "get_all", div, url, document.getElementById( 'hd_main_soli_estado' ).value, "","","","","","","","","" );
			}
		};
		xhr.send(data);	
	}
}
function js_verSolicitud_procesar( soli_codi, per_codi, soli_estado, div, url, soli_observacion, enviar_mail )
{   if ( confirm( "¿Está seguro de tomar esta acción ahora?" ) )
	{   var data = new FormData( );
		data.append( 'event' , 'set_estado' );
		data.append( 'soli_codi' , soli_codi );
		data.append( 'per_codi' , per_codi );
		data.append( 'soli_estado' , soli_estado );
		data.append( 'soli_observacion' , soli_observacion );
		data.append( 'enviar_mail' , enviar_mail );
		var xhr = new XMLHttpRequest( );
		xhr.open( 'POST' , url , true );
		xhr.onreadystatechange = function( )
		{   if ( xhr.readyState === 4 && xhr.status === 200 )
			{	obj = JSON.parse( xhr.responseText );
				var n = obj[ 'MENSAJE' ].length;
				if ( n > 0 )
				{   valida_tipo_growl( obj[ 'MENSAJE' ] );
				}
				else
				{   $.growl.warning( { title: "Educalinks informa:", message: "Proceso realizado." } );
				}
				js_verSolicitud_buscar_todos ( "get_all", div, url, document.getElementById( 'hd_main_soli_estado' ).value, "","","","","","","","","" );
			}
		};
		xhr.send(data);	
	}
}
function js_verSolicitud_consulta_general_xls( formulario )
{   document.getElementById('evento').value='print_excel';
	document.getElementById(formulario).submit();
}
function js_verSolicitud_consulta_docu_pdtes_xls( formulario )
{   document.getElementById('evento').value='print_docu_pdtes_excel';
	document.getElementById(formulario).submit();
}
function js_verSolicitud_buscar_todos( evento, div, url, soli_estado,
	txt_s_fecha_ini, txt_s_fecha_fin, txt_s_id_solicitud, cmb_s_curso_aplica, txt_s_id_repr, txt_s_num_intentos,
	txt_s_nom_postulante,	txt_s_nom_repr, txt_s_id_postulante )
{   var data = new FormData( );
	data.append( 'event' , evento );
	data.append( 'soli_estado' , soli_estado );
	data.append( 'fini_ingreso' , txt_s_fecha_ini );
	data.append( 'ffin_ingreso' , txt_s_fecha_fin );
	data.append( 'soli_codi' , txt_s_id_solicitud );
	data.append( 'curso_aplicado' , cmb_s_curso_aplica );
  //data.append( 'soli_estado' , txt_s_nom_postulante );
	data.append( 'id_repr_acad' , txt_s_id_repr );
  //data.append( 'soli_estado' , txt_s_nom_repr );
  //data.append( 'soli_estado' , txt_s_id_postulante );
	data.append( 'num_intento' , txt_s_num_intentos );
	var xhr = new XMLHttpRequest( );
	xhr.open( 'POST' , url , true );
	xhr.onreadystatechange = function( )
	{   if ( xhr.readyState === 4 && xhr.status === 200 )
		{	document.getElementById( div ).innerHTML = xhr.responseText;
			$(".detalle").tooltip({
				'html': 		true,
				'selector': 	'',
				'placement': 	'bottom',
				'container': 	'body',
				'tooltipClass': 'detalleTooltip'
			});
			$('#tbl_solicitud').DataTable({
				"bPaginate": true,
				"bStateSave": false,
				"xScroll": "100%",
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
				language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'}
			});
		}
	};
	xhr.send(data);
}
function js_verSolicitud_asignar_fecha( soli_codi, soli_estado, modal, url, admin )
{   document.getElementById( 'hd_fecha_soli_codi' ).value = soli_codi;
	document.getElementById( 'hd_fecha_soli_estado' ).value = soli_estado;
	document.getElementById( 'hd_fecha_ruta_html' ).value = url;
	$('#' + modal).modal('show');
	js_verSolicitud_fecha_examen_ver( soli_codi, modal + '_bandeja', url );
	if( admin )
	{   document.getElementById( modal + '_body' ).style.display = 'block';
        document.getElementById( modal + '_footer' ).style.display = 'block';
	}
	else
	{   document.getElementById( modal + '_body' ).style.display = 'none';
        document.getElementById( modal + '_footer' ).style.display = 'none';
	}
}
function js_verSolicitud_fecha_examen_ver( soli_codi, div_modal, url )
{   document.getElementById(div_modal).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var data = new FormData();
	data.append( 'event' , 'fecha_examen_ver' );
	data.append( 'soli_codi' , soli_codi );
	var xhr = new XMLHttpRequest();
	xhr.open( 'POST' , url , true );
	xhr.onreadystatechange = function()
	{   if (xhr.readyState==4 && xhr.status==200)
		{	var n = xhr.responseText.length;
			if ( n > 0 )
			{   document.getElementById( div_modal ).innerHTML = xhr.responseText;
			}
			else
			{   $.growl.warning( { title: "Educalinks informa:", message: "No se ha obtenido resultado del sistema." } );
			}
		}
	};
	xhr.send(data);	
}
function js_verSolicitud_fecha_examen_borrar( soli_codi, soli_fex_codi, div_modal, url )
{   if ( confirm( "¿Borrar fecha?" ) )
	{   document.getElementById(div_modal).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
		var data = new FormData();
		data.append( 'event' , 'fecha_examen_borrar' );
		data.append( 'soli_codi' , soli_codi );
		data.append( 'soli_fex_codi' , soli_fex_codi );
		var xhr = new XMLHttpRequest();
		xhr.open( 'POST' , url , true );
		xhr.onreadystatechange = function()
		{   if (xhr.readyState==4 && xhr.status==200)
			{	var n = xhr.responseText.length;
				if ( n > 0 )
				{   valida_tipo_growl( xhr.responseText );
					js_verSolicitud_fecha_examen_ver( soli_codi, div_modal, url );
				}
				else
				{   $.growl.warning( { title: "Educalinks informa:", message: "No se ha obtenido resultado del sistema." } );
				}
			}
		};
		xhr.send(data);
	}
}
function js_verSolicitud_asignar_fecha_followed( soli_codi, soli_estado, modal, url )
{   if ( confirm( "¿Asignar fecha? Puede seguir asignando más fechas después." ) )
	{  var data = new FormData();
		data.append( 'event' , 'set_fecha_asign' );
		data.append( 'soli_codi' , soli_codi );
		data.append( 'soli_fex_fecha_asignada', document.getElementById( 'txt_fecha_asign_1' ).value );
		data.append( 'soli_fex_actividad', document.getElementById( 'txt_fecha_actividad_1' ).value );
		data.append( 'cambiar_estado' , document.getElementById( 'hd_fecha_change_est_1' ).value );
		var xhr = new XMLHttpRequest( );
		xhr.open( 'POST' , url , true );
		xhr.onreadystatechange = function( )
		{   if ( xhr.readyState === 4 && xhr.status === 200 )
			{	obj = JSON.parse( xhr.responseText );
				var n = obj[ 'MENSAJE' ].length;
				if ( n > 0 )
				{   valida_tipo_growl( obj[ 'MENSAJE' ] );
				}
				else
				{   $.growl.warning( { title: "Educalinks informa:", message: "Proceso realizado." } );
				}
				js_verSolicitud_fecha_examen_ver( soli_codi, modal, url );
				document.getElementById( 'txt_fecha_actividad_1' ).value = "";
				document.getElementById( 'txt_fecha_asign_1' ).value = "";
			}
		};
		xhr.send(data);
	}
}
function js_verSolicitud_subir_sintesis( soli_codi, num_soli, modal, url, admin )
{   document.getElementById( 'hd_sint_soli_codi' ).value = soli_codi;
	document.getElementById( 'hd_sint_num_soli' ).value = num_soli;
	document.getElementById( 'hd_sint_ruta_html' ).value = url;
	$('#' + modal).modal('show');
	js_docAdmin_ver_sintesis( soli_codi, modal + '_bandeja', url );
	if( admin )
	{   document.getElementById( 'modal_subir_archivo_body' ).style.display = 'block';
        document.getElementById( 'modal_subir_archivo_footer' ).style.display = 'block';
	}
	else
	{   document.getElementById( 'modal_subir_archivo_body' ).style.display = 'none';
        document.getElementById( 'modal_subir_archivo_footer' ).style.display = 'none';
	}
}
function js_verSolicitud_carga_formulario( id_solicitud, estudiante_per_codi, div, url, deband ) //se usa desde la funcion get_solicitud_opciones del controller de 'verSolicitud'.
{   document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var data = new FormData();
	data.append( 'event' , 'form_continue' );
	data.append( 'deband' , deband );
	data.append( 'id_solicitud' , id_solicitud );
	data.append( 'estudiante_per_codi' , estudiante_per_codi );
	var xhr = new XMLHttpRequest();
	xhr.open('POST' , url , true);
	xhr.onreadystatechange = function()
	{   if ( xhr.readyState === 4 && xhr.status === 200 )
		{	var n = xhr.responseText.length;
			if ( n > 0 )
			{   document.getElementById( div ).innerHTML = xhr.responseText;
				document.getElementById('div_btn_back').style.display = 'block';
				$("#per_fecha_nac").datepicker();
				$("#per_fecha_nac").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
			}
			else
			{   $.growl.warning( { title: "Educalinks informa:", message: "No se ha obtenido resultado del sistema." } );
			}
		}
	};
	xhr.send(data);
}
function js_verSolicitud_formulario_PDF( id_solicitud, estudiante_per_codi, div, url )
{   document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    
	var data = new FormData();
	data.append('event', 'printvisor');
	var url2 = url + '?event=print_formulario_pdf&id=' + id_solicitud + '&perc=' + estudiante_per_codi;
	data.append( 'url', url2 );
	var xhr = new XMLHttpRequest();
	xhr.open( 'POST', url , true );
	xhr.onreadystatechange = function()
	{   if ( xhr.readyState === 4 && xhr.status === 200 )
		{   document.getElementById( div ).innerHTML = xhr.responseText;
		} 
	};
	xhr.send(data);
}
function js_verSolicitud_enviar( id_solicitud, div, url )
{   if ( confirm( "¿Marcar la solicitud como enviada?" ) )
	{   var data = new FormData();
		data.append('event' , 'send');
		data.append('id_solicitud' , id_solicitud);
		var xhr = new XMLHttpRequest();
		xhr.open('POST' , url , true);
		xhr.onreadystatechange=function()
		{   if ( xhr.readyState === 4 && xhr.status === 200 )
			{	obj = JSON.parse(xhr.responseText);
				if( obj['MENSAJE'] )
				{   var n = obj['MENSAJE'].length;
					if ( n > 0 )
					{   valida_tipo_growl(obj['MENSAJE']);
					}
					else
					{   $.growl.warning({ title: "Educalinks informa:",message: "Proceso realizado." });
					}	
				}
				js_verSolicitud_buscar_todos ( "get_all", div, url, document.getElementById( 'hd_main_soli_estado' ).value, "","","","","","","","","" );
			}
		};
		xhr.send(data);	
	}
}
function js_verSolicitud_check_fecha(){
    "use strict";
    var checked=document.getElementById('chk_fecha').checked;
    if(!checked)
    {
        document.getElementById('txt_s_fecha_ini').disabled = true;
        document.getElementById('txt_s_fecha_ini').value = '';
        document.getElementById('txt_s_fecha_fin').disabled = true;
        document.getElementById('txt_s_fecha_fin').value = '';
    }else
    {
        document.getElementById('txt_s_fecha_ini').disabled = false;
        document.getElementById('txt_s_fecha_fin').disabled = false;
    }
}