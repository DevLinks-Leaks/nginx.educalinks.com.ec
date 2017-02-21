<?php 

    session_start();     
    include ('../framework/dbconf.php');  
    include ('../../Clases/PHP/Lib_Libros.php');
     
    
    
    if(isset($_GET['recu_codi'])){  $recu_codi=$_GET['recu_codi']; } else {$recu_codi=0;}
    
    
    $recu_tipo_codi=1;
    if ($recu_codi > 0) {
            
         
        $params = array($recu_codi);
        $sql="{call lib_recu_info(?)}";
        $lib_recu_info= sqlsrv_query($conn, $sql, $params);  
        $row_lib_recu_info = sqlsrv_fetch_array($lib_recu_info);
        
        $recu_codi_impr=$row_lib_recu_info['recu_codi_impr'];
        $recu_titu=$row_lib_recu_info['recu_titu'];
        $recu_isbn=$row_lib_recu_info['recu_isbn'];
        $recu_issn=$row_lib_recu_info['recu_issn'];
        $recu_fech_publ=date_format( $row_lib_recu_info['recu_fech_publ'], 'd/m/Y' );
        //$recu_vide_dura=$row_lib_recu_info['recu_vide_dura'];
        //$recu_vide_resu=$row_lib_recu_info['recu_vide_resu'];


        $recu_auto_codi=$row_lib_recu_info['recu_auto_codi'];
        $recu_cole_codi=$row_lib_recu_info['recu_cole_codi'];
        $recu_edit_codi=$row_lib_recu_info['recu_edit_codi'];
        $recu_tipo_codi=$row_lib_recu_info['recu_tipo_codi'];

        $recu_edit_deta=$row_lib_recu_info['edit_deta'];
        $recu_cole_deta=$row_lib_recu_info['cole_deta'];
        
        $array_cate = [];

        $params = array($recu_codi);
        $sql="{call lib_recu_cate_view(?)}";
        $recu_cate_view= sqlsrv_query($conn, $sql, $params);
        while($row_recu_cate_view = sqlsrv_fetch_array($recu_cate_view)){
             $array_cate[$row_recu_cate_view['cate_codi']] = $row_recu_cate_view['cate_codi'];
        }

        $array_desc = [];

        $params = array($recu_codi);
        $sql="{call lib_recu_desc_view(?)}";
        $recu_desc_view= sqlsrv_query($conn, $sql, $params);
        while($row_recu_desc_view = sqlsrv_fetch_array($recu_desc_view)){
             $array_desc[$row_recu_desc_view['desc_codi']] = $row_recu_desc_view['desc_codi'];
        }
    }
     
?>

    <!-- region de edicion -->
