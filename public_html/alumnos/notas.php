<!DOCTYPE html>
<html lang="es">
<?php include("template/head.php");?>
<body class="hold-transition skin-blue sidebar-mini">
	<div class="wrapper">
		<?php include ('template/header.php');?>
		<?php $active="cons_estudiantes";include("template/menu.php");?>
		<div class="content-wrapper">
			<section class="content-header">
				<h1>Calificaciones
					<small>Libreta</small>
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-book"></i></a></li>
					<li class="active">Calificaciones</li>
				</ol>
			</section>
			<section class="content" id="mainPanel">
				<div id='information' name='information'>
					<?
					switch ($_SESSION['peri_dist_cab_tipo'])
					{
						case 'I':
						// $url_libreta = 'libretas/cursos_paralelo_notas_alum_libreta_inicial_'.$_SESSION['directorio'].'.php';
						$url_libreta = '../admin/libretas/'.$_SESSION['directorio'].'/'.$_SESSION['peri_codi'].'/lib_ini_one.php';
						break;	

						case 'G':
						// $url_libreta = 'libretas/cursos_paralelo_notas_alum_libreta_'.$_SESSION['directorio'].'.php';
						$url_libreta = '../admin/libretas/'.$_SESSION['directorio'].'/'.$_SESSION['peri_codi'].'/lib_one.php';
						break;
					}
					$peri_codi = $_SESSION['peri_codi'];
					
					if (!alum_tiene_deuda($_SESSION['alum_codi'],$_SESSION['curs_para_codi']) and !alum_tiene_deuda_vencida($_SESSION['alum_codi'],$peri_codi))
					{
						?>
						<div class="panel panel-default">
							<div class="panel-heading">
								<h3 class="panel-title">
									Lista de Calificaciones disponibles
								</h3>
							</div>
							<div class="panel-body"  id="desplegable_busqueda" name="desplegable_busqueda">
								<table class="table table-responsive">
									<thead>
										<tr class="active">
											<th>Periodo</th>
											<th>Opciones</th>
										</tr>
									</thead>
										<? 
									  	//ETAPA PARA ALUMNOS Y REPRESENTANTES 
										$peri_etap_codi = 'U';
										$params = array($peri_codi, $_SESSION['peri_dist_cab_tipo'],$peri_etap_codi);
										$sql="{call peri_dist_peri_view_Lb_etapa(?,?,?)}";
										$peri_dist_peri_view = sqlsrv_query($conn, $sql, $params);
										while($row_peri_dist_peri_view = sqlsrv_fetch_array($peri_dist_peri_view)){

											
										?>
										<tr>
											<td width="87%"><?= $row_peri_dist_peri_view['peri_dist_deta'];?> </td>
											<td width="13%">
											
											<a  class="btn btn-success" target="_blank"
											href="<?= $url_libreta?>?peri_dist_codi=<?= $row_peri_dist_peri_view['peri_dist_codi'];?>&alum_codi=<?= $_SESSION['alum_codi']?>&curs_para_codi=<?= $_SESSION['curs_para_codi']?>">
											<span class="fa fa-download" aria-hidden="true"></span> Ver
											</a>
										
										</td>
									</tr>
									<?php 	} ?>
								</table>
							</div>
						</div>
						<?php }else{ ?>
							<div class="panel panel-default">
								<div class="panel-heading">
									<h3 class="panel-title">
										Lista de Calificaciones disponibles
									</h3>
								</div>
								<div class="panel-body"  id="desplegable_busqueda" name="desplegable_busqueda">
									<h4><b><?= para_sist(306); ?></b></h4>
								</div>
							</div>
							
						<?php } ?>

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
			<script src="../js/med_fichas.js"></script>
			<script type="text/javascript">  
				$(document).ready(function(){  

				});
			</script>
		</body>
		</html>