<!DOCTYPE html>
<html lang="es">
    <?php include("template/head.php");?>
    <body class="hold-transition skin-blue sidebar-mini <?php echo $_SESSION['sidebar_status']; ?>">
		<div class="wrapper">
			<?php include ('template/header.php');?>
			<?php $Menu=412;include("template/menu.php");?>
			<div class="content-wrapper">
				<section class="content-header">
					<h1>Notas Permisos</h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-list-alt"></i></a></li>
						<li class="active">Notas Permisos</li>
					</ol>
				</section>
				<section class="content" id="mainPanel">
					<div id="information">
						<div class="box box-default">
							<div class="box-header with-border">
								<h3 class="box-title">
									<?php if (permiso_activo(64)){?>
									  <a class="btn btn-default"  id="bt_curs_add" onclick="document.getElementById('curs_deta').value='';" data-toggle="modal" data-target="#nuev_perm_indi" title="">
										<span style='color:#3c8dbc' class="fa fa-plus"></span> Individual
									  </a>
									<?php }if (permiso_activo(65)){?>
									  <a class="btn btn-primary"  id="bt_curs_add" o  data-toggle="modal" data-target="#nuev_perm_group" title="">
										<span class="fa fa-plus"></span> General
									  </a>
									<?php }?>
								</h3>
							</div><!-- /.box-header -->
							<div class="box-body">
								<script src="js/funciones_notas_permisos.js"></script>
								<script src="js/select_permisos.js"></script>
								<div class="nav-tabs-custom">
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
										
											<div class="panel panel-info">
												<div class="panel-heading">
													<h3 class="panel-title">
														<a href="#/" id="boton_busqueda" name="boton_busqueda" style="text-decoration:none;">
															<div width="100%">
																<span class="fa fa-search"></span>&nbsp;Búsqueda
															</div>
														</a>
													</h3>
												</div>
												<div class="panel-body" id="desplegable_busqueda" name="desplegable_busqueda">
													<div class="form-horizontal" role="form">
														<div class="form-group">
															<label class="col-md-2 col-sm-3 control-label" style="text-align: right;">Período distribución:</label>
															<div class="col-md-4 col-sm-5">
																<?
																	$params = array($PERI_CODI);
																	$sql="{call peri_dist_cab_view(?)}";
																	$peri_dist_cab_view = sqlsrv_query($conn, $sql, $params);
																?>
																<select class='form-control input-sm' 
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
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-2 col-sm-3 control-label" style="text-align: right;">Unidad:</label>
															<div class="col-md-4 col-sm-5">
																<div id="div_peri_dist_repo" style="display: inline;">
																	<select class='form-control input-sm' 
																		id="repo_peri_dist_codi" 
																		disabled="disabled"
																		style="width: 250px; margin-top:10px">
																		<option value="-1">Seleccione</option>
																	</select>
																</div>
															</div>
														</div>
														<div class="form-group">
															<div class="col-md-2 col-sm-3 control-label" style="text-align: right;">
																<button type="button" class="btn btn-primary btn" onClick="print_view();">
																	<span class="fa fa-print"></span> Imprimir
																</button>
															</div>
														</div>
													</div>
												</div>
											</div>						
											<div id="curs_para_main_repo_deta">
												<?php include ('cursos_notas_permisos_main_view_repo.php'); ?>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
		            </div>
				</section>
				<?php include("template/menu_sidebar.php");?>
			</div>
			<form id="frm_actu" name="frm_actu" method="post" action="" enctype="multipart/form-data">
				<?php include("template/rutas.php");?>
			</form>
			<?php include("template/footer.php");?>
		</div>
		<!-- =============================== -->
		<input name="mens_de"  		type="hidden" id="mens_de" 		value='<?php echo $_SESSION['USUA_DE'];  ?>'    />
		<input name="mens_de_tipo"  type="hidden" id="mens_de_tipo" value='<?php echo $_SESSION['USUA_TIPO']; ?>'    />
		<?php include("template/scripts.php");?>
		<script src="js/funciones_curs.js"></script>
		<script>
			load_ajax_get('curs_para_main_repo_deta','cursos_notas_permisos_main_view_repo.php?peri_dist_codi=' + document.getElementById('repo_peri_dist_codi').value);
		</script>
	</body>
