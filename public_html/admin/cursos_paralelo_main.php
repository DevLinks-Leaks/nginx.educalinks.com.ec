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
              ?> 
          	<div class="title">
            	<h3><span class="icon-books icon"></span>Cursos Paralelos</h3>
            </div>
                
            <div class="options" style="display: block; float: left; width: 100%; height: 50px;">

              <ul style="display: block; float: left;">
                <?php if (permiso_activo(36)){?>
                <li>
                  <a class="button_text"  id="bt_curs_add" onclick="document.getElementById('curs_deta').value='';" data-toggle="modal" data-target="#curs_nuev" title="">
                    <span class="icon-add icon"></span> Nuevo Curso
                  </a>
                </li>
                <?php }?>
                <li>
                  <a class="button_text"  id="bt_curs_add"  href="cursos_paralelo_nomina_distrito_main_view_xls.php?peri_codi=<?= $_SESSION['peri_codi']; ?>" >
                    <span style='color:#22ae73;' class="icon-file-excel"></span> Nómina Matr. General
                  </a>
                </li>
                <li>
                  <a class="button_text"  id="bt_curs_add"  href="cursos_paralelo_nomina_totales_distrito_main_view_xls.php?peri_codi=<?= $_SESSION['peri_codi']; ?>" >
                    <span style='color:#22ae73;' class="icon-file-excel"></span> Nómina Matr. Resumen
                  </a>
                </li>
                 <!--<li>
                  <a class="button_text"  id="bt_curs_add"  href="cursos_paralelo_listas_main_view.php?peri_codi=<?= $_SESSION['peri_codi']; ?>" >
                    <span class="icon-print"></span> Lista General
                  </a>
                </li>-->
                <li>
                  <a class="button_text"  id="bt_curs_add"  href="listado_alumnos_all_xls.php" >
                    <span style='color:#22ae73;' class="icon-file-excel"></span> Lista Matriculados
                  </a>
                </li>
				<li>
                  <a class="button_text"  id="bt_curs_add"  href="listado_all_xls.php" title='Todos los alumnos con estado respectivo'>
                    <span style='color:#22ae73;' class="icon-file-excel"></span> Lista General
                  </a>
                </li>
                <li>
                  <a 
                  	class="button_text"
                    onclick=""
                    data-toggle="modal"
                    data-target="#ModalExcelencia"
                    title="">
                    	<span style='color:#d5b62e;' class="icon-star icon"></span> Excelencia Acad.
                  </a>
                </li>
              </ul>
            </div>
		  
		  <!-- InstanceEndEditable -->
          </div>
          
                        <!-- InstanceBeginEditable name="information" -->
            <div 
            	style="text-align:right; 
                width:97%; 
                margin:10px;  
                margin-top:30px;">
            </div>
            <div id="curs_para_main">
            	<?php 
					include ('cursos_paralelo_main_lista.php'); 
				?>
            </div>
            <script src="js/funciones_curs.js"></script>
            <script src="js/funciones_notas.js"></script>
            
                       <!--Inicio modal agregar curso paralelo-->
            <div 
            	class="modal fade" 
                id="curs_nuev" 
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
            		<h4 class="modal-title" id="myModalLabel">
                    	Nuevo curso paralelo
                    </h4>
            	</div>
            <div id="modal_main" class="modal-body">
            <div id="div_usua_edi"> 
            	<form 
                	id="frm_usua_edi" 
                    name="frm_usua_edi" 
                    method="post" 
                    action="" 
                    enctype="multipart/form-data">
            	<div class="form_element">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    	<tr>
                            <td width="25%" style="padding-top: 15px;">
                                <label>Periodo Distribución: </label>
                            </td>
                            <td style="padding-top: 15px;">
                            <? 	
                                $peri_codi=$_SESSION['peri_codi'];
                                $params = array($peri_codi);
                                $sql="{call dist_peri_cab_view(?)}";
                                $dist_peri_cab_view = sqlsrv_query($conn, $sql, $params);  
                            ?>
                            <select 
                            	id="sl_peri_dist_cabe_codi" 
                                style="width: 75%; background-color:#CDF8F6;" 
                                onchange="CargarModelos(this.value,document.getElementById('nota_refe_cab_codi').value);">
                            <? 
                            while($row_dist_peri_cab_view = sqlsrv_fetch_array($dist_peri_cab_view))
                            { 
                            ?>
                              <option 
                                value="<?= $row_dist_peri_cab_view['peri_dist_cab_codi'];?>">
                                        <?= 
                                            $row_dist_peri_cab_view['peri_dist_cab_deta'];
                                        ?>
                              </option>
                            <?php
                            }
                            ?>
                            </select> 
                            </td>
                        </tr>
                        <tr>
                            <td width="25%">
                            	Curso: 
							</td>
                            <td width="75%">
								<?php  
                                $params = array();
                                $sql="{call curs_view()}";
                                $curs_view = sqlsrv_query($conn, $sql, $params);  
                                ?> 
                            	<select 
                                	name="curs_codi" 
                                    id="curs_codi" 
                                    style="width: 75%; margin-top: 5px;">
                            	<?php  
								while ($row_curs_view = sqlsrv_fetch_array($curs_view)) 
								{
                            	$cc +=1; 
								?>     
                            		<option 
                                    	value="<?= $row_curs_view['curs_codi']; ?>">
										<?= $row_curs_view['curs_deta']; ?>
									</option>
                            	<?php 
								}  
								?>	  
                            	</select>
                            </td>
                        </tr>
                        <tr>
                            <td>Paralelo: </td>
                            <td>
								<?php  
                                $params = array();
                                $sql="{call para_view()}";
                                $para_view = sqlsrv_query($conn, $sql, $params);  
                                ?> 
                                <select 
                                	name="para_codi"   
                                    id="para_codi" 
                                    style="width: 25%; margin-top: 5px;">
                                <?php  
								while ($row_para_view = sqlsrv_fetch_array($para_view))
								{
                                	$cc +=1; 
								?>     
                                	<option 
                                    	value="<?= $row_para_view['para_codi']; ?>">
										<?= $row_para_view['para_deta']; ?>
                                    </option>
                                <?php 
								}  
								?>	  
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Cupos: </td>
                            <td>
                            	<input 
                                	id="curs_para_cupo" 
                                    name="curs_para_cupo" 
                                    type="number" 
                                    value="<?php echo  para_sist(1); ?>" 
                                    min="0" style="width: 25%; margin-top: 5px;" 
                                    required>
							</td>
                        </tr>
                    </table>
                </div>
                <div class="form_element">&nbsp;</div>                
            </form>
            </div>
            </div>
                <div class="modal-footer">
                	<button 
                    	type="button" 
                        class="btn btn-primary"  
                        onClick="curs_para_save(<?= $_SESSION['peri_codi'];  ?>	,selectvalue(document.getElementById('sl_peri_dist_cabe_codi')),selectvalue(document.getElementById('curs_codi')),selectvalue(document.getElementById('para_codi')),document.getElementById('curs_para_cupo').value);" 
                        data-dismiss="modal" >
                		Aceptar
                	</button>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
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
                       <!--Inicio modal agregar curso paralelo-->
                        
                        <!--Inicio modal eliminar notas curso paralelo-->
                        <div class="modal fade" id="ModalEliminarNotas" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="ModalCopiadeMaterias">Eliminar Notas</h4>
                              </div>
                              <div id="modal_main" class="modal-body">
                                <div id="div_cupo_edi"> 
                                    <div class="form_element">
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%;" class="table">
                                        <tr>
                                            <td width="25%" style="padding-top: 15px;">
                                                <label for="curs_para">Paralelo: </label>
                                            </td>
                                            <td style="padding-top: 15px;">
                                            <? 	
                                                $peri_codi=$_SESSION['peri_codi'];
                                                $params = array($peri_codi);
                                                $sql="{call peri_dist_peri_view_Lb(?)}";
                                                $peri_dist_peri_view = sqlsrv_query($conn, $sql, $params);  
                                            ?>
                                            <select id="peri_dist_codi" style="width: 75%;">
                                            <? 
                                            while($row_peri_dist_peri_view = sqlsrv_fetch_array($peri_dist_peri_view))
                                            { 
                                            ?>
                                              <option 
                                                value="<?= $row_peri_dist_peri_view['peri_dist_codi'];?>">
                                                        <?= 
                                                            (($row_peri_dist_peri_view['padre']=='')?
                                                            $row_peri_dist_peri_view['padre']:
                                                            $row_peri_dist_peri_view['padre'].' - ').
                                                            $row_peri_dist_peri_view['peri_dist_deta'];
                                                        ?>
                                              </option>
                                            <?php
                                            }
                                            ?>
                                            </select> 
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="25%" style="padding-top: 15px;">
                                                Clave de seguridad:
                                            </td>
                                            <td style="padding-top: 15px;">
                                                <input type="password" id="txt_clave" placeholder="Ingrese su clave" style="width: 35%;"  />
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
                                    class="btn btn-success" 
                                    onClick="notas_elim_peri_dist_all(document.getElementById('peri_dist_codi').value,
																	  <? echo $_SESSION['codi']; ?>,
                                                                      document.getElementById('txt_clave').value);" >
                                    Eliminar
                                </button>
                                <button 
                                    type="button" 
                                    class="btn btn-default" 
                                    data-dismiss="modal" >
                                    Cerrar
                                </button>
                              </div>
                            </div>
                          </div>
                        </div>
                        <!--Fin modal eliminar notas a curso paralelo-->
						<script type="text/javascript" src="js/select_reportes_generales.js"></script>
						<!--Inicio modal excelencia académica-->
                        <div class="modal fade" id="ModalExcelencia" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="ModalCopiadeMaterias">Informe de Excelencia Académica</h4>
                              </div>
                              <div id="modal_main" class="modal-body">
                                <div id="div_cupo_edi"> 
                                    <div class="form_element">
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%;" class="table">
                                        <tr>
                                            <td width="25%" style="padding-top: 15px;">
                                                <label>Tipo de Periodo: </label>
                                            </td>
                                            <td style="padding-top: 15px;">
                                            <? 	
                                                $peri_codi=$_SESSION['peri_codi'];
                                                $params = array($peri_codi);
                                                $sql="{call peri_dist_cab_view(?)}";
                                                $stmt = sqlsrv_query($conn, $sql, $params);  
                                            ?>
                                            <select id="sl_peri_dist_cab" onchange="CargarCursosParalelosExc(this.value);" style="width: 200px">
												<option>Elija</option>
                                            <? 
                                            while($row = sqlsrv_fetch_array($stmt))
                                            { 
                                            ?>
                                              <option 
                                                value="<?= $row['peri_dist_cab_codi'];?>">
                                                        <?= 
                                                            $row["peri_dist_cab_deta"];
                                                        ?>
                                              </option>
                                            <?php
                                            }
                                            ?>
                                            </select> 
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="25%" style="padding-top: 15px;">
                                                <label>Curso/Paralelo: </label>
                                            </td>
                                            <td style="padding-top: 15px;">
												<div id="div_sl_paralelos">
													<select
														disabled="disabled"
														style="width: 200px"
														id="sl_paralelos">
														<option value="0">Curso/Paralelo</option>
													</select>
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
                                    class="btn btn-success"
									onclick="getURLExcelenciaAcadExcel();">
                                    Descargar
                                </button>
                                <button 
                                    type="button" 
                                    class="btn btn-default" 
                                    data-dismiss="modal" >
                                    Cerrar
                                </button>
                              </div>
                            </div>
                          </div>
                        </div>
                        <!--Fin modal excelencia académica-->
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
    
<!-- InstanceBeginEditable name="EditRegion4" -->EditRegion4<!-- InstanceEndEditable -->
</body>
<!-- InstanceEnd --></html>