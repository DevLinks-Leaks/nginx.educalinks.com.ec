/*     ------------------------------------------------------------------------------------------------------------------------------------------------
    CARGA DE DATOS
    ------------------------------------------------------------------------------------------------------------------------------------------------
    
    0. Cliente externo (se abren todas las opciones.).
    1. Alumno (se abre opción de datos académicos, se cierra datos laborales, se ).
    2. Representante (se abre la opción de datos laborales, se cierra opción de datos académicos).
    3. Empleado (se abre la opción de datos laborales, se queman los datos de empresa y RUC, se cierra opción de datos académicos).
    4. Cliente externo (todo bloqueado, menos los campos de alumnos)
    
    variable "perX" (principal: "perMain")
    
    Utilizada para poder utilizar más de una instancia de controles de personas. En caso de que alguna vez algún formulario requiera
    ser construido utilizando dos o más personas. Tal como se dio en el caso de Admisiones (ver admisiones/enviarSolicitud.js).
    
*/
function js_persona_select_user_searchlist( div_buttons, div_modal, div_body, procedencia_formulario )
{   var spanish_in="//cdn.datatables.net/plug-ins/f2c75b7247b/i18n/Spanish.json";
    document.getElementById( div_modal ).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var data = new FormData();
    data.append( 'event', 'consultar' );
    data.append( 'div_show_result' , div_body );
    data.append( 'div_buttons' , div_buttons );
    data.append( 'procedencia_formulario' , procedencia_formulario );
    var xhr = new XMLHttpRequest(  );
    xhr.open( 'POST', document.getElementById('ruta_html_common').value + '/persona/controller.php' , true );
    xhr.onreadystatechange=function(  )
    {   if ( xhr.readyState === 4 && xhr.status === 200 )
        {   document.getElementById( div_modal ).innerHTML = xhr.responseText;
            $('#persona_table').DataTable({
                "info": false,
                "ordering": true,
                "searching":false,
                "lengthChange":false,
                "paging":true,
                "language": {url: spanish_in }
            });
            $('#modal_seleccionar_persona_lista').modal('show');
        }
    };
    xhr.send(data);
}
function js_persona_select_user_searchlist_2( div_buttons, div_modal, div_body, js )
{   var spanish_in="//cdn.datatables.net/plug-ins/f2c75b7247b/i18n/Spanish.json";
    document.getElementById( div_modal ).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var data = new FormData();
    data.append( 'event', 'consultar_2' );
    data.append( 'div_show_result' , div_body );
    data.append( 'div_buttons' , div_buttons );
    data.append( 'js' , js );
    var xhr = new XMLHttpRequest(  );
    xhr.open( 'POST', document.getElementById('ruta_html_common').value + '/persona/controller.php' , true );
    xhr.onreadystatechange=function(  )
    {   if ( xhr.readyState === 4 && xhr.status === 200 )
        {   document.getElementById( div_modal ).innerHTML = xhr.responseText;
            $('#persona_table').DataTable({
                "info": false,
                "ordering": true,
                "searching":false,
                "lengthChange":false,
                "paging":true,
                "language": {url: spanish_in }
            });
            $('#modal_seleccionar_persona_lista').modal('show');
            if( js=='js_factura_selecciona' || js=='js_cobros_selecciona' )
                $("#cmb_per_consulta_tipo_persona option[value='3']").remove();
        }
    };
    xhr.send(data);
}
function js_persona_select_user_searchlist_search( tipo_persona, filtro, div, url )
{   document.getElementById( div ).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var data = new FormData();
    data.append('event', 'get_lista_persona');
    data.append('tipo_persona', tipo_persona );
    if(filtro == 'nombres')
    {   data.append(filtro, document.getElementById('nombre_busq').value);    
    }
    else
    {   data.append(filtro, document.getElementById('numeroIdentificacion_busq').value);        
    }
        
    var xhr = new XMLHttpRequest();
    xhr.open('POST', url , true);
    xhr.onreadystatechange=function()
    {   if (xhr.readyState==4 && xhr.status==200)
        {   document.getElementById(div).innerHTML=xhr.responseText;
            $('#persona_table').DataTable({
                "info": false,
                "ordering": true,
                "searching":false,
                "lengthChange":false,
                "paging":true,
                 "language": {
                     "url":"//cdn.datatables.net/plug-ins/f2c75b7247b/i18n/Spanish.json"
                 }
              });
            $('#persona_table tbody').on('click','tr',function(){
                if($(this).hasClass('selected')){
                    $(this).removeClass('selected');
                }else{
                    $('#persona_table tr.selected').removeClass('selected');
                    $(this).addClass('selected');
                }
            });
        } 
    };
    xhr.send(data);
}
function js_persona_select_user_searchlist_followed( div_buttons, div_body, procedencia_formulario, tipo_persona )
{   document.getElementById( div_body ).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var per_codi = $('#persona_table tr.selected').find('td:nth-child(1)').text();
    var perX  = 'perMain'; 
    var data = new FormData();
    data.append( 'event', 'get_per_especifico' );
    data.append( 'procedencia_formulario' , procedencia_formulario );
    data.append( 'tipo_persona' , tipo_persona );
    data.append( 'per_codi' , per_codi );
    data.append( 'perX' , perX );
    var xhr = new XMLHttpRequest(  );
    xhr.open( 'POST', document.getElementById('ruta_html_common').value + '/persona/controller.php' , true );
    xhr.onreadystatechange=function(  )
    {   if ( xhr.readyState === 4 && xhr.status === 200 )
        {   if ( xhr.responseText.length > 0 )
            {   $.growl.notice({ title: "Educalinks informa:",message: "Datos cargados." });
                document.getElementById( div_body ).innerHTML = xhr.responseText;
                document.getElementById( div_buttons ).innerHTML = "<button type='button' id='btn_persona_save_button' name='btn_persona_save_button' class='btn btn-success' " +
                " onclick='js_persona_set(\"" + perX + "\");'>" +
                " <span class='glyphicon glyphicon-floppy-disk'></span>&nbsp;Guardar</button>";
                js_persona_formularioPersona_onload( tipo_persona, perX );
            }
            else
            {   $.growl.warning({ title: "Educalinks informa:",message: "Hubo un problema. Por favor intente en unos minutos." +
                                            " Si el problema persiste, comuníquese con soporte." });
            }
        }
    };
    xhr.send(data);
}
function js_persona_get( div_buttons, div_body, procedencia_formulario, tipo_persona, per_codi, perX )
{   document.getElementById( div_body ).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var data = new FormData();
    data.append( 'event', 'get_per_especifico' );
    data.append( 'procedencia_formulario' , procedencia_formulario );
    data.append( 'tipo_persona' , tipo_persona );
    data.append( 'per_codi' , per_codi );
    data.append( 'perX' , perX );
    var xhr = new XMLHttpRequest(  );
    xhr.open( 'POST', document.getElementById('ruta_html_common').value + '/persona/controller.php' , true );
    xhr.onreadystatechange=function(  )
    {   if ( xhr.readyState === 4 && xhr.status === 200 )
        {   if ( xhr.responseText.length > 0 )
            {   $.growl.notice({ title: "Educalinks informa:",message: "Datos cargados." });
                document.getElementById( div_body ).innerHTML = xhr.responseText;
                document.getElementById( div_buttons ).innerHTML = "<button type='button' id='btn_persona_save_button' name='btn_persona_save_button' class='btn btn-success' " +
                " onclick='js_persona_set(\"" + perX + "\");'>" +
                " <span class='glyphicon glyphicon-floppy-disk'></span>&nbsp;Guardar</button>";
                js_persona_formularioPersona_onload( tipo_persona, perX );
            }
            else
            {   $.growl.warning({ title: "Educalinks informa:",message: "Hubo un problema. Por favor intente en unos minutos." +
                                            " Si el problema persiste, comuníquese con soporte." });
            }
        }
    };
    xhr.send(data);
}
function js_persona_add( div_buttons, div_body, tipo_persona, procedencia_formulario )
{   document.getElementById(div_body).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var data = new FormData();
    var perX = 'perMain';
    data.append( 'event' , 'form_per' );
    data.append( 'perX' , perX );
    data.append( 'tipo_persona' , tipo_persona ); 
    data.append( 'procedencia_formulario' , procedencia_formulario ); 
    /*  0. Cliente externo (se abren todas las opciones.).
        1. Alumno (se abre opción de datos académicos, se cierra datos laborales, se ).
        2. Representante (se abre la opción de datos laborales, se cierra opción de datos académicos).
        3. Empleado (se abre la opción de datos laborales, se queman los datos de empresa y RUC, se cierra opción de datos académicos).
        4. Cliente externo (todo bloqueado, menos los campos de alumnos)
    */
    var xhr = new XMLHttpRequest();
    xhr.open( 'POST', document.getElementById('ruta_html_common').value + '/persona/controller.php', true );
    xhr.onreadystatechange=function()
    {   if ( xhr.readyState === 4 && xhr.status === 200 )
        {   document.getElementById( div_body ).innerHTML = xhr.responseText;
            document.getElementById( div_buttons ).innerHTML = "<button type='button' id='btn_persona_save_button' name='btn_persona_save_button' class='btn btn-success' " +
                " onclick='js_persona_set(\"" + perX + "\");'> " +
                " <span class='glyphicon glyphicon-floppy-disk'></span>&nbsp;Guardar</button>";
            js_persona_formularioPersona_onload( tipo_persona, perX );
        }
    };
    xhr.send( data );
}
function js_persona_formularioPersona_onload( tipo_persona, perX )
{   $("#" + perX + "_fecha_nac").datepicker();
    $("#" + perX + "_fecha_nac").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
    
    if ( tipo_persona !== 1 )
    {   $("#" + perX + "_empr_ingreso_mensual").numeric({ decimal : ".",  negative : false, scale: 2, precision: 8 });
        $("#" + perX + "_num_hijos").numeric({ decimal : ".",  negative : false, scale: 0, precision: 3 });
    }
    
    if ( tipo_persona === '3'  || tipo_persona === '0' )
    {   $("#" + perX + "_empr_turno_empl_de").timepicker({ showInputs: false });
        $("#" + perX + "_empr_turno_empl_a").timepicker({ showInputs: false });
        $("#" + perX + "_fecha_ini_c").datepicker();
        $("#" + perX + "_fecha_ini_c").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        $("#" + perX + "_fecha_fin_c").datepicker();
        $("#" + perX + "_fecha_fin_c").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        
        $('#' + perX + '_tbl_act_ext').addClass( 'nowrap' ).DataTable({
            lengthChange: false, 
            responsive: true, 
            searching: false,  
            orderClasses: false, 
            paging:false,
            bInfo:false,
            language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'},
            "columnDefs": [
                { "sWidth": "10%", "targets": [2] },
                {className: "dt-body-left"  , "targets": [0], "visible": false},
                {className: "dt-body-left"  , "targets": [1]},
                {className: "dt-body-center", "targets": [2]}
            ]
            
        });
        $('#' + perX + '_tbl_ele_protex').addClass( 'nowrap' ).DataTable({
            lengthChange: false, 
            responsive: true, 
            searching: false,  
            orderClasses: false, 
            paging:false,
            bInfo:false,
            language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'},
            "columnDefs": [
                { "sWidth": "10%", "targets": [2] },
                {className: "dt-body-left"    , "targets": [0], "visible": false},
                {className: "dt-body-left"  , "targets": [1]},
                {className: "dt-body-center", "targets": [2]}
            ]
        });
        $('#' + perX + '_tbl_datos_laborales').addClass( 'nowrap' ).DataTable({
            lengthChange: false, 
            responsive: true, 
            searching: false,  
            orderClasses: false, 
            paging:false,
            bInfo:false,
            language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'},
            "columnDefs": [
                { "sWidth": "10%", "targets": [6] },
                {className: "dt-body-left"  , "targets": [0], "visible": false},
                {className: "dt-body-left"  , "targets": [1]},
                {className: "dt-body-center", "targets": [2]},
                {className: "dt-body-center", "targets": [3]},
                {className: "dt-body-center", "targets": [4]},
                {className: "dt-body-center", "targets": [5]},
                {className: "dt-body-center", "targets": [6]}
            ]
            
        });
    }
}
/*     ------------------------------------------------------------------------------------------------------------------------------------------------
    FORMULARIO DATOS PERSONA
    ------------------------------------------------------------------------------------------------------------------------------------------------
*/
//Tal vez js_persona_edit ya no se usa. Revisar.
function js_persona_edit( alum_codi, repr_codi, modal, url )
{   document.getElementById(modal).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var data = new FormData();
    data.append( 'event' , 'get_per_especifico' );
    data.append( 'perX' , 'perMain' ); //js_persona_set
    data.append( 'alum_codi' , alum_codi );
    data.append( 'repr_codi' , repr_codi );
    var xhr = new XMLHttpRequest();
    xhr.open('POST' , document.getElementById('ruta_html_common').value + '/persona/controller.php' , true);
    xhr.onreadystatechange=function()
    {   if ( xhr.readyState === 4 && xhr.status === 200 )
        {   document.getElementById( modal ).innerHTML = xhr.responseText;
        }
    };
    xhr.send( data );
}
function js_persona_set( perX )
{   var tipo_persona = document.getElementById('perMain_tipo').value;
    
    var validator = 'false';
    
    if( tipo_persona != 0 && tipo_persona != 3 )
    {   var validator = 'true';
    }
    else
    {   if ( !document.querySelector('input[id="' + perX + '_rdb_tipo_empl"]:checked') )
            $.growl.error({ title: "Educalinks informa:",message: "Seleccione primero el 'Tipo de empleado' en 'Datos del empleado'." });
        else
            var validator = 'true';
    }
    if ( validator == 'true' )
    {   var per_cedula = document.getElementById('perMain_numero_identificacion').value;
        var per_tipo_id = document.getElementById('cmb_perMain_tipo_identificacion').value;
        var per_nombre = document.getElementById('perMain_nomb').value;
        var per_apellido = document.getElementById('perMain_apel').value;
        if ( per_tipo_id.trim() )
        {   if ( per_cedula.trim() )
            {   if ( per_cedula.length > 4 )
                {   if ( per_nombre.trim())
					{   if ( per_apellido.trim() )
						{   js_persona_set_followed( perX, tipo_persona );
						}
						else
						{   $.growl.warning({ title: "Educalinks informa:",message: "El primer apellido no puede ir vacío." });
						}
					}
					else
					{   $.growl.warning({ title: "Educalinks informa:",message: "El primer nombre no puede ir vacío." });
					}
				}
                else
                {   $.growl.warning({ title: "Educalinks informa:",message: "El número de identificación debe ser mayor a 4 caracteres." });
                }
            }
            else
            {   $.growl.warning({ title: "Educalinks informa:",message: "Por favor, ingrese su número de identificación." });
            }
        }
        else
        {   $.growl.warning({ title: "Educalinks informa:",message: "Por favor, seleccione un tipo de indentificación." });
        }
    }
}
function js_persona_set_followed( perX, tipo_persona )
{   var data = new FormData( );
	document.getElementById('btn_persona_save_button').disabled=true;
	data.append( 'event' , 'set_per_especifico' );
	data.append( 'perX' , perX );
	data.append( 'perMain_tipo' , tipo_persona );
	data.append( 'perMain_codi' , document.getElementById('perMain_codi').value );
	data.append( 'cmb_perMain_tipo_identificacion' , document.getElementById('cmb_perMain_tipo_identificacion').value );
	data.append( 'perMain_numero_identificacion' , document.getElementById('perMain_numero_identificacion').value );
	data.append( 'perMain_nomb' , document.getElementById('perMain_nomb').value );
	data.append( 'perMain_nomb_seg' , document.getElementById('perMain_nomb_seg').value );
	data.append( 'perMain_apel' , document.getElementById('perMain_apel').value );
	data.append( 'perMain_apel_mat' , document.getElementById('perMain_apel_mat').value );
	data.append( 'perMain_rdb_genero' , document.querySelector('input[id="perMain_rdb_genero"]:checked').value );
	data.append( 'cmb_pais_perMain_residencia' , document.getElementById('cmb_pais_perMain_residencia').value );
	data.append( 'cmb_provincia_perMain_residencia' , document.getElementById('cmb_provincia_perMain_residencia').value );
	data.append( 'cmb_ciudad_perMain_residencia' , document.getElementById('cmb_ciudad_perMain_residencia').value );
	data.append( 'perMain_parroquia' , document.getElementById('perMain_parroquia').value );
	data.append( 'perMain_dir' , document.getElementById('perMain_dir').value );
	data.append( 'perMain_telf' , document.getElementById('perMain_telf').value );
	data.append( 'perMain_email_personal' , document.getElementById('perMain_email_personal').value );
	data.append( 'perMain_fecha_nac' , document.getElementById('perMain_fecha_nac').value );
	data.append( 'cmb_pais_perMain_lugar_nac' , document.getElementById('cmb_pais_perMain_lugar_nac').value );
	data.append( 'cmb_provincia_perMain_lugar_nac' , document.getElementById('cmb_provincia_perMain_lugar_nac').value );
	data.append( 'cmb_ciudad_perMain_lugar_nac' , document.getElementById('cmb_ciudad_perMain_lugar_nac').value );
	data.append( 'cmb_lateralidad_perMain' , document.getElementById('cmb_lateralidad_perMain').value );
	
	if( tipo_persona != 1 )
	{   data.append( 'perMain_empr_ingreso_mensual' , document.getElementById('perMain_empr_ingreso_mensual').value );
		data.append( 'perMain_num_hijos' , document.getElementById('perMain_num_hijos').value );
		data.append( 'cmb_estado_civil_perMain' , document.getElementById('cmb_estado_civil_perMain').value );
		data.append( 'cmb_profesion_perMain' , document.getElementById('cmb_profesion_perMain').value );
	}
	
	if( tipo_persona == 0 || tipo_persona == 3 )
	{   data.append( 'perMain_empl_codi' , document.getElementById('perMain_empl_codi').value );
		data.append( 'perMain_rdb_tipo_empl' , document.querySelector('input[id="perMain_rdb_tipo_empl"]:checked').value );
		data.append( 'cmb_area_perMain' , document.getElementById('cmb_area_perMain').value );
		data.append( 'cmb_dept_perMain' , document.getElementById('cmb_dept_perMain').value );
		data.append( 'cmb_cargo_perMain' , document.getElementById('cmb_cargo_perMain').value );
		data.append( 'perMain_empr_turno_empl_de' , document.getElementById('perMain_empr_turno_empl_de').value );
		data.append( 'perMain_empr_turno_empl_a' , document.getElementById('perMain_empr_turno_empl_a').value );
		data.append( 'cmb_jornada_perMain' , document.getElementById('cmb_jornada_perMain').value );
		data.append( 'perMain_fecha_ini_c' , document.getElementById('perMain_fecha_ini_c').value );
		data.append( 'perMain_fecha_fin_c' , document.getElementById('perMain_fecha_fin_c').value );
		data.append( 'perMain_empl_ext' , document.getElementById('perMain_empl_ext').value );
		data.append( 'perMain_empl_mail' , document.getElementById('perMain_empl_mail').value );
	}
	var xhr = new XMLHttpRequest();
	xhr.open('POST' , document.getElementById('ruta_html_common').value + '/persona/controller.php' , true);
	xhr.onreadystatechange=function()
	{   if (xhr.readyState==4 && xhr.status==200)
		{   obj = JSON.parse(xhr.responseText);
			var n = obj['MENSAJE'].length;
			if ( n > 0 )
			{   valida_tipo_growl(obj['MENSAJE']);
				document.getElementById( 'perMain_codi' ).value = obj['PER_CODI'];
				document.getElementById( 'perMain_empl_codi' ).value = obj['EMPL_CODI'];
			}
			else
			{   $.growl.warning({ title: "Educalinks informa:",message: "Proceso realizado." });
			}
			document.getElementById('btn_persona_save_button').disabled=false;
		}
	};
	xhr.send(data);
}
/*  ------------------------------------------------------------------------------------------------------------------------------------------------
    MOSTRAR VISTA DE MODALES
    ------------------------------------------------------------------------------------------------------------------------------------------------
*/
function js_persona_add_datos_laborales( div_show_result, perX, per_empr_codi )
{      if( document.getElementById( perX + '_codi').value != '' )
    {   var data = new FormData();
        var nombre_completo = document.getElementById( perX + '_apel').value + ' ' + document.getElementById( perX + '_apel_mat').value + ' ' 
            + document.getElementById( perX + '_nomb').value + ' ' + document.getElementById( perX + '_nomb_seg').value;
        
        data.append( 'event' , 'agregar_datos_laborales' );
        data.append( 'perX' , perX );
        data.append( 'per_nombre_completo' , nombre_completo );
        data.append( 'div_show_result' , div_show_result ); 
        data.append( 'per_codi' , document.getElementById( perX + '_codi').value );
        data.append( 'per_empr_codi' , document.getElementById( per_empr_codi ) );
        var xhr = new XMLHttpRequest();
        xhr.open('POST' , document.getElementById('ruta_html_common').value + '/persona/controller.php', true);
        xhr.onreadystatechange=function()
        {   if ( xhr.readyState === 4 && xhr.status === 200 )
            {   document.getElementById( 'div_modal_datos_laborales' ).innerHTML = xhr.responseText;
                $('#modal_datos_laborales').modal('show');
            }
        };
        xhr.send( data );
    }
    else
    {   alert("Debe guardar los datos generales primero para poder realizar esta acción.");
    }
}
function js_persona_add_act_ext( div_show_result, perX, per_act_ext_codi )
{      if( document.getElementById( perX + '_codi').value != '' )
    {   var data = new FormData();
        var nombre_completo = document.getElementById( perX + '_apel').value + ' ' + document.getElementById( perX + '_apel_mat').value + ' ' 
            + document.getElementById( perX + '_nomb').value + ' ' + document.getElementById( perX + '_nomb_seg').value;
        
        data.append( 'event' , 'agregar_actividades_extralaborales' );
        data.append( 'perX' , perX );
        data.append( 'per_nombre_completo' , nombre_completo );
        data.append( 'div_show_result' , div_show_result );
        data.append( 'per_codi' , document.getElementById( perX + '_codi').value );
        data.append( 'per_act_ext_codi' , per_act_ext_codi ); 
        var xhr = new XMLHttpRequest();
        xhr.open('POST' , document.getElementById('ruta_html_common').value + '/persona/controller.php', true);
        xhr.onreadystatechange=function()
        {   if ( xhr.readyState === 4 && xhr.status === 200 )
            {   document.getElementById( 'div_modal_actividades_extralaborales' ).innerHTML = xhr.responseText;
                $('#modal_show_act_ext').modal('show');
            }
        };
        xhr.send( data );
    }
    else
    {   alert("Debe guardar los datos generales primero para poder realizar esta acción.");    
    }
}
function js_persona_add_ele_protex( div_show_result, perX, per_ele_protex_codi )
{      if( document.getElementById( perX + '_codi').value != '' )
    {   var data = new FormData();
        var nombre_completo = document.getElementById( perX + '_apel').value + ' ' + document.getElementById( perX + '_apel_mat').value + ' ' 
            + document.getElementById( perX + '_nomb').value + ' ' + document.getElementById( perX + '_nomb_seg').value;
        
        data.append( 'event', 'agregar_proteccion_especial' );
        data.append( 'perX' , perX );
        data.append( 'per_nombre_completo' , nombre_completo );
        data.append( 'div_show_result' , div_show_result ); 
        data.append( 'per_codi' , document.getElementById( perX + '_codi').value );
        data.append( 'per_ele_protex_codi' , per_ele_protex_codi ); 
        var xhr = new XMLHttpRequest();
        xhr.open('POST' , document.getElementById('ruta_html_common').value + '/persona/controller.php', true);
        xhr.onreadystatechange=function()
        {   if ( xhr.readyState === 4 && xhr.status === 200 )
            {   document.getElementById( 'div_modal_proteccion_especial' ).innerHTML = xhr.responseText;
                $('#modal_proteccion_especial').modal('show');
            }
        };
        xhr.send( data );
    }
    else
    {   alert("Debe guardar los datos generales primero para poder realizar esta acción.");    
    }
}
/*     ------------------------------------------------------------------------------------------------------------------------------------------------
    SETEAR
    ------------------------------------------------------------------------------------------------------------------------------------------------
*/
function js_persona_set_act_ext( div_show_result, per_act_ext_codi, per_codi, per_act_ext_detalle, perX )
{      if( per_act_ext_detalle.value.length > 0 )
    {   var data = new FormData();
        data.append( 'event' , 'setear_actividades_extralaborales' );
        data.append( 'per_codi' , per_codi );
        data.append( 'per_act_ext_codi' , per_act_ext_codi );
        data.append( 'per_act_ext_detalle' , per_act_ext_detalle.value );
        data.append( 'perX' , perX ); //perMain
        var xhr = new XMLHttpRequest();
        xhr.open('POST' , document.getElementById('ruta_html_common').value + '/persona/controller.php', true);
        xhr.onreadystatechange=function()
        {   if ( xhr.readyState === 4 && xhr.status === 200 )
            {   obj = JSON.parse( xhr.responseText );
                var n = obj['MENSAJE'].length;
                if ( n > 0 )
                {   valida_tipo_growl(obj['MENSAJE']);
                }
                else
                {   $.growl.warning({ title: "Educalinks informa:",message: "No se realizó el proceso. Intente en unos minutos." });
                }
                $('#modal_show_act_ext').modal('hide');
                js_persona_consulta_act_ext( div_show_result, per_codi, perX );
            }
        };
        xhr.send( data );
    }
    else
    {   $.growl.error({title: 'Educalinks Informa', message: "Falta ingresar el nombre de la activdad."});
        per_act_ext_detalle.style.border = "1px solid red";
        document.getElementById( perX + '_act_ext_nombre_lbl' ).style.color = "red";
    }
}
function js_persona_set_ele_protex( div_show_result, per_codi, ele_protex_codi, perX )
{      if( ele_protex_codi.value > 0 )
    {   var data = new FormData();
        data.append( 'event' , 'setear_proteccion_especial' );
        data.append( 'per_codi' , per_codi );
        data.append( 'ele_protex_codi' , ele_protex_codi.value );
        data.append( 'perX' , perX ); //perMain
        var xhr = new XMLHttpRequest();
        xhr.open('POST' , document.getElementById('ruta_html_common').value + '/persona/controller.php', true);
        xhr.onreadystatechange=function()
        {   if ( xhr.readyState === 4 && xhr.status === 200 )
            {   obj = JSON.parse( xhr.responseText );
                var n = obj['MENSAJE'].length;
                if ( n > 0 )
                {   valida_tipo_growl(obj['MENSAJE']);
                }
                else
                {   $.growl.warning({ title: "Educalinks informa:",message: "No se realizó el proceso. Intente en unos minutos." });
                }
                $('#modal_proteccion_especial').modal('hide');
                js_persona_consulta_ele_protex( div_show_result, per_codi, perX );
            }
        };
        xhr.send( data );
    }
    else
    {   $.growl.error({title: 'Educalinks Informa', message: "No ha seleccionado un elemento de protecci&oacute;n."});
        ele_protex_codi.style.border = "1px solid red";
        document.getElementById( perX + '_lbl_protex_esp_nombre' ).style.color = "red";
    }
}
function js_persona_set_datos_laborales( div_show_result, per_codi, per_empr_codi, per_per_empr_codi, 
                                            per_empr_nomb, per_empr_ruc, per_empr_dir, per_empr_cargo, per_empr_telf, per_empr_mail, perX )
{      if( per_empr_nomb.value.length > 0 )
    {   per_empr_nomb.style.border = "1px solid #D2D6DE";
        /*if( per_empr_ruc.value.length > 0 )
        {   */
            per_empr_ruc.style.border = "1px solid #D2D6DE";
            if( per_empr_cargo.value.length > 0 )
            {   per_empr_cargo.style.border = "1px solid #D2D6DE";
                var data = new FormData();
                data.append( 'event' , 'setear_datos_laborales' );
                data.append( 'per_codi' , per_codi );
                data.append( 'perX' , perX );
                
                data.append( 'per_empr_codi'     , per_empr_codi.value );
                data.append( 'per_per_empr_codi', per_per_empr_codi.value );
                data.append( 'per_empr_nomb'     , per_empr_nomb.value );
                data.append( 'per_empr_ruc'     , per_empr_ruc.value );
                data.append( 'per_empr_dir'        , per_empr_dir.value );
                data.append( 'per_empr_cargo'     , per_empr_cargo.value );
                data.append( 'per_empr_telf'     , per_empr_telf.value );
                data.append( 'per_empr_mail'     , per_empr_mail.value );
                
                var xhr = new XMLHttpRequest();
                xhr.open('POST' , document.getElementById('ruta_html_common').value + '/persona/controller.php', true);
                xhr.onreadystatechange=function()
                {   if ( xhr.readyState === 4 && xhr.status === 200 )
                    {   obj = JSON.parse( xhr.responseText );
                        var n = obj['MENSAJE'].length;
                        if ( n > 0 )
                        {   valida_tipo_growl(obj['MENSAJE']);
                        }
                        else
                        {   $.growl.warning({ title: "Educalinks informa:",message: "No se realizó el proceso. Intente en unos minutos." });
                        }
                        $('#modal_datos_laborales').modal('hide');
                        js_persona_consulta_datos_laborales( div_show_result, per_codi, perX );
                    }
                };
                xhr.send( data );
            }
            else
            {   $.growl.error({title: 'Educalinks Informa', message: "Falta ingresar el cargo de la persona en la institución."});
                per_empr_cargo.style.border = "1px solid red";
            }
        /*}
        else
        {   $.growl.error({title: 'Educalinks Informa', message: "Falta ingresar el RUC de la institución."});
            per_empr_ruc.style.border = "1px solid red";
        }*/
    }
    else
    {   $.growl.error({title: 'Educalinks Informa', message: "Falta ingresar el nombre de la institución."});
        per_empr_nomb.style.border = "1px solid red";
    }
}
/*     ------------------------------------------------------------------------------------------------------------------------------------------------
    CARGA TABLA
    ------------------------------------------------------------------------------------------------------------------------------------------------
*/
function js_persona_consulta_datos_laborales( div_show_result, per_codi, perX )
{      var data = new FormData();
    data.append( 'event' , 'consultar_datos_laborales' );
    data.append( 'perX' , perX );
    data.append( 'per_codi' , per_codi );
    data.append( 'div_show_result' , div_show_result );
    var xhr = new XMLHttpRequest();
    xhr.open('POST' , document.getElementById('ruta_html_common').value + '/persona/controller.php', true);
    xhr.onreadystatechange=function()
    {   if ( xhr.readyState === 4 && xhr.status === 200 )
        {   document.getElementById( div_show_result ).innerHTML = xhr.responseText;
            $('#' + perX + '_tbl_datos_laborales').addClass( 'nowrap' ).DataTable({
                lengthChange: false, 
                responsive: true, 
                searching: false,  
                orderClasses: false, 
                paging:false,
                bInfo:false,
                language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'},
                "columnDefs": [
                    { "sWidth": "10%", "targets": [6] },
                    {className: "dt-body-left"  , "targets": [0], "visible": false},
                    {className: "dt-body-left"  , "targets": [1]},
                    {className: "dt-body-center", "targets": [2]},
                    {className: "dt-body-center", "targets": [3]},
                    {className: "dt-body-center", "targets": [4]},
                    {className: "dt-body-center", "targets": [5]},
                    {className: "dt-body-center", "targets": [6]}
                ]
                
            });
        }
    };
    xhr.send( data );
}
function js_persona_consulta_act_ext( div_show_result, per_codi, perX )
{      var data = new FormData();
    data.append( 'event' , 'consultar_actividades_extralaborales' );
    data.append( 'perX' , perX );
    data.append( 'per_codi' , per_codi );
    data.append( 'div_show_result' , div_show_result );
    var xhr = new XMLHttpRequest();
    xhr.open('POST' , document.getElementById('ruta_html_common').value + '/persona/controller.php', true);
    xhr.onreadystatechange=function()
    {   if ( xhr.readyState === 4 && xhr.status === 200 )
        {   document.getElementById( div_show_result ).innerHTML = xhr.responseText;
            $('#' + perX + '_tbl_act_ext').addClass( 'nowrap' ).DataTable({
                lengthChange: false, 
                responsive: true, 
                searching: false,  
                orderClasses: false, 
                paging:false,
                bInfo:false,
                language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'},
                "columnDefs": [
                    { "sWidth": "10%", "targets": [2] },
                    {className: "dt-body-left"  , "targets": [0], "visible": false},
                    {className: "dt-body-left"  , "targets": [1]},
                    {className: "dt-body-center", "targets": [2]}
                ]
                
            });
        }
    };
    xhr.send( data );
}
function js_persona_consulta_ele_protex( div_show_result, per_codi, perX )
{      var data = new FormData();
    data.append( 'event' , 'consultar_proteccion_especial' );
    data.append( 'perX' , perX );
    data.append( 'per_codi' , per_codi );
    data.append( 'div_show_result' , div_show_result );
    var xhr = new XMLHttpRequest();
    xhr.open('POST' , document.getElementById('ruta_html_common').value + '/persona/controller.php', true);
    xhr.onreadystatechange=function()
    {   if ( xhr.readyState === 4 && xhr.status === 200 )
        {   document.getElementById( div_show_result ).innerHTML = xhr.responseText;
            $('#' + perX + '_tbl_ele_protex').addClass( 'nowrap' ).DataTable({
                lengthChange: false, 
                responsive: true, 
                searching: false,  
                orderClasses: false, 
                paging:false,
                bInfo:false,
                language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'},
                "columnDefs": [
                    { "sWidth": "10%", "targets": [2] },
                    {className: "dt-body-left"  , "targets": [0], "visible": false},
                    {className: "dt-body-left"  , "targets": [1]},
                    {className: "dt-body-center", "targets": [2]}
                ]
                
            });
        }
    };
    xhr.send( data );
}
/*     ------------------------------------------------------------------------------------------------------------------------------------------------
    ELIMINACION DE DATOS ADICIONALES
    ------------------------------------------------------------------------------------------------------------------------------------------------
*/
function js_persona_del_datos_laborales( div_show_result, per_codi, perX, per_inst_codi )
{      var data = new FormData();
    data.append( 'event' , 'borrar_datos_laborales' );
    data.append( 'per_codi' , per_codi );
    data.append( 'per_inst_codi' , per_inst_codi );
    data.append( 'perX' , perX ); //perMain
    var xhr = new XMLHttpRequest();
    xhr.open('POST' , document.getElementById('ruta_html_common').value + '/persona/controller.php', true);
    xhr.onreadystatechange=function()
    {   if ( xhr.readyState === 4 && xhr.status === 200 )
        {   obj = JSON.parse( xhr.responseText );
            var n = obj['MENSAJE'].length;
            if ( n > 0 )
            {   valida_tipo_growl( obj['MENSAJE'] );
            }
            else
            {   $.growl.warning({ title: "Educalinks informa:",message: "No se realizó el proceso. Intente en unos minutos." });
            }
            js_persona_consulta_datos_laborales( div_show_result, per_codi, perX );
        }
    };
    xhr.send( data );
}
function js_persona_del_act_ext( div_show_result, per_codi, perX, per_act_ext_codi )
{      var data = new FormData();
    data.append( 'event' , 'borrar_actividades_extralaborales' );
    data.append( 'per_codi' , per_codi );
    data.append( 'per_act_ext_codi' , per_act_ext_codi );
    data.append( 'perX' , perX ); //perMain
    var xhr = new XMLHttpRequest();
    xhr.open('POST' , document.getElementById('ruta_html_common').value + '/persona/controller.php', true);
    xhr.onreadystatechange=function()
    {   if ( xhr.readyState === 4 && xhr.status === 200 )
        {   obj = JSON.parse( xhr.responseText );
            var n = obj['MENSAJE'].length;
            if ( n > 0 )
            {   valida_tipo_growl( obj['MENSAJE'] );
            }
            else
            {   $.growl.warning({ title: "Educalinks informa:",message: "No se realizó el proceso. Intente en unos minutos." });
            }
            js_persona_consulta_act_ext( div_show_result, per_codi, perX );
        }
    };
    xhr.send( data );
}
function js_persona_del_ele_protex( div_show_result, per_codi, perX, per_ele_protex_codi )
{      var data = new FormData();
    data.append( 'event' , 'borrar_proteccion_especial' );
    data.append( 'per_codi' , per_codi );
    data.append( 'per_ele_protex_codi' , per_ele_protex_codi );
    data.append( 'perX' , perX ); //perMain
    var xhr = new XMLHttpRequest();
    xhr.open('POST' , document.getElementById('ruta_html_common').value + '/persona/controller.php', true);
    xhr.onreadystatechange=function()
    {   if ( xhr.readyState === 4 && xhr.status === 200 )
        {   obj = JSON.parse( xhr.responseText );
            var n = obj['MENSAJE'].length;
            if ( n > 0 )
            {   valida_tipo_growl( obj['MENSAJE'] );
            }
            else
            {   $.growl.warning({ title: "Educalinks informa:",message: "No se realizó el proceso. Intente en unos minutos." });
            }
            js_persona_consulta_ele_protex( div_show_result, per_codi, perX );
        }
    };
    xhr.send( data );
}

