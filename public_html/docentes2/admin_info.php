<!DOCTYPE html>
<html lang="es">
    <?php include("template/head.php");?>
    <body class="hold-transition skin-blue sidebar-mini">
		<div class="wrapper">
			<?php include ('template/header.php');?>
			<?php $Menu=0;include("template/menu.php");?>
			<div class="content-wrapper">
				<section class="content-header">
					<?php  
						session_start();
                        include ('../framework/dbconf.php');
						?>
					<h1>Perfil</h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-user"></i></a></li>
						<li class="active">Perfil</li>
					</ol>
				</section>
				<section class="content" id="mainPanel">
					<div id="information">
						<div class="box box-default">
							<div class="box-header with-border">
								<h3 class="box-title">Informaci&oacute;n de usuario
								</h3>
							</div><!-- /.box-header -->
							<div class="box-body">
								<!-- InstanceBeginEditable name="information" -->
								<form name="frm_prof" id="frm_prof" action="" enctype="multipart/form-data" method="post">
								<?php
									if(isset($_POST['prof_cedu'])){
										$prof_cedu=$_POST['prof_cedu'];
										$prof_mail=$_POST['prof_mail'];
										$_SESSION['prof_mail']=$prof_mail;
										$_SESSION['prof_cedu']=$prof_cedu;
										$prof_codi=$_SESSION['prof_codi'];
										$params = array($_SESSION['prof_usua'],$_SESSION['prof_nomb'],$_SESSION['prof_apel'],$prof_mail,$_SESSION['prof_dire'],$_SESSION['prof_telf'],$prof_cedu,$prof_codi);
										$sql="{call prof_upd(?,?,?,?,?,?,?,?)}";
										$prof_info = sqlsrv_query($conn, $sql, $params);
										if( $conn === false){echo "Error in connection.\n";die( print_r( sqlsrv_errors(), true));}
									}
								?>
									<div style="width:100%; padding-left:20px; padding-top:20px;">
										<?php
										$ruta=$_SESSION['ruta_foto_usuario'].$_SESSION['prof_codi'].".jpg";
										$file_exi=$ruta;
										if (file_exists($file_exi)) {
											$pp=$file_exi;
										} else {
											$pp=$_SESSION['foto_default'];
										}
										?>
										<div class='form-horizontal'>
											<div class='form-group'>
												<div class="col-sm-4">
													<div class="box">
														<div class="box-header">
															<h3 class="box-title"></h3>
														</div>
														<div class="box-body">
															<div class="selector" style="text-align:center;">
																<div class="photo">
																	<img src="<?php echo $pp;?>" style="height:200px; width:200px;" class="img-polaroid" />
																</div>
															</div>															
														</div>
													</div>
												</div>
												<div class="col-sm-8">
													<div class="box">
														<div class="box-header">
															<h3 class="box-title"></h3>
														</div>
														<div class="box-body">
															<div class='form-horizontal'>
																<div class='form-group'>
																	<div class="col-sm-2"><label for="current_pass">Nombre:</label></div>
																	<div class="col-sm-4">
																		<?= $_SESSION['prof_nomb']; ?> <?= $_SESSION['prof_apel']; ?>
																	</div>
																</div>
																<div class='form-group'>
																	<div class="col-sm-2"><label for="prof_mail">Email:</label></div>
																	<div class="col-sm-4">
																		<input class="form-control input-sm" type="text" id="prof_mail" name="prof_mail" value="<?= $_SESSION['prof_mail']; ?>"/>
																	</div>
																</div>
																<div class='form-group'>
																	<div class="col-sm-2"><label>Usuario:</label></div>
																	<div class="col-sm-4">
																		<?= $_SESSION['prof_usua']; ?>
																	</div>
																</div>
																<div class='form-group'>
																	<div class="col-sm-2"><label>Domicilio:</label></div>
																	<div class="col-sm-4">
																		<?= $_SESSION['prof_dire']; ?>
																	</div>
																</div>
																<div class='form-group'>
																	<div class="col-sm-2"><label>Tel&eacute;fono:</label></div>
																	<div class="col-sm-4">
																		<?= $_SESSION['prof_telf']; ?>
																	</div>
																</div>
																<div class='form-group'>
																	<div class="col-sm-2"><label>C&eacute;dula:</label></div>
																	<div class="col-sm-4">
																		<input class="form-control input-sm" type="text" id="prof_cedu" name="prof_cedu" value="<?= $_SESSION['prof_cedu']; ?>"/>
																	</div>
																</div>
																<div class='form-group'>
																	<div class="col-sm-6" style='text-align:center;'>
																		<button class='btn btn-success' type="submit" class="btn btn-primary"><span class='fa fa-floppy-o'></span> Grabar</button>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div> 
								</form> 
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
		<input class="form-control input-sm"name="mens_de"  		type="hidden" id="mens_de" 		value='<?php echo $_SESSION['USUA_DE'];  ?>'    />
		<input class="form-control input-sm"name="mens_de_tipo"  type="hidden" id="mens_de_tipo" value='<?php echo $_SESSION['USUA_TIPO']; ?>'    />
		<?php include("template/scripts.php");?>
		<script type="text/javascript" charset="utf-8">
		</script>
	</body>
</html>