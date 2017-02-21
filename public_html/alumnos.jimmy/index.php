<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml"
xmlns:og="http://ogp.me/ns#"
xmlns:fb="http://www.facebook.com/2008/fbml">
	<!-- InstanceBegin template="/Templates/alumnos.dwt" codeOutsideHTMLIsLocked="false" -->

	<?php include ('head.php');?>
		
	<body class="general admin">
		<!-- InstanceBeginEditable name="EditRegion3" --><?php  $Menu=0;    ?><!-- InstanceEndEditable -->
		<div class="pageContainer"> 
			
			<?php include ('menu.php');?>

			<div  id="mainPanel"  class="section_main">
	            
		        <?php include ('header.php');?>
					
				<!--
		        <div class="optionbar">
		        <span class="icon-earth icon"></span><span>Su ubicación:</span>
		               <nav class="menu_breadcrumb">
		                  <ul>
		                    
		                    <li><a href="">Inicio</a></li>
		                    <li><a href="" class="active">CurrentPage</a></li>
		                  </ul>
		               </nav>
		        </div>
				-->
				<div class="main sectionBorder">
					<div id="information">
		          
						<div class="titleBar">
							<!-- InstanceBeginEditable name="Titulo Top" -->
		          
				          	<?php 
							
							
								$params = array($_SESSION['curs_para_codi']);
								$sql="{call curs_para_info(?)}";
								$curs_para_info = sqlsrv_query($conn, $sql, $params);  
								$row_curs_para_info = sqlsrv_fetch_array($curs_para_info);
							
						  
						  	?>
				            <div class="title" style="width:70%;">
				            	<h3><span class="icon-home icon"></span>Inicio</h3>
				                <h4><?=   $_SESSION['alum_apel']  ?> <?=   $_SESSION['alum_nomb']  ?>  // <?=   $row_curs_para_info['curs_deta'];  ?>  / <?=   $row_curs_para_info['para_deta'];  ?>  </h4>
				            </div> 
		          			<!-- InstanceEndEditable -->
		          		</div>
		          
		                <!-- InstanceBeginEditable name="information" -->	
					  	<?php 
						include ('index_script.php'); 
						?>
						<!-- InstanceEndEditable -->
		            </div>
				</div>
			</div>
		</div>
    
    
	    <input name="mens_de"  		type="hidden" id="mens_de" 		value='<?php echo $_SESSION['USUA_DE'];  ?>'    />
	 	<input name="mens_de_tipo"  type="hidden" id="mens_de_tipo" value='<?php echo $_SESSION['USUA_TIPO']; ?>'    />
    
	<!-- InstanceBeginEditable name="EditRegion4" --><!-- InstanceEndEditable -->
	</body>
<!-- InstanceEnd -->
</html>