function js_paciente_submit( url, evento, submenu )
{   var f = document.createElement('form');
	f.action = url;
	f.method = 'POST';
	//f.target = '_blank';
	var i = document.createElement( 'input' );
	i.type = 'hidden';
	i.name = 'event';
	i.id = 'evento';
	i.value = evento;
	f.appendChild(i);
	var j = document.createElement( 'input' );
	j.type = 'hidden';
	j.name = 'submenu';
	j.id = 'submenu';
	j.value = submenu;
	f.appendChild(j);
	document.body.appendChild(f);
	f.submit();
}
function js_paciente_nuevo( )
{   var url =  '../../medic/paciente/';
	js_paciente_submit( url, 'setear', '{menuPaciente01}');
}
function js_paciente_consulta( )
{   var url = '../../medic/paciente/';
	js_paciente_submit( url, 'buscar_todos', '{menuPaciente02}');
}
function js_ficha_med_consulta( )
{   var url = '../../medic/ficha_nuevo/';
	js_paciente_submit( url, 'get_ficha_med_listado', '{menuPaciente02}');
}
