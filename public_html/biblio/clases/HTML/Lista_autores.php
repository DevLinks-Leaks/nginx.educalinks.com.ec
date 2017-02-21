<?php
    include("clases/PHP/Lib_Autores.php");
    $busq="";
    $Autores = new Autores();
    $Autores->lib_auto_view($busq);       
    $i=0;
	 
?>
 
dd
<div class="container-fluid">   
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <table class="table table-striped table-hover table-responsive" id="table_cons_Autores" data-page-length='8'>
                <thead>
                    <tr>                       
                        <th  style="width:10px;">Código</th>
                        <th >Autores</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                 
                    foreach($Autores->rows as $Autor){$i++;?>
                    <tr class="cursor_link" onClick="">
                        
                        <td><?= $Autor['libr_auto_codi'];?></td>
                        <td>
                        	Nombre: <span id="libr_auto_deta_<?=$Autor['libr_auto_codi']?>"><?=$Autor['libr_auto_nomb']?></span>                        </td>            
                    </tr>
                    <?php }?>
                </tbody>
            </table>
        </div>
    </div>
</div>