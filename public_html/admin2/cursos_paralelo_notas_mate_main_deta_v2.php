<!DOCTYPE html>
<html lang="es">
    <?php include("template/head.php");?>
    <body class="hold-transition skin-blue sidebar-mini <?php echo $_SESSION['sidebar_status']; ?>">
		<div class="wrapper">
			<?php include ('template/header.php');?>
			<?php $Menu=201;include("template/menu.php");?>
			<div class="content-wrapper">
				<section class="content-header">
					<?php
						if(isset($_GET['curs_para_mate_codi']))
						{   $curs_para_mate_codi=$_GET['curs_para_mate_codi'];
						}
						$PERI_CODI = $_SESSION['peri_codi']; 	 
						$params = array($curs_para_mate_codi);
						$sql="{call curs_peri_mate_info(?)}";
						$curs_peri_mate_info = sqlsrv_query($conn, $sql, $params);
						$row_curs_peri_mate_info = sqlsrv_fetch_array($curs_peri_mate_info);
						$curs_para_codi = $row_curs_peri_mate_info["curs_para_codi"];
						
						/*codigo q estaba en el deta*/
						if (isset($_POST['peri_dist_codi'])){$peri_dist_codi=$_POST['peri_dist_codi'];}else{if (isset($_GET['peri_dist_codi'])){$peri_dist_codi=$_GET['peri_dist_codi'];}}
				
						if (isset($_POST['curs_para_mate_codi'])){$curs_para_mate_codi=$_POST['curs_para_mate_codi'];}else{if (isset($_GET['curs_para_mate_codi'])){$curs_para_mate_codi=$_GET['curs_para_mate_codi'];}}
				  	?>
					<h1><?= $row_curs_peri_mate_info['curs_deta'];?> - <?= $row_curs_peri_mate_info['para_deta'];?> - <?= $row_curs_peri_mate_info['mate_deta'];?></h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa fa-leanpub"></i></a></li>
						<li class="active">Ver Materia</li>
					</ol>
				</section>
				<section class="content" id="mainPanel">
					<div id="information">
						<div class="box box-default">
							<div class="box-header with-border">
								<h3 class="box-title">
									<a class="btn btn-warning" 
										href="cursos_paralelo_notas_mate_main_v2.php?peri_codi=<?php echo $_SESSION['peri_codi']; ?>&curs_para_codi=<?php echo $curs_para_codi; ?>" title=""><span class="fa fa-chevron-left"></span> Volver</a>
								</h3>
							</div><!-- /.box-header -->
							<div class="box-body">
								<script src="js/funciones_notas_secretaria.js"></script>
								<div id="notas_view">
									<table class="table table-striped table-bordered">
										<thead>
											<tr>
												<th  style='text-align:center;' width="10%">Código Alumno</th>
												<th width="30%">Apellidos</th>
												<th width="30%">Nombres</th>
												<th style='text-align:center;' width="30%">Modificar Notas</th>
											</tr>
										</thead>
										<tbody>
											<?php 	
											$params = array($curs_para_mate_codi);
											$sql="{call curs_para_mate_info_NEW(?)}";
											$curs_para_mate_info = sqlsrv_query( $conn, $sql, $params );
											$row_curs_para_mate_info = sqlsrv_fetch_array( $curs_para_mate_info );
											
											$params	= array($curs_para_mate_codi);
											$sql	= "{call alum_curs_para_mate_view (?)}";
											$stmt	= sqlsrv_query($conn,$sql,$params);
											while ($row = sqlsrv_fetch_array($stmt))
											{
											?>
											<tr>
												<td style='text-align:center;'><?=$row["alum_codi"]?></td>
												<td><?=$row["alum_apel"]?></td>
												<td><?=$row["alum_nomb"]?></td>
												<td style='text-align:center;'>
													<a 
														class="btn btn-default" 
														onclick="IniciarForm('<?= $row["alum_apel"]." ".$row["alum_nomb"]?>',<?=$row["alum_curs_para_mate_codi"]?>,<?=$row["alum_codi"]?>);" 
														data-toggle="modal" 
														data-target="#ModalIngresarNotas">
														<span class="fa fa-edit btn_opc_lista_editar"></span>
													</a>
												</td>
											</tr>
											<?
											}
											?>
										</tbody>
									</table>
									<script type="text/javascript">
										$(document).ready(function() {
										$("input.cls_validar").keydown(function (e) {
											// Allow: backspace, delete, tab, escape, enter and .
											if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
												 // Allow: Ctrl+A
												(e.keyCode == 65 && e.ctrlKey === true) || 
												 // Allow: home, end, left, right
												(e.keyCode >= 35 && e.keyCode <= 39)) {
													 // let it happen, don't do anything
													 return;
											}
											// Ensure that it is a number and stop the keypress
											if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) 
											{
												e.preventDefault();
											}		
										});
									 });
									</script>
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
		<input class="form-control input-sm"name="mens_de"  		type="hidden" id="mens_de" 		value='<?php echo $_SESSION['USUA_DE'];  ?>'    />
		<input class="form-control input-sm"name="mens_de_tipo"  type="hidden" id="mens_de_tipo" value='<?php echo $_SESSION['USUA_TIPO']; ?>'    />
		<?php include("template/scripts.php");?>
		<script type="text/javascript" language="javascript">
			function ejecutar_submit(frm){
				document.getElementById(frm).submit();
			}
			function ValidarImprimir()
			{	if (document.getElementById('sl_peri_dist_codi').value==0)
				{	alert ('Escoja un periodo a consultar'); 
				}
				else
				{	window.open('reportes_generales/notas_ingresadas_pdf.php?peri_dist_codi=' + selectvalue(document.getElementById('sl_peri_dist_codi')) +'&curs_para_mate_codi=<?=$row_curs_peri_mate_info['curs_para_mate_codi']?>')
				}
			}
		</script>
	</body>
