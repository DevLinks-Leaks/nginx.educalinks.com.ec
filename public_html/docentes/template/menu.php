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
				<li class="header">MÓDULO DOCENTE</li>
				<li class="<? if ($Menu==0) echo 'active'; ?>"><a href="index.php"><i class="fa fa-home"> </i> <span>Inicio</span></li></a>
				
				<li class="<? if ($Menu==2) echo 'active'; ?>"><a href="agenda.php"><i class="fa fa-book"> </i> <span>Agenda</span></li></a>
				<li class="<? if ($Menu==3) echo 'active'; ?>"><a href="clases.php"><i class="fa fa-upload"> </i> <span>Clases</span></li></a>
				<li class="<? if ($Menu==4) echo 'active'; ?>"><a href="notas.php"><i class="fa fa-clipboard"> </i> <span>Notas</span></li></a>
				<li class="<? if ($Menu==7) echo 'active'; ?>"><a href="tutor.php"><i class="fa fa-briefcase"> </i> <span>Tutor</span></li></a>
				
				<li class="<? if ($Menu==5) echo 'active'; ?>"><a href="hora_aten_repr_listas_main.php"><i class="fa fa-calendar"> </i> <span>Citas</span>
				<?php
					$params = array($_SESSION['prof_codi']);
					$sql="{call citas_prof_cont(?)}";
					$citas_prof_info = sqlsrv_query($conn, $sql, $params);  
					$row_citas_prof_info = sqlsrv_fetch_array($citas_prof_info);
					if ( $row_citas_prof_info['cant'] > 0 )
						echo '<span class="pull-right-container"><small class="label pull-right bg-red">'.$row_citas_prof_info['cant'].'</small></span>';
                ?>
				</li></a>
				
				<li class="<? if ($Menu==6) echo 'active'; ?>"><a href="observaciones.php"><i class="fa fa-eye"> </i> <span>Observaciones</span></li></a>
				<li class="<? if ($Menu==700) echo 'active'; ?>"><a href="mensajes.php"><i class="fa fa-envelope"></i> <span>Mensajes</span></a></li>
				<li><a href="../help/MANUAL_DOCENTE.pdf" target='_blank'><i class="fa fa-info-circle"></i> <span>Manual de ayuda</span></a><li><!-- {menu001} -->
				<li class="<? if ($Menu==800) echo 'active'; ?>"><a href="acerca.php"><i class="icon icon-logo"></i> <span>Acerca de Educalinks</span></a></li>
			</ul>
        </section>
        <!-- /.sidebar -->
    </aside>