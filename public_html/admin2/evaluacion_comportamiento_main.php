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
 				<?php 	
				   
				   
				include ('../framework/dbconf.php');
				session_start();
				
				$PERI_CODI = $_SESSION['peri_codi'];
				
				  
			 ?>
			<div class="title">
            	<h3><span class="icon-books icon"></span>EVALUACION COMPORTAMIENTO </h3>
                
               </div>        
            <div class="options">

              <ul>
                 <li>
                  <a id="bt_valo_add" class="button_text" data-toggle="modal" data-target="#eval_comp_nuev">
                    <span class="icon-add icon"></span> Asignar Indicadores a Parcial
                  </a>
                </li>
              </ul>
            </div>
     
     
 
          <!-- InstanceEndEditable -->
          </div>
          
                        <!-- InstanceBeginEditable name="information" -->
                  
					 
					<!--<script type="text/javascript" src="../framework/funciones.js"></script>-->
					<script src="js/funciones_indi_parc.js"></script>                         
                    <div  id="indi_parc_main">
                         <?php 	include('evaluacion_comportamiento_main_lista.php') ?>
                    </div>
						            
     <!-- Modal -->
<div 
	class="modal fade" 
    id="eval_comp_nuev" 
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
                	<span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
			</button>
            <h4 class="modal-title" id="myModalLabel">Nuevo Indicador</h4>
          </div>
          <div class="modal-body">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="25%">Unidad: </td>
                <td><? 	
                    $peri_codi=$_SESSION['peri_codi'];
                    $peri_dist_nive=2;
                    $params = array($peri_codi,$peri_dist_nive);
                    $sql="{call peri_dist_peri_nive_view(?,?)}";
                    $peri_dist_peri_nive_view = sqlsrv_query($conn, $sql, $params);  
                    ?>
                    <select id="sl_peri_dist" style="width: 75%; margin-top: 5px;">
                    <? while($row_peri_dist_peri_nive_view = sqlsrv_fetch_array($peri_dist_peri_nive_view))
					{ 
					?>
                    	<option value="<?= $row_peri_dist_peri_nive_view['peri_dist_codi'];?>">
                    		<?= $row_peri_dist_peri_nive_view['peri_dist_padr_deta'];?> \ 
							<?= $row_peri_dist_peri_nive_view['peri_dist_deta'];?>
                    	</option>
					<?php 	 
					} 
					?>
                    </select>
                    </td>
              </tr>
              <tr>
                <td width="25%">Valor: </td>
                <td>
                    <? 	
                        $params = array();
                        $sql="{call valo_view()}";
                        $valo_view = sqlsrv_query($conn, $sql, $params);  
                    ?>
                    <select id="sl_valor" onChange="indi_view(this.value,'div_indicador')"style="width: 75%; margin-top: 5px;" >
                        <? while($row_valo_view = sqlsrv_fetch_array($valo_view))
                        { 
						?>
                          <option 
                          	value="<?= $row_valo_view['valo_codi'];?>" 
						  	<? if ($row_valo_view['valo_codi']==$row_valo_view["valo_codi"] ) echo 'selected="selected"';?>>
                            <?= $row_valo_view['valo_deta'];?>
                          </option>
                     <? } ?>
                    </select>     
                </td>
              </tr>
              <tr>
                <td width="25%">Indicador:</td>
                <td>
                    <div id="div_indicador"> </div>
                </td>
              </tr>
           </table>
           <div class="form_element">&nbsp;</div> 
          </div>
          <div class="modal-footer">
             <button type="button" class="btn btn-primary"  data-dismiss="modal" onClick="indi_parc_add()">
                    Aceptar
             </button>
             
             &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
           
          </div>
        </div>
      </div>
</div>      
<script>
	$(document).ready(indi_view(selectvalue(document.getElementById('sl_valor')),'div_indicador'));
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
    
<!-- InstanceBeginEditable name="EditRegion4" -->
<!-- InstanceEndEditable -->
</body>
<!-- InstanceEnd --></html>