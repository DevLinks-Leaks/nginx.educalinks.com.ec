<?php 

	session_start();	 
	include ('../framework/dbconf.php');  
	include ('../../Clases/PHP/Lib_Libros.php');
	 
 	
	
	if(isset($_GET['libr_codi'])){	$libr_codi=$_GET['libr_codi']; } else {$libr_codi=0;}
	
	$libr_cole_codi=1;
        $libr_tipo_codi=1;
	if ($libr_codi > 0) {
			
		 
		$params = array($libr_codi);
		$sql="{call lib_libr_info(?)}";
		$lib_libr_info= sqlsrv_query($conn, $sql, $params);  
		$row_lib_libr_info = sqlsrv_fetch_array($lib_libr_info);
		
		$libr_codi_impr=$row_lib_libr_info['libr_codi_impr'];
		$libr_titu=$row_lib_libr_info['libr_titu'];
                
		$libr_auto_codi=$row_lib_libr_info['libr_auto_codi'];
		$libr_cole_codi=$row_lib_libr_info['libr_cole_codi'];
		$libr_edit_codi=$row_lib_libr_info['libr_edit_codi'];
		$libr_tipo_codi=$row_lib_libr_info['libr_tipo_codi'];
                
		$libr_auto_nomb=$row_lib_libr_info['libr_auto_nomb'];
		$libr_cole_deta=$row_lib_libr_info['libr_cole_deta'];
		$libr_edit_deta=$row_lib_libr_info['libr_edit_deta'];
		$libr_tipo_deta=$row_lib_libr_info['libr_tipo_deta'];
                
                
		$libr_issn=$row_lib_libr_info['libr_issn'];
		$libr_isbn=$row_lib_libr_info['libr_isbn'];
		$libr_revi_nume=$row_lib_libr_info['libr_revi_nume'];
		
		
		$libr_fech_publ=$row_lib_libr_info['libr_fech_publ'];
		$libr_fech_ingr=$row_lib_libr_info['libr_fech_ingr'];
		
		
		$libr_obse=$row_lib_libr_info['libr_obse'];
		
		
		$libr_fech_regi=$row_lib_libr_info['libr_fech_regi'];
		$usua_codi=$row_lib_libr_info['usua_codi'];
		$libr_esta=$row_lib_libr_info['libr_esta'];
		
		
		$libr_vide_dire=$row_lib_libr_info['libr_vide_dire'];
		$libr_vide_acto=$row_lib_libr_info['libr_vide_acto'];
		$libr_vide_inte=$row_lib_libr_info['libr_vide_inte'];
		$libr_vide_orig=$row_lib_libr_info['libr_vide_orig'];
		$libr_vide_dura=$row_lib_libr_info['libr_vide_dura'];
		$libr_vide_gene=$row_lib_libr_info['libr_vide_gene'];
		$libr_vide_resu=$row_lib_libr_info['libr_vide_resu'];
		
                
		
	}
 	 
?>

    <!-- region de edicion -->
