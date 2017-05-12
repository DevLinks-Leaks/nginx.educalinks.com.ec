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
		  
						$peri_codi = $_GET['peri_codi'];		
						$params = array($peri_codi);
						$sql="{call peri_info(?)}";			 
						$peri_info = sqlsrv_query($conn, $sql, $params);  
						$row_peri_info = sqlsrv_fetch_array($peri_info);
					?>
					<h1>Periodos Distribución: <?= $row_peri_info['peri_deta'];	?> </h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-circle-o"></i></a></li>
						<li class="active">Periodos Distribución</li>
					</ol>
				</section>
				<section class="content" id="mainPanel">
					<div id="information">
						<div class="box box-default">
							<div class="box-header with-border">
								<h3 class="box-title">
									<!--<a id="bt_peri_add" class="btn btn-warning"  data-toggle="modal" data-target="#copia_peri_mode_cali" >
										<span class="fa fa-copy"></span>  Nuevo Modelo de Calificacion</a>-->
								</h3>
							</div><!-- /.box-header -->
							<div class="box-body">
								<script src="js/funciones_periodos_distribucion.js"></script>
								<div id="curs_peri_main" >
									<?php include ('admin_periodos_notas_view.php'); ?>
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
				$('#rol_table').DataTable() ;
			} );
		</script>
	</body>
</html>
<?php include ('head.php');?>
<!-- Modal -->                                            
<div class="modal fade" id="copia_peri_mode_cali" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel"><label id="n_modaltitu">MODELO DE CALIFICACION</label></h4>
	  </div>
	  <div class="modal-body">
			 <table width="100%" border="0" cellspacing="0" cellpadding="0">                                      
				<tr>
					<td height="50px"> </td>
					<td>dddd</td>
				</tr>
			</table>
			
				  </div>
				  <div class="modal-footer">
					 <button type="button" class="btn btn-primary"  data-dismiss="modal" onClick="peri_aceptar()">Aceptar</button>
					 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					 <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				   <br>
			<br>
			<br>

	  </div>
	</div>
  </div>
</div>