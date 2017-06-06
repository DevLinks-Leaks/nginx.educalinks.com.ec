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
				<li class="<? if (substr($Menu,0,1)==0) echo 'active'; ?>"><a href="index.php"><i class="fa fa-home"> </i> <span>Inicio</span></li></a>
				<?php if (permiso_activo(2)){?>
				<li class="<? if (substr($Menu,0,1)==1) echo 'active'; ?> treeview"><!-- AQUI SERIA EL OPEN --><!--  -->
					<a id="acc_alumnos" href="#"><i class="fa fa-user"></i> <span><span style="text-decoration: underline;">A</span>lumnos</span> <i class="fa fa-angle-left pull-right"></i></a>
					<ul id="ul_alumnos" class="treeview-menu <? if (substr($Menu,0,1)==1) echo 'menu-open'; ?>"">
						<?php if(permiso_activo( 7))?> <li <? if($Menu==101) echo 'class="active"'; ?>><a id="acc_alum_insc" href="alumnos_add.php"><span class='fa fa-clipboard'></span> <span style="text-decoration: underline;">l</span>nscripción </a></li>
						<?php if(permiso_activo( 8))?> <li <? if($Menu==102) echo 'class="active"'; ?>><a id="acc_alum_alum" href="alumnos_main.php"><span class='fa fa-graduation-cap'></span> Bandeja de A<span style="text-decoration: underline;">l</span>umnos</a></li>
						<?php if(permiso_activo( 9))?> <li <? if($Menu==103) echo 'class="active"'; ?>><a id="acc_alum_repr" href="alumnos_repre_main.php"><span class='fa fa-heart-o'></span> Re<span style="text-decoration: underline;">p</span>resentantes</a></li>
						<?php if(permiso_activo(83))?> <li <? if($Menu==105) echo 'class="active"'; ?>><a id="acc_alum_bloq" href="alum_matri_deuda_main.php"><span class='fa fa-ban'></span> Blo<span style="text-decoration: underline;">q</span>ueo Libreta</a> </li>
						<?php if(permiso_activo(527))?><li <? if($Menu==106) echo 'class="active"'; ?>><a id="acc_alum_black" href="alumnos_blacklist_main.php"><span class='fa fa-list'></span> <span style="text-decoration: underline;">B</span>lacklist</a></li>
					</ul>
				</li>
				<?php }?>
				<?php if (permiso_activo(3)){?>
				<li class="<? if (substr($Menu,0,1)==2) echo 'active'; ?> treeview"><!-- AQUI SERIA EL OPEN --><!--  -->
					<a id="acc_cursos" href="#"><i class="fa fa-list-alt"></i> <span><span style="text-decoration: underline;">C</span>ursos</span> <i class="fa fa-angle-left pull-right"></i></a>
					<ul id="ul_cursos" class="treeview-menu <? if (substr($Menu,0,1)==2) echo 'menu-open'; ?>"">
						<?php if(permiso_activo(10))?> <li <? if($Menu==201) echo 'class="active"'; ?>><a id="acc_cursos_para" href="cursos_paralelo_main.php"><span class='fa fa-university'></span> Cursos <span style="text-decoration: underline;">P</span>aralelo</a></li>
						<?php if(permiso_activo(11))?> <li <? if($Menu==202) echo 'class="active"'; ?>><a id="acc_cursos_perm" href="cursos_notas_permisos_main.php"><span class='fa fa-list-alt'></span> <span style="text-decoration: underline;">N</span>otas Permisos</a></li>
						<?php if(permiso_activo(62))?> <li <? if($Menu==206) echo 'class="active"'; ?>><a href="cursos_cursos_main.php"><span class='fa fa-building'></span> Cursos</a></li>
						<?php if(permiso_activo(12))?> <li <? if($Menu==203) echo 'class="active"'; ?>><a href="cursos_materias_main.php"><span class='fa fa-address-book-o'></span> Materias</a> </li>
						<?php if(permiso_activo(13))?> <li <? if($Menu==204) echo 'class="active"'; ?>><a href="cursos_aulas_main.php"><span class='fa fa-list-alt'></span> Aulas</a></li>
						<?php if(permiso_activo(14))?> <li <? if($Menu==205) echo 'class="active"'; ?>><a href="cursos_admin_paralelo_main.php"><span class='fa fa-list-alt'></span> Paralelos</a></li>
						<?php if(permiso_activo(67))?> <li <? if($Menu==207) echo 'class="active"'; ?>><a href="profesores_main.php"><span class='fa fa-users'></span> Profesores</a></li>
						<?php if(permiso_activo(521))?><li <? if($Menu==208) echo 'class="active"'; ?>><a href="areas_main.php"><span class='fa fa-list-alt'></span> Áreas</a></li>
					</ul>
				</li>
				<?php }?>
				<?php if (permiso_activo(4)){?>
				<li class="<? if (substr($Menu,0,1)==4) echo 'active'; ?> treeview"><!-- AQUI SERIA EL OPEN --><!--  -->
					<a id="acc_admin" href="#"><i class="fa fa-cogs"></i> <span>A<span style="text-decoration: underline;">d</span>ministración</span> <i class="fa fa-angle-left pull-right"></i></a>
					<ul id="ul_admin" class="treeview-menu <? if (substr($Menu,0,1)==4) echo 'menu-open'; ?>">
						<?php if(permiso_activo(15))?> <li <? if($Menu==401) echo 'class="active"'; ?>><a href="roles_main.php"><span class='fa fa-briefcase'></span> Roles </a></li>
						<?php if(permiso_activo(16))?> <li <? if($Menu==402) echo 'class="active"'; ?>><a href="usuarios_main.php"><span class='fa fa-users'></span> Usuarios</a></li>
						<?php if(permiso_activo(71))?> <li <? if($Menu==407) echo 'class="active"'; ?>><a href="reset_pass.php"><span class='fa fa-key'></span> Reseteo de Clave</a></li>
						<?php if(permiso_activo(17))?> <li <? if($Menu==403) echo 'class="active"'; ?>><a id="acc_admin_peri" href="admin_periodos.php"><span class='fa fa-circle-o'></span> <span style="text-decoration: underline;">P</span>eriodos</a> </li>
						<?php if(permiso_activo(18))?> <li <? if($Menu==404) echo 'class="active"'; ?>><a href="admin_auditoria.php"><span class='fa fa-wpforms'></span> Auditoria</a></li>
						<!--<?php if(permiso_activo(19))?> <li <? if($Menu==405) //echo 'class="active"'; ?>><a href="alumnos_blacklist_main.php"><span class='fa fa-circle-o'></span> Parámetros generales</a></li>-->
						<?php if(permiso_activo(20))?> <li <? if($Menu==406) echo 'class="active"'; ?>><a href="admin_permisos.php"><span class='fa fa-lock'></span> Permisos</a></li>
						<?php if(permiso_activo(84))?> <li <? if($Menu==410) echo 'class="active"'; ?>><a id="acc_admin_para_sist" href="para_sistema_main.php"><span class='fa fa-toggle-on'></span> Parámetros <span style="text-decoration: underline;">S</span>istema</a></li>
						<?php if(permiso_activo(87))?> <li <? if($Menu==411) echo 'class="active"'; ?>><a href="usua_pass_main.php"><span class='fa fa-key'></span> Usuarios y Claves</a></li>
					</ul>
				</li>
				<?php }?>
				<?php if (permiso_activo(66)){?>
				<li class="<? if (substr($Menu,0,1)==6) echo 'active'; ?> treeview"><!-- AQUI SERIA EL OPEN --><!--  -->
					<a id="acc_repo" href="#"><i class="fa fa-book"></i> <span><span style="text-decoration: underline;">R</span>eportes</span> <i class="fa fa-angle-left pull-right"></i></a>
					<ul id="ul_repo" class="treeview-menu <? if (substr($Menu,0,1)==6) echo 'menu-open'; ?>"">
						<?php if(permiso_activo(66))?> <li <? if($Menu==602) echo 'class="active"'; ?>><a href="cursos_paralelo_profe_listas_main.php"><span class='fa fa-bookmark-o'></span> R. Profesores</a></li>
						<?php if(permiso_activo(66))?> <li <? if($Menu==603) echo 'class="active"'; ?>><a href="cursos_paralelo_peri_listas_main.php"><span class='fa fa-bookmark-o'></span> R. Cursos</a></li>
						<?php if(permiso_activo(66))?> <li <? if($Menu==604) echo 'class="active"'; ?>><a href="hora_aten_repr_listas_main.php"><span class='fa fa-bookmark-o'></span> R. Citas Profesores</a></li>
						<?php if(permiso_activo(66))?> <li <? if($Menu==605) echo 'class="active"'; ?>><a href="alum_matri_main.php"><span class='fa fa-bookmark-o'></span> R. Alumnos</a></li>
						<?php if(permiso_activo(66))?> <li <? if($Menu==606) echo 'class="active"'; ?>><a id="acc_repo_gene" href="report_gene.php"><span class='fa fa-bookmark-o'></span> R. <span style="text-decoration: underline;">G</span>enerales</a></li>
						<?php if(permiso_activo(76))?> <li <? if($Menu==607) echo 'class="active"'; ?>><a id="acc_repo_acta" href="report_gene_actas.php"><span class='fa fa-bookmark-o'></span> Acta<span style="text-decoration: underline;">s</span></a></li>
					</ul>
				</li>
				<?php }?>
				
				<li class="<? if ($Menu==700) echo 'active'; ?>"><a id="acc_mens" href="mensajes.php"><i class="fa fa-envelope"></i> <span><span style="text-decoration: underline;">M</span>ensajes</span></a></li>
				<li><a href="../help/ACADEMICO.pdf" target='_blank'><i class="fa fa-info-circle"></i> <span>Manual de ayuda</span></a><li><!-- {menu001} -->
				<li class="<? if ($Menu==800) echo 'active'; ?>"><a href="acerca.php"><i class="icon icon-logo"></i> <span>Acerca de Educalinks</span></a></li>
			</ul>
        </section>
        <!-- /.sidebar -->
    </aside>