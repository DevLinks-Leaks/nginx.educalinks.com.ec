<div class="container-fluid">   
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <table class="table table-striped table-hover table-responsive" id="table_cons_libros_items" data-page-length='8'>
                <thead>
                    <tr>
                        <th width="5%">Codigo</th>
                        <th width="20%">ISBN/ISSN</th>
                        <th width="35%">Título</th>
                        <th width="20%">Editorial</th>
                        <th width="20%">Colección</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    session_start();     
                    include ('../../../framework/dbconf.php');

                    if(isset($_POST['recu_tipo_codi'])){  $recu_tipo_codi=$_POST['recu_tipo_codi']; } else {$recu_tipo_codi=1;}

                    $params = array($recu_tipo_codi);
                    $sql="{call lib_prest_recu_view(?)}";
                    $lib_prest_recu_view = sqlsrv_query($conn, $sql, $params);
                    while($row_lib_prest_recu_view = sqlsrv_fetch_array($lib_prest_recu_view)){

                    ?>
                   <tr class="cursor_link" style="cursor: pointer;">
                        <td><?=$row_lib_prest_recu_view['recu_codi']?></td>
                        
                        <?php if($row_lib_prest_recu_view['recu_tipo_codi']==0){?>
                        <td><?= $row_lib_prest_recu_view['recu_isbn'];?> </td>
                        <?php }elseif($row_lib_prest_recu_view['recu_tipo_codi']==1){?>
                        <td><?= $row_lib_prest_recu_view['recu_isbn'];?> </td>
                        <?php }else{?>
                        <td> </td>
                        <?php } ?> 

                        <td><?=$row_lib_prest_recu_view['recu_titu']?></td>
                        <td><?=$row_lib_prest_recu_view['edit_deta']?></td>
                        <td><?=$row_lib_prest_recu_view['cole_deta']?></td>     
                    </tr>
                    <?php }?>
                </tbody>
            </table>
        </div>
    </div>
</div>