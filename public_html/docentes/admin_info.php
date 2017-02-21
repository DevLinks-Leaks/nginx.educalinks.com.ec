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
              
            </ul>



			</div> 

			<div  id="mainPanel"  class="section_main">
            
            <div class="header">
                <a id="btn" href="#" > <span class=" icon-menu"> </span> Mostrar / Ocultar Menú</a> 


                <div class="userbar dropdown">

                 <ul>
                    <li class="userProfile">
                      <a class="profile" href="#" data-toggle="dropdown"  >
                        <?php
                        $ruta=$_SESSION['ruta_foto_usuario'].$_SESSION['prof_codi'].".jpg";
                        $file_exi=$ruta;
                        if (file_exists($file_exi)) {
                            $pp=$file_exi;
                        } else {
                            $pp=$_SESSION['foto_default'];
                        }
                        ?>

                        <div class="photo">
                        <img src="<?php echo $pp;?>" style="height:60px; width:60px;" />

                       </div>
                       <div class="username">
                           <h5>Bienvenido,</h5>
                           <?= $_SESSION['prof_nomb']; ?> <?= $_SESSION['prof_apel']; ?> 
                       </div>

                   </a>
                   <ul class="dropdown-menu" role="menu" >
                     <li><a href="admin_foto.php"> <span class="li_pict">Cambiar foto</span></a></li>								
                     <li><a href="admin_pass.php"> <span class="li_pass">Cambiar password</span></a></li>
                     <li><a href="admin_info.php"> <span class="li_user">Ver Información</span></a></li>
                     <li><a href="../salir.php"><span class="li_logout">Cerrar Sesión</span></a></li>
                 </ul>
             </li>

             <li class="userButtons">
               <ul>
                <li>

                 <div id="mens_alert" >
                     <?php include ('script_mens_view.php'); ?>
                 </div>



             </li>
         </ul>
     </li>
 </ul>

</div>
</div>
				

				<div class="main sectionBorder">
					<div id="information">
          
          <div class="titleBar">
          <!-- InstanceBeginEditable name="Titulo Top" --><div class="title"><h3><span class="icon-user icon"></span>Informaci&oacute;n de usuario</h3></div><!-- InstanceEndEditable -->
          </div>
          
                        <!-- InstanceBeginEditable name="information" -->
                        <form name="frm_prof" id="frm_prof" action="" enctype="multipart/form-data" method="post">
                        <?php
							if(isset($_POST['prof_cedu'])){
								$prof_cedu=$_POST['prof_cedu'];
								$prof_mail=$_POST['prof_mail'];
								$_SESSION['prof_mail']=$prof_mail;
								$_SESSION['prof_cedu']=$prof_cedu;
								$prof_codi=$_SESSION['prof_codi'];
								$params = array($_SESSION['prof_usua'],$_SESSION['prof_nomb'],$_SESSION['prof_apel'],$prof_mail,$_SESSION['prof_dire'],$_SESSION['prof_telf'],$prof_cedu,$prof_codi);
								$sql="{call prof_upd(?,?,?,?,?,?,?,?)}";
								$prof_info = sqlsrv_query($conn, $sql, $params);
								if( $conn === false){echo "Error in connection.\n";die( print_r( sqlsrv_errors(), true));}
							}
                        ?>
                        	<div style="width:100%; padding-left:20px; padding-top:20px;">
								<?php
								$ruta=$_SESSION['ruta_foto_usuario'].$_SESSION['prof_codi'].".jpg";
								$file_exi=$ruta;
								if (file_exists($file_exi)) {
									$pp=$file_exi;
								} else {
									$pp=$_SESSION['foto_default'];
								}
								?>
								<div class="photo">
								<img src="<?php echo $pp;?>" style="height:200px; width:200px;" class="img-polaroid" />
								</div>
                                <p><h4>Nombre: </h4><?= $_SESSION['prof_nomb']; ?> <?= $_SESSION['prof_apel']; ?></p>
                                <p><h4>Email: </h4><input type="text" id="prof_mail" name="prof_mail" value="<?= $_SESSION['prof_mail']; ?>"/></p>
                                <p><h4>Usuario: </h4><?= $_SESSION['prof_usua']; ?></p>
                                <p><h4>Domicilio: </h4><?= $_SESSION['prof_dire']; ?></p>
                                <p><h4>Tel&eacute;fono: </h4><?= $_SESSION['prof_telf']; ?></p>
                                <p><h4>C&eacute;dula: </h4><input type="text" id="prof_cedu" name="prof_cedu" value="<?= $_SESSION['prof_cedu']; ?>"/></p>
                                <p><button type="submit" class="btn btn-primary">Grabar</button></p>
                            </div> 
                    	</form> 
                    
                    
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