// JavaScript Document

$(document).ready(function(){
    "use strict";
    actualiza_badge_gest_fact();
	//get it if Status key found
	/*if(localStorage.getItem("Status"))
	{   Toaster.show("The record is added");
		localStorage.clear();
	}*/
});
var spanish="//cdn.datatables.net/plug-ins/f2c75b7247b/i18n/Spanish.json";
var myVar=setInterval(function () {"use strict"; actualiza_badge_gest_fact();}, 120000);
var gest=0;
function go_home(url){
    "use strict";
    var data = new FormData();
    data.append('event', 'index');
    var xhr = new XMLHttpRequest();
    xhr.open('POST', url , true);
    xhr.send(data);
}
function get_box(box, url, div)
{   var data = new FormData();
    data.append('event', 'get_box');
    data.append('box', box);
	var xhr = new XMLHttpRequest();
	xhr.open('POST', url , true);
	xhr.onreadystatechange=function()
	{   if (xhr.readyState==4 && xhr.status==200)
		{   document.getElementById(div).innerHTML=xhr.responseText;
		}
	};
	xhr.send(data);
}
function js_general_settings_get()
{   document.getElementById( 'modal_configColecturia_body' ).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var data = new FormData();
    data.append('event', 'config');
    var xhr = new XMLHttpRequest();
    xhr.open('POST', document.getElementById('ruta_html_finan').value + '/general/controller.php' , true);
    xhr.onreadystatechange=function()
	{   if (xhr.readyState === 4 && xhr.status === 200)
		{   document.getElementById( 'modal_configColecturia_body' ).innerHTML = xhr.responseText;
			$("#desc_pronto").numeric({ decimal : ".",  negative : false, scale: 2, precision: 5 });
			$("#desc_prepago").numeric({ decimal : ".",  negative : false, scale: 2, precision: 5 });
        }
    };
    xhr.send(data);
}
function js_general_check_usa_pp_dv()
{	var usa_pp_dv = document.getElementById( 'check_usa_pp_dv' ).checked;
	if ( usa_pp_dv )
		document.getElementById( 'desc_pronto' ).disabled = false;
	else
	{   document.getElementById( 'desc_pronto' ).disabled = true;
		document.getElementById( 'desc_pronto' ).value = '0.00';
	}
}
function js_general_settings_change(usa_pp_dv,prontopago,iva,enviar_fac_sri_en_cobro,enviar_cheque_a_bandeja,bloqueo,apikey,apikeytoken,gdm,bmpd,bgmpm,bbppp,url)
{   "use strict";
    var data = new FormData();
	data.append('usa_pp_dv', usa_pp_dv);
    data.append('prontopago', prontopago);
    data.append('iva', iva);
	data.append('enviar_fac_sri_en_cobro', enviar_fac_sri_en_cobro);
	data.append('enviar_cheque_a_bandeja', enviar_cheque_a_bandeja);
	if ( document.querySelector('input[id="rdb_metodo_descuento"]:checked') )
		data.append( 'rdb_metodo_descuento' , document.querySelector('input[id="rdb_metodo_descuento"]:checked').value );
    data.append('bloqueo', bloqueo);
    data.append('apikey', apikey);
    data.append('apikeytoken', apikeytoken);
    data.append('gdm', gdm);
    data.append('bmpd', bmpd);
	data.append('bgmpm', bgmpm);
	data.append('bbppp', bbppp);
    data.append('event', 'set_settings');
    document.getElementById( 'modal_configColecturia_body' ).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i><br>Procesando solicitud...</div>';
	var xhr = new XMLHttpRequest();
    xhr.open('POST', url , true);
    xhr.onreadystatechange=function()
	{   if (xhr.readyState === 4 && xhr.status === 200)
		{   $('#modal_configColecturia').modal('hide');
			var n = xhr.responseText.length;
			if (n > 0)
			{   valida_tipo_growl(xhr.responseText);
			}
			else
			{   $.growl.warning({ title: "Educalinks informa:",message: "Proceso realizado." + xhr.responseText });
			}
        }
    };
    xhr.send(data);
}
function js_general_rdb_bdp_active()
{   if(document.getElementById('rdb_bdp_activo_act').checked)
	{	document.getElementById('pto_prefijo_web').disabled = false;
		document.getElementById('pto_sucursal_web').disabled = false;
		document.getElementById('pto_secuencia_web').disabled = false;
	}
	else if(document.getElementById('rdb_bdp_activo_ina').checked)
	{	document.getElementById('pto_prefijo_web').disabled = 'disabled';
		document.getElementById('pto_sucursal_web').disabled = 'disabled';
		document.getElementById('pto_secuencia_web').disabled = 'disabled';
	}
}
function js_general_config_bdp_change()
{	var data = new FormData();
	data.append('event', 'set_pagoweb');
	if(document.getElementById('rdb_bdp_activo_act').checked)
	{	data.append('active_web', 'S' );
	}
	else if(document.getElementById('rdb_bdp_activo_ina').checked)
	{	data.append('active_web', 'N' );
	}
	
	data.append('puntVent_prefijo', document.getElementById('pto_prefijo_web').value);
	data.append('puntVent_codigoSucursal', document.getElementById('pto_sucursal_web').value);
	data.append('puntVent_secuencia', document.getElementById('pto_secuencia_web').value);
	document.getElementById( 'modal_configBoton_body' ).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i><br>Procesando solicitud...</div>';
	var xhr = new XMLHttpRequest();
	xhr.open('POST', document.getElementById('ruta_html_finan').value + '/general/controller.php' , true);
	xhr.onreadystatechange=function()
	{   if (xhr.readyState === 4 && xhr.status === 200)
		{   $('#modal_configBoton').modal('hide');
			document.getElementById( 'modal_configBoton_body' ).innerHTML='';
			//Limpia contenido del modal, en caso de que los nombres de los controles entren en conflicto con otro control cargado en la página.
			var n = xhr.responseText.length;
			if (n > 0)
			{   valida_tipo_growl(xhr.responseText);
			}
			else
			{   $.growl.warning({ title: "Educalinks informa:",message: "Proceso realizado." + xhr.responseText });
			}
        }
	};
	xhr.send(data);
}
function js_general_config_bdp()
{   $('#modal_configBoton').modal('show');
	document.getElementById( 'modal_configBoton_body' ).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var data = new FormData();
    data.append('event', 'config_pagoweb');
    var xhr = new XMLHttpRequest();
    xhr.open('POST', document.getElementById('ruta_html_finan').value + '/general/controller.php' , true);
    xhr.onreadystatechange=function()
	{   if (xhr.readyState === 4 && xhr.status === 200)
		{   document.getElementById( 'modal_configBoton_body' ).innerHTML = xhr.responseText;
			$('[data-toggle="popover"]').popover({html:true});
			$("#pto_prefijo_add").numeric({ decimal : false,  negative : false, precision: 3 });
			$("#pto_secuencia_add").numeric({ decimal : false,  negative : false, precision: 14 });
        }
    };
    xhr.send(data);
	
}
function cargaCursos(div, url)
{   "use strict";
    document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var comboPeriodos = document.getElementById("periodos");
    var data = new FormData();
    data.append('cod_peri', comboPeriodos.value);
    data.append('event', 'get_curso');
    var xhr = new XMLHttpRequest();
    xhr.open('POST', url , true);
    xhr.onreadystatechange=function()
    {   if (xhr.readyState === 4 && xhr.status === 200)
        {    document.getElementById(div).innerHTML=xhr.responseText;
        }
    };
    xhr.send(data);
}
function LimpiarCursos(div, url)
{   "use strict";
    document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var data = new FormData();
    data.append('event', 'unset_curso');
    var xhr = new XMLHttpRequest();
    xhr.open('POST', url , true);
    xhr.onreadystatechange=function()
    {   if (xhr.readyState === 4 && xhr.status === 200)
        {    document.getElementById(div).innerHTML=xhr.responseText;
        }
    };
    xhr.send(data);
}
function cargaCursosPorNivelEconomico(div, url)
{   "use strict";
    document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var comboPeriodos = document.getElementById("periodos");
    var comboNivelesEconomicos = document.getElementById("cmb_nivelesEconomicos");
    var data = new FormData();
    data.append('cod_peri', comboPeriodos.value);
    data.append('nivel_economico', comboNivelesEconomicos.value);
    data.append('event', 'get_curso_by_econ_level');
    var xhr = new XMLHttpRequest();
    xhr.open('POST', url , true);
    xhr.onreadystatechange=function(){
        if (xhr.readyState === 4 && xhr.status === 200){
            document.getElementById(div).innerHTML=xhr.responseText;
        }
    };
    xhr.send(data);
}
function cargaNivelesEconomicos(div, url)
{   "use strict";
    document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    var comboPeriodos = document.getElementById("periodos");
    var data = new FormData();
    data.append('cod_peri', comboPeriodos.value);
    data.append('event', 'get_nivelesEconomicos');
    var xhr = new XMLHttpRequest();
    xhr.open('POST', url , true);
    xhr.onreadystatechange=function(){
        if (xhr.readyState === 4 && xhr.status === 200){
            document.getElementById(div).innerHTML=xhr.responseText;
            LimpiarCursos('resultadoCursos',url);
        }
    };
    xhr.send(data);
}
function get_badge_class(num)
{   //bg-light-blue,yellow,red,green
	var bg_class = '';
	if (num === 0)
		bg_class = 'label pull-right';
	if((num>0) && (num <=10))
		bg_class = 'label pull-right bg-light-blue';
	if((num>10) && (num <=30))
		bg_class = 'label pull-right bg-green';
	if((num>30) && (num <=100))
		bg_class = 'label pull-right bg-yellow';
	if(num>100)
		bg_class = 'label pull-right bg-red';
	return bg_class;
}
function actualiza_badge_gest_fact()
{   "use strict";
    var url=document.getElementById('ruta_html_finan').value+'/gestionFacturas/controller.php';
    var data = new FormData();
    data.append('event', 'badge_gest_fac');
    var xhrbadge = new XMLHttpRequest();
    xhrbadge.open('POST', url , true);
    xhrbadge.onreadystatechange=function(){
        if (xhrbadge.readyState === 4 && xhrbadge.status === 200){
            if(xhrbadge.responseText === ""){
                gest=0;
            }else{
                gest=xhrbadge.responseText;
            }
			if( document.getElementById('badge_gest_fac_in') )
				document.getElementById('badge_gest_fac_in').innerHTML='<span class="' + get_badge_class(xhrbadge.responseText) + '">' + xhrbadge.responseText + '</span>';
			if( document.getElementById('badge_gest_fac_in_header1') )
				document.getElementById('badge_gest_fac_in_header1').innerHTML=xhrbadge.responseText;
			if( document.getElementById('badge_gest_fac_in_header2') )
				document.getElementById('badge_gest_fac_in_header2').innerHTML=xhrbadge.responseText;
			$('#pb_fac').removeClass().addClass(get_progress_bar_badge_class(xhrbadge.responseText));
			if( document.getElementById('pb_fac') )
				document.getElementById('pb_fac').style.width = xhrbadge.responseText + '%';
            actualiza_badge_gest_notascredito(gest);
        }
    };
    xhrbadge.send(data);
}
function actualiza_badge_gest_notascredito(badge_total)
{   "use strict";
    var url=document.getElementById('ruta_html_finan').value+'/gestionNotascredito/controller.php';
    var data = new FormData();
    data.append('event', 'badge_gest_nc');
    var xhrbadgenc = new XMLHttpRequest();
    xhrbadgenc.open('POST', url , true);
    xhrbadgenc.onreadystatechange=function(){
        if (xhrbadgenc.readyState === 4 && xhrbadgenc.status === 200){
            var gestnc=0;
            var gestsuma=0;
            if(xhrbadgenc.responseText === ""){
                gestnc=0;
            }else{
                gestnc=xhrbadgenc.responseText;
            }
            gestsuma=parseInt(badge_total)+parseInt(gestnc);
            if( document.getElementById('badge_gest_nc_in') )
				document.getElementById('badge_gest_nc_in').innerHTML = '<span class="' + get_badge_class(xhrbadgenc.responseText) + '">' + xhrbadgenc.responseText + '</span>';
			if( document.getElementById('badge_gest_nc_in_header1') )
				document.getElementById('badge_gest_nc_in_header1').innerHTML = xhrbadgenc.responseText;
			if( document.getElementById('badge_gest_nc_in_header2') )
				document.getElementById('badge_gest_nc_in_header2').innerHTML = xhrbadgenc.responseText;
			$('#pb_nc').removeClass().addClass(get_progress_bar_badge_class(xhrbadgenc.responseText));
			document.getElementById('pb_nc').style.width = xhrbadgenc.responseText + '%';
			//actualiza_badge_gest_notasdebito(gestsuma);
			actualiza_badge_gest_deudas(gestsuma);
        }
    };
    xhrbadgenc.send(data);
}
function actualiza_badge_gest_notasdebito(badge_total)
{   "use strict";
    var url=document.getElementById('ruta_html_finan').value+'/gestionNotasdebito/controller.php';
    var data = new FormData();
    data.append('event', 'badge_gest_nd');
    var xhrbadgend = new XMLHttpRequest();
    xhrbadgend.open('POST', url , true);
    xhrbadgend.onreadystatechange=function(){
        if (xhrbadgend.readyState === 4 && xhrbadgend.status === 200){
            var gestnd=0;
            var gestsuma=0;
            if(xhrbadgend.responseText === ""){
                gestnd=0;
            }else{
                gestnd=xhrbadgend.responseText;
            }
            gestsuma=parseInt(badge_total)+parseInt(gestnd);
			if( document.getElementById('badge_gest_nd_in') )
				document.getElementById('badge_gest_nd_in').innerHTML='<span class="' + get_badge_class(xhrbadgend.responseText) + '">' + xhrbadgend.responseText + '</span>';
			if( document.getElementById('badge_gest_nd_in_header1') )
				document.getElementById('badge_gest_nd_in_header1').innerHTML = xhrbadgend.responseText;
			if( document.getElementById('badge_gest_nd_in_header2') )
				document.getElementById('badge_gest_nd_in_header2').innerHTML = xhrbadgend.responseText;
			$('#pb_nd').removeClass().addClass(get_progress_bar_badge_class(xhrbadgend.responseText));
			if( document.getElementById('pb_nd') )
				document.getElementById('pb_nd').style.width = xhrbadgend.responseText + '%';
			actualiza_badge_gest_deudas(gestsuma);
        }
    };
    xhrbadgend.send(data);
}
function actualiza_badge_gest_deudas(badge_total)
{   "use strict";
    var url=document.getElementById('ruta_html_finan').value+'/contabilidad/controller.php';
    var data = new FormData();
    data.append('event', 'view_badge_deudas');
    var xhrbadgedeuda = new XMLHttpRequest();
    xhrbadgedeuda.open('POST', url , true);
    xhrbadgedeuda.onreadystatechange=function(){
        if (xhrbadgedeuda.readyState === 4 && xhrbadgedeuda.status === 200){
            var gestdeudas=0;
            var gestsuma=0;
            if(xhrbadgedeuda.responseText === ""){
                gestdeudas=0;
            }else{
                gestdeudas=xhrbadgedeuda.responseText;
            }
            gestsuma=parseInt(badge_total)+parseInt(gestdeudas);
			if ( document.getElementById('badge_gest_deudas_in') )
			{   document.getElementById('badge_gest_deudas_in').innerHTML = '<span class="' + get_badge_class(xhrbadgedeuda.responseText) + '">' + xhrbadgedeuda.responseText + '</span>';
			}
			if( document.getElementById('badge_gest_deudas_in_header1') )
				document.getElementById('badge_gest_deudas_in_header1').innerHTML = xhrbadgedeuda.responseText;
			if( document.getElementById('badge_gest_deudas_in_header2') )
				document.getElementById('badge_gest_deudas_in_header2').innerHTML = xhrbadgedeuda.responseText;
			$('#pb_deudas').removeClass().addClass(get_progress_bar_badge_class(xhrbadgedeuda.responseText));
			if( document.getElementById('pb_deudas') )
				document.getElementById('pb_deudas').style.width = xhrbadgedeuda.responseText + '%';
			actualiza_badge_gest_pagos(gestsuma,gestdeudas);
        }
    };
    xhrbadgedeuda.send(data);
}
function actualiza_badge_gest_pagos(badge_total,badge_contifico)
{   "use strict";
    var url=document.getElementById('ruta_html_finan').value+'/contabilidad/controller.php';
    var data = new FormData();
    data.append('event', 'view_badge_pagos');
    var xhrbadgepagos = new XMLHttpRequest();
    xhrbadgepagos.open('POST', url , true);
    xhrbadgepagos.onreadystatechange=function(){
        if (xhrbadgepagos.readyState === 4 && xhrbadgepagos.status === 200){
            var gestpagos=0;
            var gestsuma=0;
			var gestsumacontifico=0;
            if(xhrbadgepagos.responseText === "")
			{   gestpagos=0;
            }else
			{   gestpagos=xhrbadgepagos.responseText;
            }
            gestsuma=parseInt(badge_total)+parseInt(gestpagos);
			gestsumacontifico=parseInt(badge_contifico)+parseInt(gestpagos);
			if(gestsumacontifico === 0)
			{   if( document.getElementById('badge_gest_contifico') )
					document.getElementById('badge_gest_contifico').innerHTML = "";
            }
			else
			{   var newbadge_contifico = '<span class="' + get_badge_class(gestsumacontifico) + '">' + gestsumacontifico + '</span>';
				if( document.getElementById('badge_gest_contifico') )
				{   if(document.getElementById('badge_gest_contifico').innerHTML != newbadge_contifico)
					{   document.getElementById('badge_gest_contifico').innerHTML = newbadge_contifico;
					}
				}
            }
			if ( document.getElementById('badge_gest_pagos_in') )
			{   document.getElementById('badge_gest_pagos_in').innerHTML = '<span class="' + get_badge_class(xhrbadgepagos.responseText) + '">' + xhrbadgepagos.responseText + '</span>';
			}
			if( document.getElementById('badge_gest_pagos_in_header1') )
				document.getElementById('badge_gest_pagos_in_header1').innerHTML = xhrbadgepagos.responseText;
			if( document.getElementById('badge_gest_pagos_in_header2') )
				document.getElementById('badge_gest_pagos_in_header2').innerHTML = xhrbadgepagos.responseText;
			$('#pb_pagos').removeClass().addClass(get_progress_bar_badge_class(xhrbadgepagos.responseText));
			if( document.getElementById('pb_pagos') )
				document.getElementById('pb_pagos').style.width = xhrbadgepagos.responseText + '%';
			actualiza_badge_gest_cheques(gestsuma);
        }
    };
    xhrbadgepagos.send(data);
}
function actualiza_badge_gest_cheques(badge_total)
{   "use strict";
    var url=document.getElementById('ruta_html_finan').value+'/valida_cheques/controller.php';
    var data = new FormData();
    data.append('event', 'badge_gest_cheques');
    var xhrbadgecheque = new XMLHttpRequest();
    xhrbadgecheque.open('POST', url , true);
    xhrbadgecheque.onreadystatechange=function(){
        if (xhrbadgecheque.readyState === 4 && xhrbadgecheque.status === 200){
            var gestdeudas=0;
            var gestsuma=0;
            if(xhrbadgecheque.responseText === ""){
                gestdeudas=0;
            }else{
                gestdeudas=xhrbadgecheque.responseText;
            }
            gestsuma=parseInt(badge_total)+parseInt(gestdeudas);
            if(gestsuma === 0){
                if( document.getElementById('badge_gest_fac') )
					document.getElementById('badge_gest_fac').innerHTML = "";
				if( document.getElementById('badge_gest_fac_header1') )
					document.getElementById('badge_gest_fac_header1').innerHTML="";
				if( document.getElementById('badge_gest_fac_header2') )
					document.getElementById('badge_gest_fac_header2').innerHTML="";
				$('#span_badge_gest_fac_header1').removeClass();
				$('#cash_angle').removeClass().addClass('fa fa-angle-left pull-right');
            }else{
				if( document.getElementById('badge_gest_fac_header1') )
				{   if(document.getElementById('badge_gest_fac_header1').innerHTML != gestsuma)
					{   document.getElementById('badge_gest_fac').innerHTML = '<span class="' + get_badge_class(gestsuma) + '">' + gestsuma + '</span>';
						if( document.getElementById('badge_gest_fac_header1') )
							document.getElementById('badge_gest_fac_header1').innerHTML=gestsuma;
						if( document.getElementById('badge_gest_fac_header2') )
							document.getElementById('badge_gest_fac_header2').innerHTML=gestsuma;
						$('#span_badge_gest_fac_header1').removeClass().addClass(get_menu_span_badge_class(gestsuma));
						$('#cash_angle').removeClass();
					}
				}
            }
			if( document.getElementById('badge_gest_cheques_in') )
				document.getElementById('badge_gest_cheques_in').innerHTML = '<span class="' + get_badge_class(xhrbadgecheque.responseText) + '">' + xhrbadgecheque.responseText + '</span>';
			if( document.getElementById('badge_gest_cheques_in_header1') )
				document.getElementById('badge_gest_cheques_in_header1').innerHTML = xhrbadgecheque.responseText;
			if( document.getElementById('badge_gest_cheques_in_header2') )
				document.getElementById('badge_gest_cheques_in_header2').innerHTML = xhrbadgecheque.responseText;
			$('#pb_cheques').removeClass().addClass(get_progress_bar_badge_class(xhrbadgecheque.responseText));
			if( document.getElementById('pb_cheques') )
				document.getElementById('pb_cheques').style.width = xhrbadgecheque.responseText + '%';
        }
    };
    xhrbadgecheque.send(data);
}

