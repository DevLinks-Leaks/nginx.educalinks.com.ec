function js_verSolicitud_submit( url, estado, submenu )
{   var f = document.createElement('form');
	f.action = url;
	f.method = 'POST';
	//f.target = '_blank';
	var i = document.createElement( 'input' );
	i.type = 'hidden';
	i.name = 'soli_estado';
	i.id = 'soli_estado';
	i.value = estado;
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
function js_verSolicitud_enviada( )
{   var url =  '../../admisiones/verSolicitud/';
	js_verSolicitud_submit( url, 'ENVIADA', '{menuSoli01}');
}
function js_verSolicitud_pdte_pago( )
{   var url = '../../admisiones/verSolicitud/';
	js_verSolicitud_submit( url, 'PDTE. PAGO', '{menuSoli02}');
}
function js_verSolicitud_pagada( )
{   var url = '../../admisiones/verSolicitud/';
	js_verSolicitud_submit( url, 'PAGADA', '{menuSoli03}' );
}
function js_verSolicitud_fecha_asignada( )
{   var url = '../../admisiones/verSolicitud/';
	js_verSolicitud_submit( url, 'FECHA ASIGNADA', '{menuSoli04}' );
}
function js_verSolicitud_ex_aprobado( )
{   var url = '../../admisiones/verSolicitud/';
	js_verSolicitud_submit( url, 'EX. APROBADO', '{menuSoli05}' );
}
function js_verSolicitud_aprobado_directores( )
{   var url = '../../admisiones/verSolicitud/';
	js_verSolicitud_submit( url, 'APROBADO DIRECTORES', '{menuSoli06}' );
}
function js_verSolicitud_admitido( )
{   var url =  '../../admisiones/verSolicitud/';
	js_verSolicitud_submit( url, 'ADMITIDO', '{menuSoli07}' );
}
function js_verSolicitud_guardada( )
{   var url =  '../../admisiones/verSolicitud/';
	js_verSolicitud_submit( url, 'GUARDADA', '{menuSoli08}' );
}
function js_verSolicitud_no_admitido( )
{   var url =  '../../admisiones/verSolicitud/';
	js_verSolicitud_submit( url, 'NO ADMITIDO', '{menuSoli09}' );
}
function js_verSolicitud_mantenimiento( )
{   var url =  '../../admisiones/verSolicitud/';
	js_verSolicitud_submit( url, 'MANT', '{menuSoli10}' );
}