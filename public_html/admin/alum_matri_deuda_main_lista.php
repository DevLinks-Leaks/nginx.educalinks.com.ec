<?
session_start();	 
include ('../framework/dbconf.php');
include ('../framework/funciones.php');?>
    



 

<?php 


  if(isset($_POST['texto'])) $texto=$_POST['texto'];    
  else   $texto='%';

   
  $params = array($texto,$_SESSION['peri_codi']);
  $sql="{call alum_peri_busq_matri(?,?)}";
  $alum_busq = sqlsrv_query($conn, $sql, $params);  
  $cc = 0; 
?>

<div class="alumnos_main_lista">
<table class="table_striped" id="alum_matri_table">
 <thead>
  <tr>
    <th width="10%" class="sort"><span class="icon-sort icon"></span>Código </th>
    <th width="40%" class="sort"><span class="icon-sort icon"></span>Nombre</th>
    <th width="35%" class="sort"><span class="icon-sort icon"></span>Curso</th>
	<th width="15%" class="sort" colspan="2"><span class="icon-sort icon"></span>Deuda</th>
  </tr>
 </thead>
 <tbody>
 <?php  while ($row_alum_busq = sqlsrv_fetch_array($alum_busq)) { $cc +=1; ?>
  <tr>
    <td><?php echo $row_alum_busq["alum_codi"]; ?></td>
    <td><?php echo $row_alum_busq["alum_apel"]." ".$row_alum_busq["alum_nomb"]; ?></td>
    <td><?php echo $row_alum_busq["curs_deta"]." - ".$row_alum_busq["para_deta"]; ?></td>
	 <td>
		<?= ($row_alum_busq['alum_tiene_deuda']?'Activada':'Desactivada')?>
    </td>
	<td>
	<input id="chk_<?=$row_alum_busq['alum_codi'].'_'.$row_alum_busq['curs_para_codi'];?>" data-alum_codi="<?=$row_alum_busq['alum_codi'];?>" data-curs_para_codi="<?=$row_alum_busq['curs_para_codi'];?>" type="checkbox" onclick="activar_desactivar_deuda(this);" <? echo ($row_alum_busq['alum_tiene_deuda']?'checked':''); ?> />
	</td>
  </tr>
 
 <?php  }?>
 </tbody>
 <tfoot>
   <tr class="pager_table" >
   <td colspan="4" class="left"><div class="paging"></div></td>
 </tr>
 <tr class="pager_table" >
   <td colspan="4"><span class="icon-users icon"></span> Total de Alumnos ( <?php echo $cc;?> )</td>
 </tr>
 </tfoot>
</table>
</div>