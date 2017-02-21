<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml"
xmlns:og="http://ogp.me/ns#"
xmlns:fb="http://www.facebook.com/2008/fbml"><!-- InstanceBegin template="/Templates/alumnos.dwt" codeOutsideHTMLIsLocked="false" -->
  
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
          <!-- InstanceBeginEditable name="Titulo Top" --><div class="title"><h3><span class="icon-user icon"></span>Informaci&oacute;n de usuario</h3></div><!-- InstanceEndEditable -->
          </div>
          
                        <!-- InstanceBeginEditable name="information" -->
                        <form name="frm_alum" id="frm_alum" action="" enctype="multipart/form-data" method="post">
                        <?php
							if(isset($_POST['alum_cedu'])){
								$alum_cedu=$_POST['alum_cedu'];
								$_SESSION['alum_cedu']=$alum_cedu;
								$alum_codi=$_SESSION['alum_codi'];
								$params = array($_SESSION['alum_codi'],$_SESSION['alum_fech_naci'],$_SESSION['alum_apel'],$_SESSION['alum_apel'],$_SESSION['alum_mail'],$_SESSION['alum_celu'],$_SESSION['alum_telf'],$_SESSION['alum_domi'],$_SESSION['alum_ciud'],$_SESSION['alum_reli'],$_SESSION['alum_pais'],$_SESSION['alum_cedu'],$_SESSION['alum_estado_civil_padres'],$_SESSION['alum_telf_emerg'],$_SESSION['alum_ex_plantel'],$_SESSION['alum_usua']);
								$sql="{call alum_upd(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
								$prof_info = sqlsrv_query($conn, $sql, $params);
								if( $conn === false){echo "Error in connection.\n";die( print_r( sqlsrv_errors(), true));}
							}
                        ?>
                        	<div style="width:100%; padding-left:20px; padding-top:20px;">
								<?php
								$ruta=$_SESSION['ruta_foto_usuario'].$_SESSION['alum_codi'].".jpg";
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
                                <p><h4>Nombre: </h4><?= $_SESSION['alum_nomb']; ?> <?= $_SESSION['alum_apel']; ?></p>
                                <p><h4>Email: </h4><?= $_SESSION['alum_mail']; ?></p>
                                <p><h4>Usuario: </h4><?= $_SESSION['alum_usua']; ?></p>
                                <p><h4>Celular: </h4><?= $_SESSION['alum_celu']; ?></p>
                                <p><h4>Domicilio: </h4><?= $_SESSION['alum_domi']; ?></p>
                                <p><h4>Tel&eacute;fono: </h4><?= $_SESSION['alum_telf']; ?></p>
                                <p><h4>Fecha de Nacimiento: </h4><?= date_format($_SESSION['alum_fech_naci'],'d/m/Y'); ?></p>
                                <p><h4>C&eacute;dula: </h4><input type="text" id="alum_cedu" name="alum_cedu" value="<?= $_SESSION['alum_cedu']; ?>"/></p>
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


<!-- InstanceEnd --></html>