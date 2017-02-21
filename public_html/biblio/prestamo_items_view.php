<div class="box box-default">
    <div class="box-header with-border"><h3 class="box-title">Items</h3></div>
    <div class="box-body" id="items_body">
        <table id="tbl_items_prestamo" class="cell-border" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <!-- <th></th> -->
                    <th width="10%">Código</th>
                    <th width="20%">Edición</th>
                    <th width="30%">Procedencia</th>
                    <th width="30%">Estado</th>
                    <th width="10%">Opciones</th>
                </tr>
            </thead>
            <tbody>
            <?php 
            session_start();     
            include ('../framework/dbconf.php');
            if(isset($_POST['recu_codi'])){  $recu_codi=$_POST['recu_codi']; } else {$recu_codi=0;}
            $params = array($recu_codi);
            $sql="{call lib_item_view(?)}";
            $item_view = sqlsrv_query($conn, $sql, $params);
            $index = 0;
            while($row_item_view = sqlsrv_fetch_array($item_view)){ 
            ?>
                <tr>
                    <!-- <td></td> -->
                    <td><?= $row_item_view['item_codi'];?> </td>
                    <td><?= $row_item_view['item_edic'];?> </td>
                    <td><?= $row_item_view['proc_deta'];?> </td>
                    <td>
                    <?php if($row_item_view['item_estado']=='A'){ ?> 
                        Disponible 
                    <?php }elseif ($row_item_view['item_estado']=='P'){ ?>
                        Prestado
                    <? } ?>

                    </td>
                    <td>
                        <button id="<?= $row_item_view['item_codi'];?>" type="button" class="btn btn-success selec_add" <?php if($row_item_view['item_estado']=='P') echo 'disabled'; ?> ><i class="fa fa-plus"></i></button>
                    </td>
                </tr>
            <?php  $index = $index + 1; } ?>
            </tbody>
        </table>
    </div>
</div>  