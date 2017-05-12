<!DOCTYPE html>
<html lang="es">
    <?php include("template/head.php");?>
    <body class="hold-transition skin-blue sidebar-mini">
		<div class="wrapper">
			<?php include ('template/header.php');?>
			<?php $Menu=7;include("template/menu.php");?>
			<div class="content-wrapper">
				<section class="content-header">
					<h1>Tutor</h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-briefcase"></i></a></li>
						<li class="active">Tutor</li>
					</ol>
				</section>
				<section class="content" id="mainPanel">
					<div id="information">
						<div class="box box-default">
							<div class="box-header with-border">
								<h3 class="box-title"><a href='tutor.php' class='btn btn-warning'><span class='fa fa-chevron-left'></span> Volver</a></h3>
							</div><!-- /.box-header -->
							<div class="box-body">
								<div id="alum_main" >
									<?php
										$curs_para_codi = $_GET['curs_para_codi'];
										$peri_dist_codi = $_GET['peri_dist_codi'];
										
										$nive_codi = curs_para_nive_cons($curs_para_codi);
										
										if ($nive_codi==4 or $nive_codi==5)
										{
											/*Archivo.php para libretas de inicial*/
											$url_libreta_individual="nota_obse_inicial";
										}
										else
										{
											/*Archivo.php para las demás libretas de inicial*/
											$url_libreta_individual="nota_obse";
										}
										
										$sql = "{call alum_curs_para_view (?)}";
										$params = array ($curs_para_codi);
										$stmt = sqlsrv_query($conn, $sql, $params);
									?>
									<table id='tbl_tutor_alumnos' class="table table-striped">
										<thead>
											<th width="5%" style="text-align:center">#</th>
											<th width="75%">Alumnos</th>
											<th width="20%" style="text-align:center">Opción</th>
										</thead>
										<tbody>
										<?
										$cc=0;
										while ($row_alum = sqlsrv_fetch_array($stmt))
										{
											$cc++;
										?>
											<tr>
												<td style="text-align:center">
													<?= $cc ?>
												</td>
												<td>
													<?= $row_alum['alum_apel'].' '.$row_alum['alum_nomb'] ?>
												</td>
												<td style="text-align:center">
													<button 
														class="btn btn-default" title='Editar' onmouseover='$(this).tooltip("show");'
														onClick="window.open('<?= $url_libreta_individual?>.php?curs_para_codi=<?= $curs_para_codi?>&peri_dist_codi=<?= $peri_dist_codi?>&alum_codi=<?= $row_alum['alum_codi']?>','_blank')">
														<span class='fa fa-pencil btn_opc_lista_editar'></span>
													</button>
												</td>
											</tr>
										<?
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
			$(document).ready(function() {
				$('#tbl_tutor_alumnos').DataTable() ;
			} );
		</script>
	</body>
</html>