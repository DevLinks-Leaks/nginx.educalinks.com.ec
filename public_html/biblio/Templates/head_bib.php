
 <?php 
    
	session_start(); 
    
    include ('../framework/funciones.php');
    //Valida la Sesion este activa
    session_activa(); 
     
    include ('../framework/dbconf.php');
   

	
?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Gustavo Decker">
    <link rel="icon" href="../imagenes/favicon.png">
    <title>Educalinks | Biblio |  <?php echo para_sist(2); ?></title>
    <!-- Latest compiled and minified CSS 
    <link href="bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css"/>-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <!-- Optional theme 
    <link href="bootstrap/css/bootstrap-theme.css" rel="stylesheet" type="text/css"/>-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
    <link href="css/theme.css" rel="stylesheet">
    <link href="bootstrap/css/bootstrap-datepicker3.css" rel="stylesheet" type="text/css"/>
    <link href="//cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/build/css/bootstrap-datetimepicker.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/r/bs/dt-1.10.8,af-2.0.0,b-1.0.1,b-colvis-1.0.1,b-print-1.0.1,cr-1.2.0,fc-3.1.0,fh-3.0.0,kt-2.0.0,r-1.0.7,rr-1.0.0,sc-1.3.0,se-1.0.0/datatables.min.css"/>
</head>
