<div class="container-fluid">   
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <table class="table table-striped table-hover table-responsive" id="table_cons_Colecciones" data-page-length='8'>
                <thead>
                    <tr>                       
                        <th >Código</th>
                        <th >Colecciones</th>
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
                    <tr class="cursor_link" style="cursor: pointer;">
                        <td><?= $row_cole_view['cole_codi'];?></td>
                        <td><?= $row_cole_view['cole_deta'];?></td>            
                    </tr>
                    <?php }?>
                </tbody>
            </table>
        </div>
    </div>
</div>