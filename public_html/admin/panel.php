<!DOCTYPE html>
<html><!-- InstanceBegin template="/Templates/admin_panel.dwt" codeOutsideHTMLIsLocked="false" -->
<?php
	//Set no cachinh
    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
    header("Cache-Control: no-store, no-cache, must-revalidate"); 
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    
	session_start();
    include ('../framework/dbconf.php');
    include ('../framework/funciones.php');
								 
	session_activa();
?>
		
	 
    
       
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>Ingenium | UEMAG</title> 
        <link rel="SHORTCUT ICON" href="http://186.101.64.250/ingeniumacad/imagenes/logo_icon.png"/>
        
        
        <link href="../theme/css/base/bootstrap-combined.min.css" rel="stylesheet" type="text/css" >
		<link href="../theme/css/base/dataTables.bootstrap.css" rel="stylesheet" type="text/css" >
		<link href="../theme/css/main.css" rel="stylesheet" type="text/css">
        <link href="../framework/ckeditor/sample.css" rel="stylesheet">   
        <link href="../theme/jquery1_11/jquery-ui.css" rel="stylesheet">
		<link href="../theme/jquery1_11/external/jquery/jquery_growl/stylesheets/jquery.growl.css" rel="stylesheet" type="text/css" />
        <link href="../theme/jquery1_11/external/jquery/jquery_bonsai/jquery.bonsai.css" rel="stylesheet" type="text/css" />
         
        
        <script src="../framework/funciones.js"></script>
	    <script src="../framework/funciones_mensajes.js"></script> 
    	<script src="../framework/ckeditor/ckeditor.js"></script>
        <script src="../theme/js/modernizr.custom.js"></script>
		<script src="../theme/jquery1_11/external/jquery/jquery.js"></script>
        <script src="../theme/js/bootstrap.js"></script>
        <script src="../theme/js/moment.min.js"></script>
        <script src="../theme/js/bootstrap-datetimepicker.js"></script>
        <script src="../theme/js/bootstrap-datetimepicker-lang-es.js"></script>
        <script src="../theme/js/classie.js"></script>
        <script src="../theme/js/effects.js"></script>
        <script src="../theme/jquery1_11/jquery-ui.js"></script>
        <script src="../theme/jquery1_11/external/jquery/jquery_growl/javascripts/jquery.growl.js" type="text/javascript"></script>
        <script src="../theme/jquery1_11/external/jquery/jquery_bonsai/jquery.bonsai.js" type="text/javascript"></script>
        <script src="../theme/jquery1_11/external/jquery/jquery_bonsai/jquery.qubit.js" type="text/javascript"></script>
        
        <script type="text/javascript" language="javascript" src="../theme/js/dataTables.bootstrap.js"></script>
        <script type="text/javascript" language="javascript" src="../theme/js/datatable.js"></script>
        
        
		<!-- InstanceBeginEditable name="EditRegion5" --><!-- InstanceEndEditable -->
	</head>
	<body class="general admin cbp-spmenu-push">
								<!-- InstanceBeginEditable name="EditRegion3" --><?php  $Menu=101; ?><!-- InstanceEndEditable -->
		<div class="pageContainer"> 

		
 
			<div class="section_side  cbp-spmenu-left cbp-spmenu-open" id="sidePanel">
            
            

       <section class="main">
        
        <div class="ingenium">
          <img src="../theme/images/logo_ingenium.png">
        </div>

        <div class="logo"> 
          <img src="<?= $_SESSION['ruta_foto_logo_web'];?>" alt="">
        </div>
        <h5>Unidad Educativa</h5>
        <h4>Maria Auxiliadora</h4>
      </section>
            	
				<? session_start();include ('../framework/dbconf.php');?>
				<ul class="menu_main">
					<li>
						<a href="index.php"  <? if ($Menu==0) { echo 'class="active"';} else { echo' class="link_menu"'; } ?> class="active"  alt="Ir al inicio"> 
							<span class="icon-home icon"></span>
							<div class="text"><h5>Inicio</h5></div>
						</a>
					</li>
                    <?php if (permiso_activo(1)){?>
                    <li>
                        <a href="mensajes.php"  <?  if ($Menu==1) { echo 'class="active"';} else { echo' class="link_menu"'; } ?> class="link_menu" alt="Ir al inicio">
                            <span class="icon-envelope icon"></span>
                            <div class="text"><h5>Mensajes</h5></div>
                        </a>
                    </li>
                    <?php }?>
                    <?php if (permiso_activo(2)){?>
                    <li>
                    <div class=" panel-menu">
                        <div class="panel-heading ">
                          <h4 class="panel-title">
                            <a data-toggle="collapse"  data-parent="#accordion" href="#alumnos" class="collapsed">
                              <span class="icon-users icon"></span>
                            <div class="text"><h5>Alumnos</h5></div>
                            </a>
                          </h4>
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
                              <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#cursos" class="collapsed" >
                                  <span class="icon-books icon"></span>
                                <div class="text"><h5>Cursos</h5></div>
                                </a>
                              </h4>
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
                          <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#administracion" class="collapsed">
                              <span class="icon-parent icon"></span>
                            <div class="text"><h5>Administracion</h5></div>
                            </a>
                          </h4>
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
                          <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#reportes" class="collapsed">
                              <span class="icon-print icon"></span>
                            <div class="text"><h5>Reportes</h5></div>
                            </a>
                          </h4>
                        </div>
                        <div id="reportes" class="panel-collapse collapse <? if (substr($Menu,0,1)<>6)  echo 'in'; ?> ">
                          <div class="panel-body">
                            <ul>
                              <li>
                              	<a <? if ($Menu==601) echo 'class="active"'; ?>   href="reportes_main.php">Reportes Administrativos</a> 
                              </li>
                            </ul>
                            
                            
                            
                          </div>
                        </div>
                      </div>
					</li>
			 		<?php }?>
                    <?php if (permiso_activo(5)){?>
					<li>
						<a href="#" class="section_califications link_menu" alt="Ver Calificaciones">
							<span class="icon-signup  icon"></span>
							<div class="text"><h5>Ayuda</h5></div> 
						</a>
					</li>
                    <?php }?>
				</ul>



			</div> 

			<div id="mainPanel" class="section_main">
            
            <div class="header">
                <span class=" icon-menu"></span><a href="#" class="hideMenu">Ocultar menu</a>
                <div class="userbar dropdown">
						
							<ul>
								<li class="userProfile">
										<a class="profile" href="#" data-toggle="dropdown"  >
										
												<div class="photo">
													<img src="../fotos/admin/admin.jpg" alt="user" style=" height:60px; width:60px;">
												</div>
												<div class="username">
													<h5>Bienvenido,</h5>
													<?= $_SESSION['usua_nomb']; ?> <?= $_SESSION['usua_apel']; ?> <b>(<?= $_SESSION['usua_codi']; ?></b>)
												</div>
											
										</a>
										<ul class="dropdown-menu" role="menu" >
											<li><a href="admin_foto.php"> <span class="li_pict">Cambiar foto</span></a></li>								
											<li><a href="admin_pass.php"> <span class="li_pass">Cambiar password</span></a></li>
											<li><a href="admin_info.php"> <span class="li_user">Ver Información</span></a></li>
											<li><a href="../salir.php"><span class="li_logout">Cerrar Sesión</span></a></li>

										</ul>
									</li>

								<li class="userButtons">
                                	<ul>
                                    <li>
								 
											<div id="mens_alert" >
											<?php include ('script_mens_view.php'); ?>
                                       		</div>
                                       
										
									 
                                    </li>
                                    </ul>
								</li>
							</ul>
						
								
	
								

								
						</div>
            </div>
				
