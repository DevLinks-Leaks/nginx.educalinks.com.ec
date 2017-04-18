<!DOCTYPE html>
<html lang="es">
    <?php include("template/head.php");?>
    <body class="hold-transition skin-blue sidebar-mini">
		<div class="wrapper">
			<?php include ('template/header.php');?>
			<?php $Menu=403;include("template/menu.php");?>
			<div class="content-wrapper">
				<section class="content-header">
					<?php
						$params = array($_SESSION['curs_para_codi']);
						$sql="{call curs_para_info(?)}";
						$curs_para_info = sqlsrv_query($conn, $sql, $params);  
						$row_curs_para_info = sqlsrv_fetch_array($curs_para_info);
				  	?>
					<h1>Periodos</h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-calendar"></i></a></li>
						<li class="active">Periodos</li>
					</ol>
				</section>
				<section class="content" id="mainPanel">
					<div id="information">
						<div class="box box-default">
							<div class="box-header with-border">
								<h3 class="box-title">
									<?php if (permiso_activo(52)){?>
									  <a id="bt_peri_add" class="btn btn-primary" onclick="peri_nue()" data-toggle="modal" data-target="#peri_nuev" >
										<span class="fa fa-calendar"></span> <span class="fa fa-plus"></span> Nuevo periodo
									  </a>
								  <?php }?>
								</h3>
							</div><!-- /.box-header -->
							<div class="box-body">
								<script type="text/javascript" src="../framework/funciones.js"> </script>
							   <script src="js/funciones_periodos.js"></script>
							   
							   <div id="curs_peri_main" >
									<?php include ('admin_periodos_lista.php'); ?>                           
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
		<script>
		</script>
	</body>
</html>
<!-- Modal -->
<input id="n_peri_codi" name="n_peri_codi" type="hidden" value="">
<input id="n_do" name="n_do" type="hidden" value="N">
<div class="modal fade" id="peri_nuev" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
				</button>
				<h4 class="modal-title" id="myModalLabel"><label id="n_modaltitu">Nuevo Periodo </label></h4>
			</div>
			<div class="modal-body">
				<div>
					<div class="form_element">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td width="25%">Nombre: </td>
							<td style="padding-top: 15px;"><input id="n_peri_deta" name="n_peri_deta" type="text" style="width: 90%;" value=""></td>
						</tr>
						<tr>
							<td width="25%">Año: </td>
							<td style="padding-top: 15px;"><input id="n_peri_ano" name="n_peri_ano" type="number" style="width: 25%;" value="<?= date("Y");?>"></td>
						</tr>
						</table>
					</div>
					<div class="form_element">&nbsp;</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary"  data-dismiss="modal" onClick="peri_aceptar()">
					Aceptar
				</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">
					Cerrar
				</button>
			</div>
		</div>
	</div>
</div>