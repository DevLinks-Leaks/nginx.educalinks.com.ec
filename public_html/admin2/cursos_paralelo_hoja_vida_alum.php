<!DOCTYPE html>
<html lang="es">
    <?php include("template/head.php");?>
    <body class="hold-transition skin-blue sidebar-mini">
		<div class="wrapper">
			<?php include ('template/header.php');?>
			<?php $Menu=201;include("template/menu.php");?>
			<div class="content-wrapper">
				<section class="content-header">
					<? $alum_curs_para_codi=$_GET['alum_curs_para_codi']; 
					   $curs_para_codi=$_GET['curs_para_codi']; 
					?>
					<h1>Observaciones</h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-eye"></i></a></li>
						<li class="active">Observaciones</li>
					</ol>
				</section>
				<section class="content" id="mainPanel">
					<div id="information">
						<div class="box box-default">
							<div class="box-header with-border">
								<h3 class="box-title">
									<a class="btn btn-warning" href='cursos_paralelo_hoja_vida_main.php?curs_para_codi=<?= $curs_para_codi; ?>'>
										<span class="fa fa-chevron-left"></span> Volver</a>
									<a class="btn btn-primary" data-toggle="modal" data-target="#modal_new_obse">
										<span class="fa fa-plus"></span> Observación</a>
									<a class="btn btn-default" href="reportes_generales/hoja_vida_estudiante.php?alum_curs_para_codi=<?= $alum_curs_para_codi; ?>" target="_blank">
										<span class="fa fa fa-file-pdf-o btn_opc_lista_eliminar"></span> Imprimir</a>
								</h3>
							</div><!-- /.box-header -->
							<div class="box-body">
								<script src="js/funciones_observaciones.js?<?= $rand?>"></script>
								<div id="div_obs_list">
									<?php
									$params_obs=array($alum_curs_para_codi);
									$sql_obs="{call observacion_alum_info(?)}";
									$stmp_obs = sqlsrv_query($conn, $sql_obs,$params_obs);
									if( $conn === false)
									{
										echo "Error in connection.\n";
										die( print_r( sqlsrv_errors(), true));
									}
									?>
									<table class="table table-striped">
										<thead style='background-color:rgba(1, 126, 186, 0.1) !important'>
										<tr>
											<th width="15%">Tipo de Observaci&oacute;n</th>
											<th width="40%">Observaci&oacute;n</th>
											<th width="15%">Ingresado por</th>
											<th width="15%">Rol</th>
											<th width="15%">Fecha de Ingreso</th>
										</tr>
										</thead>
										<tbody>
										<?php while($row_obs_view=sqlsrv_fetch_array($stmp_obs)){?>
											<tr>
												<td><?=$row_obs_view['obse_tipo_deta'];?></td>
												<td><?=$row_obs_view['obse_deta'];?></td>
												<td><?=$row_obs_view['usua_deta'];?></td>
												<td><?=$row_obs_view['usua_tipo'];?></td>
												<td><?=date_format($row_obs_view['obse_fech'],"d/m/Y");?></td>
											</tr>
										<?php }?>
										</tbody>
									</table>
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
			} );
		</script>
	</body>
</html>
<div
	class="modal fade"
	id="modal_new_obse"
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
				<h4 class="modal-title" id="myModalLabel">
					Nueva observación
				</h4>
			</div>
			<div id="modal_main" class="modal-body">
				<div id="div_usua_edi">
					<div class="form_element">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="25%" style="padding-top: 15px;">
									<label>Tipo de observación: </label>
								</td>
								<td style="padding-top: 15px;">
									<?php
									$sql="{call tipo_observacion_view()}";
									$tipo_obs_view = sqlsrv_query($conn, $sql);
									?>
									<select class='form-control input-sm' id="tipo_obs" name="tipo_obs" style="width: 100%">
										<?php while($row_tipo_obs_view = sqlsrv_fetch_array($tipo_obs_view)){?>
											<option value="<?=$row_tipo_obs_view['obse_tipo_codi']?>"><?=$row_tipo_obs_view['obse_tipo_deta']?></option>
										<?php }?>
									</select>
								</td>
							</tr>
							<tr>
								<td width="25%" style="padding-top: 15px;">Escriba la observación</td>
								<td style="padding-top: 15px;"><textarea class='form-control input-sm' id="obs_deta" style="width:100%; height: 200px;resize: none;" ></textarea></td>
							</tr>
						</table>
					</div>
					<div class="form_element">&nbsp;</div>
				</div>
			</div>
			<div class="modal-footer">
				<button
					id="btn_obs_add"
					class="btn btn-success"
					type="button"
					data-loading="Agregando..."
					onClick="obs_add('div_obs_list','script_observaciones_alum.php','<?=$alum_curs_para_codi?>')"><span class='fa fa-floppy-o'></span> Guardar Cambios</button>
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