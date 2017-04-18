<?php
    session_start();     
    include ('../framework/dbconf.php');

    if(isset($_POST['curs_codi'])){  $curs_codi=$_POST['curs_codi']; } else {$curs_codi=0;}
    if(isset($_POST['prom_codi'])){  $prom_codi=$_POST['prom_codi']; } else {$prom_codi=0;}

    $params = array($prom_codi);
    $sql="{call prom_view(?)}";
    $prom_view = sqlsrv_query($conn, $sql, $params);  
    $row_prom_view = sqlsrv_fetch_array($prom_view)
?>
<div class="modal-header">
    <button 
    	type="button" 
        class="close" 
        data-dismiss="modal">
        	<span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
	</button>
    <h4 class="modal-title" id="myModalLabel">Editar Promoción</h4>
</div>
<div class="modal-body">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td>
                Valor:
            </td>
            <td>
                <input 
                    id="prom_valu" 
                    name="prom_valu" 
                    type="number" 
                    value="<?=$row_prom_view['prom_valu'];?>"
                    style="width: 90%; margin-top: 5px;">
            </td>
        </tr>
    </table>
	<div class="form_element">&nbsp;</div>
</div>
<div class="modal-footer">
    <button id="btn_prom_upd" type="button" class="btn btn-primary" data-dismiss="modal" data-loading="Guardando.." onClick="prom_upd('<?=$prom_codi;?>','<?=$curs_codi;?>')">
    	Guardar
    </button>
     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <button type="button" class="btn btn-default" data-dismiss="modal">
    	Cerrar
    </button>
</div>