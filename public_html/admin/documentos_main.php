<!DOCTYPE html>
<html><!-- InstanceBegin template="/Templates/admin.dwt" codeOutsideHTMLIsLocked="false" -->

<?php include ('head.php');?>
        
      <!-- Nuevos Css Js -->
	
      <!-- Fin -->
	</head> 
	<body class="general admin"> 
		<!-- InstanceBeginEditable name="EditRegion3" --><?php  $Menu=402;    ?><!-- InstanceEndEditable -->
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
					<script type="text/javascript" src="js/funciones_documento.js"></script> 
                    <div id="docu_main" >
						<?php include ('documentos_main_lista.php'); ?>
                    </div>
                        
					<div	class="modal fade" 
                            id="ModalDocuAdd" 
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
									</button>
									<h4 class="modal-title" id="myModalLabel">Nuevo Documento</h4>
								</div>
								<div id="modal_main" class="modal-body">
									<div id="div_docu_nuev"> 
										<form 
											id="frm_docu_add" 
											name="frm_docu_add" 
											method="post" 
											action="" 
											enctype="multipart/form-data">
											<table width="100%">
												<tr>
													<td>
														<label>
															Per&iacute;odo activo:
														</label>
													</td>
													<td>
														<label>
															<?php echo $_SESSION['peri_deta']; ?>
														</label>
														<input 
															type="hidden" 
															id="docu_peri_codi_nuev" 
															name="docu_peri_codi_nuev" 
															value="<?php echo $_SESSION['peri_codi']; ?>">
													</td>
												</tr>
												<tr>
													<td valign='top'>
														<label for="docu_descr_nuev">
															Descripci&oacute;n:
														</label>
													</td>
													<td>
														<textarea 
															id="docu_descr_nuev" 
															name="docu_descr_nuev" 
															maxlength='250'
															rows="4"
															placeholder="Ingrese descripci&oacute;n del documento..."
															style="width: 100%; margin-top: 5px;"></textarea>
													</td>
												</tr>
											</table>
											<div class="form_element">&nbsp;</div>   
										</form>
									</div>
								</div>
								<div class="modal-footer">
									<button 
										type="button" 
										class="btn btn-success" 
										onClick="load_ajax_docu('docu_main','script_docu.php', 'add', 
												document.getElementById('docu_descr_nuev').value,
												document.getElementById('docu_peri_codi_nuev').value,
												0,0,0);" 
											>Agregar </button>
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
                    <div 	class="modal fade" 
                            id="ModalDocuEdi" 
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
									</button>
									<h4 class="modal-title" id="myModalLabel">Editar Documento</h4>
								</div>
								<div id="modal_main" class="modal-body">
									<div id="div_docu_edi"> 
										<form 
											id="frm_docu_edi" 
											name="frm_docu_edi" 
											method="post" 
											action="" 
											enctype="multipart/form-data">
											<table width="100%">
												<tr>
													<td>
														<label>
															Per&iacute;odo activo:
														</label>
													</td>
													<td>
														<label>
															<?php echo $_SESSION['peri_deta']; ?>
														</label>
														<input 
															type="hidden" 
															id="docu_codi_edi" 
															name="docu_codi_edi" 
															value="">
													</td>
												</tr>
												<tr>
													<td valign='top'>
														<label for="docu_descr_edi">
															Descripci&oacute;n:
														</label>
													</td>
													<td>
														<textarea 
															id="docu_descr_edi" 
															name="docu_descr_edi" 
															maxlength='250'
															rows="4"
															placeholder="Ingrese descripci&oacute;n del documento..."
															style="width: 100%; margin-top: 5px;"></textarea>
													</td>
												</tr>
												</table>
											</form>
									</div>
									<div class="form_element">&nbsp;</div> 
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-success" 
											onClick="load_ajax_docu('docu_main','script_docu.php', 'upd', 
												document.getElementById('docu_descr_edi').value,
												0,
												document.getElementById('docu_codi_edi').value,
												0,0);" >Grabar</button>
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
                    
                     <?php while($row_peri_view = sqlsrv_fetch_array($peri_view)){ ?>
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
				$('#docu_table').datatable({
					pageSize: 10,
					sort: [true, false],
					filters: [true, false],
					filterText: 'Escriba para buscar... '
				}) ;
		} );

		</script>
       <!-- InstanceEndEditable -->
	</body>
<!-- InstanceEnd -->
</html>