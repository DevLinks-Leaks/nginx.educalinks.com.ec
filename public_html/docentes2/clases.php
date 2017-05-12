<!DOCTYPE html>
<html lang="es">
    <?php include("template/head.php");?>
    <body class="hold-transition skin-blue sidebar-mini">
		<div class="wrapper">
			<?php include ('template/header.php');?>
			<?php $Menu=3;include("template/menu.php");?>
			<div class="content-wrapper">
				<section class="content-header">
					<h1>Clases</h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-book"></i></a></li>
						<li class="active">Clases</li>
					</ol>
				</section>
				<section class="content" id="mainPanel">
					<div id="information">
						<div class="box box-default">
							<div class="box-header with-border">
								<h3 class="box-title">
									<div class="col-lg-12 col-sm-12 input-group input-group-sm">
										<span id="span_balance_reason" name="span_balance_reason" class="input-group-addon">Ver</span>
										<select id="cmb_mostrarMat" name="cmb_mostrarMat" class="form-control" onchange='js_clases_select(this.value);' disabled='disabled'>
											<option value="">- Seleccione una materia -</option>
											<?php 
												$params_mate = array($_SESSION['prof_codi'],$_SESSION['peri_codi']);
												$sql_mate="{call prof_curs_para_mate_view(?,?)}";
												$stmp_mate = sqlsrv_query($conn, $sql_mate, $params_mate); 
												while($row_curs_mate_view=sqlsrv_fetch_array($stmp_mate))
												{
													if ($row_curs_mate_view['curs_para_mate_agen']==1) 
													{
														echo '<option value="'.$row_curs_mate_view['curs_para_mate_codi'].'">'.
															$row_curs_mate_view["curs_deta"]." ".$row_curs_mate_view["para_deta"]." - ".$row_curs_mate_view["mate_deta"].'</option>';
													}
												}
											?>
										</select>
									</div>
								</h3>
							</div><!-- /.box-header -->
							<div class="box-body">
								<div id='div_ini_wait' align="center" style="height:100%;"><br><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i><br>Por favor, espere...</div>
								<div class="docentes_clases">
									<?php
									$params_mate = array($_SESSION['prof_codi'],$_SESSION['peri_codi']);
									$sql_mate="{call prof_curs_para_mate_view(?,?)}";
									$stmp_mate = sqlsrv_query($conn, $sql_mate, $params_mate);
									$aux = 0;
									while($row_curs_mate_view=sqlsrv_fetch_array($stmp_mate))
									{   if ($row_curs_mate_view['curs_para_mate_agen']==1) 
										{?>
										<div style='display:none;' id='mate_h_<?= $row_curs_mate_view['curs_para_mate_codi'];?>' name='mate_h_<?php echo $aux; ?>' >
											<div class='form-horizontal'>
												<div class='form-group'>
													<div class='col-sm-12'>
															<span class="fa fa-books"></span>Agendas: 
															<?php 
															$tipo_usua="A";
															$params_agen = array($row_curs_mate_view['curs_para_mate_prof_codi'],$tipo_usua);
															$sql_agen="{call agen_curs_para_mate_view_cont(?,?)}";
															$stmp_agen = sqlsrv_query($conn, $sql_agen, $params_agen); 
															while($row_agen_curs_view= sqlsrv_fetch_array($stmp_agen)){?>
																<?=$row_agen_curs_view['cont_agen']?>
															<?php } ?>
														<div class='pull-right'>
															<a  class="btn btn-default"
																href="cursos_paralelos_materias_profesor_lista.php?curs_para_mate_prof_codi=<?= $row_curs_mate_view['curs_para_mate_prof_codi']?>">
																<span class="fa fa-list"></span>
																Listado
															</a>
														</div>
													</div>
												</div>
												<div class='form-group'>
													<div class='col-sm-12'>
														<a class="btn btn-success btn-lg btn-block" href="clases_main.php?curs_para_mate_prof_codi=<?= $row_curs_mate_view['curs_para_mate_prof_codi'];?>&curs_para_mate_codi=<?= $row_curs_mate_view['curs_para_mate_codi'];?>&curs_para_codi=<?= $row_curs_mate_view['curs_para_codi'];?>" style="color:#FFF;">
														<span class="fa fa-search"></span> Ver Detalles del Curso
														</a>
													</div>
												</div>
												<div class='form-group'>
													<div class='col-sm-6'>
														<table class="table table-striped">
																<?php 
																$ruta=$_SESSION['ruta_foto_docente'];
																$full_name=$ruta.$row_curs_mate_view['prof_codi'].".jpg";
																$file_exi=$full_name;
																if (file_exists($file_exi)){
																	$pp=$file_exi;
																} else {
																	$pp=$_SESSION['foto_default'];
																}?>
															<thead>
																<tr>
																	<th>
																	  <span class="icons icon-parent"></span>Profesor
																	</th>
																</tr>
															</thead>
															<tbody>
																<tr>
																	<td class="no-padding">
																		<div class="teacher">
																			<div class="image">
																			<img 
																				src="<?php echo $pp;?>" title="<?= $row_curs_mate_view['prof_nomb']?>"  
																				border="0" 
																				style="border-color:#F0F0F0;width:55px; height:55px;"/>
																							
																			</div>
																			<div class="information">
																				<div class="name">
																					<?= $row_curs_mate_view["prof_nomb"]; ?>
																				</div>
																				<div class="email">
																					<?= $row_curs_mate_view["prof_mail"]; ?>
																				</div>
																			</div>
																		</div>
																	</td>
																</tr>
															</tbody>
														</table>
														<!-- AGENDA -->
														<table class="table_striped ">
															<thead>
															  <tr>
																<th>
																  <span class="icons icon-list"></span>AGENDA
																</th>
															  </tr>
															</thead>
															<tbody>
																<tr>
																	<td class="no-padding">
																		<div class="agenda_list">
																		<?php 
																		$tipo_usua="A";
																		$params_agen = array($row_curs_mate_view['curs_para_mate_prof_codi'],$tipo_usua);
																		$sql_agen="{call agen_curs_para_mate_view(?,?)}";
																		$stmp_agen = sqlsrv_query($conn, $sql_agen, $params_agen); 
																		while($row_agen_curs_view= sqlsrv_fetch_array($stmp_agen)){?>
																			<div class="agenda">
																				<div style="width:70%;float:left;"><?=$row_agen_curs_view['agen_titu']?></div>
																				<div style="width:30%;float:right;"><?=date_format($row_agen_curs_view['agen_fech_fin'], 'd/m/Y')?></div>
																			</div>
																		<?php } ?>
																		</div>
																	</td>
																</tr>
															</tbody>
														</table>
													</div>
													<div class='col-sm-6'>
														<?
														if (para_sist(401))
														{
														?>
														<table class="table_striped">
														  <thead>
															<tr>
															  <th>
																<span class="icons icon-bubbles"></span>COMENTARIOS
															  </th>
															</tr>
														  </thead>
														  <tbody>
															<tr>
																<td class="no-padding">
																	<div class="post_list">
																		<?php
																		$params_post = array($row_curs_mate_view['curs_para_mate_prof_codi']);
																		$sql_post="{call wall_curs_para_mate_view(?)}";
																		$stmp_post = sqlsrv_query($conn, $sql_post, $params_post); 
																		while($row_wall_curs_view= sqlsrv_fetch_array($stmp_post)){?>
																		<div class="post">
																			<div class="image">
																				<?php
																				if ($row_wall_curs_view['wall_curs_para_tipo_usua']=='A'){
																				$ruta=$_SESSION['ruta_foto_alumno'];
																				}elseif($row_wall_curs_view['wall_curs_para_tipo_usua']=='D'){
																				$ruta=$_SESSION['ruta_foto_docente'];
																				}elseif($row_wall_curs_view['wall_curs_para_tipo_usua']=='R'){
																				$ruta=$_SESSION['ruta_foto_repre'];
																				}
																				$full_name=$ruta.$row_wall_curs_view['usua_codi'].".jpg";
																				$file_exi=$full_name;
																				if (file_exists($file_exi)){
																				$pp=$file_exi;
																				} else {
																				$pp=$_SESSION['foto_default'];
																				}

																				?>
																				<img src="<?php echo $pp;?>" border="0" />
																			</div>
																			<div class="information">
																				<div class="user">
																					<strong><?=$row_wall_curs_view['wall_curs_para_nombre']?></strong> <span><?= date_format($row_wall_curs_view['wall_curs_para_fech_regi'],'d/m/Y  h:m:s')?></span> 
																				</div>
																				<div class="text">
																					<?=$row_wall_curs_view['wall_curs_para_text']?>
																				</div>
																			</div>
																		</div>
																		<?php }?>
																	</div>
																</td>
															</tr>
															<tr>
															  <td class="footer">
																<div class="details">

																  <a class="btn btn-info" href="posts_main.php?curs_para_mate_prof_codi=<?=$row_curs_mate_view['curs_para_mate_prof_codi']?>&curs_para_mate_codi=<?=$row_curs_mate_view['curs_para_mate_codi']?>&curs_para_codi=<?=$row_curs_mate_view['curs_para_codi']?>">
																	<span class="fa fa-plus"></span> Ver Todos
																  </a>
																</div>

															  </td>
															</tr>
														  </tbody>
														</table>
														<?
														}
														else
														{
														?>
															<h4>Los comentarios están desactivados.</h4>
														<?
														}
														?> 
													</div>
												</div>
											</div>
										</div>
									<?		$aux++;
										}
									}?> 
								</div>
								<input type="hidden"  name="hd_num_materias" id="hd_num_materias" value='<?php echo $aux; ?>' />
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
		<script type="text/javascript" charset="utf-8">
			$( document ).ready(function() {
				document.getElementById( "div_ini_wait" ).innerHTML = '';
				document.getElementById( "cmb_mostrarMat" ).disabled = false;
				document.getElementById( "cmb_mostrarMat" ).focus();
			});
			function js_clases_select( value )
			{	var num_materias = document.getElementById( "hd_num_materias" ).value;
				var i = 0;
				for (i = 0; i < num_materias; i++ )
				{   document.getElementsByName( "mate_h_" + i )[0].style.display ='none';
				}
				document.getElementById( "mate_h_" + value ).style.display ='inline';
				//$.growl({ title: "Educalinks informa", message: "Materia seleccionada" });
			}
		</script>
	</body>
</html>

