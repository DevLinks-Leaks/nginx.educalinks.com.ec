<form name="frm_menu" id="frm_menu" action="../general/" enctype="multipart/form-data" method="post">
	<input type="hidden" name="event" id="event" value="" />
	<header class="main-header">
        <!-- Logo -->
        <a href="../general/controller.php" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><div style="margin-top:10px"><img src="{ruta_imagenes}/LOGO_EDUCALINKS_small.png" alt="Educalinks"></div></span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><div style="margin-left:-10px;margin-top:10px"><img src="{ruta_imagenes}/LOGO_EDUCALINKS.png" alt="Educalinks"></div></span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
			<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</a>
			<div class="navbar-custom-menu">
				<ul class="nav navbar-nav">
					<!-- Messages: style can be found in dropdown.less
					<li class="dropdown messages-menu">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						  <i class="fa fa-envelope-o"></i>
						  <span id="span_badge_sms_header1" class="label"><span id="badge_sms_header1"></span></span>
						</a>
						<ul class="dropdown-menu">
							<li class="header" id="badge_sms_header2" ></li>
							<li>
								<ul id='badge_sms_detail' name='badge_sms_detail' class="menu">
								</ul>
							</li>
							<li class="footer"><a href="../mensajeria/">Ver todos los mensajes</a></li>
						</ul>
					</li>-->
					<!-- Tasks: style can be found in dropdown.less -->
					
				    <!-- User Account: style can be found in dropdown.less -->
					<li class="dropdown user user-menu">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<img src="../{fotoUsuario}" class="user-image" alt="Imagen de usuario">
							<span class="hidden-xs">{usua_nombres} {usua_apellidos}</span>
						</a>
						<ul class="dropdown-menu">
							<!-- User image -->
							<!-- Menu Body -->
							<li class="user-header">
								<img src="../{fotoUsuario}" class="user-image" alt="Imagen de usuario"><br>
								<p>
									{usua_nombres} {usua_apellidos}
									<small>Usuario de sistema Educalinks.</small>
								</p>
							</li>
						  <!-- Menu Footer-->
							<li class="user-footer">
								<div class="pull-left">
									<a href="#" onclick="document.getElementById('event').value='password';document.frm_menu.submit();" class="btn btn-default btn-flat">Contraseña</a>
									<a href="#" onclick="document.getElementById('event').value='datos';document.frm_menu.submit();" class="btn btn-default btn-flat">Perfil</a>
								</div>
								<div class="pull-right">
									<a href="../salir.php" class="btn btn-default btn-flat">Salir</a>
								</div>
							</li>
						</ul>
					</li>
				</ul>
			</div>
        </nav>
    </header>
</form>