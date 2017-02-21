<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml"
xmlns:og="http://ogp.me/ns#"
xmlns:fb="http://www.facebook.com/2008/fbml">
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
								 
	session_activa(2);
?> 
   
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="Expires" content="0"> 
        <meta http-equiv="Pragma" content="no-cache">
		<title>Educalinks | <?= para_sist(2); ?></title> 
        
        <link rel="SHORTCUT ICON" href="http://108.179.196.99/educalinks/imagenes/logo_icon.png"/>
        <link href="../theme/css/base/bootstrap-combined.min.css" rel="stylesheet" type="text/css" >
		<link href="../theme/css/base/dataTables.bootstrap.css" rel="stylesheet" type="text/css" >
		<link href="../theme/css/main.css" rel="stylesheet" type="text/css">
    	<link href="../theme/css/print.css" media="print" rel="stylesheet" type="text/css">
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
        <script src="../docentes/js/posts.js"></script>
        <script src="../docentes/js/agendas.js"></script>
    
        <script src="../theme/js/effects.js"></script>
        <script src="../theme/jquery1_11/jquery-ui.js"></script>
        <script src="../theme/jquery1_11/external/jquery/jquery_growl/javascripts/jquery.growl.js" type="text/javascript"></script>
        <script src="../theme/jquery1_11/external/jquery/jquery_bonsai/jquery.bonsai.js" type="text/javascript"></script>
        <script src="../theme/jquery1_11/external/jquery/jquery_bonsai/jquery.qubit.js" type="text/javascript"></script>
        
        <script type="text/javascript" language="javascript" src="../theme/js/dataTables.bootstrap.js"></script>
        <script type="text/javascript" language="javascript" src="../theme/js/datatable.js"></script>
        
        
		<!-- TemplateBeginEditable name="EditRegion5" --><!-- TemplateEndEditable -->
	</head>
	<body class="general admin">
								<!-- TemplateBeginEditable name="EditRegion3" --><?php  $Menu=101; ?><!-- TemplateEndEditable -->
		<div class="pageContainer"> 

		
 
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
                
                <li>
                    <a href="agenda.php"  <?  if ($Menu==2) { echo 'class="active"';} else { echo' class="link_menu"'; } ?> class="link_menu" alt="Ir a las agendas">
                        <span class="icon-calendar icon"></span>
                        <div class="text"><h4>Agenda</h4></div>
                    </a>
                </li>
                
                <li>
                    <a href="clases.php"  <?  if ($Menu==3) { echo 'class="active"';} else { echo' class="link_menu"'; } ?> class="link_menu" alt="Ir a las clases">
                        <span class="icon-book icon"></span>
                        <div class="text"><h4>Clases</h4></div>
                    </a>
                </li>
                     
                
                <li>
                    <a href="notas.php"  <?  if ($Menu==4) { echo 'class="active"';} else { echo' class="link_menu"'; } ?> class="link_menu" alt="Ir a las notas">
                        <span class="icon-briefcase icon"></span>
                        <div class="text"><h4>Notas</h4></div>
                    </a>
                </li>
                <?
                if ($_SESSION['es_tutor'])
				{
                ?>
                 <li>
                    <a href="tutor.php"  <?  if ($Menu==7) { echo 'class="active"';} else { echo' class="link_menu"'; } ?> class="link_menu" alt="Ir a las notas">
                        <span class="icon-briefcase icon"></span>
                        <div class="text"><h4>Tutor</h4></div>
                    </a>
                </li>
                <?
				}
				?>
                <li>
                    <a href="hora_aten_repr_listas_main.php"  <?  if ($Menu==5) { echo 'class="active"';} else { echo' class="link_menu"'; } ?> class="link_menu" alt="Ir a las notas">
                        <span class="icon-clock icon"></span>
                        <?php
                            $params = array($_SESSION['prof_codi']);
                            $sql="{call citas_prof_cont(?)}";
                            $citas_prof_info = sqlsrv_query($conn, $sql, $params);  
                            $row_citas_prof_info = sqlsrv_fetch_array($citas_prof_info);
                        ?>
                        <div class="text"><h4>Citas ( <?=$row_citas_prof_info['cant'];?> )</h4></div>
                    </a>
                </li>
                
                <li>
                    <a href="observaciones.php"  <?  if ($Menu==6) { echo 'class="active"';} else { echo' class="link_menu"'; } ?> class="link_menu" alt="Ir a las notas">
                        <span class="icon-eye icon"></span>
                        <div class="text"><h4>Observaciones</h4></div>
                    </a>
                </li>
            
                
                <li>
                    <a href="../help/MANUAL_DOCENTE.pdf" target="_blank" class="section_califications link_menu" alt="Ver Calificaciones">
                        <span class="icon-signup  icon"></span>
                        <div class="text"><h4>Ayuda</h4></div> 
                    </a>
                </li>
              
            </ul>



			</div> 

			<div  id="mainPanel"  class="section_main">
            
            <div class="header">
                <a id="btn" href="#" > <span class=" icon-menu"> </span> Mostrar / Ocultar Menú</a> 


                <div class="userbar dropdown">

                 <ul>
                    <li class="userProfile">
                      <a class="profile" href="#" data-toggle="dropdown"  >
                        <?php
                        $ruta=$_SESSION['ruta_foto_usuario'].$_SESSION['prof_codi'].".jpg";
                        $file_exi=$ruta;
                        if (file_exists($file_exi)) {
                            $pp=$file_exi;
                        } else {
                            $pp=$_SESSION['foto_default'];
                        }
                        ?>

                        <div class="photo">
                        <img src="<?php echo $pp;?>" style="height:60px; width:60px;" />

                       </div>
                       <div class="username">
                           <h5>Bienvenido,</h5>
                           <?= $_SESSION['prof_nomb']; ?> <?= $_SESSION['prof_apel']; ?> 
                       </div>

                   </a>
                   <ul class="dropdown-menu" role="menu" >
                     <li><a href="../docentes/admin_foto.php"> <span class="li_pict">Cambiar foto</span></a></li>								
                     <li><a href="../docentes/admin_pass.php"> <span class="li_pass">Cambiar password</span></a></li>
                     <li><a href="../docentes/admin_info.php"> <span class="li_user">Ver Información</span></a></li>
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
				

				<div class="main sectionBorder">
					<div id="information">
          
          <div class="titleBar">
          <!-- TemplateBeginEditable name="Titulo Top" -->

            <!-- TemplateEndEditable -->
          </div>
          
                        <!-- TemplateBeginEditable name="information" -->
                        
                        <!-- TemplateEndEditable -->
                    </div>
				</div>
			</div>

	
	</div>
    
    
    <input name="mens_de"  		type="hidden" id="mens_de" 		value='<?php echo $_SESSION['USUA_DE'];  ?>'    />
 	<input name="mens_de_tipo"  type="hidden" id="mens_de_tipo" value='<?php echo $_SESSION['USUA_TIPO']; ?>'    />
    
<!-- TemplateBeginEditable name="EditRegion4" --><!-- TemplateEndEditable -->
</body>

<script>

var myVar=setInterval(function () {myTimer()}, 120000);


</script>
</html>