 
<?php 
    session_start();     
    include ('../framework/dbconf.php'); 
    
    if(isset($_GET['pres_codi'])){  $pres_codi=$_GET['pres_codi']; } else {$pres_codi=0;}
    
    
    if ($pres_codi > 0) {
            
         
        $params = array($pres_codi);
        $sql="{call lib_pres_info(?)}";
        $lib_pres_info= sqlsrv_query($conn, $sql, $params);  
        $row_lib_pres_info = sqlsrv_fetch_array($lib_pres_info);
        
        $pres_usua_codi=$row_lib_pres_info['pres_usua_codi'];
        $pres_usua_tipo_codi=$row_lib_pres_info['pres_usua_tipo_codi'];
        $pres_fech_devo=$row_lib_pres_info['pres_fech_devo'];
        $pres_fech_devo=date_format( $row_lib_pres_info['pres_fech_devo'], 'd/m/Y' );
        $pres_estado =$row_lib_pres_info['pres_estado'];

        $params = array($pres_usua_codi, $pres_usua_tipo_codi);
        $sql="{call lib_usua_by_tipo_info(?,?)}";
        $lib_usua_by_tipo_info= sqlsrv_query($conn, $sql, $params);  
        $row_lib_usua_by_tipo_info = sqlsrv_fetch_array($lib_usua_by_tipo_info);
        
        $pres_usua_deta = $row_lib_usua_by_tipo_info['usua_apel'].' '.$row_lib_usua_by_tipo_info['usua_nomb'];
    }
     
