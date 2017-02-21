<!DOCTYPE html>
<html><!-- InstanceBegin template="/Templates/admin.dwt" codeOutsideHTMLIsLocked="false" -->

<?php include ('head.php');?>
        
      <!-- Nuevos Css Js -->
	
      <!-- Fin -->
	</head> 
	<body class="general admin"> 
								<!-- InstanceBeginEditable name="EditRegion3" --><?php  $Menu=206;    ?><!-- InstanceEndEditable -->
		<div class="pageContainer"> 

		  <?php include ('menu.php');?>

			<div id="mainPanel" class="section_main">
            
        			<?php include ('header.php');?>
        
				<div class="main sectionBorder">
					<div id="information">
          
          <div class="titleBar">
          <!-- InstanceBeginEditable name="Titulo Top" -->
          
          <?php 

			session_start();	 
			include ('../framework/dbconf.php');
			
			if(isset($_GET['curs_para_mate_codi'])){
			 $curs_para_mate_codi=$_GET['curs_para_mate_codi'];
			}
			if(isset($_GET['curs_para_mate_prof_codi'])){
			 $curs_para_mate_prof_codi=$_GET['curs_para_mate_prof_codi'];
			}
			 
			
			$params = array($curs_para_mate_prof_codi);
			$sql="{call curs_para_mate_prof_info(?)}";
			$curs_para_mate_info = sqlsrv_query($conn, $sql, $params);  
			$row_curs_para_mate_info = sqlsrv_fetch_array($curs_para_mate_info); 
			 

			?>
         	 <script src="js/funciones_notas_permisos.js"></script>

           <div class="title">
             <h3>
                <span class="icon-check icon"></span>
                Notas Permisos <?= $row_curs_para_mate_info['curs_deta']; ?> <?= $row_curs_para_mate_info['para_deta']; ?>
                </h3>
           </div>
          	<div class="zones">
            <div class="zone">
                <strong>Materia:</strong>
                  <?= $row_curs_para_mate_info['mate_deta']; ?> 
            </div>
            <div class="zone-last">
                <strong>Profesor:</strong>
                <?= $row_curs_para_mate_info['prof_nomb']; ?>
            </div>
            </div>
                
         
		  
		  <!-- InstanceEndEditable -->
          </div>
          
                        <!-- InstanceBeginEditable name="information" -->
                          <div style="text-align:right; width:97%; margin:10px;  margin-top:30px;"></div>   
							
                        	 
                    		 <div id="curs_para_main_perm_deta"  >
 					
							  <?php include ('cursos_notas_permisos_main_deta_view.php'); ?>
                             
                             </div> 
                         
                        
                       <!-- Modal -->
                            <div class="modal fade" id="nuev_perm_indi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                    <h4 class="modal-title" id="myModalLabel">Nuevo Permisos</h4>
                                  </div>
                                  <div class="modal-body">
                                   <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                    <td height="40" >Unidad:</td>
                                    <td > 
                                    <? 
                                         
                                         
                                        $peri_dist_nive= 2;
                                        
                                        $params = array($PERI_CODI ,$peri_dist_nive);
                                        $sql="{call peri_dist_peri_nive_view(?,?)}";
                                        $peri_dist_peri_nive_view = sqlsrv_query($conn, $sql, $params);  
                                         
                                    ?>
                                      <select name="pi_peri_dist_codi" id="pi_peri_dist_codi">
                                       <?php  while ($row_peri_dist_peri_nive_view = sqlsrv_fetch_array($peri_dist_peri_nive_view)) { ?> 
                                        <option value="<?= $row_peri_dist_peri_nive_view['peri_dist_codi']; ?>"><?= $row_peri_dist_peri_nive_view['peri_dist_deta']; ?> (<?= $row_peri_dist_peri_nive_view['peri_dist_padr_deta']; ?>)</option>
                                        <? } ?>
                                    </select></td>
                                  </tr>
                                <tr> 
                              
                                <tr>
                                <td >Desde:</td>
                                <td><input id="pi_nota_peri_fec_ini"   type="text" value="<?= date('Y-m-d');?>"></td>
                              </tr>
                                 </tr>
                                <tr>
                                <td  >Hasta: </td>
                                <td><input id="pi_nota_peri_fec_fin"   type="text" value="<?= date('Y-m-d');?>"></td>
                              </tr>
                            </table>
                            
                                  </div>
                                  <div class="modal-footer">
                                    	 <button type="button" class="btn btn-primary"  
                                     		onClick="nota_perm_add(1);"   >
                                            Aceptar
                                    	</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <button type="button" class="btn btn-default" data-dismiss="modal">
                                        	Cerrar
                                        </button>                                   
                                  </div>
                                </div>
                              </div>
                            </div>
                     
						<!-- Modal -->
 
                        
                        
                        <form >
                        <input type="hidden" name="peri_codi" id="peri_codi" value="<?= $row_peri_info['peri_codi']; ?>">
                      
                    
 							<script>
								 
								$("#pi_nota_peri_fec_ini").datepicker({ dateFormat: 'yy-mm-dd' });
								$("#pi_nota_peri_fec_fin").datepicker({ dateFormat: 'yy-mm-dd' });
								 
						
								curs_peri_mate_view(selectvalue(document.getElementById('pi_curs_para_codi')),'pi_mate_prof','pi')

                            </script> 

  					<!-- Modal GRUPO -->
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
    
<!-- InstanceBeginEditable name="EditRegion4" -->EditRegion4<!-- InstanceEndEditable -->
</body>
<!-- InstanceEnd --></html>