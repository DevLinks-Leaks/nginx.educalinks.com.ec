<!DOCTYPE html>
<html lang="es">
    <?php include("template/head.php");?>
    <body class="hold-transition skin-blue sidebar-mini">
		<div class="wrapper">
			<?php include ('template/header.php');?>
			<?php $Menu=201;include("template/menu.php");?>
			<div class="content-wrapper">
				<section class="content-header">
					<h1>Observaciones</h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-eye"></i></a></li>
						<li class="active">Observaciones</li>
					</ol>
				</section>
				<section class="content" id="mainPanel">
					<div id="information">
						<div class="box box-default">
							<div class="box-header with-border">
								<h3 class="box-title">
									<a class="btn btn-warning" href='cursos_paralelo_main.php'>
										<span class="fa fa-chevron-left"></span> Volver</a>
								</h3>
							</div><!-- /.box-header -->
							<div class="box-body">
								<div  id="tab_libr">
									<?
									$curs_para_codi=$_GET['curs_para_codi'];
									$params = array($curs_para_codi);
									$sql="{call alum_curs_para_view(?)}";
									$alum_curs_para_view = sqlsrv_query($conn, $sql, $params);
									?>
									<table class="table table-striped">
										<thead style='background-color:rgba(1, 126, 186, 0.1) !important'>
											<tr><th>Alumno</th><th style='text-align:center'>Editar</th>
											</tr>
										</thead>
										<tbody>
										<?php  while ($row_alum_curs_para_view = sqlsrv_fetch_array($alum_curs_para_view)) { $cc +=1; ?>
											<tr>
												<td width="80%">
													<table>
														<tr>
															<?php
															$file_exi = $_SESSION['ruta_foto_alumno'].$row_alum_curs_para_view["alum_codi"].'.jpg';
															if (file_exists($file_exi)) {
																$pp=$file_exi;
															} else {
																$pp='../fotos/'.$_SESSION['directorio'].'/alumnos/0.jpg';
															}
															?>
															<td width="30" class="center"><?php echo $cc; ?></td>
															<td width="40" class="center" >
																<img src="<?php echo $pp; ?>" style=" text-align:right; border:none; width:40px; height:40px;"/>
															</td>
															<td width="404" class="left" ><?= $row_alum_curs_para_view["alum_codi"]; ?>
																- <?= $row_alum_curs_para_view["alum_apel"]." ".$row_alum_curs_para_view["alum_nomb"]; ?></td>
														</tr>
													</table>
												</td>
												<td style='text-align:center'>
													<button
														class="btn btn-default"
														onClick="window.location='cursos_paralelo_hoja_vida_alum.php?alum_curs_para_codi=<?= $row_alum_curs_para_view["alum_curs_para_codi"];?>&curs_para_codi=<?= $curs_para_codi;?>'">
														<span class='fa fa-edit btn_opc_lista_editar'></span>
													</button>
												</td>
											</tr>
										<?php }?>
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
			$(document).ready(function() {
			} );
		</script>
	</body>
</html>