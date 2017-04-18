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
			<!-- sidebar menu: : style can be found in sidebar.less -->
			<ul class="sidebar-menu">
				<li class="header">MÓDULO ACADÉMICO</li>
				<li class="<? if (substr($Menu,0,1)==0) echo 'active'; ?>"><a href="index.php"><i class="fa fa-home"> </i> <span>Inicio</span></li></a>
				<?php if (permiso_activo(2)){?>
				<li class="<? if (substr($Menu,0,1)==1) echo 'active'; ?> treeview"><!-- AQUI SERIA EL OPEN --><!--  -->
					<a href="#"><i class="fa fa-user"></i> <span>Alumnos</span> <i class="fa fa-angle-left pull-right"></i></a>
					<ul class="treeview-menu">
						<?php if(permiso_activo( 7))?> <li <? if($Menu==101) echo 'class="active"'; ?>><a href="alumnos_add.php"><span class='fa fa-clipboard'></span> Inscripcion </a></li>
						<?php if(permiso_activo( 8))?> <li <? if($Menu==102) echo 'class="active"'; ?>><a href="alumnos_main.php"><span class='fa fa-graduation-cap'></span> Bandeja de Alumnos</a></li>
						<?php if(permiso_activo( 9))?> <li <? if($Menu==103) echo 'class="active"'; ?>><a href="alumnos_repre_main.php"><span class='fa fa-heart-o'></span> Bandeja de Representantes</a></li>
						<?php if(permiso_activo(83))?> <li <? if($Menu==105) echo 'class="active"'; ?>><a href="alum_matri_deuda_main.php"><span class='fa fa-ban'></span> Bloqueo Libreta</a> </li>
						<?php if(permiso_activo(527))?><li <? if($Menu==106) echo 'class="active"'; ?>><a href="alumnos_blacklist_main.php"><span class='fa fa-list'></span> Blacklist</a></li>
					</ul>
				</li>
				<?php }?>
				<?php if (permiso_activo(3)){?>
				<li class="<? if (substr($Menu,0,1)==2) echo 'active'; ?> treeview"><!-- AQUI SERIA EL OPEN --><!--  -->
					<a href="#"><i class="fa fa-user"></i> <span>Cursos</span> <i class="fa fa-angle-left pull-right"></i></a>
					<ul class="treeview-menu">
						<?php if(permiso_activo(10))?> <li <? if($Menu==201) echo 'class="active"'; ?>><a href="cursos_paralelo_main.php"><span class='fa fa-circle-o'></span> Cursos Paralelo</a></li>
						<?php if(permiso_activo(11))?> <li <? if($Menu==202) echo 'class="active"'; ?>><a href="cursos_notas_permisos_main.php"><span class='fa fa-circle-o'></span> Notas Permisos</a></li>
						<?php if(permiso_activo(62))?> <li <? if($Menu==206) echo 'class="active"'; ?>><a href="cursos_cursos_main.php"><span class='fa fa-circle-o'></span> Cursos</a></li>
						<?php if(permiso_activo(12))?> <li <? if($Menu==203) echo 'class="active"'; ?>><a href="cursos_materias_main.php"><span class='fa fa-circle-o'></span> Materias</a> </li>
						<?php if(permiso_activo(13))?> <li <? if($Menu==204) echo 'class="active"'; ?>><a href="cursos_aulas_main.php"><span class='fa fa-circle-o'></span> Aulas</a></li>
						<?php if(permiso_activo(14))?> <li <? if($Menu==205) echo 'class="active"'; ?>><a href="cursos_admin_paralelo_main.php"><span class='fa fa-circle-o'></span> Paralelos</a></li>
						<?php if(permiso_activo(67))?> <li <? if($Menu==207) echo 'class="active"'; ?>><a href="profesores_main.php"><span class='fa fa-circle-o'></span> Profesores</a></li>
						<?php if(permiso_activo(521))?><li <? if($Menu==208) echo 'class="active"'; ?>><a href="areas_main.php"><span class='fa fa-circle-o'></span> Áreas</a></li>
					</ul>
				</li>
				<?php }?>
				<?php if (permiso_activo(4)){?>
				<li class="<? if (substr($Menu,0,1)==4) echo 'active'; ?> treeview"><!-- AQUI SERIA EL OPEN --><!--  -->
					<a href="#"><i class="fa fa-user"></i> <span>Administración</span> <i class="fa fa-angle-left pull-right"></i></a>
					<ul class="treeview-menu">
						<?php if(permiso_activo(15))?> <li <? if($Menu==401) echo 'class="active"'; ?>><a href="roles_main.php"><span class='fa fa-circle-o'></span> Roles </a></li>
						<?php if(permiso_activo(16))?> <li <? if($Menu==402) echo 'class="active"'; ?>><a href="usuarios_main.php"><span class='fa fa-users'></span> Usuarios</a></li>
						<?php if(permiso_activo(71))?> <li <? if($Menu==407) echo 'class="active"'; ?>><a href="reset_pass.php"><span class='fa fa-key'></span> Reseteo de Clave</a></li>
						<?php if(permiso_activo(17))?> <li <? if($Menu==403) echo 'class="active"'; ?>><a href="admin_periodos.php"><span class='fa fa-circle-o'></span> Periodos</a> </li>
						<?php if(permiso_activo(18))?> <li <? if($Menu==404) echo 'class="active"'; ?>><a href="admin_auditoria.php"><span class='fa fa-circle-o'></span> Auditoria</a></li>
						<!--<?php if(permiso_activo(19))?> <li <? if($Menu==405) //echo 'class="active"'; ?>><a href="alumnos_blacklist_main.php"><span class='fa fa-circle-o'></span> Parámetros generales</a></li>-->
						<?php if(permiso_activo(20))?> <li <? if($Menu==406) echo 'class="active"'; ?>><a href="admin_permisos.php"><span class='fa fa-lock'></span> Permisos</a></li>
						<?php if(permiso_activo(84))?> <li <? if($Menu==410) echo 'class="active"'; ?>><a href="para_sistema_main.php"><span class='fa fa-circle-o'></span> Parámetros del sistema</a></li>
						<?php if(permiso_activo(87))?> <li <? if($Menu==411) echo 'class="active"'; ?>><a href="usua_pass_main.php"><span class='fa fa-key'></span> Usuarios y Claves</a></li>
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
						<?php if(permiso_activo(66))?> <li <? if($Menu==605) echo 'class="active"'; ?>><a href="alum_matri_main.php"><span class='fa fa-bookmark-o'></span> R. Alumnos Matriculados</a></li>
						<?php if(permiso_activo(66))?> <li <? if($Menu==606) echo 'class="active"'; ?>><a href="report_gene.php"><span class='fa fa-bookmark-o'></span> R. Generales</a></li>
						<?php if(permiso_activo(76))?> <li <? if($Menu==607) echo 'class="active"'; ?>><a href="report_gene_actas.php"><span class='fa fa-bookmark-o'></span> Actas</a></li>
					</ul>
				</li>
				<?php }?>
				
				<li class="<? if ($Menu==700) echo 'active'; ?>"><a href="mensajes.php"><i class="fa fa-envelope"></i> <span>Mensajes</span></a></li>
				<li><a href="../help/ACADEMICO.pdf" target='_blank'><i class="fa fa-info-circle"></i> <span>Manual de ayuda</span></a><li><!-- {menu001} -->
				<li class=""><a href="acerca.php"><i class="icon icon-logo"></i> <span>Acerca de Educalinks</span></a></li>
			</ul>
        </section>
        <!-- /.sidebar -->
    </aside>