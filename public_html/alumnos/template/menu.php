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
			<?php session_start(); ?>
			<!-- sidebar menu: : style can be found in sidebar.less -->
			<ul class="sidebar-menu">
				<li class="header"><?php echo $_SESSION['nombre_del_modulo']; ?></li>
				<li class="<? if ($Menu==0) echo 'active'; ?>"><a href="index.php"><i class="fa fa-home"> </i> <span>Inicio</span></li></a>
				<li class="<? if ($Menu==2) echo 'active'; ?>"><a href="agenda.php"><i class="fa fa-calendar"></i> <span>Agenda</span></a></li>
				<li class="<? if ($Menu==3) echo 'active'; ?>"><a href="clases.php"><i class="glyphicon glyphicon-book"></i> <span>Materiales</span></a></li>
				<li class="<? if ($Menu==700) echo 'active'; ?>"><a href="notas.php"><i class="fa fa-book"></i> <span>Calificaciones</span></a></li>
				<?php
				
				if( $_SESSION['certus_medic'] == 1 )
				{	?><li class="<? if ($Menu==700) echo 'active'; ?>"><a href="visitas_medicas.php"><i class="fa fa-medkit"></i> <span>Visitas Médicas</span></a></li><?php
				}
				if($_SESSION['USUA_TIPO']=='R')
				{   if (para_sist(402))
					{	?><li class="<? if ($Menu==5) echo 'active'; ?>"><a href="citas.php"><i class="fa fa-clock-o"></i> <span>Citas</span></a></li><?php 
					}
				}
				if( $_SESSION['certus_boton_de_pago'] == 1 )
				{	echo '<li><a href="#" onclick="js_menu_pagos();"><i class="fa fa-credit-card"></i> <span>Pagos</span></a></li>';
				}
				?>
				<li class="<? if ($Menu==6) echo 'active'; ?>"><a href="observaciones_main.php"><i class="fa fa-comments"></i> <span>Hoja de Vida</span></a></li>
				<li class="<? if ($Menu==700) echo 'active'; ?>"><a href="mensajes.php"><i class="fa fa-envelope"></i> <span>Mensajes</span></a></li>
				<li><a href="../help/MANUAL_REPR.pdf" target='_blank'><i class="fa fa-info-circle"></i> <span>Manual de ayuda</span></a><li><!-- {menu001} -->
				<li class=""><a href="acerca.php"><i class="icon icon-logo"></i> <span>Acerca de Educalinks</span></a></li>
			</ul>
        </section>
        <!-- /.sidebar -->
    </aside>