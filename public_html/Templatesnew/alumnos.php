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

session_activa(3);
?>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <title>Educalinks | <?php echo para_sist(2); ?></title> 

  <link rel="SHORTCUT ICON" href="http://108.179.196.99/educalinks/imagenes/logo_icon.png"/>

        <!--
        <link href="../theme/css/base/bootstrap-combined.min.css" rel="stylesheet" type="text/css" >
		<link href="../theme/css/base/dataTables.bootstrap.css" rel="stylesheet" type="text/css" >
    -->
    <link href="../theme/css/main.css" rel="stylesheet" type="text/css">
    <link href="../theme/css/color_schema.css" rel="stylesheet" type="text/css">

    <script src="../alumnos/js/posts.js"></script>
    <script src="../alumnos/js/agendas.js"></script>
    <script src="../framework/funciones.js"></script>
    <script src="../framework/funciones_mensajes.js"></script> 
    <script src="../framework/ckeditor/ckeditor.js"></script>
    <script src="../theme/js/modernizr.custom.js"></script>
    <script src="../theme/jquery1_11/external/jquery/jquery.js"></script>
    <script src="../theme/js/moment.min.js"></script>

    <link href="../framework/ckeditor/sample.css" rel="stylesheet">  
     
    <link href="../theme/jquery1_11/jquery-ui.css" rel="stylesheet">
    <script src="../theme/jquery1_11/jquery-ui.js"></script>

    <link href="../theme/jquery1_11/external/jquery/jquery_growl/stylesheets/jquery.growl.css" rel="stylesheet" type="text/css" />
    <link href="../theme/jquery1_11/external/jquery/jquery_bonsai/jquery.bonsai.css" rel="stylesheet" type="text/css" />
        <script src="../theme/jquery1_11/external/jquery/jquery_growl/javascripts/jquery.growl.js" type="text/javascript"></script>
        <script src="../theme/jquery1_11/external/jquery/jquery_bonsai/jquery.bonsai.js" type="text/javascript"></script>
        <script src="../theme/jquery1_11/external/jquery/jquery_bonsai/jquery.qubit.js" type="text/javascript"></script>
        
        <script type="text/javascript" language="javascript" src="../theme/js/dataTables.bootstrap.js"></script>
        <script type="text/javascript" language="javascript" src="../theme/js/datatable.js"></script>
<!--
    -->

    <script src="../theme/js/bootstrap.js"></script>
    <script src="../theme/js/jquery.easing.1.3.js"></script>
    <script src="../theme/js/jquery.fitvids.js"></script>
    <script src="../theme/js/jquery.bxslider-rahisified.js"></script>
    
    <!--
        -->
            <script src="../theme/js/effects.js"></script>
            <script src="../theme/js/select.js"></script>

        
        
        <!-- TemplateBeginEditable name="EditRegion5" --><!-- TemplateEndEditable -->
    </head>
    <body class="general admin textcolor_default">
        <!-- TemplateBeginEditable name="EditRegion3" --><?php  $Menu=101; ?><!-- TemplateEndEditable -->
        <div class="pageContainer ">


            <? session_start();include ('../framework/dbconf.php');?>



    



