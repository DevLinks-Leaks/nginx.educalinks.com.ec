<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml"
xmlns:og="http://ogp.me/ns#"
xmlns:fb="http://www.facebook.com/2008/fbml"><!-- InstanceBegin template="/Templates/docentes.dwt.php" codeOutsideHTMLIsLocked="false" -->
<?php include ('head.php');?>
		<!-- InstanceBeginEditable name="EditRegion5" --><!-- InstanceEndEditable -->
	</head>
	<body class="general admin">
								<!-- InstanceBeginEditable name="EditRegion3" --><?php  $Menu=4;    ?><!-- InstanceEndEditable -->
		<div class="pageContainer"> 

		
 
			<?php include ('menu.php');?>

			<div  id="mainPanel"  class="section_main">
            
          <?php include ('header.php');?>

				<div class="main sectionBorder">
					<div id="information">
          
          <div class="titleBar">
          <!-- InstanceBeginEditable name="Titulo Top" -->
          <div class="title"><h3><span class="icon-briefcase icon"></span>Notas</h3></div>
		  <!-- InstanceEndEditable -->
          </div>
          
                        <!-- InstanceBeginEditable name="information" -->
                        
                        	
                    	<div  id="notas_view">
							 <?php 	include('notas_viewv2.php') ?>
						</div> 
						<form id="form_notas" name="form_notas" action="" method="POST">
							<input type="hidden" name="curs_para_mate_prof_codi" id="curs_para_mate_prof_codi" value=""/>
							<input type="hidden" name="curs_para_mate_codi" id="curs_para_mate_codi" value=""/>
							<input type="hidden" name="peri_dist_codi" id="peri_dist_codi" value=""/>
							<input type="hidden" name="nota_perm_codi" id="nota_perm_codi" value=""/>
							<input type="hidden" name="opc" id="opc" value="upload_view"/>
						</form>                    
                     <script src="js/notasv2.js?<?=$rand;?>"></script>
                        <!-- InstanceEndEditable -->
                    </div>
				</div>
			</div>

	
	</div>
    
    
    <input name="mens_de"  		type="hidden" id="mens_de" 		value='<?php echo $_SESSION['USUA_DE'];  ?>'    />
 	<input name="mens_de_tipo"  type="hidden" id="mens_de_tipo" value='<?php echo $_SESSION['USUA_TIPO']; ?>'    />
    
<!-- InstanceBeginEditable name="EditRegion4" --><!-- InstanceEndEditable -->
</body>

<!-- InstanceEnd --></html>