<?php 

	session_start();	 
	//include ('../framework/dbconf.php');  
	include ('clases/PHP/Lib_Libros.php'); 
	

	if(isset($_GET['libr_codi'])){	$libr_codi=$_GET['libr_codi']; }
	
	if ($libr_codi > 0) {
		$libros =  new libros();
		$libros->libr_ejem_view_libr($libr_codi);  	
	 
?> 


<div>

<div id="demo"></div>

<script>
	$("#demo").barcode(
		"1234567890128", // Value barcode (dependent on the type of barcode)
		"ean13" // type (string)
	);     
	
	
</script>



</div>

   
    <div class="panel panel-default">
     	<div class="panel-body">
<div class="bs-example" data-example-id="striped-table">
    <table class="table table-striped" id="tb_libros">
      <thead>
        <tr>
          <th width="15px">Cod.</th>
          <th width="100px">Fecha</th>
          <th width="60px">Edición</th>          
          <th width="60px">Ano</th>
          <th >Procedencia</th>
          <th width="60px">Precio</th>
          <th width="60px">Opciones</th>
        </tr>
      </thead>
      <tbody>
       
        <?php   $i=0;  foreach($libros->rows as $libro){$i++;?>
            <tr>
              	<th scope="row"><?= $libro['libr_codi']; ?></th>
               	<th scope="row"><?= date_format($libro['libr_ejem_fech'], 'd/M/Y' ); ?></th>
              	<th scope="row"><?= $libro['libr_ejem_edic']; ?></th>
               	<th scope="row"><?= $libro['libr_ejem_ano']; ?></th>
                <th scope="row"><?= $libro['libr_proc_deta']; ?></th>
                <th scope="row"><?= $libro['libr_ejem_prec']; ?></th>
              	<td>
                    <a class="option"  href="libro.php?libr_codi=<?= $libro['libr_codi']; ?>">
                        <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>Editar
                	</a>
                </td>
            </tr>
		<?php  } ?> 
      </tbody>
    </table>
    
   
  </div>
      </div>
</div>

<?php  } ?> 