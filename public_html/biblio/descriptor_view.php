<div class="container-fluid theme-showcase" role="main">
    <!-- region de edicion -->
    <div class="box">
        <div class="box-header"> 
            <a data-toggle="modal" data-target="#modal_descriptor_add"
                 class="btn btn-success" onclick="document.getElementById('desc_deta').value=''">
                    <span class="fa fa-plus" aria-hidden="true"></span> Nuevo Descriptor
                    </a>
        </div>
        <div class="box-body" id="div_libro_main" >
            <div class="row">
                <div class="col-md-12">
                    <table id="tbl_descriptores" class="cell-border" cellspacing="0" width="100%">
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
                        $sql="{call lib_desc_view()}";
                        $desc_view = sqlsrv_query($conn, $sql, $params);
                        while($row_desc_view = sqlsrv_fetch_array($desc_view)){

                        ?>
                            <tr>
                                <td width="77%"><?= $row_desc_view['desc_deta'];?> </td>
                                <td width="23%">
                                    <a  data-toggle="modal" data-target="#modal_descriptor_edit"
                                     class="btn btn-primary" onclick="document.getElementById('desc_deta_edit').value='<?= $row_desc_view['desc_deta']?>';document.getElementById('desc_codi').value='<?= $row_desc_view['desc_codi']?>';"
                                    >
                                    <span class="fa fa-edit" aria-hidden="true"></span> Editar
                                    </a>
                                    <a  class="btn btn-danger" data-toggle="modal" data-target="#modal_descriptor_del"
                                    onclick="document.getElementById('desc_codi_del').value='<?= $row_desc_view['desc_codi']?>';">
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
