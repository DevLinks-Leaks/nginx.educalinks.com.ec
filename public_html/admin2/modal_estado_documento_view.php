<?php 
	include ('../framework/dbconf.php');
	
	$params_docu = array($_SESSION['peri_codi'], '%');
	$sql_docu="{call docu_consulta(?,?)}";
	$docu_busq = sqlsrv_query($conn, $sql_docu, $params_docu);
	$i=0;
	$aux=array();
	while ($row_docu_busq = sqlsrv_fetch_array($docu_busq))
	{
		$aux[$i][0]=$row_docu_busq['docu_peri_codi'];
		$aux[$i][1]=$row_docu_busq['docu_descr'];
		$i++;
	}
	$alum_codi = $_POST["alum_codi"];
	$params_alum_docu = array($alum_codi, $_SESSION['peri_codi']);
	$sql_alum_docu="{call alum_info_docu(?,?)}";
	$docu_alum_docu = sqlsrv_query($conn, $sql_alum_docu, $params_alum_docu);
	$j=0;
	$aux2=array();
	while ($row_alum_docu = sqlsrv_fetch_array($docu_alum_docu))
	{
		$aux2[$j][0]=$row_alum_docu['docu_peri_codi'];
		$aux2[$j][1]=$row_alum_docu['alum_docu_peri_estado_documento'];
		$j++;
	}
	$x = $y = 0;
	$aux3=array();
	while($x<$i)
	{
		$f=0;
		$y=0;
		while($y<$j)
		{
			if($f==0)
			{
				if($aux[$x][0]==$aux2[$y][0])
				{
					$aux3[$x][0]=$aux[$x][0];
					$aux3[$x][1]=$aux[$x][1];
					$aux3[$x][2]=$aux2[$y][1];
					$f++;
				}
			}
			$y++;
		}
		if($f==0)
		{
			$aux3[$x][0]=$aux[$x][0];
			$aux3[$x][1]=$aux[$x][1];
			$aux3[$x][2]=0;
		}
		$x++;
	}
	$c=0;
?>
<table width='100%'>
	<tr>
		<td width='120px' height='40px' colspan='2' valign='bottom'><b>Documentos entregados</b></td>
	</tr>
	<tr>
		<td width='120px' height='1px' colspan='2'>
			<div style='font-size:1px'><hr style='height:1px; margin-top: 0.5em;' /></div>
		</td>
	</tr>
	<tr>
		<?php 
		if($i>0){
			while($c<$i){ 
				if($c%2==0){
					if($c!=0) echo '</tr>'
		?>
					<td width="50%">
						<input id='check_<?=$aux3[$c][0]?>' name='check_<?=$aux3[$c][0]?>' type='checkbox' <?= ($aux3[$c][2]==1)? 'checked' : '';?>	onClick="load_ajax_alum_docu('div_estado_documento', 'script_alum.php', 'alum_info_docu_check', this.checked, '<?=$alum_codi;?>', '<?=$_SESSION['peri_codi'];?>', '<?=$aux3[$c][0];?>');" >
						<label for='check_<?=$aux3[$c][0]?>' ><?=$aux3[$c][1];?></label>
					</td>
				<?}else{?>
					<td width="50%">
						<input id='check_<?=$aux3[$c][0]?>' name='check_<?=$aux3[$c][0]?>' type='checkbox' <?= ($aux3[$c][2]==1)? 'checked' : '';?>	onClick="load_ajax_alum_docu('div_estado_documento', 'script_alum.php', 'alum_info_docu_check', this.checked, '<?=$alum_codi;?>', '<?=$_SESSION['peri_codi'];?>', '<?=$aux3[$c][0];?>');" >
						<label for='check_<?=$aux3[$c][0]?>' ><?=$aux3[$c][1];?></label>
					</td>
				</tr>
				<?}
		?>

			
		<?php $c++;
			}
		}else{?>
			<td colspan='2' width='120px'><small><i>-No hay objetos en esta categor&iacute;a-</i></small></td>
		<?php } ?>
	</tr>
</table>