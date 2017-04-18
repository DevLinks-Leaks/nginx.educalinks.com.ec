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
						<li class="active">Activación de licencia</li>
					</ol>
				</section>
				<section class="content" id="mainPanel">
					<div id="information" class="box" style="padding: 20px">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-6 form-inline">
                                <p>Por favor ingrese su llave electrónica para poder activar el aula virtual</p>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fa fa-keyboard-o" aria-hidden="true"></i></div>
                                        <input type="text" class="form-control" id="txt_pin" placeholder="Llave electrónica">
                                        <div class="input-group-addon"><i class="fa fa-key" aria-hidden="true"></i></div>
                                        <input id="txt_alum_curs_para_codi" value="<?= $_SESSION['alum_curs_para_codi'] ?>" type="hidden" />
                                    </div>
                                </div>
                                <button id="btn_activar_licencia" type="submit" class="btn btn-primary">Activar licencia</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-offset-3 col-md-6">
                                <p id="msj_error" class="bg-warning text-warning"></p>
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
		<? if($_SESSION['encu_deta']!=null) include("modal_encuesta.php");?>
		<!-- =============================== -->
		<input name="mens_de"  		type="hidden" id="mens_de" 		value='<?php echo $_SESSION['USUA_DE'];  ?>'    />
		<input name="mens_de_tipo"  type="hidden" id="mens_de_tipo" value='<?php echo $_SESSION['USUA_TIPO']; ?>'    />
		<?php include("template/scripts.php");?>
		<script type="text/javascript">
		$(window).load(function(){
		    $('#txt_pin').focus();
		});
		</script>
	</body>
</html>