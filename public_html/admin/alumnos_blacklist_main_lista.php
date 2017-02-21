<?php 
session_start();	 
include ('../framework/dbconf.php');
include ('../framework/funciones.php');

$response = file_get_contents($_SESSION['web_service_url'].'/api/listadobl?api_token='.$_SESSION['api_token']);

$response = json_decode($response,true);

$response = $response['result'];
$cc=0;
?>  
<div class="main_lista">
    <?php 
    if(isset($_POST['texto'])) $texto=$_POST['texto'];		
    else   $texto='%';


    ?>

    <table class="table_striped" id="alum_table">
      <thead>
          <tr>
            <th width="50%">Alumno</th>
            <th width="25%">Motivo Bloqueo</th>
            <th width="25%">Opciones</th>
        </tr>
    </thead>
    <tbody>
     <?php  
     foreach($response as $item) {
         $cc +=1;?>
         <tr>
            <td><?= $item["bl_alum_apel"]." ".$item["bl_alum_nomb"]?>
            </td>
            <td><?= $item["bl_moti_bloq_deta"]?>
            </td>
            <td>
                <div class="menu_options">
                 <ul>
                  <?php if (permiso_activo(529)){?>
                  <li>
                  <a data-toggle="modal" data-target="#BlacklistEdit" onclick="load_ajax('modal_main_blacklist','script_alumnos_blacklist.php','bl_codi=<?= $item["bl_codi"]; ?>&bl_moti_bloq_deta=<?= $item["bl_moti_bloq_deta"];?>&opc=edit_view');" class="option"><span class="icon-pencil2 icon"></span>Editar</a>
                 </li>
                 <?php }if (permiso_activo(530)){?>
                 <li>
                     <a onClick="load_ajax_del_alum_bl('modal_main_blacklist','script_alumnos_blacklist.php','bl_codi=<?= $item["bl_codi"]; ?>&opc=del');" class="option"><span class="icon-remove icon"></span>Eliminar</a>
                 </li>
                 <?php }?>
             </ul>
         </div>
     </td>
 </tr>
 <?php  }?>
</tbody>
<tfoot>
   <tr class="pager_table">
    <td colspan="2">
        <span class="icon-users icon"></span> Total de Alumnos ( <?php echo $cc;?> )
    </td>
</tr>
<tr>
    <td colspan="2" class="left">
        <div class="paging"></div>
    </td>
</tr>
</tfoot>
</table>

</div>

