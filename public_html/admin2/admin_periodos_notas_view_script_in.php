 <?php 	
	  include ('../framework/dbconf.php');
	  session_start();
	  
 
	  if(isset($_POST['peri_dist_codi'])) $peri_dist_codi=$_POST['peri_dist_codi'];
	  if(isset($_POST['nota_refe_cab_codi'])) $nota_refe_cab_codi=$_POST['nota_refe_cab_codi'];
	  
	  
	  $params = array($peri_dist_codi,$nota_refe_cab_codi);
	  $sql="{call peri_dist_peri_view_nota_refe_IN(?,?)}";
	  $peri_dist_peri_view_nota_refe_IN = sqlsrv_query($conn, $sql, $params); 
                                    
?> 

<input type="hidden" id="in_peri_dist_codi" value="<?= $peri_dist_codi ?>" />
<input type="hidden" id="in_nota_refe_cab_codi" value="<?= $nota_refe_cab_codi ?> " />
    
   <div class="admin_periodos_notas_view_script_acc" >
    <p></p>
   
<table  class="table_striped" >
<thead>
        <tr>
          <th colspan="7">INGRESO A RELIZARSE
          <div  style="float:right;">
          	<button type="button" class="btn btn-default btn-xs"  onclick="$('#myModal').modal('show')" >
            	<span class="icon-add icon"></span> Agregar
            </button>
            </div></th>
        </tr>
      </thead>
 
<?php   while ($row_peri_dist_peri_view_nota_refe_IN = sqlsrv_fetch_array($peri_dist_peri_view_nota_refe_IN)){s ?>
  <tr>
    	<td height="25">N<?= $row_peri_dist_peri_view_nota_refe_IN['peri_dist_codi'] ; ?> // <?= $row_peri_dist_peri_view_nota_refe_IN['peri_dist_deta'] ; ?> // <?= $row_peri_dist_peri_view_nota_refe_IN['peri_dist_orde'] ; ?>
        	<div  style="float:right;">
    	  	<button type="button" class="btn btn-default btn-xs" onclick="peri_dist_in_del(<?= $row_peri_dist_peri_view_nota_refe_IN['peri_dist_codi'] ; ?>)" >
            	<span class="icon-remove icon"></span>Eliminar
            </button>
            </div>
		 </td>
    </tr> 
  <?php 	 } ?>
</table>

</div>          

<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" id="myModal">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Nuevo Ingreso</h4>
      </div>
      <div class="modal-body">
        <p>Detalle: <input type="text" class="form-control" id="in_peri_dist_deta" placeholder="Detalle de Ingreso"></p>
        <p>Abreviatura: <input type="text" class="form-control" id="in_peri_dist_abre" placeholder="Detalle de Abreviatura"></p>
      </div>
      <div class="modal-footer">
         
        <button type="button" class="btn btn-primary" onclick="peri_dist_in_add();"    >Agregar</button>
      </div>
    </div>
  </div>
</div>      
     
                             