<?php 

	session_start();	 
	include ('../framework/dbconf.php');
	include ("../framwork/funciones.php");					 
	
	$params = array($_SESSION['prof_codi'],$_SESSION['peri_codi']);
	$sql="{call prof_curs_para_view(?,?)}";
	$prof_curs_para_mate_view = sqlsrv_query($conn, $sql, $params);  
	$cc = 0; 
?> 
<div class="zones docentes">
<table class="table_striped">
    <thead>
    <tr>
    <td><div class="title"><h4>Materias:</h4></div>
    </td>
    </tr>
    </thead>
    <tbody>
    <tr style="display:none;"><td></td></tr>
    <tr>
    <td>
	<?php
        $params_mate = array($_SESSION['prof_codi'],$_SESSION['peri_codi']);
        $sql_mate="{call prof_curs_para_mate_view(?,?)}";
        $stmp_mate = sqlsrv_query($conn, $sql_mate, $params_mate); 
        while($row_curs_mate_view=sqlsrv_fetch_array($stmp_mate)){
			if ($row_curs_mate_view["curs_para_mate_agen"] == 1)
			{?>
			<div class="accordion" id="mate_h<?= $row_curs_mate_view['curs_para_mate_codi'];?>">
              <div class="accordion-group">
                <div class="accordion-heading">
                  <a class="accordion-toggle" data-toggle="collapse" data-parent="#mate_h<?= $row_curs_mate_view['curs_para_mate_codi'];?>" href="#mate_b_<?= $row_curs_mate_view['curs_para_mate_codi'];?>">
				  	<div style=" width:70%;float:left;" ><?= $row_curs_mate_view["curs_deta"]." ".$row_curs_mate_view["para_deta"]." / ".$row_curs_mate_view["mate_deta"]; ?></div>
                    <div style=" text-align:right;">
                    	Agendas: 
                    	<?php 
						$tipo_usua="A";
						$params_agen = array($row_curs_mate_view['curs_para_mate_prof_codi'],$tipo_usua);
						$sql_agen="{call agen_curs_para_mate_view_cont(?,?)}";
						$stmp_agen = sqlsrv_query($conn, $sql_agen, $params_agen); 
						while($row_agen_curs_view= sqlsrv_fetch_array($stmp_agen)){?>
							<?=$row_agen_curs_view['cont_agen']?>
						<?php } ?>
                    </div>
                 
                  </a>
                </div>
                <div id="mate_b_<?= $row_curs_mate_view['curs_para_mate_codi'];?>" class="accordion-body collapse in">
                  <div  id="mate-inner_<?= $row_curs_mate_view['curs_para_mate_codi'];?>" class="accordion-inner">
                  	<div class="zone" >
                    <div class="container"> 

                    <table class="table_striped ">
                        <thead>
                            <tr>
                                <th>
                                    <span class="icons icon-list"></span>Agenda
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td  class="no-padding">

                         <div class="agenda_list">
                        <?php 
                        $tipo_usua="A";
                        $params_agen = array($row_curs_mate_view['curs_para_mate_prof_codi'],$tipo_usua);
                        $sql_agen="{call agen_curs_para_mate_view(?,?)}";
                        $stmp_agen = sqlsrv_query($conn, $sql_agen, $params_agen); 
                        while($row_agen_curs_view= sqlsrv_fetch_array($stmp_agen)){?>
                            <div class="agenda">
                            <div style="width:70%;float:left;"><?=$row_agen_curs_view['agen_titu']?></div>
                            <div style="width:30%;float:right;"><?=date_format($row_agen_curs_view['agen_fech_fin'], 'd/m/Y')?></div>
                            </div>
                        <?php } ?>
                        </div>



                                </td>
                            </tr>
                        </tbody>
                        
                    </table>
                   
                    	</div>
                    <div class="container"> 

                    <table class="table_striped ">
                        <thead>
                            <tr>
                                <th>
                                    <span class="icons icon-list"></span>Permisos de Notas 
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td  class="no-padding">



                         <div class="agenda_list">
                        <?php 
								 
						  
							$curs_para_mate_codi=$row_curs_mate_view['curs_para_mate_codi']; 
							$params = array($curs_para_mate_codi);
							$sql="{call nota_perm_view_acti_pend(?)}";
							$nota_perm_view_acti_pend = sqlsrv_query($conn, $sql, $params);  
							$cc = 0;
					  ?>
					  <?php  while($row_nota_perm_view_acti_pend= sqlsrv_fetch_array($nota_perm_view_acti_pend)){?>
                      		<?
                            	if ($row_nota_perm_view_acti_pend['nota_peri_esta_resu']=='A') $ColorDeEstado='#DFD'; 
								if ($row_nota_perm_view_acti_pend['nota_peri_esta_resu']=='P') $ColorDeEstado='#D7EBFF'; 
								
							
							?>
                      
                            <div class="agenda" style="background:<?=$ColorDeEstado;?>;">
                            <div style="width:50%;float:left;"><?=$row_nota_perm_view_acti_pend['peri_dist_deta']?></div>
                            
                            <div style="width:50%;float:right;">Inicio del Permiso:<?=date_format($row_nota_perm_view_acti_pend['nota_peri_fec_ini'], 'd/m/Y')?></div>
                            <div style="width:50%;float:left;">Estado: <?=$row_nota_perm_view_acti_pend['resu']?></div>
                            <div style="width:50%;float:right;">Fin del Permiso:<?=date_format($row_nota_perm_view_acti_pend['nota_peri_fec_fin'], 'd/m/Y')?></div>
                            </div>
                        <?php } ?>
                        </div>



                                </td>
                            </tr>
                        </tbody>
                        
                    </table>
                   
                    	</div>
                    </div>
                    
                        
                    
                   

                    <div class="zone-last">

<div class="container">


                    	<table class="table_striped">
						<?php 
                        $params_compa = array($row_curs_mate_view['curs_para_mate_prof_codi']);
                        $sql_compa="{call curs_para_prof_alums_view(?)}";
                        $stmp_compa = sqlsrv_query($conn, $sql_compa, $params_compa); 
                        $colum=6;
                        ?>
                        <thead>
                            <tr>
                              <th colspan="<?= $colum?>">
                                <span class="icons icon-users"></span>COMPAÑEROS DE CURSO:
                              </th>
                            </tr>
                        </thead>
                        <tbody>
                        <tr>
                        <td>
                        <?php $cont=0; while($row_compas_view = sqlsrv_fetch_array($stmp_compa)){?>
                            
                                <?php
                                        $cont++;
                                        $ruta=$_SESSION['ruta_foto_alumno'];
                                        $full_name=$ruta.$row_compas_view['alum_codi'].".jpg";
                                        $file_exi=$full_name;
                                        if (file_exists($file_exi)){
                                            $pp=$file_exi;
                                        } else {
                                            $pp=$_SESSION['foto_default'];
                                        }
                                        ?>
                                        <div id="div_foto_<?=$row_compas_view['alum_codi']?>" style="padding-left:5px;width:55px; height:55px;float:left">
                                            <img src="<?php echo $pp;?>" title="<?= $row_compas_view['alum_apel']." ".$row_compas_view['alum_nomb']?>"  border="0" style="border-color:#F0F0F0; width:50px; height:50px;"/>
                                        </div> 
                                        <?php if($cont==$colum){echo "<div style='float:none; width:100%; height:55px;'>&nbsp;</div>"; $cont=0;}?>
                            
                        <?php } ?>
                        </td>
                        </tr>
                        </tbody>
                        </table>
</div>
                    </div>
                  </div>
                </div>
              </div>
               
            </div>
	<?php }
	}
    ?>
	</td>
    </tr>
    </tbody>
</table>

</div>