<div class="container-fluid theme-showcase" role="main">
    <!-- region de edicion -->
    <div class="box">
        
        <div class="box-body" id="div_libro_main" >
            <div class="row">
                <div class="col-md-12">
                    <table id="tbl_recursos_reportes" class="cell-border table-responsive" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th width="40%" >Título</th>
                                <th width="15%">ISBN / ISSN</th>
                                <th width="15%">Tipo</th>
                                <th width="15%">Editorial</th>
                                <th width="15%">Colección</th>
                                <th width="15%">Autor</th>
                                <th width="15%">Director/Actor</th>>
                                <th width="15%">Fecha de Publicación</th>
                                <!-- <th width="15%">Duración</th> -->
                                <!-- <th width="15%">Resumen</th> -->
                                <th width="15%">Fecha de Registro</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                        session_start();	 
                        include ('../framework/dbconf.php');

                        $params = array();
                        $sql="{call lib_recu_view()}";
                        $recu_view = sqlsrv_query($conn, $sql, $params);
                        while($row_recu_view = sqlsrv_fetch_array($recu_view)){
                        ?>
                            <tr>
                                <td ><?= $row_recu_view['recu_titu'];?> </td>
                                <?php if($row_recu_view['recu_tipo_codi']==1){?>
                                <td width="15%"><?= $row_recu_view['recu_isbn'];?> </td>
                                <?php }elseif($row_recu_view['recu_tipo_codi']==2){?>
                                <td width="15%"><?= $row_recu_view['recu_issn'];?> </td>
                                <?php }else{?>
                                <td width="15%"> </td>
                                <?php } ?>
                                <td><?= $row_recu_view['tipo_deta'];?> </td>
                                <td><?= $row_recu_view['edit_deta'];?> </td>
                                <td><?= $row_recu_view['cole_deta'];?> </td>
                                <td><ul >
                                <?php 
                                    $params = array($row_recu_view['recu_codi']);
                                    $sql="{call lib_recu_auto_view(?)}";
                                    $lib_recu_auto_view = sqlsrv_query($conn, $sql, $params);
                                    while($row_lib_recu_auto_view = sqlsrv_fetch_array($lib_recu_auto_view)){
                                        if($row_lib_recu_auto_view['auto_tipo']=='A'){
                                ?>
                                <li><?= $row_lib_recu_auto_view['auto_apel'].' '.$row_lib_recu_auto_view['auto_nomb'] ;?></li>
                                <?php  }} ?>
                                <ul></td>
                                <td><ul class="list-unstyled">
                                <?php 
                                    $params = array($row_recu_view['recu_codi']);
                                    $sql="{call lib_recu_auto_view(?)}";
                                    $lib_recu_auto_view = sqlsrv_query($conn, $sql, $params);
                                    while($row_lib_recu_auto_view = sqlsrv_fetch_array($lib_recu_auto_view)){
                                        if($row_lib_recu_auto_view['auto_tipo']!='A'){
                                ?>
                                <li><?= '<b>'.$row_lib_recu_auto_view['auto_tipo_deta'].'</b>: '.$row_lib_recu_auto_view['auto_apel'].' '.$row_lib_recu_auto_view['auto_nomb'] ;?></li>
                                <?php  }} ?>
                                
                                <td><?= date_format( $row_recu_view['recu_fech_publ'], 'd/M/Y' );?> </td>
                                <!-- <td><?= date_format( $row_lib_recu_info['recu_vide_dura'], 'H:i' );?> </td> -->
                                <!-- <td><?= $row_recu_view['recu_vide_resu'];?> </td> -->
                                <td><?= date_format( $row_recu_view['recu_fech_regi'], 'd/M/Y' );?> </td>
                            </tr>
                    	<?php  } ?>
                   		</tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
