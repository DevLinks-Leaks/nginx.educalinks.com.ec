<?php  
	session_start();	 
	include ('../framework/dbconf.php');
	include ('script_cursos.php'); 
	
	$peri_codi=$_POST['peri_codi'];
 
	 
	$params = array($peri_codi);
	$sql="{call peri_dist_peri_libt_view(?)}";
	$peri_dist_peri_libt_view = sqlsrv_query($conn, $sql, $params);  
	 
 ?>  
  <tr>
                        <td width="87" height="45">Unidad: </td>
                         <td>
                         
                        
                      <select name="n_peri_dist_codi"   id="n_peri_dist_codi" >
 <?php  while ($row_peri_dist_peri_libt_view = sqlsrv_fetch_array($peri_dist_peri_libt_view)) { ?>     
 	 <option value="<?= $row_peri_dist_peri_libt_view['peri_dist_codi']; ?>">
	 	<?= $row_peri_dist_peri_libt_view['peri_dist_deta']; ?> / <?= $row_peri_dist_peri_libt_view['peri_dist_padr_deta']; ?>   
      </option>
<?php }  ?>	  
</select>   
                         
                    
                        </td>
                    </tr>
