<table class="table table-responsive table-stripped table-hover" id="table_respuestas" data-page-length='10'>
    <thead>
        <tr>
            <th width="10%">#</th>
            <th width="40%">Respuesta</th>
            <th width="50%">Opciones</th>
        </tr>
    </thead>
    <tbody>
        <?php $i=0;
        foreach($fichas->rows as $ficha){ $i++;
        ?>
        <tr data-codigo="<?=$ficha['fic_cam_resp_codigo'];?>">
            <td><?=$i;?></td>
            <td><?=$ficha['fic_cam_resp_respuesta'];?></td>
            <td><button class="btn btn-danger" type="button" onclick="borra_respuesta('respuestas_div','ajax_script/fichas.php','<?=$ficha['fic_cam_resp_codigo'];?>','<?=$ficha['fic_cam_codigo'];?>');"><span class="glyphicon glyphicon-trash"></span> Eliminar</button></td>
        </tr>
        <?php 
        }?>
    </tbody>
</table>