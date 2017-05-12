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
                            <a id="acc_alumnos" data-toggle="collapse"  data-parent="#accordion" href="#alumnos" class="collapsed" onclick="close_others(this.id);" title="Presione [Alt+A] para abrir">
                              <span class="icon-users icon"></span>
                            <div class="text"><h4><span style='text-decoration: underline;'>A</span>lumnos</h4></div>
                            </a>
                          </div>
                        </div>
                        <div id="alumnos" class="panel-collapse collapse <? if (substr($Menu,0,1)<>1)  echo 'in'; ?>">
                          <div class="panel-body">
                            
                            <ul>
                            	<?php if (permiso_activo(7)){?>
                                <li>
                                            <a id="acc_alum_insc" <? if ($Menu==101) echo 'class="active"'; ?>href="../admin/alumnos_add.php" title="Presione [Alt+I] para abrir"><span style='text-decoration: underline;'>I</span>nscripcion </a> 
                                </li>
                                <?php }if (permiso_activo(8)){?>
                                <li>
                                            <a id="acc_alum_alum" <? if ($Menu==102) echo 'class="active"'; ?>href="../admin/alumnos_main.php" title="Presione [Alt+L] para abrir">A<span style='text-decoration: underline;'>l</span>umnos</a> 
                                </li>
                                <?php }if (permiso_activo(9)){?>
                                <li>
                                            <a id="acc_alum_repr" <? if ($Menu==103) echo 'class="active"'; ?>href="../admin/alumnos_repre_main.php" title="Presione [Alt+P] para abrir">Re<span style='text-decoration: underline;'>p</span>resentantes</a> 
                                </li>
                                <?php }if (permiso_activo(77)){?>
                                <!-- <li>
                                <a <? if ($Menu==104) echo 'class="active"'; ?>href="../admin/alumnos_bloqueados_main.php">Bloquear Alumno</a> 
                                </li> -->
                                <?php }if (permiso_activo(83)){?>
                                <li>
                                <a id="acc_alum_bloq" <? if ($Menu==105) echo 'class="active"'; ?>href="../admin/alum_matri_deuda_main.php" title="Presione [Alt+Q] para abrir">Blo<span style='text-decoration: underline;'>q</span>ueo Libreta</a> 
                                </li>
                                <?php }if (permiso_activo(527)){?>
                                <li>
                                <a id="acc_alum_black" <? if ($Menu==106) echo 'class="active"'; ?>href="../admin/alumnos_blacklist_main.php" title="Presione [Alt+B] para abrir"><span style='text-decoration: underline;'>B</span>lacklist</a> 
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
                                <a id="acc_cursos" data-toggle="collapse" data-parent="#accordion" href="#cursos" class="collapsed" onclick="close_others(this.id);" title="Presione [Alt+C] para abrir">
                                  <span class="icon-books icon"></span>
                                <div class="text"><h4><span style='text-decoration: underline;'>C</span>ursos</h4></div> 
                                </a>
                              </div>
                            </div>
                            <div id="cursos" class="panel-collapse collapse <? if (substr($Menu,0,1)<>2)  echo 'in'; ?> ">
                              <div class="panel-body">
                                
                                <ul>
                                	<?php if (permiso_activo(10)){?>
                                    <li>
                                                <a id="acc_cursos_para" <? if ($Menu==201) echo 'class="active"'; ?> href="cursos_paralelo_main.php" title="Presione [Alt+P] para abrir">Cursos <span style='text-decoration: underline;'>P</span>aralelo</a> 
                                    </li>
                                    <?php }if (permiso_activo(62)){?>
                                     <li>
                                                <a id="acc_cursos_perm" <? if ($Menu==206) echo 'class="active"'; ?> href="cursos_notas_permisos_main.php" title="Presione [Alt+N] para abrir"><span style='text-decoration: underline;'>N</span>otas Permisos</a> 
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
                            <a id="acc_admin" data-toggle="collapse" data-parent="#accordion" href="#administracion" class="collapsed" onclick="close_others(this.id);" title="Presione [Alt+D] para abrir">
                              <span class="icon-parent icon"></span>
                            <div class="text"><h4>A<span style='text-decoration: underline;'>d</span>ministracion</h4></div>
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
                                            <a id="acc_admin_peri" <? if ($Menu==403) echo 'class="active"'; ?>   href="admin_periodos.php" title="Presione [Alt+P] para abrir"><span style='text-decoration: underline;'>P</span>eriodos</a> 
                                </li>
                                <!-- <?php }if (permiso_activo(18)){?>
                              <li>
                                            <a <? if ($Menu==404) echo 'class="active"'; ?>   href="admin_parametos.php">Parametros Generales</a> 
                              </li> -->
                              <?php }if (permiso_activo(19)){?>
                                <li>
                                            <a <? if ($Menu==405) echo 'class="active"'; ?>   href="admin_auditoria.php">Auditoria</a> 
                                </li>
                                <?php }if (permiso_activo(20)){?>
                                <li>
                                            <a <? if ($Menu==406) echo 'class="active"'; ?>   href="admin_permisos.php">Permisos</a> 
                                </li>
                                <?php }?>
                                <?php if (permiso_activo(86)){?>
                                <li>
                                            <a <? if ($Menu==409) echo 'class="active"'; ?>   href="importacion_datos.php">Importación de datos</a> 
                                </li>
                                <?php }?>
                                <?php if (permiso_activo(84)){?>
                                <li>
                                            <a id="acc_admin_para_sist" <? if ($Menu==410) echo 'class="active"'; ?>   href="para_sistema_main.php" title="Presione [Alt+S] para abrir">Parámetros del <span style='text-decoration: underline;'>S</span>istema</a> 
                                </li>
                                <?php }?>
                                <?php if (permiso_activo(87)){?>
                                <li>
                                            <a <? if ($Menu==411) echo 'class="active"'; ?>   href="usua_pass_main.php">Usuarios y Claves</a> 
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
                            <a id="acc_repo" data-toggle="collapse" data-parent="#accordion" href="#reportes" class="collapsed" onclick="close_others(this.id);" title="Presione [Alt+R] para abrir">
                              <span class="icon-print icon"></span>
                            <div class="text"><h4><span style='text-decoration: underline;'>R</span>eportes</h4></div>
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
                              	<a id="acc_repo_gene" <? if ($Menu==606) echo 'class="active"'; ?>   href="report_gene.php" title="Presione [Alt+G] para abrir">Reportes <span style='text-decoration: underline;'>G</span>enerales</a> 
                              </li>
                               <?php if (permiso_activo(76)){?>
                                <li>
                                  <a id="acc_repo_acta"<? if ($Menu==607) echo 'class="active"'; ?>   href="report_gene_actas.php" title="Presione [Alt+S] para abrir">Acta<span style='text-decoration: underline;'>s</span></a> 
                                </li>
                                <?php }?>
                            </ul>
                            
                            
                            
                          </div>
                        </div>
                      </div>
					</li>
			 		<?php }?>
                    
					<li>
            <a id="acc_mens" href="mensajes.php" class='section_califications link_menu <? if ($Menu==700) echo 'active'; ?>' title="Presione [Alt+M] para abrir">
              <span class="icon-envelope  icon"></span>
              <div class="text"><h4><span style='text-decoration: underline;'>M</span>ensajes</h4></div>  
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