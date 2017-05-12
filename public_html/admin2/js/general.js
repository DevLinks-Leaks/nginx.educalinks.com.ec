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