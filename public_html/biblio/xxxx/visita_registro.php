
<!DOCTYPE html>
<html lang="es"><!-- InstanceBegin template="/Templates/biblio.dwt.php" codeOutsideHTMLIsLocked="false" -->

<?php include("../Templates/head.php");?>
<?php session_activa(); ?>

<body role="document">
	<?php require("../Templates/navbar.php"); ?>
	<!-- InstanceBeginEditable name="submenu" -->
  
	<!-- InstanceEndEditable -->
    
    <div class="container-fluid">    
        <div id="Main_div" >
            <!-- InstanceBeginEditable name="Centro" -->  
             <div id="semana_deta" > 
        		<?php require("../visitas_view.php"); ?>
       		</div>
       
       <!-- Button trigger modal -->
            <?php include("../clases/HTML/Libros_modales_editorial.php"); ?>
          
        <!-- InstanceEndEditable -->
		</div>
    </div>
 
   
<?php include("../Templates/scripts.php");?>
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
		 
		
   		</script>      
    
         <script  >
              
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
					
				}
				
            </script> 
<!-- InstanceEndEditable -->
</body>
<!-- InstanceEnd --></html>
