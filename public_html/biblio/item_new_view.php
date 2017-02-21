<?php 
    session_start();     
    include ('../framework/dbconf.php');
    if(isset($_POST['recu_codi'])){  $recu_codi=$_POST['recu_codi']; } else {$recu_codi=0;}
    if(isset($_POST['item_codi'])){  $item_codi=$_POST['item_codi']; } else {$item_codi=0;}

    if($item_codi>0){
        $params = array($item_codi);
        $sql="{call lib_item_info(?)}";
        $lib_item_info= sqlsrv_query($conn, $sql, $params);  
        $row_lib_item_info = sqlsrv_fetch_array($lib_item_info);
        
        $item_edic=$row_lib_item_info['item_edic'];
        $item_fech_ing=date_format( $row_lib_item_info['item_fech_ing'], 'd/m/Y' );
        $item_prec=$row_lib_item_info['item_prec'];
        $item_proc_codi=$row_lib_item_info['item_proc_codi'];
    }
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="myModalLabel"> <?php if($item_codi>0){ ?> Editar Item</h4> <?php }else{ ?> Nuevo Item <? } ?>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-md-6 ">
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon" >Edición:</span>
                    <input type="text" class="form-control" id="item_edic" name="item_edic" placeholder="Edición" value="<?= $item_edic;?>">
                </div>
            </div>
        </div>
        <div class="col-md-6 ">
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon" >Precio:</span>
                    <input type="text" class="form-control" id="item_prec"  name="item_prec" value="<?= $item_prec;?>">
                    <div class="input-group-addon">
                        <i class="fa fa-usd"></i>
                    </div>
                </div>
            </div>   
        </div>
        <div class="col-md-6 ">
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon" >Fecha Ingreso:</span>
                    <input type="text" class="form-control" id="item_fech_ing" name="item_fech_ing" value="<?= $item_fech_ing;?>">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                </div>
            </div>   
        </div>
        <div class="col-md-6 ">
            <div class="form-group">   
                <div class="input-group">
                    <span class="input-group-addon"  >Procedencia:</span>
                    <?php 
                        $params = array();
                        $sql="{call lib_proc_view()}";
                        $lib_proc_view= sqlsrv_query($conn, $sql, $params);  
                        $cc = 0;
                    ?>
                    <select class="form-control" id="item_proc_codi" >
                    <?php  while ($row_lib_proc_view = sqlsrv_fetch_array($lib_proc_view)) {?> 
                        <option  value="<?= $row_lib_proc_view['proc_codi']; ?>"  <? if ($item_proc_codi==$row_lib_proc_view['proc_codi']) echo 'selected="selected"';  ?>>
                          <?= $row_lib_proc_view['proc_deta']; ?>
                        </option> 
                    <?php  } ?>
                    </select>
                </div>
            </div> 
        </div>
        <?php if($item_codi<=0){ ?> 
            <div class="col-md-6 ">
                <div class="form-group">   
                    <div class="input-group">
                        <span class="input-group-addon"  >Cantidad:</span>
                        <input type="number" class="form-control" id="item_cant" min="1" name="item_cant" value="1">
                    </div>
                </div> 
            </div>
        <?php } ?> 
    </div>
</div>
<div class="modal-footer">
    <input type="hidden" value="<?= $item_codi ?>" name="item_codi" id="item_codi" />
    <button id="btn_item_add" type="button" class="btn btn-success" data-loading-text="Agregando..." onClick="load_ajax_add_item('item_main','script_items.php','<?= $recu_codi; ?>');" >Agregar</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
</div>