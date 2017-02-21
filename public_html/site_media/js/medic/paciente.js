var count_news = 0;

function js_paciente_select_user( div_buttons, tipo_persona, procedencia_formulario )
{   var mensaje = "";
	if ( count_news === 0)
		mensaje = '¿Desea crear nuevo registro?'
	else
		mensaje = '¿Desea crear nuevo registro? Si ha hecho cambios, y no los ha guardado, se perderán.'
	if ( confirm( mensaje ) )
	{   document.getElementById( "div_paciente_setear_formulario" ).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
		js_persona_add( div_buttons, 'div_paciente_setear_formulario', tipo_persona, procedencia_formulario );
		count_news = count_news + 1;
	}
}