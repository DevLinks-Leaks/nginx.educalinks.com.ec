<div class="container-fluid theme-showcase" role="main">
    <!-- region de edicion -->
    <div class="box">
        <div class="box-header"> 
            <a data-toggle="modal" data-target="#modal_autor_add"
                 class="btn btn-success" onclick="document.getElementById('auto_apel').value='';document.getElementById('auto_nomb').value=''">
                    <span class="fa fa-plus" aria-hidden="true"></span> Nuevo Autor
                    </a>
        </div>
        <div class="box-body" id="div_libro_main" >
            <div class="row">
                <div class="col-md-12">
                    <table id="tbl_autores" class="cell-border" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Apellido</th>
                                <th>Nombre</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                        session_start();	 
                        include ('../framework/dbconf.php');

                        $params = array();
                        $sql="{call lib_auto_view()}";
                        $auto_view = sqlsrv_query($conn, $sql, $params);
                        while($row_auto_view = sqlsrv_fetch_array($auto_view)){

                        ?>
                            <tr>
                                <td width="33%"><?= $row_auto_view['auto_apel'];?> </td>
                                <td width="33%"><?= $row_auto_view['auto_nomb'];?> </td>
                                <td width="33%">
                                    <a  data-toggle="modal" data-target="#modal_autor_edit"
                                     class="btn btn-primary" onclick="document.getElementById('auto_apel_edit').value='<?= $row_auto_view['auto_apel']?>';document.getElementById('auto_nomb_edit').value='<?= $row_auto_view['auto_nomb']?>';document.getElementById('auto_codi').value='<?= $row_auto_view['auto_codi']?>';"
                                    >
                                    <span class="fa fa-edit" aria-hidden="true"></span> Editar
                                    </a>
                                    <a  class="btn btn-danger" data-toggle="modal" data-target="#modal_autor_del"
                                    onclick="document.getElementById('auto_codi_del').value='<?= $row_auto_view['auto_codi']?>';">
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
