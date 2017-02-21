<!DOCTYPE html>
<html><!-- InstanceBegin template="/Templates/admin.dwt" codeOutsideHTMLIsLocked="false" -->

<?php include ('head.php');?>
        
      <!-- Nuevos Css Js -->
	
      <!-- Fin -->
	</head> 
	<body class="general admin"> 
								<!-- InstanceBeginEditable name="EditRegion3" --><?php  $Menu=207;    ?><!-- InstanceEndEditable -->
		<div class="pageContainer"> 

		  <?php include ('menu.php');?>

			<div id="mainPanel" class="section_main">
            
        			<?php include ('header.php');?>
        
				<div class="main sectionBorder">
					<div id="information">
          
          <div class="titleBar">
          <!-- InstanceBeginEditable name="Titulo Top" --><div class="title"><h3><span class="icon-users icon"></span>Profesores</h3></div>
		  <div class="options">
          	<ul>
            	<?php if (permiso_activo(67)){?>
                <li>
                  <a class="button_text" onclick="document.getElementById('usua_nombre').focus();" data-toggle="modal" data-target="#ModalUsuaAdd" title="">
                    <span class="icon-add icon"></span> Agregar Profesor
                  </a>
                </li>
                <?php }?>
            </ul>
          </div>
		  
		  <!-- InstanceEndEditable -->
          </div>
          
                        <!-- InstanceBeginEditable name="information" -->
                        <script type="text/javascript" src="js/funciones_profe.js"></script> 
                        <div id="usua_main" >
                             <?php include ('profesores_main_lista.php'); ?>
                        </div>
                        
                        <div class="modal fade" id="ModalUsuaAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">Nuevo Profesor</h4>
                              </div>
                              <div id="modal_main" class="modal-body">
                                <div id="div_usua_nuev"> 
                                    <form id="frm_usua_add" name="frm_usua_add" method="post" action="" enctype="multipart/form-data">
                                    	<div class="form_element">
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%;" class="table">
                                            <tr>
                                                <td width="25%">
                                                	<label for="usua_nombre">
                                                    	C&eacute;dula: 
													</label>
												</td>
                                                <td width="75%">
													<input 
                                                    	type="text" 
                                                        id="usua_cedu" 
                                                        name="usua_cedu" 
                                                        value="" 
                                                        placeholder="Ingrese la c&eacute;dula..." 
                                                        style="width: 50%; margin-top: 5px;">
												</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                	<label for="usua_nombre">
                                                    	Nombres: 
													</label>
												</td>
                                                <td>
                                                	<input 
                                                    	type="text" 
                                                        id="usua_nombre" 
                                                        name="usua_nombre" 
                                                        value="" 
                                                        placeholder="Ingrese los nombres..." 
                                                        style="width: 100%; margin-top: 5px;">
												</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                	<label for="usua_apellido">
                                                    	Apellidos: 
													</label>
												</td>
                                                <td>
                                                	<input 
                                                    	type="text" 
                                                        id="usua_apellido" 
                                                        name="usua_apellido" 
                                                        value="" 
                                                        placeholder="Ingrese los apellidos..." 
                                                        style="width: 100%; margin-top: 5px;">
												</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                	<label for="usua_email">Email: </label>
												</td>
                                                <td>
                                                	<input 
                                                    	type="text" 
                                                        id="usua_email" 
                                                        name="usua_email" 
                                                        value="" 
                                                        placeholder="Ingrese el email..." 
                                                        style="width: 100%; margin-top: 5px;">
												</td>
                                            </tr>
                                            <tr>
                                                <td>
													<script>
                                                    function verif_usua_prof(text)
                                                    {
                                                        load_ajax_veri_usua_prof('div_veri_usua','script_profe.php','opc=veri_usua&usua_username='+text);
                                                    }
                                                    </script>
                                                    <label for="usua_email">
                                                    	Direcci&oacute;n: 
													</label>
												</td>
                                                <td>
                                                	<input 
                                                    	type="text" 
                                                        id="usua_dire" 
                                                        name="usua_dire" 
                                                        value="" 
                                                        placeholder="Ingrese el direcci&oacute;n..." 
                                                        style="width: 100%; margin-top: 5px;">
												</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                	<label for="usua_email">
                                                    	Tel&eacute;fono: 
													</label>
												</td>
                                                <td>
                                                	<input 
                                                    	type="text" 
                                                        id="usua_telf" 
                                                        name="usua_telf" 
                                                        value="" 
                                                        placeholder="Ingrese el tel&eacute;no..." 
                                                        style="width: 50%; margin-top: 5px;">
												</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                	<label for="usua_username">
                                                    	Username: 
													</label>
												</td>
                                                <td>
                                                	<input 
                                                    	type="text" 
                                                        id="usua_username" 
                                                        name="usua_username" 
                                                        value="" 
                                                        placeholder="Ingrese el username..." 
                                                        onkeyup="verif_usua_prof(this.value)" 
                                                        style="width: 50%; margin-top: 5px;">
                                                	<input 
                                                    	type="hidden" 
                                                        id="usua_veri_username" 
                                                        name="usua_veri_username" 
                                                        value="">
                                                        <div id="div_veri_usua" style="float: right; width: 50%;">
                                                        </div>
												</td>
                                            </tr>
                                        </table>   
                                        </div>
                                        <div class="form_element">&nbsp;</div>                                     
                                    </form>
                                </div>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-success" onClick="load_ajax_add_prof('usua_main','script_profe.php','opc=add&usua_nombre='+document.getElementById('usua_nombre').value+'&usua_apellido='+document.getElementById('usua_apellido').value+'&usua_email='+document.getElementById('usua_email').value+'&usua_username='+document.getElementById('usua_username').value+'&usua_dire='+document.getElementById('usua_dire').value+'&usua_telf='+document.getElementById('usua_telf').value+'&usua_cedu='+document.getElementById('usua_cedu').value);" >Agregar</button>
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
                                <h4 class="modal-title" id="myModalLabel">Editar Profesor</h4>
                              </div>
                              <div id="modal_main" class="modal-body">
                                <div id="div_usua_edi"> 
                                    <form id="frm_usua_edi" name="frm_usua_edi" method="post" action="" enctype="multipart/form-data">
                                    	<div class="form_element">
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%;" class="table">
                                        <tr>
                                            <td width="25%">
                                            	<label for="usua_nombre_edi">
                                                	C&eacute;dula: 
												</label>
											</td>
                                            <td width="75%">
                                            	<input 
                                                	type="text" 
                                                    id="usua_cedu_edi" 
                                                    name="usua_cedu_edi" 
                                                    value="" 
                                                    placeholder="Ingrese la c&eacute;dula..."
                                                    style="width: 50%; margin-top: 5px;">
											</td>
                                        </tr>
                                        <tr>
                                            <td>
                                            	<label for="usua_nombre_edi">
                                                	Nombres: 
                                            	</label>
                                            </td>
                                            <td>
                                            	<input 
                                                	type="text" 
                                                    id="usua_nombre_edi"
                                                    name="usua_nombre_edi" 
                                                    value="" 
                                                    placeholder="Ingrese los nombres..."
                                                    style="width: 100%; margin-top: 5px;">
											</td>
                                        </tr>
                                        <tr>
                                            <td>
                                            	<label for="usua_apellido_edi">
                                                	Apellidos: 
												</label>
											</td>
                                            <td>
                                            	<input 
                                                	type="text" 
                                                    id="usua_apellido_edi" 
                                                    name="usua_apellido_edi" 
                                                    value="" 
                                                    placeholder="Ingrese los apellidos..."
                                                    style="width: 100%; margin-top: 5px;">
											</td>
                                        </tr>
                                        <tr>
                                            <td>
                                            	<label for="usua_email_edi">
                                                	Email: 
												</label>
											</td>
                                            <td>
                                            	<input 
                                                	type="text" 
                                                    id="usua_email_edi" 
                                                    name="usua_email_edi" 
                                                    value="" 
                                                    placeholder="Ingrese el email..."
                                                    style="width: 100%; margin-top: 5px;">
											</td>
                                        </tr>
                                        <tr>
                                            <td>
                                            	<label for="usua_email">
                                                	Direcci&oacute;n: 
                                            	</label>
                                            </td>
                                            <td>
                                            	<input 
                                                	type="text" 
                                                    id="usua_dire_edi" 
                                                    name="usua_dire_edi" 
                                                    value="" 
                                                    placeholder="Ingrese el direcci&oacute;n..."
                                                    style="width: 100%; margin-top: 5px;">
											</td>
                                        </tr>
                                        <tr>
                                            <td>
                                            	<label for="usua_telf_edi">
                                                	Tel&eacute;fono: 
												</label>
											</td>
                                            <td>
                                            	<input 
                                                	type="text" 
                                                    id="usua_telf_edi" 
                                                    name="usua_telf_edi" 
                                                    value="" 
                                                    placeholder="Ingrese el tel&eacute;fono..."
                                                    style="width: 50%; margin-top: 5px;">
											</td>
                                        </tr>
                                        <tr>
                                            <td>
                                            	<label for="usua_username_edi">
                                                	Username: 
												</label>
											</td>
                                            <td>
                                            	<input 
                                                	type="text" 
                                                    id="usua_username_edi" 
                                                    name="usua_username_edi" 
                                                    disabled="disabled" 
                                                    value="" 
                                                    placeholder="Ingrese el username..."
                                                    style="width: 50%; margin-top: 5px;">
                                                <input 
                                                	type="hidden" 
                                                    id="usua_veri_username_edi" 
                                                    name="usua_veri_username_edi" 
                                                    value="">
                                                <input 
                                                	type="hidden" 
                                                    id="usua_codi_edi" 
                                                    name="usua_codi_edi" 
                                                    value="">
											</td>
                                        </tr>
                                        </table>  
                                        </div>
                                        <div class="form_element">&nbsp;</div>                
                                    </form>
                                </div>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-success" onClick="load_ajax_edi_prof('usua_main','script_profe.php','opc=upd&usua_nombre='+document.getElementById('usua_nombre_edi').value+'&usua_apellido='+document.getElementById('usua_apellido_edi').value+'&usua_email='+document.getElementById('usua_email_edi').value+'&usua_username='+document.getElementById('usua_username_edi').value+'&usua_dire='+document.getElementById('usua_dire_edi').value+'&usua_telf='+document.getElementById('usua_telf_edi').value+'&usua_cedu='+document.getElementById('usua_cedu_edi').value+'&prof_codi='+document.getElementById('usua_codi_edi').value);" >Grabar</button>
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
			sort: [true, false, false],
			filters: [true, false, false],
			filterText: 'Escriba para buscar... '
		}) ;
} );

</script>
       <!-- InstanceEndEditable -->
</body>
<!-- InstanceEnd --></html>