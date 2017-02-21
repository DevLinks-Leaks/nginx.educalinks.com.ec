<!DOCTYPE html>
<html lang="es">
    <?php include("template/head.php");?>
    <?php include("template/scripts.php");?>
    <body class="hold-transition skin-blue sidebar-mini">
		<div class="wrapper">
			<?php include ('template/header.php');?>
			<?php $active="cons_estudiantes";include("template/menu.php");?>
			<div class="content-wrapper">
				<section class="content-header">
					<h1>Agendas
						<small>Tareas y lecciones</small>
					</h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-calendar"></i></a></li>
						<li class="active">Agendas</li>
					</ol>
				</section>
				<section class="content" id="mainPanel">
					<div id="information">
						<div class="panel panel-default">
							<div class="panel-heading">
								<h3 class="panel-title">
									Agenda
								</h3>
							</div>
							<div class="panel-body">
								<div class="row">
									<div class="col-md-3">
										<div class="box box-default">
											<div class="box-header with-border">
												<h4 class="box-title">Tipos Agenda</h4>
											</div>
											<div class="box-body no-padding">
												<div style="background-color: #c3ffc1;postion: relative;">Agendas Activas</div>
												<div style="background-color: #ffcccc;postion: relative;">Agendas por Terminar</div>
												<div style="background-color: #D1F2EB;postion: relative;">Agendas Pendientes</div>
												<div style="background-color: #F5F5F5;postion: relative;">Agendas Inactivas</div>
											</div>
										</div>
									</div>
									<div class="col-md-9">
										<div class="box box-default">
											<div class="box-body no-padding">
												<?php include("agenda_main.php");?>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
							
					</div><!-- Information -->
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
		
		<script src="../js/med_fichas.js"></script>
		
	</body>
</html>