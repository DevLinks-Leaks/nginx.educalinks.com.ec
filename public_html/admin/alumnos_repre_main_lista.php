<link href="../theme/jquery1_11/jquery-ui.css" rel="stylesheet">
<link href="../theme/jquery1_11/external/jquery/jquery_growl/stylesheets/jquery.growl.css" rel="stylesheet" type="text/css" />
<?
session_start();	 
include ('../framework/dbconf.php');
include ('../framework/funciones.php');?>



<?php 
  if(isset($_POST['texto'])) $texto=$_POST['texto'];    
  else   $texto='%';
  $params = array($texto,$_SESSION['peri_codi']);
  $sql="{call repr_peri_busq(?,?)}";
  $repr_busq = sqlsrv_query($conn, $sql, $params);  
  $cc = 0; 
?>

<div class="alumnos_main_lista">


<table class="table_striped" id="repre_table">
  <thead>
  <tr>
    <th width="25%" class="sort"><span class="icon-sort icon"></span>Nombre</th>
    <th width="45%" class="sort"><span class="icon-sort icon"></span>Alumnos</th>
    <th width="30%" class="sort"><span class="icon-sort icon"></span>Opciones</th>
  </tr>
  </thead>
  <tbody>
 <?php  while ($row_repr_busq = sqlsrv_fetch_array($repr_busq)) { $cc +=1; ?>
  <tr onclick="" >
    <td><?= $row_repr_busq["repr_apel"]." ".$row_repr_busq["repr_nomb"]." - ".$row_repr_busq["repr_usua"]; ?></td>
    <td>
    	<?  $params = array($row_repr_busq["repr_codi"]);
			$sql="{call alum_repr_info(?)}";
			$alum_busq = sqlsrv_query($conn, $sql, $params);
			$c=0;
			while($row_alum_busq = sqlsrv_fetch_array($alum_busq)){
				echo $c>0?"<br>":"";
				echo $row_alum_busq['alum_codi']."-".$row_alum_busq['alum_apel']." ".$row_alum_busq['alum_nomb']." (".$row_alum_busq['curs_deta']." ".$row_alum_busq['para_deta'].")";
				$c++;
			}?>
    </td>
    <td>

    <div class="menu_options">
      <ul>
      <?php if (permiso_activo(25)){?>
        <li><a class="option" onclick="goto_url('representantes_add.php?repr_codi=<?= $row_repr_busq["repr_codi"]?>');" ><span class="icon-pencil2 icon"></span>Editar</a></li>
        <?php }if (permiso_activo(26)){?>
        <li><a class="option" onclick="load_ajax_del_repr('repr_main','script_repr.php','opc=repr_del&repr_codi=<?= $row_repr_busq["repr_codi"]?>')" ><span class="icon-remove icon"></span>Eliminar</a></li>
        <?php }?>
      </ul>
	</div>
    </td>
  </tr>
 <?php  }?>
 </tbody>
 <tfoot>
   <tr class="pager_table" >
    <td><span class="icon-users icon"></span>Total de Representantes ( <?php echo $cc;?> )</td>
    <td colspan="2" class="right"><div class="paging"></div></td>
  </tr>
 </tfoot>
</table>


</div>
