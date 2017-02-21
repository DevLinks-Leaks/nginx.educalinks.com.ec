<div class="container-fluid theme-showcase" role="main">
    <!-- region de edicion -->
    <div class="box">
        <div class="box-header"> 
            <a data-toggle="modal" data-target="#modal_editorial_add"
                 class="btn btn-success" onclick="document.getElementById('edit_deta').value=''">
                    <span class="fa fa-plus" aria-hidden="true"></span> Nuevo Editorial
                    </a>
        </div>
        <div class="box-body" id="div_libro_main" >
            <div class="row">
                <div class="col-md-12">
                    <table id="tbl_editoriales" class="cell-border" cellspacing="0" width="100%">
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
                        $sql="{call lib_edit_view()}";
                        $edit_view = sqlsrv_query($conn, $sql, $params);
                        while($row_edit_view = sqlsrv_fetch_array($edit_view)){
                        ?>
                        
                            <tr>
                                <td width="77%"><?= $row_edit_view['edit_deta'];?> </td>
                                <td width="23%">
                                    <a  data-toggle="modal" data-target="#modal_editorial_edit"
                                     class="btn btn-primary" onclick="document.getElementById('edit_deta_edit').value='<?= $row_edit_view['edit_deta']?>';document.getElementById('edit_codi').value='<?= $row_edit_view['edit_codi']?>';"
                                    >
                                    <span class="fa fa-edit" aria-hidden="true"></span> Editar
                                    </a>
                                    <a  class="btn btn-danger" data-toggle="modal" data-target="#modal_editorial_del"
                                    onclick="document.getElementById('edit_codi_del').value='<?= $row_edit_view['edit_codi']?>';">
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
