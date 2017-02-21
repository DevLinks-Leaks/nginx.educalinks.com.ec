<!DOCTYPE html>
<html><!-- InstanceBegin template="/Templates/admin.dwt" codeOutsideHTMLIsLocked="false" -->

<?php include ('head.php');?>
        
      <!-- Nuevos Css Js -->

      <!-- Fin -->
	</head> 
	<body class="general admin"> 
								<!-- InstanceBeginEditable name="EditRegion3" --><?php  $Menu=0;    ?><!-- InstanceEndEditable -->
		<div class="pageContainer"> 

		  <?php include ('menu.php');?>

			<div id="mainPanel" class="section_main">
            
        			<?php include ('header.php');?>
        
				<div class="main sectionBorder">
					<div id="information">
          
          <div class="titleBar">
          <!-- InstanceBeginEditable name="Titulo Top" -->
            <div class="title"><h3><span class="icon-home icon"></span>Inicio</h3></div> 	
          <!-- InstanceEndEditable -->
          </div>
          
                        <!-- InstanceBeginEditable name="information" -->
                        <script src="../framework/Chart.js-master/Chart.js"></script>
                         <script src="../admin/js/funciones_monitor.js"></script>
                      		 <div id="curs_para_main" >
                             <ul class="nav nav-tabs">    
								  <?php if (permiso_activo(1)){?><li class="active"><a href="#tab1" data-toggle="tab"  onClick="">Matriculados		</a></li><? }?>
                                  <?php if (permiso_activo(93)){?><!--<li><a href="#tab2" data-toggle="tab" onClick="">Visitas al Sistema	</a></li>--><? }?>
                                  <?php if (permiso_activo(94)){?><!--<li><a href="#tab3" data-toggle="tab" onClick="">Agenda				</a></li>--><? }?>
                                  <?php if (permiso_activo(95)){?><li><a href="#tab4" data-toggle="tab" onClick="">Monitoreo			</a></li><? }?>
                             </ul> 				 
                             <div class="tab-content">
                              <div class="tab-pane active" id="tab1"><?php include ('index_tab1.php'); ?></div>
                              <!--<div class="tab-pane" id="tab2"><?php include ('index_tab2.php'); ?></div>
                              <div class="tab-pane" id="tab3"><?php include ('index_tab3.php'); ?></div>-->
                              <div class="tab-pane" id="tab4"><?php include ('index_tab4.php'); ?></div> 
                            </div>
                             </div>
					<script>
                      $(function () {
                        $('#myTab a:last').tab('show');
                      })
					  
					  
						 


                    </script>
                    
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