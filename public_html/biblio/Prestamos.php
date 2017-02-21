<!DOCTYPE html>
<html lang="es">
    <?php include("Templates/head.php");?>
	<?php session_activa(); ?>
	<body class="hold-transition skin-green-light layout-top-nav">
		<div class="wrapper">
			<?php include("Templates/navbar.php");?>
			<?php $active="cons_estudiantes";?>
			<div class="content-wrapper">
				<section class="content-header">
					<h1>Visitas
						<small>Registro nuevo</small>
					</h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-plus"></i></a></li>
						<li class="active">Visitas</li>
					</ol>
				</section>
				<section class="content" id="formulario">
					<div id="Main_div" >
						<div id="semana_deta" > 
							<?php include("Prestamos_view.php"); ?>
						</div>
					</div>
				</section>
				<?php include("Templates/menu_sidebar.php");?>
			</div>
			<form id="frm_actu" name="frm_actu" method="post" action="" enctype="multipart/form-data">
				<?php include("Templates/rutas.php");?>
			</form>
			<?php include("Templates/footer.php");?>
		</div>
		<?php include("Templates/scripts.php");?>
		<script>
		$(document).ready(function(){   
			var table = $('#table_cons_prestamos').DataTable({select: false,lengthChange: false,searching: true,language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'}});
				table.columns.adjust().draw();
			});
			function prestamos_ver()
			{}
		</script>
	</body>
</html>