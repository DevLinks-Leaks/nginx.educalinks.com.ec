<?php
include_once("../clases/Atenciones.php");
$materias = new Atenciones();
$materias->get_all_mate_alum_selectFormat($alum_codi, $curs_para_codi);?>
<span class="input-group-addon" id="mate_alum_curso_addon">Materias:</span>
<select id="mate_alum_curso" name="mate_alum_curso" class="form-control" onchange="carga_profesor('mate_alum_curso','data_prof_codi','prof_codi','data_prof_nomb','prof_nomb')">
    <option value="" data_prof_codi="0" data_prof_nomb="">Seleccione...</option>
    <?php
    foreach($materias->rows as $materia){
    ?>
    <option value="<?=$materia['mate_codi']?>" data_prof_codi="<?=$materia['prof_codi']?>" data_prof_nomb="<?=$materia['prof_nomb']?>"><?=$materia['mate_deta']?></option>
    <?php 
    }
    ?>
    <option value="-1" data_prof_codi="-1" data_prof_nomb="">Entrada</option>
    <option value="-2" data_prof_codi="-2" data_prof_nomb="">Recreo</option>
    <option value="-3" data_prof_codi="-3" data_prof_nomb="">Salida</option>
</select>
