<div class="container-fluid theme-showcase" role="main">
    <!-- region de edicion -->
    <div class="box">
        <div class="box-header"> 
            <a href="prestamo_new.php"
                 class="btn btn-success" >
                <span class="fa fa-plus" aria-hidden="true"></span> Nuevo Prestamo
            </a>
        </div>
        <div class="box-body" id="div_libro_main" >
            <div class="row">
                <div class="col-md-12">
                    <table id="tbl_prestamos" class="cell-border" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Usuario</th>
                                <th>Tipo Usuario</th>
                                <th>Fecha de Registro</th>
                                <th>Fecha de Devolución</th>
                                <th>Estado</th>
                                <th>Opciones</th>
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
                                <td width="40%"><?= $row_pres_view['usua_deta'];?> </td>
                               
                                <td width="15%"><?= $row_pres_view['usua_tipo_deta'];?> </td>
                                <td width="10%"><?= date_format( $row_pres_view['pres_fech_regi'], 'd/M/Y' );?> </td>
                                <td width="10%"><?= date_format( $row_pres_view['pres_fech_devo'], 'd/M/Y' );?> </td>
                                <?php if($row_pres_view['pres_estado']=='A'){ ?>
                                    <td> Activo </td>
                                <?php }else{ ?>
                                    <td> Devuelto </td>
                                <? } ?>
                                <td width="20%">
                                    <?php if($row_pres_view['pres_estado']=='A'){ ?>
                                        <a  class="btn btn-success" data-toggle="modal" data-target="#modal_devolucion_add"
                                        onclick="load_ajax_devolucion_main('modal_main_devolucion','devolucion_view.php','pres_codi=<?= $row_pres_view['pres_codi']?>');">
                                        <span class="fa fa-book" aria-hidden="true"></span> Devolución
                                        </a>
                                    <?php }else{ ?>
                                        <a  class="btn btn-success" disabled>
                                        <span class="fa fa-book" aria-hidden="true"></span> Devolución
                                        </a>
                                    <? } ?>
                                    
                                    <a  href="prestamo_new.php?pres_codi=<?= $row_pres_view['pres_codi']?>"
                                     class="btn btn-primary" >
                                    <span class="fa fa-edit" aria-hidden="true"></span> Editar
                                    </a>
                                    <a  class="btn btn-danger" data-toggle="modal" data-target="#modal_prestamo_del"
                                    onclick="document.getElementById('pres_codi_del').value='<?= $row_pres_view['pres_codi']?>';">
                                    <span class="fa fa-trash-o" aria-hidden="true"></span> Eliminar
                                    </a>
                                </td>
                            </tr>
                    	<?php   } ?>
                   		</tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
