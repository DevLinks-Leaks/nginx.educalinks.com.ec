
<?php 

	 	 
	include ('../framework/dbconf.php');


	$params = array($_SESSION['peri_codi']);
	$sql="{call curs_peri_cc_general(?)}";
	$curs_peri_cc_alum = sqlsrv_query($conn, $sql, $params);  
	$cc = 0; 
  
		 
?>

<table width="100%"  class="table_striped">
  <thead>
    <tr>
    
    <th width="25%">Curso</th>
    <th width="15%" align="center" valign="middle">CC.  Alum</th>
    <th width="15%" align="center" valign="middle">Agenda In.</th>
    <th width="15%" align="center" valign="middle">Repre In.</th>
    <th width="15%" align="center" valign="middle"><h4>Alum In.</h4></th>
    <th width="15%" align="center" valign="middle">Prof In.</th>
  </tr>
  </thead> <tbody>
   <? while ($row_curs_peri_cc_alum = sqlsrv_fetch_array($curs_peri_cc_alum)) { ?>
	 
		
  <tr>
    <td><?= $row_curs_peri_cc_alum['curs_deta']; ?> </td>
    <td align="center" valign="middle"><?= $row_curs_peri_cc_alum['cc_Alum']; ?></td>
    <td align="center" valign="middle"><?= $row_curs_peri_cc_alum['cc_agen']; ?></td>
    <td align="center" valign="middle"><?= $row_curs_peri_cc_alum['cc_inweb_repr']; ?></td>
    <td align="center" valign="middle"><?= $row_curs_peri_cc_alum['cc_inweb_alum']; ?></td>
    <td align="center" valign="middle"><?= $row_curs_peri_cc_alum['cc_inweb_prof']; ?></td>
  </tr>
   <? } ?></tbody>
    <tr>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
  </tr>
</table>
