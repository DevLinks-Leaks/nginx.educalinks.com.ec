<!DOCTYPE html>
<html lang="es">
    <?php include("template/head.php");?>
    <body class="hold-transition skin-blue sidebar-mini <?php echo $_SESSION['sidebar_status']; ?>">
		<div class="wrapper">
			<?php include ('template/header.php');?>
			<?php $Menu=124;include("template/menu.php");?>
			<div class="content-wrapper">
				<section class="content-header">
					<?php
						$params = array($_SESSION['curs_para_codi']);
						$sql="{call curs_para_info(?)}";
						$curs_para_info = sqlsrv_query($conn, $sql, $params);  
						$row_curs_para_info = sqlsrv_fetch_array($curs_para_info);
				  	?>
					<h1>Motivos de bloqueo</h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-ban"></i></a></li>
						<li class="active">Motivos de bloqueo</li>
					</ol>
				</section>
				<section class="content" id="mainPanel">
					<script type="text/javascript" src="js/funciones_motivo_bloqueo.js"></script> 
                    <div id="information">
						<div class="box box-default">
							<div class="box-header with-border">
								<h3 class="box-title">
									<?php if (permiso_activo(516)){?>
										<a class="btn btn-primary" data-toggle="modal" data-target="#ModalMotiAdd" 
											title=""><span class="fa fa-plus"></span> Agregar Motivo</a>
									<?php }?>
									<a class="btn btn-info" href='alumnos_main.php'
										title=""><span class="fa fa-graduation-cap"></span> Ir a bandeja de alumnos</a>
								</h3>
							</div><!-- /.box-header -->
							<div class="box-body">
								<div id="moti_main" >
									<?php include ('motivo_bloqueo_main_lista.php'); ?>
								</div>

							</div>
						</div>
					</div>
				</section>
				<?php include("template/menu_sidebar.php");?>
			</div>
			<form id="frm_actu" name="frm_actu" method="post" action="" enctype="multipart/form-data">
				<?php include("template/rutas.php");?>
			</form>
			<?php include("template/footer.php");?>
		</div>
		<!-- =============================== -->
		<input name="mens_de"  		type="hidden" id="mens_de" 		value='<?php echo $_SESSION['USUA_DE'];  ?>'    />
		<input name="mens_de_tipo"  type="hidden" id="mens_de_tipo" value='<?php echo $_SESSION['USUA_TIPO']; ?>'    />
		<?php include("template/scripts.php");?>
		<script type="text/javascript" charset="utf-8">
			$(document).ready(function() {
				$('#moti_table').DataTable({
					"bPaginate": true,
					"bStateSave": false,
					"bAutoWidth": false,
					"bScrollAutoCss": true,
					"bProcessing": true,
					"bRetrieve": true,
					"sDom": '<"H"CTrf>t<"F"lip>',
					"aLengthMenu": [[10,25, 50, 100, -1], [10,25, 50, 100, "Todos"]],
					"sScrollXInner": "110%",
					"fnInitComplete": function() {
						this.css("visibility", "visible");
					},
					paging: true,
					lengthChange: true,
					searching: true,
					language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'},
					"columnDefs": [
						{className: "dt-body-left"  , "targets": [0]},
						{className: "dt-body-left"  , "targets": [1]},
						{className: "dt-body-center", "targets": [2]}
					]
				});
				var table = $('#moti_table').DataTable();
				table.column( '0:visible' ).order( 'asc' );
			} );
		</script>
	</body>
</html>
<div class="modal fade" 
	 id="ModalMotiAdd" 
	 tabindex="-1" 
	 role="dialog" 
	 aria-labelledby="myModalLabel" 
	 aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button 
					type="button" 
					class="close" 
					data-dismiss="modal">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">Nuevo motivo</h4>
			</div>
			<div id="modal_main" class="modal-body">
				<div id="div_docu_nuev"> 
					<form 
						id="frm_docu_add" 
						name="frm_docu_add" 
						method="post" 
						action="" 
						enctype="multipart/form-data">
						<table width="100%">
							<tr>
								<td width="25%">
									Motivo
								</td>
								<td style="margin-top:5px">
									<input id="txt_motivo" type="text" style="width: 90%" value="" />
								</td>
							</tr>
							<tr>
								<td width="25%">
									Bloqueo obligatorio
								</td>
								<td style="margin-top:5px">
									<input id="check_obligatorio" type="checkbox" style="margin-top: 10px" checked />
								</td>
							</tr>
						</table>
						<div class="form_element">&nbsp;</div>   
					</form>
				</div>
			</div>
			<div class="modal-footer">
				<button 
					type="button" 
					class="btn btn-success" 
					data-dismiss="modal"
					onClick="load_ajax_moti('moti_main','script_moti_bloq.php','add',0);" 
						><span class='fa fa-floppy-o'></span> Guardar Cambios</button>
				<button 
					type="button" 
					class="btn btn-default" 
					data-dismiss="modal">
						Cerrar
				</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" 
	 id="ModalMotiEdi" 
	 tabindex="-1" 
	 role="dialog" 
	 aria-labelledby="myModalLabel" 
	 aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button 
					type="button" 
					class="close" 
					data-dismiss="modal">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">Editar motivo</h4>
			</div>
			<div id="modal_main" class="modal-body">
				<div id="div_docu_nuev"> 
					<form 
						id="frm_moti_edit" 
						name="frm_moti_edit" 
						method="post" 
						action="" 
						enctype="multipart/form-data">
						<table width="100%">
							<tr>
								<td width="20%">
									Motivo
								</td>
								<td style="margin-top:5px">
									<input id="txt_moti_bloq_deta" type="text" style="width: 90%" value="" />
									<input id="txt_moti_bloq_codi" type="hidden" value="" />
								</td>
							</tr>
							<tr>
								<td width="25%">
									Bloqueo obligatorio
								</td>
								<td style="margin-top:5px">
									<input id="check_moti_bloq_obli" type="checkbox" style="margin-top: 10px"/>
								</td>
							</tr>
						</table>
						<div class="form_element">&nbsp;</div>   
					</form>
				</div>
			</div>
			<div class="modal-footer">
				<button 
					type="button" 
					class="btn btn-success" 
					data-dismiss="modal"
					onClick="load_ajax_moti('moti_main','script_moti_bloq.php','upd',document.getElementById('txt_moti_bloq_codi').value);" 
						><span class='fa fa-floppy-o'></span> Guardar Cambios</button>
				<button 
					type="button" 
					class="btn btn-default" 
					data-dismiss="modal">
						Cerrar
				</button>
			</div>
		</div>
	</div>
</div>