<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml"
xmlns:og="http://ogp.me/ns#"
xmlns:fb="http://www.facebook.com/2008/fbml"><!-- InstanceBegin template="/Templates/docentes.dwt.php" codeOutsideHTMLIsLocked="false" -->
<?php include ('head.php');?>
		<!-- InstanceBeginEditable name="EditRegion5" --><!-- InstanceEndEditable -->
	</head>
	<body class="general admin">
								<!-- InstanceBeginEditable name="EditRegion3" --><? $Menu=5; ?>
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
              <h3><span class="icon-users icon"></span>Lista de citas</h3>
      	 </div>
          <div class="options">
                  <ul>
                    <li>
                      <a id="bt_mate_add"  class="button_text"  href="javascript:getURL()">
                        <span class="icon-print"></span>Imprimir Lista
                      </a>
                    </li>
                  </ul>
		 </div>
          <!-- InstanceEndEditable -->
          </div>
          
                        <!-- InstanceBeginEditable name="information" -->
                        <div id="curs_main">
							  <?php 
							  include ('hora_aten_repr_script.php');
							   ?>
                             
                             </div>
                             <script type="text/javascript">
							 
							 $("#hora_aten_repr_fecha").datepicker({
						      onSelect: function(date){
							 MostrarCitas (date);
							  }
						   });
							 
							 function getURL()
							 {
								 var direccion;
								 direccion="hora_aten_repr_listas_main_view.php?fecha=";
								 direccion=direccion+document.getElementById('hora_aten_repr_fecha').value;
								 window.location.href=direccion;
							}
							 </script>
						<!-- InstanceEndEditable -->
                    </div>
				</div>
			</div>

	
	</div>
    
    
    <input name="mens_de"  		type="hidden" id="mens_de" 		value='<?php echo $_SESSION['USUA_DE'];  ?>'    />
 	<input name="mens_de_tipo"  type="hidden" id="mens_de_tipo" value='<?php echo $_SESSION['USUA_TIPO']; ?>'    />
    
<!-- InstanceBeginEditable name="EditRegion4" --><!-- InstanceEndEditable -->
</body>

<script>

var myVar=setInterval(function () {myTimer()}, 5000);


</script>
<!-- InstanceEnd --></html>