<div class="container-fluid">   
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <table class="table table-striped table-hover table-responsive" id="table_cons_prestamos" data-page-length='8'>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Ref</th>
                        <th>Libros</th>
                        <th>Usuarios</th>
                        <th>Prestado Por:</th>
                        <th>Fecha de Prestamo</th>
                        <th>Entregado a:</th>
                        <th>Fecha de Entrega</th>
                        <th>Opciones</th>
                        
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include("clases/PHP/Lib_Prestamos.php");
                  
                    $Prestamos = new Prestamos();
                    $Prestamos->lib_pres_view();       
                    $i=0;
                    foreach($Prestamos->rows as $Prestamo){$i++;?>
                    <tr class="cursor_link" >
                        <td><?= $i;?></td>
                        <td><?=$Prestamo['pres_codi']?></td>
                        <td><?=$Prestamo['libr_ejem_codi']?></td>
                        <td><?=$Prestamo['usua_codi']?></td>
                        <td><?=$Prestamo['usua_codi_inic']?></td>
                        <td><?= date_format($Prestamo['pres_fech_inic'], 'd/M/Y' ); ?></td>
                        <td><?=$Prestamo['usua_codi_entr']?></td>
                        <td><?= date_format($Prestamo['pres_fech_entr'], 'd/M/Y' ); ?></td> 
                        <td> entregar</td> 
                        
                    </tr>
                    <?php }?>
                </tbody>
            </table>
        </div>
    </div>
</div>