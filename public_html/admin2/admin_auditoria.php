<!DOCTYPE html>
<html lang="es">
    <?php include("template/head.php");?>
    <body class="hold-transition skin-blue sidebar-mini">
		<div class="wrapper">
			<?php include ('template/header.php');?>
			<?php $Menu=404;include("template/menu.php");?>
			<div class="content-wrapper">
				<section class="content-header">
					<?php
						$params = array($_SESSION['curs_para_codi']);
						$sql="{call curs_para_info(?)}";
						$curs_para_info = sqlsrv_query($conn, $sql, $params);  
						$row_curs_para_info = sqlsrv_fetch_array($curs_para_info);
				  	?>
					<h1>Auditoría</h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-briefcase"></i></a></li>
						<li class="active">Auditoría</li>
					</ol>
				</section>
				<section class="content" id="mainPanel">
					<div id="information">
						<form name="auditoria" target="_blank" method="post" action="audi_listas_main_view.php" onSubmit="return Validar()">
							<div class="box box-default">
								<div class="box-header with-border">
									<h3 class="box-title">
										<div class="col-sm-6"  >
											<div class="input-group" >		
												<span class="input-group-addon">
													<small>Desde: </small></span>
												<input type="text" class="form-control" name="audi_fec_ini" id="audi_fec_ini" 
															value="<?= date("Y-m-d");?>" required="required">
											
												<span class="input-group-addon">
													<small>Hasta:</small></span>
												<input type="text" class="form-control" name="audi_fec_fin" id="audi_fec_fin" 
															value="<?= date("Y-m-d");?>"required="required">
											</div>
										</div>
										<div class='col-sm-2'>
											<a id="bt_mate_add" class="btn btn-default"  onClick="document.auditoria.onsubmit();" >
												<span style='color:red;' class="fa fa-file-pdf-o"></span> Imprimir historial
											</a>
										</div>
									</h3>
								</div><!-- /.box-header -->
								<div class="box-body">
									<div id="auditoria_main" >
										 <?php include ('admin_auditoria_script.php'); ?>
									</div>
								</div>
							</div>
						</form>
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
			function Validar ()
			{   if (ValidaAcciones() && ValidaUsuarios())
				{   document.auditoria.submit();
					return true;
				}
				else
				{   return false;
				}
			}
			function ValidaAcciones ()
			{
				if (IsChk('acciones'))
				{   //ok, hay al menos 1 elemento checkeado envía el form!
					return true;
				} 
				else 
				{   //ni siquiera uno chequeado no envía el form
					alert ('¡Seleccione una acción!');
					return false;
				}
			}
			
			function ValidaUsuarios ()
			{   if (IsChk('usuarios'))
				{   //ok, hay al menos 1 elemento checkeado envía el form!
					return true;
				} 
				else 
				{   //ni siquiera uno chequeado no envía el form
					alert ('¡Seleccione un usuario!');
					return false;
				}
			}
			
			function IsChk(chkName)
			{   var found = false;
				var chk = document.getElementsByName(chkName+'[]');
				for (var i=0 ; i < chk.length ; i++)
				{
					found = chk[i].checked ? true : found;
				}
				return found;
			}
			
			function seleccionar_todos_acciones()
			{   var chk = document.getElementsByName('acciones[]');
				for (var i=0 ; i < chk.length ; i++)
				{
					chk[i].checked=1;
				}
			} 
			function deseleccionar_todos_acciones()
			{   var chk = document.getElementsByName('acciones[]');
				for (var i=0 ; i < chk.length ; i++)
				{
					chk[i].checked=0;
				}
			} 
			function seleccionar_todos_usuarios()
			{   var chk = document.getElementsByName('usuarios[]');
				for (var i=0 ; i < chk.length ; i++)
				{
					chk[i].checked=1;
				}
			} 
			
			function deseleccionar_todos_usuarios()
			{   var chk = document.getElementsByName('usuarios[]');
				for (var i=0 ; i < chk.length ; i++)
				{
					chk[i].checked=0;
				}
			}
			$("#audi_fec_ini").datepicker
			(   {   dateFormat: 'yy-mm-dd',
					onSelect: function(date)
					{
						this.value=date;
					}
				}
			);
			$("#audi_fec_fin").datepicker({ dateFormat: 'yy-mm-dd' });
		</script>
	</body>
</html>