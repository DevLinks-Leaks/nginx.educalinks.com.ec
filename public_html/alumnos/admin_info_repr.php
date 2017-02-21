<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml"
xmlns:og="http://ogp.me/ns#"
xmlns:fb="http://www.facebook.com/2008/fbml">
  <?php include ('head.php');?>

	<body class="general admin">
								<!-- InstanceBeginEditable name="EditRegion3" --><?php  $Menu=0;    ?><!-- InstanceEndEditable -->
		<div class="pageContainer"> 
			
      <?php include ('menu.php');?>

			<div  id="mainPanel"  class="section_main">
        
        <?php include ('header.php');?>
            
				<div class="main sectionBorder">
				  <div id="information">
          
            <div class="titleBar">
              <div class="title"><h3><span class="icon-user icon"></span>Informaci&oacute;n de usuario</h3></div>
            </div>
          
                        <!-- InstanceBeginEditable name="information" -->
            <form name="frm_alum" id="frm_alum" action="" enctype="multipart/form-data" method="post">
            <?php
							if(isset($_POST['repr_cedu'])){
								$repr_cedu=$_POST['repr_cedu'];
								$_SESSION['repr_cedula']=$repr_cedu;
								$repr_codi=$_SESSION['repr_codi'];
								$params = array($_SESSION['repr_nomb'],$_SESSION['repr_apel'],$_SESSION['repr_cedula'],$_SESSION['repr_email'],$_SESSION['repr_telf'],$_SESSION['repr_domi'],$_SESSION['repr_estado_civil'],$_SESSION['repr_celular'],$_SESSION['repr_parentesco'],$_SESSION['repr_codi']);
								$sql="{call repr_upd(?,?,?,?,?,?,?,?,?,?)}";
								$prof_info = sqlsrv_query($conn, $sql, $params);
								if( $conn === false){echo "Error in connection.\n";die( print_r( sqlsrv_errors(), true));}
							}
            ?>
                <div style="width:100%; padding-left:20px; padding-top:20px;">
  								<?php
  								$ruta=$_SESSION['ruta_foto_usuario'].$_SESSION['repr_codi'].".jpg";
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
                  <p><h4>Nombre: </h4><?= $_SESSION['repr_nomb']; ?> <?= $_SESSION['repr_apel']; ?></p>
                  <p><h4>Email: </h4><?= $_SESSION['repr_email']; ?></p>
                  <p><h4>Usuario: </h4><?= $_SESSION['repr_usua']; ?></p>
                  <p><h4>Celular: </h4><?= $_SESSION['repr_celular']; ?></p>
                  <p><h4>Domicilio: </h4><?= $_SESSION['repr_domi']; ?></p>
                  <p><h4>Tel&eacute;fono: </h4><?= $_SESSION['repr_telf']; ?></p>
                  <p><h4>C&eacute;dula: </h4><input type="text" id="repr_cedu" name="repr_cedu" value="<?= $_SESSION['repr_cedula']; ?>"/></p>
                  <p><button type="submit" class="btn btn-primary">Grabar</button></p>
                </div> 
          	</form>	      
          </div>
				</div><!-- Section Border -->
			</div>
	</div><!-- Page Container -->
    
  <input name="mens_de"  		type="hidden" id="mens_de" 		value='<?php echo $_SESSION['USUA_DE'];  ?>'    />
 	<input name="mens_de_tipo"  type="hidden" id="mens_de_tipo" value='<?php echo $_SESSION['USUA_TIPO']; ?>'    />
    

</body>


</html>