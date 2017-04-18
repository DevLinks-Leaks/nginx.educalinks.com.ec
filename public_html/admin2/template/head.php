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
    include ('../framework/lenguaje.php');
    //Valida la Sesion este activa
    session_activa(1); 
	
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

    $rand = rand().rand();
?>
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<title>Educalinks | <?= para_sist(2); ?></title>
	
	<link href="../../includes/common/jquery/jquery-ui/jquery-ui.css" rel="stylesheet">
    <link rel="stylesheet" href="../../includes/common/plugins/daterangepicker/daterangepicker-bs3.css">
	<link rel="stylesheet" href="../../includes/common/plugins/datepicker/datepicker3.css" />
	<link rel="shortcut icon" href="{ruta_imagenes_common}/favicon.png" />
	<link href="../../includes/common/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">
	<link href="../../includes/common/plugins/datatables/jquery.dataTables.min.css?" rel="stylesheet">
	<link href="https://cdn.datatables.net/buttons/1.1.2/css/buttons.dataTables.min.css" rel="stylesheet">
	
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="../../includes/common/bootstrap/css/bootstrap.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../includes/common/dist/css/AdminLTE.min.css?<?= $rand?>">
	<!-- Select 2 -->
    <link rel="stylesheet" href="../../includes/common/plugins/select2/select2.min.css">
	
	<link href="//cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/build/css/bootstrap-datetimepicker.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/r/bs/dt-1.10.8,af-2.0.0,b-1.0.1,b-colvis-1.0.1,b-print-1.0.1,cr-1.2.0,fc-3.1.0,fh-3.0.0,kt-2.0.0,r-1.0.7,rr-1.0.0,sc-1.3.0,se-1.0.0/datatables.min.css"/>   
    <!-- fullCalendar 2.2.5-->
    <link rel="stylesheet" href="../includes/common/plugins/fullcalendar/fullcalendar.min.css">
    <link rel="stylesheet" href="../includes/common/plugins/fullcalendar/fullcalendar.print.css" media="print">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="../../includes/common/dist/css/skins/_all-skins.min.css?<?= $rand?>">
    <!-- iCheck -->
    <link rel="stylesheet" href="../../includes/common/plugins/iCheck/flat/blue.css">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>