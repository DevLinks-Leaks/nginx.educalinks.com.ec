<?
session_start();	 
include ('../framework/dbconf.php');
include ('../framework/funciones.php');?>
    
<?php 
  if(isset($_POST['texto'])) 
  	$texto=$_POST['texto'];    
  else   
  	$texto='%';

  $params = array($texto,$_SESSION['peri_codi']);
  $sql="{call alum_peri_busq_matri(?,?)}";
  $alum_busq = sqlsrv_query($conn, $sql, $params);  
  $cc = 0; 
?>

<div class="alumnos_main_lista">
<table class="table_striped" id="alum_table">
 <thead>
  <tr>
    <th width="10%" class="sort"><span class="icon-sort icon"></span>Código </th>
    <th width="40%" class="sort"><span class="icon-sort icon"></span>Nombre</th>
    <th width="50%" class="sort"><span class="icon-sort icon"></span>Curso</th>
  </tr>
 </thead>
 <tbody>
 <?php  while ($row_alum_busq = sqlsrv_fetch_array($alum_busq)) { $cc +=1; ?>
  <tr>
    <td><?php echo $row_alum_busq["alum_codi"]; ?></td>
    <td><?php echo $row_alum_busq["alum_apel"]." ".$row_alum_busq["alum_nomb"]; ?></td>
    <td><?php echo $row_alum_busq["curs_deta"]." - ".$row_alum_busq["para_deta"]; ?></td>
  </tr>
 
 <?php  }?>
 </tbody>
 <tfoot>
 <tr class="pager_table">
   <td colspan="2"><span class="icon-users icon"></span> Total de Alumnos ( <?php echo $cc;?> )</td>
   <td class="left"><div class="paging"></div></td>
 </tr>
 </tfoot>
</table>


</div>