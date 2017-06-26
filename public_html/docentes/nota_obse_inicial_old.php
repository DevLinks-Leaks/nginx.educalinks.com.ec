<?php
	session_start();	 
	include ('../framework/dbconf.php');
    include ('../framework/funciones.php');
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Educalinks |  <?php echo para_sist(2); ?></title> 
    <link rel="SHORTCUT ICON" href="../imagenes/favicon.png"/>

    <link href="../theme/css/main.css" rel="stylesheet" type="text/css"> 
    <link href="../theme/css/print.css" media="print" rel="stylesheet" type="text/css">
    <link href="../theme/jquery1_11/external/jquery/jquery_growl/stylesheets/jquery.growl.css" rel="stylesheet" type="text/css" />
  <script src="../framework/funciones.js"></script>
    <script src="js/notasv2.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js" type="text/javascript"></script>
    <script src="../theme/jquery1_11/external/jquery/jquery_growl/javascripts/jquery.growl.js" type="text/javascript"></script>
<style>
  	@page 
  	{  
  		size: A4 portrait;  
		margin: 0.5cm;
	}  
</style>
</head>
<body>
<div>
  <iframe style="width:100%;height: 400px;" src="../admin/libretas/<?=$_SESSION['directorio']?>/<?=$_SESSION['peri_codi']?>/lib_ini_one.php?peri_dist_codi=<?=$_GET['peri_dist_codi']?>&curs_para_codi=<?=$_GET['curs_para_codi']?>&alum_codi=<?=$_GET['alum_codi']?>"></iframe>
 </div>
 <?
  
    //Observaciones del estudiante
    $sql_obs="{call nota_obse_view(?,?)}";
    $params_obs = array($row_alum_info['alum_codi'], $_GET['peri_dist_codi']);
    $stmt_obs = sqlsrv_query($conn, $sql_obs, $params_obs);
  
    if( $stmt_obs === false )
    {
      echo "Error in executing statement .\n";
      die( print_r( sqlsrv_errors(), true));
    }
    $observaciones=sqlsrv_fetch_array($stmt_obs);
    ?>
        <div style="border: 1px solid #999; height: 100px; margin-top: 15px;">
            <textarea
              id="txt_observacion" 
              style="width: 100%; height: 100px; background-color:#FFFF99; resize: none;" 
                placeholder="Ingrese una observación"><?= $observaciones['nota_obse_deta']; ?></textarea>
        </div>
        <button 
          class="btn btn-primary"
            onClick="GuardarObs(<?= $_GET['peri_dist_codi']?>, <?= $_GET['alum_codi']?>, document.getElementById('txt_observacion').value)"
            style="margin: 10px 0px;"><span class="icon-disk "></span> Guardar
    </button>
        <button 
          class="btn btn-primary"
            onClick="window.history.go(-1);"
            style="margin: 10px 0px;"><span class="icon-arrow-left"></span> Regresar
    </button>
</body>
</html>