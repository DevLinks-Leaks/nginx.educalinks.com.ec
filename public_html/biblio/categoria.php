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
					<h1>Categoría
						<small>Listado de Categorías</small>
					</h1>
					<!-- <ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-plus"></i></a></li>
						<li class="active">Categorías</li>
					</ol> -->
				</section>
				<section class="content" id="formulario_categoria">
					<div id="Main_div" >
						<div id="categoria_main" > 
							<?php include("categoria_view.php"); ?>
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
		<!-- Modal Categoria -->
		<div class="modal fade" id="modal_categoria_add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	      	<div class="modal-dialog">
	        	<div class="modal-content">
	          		<div class="modal-header">
	            		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
	            		<h4 class="modal-title" id="myModalLabel">Nueva Categoría</h4>
	        		</div>
        			<div id="modal_main_categoria" class="modal-body">
	            		<div class="row">
							<div class="col-md-6 col-md-offset-3">
								<div class="form-group">
									<label for="cate_deta">Detalle:</label>
									<input class="form-control" id="cate_deta" name="cate_deta" type="text" placeholder="Ingrese el detalle de la categoría..." value="">
								</div>
							</div>
						</div>
	       			</div>
	        		<div class="modal-footer">
	            		<button id="btn_cate_add" type="button" class="btn btn-success" data-loading-text="Agregando..." onClick="load_ajax_add_cate('categoria_main','script_categorias.php','opc=add&cate_deta='+document.getElementById('cate_deta').value);" >Agregar</button>
	            		<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
	        		</div>
	    		</div>
			</div>
		</div>
		<!-- Modal Categoria Fin -->
		<!-- Modal Categoria -->
		<div class="modal fade" id="modal_categoria_edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	      	<div class="modal-dialog">
	        	<div class="modal-content">
	          		<div class="modal-header">
	            		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
	            		<h4 class="modal-title" id="myModalLabel">Editar Categoría</h4>
	        		</div>
        			<div id="modal_main_categoria" class="modal-body">
	            		<div class="row">
							<div class="col-md-6 col-md-offset-3">
								<div class="form-group">
									<label for="cate_deta">Detalle:</label>
									<input class="form-control" id="cate_deta_edit" name="cate_deta" type="text" placeholder="Ingrese el detalle de la categoría..." value="">
									<input type="hidden" name="cate_codi" value="" id="cate_codi">
								</div>
							</div>
						</div>
	       			</div>
	        		<div class="modal-footer">
	            		<button id="btn_cate_edit" type="button" class="btn btn-success" data-loading-text="Editando..." onClick="load_ajax_edit_cate('categoria_main','script_categorias.php','opc=edit&cate_deta='+document.getElementById('cate_deta_edit').value+'&cate_codi='+document.getElementById('cate_codi').value);" >Editar</button>
	            		<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
	        		</div>
	    		</div>
			</div>
		</div>
		<!-- Modal Categoria Fin -->
		<!-- Modal Categoria -->
		<div class="modal fade bs-example-modal-sm" id="modal_categoria_del" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	      	<div class="modal-dialog modal-sm">
	        	<div class="modal-content">
	          		<div class="modal-header">
	            		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
	            		<h4 class="modal-title" id="myModalLabel">Mensaje de confirmación</h4>
	        		</div>
        			<div id="modal_main_categoria" class="modal-body">
	            		<div class="row">
							<div class="col-md-12">
								<center><h4>¿Está seguro que desea eliminar esta categoría?</h4></center>
								<input type="hidden" name="cate_codi" value="" id="cate_codi_del">
							</div>
						</div>
	       			</div>
	        		<div class="modal-footer">
	        			<div class="row">
	        				<div class="col-md-6">
		            			<center><button id="btn_cate_del" type="button" class="btn btn-danger" data-loading-text="Eliminando..." onclick="load_ajax_del_cate('categoria_main','script_categorias.php','opc=del&cate_codi='+document.getElementById('cate_codi_del').value);" ><span class="fa fa-check" aria-hidden="true"></span> Eliminar</button></center>
		            		</div>
		            		<div class="col-md-6">
		            			<center><button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-times" aria-hidden="true"></span> Cancelar</button></center>
	            			</div>
	            		</div>
	        		</div>
	    		</div>
			</div>
		</div>
		<!-- Modal Categoria Fin -->
		<script>
		    $(document).ready(function() {
		        $('#tbl_categorias').addClass( 'nowrap' ).DataTable({
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
