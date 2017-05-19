<!DOCTYPE html>
<html lang="es">
    <?php include("template/head.php");?>
	<style>
		.toolbar {
			float: left;
		}
	</style>
    <body class="hold-transition skin-blue sidebar-mini">
		<?php include ('template/header.php');?>
		<?php $Menu=700; include("template/menu.php");?>
		<div class="content-wrapper">
			<!--<div style="padding: 20px 30px; background: rgb(243, 156, 18); z-index: 999999; font-size: 16px; font-weight: 600;"><a class="pull-right" href="#" data-toggle="tooltip" data-placement="left" 
			title="No mostrarme este mensaje de nuevo!"
			style="color: rgb(255, 255, 255); font-size: 20px;">×</a><a href="../../admin/periodos_main.php" style="color: rgba(255, 255, 255, 0.901961); display: inline-block; margin-right: 10px; text-decoration: none;">
			Tienes etapas de distribucion por terminar</a><a class="btn btn-default btn-sm" href="../../admin/admin_periodos_etapas.php?peri_codi=<?=$_SESSION['peri_codi']?>" style="margin-top: -5px; border: 0px; box-shadow: none; color: rgb(243, 156, 18); font-weight: 600; background: rgb(255, 255, 255);">
			Ver etapas por terminar!</a></div>-->
			<section class="content-header">
				<h1>Bandeja de mensajes 
					<small></small>
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-envelope"></i></a></li>
					<li class="active">Bandeja de mensajes</li>
				</ol>
			</section>
			<section class="content" id="mainPanel">
				<div class="information">
					<div class="mensajes">
						<script type="text/javascript" src="../framework/funciones.js"> </script>
						<div id="mens_main_view">
							<?php include ('mensajes_view.php'); ?>
						</div>
					</div>
				</div>
			</section>
			<?php include("template/menu_sidebar.php");?>
			<form id="frm_actu" name="frm_actu" method="post" action="" enctype="multipart/form-data">
				<?php include("template/rutas.php");?>
			</form>
			<?php include("template/footer.php");?>
		</div>
		<!-- =============================== -->
		<input name="mens_de"  		type="hidden" id="mens_de" 		value='<?php echo $_SESSION['USUA_DE'];  ?>'    />
		<input name="mens_de_tipo"  type="hidden" id="mens_de_tipo" value='<?php echo $_SESSION['USUA_TIPO']; ?>'    />
		<?php include("template/scripts.php");?>
		<script type="text/javascript" src="../../site_media/js/common/general.js"></script>
		<script type="text/javascript" src="../../site_media/js/finan/general.js"></script>
		<script type="text/javascript">  
			$(document).ready(function(){  
				$('#mensajes_table').DataTable({
					"bPaginate": false,
					"bStateSave": false,
					"bAutoWidth": false,
					"bScrollAutoCss": true,
					"bProcessing": true,
					"bRetrieve": true,
					"aLengthMenu": [[10,25, 50, 100, -1], [10,25, 50, 100, "Todos"]],
					"fnInitComplete": function() {
						this.css("visibility", "visible");
						$("div.toolbar").html("<button class='btn btn-default margin-bottom' type='button' id='ckb_codigoDocumento_head2' name='ckb_codigoDocumento_head2'"+
												"onClick='js_mensajes_select_all( )'>"+
												"<span id='span_codigoDocumento_head1' class='fa fa-square-o'></span>&nbsp;"+
												"<span id='span_codigoDocumento_head2'>Marcar todos</span></button>"+
											"&nbsp;<button style='display:none;' class='btn btn-default margin-bottom' type='button' id='btn_delete_all_sms' name='btn_delete_all_sms' onclick='js_mensajes_delete_all_sms();'><span class='fa fa-trash'></span> Eliminar todos</button>");
					},
					paging: true,
					lengthChange: false,
					searching: true,
					language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'},
						"columnDefs": [
							{className: "dt-body-center" , "targets": [2]}
						],
					"dom": '<"toolbar">frtip'
				});
			});
			function js_mensajes_delete_all_sms()
			{   checkboxes = document.getElementsByName('ckb_codigoDocumento[]');
				var mensaje=[];
				var bandera = 0;
				for(var i = 0, n = checkboxes.length; i < n; i++ )
				{   if ( checkboxes[i].checked )
					{   mensaje.push(checkboxes[i].value);
						bandera++;
					}
				}
				document.getElementById('hd_del_sms_many').value = JSON.stringify( mensaje );
				$('#modal_del_sms_many').modal("show");
				
			}
			function js_mensajes_delete_all_sms_followed()
			{   var data = new FormData();
				data.append('opc', 'delete_all' );
				data.append('op', document.getElementById('hd_op').value );
				data.append('mensajes', document.getElementById('hd_del_sms_many').value );
			
				var xhr_mensaje = new XMLHttpRequest();
				xhr_mensaje.open('POST', 'script_mensajes_funciones.php' , true);
				xhr_mensaje.onload = function ()
				{   
				};
				xhr_mensaje.onreadystatechange=function()
				{   if (xhr_mensaje.readyState==4 && xhr_mensaje.status==200)
					{   var n = xhr_mensaje.responseText.length;
						$('#modal_del_sms_many').modal("hide");
						if (n > 0)
						{	valida_tipo_growl(xhr_mensaje.responseText);
						}
						else
						{   $.growl.warning({ title: "Educalinks informa:",message: "Proceso realizado sin confirmación del sistema." });
						}
						load_ajax_mensajes( 'mens_main_view', 'mensajes_view.php', 'OP=' + document.getElementById('hd_op').value, 4 );              
					}
				};
				xhr_mensaje.send(data);
			}
			function js_mensajes_select_all (  )
			{   if ( $('#span_codigoDocumento_head1').hasClass('fa-square-o') )
				{   $('#span_codigoDocumento_head1').removeClass('fa-square-o').addClass('fa-check-square-o');
					$('#span_codigoDocumento_head2').html("Desmarcar todos");
					if ( document.getElementById('hd_op').value !== 4)
						document.getElementById('btn_delete_all_sms').style.display = 'inline';
					checked = true;
				}
				else
				{   $('#span_codigoDocumento_head1').removeClass('fa-check-square-o').addClass('fa-square-o');	
					$('#span_codigoDocumento_head2').html("Marcar todos");
					document.getElementById('btn_delete_all_sms').style.display = 'none';
					checked = false;
				}
				checkboxes = document.getElementsByName('ckb_codigoDocumento[]');
				for(var i = 0, n = checkboxes.length; i < n; i++ )
				{   checkboxes[i].checked = checked;
					
					if ( checked )
					{   if ( document.getElementById( 'tr_row_' + checkboxes[i].value ) )
							document.getElementById( 'tr_row_' + checkboxes[i].value ).style.backgroundColor = '#ffc';
					}
					else
					{   if ( document.getElementById( 'tr_row_' + checkboxes[i].value ) )
							document.getElementById( 'tr_row_' + checkboxes[i].value ).style.backgroundColor = 'white';
					}
				}
				if ( checked )
				{   document.getElementById('ckb_codigoDocumento_head').checked = true;
				}
				else
				{   document.getElementById('ckb_codigoDocumento_head').checked = false;
				}		
			}
			function js_mensajes_select_check_ind ( source, num_linea )
			{   var marcar = 'si';
				checkboxes = document.getElementsByName('ckb_codigoDocumento[]');
				var total_sinchecar = 0;
				for(var i = 0, n = checkboxes.length; i < n; i++ )
				{   if ( !checkboxes[i].checked )
					{	marcar = 'no';
						total_sinchecar++;
					}
				}
				if ( source.checked ) //si se marcó el checkbox del cual proviene la acción
				{   if ( document.getElementById( 'tr_row_' + source.value ) )
						document.getElementById( 'tr_row_' + source.value ).style.backgroundColor = '#ffc';
				}
				else //si se desmarcó el checkbox del cual proviene la acción
				{   if ( document.getElementById( 'tr_row_' + source.value ) )
						document.getElementById( 'tr_row_' + source.value ).style.backgroundColor = 'white';
				}
				if ( marcar === 'si' ) //si todos están seleccionados
				{	document.getElementById('ckb_codigoDocumento_head').checked = 'checked';
					$('#span_codigoDocumento_head1').removeClass('fa-square-o').addClass('fa-check-square-o');
					$('#span_codigoDocumento_head2').html("Desmarcar todos");
					if ( document.getElementById('hd_op').value !== 4 )
						document.getElementById('btn_delete_all_sms').style.display = 'inline';
				}
				else  //si no todos están seleccionados
				{	document.getElementById('ckb_codigoDocumento_head').checked = false;
					$('#span_codigoDocumento_head1').removeClass('fa-check-square-o').addClass('fa-square-o');
					$('#span_codigoDocumento_head2').html("Marcar todos");
				}
				if ( total_sinchecar == n ) //si no hay ningún seleccionado
				{	document.getElementById('btn_delete_all_sms').style.display = 'none';
				}
				else //si hay por lo menos uno seleccionado
				{   if ( document.getElementById('hd_op').value !== 4 )
						document.getElementById('btn_delete_all_sms').style.display = 'inline';
				}
			}
		</script>
		<!-- Modal -->
		<div class="modal fade bs-example-modal-lg" id="nuev_mens" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						<h4 class="modal-title" id="nuev_mens_modal">Nuevo Mensaje</h4>
					</div>
					<div class="modal-body">
						<div class="row" id="div_mens_nuev" >
							titulo
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" id="envio_mensaje" data-loading-text="Enviando..." onClick="envio_mensaje_nuevo();">
						Enviar
						</button>

						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<button type="button" class="btn btn-default" data-dismiss="modal">
						Cerrar
						</button>
					</div>
				</div>
			</div>
		</div>
		<!-- Modal Responder-->
		<div class="modal fade bs-example-modal-lg" id="mens_responder" tabindex="-1" role="dialog" aria-labelledby="myModal" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div id="div_mens_resp" class="modal-content">
				  
				</div>
			</div>
		</div>
		<!-- Modal eliminar-->
		<div class="modal fade bs-example-modal-sm" id="modal_del_sms" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-sm">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						<h4 class="modal-title">Educalinks</h4>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-md-12">
								¿Eliminar mensaje? Pasará a la bandeja de mensajes eliminados.
							</div>
						</div>
						<input type='hidden' id='hd_del_mes_codi' name='hd_del_mes_codi' value=''></input>
					</div>
					<div class="modal-footer">
						<button class="btn btn-danger" type="button" onclick="elimina_mensaje_followed( )">
							<span class="fa fa-trash"></span>&nbsp;Eliminar</button>
						<button class="btn btn-default" data-dismiss="modal"><li style="color:red;" class="fa fa-ban"></li>&nbsp;No Eliminar</button>
					</div>
				</div>
			</div>
		</div>
		<!-- Modal eliminar-->
		<div class="modal fade bs-example-modal-sm" id="modal_del_sms_many" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-sm">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						<h4 class="modal-title">Educalinks</h4>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-md-12">
								¿Eliminar mensajes? Pasarán a la bandeja de mensajes eliminados.
							</div>
						</div>
						<input type='hidden' id='hd_del_sms_many' name='hd_del_sms_many' value=''></input>
					</div>
					<div class="modal-footer">
						<button class="btn btn-danger" type="button" onclick="js_mensajes_delete_all_sms_followed( )">
							<span class="fa fa-trash"></span>&nbsp;Eliminar</button>
						<button class="btn btn-default" data-dismiss="modal"><li style="color:red;" class="fa fa-ban"></li>&nbsp;No Eliminar</button>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
