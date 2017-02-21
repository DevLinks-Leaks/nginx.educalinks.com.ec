<?php
    include("clases/PHP/Lib_Categorias.php");
    $busq="";
    $Categorias = new Categorias();
    $Categorias->lib_cate_view();       
    $i=0;
	 
?>
 
<div class="container-fluid">   
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <table class="table table-striped table-hover table-responsive" id="table_cons_Categorias" data-page-length='8'>
                <thead>
                    <tr>                       
                        <th  style="width:10px;">Código</th>
                        <th >Categoria</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                 
                    foreach($Categorias->rows as $Categoria){$i++;?>
                    <tr class="cursor_link" onClick="">
                        
                        <td><?= $Categoria['cate_codi'];?></td>
                        <td>
                        	<span id="cate_deta_<?=$i;?>"><?=$Categoria['cate_deta']?></span>                        </td>            
                    </tr>
                    <?php }?>
                </tbody>
            </table>
        </div>
    </div>
</div>