function aumenta_porc(porc){
    "use strict";
    var div='prog_bar_deudas';
    var val_now= parseInt(document.getElementById(div).getAttribute('aria-valuenow'))+porc;
	if(val_now<=100){
		document.getElementById(div).setAttribute('aria-valuenow',val_now);
		document.getElementById(div).style.width=String(val_now)+'%';
		if(val_now<100){
			document.getElementById(div).innerHTML=String(val_now)+'%';
			document.getElementById('prog_bar_deudas').setAttribute('class','progress-bar progress-bar-striped active');
		}else{
			document.getElementById(div).innerHTML='Completado';
			document.getElementById('prog_bar_deudas').setAttribute('class','progress-bar progress-bar-striped');
		}
	}
}
function validaNumerosEnteros(e, field){
    "use strict";
    var nuevoValor = field.value+String.fromCharCode(e.which);
    nuevoValor = parseInt(nuevoValor);
    if(isNaN(nuevoValor)){
      return false;
    }else{
      return true;
    }
}
function isNumber(n) {
  return !isNaN(parseFloat(n)) && isFinite(n);
}
function validaNumeros(e, field){
    "use strict";
    var key = e.keyCode ? e.keyCode : e.which;
    if (key == 8){return true;}
    if (key > 47 && key < 58) {
      if (field.value == ""){return true;}
      var regexp1 = /.[0-9]{5}$/;
      return !(regexp1.test(field.value));
    }
    if (key == 46) {
      if (field.value == ""){return false;}
      var regexp2 = /^[0-9]+$/;
      return regexp2.test(field.value);
    }
    return false;
}

