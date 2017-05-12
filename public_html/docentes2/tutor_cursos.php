
<?php 

	session_start();	 
	include ('../framework/dbconf.php');
 
	$params = array($_SESSION['prof_codi'],$_SESSION['peri_codi']);
	$sql="{call curs_para_tuto_view(?,?)}";
	$curs_prof_tuto_view = sqlsrv_query($conn, $sql, $params);  
	$cc = 0; 
	
	
?> 

<div class="docentes_cursos">
<table class="table table-striped">
  <tr>
    <th width="30%"><strong>Periodo Dist.</strong></th>
    <th width="50%"><strong>Curso</strong></th>
    <th width="10%"><strong>Paralelo</strong></th>
    <th width="10%"><strong>Alumnos</strong></th>
  </tr>
 <?php  
 while ($row_curs_prof_tuto_view = sqlsrv_fetch_array($curs_prof_tuto_view)) 
 { 
 	$cc +=1; 
 ?>
  <tr>
  	<td>
    	<?  
			$peri_dist_nive=2;
			$params = array($row_curs_prof_tuto_view['curs_para_codi']);
			$sql="{call peri_dist_peri_view_Lb_NEW(?)}";
			$peri_dist_peri_nive_view = sqlsrv_query($conn, $sql, $params);  
		?>
    	<select class='form-control input-sm' id="peri_dist_codi_<?= $cc?>">
		<? 
            while($row_peri_dist_peri_nive_view = sqlsrv_fetch_array($peri_dist_peri_nive_view))
            { 
        ?>
            <option value="<?= $row_peri_dist_peri_nive_view['peri_dist_codi'];?>"   >
               <?= (($row_peri_dist_peri_nive_view['padre']=='')?
                        $row_peri_dist_peri_nive_view['padre']:
                        $row_peri_dist_peri_nive_view['padre'].' - ').
                        $row_peri_dist_peri_nive_view['peri_dist_deta'];
                    ?>
            </option>
        <?php   
            } 
        ?>
        </select> 
    </td>
    <td height="29">
    	<a 
        	onClick="window.location='tutor_deta_alum.php?curs_para_codi=<?= $row_curs_prof_tuto_view["curs_para_codi"]; ?>&peri_dist_codi='+document.getElementById('peri_dist_codi_<?= $cc ?>').value" style='cursor:pointer'
            style="width:100%; text-align:left; padding:0; border:0; background:none; outline: none;">
     		<strong>
        		<?= $row_curs_prof_tuto_view["curs_deta"]; ?> 
			</strong>
			<br />
      		<?= $row_agen_prof_curs_para_mate_view["mate_deta"]; ?> 
		</a>
     </td>
    <td align="center"><?= $row_curs_prof_tuto_view["para_deta"]; ?></td>
    <td align="center"><?= $row_curs_prof_tuto_view["alum_count"]; ?></td>
  </tr>
 <?php  
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