<!DOCTYPE html>
<html><!-- InstanceBegin template="/Templates/admin.dwt" codeOutsideHTMLIsLocked="false" -->

<?php include ('head.php');?>
        
      <!-- Nuevos Css Js -->
	
      <!-- Fin -->
	</head> 
	<body class="general admin"> 
								<!-- InstanceBeginEditable name="EditRegion3" --><?php  $Menu=410;    ?><!-- InstanceEndEditable -->
		<div class="pageContainer"> 

		  <?php include ('menu.php');?>

			<div id="mainPanel" class="section_main">
            
        			<?php include ('header.php');?>
        
				<div class="main sectionBorder">
					<div id="information">
          
          <div class="titleBar">
          <!-- InstanceBeginEditable name="Titulo Top" -->
          <div class="title">
          	<h3>
            	<span class="icon-users icon"></span>Parámetros del Sistema
            </h3>
          </div>  
		  <!-- InstanceEndEditable -->
          </div>
          
                        <!-- InstanceBeginEditable name="information" -->
                        <script type="text/javascript" src="js/funciones_para_sistema.js"></script> 
                        <div id="para_sist_main" >
                             <?php include ('para_sistema_main_lista.php'); ?>
                        </div>
                        <div class="modal fade" id="ModalUsuaEdi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">Editar Parámetro</h4>
                              </div>
                              <div id="modal_main" class="modal-body">
                                <div id="div_usua_edi"> 
                                    <form id="frm_usua_edi" name="frm_usua_edi" method="post" action="" enctype="multipart/form-data">
                                    	<div class="form_element">
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%;" class="table">
                                        <tr>
                                        <td width="25%"><label for="para_deta_edi">Parámetro: </label></td>
                                        <td width="75%">
                                        <input type="text" id="para_deta_edi" style="width: 100%; margin-top: 5px;"  name="para_deta_edi" value="" disabled>
                                        <input type="hidden" id="para_codi_edi" name="para_codi_edi" value="">
                                        </td>
                                        </tr>
                                        <tr>
                                        <td><label for="para_valo_edi">Valor: </label></td>
                                        <td><textarea id="para_valo_edi" style="width: 100%; margin-top: 5px;" name="para_valo_edi" value=""></textarea></td>
                                        </tr>
                                        </table>  
                                        </div>
                                        <div class="form_element">&nbsp;</div>                
                                    </form>
                                </div>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-success" onClick="load_ajax_edi_para_sist('para_sist_main','script_para_sistema.php','opc=upd&sist_codi='+document.getElementById('para_codi_edi').value+'&sist_valo='+document.getElementById('para_valo_edi').value);" >Grabar</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
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
    
<!-- InstanceBeginEditable name="EditRegion4" -->
<script type="text/javascript" charset="utf-8">
$(document).ready(function() {
	    $('#para_sist_table').datatable({
			pageSize: 10,
			sort: [true, false, false],
			filters: [true, false, false],
			filterText: 'Escriba para buscar... '
		}) ;
} );

</script>
       <!-- InstanceEndEditable -->
</body>
<!-- InstanceEnd --></html>