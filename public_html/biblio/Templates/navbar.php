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
		<div class="navbar-custom-menu">
			<ul class="nav navbar-nav">
				<li class="dropdown user user-menu">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<img src="<?php echo "../".$_SESSION['ruta_foto_usuario'].'admin.jpg'; ?>" class="user-image" alt="Imagen de usuario">
						<span class="hidden-xs"><?= $_SESSION['usua_nomb']; ?> <?= $_SESSION['usua_apel']; ?></span>&nbsp;
					</a>
					<ul class="dropdown-menu">
						<!-- User image -->
						<!-- Menu Body -->
						<li class="user-header">
							<img src="<?php echo "../".$_SESSION['ruta_foto_usuario'].'admin.jpg'; ?>" class="user-image" alt="Imagen de usuario">
							<p><?= $_SESSION['usua_nomb']; ?> <?= $_SESSION['usua_apel']; ?><!-- <br>
								<span style="font-size:x-small;"><b><?= $_SESSION['usua_codi']; ?></b></span> -->
								<small>Usuario de sistema Educalinks.</small>
							</p>
						</li>
					  <!-- Menu Footer-->
						<li class="user-footer">
							<!-- <div class="pull-left">
								<a href="#" onclick="document.getElementById('event').value='password';document.frm_menu.submit();" class="btn btn-default btn-flat">Contraseña</a>
								
							</div> -->
							<div class="pull-right">
								<a href="../../../salir.php" class="btn btn-default btn-flat">Salir</a>
							</div>
						</li>
					</ul>
				</li>
				<!-- <li title='Expandir'><a href="#" onclick="toggleFullScreen();"><i class="fa fa-television"></i>&nbsp;</a></li> -->
				<li><a href="#" data-toggle="control-sidebar"><i class="fa fa-globe"></i>&nbsp;</a></li>
			</ul>
		</div>
	</nav>
</header>