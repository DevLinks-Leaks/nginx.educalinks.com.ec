<!DOCTYPE html>
<html lang="es">
    <?php include("template/head.php");?>
    <body class="hold-transition skin-blue sidebar-mini <?php echo $_SESSION['sidebar_status']; ?>">
		<div class="wrapper">
			<?php include ('template/header.php');?>
			<?php $Menu=403;include("template/menu.php");?>
			<div class="content-wrapper">
				<?php if ($_SERVER['REQUEST_METHOD'] == 'POST') include ('para_sistema_main_submit_save.php'); ?>
				<section class="content-header">
					<?php
						$params = array($_SESSION['curs_para_codi']);
						$sql="{call curs_para_info(?)}";
						$curs_para_info = sqlsrv_query($conn, $sql, $params);  
						$row_curs_para_info = sqlsrv_fetch_array($curs_para_info);
				  	?>
					<h1><i class='fa fa-cog fa-spin'></i>&nbsp;Parámetros del sistema</h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-cogs fa-spin"></i></a></li>
						<li class="active">Parámetros del sistema</li>
					</ol>
				</section>
				<section class="content" id="mainPanel">
					<div id="information">
						<div class="box box-default">
							<div class="box-header with-border" style='text-align:center;'>
								<div style='font-size:small'>Los valores configurados en esta pestaña afectan todo el sistema. </div>
							</div><!-- /.box-header -->
							<div class="box-body">
								<script type="text/javascript" src="js/funciones_para_sistema.js"></script> 
								<div id="para_sist_main" >
									 <?php include ('para_sistema_main_lista.php'); ?>
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
				$('[data-toggle="popover"]').popover({html:true});
				$('#para_sist_table').DataTable({
					language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'},
				 	"bSort": false 
				}) ;
			} );
			var b = false;
			function toggle_notas_decimales( opc )
			{
				if ( opc === 1 )
					$('#notas_decimales').prop('checked', true).change()
				if ( opc === 2 )
					$('#notas_decimales').prop('checked', false).change()
			}
			function toggle_modo_genera_alum_codi( opc )
			{
				if ( opc === 1 )
					$('#modo_genera_alum_codi').prop('checked', true).change()
				if ( opc === 2 )
					$('#modo_genera_alum_codi').prop('checked', false).change()
			}
			function js_param_list_navbar( object )
			{   $( '.button_param_menu' ).removeClass('btn btn-primary btn-block');
				$( '.button_param_menu' ).addClass('btn btn-default btn-block');
				$( '.button_param_menu' ).css('color', 'black');
				$( object ).addClass('btn btn-primary btn-block');
				$( object ).css('color', 'white');
			}
			function js_param_list_navbar_sm ( object )
			{   $( '.button_param_menu' ).removeClass('btn btn-primary');
				$( '.button_param_menu' ).addClass('btn btn-default');
				$( '.button_param_menu' ).css('color', 'black');
				$( object ).addClass('btn btn-primary');
				$( object ).css('color', 'white');
			}
			function js_param_list_save ()
			{	document.getElementById('frm_parametros_sistema').submit();
			}
			function dismiss_process_ans() {
				var e = document.getElementById('save_ans');
				if(!b) e.style.display = 'none';
				b=false;
			}
			function js_general_config_bdp()
			{   $('#modal_configBoton').modal('show');
				document.getElementById( 'modal_configBoton_body' ).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
				var data = new FormData();
				data.append('event', 'config_pagoweb');
				var xhr = new XMLHttpRequest();
				xhr.open('POST', '../../modulos/finan/general/controller.php' , true);
				xhr.onreadystatechange=function()
				{   if (xhr.readyState === 4 && xhr.status === 200)
					{   document.getElementById( 'modal_configBoton_body' ).innerHTML = xhr.responseText;
						$('[data-toggle="popover"]').popover({html:true});
						$("#pto_prefijo_add").numeric({ decimal : false,  negative : false, precision: 3 });
						$("#pto_secuencia_add").numeric({ decimal : false,  negative : false, precision: 14 });
					}
				};
				xhr.send(data);
				
			}
			function js_general_config_bdp_change()
			{	var data = new FormData();
				data.append('event', 'set_pagoweb');
				if(document.getElementById('rdb_bdp_activo_act').checked)
				{	data.append('active_web', 'S' );
				}
				else if(document.getElementById('rdb_bdp_activo_ina').checked)
				{	data.append('active_web', 'N' );
				}
				
				data.append('puntVent_prefijo', document.getElementById('pto_prefijo_web').value);
				data.append('puntVent_codigoSucursal', document.getElementById('pto_sucursal_web').value);
				data.append('puntVent_secuencia', document.getElementById('pto_secuencia_web').value);
				document.getElementById( 'modal_configBoton_body' ).innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i><br>Procesando solicitud...</div>';
				var xhr = new XMLHttpRequest();
				xhr.open('POST', '../../modulos/finan/general/controller.php' , true);
				xhr.onreadystatechange=function()
				{   if (xhr.readyState === 4 && xhr.status === 200)
					{   $('#modal_configBoton').modal('hide');
						document.getElementById( 'modal_configBoton_body' ).innerHTML='';
						//Limpia contenido del modal, en caso de que los nombres de los controles entren en conflicto con otro control cargado en la página.
						var n = xhr.responseText.length;
						if (n > 0)
						{   js_funciones_valida_tipo_growl(xhr.responseText);
						}
						else
						{   $.growl.warning({ title: "Educalinks informa:",message: "Proceso realizado." + xhr.responseText });
						}
					}
				};
				xhr.send(data);
			}
		</script>
	</body>
</html>
<div class="modal fade" id="ModalUsuaEdi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Editar Parámetro</h4>
			</div>
			<div id="modal_main" class="modal-body">
				<div id="div_usua_edi"> 
					<form id="frm_usua_edi" name="frm_usua_edi" method="post" action="" enctype="multipart/form-data">
						<div class="form_element">
						<table border="0" cellpadding="0" cellspacing="0" width="100%;" class="table">
						<tr>
						<td width="25%"><label for="para_deta_edi">Parámetro: </label></td>
						<td width="75%">
						<input type="text" class="form-control input-sm"id="para_deta_edi" style="width: 100%; margin-top: 5px;"  name="para_deta_edi" value="" disabled>
						<input type="hidden" id="para_codi_edi" name="para_codi_edi" value="">
						</td>
						</tr>
						<tr>
						<td><label for="para_valo_edi">Valor: </label></td>
						<td><textarea id="para_valo_edi" style="width: 100%; margin-top: 5px;" name="para_valo_edi" value=""></textarea></td>
						</tr>
						</table>  
						</div>
						<div class="form_element">&nbsp;</div>                
					</form>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-success" 
					onClick="load_ajax_edi_para_sist('para_sist_main','script_para_sistema.php',
					'opc=upd&sist_codi='+document.getElementById('para_codi_edi').value+'&sist_valo='+document.getElementById('para_valo_edi').value);" >
					<span class='fa fa-floppy-o'></span> Guardar Cambios</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>  