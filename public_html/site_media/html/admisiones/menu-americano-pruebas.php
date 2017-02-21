	<aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
			<!-- Sidebar user panel -->
			<div class="user-panel">
				<div class="pull-left image">
					<img src="../{fotoUsuario}" class="img-circle" alt="User Image">
				</div>
				<div class="pull-left info">
					<p>{usua_nombres} {usua_apellidos} </p>
					<a href="#"><i class="fa fa-circle text-success"></i> En línea</a>
				</div>
			</div>
			<!-- search form 
			<form action="#" method="get" class="sidebar-form">
				<div class="input-group">
					<input type="text" name="q" class="form-control" placeholder="Search...">
					<span class="input-group-btn">
						<button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
					</span>
				</div>
			</form>-->
			<!-- /.search form -->
			<!-- sidebar menu: : style can be found in sidebar.less -->
			<ul class="sidebar-menu">
				<li class="header">ADMISIONES</li>
				<!-- <li>
				  <a href="#">
					<i class="fa fa-home"></i> <span>Inicio</span>
				  </a>
				</li>-->
				<li><a href="../enviarSolicitud/"><i class="fa fa-child"></i> <span>Inicio solicitante</span></a></li>
				<li class="{openSoli} treeview">
					<a href="#">
						<i class="fa fa-folder-open-o"></i>
						<span>Solicitudes</span>
						<i class="fa fa-angle-left pull-right"></i>
					</a>
					<ul class="treeview-menu">
						<li class="{menuSoli01}"><a href="../verSolicitud/"><i class="fa fa-send"></i>Recibidas</a></li>
						<li class="{menuSoli02}"><a href="#" onclick="js_verSolicitud_pdte_pago();"><i class="fa fa-money"></i>Pdtes. Pago</a></li>
						<li class="{menuSoli03}"><a href="#" onclick="js_verSolicitud_pagada();"><i class="fa fa-clock-o"></i>Por asignar fechas</a></li>
						<li class="{menuSoli04}"><a href="#" onclick="js_verSolicitud_fecha_asignada();"><span class="glyphicon glyphicon-import"></span>Por subir síntesis</a></li>
						<li class="{menuSoli05}"><a href="#" onclick="js_verSolicitud_ex_aprobado();"><i class="fa fa-check-circle"></i>Por aprobar directores</a></li>
						<li class="{menuSoli06}"><a href="#" onclick="js_verSolicitud_aprobado_directores();"><i class="fa fa-check-square"></i>Por aprobar consejo</a></li>
						<li class="{menuSoli07}"><a href="#" onclick="js_verSolicitud_admitido();"><i class="fa fa-child"></i>Admitidos</a></li>
					</ul>
				</li>
				<li class="{openSoliInfo} treeview">
					<a href="#">
						<i class="fa fa-pie-chart"></i>
						<span>Informes</span>
						<i class="fa fa-angle-left pull-right"></i>
					</a>
					<ul class="treeview-menu">
						<li><a href="#"><i class="fa fa-eye"></i>Estadística</small></a></li>
						<li><a href="#"><i class="fa fa-eye"></i>Exámenes a rendir</small></a></li>
					</ul>
				</li>
				<li class="{openSoliConfigUsua} treeview">
					<a href="#">
						<i class="fa fa-user"></i>
						<span>Configuración de Usuario</span>
						<i class="fa fa-angle-left pull-right"></i>
					</a>
					<ul class="treeview-menu">
						<li><a href="#"><i class="fa fa-group"></i>Usuarios</a></li>
						<li><a href="#"><i class="fa fa-check-square"></i>Roles de usuarios</a></li>
						<li><a href="#"><i class="fa fa-key"></i>Permisos</a></li>
					</ul>
				</li>
				<li class="{openSoliConfigSist} treeview">
					<a href="#">
						<i class="fa fa-gears"></i>
						<span>Configuración de sistema</span>
						<i class="fa fa-angle-left pull-right"></i>
					</a>
					<ul class="treeview-menu">
						<li class="{menuopenSoliConfigSist01}"><a href="#"><i class="fa fa-calendar-plus-o"></i>Períodos de admisión</a></li>
						<li class="{menuopenSoliConfigSist02}"><a href="../documentos_admision/"><i class="fa fa-paperclip"></i>Documentos adjuntos</a></li>
					</ul>
				</li>
          </ul>
          </ul>
        </section>
        <!-- /.sidebar -->
    </aside>