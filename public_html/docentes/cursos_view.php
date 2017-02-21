
<?php 

	session_start();	 
	include ('../framework/dbconf.php');
	
	if(isset($_POST['add_aula'])){
		if($_POST['add_aula']=='Y'){		
	 		$aula_deta=$_POST['aula_deta'];	 
			$params = array($aula_deta);
			$sql="{call aula_add(?)}";
			$aula_add = sqlsrv_query($conn, $sql, $params);  
		}
	}
 					 
	 
	 
	$params = array($_SESSION['prof_codi'],$_SESSION['peri_codi']);
	$sql="{call prof_curs_para_mate_view(?,?)}";
	$prof_curs_para_mate_view = sqlsrv_query($conn, $sql, $params);  
	$cc = 0; 
	
	
?> 
<table width="100%"   class="table_full">
 
  <tr>
    <td width="58%"><strong>Listado de Clases 4</strong></td>
  </tr>
 <?php  while ($row_prof_curs_para_mate_view = sqlsrv_fetch_array($prof_curs_para_mate_view)) { $cc +=1; ?>
  
  <tr onclick="curs_show(<?= $row_prof_curs_para_mate_view["curs_para_codi"]; ?>)"  >
    <td height="29"><h5><strong>
        <?= $row_prof_curs_para_mate_view["curs_deta"]; ?> 
         (<?= $row_prof_curs_para_mate_view["para_deta"]; ?>)</strong><br />
     
      <?= $row_prof_curs_para_mate_view["mate_deta"]; ?></h5>
    
 
    <script>
    	function curs_show(curs_para_codi){
			 
    	load_ajax('curs_view_'+ curs_para_codi,'cursos_view_alum.php','curs_para_codi=' + curs_para_codi);
		}
    </script>
    </td>
  </tr>
  <tr  >
    <td  > 
    	<div id="curs_view_<?= $row_prof_curs_para_mate_view["curs_para_codi"]; ?>">
        
    	</div>
    </td>
  </tr>
 
 <?php  }?>
   <tr>
    <td >Total de Cursos ( <?php echo $cc;?> )</td>
  </tr>

</table>
