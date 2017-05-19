<?php
	require_once ('../framework/dbconf.php');
		
	if (isset($_POST['alum_codi']))
		$alum_codi = $_POST['alum_codi'];
	else
		$alum_codi = -1;
		
	if (isset($_POST['curs_para_codi_orig']))
		$curs_para_codi_orig = $_POST['curs_para_codi_orig'];
	else
		$curs_para_codi_orig = -1;
		
	if (isset($_POST['curs_para_codi_dest']))
		$curs_para_codi_dest = $_POST['curs_para_codi_dest'];
	else
		$curs_para_codi_dest = -1;
		
	if (isset($_POST['alum_curs_para_codi']))
		$alum_curs_para_codi = $_POST['alum_curs_para_codi'];
	else
		$alum_curs_para_codi = -1;
	
	if ($curs_para_codi_dest==-1)
		exit();
	
	$params = array($curs_para_codi_orig, $alum_curs_para_codi);
	$sql="{call alum_curs_para_mate_deta(?,?)}";
	$mate_view = sqlsrv_query($conn, $sql, $params);  
	$cc = 0; 		
?>
<table width="100%" class="table_striped">
<thead>
	<th width="35%">
    Materia origen
    </th>
    <th width="65%">
    Materia Destino
    </th>
</thead>
  <?php  
    while ($row_mate_view = sqlsrv_fetch_array($mate_view)) 
	{ 
		if (!is_null($row_mate_view['alum_curs_para_mate_codi']))
		{
			$cc +=1;
  ?>
  <tr>
    <td width="35%">
		<?php 
        echo '<b>'.$row_mate_view['mate_codi'].'</b> '.substr($row_mate_view['mate_deta'],0,30);
        ?>
        <input 
        	type="hidden" 
            id="txt_materias_orig_<?= $cc?>" 
            data-curs_para_mate_codi="<?= $row_mate_view['curs_para_mate_codi']?>" />
    </td>
    <td width="65%">
		<select
        	style="text-align:left;"
            id="sl_materias_dest_<?= $cc?>">
        <option data-curs_para_mate_codi="-1">SELECCIONE...</option>
    	<?
		$params = array($curs_para_codi_dest);
		$sql="{call curs_para_mate_full_cons(?)}";
		$mate_dest_view = sqlsrv_query($conn, $sql, $params);  	
		while ($row_mate_dest_view = sqlsrv_fetch_array($mate_dest_view)) 
		{
        ?>
        	<option
            	data-curs_para_mate_codi="<?= $row_mate_dest_view["curs_para_mate_codi"]?>"
                data-curs_para_mate_prof_codi="<?= $row_mate_dest_view["curs_para_mate_prof_codi"]?>"
				<?= ($row_mate_dest_view["mate_codi"]== $row_mate_view['mate_codi']?'selected':'')?>>
				<?= '<b>'.$row_mate_dest_view['mate_codi'].'</b> '.substr($row_mate_dest_view["mate_deta"],0,30).' ('.$row_mate_dest_view["prof_apel"].' '.$row_mate_dest_view["prof_nomb"].')' ?>
            </option>
        <?
		}
		?>
        </select>
    </td>
  </tr>
 	<?php 
  		}
	}
	?>
</table>
<input 
	type="hidden" 
    id="txt_datos" 
    data-num_materias="<?= $cc?>"
    data-curs_para_codi_orig="<?= $curs_para_codi_orig?>"
    data-curs_para_codi_dest="<?= $curs_para_codi_dest?>"
    data-alum_codi="<?= $alum_codi?>"/>