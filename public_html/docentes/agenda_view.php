
<?php 

	session_start();	 
	include ('../framework/dbconf.php');
 
	$params = array($_SESSION['prof_codi'],$_SESSION['peri_codi']);
	$sql="{call agen_prof_curs_para_mate_view(?,?)}";
	$agen_prof_curs_para_mate_view = sqlsrv_query($conn, $sql, $params);  
	$cc = 0; 
	
	
?> 

<div class="docentes_agendas">
<table class="table_striped_rollover">
  <tr>
    <th width="68%"><strong>Listado de Clases</strong></th>
    <th width="8%"><strong>Activos</strong></th>
    <th width="8%"><strong>Inactivos</strong></th>
    <th width="8%"><strong>Pendientes</strong></th>
    <th width="8%"><strong>Total</strong></th>
  </tr>
 <?php  
 while ($row_agen_prof_curs_para_mate_view = sqlsrv_fetch_array($agen_prof_curs_para_mate_view)) 
 { 
	 if ($row_agen_prof_curs_para_mate_view["curs_para_mate_agen"]==1)
	 {
 	$cc +=1; 
 ?>
  <tr>
    <td height="29">
    	<a 
        	href="agenda_main.php?curs_para_mate_prof_codi=<?= $row_agen_prof_curs_para_mate_view["curs_para_mate_prof_codi"]; ?>&curs_para_mate_codi=<?= $row_agen_prof_curs_para_mate_view["curs_para_mate_codi"]; ?>" 
            class="btn btn-default " 
            style="width:100%; text-align:left; padding:0; border:0; background:none; outline: none;">
     		<strong>
        		<?= $row_agen_prof_curs_para_mate_view["curs_deta"]; ?> 
         		(<?= $row_agen_prof_curs_para_mate_view["para_deta"]; ?>)
			</strong>
			<br />
      		<?= $row_agen_prof_curs_para_mate_view["mate_deta"]; ?> 
		</a>
     </td>
    <td align="center"><?= $row_agen_prof_curs_para_mate_view["cc_A"]; ?></td>
    <td align="center"><?= $row_agen_prof_curs_para_mate_view["cc_I"]; ?></td>
    <td align="center"><?= $row_agen_prof_curs_para_mate_view["cc_P"]; ?></td>
    <td align="center"><?= ($row_agen_prof_curs_para_mate_view["cc_A"]+$row_agen_prof_curs_para_mate_view["cc_I"]+$row_agen_prof_curs_para_mate_view["cc_P"]); ?></td>
  </tr>
 
 <?php  
 }
 }
 ?>
 <tfoot>
	<tr class="pager_table">
    	<td height="40" colspan="5">
        	<span class="icons icon-books"></span> Total de Cursos ( <?php echo $cc;?> )
		</td>
  </tr>
  </tfoot>
</table>
</div>