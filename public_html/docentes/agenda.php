<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml"
xmlns:og="http://ogp.me/ns#"
xmlns:fb="http://www.facebook.com/2008/fbml"><!-- InstanceBegin template="/Templates/docentes.dwt.php" codeOutsideHTMLIsLocked="false" -->
<?php include ('head.php');?>
        <!-- InstanceEndEditable -->
	</head>
	<body class="general admin">
								<!-- InstanceBeginEditable name="EditRegion3" --><?php  $Menu=2;    ?><!-- InstanceEndEditable -->
		<div class="pageContainer"> 

		
      <?php include ('menu.php');?>
			
			<div  id="mainPanel"  class="section_main">
            
				<?php include ('header.php');?>

				<div class="main sectionBorder">
					<div id="information">
          
          <div class="titleBar">
          <!-- InstanceBeginEditable name="Titulo Top" -->
			<div class="title">
          		<h3>
            		<span class="icon-calendar icon"></span>
                	Agenda
				</h3>
			</div><!-- InstanceEndEditable -->
          </div>
          
                        <!-- InstanceBeginEditable name="information" -->
                        <script type="text/javascript" src="js/agenda.js">  
						
                        </script>
                      
						<div id="para_main" >
							<?php include ('agenda_view.php'); ?>     
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

<script>

var myVar=setInterval(function () {myTimer()}, 5000);


</script>
<!-- InstanceEnd --></html>