function cerrar_changelog(){
    if($('#chk_mostrar').is(':checked')==true){
        registrar_changelog();
        $('#modal_changelog').modal('toggle');
    }else
        $('#modal_changelog').modal('toggle');
}
function registrar_changelog(){
  if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
      xmlhttp=new XMLHttpRequest();
  }
  else
  {// code for IE6, IE5
      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  var jsonC = [];
  $('.changelog_div').each(function(){ 
    jsonC.push({
        chan_codi: $(this).attr('id')
    });
  });
  var data = new FormData();
  data.append('opc', 'validate_changelog_show');
  data.append('jsonC', JSON.stringify(jsonC));
  xmlhttp.onreadystatechange=function()
  {
      if (xmlhttp.readyState==4 && xmlhttp.status==200){
          var json = JSON.parse(xmlhttp.responseText);
          
      }
  };
  xmlhttp.open("POST",'script_general.php',true);
  xmlhttp.send(data);
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
    var data = new FormData();
    data.append('event', 'toggle_fullscreen');
    data.append('toggle', toggle);
    var xhr = new XMLHttpRequest();
    xhr.open('POST', document.getElementById('ruta_html_common').value + '/general/controller.php' , true);
    xhr.onreadystatechange=function(){
        if (xhr.readyState === 4 && xhr.status === 200){
            console.log(xhr.responseText);
            console.log(toggle);console.log(document.getElementById('hd_toggle_fullscreen').value)
            document.getElementById('hd_toggle_fullscreen').value = xhr.responseText;console.log(document.getElementById('hd_toggle_fullscreen').value)
        }
    };
    xhr.send(data);
}
function obtener_fecha_subfuncion(cuanto)
{   "use strict";
   var today = new Date();
   var dd = today.getDate() + cuanto;
   var mm = today.getMonth() + 1; //January is 0!

   var yyyy = today.getFullYear();
   if(dd<10){
       dd='0'+dd;
   }
   if(mm<10){
       mm='0'+mm;
   }
   today = dd+'/'+mm+'/'+yyyy;
   return today;
}
function obtener_fecha(cuando)
{   "use strict";
   if(cuando=='ayer')
   {
       return obtener_fecha_subfuncion(-1);
   }
   if(cuando=='hoy')
   {
       return obtener_fecha_subfuncion(0);
   }
   if(cuando=='mañana')
   {
       return obtener_fecha_subfuncion(1);
   }
}