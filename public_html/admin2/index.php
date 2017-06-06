
<!DOCTYPE html>
<html lang="es">
    <?php
	session_start();
	$_SESSION['modulo'] = 'acad';
	include("template/head.php");?>
    <body class="hold-transition skin-blue sidebar-mini <?php echo $_SESSION['sidebar_status']; ?>">
		<div class="wrapper">
			<?php include ('template/header.php');?>
			<?php $Menu=000;include("template/menu.php");?>
			<div class="content-wrapper">
				<section class="content-header">
					<?php
						$params = array($_SESSION['curs_para_codi']);
						$sql="{call curs_para_info(?)}";
						$curs_para_info = sqlsrv_query($conn, $sql, $params);  
						$row_curs_para_info = sqlsrv_fetch_array($curs_para_info);
				  	?>
					<h1>Inicio</h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-home"></i></a></li>
						<li class="active">Inicio</li>
					</ol>
				</section>
				<section class="content" id="mainPanel">
					<div id="information">
						<div class='form-horizontal'>
							<div class='row'>
								<?php
								if(permiso_activo( 7 ))
								{
									echo '<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
										<div class="small-box bg-aqua">
											<div class="inner">
											<h3>Inscripción</h3>

											<p>Registro de un nuevo alumno</p>
											</div>
											<div class="icon">
												<i class="fa fa-clipboard"></i>
											</div>
											<a href="alumnos_add.php" class="small-box-footer">Ir a inscripción <i class="fa fa-arrow-circle-right"></i></a>
										</div>
									</div>';
								}
								if(permiso_activo(10))
								{	echo '<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
										<div class="small-box bg-purple">
											<div class="inner">
											<h3>Cursos</h3>

											<p>Listado de cursos</p>
											</div>
											<div class="icon">
												<i class="fa fa-circle-o"></i>
											</div>
											<a href="cursos_paralelo_main.php" class="small-box-footer">Ir a cursos <i class="fa fa-arrow-circle-right"></i></a>
										</div>
									</div>';
								}
								if(permiso_activo( 8))
								{	echo '<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
										<div class="small-box bg-green">
											<div class="inner">
											<h3>Alumnos</h3>

											<p>Bandeja de alumnos</p>
											</div>
											<div class="icon">
												<i class="fa fa-graduation-cap"></i>
											</div>
											<a href="alumnos_main.php" class="small-box-footer">Ir a alumnos <i class="fa fa-arrow-circle-right"></i></a>
										</div>
									</div>';
								}
								if(permiso_activo(76))
								{   echo '<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
									<div class="small-box bg-yellow">
										<div class="inner">
										<h3>Actas</h3>

										<p>Reportes, sábanas en excel</p>
										</div>
										<div class="icon">
											<i class="fa fa-file-excel-o"></i>
										</div>
										<a href="report_gene_actas.php" class="small-box-footer">Ir a actas <i class="fa fa-arrow-circle-right"></i></a>
									</div>
								</div>';
								}?>
							</div>
						</div>
						<script src="../framework/Chart.js-master/Chart.js"></script>
						<script src="../admin/js/funciones_monitor.js"></script>
						<div id="curs_para_main" class="nav-tabs-custom">
							<ul class="nav nav-tabs">    
								<?php if (permiso_activo( 1)){?><li class="active"><a href="#tab1" data-toggle="tab">Matriculados</a></li><? }?>
								<?php if (permiso_activo(95)){?><li				  ><a href="#tab4" data-toggle="tab">Monitoreo</a></li><? }?>
							</ul> 				 
							<div class="tab-content">
								<div class="tab-pane active" id="tab1"><?php include ('index_tab1.php'); ?></div>
								<div class="tab-pane" id="tab4"><?php include ('index_tab4.php'); ?></div> 
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
		
		
		<input name="mens_de"  		type="hidden" id="mens_de" 		value='<?php echo $_SESSION['USUA_DE'];  ?>'    />
		<input name="mens_de_tipo"  type="hidden" id="mens_de_tipo" value='<?php echo $_SESSION['USUA_TIPO']; ?>'    />
		<?php include("template/scripts.php");?>
		<!-- ===================== -->
		<?php include('modal_changelog.php');?>
		<!-- =============================== -->
		<script>
			$(function () {
				$('#myTab a:last').tab('show');
			})
		</script>
	</body>
</html>