<!DOCTYPE html>
<html lang="es">
<?php include("../template/head.php");?>
	<body class="hold-transition skin-blue sidebar-mini">
		<div class="wrapper">
			<?php include("../template/navbar.php");?>
			<?php $active="cons_estudiantes";include("../template/menu.php");?>
			<div class="content-wrapper">
				<section class="content-header">
					<h1>Reporte de inventarios
						<small></small>
					</h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-plus"></i></a></li>
						<li class="active">Reporte de inventarios</li>
					</ol>
				</section>
				<section class="content" id="formulario">
					<?php include("rep_inventarios_main.php");?>
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
		<script src="../js/med_fichas.js"></script>
		<script type="text/javascript">  
			$(document).ready(function(){  
				$('#fecha_ini').datetimepicker({
					format: 'DD/MM/YYYY',
					locale: 'es',
					showTodayButton: true,
					tooltips: {
						today: 'Ir al día actual',
						clear: 'Borrar selección',
						close: 'Cerrar el Seleccionador',
						selectMonth: 'Seleccione el Mes',
						prevMonth: 'Mes Anterior',
						nextMonth: 'Mes Siguiente',
						selectYear: 'Seleccione el Año',
						prevYear: 'Año Anterior',
						nextYear: 'Año Siguiente',
						selectDecade: 'Seleccione la Década',
						prevDecade: 'Década Anterior',
						nextDecade: 'Década Siguiente',
						prevCentury: 'Siglo Anterior',
						nextCentury: 'Siglo Siguiente'
					}
				});
				$('#fecha_fin').datetimepicker({
					format: 'DD/MM/YYYY',
					locale: 'es',
					showTodayButton: true,
					tooltips: {
						today: 'Ir al día actual',
						clear: 'Borrar selección',
						close: 'Cerrar el Seleccionador',
						selectMonth: 'Seleccione el Mes',
						prevMonth: 'Mes Anterior',
						nextMonth: 'Mes Siguiente',
						selectYear: 'Seleccione el Año',
						prevYear: 'Año Anterior',
						nextYear: 'Año Siguiente',
						selectDecade: 'Seleccione la Década',
						prevDecade: 'Década Anterior',
						nextDecade: 'Década Siguiente',
						prevCentury: 'Siglo Anterior',
						nextCentury: 'Siglo Siguiente'
					}
				});
			});
		</script>
	</body>
</html>