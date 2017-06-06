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
					<?php echo $_SESSION['menu_institucion']; ?></p>
				</div>
			</div>
			<!-- sidebar menu: : style can be found in sidebar.less -->
			<ul class="sidebar-menu">
				<li class="header">MÓDULO ACADÉMICO</li>
				<li class="<? if (substr($Menu,0,1)==0) echo 'active'; ?>"><a href="index.php" title='Inicio'><i class="fa fa-home"> </i> <span>Inicio</span></li></a>
				<?php if (permiso_activo(2)){?>
				<li class="<? if (substr($Menu,0,1)==1) echo 'active'; ?> treeview"><!-- AQUI SERIA EL OPEN --><!--  -->
					<a href="#"><i class="fa fa-user"></i> <span>Alumnos</span> <i class="fa fa-angle-left pull-right"></i></a>
					<ul class="treeview-menu">
						<?php if(permiso_activo( 7))?> <li <? if($Menu==101) echo 'class="active"'; ?>><a href="alumnos_add.php" title='Formulario para registrar un alumno nuevo'><span class='fa fa-clipboard'></span> Inscripción </a></li>
						<?php if(permiso_activo( 8))?> <li <? if($Menu==102) echo 'class="active"'; ?>><a href="alumnos_main.php" title='Bandeja principal de todos los alumnos'><span class='fa fa-graduation-cap'></span> Bandeja de Alumnos</a></li>
						<?php if(permiso_activo( 9))?> <li <? if($Menu==103) echo 'class="active"'; ?>><a href="alumnos_repre_main.php" title='Bandeja principal de todos los representantes'><span class='fa fa-heart-o'></span> Bandeja Representantes</a></li>
						<?php if(permiso_activo(527))?><li <? if($Menu==106) echo 'class="active"'; ?>><a href="alumnos_blacklist_main.php" title='Listado de alumnos en Blacllist'><span class='fa fa-list'></span> Bandeja de Blacklist</a></li>
						<li class='<? if (substr($Menu,1,1)==2) echo 'active'; ?>  treeview'><a href="#"><i class="fa fa-wrench"></i> <span>Mantenimiento</span> <i class="fa fa-angle-left pull-right"></i></a>
							<ul class="treeview-menu">
								<?php if(permiso_activo( 8))?> <li <? if($Menu==124) echo 'class="active"'; ?>><a href="motivo_bloqueo_main.php" title='Mantenimiento de motivos de bloqueo'><span class='fa fa-ban'></span> Motivos bloqueo</a></li>
								<?php if(permiso_activo( 8))?> <li <? if($Menu==127) echo 'class="active"'; ?>><a href="documentos_main.php" title='Mantenimiento de los documentos solicitados en matriculación. Sirven para hacer check en la ventana de matriculación.'><span class='fa fa-briefcase'></span> Doc. entregados</a></li>
							</ul>
						</li>
						<?php if(permiso_activo(83))?> <li <? if($Menu==105) echo 'class="active"'; ?>><a href="alum_matri_deuda_main.php" title='Listado de alumnos matriculados para bloquear libreta'><span class='fa fa-ban'></span> Bloqueo Libreta</a> </li>
					</ul>
				</li>
				<?php }?>
				<?php if (permiso_activo(3)){?>
				<li class="<? if (substr($Menu,0,1)==2) echo 'active'; ?> treeview"><!-- AQUI SERIA EL OPEN --><!--  -->
					<a href="#"><i class="fa fa-university"></i> <span>Cursos</span> <i class="fa fa-angle-left pull-right"></i></a>
					<ul class="treeview-menu">
						<?php if(permiso_activo(10))?> <li <? if($Menu==201) echo 'class="active"'; ?>><a href="cursos_paralelo_main.php" title='Bandeja principal de cursos abiertos'><span class='fa fa-university'></span> Cursos Paralelo</a></li>
						<li class='<? if (substr($Menu,1,1)==1) echo 'active'; ?>  treeview'><a href="#"><i class="fa fa-wrench"></i> <span>Mantenimiento</span> <i class="fa fa-angle-left pull-right"></i></a>
							<ul class="treeview-menu">
								<?php if(permiso_activo(17))?> <li <? if($Menu==217) echo 'class="active"'; ?>><a href="admin_periodos.php"><span class='fa fa-calendar'></span> Periodos lectivos</a> </li>
								<?php if(permiso_activo(62))?> <li <? if($Menu==216) echo 'class="active"'; ?>><a href="cursos_cursos_main.php"><span class='fa fa-building'></span> Cursos</a></li>
								<?php if(permiso_activo(14))?> <li <? if($Menu==215) echo 'class="active"'; ?>><a href="cursos_admin_paralelo_main.php"><span class='fa fa-list-alt'></span> Paralelos</a></li>
								<?php if(permiso_activo(13))?> <li <? if($Menu==214) echo 'class="active"'; ?>><a href="cursos_aulas_main.php"><span class='fa fa-list-alt'></span> Aulas</a></li>
								<?php if(permiso_activo(12))?> <li <? if($Menu==213) echo 'class="active"'; ?>><a href="cursos_materias_main.php"><span class='fa fa-address-book-o'></span> Materias</a> </li>
								<?php if(permiso_activo(521))?><li <? if($Menu==218) echo 'class="active"'; ?>><a href="areas_main.php"><span class='fa fa-list-alt'></span> Áreas</a></li>
							</ul>	
						</li>
					</ul>
				</li>
				<li class="<? if ($Menu==901) echo 'active'; ?>"><a href="../../admin/profesores_main.php"><i class="fa fa-briefcase"></i> <span>Profesores</span></a></li>
				<?php }?>
				<?php if (permiso_activo(4)){?>
				<li class="<? if (substr($Menu,0,1)==5) echo 'active'; ?> treeview"><!-- AQUI SERIA EL OPEN --><!--  -->
					<a href="#"><i class="fa fa-users"></i> <span>Config. de usuario</span> <i class="fa fa-angle-left pull-right"></i></a>
					<ul class="treeview-menu">
						<?php if(permiso_activo(15))?> <li <? if($Menu==501) echo 'class="active"'; ?>><a href="roles_main.php"><span class='fa fa-briefcase'></span> Roles de usuario</a></li>
						<?php if(permiso_activo(16))?> <li <? if($Menu==502) echo 'class="active"'; ?>><a href="usuarios_main.php"><span class='fa fa-users'></span> Usuarios</a></li>
						<?php if(permiso_activo(71))?> <li <? if($Menu==503) echo 'class="active"'; ?>><a href="reset_pass.php"><span class='fa fa-key'></span> Reseteo de Clave</a></li>
					</ul>
				</li>
				<li class="<? if (substr($Menu,0,1)==4) echo 'active'; ?> treeview"><!-- AQUI SERIA EL OPEN --><!--  -->
					<a href="#"><i class="fa fa-cogs"></i> <span>Administración</span> <i class="fa fa-angle-left pull-right"></i></a>
					<ul class="treeview-menu">
						<?php if(permiso_activo(18))?> <li <? if($Menu==404) echo 'class="active"'; ?>><a href="admin_auditoria.php"><span class='fa fa-wpforms'></span> Auditoria</a></li>
						<li class='<? if (substr($Menu,1,1)==1) echo 'active'; ?>  treeview'><a href="#"><i class="fa fa-lock"></i> <span>Permisos</span> <i class="fa fa-angle-left pull-right"></i></a>
							<ul class="treeview-menu">
								<?php if(permiso_activo(20))?> <li <? if($Menu==416) echo 'class="active"'; ?>><a href="admin_permisos.php"><span class='fa fa-users'></span> Permisos de usuario</a></li>
								<?php if(permiso_activo(11))?> <li <? if($Menu==412) echo 'class="active"'; ?>><a href="cursos_notas_permisos_main.php" title='Permisos de ingresos de notas a docentes.'><span class='fa fa-list-alt'></span> Ingreso de notas</a></li>
								<?php if(permiso_activo(11))?> <li <? if($Menu==418) echo 'class="active"'; ?>><a href="admin_periodos_etapas.php?peri_codi=<? echo $_SESSION['peri_codi']; ?>" 
								title='El usuario puede activar ciertas funcionalidades del sistema, determinando el tiempo por el cual el acceso a la misma es vigente para los usuarios'><span class='fa fa-arrows-h'></span> Permisos por tiempo</a></li>
							</ul>	
						</li>
						<?php if(permiso_activo(84))?> <li <? if($Menu==403) echo 'class="active"'; ?>><a href="para_sistema_main.php"><span class='fa fa-toggle-on'></span> Parámetros sistema</a></li>
					</ul>
				</li>
				<?php }?>
				<?php if (permiso_activo(66)){?>
				<li class="<? if (substr($Menu,0,1)==6) echo 'active'; ?> treeview"><!-- AQUI SERIA EL OPEN --><!--  -->
					<a href="#"><i class="fa fa-book"></i> <span>Reportes</span> <i class="fa fa-angle-left pull-right"></i></a>
					<ul class="treeview-menu">
						<?php if(permiso_activo(66))?> <li <? if($Menu==602) echo 'class="active"'; ?>><a href="cursos_paralelo_profe_listas_main.php"><span class='fa fa-bookmark-o'></span> R. Profesores</a></li>
						<?php if(permiso_activo(66))?> <li <? if($Menu==603) echo 'class="active"'; ?>><a href="cursos_paralelo_peri_listas_main.php"><span class='fa fa-bookmark-o'></span> R. Cursos</a></li>
						<?php if(permiso_activo(66))?> <li <? if($Menu==604) echo 'class="active"'; ?>><a href="hora_aten_repr_listas_main.php"><span class='fa fa-bookmark-o'></span> R. Citas Profesores</a></li>
						<?php if(permiso_activo(66))?> <li <? if($Menu==605) echo 'class="active"'; ?>><a href="alum_matri_main.php"><span class='fa fa-bookmark-o'></span> R. Alumnos</a></li>
						<?php if(permiso_activo(66))?> <li <? if($Menu==606) echo 'class="active"'; ?>><a href="report_gene.php"><span class='fa fa-bookmark-o'></span> R. Generales</a></li>
						<?php if(permiso_activo(76))?> <li <? if($Menu==607) echo 'class="active"'; ?>><a href="report_gene_actas.php"><span class='fa fa-bookmark-o'></span> Actas</a></li>
					</ul>
				</li>
				<?php }?>
				
				<li class="<? if ($Menu==700) echo 'active'; ?>"><a href="../../admin/mensajes.php"><i class="fa fa-envelope"></i> <span>Mensajes</span></a></li>
				<li><a href="../help/ACADEMICO.pdf" target='_blank'><i class="fa fa-info-circle"></i> <span>Manual de ayuda</span></a><li><!-- {menu001} -->
				<li class="<? if ($Menu==800) echo 'active'; ?>"><a href="acerca.php"><i class="icon icon-logo"></i> <span>Acerca de Educalinks</span></a></li>
			</ul>
        </section>
        <!-- /.sidebar -->
    </aside>