<div class="panel panel-default">
    <div class="panel-heading"> 
            <h4> Libro: <?php if ($libr_codi > 0)  echo '#: ' . $libr_codi . ' - ' . $libr_titu . '  Codigo: ' .$libr_codi_impr ; else echo 'Nuevo' ?> </h4>
    </div>
    <div class="panel-body" id="div_libro_main" >

        <div class="row">
            <div class="col-md-6 col-xs-12 col-sm-6 ">
                <div class="input-group">
                    <span class="input-group-addon" >Titulo:</span>
                    <input type="text" class="form-control" id="libr_titu" name="libr_titu" placeholder="Titulo" value="<?= $libr_titu;?>">
                </div>
            </div>

            <div class="col-md-6 ">     
                <div class="input-group">
                    <span class="input-group-addon"  >Tipo: <?= $row_lib_libr_tipo_view['libr_tipo_codi'];?></span>
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
        <div class="row">
            <div class="col-md-6 ">         
                <div class="row ">
                    <div class="col-md-12 ">     
                        <div class="input-group">
                            <span class="input-group-addon"  >Tipo: <?= $row_lib_libr_tipo_view['libr_tipo_codi'];?></span>
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
                            <span class="input-group-addon" >Editorial:</span>
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
                            <span class="input-group-addon" >Autor:</span>
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
                            <span class="input-group-addon" >Coleccion:</span>
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
                            <span class="input-group-addon" >Categorias:</span>
                            
                               <select id="cate_codi" name="cate_codi" multiple="multiple"  class="form-control">
                                    
         
                                </select>

                            <span class="input-group-btn">
                            <button class="btn btn-default" type="button" data-toggle="modal" data-target="#modal_categorias">
                                       <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                            </button>
                            <button class="btn btn-warning" type="button"   onClick="elimina_option('cate_codi');">
                                       <span class="glyphicon glyphicon-minus" aria-hidden="true"></span>
                            </button>
                            </span>
                        </div>                      
                    </div>    
                </div>
            </div>

            <div class="col-md-6 col-xs-12 col-sm-6 bottom_10"> 
                <div class="row" style="margin-top:10px;">
                     <div class="col-md-12 bottom_10"> 
                        <div class="input-group">
                            <span class="input-group-addon" >Caratula:</span>
                            <input name="libr_cara" type="file" multiple class="form-control" id="libr_cara" accept='image/*'>
                        </div> 
                     </div>
                </div>
                <div class="row" style="margin-top:10px;">
                     <div class="col-md-12 bottom_10">     
                       <div class="thumbnail">
                            <img src="../files/desarrollo/libros/lib_0.jpg"  />      
                        </div>
                    </div>
                </div>    
            </div>
        </div>




        <div class="row">
            <div class="col-md-6 col-xs-12 col-sm-6 bottom_10">
                <div class="input-group">
                    <span class="input-group-addon" >ISSN:</span>
                    <input type="text" class="form-control" id="libr_issn" name="libr_issn" placeholder="Numero ISSN"  value="<?= $libr_issn;?>" >
                </div><br />

                
            </div>
            
            <div class="col-md- col-xs-12 col-sm-6 bottom_10" style="margin-top:10px;">
            	<div class="row">
                	<div class="col-md-12 col-xs-12 col-sm-6 bottom_10" style="margin-top:10px;">
                    	<div class="input-group">
                            <span class="input-group-addon" >Fecha Publicacion:</span>
                            <input type="text" class="form-control" id="libr_fech_publ" name="libr_fech_publ" value="">
                        </div>
                   </div>
               </div>
               <div class="row">
                   <div class="col-md-12 col-xs-12 col-sm-6 bottom_10" style="margin-top:10px;">
                     	<div class="input-group">
                        	<span class="input-group-addon" >Fecha Ingreso:</span>
                        	<input type="text" class="form-control" id="libr_fech_ingr" name="libr_fech_ingr" value="">
                   		</div>
                   </div>
               </div>
            </div>
        </div>
        <div class="row">&nbsp;</div>
        <div class="row">
            <div class="col-md-12 col-xs-12 col-sm-6 bottom_10">
                <div class="input-group">
                    <span class="input-group-addon" >Observacion :</span>    
                    <textarea class="form-control" rows="3" id="libr_obse"> <?= $libr_obse;?></textarea>
                </div>
            </div>
        </div>
        
        
        <!--   /////////////////////  REVISTA //////////////////////-->
        <div  id="div_revista" class="panel panel-default" style="margin-top:10px;" >

            <div class="panel-body">
                <div class="row">
                    <div class="col-md-3 col-xs-12 col-sm-6 bottom_10">
                         <div class="input-group">
                            <span class="input-group-addon" >ISBN:</span>
                            <input type="text" class="form-control" id="libr_isbn" name="libr_isbn" placeholder="Numero ISBN"   value="<?= $libr_isbn;?>">
                        </div>
                    </div>  
                    <div class="col-md-3 col-xs-12 col-sm-6 bottom_10">
                         <div class="input-group">
                            <span class="input-group-addon" >Numero:</span>
                            <input type="text" class="form-control" id="libr_revi_nume" name="libr_revi_nume" placeholder="Numero de Revista"   value="<?= $libr_revi_nume;?>">
                        </div>
                    </div>                      
                </div>
            </div>   
        </div>
        <!--   ********************  REVISTA ********************-->
        
        
        <!--   /////////////////////  VIDEO PELICULA DVD  //////////////////////-->
        <div  id="div_video" class="panel panel-default" style="margin-top:10px;" >

            <div class="panel-body">
                <div class="row" style="margin-top:10px;" >
                    <div class="col-md-9 col-xs-12 col-sm-6 bottom_10">
                         <div class="input-group">
                            <span class="input-group-addon" >Director:</span>
                            <input type="text" class="form-control" id="libr_vide_dire" name="libr_vide_dire" placeholder="Director"   value="<?= $libr_vide_dire;?>">
                        </div>
                    </div>  
                    <div class="col-md-3 col-xs-12 col-sm-6 bottom_10">
                         <div class="input-group">
                            <span class="input-group-addon" >Duracion:</span>
                            <input type="text" class="form-control" id="libr_vide_dura" name="libr_vide_dura" placeholder="Duracion de Video"   value="<?= $libr_vide_dura;?>">
                        </div>
                    </div>   
                    
                </div>
                 <div class="row" style="margin-top:10px;" >
                    <div class="col-md-7 col-xs-12 col-sm-6 bottom_10">
                         <div class="input-group">
                            <span class="input-group-addon" >Actores:</span>
                            <input type="text" class="form-control" id="libr_vide_acto" name="libr_vide_acto" placeholder="Actores Principales"   value="<?= $libr_vide_acto;?>">
                        </div>
                    </div>  
                    <div class="col-md-5 col-xs-12 col-sm-6 bottom_10">
                         <div class="input-group">
                            <span class="input-group-addon" >Genero:</span>
                            <input type="text" class="form-control" id="libr_vide_gene" name="libr_vide_gene" placeholder="Genero"   value="<?= $libr_vide_gene;?>">
                        </div>
                    </div>   
                    
                </div>
                 <div class="row" style="margin-top:10px;" >
                    <div class="col-md-7 col-xs-12 col-sm-6 bottom_10">
                         <div class="input-group">
                            <span class="input-group-addon" >Interpertes:</span>
                            <input type="text" class="form-control" id="libr_vide_inte" name="libr_vide_inte" placeholder="Interpretes Secundarios"   value="<?= $libr_vide_inte;?>">
                        </div>
                    </div>  
                    <div class="col-md-5 col-xs-12 col-sm-6 bottom_10">
                         <div class="input-group">
                            <span class="input-group-addon" >Origen:</span>
                            <input type="text" class="form-control" id="libr_vide_orig" name="libr_vide_orig" placeholder="Origen"   value="<?= $libr_vide_orig;?>">
                        </div>
                    </div>   
                    
                </div>
                 <div class="row" style="margin-top:10px;" >
                 	<div class="col-md-12 col-xs-12 col-sm-6 bottom_10">
                         <div class="input-group">
                            <span class="input-group-addon" >Resumen :</span>    
                            <textarea class="form-control" rows="3" id="libr_vide_resu"> <?= $libr_vide_resu;?></textarea>
                        </div>
                    </div>
                </div>
            </div>   
        </div>
        <!--   ********************   VIDEO PELICULA DVD  ********************-->
        
        
        <!--   /////////////////////  EJEMPLARES  //////////////////////-->
        <?php if ($libr_codi > 0) { ?>
            <div class="panel panel-default" style="margin-top:10px;"> 
            	<div class="panel-heading"> 
                   Ejemplares
            	</div>
                <div class="panel-body"  id="div_libro_ejemplares" >
                	<? include ('libro_view_ejem.php'); ?>
                </div>
            </div>
            
        <? } ?>    
        <!--   ********************   EJEMPLARES ********************-->
        
        <div class="panel panel-default" style="margin-top:10px;" >
          
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-3 col-xs-12 col-sm-6 bottom_10">
                        <button class="btn btn-primary"  <?php if ($libr_codi > 0) { ?>onclick="boton_click('U');" <? } else { ?>  onclick="boton_click('N');" <? } ?> >
                            <span class="glyphicon glyphicon-save"></span> <?php if ($libr_codi > 0)  echo 'Guardar Cambio en Libro' ; else   echo 'Guardar Nuevo Libro'; ?>
                        </button>
                    </div>    	 
                </div>
            </div>   
        </div>
        
        
    </div>
 </div>
 
 <div id="resu_view" > </div>


    
    
 