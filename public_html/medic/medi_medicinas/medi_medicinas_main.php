<?php include("../clases/medicamentos.php");
    $medicamentos = new Medicamentos();
    if(isset($_POST['med_codigo']) && $_POST['med_codigo']!=""){
        $medicamentos->ingresa_medicamento($_POST['med_codigo'], $_POST['med_descripcion'], $_POST['med_stock'],$_POST['pres_codigo']);
        $mensaje=$medicamentos->mensaje;
    }
    $medicamentos->get_all_medicamentos();
    
    include("../clases/Presentaciones.php");
    $presentaciones = new Presentaciones();
    $presentaciones->get_all_presentaciones();?>
    <div class="container-fluid theme-showcase" role="main">
        <?=$mensaje;?>
    <!-- region de edicion -->
    <form enctype="multipart/form-data" name="frm_medicamentos" id="frm_medicamentos" action="" method="post">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Datos de la Medicina</h3>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-3 col-xs-12 col-sm-6 bottom_10">
                                    <div class="input-group">
                                        <span class="input-group-addon">Presentación:</span>
                                        <select id="pres_codigo" name="pres_codigo" class="form-control" required>
                                            <option value="">Seleccione...</option>
                                            <?php $i=0;
                                            foreach($presentaciones->rows as $presentacion){ $i++;
                                            ?>
                                            <option value="<?=$presentacion['pres_codigo'];?>"><?=$presentacion['pres_descripcion'];?></option>
                                            <?php 
                                            } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 col-xs-12 col-sm-6 bottom_10">
                                    <div class="input-group">
                                        <span class="input-group-addon" id="med_descripcion_addon">Medicamento:</span>
                                        <input type="text" class="form-control" autocomplete="off" id="med_descripcion" name="med_descripcion" placeholder="Descripción de la Medicina" aria-describedby="med_descripcion_addon" required>
                                    </div>
                                    <input id="med_codigo" name="med_codigo" class="form-control" type="hidden" />
                                </div>
                                <div class="col-md-3 col-xs-12 col-sm-6 bottom_10">
                                    <div class="input-group">
                                        <span class="input-group-addon" id="med_stock_addon">Cantidad:</span>
                                        <input type="text" class="form-control" autocomplete="off" id="med_stock" name="med_stock" placeholder="Cantidad de Ingreso" aria-describedby="med_stock_addon" required>
                                    </div>
                                </div>
                                <div class="col-md-3 col-xs-12 col-sm-6 bottom_10">
                                    <div class="input-group">
                                        <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Ingresar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Medicamentos Ingresados</h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12" id="div_medicamentos_table">
                        <?php include("tabla_medicinas.php");?>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="modal_egreso" tabindex="-1" role="dialog" aria-labelledby="modal_egresoLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="modal_egresoLabel">Egresar Medicamento</h4>
                    </div>
                    <div class="modal-body" id="modal_egresobody">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                  <label for="med_stock_edit">Cantidad a Egresar</label>
                                  <input type="text" class="form-control" id="med_stock_edit" name="med_stock_edit" placeholder="Cantidad a egresar">
                                </div>
                                <input type="hidden" id="med_codigo_egreso" name="med_codigo_egreso" value="">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="egreso_medicamento('div_medicamentos_table','../ajax_script/medicamentos.php',document.getElementById('med_codigo_egreso').value,document.getElementById('med_stock_edit').value);">Guardar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="modal_edit" tabindex="-1" role="dialog" aria-labelledby="modal_editLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="modal_editLabel">Editar Medicamento</h4>
                    </div>
                    <div class="modal-body" id="modal_editbody">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                  <label for="med_stock_edit">Descripción del Medicamento</label>
                                  <input type="text" class="form-control" id="med_descripcion_edit" name="med_descripcion_edit" placeholder="Descripción del medicamento">
                                </div>
                                <input type="hidden" id="med_codigo_edit" name="med_codigo_edit" value="">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="edit_medicamento('div_medicamentos_table','../ajax_script/medicamentos.php',document.getElementById('med_codigo_edit').value,document.getElementById('med_descripcion_edit').value);">Guardar</button>
                    </div>
                </div>
            </div>
        </div>
    <!-- =============================== -->
    </div><!-- /container -->    