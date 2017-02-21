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
					<h1>Reportes de Registros
						<small>Registros de Visitas</small>
					</h1>
					<!-- <ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-plus"></i></a></li>
						<li class="active">Reportes de Registros</li>
					</ol> -->
				</section>
				<section class="content" id="formulario">
					<div id="Main_div" >
						<div class="panel panel-default">
							<div class="panel-heading"> 
								<div class="row">
								  <div class="col-md-6">Registros de Visitas
								  </div>
								  <div class="col-md-6 text-right"> <button type="button" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Imprimir</button>
								  </div>
								</div>
							
							  
							</div>
							<div class="panel-body">
								<div class="row">
									<div class="col-md-6 col-xs-12 col-sm-6 bottom_10" style="margin-top:10px;">
										<div class="row">
											<div class="col-md-5 col-xs-12 col-sm-6 bottom_10" >
												<div class="input-group">
													<span class="input-group-addon">Cod.:</span>
													<input type="text" class="form-control" id="usua_codi" name="usua_codi" placeholder="Usuario"  readonly>
												</div>
											</div>
											<div class="col-md-5 col-xs-12 col-sm-6 bottom_10"   >
												<div class="input-group">
													<span class="input-group-addon" ></span>
													<input type="text" class="form-control" id="usua_nomb" name="usua_nomb" placeholder="Nombre de Usuario"  readonly>
												</div>
											</div>
						  
											<div class="col-md-2 col-xs-12 col-sm-6 bottom_10">
												<button class="btn btn-info" data-toggle="modal" data-target="#modal_usuarios"><span class="glyphicon glyphicon-search"></span></button>
											</div>
										</div>                    
									</div>
									<div class="col-md-3 col-xs-12 col-sm-6 bottom_10" style="margin-top:10px;">
										<div class="input-group">
											<span class="input-group-addon">Desde:</span>
											<input type="text" class="form-control" id="visi_fech_ini" name="visi_fech_ini" value="<?=  date("1/m/Y"); ?>">
									   </div>
									   </div>
										  <div class="col-md-3 col-xs-12 col-sm-6 bottom_10" style="margin-top:10px;">
										 <div class="input-group">
											<span class="input-group-addon">Hasta:</span>
											<input type="text" class="form-control" id="visi_fech_fin" name="visi_fech_fin" value="<?=  date("d/m/Y"); ?>">
									   </div>
									</div>
								</div>
								
								<div class="row">
									<div class="col-md-6 col-xs-12 col-sm-6 bottom_10" style="margin-top:10px;">
										<div class="input-group">
											<span class="input-group-addon" >Tipo Usua.:</span>
											 <?php 
												$params = array();
												$sql="{call usua_tipo_view()}";
												$usua_tipo_view= sqlsrv_query($conn, $sql, $params);  
												$cc = 0;
						
											?>
											<select class="form-control"  id="usua_tipo_codi" >
												<option  value="0"  selected  >Todos..</option> 
												<?php  while ($row_usua_tipo_view = sqlsrv_fetch_array($usua_tipo_view)) {?> 
													<option  value="<?= $row_usua_tipo_view['usua_tipo_codi']; ?>"   >
														  <?= $row_usua_tipo_view['usua_tipo_deta']; ?>
													</option> 
												<?php  } ?>
											</select>
										 </div>
									</div>
								  
									<div class="col-md-6 col-xs-12 col-sm-6 bottom_10 text-right" style="margin-top:10px;">
										<button class="btn btn-info"  onClick="boton_buscar()"> <span class="glyphicon glyphicon-search" ></span> Buscar Visitas</button>
									</div>
								</div>
							</div>
						</div>
						<div class="panel panel-default"> 
							<div class="panel-body">                    
								<div class="row">
									<div class="col-md-12 col-xs-12 col-sm-6 bottom_10"  >
										<div id="div_visita" > 
											<?php require("visitas_view.php"); ?>
										</div>
									</div>
								</div>            		 
							</div>
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
            $('#visi_fech_ini').datetimepicker({
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
		
			$('#visi_fech_fin').datetimepicker({
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
	       
				var table = $('#table_cons_Usuarios').DataTable({select: false,lengthChange: false,searching: true,language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'}});
				table.columns.adjust().draw();
				
				$('#table_cons_Usuarios tbody').on( 'click', 'tr', function () {
						var table2 = $('#table_cons_Usuarios').DataTable();

						var idx = table2.row(this).index();
						var idx_ref = table2.cell( idx, 0).data();
						document.getElementById('usua_codi').value=document.getElementById('usua_codi_' + idx_ref).innerHTML; 
						document.getElementById('usua_nomb').value=document.getElementById('usua_nomb_' + idx_ref).innerHTML; 
						//document.getElementById('usua_tipo_codi').value=document.getElementById('usua_tipo_codi_' + idx_ref).innerHTML;
						//document.getElementById('usua_tipo_deta').value=document.getElementById('usua_tipo_deta_' + idx_ref).innerHTML; 
						$('#modal_usuarios').modal('hide');
				});
			
			});
		 	var Visitas = new C_Visitas();
			
			function boton_buscar(){
				//Carga de valores			
				visi_fech_ini=      document.getElementById('visi_fech_ini').value;
				visi_fech_fin=      document.getElementById('visi_fech_fin').value;
				usua_codi=         	document.getElementById('usua_codi').value;
				usua_tipo_codi=     selectvalue(document.getElementById('usua_tipo_codi'));
				Visitas.visi_busq(visi_fech_ini,visi_fech_fin,usua_codi,usua_tipo_codi);
			}
		
			boton_buscar();
   		 
			
				
           </script> 
        <?php include("clases/HTML/Libros_modales_usuarios.php"); ?> 
	</body>
</html>