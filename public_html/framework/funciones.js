function set_repr_alum(alum_codi,repr_codi)
{   document.getElementById('information').innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
	var data = new FormData();	
	data.append('opc', 'set_alum');
	data.append('alum_codi', alum_codi);
	data.append('repr_codi', repr_codi);
	var xhr = new XMLHttpRequest();
	xhr.open('POST', '../alumnos/script_set_alum.php' , true);
	xhr.onreadystatechange=function()
	{   if (xhr.readyState==4 && xhr.status==200)
		{   
			if(xhr.responseText=='N')
				window.location="index.php";
			else
				window.location="preinscripcion.php";
		} 
	};
	xhr.send(data);
}
function selectvalue(e){
	if (e.selectedIndex == -1) 
		return  ''; 
	else 
		return e.options[e.selectedIndex].value;

}

function selectvalue_set(sel,val){
		 
    var opts = sel.options;
    for(var opt, j = 0; opt = opts[j]; j++) {
        if(opt.value == val) {
            sel.selectedIndex = j;
            break;
        }
    }
 
}

function selectcheck(inputche){
	inputcheck = document.getElementById(inputche)
    if (inputcheck.checked==true){
		inputcheck.checked=false;
	}
	else{
		inputcheck.checked=true;
	}; 
 
}


function registrar_auditoria(codi_tipo_audi, deta)
{	
	
	var data = new FormData();
	data.append('detalle', deta);
	data.append('tipo_auditoria', codi_tipo_audi);

	var xhr1 = new XMLHttpRequest();
	xhr1.open('POST', '../framework/auditoria.php' , true);
	xhr1.onload = function () {
	  // do something to response
	  console.log(this.responseText);
	};
	xhr1.onreadystatechange=function(){
	  if (xhr1.readyState==4 && xhr1.status==200)
	  {

	  } 
	  else
	  {

	  }
	}
	 xhr1.send(data);

}


function selectvalue_radio(e){
	if (e.checked) {
	  return e.value; 
	}
}


function load_ajax_lista(div,url,data,div_cont,tabla){
	document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById(div).innerHTML=xmlhttp.responseText;	
			$('#'+tabla).datatable({pageSize: 10,sort: [true, true, false],filters: [true, false, false],filterText: 'Escriba para buscar... '});
		}
	}
	xmlhttp.open("POST",url,true);
	xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
	xmlhttp.send(data);	
}
function load_ajax_lista_twofilters(div,url,data,div_cont,tabla){
	document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById(div).innerHTML=xmlhttp.responseText;	
			$("#"+div_cont).ready(function(){ $('#'+tabla).datatable({pageSize: 10,sort: [true, true,true,false],filters: [true, true, 'select', false],filterText: 'Escriba para buscar... '});});
		}
	}
	xmlhttp.open("POST",url,true);
	xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
	xmlhttp.send(data);	
}
function load_ajax_mensajes(div,url,data,column){
	document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById(div).innerHTML=xmlhttp.responseText;
			if (column==5){
				$(document).ready(function() {
			      $('#mensajes_table').datatable({
			        pageSize: 8,
			        sort: [false,true, false,false],
			        filters: [true,true, false,false],
			        filterText: 'Buscar... '
			      }) ;
			  } );
			}else{
				$(document).ready(function() {
			      $('#mensajes_table').datatable({
			        pageSize: 8,
			        sort: [false,true, false],
			        filters: [true,true, false],
			        filterText: 'Buscar... '
			      }) ;
			  } );
			}
		}
	}
	xmlhttp.open("POST",url,true);
	xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
	xmlhttp.send(data);	
}
function load_ajax(div,url,data){
	document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById(div).innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("POST",url,true);
	xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
	xmlhttp.send(data);	
}
function load_ajax2(div,url,data){
	
	document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp2=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
		xmlhttp2=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp2.onreadystatechange=function()
	{
		if (xmlhttp2.readyState==4 && xmlhttp2.status==200){
			document.getElementById(div).innerHTML=xmlhttp2.responseText;	
		}
	}
	xmlhttp2.open("POST",url,true);
	xmlhttp2.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
	xmlhttp2.send(data);	
}


function load_ajax_get(div,url){
	 
	document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById(div).innerHTML=xmlhttp.responseText;	
		}
	}
	xmlhttp.open("GET",url,true);	 
	xmlhttp.send();	
}

