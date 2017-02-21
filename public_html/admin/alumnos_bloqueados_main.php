<!DOCTYPE html>
<html><!-- InstanceBegin template="/Templates/admin.dwt" codeOutsideHTMLIsLocked="false" -->

<?php include ('head.php');?>
        
      <!-- Nuevos Css Js -->
	
      <!-- Fin -->
	</head> 
	<body class="general admin"> 
								<!-- InstanceBeginEditable name="EditRegion3" --><?php  $Menu=104;    ?><!-- InstanceEndEditable -->
		<div class="pageContainer"> 

		  <?php include ('menu.php');?>

			<div id="mainPanel" class="section_main">
            
        			<?php include ('header.php');?>
        
				<div class="main sectionBorder">
					<div id="information">
          
          <div class="titleBar">
          <!-- InstanceBeginEditable name="Titulo Top" --><div class="title"><h3><span class="icon-users icon"></span>Alumnos bloqueados</h3></div>
		  <div class="options">
          	<ul>
            	<?php if (permiso_activo(78)){?>
                <li>
                  <a class="button_text" onclick="document.getElementById('usua_nombre').focus();" data-toggle="modal" data-target="#ModalUsuaAdd" title="">
                    <span class="icon-add icon"></span> Bloquear Alumno
                  </a>
                </li>
                <?php }?>
            </ul>
          </div>
		  
		  <!-- InstanceEndEditable -->
          </div>
          
                        <!-- InstanceBeginEditable name="information" -->
                        <script type="text/javascript" src="js/funciones_alumnos_bloqueados.js"></script> 
                        <div id="alum_main" >
                             <?php include ('alumnos_bloqueados_main_lista.php'); ?>
                        </div>
                        
                        <div class="modal fade" id="ModalUsuaAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">Nuevo bloqueo</h4>
                              </div>
                              <div id="modal_main" class="modal-body">
                                <div id="div_usua_nuev"> 
                                    <form id="frm_usua_add" name="frm_usua_add" method="post" action="" enctype="multipart/form-data">
                                    	<div class="form_element">
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%;" class="table">
                                        <tr>
                                        <td width="25%"><label for="alum_nombre">C&eacute;dula: </label></td>
                                        <td width="75%"><input type="text" id="alum_cedu" name="alum_cedu" value="" placeholder="Ingrese la c&eacute;dula..."></td>
                                        </tr>
                                        <tr>
                                        <td><label for="alum_nombre">Nombres: </label></td>
                                        <td><input type="text" id="alum_nombre" name="alum_nombre" value="" placeholder="Ingrese los nombres..."></td>
                                        </tr>
                                        <tr>
                                        <td><label for="alum_apellido">Apellidos: </label></td>
                                        <td><input type="text" id="alum_apellido" name="alum_apellido" value="" placeholder="Ingrese los apellidos..."></td>
                                        </tr>
                                        <tr>
                                        <td><label for="usua_email">Observaci&oacute;n: </label></td>
                                        <td><input type="text" id="alum_obse" name="alum_obse" value="" placeholder="Ingrese una observaci&oacute;n"></td>
                                        </tr>
                                        <tr>
                                        </table>   
                                        </div>
                                        <div class="form_element">&nbsp;</div>                                     
                                    </form>
                                </div>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-success" onClick="load_ajax_add_alum('alum_main','script_alumnos_bloqueados.php','opc=add&alum_nombre='+document.getElementById('alum_nombre').value+'&alum_apellido='+document.getElementById('alum_apellido').value+'&alum_obse='+document.getElementById('alum_obse').value+'&alum_cedu='+document.getElementById('alum_cedu').value);" >Agregar</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                              </div>
                            </div>
                          </div>
                        </div>
                        
                        <div class="modal fade" id="ModalUsuaEdi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">Editar Alumno</h4>
                              </div>
                              <div id="modal_main" class="modal-body">
                                <div id="div_usua_edi"> 
                                    <form id="frm_usua_edi" name="frm_usua_edi" method="post" action="" enctype="multipart/form-data">
                                    	<div class="form_element">
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%;" class="table">
                                        <tr>
                                        <td width="25%"><label for="alum_cedu_edi">C&eacute;dula: </label></td>
                                        <td width="75%"><input type="text" id="alum_cedu_edi" name="alum_cedu_edi" value="" placeholder="Ingrese la c&eacute;dula..."></td>
                                        </tr>
                                        <tr>
                                        <td><label for="alum_nomb_edi">Nombres: </label></td>
                                        <td><input type="text" id="alum_nomb_edi" name="alum_nomb_edi" value="" placeholder="Ingrese los nombres..."></td>
                                        </tr>
                                        <tr>
                                        <td><label for="alum_apel_edi">Apellidos: </label></td>
                                        <td><input type="text" id="alum_apel_edi" name="alum_apel_edi" value="" placeholder="Ingrese los apellidos..."></td>
                                        </tr>
                                        <tr>
                                        <td><label for="alum_obse">Observaci&oacute;n: </label></td>
                                        <td>
                                        <input type="text" id="alum_obse_edi" name="alum_obse_edi" value="" placeholder="Ingrese una observaci&oacute;n">
                                        <input type="hidden" id="alum_codi_edi" name="alum_codi_edi" value="">
                                        </td>
                                        </tr>
                                        <tr>
                                        </table>  
                                        </div>
                                        <div class="form_element">&nbsp;</div>                
                                    </form>
                                </div>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-success" onClick="load_ajax_edi_alum('alum_main','script_alumnos_bloqueados.php','opc=upd&alum_nombre='+document.getElementById('alum_nomb_edi').value+'&alum_apellido='+document.getElementById('alum_apel_edi').value+'&alum_obse='+document.getElementById('alum_obse_edi').value+'&alum_cedu='+document.getElementById('alum_cedu_edi').value+'&alum_codi='+document.getElementById('alum_codi_edi').value);" >Grabar</button>
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
	    $('#alum_table').datatable({
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