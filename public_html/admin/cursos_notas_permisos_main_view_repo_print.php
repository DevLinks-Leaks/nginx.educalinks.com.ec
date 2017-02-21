<?php
	session_start();	 
	include ('../framework/dbconf.php');
	include ('../framework/funciones.php');
	
	if(isset($_POST['peri_codi'])) $PERI_CODI=$_POST['peri_codi'];
	else $PERI_CODI=$_SESSION['peri_codi'];
	
	if(isset($_POST['peri_codi'])) $PERI_CODI=$_POST['peri_codi'];
	else $PERI_CODI=$_SESSION['peri_codi'];
	
	if(isset($_GET['peri_dist_cab_codi']))
	{
		$peri_dist_cab_codi = $_GET['peri_dist_cab_codi'];
	}
	else
	{
		$peri_dist_cab_codi = -1;
	}
	
	
	$params = array($peri_dist_cab_codi);
	$sql="{call curs_para_by_peri_view(?)}";
	$curs_peri_view = sqlsrv_query($conn, $sql, $params);  
	$cc = 0;
	
	$peri_dist_codi=$_GET['peri_dist_codi'];
		
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Educalinks | <?php echo para_sist(2); ?></title> 
	<link rel="SHORTCUT ICON" href="../imagenes/logo_icon.png"/>
	<link href="../theme/css/main.css" rel="stylesheet" type="text/css"> 
	<link href="../theme/css/print.css" media="print" rel="stylesheet" type="text/css">
	  
	<style>
		@page 
		{    
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


<page>
	<div class="lista" >
	<div class="header_institution">
        <div class="institution">
          <div class="image">
            <img src="../imagenes/reportes/<?= $_SESSION['directorio']; ?>/logo_libreta.png" width="90" height="107">
          </div>
          <div class="name">
                  <h4 style="margin: 0px 5px;"><strong> UNIDAD EDUCATIVA <?= para_sist(3); ?> </strong></h4>
                  <h4 style="margin: 0px 5px;">Reporte de Ingresos de Notas</h4>
                  <h5 style="margin: 0px 5px;">Año Lectivo <?= $_SESSION['peri_deta']; ?></h5>
          </div>
        </div>
    </div>

	<div class="full">
	<?php  
	while ($row_curs_peri_view = sqlsrv_fetch_array($curs_peri_view)) 
	{ 
		$cc +=1; 
	?> 
	<table class="table_striped" style="margin-bottom: 25px">
		<thead>
			<tr>
				<th colspan="4">
				<strong><?= $row_curs_peri_view["curs_deta"]; ?></strong> - <?= $row_curs_peri_view["para_deta"]; ?>  
				</th>
			</tr>
			<tr>
				<th width="30%">Materia</th>
				<th>Profesor</th>
				<th>Ingreso</th>
				<th>Fecha Ultimo Ingreso</th>
			</tr>
		</thead>
		<?php 
			$params = array($row_curs_peri_view["curs_para_codi"],$peri_dist_codi);
			$sql="{call curs_peri_mate_view_perm_ingr(?,?)}";
			$curs_peri_mate_view = sqlsrv_query($conn, $sql, $params);  
			$cc = 0;
		?>
		<tbody>
		<?php  
		while ($row_curs_peri_mate_view = sqlsrv_fetch_array($curs_peri_mate_view)) 
		{ 
			$cc +=1; 
		?> 
		<tr>
			<td width="35%"><?= $row_curs_peri_mate_view["mate_deta"]; ?> </td>
			<td width="30%"><?= $row_curs_peri_mate_view["prof_nomb"]; ?></td>
			<td width="5%"> <?= $row_curs_peri_mate_view["cc_ingr"]; ?></td>
			<td width="30%"> <?= date_format($row_curs_peri_mate_view['nota_peri_fec_in'], 'd/M/Y' ); ?> </a></td>
		</tr>
		  
		<?php  
		}   
		?>
		</tbody>
	</table>
	<?php  
	}   
	?>
<p><strong>Usuario: </strong> <?= $_SESSION['usua_codi']; ?>  <strong>Fecha de Impresión: </strong><?= date('l jS \of F Y h:i:s A'); ?></p>

</div>

</div>
</page>
<div class="page-break"></div>

</body>
</html>


              