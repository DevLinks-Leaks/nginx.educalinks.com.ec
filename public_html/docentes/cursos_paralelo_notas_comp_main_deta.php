<?php 
    session_start();	 
    include ('../framework/dbconf.php');

    $a=$_POST['a'];

    $params = array($_GET['peri_dist_codi'],$_GET['valo_codi']);
    $sql="{call indi_valo_parc_view(?,?)}";
    $indi_valo_parc_view = sqlsrv_query($conn, $sql, $params);  
    $cc = 0;
?>

<table class="table_striped">
    <?php  
	while ($row_indi_valo_parc_view = sqlsrv_fetch_array($indi_valo_parc_view)) 
	{ 
	$cc +=1; 
	?>
        <thead>
        	<tr>
	        	<th colspan="4">
					<?php echo $cc.'.- '.$row_indi_valo_parc_view['indi_deta']; ?>
                    <input id="indi_<?= $cc; ?>" value="<?= $row_indi_valo_parc_view['indi_parc_codi']; ?>" type="hidden"/>
                </th>
            </tr>
        </thead>
        <tbody>
        <?php
		$params = array($_GET['curs_para_codi'], $row_indi_valo_parc_view['indi_parc_codi']);
				
		$sql="{call alum_curs_para_comp_view(?,?)}";
		$alum_curs_para_view = sqlsrv_query($conn, $sql, $params);  
		$cc2 = 0;
		while ($row_alum_curs_para_view = sqlsrv_fetch_array($alum_curs_para_view))
		{
			$cc2++;
		?>
            <tr>
            	<td class="center" width="5%"><?= $cc2; ?></td>
                <td class="left" width="35%">
					<?= $row_alum_curs_para_view['alum_codi'].'-'.$row_alum_curs_para_view['alum_apel'].' '.$row_alum_curs_para_view['alum_nomb']; ?>
                    <input id="alum_<?= $cc; ?>_<?= $cc2; ?>" value="<?= $row_alum_curs_para_view['alum_curs_para_codi']; ?>" data-alum_codi="<?= $row_alum_curs_para_view['alum_codi'] ?>" type="hidden"/>
                </td>
                <td class="left" width="30%">
                <select id="nota_<?= $cc; ?>_<?= $cc2; ?>">
                <?php
					$params = array('Q', $_SESSION['peri_codi']);
					$sql="{call nota_peri_cual_tipo_view(?,?)}";
					$nota_peri_cual_tipo_view = sqlsrv_query($conn, $sql, $params);
					while ($row_nota_peri_cual_tipo_view = sqlsrv_fetch_array($nota_peri_cual_tipo_view)) 
					{
				?>
                	<option value="<?= $row_nota_peri_cual_tipo_view['nota_peri_cual_codi'];?>" 
					<?php 
					if ($row_nota_peri_cual_tipo_view['nota_peri_cual_codi']==$row_alum_curs_para_view['nota'])
					{
						echo " selected";
					}
					?>
                    
                    ><?= $row_nota_peri_cual_tipo_view['nota_peri_cual_deta'];?></option>
                <?php 
					}
				?>
                </select>
                </td>
                <td>
                	<textarea style="width:100%;" id="observacion_<?= $cc; ?>_<?= $cc2; ?>" placeholder="Ingrese aquí alguna observación"><?= $row_alum_curs_para_view['nota_obse_deta'] ?></textarea>
                </td>
            </tr>
    <?php 
		}	
	} ?>
    </tbody>
    <tr>
    	<td colspan="4"><div></div></td>
    </tr>
</table>
<input id="indi_cont" value="<?= $cc; ?>" type="hidden"/>
<input id="alum_cont" value="<?= $cc2; ?>" type="hidden"/>
<div style="width:95%; height:90; text-align:right; clear: both">
<table width="100%" border="0" cellpadding="0" cellspacing="0"   style="float:right;">
  <tr>
    <td width="75%" height="120" align="right" valign="middle">
    	<button class="btn btn-primary" onclick="curs_para_nota_comp_save(<?= $_GET['nota_perm_codi'] ?>, <?= $_GET['peri_dist_codi'] ?>);">&nbsp;&nbsp;&nbsp;Grabar&nbsp;&nbsp;&nbsp;</button>
    </td>
    <td height="120" align="right" valign="middle">
    	<button class="btn btn-primary" 
        onclick="document.location='cursos_paralelo_notas_mate_main.php?peri_codi=<?= $_SESSION['peri_codi'] ?>&curs_para_codi=<?= $_GET['curs_para_codi'] ?>'">
        Cancelar
        </button></td>
  </tr>
</table>
</div>
