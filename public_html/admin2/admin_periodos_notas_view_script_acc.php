 <?php 	
  include ('../framework/dbconf.php');
  session_start();

  if(isset($_POST['nota_refe_cab_codi'])) $nota_refe_cab_codi=$_POST['nota_refe_cab_codi'];
  if(isset($_POST['peri_dist_codi'])) $peri_dist_codi=$_POST['peri_dist_codi'];

  $params = array($nota_refe_cab_codi,$peri_dist_codi);
  $sql="{call nota_refe_cab_view_deta(?,?)}";
  $nota_refe_cab_view_deta = sqlsrv_query($conn, $sql, $params);
?> 
<p>&nbsp;</p>
<div class="admin_periodos_notas_view_script_acc">
<table class="table_striped">
<thead>
        <tr>
          <th colspan="10"> PROCESO DE CALIFICACIÓN  
          	<button type="button" class="btn btn-default btn-xs" onclick="nota_refe_add()" style="float:right">
            	<span class="fa fa-plus"></span>  
            </button>
           </th>
        </tr>
      </thead>
<?php $cc=0;  while ($row_nota_refe_cab_view_deta = sqlsrv_fetch_array($nota_refe_cab_view_deta)){ $cc+=1; ?>
  <tr>
    <td width="5%" height="25">
		 	R<?= $row_nota_refe_cab_view_deta['nota_refe_acc_orde'] ; ?>=
    </td>
    <td width="10%" align="center" valign="middle">
		<input  type="text"  value="<?= $row_nota_refe_cab_view_deta['nota_refe_1'] ; ?>" id="nota_refe_1_<?= $cc; ?>"  ?>
    </td>
    <td width="5%" align="center" valign="middle"> 
    	<select id="nota_refe_cc_<?= $cc; ?>" style=" width:35px;" >
		<?php  	
			$params = array();
			$sql="{call nota_refe_CC_view()}";
			$nota_refe_CC_view = sqlsrv_query($conn, $sql, $params);
			while ($row_nota_refe_CC_view = sqlsrv_fetch_array($nota_refe_CC_view)){  ?>
			<option value="<?=  $row_nota_refe_CC_view['nota_refe_cc'];  ?>" <? if ($row_nota_refe_CC_view['nota_refe_cc']==$row_nota_refe_cab_view_deta['nota_refe_cc']) echo 'selected="selected"'?>  >
					<?=  $row_nota_refe_CC_view['nota_refe_cc'];  ?> 
			</option>
		<?php 	 } ?>
        </select>
    </td>
    <td width="10%" align="center" valign="middle">
		<input  type="text"  value="<?= $row_nota_refe_cab_view_deta['nota_refe_2'] ; ?>" id="nota_refe_2_<?= $cc; ?>" ?>
	</td>
	<td width="15%" align="center" valign="middle">
		<select id="nota_refe_func_dec_<?=$cc?>">
			<option value="R" <? if ($row_nota_refe_cab_view_deta['nota_refe_func_dec']=="R") echo 'selected="selected"'?>>Redondear</option>
			<option value="T" <? if ($row_nota_refe_cab_view_deta['nota_refe_func_dec']=="T") echo 'selected="selected"'?>>Truncar</option>
		</select>
	</td>
	<td width="10%" align="center" valign="middle">
		<select id="nota_refe_num_dec_<?=$cc?>">
			<option value="1" <? if ($row_nota_refe_cab_view_deta['nota_refe_num_dec']==1) echo 'selected="selected"'?>>1</option>
			<option value="2" <? if ($row_nota_refe_cab_view_deta['nota_refe_num_dec']==2) echo 'selected="selected"'?>>2</option>
			<option value="3" <? if ($row_nota_refe_cab_view_deta['nota_refe_num_dec']==3) echo 'selected="selected"'?>>3</option>
			<option value="4" <? if ($row_nota_refe_cab_view_deta['nota_refe_num_dec']==4) echo 'selected="selected"'?>>4</option>
		</select>
	</td>
    <td width="5%" align="center" valign="middle">
    	<button class="" onclick="nota_refe_upt_cc(<?= $cc; ?>,<?= $row_nota_refe_cab_view_deta['nota_refe_cod'] ; ?>)"><span class="fa fa-book"></span></button>
	</td>
    <td width="5%" align="center" valign="middle">
		<button class="" onclick=" nota_refe_del(<?= $row_nota_refe_cab_view_deta['nota_refe_cod'] ; ?>)"><span class="fa fa-close"></span></button>
	</td>
    <td width="5%" align="center" valign="middle">
    	<button class="" onclick="nota_refe_pos('D',<?= $row_nota_refe_cab_view_deta['nota_refe_cod'] ; ?>)"><span class=" fa fa-chevron-down"></span></button>
	</td>
    <td width="5%" align="center" valign="middle">
		<button class="" onclick="nota_refe_pos('U',<?= $row_nota_refe_cab_view_deta['nota_refe_cod'] ; ?>)"><span class="fa fa-arrow-up"></span></button>
	</td>
  </tr> 
  <?php 	 } ?>
</table>
</div>
 
<input  type="hidden"  id="peri_dist_codi_in" value="<?= $peri_dist_codi; ?>" />