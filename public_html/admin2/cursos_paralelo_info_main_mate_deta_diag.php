<?php 
	session_start();	 
	include ('../framework/dbconf.php');
	
	if(isset($_POST['prof_codi'])) 
		$prof_codi=$_POST['prof_codi'];
		
	if(isset($_POST['aula_codi'])) 
		$aula_codi=$_POST['aula_codi'];
		
	if(isset($_POST['curs_para_mate_codi'])) 
		$curs_para_mate_codi=$_POST['curs_para_mate_codi'];
		
	if(isset($_POST['curs_para_mate_prof_codi'])) 
		$curs_para_mate_prof_codi=$_POST['curs_para_mate_prof_codi'];
		
	$params = array();
	$sql="{call prof_view()}";
	$prof_view = sqlsrv_query($conn, $sql, $params);  
?>
<div class="form_element">
 <table class="table" width="100%;" cellspacing="0" cellpadding="0" border="0">
 <tbody>
  <tr>
    <td width="25%" style="padding-top: 10px;">Profesor</td>
    <td style="padding-top: 10px;">
        <input 
            type="hidden" 
            value="<?= $curs_para_mate_codi; ?>" 
            id="curs_para_mate_codi" 
            name="curs_para_mate_codi" />
        <input 
            type="hidden" 
            value="<?= $curs_para_mate_prof_codi; ?>" 
            id="curs_para_mate_prof_codi" 
            name="curs_para_mate_prof_codi" />

		<select id="prof_codi" name="prof_codi" class="select" style="width: 100%"> 
		<?php   
			while ($row_prof_view = sqlsrv_fetch_array($prof_view))
			{
		?>
			<option 
            	value="<?php echo $row_prof_view['prof_codi'] ; ?>"  
					   <?php if ($prof_codi==$row_prof_view['prof_codi']) 
					   echo 'selected="selected"';?> > 
					   		<?= $row_prof_view['prof_apel'] ; ?> <?= $row_prof_view['prof_nomb'] ; ?>
			</option>

		<?php 	 
			} 
		?>
        </select>
    </td>
  </tr>
  <tr>
    <td width="25%" style="padding-top: 10px;">Aula</td>
    <td style="padding-top: 10px;">
    	<select id="aula_codi" name="aula_codi"  class="select" style="width: 25%"> 
		<?php 
			$params = array();
            $sql="{call aula_view()}";
            $aula_view = sqlsrv_query($conn, $sql, $params);
			while ($row_aula_view = sqlsrv_fetch_array($aula_view))
			{ 
		?>
			<option 
            	value="<?php echo $row_aula_view['aula_codi'] ;?>"  
				<?php if ($aula_codi==$row_aula_view['aula_codi']) echo 'selected="selected"';?>> 
					<?= $row_aula_view['aula_deta'] ; ?>  
			</option>

		<?php
        	}
		?>
		</select>
	</td>
  </tr>
  </tbody>
</table>
</div>
<div class="form_element">&nbsp;</div> 