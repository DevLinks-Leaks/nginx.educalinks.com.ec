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
			$nombre = $usua = "";
			if($_SESSION['USUA_TIPO']=='R')
			{   $nombre = $_SESSION['repr_nomb']." ".$_SESSION['repr_apel'];
				$usua 	= $_SESSION['repr_usua'];
				$_SESSION['nombre_del_modulo'] = 'MÓDULO REPRESENTANTE';
			}else
			{   $nombre = $_SESSION['alum_nomb']." ".$_SESSION['alum_apel'];
				$usua 	= $_SESSION['alum_usua'];
				$_SESSION['nombre_del_modulo'] = 'MÓDULO ALUMNO';
			}
			if($_SESSION['USUA_TIPO']=='R')
			{   $ruta = $_SESSION['ruta_foto_usuario'].$_SESSION['repr_codi'].".jpg";
			}else
			{   $ruta = $_SESSION['ruta_foto_usuario'].$_SESSION['alum_codi'].".jpg";
			}
			$file_exi = $ruta;
			if (file_exists($file_exi))
			{   $pp = $file_exi;
			}else
			{   $pp = '../'.$_SESSION['foto_default'];
			}
			$_SESSION['ruta_foto_header'] = $pp;
			?>
			<div class="navbar-custom-menu">
				<ul class="nav navbar-nav">
					<!-- Messages: style can be found in dropdown.less-->
					<li title="Seleccionar período activo">
						<a href="#" ><i class="fa fa-calendar"></i>&nbsp;Período: <?= $_SESSION['peri_deta']; ?></a>
					</li>
					<?php
					$combo="";
					if($_SESSION['USUA_TIPO']=='R')
					{	$combo='
						<li class="dropdown user user-menu messages-menu">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<img src="{fotoUsuario}?'.$rand.'" class="user-image" alt="">
								<span class="hidden-xs"><small>{usua_nombres}</small></span>
							</a>
							<ul class="dropdown-menu" >
								<li class="header"><small>Seleccione un alumno</small></li>
								<li>
									<!-- inner menu: contains the actual data -->
									
										<ul class="menu" style="overflow: hidden; width: 100%;">';
										$params2 = array($_SESSION['repr_codi'],$_SESSION['peri_codi']);
										$sql2="{call repr_alum_info_princ_usua(?,?)}";
										$resu_alum_info = sqlsrv_query($conn, $sql2, $params2);  
										while($row_resu_alum_info = sqlsrv_fetch_array($resu_alum_info))
										{   
											$ruta = $_SESSION['ruta_foto_alumno'].$row_resu_alum_info['alum_codi'].".jpg";
											$file_exi = $ruta;
											if (file_exists($file_exi))
											{   $pp = $file_exi;
											}else
											{   $pp = '../'.$_SESSION['foto_default'];
											}
											if( $row_resu_alum_info['alum_codi'] == $_SESSION['alum_codi'] ){ $usua_nombre = $row_resu_alum_info['alum_nomb']; 
												$ruta_alum_sel=$pp;}
											$combo.='<li>
												<a href="#" 
													onClick="set_repr_alum('.$row_resu_alum_info['alum_codi'].',\''.$_SESSION['repr_codi'].'\')">
													<div class="pull-left">
														<img src="'.$pp.'?'.$rand.'" class="img-circle" alt="User Image">
													</div>
													<p>
														'.$row_resu_alum_info['alum_apel']." ".$row_resu_alum_info['alum_nomb'].'
													</p>
													<p><small>'.$row_resu_alum_info['CursoParalelos'].'</small></p>
												</a>
											</li>';
										}
								$combo.='	<div class="slimScrollBar" style="width: 3px; position: absolute; top: 0px; opacity: 0.4; display: block; border-radius: 7px; z-index: 99; right: 1px; height: 131.148px; background: rgb(0, 0, 0);"></div><div class="slimScrollRail" style="width: 3px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; opacity: 0.2; z-index: 90; right: 1px; background: rgb(51, 51, 51);"></div>
										</ul>
								</li>
							</ul>
						</li>
						<input type="hidden" name="alum_sel" id="alum_sel" value="'.$row_resu_alum_info['alum_codi'].'">';

						$combo = str_replace('{usua_nombres}',$usua_nombre,$combo);
						$combo = str_replace('{fotoUsuario}',$ruta_alum_sel,$combo);
						echo $combo;
						
						$combo = str_replace('set_repr_alum','js_alumnos_general_set_repr_alum',$combo);
						$_SESSION['cmb_alum_sel'] = $combo;
					}
					?>
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
									<a href="<?php if($_SESSION['USUA_TIPO']=='R'){echo "admin_pass_repr.php";}else{ echo "admin_pass.php";}?>" class="btn btn-default btn-flat">Contraseña</a>
									<!--<a href="<?php if($_SESSION['USUA_TIPO']=='R'){echo "admin_info_repr.php";}else{ echo "admin_info.php";}?>" class="btn btn-default btn-flat">Perfil</a>-->
								</div>
								<div class="pull-right">
									<a href="../../salir.php" class="btn btn-default btn-flat">Salir</a>
								</div>
							</li>
						</ul>
					</li>
					<?php include ('script_mens_view.php');?>
				</ul>
			</div>
        </nav>
    </header>
