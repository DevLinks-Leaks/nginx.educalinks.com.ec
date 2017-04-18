
<?php 

	session_start();	 
	require_once ('../framework/dbconf.php');
	require_once ('../framework/funciones.php');
	require_once ('script_cursos.php');

	$curs_para_codi=$_POST['curs_para_codi'];
	$curs_para_mate_codi=$_POST['curs_para_mate_codi'];
	$alum_curs_para_codi=$_POST['alum_curs_para_codi'];
	$alum_codi=$_POST['alum_codi'];
	
	if(isset($_POST['del_alum_mate'])){
		if($_POST['del_alum_mate']=='Y'){
			alum_curs_para_mate_del_ii($_POST['alum_curs_para_mate_codi']);
		}
	}
	
	if(isset($_POST['add_alum_mate'])){
		if($_POST['add_alum_mate']=='Y'){
			alum_curs_para_mate_add_ii($alum_curs_para_codi, $curs_para_mate_codi, $alum_codi);
		}
	}
	
	
	$params = array($curs_para_codi, $alum_curs_para_codi);
	$sql="{call alum_curs_para_mate_deta(?,?)}";
	$mate_view = sqlsrv_query($conn, $sql, $params);  
	$cc = 0; 
?>
<div class="form_element">
<table width="100%" class="table_striped">
  <?php  while ($row_mate_view = sqlsrv_fetch_array($mate_view)) { $cc +=1; ?>
  <tr>
    <td width="90%" colspan="2">
    	<strong>
    	(
    	<?php 
		echo $row_mate_view['curs_para_mate_codi']; 
		?>)
    	</strong>
<?php 
		echo $row_mate_view['mate_deta']; 
		?>
    	/
   	  <?php 
		echo $row_mate_view['aula_deta']; 
		?>
   	  /
   	  <?php 
		echo $row_mate_view['prof_nomb']; 
		?></td>
    <td>
    	<?
    	if ($row_mate_view['alum_curs_para_mate_codi']!=NULL)
		{
			$alum_curs_para_mate_codi=$row_mate_view['alum_curs_para_mate_codi'];
			echo "<button type='button' onclick='alum_curs_para_mate_del_2(".$alum_curs_para_mate_codi.",".$curs_para_codi.",".$alum_curs_para_codi.")'>Quitar&nbsp;&nbsp;&nbsp;</button>";
		}
		else
		{
			echo "<button type='button' onclick='alum_curs_para_mate_add_2(".$row_mate_view['alum_curs_para_codi'].",".$row_mate_view['curs_para_mate_codi'].",".$alum_codi.",".$curs_para_codi.")'>Agregar</button>";
		}
		?>
   	</td>
  </tr>
 
 <?php  }?>
</table>
</div>
<div class="form_element">&nbsp;</div>  
