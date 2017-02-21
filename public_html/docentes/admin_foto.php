<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml"
xmlns:og="http://ogp.me/ns#"
xmlns:fb="http://www.facebook.com/2008/fbml"><!-- InstanceBegin template="/Templates/docentes.dwt.php" codeOutsideHTMLIsLocked="false" -->
<?php include ('head.php');?>
        <!-- InstanceEndEditable -->
	</head>
	<body class="general admin">
								<!-- InstanceBeginEditable name="EditRegion3" --><?php  $Menu=0;    ?><!-- InstanceEndEditable -->
		<div class="pageContainer"> 

		
      <?php include ('menu.php');?>
			
			<div  id="mainPanel"  class="section_main">
            
				<?php include ('header.php');?>

				<div class="main sectionBorder">
					<div id="information">
          
          <div class="titleBar">
          <!-- InstanceBeginEditable name="Titulo Top" --><div class="title"><h3><span class="icon-camera icon"></span>Foto de Perfil</h3></div><!-- InstanceEndEditable -->
          </div>
          
                        <!-- InstanceBeginEditable name="information" -->
                        <?php  
						session_start();
                        include ('../framework/dbconf.php');
						?>

            <div class="alumnos_add_script">
              

              <form id="usua_foto_form" name="usua_foto_form" enctype="multipart/form-data" action="" method="post">
                
                <div class="picture">
                  <div class="selector">
                    <?php
                    $ruta=$_SESSION['ruta_foto_usuario'];
                    $full_name=$ruta.$_SESSION['prof_codi'].".jpg";
                    if (isset($_FILES['usua_foto'])){
                      $temporal = $_FILES['usua_foto']['tmp_name'];
                      $tamano= ($_FILES['usua_foto']['size'] / 1000)."Kb";
                      move_uploaded_file($temporal,$full_name);
                    }
                    $file_exi=$full_name;
                    if (file_exists($file_exi)){
                      $pp=$file_exi;
                    } else {
                      $pp=$_SESSION['foto_default'];
                    }
                    ?>
                    <div id="div_foto" style="width:230px; height:200px; padding-left:30px;">
                     <img src="<?php echo $pp;?>" style="border-color:#F0F0F0; height:200px; width:200px;" class="img-polaroid"  />
                   </div>
                   <input type="file" name="usua_foto" id="usua_foto" class="btn" onBlur='LimitAttach(this,1);' />
                   

                   <div class="buttons">
                    <ul>
                      <li>
                       <button id="foto_guardar" name="foto_guardar" type="submit" >Grabar</button>
                     </li>
                   </ul>
                 </div>
                 
               </div>
             </div>
           </form>
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

var myVar=setInterval(function () {myTimer()}, 120000);


</script>
<!-- InstanceEnd --></html>