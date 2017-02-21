<!DOCTYPE html>
<html><!-- InstanceBegin template="/Templates/admin.dwt" codeOutsideHTMLIsLocked="false" -->

<?php include ('head.php');?>
        
      <!-- Nuevos Css Js -->
	
      <!-- Fin -->
	</head> 
	<body class="general admin"> 
								<!-- InstanceBeginEditable name="EditRegion3" --><?php  $Menu=203;    ?><!-- InstanceEndEditable -->
		<div class="pageContainer"> 

		  <?php include ('menu.php');?>

			<div id="mainPanel" class="section_main">
            
        			<?php include ('header.php');?>
        
				<div class="main sectionBorder">
					<div id="information">
          
          <div class="titleBar">
          <!-- InstanceBeginEditable name="Titulo Top" -->
          <? 
		  	$peri_codi=$_SESSION['peri_codi'];	 
		  ?>
              <div class="title">
                  <h3><span class="icon-books icon"></span>Materias</h3>
              </div> 
              <div class="options">
                  <ul>
                  <?php if (permiso_activo(37)){?>
                    <li>
                      <a id="bt_mate_add"  class="button_text" onclick="document.getElementById('mate_deta').value='';" data-toggle="modal" data-target="#mate_nuev" >
                        <span class="icon-add icon"></span>Nueva Materia
                      </a>
                    </li>
              <?php }?>
                  </ul>
              </div>

          <!-- InstanceEndEditable -->
          </div>
          
                        <!-- InstanceBeginEditable name="information" -->
                     
                   <script src="js/funciones_mate.js"></script>
                        	 <script type="text/javascript" src="../framework/funciones.js"> </script>
                    		 <div id="curs_mate_main" >
 
							               <?php include ('cursos_materias_main_lista.php'); ?>
                             
                             </div>

                    <!-- Modal -->
                        <div class="modal fade" id="mate_nuev" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                <h4 class="modal-title" id="myModalLabel">Nueva Materia</h4>
                              </div>
                              <div class="modal-body">
                               <table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td>Nombre: </td>
                                <td><input id="mate_deta" name="mate_deta" type="text" value="" style="width: 100%;"></td>
                              </tr>
                        		</table>
                        
                              </div>
                              <div class="modal-footer">
                                 <button type="button" class="btn btn-primary"  data-dismiss="modal" onClick="mate_add(document.getElementById('mate_deta').value)">Aceptar</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                               
                              </div>
                            </div>
                          </div>
                        </div>
                         <?php include ('cursos_materias_main_modal.php'); ?> 
                    
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