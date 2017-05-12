 <?php 	
	  include ('../framework/dbconf.php');
	  
	  session_start();
	  
	  
	  $peri_dist_cab_codi = $_GET['peri_dist_cab_codi'];
	  
	  
	  $params = array($peri_dist_cab_codi);
	  $sql="{call nota_refe_cab_view(?)}";
	  $nota_refe_cab_view = sqlsrv_query($conn, $sql, $params); 
                                    
?>


<table  class="table table-striped" >
	<thead>
        <tr>
          <th width="49" class='text-center'>Codigo</th>
          <th width="238"  >Detalle de Modelo de Nota</th>
          <th width="54" class='text-center'>Tipo</th>
          <th width="231" class='text-center' >Opciones</th>
        </tr>
      </thead>
  <tbody>
	<?php  while ($row_nota_refe_cab_view = sqlsrv_fetch_array($nota_refe_cab_view)) {  ?>
  	 <tr>
    	<td class='text-center'><?= $row_nota_refe_cab_view['nota_refe_cab_codi']; ?></td>     
        <td><?= $row_nota_refe_cab_view['nota_refe_cab_deta']; ?></td>     
        <td class='text-center'><?= $row_nota_refe_cab_view['nota_refe_cab_tipo']; ?></td>   
         <td class='text-center'>
			<a 
					onmouseover='$(this).tooltip("show")'
					title='Editar'
					class="btn btn-default" onclick="" disabled>
				<span class="fa fa-pencil"></span>
			</a>
			<a 
					onmouseover='$(this).tooltip("show")'
					title='Eliminar'
					class="btn btn-default" onclick="" disabled>
				<span class="fa fa-trash"></span></a>
         </td>     
  	 </tr>
    <?php   }?>
  </tbody>
</table>


<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" id="myModal">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><div id="tit_modal"></div></h4>
      </div>
      <div class="modal-body">
        <p>Detalle: <input type="text" class="form-control" id="in_peri_dist_deta" placeholder="Detalle de Ingreso"></p>
        <p>Tipo::          </p>
      </div>
      <div class="modal-footer">
         
        <button type="button" class="btn btn-primary" onclick="peri_dist_in_add();"    >Agregar</button>
      </div>
    </div>
  </div>
</div>      
     
                   

