<!DOCTYPE html>
<html lang="es">
    <?php include("template/head.php");?>
    <body class="hold-transition skin-blue sidebar-mini">
		<div class="wrapper">
			<?php include ('template/header.php');?>
			<?php $Menu=800;include("template/menu.php");?>
			<div class="content-wrapper">
				<section class="content-header">
					<h1>Acerca de
						<small>Educalinks</small>
					</h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="icon icon-logo"></i></a></li>
						<li class="active">Acerca de</li>
					</ol>
					
				</section>
				<section class="content" id="mainPanel">
					<div id="information">
						<div class="box box-default">
							<div class="box-header with-border">
								<span style="font-size:1000%"class='icon icon-educalinks'></span>
								<div class="box-tools pull-right">
									<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
									<!--<button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button> NO REMOVER-->
								</div>
							</div><!-- /.box-header -->
							<div class="box-body">
								<div id="formulario">
									Sistema Educativo de control académico y administrativo.
									<br>
									<br>
									<span class='icon icon-logo'></span> Desarrollado por <span style='color:darkred;font-weight:bold'>Redlinks</span>.
									<br>
									<br>
									<span style='font-weight:bold'><li class='fa fa-compass'></li> Dirección: </span>Av. Raúl Gómez Lince (Av. Las Aguas) Mz 192 Solar 1 Oficina 3 1er Piso. 
									<br>
									<span style='font-weight:bold'><li class='fa fa-phone'></li> Teléfono: </span> 043726466 - 043726465 - 043726460
									<br>
									<span style='font-weight:bold'><li class='fa fa-envelope-o'></li> Email: </span> <a href="mail:to">info@redlinks.com.ec</a><br>
									<span style='font-weight:bold'><li class='fa fa-comments-o'></li> Soporte: </span> <a href="http://soporte.redlinks.com.ec/index.php">soporte.redlinks.com.ec</a>
									<br>
									<br>
									<span style='color:darkred;font-weight:bold'>SITIOS WEB</span><br>
									<span style='font-weight:bold'><li class='fa fa-desktop'></li> Redlinks: </span> <a href="http://www.redlinks.com.ec">www.redlinks.com.ec</a><br>
									<span style='font-weight:bold'><li class='fa fa-desktop'></li> Educalinks: </span> <a href="http://www.educalinks.com.ec">www.educalinks.com.ec</a>
									<br>
									<br>
									Copyright © 2014-2016. Todos los derechos reservados.
								</div>
							</div><!-- /.box-body -->
							<div class="box-footer">
							</div>
						</div>
					</div>
				</section>
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
		<script src="../js/med_fichas.js"></script>
		<script type="text/javascript">  
			$(document).ready(function(){  
				
			});
		</script>
	</body>
</html>	