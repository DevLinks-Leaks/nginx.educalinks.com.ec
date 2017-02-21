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
					<h1>Citas
						<small>Citas</small>
					</h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-clock-o"></i></a></li>
						<li class="active">Citas</li>
					</ol>
				</section>
				<section class="content" id="mainPanel">
					<div id="information">
						
						<?php include ('citas_main.php'); ?>

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
		
		<script src="../medic/js/med_fichas.js"></script>
		
	</body>
</html>