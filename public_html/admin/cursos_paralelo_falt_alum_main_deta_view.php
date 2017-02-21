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

<table  class="table_striped">
        <thead>
            <tr>
              <th width="68"  align="left">Periodo</th>
              <th width="76"   align="center" valign="middle">Fecha</th>
              <th width="53"   align="center" valign="middle">Tipo</th>
              <th width="184" align="left">Opciones</th>
            </tr>
        </thead>
        <tbody>
            <?php  while ($row_alum_peri_falt = sqlsrv_fetch_array($alum_peri_falt)) { $cc +=1; ?> 
            <tr>
              <td  ><span class="left">
                <?= $row_alum_peri_falt["peri_dist_deta"]; ?>
              </span></td>
              <td align="center" valign="middle"><span class="left">
                 <?=  date_format($row_alum_peri_falt["falt_fech"], 'd/M/Y' ); ?>
              </span></td>
              <td align="center" valign="middle"><span class="left">
                <?= $row_alum_peri_falt["Falt_tipo_deta"]; ?>
              </span></td>
              <td align="left"> 
            
                    <div class="menu_options">
                          <ul>
                           <li>
                              
                              <a  class="option"   onclick="alum_curs_para_falt_del(<?= $row_alum_peri_falt["falt_codi"]; ?>)" data-toggle="modal" data-target="#ModalFalta" title=""> 
                                  <span class="icon-del icon"> </span> Eliminar
                              </a>
                        
                            </li>                         
                          </ul>
                        </div>
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
