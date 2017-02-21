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
					<!-- <ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-plus"></i></a></li>
						<li class="active">Visitas</li>
					</ol> -->
				</section>
				<section class="content" id="formulario">
					<div id="Main_div" >
						<div id="semana_deta" > 
							<?php include("Prestamo_nuevo_view.php"); ?>
						</div>
						<div id="resu">
							xx
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
	       
            var table = $('#table_cons_Usuarios').DataTable({select: false,lengthChange: false,searching: true,language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'}});
            table.columns.adjust().draw();
       	
		
			$('#table_cons_Usuarios tbody').on( 'click', 'tr', function () {
					var table2 = $('#table_cons_Usuarios').DataTable();

					var idx = table2.row(this).index();
					var idx_ref = table2.cell( idx, 0).data();
					document.getElementById('usua_codi').value=document.getElementById('usua_codi_' + idx_ref).innerHTML; 
					document.getElementById('usua_nomb').value=document.getElementById('usua_nomb_' + idx_ref).innerHTML; 
					document.getElementById('usua_tipo_codi').value=document.getElementById('usua_tipo_codi_' + idx_ref).innerHTML;
					document.getElementById('usua_tipo_deta').value=document.getElementById('usua_tipo_deta_' + idx_ref).innerHTML; 
					$('#modal_usuarios').modal('hide');
			});
		
		});
		
		  $(document).ready(function(){   
	       
            var table = $('#table_cons_libros_ejemplares').DataTable({select: false,lengthChange: false,searching: true,language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'}});
            table.columns.adjust().draw();
       	
		
			$('#table_cons_libros_ejemplares tbody').on( 'click', 'tr', function () {
					var table3 = $('#table_cons_libros_ejemplares').DataTable();

					var idx = table3.row(this).index();
					var idx_ref = table3.cell( idx, 0).data();
					document.getElementById('libr_ejem_codi').value=document.getElementById('libr_ejem_codi_' + idx_ref).innerHTML; 
					document.getElementById('libr_titu').value=document.getElementById('libr_titu_' + idx_ref).innerHTML; 
					 
					$('#modal_ejemplares').modal('hide');
			});
		
		});
		
		   $('#pres_fech_inic').datetimepicker({
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
		
    	function boton_prestar(){
			
			var Prestamos = new C_Prestamos();
			//Carga de valores			
			
                                        
			usua_codi=         	document.getElementById('usua_codi').value;
			usua_tipo_codi=		document.getElementById('usua_tipo_codi').value;
				 
			libr_ejem_codi	=         document.getElementById('libr_ejem_codi').value;
			pres_fech_inic	=         document.getElementById('pres_fech_inic').value;
		 
			pres_obse_inic=		document.getElementById('pres_obse_inic').value;
			
			Prestamos.lib_pres_add(usua_codi,usua_tipo_codi,libr_ejem_codi,pres_fech_inic,pres_obse_inic);	
                             
			
		}
    </script> 
    <?php include("clases/HTML/Libros_modales_usuarios.php"); ?> 
    <?php include("clases/HTML/Libros_modales_ejemplares.php"); ?>    
	</body>
</html>
