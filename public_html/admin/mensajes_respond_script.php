 
<?php  

	session_start();
	include ('../framework/dbconf.php');  
	include ('../framework/funciones.php');  
	
  $mens_codi = $_POST['mens_codi'];

  $params = array($mens_codi);
  $sql="{call mens_info(?)}";
  $mens_info = sqlsrv_query($conn, $sql, $params);  
  $row_mens_info= sqlsrv_fetch_array($mens_info);
				
?>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
  <h4 class="modal-title" id="respond_mens_modal">Responder mensaje a <?= $row_mens_info['mens_de_nomb']; ?>  (<?= $row_mens_info['mens_usua_tipo_deta_de']; ?>)</h4>
</div>
<div class="modal-body">
  <script type="text/javascript" src="../framework/funciones.js"> </script>
  <div  id="usua_mens" style="border:thin; width:100%; height:40px;margin-bottom:5px;float:left;"    >
    <input id="mens_titu" name="mens_titu" type="text" placeholder="Ingrese el Titulo..." value="" style="width:100%;"> 
  </div>
  
  <div   style=" float:left; width:100%; margin-bottom:20px;  "  >
    <textarea cols="80" id="mens_deta" name="mens_deta" rows="8"placeholder="Escriba su mensaje Aqui..."  >
    </textarea>
  </div>

</div>
<div class="modal-footer">
  <button type="button" class="btn btn-primary" id="responder_mensaje" data-loading-text="Enviando..."   onClick="envio_mensaje_resp('<?= $row_mens_info['mens_de'] ?>','<?= $row_mens_info['mens_de_tipo'] ?>');">
    Enviar
  </button>

  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  <button type="button" class="btn btn-default" data-dismiss="modal">
    Cerrar
  </button>


</div>