<!--
        <div class="optionbar">
        <span class="icon-earth icon"></span><span>Su ubicación:</span>
               <nav class="menu_breadcrumb">
                  <ul>
                    
                    <li><a href="">Inicio</a></li>
                    <li><a href="" class="active">CurrentPage</a></li>
                  </ul>
               </nav>
        </div>
-->
				<div class="main sectionBorder">
					<div id="information">
          
          <div class="titleBar">
          <!-- InstanceBeginEditable name="Titulo Top" -->

            <!-- InstanceEndEditable -->
          </div>
          
                        <!-- InstanceBeginEditable name="information" -->
                       <div id="btnMenu">
                        <a id="btn" href="#" >Mostrar / Ocultar Menu</a> 
  
                        
                        </div>
   
                        <!-- InstanceEndEditable -->
                    </div>
				</div>
			</div>

	
	</div>
    
    
    <input name="mens_de"  		type="hidden" id="mens_de" 		value='<?php echo $_SESSION['USUA_DE'];  ?>'    />
 	<input name="mens_de_tipo"  type="hidden" id="mens_de_tipo" value='<?php echo $_SESSION['USUA_TIPO']; ?>'    />
    
<!-- InstanceBeginEditable name="EditRegion4" --><!-- InstanceEndEditable -->
</body>

<script>

var myVar=setInterval(function () {myTimer()}, 120000);


</script>
<!-- InstanceEnd --></html>