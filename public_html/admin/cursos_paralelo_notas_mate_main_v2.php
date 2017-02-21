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
				   
				   
						include ('../framework/dbconf.php');
						session_start();
						  
						  
						if(isset($_GET['curs_para_codi'])){
							 $curs_para_codi=$_GET['curs_para_codi'];
						}
						
						$PERI_CODI = $_SESSION['peri_codi'];
						
			 	 
				$params = array($curs_para_codi);
				$sql="{call curs_peri_info(?)}";
				$curs_peri_info = sqlsrv_query($conn, $sql, $params);
				$row_curs_peri_info = sqlsrv_fetch_array($curs_peri_info);
				
				  
			 ?>
		  		
            	
           
                    

			<div class="title">
				<h3>
					<span class="icon-books icon"></span>Curso: <?= $row_curs_peri_info['curs_deta'];?> (<?= $row_curs_peri_info['para_deta'];?>)
				</h3>
			   </div>
     
     
 
          <!-- InstanceEndEditable -->
          </div>
          
                        <!-- InstanceBeginEditable name="information" -->
                        <div>
						<?php 
						$peri_codi= $_GET['peri_codi'];
						$params = array($curs_para_codi);
						$sql="{call curs_peri_mate_view(?)}";
						$curs_peri_mate_view = sqlsrv_query($conn, $sql, $params);  
						$cc = 0;
						?>
						<table class=" table_striped " >
							<thead>
								<tr>
									<th>#</th>             
									<th> Materias</th>
									<th>Aula</th>
									<th>Profesores</th>
									<th>&nbsp;</th>              
								</tr>
							</thead>
							<tbody>
						<?php  
						while ($row_curs_peri_mate_view = sqlsrv_fetch_array($curs_peri_mate_view)) 
						{ 	$cc +=1; 
						?> 
								<tr>
									<td class="center">
										<?= $cc; ?>
									</td>
									<td>
										<?php echo $row_curs_peri_mate_view["mate_deta"];?>
									</td>
									<td>
										<?php 
											if  ($row_curs_peri_mate_view["mate_hijo_cc"] == 0)
											{ 
										?> 
										<?php 
											echo $row_curs_peri_mate_view["aula_deta"]; 
										?>
										<?php 
											}
										?>
									</td>
									<?php
										$file_exi=$_SESSION['ruta_foto_docente'].$row_curs_peri_mate_view["prof_codi"] . '.jpg';
										if (file_exists($file_exi)) 
										{	$pp=$file_exi;
										} 
										else 
										{	$pp=$_SESSION['ruta_foto_docente'].'0.jpg';
										}
									?>
									<td>
										<?php 
										if  ($row_curs_peri_mate_view["prof_codi"] <> '')
										{ 
										?> 
										<img 
											src="<?php echo $pp; ?>" 
											width="58" 
											height="59"  
											style=" text-align:right; border:none; width:30px; height:30px;"/>
											<?php echo $row_curs_peri_mate_view["prof_nomb"]; ?> 
										<?php 
										}
										?>
									</td>
									<td>
										<div class="menu_options">
											<ul>
												<?php 
												$url="window.location='cursos_paralelo_notas_mate_main_deta_v2.php?&curs_para_mate_codi=".$row_curs_peri_mate_view["curs_para_mate_codi"]."'";
												if ($row_curs_peri_mate_view["mate_hijo_cc"] == 0)
												{ 	if (permiso_activo(210))
													{
											?>
											<ul> 
												<li>
													<a class="option" onclick="<?= $url; ?>"> 
														<span class="icon-stats icon"></span>Editar
													</a>
												</li>
										<?php 
													}
												}
										?>
											</ul>
										</div>
									</td>
								</tr>
							<?php 
							}
							?>
							</tbody>
						</table>
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
<!-- InstanceEndEditable -->
</body>
<!-- InstanceEnd --></html>