</form>
<div class="modal fade bd-example-modal-lg" id="modal_leer_ext" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div id="modal_main_ext" width="100%" class="modal-content">
            
        </div>
    </div>
</div>
<script>
function envio_mensaje_nuevo(){   
  
  $('#envio_mensaje').button('loading');
  
  if (validar_envio()){
      
    tipo = document.getElementById('mens_tipo').value;
    cc = document.getElementById('mens_cc_usua').value;
    
    url='mensajes_nuevo_script_envio.php';
    
    mens_ok=0;
    mens_ko=0;
    mm=0;
    i=1;
    
    var jsonArr = [];

    while (i<=cc){
      
      if (document.getElementById('ch_'+ tipo + '_' + i) != null) {
        if (document.getElementById('ch_'+ tipo + '_' + i).checked){
          jsonArr.push({
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
    xhr_mensaje.onreadystatechange=function(){
      if (xhr_mensaje.readyState==4 && xhr_mensaje.status==200){
        obj = JSON.parse(xhr_mensaje.responseText);
        if (obj.tipo == "error")
        { $.growl.error({ title: "Error: ",message: obj.mensaje });
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
          if(repr==""){
            $.growl.notice({ title: "Información: ",message: "Mensajes enviados con éxito" });
            $('#envio_mensaje').button('reset');
            $('#nuev_mens').modal('hide');  
          }else{
            $.growl.warning({ title: "Advertencia: "
              ,duration: 5600
              ,size: 'large'
              ,message: "Mail no enviado a los siguientes representantes: <b>"+repr+"</b></br>verificiar formato de e-mail." });
            $('#envio_mensaje').button('reset');
            $('#nuev_mens').modal('hide');
          }
        }
             
      }
    }
    xhr_mensaje.send(data);
    
  }
  
}
function envio_mensaje_resp(mens_para,mens_para_tipo){    
  
  $('#responder_mensaje').button('loading');
  
  if (validar_envio_respuesta()){
    
    url='mensajes_nuevo_script_envio.php';
    
    
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
      if (xhr_mensaje.readyState==4 && xhr_mensaje.status==200){
        obj = JSON.parse(xhr_mensaje.responseText);
        if (obj.tipo == "error")
        { $.growl.error({ title: "Error: ",message: obj.mensaje });
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
          if(repr==""){
            $.growl.notice({ title: "Información: ",message: "Mensajes enviados con éxito" });
            $('#responder_mensaje').button('reset');
            $('#mens_responder').modal('hide'); 
          }else{
            $.growl.warning({ title: "Advertencia: "
              ,duration: 5600
              ,message: "Mail no enviado al representante: <b>"+repr+"</b></br>verificiar formato de e-mail." });
            $('#responder_mensaje').button('reset');
            $('#mens_responder').modal('hide');
          }
        }
             
      }
    }
    xhr_mensaje.send(data);
    
  }
  
}
</script>