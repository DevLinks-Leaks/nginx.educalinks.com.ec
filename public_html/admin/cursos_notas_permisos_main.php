<!DOCTYPE html>
<html><!-- InstanceBegin template="/Templates/admin.dwt" codeOutsideHTMLIsLocked="false" -->

<?php include ('head.php');?>
        
      <!-- Nuevos Css Js -->
	
      <!-- Fin -->
	</head> 
	<body class="general admin"> 
								<!-- InstanceBeginEditable name="EditRegion3" --><?php  $Menu=206;    ?><!-- InstanceEndEditable -->
		<div class="pageContainer"> 

		  <?php include ('menu.php');?>

			<div id="mainPanel" class="section_main">
            
        			<?php include ('header.php');?>
        
				<div class="main sectionBorder">
					<div id="information">
          
          <div class="titleBar">
          <!-- InstanceBeginEditable name="Titulo Top" -->
          <script src="js/funciones_notas_permisos.js"></script>
		  <script src="js/select_permisos.js"></script>


          	<div class="title">
            	<h3><span class="icon-check icon"></span>Notas Permisos</h3>
            </div>

            <div class="options">

              <ul>


                <li>
                  <div class="element">



                  </div>
                </li>
               <?php if (permiso_activo(64)){?>
                <li>
                  <a class="button_text"  id="bt_curs_add" onclick="document.getElementById('curs_deta').value='';" data-toggle="modal" data-target="#nuev_perm_indi" title="">
                    <span class="icon-add icon"></span>Individual
                  </a>
                </li>
                <?php }if (permiso_activo(65)){?>
                 <li>
                  <a class="button_text"  id="bt_curs_add" o  data-toggle="modal" data-target="#nuev_perm_group" title="">
                    <span class="icon-add icon"></span>General
                  </a>
                </li>
				<?php }?>
              </ul>
            </div>

		  <!-- InstanceEndEditable -->
          </div>
          
                        <!-- InstanceBeginEditable name="information" -->
                        <div>

                      <!-- Nav tabs -->
                      <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#curs_para_main" aria-controls="curs_para_main" role="tab" data-toggle="tab">Asignacion</a></li>
                        <li role="presentation"><a href="#curs_para_main_repo" aria-controls="curs_para_main_repo" role="tab" data-toggle="tab">Reportes de Ingresos</a></li>
                      </ul>

                      <!-- Tab panes -->
                      <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="curs_para_main">
                            <?php include ('cursos_notas_permisos_main_view.php'); ?>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="curs_para_main_repo">

                                <script>
								function print_view(){
									window.location='cursos_notas_permisos_main_view_repo_print.php?peri_dist_codi=' + document.getElementById('repo_peri_dist_codi').value + '&peri_dist_cab_codi=' + document.getElementById('sl_repo_peri_dist_cab').value;
								}
								</script>
								
								<div style="text-align: right;">
								<div class="options">
									Periodo distribución:
										<?
											$params = array($PERI_CODI);
											$sql="{call peri_dist_cab_view(?)}";
											$peri_dist_cab_view = sqlsrv_query($conn, $sql, $params);
										?>
										<select
											id="sl_repo_peri_dist_cab"
											style="width:250px; margin-top:10px;"
											onChange="CargarUnidadesReporte(this.value, 2, 'div_peri_dist_repo')">
												<option value="0">Elija</option>
										   <?php  while ($row_peri_dist_cab_view = sqlsrv_fetch_array($peri_dist_cab_view)) { ?>
												<option value="<?= $row_peri_dist_cab_view['peri_dist_cab_codi']; ?>">
													<?= $row_peri_dist_cab_view['peri_dist_cab_deta']; ?>
												</option>
											<? } ?>
										</select>
											Unidad:
										<div id="div_peri_dist_repo" style="display: inline;">
											<select 
												id="repo_peri_dist_codi" 
												disabled="disabled"
												style="width: 250px; margin-top:10px">
												<option value="-1">Seleccione</option>
											</select>
										</div>
										<button type="button" class="btn btn-default btn" onClick="print_view();">
										<span class="icon-print"></span>  Imprimir
									</button>
								</div>
								
										
                            </div>							
                            <div id="curs_para_main_repo_deta">
								<?php include ('cursos_notas_permisos_main_view_repo.php'); ?>
                            </div>
                        </div>

                      </div>

                    </div>


						<script src="js/funciones_curs.js"></script>
                        <script>
							load_ajax_get('curs_para_main_repo_deta','cursos_notas_permisos_main_view_repo.php?peri_dist_codi=' + document.getElementById('repo_peri_dist_codi').value);
                        </script>




