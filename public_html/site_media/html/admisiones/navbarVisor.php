<form name="frm_menu" id="frm_menu" action="../general/" enctype="multipart/form-data" method="post">
	<input type="hidden" name="event" id="event" value="" />
	<header class="main-header">
        <a href="../general/controller.php" class="logo" id='a_nav_main' name='a_nav_main'> -->
		<a href="·" class="logo" id='a_nav_main' name='a_nav_main' data-toggle="offcanvas" role="button">
			<span class="logo-mini"><div style="margin-top:10px" id='div_nav_logo_small' name='div_nav_logo_small'><img src="{navbar_logo_educalinks_small}" alt="EL"></div></span>
			<span class="logo-lg"><div style="margin-left:-10px;margin-top:10px" id='div_nav_logo' name='div_nav_logo'><img src="{navbar_logo_educalinks}" alt="Educalinks"></div></span>
        </a>
        <nav class="navbar navbar-static-top" role="navigation">
			<div class="navbar-custom-menu">
				<ul class="nav navbar-nav">
					<li class="dropdown user user-menu">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<img src="../{fotoUsuario}" class="user-image" alt="Imagen de usuario">
							<span class="hidden-xs">{usua_nombres} {usua_apellidos}</span>&nbsp;
						</a>
					</li>
					<li>
						<a href="../salirVisor/"><span class="glyphicon glyphicon-off" aria-hidden="true"></span>Salir</a>
					</li>
				</ul>
			</div>
        </nav>
    </header>
</form>


<form name="frm_menu" id="frm_menu" action="../general/" enctype="multipart/form-data" method="post">
	<input type="hidden" name="event" id="event" value="" />
	<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="../salirVisor/"><img alt="Educalinks" src="{ruta_imagenes}/LOGO_EDUCALINKS.png"></a>
			</div>
			<div id="navbar" class="navbar-collapse collapse">
				<ul class="nav navbar-nav navbar-right">
					<li><a href="#"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Bienvenido, {usua_nombres} {usua_apellidos}</span></a></li>
					<li class="bor"><a href="../salirVisor/"><span class="glyphicon glyphicon-off" aria-hidden="true"></span> Salir</a></li>
				</ul>
			</div>
		</div>
	</nav>
</form>