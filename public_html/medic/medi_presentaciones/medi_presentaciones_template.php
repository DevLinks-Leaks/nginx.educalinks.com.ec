<!DOCTYPE html>
<html lang="es">
    <?php include("../template/head.php");?>
   <body class="hold-transition skin-blue sidebar-mini">
		<div class="wrapper">
			<?php include("../template/navbar.php");?>
			<?php $active="cons_estudiantes";include("../template/menu.php");?>
			<div class="content-wrapper">
				<section class="content-header">
					<h1>Atención médica estudiantil
						<small>Ingreso de nuevo registro</small>
					</h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-plus"></i></a></li>
						<li class="active">Atención médica estudiantil</li>
					</ol>
				</section>
				<section class="content" id="formulario">
					<?php include("medi_presentaciones_main.php");?>
				</section>
				<?php include("../template/menu_sidebar.php");?>
			</div>
			<form id="frm_actu" name="frm_actu" method="post" action="" enctype="multipart/form-data">
				<?php include("../template/rutas.php");?>
			</form>
			<?php include("../template/footer.php");?>
		</div>
		<!-- =============================== -->
		        
		<?php include("../template/scripts.php");?>
    <script src="../js/med_presentaciones.js"></script>
    <script type="text/javascript">          
        $(document).ready(function(){
            var table= $('#table_presentaciones').DataTable({select: false,lengthChange: false,searching: false,language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'}});
            table.columns.adjust().draw();
        });
    </script>
  </body>
</html>