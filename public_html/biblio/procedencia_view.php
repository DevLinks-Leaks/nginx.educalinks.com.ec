<div class="container-fluid theme-showcase" role="main">
    <!-- region de edicion -->
    <div class="box">
        <div class="box-header"> 
            <a data-toggle="modal" data-target="#modal_procedencia_add"
                 class="btn btn-success" onclick="document.getElementById('proc_deta').value=''">
                    <span class="fa fa-plus" aria-hidden="true"></span> Nueva Procedencia
                    </a>
        </div>
        <div class="box-body" id="div_libro_main" >
            <div class="row">
                <div class="col-md-12">
                    <table id="tbl_procedencias" class="cell-border" cellspacing="0" width="100%">
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
                        $sql="{call lib_proc_view()}";
                        $proc_view = sqlsrv_query($conn, $sql, $params);
                        while($row_proc_view = sqlsrv_fetch_array($proc_view)){
                        ?>
                            <tr>
                                <td width="77%"><?= $row_proc_view['proc_deta'];?> </td>
                                <td width="23%">
                                    <a  data-toggle="modal" data-target="#modal_procedencia_edit"
                                     class="btn btn-primary" onclick="document.getElementById('proc_deta_edit').value='<?= $row_proc_view['proc_deta']?>';document.getElementById('proc_codi').value='<?= $row_proc_view['proc_codi']?>';"
                                    >
                                    <span class="fa fa-edit" aria-hidden="true"></span> Editar
                                    </a>
                                    <a  class="btn btn-danger" data-toggle="modal" data-target="#modal_procedencia_del"
                                    onclick="document.getElementById('proc_codi_del').value='<?= $row_proc_view['proc_codi']?>';">
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
