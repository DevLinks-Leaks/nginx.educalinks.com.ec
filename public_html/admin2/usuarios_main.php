<!DOCTYPE html>
<html lang="es">
    <?php include("template/head.php");?>
    <body class="hold-transition skin-blue sidebar-mini">
		<div class="wrapper">
			<?php include ('template/header.php');?>
			<?php $Menu=402;include("template/menu.php");?>
			<div class="content-wrapper">
				<section class="content-header">
					<?php
						$params = array($_SESSION['curs_para_codi']);
						$sql="{call curs_para_info(?)}";
						$curs_para_info = sqlsrv_query($conn, $sql, $params);  
						$row_curs_para_info = sqlsrv_fetch_array($curs_para_info);
				  	?>
					<h1>Usuarios</h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-users"></i></a></li>
						<li class="active">Usuarios</li>
					</ol>
				</section>
				<section class="content" id="mainPanel">
					<div id="information">
						<div class="box box-default">
							<div class="box-header with-border">
								<h3 class="box-title">
									<?php if (permiso_activo(49)){?>
										<a class="btn btn-primary" onclick="document.getElementById('usua_nombre').focus();" data-toggle="modal" data-target="#ModalUsuaAdd" title="">
											<span class="fa fa-user"></span><span class="fa fa-plus"></span> Agregar Usuario
										</a>
									<?php }?>
								</h3>
							</div><!-- /.box-header -->
							<div class="box-body">
								<script type="text/javascript" src="js/funciones_usua.js"></script> 
								<div id="usua_main">
									<?php include ('usuarios_main_lista.php'); ?>
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
			$(document).ready(function() {
				$('#usua_table').DataTable() ;
			} );
		</script>
	</body>
</html>
<div 
	class="modal fade" 
	id="ModalUsuaAdd" 
	tabindex="-1" 
	role="dialog" 
	aria-labelledby="myModalLabel" 
	aria-hidden="true">
  <div class="modal-dialog">
	<div class="modal-content">
	  <div class="modal-header">
		<button 
			type="button" 
			class="close" 
			data-dismiss="modal">
			<span aria-hidden="true">&times;</span>
		</button>
		<h4 class="modal-title" id="myModalLabel">Nuevo Usuario</h4>
	  </div>
	  <div id="modal_main" class="modal-body">
		<div id="div_usua_nuev"> 
			<form 
				id="frm_usua_add" 
				name="frm_usua_add" 
				method="post" 
				action="" 
				enctype="multipart/form-data">
			<table style="width: 100%;" >
				<tr>
					<td>
						<label for="rol_codi">
							Rol: 
						</label>
					</td>
					<td>
						<select 
							id="rol_codi"
							name="rol_codi" 
							class="form-control input-sm"
							style="width: 50%; margin-top: 5px;">
					<? 
					session_start();	 
					include ('../framework/dbconf.php');
					$texto='%';
					$params = array($texto);
					$sql="{call rol_busq(?)}";
					$rol_busq = sqlsrv_query($conn, $sql, $params);  
					while($row_rol_busq = sqlsrv_fetch_array($rol_busq))
					{
					?>
						<option value="<?= $row_rol_busq['rol_codi']?>">
							<?= $row_rol_busq['rol_deta']?>
						</option>
					<? 
					}
					?>
						</select>
					</td>
				<tr>
					<td>
						<label for="usua_nombre">Nombres: </label>
					</td>
					<td>
						<input 
							type="text" class="form-control input-sm"
							id="usua_nombre" 
							name="usua_nombre" 
							value="" 
							placeholder="Ingrese los nombres..."
							style="width: 100%; margin-top: 5px;">
					</td>
				</tr>
				<tr>
					<td>
						<label for="usua_apellido">
							Apellidos: 
						</label>
					</td>
					<td>
						<input 
							type="text" class="form-control input-sm"
							id="usua_apellido" 
							name="usua_apellido" 
							value="" 
							placeholder="Ingrese los apellidos..."
							style="width: 100%; margin-top: 5px;">
					</td>
				<tr>
					<td>
						<label for="usua_email">
							Email: 
						</label>
					</td>
					<td>
						<input 
						type="text" class="form-control input-sm"
						id="usua_email" 
						name="usua_email" 
						value="" 
						placeholder="Ingrese el email..."
						style="width: 100%; margin-top: 5px;">
					</td>
				 </tr>
				<script>
				function verif_usua(text){
					load_ajax_veri_usua('div_veri_usua','script_usua.php','opc=veri_usua&usua_username='+text);
					
				}
				</script>
				<tr>
					<td>
						<label for="usua_username">
							Username: 
						</label>
					</td>
					<td style="display: block;">
						<input 
							type="text" class="form-control input-sm"
							id="usua_username" 
							name="usua_username" 
							value="" 
							placeholder="Ingrese el username..." 
							onkeyup="verif_usua(this.value)"
							style="width: 50%; margin-top: 5px;">
						<input 
							type="hidden" 
							id="usua_veri_username" 
							name="usua_veri_username" 
							value="">
						<div id="div_veri_usua" style="float: right; width: 50%;"></div>
					</td>
			   </tr>                                   
			</table>
			<div class="form_element">&nbsp;</div>   
			</form>
		</div>
	  </div>
	  <div class="modal-footer">
		<button 
			type="button" 
			class="btn btn-success" 
			onClick="load_ajax_add_usua('usua_main','script_usua.php','opc=add&usua_nombre='+document.getElementById('usua_nombre').value+'&usua_apellido='+document.getElementById('usua_apellido').value+'&usua_email='+document.getElementById('usua_email').value+'&usua_username='+document.getElementById('usua_username').value+'&rol_codi='+document.getElementById('rol_codi').value);" >
				Agregar
		</button>
		<button 
			type="button" 
			class="btn btn-default" 
			data-dismiss="modal">
				Cerrar
		</button>
	  </div>
	</div>
  </div>
