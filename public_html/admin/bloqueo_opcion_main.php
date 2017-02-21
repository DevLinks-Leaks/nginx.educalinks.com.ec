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
			<div class="title">
				<h3>
					<span class="icon-users icon"></span>
					Bloqueo de opciones
				</h3>
			</div>
			<div class="options">
				<ul>
					<?php if (permiso_activo(49)){?>
					<li>
					  <a 
						class="button_text" 
						data-toggle="modal" 
						data-target="#ModalBloqAdd" 
						title="">
							<span class="icon-add icon"></span> 
							Agregar Bloqueo
					  </a>
					</li>
					<?php }?>
				</ul>
			</div>
		  <!-- InstanceEndEditable -->
          </div>
          
                        <!-- InstanceBeginEditable name="information" -->
					<script type="text/javascript" src="js/funciones_bloqueo.js"></script> 
                    <div id="bloq_main" >
						<?php include ('bloqueo_opcion_main_lista.php'); ?>
                    </div>
                        
					<div	class="modal fade" 
                            id="ModalBloqAdd" 
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
									<h4 class="modal-title" id="myModalLabel">Bloqueo</h4>
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
													<td width="30%">
														Motivo
													</td>
													<td style="margin-top:5px">
														<select id="cmb_motivos" style="width: 75%">
														<?
														$sql	= "{call moti_bloq_all()}";
														$params	= array();
														$stmt	= sqlsrv_query($conn,$sql,$params);
														if ($stmt === false)
														{	die(print_r(sqlsrv_errors(),true));
														}
														while ($row = sqlsrv_fetch_array($stmt))
														{	echo "<option value='".$row["moti_bloq_codi"]."'>".$row["moti_bloq_deta"]."</option>";
														}
														?>
														</select>
													</td>
												</tr>
												<tr>
													<td width="30%">
														Opción a bloquear
													</td>
													<td style="padding-top:5px">
														<select id="cmb_opciones" style="width: 75%">
														<?
														$sql	= "{call opci_all()}";
														$params	= array();
														$stmt	= sqlsrv_query($conn,$sql,$params);
														if ($stmt === false)
														{	die(print_r(sqlsrv_errors(),true));
														}
														while ($row = sqlsrv_fetch_array($stmt))
														{	echo "<option value='".$row["opci_codi"]."'>".$row["opci_deta"]."</option>";
														}
														?>
														</select>
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
										onClick="load_ajax_bloq('bloq_main','script_bloq.php','add',0);" 
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
				$('#bloq_table').datatable({
					pageSize: 10,
					sort: [true,true,false],
					filters: ['select','select',false],
					filterText: 'Escriba para buscar... '
				}) ;
		} );

		</script>
       <!-- InstanceEndEditable -->
</body>
<!-- InstanceEnd --></html>