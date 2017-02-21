<!DOCTYPE html>
<html><!-- InstanceBegin template="/Templates/admin.dwt" codeOutsideHTMLIsLocked="false" -->

<?php include ('head.php');?>
        
      <!-- Nuevos Css Js -->
	
      <!-- Fin -->
	</head> 
	<body class="general admin"> 
								<!-- InstanceBeginEditable name="EditRegion3" --><?php  $Menu=201;    ?><!-- InstanceEndEditable -->
		<div class="pageContainer"> 

		  <?php include ('menu.php');?>

			<div id="mainPanel" class="section_main">
            
        			<?php include ('header.php');?>
        
				<div class="main sectionBorder">
					<div id="information">
          
          <div class="titleBar">
          <!-- InstanceBeginEditable name="Titulo Top" -->
 				<?php 	
				   
				   
						include ('../framework/dbconf.php');
						session_start();
						  
						  
						if(isset($_GET['curs_para_codi'])){
							 $curs_para_codi=$_GET['curs_para_codi'];
						}
						
						$PERI_CODI = $_SESSION['peri_codi'];
						
			 	 
				$params = array($curs_para_codi);
				$sql="{call curs_peri_info(?)}";
				$curs_peri_info = sqlsrv_query($conn, $sql, $params);
				$row_curs_peri_info = sqlsrv_fetch_array($curs_peri_info);
				
				  
			 ?>
		  		
            	
           
                    

			<div class="title">
            	<h3><span class="icon-books icon"></span>Cursos Paralelos \ <?= $row_curs_peri_info['curs_deta'];?> - <?= $row_curs_peri_info['para_deta'];?> </h3>
                
               </div>        
            <div class="options">

              <ul>

                   
               
                 <li>
                  <a class="button_text"  id="bt_curs_add"   onClick="window.location='cursos_paralelo_notas_mate_main_deta_view_print_full.php?peri_dist_codi=' + selectvalue(document.getElementById('peri_dist_codi')) + '&curs_para_codi=<?= $curs_para_codi; ?>'"  >
                    <span class="icon-print"></span> Reporte Completo
                  </a>
                </li>
                
                <li>
                  <a class="button_text"  id="bt_curs_add"   onClick="window.location='cursos_paralelo_notas_mate_main_deta_view_print_full_xls.php?peri_dist_codi=' + selectvalue(document.getElementById('peri_dist_codi')) + '&curs_para_codi=<?= $curs_para_codi; ?>'"  >
                    <span class="icon-print"></span> Excel
                  </a>
                </li>
			 
              </ul>
            </div>
     
     
 
          <!-- InstanceEndEditable -->
          </div>
          
                        <!-- InstanceBeginEditable name="information" -->
                  
					 
					<script type="text/javascript" src="../framework/funciones.js"></script>
		
                            
                        <div  id="tab_alum">
							 <?php 	include('cursos_paralelo_notas_mate_main_view.php') ?>
						</div>
						
		 
						<div  id="tab_alum_notas">
						 
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
    
<!-- InstanceBeginEditable name="EditRegion4" -->
<!-- InstanceEndEditable -->
</body>
<!-- InstanceEnd --></html>