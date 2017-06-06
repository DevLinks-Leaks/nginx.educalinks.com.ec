								 <div class="box-tools pull-right">
									<div class="btn-group">
										<button type="button" class="btn btn-box-tool dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
										<i class="fa fa-cog"></i> Configuración</button>
										<ul class="dropdown-menu" role="menu">
											<?php if(permiso_activo(17))?> <li><a href="admin_periodos.php"><span class='fa fa-calendar'></span> Período lectivo</a></li>
											<?php if(permiso_activo(62))?> <li><a href="cursos_cursos_main.php"><span class='fa fa-building'></span> Cursos</a></li>
											<?php if(permiso_activo(14))?> <li><a href="cursos_admin_paralelo_main.php"><span class='fa fa-list-alt'></span> Paralelos</a></li>
											<?php if(permiso_activo(12))?> <li><a href="cursos_materias_main.php"><span class='fa fa-address-book-o'></span> Materias</a> </li>
											<?php if(permiso_activo(13))?> <li><a href="cursos_aulas_main.php"><span class='fa fa-list-alt'></span> Aulas</a></li>
											<?php if(permiso_activo(521))?><li><a href="areas_main.php"><span class='fa fa-list-alt'></span> Áreas</a></li>
											<li class="divider"></li>
											<?php if(permiso_activo(11))?> <li <? if($Menu==412) echo 'class="active"'; ?>><a href="cursos_notas_permisos_main.php" title='Permisos de ingresos de notas a docentes.'><span class='fa fa-list-alt'></span> Permiso de ingreso de notas a profesores</a></li>
											<?php if(permiso_activo(67))?> <li><a href="profesores_main.php"><span class='fa fa-users'></span> Listado de Profesores</a></li>
										</ul>
									</div>
								</div>