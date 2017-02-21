<table class="table table-responsive table-stripped table-hover" id="table_presentaciones" data-page-length='10'>
    <thead>
        <tr>
            <th width="5%">#</th>
            <th width="35%">Presentación</th>
            <th width="30%">Baja de Inventario</th>
            <th width="30%">Opciones</th>
        </tr>
    </thead>
    <tbody>
        <?php $i=0;
        foreach($presentaciones->rows as $presentacion){ $i++;
        ?>
        <tr data-codigo="<?=$presentacion['pres_codigo'];?>">
            <td><?=$i;?></td>
            <td><?=$presentacion['pres_descripcion'];?></td>
            <td>
                <span class="sr-only"><?=$presentacion['pres_baja_automatica'];?></span>
                <select class="form-control" id="baja_auto_<?=$presentacion['pres_codigo'];?>" name="baja_auto_<?=$presentacion['pres_codigo'];?>" onchange="change_baja_inventario('../ajax_script/presentaciones.php','<?=$presentacion['pres_codigo'];?>',this.value)">
                    <option value="Y" <?=$presentacion['pres_baja_automatica']=="Y"?"selected":""; ?>>Automática</option>
                    <option value="N" <?=$presentacion['pres_baja_automatica']=="N"?"selected":""; ?>>Manual</option>
                </select>
            </td>
            <td>
                <button class="btn btn-default" type="button" data-toggle="modal" data-target="#modal_edicion" onclick="document.getElementById('pres_descripcion_edit').value='<?=$presentacion['pres_descripcion'];?>';document.getElementById('pres_codigo_edit').value='<?=$presentacion['pres_codigo'];?>';"><span class="glyphicon glyphicon-edit"></span> Editar</button> 
                <button class="btn btn-danger" type="button" onclick="delete_presentacion('div_presentaciones_table','../ajax_script/presentaciones.php','<?=$presentacion['pres_codigo'];?>');"><span class="glyphicon glyphicon-trash"></span> Eliminar</button></td>
        </tr>
        <?php 
        }?>
    </tbody>
</table>