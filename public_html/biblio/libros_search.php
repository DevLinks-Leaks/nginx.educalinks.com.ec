 

<div class="panel-body"  >
	<div class="row"  >
		<div class="col-md-6">  
        
        <input type="text" class="global_filter" id="busca_todos">
        </div>
        <div class="col-md-4">  
         <button class="btn btn-primary" type="button"  aria-expanded="false" aria-controls="collapseExample">
	         <span class="glyphicon glyphicon-search" aria-hidden="true"></span> Buscar
        </button>
          <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#buscamas" aria-expanded="false" aria-controls="buscamas">
	       <span class="glyphicon glyphicon-triangle-bottom" aria-hidden="true"></span>
           <span class="glyphicon glyphicon-triangle-bottom" aria-hidden="true"></span>
        </button>
        </div>
        <div class="col-md-2 text-right">
        	 <button type="button" class="btn btn-default btn-sm">
             	<span class="glyphicon glyphicon-print" aria-hidden="true"></span> Imprimir</button>
        </div>  
	</div>
</div>

<div class="panel-body collapse"  id="buscamas">
     <div class="row" style="margin-top:10px;">
            <div class="col-md-6 bottom_10">         
                <div class="row ">
                    <div class="col-md-12 bottom_10">     
                        <div class="input-group">
                       
                   <span class="input-group-addon"  >   <input id="libr_tipo_codi_ch" type="checkbox" aria-label="..."> Tipo: <?= $row_lib_libr_tipo_view['libr_tipo_codi'];?></span>
                    <?php 
                        $params = array();
                        $sql="{call lib_libr_tipo_view()}";
                        $lib_libr_tipo_view= sqlsrv_query($conn, $sql, $params);  
                        $cc = 0;

                    ?>
                    <select class="form-control"  id="libr_tipo_codi"   onChange="Libros.libr_tipo_view(selectvalue(this),'div_revista','div_video')">
                        <?php  while ($row_lib_libr_tipo_view = sqlsrv_fetch_array($lib_libr_tipo_view)) {?> 
                            <option  value="<?= $row_lib_libr_tipo_view['libr_tipo_codi']; ?>"  <? if ($libr_tipo_codi==$row_lib_libr_tipo_view['libr_tipo_codi']) echo 'selected="selected"';  ?>>
                                  <?= $row_lib_libr_tipo_view['libr_tipo_deta']; ?>
                            </option> 
                        <?php  } ?>
                    </select>
                 </div> 
                    </div>
                </div>
                <div class="row" style="margin-top:10px;">
                    <div class="col-md-12 bottom_10">    
                        <div class="input-group">
                            <span class="input-group-addon" > <input id="libr_edit_codi_ch" type="checkbox" aria-label="..."> 
                            Editorial:</span>
                            <input name="libr_edit_codi" type="hidden" class="form-control" id="libr_edit_codi"value="<?= $libr_edit_codi;?>"  >
                            <input name="libr_edit_deta" type="text" class="form-control" id="libr_edit_deta" value="<?= $libr_edit_deta;?>" placeholder="Editorial" readonly  >

                            <span class="input-group-btn">
                            <button class="btn btn-default" type="button" data-toggle="modal" data-target="#modal_editorial">
                                        <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                            </button>
                            </span>
                        </div>
                     </div>    
                </div>
                <div class="row" style="margin-top:10px;">
                    <div class="col-md-12 bottom_10"> 
                        <div class="input-group">
                            <span class="input-group-addon" > <input id="libr_auto_codi_ch" type="checkbox" aria-label="..."> 
                            Autor:</span>
                            <input name="libr_auto_codi" type="hidden" class="form-control" id="libr_auto_codi"value="<?= $libr_auto_codi;?>"  >
                            <input name="libr_auto_deta" type="text" class="form-control" id="libr_auto_deta" value="<?= $libr_auto_nomb;?>" placeholder="Autor" readonly  >

                            <span class="input-group-btn">
                            <button class="btn btn-default" type="button" data-toggle="modal" data-target="#modal_autores">
                                       <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                            </button>
                            </span>
                        </div>                      
                    </div>    
                </div>
                <div class="row" style="margin-top:10px;">
                    <div class="col-md-12 bottom_10"> 
                        <div class="input-group">
                            <span class="input-group-addon" > <input id="libr_cole_codi_ch" type="checkbox" aria-label="..."> 
                            Coleccion:</span>
                            <input name="libr_cole_codi" type="hidden" class="form-control" id="libr_cole_codi"value="<?= $libr_cole_codi;?>"  >
                            <input name="libr_cole_deta" type="text" class="form-control" id="libr_cole_deta" value="<?= $libr_cole_deta;?>" placeholder="NINGUNA" readonly  >

                            <span class="input-group-btn">
                            <button class="btn btn-default" type="button" data-toggle="modal" data-target="#modal_colecciones">
                                       <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                            </button>
                            </span>
                        </div>                      
                    </div>    
                </div>
                <div class="row" style="margin-top:10px;">
                    <div class="col-md-12 bottom_10"> 
                        <div class="input-group">
                            <span class="input-group-addon" > <input id="cate_codi_ch" type="checkbox" aria-label="..."> 
                            Categorias:</span>
                            
                               <select name="cate_codi" multiple="multiple"  class="form-control">
                                    <option>text1</option>
         
                                </select>

                            <span class="input-group-btn">
                            <button class="btn btn-default" type="button" data-toggle="modal" data-target="#modal_categorias">
                                       <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                            </button>
                            <button class="btn btn-warning" type="button"  >
                                       <span class="glyphicon glyphicon-minus" aria-hidden="true"></span>
                            </button>
                            </span>
                        </div>                      
                    </div>    
                </div>
            </div>

            <div class="col-md-6 col-xs-12 col-sm-6 bottom_10"> 
              
            </div>
        </div>
</div>
