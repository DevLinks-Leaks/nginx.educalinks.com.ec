<!-- Modal SELECCION DE PERIODO -->
<div class="modal fade" id="ModalPeriodoActivo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title" id="myModalLabel"><span class='fa fa-calendar'></span>&nbsp;Seleccione un período</h4>
			</div>
			<div class="modal-body" style='text-align:center;'>
				<div class="btn-group-vertical" style='text-align:center;'>
                    <? 	
						$i=0;
						//$color = "bg-orange,bg-olive,bg-purple,bg-navy,bg-maroon";
						//$color = "btn-warning,btn-danger,btn-info,btn-olive,btn-primary,btn-default,btn-success";
						//$colors = explode(",", $color);
						
						$params = array();
						$sql="{call peri_view()}";
						$peri_view = sqlsrv_query($conn, $sql, $params);  
                    
						while($row_peri_view = sqlsrv_fetch_array($peri_view))
						{ ?>
							<button type="button" class="btn <?php echo ( $row_peri_view["peri_codi"] == $_SESSION['peri_codi'] ? 'btn btn-primary': 'btn btn-default'); ?>" style="width:100%;" onClick="periodo_cambio(<?= $row_peri_view["peri_codi"]; ?>);">ACTIVAR PERIODO LECTIVO <?= $row_peri_view["peri_deta"]; ?></button>
							<?php
							$i++;
						} ?>
				</div>
			</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<form name="frm_menu" id="frm_menu" action="../general/" enctype="multipart/form-data" method="post">
	<input type="hidden" name="event" id="event" value="" />
	<header class="main-header">
        <a href="·" class="logo" id='a_nav_main' name='a_nav_main' data-toggle="offcanvas" role="button">
			<span class="logo-mini"><div style="" id='div_nav_logo_small' name='div_nav_logo_small'><img src="../../includes/common/logos/LOGO_EDUCALINKS_white_small.png" alt="EL"></div></span>
			<span class="logo-lg"><div style="margin-left:-10px;" id='div_nav_logo' name='div_nav_logo'><img src="../../includes/common/logos/LOGO_EDUCALINKS_white.png" alt="Educalinks"></div></span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button -->
			<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</a>
			<?php
			$nombre = $_SESSION['usua_nomb'] . ' ' . $_SESSION['usua_apel'];
			$usua = $_SESSION['usua_codi'];
			
			$file_exi=$_SESSION['ruta_foto_usuario'].$_SESSION['usua_codi'].'.jpg';
			$foto_ruta = "";
			if (file_exists($file_exi))
				$foto_ruta = $_SESSION['ruta_foto_usuario'].$_SESSION['usua_codi'].'.jpg';
			else
				$foto_ruta = $_SESSION['ruta_foto_usuario'].'admin.jpg';
											
			$_SESSION['ruta_foto_header'] = $foto_ruta;
			?>
			<div class="navbar-custom-menu">
				<ul class="nav navbar-nav">
					<!-- Messages: style can be found in dropdown.less-->
					<li title="Seleccionar período activo">
						<a href="#" data-toggle="modal" data-target="#ModalPeriodoActivo"><i class="fa fa-calendar"></i>
							</i><span class='hidden-xs'>&nbsp;Período: <?= $_SESSION['peri_deta']; ?></span></a>
					</li>
					<li class="dropdown user user-menu">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<img src="<?php echo $_SESSION['ruta_foto_header']; ?>" class="user-image" alt="Imagen de usuario">
							<span class="hidden-xs" style='font-size:x-small;'><?php echo $nombre; ?></span>&nbsp;
						</a>
						<ul class="dropdown-menu">
							<!-- User image -->
							<!-- Menu Body -->
							<li class="user-header">
								<img src="<?php echo $_SESSION['ruta_foto_header']; ?>" class="user-image" alt="Cambiar foto de perfil"
									href="<?php if($_SESSION['USUA_TIPO']=='R'){echo "admin_foto_repr.php";}else{ echo "admin_foto_repr.php";}?>">
								<p><?php echo $nombre; ?><!-- <br>
									<span style="font-size:x-small;"><b><?php echo $usua; ?></b></span> -->
									<small>Usuario de sistema Educalinks.</small>
								</p>
							</li>
						  <!-- Menu Footer-->
							<li class="user-footer">
								<div class="pull-left">
									<a href="admin_pass.php" class="btn btn-default btn-flat">Contraseña</a>
									<a href="admin_info.php" class="btn btn-default btn-flat">Perfil</a>
								</div>
								<div class="pull-right">
									<a href="../../salir.php" class="btn btn-default btn-flat">Salir</a>
								</div>
							</li>
						</ul>
					</li>
					<li id='li_navbar_sms' class="dropdown messages-menu">
					<?php include ('script_mens_view.php');?>
					</li>
					<!--<li title="Expandir">
						<a href="#" onclick="toggleFullScreen();"><i class="fa fa-television"></i>&nbsp;</a>-
					</li>-->
					<li title='Ver módulos del sistema' >
						<a onmouseover='$(this).tooltip("show");' href="#" data-toggle="modal" data-target='#ModalEducalinksMoludos'><i class="fa fa-briefcase"></i>&nbsp;</a>
					</li>
				</ul>
			</div>
        </nav>
    </header>
