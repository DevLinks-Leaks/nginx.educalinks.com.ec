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
	<header class="main-header">
        <nav class="navbar navbar-static-top">
          <div class="container-fluid">
          <div class="navbar-header">
            <span class="logo-lg"><div style="margin-top:13px;margin-left:16px;" 
				id='div_nav_logo' name='div_nav_logo'><img src="../../includes/common/logos/LOGO_EDUCALINKS_white.png" alt="Educalinks" width='80%'></div> </span>
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
              <i class="fa fa-bars"></i>
            </button>
          </div>
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
          <!-- Collect the nav links, forms, and other content for toggling -->
          <div class="collapse navbar-collapse" id="navbar-collapse">
            <ul class="nav navbar-nav">
              <li ><a href="#" onclick="window.history.back();"><span class="fa fa-angle-left"></span> Atrás</a></li>
            </ul>
            <form class="navbar-form navbar-left" role="search">
              <div class="form-group">
                <input type="text" class="form-control" id="navbar-search-input" placeholder="Buscar">
              </div>
            </form>
            <ul class="nav navbar-nav navbar-right">
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
				<li title="Expandir">
					<a href="#" onclick="toggleFullScreen();"><i class="fa fa-television"></i>&nbsp;</a>
				</li>
				<li title='Ver módulos del sistema' >
					<a onmouseover='$(this).tooltip("show");' href="#" data-toggle="modal" data-target='#ModalEducalinksMoludos'><i class="fa fa-briefcase"></i>&nbsp;</a>
				</li>
            </ul>
          </div><!-- /.navbar-collapse -->
          </div><!-- /.container-fluid -->
        </nav>
      </header>
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