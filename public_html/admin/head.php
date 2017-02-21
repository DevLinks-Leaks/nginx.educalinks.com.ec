<?php 
	//Set no cachinh
    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
    header("Cache-Control: no-store, no-cache, must-revalidate"); 
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    
	session_start(); 
    
    include ('../framework/funciones.php');
    include ('../framework/lenguaje.php');
    //Valida la Sesion este activa
    session_activa(1); 
     
    include ('../framework/dbconf.php');

    $rand = rand().rand();

    $inactivo = $_SESSION['session_timeout'];
    if(isset($_SESSION['tiempo']) ) {
        $vida_session = time() - $_SESSION['tiempo'];
        if($vida_session > $inactivo){
            session_destroy();
            header("Location: index.php"); 
        }
    }
    $_SESSION['tiempo'] = time();
    
    
?>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>Educalinks | <?php echo para_sist(2); ?></title> 
        <link rel="SHORTCUT ICON" href="http://108.179.196.99/educalinks/imagenes/logo_icon.png"/>
        <!--<link href="../theme/css/base/bootstrap-combined.min.css?<?= $rand?>" rel="stylesheet" type="text/css" >-->
		<link href="../theme/css/base/dataTables.bootstrap.css" rel="stylesheet" type="text/css" >
		<link href="../theme/css/main.css?<?= $rand?>" media="screen" rel="stylesheet" type="text/css">
        <link href="../theme/css/print.css?<?= $rand?>" media="print" rel="stylesheet" type="text/css">
        <!-- <link href="../framework/ckeditor/sample.css?<?= $rand?>" rel="stylesheet">    -->
        <link href="../theme/jquery1_11/jquery-ui.css" rel="stylesheet">
		<link href="../theme/jquery1_11/external/jquery/jquery_growl/stylesheets/jquery.growl.css" rel="stylesheet" type="text/css" />
        <link href="../theme/jquery1_11/external/jquery/jquery_bonsai/jquery.bonsai.css" rel="stylesheet" type="text/css" />
        <script src="../theme/js/modernizr.custom.js"></script>
        <script src="../theme/jquery1_11/external/jquery/jquery.js"></script>
        <script src="../theme/js/bootstrap.js"></script>
        <script src="../theme/js/moment.min.js"></script>
        <script src="../theme/js/effects.js"></script>
        <script src="../theme/jquery1_11/jquery-ui.js"></script>
        <script src="../theme/jquery1_11/external/jquery/jquery_growl/javascripts/jquery.growl.js" type="text/javascript"></script>
        <script src="../theme/jquery1_11/external/jquery/jquery_bonsai/jquery.bonsai.js" type="text/javascript"></script>
        <script src="../theme/jquery1_11/external/jquery/jquery_bonsai/jquery.qubit.js" type="text/javascript"></script>

        <script type="text/javascript" language="javascript" src="../theme/js/dataTables.bootstrap.js"></script>
        <script type="text/javascript" language="javascript" src="../theme/js/datatable.js"></script>

        <script type="text/javascript" src="../framework/funciones.js?<?= $rand?>"></script>
	    <script src="../framework/funciones_mensajes.js?<?= $rand?>"></script> 
    	<script src="../framework/ckeditor/ckeditor.js"></script>
        
        <script type="text/javascript" src="js/funciones_alum.js?<?= $rand?>"></script>
        <script type="text/javascript" src="js/funciones_alumnos_blacklist.js?<?= $rand?>"></script> 
        <script type="text/javascript" src="js/funciones_alum.js?<?= $rand?>"></script>
        <script type="text/javascript" src="js/funciones_repre.js?<?= $rand?>"></script>