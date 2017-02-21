<div class="section_side" id="sidePanel">
            
       <section class="main">
        
        <div class="ingenium">
          <img src="../theme/images/logo_ingenium.png">
        </div>

          <div class="contenedor">
        <div class="logo"> 
          <img src="<?= $_SESSION['ruta_foto_logo_web'];?>" alt="">
        </div>
        <h5>Unidad Educativa</h5>
        <h4><?php echo para_sist(3); ?></h4>
        </div>
      </section>
            	
				<? session_start();include ('../framework/dbconf.php');?>
				<ul class="menu_main">
					<li>
						<a href="index.php"  <? if ($Menu==0) { echo 'class="active"';} else { echo' class="link_menu"'; } ?> class="active"  alt="Ir al inicio"> 
							<span class="icon-home icon"></span>
							<div class="text"><h4>Inicio</h4></div>
						</a>
					</li>
                    <?php if (permiso_activo(2)){?>
                    <li>
                    <div class=" panel-menu">
                        <div class="panel-heading ">
                          <div class="panel-title">
                            <a data-toggle="collapse"  data-parent="#accordion" href="#alumnos" class="collapsed">
                              <span class="icon-users icon"></span>
                            <div class="text"><h4>Alumnos</h4></div>
                            </a>
                          </div>
                        </div>
                        <div id="alumnos" class="panel-collapse collapse <? if (substr($Menu,0,1)<>1)  echo 'in'; ?>">
                          <div class="panel-body">
                            
                            <ul>
                            	<?php if (permiso_activo(7)){?>
                                <li>
                                            <a <? if ($Menu==101) echo 'class="active"'; ?>href="../admin/alumnos_add.php">Inscripcion </a> 
                                </li>
                                <?php }if (permiso_activo(8)){?>
                                <li>
                                            <a <? if ($Menu==102) echo 'class="active"'; ?>href="../admin/alumnos_main.php">Alumnos</a> 
                                </li>
                                <?php }if (permiso_activo(9)){?>
                                <li>
                                            <a <? if ($Menu==103) echo 'class="active"'; ?>href="../admin/alumnos_repre_main.php">Representantes</a> 
                                </li>
                                <?php }if (permiso_activo(77)){?>
                                <!-- <li>
                                <a <? if ($Menu==104) echo 'class="active"'; ?>href="../admin/alumnos_bloqueados_main.php">Bloquear Alumno</a> 
                                </li> -->
                                <?php }if (permiso_activo(83)){?>
                                <li>
                                <a <? if ($Menu==105) echo 'class="active"'; ?>href="../admin/alum_matri_deuda_main.php">Bloqueo Libreta</a> 
                                </li>
                                <?php }if (permiso_activo(527)){?>
                                <li>
                                <a <? if ($Menu==106) echo 'class="active"'; ?>href="../admin/alumnos_blacklist_main.php">Blacklist</a> 
                                </li>
                                <?php }?>
                            </ul>
                            
                            
                            
                          </div>
                        </div>
                      </div>
                    </li>
                    <?php }?>
                    <?php if (permiso_activo(3)){?>
					<li>
                    	<div class=" panel-menu">
                            <div class="panel-heading ">
                              <div class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#cursos" class="collapsed" >
                                  <span class="icon-books icon"></span>
                                <div class="text"><h4>Cursos</h4></div> 
                                </a>
                              </div>
                            </div>
                            <div id="cursos" class="panel-collapse collapse <? if (substr($Menu,0,1)<>2)  echo 'in'; ?> ">
                              <div class="panel-body">
                                
                                <ul>
                                	<?php if (permiso_activo(10)){?>
                                    <li>
                                                <a <? if ($Menu==201) echo 'class="active"'; ?> href="cursos_paralelo_main.php">Cursos Paralelo</a> 
                                    </li>
                                    <?php }if (permiso_activo(62)){?>
                                     <li>
                                                <a <? if ($Menu==206) echo 'class="active"'; ?> href="cursos_notas_permisos_main.php">Notas Permisos</a> 
                                    </li>
                                    <?php }if (permiso_activo(11)){?>
                                     <li>
                                                <a <? if ($Menu==202) echo 'class="active"'; ?> href="cursos_cursos_main.php">Cursos</a> 
                                    </li>
                                    <?php }if (permiso_activo(12)){?>
                                    <li>
                                                <a <? if ($Menu==203) echo 'class="active"'; ?>  href="cursos_materias_main.php">Materias</a> 
                                    </li>
                                   
                                    <?php }if (permiso_activo(13)){?>
                                    <li>
                                                <a <? if ($Menu==204) echo 'class="active"'; ?> href="cursos_aulas_main.php">Aulas</a> 
                                    </li>
                                    <?php }if (permiso_activo(14)){?>
                                     <li>
                                                <a <? if ($Menu==205) echo 'class="active"'; ?> href="cursos_admin_paralelo_main.php">Paralelos</a> 
                                    </li>
                                    
                                    <?php }if (permiso_activo(67)){?>
                                     <li>
                                                <a <? if ($Menu==207) echo 'class="active"'; ?> href="profesores_main.php">Profesores</a> 
                                    </li>

                                    <?php }if (permiso_activo(521)){?>
                                     <li>
                                                <a <? if ($Menu==208) echo 'class="active"'; ?> href="areas_main.php">Áreas</a> 
                                    </li>
                                    <?php }?>
                                </ul>
                                
                                
                                
                              </div>
                            </div>
                      </div>
					</li>
                    <?php }?>
                    <?php if (permiso_activo(4)){?>
					<li>
						<div class=" panel-menu">
                        <div class="panel-heading ">
                          <div class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#administracion" class="collapsed">
                              <span class="icon-parent icon"></span>
                            <div class="text"><h4>Administracion</h4></div>
                            </a>
                          </div>
                        </div>
                        <div id="administracion" class="panel-collapse collapse <? if (substr($Menu,0,1)<>4)  echo 'in'; ?> ">
                          <div class="panel-body">
                            
                            <ul>
                            	<?php if (permiso_activo(15)){?>
                                <li>		<a <? if ($Menu==401) echo 'class="active"'; ?>  href="roles_main.php">Roles</a> 
                                </li>
                                <?php }if (permiso_activo(16)){?>
                                <li>		<a <? if ($Menu==402) echo 'class="active"'; ?>  href="usuarios_main.php">Usuarios</a> 
                                </li>
                                <?php }if (permiso_activo(71)){?>
                                <li>		<a <? if ($Menu==407) echo 'class="active"'; ?>  href="reset_pass.php">Reseteo de Clave</a> 
                                </li>
                                <?php }if (permiso_activo(17)){?>
                                <li>
                                            <a <? if ($Menu==403) echo 'class="active"'; ?>   href="admin_periodos.php">Periodos</a> 
                                </li>
                                <?php }if (permiso_activo(18)){?>
                              <li>
                                            <a <? if ($Menu==404) echo 'class="active"'; ?>   href="admin_parametos.php">Parametros Generales</a> 
                              </li>
                              <?php }if (permiso_activo(19)){?>
                                <li>
                                            <a <? if ($Menu==405) echo 'class="active"'; ?>   href="admin_auditoria.php">Auditoria</a> 
                                </li>
                                <?php }if (permiso_activo(20)){?>
                                <li>
                                            <a <? if ($Menu==406) echo 'class="active"'; ?>   href="admin_permisos.php">Permisos</a> 
                                </li>
                                <?php }?>
                                <?php if (permiso_activo(72)){?>
                                <li>
                                            <a <? if ($Menu==408) echo 'class="active"'; ?>   href="comportamiento.php">Parámetros de comportamiento</a> 
                                </li>
                                <?php }?>
                                <?php if (permiso_activo(86)){?>
                                <li>
                                            <a <? if ($Menu==409) echo 'class="active"'; ?>   href="importacion_datos.php">Importación de datos</a> 
                                </li>
                                <?php }?>
                                <?php if (permiso_activo(84)){?>
                                <li>
                                            <a <? if ($Menu==410) echo 'class="active"'; ?>   href="para_sistema_main.php">Parámetros del sistema</a> 
                                </li>
                                <?php }?>
                                <?php if (permiso_activo(87)){?>
                                <li>
                                            <a <? if ($Menu==411) echo 'class="active"'; ?>   href="usua_pass_main.php">Usuarios y Claves</a> 
                                </li>
                                <?php }?>
                                <?php if (permiso_activo(159)){?>
                                <li>
                                            <a <? if ($Menu==412) echo 'class="active"'; ?>   href="cata_sistema_main.php">Catálogo del sistema</a> 
                                </li>
                                <?php }?>
                            </ul>
                            
                            
                            
                          </div>
                        </div>
                      </div>
					</li>
			 		<?php }?>
                    
                    <?php if (permiso_activo(66)){?>
					<li>
						<div class=" panel-menu">
                        <div class="panel-heading ">
                          <div class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#reportes" class="collapsed">
                              <span class="icon-print icon"></span>
                            <div class="text"><h4>Reportes</h4></div>
                            </a>
                          </div>
                        </div>
                        <div id="reportes" class="panel-collapse collapse <? if (substr($Menu,0,1)<>6)  echo 'in'; ?> ">
                          <div class="panel-body">
                            
                            <ul>
                              <li>
                              	<a <? if ($Menu==602) echo 'class="active"'; ?>   href="cursos_paralelo_profe_listas_main.php">Reportes Profesores</a> 
                              </li>
                              <li>
                              	<a <? if ($Menu==603) echo 'class="active"'; ?>   href="cursos_paralelo_peri_listas_main.php">Reportes Cursos</a> 
                              </li>
                              <li>
                              	<a <? if ($Menu==604) echo 'class="active"'; ?>   href="hora_aten_repr_listas_main.php">Reportes Citas Profesores</a> 
                              </li>
                              <li>
                              	<a <? if ($Menu==605) echo 'class="active"'; ?>   href="alum_matri_main.php">Reportes Alumnos Matriculados</a> 
                              </li>
                              <li>
                              	<a <? if ($Menu==606) echo 'class="active"'; ?>   href="report_gene.php">Reportes Generales</a> 
                              </li>
                               <?php if (permiso_activo(76)){?>
                                <li>
                                  <a <? if ($Menu==607) echo 'class="active"'; ?>   href="report_gene_actas.php">Actas</a> 
                                </li>
                                <?php }?>
                            </ul>
                            
                            
                            
                          </div>
                        </div>
                      </div>
					</li>
			 		<?php }?>
                    
					<li>
            <a href="mensajes.php" class='section_califications link_menu <? if ($Menu==700) echo 'active'; ?>' >
              <span class="icon-envelope  icon"></span>
              <div class="text"><h4>Mensajes</h4></div>  
            </a>
          </li> 
          <?php if (permiso_activo(5)){?>
          <li>
						<a href="../help/ACADEMICO.pdf" target="_blank" class="section_califications link_menu" alt="Ver Calificaciones">
							<span class="icon-signup  icon"></span>
							<div class="text"><h4>Ayuda</h4></div> 
						</a>
					</li> 
                    <?php }?>
				</ul>
			</div>