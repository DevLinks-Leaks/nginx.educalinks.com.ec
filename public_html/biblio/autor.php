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
					<h1>Autores
						<small>Listado de Autores</small>
					</h1>
					<!-- <ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-plus"></i></a></li>
						<li class="active">Autores</li>
					</ol> -->
				</section>
				<section class="content" id="formulario_autor">
					<div id="Main_div" >
						<div id="autor_main" > 
							<?php include("autor_view.php"); ?>
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
		<!-- Modal autor -->
		<div class="modal fade" id="modal_autor_add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	      	<div class="modal-dialog">
	        	<div class="modal-content">
	          		<div class="modal-header">
	            		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
	            		<h4 class="modal-title" id="myModalLabel">Nuevo Autor</h4>
	        		</div>
        			<div id="modal_main_autor" class="modal-body">
        				<div class="row">
							<div class="col-md-6 col-md-offset-3">
								<div class="form-group">
									<label for="auto_nomb">Nombre:</label>
									<input class="form-control" id="auto_nomb" name="auto_nomb" type="text" placeholder="Ingrese el nombre del autor..." value="">
								</div>
							</div>
						</div>
	            		<div class="row">
							<div class="col-md-6 col-md-offset-3">
								<div class="form-group">
									<label for="auto_apel">Apellido:</label>
									<input class="form-control" id="auto_apel" name="auto_apel" type="text" placeholder="Ingrese el apellido del autor..." value="">
								</div>
							</div>
						</div>
	       			</div>
	        		<div class="modal-footer">
	            		<button id="btn_auto_add" type="button" class="btn btn-success" data-loading-text="Agregando..." onClick="load_ajax_add_auto('autor_main','script_autores.php','opc=add&auto_apel='+document.getElementById('auto_apel').value+'&auto_nomb='+document.getElementById('auto_nomb').value);" >Agregar</button>
	            		<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
	        		</div>
	    		</div>
			</div>
		</div>
		<!-- Modal autor Fin -->
		<!-- Modal autor -->
		<div class="modal fade" id="modal_autor_edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	      	<div class="modal-dialog">
	        	<div class="modal-content">
	          		<div class="modal-header">
	            		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
	            		<h4 class="modal-title" id="myModalLabel">Editar Autor</h4>
	        		</div>
        			<div id="modal_main_autor" class="modal-body">
        				<div class="row">
							<div class="col-md-6 col-md-offset-3">
								<div class="form-group">
									<label for="auto_nomb">Nombre:</label>
									<input class="form-control" id="auto_nomb_edit" name="auto_nomb" type="text" placeholder="Ingrese el nombre del autor..." value="">
								</div>
							</div>
						</div>
	            		<div class="row">
							<div class="col-md-6 col-md-offset-3">
								<div class="form-group">
									<label for="auto_apel">Apellido:</label>
									<input class="form-control" id="auto_apel_edit" name="auto_apel" type="text" placeholder="Ingrese el apellido del autor..." value="">
									<input type="hidden" name="auto_codi" value="" id="auto_codi">
								</div>
							</div>
						</div>
	       			</div>
	        		<div class="modal-footer">
	            		<button id="btn_auto_edit" type="button" class="btn btn-success" data-loading-text="Editando..." onClick="load_ajax_edit_auto('autor_main','script_autores.php','opc=edit&auto_apel='+document.getElementById('auto_apel_edit').value+'&auto_nomb='+document.getElementById('auto_nomb_edit').value+'&auto_codi='+document.getElementById('auto_codi').value);" >Editar</button>
	            		<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
	        		</div>
	    		</div>
			</div>
		</div>
		<!-- Modal autor Fin -->
		<!-- Modal autor -->
		<div class="modal fade bs-example-modal-sm" id="modal_autor_del" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	      	<div class="modal-dialog modal-sm">
	        	<div class="modal-content">
	          		<div class="modal-header">
	            		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
	            		<h4 class="modal-title" id="myModalLabel">Mensaje de confirmación</h4>
	        		</div>
        			<div id="modal_main_autor" class="modal-body">
	            		<div class="row">
							<div class="col-md-12">
								<center><h4>¿Está seguro que desea eliminar este autor?</h4></center>
								<input type="hidden" name="auto_codi" value="" id="auto_codi_del">
							</div>
						</div>
	       			</div>
	        		<div class="modal-footer">
	        			<div class="row">
	        				<div class="col-md-6">
		            			<center><button id="btn_auto_del" type="button" class="btn btn-danger" data-loading-text="Eliminando..." onclick="load_ajax_del_auto('autor_main','script_autores.php','opc=del&auto_codi='+document.getElementById('auto_codi_del').value);" ><span class="fa fa-check" aria-hidden="true"></span> Eliminar</button></center>
		            		</div>
		            		<div class="col-md-6">
		            			<center><button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-times" aria-hidden="true"></span> Cancelar</button></center>
	            			</div>
	            		</div>
	        		</div>
	    		</div>
			</div>
		</div>
		<!-- Modal autor Fin -->
		<script>
		    $(document).ready(function() {
		        $('#tbl_autores').addClass( 'nowrap' ).DataTable({
					//dom: 'Bfrtip',
					// buttons: [ 
					// 	{ extend: 'copy', text: 'Copiar <i class="fa fa-copy"></i>' },
					// 	{ extend: 'csv', text: 'CSV <i style="color:green" class="fa fa-file-excel-o"></i>' },
					// 	{ extend: 'excel', text: 'Excel <i style="color:green" class="fa fa-file-excel-o"></i>' },
					// 	{ extend: 'pdf', text: 'PDF <i style="color:red" class="fa fa-file-pdf-o"></i>' },
					// 	{ extend: 'print', text: 'Imprimir <i style="color:#428bca" class="fa fa-print"></i>' },
					// 	],
					"bPaginate": true, //paginacion anterior siguiente
					"bStateSave": false, //nose
					"bAutoWidth": false,
					"bScrollAutoCss": true,
					"bProcessing": true,
					"bRetrieve": true,
					"aLengthMenu": [[10,25, 50, 100, -1], [10,25, 50, 100, "Todos"]],
					"sScrollXInner": "110%",
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
