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
		  		
			$alum_codi=$_GET['alum_codi'];
			$alum_curs_para_codi =$_GET['alum_curs_para_codi'];
			
		 
			$params = array($peri_dist_codi);
			$sql="{call peri_dist_padr_view(?)}";
			$peri_dist_padr_view = sqlsrv_query($conn, $sql, $params); 
			
			$peri_codi=Periodo_Distribucion_Peri_Codi($peri_dist_codi);
			 
		 
		 
			$params = array($alum_curs_para_codi);
			$sql="{call alum_info_curs_para(?)}";
			$alum_info_curs_para = sqlsrv_query($conn, $sql, $params);
			$row_alum_info_curs_para = sqlsrv_fetch_array($alum_info_curs_para);
		  
		  
 			?>
            
            <div class="title">
              <h3><span class="icon-checkbox-checked icon"></span>Faltas detallado</h3>
            </div>

          <!-- InstanceEndEditable -->
          </div>
          
                        <!-- InstanceBeginEditable name="information" -->
              
					 <h4> Alumno: <?= $row_alum_info_curs_para['alum_apel']; ?> <?= $row_alum_info_curs_para['alum_nomb']; ?> ||  Curso: <?= $row_alum_info_curs_para['curs_deta']; ?></h4> 
					       
                        <div  id="curs_para_view_falt">
							 <?php 	include('cursos_paralelo_falt_alum_main_deta_view.php'); ?>
						</div>
						
		 
						<script type="text/javascript" src="js/funciones_faltas.js"></script>
                    
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