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
						$params = array($_SESSION['curs_para_codi']);
						$sql="{call curs_para_info(?)}";
						$curs_para_info = sqlsrv_query($conn, $sql, $params);  
						$row_curs_para_info = sqlsrv_fetch_array($curs_para_info);
				  	?>
					<h1>Contrase&ntilde;a</h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-key"></i></a></li>
						<li class="active">Contrase&ntilde;a</li>
					</ol>
				</section>
				<section class="content" id="mainPanel">
					<div id="information">
						<div class="box box-default">
							<div class="box-header with-border">
								<h3 class="box-title">Cambio de Contrase&ntilde;a
								</h3>
							</div><!-- /.box-header -->
							<div class="box-body">
								<?php  
								session_start();
								include ('../framework/dbconf.php');
								
								if(isset($_POST['current_pass']))
								{
									$params = array($_SESSION['prof_codi']);
									$sql="{call prof_info(?)}";
									$stmt = sqlsrv_query($conn, $sql, $params);
									if( $stmt === false )
									{
										echo "Error in executing statement .\n";
										die( print_r( sqlsrv_errors(), true));
									} 
									$usua_view= sqlsrv_fetch_array($stmt);
									if($usua_view['prof_pass']==$_POST['current_pass'])
									{
										if ($_POST['new_pass_1']==$_POST['new_pass_2'])
										{
											$params_usua = array($_SESSION['prof_codi'], $_POST['new_pass_1']);
											$sql_usua="{call prof_pass_upd(?,?)}";
											$stmt_usua = sqlsrv_query($conn, $sql_usua, $params_usua);
											if( $stmt_usua === false )
											{
												echo "Error in executing statement .\n";
												die( print_r( sqlsrv_errors(), true));
											}
											else
											{
										?>
											<script>
												$.growl.notice({ title: "Listo!",message: "Se actualiz&oacute; la contrase&ntilde;a correctamente." });
											</script>
										<?
											}
										}
										else
										{
									?>
										<script>
											$.growl.error({ title: "<b>¡Error!</b>",message: "Las contraseñas no coinciden." });
										</script>
									<?
										}
									}
									else
									{
									?>
										<script>
											$.growl.error({ title: "<b>¡Error!</b>",message: "Las contraseña ingresada no es la correcta." });
										</script>
									<?
										
									}
								}
									?>

									<div class="alumnos_add_script admin_pass">
									  <form id="usua_pass_form" name="usua_pass_form" enctype="multipart/form-data" action="admin_pass.php" method="post">

										<div class='form-horizontal'>
											<div class='form-group'>
												<div class="col-sm-6">
													<label for="current_pass">Contrase&ntilde;a Actual:</label>
													<input class='form-control input-sm' id="current_pass" name="current_pass" type="password" placeholder="Ingrese su clave actual..." value="">
												</div>
											</div>
											<div class='form-group'>
												  <div class="col-sm-6">
													<label for="new_pass_1">Nueva Contrase&ntilde;a:</label>
													<input class='form-control input-sm' id="new_pass_1" name="new_pass_1" type="password" placeholder="Ingrese su nueva clave..." value="">
												  </div>
											</div>
											<div class='form-group'>
												<div class="col-sm-6">
													<label for="new_pass_2">Confirme su nueva contrase&ntilde;a:</label>
													<input class='form-control input-sm' id="new_pass_2" name="new_pass_2" type="password" placeholder="Confirme su nueva clave..." value="">
												</div>
											</div>
											<div class='form-group'>
												<div class="col-sm-6">
													<button class='btn btn-success' id="pass_guardar" name="pass_guardar" type="submit" ><span class='fa fa-floppy-o'></span> Grabar</button>
												</div>
											</div>
										</div>
								   </form>
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