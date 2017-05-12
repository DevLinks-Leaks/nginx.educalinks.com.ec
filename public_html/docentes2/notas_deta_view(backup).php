<?php 

	session_start();	 
	include ('../framework/dbconf.php');
	include ('../framework/funciones.php');
			
	 
	$peri_dist_codi=$_GET['peri_dist_codi'];
	$curs_para_mate_prof_codi =$_GET['curs_para_mate_prof_codi'];
	$curs_para_mate_codi =$_GET['curs_para_mate_codi'];
	$nota_refe_cab_tipo =$_GET['nota_refe_cab_tipo'];
	$nota_refe_cab_codi =$_GET['nota_refe_cab_codi'];
 
	$params = array($peri_dist_codi,$curs_para_mate_codi);
	$sql="{call peri_dist_padr_view_NEW(?,?)}";
	$peri_dist_padr_view = sqlsrv_query($conn, $sql, $params); 
	
	$params = array($curs_para_mate_prof_codi,$peri_dist_codi);
	$sql="{call curs_para_nota_peri_dist_view_prof(?,?)}";
	$curs_para_nota_peri_dist_view = sqlsrv_query($conn, $sql, $params, array('Scrollable' => 'buffered')); 
	$row_curs_para_nota_peri_dist_view= sqlsrv_fetch_array($curs_para_nota_peri_dist_view);
	
	$CC_COLUM=$row_curs_para_nota_peri_dist_view['CC_COLUM'];
	 
	sqlsrv_next_result($curs_para_nota_peri_dist_view);
	  
	 
	$cc = 0;
	$CC_COLUM_index=0;
	
	$nota_perm_codi=$_GET['nota_perm_codi'];
	$params = array($nota_perm_codi);
	$sql="{call nota_perm_info(?)}";
	$nota_perm_info = sqlsrv_query($conn, $sql, $params); 
	$row_nota_perm_info= sqlsrv_fetch_array($nota_perm_info);
	
	// validacion si el permiso esta activa
	$aa=$row_nota_perm_info['nota_peri_esta_resu'];
	
?>
<input id="CC_COLUM_index" value="<?= $CC_COLUM; ?>" type="hidden"  />

<table class="table_striped" >
<thead>
	<tr>
   		<th align="left">#</th> 
      	<th align="left">Alumnos</th> 
      	<? 
		while($row_peri_dist_padr_view= sqlsrv_fetch_array($peri_dist_padr_view))  
		{ 
			$cc +=1 
		?>       
        <th class="left">
  			<?= $row_peri_dist_padr_view['peri_dist_abre']; ?>
            <input 
            	type="hidden" 
                value="<?= $row_peri_dist_padr_view['peri_dist_codi']; ?>" 
                id="peri_dist_codi_<?= $cc;?>"/>
                
            <input 
            	type="hidden" 
                value="<?= $row_peri_dist_padr_view['peri_dist_nota_tipo']; ?>" 
                id="peri_dist_nota_tipo_<?= $cc;?>"/>
                
            <?php  
				$peri_dist_nota_tipo[$cc]= $row_peri_dist_padr_view['peri_dist_nota_tipo'];
			?>  
        </th>    
      	<?php  
		}
		$cc =0;
		?> 
	</tr>
