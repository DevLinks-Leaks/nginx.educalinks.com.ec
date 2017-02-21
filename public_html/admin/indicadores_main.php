<!DOCTYPE html>
<html><!-- InstanceBegin template="/Templates/admin.dwt" codeOutsideHTMLIsLocked="false" -->

<?php include ('head.php');?>
        
      <!-- Nuevos Css Js -->
	
      <!-- Fin -->
	</head> 
	<body class="general admin"> 
								<!-- InstanceBeginEditable name="EditRegion3" --><?php  $Menu=408;    ?><!-- InstanceEndEditable -->
		<div class="pageContainer"> 

		  <?php include ('menu.php');?>

			<div id="mainPanel" class="section_main">
            
        			<?php include ('header.php');?>
        
				<div class="main sectionBorder">
					<div id="information">
          
          <div class="titleBar">
          <!-- InstanceBeginEditable name="Titulo Top" -->
              <div class="title">
                  <h3><span class="icon-books icon"></span>Indicadores de evaluacion</h3>
              </div>


              <div class="options">
                  <ul>
                      <li>
                          <a id="bt_valo_add" class="button_text" onclick="indi_nuev_dial();" data-toggle="modal" data-target="#indi_nuev" >
                          <span class="icon-add icon"></span>Nuevo Indicador
                          </a>
                      </li>
                  </ul>
              </div>
          <!-- InstanceEndEditable -->
          </div>
          
                        <!-- InstanceBeginEditable name="information" --> 
                  			 <script src="js/funciones_indi.js"></script> 
                    		 <div id="indi_main" >
 
							  	<?php include ('indicadores_main_lista.php'); ?>
                             
                             </div>

                    <!-- Modal -->
                    <div class="modal fade" 
                    	 id="indi_nuev" 
                         tabindex="-1" 
                         role="dialog" 
                         aria-labelledby="myModalLabel" 
                         aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" 
                            		class="close" 
                                    data-dismiss="modal">
                                    	<span aria-hidden="true">&times;</span>
                                        <span class="sr-only">Close</span>
							</button>
                            <h4 class="modal-title" id="myModalLabel">Nuevo Indicador</h4>
                          </div>
                          <div class="modal-body">
                              <div class="form_element">
                               <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                  <tr>
                                    <td width="25%">
                                    	Nombre: 
                                    </td>
                                    <td width="75%">
                                    	<input id="n_indi_deta" 
                                        	   name="n_indi_deta" 
                                               type="text" 
                                               value="" 
                                               style="width: 100%; margin-top: 5px;">
                                     </td>
                                  </tr>
                                  <tr>
                                    <td width="25%">
                                    	Valor asociado: 
                                    </td>
                                    <td width="75%">
                                        <? 	
                                            $params = array();
                                            $sql="{call valo_view()}";
                                            $valo_view = sqlsrv_query($conn, $sql, $params);  
                                        ?>
                                        <select id="n_valo_codi" style="width: 75%; margin-top: 5px;">
                                            <? while($row_valo_view = sqlsrv_fetch_array($valo_view))
                                            { 
                                            ?>
                                              <option value="<?= $row_valo_view['valo_codi'];?>" 
                                              <? if ($row_valo_view['valo_codi']==$row_valo_view["valo_codi"]) 
                                                    echo 'selected="selected"';?>>
                                                <?= $row_valo_view['valo_deta'];?>
                                              </option>
                                            <? } ?>
                                        </select>     
                                    </td>
                                  </tr>
                                </table>
                                </div>
                                <div class="form_element">&nbsp;</div>   
                          </div>
                          <div class="modal-footer">
                             <button 
                             	type="button" 
                                class="btn btn-primary"  
                                data-dismiss="modal" 
                                onClick="indi_add_upd()">
                             		Aceptar
                             </button>
                             <button 
                             	type="button" 
                                class="btn btn-default" 
                                data-dismiss="modal">
                                	Cerrar
							 </button>
                          </div>
                        </div>
                      </div>
                    </div>
                   	 <input id="n_indi_codi" name="n_indi_codi" type="hidden" value="">                  
                     <input id="n_que" name="n_que" type="hidden" value="">
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