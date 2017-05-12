<table class="table_striped">
	<?php
	$nota_perm_codi=$_GET['nota_perm_codi'];
	
    $params = array($_GET['curs_para_mate_codi'], $_GET['peri_dist_codi']);
    $sql="{call alum_curs_para_mate_cuali_view(?,?)}";
    $alum_curs_para_view = sqlsrv_query($conn, $sql, $params);  
    $cc2 = 0;
    while ($row_alum_curs_para_view = sqlsrv_fetch_array($alum_curs_para_view))
    {
        $cc++;
    ?>
        <tr>
            <td class="center" width="5%">
				<?= $cc; ?>
            </td>
            <td class="left" width="35%">
                <?= $row_alum_curs_para_view['alum_apel'].' '.$row_alum_curs_para_view['alum_nomb']; ?>
                <input 
                	id="alum_<?= $cc; ?>" 
                    value="<?= $row_alum_curs_para_view['alum_curs_para_mate_codi']; ?>" 
                    data-alum_codi="<?= $row_alum_curs_para_view['alum_codi'] ?>" 
                    type="hidden"/>
            </td>
            <td class="left" width="30%">
                <select 
                    id="nota_<?= $cc; ?>" 
                    style="text-align:left;">
                <?php
                    $params = array('P', $_SESSION['peri_codi']);
                    $sql="{call nota_peri_cual_tipo_view(?,?)}";
                    $nota_peri_cual_tipo_view = sqlsrv_query($conn, $sql, $params);
                    while ($row_nota_peri_cual_tipo_view = sqlsrv_fetch_array($nota_peri_cual_tipo_view)) 
                    {
                ?>
                    <option 
                        value="<?= $row_nota_peri_cual_tipo_view['nota_peri_cual_codi'];?>" 
                        style="text-align:left;"
                    <?php 
                    if ($row_nota_peri_cual_tipo_view['nota_peri_cual_codi']==
                    $row_alum_curs_para_view['nota_cual_codi'])
                    {
                        echo " selected";
                    }
                    ?>
                    >
                        <?= 
                        $row_nota_peri_cual_tipo_view['nota_peri_cual_refe'].' - '
                        .$row_nota_peri_cual_tipo_view['nota_peri_cual_deta'];
                        ?>
                    </option>
                <?php 
                    }
                ?>
                </select>
            </td>
        </tr>
<?php 
    }	
?>
    </tbody>
</table>
<input id="alum_cont" value="<?= $cc; ?>" type="hidden"/>
<table width="80%" border="0" cellpadding="0" cellspacing="0"   style="margin:0 10% 0 10%;">
  <tr>
    <td width="75%" height="120" align="right" valign="middle">
    	<button 
        	class="btn btn-primary" 
            onclick="curs_para_nota_cual_save(<?= $_GET['peri_dist_codi'] ?>, <?= $nota_perm_codi ?>);">
            	&nbsp;&nbsp;&nbsp;Grabar&nbsp;&nbsp;&nbsp;
		</button>
    </td>
  </tr>
</table>
</div>