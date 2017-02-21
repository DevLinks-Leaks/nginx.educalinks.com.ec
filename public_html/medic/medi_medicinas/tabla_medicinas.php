<table class="table table-responsive table-stripped table-hover" id="table_medicinas" data-page-length='10'>
    <thead>
        <tr>
            <th width="5%">#</th>
            <th width="25%">Medicamento</th>
            <th width="25%">Presentación</th>
            <th width="15%">Stock</th>
            <th width="30%">Opciones</th>
        </tr>
    </thead>
    <tbody>
        <?php $i=0;
        foreach($medicamentos->rows as $medicamento){ $i++;
        ?>
        <tr data-codigo="<?=$medicamento['med_codigo'];?>">
            <td><?=$i;?></td>
            <td><?=$medicamento['med_descripcion'];?></td>
            <td><?=$medicamento['pres_descripcion'];?></td>
            <td><?=$medicamento['med_stock'];?></td>
            <td><button class="btn btn-default" type="button" data-toggle="modal" data-target="#modal_edit" onclick="document.getElementById('med_descripcion_edit').value='<?=$medicamento['med_descripcion'];?>';document.getElementById('med_codigo_edit').value='<?=$medicamento['med_codigo'];?>';"><span class="glyphicon glyphicon-edit"></span> Editar</button>
                <button class="btn btn-warning" type="button" data-toggle="modal" data-target="#modal_egreso" onclick="document.getElementById('med_stock_edit').value='';document.getElementById('med_codigo_egreso').value='<?=$medicamento['med_codigo'];?>';" ><span class="glyphicon glyphicon-minus"></span> Egresos</button>
		<button class="btn btn-danger" type="button" onclick="delete_medicamento('div_medicamentos_table','../ajax_script/medicamentos.php','<?=$medicamento['med_codigo'];?>');"><span class="glyphicon glyphicon-trash"></span> Eliminar</button></td>
        </tr>
        <?php 
        }?>
    </tbody>
</table>