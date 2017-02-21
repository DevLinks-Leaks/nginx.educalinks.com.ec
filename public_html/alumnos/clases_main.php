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
                data-parent="#accordion" aria-expanded="false" aria-controls="mate_b_<?= $row_curs_mate_view['curs_para_mate_codi'];?>" href="#mate_b_<?= $row_curs_mate_view['curs_para_mate_codi'];?>" >
                <span class="glyphicon glyphicon-chevron-down"></span>
                    <?= mb_strtoupper($row_curs_mate_view["mate_deta"]); ?>

                  <div class="opciones" style="float: right;margin-right: 2%; display: inline;">


                  <span class="glyphicon glyphicon-book"></span>
                    Materiales: 
                    <?php 
                    $params_mater = array($row_curs_mate_view['curs_para_mate_prof_codi']);
                    $sql_mater="{call curs_para_mate_mater_view(?)}";
                    $stmp_mater = sqlsrv_query($conn, $sql_mater, $params_mater);
                    $cont=0;
                    while($row_mater_view = sqlsrv_fetch_array($stmp_mater)){
                      $cont++;
                    } ?>
                    <?= $cont; ?>
                </div>  
              </a>
        </h4>
    </div>
    <div id="mate_b_<?= $row_curs_mate_view['curs_para_mate_codi'];?>" 
        class="panel-collapse collapse" role="tabpanel" 
        aria-labelledby="mate_h_<?= $row_curs_mate_view['curs_para_mate_codi'];?>">
        <div class="panel-body">

          <!-- Materiales -->
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title"><span class="glyphicon glyphicon-book"></span> Materiales</h3>
            </div>
            <div class="panel-body">
              
              <?php 
                $params_mater = array($row_curs_mate_view['curs_para_mate_prof_codi']);
                $sql_mater="{call curs_para_mate_mater_view(?)}";
                $stmp_mater = sqlsrv_query($conn, $sql_mater, $params_mater);?>
                
                    <table class="table table-responsive">
                        <thead>
                            <tr>
                              <th>Detalle</th>
                              <th>Fecha</th>
                              <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php while($row_mater_view = sqlsrv_fetch_array($stmp_mater)){?>
                            <tr>
                              <td>
                                <dl>
                                  <dt><?= $row_mater_view['mater_titu'];?></dt>
                                  <dd><?= $row_mater_view['mater_deta'];?></dd>
                                </dl>
                              </td>
                              <td><h5><?= date_format($row_mater_view['mater_fech_regi'],'d/m/Y');?></h5></td>
                              <td>
                                <div class="menu_options">
                                  <a class="btn btn-success" target="_blank" href="<?= $_SESSION['ruta_materiales_carga'].$row_mater_view['mater_file'];?>" ><span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span> Descargar</a>
                                  
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
  <?php }
    }
  ?>
</div>