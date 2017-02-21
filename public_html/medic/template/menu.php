	<aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
			<!-- Sidebar user panel -->
			<div class="user-panel">
				<div class="pull-left image">
					<img src="<?php echo "../".$_SESSION['ruta_foto_usuario'].'admin.jpg'; ?>" class="img-circle" alt="User Image">
				</div>
				<div class="pull-left info">
					<p style='font-size:11px;' ><?= $_SESSION['usua_nomb']; ?> <?= $_SESSION['usua_apel']; ?></p>
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
				<li class="header">MÓDULO MÉDICO</li>
				<li><a href="../../medic/general/"><i class="fa fa-home"> </i> <span>Inicio</span></li></a>
				<li class="{openSoliInfo} treeview">
					<a href="#">
						<i class="glyphicon glyphicon-plus-sign"></i>
						<span>Atenciones</span>
						<i class="fa fa-angle-left pull-right"></i>
					</a>
					<ul class="treeview-menu">
						<li><a href="../../medic/cons_estudiantes"><i class="fa fa-circle"></i>Estudiantes</small></a></li>
						<li><a href="../../medic/cons_visitas"><i class="fa fa-circle"></i>Visitas</small></a></li>
					</ul>
				</li>
				<li class="{openPaciente} treeview">
					<a href="#">
						<i class="glyphicon glyphicon-user"></i>
						<span>Pacientes</span>
						<i class="fa fa-angle-left pull-right"></i>
					</a>
					<ul class="treeview-menu">
						<li class="{menuPaciente01}"><a href="#" onclick="js_paciente_nuevo();"><i class="fa fa-circle"></i>Nuevo</small></a></li>
						<!--<li class="{menuPaciente02}"><a href="#" onclick="js_paciente_consulta();"><i class="fa fa-circle"></i>Bandeja</small></a></li>-->
					</ul>
				</li>
				<li class="{openSoliInfo} treeview">
					<a href="#">
						<i class="glyphicon glyphicon-scale"></i>
						<span>Fichas</span>
						<i class="fa fa-angle-left pull-right"></i>
					</a>
					<ul class="treeview-menu">
						<li><a href="../../medic/ficha_nuevo/"><i class="fa fa-circle"></i>Nuevo</small></a></li>
						<li><a href="#" onclick="js_ficha_med_consulta();"><i class="fa fa-circle""></i>Bandeja</small></a></li>
					</ul>
				</li>
				<li class="{openSoliInfo} treeview">
					<a href="#">
						<i class="glyphicon glyphicon-erase"></i>
						<span>Medicinas</span>
						<i class="fa fa-angle-left pull-right"></i>
					</a>
					<ul class="treeview-menu">
						<li><a href="../../medic/medi_medicinas"><i class="fa fa-circle"></i>Ingresos</small></a></li>
						<li><a href="../../medic/medi_presentaciones"><i class="fa fa-circle"></i>Presentaciones</small></a></li>
					</ul>
				</li>
				<li class="{openSoliConfigUsua} treeview">
					<a href="#">
						<i class="glyphicon glyphicon-duplicate"></i>
						<span>Reportes</span>
						<i class="fa fa-angle-left pull-right"></i>
					</a>
					<ul class="treeview-menu">
						<li><a href="../../medic/rep_inventarios"><i class="fa fa-circle"></i>Inventario</a></li>
						<li><a href="../../medic/rep_atenciones"><i class="fa fa-circle"></i>Atenciones</a></li>
					</ul>
				</li>
				<li><a href="../../../manuales/Manual_Educalinks_medico_2017_01_27_v1.2.1.pdf" target='_blank'><i class="fa fa-info-circle"></i> <span>Manual de ayuda</span></a><li><!-- {menu001} -->
				<li class="{open7}"><a href="../../common/acerca/"><i class="icon icon-logo"></i> <span>Acerca de Educalinks</span></a></li>
			</ul>
        </section>
        <!-- /.sidebar -->
    </aside>