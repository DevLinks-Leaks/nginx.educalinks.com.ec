<div class="container-fluid">   
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <table class="table table-striped table-hover table-responsive" id="table_cons_libros_ejemplares" data-page-length='8'>
                <thead>
                    <tr>
                        <th width="5%">#</th>
                        <th width="15%">Código</th>
                        <th width="80%">Libros</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include("clases/PHP/Lib_Libros.php");
                    $busq="";
                    $Libros = new Libros();
                    $Libros->libr_ejem_view($busq);       
                    $i=0;
                    foreach($Libros->rows as $Libros){$i++;?>
                    <tr class="cursor_link" >
                        <td><?= $i;?></td>
                        <td><span id="libr_ejem_codi_<?=$i?>"><?=$Libros['libr_ejem_codi']?></span></td>
                        <td>
                            <div class="row">
                                 
                                <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        Titulo: <span id="libr_titu_<?=$i?>"><?=$Libros['libr_titu']?></span> </div>
                                    </div>
                                     
                                </div>
                            </div>
                        </td>            
                    </tr>
                    <?php }?>
                </tbody>
            </table>
        </div>
    </div>
</div>