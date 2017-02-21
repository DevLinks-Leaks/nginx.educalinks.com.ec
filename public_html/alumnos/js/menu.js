function js_menu_pagos()
{   var url = '/alumnos/pagos/';
	var f = document.createElement('form');
	f.action = url;
	f.method = 'POST';
	var i = document.createElement( 'input' );
	i.type = 'hidden';
	i.name = 'event';
	i.id = 'evento';
	i.value = 'MAIN';
	f.appendChild(i);
	document.body.appendChild(f);
	f.submit();
}