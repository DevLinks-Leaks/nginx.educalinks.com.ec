<!DOCTYPE html>
<html lang="es">
    <?php include("template/head.php");?>
    <body role="document">
    <?php $active="ficha_diseno";include("template/navbar.php");?>
    <div class="container-fluid theme-showcase" role="main">
    <!-- =============================== -->
        <div class="row">
            <div class="col-md-8 bottom_10">
                <div class="input-group">
                    <span class="input-group-addon" id="nombre_ficha_addon">Nombre:</span>
                    <input type="text" class="form-control" id="nombre_ficha" name="nombre_ficha" placeholder="Nombre de la Ficha" aria-describedby="nombre_ficha_addon">
                </div>
            </div>
            <div class="col-md-4 bottom_10">
                <div class="input-group">
                    <button class="btn btn-primary" type="button" onClick="agrega_ficha('fichas_div','ajax_script/fichas.php',document.getElementById('nombre_ficha').value);">Crear Ficha</button>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-5 col-xs-12 col-sm-6 bottom_10">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title"><span class="glyphicon glyphicon-th-list"></span> Fichas Creadas</h3>
                    </div>
                    <div class="panel-body" id="fichas_div">
                        <?php 
                        include("clases/Fichas.php");
                        $fichas = new Fichas();
                        $fichas->get_all_fichas_selectFormat();
                        include("combo_fichas.php");?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-xs-12 col-sm-6 bottom_10">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title"><span class="glyphicon glyphicon-th-list"></span> Campos de la Ficha</h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                        	<div class="col-md-4 bottom_10">
                            	<div class="input-group">
                                    <span class="input-group-addon" id="nombre_campo_addon">Pregunta:</span>
                                    <input type="text" class="form-control" id="nombre_campo" name="nombre_campo" placeholder="Pregunta" aria-describedby="nombre_campo_addon">
                                </div>
                            </div>
                            <div class="col-md-4 bottom_10">
                            	<div class="input-group">
                                    <span class="input-group-addon" id="nombre_campo_addon">Tipo de Pregunta:</span>
                                    <select class="form-control" id="tipo_campo" name="tipo_campo">
                                        <option value="texto" selected="selected">Texto</option>
                                        <option value="text_area">Text-Area</option>
                                        <option value="select">Lista</option>
                                        <option value="check">Multiple Seleccion</option>
                                        <option value="radio">Unica Seleccion</option>
                                        <option value="check_text">Multiple Seleccion-Texto</option>
                                        <option value="radio_text">Unica Seleccion-Texto</option>
                                        <option value="select_text">Lista-Texto</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 bottom_10">
                                <div class="input-group">
                                    <button class="btn btn-primary" id="btn_pregunta_add" name="btn_pregunta_add" type="button" onClick="agrega_campo('campos_div','ajax_script/fichas.php');">Agregar Pregunta</button>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                        	<div class="col-md-12 bottom_10" id="campos_div">
                            	<?php 
								$fichas->get_all_fichas_campos($fichas->codigo);
								include("tabla_preguntas.php");?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modal_editar" tabindex="-1" role="dialog" aria-labelledby="modal_editarLabel">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="modal_editarLabel">Editar Pregunta</h4>
                    </div>
                    <div class="modal-body" id="modal_editarbody">
                        <div class="row">
                        	<div class="col-md-6 bottom_10">
                            	<div class="input-group">
                                    <span class="input-group-addon" id="nombre_campo_edit_addon">Pregunta:</span>
                                    <input type="text" class="form-control" id="nombre_campo_edit" name="nombre_campo_edit" placeholder="Pregunta" aria-describedby="nombre_campo_edit_addon">
                                </div>
                                <input type="hidden" class="form-control" id="fic_cam_codigo_edit" name="fic_cam_codigo_edit">
                            </div>
                		</div>
                        <div class="row">
                            <div class="col-md-6 bottom_10">
                            	<div class="input-group">
                                    <span class="input-group-addon" id="tipo_campo_edit_addon">Tipo de Pregunta:</span>
                                    <select class="form-control" id="tipo_campo_edit" name="tipo_campo_edit">
                                        <option value="texto" selected="selected">Texto</option>
                                        <option value="text_area">Text-Area</option>
                                        <option value="select">Lista</option>
                                        <option value="check">Multiple Seleccion</option>
                                        <option value="radio">Unica Seleccion</option>
                                        <option value="check_text">Multiple Seleccion-Texto</option>
                                        <option value="radio_text">Unica Seleccion-Texto</option>
                                        <option value="select_text">Lista-Texto</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal" onClick="edita_campo('campos_div','ajax_script/fichas.php',document.getElementById('fic_cam_codigo_edit').value)">Editar</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modal_respuestas" tabindex="-1" role="dialog" aria-labelledby="modal_respuestasLabel">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="modal_respuestasLabel">Agregar Respuestas</h4>
                    </div>
                    <div class="modal-body" id="modal_respuestasbody">
                        <div class="row">
                        	<div class="col-md-6 bottom_10">
                            	<input type="hidden" class="form-control" id="fic_cam_codigo_resp" name="fic_cam_codigo_resp">
                                <div class="input-group">
                                    <span class="input-group-addon" id="respuesta_addon">Respuesta:</span>
                                    <input type="text" class="form-control" id="respuesta" name="respuesta" placeholder="Escriba aqui una respuesta" aria-describedby="respuesta_addon">
                                </div>
                            </div>
                            <div class="col-md-6 bottom_10">
                                <div class="input-group">
                                    <button type="button" class="btn btn-primary" onClick="agrega_respuesta('respuestas_div','ajax_script/fichas.php',document.getElementById('fic_cam_codigo_resp').value);">Agrega Respuesta</button>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                        	<div class="col-md-12 bottom_10" id="respuestas_div">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- /container -->
    <?php include("template/scripts.php");?>
    <script src="js/med_fichas.js"></script>
    <script type="text/javascript">  
	$(document).ready(function(){
		$('#table_preguntas').DataTable({select: false,lengthChange: false,searching: false,language: {url: '//cdn.datatables.net/plug-ins/1.10.8/i18n/Spanish.json'}});
		$('#btn_pregunta_add').prop('disabled', true);
	});
	</script>
  </body>
</html>