	<aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
			<!-- Sidebar user panel -->
			<div class="user-panel">
				<div class="pull-left image">
					<img src="<?= $_SESSION['ruta_foto_logo_web'];?>" class="img-circle" alt="User Image">
				</div>
				<div class="pull-left info" style='font-size:x-small;'>
					<p>Unidad Educativa<br>
					<?php if ( !isset( $_SESSION['menu_institucion'] ) ) $_SESSION['menu_institucion'] = para_sist(3); 
						echo $_SESSION['menu_institucion'];
					?></p>
				</div>
			</div>
			
			<? session_start();include ('../framework/dbconf.php');?>
			<!-- sidebar menu: : style can be found in sidebar.less -->
			<ul class="sidebar-menu">
				<li class="header">MÓDULO BIBLIOTECA</li>
				<li><a href="../../biblio/index.php"><i class="fa fa-home"> </i> <span>Inicio</span></li></a>
				<li class="{openSoliInfo} treeview">
					<a href="#">
						<i class="fa fa-book"></i>
						<span>Recursos</span>
						<i class="fa fa-angle-left pull-right"></i>
					</a>
					<ul class="treeview-menu">
						<li><a href="recurso_new.php"><i class="fa fa-plus-square"></i>Nuevo Recurso</small></a></li>
						<li><a href="recurso.php"><i class="fa fa-tv"></i>Control de Recursos</small></a></li>
						<li><a href="recurso_reportes.php"><i class="fa fa-bookmark-o"></i>Reportes Recursos</small></a></li>
						<li><a href="recurso_item_reportes.php"><i class="fa fa-bookmark-o"></i>Reportes Items</small></a></li>
					</ul>
				</li>
				<li class="{openSoliInfo} treeview">
					<a href="#">
						<i class="fa fa-hand-lizard-o"></i>
						<span>Prestamos</span>
						<i class="fa fa-angle-left pull-right"></i>
					</a>
					<ul class="treeview-menu">
						<li><a href="prestamo_new.php"><i class="fa fa-plus-square"></i>Nuevo Prestamo</small></a></li>
						<li><a href="prestamo.php"><i class="fa fa-tv"></i>Control de Prestamos</small></a></li>
						<li><a href="prestamo_reportes.php"><i class="fa fa-bookmark-o"></i>Reportes Prestamos</small></a></li>
						<li><a href="prestamo_item_reportes.php"><i class="fa fa-bookmark-o"></i>Reportes Prestamos Detalle</small></a></li>
					</ul>
				</li>
				<li class="{openSoliInfo} treeview">
					<a href="#">
						<i class="fa fa-wrench"></i>
						<span>Mantenimiento</span>
						<i class="fa fa-angle-left pull-right"></i>
					</a>
					<ul class="treeview-menu">
						<li><a href="autor.php"><i class="fa fa-users"></i>Autores</small></a></li>
						<li><a href="categoria.php"><i class="fa fa-sitemap"></i>Categorias</small></a></li>
						<li><a href="descriptor.php"><i class="fa fa-tags"></i>Descriptores</small></a></li>
						<li><a href="tipo.php"><i class="fa fa-th-large"></i>Tipos</small></a></li>
						<li><a href="coleccion.php"><i class="fa fa-object-group"></i>Coleciones</small></a></li>
						<li><a href="editorial.php"><i class="fa fa-newspaper-o"></i>Editoriales</small></a></li>
						<li><a href="procedencia.php"><i class="fa fa-institution"></i>Procedencias</small></a></li>
					</ul>
				</li>
				<li class="{openSoliInfo} treeview">
					<a href="#">
						<i class="fa fa-upload"></i>
						<span>Importación Datos</span>
						<i class="fa fa-angle-left pull-right"></i>
					</a>
					<ul class="treeview-menu">
						<li><a href="importacion.php"><i class="fa fa-database"></i>Principales</small></a></li>
						<li><a href="importacion_recursos.php"><i class="fa fa-database"></i>Recursos</small></a></li>
					</ul>
				</li>
				<li><a href="../help/EDUCALINKS_BIBLIOTECA.pdf" target='_blank'><i class="fa fa-info-circle"></i> <span>Manual de ayuda</span></a><li>
			</ul>
        </section>
        <!-- /.sidebar -->
    </aside>