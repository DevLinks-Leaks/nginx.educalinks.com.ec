<div class="container-fluid">   
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <table class="table table-striped table-hover table-responsive" id="table_cons_estudiantes" data-page-length='8'>
                <thead>
                    <tr>
                        <th width="5%">#</th>
                        <th width="15%">Código</th>
                        <th width="80%">Estudiante</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include("../../Clases/PHP/Estudiantes.php");
                    $busq="";
                    $estudiantes = new Estudiantes();
                    $estudiantes->get_all_alumnos($busq);       
                    $i=0;
                    foreach($estudiantes->rows as $estudiante){$i++;?>
                    <tr class="cursor_link">
                        <td><?= $i;?></td>
                        <td><?= $estudiante['alum_codi'];?></td>
                        <td>
                            <div class="row">
                                <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            Nombre: <span id="nombre_<?=$estudiante['alum_codi']?>"><?= $estudiante['alum_apel']." ".$estudiante['alum_nomb'];?></span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            Curso: <span id="curso_<?=$estudiante['alum_codi']?>"><?= $estudiante['curs_deta']." - ".$estudiante['para_deta'];?></span>
                                            <input type="hidden" value="<?=$estudiante['curs_para_codi']?>" id="curs_para_codi_<?=$estudiante['alum_codi']?>" name="curs_para_codi_<?=$estudiante['alum_codi']?>">
                                            <input type="hidden" value="<?= trim($estudiante['alum_telf_emerg'])." - ".trim($estudiante['alum_telf'])?>" id="alum_telf<?=$estudiante['alum_codi']?>" name="alum_telf<?=$estudiante['alum_codi']?>">
                                            <input type="hidden" value="<?= trim($estudiante['alum_domi'])?>" id="alum_domi<?=$estudiante['alum_codi']?>" name="alum_domi<?=$estudiante['alum_codi']?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>            
                    </tr>
                    <?php }?>
                </tbody>
            </table>
        </div>
    </div>
</div>