?>
<div class="container-fluid theme-showcase" role="main">
    <!-- region de edicion -->
    <div class="row">
         <input type="hidden" class="form-control" id="pres_codi" name="pres_codi" value="<?= $pres_codi ?>" >
        <div class="col-md-12">
            <div class="box box-default">
                <div class="box-header with-border"><h3 class="box-title">Buscar Usuario: </h3> </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon" id="alum_codi_addon">Cod.:</span>
                                    <input type="text" class="form-control" id="pres_usua_codi" name="pres_usua_codi" placeholder="Usuario" value="<?= $pres_usua_codi; ?>"  readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon" id="alum_nombre_addon">Nombre:</span>
                                    <input type="text" class="form-control" id="pres_usua_deta" name="pres_usua_deta" placeholder="Nombre de Usuario" value="<?= $pres_usua_deta; ?>"  readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"  >Tipo Usuario: </span>
                                    <?php 
                                        $params = array();
                                        $sql="{call lib_usua_view()}";
                                        $lib_usua_view= sqlsrv_query($conn, $sql, $params);  
                                    ?>
                                    <select class="form-control" id="pres_usua_tipo_codi" onchange="document.getElementById('usua_codi').value='';document.getElementById('usua_nomb').value='';" <?php if($pres_codi>0) echo 'disabled'; ?> >
                                    <?php  while ($row_lib_usua_view = sqlsrv_fetch_array($lib_usua_view)) {?> 
                                        <option  value="<?= $row_lib_usua_view['usua_tipo_codi']; ?>" <?php if($pres_usua_tipo_codi==$row_lib_usua_view['usua_tipo_codi']) echo 'selected'; ?> >
                                          <?= $row_lib_usua_view['usua_tipo_deta']; ?>
                                        </option> 
                                    <?php  } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <button class="btn btn-info" data-toggle="modal" data-target="#modal_usuarios" onclick="load_ajax_usua_prest('body_modal_usuarios','clases/HTML/Lista_usuarios.php');" <?php if($pres_codi>0) echo 'disabled'; ?> ><span class="glyphicon glyphicon-search" ></span> Buscar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php if($pres_codi==0){ ?>
        <div class="col-md-6">
            <div class="box box-default">
                <div class="box-header with-border"><h3 class="box-title">Buscar Recurso:</h3></div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="input-group">
                                   <span class="input-group-addon">Código:</span>
                                   <input type="text" class="form-control" id="recu_codi" name="recu_codi" placeholder="Código Recurso"   readonly>
                               </div>
                           </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">Titulo:</span>
                                    <input type="text" class="form-control" id="recu_titu" name="recu_titu" placeholder="Título de Recurso"   readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="input-group">
                                   <span class="input-group-addon">ISBN / ISSN:</span>
                                   <input type="text" class="form-control" id="recu_isbn" name="recu_isbn" placeholder="ISBN/ISSN"   readonly>
                               </div>
                           </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="input-group">
                                   <span class="input-group-addon">Editorial:</span>
                                   <input type="text" class="form-control" id="recu_edit_deta" name="recu_edit_deta" placeholder="Editorial"   readonly>
                               </div>
                           </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="input-group">
                                   <span class="input-group-addon">Colección:</span>
                                   <input type="text" class="form-control" id="recu_cole_deta" name="recu_cole_deta" placeholder="Colección"   readonly>
                               </div>
                           </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"  >Tipo: </span>
                                    <?php 
                                        $params = array();
                                        $sql="{call lib_tipo_view()}";
                                        $lib_recu_tipo_view= sqlsrv_query($conn, $sql, $params);  
                                        $cc = 0;
                                    ?>
                                    <select class="form-control" id="recu_tipo_codi" onchange="" >
                                    <?php  while ($row_lib_recu_tipo_view = sqlsrv_fetch_array($lib_recu_tipo_view)) {?> 
                                        <option  value="<?= $row_lib_recu_tipo_view['tipo_codi']; ?>" >
                                          <?= $row_lib_recu_tipo_view['tipo_deta']; ?>
                                        </option>
                                    <?php  } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 text-right">
                            <div class="form-group">
                                <button class="btn btn-info" data-toggle="modal" data-target="#modal_items" onclick="load_ajax_recu_prest('body_modal_items','clases/HTML/Lista_libros_items.php');"><span class="glyphicon glyphicon-search"></span> Buscar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>   
        </div>
        <div class="col-md-6" id="prestamos_items">
             
        </div>
        <?php } ?>
        <div class="col-md-12">
            <div class="box box-default">
                <div class="box-header with-border"><h3 class="box-title">Items Seleccionados</h3></div>
                <div class="box-body">
                    <table id="tbl_items_sele" class="cell-border" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <!-- <th></th> -->
                                <th width="10%">Código Item</th>
                                <th width="20%">ISBN/ISSN</th>
                                <th width="40%">Título</th>
                                <th width="20%">Tipo</th>
                                <th width="10%">Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if($pres_codi>0){
                                $params = array($pres_codi);
                                $sql="{call lib_pres_item_view(?)}";
                                $recu_cate_view= sqlsrv_query($conn, $sql, $params);
                                while($row_recu_cate_view = sqlsrv_fetch_array($recu_cate_view)){

                            ?>
                            <tr>
                                <td><?= $row_recu_cate_view['item_codi']; ?></td>
                                <?php if($row_recu_cate_view['recu_tipo_codi']==1){?>
                                <td width="15%"><?= $row_recu_cate_view['recu_isbn'];?> </td>
                                <?php }elseif($row_recu_cate_view['recu_tipo_codi']==2){?>
                                <td width="15%"><?= $row_recu_cate_view['recu_issn'];?> </td>
                                <?php }else{?>
                                <td width="15%"> </td>
                                <?php } ?>
                                <td><?= $row_recu_cate_view['recu_titu']; ?></td>
                                <td><?= $row_recu_cate_view['tipo_deta']; ?></td>
                                <td><button type="button" class="btn btn-danger" disabled ><i class="fa fa-trash"></i></button></td>
                            </tr>
                            <? }} ?>
                        </tbody>
                    </table>
                </div>
            </div>   
        </div>
        <div class="col-md-12">
            <div class="box box-default">
                <div class="box-header"><h3 class="box-title">Datos de Prestamo:</h3></div>
                <div class="box-body">
                	<div class="row">
                       <div class="col-md-4">
                            <div class="form-group">          	 
                                <div class="input-group">
                                    <span class="input-group-addon" >Fecha Devolución:</span>
                                    <input name="pres_fech_inic" type="text" class="form-control" id="pres_fech_devo" placeholder="" value="<?= $pres_fech_devo; ?>" <?php if($pres_estado=='D') echo 'disabled'; ?> >
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon" >Observación:</span>
                                    <textarea name="pres_obse" rows="3" class="form-control" id="pres_obse" <?php if($pres_codi>0) echo 'disabled'; ?> ><?= $pres_obse; ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-footer text-right">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="form-group">
                            <button class="btn btn-primary" id="btn_pres_add" data-loading-text="Guardando..."  onclick="load_ajax_add_prestamo(<?= $pres_codi; ?>);" >
                                <span class="glyphicon glyphicon-save"></span> Guardar Prestamo
                            </button>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-danger"  onclick="window.history.back();" >
                            <span class="fa fa-times"></span> Cancelar
                        </button>
                    </div>      
                </div>
            </div>
        </div> 
    <!-- =============================== -->
    </div>
</div><!-- /container -->
