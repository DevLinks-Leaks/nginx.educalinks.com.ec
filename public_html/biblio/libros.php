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
					<h1>Mantenimiento
						<small>Libros</small>
					</h1>
					<!-- <ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-plus"></i></a></li>
						<li class="active">Mantenimiento</li>
					</ol> -->
				</section>
				<section class="content" id="formulario">
					<div id="Main_div" >
						<div id="semana_deta" > 
							<?php require("libros_view.php"); ?>
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
		
        <script type="text/javascript">        
        $(document).ready(function(){  
            $('#tb_libros').DataTable({
                lengthChange: false,
                searching: false,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'
                }
            });
			
			$('input.busca_todos').on( 'keyup click', function () {
       	 	filterGlobal();
        });
		
		function filterGlobal() {
			$('#example').DataTable().search(
				$('#busca_todos').val()				 
			).draw();
		}
		
	
    } );
 
 
    </script>    
    
     <script type="text/javascript">        
            $('#libr_fech_publ').datetimepicker({
				format: 'DD/MM/YYYY',
				locale: 'es',
				defaultDate:'<?= date_format($libr_fech_publ, 'd/M/Y' ); ?>',
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
		
			$('#libr_fech_ingr').datetimepicker({
				format: 'DD/MM/YYYY',
				locale: 'es',
				defaultDate:'<?= date_format($libr_fech_ingr, 'd/M/Y' ); ?>',
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
			$(document).ready(function(){   
			   
				var table = $('#table_cons_Editorialess').DataTable({select: false,lengthChange: false,searching: true,language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'}});
				table.columns.adjust().draw();
			
			
				$('#table_cons_Editorialess tbody').on( 'click', 'tr', function () {
							  var table2 = $('#table_cons_Editorialess').DataTable();

						var idx = table2.row(this).index();
						document.getElementById('libr_edit_codi').value=table2.cell( idx, 0).data();
						document.getElementById('libr_edit_deta').value=document.getElementById('nombre_' + table2.cell( idx, 0).data()).innerHTML; 
						$('#modal_editorial').modal('hide');
				});
			
			});
			$(document).ready(function(){   
			   
				var table = $('#table_cons_Autores').DataTable({select: false,lengthChange: false,searching: true,language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'}});
				table.columns.adjust().draw();
			
			
				$('#table_cons_Autores tbody').on( 'click', 'tr', function () {
							  var table2 = $('#table_cons_Autores').DataTable();

						var idx = table2.row(this).index();
						document.getElementById('libr_auto_codi').value=table2.cell( idx, 0).data();
						document.getElementById('libr_auto_deta').value=document.getElementById('libr_auto_deta_' + table2.cell( idx, 0).data()).innerHTML; 
						$('#modal_autores').modal('hide');
				});
			
			});
			$(document).ready(function()
			{   var table = $('#table_cons_Colecciones').DataTable({select: false,lengthChange: false,searching: true,language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'}});
				table.columns.adjust().draw();
				
				$('#table_cons_Colecciones tbody').on( 'click', 'tr', function () {
							  var table2 = $('#table_cons_Colecciones').DataTable();

						var idx = table2.row(this).index();
						document.getElementById('libr_cole_codi').value=table2.cell( idx, 0).data();
						document.getElementById('libr_cole_deta').value=document.getElementById('libr_cole_deta_' + table2.cell( idx, 0).data()).innerHTML; 
						$('#modal_colecciones').modal('hide');
				});
			});
			$(document).ready(function()
			{   var table = $('#table_cons_Categorias').DataTable({select: false,lengthChange: false,searching: true,language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'}});
				table.columns.adjust().draw();
				
				$('#table_cons_Categorias tbody').on( 'click', 'tr', function () {
						
						var table2 = $('#table_cons_Categorias').DataTable();

						var idx = table2.row(this).index();
						document.getElementById('libr_cole_codi').value=table2.cell( idx, 0).data();
						document.getElementById('libr_cole_deta').value=document.getElementById('libr_cole_deta_' + table2.cell( idx, 0).data()).innerHTML; 
						$('#modal_colecciones').modal('hide');
				});
			}); 
			</script>
			<script>
				var Libros = new C_Libros();
				
				function boton_click(OP)
				{   libr_codi_impr=	document.getElementById('libr_codi_impr').value;
					libr_titu	  = document.getElementById('libr_titu').value;
					
					libr_auto_codi= document.getElementById('libr_auto_codi').value;
					libr_cole_codi= document.getElementById('libr_cole_codi').value;
					libr_edit_codi= document.getElementById('libr_edit_codi').value;
					libr_tipo_codi= selectvalue(document.getElementById('libr_tipo_codi'));
					
					//load_ajax_get('ordeno_deta','ordeno_view.php');					
					//$('#myModal').modal('hide');
				}
				
            </script> 
		<?php require("clases/HTML/Libros_modales_editorial.php"); ?>  
	</body>
</html>