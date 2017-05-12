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
        <link rel="SHORTCUT ICON" href="../imagenes/logo_icon.png"/>
        <link href="../theme/css/main.css" rel="stylesheet" type="text/css"> 
   		<link href="../theme/css/print.css" media="print" rel="stylesheet" type="text/css">
	  
<style>
	@page 
	{  
		size: A4 portrait;  
	}  
	@media all 
	{
		.page-break	
		{ 
			display: none; 
		}
	}

	@media print 
	{
		.page-break	
		{ 
			display: block;
			page-break-before: always; 
		}
	}
</style> 
</head>
<body>

 

 
 <?php 	
 
	if(isset($_GET['curs_para_codi'])){
		$curs_para_codi=$_GET['curs_para_codi'];
	}
	
	if(isset($_POST['curs_para_codi'])){
		$curs_para_codi=$_POST['curs_para_codi'];
	}
	

	$params = array($curs_para_codi);
	$sql="{call curs_para_prof_alums_view(?)}";
	$alum_curs_para_view = sqlsrv_query($conn, $sql, $params);  
	$cc = 0;
	
	$params = array($curs_para_codi);
	$sql="{call curs_peri_info(?)}";
	$curs_peri_info = sqlsrv_query($conn, $sql, $params); 
	$row_curs_peri_info = sqlsrv_fetch_array($curs_peri_info)
?>
<page>
	<div  class="lista" >
	<div class="header_institution">
        <div class="institution">
          <div class="image">
            <img src="<?= $_SESSION['ruta_foto_logo_libreta']; ?>">
          </div>
          <div class="name" style="padding-left: 25px;">
                  <h4> <strong> UNIDAD EDUCATIVA <?= $_SESSION['cliente']; ?> </strong></h4>
                  <h4>NÓMINA DE ESTUDIANTES</h4>
                  <h5>Ano Lectivo <?= $_SESSION['peri_deta']; ?></h5>
          </div>
        </div>
        <div class="user_data">
          <div class="name">
                  <h4>Curso: <?= $row_curs_peri_info['curs_deta']; ?> </h4>
                  <h4>Paralelo:<?= $row_curs_peri_info['para_deta']; ?></h4>
          </div>
        </div>
    </div>


	<div class="full">
	<table class="table_striped">
	<thead>
		<tr>
			<th colspan="11" class="center">
				NÓMINA DE ESTUDIANTES
			</th>
		</tr>
	</thead>
	        <tbody>
	            <?php  while ($row_alum_curs_para_view = sqlsrv_fetch_array($alum_curs_para_view)) { $cc +=1; ?> 
	            <tr>
	                <?php
	          	$file_exi= $_SESSION['ruta_foto_alumno'].$row_alum_curs_para_view["alum_codi"] . '.jpg';
		
				if (file_exists($file_exi)) {
					$pp=$file_exi;
				} else {
					$pp="../fotos/".$_SESSION['directorio']."/alumnos/0.jpg";
				}
			  ?>
	              <td class="center"><?php echo $cc; ?></td>
	              <td class="center"><img src="<?php echo $pp; ?>"  style="width:20px; height:20px;"/></td>
	              <td class="left" >
	                <?= $row_alum_curs_para_view["alum_codi"]; ?>
					- <?php echo $row_alum_curs_para_view["alum_apel"].' '.$row_alum_curs_para_view["alum_nomb"];
					echo ($row_alum_curs_para_view["alum_curs_para_estado"]=='I'?' (**)':'');
					?>
                  </td>
	              <td width="5%" >&nbsp;</td>
	              <td width="5%" >&nbsp;</td>
	              <td width="5%" >&nbsp;</td>
	              <td width="5%" >&nbsp;</td>
	              <td width="5%" >&nbsp;</td>
	              <td width="5%" >&nbsp;</td>
	              <td width="5%" >&nbsp;</td>
	              <td width="5%" >&nbsp;</td>
	              </tr>
	            <?php }?>
	            <tr>
	              <td colspan="11">(**) Alumno retirado</td>
	            </tr>
                <tr>
	              <td colspan="11">&nbsp;</td>
	            </tr>
	         </tbody>
	</table>
	</div>
	</div>
</page>
<div class="page-break">&nbsp;</div>
 
</body>
</html>