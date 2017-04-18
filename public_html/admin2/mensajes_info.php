<?php 

	session_start();	 
	include ('../framework/dbconf.php');
	
 	$op=1;
	if(isset($_POST['mens_codi'])) 
		$mens_codi=$_POST['mens_codi'];
	
	if(isset($_GET['mens_codi'])) 
		$mens_codi=$_GET['mens_codi'];
		
	if (isset($_POST['op']))
		$op = $_POST['op'];
	
	$params = array($mens_codi);
	$sql="{call mens_info(?)}";
	$mens_info = sqlsrv_query($conn, $sql, $params);

	$row_mens_info= sqlsrv_fetch_array($mens_info);
	
	
?>
<div class="modal-header" style="font-weight: bold !important;">
      <button 
            type="button" 
              class="close" 
              data-dismiss="modal">
              <span aria-hidden="true">&times;</span>
</button>
      <h3 class="modal-title" id="ModalLabel" >
            <?= $row_mens_info['mens_titu']; ?>
      </h3>
</div>
	<div width="100%" id="modal_main" class="modal-body" style="height:300px;overflow-y:scroll;">
		<div class="title">
      <?
		if ($op == 2)
		{
		?>
		<h4>De: <?= $row_mens_info['mens_de_nomb']; ?>  (<?= $row_mens_info['mens_usua_tipo_deta_de']; ?>)
			<? if($row_mens_info['mens_alum']!=''){ ?> - <?= $row_mens_info['mens_alum'] ?>  (<?= $row_mens_info['mens_alum_tipo_deta'] ?>)
			<? } ?>
		</h4> 
		<?
		}
		if ($op == 3)
		{
		?>
		<h4>Para: <?= $row_mens_info['mens_para_nomb']; ?>  (<?= $row_mens_info['mens_usua_tipo_deta']; ?>)
			<? if($row_mens_info['mens_alum']!=''){ ?> - <?= $row_mens_info['mens_alum'] ?>  (<?= $row_mens_info['mens_alum_tipo_deta'] ?>)
			<? } ?>
		</h4> 
		<?
		}
		?>
		<h5><?=  date_format( $row_mens_info["mens_fech_envi"], 'd / M / Y  h:m:s' ); ?></h5>
	</div>
	<p>
		<?= $row_mens_info['mens_deta']; ?>
	</p>
	</div>
</div>
<div class="modal-footer">
	<?
		if ($op == 1 or $op == 2)
		{
		?>
			<button 
		        type="button" 
		        class="btn btn-primary"  
		        onClick="load_ajax_mens_responder('div_mens_resp','mensajes_respond_script.php','<?= $mens_codi; ?>');" data-toggle="modal" data-target="#mens_responder" data-dismiss="modal">
		      	Responder
		    </button>
		<?
		}
		?>
		
	      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	      <button 
	        type="button" 
	          class="btn btn-default" 
	          data-dismiss="modal">
	        Cerrar
	      </button>  
</div>
<?php 
	if($op==1 or $op==2){	 
		$params = array($mens_codi);
		$sql="{call mens_read(?)}";
		$mens_read = sqlsrv_query($conn, $sql, $params);  
		$row_mens_read= sqlsrv_fetch_array($mens_read);
	}
?> 