/*     ------------------------------------------------------------------------------------------------------------------------------------------------
    RIESGOS LABORALES
    ------------------------------------------------------------------------------------------------------------------------------------------------
*/
function js_persona_consulta_rie_laborales( div_show_result, per_codi, perX )
{      var data = new FormData();
    data.append( 'event' , 'consultar_ant_rie_lab' );
    data.append( 'perX' , perX );
    data.append( 'per_codi' , per_codi );
    data.append( 'div_show_result' , div_show_result );
    var xhr = new XMLHttpRequest();
    xhr.open('POST' , document.getElementById('ruta_html_common').value + '/persona/controller.php', true);
    xhr.onreadystatechange=function()
    {   if ( xhr.readyState === 4 && xhr.status === 200 )
        {   document.getElementById( div_show_result ).innerHTML = xhr.responseText;
            $('#' + perX + '_tbl_rie_laborales').addClass( 'nowrap' ).DataTable({
                lengthChange: false, 
                responsive: true, 
                searching: false,  
                orderClasses: false, 
                paging:false,
                bInfo:false,
                language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'},
                "columnDefs": [
                    { "sWidth": "10%", "targets": [8] },
                    {className: "dt-body-center", "targets": [0], "visible": false},
                    {className: "dt-body-center", "targets": [1]},
                    {className: "dt-body-center", "targets": [2]},
                    {className: "dt-body-center", "targets": [3]},
                    {className: "dt-body-center", "targets": [4]},
                    {className: "dt-body-center", "targets": [5]},
                    {className: "dt-body-center", "targets": [6]},
                    {className: "dt-body-center", "targets": [7]},
                    {className: "dt-body-center", "targets": [8]}
                ]
                
            });
        }
    };
    xhr.send( data );
}
function js_persona_del_rie_laborales( div_show_result, per_codi, perX, inst_risk_codi )
{      var data = new FormData();
    data.append( 'event' , 'borrar_ant_rie_lab' );
    data.append( 'per_codi' , per_codi );
    data.append( 'inst_risk_codi' , inst_risk_codi );
    data.append( 'perX' , perX ); //perMain
    var xhr = new XMLHttpRequest();
    xhr.open('POST' , document.getElementById('ruta_html_common').value + '/persona/controller.php', true);
    xhr.onreadystatechange=function()
    {   if ( xhr.readyState === 4 && xhr.status === 200 )
        {   obj = JSON.parse( xhr.responseText );
            var n = obj['MENSAJE'].length;
            if ( n > 0 )
            {   valida_tipo_growl( obj['MENSAJE'] );
            }
            else
            {   $.growl.warning({ title: "Educalinks informa:",message: "No se realizó el proceso. Intente en unos minutos." });
            }
            js_persona_consulta_rie_laborales( div_show_result, per_codi, perX );
        }
    };
    xhr.send( data );
}
function js_persona_add_rie_laborales( div_show_result, perX, inst_risk_codi )
{      if( document.getElementById( perX + '_codi').value != '' )
    {   var data = new FormData();
        var nombre_completo = document.getElementById( perX + '_apel').value + ' ' + document.getElementById( perX + '_apel_mat').value + ' ' 
            + document.getElementById( perX + '_nomb').value + ' ' + document.getElementById( perX + '_nomb_seg').value;
        
        data.append( 'event', 'agregar_ant_rie_lab' );
        data.append( 'perX' , perX );
        data.append( 'per_nombre_completo' , nombre_completo );
        data.append( 'div_show_result' , div_show_result );
        data.append( 'per_codi' , document.getElementById( perX + '_codi').value );
        data.append( 'inst_risk_codi' , inst_risk_codi );
        var xhr = new XMLHttpRequest();
        xhr.open('POST' , document.getElementById('ruta_html_common').value + '/persona/controller.php', true);
        xhr.onreadystatechange=function()
        {   if ( xhr.readyState === 4 && xhr.status === 200 )
            {   console.log(xhr.responseText);
                document.getElementById( 'div_modal_rie_laborales' ).innerHTML = xhr.responseText;
                $('#modal_rie_laborales').modal('show');
            }
        };
        xhr.send( data );
    }
    else
    {   alert("Debe guardar los datos generales primero para poder realizar esta acción.");    
    }
}
function js_persona_set_rie_laborales(    div_show_result, per_codi, per_inst_codi,
                                        inst_risk_fisico, inst_risk_fisicomec, inst_risk_quimico,
                                        inst_risk_biologico, inst_risk_disergon, inst_risk_psicosocial, perX )
{      if( per_inst_codi.value > 0 )
    {   var data = new FormData();
        data.append( 'event' , 'setear_ant_rie_lab' );
        data.append( 'per_codi' , per_codi );
        data.append( 'per_inst_codi' , per_inst_codi.value );
        data.append( 'inst_risk_fisico' , inst_risk_fisico.value );
        data.append( 'inst_risk_fisicomec' , inst_risk_fisicomec.value );
        data.append( 'inst_risk_quimico' , inst_risk_quimico.value );
        data.append( 'inst_risk_biologico' , inst_risk_biologico.value );
        data.append( 'inst_risk_disergon' , inst_risk_disergon.value );
        data.append( 'inst_risk_psicosocial' , inst_risk_psicosocial.value );
        data.append( 'perX' , perX ); //perMain
        var xhr = new XMLHttpRequest();
        xhr.open('POST' , document.getElementById('ruta_html_common').value + '/persona/controller.php', true);
        xhr.onreadystatechange=function()
        {   if ( xhr.readyState === 4 && xhr.status === 200 )
            {   obj = JSON.parse( xhr.responseText );
                var n = obj['MENSAJE'].length;
                if ( n > 0 )
                {   valida_tipo_growl(obj['MENSAJE']);
                }
                else
                {   $.growl.warning({ title: "Educalinks informa:",message: "No se realizó el proceso. Intente en unos minutos." });
                }
                $('#modal_rie_laborales').modal('hide');
                js_persona_consulta_rie_laborales( div_show_result, per_codi, perX );
            }
        };
        xhr.send( data );
    }
    else
    {   $.growl.error({title: 'Educalinks Informa', message: "Falta ingresar el nombre de la activdad."});
        per_inst_codi.style.border = "1px solid red";
        document.getElementById( perX + '_lbl_inst_rie_fecha' ).style.color = "red";
    }
}
/*     ------------------------------------------------------------------------------------------------------------------------------------------------
    ACCIDENTES LABORALES
    ------------------------------------------------------------------------------------------------------------------------------------------------
*/
function js_persona_consulta_acc_laborales( div_show_result, per_codi, perX )
{      var data = new FormData();
    data.append( 'event' , 'consultar_ant_acc_lab' );
    data.append( 'perX' , perX );
    data.append( 'per_codi' , per_codi );
    data.append( 'div_show_result' , div_show_result );
    var xhr = new XMLHttpRequest();
    xhr.open('POST' , document.getElementById('ruta_html_common').value + '/persona/controller.php', true);
    xhr.onreadystatechange=function()
    {   if ( xhr.readyState === 4 && xhr.status === 200 )
        {   document.getElementById( div_show_result ).innerHTML = xhr.responseText;
            $('#' + perX + '_tbl_acc_laborales').addClass( 'nowrap' ).DataTable({
                lengthChange: false, 
                responsive: true, 
                searching: false,  
                orderClasses: false, 
                paging:false,
                bInfo:false,
                language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'},
                "columnDefs": [
                    { "sWidth": "10%", "targets": [8] },
                    {className: "dt-body-center", "targets": [0], "visible": false},
                    {className: "dt-body-center", "targets": [1]},
                    {className: "dt-body-center", "targets": [2]},
                    {className: "dt-body-center", "targets": [3]},
                    {className: "dt-body-center", "targets": [4]},
                    {className: "dt-body-center", "targets": [5]},
                    {className: "dt-body-center", "targets": [6]},
                    {className: "dt-body-center", "targets": [7]},
                    {className: "dt-body-center", "targets": [8]}
                ]
                
            });
        }
    };
    xhr.send( data );
}
function js_persona_del_acc_laborales( div_show_result, per_codi, perX, inst_acc_codi )
{      var data = new FormData();
    data.append( 'event' , 'borrar_ant_acc_lab' );
    data.append( 'per_codi' , per_codi );
    data.append( 'inst_acc_codi' , inst_acc_codi );
    data.append( 'perX' , perX ); //perMain
    var xhr = new XMLHttpRequest();
    xhr.open('POST' , document.getElementById('ruta_html_common').value + '/persona/controller.php', true);
    xhr.onreadystatechange=function()
    {   if ( xhr.readyState === 4 && xhr.status === 200 )
        {   obj = JSON.parse( xhr.responseText );
            var n = obj['MENSAJE'].length;
            if ( n > 0 )
            {   valida_tipo_growl( obj['MENSAJE'] );
            }
            else
            {   $.growl.warning({ title: "Educalinks informa:",message: "No se realizó el proceso. Intente en unos minutos." });
            }
            js_persona_consulta_acc_laborales( div_show_result, per_codi, perX );
        }
    };
    xhr.send( data );
}
function js_persona_add_acc_laborales( div_show_result, perX, inst_risk_codi )
{      if( document.getElementById( perX + '_codi').value != '' )
    {   var data = new FormData();
        var nombre_completo = document.getElementById( perX + '_apel').value + ' ' + document.getElementById( perX + '_apel_mat').value + ' ' 
            + document.getElementById( perX + '_nomb').value + ' ' + document.getElementById( perX + '_nomb_seg').value;
        
        data.append( 'event', 'agregar_ant_acc_lab' );
        data.append( 'perX' , perX );
        data.append( 'per_nombre_completo' , nombre_completo );
        data.append( 'div_show_result' , div_show_result );
        data.append( 'per_codi' , document.getElementById( perX + '_codi').value );
        data.append( 'inst_risk_codi' , inst_risk_codi );
        var xhr = new XMLHttpRequest();
        xhr.open('POST' , document.getElementById('ruta_html_common').value + '/persona/controller.php', true);
        xhr.onreadystatechange=function()
        {   if ( xhr.readyState === 4 && xhr.status === 200 )
            {   document.getElementById( 'div_modal_acc_laborales' ).innerHTML = xhr.responseText;
                $('#modal_acc_laborales').modal('show');
                $("#" + perX + "_inst_acc_fecha").datepicker();
                $("#" + perX + "_inst_acc_fecha").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
            }
        };
        xhr.send( data );
    }
    else
    {   alert("Debe guardar los datos generales primero para poder realizar esta acción.");    
    }
}
function js_persona_set_acc_laborales( div_show_result, per_codi,
                                    per_inst_codi, inst_acc_fecha, inst_acc_causa, inst_acc_tipo_lesion,
                                    inst_acc_parte_afectada, inst_acc_incapacidad, inst_acc_secuelas, perX )
{      if( per_inst_codi.value > 0 )
    {   var data = new FormData();
        data.append( 'event' , 'setear_ant_acc_lab' );
        data.append( 'per_codi' , per_codi );
        data.append( 'per_inst_codi' , per_inst_codi.value );
        data.append( 'inst_acc_fecha' , inst_acc_fecha.value );
        data.append( 'inst_acc_causa' , inst_acc_causa.value );
        data.append( 'inst_acc_tipo_lesion' , inst_acc_tipo_lesion.value );
        data.append( 'inst_acc_parte_afectada' , inst_acc_parte_afectada.value );
        data.append( 'inst_acc_incapacidad' , inst_acc_incapacidad.value );
        data.append( 'inst_acc_secuelas' , inst_acc_secuelas.value );
        data.append( 'perX' , perX );
        var xhr = new XMLHttpRequest();
        xhr.open('POST' , document.getElementById('ruta_html_common').value + '/persona/controller.php', true);
        xhr.onreadystatechange=function()
        {   if ( xhr.readyState === 4 && xhr.status === 200 )
            {   obj = JSON.parse( xhr.responseText );
                var n = obj['MENSAJE'].length;
                if ( n > 0 )
                {   valida_tipo_growl(obj['MENSAJE']);
                }
                else
                {   $.growl.warning({ title: "Educalinks informa:",message: "No se realizó el proceso. Intente en unos minutos." });
                }
                $('#modal_acc_laborales').modal('hide');
                js_persona_consulta_acc_laborales( div_show_result, per_codi, perX );
            }
        };
        xhr.send( data );
    }
    else
    {   $.growl.error({title: 'Educalinks Informa', message: "Falta ingresar el lugar/cargo relacionado con el accidente."});
        per_inst_codi.style.border = "1px solid red";
        document.getElementById( perX + '_lbl_inst_acc_fecha' ).style.color = "red";
    }
}