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
					<script type="text/javascript" src="js/funciones_alumno_estado.js"></script> 
                    <div id="alum_est_main" >
						<?php include ('alumno_estado_main_lista.php'); ?>
                    </div>
                        
					<div	class="modal fade" 
                            id="ModalAlumEstAdd" 
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
									<h4 class="modal-title" id="myModalLabel">Nuevo Estado de Alumno</h4>
								</div>
								<div id="modal_main" class="modal-body">
									<div id="div_alum_est_nuev"> 
										<form 
											id="frm_alum_est_add" 
											name="frm_alum_est_add" 
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
															id="alum_est_peri_codi_nuev" 
															name="alum_est_peri_codi_nuev" 
															value="<?php echo $_SESSION['peri_codi']; ?>">
													</td>
												</tr>
												<tr>
													<td valign='top'>
														<label for="alum_est_det_nuev">
															Detalle del Estado:
														</label>
													</td>
													<td>
														<input 
															type='text'
															id="alum_est_det_nuev" 
															name="alum_est_det_nuev" 
															maxlength='100'
															placeholder="Ingrese nuevo Estado..."
															style="width: 100%; margin-top: 5px;">
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
										onClick="load_ajax_alum_est('alum_est_main','script_alum_est.php', 'add', 
												document.getElementById('alum_est_det_nuev').value,
												document.getElementById('alum_est_peri_codi_nuev').value,
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
                            id="ModalAlumEstEdi" 
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
									<h4 class="modal-title" id="myModalLabel">Editar Estado</h4>
								</div>
								<div id="modal_main" class="modal-body">
									<div id="div_alum_est_edi"> 
										<form 
											id="frm_alum_est_edi" 
											name="frm_alum_est_edi" 
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
															id="alum_est_codi_edi" 
															name="alum_est_codi_edi" 
															value="">
													</td>
												</tr>
												<tr>
													<td valign='top'>
														<label for="alum_est_det_edi">
															Detalle del Estado
														</label>
													</td>
													<td>
														<input 
															type='text'
															id="alum_est_det_edi" 
															name="alum_est_det_edi" 
															maxlength='100'
															placeholder="Ingrese detalle del Estado..."
															style="width: 100%; margin-top: 5px;">
													</td>
												</tr>
												</table>
											</form>
									</div>
									<div class="form_element">&nbsp;</div> 
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-success" 
											onClick="load_ajax_alum_est('alum_est_main','script_alum_est.php', 'upd', 
												document.getElementById('alum_est_det_edi').value,
												0,
												document.getElementById('alum_est_codi_edi').value,
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
				$('#alum_est_table').datatable({
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