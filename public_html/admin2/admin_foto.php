<!DOCTYPE html>
<html><!-- InstanceBegin template="/Templates/admin.dwt" codeOutsideHTMLIsLocked="false" -->

<?php include ('head.php');?>
        
      <!-- Nuevos Css Js -->

        <link href="../theme/jquery1_11/jquery-ui.css" rel="stylesheet">
	<link href="../theme/jquery1_11/external/jquery/jquery_growl/stylesheets/jquery.growl.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="../framework/funciones.js"></script>

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
          <div class="title"><h3><span class="icon-camera icon"></span>Foto de Perfil</div><!-- InstanceEndEditable -->
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
    							$usua_codi=$_SESSION['usua_codi'].".jpg";
    							$ruta=$_SESSION['ruta_foto_usuario'];
    							$nombre = $usua_codi;
    							$full_name=$ruta.$nombre;
    							if (isset($_FILES['usua_foto'])){
    								$temporal = $_FILES['usua_foto']['tmp_name'];
    								$tamano= ($_FILES['usua_foto']['size'] / 1000)."Kb";
    								move_uploaded_file($temporal,$full_name);
    							}
                                $file_exi=$_SESSION['ruta_foto_usuario'].$_SESSION['usua_codi'].'.jpg';
                                if (file_exists($file_exi)) {
                                    $pp=$file_exi."?".rand(1,1000);
                                } else {
                                    $pp=$_SESSION['ruta_foto_usuario'].'admin.jpg';
                                }
                                ?>
            <div id="div_foto">
              <img src="<?php echo $pp;?>" width="150" height="200" border="1" style="border-color:#F0F0F0;" />
            </div>
            <input type="file" name="usua_foto" id="usua_foto" class="btn" onBlur='LimitAttach(this,1);' />
        </div>



        <div class="buttons">
            <ul>
              <li>
                
              <button id="foto_guardar" name="foto_guardar" type="submit" class="btn btn-success">Grabar</button>
                
              </li>
            </ul>
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