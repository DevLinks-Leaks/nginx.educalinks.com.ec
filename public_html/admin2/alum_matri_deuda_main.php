<!DOCTYPE html>
<html lang="es">
    <?php include("template/head.php");?>
    <body class="hold-transition skin-blue sidebar-mini">
		<div class="wrapper">
			<?php include ('template/header.php');?>
			<?php $Menu=105;include("template/menu.php");?>
			<div class="content-wrapper">
				<section class="content-header">
					<?php
						$params = array($_SESSION['curs_para_codi']);
						$sql="{call curs_para_info(?)}";
						$curs_para_info = sqlsrv_query($conn, $sql, $params);  
						$row_curs_para_info = sqlsrv_fetch_array($curs_para_info);
				  	?>
					<h1>Alumnos Matriculados</h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-users"></i></a></li>
						<li class="active">Alumnos Matriculados</li>
					</ol>
				</section>
				<section class="content" id="mainPanel">
					<div id="information">
						<script type="text/javascript" src="js/funciones_deuda.js?<?= $rand?>"></script>   
						<div id="alum_main" >
                             <?php include ('alum_matri_deuda_main_lista.php'); ?>
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
				$('#alum_matri_table').DataTable();
			});
		</script>
	</body>
</html>
<div class="modal fade" id="ModalMatri" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Nueva Matriculaci&oacute;n</h4>
			</div>
			<div id="modal_main" class="modal-body">
				<div id="div_matri"> 
					<?
						$sql_peri="{call peri_0()}";
						$peri_busq = sqlsrv_query($conn, $sql_peri);
					?>Periodo Lectivo:
					<select id="peri_0" name="peri_0"  onchange="load_ajax('div_curs','cursos_paralelo_main_combo.php','peri_codi=' + this.value)" class="select">
					<? while($row_peri_bus= sqlsrv_fetch_array($peri_busq)){?>
					<option value="<?= $row_peri_bus['peri_codi'];?>" <? echo $_SESSION['peri_codi']==$row_peri_bus['peri_codi']? "selected":"";?>><?= $row_peri_bus['peri_deta'];?></option>
					<? }?>
					</select>
					<input type="hidden" id="alum_codi" name="alum_codi" value="">
					<div id="div_curs">
						&nbsp;
					</div>
					<script>
						load_ajax_alum_curso_combo('div_curs','cursos_paralelo_main_combo.php','peri_codi='+ document.getElementById('peri_0').value);
					</script>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-success" onClick="vali_matri(document.getElementById('span_cupo').innerHTML,document.getElementById('curs_para_codi').value,document.getElementById('alum_codi').value);" >Matricular</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>