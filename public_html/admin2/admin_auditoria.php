<!DOCTYPE html>
<html lang="es">
    <?php include("template/head.php");?>
    <body class="hold-transition skin-blue sidebar-mini <?php echo $_SESSION['sidebar_status']; ?>">
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
						<form name="auditoria" target="_blank" method="post" action="" onSubmit="">
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
									<h3 class="panel-title"><span class="fa fa-search"></span>&nbsp;Búsqueda
									<div class="pull-right">
										<a href="#/"  id="boton_busqueda" name="boton_busqueda" style='text-decoration:none;'><span class='fa fa-minus'></span></a>
									</div>
								</h3>
								</div>
								<div class="panel-body" id="desplegable_busqueda" name="desplegable_busqueda">
									<div class="form-horizontal">
										<div class="form-group">
											<div class="col-md-6 col-sm-12">
												<div class="input-group">
													<span class="input-group-addon">
														<input type="checkbox" id='chk_fecha' name='chk_fecha' checked onclick='js_auditoria_chk_fecha();'>
													</span>		
													<span class="input-group-addon">
														Desde</span>
													<input type="text" class="form-control" name="audi_fec_ini" id="audi_fec_ini" 
																value="<?= date("Y-m-d");?>" required="required">
												
													<span class="input-group-addon">
														Hasta</span>
													<input type="text" class="form-control" name="audi_fec_fin" id="audi_fec_fin" 
																value="<?= date("Y-m-d");?>"required="required">
												</div>
											</div>
											<div class='col-md-6 col-sm-12' style='text-align:right;'>
												<a href="#" id="bt_mate_add" class="btn btn-primary"  onClick="Validar();" >
													<span class="fa fa-search"></span> Buscar
												</a>
											</div>
										</div>
										<div class="form-group">
											<div id="auditoria_main" class="col-sm-12">
												<div class="form-horizontal">
													<div class="row">
														<div class="col-sm-6" id='div_audi_tipos'>
															<?php include ('admin_auditoria_script.php'); ?>
														</div>
														<div class="col-sm-6"  id='div_usuarios'>
															<?php include ('admin_auditoria_script_usuarios.php'); ?>
														</div>
													</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="box box-default">
								<div class="box-header with-border">
									<h3 class="box-title">
										<span id='span_again' name='span_again'></span> Bandeja de resultado
									</h3>
								</div><!-- /.box-header -->
								<div class="box-body" id='resultado'>
									<small>Haga una búsqueda para mostrar resultados.</small>
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
			$(document).ready(function(){
				$('#tbl_audi_tipo').DataTable({
					language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'},
				 	"bSort": 			false ,
					'paging': 			false,
					"scrollY":        	"400px",
					"scrollCollapse":	true
				}) ;
				$('#tbl_lista_usuarios').DataTable({
					language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'},
				 	"bSort": 			false ,
					'paging': 			false,
					"scrollY":        	"400px",
					"scrollCollapse":	true
				}) ;
				$("#boton_busqueda").click(function(){
					$("#desplegable_busqueda").slideToggle(200);
				});
				$("#desplegable_busqueda").show();
				$('#alum_codi_in').focus();
				$('[data-toggle="popover"]').popover({html:true});
				$("#audi_fec_ini").datepicker({ format: 'yyyy-mm-dd' });
				$("#audi_fec_fin").datepicker({ format: 'yyyy-mm-dd' });
				$("#audi_fec_ini").inputmask({
					mask: "y-1-2", 
					placeholder: "yyyy-mm-dd", 
					leapday: "-02-29", 
					separator: "-", 
					alias: "yyyy/mm/dd"
				});
				$("#audi_fec_fin").inputmask({
					mask: "y-1-2", 
					placeholder: "yyyy-mm-dd", 
					leapday: "-02-29", 
					separator: "-", 
					alias: "yyyy/mm/dd"
				});
			});
			function js_call_auditoria_tipos( audi_tipo_codi )
			{
				var data = new FormData();
				document.getElementById('div_audi_tipos').innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
				
				data.append('audi_tipo_codi', audi_tipo_codi );
			
				var xhr_auditoria = new XMLHttpRequest();
				xhr_auditoria.open('POST', 'admin_auditoria_script.php' , true);
				xhr_auditoria.onload = function ()
				{   
				};
				xhr_auditoria.onreadystatechange=function()
				{   if ( xhr_auditoria.readyState === 4 && xhr_auditoria.status === 200 )
					{   document.getElementById('div_audi_tipos').innerHTML = xhr_auditoria.responseText;
						$('#tbl_audi_tipo').DataTable({
							language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'},
							"bSort": 			false ,
							'paging': 			false,
							"scrollY":        	"400px",
							"scrollCollapse":	true
						}) ;
					}
				};
				xhr_auditoria.send(data);
			}
			function js_call_usuario_tipos( usua_tipo_codi )
			{
				var data = new FormData();
				document.getElementById('div_usuarios').innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i></div>';
				
				data.append('usua_tipo_codi', usua_tipo_codi );
			
				var xhr_auditoria = new XMLHttpRequest();
				xhr_auditoria.open('POST', 'admin_auditoria_script_usuarios.php' , true);
				xhr_auditoria.onload = function ()
				{   
				};
				xhr_auditoria.onreadystatechange=function()
				{   if ( xhr_auditoria.readyState === 4 && xhr_auditoria.status === 200 )
					{   document.getElementById('div_usuarios').innerHTML = xhr_auditoria.responseText;
						$('#tbl_lista_usuarios').DataTable({
							language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'},
							"bSort": 			false ,
							'paging': 			false,
							"scrollY":        	"400px",
							"scrollCollapse":	true
						}) ;
					}
				};
				xhr_auditoria.send(data);
			}
			function Validar ()
			{   if (ValidaAcciones() && ValidaUsuarios())
				{   var data = new FormData();
					$("#desplegable_busqueda").slideToggle(200);
					document.getElementById('resultado').innerHTML='<br><div align="center" style="height:100%;"><i style="font-size:large;color:darkred;" class="fa fa-cog fa-spin"></i><br><br>Por favor, espere...</div>';
					
					checkboxes = document.getElementsByName('acciones[]');
					var acciones=[];
					var bandera = 0;
					var i = 0;
					
					for( i = 0, n = checkboxes.length; i < n; i++ )
					{   if ( checkboxes[i].checked )
						{   acciones.push(checkboxes[i].value);
							bandera++;
						}
					}
					
					checkboxes = document.getElementsByName('usuarios[]');
					var usuarios=[];
					bandera = 0;
					for( i = 0, n = checkboxes.length; i < n; i++ )
					{   if ( checkboxes[i].checked )
						{   usuarios.push(checkboxes[i].value);
							bandera++;
						}
					}
					
					data.append('audi_fec_ini', document.getElementById('audi_fec_ini').value );
					data.append('audi_fec_fin', document.getElementById('audi_fec_fin').value );
					data.append('acciones', JSON.stringify( acciones ) );
					data.append('usuarios', JSON.stringify( usuarios ) );
				
					var xhr_auditoria = new XMLHttpRequest();
					xhr_auditoria.open('POST', 'audi_listas_main_view.php' , true);
					xhr_auditoria.onload = function ()
					{   
					};
					xhr_auditoria.onreadystatechange=function()
					{   if (xhr_auditoria.readyState==4 && xhr_auditoria.status==200)
						{   document.getElementById('resultado').innerHTML = xhr_auditoria.responseText;
							document.getElementById('span_again').innerHTML = '<button type="button" class="btn btn-warning" onclick="$(\'#desplegable_busqueda\').toggle(\'show\');">Volver a consultar</button>';
							
							$('#tbl_auditoria_resultados').addClass( 'nowrap' ).DataTable({
								dom: 'Bfrtip',
								buttons: [ 
									{ extend: 'copy', text: 'Copiar <i class="fa fa-copy"></i>' },
									{ extend: 'csv', text: 'CSV <i style="color:green" class="fa fa-file-excel-o"></i>' },
									{ extend: 'excel', text: 'Excel <i style="color:green" class="fa fa-file-excel-o"></i>' },
									{ extend: 'print', text: 'Imprimir <i style="color:#428bca" class="fa fa-print"></i>' },
									],
								lengthChange: false, 
								responsive: true, 
								searching: true,  
								orderClasses: true, 
								paging:true,
								"bFilter": false, 
								"sScrollX": "100%", 
								"bScrollCollapse": true,
								language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'},
								"columnDefs": [
									{className: "dt-body-center" , "targets": [0]},
									{className: "dt-body-left"   , "targets": [1]},
									{className: "dt-body-center" , "targets": [2]},
									{className: "dt-body-center" , "targets": [3]},
									{className: "dt-body-center" , "targets": [4]},
									{className: "dt-body-left" , "targets": [5]}
								]
							});
							/*var n = xhr_auditoria.responseText.length;
							$('#modal_del_sms_many').modal("hide");
							if (n > 0)
							{	valida_tipo_growl(xhr_auditoria.responseText);
							}
							else
							{   $.growl.warning({ title: "Educalinks informa",message: "Proceso realizado sin confirmación del sistema." });
							} */         
						}
					};
					xhr_auditoria.send(data);
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
					$.growl.warning({ title: "Educalinks informa",message: "Debe seleccionar un tipo de auditoria" });
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
					$.growl.warning({ title: "Educalinks informa",message: "Debe seleccionar un usuario" });
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
			function js_audi_types_all (  )
			{   if ( $('#span_codigoTipo_head1').hasClass('fa-square-o') )
				{   $('#span_codigoTipo_head1').removeClass('fa-square-o').addClass('fa-check-square-o');
					$('#span_codigoTipo_head2').html("Desmarcar todos");
					checked = true;
				}
				else
				{   $('#span_codigoTipo_head1').removeClass('fa-check-square-o').addClass('fa-square-o');	
					$('#span_codigoTipo_head2').html("Marcar todos");
					checked = false;
				}
				checkboxes = document.getElementsByName('acciones[]');
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
				{   document.getElementById('ckb_codigoTipo_head').checked = true;
				}
				else
				{   document.getElementById('ckb_codigoTipo_head').checked = false;
				}		
			}
			function js_audi_tipo_select_check_ind ( source, num_linea )
			{   var marcar = 'si';
				checkboxes = document.getElementsByName('acciones[]');
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
				{	document.getElementById('ckb_codigoTipo_head').checked = 'checked';
					$('#span_codigoTipo_head1').removeClass('fa-square-o').addClass('fa-check-square-o');
					$('#span_codigoTipo_head2').html("Desmarcar todos");
				}
				else  //si no todos están seleccionados
				{	document.getElementById('ckb_codigoTipo_head').checked = false;
					$('#span_codigoTipo_head1').removeClass('fa-check-square-o').addClass('fa-square-o');
					$('#span_codigoTipo_head2').html("Marcar todos");
				}
				if ( total_sinchecar == n ) //si no hay ningún seleccionado
				{	//do nothing
				}
				else //si hay por lo menos uno seleccionado
				{   //do nothing
				}
			}
			function js_users_all (  )
			{   if ( $('#span_codigoUsuario_head1').hasClass('fa-square-o') )
				{   $('#span_codigoUsuario_head1').removeClass('fa-square-o').addClass('fa-check-square-o');
					$('#span_codigoUsuario_head2').html("Desmarcar todos");
					checked = true;
				}
				else
				{   $('#span_codigoUsuario_head1').removeClass('fa-check-square-o').addClass('fa-square-o');	
					$('#span_codigoUsuario_head2').html("Marcar todos");
					checked = false;
				}
				checkboxes = document.getElementsByName('usuarios[]');
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
				{   document.getElementById('ckb_codigoUsuario_head').checked = true;
				}
				else
				{   document.getElementById('ckb_codigoUsuario_head').checked = false;
				}		
			}
			function js_usuarios_select_check_ind ( source, num_linea )
			{   var marcar = 'si';
				checkboxes = document.getElementsByName('usuarios[]');
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
				{	document.getElementById('ckb_codigoUsuario_head').checked = 'checked';
					$('#span_codigoUsuario_head1').removeClass('fa-square-o').addClass('fa-check-square-o');
					$('#span_codigoUsuario_head2').html("Desmarcar todos");
				}
				else  //si no todos están seleccionados
				{	document.getElementById('ckb_codigoUsuario_head').checked = false;
					$('#span_codigoUsuario_head1').removeClass('fa-check-square-o').addClass('fa-square-o');
					$('#span_codigoUsuario_head2').html("Marcar todos");
				}
				if ( total_sinchecar == n ) //si no hay ningún seleccionado
				{	//do nothing
				}
				else //si hay por lo menos uno seleccionado
				{   //do nothing
				}
			}
			function js_auditoria_chk_fecha()
			{    var chk_tneto = document.getElementById("chk_fecha").checked;
				if(chk_tneto)
				{   document.getElementById("audi_fec_ini").disabled = false;
					document.getElementById("audi_fec_fin").disabled = false;
				}
				else
				{   document.getElementById("audi_fec_ini").disabled = true;
					document.getElementById("audi_fec_fin").disabled = true;
					document.getElementById("audi_fec_ini").value = "";
					document.getElementById("audi_fec_fin").value = "";
				}
			}
		</script>
	</body>
</html>