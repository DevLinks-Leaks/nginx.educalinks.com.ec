 <?php 	
	  include ('../framework/dbconf.php');
	  
	  session_start();
	  
	  
	  $peri_dist_cab_codi = $_GET['peri_dist_cab_codi'];
	  
	  
	  $params = array($peri_dist_cab_codi);
	  $sql="{call nota_refe_cab_view(?)}";
	  $nota_refe_cab_view = sqlsrv_query($conn, $sql, $params); 
                                    
?>


<table  class="table_striped" >
	<thead>
        <tr>
          <th width="49"  >Codigo</th>
          <th width="238"  >Detalle de Modelo de Nota</th>
          <th width="54"  >Tipo</th>
          <th width="231"  >Opciones</th>
        </tr>
      </thead>
  <tbody>
	<?php  while ($row_nota_refe_cab_view = sqlsrv_fetch_array($nota_refe_cab_view)) {  ?>
  	 <tr>
    	<td><?= $row_nota_refe_cab_view['nota_refe_cab_codi']; ?></td>     
        <td><?= $row_nota_refe_cab_view['nota_refe_cab_deta']; ?></td>     
        <td><?= $row_nota_refe_cab_view['nota_refe_cab_tipo']; ?></td>   
         <td> 
         <div class="menu_options">
           <ul>
            		        	<li>
                <a class="option" onclick="">
                    <span class="icon-pencil2 icon"></span>Editar
                </a>
            </li>
                	<li>
            	<a class="option" onclick="">
                    <span class="icon-remove icon"></span>Eliminar</a>
            </li>
           </ul>
	</div>
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
     
                   

