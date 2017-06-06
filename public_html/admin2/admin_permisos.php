<!DOCTYPE html>
<html lang="es">
    <?php include("template/head.php");?>
	<link href="../theme/jquery1_11/external/jquery/jquery_bonsai/jquery.bonsai.css" rel="stylesheet" type="text/css" />
    <body class="hold-transition skin-blue sidebar-mini <?php echo $_SESSION['sidebar_status']; ?>">
		<div class="wrapper">
			<?php include ('template/header.php');?>
			<?php $Menu=416;include("template/menu.php");?>
			<div class="content-wrapper">
				<section class="content-header">
					<h1>Permisos</h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-circle-o"></i></a></li>
						<li class="active">Permisos</li>
					</ol>
				</section>
				<section class="content" id="mainPanel">
					<div id="information">
						<script type="text/javascript" src="js/funciones_permisos.js?<?= $rand?>"> </script>
						<div class='panel panel-info'>
							<div class='panel-heading'>
								<?php 
									$sql_rol="{call rol_view()}";
									$stmt_rol = sqlsrv_query($conn, $sql_rol);
									if( $stmt_rol === false )
									{
										echo "Error in executing statement .\n";
										die( print_r( sqlsrv_errors(), true));
									}
									$a=0;
								?>
								<div class='input-group input-group-sm'>
									<span id="span_balance_reason" name="span_balance_reason" class="input-group-addon">Ver permisos del rol</span>
										<select class='form-control input-sm' id="rol_usuario" name="rol_usuario"
											onchange="carga_permisos('div_permi_roles', 'script_permisos.php', this.value,document.getElementById('a').value);">
											<option value="0">- Seleccione un rol -</option>
											<?php while($rol_view= sqlsrv_fetch_array($stmt_rol)){?>
											<option value="<?= $rol_view['rol_codi'];?>"><?= $rol_view['rol_deta'];?></option>
											<?php }?>
										</select>
									<!--<span class="input-group-btn">
										<button type="button" class="btn btn-info btn-flat" 
											onclick="carga_permisos('div_permi_roles','script_permisos.php', document.getElementById('rol_usuario').value,document.getElementById('a').value);">Ir</button>
									</span>-->
								</div>
							</div>
							<div style='background-color:white; height:300px;'>
								<div  style='background-color:white; height:300px; overflow: scroll;'>
									<br>
									<div id="div_permi_roles">
										<input type="hidden" id="a" name="a" value="<?=$a ?>"/>
									</div>
									<br>
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
        <script src="../theme/jquery1_11/external/jquery/jquery_bonsai/jquery.bonsai.js" type="text/javascript"></script>
        <script src="../theme/jquery1_11/external/jquery/jquery_bonsai/jquery.qubit.js" type="text/javascript"></script>
		<script type="text/javascript" charset="utf-8">
			$('#permi_ul').bonsai({
			  expandAll: false,
			  checkboxes: true, // depends on jquery.qubit plugin
			  createCheckboxes: true
			});
		</script>
	</body>
</html>