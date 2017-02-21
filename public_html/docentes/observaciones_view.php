
<?php 

	session_start();	 
	include ('../framework/dbconf.php');
	include ("../framwork/funciones.php");					 
	
	$params = array($_SESSION['prof_codi'],$_SESSION['peri_codi']);
	$sql="{call prof_curs_para_view(?,?)}";
	$prof_curs_para_mate_view = sqlsrv_query($conn, $sql, $params);  
	$cc = 0; 
?> 

<div class="zones">
  <div class="docentes_observaciones">
<table class=" table_striped ">
    <tbody>
    	<tr>
    	<td>
		<?php
			$params_mate = array($_SESSION['prof_codi'],$_SESSION['peri_codi']);
			$sql_mate="{call prof_curs_para_mate_view(?,?)}";
			$stmp_mate = sqlsrv_query($conn, $sql_mate, $params_mate); 
			while($row_curs_mate_view=sqlsrv_fetch_array($stmp_mate))
				{
					if ($row_curs_mate_view['curs_para_mate_agen']==1) 
					{
				?>
			<div class="accordion" id="mate_h<?= $row_curs_mate_view['curs_para_mate_codi'];?>">
              <div class="accordion-group">
                <div class="accordion-heading">
                
                  <a class="accordion-toggle" data-toggle="collapse" data-parent="#mate_h<?= $row_curs_mate_view['curs_para_mate_codi'];?>" href="#mate_b_<?= $row_curs_mate_view['curs_para_mate_codi'];?>">
                  
				  	<div style=" width:70%;float:left;" ><?= $row_curs_mate_view["curs_deta"]." ".$row_curs_mate_view["para_deta"]." / ".$row_curs_mate_view["mate_deta"]; ?>
                    </div>
                    
                    <div style=" text-align:right;">
                    	<br />
                    </div>
                    
                  </a>
                </div>
                
                <div id="mate_b_<?= $row_curs_mate_view['curs_para_mate_codi'];?>" class="accordion-body collapse in">
                  <div  id="mate-inner_<?= $row_curs_mate_view['curs_para_mate_codi'];?>" class="accordion-inner">
                  	<div style="width:100%;float:left;">
                    <?php
						$params2 = array($row_curs_mate_view['curs_para_codi']);
						$sql2="{call alum_curs_para_view(?)}";
						$alum_curs_para_view = sqlsrv_query($conn, $sql2, $params2); 
					?>
                    <table class=" table_striped ">
                    <thead>
                        <tr>
                            <th width="5%"></th>
                            <th width="5%"></th>
                            <th width="80%">Alumnos</th>
                            <th width="10%">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
							<?php 
                            $cc=0; 
                            while ($row_alum_curs_para_view = sqlsrv_fetch_array($alum_curs_para_view)) 
                            { 
                                $cc +=1; 
                            ?> 
	            		<tr>
							<?php
                            $file_exi=$_SESSION['ruta_foto_alumno'].$row_alum_curs_para_view["alum_codi"].'.jpg';
                
                            if (file_exists($file_exi)) 
                            {
                                $pp=$file_exi;
                            } 
                            else 
                            {
                                $pp='../fotos/'.$_SESSION['directorio'].'/alumnos/0.jpg';
                            }
                            ?>
                          <td class="center" width="5%">
                            <?php echo $cc; ?>
                          </td>
                          <td class="center" width="5%">
                            <img src="<?php echo $pp; ?>"  style="width:20px; height:20px;"/>
                          </td>
                          <td class="left" width="80%">
                           <?= $row_alum_curs_para_view["alum_codi"];?>
                           - <?= $row_alum_curs_para_view["alum_apel"].' '.$row_alum_curs_para_view["alum_nomb"];?>
                          </td>
                          <td width="10%">
                              <div class="menu_options">
                                  <button
                                      class="icon-pencil btn btn-primary"
                                      onClick="window.location='observaciones_main.php?alum_curs_para_codi=<?= $row_alum_curs_para_view["alum_curs_para_codi"]?>'">
                                      Agregar
                                  </button>
                              </div>
                          </td>
                   		</tr>
	            <?php }?>
	              </tbody>
                </table>
                </div>
                </div>
                </div>
              </div>
            </div>
	<?php 
		}
				}
    ?>
	</td>
    </tr>
    </tbody>
</table>
</div>
</div>