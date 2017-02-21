<!DOCTYPE html>
<html lang="es">
    <?php include("../template/head.php");?>
    <body class="hold-transition skin-blue sidebar-mini">
		<div class="wrapper">
			<?php include("../template/navbar.php");?>
			<?php $active="cons_estudiantes";include("../template/menu.php");?>
			<div class="content-wrapper">
				<section class="content-header">
					<h1>Atención médica a visitas
						<small>Ingreso de nuevo registro</small>
					</h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-plus"></i></a></li>
						<li class="active">Atención médica a visitas</li>
					</ol>
				</section>
				<section class="content" id="formulario">
					<?php include("medi_medicinas_main.php");?>
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
		<script src="../js/med_medicinas.js"></script>
		<script type="text/javascript">          
			$(document).ready(function(){
				var table= $('#table_medicinas').DataTable({select: false,lengthChange: false,searching: false,language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'}});
				table.columns.adjust().draw();
				
				var $input = $('#med_descripcion');
				$.get('../medicinas_json.php', function(data){
					$input.typeahead({
						source:JSON.parse(data),
						items:'all'
					});
				});        
				$input.change(function() {
					var current = $input.typeahead("getActive");
					if (current) {
						// Some item from your model is active!
						if (current.name == $input.val()) {
							// This means the exact match is found. Use toLowerCase() if you want case insensitive match.
							$("#med_codigo").val(current.id);
						} else {
							// This means it is only a partial match, you can either add a new item 
							// or take the active if you don't want new items
							$("#med_codigo").val("0");
						}
					} else {
						// Nothing is active so it is a new value (or maybe empty value)
						$("#med_codigo").val("0");
					}
				});
				
			});
		</script>
	</body>
</html>