</html>
<div class="modal fade" id="ModalIngresarNotas" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Modificación/Ingreso de notas</h4>
			</div>
			<div id="modal_main" class="modal-body">
				<div id="div_cupo_edi"> 
					<div class="form_element">
						<table border="0" cellpadding="0" cellspacing="0" width="100%;" class="">
							<tr>
								<td width="25%" style="padding-top: 5px;font-weight: bold;">
									Alumno:
								</td>
								<td style="padding-top: 5px;">
									<input class="form-control input-sm"type="hidden" id="alum_curs_para_mate_codi_in" name="alum_curs_para_mate_codi_in" />
									<input class="form-control input-sm"type="hidden" id="alum_codi" name="alum_codi" />
									<div id="alum_nombres">
									</div>
								</td>
							</tr>
							<tr>
								<td width="25%" style="padding-top: 5px;font-weight: bold;">
									Curso:
								</td>
								<td style="padding-top: 15px;">
									<?= $row_curs_peri_mate_info['curs_deta']." (".$row_curs_peri_mate_info['para_deta'].")";?>
								</td>
							</tr>
							<tr>
								<td width="25%" style="padding-top: 5px;font-weight: bold;">
									Asignatura:
								</td>
								<td style="padding-top: 15px;">
									<?= $row_curs_peri_mate_info['mate_deta'];?>
								</td>
							</tr>
							<tr>
								<td width="25%" style="padding-top: 5px;font-weight: bold;">
									Tipo calificación:
								</td>
								<td style="padding-top: 15px;">
									<? 
									switch ($row_curs_peri_mate_info['nota_refe_cab_tipo'])
									{	case 'C':
											echo 'Numérica';
										break;
										case 'D':
											echo 'Cualitativa de Comportamiento';
										break;
										case 'P':
											echo 'Cualitativa de Proyectos';
										break;
										case 'I':
											echo 'Cualitativa de cursos de inicial';
										break;
										case 'IP':
											echo 'Cualitativa Proyectos Inicial';
										break;
										default:
											echo 'No tiene asignada un tipo';
										break;
									}
									?>
									<input class="form-control input-sm"id="nota_refe_cab_tipo" type="hidden" value="<?=$row_curs_peri_mate_info['nota_refe_cab_tipo']?>" />
									<input class="form-control input-sm"id="nota_refe_cab_codi" type="hidden" value="<?=$row_curs_peri_mate_info['nota_refe_cab_cod']?>" />
									<input class="form-control input-sm"id="mate_padr" type="hidden" value="<?=$row_curs_peri_mate_info['mate_padr']?>" />
								</td>
							</tr>
							<tr>
								<td width="25%" style="padding-top: 5px;font-weight: bold;">
									Unidad/Parcial:
								</td>
								<td style="padding-top: 10px;">
								<? 	
								$peri_dist_nive=2;
								$params = array($curs_para_codi,$peri_dist_nive);
								$sql="{call peri_dist_peri_nive_view_NEW(?,?)}"; 
								$peri_dist_peri_nive_view = sqlsrv_query($conn, $sql, $params);  
								?>
									<select class='form-control input-sm' id="sl_peri_dist_codi" style="width: 75%;" onchange="consNotas();">
										<option value="0">Elija</option>
										<? while($row_peri_dist_peri_nive_view = sqlsrv_fetch_array($peri_dist_peri_nive_view))
										{ ?>
										<option value="<?= $row_peri_dist_peri_nive_view['peri_dist_codi'];?>">
										<?= (($row_peri_dist_peri_nive_view['peri_dist_padr_deta']=='')
											?$row_peri_dist_peri_nive_view['padre']:
											$row_peri_dist_peri_nive_view['peri_dist_padr_deta'].' - ').
											$row_peri_dist_peri_nive_view['peri_dist_deta']; 
										?>
										</option>
										<?php 	 
										} 
										?>
									</select> 
								</td>
							</tr>
							<tr>
								<td colspan="2" style="padding-top: 10px;">
									<div id="alum_notas_ing" class="form_element">
									</div>
								</td>
							</tr>
						</table>  
					</div>
					<div class="form_element">&nbsp;</div>                
				</div>
			</div>
			<div class="modal-footer">
				<button 
					type="button" 
					class="btn btn-info" 
					onClick="ValidarImprimir()">
					<span class="fa fa-print"></span>&nbsp;Imprimir
				</button>
				<button 
					type="button" 
					class="btn btn-success" 
					onClick="saveNotas('<?= $row_curs_peri_mate_info['curs_deta'];?>','<?= $row_curs_peri_mate_info['para_deta'];?>','<?= $row_curs_peri_mate_info['mate_deta'];?>')">
					<span class="fa fa-floppy-o"></span>&nbsp;Guardar Cambios
				</button>
				<button 
					type="button" 
					class="btn btn-default" 
					data-dismiss="modal">
					<span class="fa fa-close"></span>&nbsp;Cancelar
				</button>
			</div>
		</div>
	</div>
</div>