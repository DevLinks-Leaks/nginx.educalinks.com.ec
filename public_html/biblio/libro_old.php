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
					<h1>Libros
						<small>Registro nuevo</small>
					</h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-plus"></i></a></li>
						<li class="active">Libros</li>
					</ol>
				</section>
				<section class="content" id="formulario">
					<div id="Main_div" >
						<div id="semana_deta" > 
							<?php include("libro_view_old.php"); ?>
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
		<!-- InstanceBeginEditable name="Script Finales" -->        
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
                
        $(document).ready(function(){   
	       
            var table = $('#table_cons_Colecciones').DataTable({select: false,lengthChange: false,searching: true,language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'}});
            table.columns.adjust().draw();
       	
		
			$('#table_cons_Colecciones tbody').on( 'click', 'tr', function () {
					      var table2 = $('#table_cons_Colecciones').DataTable();

					var idx = table2.row(this).index();
					document.getElementById('libr_cole_codi').value=table2.cell( idx, 0).data();
					document.getElementById('libr_cole_deta').value=document.getElementById('libr_cole_deta_' + table2.cell( idx, 0).data()).innerHTML; 
					$('#modal_colecciones').modal('hide');
			});
		
		});
		
		$(document).ready(function(){   
	       
            var table = $('#table_cons_Categorias').DataTable({select: false,lengthChange: false,searching: true,language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'}});
            table.columns.adjust().draw();
       	
		
			$('#table_cons_Categorias tbody').on( 'click', 'tr', function () {
					
					var table2 = $('#table_cons_Categorias').DataTable();

					var idx = table2.row(this).index();
					libr_cole_codi=table2.cell( idx, 0).data();
					libr_cole_deta=document.getElementById('cate_deta_' + idx).innerHTML; 
					
					var obj = document.getElementById("cate_codi");
					opt = document.createElement("option");
					opt.value = libr_cole_codi;
					opt.text=libr_cole_deta;
					obj.appendChild(opt);
					
					$('#modal_colecciones').modal('hide');
			});
		
		}); 
		
		function elimina_option(Select_id) {
			if (document.getElementById(Select_id).selectedIndex>=0){
				var x = document.getElementById(Select_id);
				x.remove(x.selectedIndex);
			}
		}
   		</script>      
		<script>
              
				var Libros = new C_Libros();
								
				Libros.libr_tipo_view(<?= $libr_tipo_codi; ?>,'div_revista','div_video')
				function boton_click(OP){
					//Carga de valores			
					
                                        
					libr_codi_impr=         document.getElementById('libr_codi_impr').value;
					libr_titu=		document.getElementById('libr_titu').value;
					
					libr_auto_codi=         document.getElementById('libr_auto_codi').value;
					libr_cole_codi=         document.getElementById('libr_cole_codi').value;
					libr_edit_codi=         document.getElementById('libr_edit_codi').value;
					libr_tipo_codi=         selectvalue(document.getElementById('libr_tipo_codi'));
					
					libr_issn=		document.getElementById('libr_issn').value;
					libr_isbn=		document.getElementById('libr_isbn').value;
					libr_revi_nume=		document.getElementById('libr_revi_nume').value;
					
					libr_fech_publ=         document.getElementById('libr_fech_publ').value;
					libr_fech_ingr=         document.getElementById('libr_fech_ingr').value;
					
					libr_obse=		document.getElementById('libr_obse').value;
					
					
					
					libr_vide_dire=		document.getElementById('libr_vide_dire').value;
					libr_vide_acto=		document.getElementById('libr_vide_acto').value;
					libr_vide_inte=		document.getElementById('libr_vide_inte').value;
					libr_vide_orig=		document.getElementById('libr_vide_orig').value;
					libr_vide_dura=		document.getElementById('libr_vide_dura').value;
					libr_vide_gene=		document.getElementById('libr_vide_gene').value;
					libr_vide_resu=		document.getElementById('libr_vide_resu').value;
					
					libr_cara=		document.getElementById('libr_cara');
					
					
                                        if (OP=='N'){
                                            //envio de valors
                                            Libros.libr_add(libr_codi_impr,libr_titu,libr_auto_codi,libr_edit_codi,libr_cole_codi,libr_tipo_codi,libr_isbn,libr_issn,libr_revi_nume,libr_fech_publ,libr_fech_ingr,libr_obse,libr_vide_dire,libr_vide_acto,libr_vide_inte,libr_vide_orig,libr_vide_dura,libr_vide_gene,libr_vide_resu,libr_cara);	
                                    
										}else if (OP=='U'){
                                            libr_codi=<?= $libr_codi;?>;
                                            //envio de valors
                                            Libros.libr_upd(libr_codi,libr_codi_impr,libr_titu,libr_auto_codi,libr_edit_codi,libr_cole_codi,libr_tipo_codi,libr_isbn,libr_issn,libr_revi_nume,libr_fech_publ,libr_fech_ingr,libr_obse,libr_vide_dire,libr_vide_acto,libr_vide_inte,libr_vide_orig,libr_vide_dura,libr_vide_gene,libr_vide_resu,libr_cara);	
										}
					//load_ajax_get('ordeno_deta','ordeno_view.php');					
					//$('#myModal').modal('hide');
				}
				
        </script>				   
		<!-- Button trigger modal -->
		<?php include("clases/HTML/Libros_modales_editorial.php"); ?>
		<?php include("clases/HTML/Libros_modales_autores.php"); ?>
		<?php include("clases/HTML/Libros_modales_colecciones.php"); ?>
		<?php include("clases/HTML/Libros_modales_categorias.php"); ?>
		<!-- InstanceEndEditable -->
	</body>
</html>
