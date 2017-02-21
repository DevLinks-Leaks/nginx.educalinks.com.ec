<!DOCTYPE html>
<html><!-- InstanceBegin template="/Templates/admin.dwt" codeOutsideHTMLIsLocked="false" -->

<?php include ('head.php');?>
        
      <!-- Nuevos Css Js -->
	
      <!-- Fin -->
	</head> 
	<body class="general admin"> 
								<!-- InstanceBeginEditable name="EditRegion3" --><?php  $Menu=403;    ?><!-- InstanceEndEditable -->
		<div class="pageContainer"> 

		  <?php include ('menu.php');?>

			<div id="mainPanel" class="section_main">
            
        			<?php include ('header.php');?>
        
				<div class="main sectionBorder">
					<div id="information">
          
          <div class="titleBar">
          <!-- InstanceBeginEditable name="Titulo Top" -->
          
          <script src="js/funciones_periodos_distribucion.js"></script>
 
          <?php 
		  
			$peri_codi = $_GET['peri_codi'];
						
			$params = array($peri_codi);
			$sql="{call peri_info(?)}";			 
			$peri_info = sqlsrv_query($conn, $sql, $params);  
			$row_peri_info = sqlsrv_fetch_array($peri_info);
		
		  
		  ?>
          
          <div class="title"><h3><span class="icon-calendar icon"></span>Periodos Modelos de Notas <?= $row_peri_info['peri_deta'];	?> </h3></div>
		    <div class="options">
                
                 <ul>                    
                    <li>
                      <a id="bt_peri_add" class="button_text"  data-toggle="modal" data-target="#copia_peri_mode_cali" >
                        <span class="icon-copy icon"></span>  Nuevo Modelo de Calificacion</a>
                    </li>  
                </ul>
          </div>
		  <!-- InstanceEndEditable -->
          </div>
          
                        <!-- InstanceBeginEditable name="information" -->
                 
                    		 <div id="curs_peri_main" >
 
							  <?php include ('admin_periodos_notas_modelos_view.php'); ?>
                             
                             </div>
                             
                             
                          <!-- Modal -->                                            
                            <div class="modal fade" id="copia_peri_mode_cali" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                    <h4 class="modal-title" id="myModalLabel"><label id="n_modaltitu">MODELO DE CALIFICACION</label></h4>
                                  </div>
                                  <div class="modal-body">
                                         <table width="100%" border="0" cellspacing="0" cellpadding="0">                                      
                                            <tr>
                                            	<td height="50px"> </td>
                                            	<td><input id="" type="text" value=""  ><br><br>

<br>

</td>
                                          	</tr>
                                        </table>
                                        
                                              </div>
                                              <div class="modal-footer">
                                                 <button type="button" class="btn btn-primary"  data-dismiss="modal" onClick="peri_aceptar()">Aceptar</button>
                                                 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                 <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                               <br>
                                        <br>
                                        <br>
                            
                                  </div>
                                </div>
                              </div>
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
    
<!-- InstanceBeginEditable name="EditRegion4" -->EditRegion4<!-- InstanceEndEditable -->
</body>
<!-- InstanceEnd --></html>