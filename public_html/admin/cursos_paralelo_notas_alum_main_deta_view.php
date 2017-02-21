<?php 

	session_start();	 
	include ('../framework/dbconf.php');
			
	$alum_codi=$_GET['alum_codi'];
	$peri_dist_codi=$_GET['peri_dist_codi'];
	
 
	$params = array($peri_dist_codi);
	$sql="{call peri_dist_padr_view(?)}";
	$peri_dist_padr_view = sqlsrv_query($conn, $sql, $params); 
			
	$params = array($alum_codi,$peri_dist_codi);
	$sql="{call alum_nota_peri_dist_view(?,?)}";
	$alum_nota_peri_dist_view = sqlsrv_query($conn, $sql, $params); 
	$row_alum_nota_peri_dist_view= sqlsrv_fetch_array($alum_nota_peri_dist_view);
	$CC_COLUM=$row_alum_nota_peri_dist_view['CC_COLUM'];
	 
	sqlsrv_next_result($alum_nota_peri_dist_view);
	sqlsrv_next_result($alum_nota_peri_dist_view); 
	 
	
 	echo peri_nota_max($_SESSION['peri_codi']);
	 
	$cc = 0;
	$CC_COLUM_index=0;
	
?>
<table width="600" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td>&nbsp;</td>
    </tr>
  	<tr>
        <td>
            <table width="100%"  class="table_full" >
                <thead>                 
                      <tr>
                        <th colspan="3" align="left">Asignaturas</th>
                        <? while($row_peri_dist_padr_view= sqlsrv_fetch_array($peri_dist_padr_view))  {?>       
                        <th align="left">
                            <?= $row_peri_dist_padr_view['peri_dist_deta']; ?>
                        </th>    
                      <?php  }?>         
                <td width="3%">
                
                </thead>
            
            
                        <?php  while ($row_alum_nota_peri_dist_view= sqlsrv_fetch_array($alum_nota_peri_dist_view)) { $cc +=1; ?> 
                            <tr>
                              <td width="3%"><?= $cc;?> </td>
                              <td width="4%">&nbsp;</td>
                              <td width="84%" height="26">
                                <?= $row_alum_nota_peri_dist_view['mate_deta']; ?>
                              </td>
                                <? $CC_COLUM_index =0; while($CC_COLUM_index < $CC_COLUM )  {?>       
                                  <td width="6%">
                                     <?= $row_alum_nota_peri_dist_view[$CC_COLUM_index + 6]; ?>                                  
                                  </td>
                                <?php $CC_COLUM_index+=1;}?>    
                            </tr>
                        <?php }?>
                        
                        
                        <tr>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                         <? $CC_COLUM_index =0; while($CC_COLUM_index < $CC_COLUM )  {?>       
                            <th align="left"></th>    
                          <?php $CC_COLUM_index+=1;}?>    
                        </tr>
            </table>
        </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
