<?php 

	session_start();	 
	include ('../framework/dbconf.php');
	
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

 
<table class="table table-striped">
<?php  while ($row_curs_peri_view = sqlsrv_fetch_array($curs_peri_view)) { $cc +=1; ?> 

		<thead style='background-color:rgba(1, 126, 186, 0.1) !important;'>
        <tr>
          <th colspan="4"><strong><?= $row_curs_peri_view["curs_deta"]; ?></strong> - <?= $row_curs_peri_view["para_deta"]; ?>  
          </th>
        
        </tr>
      </thead>
	    <thead>
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
	<?php  while ($row_curs_peri_mate_view = sqlsrv_fetch_array($curs_peri_mate_view)) { $cc +=1; ?> 
    
     
  
    
        <tr>
         
          <td width="35%"><?= $row_curs_peri_mate_view["mate_deta"]; ?> </td>
          <td width="30%"><?= $row_curs_peri_mate_view["prof_nomb"]; ?></td>
          <td width="5%"> <?= $row_curs_peri_mate_view["cc_ingr"]; ?></td>
          <td width="30%"> <?= date_format($row_curs_peri_mate_view['nota_peri_fec_in'], 'd/M/Y' ); ?> </a></td>
        </tr>
       
     
    <?php  }   ?>
     </tbody>
  <tr>
          <td colspan="4" style="height:35px; background:#FFFFFF; vertical-align:top;">
          <hr /></td>
        
        </tr>
  
<?php  }   ?>

</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
 
 
 
 