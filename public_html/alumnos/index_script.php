<?php
	session_start(); 
	include ('../framework/dbconf.php');
?>
<div class="row">
	<div class="col-md-7">
	    <div class="panel-group" role="tablist" id="accordion" aria-multiselectable="true" >        
	        <?php
	        $params_mate = array($_SESSION['alum_codi'],$_SESSION['curs_para_codi']);
	        $sql_mate="{call alum_curs_peri_mate_view(?,?)}";
	        $stmp_mate = sqlsrv_query($conn, $sql_mate, $params_mate); 
	        while($row_curs_mate_view=sqlsrv_fetch_array($stmp_mate)){
				if ($row_curs_mate_view['curs_para_mate_agen']==1) 
				{?>
	                        
	            <div class="panel panel-default">
	                <div class="panel-heading" role="tab" id="mate_h_<?= $row_curs_mate_view['curs_para_mate_codi'];?>">
	                    <h4 class="panel-title">
	                        <a  role="button"
	                            data-toggle="collapse" 
	                            data-parent="#accordion" aria-expanded="false" aria-controls="mate_b_<?= $row_curs_mate_view['curs_para_mate_codi'];?>" 
	                            href="#mate_b_<?= $row_curs_mate_view['curs_para_mate_codi'];?>" >
	                        
	                              
	                               <span class="glyphicon glyphicon-chevron-down"></span>
	                               <?= mb_strtoupper($row_curs_mate_view["mate_deta"]); ?>
	                             

	                            <div class="opciones" style="float: right;margin-right: 2%; display: inline;">


	                              <span class="glyphicon glyphicon-calendar"></span>
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
	                    </h4>
	                </div>
	                <div id="mate_b_<?= $row_curs_mate_view['curs_para_mate_codi'];?>" 
	                    class="panel-collapse collapse" role="tabpanel" 
	                    aria-labelledby="mate_h_<?= $row_curs_mate_view['curs_para_mate_codi'];?>">
	                    <div class="panel-body">

                            <!-- PROFESOR -->
                            <div class="panel panel-default">
							  	<div class="panel-heading">
								    <h3 class="panel-title"><span class="glyphicon glyphicon-user"></span> Profesor</h3>
							  	</div>
							  	<div class="panel-body">
							  		<?php
                                    $ruta=$_SESSION['ruta_foto_docente'];
                                    $full_name=$ruta.$row_curs_mate_view['prof_codi'].".jpg";
                                    $file_exi=$full_name;
                                    if (file_exists($file_exi)){
                                      $pp=$file_exi;
                                    } else {
                                      $pp=$_SESSION['foto_default'];
                                    }?>
                                    <div class="row">
                                    	<div class="col-md-2"><img src="<?php echo $pp;?>" title="<?= $row_curs_mate_view['prof_nomb']?>"  border="0" style="border-color:#F0F0F0;" class="img-responsive"/></div>
									    <div class="col-md-10">
									        <div class="row">
									            <div class="col-md-12"><h4><?= $row_curs_mate_view["prof_nomb"]; ?></h4></div>
									            <div class="col-md-12"><h5><b><?= $row_curs_mate_view["prof_mail"]; ?><b></h5></div>
									        </div>
									    </div>
									</div>
							  	</div>
							</div>
							<!-- AGENDA -->
							<div class="panel panel-default">
							  	<div class="panel-heading">
								    <h3 class="panel-title"><span class="glyphicon glyphicon-list"></span> AGENDA</h3>
							  	</div>
							  	<div class="panel-body">
							  		<?php 
                                    $tipo_usua="A";
                                    $params_agen = array($row_curs_mate_view['curs_para_mate_prof_codi'],$tipo_usua);
                                                    
                                    $sql_agen="{call agen_curs_para_mate_view(?,?)}";
                                    $stmp_agen = sqlsrv_query($conn, $sql_agen, $params_agen); 
                                    while($row_agen_curs_view= sqlsrv_fetch_array($stmp_agen)){?>
                                    <div class="row">
                                    	<div class="col-md-10"><?=$row_agen_curs_view['agen_titu']?></div>
                                    	<div class="col-md-2"><?=date_format($row_agen_curs_view['agen_fech_fin'], 'd/m/Y')?></div>
                                    </div>
                                    <?php } ?>
							  	</div>
							</div>
	                    </div>
	                </div>
	            </div> 
		    <?php } 
			} ?>
    	</div>
    </div>
	<div class="col-md-5">

	    <div class="panel panel-default">
	        <div class="panel-heading">
	            <span class="icons icon-users"></span>COMPAÑEROS DE CURSO:
	        </div>
	        <div class="panel-body">

	            <?php 
	            $params_compa = array($_SESSION['curs_para_codi']);
	            $sql_compa="{call curs_para_alums_view(?)}";
	            $stmp_compa = sqlsrv_query($conn, $sql_compa, $params_compa); 
	            $colum=6;
	            ?>
	            
	            <?php $cont=0; while($row_compas_view = sqlsrv_fetch_array($stmp_compa)){?>

	            <?php
	                $ruta=$_SESSION['ruta_foto_alumno'];
	                $full_name = $ruta . $row_compas_view['alum_codi'].".jpg";
	                $file_exi=$full_name;
	                if (file_exists($file_exi)){
	                    $pp=$file_exi;
	                } else {
	                    $pp=$_SESSION['foto_default'];
	                }
	            ?>
	                
	                <div class="col-md-2 col-sm-2 col-xs-2 col-lg-2" id="div_foto_<?=$row_compas_view['alum_codi']?>" >
	                    <img src="<?php echo $pp;?>" title="<?= $row_compas_view['alum_apel']." ".$row_compas_view['alum_nomb']?>"  border="0"  class="img-thumbnail" style="border-color:#F0F0F0; width: 50px !important;height: 60px !important;"/>
	                </div>

	            <?php $cont++; if($cont==$colum){echo "<div style='float:none; width:100%; height:55px;'>&nbsp;</div>"; $cont=0;}?>
	                            
	            <?php } ?>
	        </div>
	    </div>

	</div>
</div>