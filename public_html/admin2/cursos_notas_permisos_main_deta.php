<!DOCTYPE html>
<html lang="es">
    <?php include("template/head.php");?>
    <body class="hold-transition skin-blue sidebar-mini <?php echo $_SESSION['sidebar_status']; ?>">
		<div class="wrapper">
			<?php include ('template/header.php');?>
			<?php $Menu=412;include("template/menu.php");?>
			<div class="content-wrapper">
				<section class="content-header">
					<?php
						session_start();	 
						include ('../framework/dbconf.php');
						
						if(isset($_GET['curs_para_mate_codi'])){
						 $curs_para_mate_codi=$_GET['curs_para_mate_codi'];
						}
						if(isset($_GET['curs_para_mate_prof_codi'])){
						 $curs_para_mate_prof_codi=$_GET['curs_para_mate_prof_codi'];
						}
						$params = array($curs_para_mate_prof_codi);
						$sql="{call curs_para_mate_prof_info(?)}";
						$curs_para_mate_info = sqlsrv_query($conn, $sql, $params);  
						$row_curs_para_mate_info = sqlsrv_fetch_array($curs_para_mate_info); 
				  	?>
					<h1>Notas Permisos</h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-check-square-o"></i></a></li>
						<li class="active">Notas Permisos</li>
					</ol>
				</section>
				<section class="content" id="mainPanel">
					<div id="information">
						<div class="box box-default">
							<div class="box-header with-border">
								<a  class='btn btn-warning' href='cursos_notas_permisos_main.php'><span class='fa fa-chevron-left'></span> Volver</a>
							</div>
							<div class="box-body">
								<script src="js/funciones_notas_permisos.js"></script>
								<div class="callout callout-info">
									<h4>Información del curso</h4>
									<table>
										<tr><td width='150px;'><b>Curso:</b></td><td><?= $row_curs_para_mate_info['curs_deta']; ?> <?= $row_curs_para_mate_info['para_deta']; ?></td></tr>
										<tr><td><b>Materia:</b></td><td><?= $row_curs_para_mate_info['mate_deta']; ?></td></tr>
										<tr><td><b>Profesor:</b></td><td><?= $row_curs_para_mate_info['prof_nomb']; ?></td></tr>
									</table>
								</div>
								<div id="curs_para_main_perm_deta"  >
									<?php include ('cursos_notas_permisos_main_deta_view.php'); ?>
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
		<input type="hidden" name="peri_codi" id="peri_codi" value="<?= $row_peri_info['peri_codi']; ?>">
        <script>
			$("#pi_nota_peri_fec_ini").datepicker({ dateFormat: 'yy-mm-dd' });
			$("#pi_nota_peri_fec_fin").datepicker({ dateFormat: 'yy-mm-dd' });
			curs_peri_mate_view(selectvalue(document.getElementById('pi_curs_para_codi')),'pi_mate_prof','pi')
		</script>
	</body>
</html>
<div class="modal fade" id="nuev_perm_indi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title" id="myModalLabel">Nuevo Permisos</h4>
			</div>
			<div class="modal-body">
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td height="40" >Unidad:</td>
						<td > 
						<? 
							 
							 
							$peri_dist_nive= 2;
							
							$params = array($PERI_CODI ,$peri_dist_nive);
							$sql="{call peri_dist_peri_nive_view(?,?)}";
							$peri_dist_peri_nive_view = sqlsrv_query($conn, $sql, $params);  
							 
						?>
						  <select name="pi_peri_dist_codi" id="pi_peri_dist_codi">
						   <?php  while ($row_peri_dist_peri_nive_view = sqlsrv_fetch_array($peri_dist_peri_nive_view)) { ?> 
							<option value="<?= $row_peri_dist_peri_nive_view['peri_dist_codi']; ?>"><?= $row_peri_dist_peri_nive_view['peri_dist_deta']; ?> (<?= $row_peri_dist_peri_nive_view['peri_dist_padr_deta']; ?>)</option>
							<? } ?>
						</select></td>
					</tr>
					<tr> 
						<td >Desde:</td>
						<td><input id="pi_nota_peri_fec_ini"   type="text" value="<?= date('Y-m-d');?>"></td>
					</tr>
					<tr>
						<td >Hasta: </td>
						<td><input id="pi_nota_peri_fec_fin"   type="text" value="<?= date('Y-m-d');?>"></td>
					</tr>
				</table>
			</div>
			<div class="modal-footer">
				 <button type="button" class="btn btn-primary"  
					onClick="nota_perm_add(1);"   >
					Aceptar
				</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<button type="button" class="btn btn-default" data-dismiss="modal">
					Cerrar
				</button>                                   
			</div>
		</div>
	</div>
</div>