<!-- Modal -->
            <div
            	class="modal fade"
                id="nuev_perm_indi"
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
                        	<span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
					</button>
                    <h4 class="modal-title" id="myModalLabel">Nuevo Permiso Individual</h4>
                  </div>
                  <div class="modal-body">
                  <div id="div_perm_add">
                   <table width="100%" cellspacing="0" cellpadding="0">
					<tr>
						<td width="25%">
							Periodo Distribución:
						</td>
						<td width="75%">
						<?
							$params = array($PERI_CODI);
							$sql="{call peri_dist_cab_view(?)}";
							$peri_dist_cab_view = sqlsrv_query($conn, $sql, $params);
						?>
						<select
							name="sl_peri_dist_cab"
							id="sl_peri_dist_cab"
							style="width:75%; margin-top:10px;"
							onChange="CargarUnidadesIndividual(this.value, 2, 'div_unidad_ind');CargarCursosIndividual(this.value,'div_curso_ind');CargarProfesoresIndividual(-1,'div_profesor_materia_ind')">
								<option value="0">Elija</option>
						   <?php  while ($row_peri_dist_cab_view = sqlsrv_fetch_array($peri_dist_cab_view)) { ?>
								<option value="<?= $row_peri_dist_cab_view['peri_dist_cab_codi']; ?>">
									<?= $row_peri_dist_cab_view['peri_dist_cab_deta']; ?>
								</option>
							<? } ?>
						</select>
						</td>
					  </tr>
                    <tr>
                    	<td width="25%">
                        	Unidad:
						</td>
                        <td width="75%">
							<div id="div_unidad_ind">
								<select
									id="pi_peri_dist_codi"
									style="width:75%; margin-top:10px;"
									disabled="disabled">
								</select>
							</div>
                        </td>
                    </tr>
                    <tr>
                        <td width="25%">
                        	Curso Paralelo:
						</td>
                        <td width="75%">
							<div id="div_curso_ind">
								<select
									id="pi_curs_para_codi"
									style="width:75%; margin-top:10px;"
									disabled="disabled">
								</select>
							</div>
                		</td>
              		</tr>
                        <td width="25%">
                        	Profesor / Materia:
						</td>
                        <td width="75%">
                            <div id="div_profesor_materia_ind">
								<select
									id="pi_profesor_materia"
									style="width:75%; margin-top:10px;"
									disabled="disabled">
								</select>
                            </div>
                		</td>
              		</tr>
                    <tr>
                        <td>
                        	Desde:
						</td>
                        <td>
                        	<input
                            	id="pi_nota_peri_fec_ini"
                                type="text"
                                value="<?= date('Y-m-d');?>"
                                style="width: 30%; margin-top: 5px;">
						</td>
                  	</tr>
                    <tr>
                        <td>
                        	Hasta:
						</td>
                        <td>
                        	<input
                            	id="pi_nota_peri_fec_fin"
                                type="text"
                                value="<?= date('Y-m-d');?>"
                                style="width: 30%; margin-top: 5px;">
						</td>
					</tr>
				</table>
                </div>
                <div class="form_element">&nbsp;</div>
                </div>
                <div class="modal-footer">
                     <button
                     	type="button"
                        class="btn btn-primary"
                        onClick="nota_perm_add(1);">
                        Aceptar
                    </button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
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

    <!-- Modal -->
    <form >
    <input type="hidden" name="peri_codi" id="peri_codi" value="<?= $_SESSION['peri_codi']; ?>">
   <!-- Modal GRUPO -->
    <div
        class="modal fade"
        id="nuev_perm_group"
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
                	<span aria-hidden="true">
                    	&times;</span><span class="sr-only">Close</span>
			</button>
            <h4 class="modal-title" id="myModalLabel">Nuevo Permiso General</h4>
          </div>
          <div class="modal-body">
          <div>
           <table width="100%" cellspacing="0" cellpadding="0">
           <tr>
            <td width="25%">
                Periodo Distribución:
            </td>
            <td width="75%">
            <?
                $params = array($PERI_CODI);
                $sql="{call peri_dist_cab_view(?)}";
                $peri_dist_cab_view = sqlsrv_query($conn, $sql, $params);
            ?>
			<select
              	name="sl_peri_dist_cab"
                id="sl_peri_dist_cab"
                style="width:75%; margin-top:10px;"
                onChange="CargarUnidadesGeneral(this.value, 2, 'div_unidad_gen');CargarCursosGeneral(this.value, 'div_curso_gen');CargarProfesoresGeneral(this.value, 'div_profesor_gen');">
                	<option value="0">Elija</option>
               <?php  while ($row_peri_dist_cab_view = sqlsrv_fetch_array($peri_dist_cab_view)) { ?>
                	<option value="<?= $row_peri_dist_cab_view['peri_dist_cab_codi']; ?>">
						<?= $row_peri_dist_cab_view['peri_dist_cab_deta']; ?>
                    </option>
                <? } ?>
			</select>
			</td>
          </tr>
           <tr>
            <td width="25%">
                Unidad:
            </td>
            <td width="75%">
            	<div id="div_unidad_gen">
                	<select
                    	id="pg_peri_dist_codi"
                        style="width:75%; margin-top:10px;"
                        disabled="disabled">
                    </select>
                </div>
			</td>
          </tr>
         <tr>
            <td colspan="2">
            	<hr width="100%">
			</td>
		</tr>
      	<tr>
        	<td>
            	Periodo:
			</td>
        	<td>
        	<input
            	type="radio"
                name="radio_op"
                id="radio_op2"
                value="<?= $_SESSION['peri_codi']; ?>"
                style="margin-left: 15px; margin-right:10px; margin-top:10px;">
					<?= $_SESSION['peri_deta']; ?>
			</td>
      </tr>
      <tr>
        <td>
        	Curso Paralelo:
		</td>
        <td>
            <div id="div_curso_gen">
                <input
                    type="radio"
                    name="radio_op"
                    id="radio_op3"
                    value="3"
                    style="margin-left: 15px; margin-right:10px; margin-top:10px;">
				<select
                	id="pg_curs_para_codi"
                	style="width:75%; margin-top:10px;"
                    disabled="disabled">
                </select>
            </div>
        </td>
      </tr>
        <tr>
        	<td>
            	Profesor:
			</td>
        	<td height="40">
				<div id="div_profesor_gen">
                	<input
                        type="radio"
                        name="radio_op"
                        id="radio_op4"
                        value="4"
                        style="margin-left: 15px; margin-right:10px; margin-top:10px;">
                    <select
                    	id="pg_prof_codi"
                        style="width:75%; margin-top:10px;"
                        disabled="disabled">
                    </select>
                </div>
        	</td>
        </tr>
        <tr>
            <td>
            	Desde:
			</td>
            <td>
            	<input
                	id="pg_nota_peri_fec_ini"
                    type="text"
                    value="<?= date('Y-m-d');?>"
                    style="margin-left: 40px; margin-top:10px;">
			</td>
      	</tr>
        <tr>
            <td>
            	Hasta:
			</td>
            <td>
            	<input
                	id="pg_nota_peri_fec_fin"
                    type="text"
                    value="<?= date('Y-m-d');?>"
                    style="margin-left: 40px; margin-top:10px;">
			</td>
      </tr>
    </table>
          </div>
          <div class="form_element">&nbsp;</div>
          </div>
          <div class="modal-footer">
                 <button type="button" class="btn btn-primary"
                    onClick="nota_perm_add(radio_opcion());"  >
                    Aceptar
                </button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <button type="button" class="btn btn-default" data-dismiss="modal"  >
                    Cerrar
                </button>
          </div>
        </div>
      </div>
    </div>

	<script>
        $("#pi_nota_peri_fec_ini").datepicker({ dateFormat: 'yy-mm-dd' });
        $("#pi_nota_peri_fec_fin").datepicker({ dateFormat: 'yy-mm-dd' });

        $("#pg_nota_peri_fec_ini").datepicker({ dateFormat: 'yy-mm-dd' });
        $("#pg_nota_peri_fec_fin").datepicker({ dateFormat: 'yy-mm-dd' });

        curs_peri_mate_view(selectvalue(document.getElementById('pi_curs_para_codi')),'pi_mate_prof','pi')
        curs_peri_mate_view(selectvalue(document.getElementById('pg_curs_para_codi')),'pg_mate_prof','pg')
    </script>

  					<!-- Modal GRUPO -->
</form>
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