<div class="header  hidden-sm hidden-xs"> <!-- HEADER DESKTOP -->
   
        
        <div class="logo col-md-1 "> 
            <img src="<?= $_SESSION['ruta_foto_logo_web'];?>" title="Ir al Inicio">
        </div>
       



        <div class="userbar col-md-8">
            
            <?php if($_SESSION['USUA_TIPO']=='R'){?>

                <?php }?>
                
                    <ul class="nav navbar-nav ">
                        <li class="dropdown ">
                            <a class="user_button dropdown-toggle linkcolor_primary " href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"  >
                                                <?php
                                                if($_SESSION['USUA_TIPO']=='R'){
                                                    $ruta=$_SESSION['ruta_foto_usuario'].$_SESSION['repr_codi'].".jpg";
                                                }else{
                                                    $ruta=$_SESSION['ruta_foto_usuario'].$_SESSION['alum_codi'].".jpg";
                                                }
                                                $file_exi=$ruta;
                                                if (file_exists($file_exi)) {
                                                    $pp=$file_exi;
                                                } else {
                                                    $pp=$_SESSION['foto_default'];
                                                }
                                                ?>
                                        <div class="user">
                                        <div class="photo">
                                            <img src="<?php echo $pp;?>" />
                                        </div>
                                                
                                        <div class="data">
                                           
                                                 <?php 
                                                 if($_SESSION['USUA_TIPO']=='R'){
                                                    echo $_SESSION['repr_nomb']." ".$_SESSION['repr_apel']."</br>( ".$_SESSION['repr_usua']." )";
                                                }else{
                                                    echo $_SESSION['alum_nomb']." ".$_SESSION['alum_apel']."</br>( ".$_SESSION['alum_usua']." )";
                                                }?>
                                            
                                        </div>
                                        </div>
                                    </a>

                                    <ul class="dropdown-menu " id="user_options" role="menu" >
                                            <? 
                                            /*Pregunto si está activada la opción para cambiar fotos*/
                                            if (para_sist(21))
                                            {
                                                ?>
                                                <?php if($_SESSION['USUA_TIPO']=='R'){?><li><a href="../alumnos/admin_foto_repr.php"> <span class="li_pict">Cambiar foto</span></a></li><?php }else{?><li><a href="../alumnos/admin_foto.php"> <span class="li_pict">Cambiar foto</span></a></li><?php }?>

                                                <?
                                            }
                                            ?>
                                            <?php if($_SESSION['USUA_TIPO']=='R'){?>

                                            <li ><a href="../alumnos/admin_pass_repr.php"> <span class="li_pict">Cambiar password</span></a></li><?php }else{?><li><a href="../alumnos/admin_pass.php"> <span class="li_pict">Cambiar password</span></a></li><?php }?>
                                            <li role="separator hidden-md" class="divider"></li>
                                            <?php if($_SESSION['USUA_TIPO']=='R'){?>
                                            <li><a href="../alumnos/admin_info_repr.php"> <span class="li_pict">Ver Información</span></a></li><?php }
                                            else{?>
                                            <li><a href="../alumnos/admin_info.php"> <span class="li_pict">Ver Información</span></a></li><?php }?>
                                            <li class="visible-xs"><a href="../alumnos/mensajes.php"> <span class="li_pict">Mensajes</span></a></li></li>
                                            <li role="separator" class="divider"></li>
                                            <li><a href="../salir.php"><span class="li_logout">Cerrar Sesión</span></a></li>
                                    </ul>
                                </li>
                                <li>
                                    <?php include ('../framework/funciones_mensajes_script_new.php'); ?>
                                </li>
                            </ul>

        </div><!-- FIN USERBAR -->

        <div class="educalinks col-md-2 hidden-sm hidden-xs">
            <a href="http://redlinks.com.ec" target="_blank" title="Visítanos"> Visítanos</a>
        </div>
  


</div><!-- FIN HEADER DESKTOP -->



<div class="header  hidden-md hidden-lg" role="navigation">
<div class="container-fluid">
<div class="row movil">
    

    <a class="link" role="button" data-toggle="collapse" href="#collapseHeader" aria-expanded="false" aria-controls="collapseHeader">
        <div class="logo col-xs-4 "> 
            <img src="<?= $_SESSION['ruta_foto_logo_web'];?>" title="Ir al Inicio">
        </div>
        <div class="userbar">

            <?php
                if($_SESSION['USUA_TIPO']=='R'){
                    $ruta=$_SESSION['ruta_foto_usuario'].$_SESSION['repr_codi'].".jpg";
                }else{
                    $ruta=$_SESSION['ruta_foto_usuario'].$_SESSION['alum_codi'].".jpg";
                }
                $file_exi=$ruta;
                if (file_exists($file_exi)) {
                    $pp=$file_exi;
                } else {
                    $pp=$_SESSION['foto_default'];
                }
            ?>
            <div class="user">
                <div class="photo hidden-xs">
                    <img src="<?php echo $pp;?>" />
                </div>
                                                
                <div class="data">
                                           
                            <?php 
                            if($_SESSION['USUA_TIPO']=='R'){
                                                    echo $_SESSION['repr_nomb']." ".$_SESSION['repr_apel']."</br>( ".$_SESSION['repr_usua']." )";
                        }else{
                                                    echo $_SESSION['alum_nomb']." ".$_SESSION['alum_apel']."</br>( ".$_SESSION['alum_usua']." )";
                        }?>
                                            
                </div>
            </div>
        </div><!-- FIN USERBAR -->
    </a>


        
        

    <div class="panel-collapse collapse" id="collapseHeader">
        <ul class="nav navbar-nav ">
            <? 
            /*Pregunto si está activada la opción para cambiar fotos*/
            if (para_sist(21))
            {
                ?>
                <?php if($_SESSION['USUA_TIPO']=='R'){?><li><a href="../alumnos/admin_foto_repr.php"> <span class="li_pict">Cambiar foto</span></a></li><?php }else{?><li><a href="../alumnos/admin_foto.php"> <span class="li_pict">Cambiar foto</span></a></li><?php }?>

                <?
            }
            ?>
            <?php if($_SESSION['USUA_TIPO']=='R'){?>

            <li ><a href="../alumnos/admin_pass_repr.php"> <span class="li_pict">Cambiar password</span></a></li><?php }else{?><li><a href="../alumnos/admin_pass.php"> <span class="li_pict">Cambiar password</span></a></li><?php }?>
            <li role="separator hidden-md" class="divider"></li>
            
            <?php if($_SESSION['USUA_TIPO']=='R'){?>
            <li><a href="../alumnos/admin_info_repr.php"> <span class="li_pict">Ver Información</span></a></li>
            <?php } else {?>
                <li><a href="../alumnos/admin_info.php"> <span class="li_pict">Ver Información</span></a></li>
            <?php }?>
            
            <li ><a href="../alumnos/mensajes.php"> <span class="li_pict">Mensajes</span></a></li></li>
            <li role="separator" class="divider"></li>
            <li><a href="../salir.php"><span class="li_logout">Cerrar Sesión</span></a></li>
        </ul>
                                        
    </div>