</html>
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
                        onClick="nota_perm_add(1);"
                        data-dismiss="modal">
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
                <form class="form-horizontal">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="sl_peri_dist_cab" class="col-md-4 control-label">Periodo Distribución: </label>
                            <?
                            $params = array($PERI_CODI);
                            $sql="{call peri_dist_cab_view(?)}";
                            $peri_dist_cab_view = sqlsrv_query($conn, $sql, $params);
                            ?>
                            <div class="col-md-8">
                                <select class="form-control"
                                    name="sl_peri_dist_cab"
                                    id="sl_peri_dist_cab"
                                    onChange="CargarUnidadesGeneral(this.value, 2, 'div_unidad_gen');CargarCursosGeneral(this.value, 'div_curso_gen');CargarProfesoresGeneral(this.value, 'div_profesor_gen');">
                                        <option value="0">Elija</option>
                                   <?php  while ($row_peri_dist_cab_view = sqlsrv_fetch_array($peri_dist_cab_view)) { ?>
                                        <option value="<?= $row_peri_dist_cab_view['peri_dist_cab_codi']; ?>">
                                            <?= $row_peri_dist_cab_view['peri_dist_cab_deta']; ?>
                                        </option>
                                    <? } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="pg_peri_dist_codi" class="col-md-4 control-label">Unidad: </label>
                            <div id="div_unidad_gen" class="col-md-8">
                                <select
                                    id="pg_peri_dist_codi"
                                    class="form-control"
                                    disabled="disabled">
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="radio_op" class="col-md-4 control-label">Periodo: </label>
                            <div class="col-md-8">
                                <input
                                    type="radio"
                                    name="radio_op"
                                    id="radio_op2"
                                    value="<?= $_SESSION['peri_codi']; ?>"
                                    style="margin-left: 15px; margin-right:10px; margin-top:10px;">
                                        <?= $_SESSION['peri_deta']; ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="pg_curs_para_codi" class="col-md-4 control-label">Curso Paralelo: </label>
                            <div id="div_curso_gen">
                                <div class="col-md-1">
                                    <input
                                        type="radio"
                                        name="radio_op"
                                        id="radio_op3"
                                        value="3"
                                        style="margin-left: 15px; margin-right:10px; margin-top:10px;">
                                </div>
                                <div class="col-md-7">
                                    <select
                                        id="pg_curs_para_codi"
                                        class="form-control"
                                        disabled="disabled">
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="pg_prof_codi" class="col-md-4 control-label">Profesor: </label>
                            <div id="div_profesor_gen">
                                <div class="col-md-1">
                                    <input
                                        type="radio"
                                        name="radio_op"
                                        id="radio_op4"
                                        value="4"
                                        style="margin-left: 15px; margin-right:10px; margin-top:10px;">
                                </div>
                                <div class="col-md-7">
                                    <select
                                        id="pg_prof_codi"
                                        class="form-control"
                                        disabled="disabled">
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="pg_nota_peri_fec_ini" class="col-md-4 control-label">Desde: </label>
                            <div id="div_profesor_gen" class="col-md-8">
                                <input class="form-control"
                                    id="pg_nota_peri_fec_ini"
                                    type="text"
                                    value="<?= date('Y-m-d');?>"
                                    >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="pg_nota_peri_fec_fin" class="col-md-4 control-label">Hasta: </label>
                            <div id="div_profesor_gen" class="col-md-8">
                                <input class="form-control"
                                    id="pg_nota_peri_fec_fin"
                                    type="text"
                                    value="<?= date('Y-m-d');?>"
                                    >
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                         <button type="button" class="btn btn-primary"
                            onClick="nota_perm_add(radio_opcion());"  data-dismiss="modal">
                            Aceptar
                        </button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <button type="button" class="btn btn-default" data-dismiss="modal"  >
                            Cerrar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

	<script>
        $("#pi_nota_peri_fec_ini").datepicker({ format: 'yyyy-mm-dd' });
        $("#pi_nota_peri_fec_ini").inputmask({
			mask: "y-1-2", 
			placeholder: "yyyy-mm-dd", 
			leapday: "-02-29", 
			separator: "-", 
			alias: "yyyy/mm/dd"
		});
		$("#pi_nota_peri_fec_fin").datepicker({ format: 'yyyy-mm-dd' });
        $("#pi_nota_peri_fec_fin").inputmask({
			mask: "y-1-2", 
			placeholder: "yyyy-mm-dd", 
			leapday: "-02-29", 
			separator: "-", 
			alias: "yyyy/mm/dd"
		});
		$("#pg_nota_peri_fec_ini").datepicker({ format: 'yyyy-mm-dd' });
        $("#pg_nota_peri_fec_ini").inputmask({
			mask: "y-1-2", 
			placeholder: "yyyy-mm-dd", 
			leapday: "-02-29", 
			separator: "-", 
			alias: "yyyy/mm/dd"
		});
		$("#pg_nota_peri_fec_fin").datepicker({ format: 'yyyy-mm-dd' });
        $("#pg_nota_peri_fec_fin").inputmask({
			mask: "y-1-2", 
			placeholder: "yyyy-mm-dd", 
			leapday: "-02-29", 
			separator: "-", 
			alias: "yyyy/mm/dd"
		});

        curs_peri_mate_view(selectvalue(document.getElementById('pi_curs_para_codi')),'pi_mate_prof','pi')
        curs_peri_mate_view(selectvalue(document.getElementById('pg_curs_para_codi')),'pg_mate_prof','pg')
    </script>
</form>