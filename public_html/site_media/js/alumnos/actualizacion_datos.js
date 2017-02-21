function js_actualizacion_datos_formulario_set( perX )
{   var data = new FormData( );
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
				window.location.href = '/alumnos/actualizacion_datos.php'
			}
			else
			{   $.growl.warning({ title: "Educalinks informa:",message: "Hubo un problema al obtener respuesta del sistema. Por favor, intente en unos minutos." });
			}
		}
	};
	xhr.send(data);
		
	/*var noway = "false";
	if ( document.getElementById( perX + '_corazon' ).value == "" )
		noway = "true";
	if ( document.getElementById( perX + '_pulmones' ).value == "" )
		noway = "true";
	if ( document.getElementById( perX + '_superior_derecha' ).value == "" )
		noway = "true";
	if ( document.getElementById( perX + '_superior_izquierda' ).value == "" )
		noway = "true";
	if ( document.getElementById( perX + '_inferior_derecha' ).value == "" )
		noway = "true";
	if ( document.getElementById( perX + '_inferior_izquierda' ).value == "" )
		noway = "true";
	if ( document.getElementById( perX + '_ojo_derecho' ).value == "" )
		noway = "true";
	if ( document.getElementById( perX + '_ojo_izquierdo' ).value == "" )
		noway = "true";
	if ( document.getElementById( perX + '_oido_derecho' ).value == "" )
		noway = "true";
	if ( document.getElementById( perX + '_oido_izquierdo' ).value == "" )
		noway = "true";
	if ( document.getElementById( perX + '_marcha' ).value == "" )
		noway = "true";
	if ( document.getElementById( perX + '_sens_superficial' ).value == "" )
		noway = "true";
	if ( noway == 'false')
	{   //aquí va el código desde "var xhr = new XMLHttpRequest();"
	}
	else
	{   $.growl.error({ title: "Educalinks informa:",message: "Faltan llenar algunos datos." });
	}*/
}