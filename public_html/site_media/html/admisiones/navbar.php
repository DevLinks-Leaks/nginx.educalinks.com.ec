<form name="frm_menu" id="frm_menu" action="../general/" enctype="multipart/form-data" method="post">
	<input type="hidden" name="event" id="event" value="" />
	<header class="main-header">
        <!-- Logo
        <a href="../general/controller.php" class="logo" id='a_nav_main' name='a_nav_main'> -->
		<a href="·" class="logo" id='a_nav_main' name='a_nav_main' data-toggle="offcanvas" role="button">
		
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><div style="margin-top:10px" id='div_nav_logo_small' name='div_nav_logo_small'><img src="{navbar_logo_educalinks_small}" alt="EL"></div></span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><div style="margin-left:-10px;margin-top:10px" id='div_nav_logo' name='div_nav_logo'><img src="{navbar_logo_educalinks}" alt="Educalinks"></div></span>
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
					<!-- Messages: style can be found in dropdown.less-->
					<li class="dropdown messages-menu">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						  &nbsp;<i class="fa fa-envelope-o"></i>
						  <span id="span_badge_sms_header1" class="label"><span id="badge_sms_header1"></span></span>
						</a>
						<ul class="dropdown-menu">
							<li class="header" id="badge_sms_header2" ></li>
							<li>
								<!-- inner menu: contains the actual data -->
								<ul id='badge_sms_detail' name='badge_sms_detail' class="menu">
								</ul>
							</li>
							<li class="footer"><a href="../../common/mensajeria/">Ver todos los mensajes</a></li>
						</ul>
					</li>
					<!-- Tasks: style can be found in dropdown.less -->
					<li class="dropdown tasks-menu">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							&nbsp;<i class="fa fa-flag"></i>
							<span id="span_badge_gest_fac_header1" class="label"><span id="badge_gest_fac_header1"></span></span>
						</a>
						<!-- <ul class="dropdown-menu">
							<li class="header">Tienes <span id="badge_gest_fac_header2"></span> tarea(s) pendiente(s)</li>
							<li>
								<ul class="menu">
									<li>
										<a href="../gestionFacturas/controller.php">
											<h3>
												Facturas al SRI
											<small class="pull-right"><span id="badge_gest_fac_in_header1"></span></small>
											</h3>
											<div class="progress xs">
												<div id="pb_fac" name="pb_fac" class="progress-bar" style="width: 0%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
													<span class="sr-only"><span id="badge_gest_fac_in_header2"></span></span>
												</div>
											</div>
										</a>
									</li>
								</ul>
							</li>
						</ul> -->
					</li>
					<li class="dropdown user user-menu">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<img src="../{fotoUsuario}" class="user-image" alt="Imagen de usuario">
							<span class="hidden-xs">{usua_nombres} {usua_apellidos}</span>&nbsp;
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
									<a href="../../../salir.php" class="btn btn-default btn-flat">Salir</a>
								</div>
							</li>
						</ul>
					</li>
					<li title='Expandir'>
						<a href="#" onclick="toggleFullScreen();"><i class="fa fa-television"></i>&nbsp;</a>
					</li>
					<li><a href="#" data-toggle="control-sidebar"><i class="fa fa-globe"></i>&nbsp;</a></li>
				</ul>
			</div>
        </nav>
    </header>
</form>