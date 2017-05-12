<?php  
    session_start();
    include ('../framework/dbconf.php');
    include ('../framework/funciones.php');
    if(isset($_POST['alum_codi'])){$alum_codi=$_POST['alum_codi'];}else{if(isset($_GET['alum_codi'])){$alum_codi=$_GET['alum_codi'];}else{$alum_codi=0;}}
    // if(isset($_POST['repr_codi'])){$repr_codi=$_POST['repr_codi'];}else{if(isset($_GET['repr_codi'])){$repr_codi=$_GET['repr_codi'];}else{$repr_codi=0;}}
    
    /*Para los parentescos*/
    $row_parentescos = array();
    $sql="{call parentescos_cons()}";
    $stmt = sqlsrv_query($conn, $sql);
    if( $stmt === false )
    {
        echo "Error in executing statement .\n";
        die( print_r( sqlsrv_errors(), true));
    }
    else
        if (sqlsrv_has_rows($stmt))
            while($row_parentescos[]= sqlsrv_fetch_array($stmt));
        array_pop($row_parentescos);
    $sql_opc = "{call repr_alum_info(?)}";
    $params_opc= array($alum_codi);
    $stmt_opc = sqlsrv_query( $conn, $sql_opc,$params_opc);
    $cc=0;
?>
<input id="hd_alum_codi" name="hd_alum_codi" type="hidden" value="<?=$alum_codi;?>"/>
<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title">
            <button id="btn_regresar" name="btn_regresar" class='btn btn-warning' type="button" onclick="window.history.back();"><span class='fa fa-arrow-left'></span> Volver</button>
            
        </h3>
        <div class="pull-right">
            <a id="bt_curs_add" class="btn btn-primary" data-toggle="modal" data-target="#modal_representante_edit" onclick="load_modal_repre_view('modal_representante_edit_content','representantes_add_modal.php','repr_codi=0');">
                <span class="fa fa-plus"></span> Representante
            </a>
        </div>
    </div><!-- /.box-header -->
    <div class="box-body">
        <table class="table table-striped" id="repr_table">
            <thead>
                <tr>
                    <th class="text-center">Número de identidad </th>
                    <th class="text-center">Nombre </th>
                    <th class="text-center">Relación </th>
                    <th class="text-center">Principal / Legal </th>
                    <th class="text-center">Financiero </th>
                    <th >Opciones</th>
                </tr>
            </thead>
                <tbody>
                   <?php while ($row_repr_view = sqlsrv_fetch_array($stmt_opc)) { $cc +=1; ?>
                   <tr> 
                        <td class="text-center"><?=$row_repr_view['repr_cedula'];?></td>
                        <td class="text-center"><?=$row_repr_view['repr_apel']." ".$row_repr_view['repr_nomb'];?></td>
                        <td class="text-center">
                            <select id="<?= $row_repr_view['repr_codi'];?>" class="form-control" onchange="update_relative('div_repr_list','script_repr.php','<?=$alum_codi?>','<?=$row_repr_view['repr_codi']?>',this.value);">
                                <option value="0">Elija</option>
                                <?  $selected="";
                                foreach ($row_parentescos as $row_par)
                                {
                                 if ($row_par["codigo"]==$row_repr_view["idparentesco"])
                                     $selected="selected";
                                 else
                                     $selected="";
                                echo "<option value='".$row_par["codigo"]."' $selected>".$row_par["descripcion"]."</option>";
                                }
                                ?>
                            </select>
                        </td>
                        <td class="text-center">
                            <input type="radio" class="principal" name="principal" data-reprcodi="<?=$row_repr_view['repr_codi']?>"  title='Hacer principal'
                            <?php if($row_repr_view['repre_alum_princ']=='P'){echo " checked='checked' ";}?> />
                        </td>
                        <td class="text-center">
                            <input type="radio" class="financiero" name="financiero" data-reprcodi="<?=$row_repr_view['repr_codi']?>" title='Hacer financiero'
                            <?php if($row_repr_view['repre_alum_fact']=='S'){echo " checked='checked' ";}?> />
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group">
                                <a class="btn btn-default" data-toggle="modal" onmouseover="$(this).tooltip('show')" title="Editar Representante" data-target="#modal_representante_edit" onclick="load_modal_repre_view('modal_representante_edit_content','representantes_add_modal.php','repr_codi=<?=$row_repr_view['repr_codi']?>');"  >
                                    <span class="fa fa-pencil btn_opc_lista_editar"></span>
                                </a>
                                <a class="btn btn-danger" onmouseover="$(this).tooltip('show')" title="Eliminar Representante" href="javascript:quitar_representado('script_repr.php','<?=$alum_codi?>','<?=$row_repr_view['repr_codi']?>');" >
                                    <span class="fa fa-trash "></span>
                                </a> 
                            </div>
                        </td>
                    </tr>

                <?php  }?>
                <tr class="pager_table">
                    <td colspan="2">
                        <span class="fa fa-users"> </span> Total de Representantes ( <?php echo $cc;?> )
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
