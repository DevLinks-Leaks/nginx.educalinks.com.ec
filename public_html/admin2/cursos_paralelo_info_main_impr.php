<?php
	session_start();	 
	include ('../framework/dbconf.php');
	include ('../framework/funciones.php');
	include ('script_cursos.php'); 
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
		@page {  size: A4 Portrait;  }  
		@media all {
	.page-break	{ display: none; }
}

@media print {
	.page-break	{ display: block; page-break-before: always; }
}
	</style> 
</head>
<body>

<?php 
	$all='UNA';$peri_codi=0;
	
	if(isset($_GET['peri_codi'])){
		 $peri_codi=$_GET['peri_codi'];
		 $all='YES';
	}
	
	
	$params = array($peri_codi);
	$sql="{call curs_peri_view(?)}";
	$curs_peri_view = sqlsrv_query($conn, $sql, $params);  
	 
?>	



<?php  while (($row_curs_peri_view = sqlsrv_fetch_array($curs_peri_view)) or  ($all=='UNA'))  {  ?> 

 <?php 	
	if ($all=='UNA'){ 
		$all='OFF';
		if(isset($_GET['curs_para_codi'])){
		 	$curs_para_codi=$_GET['curs_para_codi'];
		}
		if(isset($_POST['curs_para_codi'])){
		 	$curs_para_codi=$_POST['curs_para_codi'];
		}
		 
	}else {
		$curs_para_codi=$row_curs_peri_view['curs_para_codi'];
	}
	

	$params = array($curs_para_codi);
	$sql="{call alum_curs_para_view(?)}";
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
            <img src="<?= $_SESSION['ruta_foto_logo_libreta']?>" width="90" height="107">
          </div>
          <div class="name">
                  <h4> <strong> <?= para_sist(3); ?> </strong></h4>
                  <h4>Datos de Curso </h4>
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
<table border="0" cellspacing="0" cellpadding="0"  >
  <tr>
    <td valign="top" width="49%"><table class="table_striped">
	<thead>
		<tr>
			<th colspan="2" class="center">
				
				Listado de Materias </th>
		</tr>
	</thead>
	        <tbody>
		<?php 
			$params = array($curs_para_codi);
			$sql="{call curs_peri_mate_view(?)}";
			$curs_peri_mate_view = sqlsrv_query($conn, $sql, $params);  
			$cc = 0;
		?>

	            <?php  while ($row_curs_peri_mate_view = sqlsrv_fetch_array($curs_peri_mate_view)) { $cc +=1; ?> 
	            <tr>
	                 
	              <td width="7%" class="center"><?php echo $cc; ?></td>
	              <td width="85%" align="left"     >   <div  <? if ($row_curs_peri_mate_view["mate_padr"] >0) echo 'style="text-indent:15px;"';?>>
	                <?= $row_curs_peri_mate_view["mate_codi"].' - '.$row_curs_peri_mate_view["mate_deta"]; ?><br>

	                           Aula: <?= $row_curs_peri_mate_view["aula_deta"]; ?> Profesor: 
                    <?= $row_curs_peri_mate_view["prof_nomb"]; ?>
                            </div>   </td>
                </tr>
	            <?php }?>
              </tbody>
	</table></td>
    <td width="2%"></td>
    <td width="49%"valign="top"><table class="table_striped">
	<thead>
		<tr>
			<th colspan="3" class="center">
				
				Listado de Estudiantes

			</th>
		</tr>
	</thead>
	        <tbody>


	            <?php  $cc=0; while ($row_alum_curs_para_view = sqlsrv_fetch_array($alum_curs_para_view)) { $cc +=1; ?> 
	            <tr>
	                <?php
	          	$file_exi=$_SESSION['ruta_foto_alumno'].$row_alum_curs_para_view["alum_codi"].'.jpg';

		
				if (file_exists($file_exi)) {
					$pp=$file_exi;
				} else {
					$pp='../fotos/'.$_SESSION['directorio'].'/alumnos/0.jpg';
				}
			  ?>
	              <td class="center"><?php echo $cc; ?></td>
	              <td class="center"><img src="<?php echo $pp; ?>"  style="width:20px; height:20px;"/></td>
	              <td class="left" >
	                <?= $row_alum_curs_para_view["alum_codi"]; ?>
	- <?= $row_alum_curs_para_view["alum_apel"]." ".$row_alum_curs_para_view["alum_nomb"]; ?></td>
                </tr>
	            <?php }?>
	            <tr>
	              <td>&nbsp;</td>
	              <td>&nbsp;</td>
	              <td>&nbsp;</td>
                </tr>
              </tbody>
	</table></td>
  </tr>
</table>

	
	</div>

  </div>
</page>
<div class="page-break"></div>
<? } ?>
</body>
</html>
<script>
window.print();
</script>