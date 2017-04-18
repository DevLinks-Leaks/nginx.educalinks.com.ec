<?php 

	session_start();	 
	 
	
	//echo $_GET['alum_bloq_nomb'];
	
	if (strlen(trim($_GET['alum_bloq_nomb']))>0) $alum_bloq_nomb= $_GET['alum_bloq_nomb'];
	if (strlen(trim($_GET['alum_bloq_apel']))>0)$alum_bloq_apel= $_GET['alum_bloq_apel'];
	if (strlen(trim($_GET['alum_bloq_cedu']))>0)$alum_bloq_cedu= $_GET['alum_bloq_cedu'];
	
	
	include ('../framework/dbconf.php');
	$params = array($alum_bloq_nomb,$alum_bloq_apel,$alum_bloq_cedu);
	$sql="{call alum_bloq_busq(?,?,?)}";
	$alum_bloq_busq = sqlsrv_query($conn, $sql, $params);  
	 
?>

<br />

<table  class="table_striped">
        <thead>
            <tr>
              <th colspan="2"> Lista de Bloqueos  </tr>
        </thead>


            <?php  while ($row_alum_bloq_busq = sqlsrv_fetch_array($alum_bloq_busq)) { $cc +=1; ?> 
            <tr>
                  <td  class="center"><?php echo $cc; ?></td>
                  <td align="left">
                  
                  <?= $row_alum_bloq_busq["alum_bloq_cedu"]; ?> - <?php echo $row_alum_bloq_busq["alum_bloq_apel"]." ".$row_alum_bloq_busq["alum_bloq_nomb"]; ?>
                </td>
  			</tr>
            <?php }?>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              </tr>
          </table>