<?php 
	session_start();	 
	include ('../framework/dbconf.php');
	include ('script_cursos.php'); 
 
	$peri_codi= $_GET['peri_codi'];
	$params = array($curs_para_codi);
	$sql="{call curs_peri_mate_view(?)}";
	$curs_peri_mate_view = sqlsrv_query($conn, $sql, $params);  
	$cc = 0;
?>
<div style="margin: 10px 10px;">
<? 	
	$peri_dist_nive=2;
	$params = array($curs_para_codi,$peri_dist_nive);
	$sql="{call peri_dist_peri_nive_view_NEW(?,?)}"; 
	$peri_dist_peri_nive_view = sqlsrv_query($conn, $sql, $params);  
?>
		<select id="sl_peri_dist_codi">
			<? while($row_peri_dist_peri_nive_view = sqlsrv_fetch_array($peri_dist_peri_nive_view))
			{ ?>
			<option value="<?= $row_peri_dist_peri_nive_view['peri_dist_codi'];?>">
			<?= (($row_peri_dist_peri_nive_view['peri_dist_padr_deta']=='')
				?$row_peri_dist_peri_nive_view['padre']:
				$row_peri_dist_peri_nive_view['peri_dist_padr_deta'].' - ').
				$row_peri_dist_peri_nive_view['peri_dist_deta']; 
			?>
			</option>
			<?php 	 
			} 
			?>
		</select> 
</div>
<table class=" table_striped " >
<thead>
    <tr>
        <th>#</th>             
        <th> Materias</th>
        <th>Aula</th>
        <th>Profesores</th>
        <th>&nbsp;</th>              
    </tr>
</thead>
<tbody>
<?php  
while ($row_curs_peri_mate_view = sqlsrv_fetch_array($curs_peri_mate_view)) 
{ 
	$cc +=1; 
?> 
    <tr>
        <td class="center">
			<?= $cc; ?>
		</td>
        <td>
			<?php echo $row_curs_peri_mate_view["mate_deta"];?>
		</td>
        <td>
			<?php 
				if  ($row_curs_peri_mate_view["mate_hijo_cc"] == 0)
				{ 
			?> 
            <?php 
				echo $row_curs_peri_mate_view["aula_deta"]; 
			?>
            <?php 
				}
			?>
        </td>
        <?php
			$file_exi=$_SESSION['ruta_foto_docente'].$row_curs_peri_mate_view["prof_codi"] . '.jpg';
			if (file_exists($file_exi)) 
			{
				$pp=$file_exi;
			} 
			else 
			{
				$pp=$_SESSION['ruta_foto_docente'].'0.jpg';
			}
		?>
        <td>
        	<?php 
			if  ($row_curs_peri_mate_view["prof_codi"] <> '')
			{ 
			?> 
        	<img 
            	src="<?php echo $pp; ?>" 
                width="58" 
                height="59"  
                style=" text-align:right; border:none; width:30px; height:30px;"/>
				<?php echo $row_curs_peri_mate_view["prof_nomb"]; ?> 
			<?php 
			}
			?>
        </td>
        <td>
            <div class="menu_options">
                <ul>
					<?php 
					$url="window.location='cursos_paralelo_notas_mate_main_deta.php?peri_dist_codi='".
					" + selectvalue(document.getElementById('sl_peri_dist_codi')) +'&curs_para_mate_codi=".
					$row_curs_peri_mate_view["curs_para_mate_codi"]."'";
						
					if ($row_curs_peri_mate_view["mate_hijo_cc"] == 0)
					{ 
						if (permiso_activo(211))
						{ 
					?> 
                    <li>
                    	<a 
                        	class="option" 
                            onclick="window.location='reportes_generales/notas_ingresadas_pdf.php?peri_dist_codi=' + selectvalue(document.getElementById('sl_peri_dist_codi')) +'&curs_para_mate_codi=<?= $row_curs_peri_mate_view["curs_para_mate_codi"]; ?>'"
                            target="_blank"> 
                    		<span class="icon-file icon"> </span>  Imprimir
                    	</a>
                    </li>
				</ul>
				<?	
						}
						
						if (permiso_activo(210))
						{
                ?>
				<ul> 
                    <li>
                    	<a class="option" onclick="<?= $url; ?>"> 
                    		<span class="icon-stats icon"></span>Editar
                    	</a>
                    </li>
			<?php 
						}
            		}
            ?>
            	</ul>
            </div>
        </td>
    </tr>
    <?php 
	}
	?>
</tbody>
</table>