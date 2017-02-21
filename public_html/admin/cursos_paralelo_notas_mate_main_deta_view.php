<?php 
	/*session_start();
	 
	include ('../framework/dbconf.php');
	include ('../framework/funciones.php');
	include ('../framework/cls_SQLServerConnection.php');
	*/
	
	$params = array($peri_dist_codi,$curs_para_mate_codi);
	$sql="{call peri_dist_padr_view_NEW(?,?)}";
	$peri_dist_padr_view = sqlsrv_query($conn, $sql, $params); 
	
	$params = array( $curs_para_mate_codi, $peri_dist_codi );
	$sql="{call curs_para_nota_peri_dist_view_NEW(?,?)}";
	
	$curs_para_nota_peri_dist_view = sqlsrv_query( $conn, $sql, $params, array( 'Scrollable' => 'buffered' ) ); 
	
	$row_curs_para_nota_peri_dist_view = sqlsrv_fetch_array( $curs_para_nota_peri_dist_view );
	$CC_COLUM = $row_curs_para_nota_peri_dist_view['CC_COLUM'];
	
	sqlsrv_next_result( $curs_para_nota_peri_dist_view );
	
	$cc = 0;
	$CC_COLUM_index=0;
	
	$params = array( $curs_para_mate_codi );
	$sql="{call curs_para_mate_info_NEW(?)}";
	$curs_para_mate_info = sqlsrv_query( $conn, $sql, $params );
	$row_curs_para_mate_info = sqlsrv_fetch_array( $curs_para_mate_info );
	
?>


<form method="post" id="frm_notas" action="cursos_paralelo_notas_mate_main_deta_resp.php" enctype="multipart/form-data">
	<input id="CC_COLUM_index" 	name="CC_COLUM_index" 	value="<?= $CC_COLUM; ?>" 	type="hidden"  />
	<input id="graba" 			name="graba" 			value="S" 					type="hidden" />
