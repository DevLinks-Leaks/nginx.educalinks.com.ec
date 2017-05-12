
<?php 

	session_start();	 
	include ('../framework/dbconf.php');
	
 	$tipo='D';
	
	
	$params = array($_SESSION['prof_codi'],$_SESSION['peri_codi']);
	$sql="{call agen_prof_curs_para_mate_view(?,?)}";
	$agen_prof_curs_para_mate_view = sqlsrv_query($conn, $sql, $params);  
	$cc = 0; 
	
	
?> 
<table width="100%"   class="table_full">
 
  <?php  while ($row_agen_prof_curs_para_mate_view = sqlsrv_fetch_array($agen_prof_curs_para_mate_view)) { $cc +=1; ?>
  <tr >
    <td width="58%" height="29"><a  href="agenda_main.php?curs_para_mate_codi=<?= $row_agen_prof_curs_para_mate_view["curs_para_mate_codi"]; ?>" class="btn btn-default " style="width:100%; text-align:left;"><?= $row_agen_prof_curs_para_mate_view["mate_deta"]; ?></a>
  
     </td>
    <td width="8%" align="center"><?= $row_agen_prof_curs_para_mate_view["cc_A"]; ?></td>
    <td width="8%" align="center"><?= $row_agen_prof_curs_para_mate_view["cc_I"]; ?></td>
    <td width="8%" align="center">&nbsp;</td>
    <td width="8%" align="center">&nbsp;</td>
  </tr>
 
 <?php  }?>
</table>