function load_ajax_noload(div,url,data){

	 
	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp2=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
		xmlhttp2=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp2.onreadystatechange=function()
	{
		if (xmlhttp2.readyState==4 && xmlhttp2.status==200){
			document.getElementById(div).innerHTML=xmlhttp2.responseText;	
		}
	}
	xmlhttp2.open("POST",url,true);
	xmlhttp2.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
	xmlhttp2.send(data);	
}


 
 function load_ajax_mens_nuev(div,url,data){
	document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
	document.getElementById(div).innerHTML='';
	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById(div).innerHTML=xmlhttp.responseText;	
			CKEDITOR.replace( 'mens_deta' );
			carga_usua();
		}
	}
	xmlhttp.open("POST",url,true);
	xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
	xmlhttp.send(data);	
}

 function load_ajax_mens_responder(div,url,mens_codi){
	//document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
	document.getElementById(div).innerHTML='';
	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	var data = new FormData();
	data.append('mens_codi', mens_codi );
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById(div).innerHTML=xmlhttp.responseText;	
			CKEDITOR.replace( 'mens_deta' );
		}
	}
	xmlhttp.open("POST",url,true);
	xmlhttp.send(data);	
}

function load_ajax_file(div,url,file){
	document.getElementById(div).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
	var archivos = document.getElementById(file);//Damos el valor del input tipo file
	var archivo = archivos.files; //Obtenemos el valor del input (los arcchivos) en modo de arreglo
	/* Creamos el objeto que hara la petición AJAX al servidor, debemos de validar 
	si existe el objeto " XMLHttpRequest" ya que en internet explorer viejito no esta,
	y si no esta usamos "ActiveXObject" */ 
	
	 if(window.XMLHttpRequest) { 
	 var Req = new XMLHttpRequest(); 
	 }else if(window.ActiveXObject) { 
	 var Req = new ActiveXObject("Microsoft.XMLHTTP"); 
	 }
	
	//El objeto FormData nos permite crear un formulario pasandole clave/valor para poder enviarlo, 
	//este tipo de objeto ya tiene la propiedad multipart/form-data para poder subir archivos
	var data = new FormData();
	
	//Como no sabemos cuantos archivos subira el usuario, iteramos la variable y al
	//objeto de FormData con el metodo "append" le pasamos calve/valor, usamos el indice "i" para
	//que no se repita, si no lo usamos solo tendra el valor de la ultima iteración
	for(i=0; i<archivo.length; i++){
	   data.append('archivo'+i,archivo[i]);
	}
	
	//Pasándole la url a la que haremos la petición
	Req.open("POST", url, true);
	
	/* Le damos un evento al request, esto quiere decir que cuando termine de hacer la petición,
	se ejecutara este fragmento de código */ 
	
	Req.onload = function(Event) {
	//Validamos que el status http sea ok 
	if (Req.status == 200) { 
	  //Recibimos la respuesta de php
	  var msg = Req.responseText;
	  //alert(msg);
	  document.getElementById(div).innerHTML=msg;
	  //$("#"+div).append(msg);
	} else { 
	  console.log(Req.status); //Vemos que paso. 
	} 
	};
	
	 //Enviamos la petición 
	 Req.send(data);
}

function LimitAttach(tField,iType) { 
	file=tField.value; 
	if (iType==1) { 
		extArray = new Array(".jpg"); 
	} 
	if (iType==2) { 
		extArray = new Array(".swf"); 
	} 
	if (iType==3) { 
		extArray = new Array(".exe",".sit",".zip",".tar",".swf",".mov",".hqx",".ra",".wmf",".mp3",".qt",".med",".et"); 
	} 
	if (iType==4) { 
		extArray = new Array(".mov",".ra",".wmf",".mp3",".qt",".med",".et",".wav"); 
	} 
	if (iType==5) { 
		extArray = new Array(".html",".htm",".shtml"); 
	} 
	if (iType==6) { 
		extArray = new Array(".doc",".xls",".ppt"); 
	}
	if (iType==7) { 
		extArray = new Array(".jpg",".png",".gif"); 
	} 
	allowSubmit = false; 
	if (!file) return; 
	while (file.indexOf("\\") != -1) file = file.slice(file.indexOf("\\") + 1); 
	ext = file.slice(file.indexOf(".")).toLowerCase(); 
	for (var i = 0; i < extArray.length; i++) { 
		if (extArray[i] == ext) { 
			allowSubmit = true; 
			break; 
		} 
	} 
	if (allowSubmit) { 
	} else { 
		tField.value=""; 
		alert("Usted sólo puede subir archivos con extensiones " + (extArray.join(" ")) + "\nPor favor seleccione un nuevo archivo"); 
	} 
}  

function goto_url(url)
{
	window.location=url;	
}

function runScript(e,op) {
    if (e.keyCode == 13){
		switch (op){
			case "texto_buscar":
				texto_buscar();
			break;
		}
	}
}


function cambio_pagina(Page_index,Page_go,Page_cc){
	page_new=Page_index+Page_go;
	if (Page_go==-1 && Page_index > 0) {
		document.getElementById('page_' + Page_index).style.display='none';
		document.getElementById('page_' + page_new).style.display='block'
		return page_new;
	}
	if (Page_go==1 && Page_index +1 < Page_cc) {
		document.getElementById('page_' + Page_index).style.display='none';
		document.getElementById('page_' + page_new).style.display='block'
		return page_new;
	}
	return Page_index;
	
}


