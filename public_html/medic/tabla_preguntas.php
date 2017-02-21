<table class="table table-responsive table-stripped table-hover" id="table_preguntas" data-page-length='10'>
    <thead>
        <tr>
            <th width="10%">#</th>
            <th width="33%">Pregunta</th>
            <th width="33%">Tipo de Pregunta</th>
            <th width="33%">Opciones</th>
        </tr>
    </thead>
    <tbody>
        <?php $i=0;
        foreach($fichas->rows as $ficha){ $i++;
        ?>
        <tr data-codigo="<?=$ficha['fic_cam_codigo'];?>">
            <td><?=$i;?></td>
            <td><?=$ficha['fic_cam_pregunta'];?></td>
            <td><?=$ficha['fic_cam_tipo'];?></td>
            <td><button class="btn btn-default" type="button" data-toggle="modal" data-target="#modal_editar" onclick="carga_editar('<?=$ficha['fic_cam_codigo'];?>','<?=$ficha['fic_cam_pregunta'];?>','<?=$ficha['fic_cam_tipo'];?>');"><span class="glyphicon glyphicon-edit"></span> Editar</button> 
                <?php if ($ficha['fic_cam_tipo']!="texto" && $ficha['fic_cam_tipo']!='check_text' && $ficha['fic_cam_tipo']!='text_area'){?><button class="btn btn-info" type="button" data-toggle="modal" data-target="#modal_respuestas" onclick="carga_respuestas('respuestas_div','ajax_script/fichas.php','<?=$ficha['fic_cam_codigo'];?>');document.getElementById('fic_cam_codigo_resp').value=<?=$ficha['fic_cam_codigo'];?>"><span class="glyphicon glyphicon-list-alt"></span> Respuestas</button> <?php }?>
                <button class="btn btn-danger" type="button" onclick="borra_campo('campos_div','ajax_script/fichas.php','<?=$ficha['fic_cam_codigo'];?>');"><span class="glyphicon glyphicon-trash"></span> Eliminar</button></td>
        </tr>
        <?php 
        }?>
    </tbody>
</table>