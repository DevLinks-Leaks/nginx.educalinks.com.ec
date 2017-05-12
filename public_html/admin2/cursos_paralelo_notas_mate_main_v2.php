<!DOCTYPE html>
<html lang="es">
    <?php include("template/head.php");?>
    <body class="hold-transition skin-blue sidebar-mini">
		<div class="wrapper">
			<?php include ('template/header.php');?>
			<?php $Menu=201;include("template/menu.php");?>
			<div class="content-wrapper">
				<section class="content-header">
					<?php
						include ('../framework/dbconf.php');
						session_start();
						if(isset($_GET['curs_para_codi']))
						{   $curs_para_codi=$_GET['curs_para_codi'];
						}
						$PERI_CODI = $_SESSION['peri_codi'];
						$params = array($curs_para_codi);
						$sql="{call curs_peri_info(?)}";
						$curs_peri_info = sqlsrv_query($conn, $sql, $params);
						$row_curs_peri_info = sqlsrv_fetch_array($curs_peri_info);
				  	?>
					<h1>Notas de <?= $row_curs_peri_info['curs_deta'];?> (<?= $row_curs_peri_info['para_deta'];?>)</h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-address-book-o"></i></a></li>
						<li class="active">Cursos Paralelo</li>
					</ol>
				</section>
				<section class="content" id="mainPanel">
					<div id="information">
						<div class="box box-default">
							<div class="box-header with-border">
								<h3 class="box-title">
									<a class="btn btn-warning" href="cursos_paralelo_main.php" title=""><span class="fa fa-chevron-left"></span> Volver</a>
								</h3>
							</div><!-- /.box-header -->
							<div class="box-body">
								<script type="text/javascript" src="js/funciones_usua.js"></script> 
								<div>
									<?php 
									$peri_codi= $_GET['peri_codi'];
									$params = array($curs_para_codi);
									$sql="{call curs_peri_mate_view(?)}";
									$curs_peri_mate_view = sqlsrv_query($conn, $sql, $params);  
									$cc = 0;
									?>
									<table class="table table-striped table-bordered">
										<thead>
											<tr style='background:rgba(1, 126, 186, 0.1) !important;'>
												<th></th>             
												<th style='width:50%;'>Materias</th>
												<th style='text-align:center;'>Aula</th>
												<th>Profesores</th>
												<th style='text-align:center;'>Ver</th>              
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
												<td style='text-align:center;'>
													<?php 
													$url="window.location='cursos_paralelo_notas_mate_main_deta_v2.php?&curs_para_mate_codi=".$row_curs_peri_mate_view["curs_para_mate_codi"]."'";
													if ($row_curs_peri_mate_view["mate_hijo_cc"] == 0)
													{ 	if (permiso_activo(210))
														{
													?>
														<a class="btn btn-default" onclick="<?= $url; ?>"> 
															<span style='color:#015C88' class="fa fa-leanpub"></span>
														</a>
													<?php 
														}
													}
													?>
												</td>
											</tr>
										<?php 
										}
										?>
										</tbody>
									</table>
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
		<script type="text/javascript" charset="utf-8">
		</script>
	</body>
</html>