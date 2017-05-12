<?php 

	session_start();	 
	include ('../framework/dbconf.php'); 
	include ('../framework/funciones.php'); 
			
	if(isset($_GET['alum_curs_para_codi'])){
		 $alum_curs_para_codi=$_GET['alum_curs_para_codi'];
	}
	if(isset($_POST['alum_curs_para_codi'])){
		 $alum_curs_para_codi=$_POST['alum_curs_para_codi'];
	}
	
	if(isset($_POST['del_falt'])){
		 
		$falt_codi= $_POST['falt_codi'];
	   
		
		$params = array($falt_codi);
		$sql="{call falt_del(?)}";
		
		sqlsrv_query($conn, $sql, $params);		  
		
		
		//Para auditoría
		$detalle="Código: ".$falt_codi;
		registrar_auditoria (21, $detalle);
	}
 
 	$params = array($alum_curs_para_codi);
	$sql="{call alum_peri_falt(?)}";
	$alum_peri_falt = sqlsrv_query($conn, $sql, $params);  
?>

<input  type="hidden" value="<?= $alum_curs_para_codi; ?>" id="alum_curs_para_codi"/>

<table  class="table table-striped table-bordered">
        <thead style='background-color:rgba(1, 126, 186, 0.1) !important;'>
            <tr>
              <th width="68"  style='text-align:left' >Periodo</th>
              <th width="76"  style='text-align:center'>Fecha</th>
              <th width="53"  style='text-align:center'>Tipo</th>
              <th width="184" style='text-align:center'>Eliminar falta</th>
            </tr>
        </thead>
        <tbody>
            <?php  while ($row_alum_peri_falt = sqlsrv_fetch_array($alum_peri_falt)) { $cc +=1; ?> 
            <tr>
              <td style='text-align:left'><?= $row_alum_peri_falt["peri_dist_deta"]; ?></td>
              <td style='text-align:center'><?=  date_format($row_alum_peri_falt["falt_fech"], 'd/M/Y' ); ?></td>
              <td style='text-align:center'><?= $row_alum_peri_falt["Falt_tipo_deta"]; ?></td>
              <td style='text-align:center'>
				<a  class="btn btn-default" title='Eliminar' onmouseover='$(this).tooltip("show");'
					onclick="alum_curs_para_falt_del(<?= $row_alum_peri_falt["falt_codi"]; ?>)" data-toggle="modal" data-target="#ModalFalta" title=""> <span class="fa fa-trash btn_opc_lista_eliminar"></span></a>
                </td>
              </tr>
            <?php }?>

            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>

    </tbody>
</table>
