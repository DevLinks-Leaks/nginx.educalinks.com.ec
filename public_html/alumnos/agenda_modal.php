<?php 
	session_start();	 
	include ('../framework/dbconf.php');
	
	if(isset($_POST['agen_codi'])) 
		$agen_codi=$_POST['agen_codi'];
	
	$params = array($agen_codi);
	$sql="{call agen_info(?)}";
	$mens_info = sqlsrv_query($conn, $sql, $params);

	$row_agen_info= sqlsrv_fetch_array($agen_info);
?>
<div class="modal-header" style="font-weight: bold !important;">
      <button 
            type="button" 
              class="close" 
              data-dismiss="modal">
              <span aria-hidden="true">&times;</span>
</button>
      <h3 class="modal-title" id="ModalLabel" >
            <?= $row_agen_info['agen_titu']; ?>
      </h3>
</div>
	<div width="100%" id="modal_main" class="modal-body" style="height:300px;overflow-y:scroll;">
		<p>
			<?= $row_agen_info['agen_deta']; ?>
		</p>
	</div>
</div>
<div class="modal-footer">

		<button 
		type="button" 
		  class="btn btn-default" 
		  data-dismiss="modal">
		Cerrar
		</button>  
</div>
