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
          <?php  
	session_start();	 
	include ('../framework/dbconf.php');
	include ('script_cursos.php'); 
	
	$peri_codi=$_GET['peri_codi'];
 
	 
	$params = array($peri_codi);
	$sql="{call peri_info(?)}";
	$peri_info = sqlsrv_query($conn, $sql, $params);  
	 $row_peri_info = sqlsrv_fetch_array($peri_info);
 ?>  
 
    
          
          <div class="title"><h3><span class="icon-calendar icon"></span>Etapas Periodo <?= $row_peri_info['peri_deta']; ?> </h3></div>
              <div class="options">
                <ul>
                  <?php if (permiso_activo(68)){?>
                    <li>
                      <a id="bt_peri_add" class="button_text" onclick="document.getElementById('peri_deta').value='';" data-toggle="modal" data-target="#peri_nuev" >
                        <span class="icon-add icon"></span> Nueva Etapa del Periodo
                      </a>
                    </li>
                  <?php }?>
                </ul>
              </div>
		  <!-- InstanceEndEditable -->
          </div>
          
                        <!-- InstanceBeginEditable name="information" -->
                    		 <div id="peri_etap_view">
 
							 	 <?php include ('admin_periodos_etapas_view.php'); ?>
                             
                             </div>
<input type="hidden" value="<?= $peri_codi?>" id="e_peri_codi">
<script src="../framework/funciones.js"></script>
<script src="js/funciones_periodo_etapa.js"></script>
                   
             <!-- Modal -->
<div 
	class="modal fade" 
    id="peri_nuev" 
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
        <h4 class="modal-title" id="myModalLabel">Nueva Etapa</h4>
      </div>
      <div class="modal-body">
       <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="25%">Etapas: </td>
            <td>
				<?php  
					$params = array();
					$sql="{call peri_etap_view()}";
					$peri_etap_view = sqlsrv_query($conn, $sql, $params);  
				?> 
                <select 
                	name="n_peri_etap_codi"   
                    id="n_peri_etap_codi" 
                    onchange="peri_dist_peri_libt_view(<?= $peri_codi; ?>,this.value)"
                    style="width: 100%; margin-top: 5px;">
                 	<?php  
				 	while ($row_peri_etap_view = sqlsrv_fetch_array($peri_etap_view)) 
					{ 
					?>     
                    <option 
                    	value="<?= $row_peri_etap_view['peri_etap_codi']; ?>/<?= $row_peri_etap_view['peri_etap_unid']; ?>">
                        <?= $row_peri_etap_view['peri_etap_deta']; ?>    
                    </option>
                	<?php 
					}  
					?>	  
                </select>
            </td> 
		</tr>
        <tr>
            <td width="25%">
                Tipo periodo:
            </td>
            <td width="75%">
            <?
                $params = array($peri_codi);
                $sql="{call peri_dist_cab_view(?)}";
                $peri_dist_cab_view = sqlsrv_query($conn, $sql, $params);
            ?>
            <select
                name="sl_peri_dist_cab"
                id="sl_peri_dist_cab"
                style="width:75%; margin-top:10px;"
                disabled="disabled"
                onChange="CargarUnidades(this.value, 1);">
                    <option value="0">Elija</option>
               <?php  while ($row_peri_dist_cab_view = sqlsrv_fetch_array($peri_dist_cab_view)) { ?>
                    <option value="<?= $row_peri_dist_cab_view['peri_dist_cab_codi']; ?>">
                        <?= $row_peri_dist_cab_view['peri_dist_cab_deta']; ?>
                    </option>
                <? } ?>
            </select>
            </td>
          </tr>
			<?php	
				$params = array($peri_codi);
				$sql="{call peri_dist_peri_libt_view(?)}";
				$peri_dist_peri_libt_view = sqlsrv_query($conn, $sql, $params);              
            ?>  
        <tr>
            <td>
            	Unidad: 
			</td>
            <td> 
            <div id="div_unidad">
                <select 
                	name="pg_peri_dist_codi"   
                    id="pg_peri_dist_codi" 
                    style="width: 75%; margin-top: 5px;"
                    disabled="disabled"> 
                </select> 
            </div>  
            </td>
        </tr>
        <tr>
            <td>Desde:</td>                                
            <td>
            	<input 
                    id="n_peri_fech_ini"   
                    type="text" 
                    value="<?= date('Y-m-d');?>"
                    style="width: 25%; margin-top: 5px;">
			</td>
        </tr>
        <tr>
            <td>Hasta: </td>                             
            <td>
            	<input 
                	id="n_peri_fech_fin"   
                    type="text" 
                    value="<?= date('Y-m-d');?>"
                    style="width: 25%; margin-top: 5px;">
			</td>
        </tr>
        </table>
        <div class="form_element">&nbsp;</div> 
      </div>
      <div class="modal-footer">
        <button 
            type="button" 
            class="btn btn-primary"  
            data-dismiss="modal" 
            onClick="peri_acti_add(<?= $peri_codi;?>)">
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
    
<script>					 
	$("#n_peri_fech_ini").datepicker({ dateFormat: 'yy-mm-dd' });
	$("#n_peri_fech_fin").datepicker({ dateFormat: 'yy-mm-dd' });
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
    
<!-- InstanceBeginEditable name="EditRegion4" -->EditRegion4<!-- InstanceEndEditable -->
</body>
<!-- InstanceEnd --></html>