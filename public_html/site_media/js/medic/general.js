// JavaScript Document

$(document).ready(function(){
    "use strict";
	actualiza_badge_sms();
	//get it if Status key found
	/*if(localStorage.getItem("Status"))
	{   Toaster.show("The record is added");
		localStorage.clear();
	}*/
});
var spanish="//cdn.datatables.net/plug-ins/f2c75b7247b/i18n/Spanish.json";
var myVar2=setInterval(function () {"use strict"; actualiza_badge_sms();}, 120000);
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
{   var data = new FormData();
    data.append('event', 'config');
    var xhr = new XMLHttpRequest();
    xhr.open('POST', document.getElementById('ruta_html_finan').value + '/general/controller.php' , true);
    xhr.onreadystatechange=function()
	{   if (xhr.readyState === 4 && xhr.status === 200)
		{   document.getElementById('modal_configColecturia_body').innerHTML = xhr.responseText;
        }
    };
    xhr.send(data);
	
}
function js_general_settings_change(prontopago,prepago,bloqueo, url){
    "use strict";
    var data = new FormData();
    data.append('prontopago', prontopago);
    data.append('prepago', prepago);
    data.append('bloqueo', bloqueo);
    data.append('event', 'set_settings');
    var xhr = new XMLHttpRequest();
    xhr.open('POST', url , true);
    xhr.onreadystatechange=function()
	{   if (xhr.readyState === 4 && xhr.status === 200)
		{   var n = xhr.responseText.length;
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
function js_general_cargaDeudores(div, url){
    "use strict";
    document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
    document.getElementById('busqueda_result_label').innerHTML='<i class="fa fa-cog fa-spin"></i>';
    var comboCursos = document.getElementById("curso");
    var comboNivelEcon = document.getElementById("cmb_nivelesEconomicos");
    var comboPeriodos = document.getElementById("periodos");
    var dtpfechavenc_ini = document.getElementById("txt_fecha_ini");
    var dtpfechavenc_fin = document.getElementById("txt_fecha_fin");
    var data = new FormData();
    data.append('curs_codi', comboCursos.value);
    data.append('nivelEcon_codi', comboNivelEcon.value);
    data.append('peri_codi', comboPeriodos.value);
    data.append('fechavenc_ini', dtpfechavenc_ini.value);
    data.append('fechavenc_fin', dtpfechavenc_fin.value);
    data.append('event', 'get_deudores');
    var xhr = new XMLHttpRequest();
    xhr.open('POST', url , true);
    xhr.onreadystatechange=function(){
        if (xhr.readyState === 4 && xhr.status === 200)
        {   document.getElementById(div).innerHTML=xhr.responseText;
            document.getElementById('busqueda_result_label').innerHTML='';
            $('#tabla_rptDeudores').DataTable({
				//"iDisplayLength": -1,
				"bPaginate": true,
				"bStateSave": false,
				"bAutoWidth": false,
				//true
				"bScrollAutoCss": true,
				"bProcessing": true,
				"bRetrieve": true,
				//"bJQueryUI": true,
				//"sDom": 't',
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
					{ "sWidth": "150px", "targets": [0] },
					{ "sWidth": "300px", "targets": [2] },
					{className: "dt-body-center", "targets": [0]},
					{className: "dt-body-center", "targets": [1]},
					{className: "dt-body-left"  , "targets": [2]}
				]
			});
			
			$("#boton_columnas").click(function(){
				$("#desplegable").slideToggle(200);
			});
			$("#desplegable").show();
            $('a.toggle-vis').on( 'click', function (e) {
                e.preventDefault();
                var table = $('#tabla_rptDeudores').DataTable();
                // Get the column API object
                var column = table.column( $(this).attr('data-column') );
                // Toggle the visibility
                column.visible( ! column.visible() );
            });
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
function carga_reports_deudores(div,url,evento)
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
    var url2=url+'?event='+evento+'&curs_codi='+curso+'&nivelEcon_codi='+nivelEcon+'&peri_codi='+periodos+'&fechavenc_ini='+fecha_ini+'&fechavenc_fin='+fecha_fin;
    window.open(url2);
}
function carga_reports_deudores_resumen(div,url,evento)
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
    var url2=url+'?event='+evento+'&curs_codi='+curso+'&nivelEcon_codi='+nivelEcon+'&peri_codi='+periodos+'&fechavenc_ini='+fecha_ini+'&fechavenc_fin='+fecha_fin;
    window.open(url2);
}
function carga_reports_deudores_mensual(div,url,evento)
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
    var url2=url+'?event='+evento+'&curs_codi='+curso+'&nivelEcon_codi='+nivelEcon+'&peri_codi='+periodos+'&fechavenc_ini='+fecha_ini+'&fechavenc_fin='+fecha_fin;
    window.open(url2);
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
    var url2=url+'?event='+evento+'&curs_codi='+curso+'&nivelEcon_codi='+nivelEcon+'&peri_codi='+periodos+'&fechavenc_ini='+fecha_ini+'&fechavenc_fin='+fecha_fin;
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