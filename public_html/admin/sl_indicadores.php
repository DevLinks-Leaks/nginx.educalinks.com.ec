<?php  
	session_start();	 
	include ('../framework/dbconf.php');
	
	$valo_codi=$_POST['valo_codi'];
	 
	$params = array($valo_codi);
	$sql="{call indi_valo_view(?)}";
	$indi_valo_view = sqlsrv_query($conn, $sql, $params);  
	 
 ?>  
<select name="sl_indicador" id="sl_indicador" style="width: 100%; margin-top: 5px;" >
 <?php  
 while ($row_indi_valo_view = sqlsrv_fetch_array($indi_valo_view)) 
 { ?>     
 	 <option value="<?= $row_indi_valo_view['indi_codi']; ?>">
	 	<?= $row_indi_valo_view['indi_deta']; ?>
      </option>
<?php 
  }  
  ?>	  
</select>