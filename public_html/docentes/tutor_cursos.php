
<?php 

	session_start();	 
	include ('../framework/dbconf.php');
 
	$params = array($_SESSION['prof_codi'],$_SESSION['peri_codi']);
	$sql="{call curs_para_tuto_view(?,?)}";
	$curs_prof_tuto_view = sqlsrv_query($conn, $sql, $params);  
	$cc = 0; 
	
	
?> 

<div class="docentes_cursos">
<table class="table table-striped table-bordered">
	<thead style='background-color:rgba(1, 126, 186, 0.1) !important;'>
		<tr>
			<th width="35%" style='text-align:center;'><strong>Periodo Dist.</strong></th>
			<th width="35%" style='text-align:center;'><strong>Curso</strong></th>
			<th width="10%" style='text-align:center;'><strong>Paralelo</strong></th>
			<th width="10%" style='text-align:center;'><strong>Alumnos</strong></th>
			<th width="10%" style='text-align:center;'><strong>Ver</strong></th>
		</tr>
	</thead>
 <?php  
 while ($row_curs_prof_tuto_view = sqlsrv_fetch_array($curs_prof_tuto_view)) 
 { 
 	$cc +=1; 
 ?>
  <tr>
  	<td style='text-align:center;'>
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
    <td style='text-align:center;'><b><?= $row_curs_prof_tuto_view["curs_deta"]; ?> </b></td>
    <td style='text-align:center;'><?= $row_curs_prof_tuto_view["para_deta"]; ?></td>
    <td style='text-align:center;'><?= $row_curs_prof_tuto_view["alum_count"]; ?></td>
	<td style='text-align:center;'>
		<a class='btn btn-info'
        	onClick="window.location='tutor_deta_alum.php?curs_para_codi=<?= $row_curs_prof_tuto_view["curs_para_codi"]; ?>&peri_dist_codi='+document.getElementById('peri_dist_codi_<?= $cc ?>').value" style='cursor:pointer'
            style="width:100%; text-align:left; padding:0; border:0; background:none; outline: none;"><span class=' fa fa-search'></span>
		</a>
	</td>
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