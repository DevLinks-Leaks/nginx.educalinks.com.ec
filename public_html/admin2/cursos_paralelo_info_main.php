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
						session_start();	 
						include ('../framework/dbconf.php');
						
						if(isset($_GET['curs_para_codi'])){
						 $curs_para_codi=$_GET['curs_para_codi'];
						}
						
						$params = array($curs_para_codi);
						$sql="{call curs_para_info(?)}";
						$curs_para_info = sqlsrv_query($conn, $sql, $params);  
						$row_curs_para_info = sqlsrv_fetch_array($curs_para_info); 
				  	?>
					<h1><span class="icon-books icon"></span>
						<?php 
						echo $row_curs_para_info["curs_deta"]; 
						?> 
						- Paralelo: 
						<?php 
						echo $row_curs_para_info["para_deta"]; 
						?>
						Nivel: 
						<?php 
						echo $row_curs_para_info["nive_deta"]; 
						?> 
						- Cupos:  
						<?php 
						echo $row_curs_para_info["cupo_cc"]; ?> / <?php echo $row_curs_para_info["curs_para_cupo"]; 
						?>
					</h1>
					<input type="hidden" id="curs_para_cupo" data-alum_num = <?=$row_curs_para_info["cupo_cc"];?> 
						data-cupo_actual="<?=$row_curs_para_info["curs_para_cupo"]?>" />
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-circle-o"></i></a></li>
						<li class="active">Cursos</li>
					</ol>
				</section>
				<section class="content" id="mainPanel">
					<div id="information">
						<div class="box box-default">
							<div class="box-header with-border">
								<h3 class="box-title">
									<a class="btn btn-primary"  
										 onclick="document.getElementById('texto_mate').value='';" 
										 data-toggle="modal" 
										 data-target="#ModalMate" 
										 title=""><span class="fa fa-plus"></span> Materias
									  </a>
									<!--
									  <a class="btn btn-default"    
										onclick="document.getElementById('texto_alum').value=''; texto_buscar_alum();" 
										data-toggle="modal" data-target="#ModalAlum" 
										title=""><span class="fa fa-plus"></span> Alumnos</a>
									-->
								    <?php if (permiso_activo(96)){?>
									  <a class="btn btn-default"  
										onclick="" 
										data-toggle="modal" 
										data-target="#ModalCopiadeMaterias" 
										title=""><span class="fa fa-copy"></span> Copiar materias
									   </a>
									<? } ?>
									<?php if (permiso_activo(97)){?>
									  <a class="btn btn-default"  
										onclick="curs_para_cupo_upd_dial();" 
										data-toggle="modal" 
										data-target="#ModalEditCupo" 
										title=""><span class="fa fa-list"></span> Modificar cupo</a>
									<? } ?>
									  <a class="btn btn-default"
										href="cursos_paralelo_info_main_impr.php?curs_para_codi=<?= $_GET['curs_para_codi']; ?>">
											<span class="fa fa-print"></span> Imprimir</a>
								</h3>
							</div><!-- /.box-header -->
							<div class="box-body">
								<script type="text/javascript" src="../framework/funciones.js"></script>
								<script type="text/javascript" src="js/funciones_alum.js"></script>
								<script type="text/javascript" src="js/funciones_notas.js"></script>
								<div id="curs_main" >
									<?php include ('cursos_paralelo_info_main_view.php'); ?>
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
		</script>
	</body>
</html>