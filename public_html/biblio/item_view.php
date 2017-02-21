<?php 
    session_start();     
    include ('../framework/dbconf.php');
    if(isset($_GET['recu_codi'])){  $recu_codi=$_GET['recu_codi']; } else {$recu_codi=0;}
?>
<div class="container-fluid theme-showcase" role="main">
    <!-- region de edicion -->
    <div class="box">
        <div class="box-header">
            <a data-toggle="modal" data-target="#modal_item_add" onclick="load_ajax_nuevo_item('modal_item_content','item_new_view.php',0, '<?= $recu_codi; ?>');"
                 class="btn btn-success" >
                    <span class="fa fa-plus" aria-hidden="true"></span> Nuevo Item
                    </a>
            <!-- <a  class="btn btn-danger" data-toggle="modal" data-target="#modal_item_del"
            onclick="document.getElementById('item_codi_del').value='0';">
            <span class="fa fa-trash-o" aria-hidden="true"></span> Eliminar Selección
            </a> -->
        </div>
        <div class="box-body" id="div_libro_main" >
            <div class="row">
                <div class="col-md-12">
                    <table id="tbl_items" class="cell-border" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <!-- <th></th> -->
                                <th>Código</th>
                                <th>Edición</th>
                                <th>Procedencia</th>
                                <th>Precio</th>
                                <th>Fecha Ingreso</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                        session_start();	 
                        include ('../framework/dbconf.php');

                        $params = array($recu_codi);
                        $sql="{call lib_item_view(?)}";
                        $item_view = sqlsrv_query($conn, $sql, $params);
                        while($row_item_view = sqlsrv_fetch_array($item_view)){

                        ?>
                            <tr>
                                <!-- <td></td> -->
                                <td width="5%"><?= $row_item_view['item_codi'];?> </td>
                                <td width="20%"><?= $row_item_view['item_edic'];?> </td>
                                <td width="30%"><?= $row_item_view['proc_deta'];?> </td>
                                <td width="10%">$ <?= $row_item_view['item_prec'];?> </td>
                                <td width="20%"><?= date_format( $row_item_view['item_fech_ing'], 'd/M/Y' );?>  </td>
                                <td width="15%">
                                    <a  data-toggle="modal" data-target="#modal_item_add"
                                     class="btn btn-primary" onclick="load_ajax_nuevo_item('modal_item_content','item_new_view.php','<?= $row_item_view['item_codi'];?>', '<?= $recu_codi; ?>');"
                                    >
                                    <span class="fa fa-edit" aria-hidden="true"></span> Editar
                                    </a>
                                    <a  class="btn btn-danger" data-toggle="modal" data-target="#modal_item_del"
                                    onclick="document.getElementById('item_codi_del').value='<?= $row_item_view['item_codi']?>';">
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