<div class="box box-default">
    <div class="box-header with-border"> 
            <h3 class="box-title"> Recurso: <?php if ($recu_codi > 0)  echo '#: ' . $recu_codi . ' - ' . $recu_titu ; else echo 'Nuevo' ?> </h4>
    </div>
    <div class="box-body" id="div_libro_main" >

        <div class="row">
            <div class="col-md-6 ">
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon" >Titulo:</span>
                        <input type="text" class="form-control" id="recu_titu" name="recu_titu" placeholder="Titulo" value="<?= $recu_titu;?>">
                    </div>
                </div>
            </div>

            <div class="col-md-6 ">
                <div class="form-group">   
                    <div class="input-group">
                        <span class="input-group-addon"  >Tipo: <?= $row_lib_recu_tipo_view['recu_tipo_codi'];?></span>
                        <?php 
                            $params = array();
                            $sql="{call lib_tipo_view()}";
                            $lib_recu_tipo_view= sqlsrv_query($conn, $sql, $params);  
                            $cc = 0;
                        ?>
                        <select class="form-control" id="recu_tipo_codi" onchange="load_ajax_recu_dynamic('dynamic','script_recursos.php','opc=change&tipo_codi='+$('#recu_tipo_codi').val()+'&recu_codi=<?= $recu_codi; ?>');" <?php if ($recu_codi>0) echo 'disabled'  ?> >
                        <?php  while ($row_lib_recu_tipo_view = sqlsrv_fetch_array($lib_recu_tipo_view)) {?> 
                            <option  value="<?= $row_lib_recu_tipo_view['tipo_codi']; ?>"  <? if ($recu_tipo_codi==$row_lib_recu_tipo_view['tipo_codi']) echo 'selected="selected"';  ?>>
                              <?= $row_lib_recu_tipo_view['tipo_deta']; ?>
                            </option> 
                        <?php  } ?>
                        </select>
                    </div>
                </div> 
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
            <!--  IZQUIERDA -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">  
                            <div class="input-group">
                                <span class="input-group-addon" >Editorial:</span>
                                <input name="recu_edit_codi" type="hidden" class="form-control" id="recu_edit_codi" value="<?= $recu_edit_codi;?>"  >
                                <input name="recu_edit_deta" type="text" class="form-control" id="recu_edit_deta" value="<?= $recu_edit_deta;?>" placeholder="Editorial.." readonly  >

                                <span class="input-group-btn">
                                <button class="btn btn-default" type="button" data-toggle="modal" data-target="#modal_editorial">
                                            <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                                </button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12"> 
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon" >Coleccion:</span>
                                <input name="recu_cole_codi" type="hidden" class="form-control" id="recu_cole_codi" value="<?= $recu_cole_codi;?>"  >
                                <input name="recu_cole_deta" type="text" class="form-control" id="recu_cole_deta" value="<?= $recu_cole_deta;?>" placeholder="Colección.." readonly  >

                                <span class="input-group-btn">
                                <button class="btn btn-default" type="button" data-toggle="modal" data-target="#modal_colecciones">
                                           <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                                </button>
                                </span>
                            </div>                      
                        </div>    
                    </div>
                    <div class="col-md-12"> 
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon" >Fecha Publicacion:</span>
                                <input type="text" class="form-control" id="recu_fech_publ" name="recu_fech_publ" value="<?= $recu_fech_publ;?>">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                            </div>
                        </div>    
                    </div>
                    <div class="col-md-12"> 
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon" >Categorias:</span>
                                <?php 
                                    $params = array();
                                    $sql="{call lib_cate_view()}";
                                    $lib_cate_view= sqlsrv_query($conn, $sql, $params);  
                                    $cc = 0;
                                ?>
                                <select id="recu_cate_codi" style="width:100%;position: absolute;border-color:#d2d6de;" name="recu_cate_codi[]" multiple="multiple" data-placeholder="Seleccione las categorías" class="form-control">
                                <?php  while ($row_lib_cate_view = sqlsrv_fetch_array($lib_cate_view)) {
                                            if($array_cate[$row_lib_cate_view['cate_codi']]!=null)
                                                $selected = 'selected';
                                            else
                                                $selected = '';
                                ?> 
                                    <option  value="<?= $row_lib_cate_view['cate_codi']; ?>" <?= $selected ?> >
                                      <?= $row_lib_cate_view['cate_deta']; ?>
                                    </option> 
                                <?php  } ?>
                                </select>
                            </div>
                        </div>    
                    </div>
                    <div class="col-md-12"> 
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon" >Descriptor:</span>
                                <?php 
                                    $params = array();
                                    $sql="{call lib_desc_view()}";
                                    $lib_desc_view= sqlsrv_query($conn, $sql, $params);  
                                    $cc = 0;
                                ?>
                                <select id="recu_desc_codi" style="width:100%;position: absolute;border-color:#d2d6de;" name="recu_desc_codi[]" multiple="multiple" data-placeholder="Seleccione las descriptores" class="form-control">
                                <?php  while ($row_lib_desc_view = sqlsrv_fetch_array($lib_desc_view)) {
                                            if($array_desc[$row_lib_desc_view['desc_codi']]!=null)
                                                $selected = 'selected';
                                            else
                                                $selected = '';
                                ?> 
                                    <option  value="<?= $row_lib_desc_view['desc_codi']; ?>" <?= $selected ?> >
                                      <?= $row_lib_desc_view['desc_deta']; ?>
                                    </option> 
                                <?php  } ?>
                                </select>
                                
                            </div>          
                        </div>    
                    </div>
                </div>
            </div>
            <!-- DERECHA -->
            <div class="col-md-6">
                <div class="row">
                     <div class="col-md-12">
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon" >Caratula:</span>
                                <input name="recu_cara" type="file" multiple class="form-control" id="recu_cara">
                            </div> 
                        </div>
                     </div>
                </div>
                <?php 
                	$file_exi = '../files/'.$_SESSION['directorio'].'/libros/'.$recu_codi.'.png';
					if (file_exists($file_exi))
					{   $caratula = $file_exi;
					}else
					{   $caratula = '../../imagenes/biblio/recurso_default.png';
					}
                ?>
                <div class="row">
                     <div class="col-md-12">
                       <div class="thumbnail">
                            <img class="img-thumbnail img-responsive" style="max-height: 180px;" src="<?= $caratula; ?>"  >
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row" id="dynamic">
            
        </div> 
        
    </div>
    <div class="box-footer text-right">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <button class="btn btn-primary" id="btn_recu_add" data-loading-text="Guardando..."  onclick="load_ajax_add_recurso('<?= $recu_codi ?>');" >
                    <span class="glyphicon glyphicon-save"></span> <?php if ($recu_codi > 0)  echo 'Guardar Cambio en Recurso' ; else   echo 'Guardar Nuevo Recurso'; ?>
                </button>
            </div>
            <div class="col-md-2">
                <button class="btn btn-danger"  onclick="window.history.back();" >
                    <span class="fa fa-times"></span> Cancelar
                </button>
            </div>      
        </div>
    </div>   
 </div>
 
 <div id="resu_view" > </div>