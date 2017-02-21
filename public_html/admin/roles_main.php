<!DOCTYPE html>
<html><!-- InstanceBegin template="/Templates/admin.dwt" codeOutsideHTMLIsLocked="false" -->

<?php include ('head.php');?>
        
      <!-- Nuevos Css Js -->
	
      <!-- Fin -->
	</head> 
	<body class="general admin"> 
								<!-- InstanceBeginEditable name="EditRegion3" --><?php  $Menu=401;    ?><!-- InstanceEndEditable -->
		<div class="pageContainer"> 

		  <?php include ('menu.php');?>

			<div id="mainPanel" class="section_main">
            
        			<?php include ('header.php');?>
        
				<div class="main sectionBorder">
					<div id="information">
          
          <div class="titleBar">
          <!-- InstanceBeginEditable name="Titulo Top" --><div class="title"><h3><span class="icon-user icon"></span>Roles de Usuario</h3></div>
			<div class="options">
						<ul>
						<?php if (permiso_activo(46)){?>
							<li>
									<a class="button_text" onclick="document.getElementById('rol_deta').focus();" data-toggle="modal" data-target="#ModalRolAdd" title="">
										<span class="icon-add icon"></span> Agregar Rol
									</a>
								</li>
								<?php }?>
						</ul>
					</div>
					
					<!-- InstanceEndEditable -->
          </div>
          
                        <!-- InstanceBeginEditable name="information" -->
												<script type="text/javascript" src="js/funciones_usua.js"></script> 
												
													<div id="rol_main">
																<?php 
										
										include ('roles_main_lista.php'); 
									?>
															</div>
												
												
												<div class="modal fade" id="ModalRolAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
													<div class="modal-dialog">
														<div class="modal-content">
															<div class="modal-header">
																<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
																<h4 class="modal-title" id="myModalLabel">Nuevo Rol</h4>
															</div>
															<div id="modal_main" class="modal-body">
																<div id="div_rol_nuev"> 
																		<form 
																			id="frm_rol_add" 
																				name="frm_rol_add" 
																				method="post" 
																				action="" 
																				enctype="multipart/form-data">
																			<table style="width: 100%">
																					<tr>
																						<td width="25%">
																							<label for="rol_deta">
																											Descripci&oacute;n: 
																						 </label>
																						</td>
																						<td>
																							<input 
																										type="text" 
																											id="rol_deta" 
																											name="rol_deta" 
																											value="" 
																											placeholder="Ingrese la descripci&oacute;n..."
																											style="width: 100%; margin-top: 5px;">
																							 <input 
																										type="hidden" 
																											id="rol_estado" 
																											name="rol_estado" 
																											value="A">
																						</td>
																					</tr>
																					<tr>
																						<td>
																							<label>
																								Acceso a financiero:
																							</label>
																						</td>
																						<td>
																							<input
																								id="rol_finan"
																								type="checkbox"
																								style="margin-top: 10px;">
																						</td>
																					</tr>
																				</table>
																		</form>
																</div>
																<div class="form_element">&nbsp;</div>
															</div>
															<div class="modal-footer">
																<button type="button" class="btn btn-success" onClick="load_ajax_add_rol('rol_main','script_usua.php','opc=add_rol&rol_deta='+document.getElementById('rol_deta').value+'&rol_estado='+document.getElementById('rol_estado').value+'&rol_finan='+document.getElementById('rol_finan').checked);" >Agregar</button>
																<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
															</div>
														</div>
													</div>
												</div>
												
												<div class="modal fade" id="ModalRolEdi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
													<div class="modal-dialog">
														<div class="modal-content">
															<div class="modal-header">
																<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
																<h4 class="modal-title" id="myModalLabel">Editar Rol</h4>
															</div>
															<div id="modal_main" class="modal-body">
																<div id="div_rol_edi"> 
																		<form id="frm_rol_edi" name="frm_rol_edi" method="post" action="" enctype="multipart/form-data">
																			<table style="width: 100%">
																					<tr>
																						<td width="25%">
																							<label for="rol_deta_edi">
																								Descripci&oacute;n: 
																							</label>
																						</td>
																						<td>
																							<input 
																								type="text" 
																								id="rol_deta_edi" 
																								name="rol_deta_edi" 
																								value="" 
																								placeholder="Ingrese la descripci&oacute;n..."
																								style="width: 100%; margin-top: 5px;">

																							 <input 
																								type="hidden" 
																								id="rol_codi_edi" 
																								name="rol_codi_edi" 
																								value="">
																						</td>
																					</tr>
																					<tr>
																						<td>
																							<label>
																								Acceso a financiero:
																							</label>
																						</td>
																						<td>
																							<input
																								id="rol_finan_edi"
																								type="checkbox"
																								style="margin-top: 10px;">
																						</td>
																					</tr>
																				</table>
																		</form>
																</div>
																<div class="form_element">&nbsp;</div>
															</div>
															<div class="modal-footer">
																<button type="button" class="btn btn-success" onClick="load_ajax_edi_rol('rol_main','script_usua.php','opc=upd_rol&rol_deta='+document.getElementById('rol_deta_edi').value+'&rol_codi='+document.getElementById('rol_codi_edi').value+'&rol_finan='+document.getElementById('rol_finan_edi').checked);" >Grabar</button>
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
			$('#rol_table').datatable({
			pageSize: 10,
			sort: [true, false],
			filters: [true, false],
			filterText: 'Buscar... '
		}) ;
} );
</script>
			 <!-- InstanceEndEditable -->
</body>
<!-- InstanceEnd --></html>