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
                  <h3><span class="icon-books icon"></span>VALORES</h3>
              </div> 
              <div class="options">
                  <ul>
                    <li>

                    <?php if (permiso_activo(40)){?>
                    <a id="bt_valo_add"   class="button_text" onclick="document.getElementById('valo_deta').value='';" data-toggle="modal" data-target="#valo_nuev" >
                      <span class="icon-add icon"></span>Nuevo Valor
                    </a>
                    <?php }?>
                    
                  </ul>
              </div>

              <!-- InstanceEndEditable -->
          </div>
          
                        <!-- InstanceBeginEditable name="information" -->

                   
                        	 <script type="text/javascript" src="../framework/funciones.js"> </script>
                    		 <div id="valo_main" >
 
							  <?php include ('valores_main_lista.php'); ?>
                             
                             </div>

                    <!-- Modal -->
<div 
	class="modal fade" 
    id="valo_nuev" 
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
        <h4 class="modal-title" id="myModalLabel">Nuevo valor</h4>
      </div>
      <div class="modal-body">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="25%">
                Nombre: 
            </td>
            <td>
                <input 
                	id="valo_deta" 
                    name="valo_deta" 
                    type="text" 
                    value="" 
                    style="width: 100%; margin-top: 5px;">
            </td>
          </tr>
	  </table>
      </div>
      <div class="modal-footer">
         <button 
         	type="button" 
            class="btn btn-primary"  
            data-dismiss="modal" 
            onClick="load_ajax('valo_main','valores_main_lista.php','valo_deta='+ document.getElementById('valo_deta').value  + '&add_valo=Y');">
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