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

    $rand = rand().rand();
?> 
   
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="Expires" content="0"> 
        <meta http-equiv="Pragma" content="no-cache">
        <title>Educalinks | <?= para_sist(2); ?></title> 
        
        <link rel="SHORTCUT ICON" href="http://108.179.196.99/educalinks/imagenes/logo_icon.png"/>
        <!-- <link href="../theme/css/base/bootstrap-combined.min.css?<?= $rand?>" rel="stylesheet" type="text/css" > -->
        <link href="../theme/css/base/dataTables.bootstrap.css" rel="stylesheet" type="text/css" >
        <link href="../theme/css/main.css?<?= $rand?>" rel="stylesheet" type="text/css">
        <link href="../theme/css/print.css?<?= $rand?>" media="print" rel="stylesheet" type="text/css">
        <!-- <link href="../framework/ckeditor/sample.css" rel="stylesheet">    -->
        <link href="../theme/jquery1_11/jquery-ui.css" rel="stylesheet">
        <link href="../theme/jquery1_11/external/jquery/jquery_growl/stylesheets/jquery.growl.css" rel="stylesheet" type="text/css" />
        <link href="../theme/jquery1_11/external/jquery/jquery_bonsai/jquery.bonsai.css" rel="stylesheet" type="text/css" />
         
        <script type="text/javascript" src="../framework/funciones.js?<?= $rand?>"></script>
        <script src="../framework/funciones_mensajes.js?<?= $rand?>"></script> 
        <script src="../framework/ckeditor/ckeditor.js"></script>
        <script src="../theme/js/modernizr.custom.js"></script>
        <script src="../theme/jquery1_11/external/jquery/jquery.js"></script>
        <script src="../theme/js/bootstrap.js"></script>
        <script src="../theme/js/moment.min.js"></script>
        <script src="js/posts.js?<?= $rand?>"></script>
        <script src="js/agenda.js?<?= $rand?>"></script>
    
        <script src="../theme/js/effects.js"></script>
        <script src="../theme/jquery1_11/jquery-ui.js"></script>
        <script src="../theme/jquery1_11/external/jquery/jquery_growl/javascripts/jquery.growl.js" type="text/javascript"></script>
        <script src="../theme/jquery1_11/external/jquery/jquery_bonsai/jquery.bonsai.js" type="text/javascript"></script>
        <script src="../theme/jquery1_11/external/jquery/jquery_bonsai/jquery.qubit.js" type="text/javascript"></script>
        
        <script type="text/javascript" language="javascript" src="../theme/js/dataTables.bootstrap.js"></script>
        <script type="text/javascript" language="javascript" src="../theme/js/datatable.js"></script>
        
        
        <!-- InstanceBeginEditable name="EditRegion5" -->
        <link href="../theme/jquery1_11/jquery-ui.css" rel="stylesheet">
        <link href="../theme/jquery1_11/external/jquery/jquery_growl/stylesheets/jquery.growl.css" rel="stylesheet" type="text/css" />
        <!-- InstanceEndEditable -->
    