<?php
    include_once("../clases/Presentaciones.php");
    $presentaciones = new Presentaciones();
    if(isset($_POST['pres_descripcion']) && $_POST['pres_descripcion']!=""){
        $presentaciones->add_presentacion($_POST['pres_descripcion'], $_POST['baja_inventario']);
        $mensaje=$presentaciones->mensaje;
    }
    $presentaciones->get_all_presentaciones();?>
    <div class="container-fluid theme-showcase" role="main">
        <?=$mensaje;?>
    <!-- region de edicion -->
    <form enctype="multipart/form-data" name="frm_presentaciones" id="frm_presentaciones" action="" method="post">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Datos de la Presentación</h3>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-4 col-xs-12 col-sm-6 bottom_10">
                                    <div class="input-group">
                                        <span class="input-group-addon" id="pres_descripcion_addon">Presentación:</span>
                                        <input type="text" class="form-control" autocomplete="off" id="pres_descripcion" name="pres_descripcion" placeholder="Descripción de la Presentación" aria-describedby="pres_descripcion_addon">
                                    </div>
                                </div>
                                <div class="col-md-4 col-xs-12 col-sm-6 bottom_10">
                                    <div class="input-group">
                                        <span class="input-group-addon" id="baja_inventario_addon">Baja del Inventario:</span>
                                        <select id="baja_inventario" name="baja_inventario" class="form-control">
                                            <option value="Y">Automática</option>
                                            <option value="N">Manual</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 col-xs-12 col-sm-6 bottom_10">
                                    <div class="input-group">
                                        <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-floppy-disk"></span> Guardar</button>
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
                <h3 class="panel-title">Presentaciones Ingresadas</h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12" id="div_presentaciones_table">
                        <?php include("tabla_presentaciones.php");?>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="modal_edicion" tabindex="-1" role="dialog" aria-labelledby="modal_edicionLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="modal_edicionLabel">Editar Presentación</h4>
                    </div>
                    <div class="modal-body" id="modal_edicionbody">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                  <label for="pres_descripcion_edit">Descripción de la Presentación</label>
                                  <input type="text" class="form-control" id="pres_descripcion_edit" name="pres_descripcion_edit" placeholder="Descripción de la presentación">
                                </div>
                                <input type="hidden" id="pres_codigo_edit" name="pres_codigo_edit" value="">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="edit_presentacion('div_presentaciones_table','../ajax_script/presentaciones.php',document.getElementById('pres_codigo_edit').value,document.getElementById('pres_descripcion_edit').value);">Guardar</button>
                    </div>
                </div>
            </div>
        </div>
    <!-- =============================== -->
    </div><!-- /container -->