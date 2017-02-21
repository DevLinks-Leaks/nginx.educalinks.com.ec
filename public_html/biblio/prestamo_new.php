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
					<h1>Prestamos
						<small>Nuevo</small>
					</h1>
					<!-- <ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-plus"></i></a></li>
						<li class="active">Prestamos</li>
					</ol> -->
				</section>
				<section class="content" id="formulario">
					<div id="Main_div" >
						<div id="semana_deta" > 
							<?php include("prestamo_new_view.php"); ?>
						</div>
						<div id="resu">
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
	       
            var table = $('#tbl_items').DataTable({
						select: false,
						lengthChange: false,
						searching: true,
						
						language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'}
					});
	            table.columns.adjust().draw();
			load_ajax_item_prest('prestamos_items','prestamo_items_view.php',0);
		});

		   $('#pres_fech_devo').datetimepicker({
            format: 'DD/MM/YYYY',
            locale: 'es',
			defaultDate:'<?= date('d/M/Y'); ?>',
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
		
    	
    </script> 
    <?php include("clases/HTML/Libros_modales_usuarios.php"); ?> 
    <?php include("clases/HTML/Libros_modales_items.php"); ?>    
	</body>
</html>