<?php
echo '
<table class="table_striped">'.
	'<thead>'.
        '<tr>'.
           '<th align="left">#</th>'.
           '<th align="left">Alumnos</th>';
				$count_columnas=0;
				while($row_peri_dist_padr_view= sqlsrv_fetch_array($peri_dist_padr_view))  
				{ 	$cc +=1;
					$count_columnas++;
					echo '<th class="left">'.$row_peri_dist_padr_view['peri_dist_abre'].
						 '	<input type="hidden" value="' . $row_peri_dist_padr_view['peri_dist_codi'] . '" name="peri_dist_codi_'. $cc.'"/>'.
						 '	<input type="hidden" value="' . $row_peri_dist_padr_view['peri_dist_nota_tipo'].'" id="peri_dist_nota_tipo_'. $cc.'"/>';
					$peri_dist_nota_tipo[$cc]= $row_peri_dist_padr_view['peri_dist_nota_tipo'];
					echo '	<input type="hidden" value="'. $count_columnas.'" id="count_columnas" />';
					echo '	</th>';
					
				}
				$cc =0;      
                echo '	<th align="left">&nbsp;&nbsp;&nbsp;
						</th>
					</tr>
				</thead>
				<tbody>';
				$cont_fila=1;
				$filas=sqlsrv_num_rows( $curs_para_nota_peri_dist_view );
				
				while ($row_curs_para_nota_peri_dist_view= sqlsrv_fetch_array($curs_para_nota_peri_dist_view)) 
				{	$cc +=1; 
					echo "<tr>".
					  "<td class='center'>" . $cc . "</td>".
					  "<td>". $row_curs_para_nota_peri_dist_view['alum_codi']." - ".$row_curs_para_nota_peri_dist_view['alum_curs_para_mate_codi']." - ".
						"<input 
							type='hidden'".
							"value='". $row_curs_para_nota_peri_dist_view['alum_curs_para_mate_codi']."'".
							"name='alum_curs_para_mate_codi_". $cc."'".
							"id='alum_curs_para_mate_codi_". $cc ."'/>".
							$row_curs_para_nota_peri_dist_view['alum_apel'] . " " . $row_curs_para_nota_peri_dist_view['alum_nomb'].
					  "</td>";
						  
					$cont_focus=0; 
					$CC_COLUM_index =0; 
					while($CC_COLUM_index <= $CC_COLUM)
					{
						echo '<td align="right" >';
						if (($CC_COLUM_index < $CC_COLUM) and ($peri_dist_nota_tipo[$CC_COLUM_index+1]=='IN'))
						{	if ($row_curs_para_mate_info['nota_refe_cab_tipo']=='C')
							{	?>
								<input type="text" value="<?= truncar($row_curs_para_nota_peri_dist_view[$CC_COLUM_index + 10]); ?>" name="nota_<?= $cc;?>_<?= $CC_COLUM_index;?>" style="width:70px;" placeholder='0.00' onChange="TEXTVALI(this,<?= $row_curs_para_nota_peri_dist_view[$CC_COLUM_index + 10]; ?>,<?= peri_nota_max($_SESSION['peri_codi']);?>)" pattern = "^0*[1-9][0-9]*(\.[0-9]+)?|0+\.[0-9]*[1-9][0-9]*$" step="0.01" max="10" tabindex="<?= (($filas*$cont_focus)+$cont_fila);?>"/>
                                <?php 
							} 
							else 
							{	
								$params = array($_SESSION['peri_codi'],$row_curs_para_mate_info['nota_refe_cab_cod']);
								$sql="{call nota_peri_cual_view(?,?)}";
								$nota_peri_cual_view = sqlsrv_query($conn, $sql, $params); 
								echo "<select name='nota_". $cc . "_" . $CC_COLUM_index. "'>";
								while ($row_nota_peri_cual_view = sqlsrv_fetch_array($nota_peri_cual_view))
								{
									?>
									<option 
										value="<?=$row_nota_peri_cual_view['nota_peri_cual_fin']?>"
										<?= substr($row_nota_peri_cual_view['nota_peri_cual_fin'], 0, -2)==substr($row_curs_para_nota_peri_dist_view[$CC_COLUM_index + 10], 0, -2)?'selected':''; ?>>
										<?= '('.$row_nota_peri_cual_view['nota_peri_cual_refe'].') '.$row_nota_peri_cual_view['nota_peri_cual_deta'];?>
                                        
									</option>
									<?
								}
								echo "</select>";
							}
						}
						else
						{	//muestra promedio
							if ($row_curs_para_mate_info['nota_refe_cab_tipo']=='C')
							{	?>
								<?php
								echo truncar($row_curs_para_nota_peri_dist_view[$CC_COLUM_index + 10]);
							}else
							{	echo nota_peri_cual_cons ($_SESSION['peri_codi'],$row_curs_para_mate_info['nota_refe_cab_cod'],$row_curs_para_nota_peri_dist_view[$CC_COLUM_index + 10]);
							}
						}
						// SUMAS PARA PROMEDIO DE COLUMNAS 
						$prom_cc[$CC_COLUM_index] =  $prom_cc[$CC_COLUM_index] + 1;  
						$prom[$CC_COLUM_index] =  $prom[$CC_COLUM_index] + $row_curs_para_nota_peri_dist_view[$CC_COLUM_index + 10]; 
						echo '</td>';
						$cont_focus++;					
						$CC_COLUM_index+=1;
					}
					$cont_fila++;
                    echo '	<td>&nbsp;</td>
						</tr>';
				}
				if ($row_curs_para_mate_info['nota_refe_cab_tipo']=='C') 
				{	echo "<tr><td>&nbsp;</td><td>&nbsp;</td>";
					$CC_COLUM_index =0; 
					while($CC_COLUM_index <= $CC_COLUM )
					{	echo '<td align="right">&nbsp;
								<strong>'.number_format(($prom[$CC_COLUM_index]/$prom_cc[$CC_COLUM_index]), 2, '.', '')."</strong>
							  </td>";
						$CC_COLUM_index+=1;
					}
					echo "<td>&nbsp;</td>
						</tr>
						 <tr>
						  <td>&nbsp;</td><td>&nbsp;</td>";
					$CC_COLUM_index =0;
					while($CC_COLUM_index <= $CC_COLUM) 
					{ 	echo '<td align="right">&nbsp;</td>';
						$CC_COLUM_index+=1;
					}
					echo "<td>&nbsp;</td>
					</tr>";
				}
	echo '</tbody>
</table>';
?>
	<input id="cc" name="cc" value="<?= $cc; ?>" type="hidden"  />
	<input id="curs_para_mate_codi" name="curs_para_mate_codi"	value="<?= $curs_para_mate_codi; ?>" 	type="hidden"  />
	<input id="peri_dist_codi" 		name="peri_dist_codi" 		value="<?= $peri_dist_codi; ?>" 		type="hidden"  />
	<input id="alum_codi" 			name="alum_codi" 			value="<?= $alum_codi; ?>" 				type="hidden"  />
	<div style="width:95%; height:90; text-align:right; clear: both">
		<table width="400" border="0" cellpadding="0" cellspacing="0"   style="float:right;">
			<tr>
				<td height="120" align="left" valign="middle">
					<input class="btn btn-primary" type="button" onClick="ejecutar_submit('frm_notas');" value="Grabar"/>
				</td>
				<td height="80" align="left" valign="middle">
					<input type="reset" class="btn btn-primary" value="Cancelar">
				</td>
			</tr>
		</table>
	</div>
</form>
<script type="text/javascript">
	$(document).ready(function() {
    $("input.cls_validar").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
             // Allow: Ctrl+A
            (e.keyCode == 65 && e.ctrlKey === true) || 
             // Allow: home, end, left, right
            (e.keyCode >= 35 && e.keyCode <= 39)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) 
		{
			e.preventDefault();
        }		
    });
 });
</script>
