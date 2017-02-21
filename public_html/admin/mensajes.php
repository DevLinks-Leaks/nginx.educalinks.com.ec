<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml"
xmlns:og="http://ogp.me/ns#"
xmlns:fb="http://www.facebook.com/2008/fbml"><!-- InstanceBegin template="/Templates/docentes.dwt.php" codeOutsideHTMLIsLocked="false" -->
<?php include ('head.php');?>
		<!-- InstanceBeginEditable name="EditRegion5" --><!-- InstanceEndEditable -->
	</head>
	<body class="general admin">
								<!-- InstanceBeginEditable name="EditRegion3" --><? $Menu=700; ?>
								<!-- InstanceEndEditable -->
		<div class="pageContainer"> 

		
 
			<?php include ('menu.php');?>

			<div  id="mainPanel"  class="section_main">
            
          <?php include ('header.php');?>

				<div class="main sectionBorder">
					<div id="information">
          
          <div class="titleBar">
          <!-- InstanceBeginEditable name="Titulo Top" -->
              <div class="title">
                  <h3><span class="icon-envelope icon"></span>Mensajes</h3>
              </div> 
              <div class="options">
                  <ul>
                    <li>
                      
                     <a id="bt_aula_add" class="button_text" onclick="load_ajax_mens_nuev('div_mens_nuev','mensajes_nuevo_script.php','d=d');"  data-toggle="modal" data-target="#nuev_mens">
                      Nuevo Mensaje
                    </a>
                    </li>
                    <li>
                     <a class="button_text" onclick="load_ajax_mensajes('mens_main_view','mensajes_view.php','OP=2',4);" title="Recibidos">
                      Recibidos
                    </a>
                    </li>
                    
                    <li>
                    <a class="button_text" onclick="load_ajax_mensajes('mens_main_view','mensajes_view.php','OP=3',5);" title="Enviados">
                      Enviados
                    </a>
                    </li>
                    <li>
                    <a class="button_icon button_icon_md " onclick="load_ajax_mensajes('mens_main_view','mensajes_view.php','OP=4',5);" title="Eliminados" >
                      <span class="icon-remove icon"></span>
                    </a>
                    </li>
                  </ul>
              </div>
          <!-- InstanceEndEditable -->
          </div>
          
                        <!-- InstanceBeginEditable name="information" -->


<div class="mensajes">

<script type="text/javascript" src="../framework/funciones.js"> </script>

                    
                   
                             
    
<div id="mens_main_view" class="" >
    <?php include ('mensajes_view.php'); ?>

</div>


<!-- Modal -->
<div class="modal fade bs-example-modal-lg" id="nuev_mens" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="nuev_mens_modal">Nuevo Mensaje</h4>
      </div>
      <div class="modal-body">
        <div id="div_mens_nuev" >
          titulo
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" id="envio_mensaje" data-loading-text="Enviando..." class="btn btn-primary"   onClick="envio_mensaje_nuevo();">
          Enviar
        </button>

        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <button type="button" class="btn btn-default" data-dismiss="modal">
          Cerrar
        </button>


      </div>
    </div>
  </div>
</div>
<!-- Modal Responder-->
<div class="modal fade bs-example-modal-lg" id="mens_responder" tabindex="-1" role="dialog" aria-labelledby="myModal" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div id="div_mens_resp" class="modal-content">
      
    </div>
  </div>
</div>
                        <!-- InstanceEndEditable -->
                    </div>
				</div>
			</div>

	
	</div>
    
    
    <input name="mens_de"  		type="hidden" id="mens_de" 		value='<?php echo $_SESSION['USUA_DE'];  ?>'    />
 	<input name="mens_de_tipo"  type="hidden" id="mens_de_tipo" value='<?php echo $_SESSION['USUA_TIPO']; ?>'    />
    
<!-- InstanceBeginEditable name="EditRegion4" --><!-- InstanceEndEditable -->
</body>

<!--<script>

var myVar=setInterval(function () {myTimer()}, 5000);


</script>-->
<!-- InstanceEnd --></html>