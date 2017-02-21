<div class="container-fluid">   
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <table class="table table-striped table-hover table-responsive" id="table_cons_Usuarios" data-page-length='8'>
                <thead>
                    <tr>
                        <th width="15%">Código</th>
                        <th width="40%">Apellido</th>
                        <th width="40%">Nombre</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    session_start();     
                    include ('../../../framework/dbconf.php');
                    if(isset($_POST['usua_tipo_codi'])){  $usua_tipo_codi=$_POST['usua_tipo_codi']; } else {$usua_tipo_codi=1;}
                    $params = array($usua_tipo_codi);
                    $sql="{call lib_prest_usua_view(?)}";
                    $usua_view = sqlsrv_query($conn, $sql, $params);
                    while($row_usua_view = sqlsrv_fetch_array($usua_view)){

                    ?>
                    <tr class="cursor_link" style="cursor: pointer;">
                        <td><?=$row_usua_view['usua_codi']?></td>
                        <td><?=$row_usua_view['usua_apel']?></td>
                        <td><?=$row_usua_view['usua_nomb']?></td>          
                    </tr>
                    <?php }?>
                </tbody>
            </table>
        </div>
    </div>
</div>