</form>
<!-- Modal Vista mensaje-->
<div class="modal fade bd-example-modal-lg" id="modal_leer_ext" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div id="modal_main_ext" width="100%" class="modal-content">
            
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
<script>
	function envio_mensaje_nuevo()
	{	$('#envio_mensaje').button('loading');
		if (validar_envio())
		{	tipo = document.getElementById('mens_tipo').value;
			cc = document.getElementById('mens_cc_usua').value;
		
			url='mensajes_nuevo_script_envio.php';
		
			mens_ok=0;
			mens_ko=0;
			mm=0;
			i=1;
		
			var jsonArr = [];

			while (i<=cc)
			{   if (document.getElementById('ch_'+ tipo + '_' + i) != null)
				{   if (document.getElementById('ch_'+ tipo + '_' + i).checked)
					{   jsonArr.push({
							mens_para: document.getElementById('ch_'+ tipo + '_' + i).value,
							mens_para_tipo: tipo,
							mens_alum_codi: document.getElementById('ch_'+ tipo + '_' + i).getAttribute("data-alum-codi")
						});
					}
				}
				i+=1;
			}
			var data = new FormData();
			data.append('mens_de', document.getElementById('mens_de').value );
			data.append('mens_de_tipo', document.getElementById('mens_de_tipo').value);
			//data.append('mens_para', document.getElementById('ch_'+ tipo + '_' + i).value);
			//data.append('mens_para_tipo', tipo);
			data.append('mens_dest', JSON.stringify(jsonArr));
			data.append('mens_titu', document.getElementById('mens_titu').value);
			data.append('mens_deta', CKEDITOR.instances.mens_deta.getData());
			data.append('DO','ADD');
		
			var xhr_mensaje = new XMLHttpRequest();
			xhr_mensaje.open('POST', url , true);
			//xhr_mensaje.setRequestHeader("Content-Type", "application/json");
			xhr_mensaje.onload = function () {
				// do something to response
				//console.log(this.responseText);
			};
			xhr_mensaje.onreadystatechange=function()
			{   if (xhr_mensaje.readyState==4 && xhr_mensaje.status==200)
				{   obj = JSON.parse(xhr_mensaje.responseText);
					if (obj.tipo == "error")
					{	$.growl.error({ title: "Error: ",message: obj.mensaje });
						$('#envio_mensaje').button('reset');
					}
					else //if(obj.tipo == "warning")
					{	
						var repr="";
						obj.forEach(function(entry){
							if (entry.tipo=="warning") {
								repr=repr+"</br>"+entry.repr+", ";
							}
						});
						if(repr=="")
						{   $.growl.notice({ title: "Información: ",message: "Mensajes enviados con éxito" });
							$('#envio_mensaje').button('reset');
							$('#nuev_mens').modal('hide');	
						}
						else
						{   $.growl.warning({ title: "Advertencia: "
								,duration: 5600
								,size: 'large'
								,message: "Mail no enviado a los siguientes representantes: <b>"+repr+"</b></br>verificiar formato de e-mail." });
							$('#envio_mensaje').button('reset');
							$('#nuev_mens').modal('hide');
						}
					}
							 
				}
			};
			xhr_mensaje.send(data);
		}
	}
	function envio_mensaje_resp(mens_para,mens_para_tipo)
	{   $('#responder_mensaje').button('loading');
		if (validar_envio_respuesta())
		{   url='mensajes_nuevo_script_envio.php';
		
			var data = new FormData();
			data.append('mens_de', document.getElementById('mens_de').value );
			data.append('mens_de_tipo', document.getElementById('mens_de_tipo').value);
			data.append('mens_para', mens_para);
			data.append('mens_para_tipo', mens_para_tipo);
			data.append('mens_titu', document.getElementById('mens_titu').value);
			data.append('mens_deta', CKEDITOR.instances.mens_deta.getData());
			data.append('DO','RESP');
		
			var xhr_mensaje = new XMLHttpRequest();
			xhr_mensaje.open('POST', url , true);
			//xhr_mensaje.setRequestHeader("Content-Type", "application/json");
			xhr_mensaje.onload = function () {
				// do something to response
				console.log(this.responseText);
			};
			xhr_mensaje.onreadystatechange=function(){
				if (xhr_mensaje.readyState==4 && xhr_mensaje.status==200)
				{   obj = JSON.parse(xhr_mensaje.responseText);
					if (obj.tipo == "error")
					{	$.growl.error({ title: "Error: ",message: obj.mensaje });
						$('#responder_mensaje').button('reset');
					}
					else //if(obj.tipo == "warning")
					{	
						var repr="";
						obj.forEach(function(entry){
							if (entry.tipo=="warning") {
								repr=repr+"</br>"+entry.repr+", ";
							}
						});
						if(repr=="")
						{   $.growl.notice({ title: "Información: ",message: "Mensajes enviados con éxito" });
							$('#responder_mensaje').button('reset');
							$('#mens_responder').modal('hide');	
						}
						else
						{   $.growl.warning({ title: "Advertencia: "
								,duration: 5600
								,message: "Mail no enviado al representante: <b>"+repr+"</b></br>verificiar formato de e-mail." });
							$('#responder_mensaje').button('reset');
							$('#mens_responder').modal('hide');
						}
					}
							 
				}
			};
			xhr_mensaje.send(data);
		}
	}
</script>