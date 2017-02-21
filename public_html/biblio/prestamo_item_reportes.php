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
					<h1>Prestamos Items
						<small>Reporte</small>
					</h1>
					<!-- <ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-plus"></i></a></li>
						<li class="active">Prestamo Reporte</li>
					</ol> -->
				</section>
				<section class="content" id="formulario_prestamo">
					<div id="Main_div" >
						<div id="prestamo_main" > 
							<?php include("prestamo_item_reportes_view.php"); ?>
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
		    $(document).ready(function() {
		        $('#tbl_prestamos_reportes').addClass( 'nowrap' ).DataTable({
					dom: 'Bfrtip',
					buttons: [ 
						{ extend: 'copy', text: 'Copiar <i class="fa fa-copy"></i>' },
						{ extend: 'csv',  text: 'CSV <i style="color:green" class="fa fa-file-excel-o"></i>' },
						{ extend: 'excel', orientation: 'landscape', text: 'Excel <i style="color:green" class="fa fa-file-excel-o"></i>' },
						{ extend: 'pdf', orientation: 'landscape', text: 'PDF <i style="color:red" class="fa fa-file-pdf-o"></i>' },
						{ extend: 'print', orientation: 'landscape', text: 'Imprimir <i style="color:#428bca" class="fa fa-print"></i>' },
						],
					"bPaginate": true, //paginacion anterior siguiente
					"bStateSave": false, //nose
					"bAutoWidth": false,
					"bScrollAutoCss": true,
					"bProcessing": true,
					"bRetrieve": true,
					"aLengthMenu": [[10,25, 50, 100, -1], [10,25, 50, 100, "Todos"]],
					"sScrollXInner": "110%",
					"scrollX": true,
					"ordering": false,
					"fnInitComplete": function() {
						this.css("visibility", "visible");
					},
					paging: true,
					lengthChange: true,
					searching: true,
					language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'}
				});
		    } );
		</script>
		<!-- InstanceBeginEditable name="Script Finales" -->        		   
		<!-- Button trigger modal -->

		<!-- InstanceEndEditable -->
	</body>
</html>
