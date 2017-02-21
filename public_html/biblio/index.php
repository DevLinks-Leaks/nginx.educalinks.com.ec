<!DOCTYPE html>
<html lang="es">
    <?php include("Templates/head.php");?>
	<?php session_activa(); ?>
    <body class="hold-transition skin-blue sidebar-mini">
		<div class="wrapper">
			<?php include("Templates/navbar.php");?>
			<?php include("Templates/menu.php");?>
			<div class="content-wrapper">
				<section class="content-header">
					<h1>Atención bibliotecaria a visitas
						<small>Ingreso de nuevo registro</small>
					</h1>
					<!-- <ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-plus"></i></a></li>
						<li class="active">Atención biblioteca a visitas</li>
					</ol> -->
				</section>
				<section class="content" id="formulario">
					<?php include("index_view.php");?>
				</section>
				<?php include("Templates/menu_sidebar.php");?>
			</div>
			<form id="frm_actu" name="frm_actu" method="post" action="" enctype="multipart/form-data">
				<?php include("Templates/rutas.php");?>
			</form>
			<?php include("Templates/footer.php");?>
		</div>
		<!-- =============================== -->
		
		<?php include("Templates/scripts.php");?>
	</body>
</html>