function solo_numero(evt) {
  // debe ir en un input de esta forma "   onkeypress='solo_numero(event)'  ""
  var theEvent = evt || window.event;
  var key = theEvent.keyCode || theEvent.which;
  key = String.fromCharCode( key );
  var regex = /[0-9]|\./;
  if( !regex.test(key) ) {
    theEvent.returnValue = false;
    if(theEvent.preventDefault) theEvent.preventDefault();
  }   
	
}


function numero_validacion(evt,minimo,maximo) {
	
	var theEvent = evt || window.event;
	var key = theEvent.keyCode || theEvent.which;
	if (!((key == 8) || (key == 9) || (key == 46))){
		key = String.fromCharCode( key );
		var regex = /[0-9]|\./;
		var numero = evt.currentTarget.value;
		if( !regex.test(key) ) {
			theEvent.returnValue = false;
			if(theEvent.preventDefault) theEvent.preventDefault();
		}else{
			numero +=key;
			if (!(numero>=minimo && numero<=maximo)){
				theEvent.returnValue = false;
				if(theEvent.preventDefault) theEvent.preventDefault();
			} 	  	
		}
	}else {
		
	}		
}


function periodo_cambio(peri_codi) {
	
	 if (confirm("Esta seguro del cambio?")) {
		url='../admin/script_peri_cambio.php';
	 	data='upd_peri=Y&peri_codi=' + peri_codi;
		if (window.XMLHttpRequest)
		{// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		}
		else
		{// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=function()
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200){
				
				location.reload();
				
			}
		}
		xmlhttp.open("POST",url,true);
		xmlhttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		xmlhttp.send(data);	

	}
}

function new_username ()
{
	if (!document.getElementById('alum_usua').disabled)
	{
		var nombres = document.getElementById('alum_nomb').value.replace(/\s/g,'');
		var apellidos = document.getElementById('alum_apel').value.replace(/\s/g,'');
		document.getElementById('alum_usua').value= nombres.substr(0,2)+apellidos.substr(0,6);
	}
}

function validaNumeros(e, field)
{   key = e.keyCode ? e.keyCode : e.which
	if (key == 8) return true
	if (key > 47 && key < 58) 
	{   if (field.value == "") return true
		regexp = /.[0-9]{5}$/
		return !(regexp.test(field.value))
	}
	if (key == 46) 
	{   if (field.value == "") return false
		regexp = /^[0-9]+$/
		return regexp.test(field.value)
	}
	return false
}
function js_funciones_valida_tipo_growl( str )
{   "use strict";
    var str1 =  str;
    var wordsToFind = ["¡exito!", "*¡exito!*"];
    if (str1.toLowerCase().indexOf(wordsToFind[0]) === 0 || str1.toLowerCase().indexOf(wordsToFind[1]) === 0)
    {   str = str.replace("¡Exito!", "");
        $.growl.notice({ title: "Educalinks informa", message: str});
    }
    else
    {   wordsToFind = ["¡error!", "*¡error!*"];
        if (str1.toLowerCase().indexOf(wordsToFind[0]) === 0 || str1.toLowerCase().indexOf(wordsToFind[1]) === 0)
        {   str = str.replace("¡Error!", "");
            $.growl.error({ title: "Educalinks informa", message: str});
        }
        else
        {   wordsToFind = ["¡advertencia!", "*¡advertencia!*"];
            if (str1.toLowerCase().indexOf(wordsToFind[0]) === 0 || str1.toLowerCase().indexOf(wordsToFind[1]) === 0)
            {   str = str.replace("¡Advertencia!", "");
                $.growl.warning({ title: "Educalinks informa", message: str});
            }
            else
            {   $.growl({ title: "Educalinks informa", message: str});
            }
        }
    }
}
function toggleFullScreen(  ) {
    var toggle = 'false';
    if ((document.fullScreenElement && document.fullScreenElement !== null) || (!document.mozFullScreen && !document.webkitIsFullScreen))
    {   if (document.documentElement.requestFullScreen)
        {   document.documentElement.requestFullScreen();  
        }
        else if (document.documentElement.mozRequestFullScreen)
        {   document.documentElement.mozRequestFullScreen();  
        }
        else if (document.documentElement.webkitRequestFullScreen)
        {   document.documentElement.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT);  
        } 
        toggle = 'true';
    }
    else 
    {   if (document.cancelFullScreen)
        {   document.cancelFullScreen();  
        }
        else if (document.mozCancelFullScreen)
        {   document.mozCancelFullScreen();  
        }
        else if (document.webkitCancelFullScreen)
        {   document.webkitCancelFullScreen();  
        }
        toggle = 'false';
    }
}