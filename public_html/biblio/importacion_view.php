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
                                <td><i class="fa fa-users fa-2x"></i></td>
                                <td><h4>Autor - Actor - Director</h4></td>
                                <td><a class="btn btn-default" href="../importacion_datos/biblio/downloads/tmp_autor.xls"><i class="fa fa-download"></i> Descargar</a></td>
                                <td><a data-toggle="modal" data-target="#modal_importacion" onclick="$('#file').closest('.form-group').removeClass('has-error');document.getElementById('opc').value='auto';document.getElementById('file').value='';" class="btn btn-primary"><i class="fa fa-upload"></i> Subir Archivo </a>
                                </td>
                            </tr>
                            <tr>
                                <td><i class="fa fa-sitemap fa-2x"></i></td>
                                <td><h4>Categorías</h4></td>
                                <td><a class="btn btn-default" href="../importacion_datos/biblio/downloads/tmp_categoria.xls"><i class="fa fa-download"></i> Descargar</a></td>
                                <td><a class="btn btn-primary" data-toggle="modal" data-target="#modal_importacion" onclick="$('#file').closest('.form-group').removeClass('has-error');document.getElementById('opc').value='cate';document.getElementById('file').value='';"><i class="fa fa-upload"></i> Subir Archivo </a>
                                </td>
                            </tr>
                            <tr>
                                <td><i class="fa fa-tags fa-2x"></i></td>
                                <td><h4>Descriptores</h4></td>
                                <td><a class="btn btn-default" href="../importacion_datos/biblio/downloads/tmp_descriptor.xls"><i class="fa fa-download"></i> Descargar</a></td>
                                <td><a class="btn btn-primary" data-toggle="modal" data-target="#modal_importacion" onclick="$('#file').closest('.form-group').removeClass('has-error');document.getElementById('opc').value='desc';document.getElementById('file').value='';"><i class="fa fa-upload"></i> Subir Archivo </a>
                                </td>
                            </tr>
                            <tr>
                                <td><i class="fa fa-th-large fa-2x"></i></td>
                                <td><h4>Tipos</h4></td>
                                <td><a class="btn btn-default" href="../importacion_datos/biblio/downloads/tmp_tipo.xls"><i class="fa fa-download"></i> Descargar</a></td>
                                <td><a class="btn btn-primary" data-toggle="modal" data-target="#modal_importacion" onclick="$('#file').closest('.form-group').removeClass('has-error');document.getElementById('opc').value='tipo';document.getElementById('file').value='';" ><i class="fa fa-upload"></i> Subir Archivo </a>
                                </td>
                            </tr>
                            <tr>
                                <td><i class="fa fa-object-group fa-2x"></i></td>
                                <td><h4>Colección</h4></td>
                                <td><a class="btn btn-default" href="../importacion_datos/biblio/downloads/tmp_coleccion.xls"><i class="fa fa-download"></i> Descargar</a></td>
                                <td><a class="btn btn-primary" data-toggle="modal" data-target="#modal_importacion" onclick="$('#file').closest('.form-group').removeClass('has-error');document.getElementById('opc').value='cole';document.getElementById('file').value='';"><i class="fa fa-upload"></i> Subir Archivo </a>
                                </td>
                            </tr>
                            <tr>
                                <td><i class="fa fa-newspaper-o fa-2x"></i></td>
                                <td><h4>Editorial</h4></td>
                                <td><a class="btn btn-default" href="../importacion_datos/biblio/downloads/tmp_editorial.xls"><i class="fa fa-download"></i> Descargar</a></td>
                                <td><a class="btn btn-primary" data-toggle="modal" data-target="#modal_importacion" onclick="$('#file').closest('.form-group').removeClass('has-error');document.getElementById('opc').value='edit';document.getElementById('file').value='';"><i class="fa fa-upload"></i> Subir Archivo </a>
                                </td>
                            </tr>
                            <tr>
                                <td><i class="fa fa-institution fa-2x"></i></td>
                                <td><h4>Procedencia</h4></td>
                                <td><a class="btn btn-default" href="../importacion_datos/biblio/downloads/tmp_procedencia.xls"><i class="fa fa-download"></i> Descargar</a></td>
                                <td><a class="btn btn-primary" data-toggle="modal" data-target="#modal_importacion" onclick="$('#file').closest('.form-group').removeClass('has-error');document.getElementById('opc').value='proc';document.getElementById('file').value='';"><i class="fa fa-upload"></i> Subir Archivo </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
