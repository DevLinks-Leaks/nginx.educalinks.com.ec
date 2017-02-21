function js_menu_pagos()
{   var url = '../../alumnos/pagos/';
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
function js_alumnos_general_set_repr_alum(alum_codi,repr_codi)
{   document.getElementById('information').innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
	var data = new FormData();	
	data.append('opc', 'set_alum');
	data.append('alum_codi', alum_codi);
	data.append('repr_codi', repr_codi);
	var xhr = new XMLHttpRequest();
	xhr.open('POST', '../../alumnos/script_set_alum.php' , true);
	xhr.onreadystatechange=function(){
		if (xhr.readyState==4 && xhr.status==200){
			window.location="../../alumnos/index.php";
		} 
	}
	xhr.send(data);
}