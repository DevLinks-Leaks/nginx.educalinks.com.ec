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
                    include("../../Clases/PHP/Profesores.php");
                    $busq="";
                    $profesores = new Profesores();
                    $profesores->get_all_personal($busq);       
                    $i=0;
                    foreach($profesores->rows as $profesor){$i++;?>
                    <tr class="cursor_link">
                        <td><?= $i;?></td>
                        <td><?= $profesor['usua_codi'];?></td>
                        <td>
                            <div class="row">
                                <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            Nombre: <span id="nombre_<?=$profesor['usua_codi']?>"><?= $profesor['usua_apel']." ".$profesor['usua_nomb'];?></span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <input type="hidden" value="<?= trim($profesor['usua_telf']);?>" id="prof_telf<?=$profesor['usua_codi']?>" name="prof_telf<?=$profesor['usua_codi']?>">
                                            <input type="hidden" value="<?= trim($profesor['usua_dire'])?>" id="prof_domi<?=$profesor['usua_codi']?>" name="prof_domi<?=$profesor['usua_codi']?>">
                                            <input type="hidden" value="<?= trim($profesor['usua_tipo'])?>" id="usua_tipo<?=$profesor['usua_codi']?>" name="usua_tipo<?=$profesor['usua_codi']?>">
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