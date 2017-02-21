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
                                <th width="10%">Fecha de Registro</th>
                                <th width="10%">Fecha de Devolución</th>
                                <th width="10%">Observación</th>
                                <th width="10%">Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                        session_start();	 
                        include ('../framework/dbconf.php');

                        $params = array();
                        $sql="{call lib_pres_view()}";
                        $pres_view = sqlsrv_query($conn, $sql, $params);
                        while($row_pres_view = sqlsrv_fetch_array($pres_view)){
                        ?>
                            <tr>
                                <td><?= $row_pres_view['pres_codi'];?> </td>
                                <td><?= $row_pres_view['usua_deta'];?> </td>
                                <td><?= $row_pres_view['usua_tipo_deta'];?> </td>
                                <td><?= date_format( $row_pres_view['pres_fech_regi'], 'd/M/Y' );?> </td>
                                <td><?= date_format( $row_pres_view['pres_fech_devo'], 'd/M/Y' );?> </td>
                                <td><?= $row_pres_view['pres_obse'];?> </td>
                                <?php if($row_pres_view['pres_estado']=='A'){ ?>
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
