<!DOCTYPE html>
<html lang="es">
    <?php include("template/head.php");?>
    <body class="hold-transition skin-blue sidebar-mini">
		<div class="wrapper">
			<?php include ('template/header.php');?>
			<?php $active="cons_estudiantes";include("template/menu.php");?>
			<div class="content-wrapper">
				<section class="content-header">
					<?php
						$params = array($_SESSION['curs_para_codi']);
						$sql="{call curs_para_info(?)}";
						$curs_para_info = sqlsrv_query($conn, $sql, $params);  
						$row_curs_para_info = sqlsrv_fetch_array($curs_para_info);
				  	?>
					<h1>Inicio
						<small><b><?= $_SESSION['alum_apel'] ?> <?= $_SESSION['alum_nomb'] ?></b> - <?= $row_curs_para_info['curs_deta']; ?> "<?=  $row_curs_para_info['para_deta']; ?>"</small>
					</h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-home"></i></a></li>
						<li class="active">Inicio</li>
					</ol>
				</section>
				<section class="content" id="mainPanel">
					<div id="information">
						
		                <!-- InstanceBeginEditable name="information" -->	
					  	<?php 
						include ('index_script.php'); 
						?>
						<!-- InstanceEndEditable -->
		            </div>
				</section>
				<?php include("template/menu_sidebar.php");?>
			</div>
			<form id="frm_actu" name="frm_actu" method="post" action="" enctype="multipart/form-data">
				<?php include("template/rutas.php");?>
			</form>
			<?php include("template/footer.php");?>
		</div>
		 <!-- Modal CHANGELOG -->
	    <div class="modal fade" id="modal_changelog" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	      <div class="modal-dialog">
	        <div class="modal-content">
	            <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	                <h4 class="modal-title" id="myModalLabel">Cambios en Educalinks</h4>
	            </div>
	            <div class="modal-body">
	                <?php include('modal_changelog.php');?>
	                <div>&nbsp;
	                </div>
	            </div>

	            <div class="modal-footer">
	                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
	            </div>
	        </div>
	      </div>
	    </div>
		<!-- Modal -->
		<div class="modal fade" id="pop_up_repr" tabindex="-1" role="dialog" aria-labelledby="pop_up_repr">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">Nuevo Servicio: <b>App gratuita</b> para <b>representantes</b> y <b>estudiantes</b></h4>
					</div>
					<div class="modal-body">
						<img width='100%' src="../imagenes/<? echo $_SESSION['pop_up_repr_img']; ?>" />
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Ocultar</button>
					</div>
				</div>
			</div>
		</div>
		<!-- =============================== -->
		<?php
		include ('../framework/dbconf.php');
		$params = array($_SESSION['USUA_DE'],$_SESSION['USUA_TIPO_CODI'],$_SESSION['encu_codi'],'ENC');
		$sql="{call visi_usua_view_encu(?,?,?,?)}";
		$visi_usua_view = sqlsrv_query($conn, $sql, $params);  
		$row_visi_usua_view = sqlsrv_fetch_array($visi_usua_view);
		if($_SESSION['encu_deta']!=null and $row_visi_usua_view['chan_codi']==null) include("modal_encuesta.php");?>
		<!-- =============================== -->
		<input name="mens_de"  		type="hidden" id="mens_de" 		value='<?php echo $_SESSION['USUA_DE'];  ?>'    />
		<input name="mens_de_tipo"  type="hidden" id="mens_de_tipo" value='<?php echo $_SESSION['USUA_TIPO']; ?>'    />
		<?php include("template/scripts.php");?>
		<script type="text/javascript" src="../includes/common/flexslider/jquery.flexslider-min.js"></script>
		<script type="text/javascript">
		$(window).load(function(){
			// //if('<?= $_SESSION['usa_app'];?>'=='1'){
			// 	if('<?= $_SESSION['pop_up_repr_flag'];?>'== '1' ){
			// 		if('<?= $_SESSION['USUA_TIPO'];?>'=='A'){ //es de tipo alumno
			// 			if('<?= $_SESSION['alum_app'];?>'=='0')
			// 				$('#pop_up_repr').modal('show');
			// 		}else{
			// 			if('<?= $_SESSION['repr_app'];?>'=='0')
			// 				$('#pop_up_repr').modal('show');
			// 		}
			// 	}
			// //}
			<? if($_SESSION['encu_deta']!=null and $row_visi_usua_view['chan_codi']==null){ ?>
				$('#modal_encu').modal({backdrop: 'static', keyboard: false});
				$('#modal_encu').modal('show');
			<?} ?>
			// $('#modal_changelog').modal('show');
	        // $('.carousel').slick();
	        // $('.carousel').carousel()
	        // $('.flexslider').flexslider({
			  //   animation: "slide"
		  	// });
		});
		</script>
	</body>
</html>