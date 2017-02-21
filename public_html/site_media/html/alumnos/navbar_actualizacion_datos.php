<form name="frm_menu" id="frm_menu" action="../general/" enctype="multipart/form-data" method="post">
	<input type="hidden" name="event" id="event" value="" />
	<header class="main-header">
        <!-- Logo <a href="../general/controller.php" class="logo" id='a_nav_main' name='a_nav_main'> -->
		<a href="#" class="logo" id='a_nav_main' name='a_nav_main'>
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><div style="margin-top:10px" id='div_nav_logo_small' name='div_nav_logo_small'><img src="{navbar_logo_educalinks_small}" alt="EL"></div></span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><div style="margin-left:-10px;margin-top:10px" id='div_nav_logo' name='div_nav_logo'><img src="{navbar_logo_educalinks}" alt="Educalinks"></div></span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
			<div class="navbar-custom-menu">
				<ul class="nav navbar-nav">
					<li title='Nombre del alumno'>
						<a class="dropdown-toggle" data-toggle="dropdown">
							<span class="hidden-xs">Ficha médica de {cmb_sons}</span>
						</a>
					</li>
					<li title='Expandir'>
						<a href="#" onclick="toggleFullScreen();"><i class="fa fa-television"></i>&nbsp;</a>
					</li>
				</ul>
			</div>
        </nav>
    </header>
</form>