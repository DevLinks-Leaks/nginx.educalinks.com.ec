
<div class="container-fluid">   
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <table class="table table-striped table-hover table-responsive" id="table_cons_Editorialess" data-page-length='8'>
                <thead>
                    <tr>
                        <th width="20%">codigo</th>
                        <th width="80%">Editoriales</th>
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
                    <tr class="cursor_link" style="cursor: pointer;">
                        <td><?= $row_edit_view['edit_codi'];?></td>
                        <td><?= $row_edit_view['edit_deta'];?></td>
                    </tr>
                    <?php }?>
                </tbody>
            </table>
        </div>
    </div>
</div>
