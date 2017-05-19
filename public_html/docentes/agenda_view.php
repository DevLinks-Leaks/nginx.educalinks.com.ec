
<?php 

  session_start();   
  include ('../framework/dbconf.php');
 
  $params = array($_SESSION['prof_codi'],$_SESSION['peri_codi']);
  $sql="{call agen_prof_curs_para_mate_view(?,?)}";
  $agen_prof_curs_para_mate_view = sqlsrv_query($conn, $sql, $params);  
  $cc = 0; 
  
  
?> 

<div class="docentes_agendas">
<table id='tbl_agenda' class="table table-striped table-hover">
  <thead><tr>
    <th width="60%"><strong>Listado de Clases</strong></th>
    <th width="8%"><strong>Activos</strong></th>
    <th width="8%"><strong>Inactivos</strong></th>
    <th width="8%"><strong>Pendientes</strong></th>
    <th width="8%"><strong>Total</strong></th>
    <th width="8%"><strong></strong></th>
  </tr></thead>
 <?php  
 while ($row_agen_prof_curs_para_mate_view = sqlsrv_fetch_array($agen_prof_curs_para_mate_view)) 
 { 
   if ($row_agen_prof_curs_para_mate_view["curs_para_mate_agen"]==1)
   {
  $cc +=1; 
 ?>
  <tr title='Ver agenda del curso <?= $row_agen_prof_curs_para_mate_view["curs_deta"]; ?> (<?= $row_agen_prof_curs_para_mate_view["para_deta"]; ?>) - <?= $row_agen_prof_curs_para_mate_view["mate_deta"]; ?>'
  style='cursor:pointer;' class='clickable-row' data-href='agenda_main.php?curs_para_mate_prof_codi=<?= $row_agen_prof_curs_para_mate_view["curs_para_mate_prof_codi"]; ?>&curs_para_mate_codi=<?= $row_agen_prof_curs_para_mate_view["curs_para_mate_codi"]; ?>'>
    <td height="29">
        <strong>
            <?= $row_agen_prof_curs_para_mate_view["curs_deta"]; ?> 
            (<?= $row_agen_prof_curs_para_mate_view["para_deta"]; ?>)
      </strong>
      <br />
          <?= $row_agen_prof_curs_para_mate_view["mate_deta"]; ?> 
     </td>
    <td align="center"><?= $row_agen_prof_curs_para_mate_view["cc_A"]; ?></td>
    <td align="center"><?= $row_agen_prof_curs_para_mate_view["cc_I"]; ?></td>
    <td align="center"><?= $row_agen_prof_curs_para_mate_view["cc_P"]; ?></td>
    <td align="center"><?= ($row_agen_prof_curs_para_mate_view["cc_A"]+$row_agen_prof_curs_para_mate_view["cc_I"]+$row_agen_prof_curs_para_mate_view["cc_P"]); ?></td>
    <td><a class="btn btn-info" href='agenda_main.php?curs_para_mate_prof_codi=<?= $row_agen_prof_curs_para_mate_view["curs_para_mate_prof_codi"]; ?>&curs_para_mate_codi=<?= $row_agen_prof_curs_para_mate_view["curs_para_mate_codi"]; ?>'><span class="fa fa-search"></span></a></td>
  </tr>
 
 <?php  
 }
 }
 ?>
 <tfoot>
  <tr class="pager_table">
      <td height="40" colspan="5">
          <span class="icons icon-books"></span> Total de Cursos ( <?php echo $cc;?> )
    </td>
  </tr>
  </tfoot>
</table>
</div>