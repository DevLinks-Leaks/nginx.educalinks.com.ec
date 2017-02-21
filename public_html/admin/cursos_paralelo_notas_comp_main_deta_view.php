<?php
 	session_start();	 
	include ('../framework/dbconf.php');
	include ('../framework/funciones.php');
?>
<!DOCTYPE html>
<html>
<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>Educalinks | <?php echo para_sist(2); ?></title> 
        <link rel="SHORTCUT ICON" href="../imagenes/logo_icon.png"/>
	  

        <link href="cursos_paralelo_notas_alum_libreta.css" rel="stylesheet" type="text/css">
        <link href="../theme/css/main.css" rel="stylesheet" type="text/css"> 
        <link href="../theme/css/print.css" media="print" rel="stylesheet" type="text/css">
        <script src="../framework/funciones.js"></script>

<style>
  @page {  size: A4 landscape;  }  
</style>
</head>
<body>

<?php 	
	$alum_codi=$_GET['alum_codi'];
	$peri_dist_codi=$_GET['peri_dist_codi'];
	
	//Quimestre y Parcial
	$params = array($peri_dist_codi);
	$sql="{call peri_dist_peri_codi (?)}";
	$cab_view = sqlsrv_query($conn, $sql, $params);  
	$cab_row=sqlsrv_fetch_array($cab_view);
 
	$params = array($peri_dist_codi);
	$sql="{call peri_dist_padr_view(?)}";
	$peri_dist_padr_view = sqlsrv_query($conn, $sql, $params); 
	
	//$peri_codi=Periodo_Distribucion_Peri_Codi($peri_dist_codi);
	 
	
	$params = array($alum_codi,$peri_dist_codi);
	$sql="{call alum_nota_peri_dist_view(?,?)}";
	$alum_nota_peri_dist_view = sqlsrv_query($conn, $sql, $params); 
	$row_alum_nota_peri_dist_view= sqlsrv_fetch_array($alum_nota_peri_dist_view);
	
	$params = array($alum_codi);
	$sql="{call alum_info(?)}";
	$alum_info = sqlsrv_query($conn, $sql, $params);
	$row_alum_info = sqlsrv_fetch_array($alum_info);

    $params = array($_GET['peri_dist_codi'],$_GET['alum_codi']);
    $sql="{call nota_comp_view(?,?)}";
    $nota_comp_view = sqlsrv_query($conn, $sql, $params);  
	
	$grupo_valor="";
?>

<div class="libreta">
 <div class="header_institution">
        
        <div class="institution">
          <div class="image">
            <img src="../imagenes/reportes/logo_libreta.png" width="90" height="107">
          </div>
          <div class="name">
                  <h4> <strong><?= para_sist(3); ?></strong></h4>
                  <h4>INFORME DE COMPORTAMIENTO: <? echo $cab_row['nivel_1']."  ".$cab_row['nivel_2'];?></h4>
                  <h5>Ano Lectivo <?= $_SESSION['peri_deta']; ?></h5>
          </div>
        </div>
      

        <div class="user_data">
          <div class="name">
                  <h5>Estudiante:</h5>
                  <h4><?= $row_alum_info['alum_apel']; ?> <?= $row_alum_info['alum_nomb']; ?> - <?= $row_alum_info['alum_codi']; ?></h4>
          </div>
        </div>
      </div>
      
      
<div class="CSSTableGenerator full" >
<table class="table_striped">
    <thead>
        <tr>
            <th>VALOR</th>
            <th>INDICADORES PARA EL VALOR</th>
            <th>VALORACION</th>
        </tr>
    </thead>
    <tbody>
         <?php  
        while ($row_nota_comp_view = sqlsrv_fetch_array($nota_comp_view)) 
        { 
			$prom=$row_nota_comp_view['prom'];
        ?>
        <tr>
            <td>
			<?php
			if ($row_nota_comp_view['valo_deta']!=$grupo) 
			{
				echo $row_nota_comp_view['valo_deta']; 
				$grupo=$row_nota_comp_view['valo_deta'];
			}
			?></td>
            <td><?= $row_nota_comp_view['indi_deta'];?></td>
            <td><?= $row_nota_comp_view['nota_peri_cual_refe'];?></td>
        </tr>
        <?
        }
        ?>
        <tr>
        	<td></td>
            <td><strong>PROMEDIO</strong></td>
            <td><strong><?= $prom; ?></strong></td>
        </tr>
    </tbody>
</table>
</div>

<div class="CSSTableGenerator half" >
 <?php
	
		$params = array('Q', $_SESSION['peri_codi']);
		$sql="{call nota_peri_cual_tipo_view(?,?)}";
		$nota_peri_cual_tipo_view = sqlsrv_query($conn, $sql, $params);
		
	   
?>
  <table class="table_striped">
    <thead>
      <tr>
        <th colspan="2" align="center">EQUIVALENCIA CUALITATIVAS</th>
      </tr>
    </thead>
    <tbody>
      <?php  while ($row_nota_peri_cual_tipo_view = sqlsrv_fetch_array($nota_peri_cual_tipo_view)) { ?>
      <tr>
        <td  class="center"><?= $row_nota_peri_cual_tipo_view['nota_peri_cual_refe']; ?> -</td>
        <td><?= $row_nota_peri_cual_tipo_view['nota_peri_cual_deta']; ?></td>
        <? } ?>
      </tr>
    </tbody>
  </table>
</div>

<?
//Nombre del representante
//Consulta datos del representante
$sql_rep="{call repr_info_vida(?,?)}";
$params_rep = array($alum_codi, "R");
$stmt_rep = sqlsrv_query($conn, $sql_rep, $params_rep);

if( $stmt_rep === false )
{
	echo "Error in executing statement .\n";
	die( print_r( sqlsrv_errors(), true));
}
$representante=sqlsrv_fetch_array($stmt_rep);

?>
<table class="table_striped">
	<tr>
    	<td><br /><br /><br /></td>
    	<td><br /><br /><br /></td>
    </tr>
	<tr>
		<td align="center" width="50%">_____________________<br />Tutor(a)</td>
		<td align="center" width="50%">_____________________<br /><? echo $representante["nombres"]; ?></td>
	</tr>
</table>
</div>
</body>
</html>