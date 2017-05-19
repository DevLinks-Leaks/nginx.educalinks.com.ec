<!DOCTYPE html>
<html lang="es">
    <?php include("template/head.php");?>
    <body class="hold-transition skin-blue sidebar-mini">
		<div class="wrapper">
			<?php include ('template/header.php');?>
			<?php $Menu=102;include("template/menu.php");?>
			<div class="content-wrapper">
				<section class="content-header">
					<?php
						$params = array($_SESSION['curs_para_codi']);
						$sql="{call curs_para_info(?)}";
						$curs_para_info = sqlsrv_query($conn, $sql, $params);  
						$row_curs_para_info = sqlsrv_fetch_array($curs_para_info);
				  	?>
					<h1>Representantes</h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-heart-o"></i></a></li>
						<li class="active">Representantes</li>
					</ol>
				</section>
				<section class="content" id="mainPanel">
					<div id="information">
						<!-- <script type="text/javascript" src="js/funciones_repre.js?<?= $rand?>"></script> -->
						<div id="div_repr_list">
						<?php	include ('representantes_add_script.php');  ?>
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
		  shortcut.add("Shift+E+G", function() {
		      $('#btn_guardar').trigger("click");
		  },{'disable_in_input':true});
		  inicializar_radioBtn();
		  
		</script>
	</body>
</html>