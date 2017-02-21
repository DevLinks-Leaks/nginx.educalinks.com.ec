<?php 

	session_start();	 
	//include ('../framework/dbconf.php');  
	include ('clases/PHP/Lib_Libros.php');  
	include ('../../Clases/PHP/Lib_Libros.php');  

 
 	$libros =  new libros();
	$libros->libr_view(); 
 
 	echo $libros->mensaje;
?>
   <div class="panel panel-default">
   		<? include ('libros_search.php'); ?>
   </div>
    <div class="panel panel-default">
     	<div class="panel-body">
            <div class="bs-example" data-example-id="striped-table">
                <table class="table table-striped" id="tb_libros">
                  <thead>
                    <tr>
                      <th width="15px">#</th>
                      <th width="60px">#</th>          
                      <th>Detalles</th>
                      <th>Datos</th>
                      <th>Opciones</th>
                    </tr>
                  </thead>
                  <tbody>
                   
                    <?php   $i=0;  foreach($libros->rows as $libro){$i++;?>
                        <tr>
                          <th scope="row"><?= $libro['libr_codi']; ?></th>
                           <th scope="row">     <?php
                                        $imag_show = "../files/" . $_SESSION['directorio'] . "/libros/lib_mini_" . $libro['libr_codi'] . ".jpg";
                                        if (file_exists($imag_show)==false) $imag_show="../files/" . $_SESSION['directorio'] . "/libros/lib_0.jpg";
                                    ?>
                                <h4><img    style="float:left; padding:10px;" src="<?= $imag_show; ?>" width="71" height="90" /></th>
                          <td>	
                                   
                                <h4> 
                                <?= $libro['libr_titu']; ?></h4>
                             
                                <h5><br />Codigo: <?= $libro['libr_codi_impr']; ?>
                                <br />Fecha Publicacion: <?= date_format($libro['libr_fech_publ'], 'd/M/Y' ); ?></h5>
                         </td>
                          <td> 
                                <h5>Autor: <?= $libro['libr_auto_nomb']; ?> 
                                 <br />Editorial: <?= $libro['libr_edit_deta']; ?> 
                                 <br />Coleccion: <?= $libro['libr_cole_deta']; ?> 
                                 <br />Tipo: <?= $libro['libr_tipo_deta']; ?></h5>
                          </td>
                          <td><a class="option"  href="libro.php?libr_codi=<?= $libro['libr_codi']; ?>">
                                <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>Editar
                            </a>&nbsp;&nbsp;
                              <a class="option"  data-toggle="modal" data-target="#modal_ejemplares" >
                                <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>Ver Ejemplares
                            </a>
                            
            </td>
                        </tr>
                    <?php  } ?> 
                  </tbody>
                </table>
                
               
              </div>
      </div>
</div>