</div>

<div 
	class="modal fade" 
	id="ModalUsuaEdi" 
	tabindex="-1" 
	role="dialog" 
	aria-labelledby="myModalLabel" 
	aria-hidden="true">
  <div class="modal-dialog">
	<div class="modal-content">
	  <div class="modal-header">
		<button 
			type="button" 
			class="close" 
			data-dismiss="modal">
				<span aria-hidden="true">&times;</span>
		</button>
		<h4 class="modal-title" id="myModalLabel">Editar Usuario</h4>
	  </div>
	  <div id="modal_main" class="modal-body">
		<div id="div_usua_edi"> 
			<form 
				id="frm_usua_edi" 
				name="frm_usua_edi" 
				method="post" 
				action="" 
				enctype="multipart/form-data">
				<table width="100%">
					<tr>
						<td>
							<label>Rol:</label>
						</td>
						<td>
							<div id="div_rol_codi_edi">
								
							</div>
						</td>
					</tr>
					<tr>
						<td>
							<label for="usua_nombre_edi">
								Nombres: 
							</label>
						</td>
						<td>
							<input 
								type="text" class="form-control input-sm"
								id="usua_nombre_edi" 
								name="usua_nombre_edi" 
								value="" 
								placeholder="Ingrese los nombres..."
								style="width: 100%; margin-top: 5px;">
						</td>
					</tr>
					<tr>
						<td>
							<label for="usua_apellido_edi">
								Apellidos: 
							</label>
						</td>
						<td>
							<input 
								type="text" class="form-control input-sm"
								id="usua_apellido_edi" 
								name="usua_apellido_edi" 
								value="" 
								placeholder="Ingrese los apellidos..."
								style="width: 100%; margin-top: 5px;">
						</td>
					</tr>
					<tr>
						<td>
							<label for="usua_email_edi">
								Email: 
							</label>
						</td>
						<td>
							<input 
								type="text" class="form-control input-sm"
								id="usua_email_edi" 
								name="usua_email_edi" 
								value="" 
								placeholder="Ingrese el email..."
								style="width: 100%; margin-top: 5px;">
						</td>
					</tr>
					<tr>
						<td>
							<label for="usua_username_edi">
								Username: 
							</label>
						</td>
						<td>
							<input 
								type="text" class="form-control input-sm"
								id="usua_username_edi" 
								name="usua_username_edi" 
								disabled="disabled" 
								value="" 
								placeholder="Ingrese el username..."
								style="width: 50%; margin-top: 5px;">
							<input 
								type="hidden" 
								id="usua_veri_username_edi" 
								name="usua_veri_username_edi" 
								value="">
						</td>
					</tr>
				</table>                                     
			</form>
		</div>
		<div class="form_element">&nbsp;</div> 
	  </div>
	  <div class="modal-footer">
		<button type="button" class="btn btn-success" onClick="load_ajax_edi_usua('usua_main','script_usua.php','opc=upd&usua_nombre='+document.getElementById('usua_nombre_edi').value+'&usua_apellido='+document.getElementById('usua_apellido_edi').value+'&usua_email='+document.getElementById('usua_email_edi').value+'&usua_username='+document.getElementById('usua_username_edi').value+'&rol_codi='+document.getElementById('rol_codi_edi').value);" >Grabar</button>
		<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
	  </div>
	</div>
  </div>
</div>  