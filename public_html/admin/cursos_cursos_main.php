<!DOCTYPE html>
<html><!-- InstanceBegin template="/Templates/admin.dwt" codeOutsideHTMLIsLocked="false" -->

<?php include ('head.php');?>
        
      <!-- Nuevos Css Js -->
	
      <!-- Fin -->
	</head> 
	<body class="general admin"> 
								<!-- InstanceBeginEditable name="EditRegion3" --><?php  $Menu=202;    ?><!-- InstanceEndEditable -->
		<div class="pageContainer"> 

		  <?php include ('menu.php');?>

			<div id="mainPanel" class="section_main">
            
        			<?php include ('header.php');?>
        
				<div class="main sectionBorder">
					<div id="information">
          
          <div class="titleBar">
          <!-- InstanceBeginEditable name="Titulo Top" -->
              <div class="title">
                  <h3><span class="icon-books icon"></span>Cursos</h3>
              </div>


              <div class="options">
                  <ul>

                    <?php if (permiso_activo(34)){?>
                      <li>
                          <a id="bt_curs_add" class="button_text" onclick="curs_nuev_dial();" data-toggle="modal" data-target="#curs_nuev" >
                          <span class="icon_add icon"></span>Nuevo Curso
                          </a>
                      </li>
                    <?php }?>
                  </ul>
              </div>
          <!-- InstanceEndEditable -->
          </div>
          
                        <!-- InstanceBeginEditable name="information" --> 
                  			 <script src="js/funciones_curs.js"></script> 
                    		 <div id="curs_curs_main" >
 
							  	<?php include ('cursos_cursos_main_lista.php'); ?>
                             
                             </div>

                    <!-- Modal -->
                    <div 
                    	class="modal fade" 
                        id="curs_nuev" 
                        tabindex="-1" 
                        role="dialog" 
                        aria-labelledby="myModalLabel" 
                        aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button 
                            	type="button" 
                                class="close" 
                                data-dismiss="modal">
                                	<span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
							</button>
                            <h4 class="modal-title" id="myModalLabel">Nuevo curso</h4>
                          </div>
                          <div class="modal-body">
                           <table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td>
                                    Nombre: 
                                </td>
                                <td>
                                    <input 
                                        id="n_curs_deta" 
                                        name="n_curs_deta" 
                                        type="text" 
                                        value=""
                                        style="width: 100%; margin-top: 5px;">
                                </td>
                              </tr>
                              <tr>
                                <td>Nivel: </td>
                                <td>
                                    <? 	
                                        $params = array();
                                        $sql="{call nive_view()}";
                                        $nive_view = sqlsrv_query($conn, $sql, $params);  
                                    ?>
                                    <select  id="n_nive_codi" style="width: 75%; margin-top: 10px;">
                                        <? while($row_nive_view = sqlsrv_fetch_array($nive_view)){ ?>
                                          <option value="<?= $row_nive_view['nive_codi'];?>" <? if ($row_nive_view['nive_codi']==$row_curs_view["nive_codi"] ) echo 'selected="selected"';?> >
                                            <?= $row_nive_view['nive_deta'];?></option>
                                        <? } ?>
                                    </select>     
          
                                </td>
                              </tr>
                            </table>
                    		<div class="form_element">&nbsp;</div>
						</div>
						<div class="modal-footer">
						<button type="button" class="btn btn-primary" data-dismiss="modal" onClick="curs_add_upd()">
							Aceptar
						</button>
                             &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<button type="button" class="btn btn-default" data-dismiss="modal">
                        	Cerrar
						</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <input id="n_curs_codi" name="n_curs_codi" type="hidden" value="">                  
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