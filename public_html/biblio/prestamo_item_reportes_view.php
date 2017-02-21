<div class="container-fluid theme-showcase" role="main">
    <!-- region de edicion -->
    <div class="box">
        <div class="box-header"> 
        </div>
        <div class="box-body" id="div_libro_main" >
            <div class="row">
                <div class="col-md-12">
                    <table id="tbl_prestamos_reportes" class="cell-border" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th width="10%">Código</th>
                                <th width="10%">Usuario</th>
                                <th width="10%">Tipo Usuario</th>
                                <th width="10%">Fecha Devolución</th>
                                <th width="10%">Título Recurso</th>
                                <th width="10%">Tipo Recurso</th>
                                <th width="10%">Fecha Retornado</th>
                                <th width="10%">Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                        session_start();	 
                        include ('../framework/dbconf.php');

                        $params = array();
                        $sql="{call lib_pres_item_view_all()}";
                        $lib_pres_item_view_all = sqlsrv_query($conn, $sql, $params);
                        while($row_lib_pres_item_view_all = sqlsrv_fetch_array($lib_pres_item_view_all)){
                        ?>
                            <tr>
                                <td><?= $row_lib_pres_item_view_all['pres_codi'];?> </td>
                                <td><?= $row_lib_pres_item_view_all['usua_deta'];?> </td>
                                <td><?= $row_lib_pres_item_view_all['usua_tipo_deta'];?> </td>
                                <td><?= date_format( $row_lib_pres_item_view_all['pres_fech_devo'], 'd/M/Y' );?> </td>
                                <td><?= $row_lib_pres_item_view_all['recu_titu'];?> </td>
                                <td><?= $row_lib_pres_item_view_all['tipo_deta'];?> </td>
                                <td><?= date_format( $row_lib_pres_item_view_all['pres_item_fech_reto'], 'd/M/Y' );?> </td>
                                <?php if($row_lib_pres_item_view_all['pres_item_estado']=='A'){ ?>
                                    <td> Activo </td>
                                <?php }else{ ?>
                                    <td> Devuelto </td>
                                <? } ?>
                                
                            </tr>
                    	<?php   } ?>
                   		</tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
