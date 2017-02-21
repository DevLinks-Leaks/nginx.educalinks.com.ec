<div class="container-fluid theme-showcase" role="main">
    <!-- region de edicion -->
    <div class="box">
        <div class="box-header"> 
            <a href="recurso_new.php"
                 class="btn btn-success" >
                <span class="fa fa-plus" aria-hidden="true"></span> Nuevo Recurso
            </a>
        </div>
        <div class="box-body" id="div_libro_main" >
            <div class="row">
                <div class="col-md-12">
                    <table id="tbl_recursos" class="cell-border" cellspacing="0" >
                        <thead>
                            <tr>
                                <th>Título</th>
                                <th>ISBN / ISSN</th>
                                <th>Tipo</th>
                                <th>Fecha de Registro</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                        session_start();	 
                        include ('../framework/dbconf.php');

                        $params = array();
                        $sql="{call lib_recu_view()}";
                        $recu_view = sqlsrv_query($conn, $sql, $params);
                        while($row_recu_view = sqlsrv_fetch_array($recu_view)){
                        ?>
                            <tr>
                                <td width="35%"><?= $row_recu_view['recu_titu'];?> </td>
                                <?php if($row_recu_view['recu_tipo_codi']==1){?>
                                <td width="15%"><?= $row_recu_view['recu_isbn'];?> </td>
                                <?php }elseif($row_recu_view['recu_tipo_codi']==2){?>
                                <td width="15%"><?= $row_recu_view['recu_issn'];?> </td>
                                <?php }else{?>
                                <td width="15%"> </td>
                                <?php } ?>
                                <td width="15%"><?= $row_recu_view['tipo_deta'];?> </td>
                                <td width="10%"><?= date_format( $row_recu_view['recu_fech_regi'], 'd/M/Y' );?> </td>
                                <td width="25%">
                                	<a  href="item.php?recu_codi=<?= $row_recu_view['recu_codi']?>"
                                     class="btn btn-success" >
                                    <span class="fa fa-list" aria-hidden="true"></span> Items
                                    </a>
                                    <a  href="recurso_new.php?recu_codi=<?= $row_recu_view['recu_codi']?>"
                                     class="btn btn-primary" >
                                    <span class="fa fa-edit" aria-hidden="true"></span> Editar
                                    </a>
                                    <a  class="btn btn-danger" data-toggle="modal" data-target="#modal_recurso_del"
                                    onclick="document.getElementById('recu_codi_del').value='<?= $row_recu_view['recu_codi']?>';">
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
