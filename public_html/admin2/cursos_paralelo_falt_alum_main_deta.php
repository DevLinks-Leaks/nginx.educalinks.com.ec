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
					$alum_codi=$_GET['alum_codi'];
					$alum_curs_para_codi =$_GET['alum_curs_para_codi'];
					$curs_para_codi =$_GET['curs_para_codi'];
					
					$params = array($peri_dist_codi);
					$sql="{call peri_dist_padr_view(?)}";
					$peri_dist_padr_view = sqlsrv_query($conn, $sql, $params); 

					$peri_codi=Periodo_Distribucion_Peri_Codi($peri_dist_codi);

					$params = array($alum_curs_para_codi);
					$sql="{call alum_info_curs_para(?)}";
					$alum_info_curs_para = sqlsrv_query($conn, $sql, $params);
					$row_alum_info_curs_para = sqlsrv_fetch_array($alum_info_curs_para);

				  	?>
					<h1>Curso: <?= $row_alum_info_curs_para['curs_deta']; ?> - <?= $row_alum_info_curs_para['alum_apel']; ?> <?= $row_alum_info_curs_para['alum_nomb']; ?></h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-check-square-o"></i></a></li>
						<li class="active">Detalle de Faltas</li>
					</ol>
				</section>
				<section class="content" id="mainPanel">
					<div id="information">
						<div class="box box-default">
							<div class="box-header with-border">
								<h3 class="box-title">
									<h3 class="box-title">
									<a class="btn btn-warning" href='cursos_paralelo_falt_alum_main.php?curs_para_codi=<?= $curs_para_codi; ?>'>
										<span class="fa fa-chevron-left"></span> Volver</a>
								</h3>
							</div><!-- /.box-header -->
							<div class="box-body">
								<div  id="curs_para_view_falt">
									<?php include('cursos_paralelo_falt_alum_main_deta_view.php'); ?>
								</div>
								<script type="text/javascript" src="js/funciones_faltas.js"></script>
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