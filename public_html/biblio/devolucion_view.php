 
<?php 
    session_start();     
    include ('../framework/dbconf.php'); 
    
    if(isset($_POST['pres_codi'])){  $pres_codi=$_POST['pres_codi']; } else {$pres_codi=0;}
      
         
        $params = array($pres_codi);
        $sql="{call lib_pres_info(?)}";
        $lib_pres_info= sqlsrv_query($conn, $sql, $params);  
        $row_lib_pres_info = sqlsrv_fetch_array($lib_pres_info);
        
        $pres_usua_codi=$row_lib_pres_info['pres_usua_codi'];
        $pres_usua_tipo_codi=$row_lib_pres_info['pres_usua_tipo_codi'];
        $pres_fech_devo=date_format( $row_lib_pres_info['pres_fech_devo'], 'd/m/Y' );
        $pres_estado = $row_lib_pres_info['pres_estado'];
        
    
     
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="myModalLabel">Devolución</h4>
</div>
<div class="modal-body">
    <table id="tbl_items_devo" class="cell-border" cellspacing="0" width="100%">
        <thead>
            <tr>
                <!-- <th></th> -->
                <th width="2%">Código</th>
                <!-- <th width="10%">ISBN/ISSN</th> -->
                <th width="30%">Título</th>
                <th width="10%">Tipo</th>
                <th width="10%">Fecha Devuelto</th>
                <th width="15%">Estado</th>
                <th width="10%">Opciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
                
                $params = array($pres_codi);
                $sql="{call lib_pres_item_view(?)}";
                $recu_cate_view= sqlsrv_query($conn, $sql, $params);
                while($row_recu_cate_view = sqlsrv_fetch_array($recu_cate_view)){

            ?>
            <tr>
                <td ><?= $row_recu_cate_view['item_codi']; ?></td>
                <!-- <?php if($row_recu_cate_view['recu_tipo_codi']==1){?>
                <td ><?= $row_recu_cate_view['recu_isbn'];?> </td>
                <?php }elseif($row_recu_cate_view['recu_tipo_codi']==2){?>
                <td ><?= $row_recu_cate_view['recu_issn'];?> </td>
                <?php }else{?>
                <td > </td>
                <?php } ?> -->
                <td><?= $row_recu_cate_view['recu_titu']; ?></td>
                <td><?= $row_recu_cate_view['tipo_deta']; ?></td>
                <td><?= date_format( $row_recu_cate_view['pres_item_fech_reto'], 'd/M/Y' ); ?></td>
                <?php if($row_recu_cate_view['pres_item_estado']=='A'){ ?>
                <td> Activo </td>
                <td><button type="button" class="btn btn-success" onclick="load_ajax_pres_devo_item('script_prestamos.php','opc=devo_item&pres_item_codi=<?= $row_recu_cate_view['pres_item_codi']; ?>','<?= $pres_codi; ?>');"><i class="fa fa-check"></i> Devolver</button></td>
                <?php }else{ ?>
                <td> Devuelto </td>
                <td><button type="button" class="btn btn-success" disabled><i class="fa fa-check"></i> Devolver</button></td>
                <? } ?>
            </tr>
            <? } ?>
        </tbody>
    </table>
</div>
<div class="modal-footer">
    <button id="btn_devo_add" type="button" class="btn btn-success" data-loading-text="Devolviendo..." onClick="load_ajax_pres_devo('script_prestamos.php','opc=devo&pres_codi=<?= $pres_codi; ?>');" <?php if($pres_estado=='D') echo 'disabled' ?> >Devolver Todo</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
</div>