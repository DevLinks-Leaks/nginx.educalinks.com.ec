<form id="frm_impr" name="frm_impr" method="post" action="" enctype="multipart/form-data" target="_blank">
    <input type="hidden" id="aten_codigo_new" name="aten_codigo_new" value="<?=$aten_codigo?>" class="form-control" />
</form>
<?php
include("clases/Atenciones.php");
$atenciones_hoy = new Atenciones();
$atenciones_hoy->get_all_atenciones();
$atencion_detalles_hoy = new Atenciones();
?>
<table class="table table-stripped table-hover table-responsive" id="table_atenciones" data-page-length='10' style='font-size:10px'>
    <thead>
    <tr>
        <th>#</th>
        <th>Estudiante</th>
        <th>Edad</th>
        <th>Curso</th>
        <th>Motivo</th>
        <th>Fecha - Hora</th>
        <th>Materia</th>
        <th>Tratamiento</th>
        <th>Opciones</th>
    </tr>
    </thead>
    <tbody>
        <?php
        $i=0;
        foreach($atenciones_hoy->rows as $atencion_hoy){$i++;
        ?>
        <tr>
            <td><?= $i;?></td>
            <td><?= $atencion_hoy['pers_tipo']==1?$atencion_hoy['alum_apel']." ".$atencion_hoy['alum_nomb']:$atencion_hoy['pers_apel']." ".$atencion_hoy['pers_nomb'];?></td>
            <td><?= $atencion_hoy['edad'];?></td>
			<td><?= $atencion_hoy['pers_tipo']==1?$atencion_hoy['curs_deta']." - ".$atencion_hoy['para_deta']:$atencion_hoy['usua_tipo_deta'];?></td>
			<td><?= $atencion_hoy['enfe_descripcion'];?></td>
            <td><?= date_format($atencion_hoy['aten_fechaCreacion'],"d/m/Y H:i:s");?></td>
			<td><?= $atencion_hoy['mate_deta'];?></td>
            <td>
                <ul>
                    <?php 
                    $atencion_detalles_hoy->get_detalle_atencion_info($atencion_hoy['aten_codigo']);
                    foreach($atencion_detalles_hoy->rows as $atencion_detalle_hoy){
                        echo "<li>Medicamento: ".$atencion_detalle_hoy['med_descripcion']." Cant: ".$atencion_detalle_hoy['aten_deta_med_cantidad']."</li>";
                    }

                    ?>
                </ul>
            </td>
            <td><?php if($atencion_hoy['pers_tipo']==1){?><a href="../../medic/comprobante_atencion/<?=$atencion_hoy['aten_codigo']?>" target="_blank"><span class="glyphicon glyphicon-print"></span> Comprobante Atención</a><br/><?php }?> 
                <a href="<?= $atencion_hoy['pers_tipo']==1?"../../medic/comprobante_salida/".$atencion_hoy['aten_codigo']:"../../medic/comprobante_salida_personal/".$atencion_hoy['aten_codigo'];?>" target="_blank"><span class="glyphicon glyphicon-print"></span> Permiso de Salida</a></td>
        </tr>
        <?php }
        ?>
    </tbody>
</table>