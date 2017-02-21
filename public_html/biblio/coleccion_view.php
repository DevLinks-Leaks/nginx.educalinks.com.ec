<div class="container-fluid theme-showcase" role="main">
    <!-- region de edicion -->
    <div class="box">
        <div class="box-header"> 
            <a data-toggle="modal" data-target="#modal_coleccion_add"
                 class="btn btn-success" onclick="document.getElementById('cole_deta').value=''">
                    <span class="fa fa-plus" aria-hidden="true"></span> Nueva Colección
                    </a>
        </div>
        <div class="box-body" id="div_libro_main" >
            <div class="row">
                <div class="col-md-12">
                    <table id="tbl_colecciones" class="cell-border" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Detalle</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                        session_start();	 
                        include ('../framework/dbconf.php');

                        $params = array();
                        $sql="{call lib_cole_view()}";
                        $cole_view = sqlsrv_query($conn, $sql, $params);
                        while($row_cole_view = sqlsrv_fetch_array($cole_view)){

                        ?>
                            <tr>
                                <td width="77%"><?= $row_cole_view['cole_deta'];?> </td>
                                <td width="23%">
                                    <a  data-toggle="modal" data-target="#modal_coleccion_edit"
                                     class="btn btn-primary" onclick="document.getElementById('cole_deta_edit').value='<?= $row_cole_view['cole_deta']?>';document.getElementById('cole_codi').value='<?= $row_cole_view['cole_codi']?>';"
                                    >
                                    <span class="fa fa-edit" aria-hidden="true"></span> Editar
                                    </a>
                                    <a  class="btn btn-danger" data-toggle="modal" data-target="#modal_coleccion_del"
                                    onclick="document.getElementById('cole_codi_del').value='<?= $row_cole_view['cole_codi']?>';">
                                    <span class="fa fa-trash-o" aria-hidden="true"></span> Eliminar
                                    </a>
                                </td>
                            </tr>
                        <?php   } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
