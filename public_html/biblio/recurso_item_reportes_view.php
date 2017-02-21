<div class="container-fluid theme-showcase" role="main">
    <!-- region de edicion -->
    <div class="box">
        
        <div class="box-body" id="div_libro_main" >
            <div class="row">
                <div class="col-md-12">
                    <table id="tbl_recursos_items_reportes" class="cell-border table-responsive" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th width="20%" >Título</th>
                                <th width="10%">ISBN / ISSN</th>
                                <th width="10%">Tipo</th>
                                <th width="10%">Código Item</th>
                                <th width="10%">Edición</th>
                                <th width="10%">Procedencia</th>
                                <th width="10%">Precio</th>
                                <th width="10%">Fecha Ingreso</th>
                                <th width="10%">Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                        session_start();	 
                        include ('../framework/dbconf.php');

                        $params = array();
                        $sql="{call lib_recu_item_view_all()}";
                        $lib_recu_item_view_all = sqlsrv_query($conn, $sql, $params);
                        while($row_lib_recu_item_view_all = sqlsrv_fetch_array($lib_recu_item_view_all)){
                        ?>
                            <tr>
                                <td ><?= $row_lib_recu_item_view_all['recu_titu'];?> </td>
                                <?php if($row_lib_recu_item_view_all['recu_tipo_codi']==1){?>
                                <td width="15%"><?= $row_lib_recu_item_view_all['recu_isbn'];?> </td>
                                <?php }elseif($row_lib_recu_item_view_all['recu_tipo_codi']==2){?>
                                <td width="15%"><?= $row_lib_recu_item_view_all['recu_issn'];?> </td>
                                <?php }else{?>
                                <td width="15%"> </td>
                                <?php } ?>
                                <td><?= $row_lib_recu_item_view_all['tipo_deta'];?> </td>
                                <td><?= $row_lib_recu_item_view_all['item_codi'];?> </td>
                                <td><?= $row_lib_recu_item_view_all['item_edic'];?> </td>
                                <td><?= $row_lib_recu_item_view_all['proc_deta'];?> </td>
                                <td><?= $row_lib_recu_item_view_all['item_prec'];?> </td>
                                <td><?= date_format( $row_lib_recu_item_view_all['item_fech_ing'], 'd/M/Y' );?> </td>
                                <td>
                                <?php if($row_lib_recu_item_view_all['item_estado']=='A'){ ?> 
                                    Disponible 
                                <?php }elseif ($row_lib_recu_item_view_all['item_estado']=='P'){ ?>
                                    Prestado
                                <? } ?>
                                </td>
                            </tr>
                            	<?php  } ?>
                   		</tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
