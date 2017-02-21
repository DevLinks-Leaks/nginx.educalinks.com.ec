<!DOCTYPE html>
<html><!-- InstanceBegin template="/Templates/admin.dwt" codeOutsideHTMLIsLocked="false" -->

<?php include ('head.php');?>
        
      <!-- Nuevos Css Js -->
	
      <!-- Fin -->
	</head> 
	<body class="general admin"> 
								<!-- InstanceBeginEditable name="EditRegion3" --><?php  $Menu=102;    ?><!-- InstanceEndEditable -->
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
					<span class="icon-lock icon"></span>
					Motivos de bloqueo
				</h3>
			</div>
			<div class="options">
				<ul>
					<?php if (permiso_activo(516)){?>
					<li>
					  <a 
						class="button_text" 
						data-toggle="modal" 
						data-target="#ModalMotiAdd" 
						title="">
							<span class="icon-add icon"></span> 
							Agregar Motivo
					  </a>
					</li>
					<?php }?>
				</ul>
			</div>
		  <!-- InstanceEndEditable -->
          </div>
          
                        <!-- InstanceBeginEditable name="information" -->
					<script type="text/javascript" src="js/funciones_motivo_bloqueo.js"></script> 
                    <div id="moti_main" >
						<?php include ('motivo_bloqueo_main_lista.php'); ?>
                    </div>
                        
					<div class="modal fade" 
						 id="ModalMotiAdd" 
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
									<h4 class="modal-title" id="myModalLabel">Nuevo motivo</h4>
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
													<td width="25%">
														Motivo
													</td>
													<td style="margin-top:5px">
														<input id="txt_motivo" type="text" style="width: 90%" value="" />
													</td>
												</tr>
												<tr>
													<td width="25%">
														Bloqueo obligatorio
													</td>
													<td style="margin-top:5px">
														<input id="check_obligatorio" type="checkbox" style="margin-top: 10px" checked />
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
										data-dismiss="modal"
										onClick="load_ajax_moti('moti_main','script_moti_bloq.php','add',0);" 
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
					
					<div class="modal fade" 
						 id="ModalMotiEdi" 
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
									<h4 class="modal-title" id="myModalLabel">Editar motivo</h4>
								</div>
								<div id="modal_main" class="modal-body">
									<div id="div_docu_nuev"> 
										<form 
											id="frm_moti_edit" 
											name="frm_moti_edit" 
											method="post" 
											action="" 
											enctype="multipart/form-data">
											<table width="100%">
												<tr>
													<td width="20%">
														Motivo
													</td>
													<td style="margin-top:5px">
														<input id="txt_moti_bloq_deta" type="text" style="width: 90%" value="" />
														<input id="txt_moti_bloq_codi" type="hidden" value="" />
													</td>
												</tr>
												<tr>
													<td width="25%">
														Bloqueo obligatorio
													</td>
													<td style="margin-top:5px">
														<input id="check_moti_bloq_obli" type="checkbox" style="margin-top: 10px"/>
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
										data-dismiss="modal"
										onClick="load_ajax_moti('moti_main','script_moti_bloq.php','upd',document.getElementById('txt_moti_bloq_codi').value);" 
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
				$('#moti_table').datatable({
					pageSize: 10,
					sort: [true,true,false],
					filters: [true,false,false],
					filterText: 'Escriba para buscar... '
				}) ;
		} );

		</script>
       <!-- InstanceEndEditable -->
</body>
<!-- InstanceEnd --></html>