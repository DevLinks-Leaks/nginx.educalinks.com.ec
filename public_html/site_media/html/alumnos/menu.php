	<aside class="main-sidebar">
        <section class="sidebar">
			<div class="user-panel">
				<div class="pull-left image">
					<img src="{logo_institucion}" class="img-circle" alt="User Image">
				</div>
				<div class="pull-left info" style='font-size:x-small;'>
					<p>Unidad Educativa<br>{nombre_institucion}</p>
				</div>
			</div>
			<!-- sidebar menu: : style can be found in sidebar.less -->
			<ul class="sidebar-menu">
				<li class="header">{nombre_del_modulo}</li>
				<li><a href="../../alumnos/index.php"><i class="fa fa-home"> </i> <span>Inicio</span></li></a>
				<li class="{menuRepr01}"><a href="../../alumnos/agenda.php"><i class="fa fa-calendar"></i><span> Agenda</span></a></li>
				<li class="{menuRepr02}"><a href="../../alumnos/clases.php"><i class="glyphicon glyphicon-book"></i><span> Materiales</span></a></li>
				<li class="{menuRepr03}"><a href="../../alumnos/notas.php"><i class="fa fa-book"></i><span> Calificaciones</span></a></li>
				<li class="{menuRepr04}"><a href="../../alumnos/visitas_medicas.php"><i class="fa fa-medkit"></i><span> Visitas médicas</span></a></li>
				<li {citas_display} class="{menuRepr05}"><a href="../../alumnos/citas.php"><i class="fa fa-clock-o"></i><span> Citas</span></a></li>
				<li class="{menuRepr07}"><a href="#/" onclick="js_menu_pagos();"><i class="fa fa-credit-card"></i><span> Pagos</span></a></li>
				<li class="{menuRepr06}"><a href="../../alumnos/observaciones_main.php"><i class="fa fa-comments"></i><span> Hoja de vida</span></a></li>
				<li class="{menuRepr08}"><a href="../../alumnos/mensajes.php"><i class="fa fa-envelope"></i><span> Mensajes</a></li>
				<li><a href="../../../help/MANUAL_REPR.pdf" target='_blank'><i class="fa fa-info-circle"></i><span>Manual de ayuda</span></a><li>
				<li class="{open7}"><a href="../../alumnos/acerca.php"><i class="icon icon-logo"></i> <span> Acerca de Educalinks</span></a></li>
			</ul>
        </section>
        <!-- /.sidebar -->
    </aside>