</div>
</div>
</div>



<div class="section_menu">
   
        


    <nav class="navbar navbar-default">
                <div class="container-fluid">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-header">
                      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar_movil" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                      </button>
                      <a class="user navbar-brand visible-xs" href="#">
                        Páginas
                                       
                      </a>
                    </div>

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse hidden-md" id="navbar_movil">
                  
    <ul class="nav navbar-nav ">
        <li role="presentation" <? if ($Menu==0) { echo 'class="active background_link_default"';} else { echo' class="link_menu"'; } ?> >
            <a href="index.php"  class="active"  alt="Ir al inicio"> 
                <div class="text">Inicio</div>
            </a>
        </li>

        <li role="presentation" <?  if ($Menu==2) { echo 'class="active"';} else { echo' class="link_menu"'; } ?>>
            <a href="agen_main.php"   class="link_menu" alt="Ir a las agendas">
                <div class="text">Agenda</div>
            </a>
        </li>

        <li role="presentation" <?  if ($Menu==3) { echo 'class="active"';} else { echo' class="link_menu"'; } ?>>
            <a href="clases.php"   class="link_menu" alt="Ir a las clases">
                <div class="text">Clases</div>
            </a>
        </li>

        <li role="presentation" <?  if ($Menu==4) { echo 'class="active"';} else { echo' class="link_menu"'; } ?>>
            <a href="notas.php"   class="link_menu" alt="Ir a las notas">
                <div class="text">Notas</div>
            </a>
        </li>

        <?php if($_SESSION['USUA_TIPO']=='R'){
            if (para_sist(402))
                {?>
            <li role="presentation" <?  if ($Menu==5) { echo 'class="active"';} else { echo' class="link_menu"'; } ?> >

                <a href="citas.php"   class="link_menu" alt="Ir a las citas">
                    <div class="text">Citas</div>
                </a>
            </li>
            <?php   }
        }?>
        <?php if($_SESSION['USUA_TIPO']=='R'){?>
        <li role="presentation" <?  if ($Menu==6) { echo 'class="active"';} else { echo' class="link_menu"'; } ?>>
            <a href="observaciones_main.php"   class="link_menu" alt="Ir a las observaciones">
                <div class="text">Observaciones</div>
            </a>
        </li>
        <?php }?>

        <li role="presentation">
            <a href="#" class="section_califications link_menu" alt="Ver la Ayuda">

                <div class="text">Ayuda</div> 
            </a>
        </li>

    </ul>
                            
                                
                                
                            
                    </div><!-- /.navbar-collapse -->
                </div><!-- /.container-fluid -->
     </nav>


            


        


</div> <!--FIN DE MENU -->










<section class="current">
    <!-- Alumnos: -->
    <select 
    id="alum_sel" 
    name="alum_sel" 
    onChange="set_repr_alum(this.value,'<?=$_SESSION['repr_codi']?>')"
    class="form_element">
    <?php 
    $params2 = array($_SESSION['repr_codi'],$_SESSION['peri_codi']);
    $sql2="{call repr_alum_info_princ_usua(?,?)}";
    $resu_alum_info = sqlsrv_query($conn, $sql2, $params2);  
    while($row_resu_alum_info = sqlsrv_fetch_array($resu_alum_info)){
        ?>
        <option value="<?=$row_resu_alum_info['alum_codi']?>" <?php if($row_resu_alum_info['alum_codi']==$_SESSION['alum_codi']){echo "selected='selected'";} ?>><?=$row_resu_alum_info['alum_apel']." ".$row_resu_alum_info['alum_nomb']?></option>
        <?php 
    }?>
</select>
</section>


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


</html>