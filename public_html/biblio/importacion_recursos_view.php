<div class="container-fluid theme-showcase" role="main">
    <!-- region de edicion -->
    <div class="box">
        <div class="box-header"> 
            
        </div>
        <div class="box-body" >
            <div class="row">
                <div class="col-md-12">
                    <table id="tbl_importacion" class="table table-striped" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>&nbsp;</th>
                                <th>Descripción</th>
                                <th>Plantilla</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><i class="fa fa-book fa-2x"></i></td>
                                <td><h4>Recursos Tipo Libro</h4></td>
                                <td><a class="btn btn-default" href="../importacion_datos/biblio/downloads/tmp_recurso_libro.xls"><i class="fa fa-download"></i> Descargar</a></td>
                                <td><a data-toggle="modal" data-target="#modal_importacion" onclick="$('#file').closest('.form-group').removeClass('has-error');document.getElementById('opc').value='recu_libr';document.getElementById('file').value='';" class="btn btn-primary"><i class="fa fa-upload"></i> Subir Archivo </a>
                                </td>
                            </tr>
                            <tr>
                                <td><i class="fa fa-newspaper-o fa-2x"></i></td>
                                <td><h4>Recursos Tipo Revista</h4></td>
                                <td><a class="btn btn-default" href="../importacion_datos/biblio/downloads/tmp_recurso_revista.xls"><i class="fa fa-download"></i> Descargar</a></td>
                                <td><a class="btn btn-primary" data-toggle="modal" data-target="#modal_importacion" onclick="$('#file').closest('.form-group').removeClass('has-error');document.getElementById('opc').value='recu_revi';document.getElementById('file').value='';"><i class="fa fa-upload"></i> Subir Archivo </a>
                                </td>
                            </tr>
                            <tr>
                                <td><i class="fa fa-video-camera fa-2x"></i></td>
                                <td><h4>Recursos Tipo Videos</h4></td>
                                <td><a class="btn btn-default" href="../importacion_datos/biblio/downloads/tmp_recurso_videos.xls"><i class="fa fa-download"></i> Descargar</a></td>
                                <td><a class="btn btn-primary" data-toggle="modal" data-target="#modal_importacion" onclick="$('#file').closest('.form-group').removeClass('has-error');document.getElementById('opc').value='recu_vide';document.getElementById('file').value='';"><i class="fa fa-upload"></i> Subir Archivo </a>
                                </td>
                            </tr>
                            <tr>
                                <td><i class="fa fa-th-large fa-2x"></i></td>
                                <td><h4>Otros Recursos</h4></td>
                                <td><a class="btn btn-default" href="../importacion_datos/biblio/downloads/tmp_recurso_otros.xls"><i class="fa fa-download"></i> Descargar</a></td>
                                <td><a class="btn btn-primary" data-toggle="modal" data-target="#modal_importacion" onclick="$('#file').closest('.form-group').removeClass('has-error');document.getElementById('opc').value='recu_otro';document.getElementById('file').value='';" ><i class="fa fa-upload"></i> Subir Archivo </a>
                                </td>
                            </tr>
                            <tr>
                                <td><i class="fa fa-th-list fa-2x"></i></td>
                                <td><h4>Recursos Items</h4></td>
                                <td><a class="btn btn-default" href="../importacion_datos/biblio/downloads/tmp_recurso_items.xls"><i class="fa fa-download"></i> Descargar</a></td>
                                <td><a class="btn btn-primary" data-toggle="modal" data-target="#modal_importacion" onclick="$('#file').closest('.form-group').removeClass('has-error');document.getElementById('opc').value='recu_item';document.getElementById('file').value='';" ><i class="fa fa-upload"></i> Subir Archivo </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
