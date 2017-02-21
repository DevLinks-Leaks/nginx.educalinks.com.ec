<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml"
<?php include("template/head.php");?>
<body class="hold-transition skin-blue sidebar-mini">
	<div class="wrapper">
		<?php include ('template/header.php');?>
		<?php $active="cons_estudiantes";include("template/menu.php");?>
		<div class="content-wrapper">
			<section class="content-header">
				<h1>Notas
					<small>Notas y Libreta</small>
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-book"></i></a></li>
					<li class="active">Notas</li>
				</ol>
			</section>
			<section class="content" id="mainPanel">
					<div id='information' name='information'>
						<?
						switch ($_SESSION['peri_dist_cab_tipo'])
						{
							case 'I':
							$url_libreta = 'cursos_paralelo_notas_alum_libreta_inicial_'.$_SESSION['directorio'].'.php'; 
							break;	

							case 'G':
							$url_libreta = 'cursos_paralelo_notas_alum_libreta_'.$_SESSION['directorio'].'.php';
							break;
						}
						?>

						<?
						$alum_codi=$_GET['alum_codi'];
						$peri_dist_codi=$_GET['peri_dist_codi'];

						$peri_codi = $_SESSION['peri_codi'];
						//VALIDA PERMISO
						$peri_etap_codi = 'U';
						$params = array($peri_codi, $_SESSION['peri_dist_cab_tipo'],$peri_etap_codi);
						$sql="{call peri_dist_peri_view_Lb_etapa(?,?,?)}";
						$peri_dist_peri_view = sqlsrv_query($conn, $sql, $params);
						$negar = 0;
						while($row_peri_dist_peri_view = sqlsrv_fetch_array($peri_dist_peri_view))
						{ 	if($row_peri_dist_peri_view['peri_dist_codi'] == $peri_dist_codi)
								$nonegar++;
						}
						if($nonegar != 0)
							{	echo '
						<li>
							<a  id="bt_mate_add"
								class="button_text"
								href="'.$url_libreta.'?peri_dist_codi='.$peri_dist_codi.'">
								<span class="icon-print"></span>Imprimir Libreta
							</a>
						</li>';
						}	
						?>

						<div  id="tab_libr">
							<?php
								if($nonegar == 0)
								{	die ( "Resultado desconocido" );
								}
								else
								{   if (!alum_tiene_deuda($_SESSION['alum_codi'],$_SESSION['curs_para_codi']))
									{
										include($url_libreta); 
									}
									else
									{
										echo "<h1>Favor acercarse a la secretaría de la institución.</h1>";
									}
								}
							?>
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
		<script src="../js/med_fichas.js"></script>
		<script type="text/javascript">  
			$(document).ready(function(){  
				
			});
		</script>
	</body>
</html>