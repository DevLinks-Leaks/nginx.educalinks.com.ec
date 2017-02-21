<!DOCTYPE html>
<html><!-- InstanceBegin template="/Templates/admin.dwt" codeOutsideHTMLIsLocked="false" -->

<?php include ('head.php');?>
        
      <!-- Nuevos Css Js -->
	
      <!-- Fin -->
	</head> 
	<body class="general admin"> 
								<!-- InstanceBeginEditable name="EditRegion3" --><?php  $Menu2=303;    ?><!-- InstanceEndEditable -->
		<div class="pageContainer"> 

		  <?php include ('menu.php');?>

			<div id="mainPanel" class="section_main">
            
        			<?php include ('header.php');?>
        
				<div class="main sectionBorder">
					<div id="information">
          
          <div class="titleBar">
          <!-- InstanceBeginEditable name="Titulo Top" -->
 <div class="title">
              <h3><span class="icon-user icon"></span>Informaci&oacute;n de usuario</h3>
          </div> 
          <!-- InstanceEndEditable -->
          </div>
          
                        <!-- InstanceBeginEditable name="information" -->
                        
                        <form name="frm_adm" id="frm_adm" action="" enctype="multipart/form-data" method="post">
                        <?php
							if(isset($_POST['usua_mail'])){
								$usua_mail=$_POST['usua_mail'];
								$_SESSION['usua_mail']=$usua_mail;
								$usua_codi=$_SESSION['usua_codi'];
								$params = array($_SESSION['usua_codi'],$_SESSION['usua_nomb'],$_SESSION['usua_apel'],$usua_mail,$_SESSION['rol_codi']);
								$sql="{call usua_upd(?,?,?,?,?)}";
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
                                <p><h4>Nombre: </h4><?= $_SESSION['usua_nomb']; ?> <?= $_SESSION['usua_apel']; ?></p>
                                <p><h4>Email: </h4><input type="text" id="usua_mail" name="usua_mail" value="<?= $_SESSION['usua_mail']; ?>"/></p>
                                <p><h4>Usuario: </h4><?= $_SESSION['usua_codi']; ?></p>
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
    
    <!-- Modal SELECCION DE PERIODO -->
    <div class="modal fade" id="ModalPeriodoActivo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h4 class="modal-title" id="myModalLabel">SELECCION DE PERIODO ACTIVO</h4>
          </div>
          <div class="modal-body">
           
                <table>
                    <tr>
                        <td>PERIODOS</td>                        
                        
                    </tr>
                            
                     <? 	
						$params = array();
						$sql="{call peri_view()}";
						$peri_view = sqlsrv_query($conn, $sql, $params);  
                    ?>
                    
                     <? while($row_peri_view = sqlsrv_fetch_array($peri_view)){ ?>
                     <tr>    
     					<td height="50"><button type="button" class="btn btn-primary" style="width:100%;" onClick="periodo_cambio(<?= $row_peri_view["peri_codi"]; ?>);">ACTIVAR PERIODO LECTIVO <?= $row_peri_view["peri_deta"]; ?></button></td>
                    </tr>
                    <?php  } ?>


                     
                   
                </table>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            
          </div>
        </div>
      </div>
    </div>
    
<!-- InstanceBeginEditable name="EditRegion4" --><!-- InstanceEndEditable -->
</body>
<!-- InstanceEnd --></html>