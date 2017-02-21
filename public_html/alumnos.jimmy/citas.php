<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml"
xmlns:og="http://ogp.me/ns#"
xmlns:fb="http://www.facebook.com/2008/fbml"><!-- InstanceBegin template="/Templates/alumnos.dwt" codeOutsideHTMLIsLocked="false" -->
	<?php include ('head.php');?>

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
                            <div class="title"><h3> <span class="icon-clock icon"></span>Citas</h3></div> 
                        </div>
                        <div id="curs_main" >
    						<?php include ('citas_main.php'); ?>
                        </div>
                    </div>
				</div>
			</div>
        </div>

    <input name="mens_de"  		type="hidden" id="mens_de" 		value='<?php echo $_SESSION['USUA_DE'];  ?>'    />
 	<input name="mens_de_tipo"  type="hidden" id="mens_de_tipo" value='<?php echo $_SESSION['USUA_TIPO']; ?>'    />
    
<!-- InstanceBeginEditable name="EditRegion4" --><!-- InstanceEndEditable -->
</body>

</html>