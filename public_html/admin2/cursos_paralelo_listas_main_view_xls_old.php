<?php
	header("Content-Type: application/vnd.ms-excel;");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("content-disposition: attachment;filename=Listado_Alumnos.xls");
	session_start();
	include ('../framework/dbconf.php');
	include ('../framework/funciones.php');
	include ('script_cursos.php'); 
?>
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
	$cc = 0; 
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
	
	$params = array($curs_para_codi);
	$sql="{call curs_peri_info(?)}";
	$curs_peri_info = sqlsrv_query($conn, $sql, $params); 
	$row_curs_peri_info = sqlsrv_fetch_array($curs_peri_info)
?>
<table>
<tbody>
    <?php  while ($row_alum_curs_para_view = sqlsrv_fetch_array($alum_curs_para_view)) { $cc +=1; ?> 
    <tr>
      <td class="center">
	  	<?php echo $cc; ?>
      </td>
      <td class="left">
        <?= $row_alum_curs_para_view["alum_codi"]; ?>
      </td>
      <td class="left">
      	<? echo utf8_decode($row_alum_curs_para_view["alum_apel"]);?>
      </td>
      <td class="left">
      	<? echo utf8_decode($row_alum_curs_para_view["alum_nomb"]); ?>
        <? echo " ".($row_alum_curs_para_view["alum_curs_para_estado"]=='I'?' (**)':''); ?>
      </td>
      <td>
      	<? echo utf8_decode($row_curs_peri_info['curs_deta']); ?>
      </td>
      <td>
      	<? echo $row_curs_peri_info['para_deta']; ?>
      </td>
     </tr>
    <?php }?>
    <? } ?>
    <tr>
      <td colspan="6">(**) Alumno retirado</td>
    </tr>
 </tbody>
</table>