<!DOCTYPE html>
<html><!-- InstanceBegin template="/Templates/admin.dwt" codeOutsideHTMLIsLocked="false" -->

<?php include ('head.php');?>
        
      <!-- Nuevos Css Js -->
	
      <!-- Fin -->
	</head> 
	<body class="general admin"> 
								<!-- InstanceBeginEditable name="EditRegion3" --><?php  $Menu=407;    ?><!-- InstanceEndEditable -->
		<div class="pageContainer"> 

		  <?php include ('menu.php');?>

			<div id="mainPanel" class="section_main">
            
        			<?php include ('header.php');?>
        
				<div class="main sectionBorder">
					<div id="information">
          
          <div class="titleBar">
          <!-- InstanceBeginEditable name="Titulo Top" --><div class="title"><h3><span class="icon-users icon"></span>Usuarios</h3></div>
		  <div class="options">
          	<ul>
            	
                <li>
                  
                </li>
                
            </ul>
          </div>
		  
		  <!-- InstanceEndEditable -->
          </div>
          
                        <!-- InstanceBeginEditable name="information" -->
                        <script type="text/javascript" src="js/funciones_reset.js"></script> 
                        <div id="usua_main" >
                             <?php include ('reset_pass_main.php'); ?>
                        </div>
                        
                        <div class="modal fade" id="ModalUsuaEdi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">Resetear Clave Usuario</h4>
                              </div>
                              <div id="modal_main" class="modal-body">
                                <div id="div_usua_edi"> 
                                   <form id="frm_usua_edi" name="frm_usua_edi" method="post" action="" enctype="multipart/form-data">
                                    	<div class="form_element"> 
                                        <table width="100%;" class="table">
                                        <tr>
                                        	<td width="25%"><label for="usua_nombre_edi">Nombres: </label></td>
                                            <td width="75%"><input type="text" id="usua_nombre_edi" name="usua_nombre_edi" value="" placeholder="Ingrese los nombres..." disabled="disabled"></td>
                                        </tr>
                                        <tr>
                                        	<td><label for="usua_apellido_edi">Apellidos: </label></td>
                                            <td><input type="text" id="usua_apellido_edi" name="usua_apellido_edi" value="" placeholder="Ingrese los apellidos..." disabled="disabled"></td>
                                        </tr>
                                        <tr>
                                        	<td><label for="usua_email_edi">Email: </label></td>
                                            <td><input type="text" id="usua_email_edi" name="usua_email_edi" value="" placeholder="Ingrese el email..." disabled="disabled"></td>
                                        </tr>
                                        <tr>
                                        	<td><label for="usua_username_edi">Username: </label></td>
                                            <td><input type="text" id="usua_username_edi" name="usua_username_edi" disabled="disabled" value="" placeholder="Ingrese el username...">
                                            <input type="hidden" id="usua_tipo_edi" name="usua_tipo_edi" value=""></td>
                                        </tr>
                                        <tr>
                                        	<td><label for="usua_pass_edi">Clave: </label></td>
                                            <td><input type="text" id="usua_pass_edi" name="usua_pass_edi" value="" placeholder="Ingrese la nueva clave..."></td>
                                        </tr>
                                        </table>
										</div>
                                        <div class="form_element">&nbsp;</div>
                                    </form> 
                                </div>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-success" onClick="load_ajax_edi_usua('usua_main','script_reset.php','opc=upd&usua_nombre='+document.getElementById('usua_nombre_edi').value+'&usua_apellido='+document.getElementById('usua_apellido_edi').value+'&usua_email='+document.getElementById('usua_email_edi').value+'&usua_username='+document.getElementById('usua_username_edi').value+'&usua_tipo='+document.getElementById('usua_tipo_edi').value+'&usua_pass='+document.getElementById('usua_pass_edi').value);" >Grabar</button>
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
	    $('#usua_table').datatable({
			pageSize: 10,
			sort: [true, false],
			filters: [true, false],
			filterText: 'Escriba para buscar... '
		}) ;
} );

</script>
       <!-- InstanceEndEditable -->
</body>
<!-- InstanceEnd --></html>