</thead>
<tbody>
    	<?php  
        $cont_fila=1;
        $filas=sqlsrv_num_rows( $curs_para_nota_peri_dist_view ); 
        while ($row_curs_para_nota_peri_dist_view= sqlsrv_fetch_array($curs_para_nota_peri_dist_view)) 
		{ 
			$cc +=1; 
		?> 
    <tr>
        <td class="center">
			<?= $cc;?>
		</td>
        <td> 
			<?= $row_curs_para_nota_peri_dist_view['alum_codi']; ?> -
            <input 
                type="hidden" 
                value="<?= $row_curs_para_nota_peri_dist_view['alum_curs_para_mate_codi']; ?>" 
                id="alum_curs_para_mate_codi_<?= $cc;?>" />
                <?= $row_curs_para_nota_peri_dist_view['alum_apel']; ?> 
				<?= $row_curs_para_nota_peri_dist_view['alum_nomb']; ?>
        </td>
			<? 
            $cont_focus=0;
            $CC_COLUM_index =0; while($CC_COLUM_index <= $CC_COLUM )  {?>       
            <td align="right" >
				<? 
                if (($CC_COLUM_index < $CC_COLUM) and ($peri_dist_nota_tipo[$CC_COLUM_index+1]=='IN') and $aa=='A') 
                {
                ?>
                	<? 
						if ($nota_refe_cab_tipo=='C') 
						{
					?>
                            <input  
                                type="text" 
                                maxlength="7"  
                                value="<?= number_format($row_curs_para_nota_peri_dist_view[$CC_COLUM_index + 10],2,'.',','); ?>" 
                                id="nota_<?= $cc;?>_<?= $CC_COLUM_index;?>"   
								min="0" 
                                max="<?= peri_nota_max($_SESSION['peri_codi']);?>"   
                                onChange="TEXTVALI(this,<?= $row_curs_para_nota_peri_dist_view[$CC_COLUM_index + 10]; ?>,<?= peri_nota_max($_SESSION['peri_codi']);?>)" 								
                                tabindex="<?= (para_sist(22)==0?(($filas*$cont_focus)+$cont_fila):0);?>">
					<? 
						} 
						else 
						{
					?>
							<?
                                $params = array($_SESSION['peri_codi'],$row_curs_para_mate_info['nota_refe_cab_cod']);
                                $sql="{call nota_peri_cual_view(?,?)}";
                                $nota_peri_cual_view = sqlsrv_query($conn, $sql, $params); 
                            ?>
							<select id="nota_<?= $cc;?>_<?= $CC_COLUM_index;?>">
							<?
                                while ($row_nota_peri_cual_view = sqlsrv_fetch_array($nota_peri_cual_view))
                                {
                            ?>
                                    <option 
                                        value="<?=$row_nota_peri_cual_view['nota_peri_cual_fin']?>"
                                        <?= ($row_nota_peri_cual_view['nota_peri_cual_fin']==
										$row_curs_para_nota_peri_dist_view[$CC_COLUM_index + 10]?'selected':''); ?>>
                                        
                                        <?= '('.$row_nota_peri_cual_view['nota_peri_cual_refe'].') '
										.$row_nota_peri_cual_view['nota_peri_cual_deta'];?>
                                    </option>
							<?
								}
							?>
							</select>
						<? 
                        } 
                        ?>
                <?php 
                }
                else 
                {
                ?>
                	<? if ($nota_refe_cab_tipo=='C') 
					{
					?>
                		<?= number_format($row_curs_para_nota_peri_dist_view[$CC_COLUM_index + 10], 2, '.', ''); ?>
                    <?
					}
					else
					{
					?>
                    	<?= 
							nota_peri_cual_cons ($_SESSION['peri_codi'],
												$nota_refe_cab_codi,
												$row_curs_para_nota_peri_dist_view[$CC_COLUM_index + 10]);
						?>
                    <?
					}
					?>
				<?php 
				}
				?>
                <?php
                // SUMAS PARA PROMEDIO DE COLUMNAS 
                  $prom_cc[$CC_COLUM_index] =  $prom_cc[$CC_COLUM_index] + 1;  
                  $prom[$CC_COLUM_index] =  $prom[$CC_COLUM_index] + $row_curs_para_nota_peri_dist_view[$CC_COLUM_index + 10]; 
                ?> 
          </td>
        	<?php 
            $cont_focus++;	
            $CC_COLUM_index+=1;
            } 
            $cont_fila++; 
            ?>    
    </tr>
		<?php 
        } 
        ?>
 <? 
 if ($nota_refe_cab_tipo=='C') 
 {
 ?>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
		<? 
		$CC_COLUM_index =0; 
		while($CC_COLUM_index <= $CC_COLUM )  
		{
		?>       
       		<td align="right">&nbsp;
         	<strong>
            <?= number_format(($prom[$CC_COLUM_index]/$prom_cc[$CC_COLUM_index]), 2, '.', ''); ?> 
       </strong>
       </td> 
     	<?php 
	 		$CC_COLUM_index+=1;
		}
		?>    
    </tr>
<?
 }
?>
</tbody>
</table>
<? if ($aa=='A') 
{
?>
	<div  style="width:95%; height:90; text-align:right; clear: both">
	<button 
    	class="btn btn-primary"
        style="margin: 40px 10px; width: 10%;" 
        onClick="curs_para_nota_peri_dist_save(<?=$peri_dist_codi;?>,<?=$curs_para_mate_codi;?>,<?=$nota_perm_codi;?>,<?=$curs_para_mate_prof_codi;?>,'<?=$nota_refe_cab_tipo;?>',<?=$nota_refe_cab_codi;?>);">  
        Grabar 	
	</button>
	
	<button 
    	class="btn btn-primary" 
        style="margin: 40px 10px; width: 10%;" 
        onClick="window.location='notas.php'">
        Cancelar
	</button>
</div>
<? 
} 
?>
<input id="cc" value="<?= $cc; ?>" type="hidden"  />