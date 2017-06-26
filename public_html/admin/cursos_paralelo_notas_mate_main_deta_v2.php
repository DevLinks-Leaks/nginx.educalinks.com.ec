<!DOCTYPE html>
<html><!-- InstanceBegin template="/Templates/admin.dwt" codeOutsideHTMLIsLocked="false" -->

<?php include ('head.php');?>
        
      <!-- Nuevos Css Js -->
	
      <!-- Fin -->
	</head> 
	<body class="general admin"> 
								<!-- InstanceBeginEditable name="EditRegion3" --><?php  $Menu=201;    ?><!-- InstanceEndEditable -->
		<div class="pageContainer"> 

		  <?php include ('menu.php');?>

			<div id="mainPanel" class="section_main">
            
        			<?php include ('header.php');?>
        
				<div class="main sectionBorder">
					<div id="information">
          
          <div class="titleBar">
          <!-- InstanceBeginEditable name="Titulo Top" -->
			<?php 	
				if(isset($_GET['curs_para_mate_codi'])){
					 $curs_para_mate_codi=$_GET['curs_para_mate_codi'];
				}
				
				$PERI_CODI = $_SESSION['peri_codi']; 	 
				$params = array($curs_para_mate_codi);
				$sql="{call curs_peri_mate_info(?)}";
				$curs_peri_mate_info = sqlsrv_query($conn, $sql, $params);
				$row_curs_peri_mate_info = sqlsrv_fetch_array($curs_peri_mate_info);
				$curs_para_codi = $row_curs_peri_mate_info["curs_para_codi"];
				
				/*codigo q estaba en el deta*/
				if (isset($_POST['peri_dist_codi'])){$peri_dist_codi=$_POST['peri_dist_codi'];}else{if (isset($_GET['peri_dist_codi'])){$peri_dist_codi=$_GET['peri_dist_codi'];}}
		
				if (isset($_POST['curs_para_mate_codi'])){$curs_para_mate_codi=$_POST['curs_para_mate_codi'];}else{if (isset($_GET['curs_para_mate_codi'])){$curs_para_mate_codi=$_GET['curs_para_mate_codi'];}}

			 ?>
			<div class="title" style="width: 100%;">
            	<h3><span class="icon-books icon"></span> <?= $row_curs_peri_mate_info['curs_deta'];?> - <?= $row_curs_peri_mate_info['para_deta'];?> - <?= $row_curs_peri_mate_info['mate_deta'];?></h3>
                
               </div>        
          <!-- InstanceEndEditable -->
          </div>
          
                        <!-- InstanceBeginEditable name="information" -->
						
                          <script src="js/funciones_notas_secretaria.js"></script>
                          <div  id="notas_view">
						  <table class="table_striped">
							<thead>
								<tr>
									<th width="10%">CODALUM</th>
									<th width="30%">APELLIDOS</th>
									<th width="30%">NOMBRES</th>
									<th width="30%"></th>
								</tr>
							</thead>
							<tbody>
                            <?php 	
							$params = array($curs_para_mate_codi);
							$sql="{call curs_para_mate_info_NEW(?)}";
							$curs_para_mate_info = sqlsrv_query( $conn, $sql, $params );
							$row_curs_para_mate_info = sqlsrv_fetch_array( $curs_para_mate_info );
							
							$params	= array($curs_para_mate_codi);
							$sql	= "{call alum_curs_para_mate_view (?)}";
							$stmt	= sqlsrv_query($conn,$sql,$params);
							while ($row = sqlsrv_fetch_array($stmt))
							{
							?>
							<tr>
								<td><?=$row["alum_codi"]?></td>
								<td><?=$row["alum_apel"]?></td>
								<td><?=$row["alum_nomb"]?></td>
								<td>
									<div class="menu_options">
										<ul>
											<li>
												<a 
													class="option" 
													onclick="IniciarForm('<?= $row["alum_apel"]." ".$row["alum_nomb"]?>',<?=$row["alum_curs_para_mate_codi"]?>,<?=$row["alum_codi"]?>);" 
													data-toggle="modal" 
													data-target="#ModalIngresarNotas">
													<span class="icon-pencil2 icon"></span> Modificar Notas
												</a>
											</li>
										</ul>
									</div>
								</td>
							</tr>
							<?
							}
							?>
							</tbody>
							</table>
							<script type="text/javascript">
								$(document).ready(function() {
								$("input.cls_validar").keydown(function (e) {
									// Allow: backspace, delete, tab, escape, enter and .
									if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
										 // Allow: Ctrl+A
										(e.keyCode == 65 && e.ctrlKey === true) || 
										 // Allow: home, end, left, right
										(e.keyCode >= 35 && e.keyCode <= 39)) {
											 // let it happen, don't do anything
											 return;
									}
									// Ensure that it is a number and stop the keypress
									if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) 
									{
										e.preventDefault();
									}		
								});
							 });
							</script>
                          </div>
                         <!--Inicio modal eliminar notas curso paralelo-->
                        <div class="modal fade" id="ModalIngresarNotas" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                          <div class="modal-dialog <?=($_SESSION['directorio']=='liceonaval'? 'modal-lg' : '' );?>">
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Modificación/Ingreso de notas</h4>
                              </div>
                              <div id="modal_main" class="modal-body">
                                <div id="div_cupo_edi"> 
                                    <div class="form_element">
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%;" class="table">
										<tr>
                                            <td width="25%" style="padding-top: 5px;font-weight: bold;">
												Alumno:
                                            </td>
                                            <td style="padding-top: 5px;">
												<input type="hidden" id="alum_curs_para_mate_codi_in" name="alum_curs_para_mate_codi_in" />
												<input type="hidden" id="alum_codi" name="alum_codi" />
												<div id="alum_nombres">
												</div>
                                            </td>
                                        </tr>
										<tr>
                                            <td width="25%" style="padding-top: 5px;font-weight: bold;">
												Curso:
                                            </td>
                                            <td style="padding-top: 15px;">
												<?= $row_curs_peri_mate_info['curs_deta']." (".$row_curs_peri_mate_info['para_deta'].")";?>
                                            </td>
                                        </tr>
										<tr>
                                            <td width="25%" style="padding-top: 5px;font-weight: bold;">
												Asignatura:
                                            </td>
                                            <td style="padding-top: 15px;">
												<?= $row_curs_peri_mate_info['mate_deta'];?>
                                            </td>
										</tr>
										<tr>
                                            <td width="25%" style="padding-top: 5px;font-weight: bold;">
												Tipo calificación:
                                            </td>
                                            <td style="padding-top: 15px;">
												<? 
												switch ($row_curs_peri_mate_info['nota_refe_cab_tipo'])
												{	case 'C':
														echo 'Numérica';
													break;
													case 'D':
														echo 'Cualitativa de Comportamiento';
													break;
													case 'P':
														echo 'Cualitativa de Proyectos';
													break;
													case 'I':
														echo 'Cualitativa de cursos de inicial';
													break;
													case 'IP':
														echo 'Cualitativa Proyectos Inicial';
													break;
													default:
														echo 'No tiene asignada un tipo';
													break;
												}
												?>
												<input id="nota_refe_cab_tipo" type="hidden" value="<?=$row_curs_peri_mate_info['nota_refe_cab_tipo']?>" />
												<input id="nota_refe_cab_codi" type="hidden" value="<?=$row_curs_peri_mate_info['nota_refe_cab_cod']?>" />
												<input id="mate_padr" type="hidden" value="<?=$row_curs_peri_mate_info['mate_padr']?>" />
                                            </td>
										</tr>
                                        <tr>
                                            <td width="25%" style="padding-top: 5px;font-weight: bold;">
												Unidad/Parcial:
                                            </td>
                                            <td style="padding-top: 10px;">
											<? 	
											$peri_dist_nive=2;
											$params = array($curs_para_codi,$peri_dist_nive);
											$sql="{call peri_dist_peri_nive_view_NEW(?,?)}"; 
											$peri_dist_peri_nive_view = sqlsrv_query($conn, $sql, $params);  
											?>
												<select id="sl_peri_dist_codi" style="width: 75%;" onchange="consNotas();">
													<option value="0">Elija</option>
													<? while($row_peri_dist_peri_nive_view = sqlsrv_fetch_array($peri_dist_peri_nive_view))
													{ ?>
													<option value="<?= $row_peri_dist_peri_nive_view['peri_dist_codi'];?>">
													<?= (($row_peri_dist_peri_nive_view['peri_dist_padr_deta']=='')
														?$row_peri_dist_peri_nive_view['padre']:
														$row_peri_dist_peri_nive_view['peri_dist_padr_deta'].' - ').
														$row_peri_dist_peri_nive_view['peri_dist_deta']; 
													?>
													</option>
													<?php 	 
													} 
													?>
												</select> 
                                            </td>
                                        </tr>
										<tr>
											<td colspan="2" style="padding-top: 10px;">
												<div id="alum_notas_ing" class="form_element">
												</div>
											</td>
										</tr>
                                    </table>  
                                    </div>
                                    <div class="form_element">&nbsp;</div>                
                                </div>
                              </div>
                              <div class="modal-footer">
								<button 
                                    type="button" 
                                    class="btn btn-info" 
                                    onClick="ValidarImprimir()">
									<span class="icon-print icon"></span>
                                    Imprimir
                                </button>
                                <button 
                                    type="button" 
                                    class="btn btn-success" 
                                    onClick="saveNotas('<?= $row_curs_peri_mate_info['curs_deta'];?>','<?= $row_curs_peri_mate_info['para_deta'];?>','<?= $row_curs_peri_mate_info['mate_deta'];?>')">
									<span class="icon-disk icon"></span>
                                    Guardar
                                </button>
                                <button 
                                    type="button" 
                                    class="btn btn-default" 
                                    data-dismiss="modal">
									<span class="icon-close icon"></span>
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
<script type="text/javascript" language="javascript">
function ejecutar_submit(frm){
	document.getElementById(frm).submit();
}
function ValidarImprimir()
{	if (document.getElementById('sl_peri_dist_codi').value==0)
	{	alert ('Escoja un periodo a consultar'); 
	}
	else
	{	window.open('reportes_generales/notas_ingresadas_pdf.php?peri_dist_codi=' + selectvalue(document.getElementById('sl_peri_dist_codi')) +'&curs_para_mate_codi=<?=$row_curs_peri_mate_info['curs_para_mate_codi']?>')
	}
}
</script><!-- InstanceEndEditable -->
</body>
<!-- InstanceEnd --></html>