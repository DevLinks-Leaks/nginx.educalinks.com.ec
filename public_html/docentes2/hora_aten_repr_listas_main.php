<!DOCTYPE html>
<html lang="es">
    <?php include("template/head.php");?>
    <body class="hold-transition skin-blue sidebar-mini">
		<div class="wrapper">
			<?php include ('template/header.php');?>
			<?php $Menu=5;include("template/menu.php");?>
			<div class="content-wrapper">
				<section class="content-header">
					<h1>Lista de citas</h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-users"></i></a></li>
						<li class="active">Lista de citas</li>
					</ol>
				</section>
				<section class="content" id="mainPanel">
					<div id="information">
						<div class="box box-default">
							<div class="box-header with-border">
								<h3 class="box-title">
									<a id="bt_mate_add"  class="btn btn-default"  href="javascript:getURL()"><span class="fa fa-print"></span> Imprimir Lista</a>
								</h3>
							</div><!-- /.box-header -->
							<div class="box-body">
								<div id="curs_main">
									  <?php include ('hora_aten_repr_script.php'); ?>
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
		<script type="text/javascript"> 
			$("#hora_aten_repr_fecha").datepicker({
				onSelect: function(date){
					MostrarCitas (date);
				}
			});
			function getURL()
			{   var direccion;
				direccion="hora_aten_repr_listas_main_view.php?fecha=";
				direccion=direccion+document.getElementById('hora_aten_repr_fecha').value;
				window.location.href=direccion;
			}
		</script>
	</body>
</html>