function permite(elEvento, permitidos)
{   "use strict";
    // Variables que definen los caracteres permitidos
    var numeros = "0123456789";
    var caracteres = " abcdefghijklmnñopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZ";
    var numeros_caracteres = numeros + caracteres;
    var teclas_especiales = [8, 37, 39, 46];
    // 8 = BackSpace, 46 = Supr, 37 = flecha izquierda, 39 = flecha derecha
    // Seleccionar los caracteres a partir del parámetro de la función
    switch(permitidos)
    {    case 'num':
            permitidos = numeros;
            break;
        case 'car':
            permitidos = caracteres;
            break;
        case 'num_car':
            permitidos = numeros_caracteres;
            break;
    }
    // Obtener la tecla pulsadas
    var evento = elEvento || window.event;
    var codigoCaracter = evento.charCode || evento.keyCode;
    var caracter = String.fromCharCode(codigoCaracter);

    // Comprobar si la tecla pulsada es alguna de las teclas especiales
    // (teclas de borrado y flechas horizontales)
    var tecla_especial = false;
    for(var i in teclas_especiales)
    {   if(codigoCaracter == teclas_especiales[i])
        {   tecla_especial = true;
            break;
        }
    }
    // Comprobar si la tecla pulsada se encuentra en los caracteres permitidos
    // o si es una tecla especial
    return permitidos.indexOf(caracter) != -1 || tecla_especial;
}
function activa_mascara(field){
    "use strict";
    $(function() {$('#'+field).maskMoney({thousands:'', decimal:'.', allowZero:false});});
}
function carga_reports_deudores_curso(div,url,evento)
{   "use strict";
    var curso =0;
    var fecha_ini='';
    var fecha_fin='';
    var nivelEcon='';
    if(document.getElementById('txt_fecha_ini').value.length>0)
    {    fecha_ini= document.getElementById('txt_fecha_ini').value;
    }
    else
    {    fecha_ini='';
    }
    if(document.getElementById('txt_fecha_fin').value.length>0)
    {    fecha_fin= document.getElementById('txt_fecha_fin').value;
    }
    else
    {    fecha_fin='';
    }
    if(document.getElementById('curso').value!=-1)
    {    curso= document.getElementById('curso').value;
    }
    else
    {    curso='';
    }
    if(document.getElementById('cmb_nivelesEconomicos').value!=-1)
    {    nivelEcon= document.getElementById('cmb_nivelesEconomicos').value;
    }
    else
    {    nivelEcon='';
    }
    var periodos= document.getElementById('periodos').value;
	var quienes = document.querySelector('input[id="rdb_quienes"]:checked').value;
    var url2=url+'?event='+evento+'&curs_codi='+curso+'&nivelEcon_codi='+nivelEcon+'&peri_codi='+periodos+'&fechavenc_ini='+fecha_ini+'&fechavenc_fin='+fecha_fin+'&quienes='+quienes;
    window.open(url2);
}
function js_general_resultado_sql(str)
{   "use strict";
    var str1 =  str;
    var wordsToFind = ["¡exito!", "*¡exito!*"];
    if (str1.toLowerCase().indexOf(wordsToFind[0]) === 0 || str1.toLowerCase().indexOf(wordsToFind[1]) === 0)
    {   str = str.replace("¡Exito!", "");
        return 'exito';
    }
    else
    {   wordsToFind = ["¡error!", "*¡error!*"];
        if (str1.toLowerCase().indexOf(wordsToFind[0]) === 0 || str1.toLowerCase().indexOf(wordsToFind[1]) === 0)
        {   str = str.replace("¡Error!", "");
            return 'error';
        }
        else
        {   wordsToFind = ["¡advertencia!", "*¡advertencia!*"];
            if (str1.toLowerCase().indexOf(wordsToFind[0]) === 0 || str1.toLowerCase().indexOf(wordsToFind[1]) === 0)
            {   str = str.replace("¡Advertencia!", "");
                return 'advertencia';
            }
            else
            {   return 'nada';
            }
        }
    }
}