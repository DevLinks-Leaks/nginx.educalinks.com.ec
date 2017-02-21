
<?php 

	session_start();	 
	include ('../framework/dbconf.php');
	
	if(isset($_POST['peri_codi'])) $PERI_CODI=$_POST['peri_codi'];
	else $PERI_CODI=$_SESSION['peri_codi'];
	
	
	
	$params = array($PERI_CODI);
	$sql="{call curs_peri_view(?)}";
	$curs_peri_view = sqlsrv_query($conn, $sql, $params);  
	$cc = 0;

?>

<div class="cursos_notas_permisos_main_view">
	

<?php  while ($row_curs_peri_view = sqlsrv_fetch_array($curs_peri_view)) { $cc +=1; ?>
<div class="accordion" id="accordion<?= $cc;?>">
  <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion<?= $cc;?>" 
      		href="#collapse<?= $cc;?>" onclick="load_ajax('accordion-inner_<?= $cc;?>','cursos_notas_permisos_main_view_mate.php','curs_para_codi=<?= $row_curs_peri_view["curs_para_codi"]; ?>')">
       <strong><?= $row_curs_peri_view["curs_deta"]; ?></strong> - <?= $row_curs_peri_view["para_deta"]; ?>
      </a>
    </div>
    <div id="collapse<?= $cc;?>" class="accordion-body collapse in"  >
      <div  id="accordion-inner_<?= $cc;?>" class="accordion-inner">
      
      </div>
    </div>
  </div>
   
</div>
 <?php  }   ?>
</div>
 
 
 